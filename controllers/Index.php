<?php

namespace Modules\Minecraftserver\Controllers;

use \Modules\Minecraftserver\Mappers\Server as ServerMapper;
use \Modules\Minecraftserver\Models\Server as ServerModel;

class Index extends \Ilch\Controller\Frontend
{
    public function indexAction()
    {
        $mapper = new ServerMapper();
        $servers = $mapper->getMincraftServer(($this->getConfig()->get('minecraftserver_showOffline') ? [] : ['online' => 1]));

        $this->getLayout()->getHmenu()
            ->add($this->getTranslator()->trans('menuServer'), ['action' => 'index']);

        if ($this->getConfig()->get('minecraftserver_requestEveryPageCall') == 1) {
            $this->updateServer();
        }

        $this->getView()->set('server', $servers);
    }

    public function showAction()
    {
        $mapper = new ServerMapper();

        $servers = $mapper->readById($this->getRequest()->getParam('id'));
        if (!$servers) {
            $this->redirect()
                    ->to(['action' => 'index']);
        }

        $this->getLayout()->getHmenu()
            ->add($this->getTranslator()->trans('menuServer'), ['action' => 'index'])
            ->add($servers->getMinecraftserver(), ['id' => $this->getRequest()->getParam('id')]);

        if ($this->getConfig()->get('minecraftserver_requestEveryPageCall') == 1) {
            $this->updateServer();
        }

        $this->getView()->set('server', $servers);
        
    }

    public function updateAction()
    {
        
        $this->updateServer();

    }

    public function updateServer()
    {
        $mapper = new ServerMapper();
        return $mapper->updateDataServer();
    }
}
