<?php
namespace Avalon\Controller;

use App\Controller\AppController;
use Cake\Event\EventInterface;
use Cake\ORM\TableRegistry;
use Cake\I18n\FrozenTime;
use Cake\Core\Configure;
use Cake\Log\Log;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{
    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);
        $this->loadComponent('Avalon.Ajax');

        // $this->Auth->allow(['login', 'logout', 'resetPassword']);
        // Configure the login action to not require authentication, preventing
        // the infinite redirect loop issue
        $this->Authentication->addUnauthenticatedActions(['login', 'logout']);
    }

    public function login()
    {
        // Log::debug('running login');
        $this->viewBuilder()->setLayout('login');
        $this->request->allowMethod(['get', 'post']);
        $result = $this->Authentication->getResult();
        // regardless of POST or GET, redirect if user is logged in
        if ($result && $result->isValid()) {
            // The user is logged in

            if (isset($authUser)) {
                // Log::debug('auth user set in Users controller');
            } else {
                // Log::debug('auth user not set in Users controller');
            }

            $user = $this->Authentication->getIdentity();

            if ($this->request->is('post')) {
                // Set their last logon time
                $now = FrozenTime::now();

                $updateUser = $this->Users->get($user->id);

                $updateUser->set('last_logon', $now);
                $updateUser->login_count ++;

                // Mark the modified column as dirty making
                // the current value be set on update.
                $updateUser->setDirty('modified', true);
                $this->Users->save($updateUser);

                // Log the login
                $newLogin = $this->Users->UserLogins->newEmptyEntity();

                $newLogin->user_id = $user->id;
                $newLogin->username = $user->username;
                $newLogin->created = $now;
                $newLogin->success = 1;

                $this->Users->UserLogins->save($newLogin);

                if ($user->reset_password) {
                    $this->Flash->warning(__('You must reset your password before continuing'));

                    return $this->redirect(['controller' => 'users', 'action' => 'reset-password']);
                } else {

                    // Check if there is a URL redirect from login
                    if ($this->request->getData('redirect')) {
                        // Log::debug('Attempting to redirect');
                        return $this->redirect($this->request->getData('redirect'));
                    }

                }
            }
            return $this->redirect('/dashboard');
            // return $this->redirect($this->Auth->redirectUrl('/pages/dashboard'));

        }
        // display error if user submitted and authentication failed
        if ($this->request->is('post') && !$result->isValid()) {
            $this->Flash->error(__('Invalid username or password'));
        }
    }

    public function login_old()
    {
        $this->viewBuilder()->setLayout('login');
        // if ($this->Auth->user()) {
        //     $this->redirect(['controller' => 'users', 'action' => 'index']);
        // }

        if ($this->request->is('post'))
        {

            // Make sure we have been given data
            if (empty($this->request->data['username']) || empty($this->request->data['password']))
            {
                $this->Flash->error('Please enter a username and or password');
            }
            else
            {
                // $this->loadModel('UserLogins');
                // $userLogin = $this->UserLogins->newEntity();
                // $userLogin->username = $this->request->data['username'];
                // $userLogin->success = 0;
                // $userLogin->ipv4_address = $this->request->clientIp();

                $user = $this->Auth->identify();

                if($user)
                {
                    // Log::debug($user);
                    $this->Auth->setUser($user);

                    // $userLogin->success = 1;
                    // $userLogin->user_id = $this->Auth->user('id');
                    // $this->UserLogins->save($userLogin);


                    // Set their last logon time
                    $now = Time::now();

                    $updateUser = $this->Users->get($this->Auth->user('id'));

                    $updateUser->set('last_logon', $now);
                    $updateUser->login_count ++;

                    // Mark the modified column as dirty making
                    // the current value be set on update.
                    $updateUser->dirty('modified', true);
                    $this->Users->save($updateUser);


                    // Check to see if the current user needs to reset their password

                    if ($this->Auth->user('reset_password')) {
                        $this->Flash->warning(__('You must reset your password before continuing'));

                        return $this->redirect(['controller' => 'users', 'action' => 'reset-password']);
                    } else {

                        // Check if there is a URL redirect from login
                        if (isset($this->request->data['redirect'])) {
                            return $this->redirect($this->Auth->redirectUrl($this->request->data['redirect']));
                        }

                        return $this->redirect($this->Auth->redirectUrl('/pages/dashboard'));
                    }


                } elseif ($user == -1) {
                    $this->Flash->error(__('Your account is currently locked. Please contact your supervisor for assistance.'));
                } else {
                    $this->Flash->error(__('Invalid username or password, try again'));
                }

                // $this->UserLogins->save($userLogin);
            }
        }
    }

    public function logout()
    {
        $result = $this->Authentication->getResult();
        // regardless of POST or GET, redirect if user is logged in
        if ($result && $result->isValid()) {
            $this->request->getSession()->destroy();
            $this->Authentication->logout();
            $this->Flash->info(__('You have succesfully logged out.'));
        }
            return $this->redirect('/login');
    }

    public function resetPassword()
    {
        $user = $this->Users->get($this->Authentication->getIdentity()->id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            $user->reset_password = 0;

            $dirtyFields = $user->getDirty();

            if ($this->Users->save($user)) {

                // $this->UserAction->logAction(__FILE__, $this->Auth->user('id'));

                $this->Flash->success(__('Your password has been changed'));

                return $this->redirect([
                    'plugin' => false,
                    'controller' => 'Pages',
                    'action' => 'dashboard',
                    'prefix' => false
                ]);
            }
            $this->Flash->error(__('Your password could not be saved. Please, try again.'));
        }

        $this->set(compact('user'));
    }

    public function adminResetPassword($id = null)
    {
        $user = $this->Users->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            $dirtyFields = $user->getDirty();

            if ($this->Users->save($user)) {

                // $this->UserAction->logAction(__FILE__, $id, $dirtyFields, $user);

                $this->Flash->success(__("The password for {$user->full_name} has been changed"));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__("The password for {$user->full_name} could not be saved. Please, try again."));
        }

        $this->set(compact('user'));
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Roles']
        ];
        $users = $this->paginate($this->Users);

        $this->set(compact('users'));
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        // $user = $this->Users->get($id, [
        //     'contain' => ['Roles', 'UserRoles']
        // ]);

        // if ($this->request->is('ajax')) {
        //     $this->Ajax->sendToView($user);
        // }

        // $this->set('user', $user);
        // $this->UserAction->logAction(__FILE__, $id);

        // $this->loadModel('UserLogins');
        // $this->loadModel('UserActionLogs');

        $user = $this->Users->get($id, [
            'contain' => ['Roles'],
        ]);

        if ($this->request->is('ajax')) {
            $this->Ajax->sendToView($user);
        }

        $userLogins = $this->Users->UserLogins->find('all', [
            'conditions' => [
                'or' => [
                    'user_id' => $id,
                    'username LIKE' => '%'.$user->username.'%'
                ]
            ],
            'limit' => '500',
            'order' => ['created' => 'DESC'],
        ]);

        $userActions = $this->Users->UserActionLogs->find('all', [
            'conditions' => [
                'user_id' => $id,
            ],
            'limit' => '500',
            'order' => ['created' => 'DESC'],
        ]);

        $this->set('user', $user);
        $this->set('userLogins', $userLogins);
        $this->set('userActions', $userActions);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        // $user = $this->Users->newEntity();
        // if ($this->request->is('post')) {
        //     $user = $this->Users->patchEntity($user, $this->request->getData());
        //     if ($this->Users->save($user)) {
        //         $this->Flash->success(__('The user has been saved.'));

        //         return $this->redirect(['action' => 'index']);
        //     }
        //     $this->Flash->error(__('The user could not be saved. Please, try again.'));
        // }
        // $roles = $this->Users->Roles->find('list', ['limit' => 200]);
        // $this->set(compact('user', 'roles'));
        $user = $this->Users->newEmptyEntity();
        if ($this->request->is('post')) {

            // Make sure that the password and password confirm fields match

            $password = $this->request->getData('password');
            $passwordConfirm = $this->request->getData('password_confirm');
            if ($password !== $passwordConfirm) {
                $this->Flash->error(__('The passwords do not match'));
            } else {
                $user = $this->Users->patchEntity($user, $this->request->getData());
                if ($this->Users->save($user)) {
                    // $this->UserAction->logAction(__FILE__, $user->id);
                    $this->Flash->success(__('The user has been saved.'));

                    // Create the associated user preference
                    $userPreference = $this->Users->UserPreferences->newEmptyEntity();

                    $userPreference->user_id = $user->id;
                    $userPreference->user_timezone = $this->request->getData('user_timezone');

                    $this->Users->UserPreferences->save($userPreference);

                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error(__('The user could not be saved. Please, try again.'));
            }

        }
        $userRoles = $this->Users->Roles->find('list', ['limit' => 200]);

        $this->set(compact('user', 'userRoles'));
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        // $user = $this->Users->get($id, [
        //     'contain' => []
        // ]);
        // if ($this->request->is(['patch', 'post', 'put'])) {
        //     $user = $this->Users->patchEntity($user, $this->request->getData());
        //     if ($this->Users->save($user)) {
        //         $this->Flash->success(__('The user has been saved.'));

        //         return $this->redirect(['action' => 'index']);
        //     }
        //     $this->Flash->error(__('The user could not be saved. Please, try again.'));
        // }
        // $roles = $this->Users->Roles->find('list', ['limit' => 200]);
        // $this->set(compact('user', 'roles'));
        if ($this->request->is(['ajax'])) {
            $data = $this->request->getData();
            $groupId = $data['user_group_id'];
            $roles = $this->Users->Roles->getRolesByGroup($groupId);
            $this->Ajax->sendToView($roles);
        }

        $user = $this->Users->get($id, [
            'contain' => ['Roles'],
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            $dirtyFields = $user->getDirty();

            if ($this->Users->save($user)) {

                // $this->UserAction->logAction(__FILE__, $id, $dirtyFields, $user);

                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }

        $roles = $this->Users->Roles->find('list', ['limit' => 200]);

        $this->set(compact('user', 'roles'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'ajax', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        if ($this->request->is('ajax')) {
            $this->Ajax->sendSuccess();
        } else {
            return $this->redirect(['action' => 'index']);
        }

        // return $this->redirect(['action' => 'index']);
    }
}
