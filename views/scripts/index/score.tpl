<div>
    <div class="headline">
        <h2>
            <?php echo $this->translate('My Scores'); ?>
        </h2>
    </div>
    <div class="my-scores">
        <?php if ($this->viewer->photo_id) { ?>
        <div class="my-photo">
            <?php echo $this->itemPhoto($this->viewer, 'thumb.profile') ?>
        </div>
        <div class="my-data">
            <div
                class="title"><?php echo $this->htmlLink($this->viewer->getHref(), $this->viewer->displayname); ?></div>
            <div class="percent"><?php echo $this->viewerScore['percent'] . "%"; ?></div>
            <!--        <div class="score">--><?php //echo $this->translate('Score'); ?>
            <!--          : --><?php //echo $this->viewerScore['scores']; ?><!--</div>-->
            <!--        <div class="won">--><?php //echo $this->translate('Won'); ?><!--: -->
                <?php //echo $this->viewerScore['win']; ?><!--</div>-->
            <!--        <div class="lost">--><?php //echo $this->translate('Lost'); ?><!--: -->
                <?php //echo $this->viewerScore['loss']; ?><!--</div>-->
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
</div>
