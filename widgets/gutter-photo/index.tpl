<div>
    <div class="my-scores">
        <?php if ($this->viewer->photo_id) { ?>
        <div class="my-photo">
            <?php echo $this->itemPhoto($this->viewer, 'thumb.normal') ?>
        </div>
        <div class="my-data">
            <div
                class="title"><?php echo $this->htmlLink($this->viewer->getHref(), $this->viewer->displayname); ?></div>
            <div class="percent"><?php echo $this->viewerScore['percent'] . "%"; ?></div>
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

