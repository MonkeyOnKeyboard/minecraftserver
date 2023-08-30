<?php

/** @var \Ilch\View $this */

/** @var \Modules\Minecraftserver\Models\Server $server */
$server = $this->get('server');
?>
<form method="POST" class="form-horizontal" action="">
    <?=$this->getTokenField() ?>
    <div class="form-group <?=$this->validation()->hasError('inputServer') ? 'has-error' : '' ?>">
        <label for="inputServer" class="col-lg-2 control-label">
            <?=$this->getTrans('serverAdress') ?>
        </label>
        <div class="col-lg-2">
            <input class="form-control"
                   type="text"
                   name="inputServer"
                   id="inputServer"
                   placeholder="<?=$this->getTrans('serveradress') ?>"
                   value="<?=$this->escape($this->originalInput('inputServer', $server->getMinecraftserver())) ?>" />

        </div>
    </div>
    <div class="form-group <?=$this->validation()->hasError('inputPort') ? 'has-error' : '' ?>">
        <label for="inputPort" class="col-lg-2 control-label">
            <?=$this->getTrans('port') ?>
        </label>
        <div class="col-lg-2">
            <input class="form-control"
                   type="text"
                   name="inputPort"
                   id="inputPort"
                   placeholder="<?=$this->getTrans('query_port') ?>"
                   value="<?=$this->escape($this->originalInput('inputPort', $server->getPort())) ?>" />

        </div>
    </div>
    <div class="form-group <?=$this->validation()->hasError('inputTimeout') ? 'has-error' : '' ?>">
        <label for="inputTimeout" class="col-lg-2 control-label">
            <?=$this->getTrans('timeout') ?>
        </label>
        <div class="col-lg-2">
            <input class="form-control"
                   type="text"
                   name="inputTimeout"
                   id="inputTimeout"
                   placeholder="<?=$this->getTrans('pingtimeout') ?>"
                   value="<?=$this->escape($this->originalInput('inputTimeout', $server->getTimeout())) ?>" />

        </div>
    </div>

    <?=($server->getId()) ? $this->getSaveBar('edit') : $this->getSaveBar('add') ?>
</form>
