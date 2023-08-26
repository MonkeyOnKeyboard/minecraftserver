<?php

namespace Modules\Minecraftserver\Boxes;

use Modules\Minecraftserver\Mappers\Server as MinecraftserverMapper;

class Minecraftserver extends \Ilch\Box
{
    public function render()
    {
        $mapper = new MinecraftserverMapper();

        $this->getView()->set('minecraftserver', $mapper->getMincraftServer(['online' => 1]));
    }
}
