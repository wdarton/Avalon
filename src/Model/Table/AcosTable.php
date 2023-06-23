<?php
namespace Avalon\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Acos Model
 *
 * @property \App\Model\Table\AcosTable|\Cake\ORM\Association\BelongsTo $ParentAcos
 * @property \App\Model\Table\AcosTable|\Cake\ORM\Association\HasMany $ChildAcos
 * @property \App\Model\Table\PermissionsTable|\Cake\ORM\Association\HasMany $Permissions
 *
 * @method \App\Model\Entity\Aco get($primaryKey, $options = [])
 * @method \App\Model\Entity\Aco newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Aco[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Aco|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Aco saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Aco patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Aco[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Aco findOrCreate($search, callable $callback = null, $options = [])
 */
class AcosTable extends Table
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

        $this->setTable('acos');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->hasMany('Avalon.Permissions', [
            'foreignKey' => 'aco_id'
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
            ->nonNegativeInteger('id')
            ->allowEmptyString('id', 'create');

        $validator
            ->scalar('alias')
            ->maxLength('alias', 255)
            ->allowEmptyString('alias');

        return $validator;
    }

    public function truncate()
    {
        $truncateCommands = $this->schema()->truncateSql($this->connection());
        foreach ($truncateCommands as $truncateCommand) {
            $this->connection()->query($truncateCommand);
        }
    }

    public function getAcos()
    {
        $parents = $this->find('all', [
            'conditions' => ['parent_id is null'],
        ]);

        $children = $this->find('all', [
            'conditions' => ['parent_id >' => '0'],
        ]);

        $acos = [];

        foreach ($parents as $parent) {
            $acos[$parent->id][] = $parent;
        }

        foreach ($children as $child) {
            // Check to see if the child has a grandparent
            $parent = $this->get($child->parent_id);
            if (!is_null($parent->parent_id)) {
                // We have a grandparent
                
                // Check to see if the child has a great-grandparent
                $grandparent = $this->get($parent->parent_id);
                if (!is_null($grandparent->parent_id)) {
                    // We have a great-grandparent
                    $greatGrandparent = $this->get($grandparent->parent_id);
                    $acos[$greatGrandparent->id]['children'][$grandparent->id]['children'][$parent->id]['children'][] = $child;
                    
                } else {
                    $acos[$grandparent->id]['children'][$parent->id]['children'][] = $child;
                }
            } else {
                $acos[$child->parent_id]['children'][$child->id][] = $child;
            }
        }

        // foreach ($children as $child) {
        //     // Check to see if the child's parent has a parent
        //     $parent = $this->get($child->parent_id);
        //     if (!is_null($parent->parent_id)) {
        //         // The parent is a child
        //         $grandParent = $this->get($parent->parent_id);
        //         $acos[$grandParent->id]['children'][$parent->id]['children'][] = $child;
        //     } else {
        //         $acos[$child->parent_id]['children'][$child->id][] = $child;
        //     }

        // }

        return $acos;
    }

    public function getAcosByName($roleId)
    {
        $parents = $this->find('all', [
            'conditions' => ['parent_id is null'],
            'contain' => ['Permissions' => [
                    'conditions' => [
                            'role_id' => $roleId,
                        ]
                ]
            ]
        ]);

        $children = $this->find('all', [
            'conditions' => ['parent_id >' => '0'],
            'contain' => ['Permissions' => [
                    'conditions' => [
                            'role_id' => $roleId,
                        ]
                ]
            ]
        ]);

        $acos = [];

        foreach ($parents as $parent) {
            $acos[$parent->alias] = [
                'id' => $parent->id,
                'parent_id' => $parent->parent_id,
                'allowed' => $parent['permissions'][0]['allowed'],
            ];
        }

        foreach ($children as $child) {
            // Check to see if the child's parent has a parent
            $parent = $this->get($child->parent_id);

            if (!is_null($parent->parent_id)) {
                // The parent is a child
                $grandParent = $this->get($parent->parent_id);
                $acos[$grandParent->alias]['children'][$parent->alias]['children'][$child->alias] = [
                    'id' => $child->id,
                    'parent_id' => $child->parent_id,
                    'allowed' => $child['permissions'][0]['allowed'],
                ];

            } else {
                $acos[$parent->alias]['children'][$child->alias] = [
                    'id' => $child->id,
                    'parent_id' => $child->parent_id,
                    'allowed' => $child['permissions'][0]['allowed'],
                ];
            }

        }


        return $acos;
    }
}
