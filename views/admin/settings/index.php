<form method="POST" class="form-horizontal" action="">
<div class="alert alert-info">
        <?= $this->getTrans('edit_serverproperties') ?>
    </div>
    <?=$this->getTokenField() ?>
    <div class="form-group <?=$this->validation()->hasError('requestEveryPage') ? 'has-error' : '' ?>">
        <label for="requestEveryPage" class="col-lg-2 control-label">
            <?=$this->getTrans('requestEveryPage') ?>
        </label>
        <div class="col-lg-2">
            <div class="flipswitch">
                <input type="radio" class="flipswitch-input" name="requestEveryPage" value="1" id="requestEveryPage-on" <?=($this->originalInput('requestEveryPage', $this->get('requestEveryPage'))) ? 'checked="checked"' : ''?> />
                <label for="requestEveryPage-on" class="flipswitch-label flipswitch-label-on"><?=$this->getTrans('on') ?></label>
                <input type="radio" class="flipswitch-input" name="requestEveryPage" value="0" id="requestEveryPage-off" <?=(!$this->originalInput('requestEveryPage', $this->get('requestEveryPage'))) ? 'checked="checked"' : ''?> />
                <label for="requestEveryPage-off" class="flipswitch-label flipswitch-label-off"><?=$this->getTrans('off') ?></label>
                <span class="flipswitch-selection"></span>
            </div>
        </div>
    </div>
    <div class="form-group <?=$this->validation()->hasError('showOffline') ? 'has-error' : '' ?>">
        <label for="showOffline" class="col-lg-2 control-label">
            <?=$this->getTrans('showOffline') ?>
        </label>
        <div class="col-lg-2">
            <div class="flipswitch">
                <input type="radio" class="flipswitch-input" name="showOffline" value="1" id="showOffline-on" <?=($this->originalInput('showOffline', $this->get('showOffline'))) ? 'checked="checked"' : ''?> />
                <label for="showOffline-on" class="flipswitch-label flipswitch-label-on"><?=$this->getTrans('on') ?></label>
                <input type="radio" class="flipswitch-input" name="showOffline" value="0" id="showOffline-off" <?=!($this->originalInput('showOffline', $this->get('showOffline'))) ? 'checked="checked"' : ''?> />
                <label for="showOffline-off" class="flipswitch-label flipswitch-label-off"><?=$this->getTrans('off') ?></label>
                <span class="flipswitch-selection"></span>
            </div>
        </div>
    </div>
    
    <?=$this->getSaveBar(); ?>
</form>
