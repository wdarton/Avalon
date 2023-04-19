<?php
namespace Avalon\Controller;

use App\Controller\AppController;
use Cake\Event\EventInterface;
use Cake\ORM\TableRegistry;

/**
 * Roles Controller
 *
 * @property \App\Model\Table\RolesTable $Roles
 *
 * @method \App\Model\Entity\Role[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class RolesController extends AppController
{
    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);
        // $this->Roles = TableRegistry::getTableLocator()->get('App.Roles');

        $this->loadComponent('Avalon.Ajax');
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $roles = $this->paginate($this->Roles);

        $this->set(compact('roles'));
    }

    /**
     * View method
     *
     * @param string|null $id Role id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $role = $this->Roles->get($id, [
            // 'contain' => ['Permissions', 'UserRoles']
        ]);

        if ($this->request->is('ajax')) {
            $this->Ajax->sendToView($role);
        }

        $this->set('role', $role);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        // $acos = $this->Roles->Permissions->Acos->getAcos();
        $role = $this->Roles->newEmptyEntity();
        if ($this->request->is('post')) {
            $role = $this->Roles->patchEntity($role, $this->request->getData());
            // if ($this->Roles->savePermissions($role, $this->request->getData())) {
            if ($this->Roles->save($role)) {
                $this->Flash->success(__('The role has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->set('post', $this->request->getData());
            $this->Flash->error(__('The role could not be saved. Please, try again.'));
        }
        // $this->set(compact('role','acos'));
        $this->set(compact('role'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Role id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $role = $this->Roles->get($id, [
            'contain' => []
        ]);
        // $acos = $this->Roles->Permissions->Acos->getAcos();
        // $permissions = $this->Roles->Permissions->getEditablePermissions($id);
        // $effectivePerms = $this->Roles->getEffectiveRolePermissions($id);
        // $acosByName = $this->Roles->Permissions->Acos->getAcosByName($id);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $role = $this->Roles->patchEntity($role, $this->request->getData());
            // if ($this->Roles->savePermissions($role, $this->request->getData())) {
            if ($this->Roles->save($role)) {
                $this->Flash->success(__('The role has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The role could not be saved. Please, try again.'));
        }
        // $this->set(compact('role', 'acos', 'permissions', 'effectivePerms', 'acosByName'));
        $this->set(compact('role'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Role id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'ajax', 'delete']);
        $role = $this->Roles->get($id);
        if ($this->Roles->delete($role)) {
            $this->Flash->success(__('The role has been deleted.'));
        } else {
            $this->Flash->error(__('The role could not be deleted. Please, try again.'));
        }

        if ($this->request->is('ajax')) {
            $this->Ajax->sendSuccess();
        }

        return $this->redirect(['action' => 'index']);
    }
}
