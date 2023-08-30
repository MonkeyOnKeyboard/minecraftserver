<?php

/** @var \Ilch\View $this */

/** @var \Modules\Minecraftserver\Models\Server $server */
$server = $this->get('server');
?>
<link href="<?=$this->getModuleUrl('static/css/servers.css') ?>" rel="stylesheet">

<div id="server">
    <div class="panel panel-default">
        <div class="panel-heading">
            <?=$server->getHostname() ?>
        </div>
        <div class="panel-body">
            <div class="col-md-12 col-lg-4">
            <?php if ($server->getOnline()) : ?>
                <img src="<?=$this->getUrl(['module' => 'minecraftserver', 'controller' => 'index', 'action' => 'img', 'id' => $server->getId()]) ?>" title="<?=$server->getHostname() . ' ' . $this->getTrans('playing') . ' ' . $server->getGameId() ?>"  alt="<?=$server->getHostname() . ' ' . $this->getTrans('playing') . ' ' . $server->getGameId() ?>">
            <?php else : ?>
                <span class="badge"><?=$this->getTrans('offline') ?></span>
            <?php endif; ?>
            </div>

            <div class="col-md-12 col-lg-8">
                <ul class="list-group">
                    <li class="list-group-item">
                        <?=$this->getTrans('server') ?>
                        <span class="badge">
                            <?=$server->getMinecraftserver() . ":" . $server->getHostport()?>
                        </span>
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
                    <li class="list-group-item">
                        <?=$this->getTrans('plugins') ?>
                    <?php
                    $pluginData = unserialize($server->getPlugins());
                    if (!empty($pluginData)) {
                        echo "<span class=\"badge\">" . htmlspecialchars($pluginData) . "</span>";
                    } else {
                        echo "<span class=\"badge\">" . $this->getTrans('noPlugins') . "</span>";
                    }
                    ?>
                    </li>
                </ul>
            </div>

            <div class="clearfix"></div>
        </div>

        <div class="panel-footer clearfix">
            <div class="pull-left">
                <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#multiCollapseExample1" aria-expanded="false" aria-controls="multiCollapseExample1">
                <?=$this->getTrans('showPlayers') ?>
                </button>
                <div class="col">
                    <div class="collapse multi-collapse" id="multiCollapseExample1">
                        <div class="card card-body">

                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                    <th><?=$this->getTrans('Players')?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php $Players = unserialize($server->getPlayers());?>
                                <?php if (!$Players) : ?>
                                    <tr>
                                        <td><?=$this->getTrans('noOnlineplayers')?></td>
                                    </tr>
                                <?php else : ?>
                                    <?php foreach ($Players as $Player) : ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($Player); ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pull-right">
                <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#multiCollapseExample2" aria-expanded="false" aria-controls="multiCollapseExample2">
                    <?=$this->getTrans('showServer') ?>
                </button>
                <div class="col">
                    <div class="collapse multi-collapse" id="multiCollapseExample2">
                        <div class="card card-body">
                            <div class="row">
                                <table class="table table-bordered table-striped">
                                <?php
                                $Info = unserialize($server->getServerpinginfo());
                                ?>
                                <?php if (!empty($Info)) : ?>
                                    <?php foreach ($Info as $InfoKey => $InfoValue) : ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($InfoKey); ?></td>
                                        <td><?php
                                        if ($InfoKey === 'favicon') {
                                            echo '<img width="64" height="64" src="' . Str_Replace("\n", "", $InfoValue) . '">';
                                        } elseif (Is_Array($InfoValue)) {
                                            echo "<pre>";
                                            print_r($InfoValue);
                                            echo "</pre>";
                                        } else {
                                            echo htmlspecialchars($InfoValue);
                                        }
                                        ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="2" style="text-align: center;"><?=$this->getTrans('noServerPingInfo') ?></td>
                                    </tr>
                                <?php endif; ?>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


