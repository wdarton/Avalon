<?php
declare(strict_types=1);

namespace Avalon\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 *
 * @property \Avalon\Model\Table\RolesTable&\Cake\ORM\Association\BelongsTo $Roles
 *
 * @method \Avalon\Model\Entity\User newEmptyEntity()
 * @method \Avalon\Model\Entity\User newEntity(array $data, array $options = [])
 * @method \Avalon\Model\Entity\User[] newEntities(array $data, array $options = [])
 * @method \Avalon\Model\Entity\User get($primaryKey, $options = [])
 * @method \Avalon\Model\Entity\User findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \Avalon\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Avalon\Model\Entity\User[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \Avalon\Model\Entity\User|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Avalon\Model\Entity\User saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Avalon\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \Avalon\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \Avalon\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \Avalon\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class UsersTable extends Table
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

        $this->setTable('users');
        $this->setDisplayField('username');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('Avalon.ModifiedBy');
        $this->addBehavior('Avalon.UserActionLogs');

        $this->belongsTo('Roles', [
            'foreignKey' => 'role_id',
            'joinType' => 'INNER',
            'className' => 'Avalon.Roles',
        ]);
        $this->hasMany('UserActionLogs', [
            'foreignKey' => 'user_id',
            'className' => 'Avalon.UserActionLogs',
            'dependent' => true,
            'cascadeCallbacks' => true,
        ]);
        $this->hasMany('UserLogins', [
            'foreignKey' => 'user_id',
            'className' => 'Avalon.UserLogins',
            'dependent' => true,
            'cascadeCallbacks' => true,
        ]);
        $this->hasOne('UserPreferences', [
            'foreignKey' => 'user_id',
            'className' => 'Avalon.UserPreferences',
            'dependent' => true,
            'cascadeCallbacks' => true,
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
            ->nonNegativeInteger('role_id')
            ->notEmptyString('role_id');

        $validator
            ->scalar('first_name')
            ->maxLength('first_name', 255)
            ->allowEmptyString('first_name');

        $validator
            ->scalar('last_name')
            ->maxLength('last_name', 255)
            ->allowEmptyString('last_name');

        $validator
            ->scalar('email')
            ->maxLength('email', 255)
            ->allowEmptyString('email')
            ->add('email', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('username')
            ->maxLength('username', 255)
            ->requirePresence('username', 'create')
            ->notEmptyString('username');

        $validator
            ->scalar('password')
            ->maxLength('password', 255)
            ->allowEmptyString('password');

        $validator
            ->integer('login_count')
            ->allowEmptyString('login_count');

        $validator
            ->dateTime('last_logon')
            ->allowEmptyDateTime('last_logon');

        $validator
            ->allowEmptyString('locked');

        $validator
            ->boolean('reset_password')
            ->allowEmptyString('reset_password');

        $validator
            ->scalar('created_by')
            ->maxLength('created_by', 255)
            ->allowEmptyString('created_by');

        $validator
            ->scalar('modified_by')
            ->maxLength('modified_by', 255)
            ->allowEmptyString('modified_by');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->isUnique(['email']), ['errorField' => 'email']);
        $rules->add($rules->isUnique(['username']), ['errorField' => 'username']);
        $rules->add($rules->existsIn('role_id', 'Roles'), ['errorField' => 'role_id']);

        return $rules;
    }

    public function findNotLocked(Query $query, array $options) {
        return $query->where(['locked' => 0]);
    }
}
