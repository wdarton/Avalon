<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Log\Log;

/**
 * Permissions Model
 *
 * @property \App\Model\Table\RolesTable|\Cake\ORM\Association\BelongsTo $Roles
 * @property \App\Model\Table\AcosTable|\Cake\ORM\Association\BelongsTo $Acos
 *
 * @method \App\Model\Entity\Permission get($primaryKey, $options = [])
 * @method \App\Model\Entity\Permission newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Permission[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Permission|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Permission saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Permission patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Permission[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Permission findOrCreate($search, callable $callback = null, $options = [])
 */
class PermissionsTable extends Table
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

        $this->setTable('permissions');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Roles', [
            'foreignKey' => 'role_id'
        ]);
        $this->belongsTo('Acos', [
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


        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['role_id'], 'Roles'));
        $rules->add($rules->existsIn(['aco_id'], 'Acos'));

        return $rules;
    }

    public function savePermissions($data, $roleId)
    {
        // Check if we have premissions for the current role
        // If we do, we want to delete them first

        $currentPremissions = $this->find('all', [
            'conditions' => ['role_id' => $roleId],
        ]);

        if ($currentPremissions->count()) {
            // Delete the current permissions
            $this->deleteAll(['role_id' => $roleId]);
        }

        foreach ($data as $aco => $value) {
            // Skip all post data that isn't for an ACO
            if (strpos($aco, 'aco-') === false) {
                continue;
            }

            $acoId = str_replace('aco-', '', $aco);
            $permission = $this->newEntity();
            $permission->role_id = $roleId;
            $permission->aco_id = $acoId;
            $permission->allowed = $value;
            $this->save($permission);
        }
    }

    public function updateNonAdminPermissions() {
        // Get a list of rolls
        $roles = $this->Roles->find('all');

        // Get a list of ACOs
        $acos = $this->Acos->find('all');

        // Check if there is a permission for the ACO already
        // If not, create one and inherit the settings from the parent ACO
        foreach ($roles as $role) {
            if ($role->id === 1) {
                continue;
            }
            Log::debug('Processing permissions for role: '.$role->label);
            foreach ($acos as $aco) {
                $existingPermission = $this->find('all',[
                    'conditions' => [
                        'aco_id' => $aco->id,
                        'role_id' => $role->id,
                    ],
                ])->first();

                if (!$existingPermission) {
                    // Create the permission
                    $permission = $this->newEntity();
                    $permission->role_id = $role->id;
                    $permission->aco_id = $aco->id;
                    $permission->allowed = -1;
                    Log::debug('Creating new permission for role: '.$role->label);
                    Log::debug('Permission ACO: '.$aco->alias);
                    $this->save($permission);
                }
            }
        }

    }

    public function getEditablePermissions($roleId)
    {
        $permissions = $this->find('all', [
            'conditions' => ['role_id' => $roleId],
            'contain' => ['Acos'],
        ]);

        $editablePerms = [];
        foreach ($permissions as $permission) {
            $editablePerms[$permission->aco_id] = [
                'allowed' => $permission->allowed,
                'parent_aco_id' => $permission->aco->parent_id,
                'alias' => $permission->aco->alias,
            ];
        }

        return $editablePerms;
    }

    public function getRolePermissions($roleId)
    {
        $permissions = $this->getEditablePermissions($roleId);

        foreach ($permissions as &$permission) {
            $allowed = $permission['allowed'];
            $parentAcoId = $permission['parent_aco_id'];

            if ($allowed == -1) {
                // inherit
                if (!is_null($parentAcoId)) {
                    $tmpallowed = $permissions[$parentAcoId]['allowed'];

                    // Check the if there is a grandparent just in case
                    // If there is we should use the allowed value from there instead
                    if (!is_null($permissions[$parentAcoId]['parent_aco_id']) &&
                        $tmpallowed == -1) {
                        $gParentAcoId = $permissions[$parentAcoId]['parent_aco_id'];
                        $tmpallowed = $permissions[$gParentAcoId]['allowed'];
                    }

                } else {
                    $tmpallowed = 0; // Assume false
                }

                switch ($tmpallowed) {
                    case 1:
                        $permission['allowed'] = 1;
                        break;
                    case 0:
                    case -1:
                        $permission['allowed'] = 0;
                        break;
                }
            }
        }

        // $permissions = $this->Acos->getAcosByName($roleId);

        return $permissions;
    }

    public function getEffectiveRolePermissions($roleId)
    {
        $parents = $this->Acos->find('all', [
            'conditions' => ['parent_id is null'],
            'contain' => ['Permissions' => [
                    'conditions' => [
                            'role_id' => $roleId,
                        ]
                ]
            ]
        ]);

        $children = $this->Acos->find('all', [
            'conditions' => ['parent_id >' => '0'],
            'contain' => ['Permissions' => [
                    'conditions' => [
                            'role_id' => $roleId,
                        ]
                ]
            ]
        ]);

        $ePermissions = [];

        foreach ($parents as $parent) {
            $ePermissions[$parent->alias] = [
                'id' => $parent->id,
                'parent_id' => $parent->parent_id,
                'allowed' => $parent['permissions'][0]['allowed'],
            ];
        }
        $permissions = $this->getRolePermissions($roleId);

        foreach ($children as $child) {
            // Check to see if the child's parent has a parent
            $parent = $this->Acos->get($child->parent_id);

            if (!is_null($parent->parent_id)) {
                // The parent is a child
                $grandParent = $this->Acos->get($parent->parent_id);
                $ePermissions[$grandParent->alias]['children'][$parent->alias]['children'][$child->alias] = [
                    'id' => $child->id,
                    'parent_id' => $child->parent_id,
                    // 'allowed' => $child['permissions'][0]['allowed'],
                    'allowed' => $permissions[$child->id]['allowed'],
                ];

            } else {
                $ePermissions[$parent->alias]['children'][$child->alias] = [
                    'id' => $child->id,
                    'parent_id' => $child->parent_id,
                    // 'allowed' => $child['permissions'][0]['allowed'],
                    'allowed' => $permissions[$child->id]['allowed'],
                ];
            }

        }


        return $ePermissions;
    }

    public function getEffectivePermissions($userId)
    {

    }


}
