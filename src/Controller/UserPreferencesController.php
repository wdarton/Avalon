<?php
declare(strict_types=1);

namespace Avalon\Controller;

use Avalon\Controller\AppController;
use Cake\Log\Log;

/**
 * UserPreferences Controller
 *
 * @property \Avalon\Model\Table\UserPreferencesTable $UserPreferences
 * @method \Avalon\Model\Entity\UserPreference[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UserPreferencesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    // public function index()
    // {
    //     $userPreferences = $this->paginate($this->UserPreferences);

    //     $this->set(compact('userPreferences'));
    // }

    /**
     * View method
     *
     * @param string|null $id User Preference id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    // public function view($id = null)
    // {
    //     $userPreference = $this->UserPreferences->get($id, [
    //         'contain' => [],
    //     ]);

    //     $this->set(compact('userPreference'));
    // }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    // public function add()
    // {
    //     $userPreference = $this->UserPreferences->newEmptyEntity();
    //     if ($this->request->is('post')) {
    //         $userPreference = $this->UserPreferences->patchEntity($userPreference, $this->request->getData());
    //         if ($this->UserPreferences->save($userPreference)) {
    //             $this->Flash->success(__('The user preference has been saved.'));

    //             return $this->redirect(['action' => 'index']);
    //         }
    //         $this->Flash->error(__('The user preference could not be saved. Please, try again.'));
    //     }
    //     $this->set(compact('userPreference'));
    // }

    /**
     * Edit method
     *
     * @param string|null $id User Preference id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $userPreference = $this->UserPreferences->find('all', [
            'conditions' => [
                'user_id' => $this->Authentication->getIdentity()->id,
            ],
        ])->firstOrFail();
        if ($this->request->is(['patch', 'post', 'put'])) {
            $userPreference = $this->UserPreferences->patchEntity($userPreference, $this->request->getData());
            Log::debug(json_encode($userPreference->getDirty()));
            if ($this->UserPreferences->save($userPreference)) {
                $this->Flash->success(__('The user preferences have been saved.'));

                return $this->redirect($this->request->getData('redirect'));
            }
            $this->Flash->error(__('The user preferences could not be saved. Please, try again.'));
        }
        $this->set(compact('userPreference'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User Preference id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    // public function delete($id = null)
    // {
    //     $this->request->allowMethod(['post', 'delete']);
    //     $userPreference = $this->UserPreferences->get($id);
    //     if ($this->UserPreferences->delete($userPreference)) {
    //         $this->Flash->success(__('The user preference has been deleted.'));
    //     } else {
    //         $this->Flash->error(__('The user preference could not be deleted. Please, try again.'));
    //     }

    //     return $this->redirect(['action' => 'index']);
    // }
}
