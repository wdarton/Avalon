<?php
declare(strict_types=1);

namespace Avalon\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * UserLogins Model
 *
 * @property \Avalon\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \Avalon\Model\Entity\UserLogin newEmptyEntity()
 * @method \Avalon\Model\Entity\UserLogin newEntity(array $data, array $options = [])
 * @method \Avalon\Model\Entity\UserLogin[] newEntities(array $data, array $options = [])
 * @method \Avalon\Model\Entity\UserLogin get($primaryKey, $options = [])
 * @method \Avalon\Model\Entity\UserLogin findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \Avalon\Model\Entity\UserLogin patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Avalon\Model\Entity\UserLogin[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \Avalon\Model\Entity\UserLogin|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Avalon\Model\Entity\UserLogin saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Avalon\Model\Entity\UserLogin[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \Avalon\Model\Entity\UserLogin[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \Avalon\Model\Entity\UserLogin[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \Avalon\Model\Entity\UserLogin[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class UserLoginsTable extends Table
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

        $this->setTable('user_logins');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'className' => 'Avalon.Users',
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
            ->integer('user_id')
            ->allowEmptyString('user_id');

        $validator
            ->scalar('username')
            ->maxLength('username', 255)
            ->allowEmptyString('username');

        $validator
            ->requirePresence('success', 'create')
            ->notEmptyString('success');

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
        // $rules->add($rules->isUnique(['username']), ['errorField' => 'username']);
        $rules->add($rules->existsIn('user_id', 'Users'), ['errorField' => 'user_id']);

        return $rules;
    }
}
