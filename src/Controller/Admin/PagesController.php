<?php
namespace Avalon\Controller\Admin;

use Avalon\Controller\AppController;
use Cake\Event\EventInterface ;

/**
 * Pages Controller
 *
 * @property \App\Model\Table\PagesTable $Pages
 *
 * @method \App\Model\Entity\Page[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PagesController extends AppController
{
    public $paginate = [
        'limit' => 25,
        'order' => [
            'menu_id' => 'asc',
            'sort_order' => 'asc',
        ]
    ];

    public function beforeFilter(EventInterface  $event)
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

        $pages = $this->Pages->find('all', [
            'contain' => ['Menus'],
        ]);

        $this->set(compact('pages'));
    }

    /**
     * View method
     *
     * @param string|null $id Page id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        // $this->UserAction->logAction(__FILE__, $id);

        $page = $this->Pages->get($id, [
            'contain' => ['Menus']
        ]);

        if ($this->request->is('ajax')) {
            $this->Ajax->sendToView($page);
        }

        $this->set('page', $page);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $page = $this->Pages->newEmptyEntity();
        if ($this->request->is('post')) {
            $page = $this->Pages->patchEntity($page, $this->request->getData());
            if ($this->Pages->save($page)) {
                // $this->UserAction->logAction(__FILE__, $page->id);

                $this->Flash->success(__('The page has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The page could not be saved. Please, try again.'));
        }
        $menus = $this->Pages->Menus->find('list', ['limit' => 200]);
        $this->set(compact('page', 'menus'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Page id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $page = $this->Pages->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $page = $this->Pages->patchEntity($page, $this->request->getData());
            $dirtyFields = $page->getDirty();

            if ($this->Pages->save($page)) {
                // $this->UserAction->logAction(__FILE__, $id, $dirtyFields, $page);

                $this->Flash->success(__('The page has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The page could not be saved. Please, try again.'));
        }
        $menus = $this->Pages->Menus->find('list', ['limit' => 200]);
        $this->set(compact('page', 'menus'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Page id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        // $this->UserAction->logAction(__FILE__, $id);

        $this->request->allowMethod(['post', 'ajax', 'delete']);
        $page = $this->Pages->get($id);
        if ($this->Pages->delete($page)) {
        // if (true) {
            $this->Flash->success(__('The page has been deleted.'));
        } else {
            $this->Flash->error(__('The page could not be deleted. Please, try again.'));
        }

        if ($this->request->is('ajax')) {
            $this->Ajax->sendSuccess();
        } else {
            return $this->redirect(['action' => 'index']);
        }

    }
}
