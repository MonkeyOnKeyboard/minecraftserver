<?php

namespace Modules\Minecraftserver\Controllers\Admin;

use Ilch\Validation;

class Settings extends \Ilch\Controller\Admin
{
    public function init()
    {
        $items = [
            [
                'name' => 'menuServer',
                'active' => false,
                'icon' => 'fas fa-th-list',
                'url' => $this->getLayout()->getUrl(['controller' => 'index', 'action' => 'index'])
            ],
            [
                'name' => 'settings',
                'active' => true,
                'icon' => 'fas fa-cogs',
                'url' => $this->getLayout()->getUrl(['controller' => 'settings', 'action' => 'index'])
            ]
        ];

        $this->getLayout()->addMenu
        (
            'minecraftserver',
            $items
        );
    }

    public function indexAction()
    {
        $this->getLayout()->getAdminHmenu()
            ->add($this->getTranslator()->trans('minecraftserver'), ['controller' => 'index', 'action' => 'index'])
            ->add($this->getTranslator()->trans('settings'), ['action' => 'index']);

        if ($this->getRequest()->isPost()) {
            $validation = Validation::create($this->getRequest()->getPost(), [
                    'requestEveryPage' => 'required|numeric|min:0|max:1',
                    'showOffline' => 'required|numeric|min:0|max:1',
                ]);
            if ($validation->isValid()) {
                                
                $this->getConfig()->set('minecraftserver_requestEveryPageCall', $this->getRequest()->getPost('requestEveryPage'))
                    ->set('minecraftserver_showOffline', $this->getRequest()->getPost('showOffline'));

                $this->redirect()
                    ->withMessage('saveSuccess')
                    ->to(['action' => 'index']);
            }

            $this->addMessage($validation->getErrorBag()->getErrorMessages(), 'danger', true);
            $this->redirect()
                ->withInput()
                ->withErrors($validation->getErrorBag())
                ->to(['action' => 'index']);
        }

        $this->getView()->set('requestEveryPage', $this->getConfig()->get('minecraftserver_requestEveryPageCall'))
            ->set('showOffline', (string)$this->getConfig()->get('minecraftserver_showOffline'));
    }
}
