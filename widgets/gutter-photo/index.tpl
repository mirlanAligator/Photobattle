<div>
    <div class="my-scores">
        <?php if ($this->user->photo_id) { ?>
        <div class="my-photo">
            <?php echo $this->itemPhoto($this->user, 'thumb.profile') ?>
        </div>
        <div class="my-data">
            <div class="title"><?php echo $this->htmlLink($this->user->getHref(), $this->user->displayname); ?></div>
            <div class="percent"><?php echo $this->userScore['percent'] . "%"; ?></div>
            <div class="win"><?php echo $this->translate('Wins') . " : " . $this->userScore['win']; ?></div>
            <div class="loss"><?php echo $this->translate('Losses') . " : " . $this->userScore['loss']; ?></div>
            <div class="place"><?php echo $this->translate('Place') . " : " . $this->userPlace; ?></div>
        </div>
        <?php } else { ?>
        <div class="tip photobattle">
            <span>
                <?php echo $this->translate('NO_PHOTO'); ?>
            </span>
        </div>
        <?php } ?>
    </div>
</div>

