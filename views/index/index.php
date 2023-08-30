<?php

/** @var \Ilch\View $this */

/** @var \Modules\Minecraftserver\Models\Server[]|null $servers */
$servers = $this->get('server');
?>
<link href="<?=$this->getModuleUrl('static/css/servers.css') ?>" rel="stylesheet">

<div id="server">
<?php if ($servers) : ?>
    <?php foreach ($servers as $server) : ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <a href="<?=$this->getUrl(['module' => 'minecraftserver', 'controller' => 'index', 'action' => 'show', 'id' => $server->getId()]) ?>">
                <?php if ($server->getOnline()) : ?>
                    <?=$server->getHostname() ?>
                <?php else : ?>
                    <?=$server->getMinecraftserver() ?>
                <?php endif; ?>
            </a>
        </div>
        <div class="panel-body">
            <div  id="show-info">
                <div class="col-md-12 col-lg-4">
                    <a href="<?=$this->getUrl(['module' => 'minecraftserver', 'controller' => 'index', 'action' => 'show', 'id' => $server->getId()]) ?>">
                    <?php if ($server->getOnline()) : ?>
                        <img src="<?=$this->getUrl(['module' => 'minecraftserver', 'controller' => 'index', 'action' => 'img', 'id' => $server->getId()]) ?>" title="<?=$server->getHostname() . ' ' . $this->getTrans('playing') . ' ' . $server->getGameId() ?>"  alt="<?=$server->getHostname() . ' ' . $this->getTrans('playing') . ' ' . $server->getGameId() ?>">
                    <?php else : ?>
                        <span class="badge"><?=$this->getTrans('offline') ?></span>
                    <?php endif; ?>
                    </a>
                </div>
                <div class="col-md-12 col-lg-8">
                    <ul class="list-group">
                        <li class="list-group-item">
                            <?=$this->getTrans('server') ?>
                            <span class="badge">
                                <a href="<?=$this->getUrl(['module' => 'minecraftserver', 'controller' => 'index', 'action' => 'show', 'id' => $server->getId()]) ?>">
                                    <?=$server->getHostname() ?>
                                </a>
                            </span>
                        </li>
                        <li class="list-group-item">
                            <?=$this->getTrans('serverAdress') ?>
                            <span class="badge"><?= $server->getMinecraftserver() . ":" . $server->getHostport()?></span>
                        </li>
                        <li class="list-group-item">
                            <?=$this->getTrans('game') ?>
                            <span class="badge"><?=$server->getGameId() ?> - <?=$server->getGametype() ?></span>
                        </li>
                        <li class="list-group-item">
                            <?=$this->getTrans('players') ?>
                            <?php if ($server->getOnline() == 1) : ?>
                                <span class="badge"><?=number_format($server->getNumplayers(), 0, '', '.') . " " . $this->getTrans('of') . " " . number_format($server->getMaxplayers(), 0, '', '.') ?></span>
                            <?php else : ?>
                                <span class="badge"> / </span>
                            <?php endif; ?>
                        </li>
                        <li class="list-group-item">
                            <?=$this->getTrans('onlineIs') ?>
                            <?php if ($server->getOnline()) : ?>
                            <span class="badge"><?=$this->getTrans('online') ?></span>
                            <?php else : ?>
                            <span class="badge"><?=$this->getTrans('offline') ?></span>
                            <?php endif; ?>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
<?php else : ?>
    <?=$this->getTrans('noServer') ?>
<?php endif; ?>
</div>
