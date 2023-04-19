<?php
declare(strict_types=1);

namespace Avalon\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * UserPreferences Model
 *
 * @method \Avalon\Model\Entity\UserPreference newEmptyEntity()
 * @method \Avalon\Model\Entity\UserPreference newEntity(array $data, array $options = [])
 * @method \Avalon\Model\Entity\UserPreference[] newEntities(array $data, array $options = [])
 * @method \Avalon\Model\Entity\UserPreference get($primaryKey, $options = [])
 * @method \Avalon\Model\Entity\UserPreference findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \Avalon\Model\Entity\UserPreference patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Avalon\Model\Entity\UserPreference[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \Avalon\Model\Entity\UserPreference|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Avalon\Model\Entity\UserPreference saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Avalon\Model\Entity\UserPreference[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \Avalon\Model\Entity\UserPreference[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \Avalon\Model\Entity\UserPreference[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \Avalon\Model\Entity\UserPreference[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class UserPreferencesTable extends Table
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

        $this->setTable('user_preferences');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Avalon.UserActionLogs');
        

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
            ->scalar('user_timezone')
            ->maxLength('user_timezone', 255)
            ->requirePresence('user_timezone', 'create')
            ->notEmptyString('user_timezone');

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
        $rules->add($rules->existsIn('user_id', 'Users'), ['errorField' => 'user_id']);

        return $rules;
    }
}
