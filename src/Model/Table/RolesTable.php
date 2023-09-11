<?php
declare(strict_types=1);

namespace Avalon\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Log\Log;

/**
 * Roles Model
 *
 * @property \Avalon\Model\Table\UsersTable&\Cake\ORM\Association\HasMany $Users
 *
 * @method \Avalon\Model\Entity\Role newEmptyEntity()
 * @method \Avalon\Model\Entity\Role newEntity(array $data, array $options = [])
 * @method \Avalon\Model\Entity\Role[] newEntities(array $data, array $options = [])
 * @method \Avalon\Model\Entity\Role get($primaryKey, $options = [])
 * @method \Avalon\Model\Entity\Role findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \Avalon\Model\Entity\Role patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Avalon\Model\Entity\Role[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \Avalon\Model\Entity\Role|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Avalon\Model\Entity\Role saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Avalon\Model\Entity\Role[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \Avalon\Model\Entity\Role[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \Avalon\Model\Entity\Role[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \Avalon\Model\Entity\Role[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class RolesTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('roles');
        $this->setDisplayField('label');
        $this->setPrimaryKey('id');

        $this->addBehavior('Avalon.UserActionLogs');
        
        $this->hasMany('Avalon.Users', [
            'foreignKey' => 'role_id',
            'className' => 'Avalon.Users',
        ]);
        $this->hasMany('Avalon.Permissions', [
            'foreignKey' => 'role_id'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->scalar('label')
            ->maxLength('label', 255)
            ->allowEmptyString('label');

        return $validator;
    }

    public function savePermissions($entity, $data)
    {
        if ($this->save($entity)) {
            $this->Permissions->savePermissions($data, $entity->id);
            return true;
        }
    }

    public function getEffectiveRolePermissions($roleId)
    {
        $parents = $this->Permissions->Acos->find('all', [
            'conditions' => ['parent_id is null'],
            'contain' => ['Permissions' => [
                    'conditions' => [
                            'role_id' => $roleId,
                        ]
                ]
            ]
        ]);

        $children = $this->Permissions->Acos->find('all', [
            'conditions' => ['parent_id >' => '0'],
            'contain' => ['Permissions' => [
                    'conditions' => [
                            'role_id' => $roleId,
                        ]
                ]
            ]
        ]);


        $effectivePerms = [];

        // $parents = $this->Permissions->Acos->find('all', [
        //     'conditions' => ['parent_id is null'],
        //     'contain' => ['Permissions' => [
        //             'conditions' => [
        //                     'role_id' => $roleId,
        //                 ]
        //         ]
        //     ]
        // ]);

        // $acos = $this->Permissions->Acos->find('list', [
        //     'keyField' => 'id',
        //     'valueField' => 'parent_id',
        //     'groupField' => 
        // ])->toArray();
        // // Log::debug('ACOS: '.print_r(json_decode(json_encode($acos), true), true));
        // Log::debug('ACOS: '.print_r($acos, true));

        // $effectivePerms = [];

        foreach ($parents as $parent) {

            $effectivePerms[$parent->alias] = [
                'id' => $parent->id,
                'parent_id' => $parent->parent_id,
                'allowed' => $parent['permissions'][0]['allowed'],
            ];
        }
        $permissions = $this->Permissions->getRolePermissions($roleId);

        foreach ($children as $child) {
            // Check to see if the child has a grandparent
            $parent = $this->Permissions->Acos->get($child->parent_id);
            // $parent = (object)$parents[$child->parent_id];

            if (!is_null($parent->parent_id)) {
                // We have a grandparent
                
                // Check to see if the child has a great-grandparent
                $grandparent = $this->Permissions->Acos->get($parent->parent_id);
                // $grandparent = $parents[$parent->parent_id];

                if (!is_null($grandparent->parent_id)) {
                    // We have a great-grandparent
                    $greatGrandparent = $this->Permissions->Acos->get($grandparent->parent_id);
                    // $greatGrandparent = $parents[$grandparent->parent_id];

                    // Add to the effective permissions
                    $effectivePerms[$greatGrandparent->alias]['children'][$grandparent->alias]['children'][$parent->alias]['children'][$child->alias] = [
                        'id' => $child->id,
                        'parent_id' => $child->parent_id,
                        // 'allowed' => $child['permissions'][0]['allowed'],
                        'allowed' => $permissions[$child->id]['allowed'],
                    ];
                    
                } else {
                    // Add to the effective permissions
                    $effectivePerms[$grandparent->alias]['children'][$parent->alias]['children'][$child->alias] = [
                        'id' => $child->id,
                        'parent_id' => $child->parent_id,
                        // 'allowed' => $child['permissions'][0]['allowed'],
                        'allowed' => $permissions[$child->id]['allowed'],
                    ];

                }
            } else {
                // Add to the effective permissions
                $effectivePerms[$parent->alias]['children'][$child->alias] = [
                        'id' => $child->id,
                        'parent_id' => $child->parent_id,
                        // 'allowed' => $child['permissions'][0]['allowed'],
                        'allowed' => $permissions[$child->id]['allowed'],
                    ];

            }
        }

        // foreach ($children as $child) {
        //     // Check to see if the child's parent has a parent
        //     $parent = $this->Permissions->Acos->get($child->parent_id);

        //     if (!is_null($parent->parent_id)) {
        //         // The parent is a child
        //         $grandParent = $this->Permissions->Acos->get($parent->parent_id);
        //         $effectivePerms[$grandParent->alias]['children'][$parent->alias]['children'][$child->alias] = [
        //             'id' => $child->id,
        //             'parent_id' => $child->parent_id,
        //             // 'allowed' => $child['permissions'][0]['allowed'],
        //             'allowed' => $permissions[$child->id]['allowed'],
        //         ];

        //     } else {
        //         $effectivePerms[$parent->alias]['children'][$child->alias] = [
        //             'id' => $child->id,
        //             'parent_id' => $child->parent_id,
        //             // 'allowed' => $child['permissions'][0]['allowed'],
        //             'allowed' => $permissions[$child->id]['allowed'],
        //         ];
        //     }

        // }


        return $effectivePerms;
    }

    public function getEffectivePermissions($userId)
    {

    }
}
