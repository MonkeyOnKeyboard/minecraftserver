<?php

/** @var \Ilch\View $this */

/** @var \Modules\Minecraftserver\Models\Server[]|null $servers */
$servers = $this->get('server');
?>
<form class="form-horizontal" method="POST" action="">
    <?=$this->getTokenField() ?>
    <div class="table-responsive">
        <table class="table table-hover table-striped">
        <colgroup>
            <col class="icon_width" />
            <col class="icon_width" />
            <col class="icon_width" />
            <col />
            <col class="col-lg-1" />
            <col class="col-lg-3" />
            <col class="col-lg-1" />
        </colgroup>
        <tr>
            <th><?=$this->getCheckAllCheckbox('check_server') ?></th>
            <th>
                <a href="<?=$this->getUrl(['module' => 'minecraftserver', 'controller' => 'index', 'action' => 'update']) ?>" alt="<?=$this->getTrans('updateServers') ?>" title="<?=$this->getTrans('updateServers') ?>">
                    <i class="fas fa-sync"></i>
                </a>
            </th>
            <th></th>
            <th><?=$this->getTrans('server') ?></th>
            <th><?=$this->getTrans('online') ?></th>
            <th><?=$this->getTrans('hostname') ?></th>
            <th><?=$this->getTrans('onlineplayers') ?></th>
        </tr>
    <?php if ($servers) : ?>
        <?php foreach ($servers as $server) : ?>
            <tr>
            <input type="hidden" name="items[]" value="<?=$server->getId() ?>" />
            <td><?=$this->getDeleteCheckbox('check_streamer', $server->getId()) ?></td>
            <td><?=$this->getEditIcon(['action' => 'treat', 'id' => $server->getId()]); ?></td>
            <td><?=$this->getDeleteIcon(['action' => 'delete', 'id' => $server->getId()]) ?></td>
            <td><?=$server->getMinecraftserver() ?></td>
            <td>
                <?php if ($server->getOnline()) : ?>
                    <?=$this->getTrans('yes') ?>
                <?php else : ?>
                    <?=$this->getTrans('no') ?>
                <?php endif; ?>
            </td>
            <td><?=$server->getHostname() ?></td>
                <?php if ($server->getOnline()) : ?>
            <td><?=number_format($server->getNumplayers(), 0, '', '.') ?></td>
                <?php else : ?>
            <td> / </td>
                <?php endif; ?>
            </tr>
        <?php endforeach; ?>
    <?php else : ?>
            <tr>
                <td colspan="7"><?=$this->getTrans('noServer') ?></td>
            </tr>
    <?php endif; ?>
        </table>
    </div>
    <div class="content_savebox">
        <input type="hidden" class="content_savebox_hidden" name="action" value="" />
        <div class="btn-group dropup">
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                <?=$this->getTrans('selected') ?> <span class="caret"></span>
            </button>
            <ul class="dropdown-menu listChooser" role="menu">
                <li><a href="#" data-hiddenkey="delete"><?=$this->getTrans('delete') ?></a></li>
            </ul>
        </div>
    </div>
</form>
