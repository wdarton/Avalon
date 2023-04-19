<?php
declare(strict_types=1);

namespace Avalon\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

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
        
        $this->hasMany('Users', [
            'foreignKey' => 'role_id',
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
            ->scalar('label')
            ->maxLength('label', 255)
            ->allowEmptyString('label');

        return $validator;
    }
}
