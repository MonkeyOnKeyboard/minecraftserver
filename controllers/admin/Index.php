<?php

namespace Modules\Minecraftserver\Controllers\Admin;

use \Modules\Minecraftserver\Mappers\Server as ServerMapper;
use \Modules\Minecraftserver\Models\Server as ServerModel;
use Ilch\Validation;

class Index extends \Ilch\Controller\Admin
{
    public function init()
    {
        $items = [
            [
                'name' => 'menuServer',
                'active' => false,
                'icon' => 'fas fa-th-list',
                'url' => $this->getLayout()->getUrl(['controller' => 'index', 'action' => 'index']),
                [
                    'name' => 'add',
                    'active' => false,
                    'icon' => 'fas fa-plus-circle',
                    'url' => $this->getLayout()->getUrl(['controller' => 'index', 'action' => 'treat'])
                ]
            ],
            [
                'name' => 'settings',
                'active' => false,
                'icon' => 'fas fa-cogs',
                'url' => $this->getLayout()->getUrl(['controller' => 'settings', 'action' => 'index'])
            ]
        ];

        if ($this->getRequest()->getActionName() == 'treat') {
            $items[0][0]['active'] = true;
        } else {
            $items[0]['active'] = true;
        }

        $this->getLayout()->addMenu
        (
            'minecraftserver',
            $items
        );
    }

    public function indexAction()
    {
        $mapper = new ServerMapper();

        $this->getLayout()->getAdminHmenu()
            ->add($this->getTranslator()->trans('minecraftserver'), ['controller' => 'index', 'action' => 'index'])
            ->add($this->getTranslator()->trans('menuServers'), ['action' => 'index']);

        if ($this->getRequest()->getPost('check_server')) {
            if ($this->getRequest()->getPost('action') == 'delete') {
                foreach ($this->getRequest()->getPost('check_server') as $id) {
                    $mapper->delete($id);
                }
            }
        }

        $this->getView()->set('server', $mapper->getMincraftServer());
    }

    public function treatAction()
    {
        $mapper = new ServerMapper();
        $server = new ServerModel();

        if ($this->getRequest()->getParam('id')) {
            $this->getLayout()->getAdminHmenu()
                ->add($this->getTranslator()->trans('minecraftserver'), ['action' => 'index'])
                ->add($this->getTranslator()->trans('edit'), ['action' => 'treat']);

            $server = $mapper->readById($this->getRequest()->getParam('id'));
            $this->getView()->set('server', $server);

            if (!$server) {
                $this->redirect()
                        ->to(['action' => 'index']);
            }
        } else {
            $this->getLayout()->getAdminHmenu()
                ->add($this->getTranslator()->trans('minecraftserver'), ['controller' => 'index', 'action' => 'index'])
                ->add($this->getTranslator()->trans('add'), ['action' => 'treat']);
        }

        if ($this->getRequest()->isPost()) {
            Validation::setCustomFieldAliases([
                'inputServer' => 'server',
                'inputPort' => 'port',
                'inputTimeout' => 'timeout'
            ]);
            
            if ($server->getMinecraftserver() === null || $this->getRequest()->getPost('inputServer') !== $server->getMinecraftserver()) {
                $validationrules = ['inputServer' => 'required|unique:minecraftserver_status,minecraftserver'];
                $validationrules = ['inputPort' => 'required'];
                $validationrules = ['inputTimeout' => 'required'];
            } else {
                $validationrules = ['inputServer' => 'required'];
                $validationrules = ['inputPort' => 'required'];
                $validationrules = ['inputTimeout' => 'required'];
            }

            $validation = Validation::create($this->getRequest()->getPost(), $validationrules);

            if ($validation->isValid()) {
                
                $server->setMinecraftserver($this->getRequest()->getPost('inputServer'))
                ->setPort($this->getRequest()->getPost('inputPort'))
                ->setTimeout($this->getRequest()->getPost('inputTimeout'));

                $mapper->updateDataServer($server);
                
                $this->redirect()
                    ->withMessage('saveSuccess')
                    ->to(['action' => 'index']);
            }

            $this->addMessage($validation->getErrorBag()->getErrorMessages(), 'danger', true);
            $this->redirect()
                ->withInput()
                ->withErrors($validation->getErrorBag())
                ->to(array_merge(['action' => 'treat'], ($this->getRequest()->getParam('id') ? ['id' => $this->getRequest()->getParam('id')] : [])));
        }
    }

    public function updateAction()
    {
        $mapper = new ServerMapper();

        $mapper->updateDataServer();

        $this->redirect()
            ->withMessage('updateSuccess')
            ->to(['action' => 'index']);
    }

    public function deleteAction()
    {
        if ($this->getRequest()->isSecure()) {
            if ($this->getRequest()->getParam('id')) {
                $mapper = new ServerMapper();
                $mapper->delete($this->getRequest()->getParam('id'));

                $this->redirect()
                    ->withMessage('deleteSuccess')
                    ->to(['action' => 'index']);
            }
        }

        $this->redirect()
            ->to(['action' => 'index']);
    }
}
