<?php
namespace Avalon\Controller\Config;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Event\EventInterface;


/**
 * SystemSettings Controller
 *
 * @property \App\Model\Table\SystemSettingsTable $SystemSettings
 *
 * @method \App\Model\Entity\SystemSetting[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SystemSettingsController extends AppController
{
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
        $systemSettings = $this->paginate($this->SystemSettings);

        $this->set(compact('systemSettings'));
    }

    /**
     * View method
     *
     * @param string|null $id System Setting id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {

        $this->set('systemSetting', $systemSetting);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $systemSetting = $this->SystemSettings->newEntity();
        if ($this->request->is('post')) {
            $systemSetting = $this->SystemSettings->patchEntity($systemSetting, $this->request->getData());
            if ($this->SystemSettings->save($systemSetting)) {
                $this->Flash->success(__('The system setting has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The system setting could not be saved. Please, try again.'));
        }
        $currentCourses = $this->SystemSettings->CurrentCourses->find('list', ['limit' => 200]);
        $this->set(compact('systemSetting', 'currentCourses'));
    }

    /**
     * Edit method
     *
     * @param string|null $id System Setting id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $this->viewBuilder()->setLayout('ajax');

        $systemSetting = $this->SystemSettings->get($id, [
            'contain' => []
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $systemSetting = $this->SystemSettings->patchEntity($systemSetting, $this->request->getData());
            $dirtyFields = $systemSetting->getDirty();

            if ($this->SystemSettings->save($systemSetting)) {
                $this->UserAction->logAction(__FILE__, $systemSetting->id, $dirtyFields, $systemSetting);

                $this->Flash->success(__('The system setting has been saved.'));

                $this->Ajax->sendSuccess();
            } elseif ($this->request->is('ajax')) {
                $this->Ajax->sendErrors($systemSetting);
            }
            $this->Flash->error(__('The system setting could not be saved. Please, try again.'));
        }
        $this->set(compact('systemSetting'));
    }

    /**
     * Edit method
     *
     * @param string|null $id System Setting id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function editTimezone($id = null)
    {
        $this->edit($id);
    }

    /**
     * Delete method
     *
     * @param string|null $id System Setting id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $systemSetting = $this->SystemSettings->get($id);
        if ($this->SystemSettings->delete($systemSetting)) {
            $this->Flash->success(__('The system setting has been deleted.'));
        } else {
            $this->Flash->error(__('The system setting could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
