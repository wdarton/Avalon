<?php
namespace Avalon\Controller\Admin;
use ReflectionClass;
use ReflectionMethod;
use \Cake\Filesystem\Folder;
use \Cake\Filesystem\File;
use App\Controller\AppController;
use Cake\Event\EventInterface;
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

    private $existingACOs;
    private $existingResource;
    private $resourceAco;

    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);
        $this->Acos = TableRegistry::getTableLocator()->get('Avalon.Acos');
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
        $aco = $this->Acos->newEmptyEntity();
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

    public function updateAcosNew()
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
            // echo '<strong>C: '.$resource.'</strong><br>';
            $existingResource = $this->createNewAcoCategory($resource, null, 'ACO Category');

            foreach ($items as $item => $itemValue) {

                if (!is_array($itemValue)) {
                    // echo $tab.'I: '.$itemValue.'<br>';
                    $existingAco = $this->createNewACO($itemValue, $existingResource, 'I');
                } else {
                    // These are controllers under a prefix
                    // echo $tab.'<strong>CK: '.$item.'</strong><br>';
                    $existingAco = $this->createNewACO($item, $existingResource, 'CK');

                    foreach ($itemValue as $subItem => $subValue) {
                        // echo '$subItem TYPE: '.gettype($subItem);
                        if (!is_array($subValue)) {
                            // echo $tab.$tab.'I: '.$subValue.'<br>';
                            $existingAcoItem = $this->createNewACO($subValue, $existingAco, 'I');

                        } else {
                            $existingAcoItem = $this->createNewACO($subItem, $existingAco, 'CV');
                            // echo $tab.$tab.'<strong>CV: '.$subItem.'</strong><br>';

                            foreach ($subValue as $prefixItem => $prefixValue) {
                                if (!is_array($prefixValue)) {
                                    $existingAcoPrefixItem = $this->createNewACO($prefixValue, $existingAcoItem, 'I');
                                    // echo $tab.$tab.$tab.'I: '.$prefixValue.'<br>';
                                }
                            }
                        }

                    }
                }
            }
                    // echo "<hr>";
        }



        // foreach ($resources as $resource => $items) {
        //     $existingResource = $this->createNewAcoCategory($resource, null, 'ACO Category');

        //     foreach ($items as $item => $itemValue) {
        //         if (!is_array($item)) {
        //             // Controller
        //             $existingController = $this->createNewAcoCategory($item, $existingResource, 'Controller');
        //         } else {
        //             // Prefix or plugin
        //             $existingPrefix = $this->createNewAcoCategory($item, $existingController, 'Prefix');
        //             foreach ($prefix as $prefixItem => $prefixValue) {
        //                 $existingPrefixItem = $this->createNewAcoCategory($prefix, $existingPrefix, 'Prefix Item');
        //             }
        //         }
        //     }
        // }

        // foreach ($resources as $resource => $items) {
        //     $existingResource = $this->createNewAcoCategory($resource, null, 'ACO Category');

        //     foreach ($items as $key => $item) {
        //         if (!is_array($item)) {
        //             // These are actons

        //             $existingAction = $this->createNewACO($item, $existingResource, 'Action');

        //         } else {
        //             // These are controllers under a prefix
        //             // Check to see if the controller exists
        //             $prefixAco = $this->createNewACO($key, $existingResource, 'Action');

        //             foreach ($item as $subResource => $value) {
        //                 // These are actions

        //                 if (!is_array($value)) {
        //                     // Check to see if the action exists
        //                     if (isset($exisingController)) {
        //                         if ($exisingController) {
        //                             $exisingAction = $this->Acos->find('all', [
        //                                 'conditions' => [
        //                                     'parent_id' => $exisingController->id,
        //                                     'alias' => $value,
        //                                 ],
        //                             ])->first();

        //                             // Debugging
        //                             if ($exisingAction) {
        //                                 Log::debug('Line: '.__LINE__.' Found Prefix Action: '.$exisingAction->alias);
        //                                 unset($existingACOs[$exisingAction->id]);
        //                             }

        //                             if (!$exisingAction) {
        //                                 Log::debug('Line: '.__LINE__.' *** Creating Prefix Action: '.$value);

        //                                 $itemAco = $this->Acos->newEmptyEntity();
        //                                 $itemAco->alias = $value;
        //                                 $itemAco->parent_id = $exisingController->id;
        //                                 $this->Acos->save($itemAco);
        //                             }
        //                         }

        //                     } else {
        //                         Log::debug('Line: '.__LINE__.' *** Creating Prefix Action: '.$value);

        //                         $itemAco = $this->Acos->newEmptyEntity();
        //                         $itemAco->alias = $value;
        //                         $itemAco->parent_id = $prefixAco->id;
        //                         $this->Acos->save($itemAco);
        //                     } // If existing resource
        //                 } else {

        //                 }

        //             }
        //         }
        //     }
        // }

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
    } // End updateAcosNew()

    public function updateAcos()
    {
        Log::debug('======================================');
        Log::debug('Begin Updating ACOs');
        Log::debug('======================================');
        $resources = $this->getResources();
        $avalonResources['Avalon'] = $this->getResources(ROOT.'/plugins/Avalon/src/Controller', 'Avalon');
        $resources = array_merge($resources, $avalonResources);
        Log::debug('resources: '. print_r($resources, true));
        $existingACOs = $this->Acos->find('all');
        $existingACOs = new Collection($existingACOs);
        $existingACOs = $existingACOs->indexBy('id')->toArray();

        foreach ($resources as $resource => $items) {
            // $resource is top most label
            // Log::debug('Test');
            // Check to see if this resource exists
            $existingResource = $this->Acos->find('all', [
                'conditions' => [
                    'parent_id is null',
                    'alias' => $resource,
                ],
            ])->first();

            // Debugging
            if ($existingResource) {
                Log::debug('Line: '.__LINE__.' Found Resource: '.$existingResource->alias);
                unset($existingACOs[$existingResource->id]);
            }

            if (!$existingResource) {
                Log::debug('Line: '.__LINE__.' *** Creating Resource: '.$resource);
                $resourceAco = $this->Acos->newEmptyEntity();
                $resourceAco->alias = $resource;
                $this->Acos->save($resourceAco);
            }

            foreach ($items as $key => $item) {
                if (!is_array($item)) {
                    // These are actons

                    // Check to see if this action exists
                    if ($existingResource) {
                        $exisingAction = $this->Acos->find('all', [
                            'conditions' => [
                                'parent_id' => $existingResource->id,
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

                            $itemAco = $this->Acos->newEmptyEntity();
                            $itemAco->alias = $item;
                            $itemAco->parent_id = $existingResource->id;
                            $this->Acos->save($itemAco);
                        }

                    } else {
                        Log::debug('Line: '.__LINE__.' *** Creating Action: '.$item);

                        $itemAco = $this->Acos->newEmptyEntity();
                        $itemAco->alias = $item;
                        $itemAco->parent_id = $resourceAco->id;
                        $this->Acos->save($itemAco);
                    } // If existing resource

                } else {
                    // These are controllers under a prefix

                    ///////////
                    // First //
                    ///////////

                    // Check to see if the controller exists
                    if ($existingResource) {
                        $exisingController = $this->Acos->find('all', [
                            'conditions' => [
                                'parent_id' => $existingResource->id,
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

                            $prefixAco = $this->Acos->newEmptyEntity();
                            $prefixAco->alias = $key;
                            $prefixAco->parent_id = $resourceAco->id;
                            $this->Acos->save($prefixAco);
                        }

                    } else {
                        Log::debug('Line: '.__LINE__.' *** Creating Prefix Controller: '.$key);

                        $prefixAco = $this->Acos->newEmptyEntity();
                        $prefixAco->alias = $key;
                        $prefixAco->parent_id = $resourceAco->id;
                        $this->Acos->save($prefixAco);
                    } // If existing resource

                    foreach ($item as $subResource => $value) {
                        if (!is_array($value)) {
                            // These are actons
                            Log::debug('Line: '.__LINE__.' *** subResource: '.print_r($subResource, true));
                            Log::debug('Line: '.__LINE__.' *** value: '.print_r($value, true));

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

                                        $itemAco = $this->Acos->newEmptyEntity();
                                        $itemAco->alias = $value;
                                        $itemAco->parent_id = $exisingController->id;
                                        $this->Acos->save($itemAco);
                                    }
                                }

                            } else {
                                Log::debug('Line: '.__LINE__.' *** Creating Prefix Action: '.$value);

                                $itemAco = $this->Acos->newEmptyEntity();
                                $itemAco->alias = $value;
                                $itemAco->parent_id = $prefixAco->id;
                                $this->Acos->save($itemAco);
                            } // If existing resource
                        } else {
                            // These are controllers under a prefix
                            
                            ////////////
                            // Second //
                            ////////////
                            
                            // Check to see if the controller exists
                            if ($existingResource) {
                                $exisingController = $this->Acos->find('all', [
                                    'conditions' => [
                                        'parent_id' => $existingResource->id,
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

                                    $prefixAco = $this->Acos->newEmptyEntity();
                                    $prefixAco->alias = $key;
                                    $prefixAco->parent_id = $resourceAco->id;
                                    $this->Acos->save($prefixAco);
                                }

                            } else {
                                Log::debug('Line: '.__LINE__.' *** Creating Prefix Controller: '.$key);

                                $prefixAco = $this->Acos->newEmptyEntity();
                                $prefixAco->alias = $key;
                                $prefixAco->parent_id = $resourceAco->id;
                                $this->Acos->save($prefixAco);
                            } // If existing resource

                            foreach ($value as $subResource => $value) {
                                if (!is_array($value)) {
                                    // These are actons
                                    Log::debug('Line: '.__LINE__.' *** subResource: '.print_r($subResource, true));
                                    Log::debug('Line: '.__LINE__.' *** value: '.print_r($value, true));

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

                                                $itemAco = $this->Acos->newEmptyEntity();
                                                $itemAco->alias = $value;
                                                $itemAco->parent_id = $exisingController->id;
                                                $this->Acos->save($itemAco);
                                            }
                                        }

                                    } else {
                                        Log::debug('Line: '.__LINE__.' *** Creating Prefix Action: '.$value);

                                        $itemAco = $this->Acos->newEmptyEntity();
                                        $itemAco->alias = $value;
                                        $itemAco->parent_id = $prefixAco->id;
                                        $this->Acos->save($itemAco);
                                    } // If existing resource
                                } else {
                                    // These are controllers under a prefix
                                    Log::debug('Line: '.__LINE__.' *** Value is an array: '.print_r($value, true));

                                    
                                }

                            }
                            
                        }

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

        $this->Flash->success(__('ACOs have been updated.'));
        return $this->redirect($this->referer());
    } // End updateAcos()

    private function getResources($dir = APP.'Controller/', $namespace = 'App')
    {
        // $dir = '../src/Controller/';
        Log::debug('Searching in directory: '.$dir);
        $controllers = $this->getControllers($dir);
        $resources = [];
        foreach ($controllers as $key => $value) {
            if (!is_array($value)) {
                $actions = $this->getActions($value, '', $namespace);
                $resources[$value] = $actions;
            } else {
                // These are controllers with a prefix
                foreach ($value as $subController) {
                    $actions = $this->getActions($subController, $key, 'Avalon');
                    $resources[$key][$subController] = $actions;
                }
            }
        }
        return $resources;
    }

    private function getActions($controllerName, $dir="", $namespace = 'App')
    {
        Log::debug('controller: '.$controllerName);
        Log::debug('controller: '.$controllerName);
        Log::debug('dir: '.$dir);

        if ($dir !== '') {
            // if ($dir === 'Admin') {
            //     $dir = '';
            // } else {
            // }
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

    private function createNewACO($resource, $parentAco = null, $type = null)
    {
        Log::debug('Line: '.__LINE__.' Checking '.$type.': '.$resource);

        // Check to see if this action exists
        if ($parentAco) {
            $exisingAco = $this->Acos->find('all', [
                'conditions' => [
                    'parent_id' => $parentAco->id,
                    'alias' => $resource,
                ],
            ])->first();

            // Debugging
            if ($exisingAco) {
                Log::debug('Line: '.__LINE__.' Found '.$type.' '.$exisingAco->alias);
                unset($existingACOs[$exisingAco->id]);
            }

            if (!$exisingAco) {
                Log::debug('Line: '.__LINE__.' *** Creating '.$type.': '.$resource);

                $resourceAco = $this->Acos->newEmptyEntity();
                $resourceAco->alias = $resource;
                $resourceAco->parent_id = $parentAco->id;
                $this->Acos->save($resourceAco);

                return $resourceAco;
            }

        } else {
            Log::debug('Line: '.__LINE__.' *** Creating '.$type.': '.$resource);

            $resourceAco = $this->Acos->newEmptyEntity();
            $resourceAco->alias = $resource;
            $resourceAco->parent_id = $resourceAco->id;
            $this->Acos->save($resourceAco);
            
            return $resourceAco;
        } // If existing resource 

        return $exisingAco;

    }

    private function createNewAcoCategory($resource, $parentAco = null, $type = null)
    {
        Log::debug('Line: '.__LINE__.' Checking '.$type.': '.$resource);
        // Check to see if this resource exists
        $existingResource = $this->Acos->find('all', [
            'conditions' => [
                'parent_id is null',
                'alias' => $resource,
            ],
        ])->first();

        // Debugging
        if ($existingResource) {
            Log::debug('Line: '.__LINE__.' Found '.$type.': '.$existingResource->alias);
            unset($existingACOs[$existingResource->id]);
        }

        if (!$existingResource) {
            Log::debug('Line: '.__LINE__.' *** Creating '.$type.': '.$resource);
            $resourceAco = $this->Acos->newEmptyEntity();
            $resourceAco->alias = $resource;
            $this->Acos->save($resourceAco);
            // Log::debug('Line: '.__LINE__.' *** '.$type.' id: '.$resourceAco->id);
            
            return $resourceAco;
        }

        return $existingResource;
    }

    // private function createSubResources($resource) 
    // {

    //     Log::debug('Line: '.__LINE__.' Checking subResource: '.$resource);
    //     // Check to see if this resource exists
    //     $this->existingResource = $this->Acos->find('all', [
    //         'conditions' => [
    //             'parent_id is null',
    //             'alias' => $resource,
    //         ],
    //     ])->first();

    //     // Debugging
    //     if ($this->existingResource) {
    //         Log::debug('Line: '.__LINE__.' Found Resource: '.$this->existingResource->alias);
    //         unset($this->existingACOs[$this->existingResource->id]);
    //     }

    //     if (!$this->existingResource) {
    //         Log::debug('Line: '.__LINE__.' *** Creating Resource: '.$resource);
    //         $this->resourceAco = $this->Acos->newEmptyEntity();
    //         $this->resourceAco->alias = $resource;
    //         $this->Acos->save($this->resourceAco);
    //         // Log::debug('Line: '.__LINE__.' *** Resource id: '.$this->resourceAco->id);
    //     }
    // }

    // private function createSubAction($action)
    // {
    //     // Check to see if this action exists
    //     if ($this->existingResource) {
    //         $exisingAction = $this->Acos->find('all', [
    //             'conditions' => [
    //                 'parent_id' => $this->existingResource->id,
    //                 'alias' => $action,
    //             ],
    //         ])->first();

    //         // Debugging
    //         if ($exisingAction) {
    //             Log::debug('Line: '.__LINE__.' Found Action: '.$exisingAction->alias);
    //             unset($this->existingACOs[$exisingAction->id]);
    //         }

    //         if (!$exisingAction) {
    //             Log::debug('Line: '.__LINE__.' *** Creating Action: '.$action);

    //             $itemAco = $this->Acos->newEmptyEntity();
    //             $itemAco->alias = $action;
    //             $itemAco->parent_id = $this->existingResource->id;
    //             $this->Acos->save($itemAco);
    //         }

    //     } else {
    //         Log::debug('Line: '.__LINE__.' *** Creating Action: '.$action);

    //         $itemAco = $this->Acos->newEmptyEntity();
    //         $itemAco->alias = $action;
    //         $itemAco->parent_id = $this->resourceAco->id;
    //         $this->Acos->save($itemAco);
    //     } // If existing resource
    // }

    // private function createSubController($key)
    // {
    //     // Check to see if the controller exists
    //     if ($this->existingResource) {
    //         $exisingController = $this->Acos->find('all', [
    //             'conditions' => [
    //                 'parent_id' => $this->existingResource->id,
    //                 'alias' => $key,
    //             ],
    //         ])->first();

    //         // Debugging
    //         if ($exisingController) {
    //             Log::debug('Line: '.__LINE__.' Found Prefix Controller: '.$exisingController->alias);
    //             unset($this->existingACOs[$exisingController->id]);
    //         }

    //         if (!$exisingController) {
    //             Log::debug('Line: '.__LINE__.' *** Creating Prefix Controller: '.$key);

    //             $prefixAco = $this->Acos->newEmptyEntity();
    //             $prefixAco->alias = $key;
    //             $prefixAco->parent_id = $this->resourceAco->id;
    //             $this->Acos->save($prefixAco);
    //         }

    //     } else {
    //         Log::debug('Line: '.__LINE__.' *** Creating Prefix Controller: '.$key);

    //         $prefixAco = $this->Acos->newEmptyEntity();
    //         $prefixAco->alias = $key;
    //         $prefixAco->parent_id = $this->resourceAco->id;
    //         $this->Acos->save($prefixAco);
    //     } // If existing resource

    //     return $prefixAco;
    // }



}
