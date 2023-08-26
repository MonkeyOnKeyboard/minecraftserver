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
                   placeholder="<?=$this->getTrans('serveradress') ?>"
                   value="<?=$this->originalInput('inputServer', ($this->get('server') ? $this->escape($this->get('server')->getMinecraftserver()) : '')) ?>" />

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
                   placeholder="<?=$this->getTrans('query_port') ?>"
                   value="<?=$this->originalInput('inputPort', ($this->get('server') ? $this->escape($this->get('server')->getPort()) : '')) ?>" />

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
                   placeholder="<?=$this->getTrans('pingtimeout') ?>"
                   value="<?=$this->originalInput('inputTimeout', ($this->get('server') ? $this->escape($this->get('server')->getTimeout()) : '')) ?>" />

        </div>
    </div>

    <?=($this->get('server') != '') ? $this->getSaveBar('edit') : $this->getSaveBar('add') ?>
</form>
