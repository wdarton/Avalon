<?php
namespace Avalon\Controller\Admin;

use Avalon\Controller\AppController;
use Cake\Event\EventInterface;

/**
 * Menus Controller
 *
 * @property \App\Model\Table\MenusTable $Menus
 *
 * @method \App\Model\Entity\Menu[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class MenusController extends AppController
{
    public $paginate = [
        'limit' => 25,
        'order' => [
            'sort_order' => 'asc'
        ]
    ];

    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);
        $this->loadComponent('Avalon.Ajax');
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        // $this->UserAction->logAction(__FILE__);
        $menus = $this->Menus->find('all');

        $this->set(compact('menus'));
    }

    /**
     * View method
     *
     * @param string|null $id Menu id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        // $this->UserAction->logAction(__FILE__, $id);

        $menu = $this->Menus->get($id, [
            'contain' => ['Pages']
        ]);

        if ($this->request->is('ajax')) {
            $this->Ajax->sendToView($menu);
        }

        $this->set('menu', $menu);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $menu = $this->Menus->newEmptyEntity();
        if ($this->request->is('post')) {
            $menu = $this->Menus->patchEntity($menu, $this->request->getData());
            if ($this->Menus->save($menu)) {
                // $this->UserAction->logAction(__FILE__, $menu->id);

                $this->Flash->success(__('The menu has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The menu could not be saved. Please, try again.'));
        }
        $this->set(compact('menu'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Menu id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $menu = $this->Menus->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $menu = $this->Menus->patchEntity($menu, $this->request->getData());
            $dirtyFields = $menu->getDirty();

            if ($this->Menus->save($menu)) {
                // $this->UserAction->logAction(__FILE__, $id, $dirtyFields, $menu);

                $this->Flash->success(__('The menu has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The menu could not be saved. Please, try again.'));
        }
        $this->set(compact('menu'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Menu id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        // $this->UserAction->logAction(__FILE__, $id);

        $this->request->allowMethod(['post', 'ajax', 'delete']);
        $menu = $this->Menus->get($id);
        if ($this->Menus->delete($menu)) {
            $this->Flash->success(__('The menu has been deleted.'));
        } else {
            $this->Flash->error(__('The menu could not be deleted. Please, try again.'));
        }

        if ($this->request->is('ajax')) {
            $this->Ajax->sendSuccess();
        } else {
            return $this->redirect(['action' => 'index']);
        }

    }
}
