<?php
declare(strict_types=1);

namespace Avalon\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Menus Model
 *
 * @property \Avalon\Model\Table\PagesTable&\Cake\ORM\Association\HasMany $Pages
 *
 * @method \Avalon\Model\Entity\Menu newEmptyEntity()
 * @method \Avalon\Model\Entity\Menu newEntity(array $data, array $options = [])
 * @method \Avalon\Model\Entity\Menu[] newEntities(array $data, array $options = [])
 * @method \Avalon\Model\Entity\Menu get($primaryKey, $options = [])
 * @method \Avalon\Model\Entity\Menu findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \Avalon\Model\Entity\Menu patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Avalon\Model\Entity\Menu[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \Avalon\Model\Entity\Menu|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Avalon\Model\Entity\Menu saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Avalon\Model\Entity\Menu[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \Avalon\Model\Entity\Menu[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \Avalon\Model\Entity\Menu[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \Avalon\Model\Entity\Menu[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class MenusTable extends Table
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

        $this->setTable('menus');
        $this->setDisplayField('label');
        $this->setPrimaryKey('id');

        $this->addBehavior('Avalon.Boolean', [
            'booleans' => [
                'active',
                'literal',
                'visible',
            ]
        ]);
        $this->addBehavior('Avalon.UserActionLogs');

        $this->hasMany('Pages', [
            'foreignKey' => 'menu_id',
            'className' => 'Avalon.Pages',
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
            ->scalar('label')
            ->maxLength('label', 255)
            ->requirePresence('label', 'create')
            ->notEmptyString('label');

        $validator
            ->scalar('icon')
            ->maxLength('icon', 255)
            ->allowEmpty('icon');

        $validator
            ->scalar('_plugin')
            ->maxLength('_plugin', 255)
            ->allowEmptyString('_plugin');

        $validator
            ->scalar('prefix')
            ->maxLength('prefix', 255)
            ->allowEmptyString('prefix');

        $validator
            ->scalar('controller')
            ->maxLength('controller', 255)
            ->allowEmptyString('controller');

        $validator
            ->scalar('controller_action')
            ->maxLength('controller_action', 255)
            ->allowEmptyString('controller_action');

        $validator
            ->integer('sort_order')
            ->requirePresence('sort_order', 'create')
            ->notEmptyString('sort_order');

        $validator
            ->notEmptyString('active');

        $validator
            ->notEmptyString('literal');

        $validator
            ->requirePresence('visible', 'create')
            ->notEmptyString('visible');

        return $validator;
    }
}
