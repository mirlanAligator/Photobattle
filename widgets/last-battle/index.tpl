<div class="last-battle-widget-content">
    <div class="headline-battle">
        <h3>
            <?php echo $this->translate('Last Battle'); ?>
        </h3>
    </div>
    <?php if (!empty($this->battle)) { ?>
    <!---------------    Player1 ------->
    <div id="player1" class="player">
        <div class="user-photo-widget">
            <div class="photo-widget"
                 style="background-image: url(<?php echo $this->player1->getPhotoUrl('thumb.profile') ?>);">
            </div>
        </div>

        <div class="player-data">
            <div class="percent"><?php echo $this->player1ScoreData['percent'] . "%"; ?></div>
        </div>
    </div>
    <!----------------------------------->

    <!---------------    Player2 ------->
    <div id="player2" class="player">
        <div class="user-photo-widget">
            <div class="photo-widget"
                 style="background-image: url(<?php echo $this->player2->getPhotoUrl('thumb.profile') ?>); ">
            </div>
        </div>
        <div class="player-data">
            <div class="percent"><?php echo $this->player2ScoreData['percent'] . "%"; ?></div>
        </div>
    </div>
    <!-------------------------------------->
    <?php } else { ?>
    <div class="tip photobattle">
            <span>
                <?php echo $this->translate("You didn't vote yet"); ?>
            </span>
    </div>
    <?php } ?>
</div>
