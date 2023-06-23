<?php
namespace Avalon\Controller\Admin;

use App\Controller\AppController;

/**
 * Admin Controller
 *
 *
 * @method \App\Model\Entity\Admin[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AdminController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->UserAction->logAction(__FILE__);
    }
}
