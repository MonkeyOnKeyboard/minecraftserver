<?php

/** @var \Ilch\View $this */

/** @var \Modules\Minecraftserver\Models\Server[]|null $minecraftserver */
$minecraftserver = $this->get('minecraftserver');
?>
<?php if ($minecraftserver) : ?>
  <ul class="list-unstyled">
    <?php foreach ($minecraftserver as $server) : ?>
      <li>
        <a href="<?=$this->getUrl(['module' => 'minecraftserver', 'controller' => 'index', 'action' => 'show', 'id' => $server->getId()]) ?>"><?=$server->getHostname() ?></a> <?=$this->getTrans('players') ?> <?=number_format($server->getNumplayers(), 0, '', '.') . " von " . number_format($server->getMaxplayers(), 0, '', '.') ?>
      </li>
    <?php endforeach; ?>
  </ul>
<?php else : ?>
    <?=$this->getTrans('noServer') ?>
<?php endif; ?>
