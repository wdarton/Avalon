<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SystemSettings Model
 *
 * @property \App\Model\Table\CurrentCoursesTable|\Cake\ORM\Association\BelongsTo $CurrentCourses
 *
 * @method \App\Model\Entity\SystemSetting get($primaryKey, $options = [])
 * @method \App\Model\Entity\SystemSetting newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\SystemSetting[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\SystemSetting|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\SystemSetting patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\SystemSetting[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\SystemSetting findOrCreate($search, callable $callback = null, $options = [])
 */
class SystemSettingsTable extends Table
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

        $this->setTable('system_settings');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Avalon.UserActionLogs');

        $this->belongsTo('Courses', [
            'foreignKey' => 'current_course_id'
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
            ->scalar('system_timezone')
            ->maxLength('system_timezone', 255)
            ->allowEmpty('system_timezone');

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

        return $rules;
    }
}
