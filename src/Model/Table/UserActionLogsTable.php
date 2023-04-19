<?php
namespace Avalon\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * UserActionLogs Model
 *
 * @property \Avalon\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 * @property \Avalon\Model\Table\EntitiesTable|\Cake\ORM\Association\BelongsTo $Entities
 *
 * @method \Avalon\Model\Entity\UserActionLog get($primaryKey, $options = [])
 * @method \Avalon\Model\Entity\UserActionLog newEntity($data = null, array $options = [])
 * @method \Avalon\Model\Entity\UserActionLog[] newEntities(array $data, array $options = [])
 * @method \Avalon\Model\Entity\UserActionLog|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Avalon\Model\Entity\UserActionLog patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Avalon\Model\Entity\UserActionLog[] patchEntities($entities, array $data, array $options = [])
 * @method \Avalon\Model\Entity\UserActionLog findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class UserActionLogsTable extends Table
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

        $this->setTable('user_action_logs');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'className' => 'Avalon.Users',
            'joinType' => 'INNER'
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
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->scalar('controller')
            ->maxLength('controller', 255)
            ->allowEmpty('controller');

        $validator
            ->scalar('controller_action')
            ->maxLength('controller_action', 255)
            ->allowEmpty('controller_action');

        $validator
            ->scalar('file_location')
            ->maxLength('file_location', 255)
            ->allowEmpty('file_location');

        $validator
            ->scalar('entity_display_field')
            ->maxLength('entity_display_field', 255)
            ->allowEmpty('entity_display_field');

        $validator
            ->scalar('dirty_fields')
            ->allowEmpty('dirty_fields');

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
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }
}
