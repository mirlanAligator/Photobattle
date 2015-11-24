<div class="next-battle-widget-content">
    <div class="headline-battle">
        <h3>
            <?php echo $this->translate('Next Battle'); ?>
        </h3>
    </div>

    <?php if (!$this->noPlayers) { ?>

    <!---------------    Player1 ------->
    <div id="player1" class="player">
        <div class="user-photo-widget">
            <div class="photo-widget"
                 style="background-image: url(<?php echo $this->user1->getPhotoUrl() ?>)">
            </div>
        </div>

        <div class="player-data">
            <div class="percent"><?php echo $this->user1Score['percent'] . "%"; ?></div>
        </div>
    </div>
    <!--        --------------------------------->

    <!---------------    Player2 ------->
    <div id="player2" class="player">
        <div class="user-photo-widget">
            <div class="photo-widget"
                 style="background-image: url(<?php echo $this->user2->getPhotoUrl() ?>)">
            </div>
        </div>
        <div class="player-data">
            <div class="percent"><?php echo $this->user2Score['percent'] . "%"; ?></div>
        </div>
    </div>
    <!-------------------------------------->
    <?php } else { ?>
    <div class="tip photobattle">
            <span>
                <?php echo $this->translate('NO_PLAYERS'); ?>
            </span>
    </div>
    <?php } ?>
</div>
