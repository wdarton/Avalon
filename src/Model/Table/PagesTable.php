<?php
declare(strict_types=1);

namespace Avalon\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Pages Model
 *
 * @property \App\Model\Table\MenusTable|\Cake\ORM\Association\BelongsTo $Menus
 *
 * @method \App\Model\Entity\Page get($primaryKey, $options = [])
 * @method \App\Model\Entity\Page newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Page[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Page|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Page patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Page[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Page findOrCreate($search, callable $callback = null, $options = [])
 */
class PagesTable extends Table
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

        $this->setTable('pages');
        $this->setDisplayField('label');
        $this->setPrimaryKey('id');

        $this->addBehavior('Avalon.Boolean', [
            'booleans' => [
                'active',
                'literal',
            ]
        ]);
        $this->addBehavior('Avalon.UserActionLogs');

        $this->belongsTo('Avalon.Menus', [
            'foreignKey' => 'menu_id',
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
            ->scalar('label')
            ->maxLength('label', 255)
            ->requirePresence('label', 'create')
            ->notEmpty('label');

        $validator
            ->scalar('icon')
            ->maxLength('icon', 255)
            ->allowEmpty('icon');

        $validator
            ->scalar('_plugin')
            ->maxLength('_plugin', 255)
            ->allowEmpty('_plugin');

        $validator
            ->scalar('prefix')
            ->maxLength('prefix', 255)
            ->allowEmpty('prefix');

        $validator
            ->scalar('controller')
            ->maxLength('controller', 255)
            ->requirePresence('controller', 'create')
            ->notEmpty('controller');

        $validator
            ->scalar('controller_action')
            ->maxLength('controller_action', 255)
            ->requirePresence('controller_action', 'create')
            ->notEmpty('controller_action');

        $validator
            ->integer('sort_order')
            ->requirePresence('sort_order', 'create')
            ->notEmpty('sort_order');

        $validator
            ->boolean('active')
            ->requirePresence('active', 'create')
            ->notEmpty('active');

        $validator
            ->boolean('literal')
            ->requirePresence('literal', 'create')
            ->notEmpty('literal');

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
        $rules->add($rules->existsIn(['menu_id'], 'Menus'));

        return $rules;
    }
}
