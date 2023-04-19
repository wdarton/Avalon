<?php
namespace Avalon\Controller;
use ReflectionClass;
use ReflectionMethod;
use \Cake\Filesystem\Folder;
use \Cake\Filesystem\File;
use App\Controller\AppController;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;
use Cake\Collection\Collection;

/**
 * Acos Controller
 *
 * @property \App\Model\Table\AcosTable $Acos
 *
 * @method \App\Model\Entity\Aco[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AcosController extends AppController
{
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Acos = TableRegistry::getTableLocator()->get('Acos');
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['ParentAcos']
        ];
        $acos = $this->Acos->getAcos();
        $resources = $this->getResources();

        $this->set(compact('acos','resources'));


    }

    /**
     * View method
     *
     * @param string|null $id Aco id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $aco = $this->Acos->get($id, [
            'contain' => ['ParentAcos', 'ChildAcos', 'Permissions']
        ]);

        $this->set('aco', $aco);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $aco = $this->Acos->newEntity();
        if ($this->request->is('post')) {
            $aco = $this->Acos->patchEntity($aco, $this->request->getData());
            if ($this->Acos->save($aco)) {
                $this->Flash->success(__('The aco has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The aco could not be saved. Please, try again.'));
        }
        $parentAcos = $this->Acos->ParentAcos->find('list', ['limit' => 200]);
        $this->set(compact('aco', 'parentAcos'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Aco id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $aco = $this->Acos->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $aco = $this->Acos->patchEntity($aco, $this->request->getData());
            if ($this->Acos->save($aco)) {
                $this->Flash->success(__('The aco has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The aco could not be saved. Please, try again.'));
        }
        $parentAcos = $this->Acos->ParentAcos->find('list', ['limit' => 200]);
        $this->set(compact('aco', 'parentAcos'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Aco id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $aco = $this->Acos->get($id);
        if ($this->Acos->delete($aco)) {
            $this->Flash->success(__('The aco has been deleted.'));
        } else {
            $this->Flash->error(__('The aco could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function updateAcos()
    {
        Log::debug('======================================');
        Log::debug('Begin Updating ACOs');
        Log::debug('======================================');
        $resources = $this->getResources();
        $avalonResources['Avalon'] = $this->getResources('../plugins/Avalon/src/Controller', 'Avalon');
        $resources = array_merge($resources, $avalonResources);

        $existingACOs = $this->Acos->find('all');
        $existingACOs = new Collection($existingACOs);
        $existingACOs = $existingACOs->indexBy('id')->toArray();

        foreach ($resources as $resource => $items) {
            // $resource is top most label
            // Log::debug('Test');
            // Check to see if this resource exists
            $exisingResource = $this->Acos->find('all', [
                'conditions' => [
                    'parent_id is null',
                    'alias' => $resource,
                ],
            ])->first();

            // Debugging
            if ($exisingResource) {
                Log::debug('Line: '.__LINE__.' Found Resource: '.$exisingResource->alias);
                unset($existingACOs[$exisingResource->id]);
            }

            if (!$exisingResource) {
                Log::debug('Line: '.__LINE__.' *** Creating Resource: '.$resource);
                $resourceAco = $this->Acos->newEntity();
                $resourceAco->alias = $resource;
                $this->Acos->save($resourceAco);
            }

            foreach ($items as $key => $item) {
                if (!is_array($item)) {
                    // These are actons

                    // Check to see if this action exists
                    if ($exisingResource) {
                        $exisingAction = $this->Acos->find('all', [
                            'conditions' => [
                                'parent_id' => $exisingResource->id,
                                'alias' => $item,
                            ],
                        ])->first();

                        // Debugging
                        if ($exisingAction) {
                            Log::debug('Line: '.__LINE__.' Found Action: '.$exisingAction->alias);
                            unset($existingACOs[$exisingAction->id]);
                        }

                        if (!$exisingAction) {
                            Log::debug('Line: '.__LINE__.' *** Creating Action: '.$item);

                            $itemAco = $this->Acos->newEntity();
                            $itemAco->alias = $item;
                            $itemAco->parent_id = $exisingResource->id;
                            $this->Acos->save($itemAco);
                        }

                    } else {
                        Log::debug('Line: '.__LINE__.' *** Creating Action: '.$item);

                        $itemAco = $this->Acos->newEntity();
                        $itemAco->alias = $item;
                        $itemAco->parent_id = $resourceAco->id;
                        $this->Acos->save($itemAco);
                    } // If existing resource

                } else {
                    // These are controllers under a prefix

                    // Check to see if the controller exists
                    if ($exisingResource) {
                        $exisingController = $this->Acos->find('all', [
                            'conditions' => [
                                'parent_id' => $exisingResource->id,
                                'alias' => $key,
                            ],
                        ])->first();

                        // Debugging
                        if ($exisingController) {
                            Log::debug('Line: '.__LINE__.' Found Prefix Controller: '.$exisingController->alias);
                            unset($existingACOs[$exisingController->id]);
                        }

                        if (!$exisingController) {
                            Log::debug('Line: '.__LINE__.' *** Creating Prefix Controller: '.$key);

                            $prefixAco = $this->Acos->newEntity();
                            $prefixAco->alias = $key;
                            $prefixAco->parent_id = $resourceAco->id;
                            $this->Acos->save($prefixAco);
                        }

                    } else {
                        Log::debug('Line: '.__LINE__.' *** Creating Prefix Controller: '.$key);

                        $prefixAco = $this->Acos->newEntity();
                        $prefixAco->alias = $key;
                        $prefixAco->parent_id = $resourceAco->id;
                        $this->Acos->save($prefixAco);
                    } // If existing resource

                    foreach ($item as $subResource => $value) {
                        // These are actions

                        // Check to see if the action exists
                        if (isset($exisingController)) {
                            if ($exisingController) {
                                $exisingAction = $this->Acos->find('all', [
                                    'conditions' => [
                                        'parent_id' => $exisingController->id,
                                        'alias' => $value,
                                    ],
                                ])->first();

                                // Debugging
                                if ($exisingAction) {
                                    Log::debug('Line: '.__LINE__.' Found Prefix Action: '.$exisingAction->alias);
                                    unset($existingACOs[$exisingAction->id]);
                                }

                                if (!$exisingAction) {
                                    Log::debug('Line: '.__LINE__.' *** Creating Prefix Action: '.$value);

                                    $itemAco = $this->Acos->newEntity();
                                    $itemAco->alias = $value;
                                    $itemAco->parent_id = $exisingController->id;
                                    $this->Acos->save($itemAco);
                                }
                            }

                        } else {
                            Log::debug('Line: '.__LINE__.' *** Creating Prefix Action: '.$value);

                            $itemAco = $this->Acos->newEntity();
                            $itemAco->alias = $value;
                            $itemAco->parent_id = $prefixAco->id;
                            $this->Acos->save($itemAco);
                        } // If existing resource

                    }
                }
            }
        }

        // Remove no longer needed ACOs and Permissions
        if (!empty($existingACOs)) {
            Log::debug('Deleting ACOs and permissions is necessary');
            foreach ($existingACOs as $existingACO) {
                $oldACO = $this->Acos->get($existingACO['id']);
                $this->Acos->delete($oldACO);

                // Delete all permissions that reference this ACO
                $this->Acos->Permissions->deleteAll(['aco_id' => $existingACO['id']]);
            }
        }


        // Rebuild permissions

        $acos = $this->Acos->find('all');

        $permissions = [];

        // Generate the permissions array
        foreach ($acos as $aco) {
            if (is_null($aco->parent_id)) {
                $allowed = 1;
            } else {
                $allowed = -1;
            }

            $permissions['aco-'.$aco->id] = $allowed;

        }

        // Rebuild Admin permissions
        $this->Acos->Permissions->savePermissions($permissions, 1);

        Log::debug('==== Updating non-admin permissions ====');
        $this->Acos->Permissions->updateNonAdminPermissions();


        $this->set(compact('resources', 'acos', 'permissions', 'existingACOs'));
    }

    private function getResources($dir = '../src/Controller/', $namespace = 'App')
    {
        // $dir = '../src/Controller/';
        $controllers = $this->getControllers($dir);
        $resources = [];
        foreach ($controllers as $key => $value) {
            if (!is_array($value)) {
                $actions = $this->getActions($value, '', $namespace);
                $resources[$value] = $actions;
            } else {
                // These are controllers with a prefix
                foreach ($value as $subController) {
                    $actions = $this->getActions($subController, $key);
                    $resources[$key][$subController] = $actions;
                }
            }
        }
        return $resources;
    }

    private function getActions($controllerName, $dir="", $namespace = 'App')
    {
        if ($dir !== '') {
            $dir = $dir.'\\';
        }
        $className = $namespace.'\\Controller\\'.$dir.$controllerName.'Controller';
        $class = new ReflectionClass($className);
        $actions = $class->getMethods(ReflectionMethod::IS_PUBLIC);
        // $results = [$controllerName => []];
        $ignoreList = ['beforeFilter', 'afterFilter', 'initialize'];
        foreach ($actions as $action) {
            if ($action->class == $className && !in_array($action->name, $ignoreList)) {
                // array_push($results[$controllerName], $action->name);
                $results[] = $action->name;
            }
        }
        return $results;
    }


    private function getControllers($dir = '../src/Controller/')
    {
        // $dir = ROOT.DS.'src'.DS.'Controller';
        $items = $this->getFolderContents($dir);

        $subFolders = $items[0];
        foreach ($subFolders as $folder) {
            $folderItems = $this->getFolderContents($dir.DS.$folder);
            $items[1][$folder] = $folderItems[1];
        }
        $controllers = $items[1];
        $cleanControllers = [];

        // return $controllers;

        foreach ($controllers as $key => $controller) {
            if (!is_array($controller)) {
                $cleanControllers[] = str_replace('Controller.php','',$controller);
            } else {
                foreach ($controller as $subController) {
                    $cleanControllers[$key][] = str_replace('Controller.php','',$subController);
                }
            }
        }
        return $cleanControllers;

    }

    private function getFolderContents($dir)
    {
        $folder = new Folder($dir);
        $controllerFiles = $folder->find('.*.php', true);

        $ignoreList = [
            'Component',
            'AppController.php',
            'ErrorController.php',
        ];
        $items = $folder->read(true, $ignoreList);

        return $items;
    }

}
