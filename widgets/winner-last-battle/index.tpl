<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Mirlan
 * Date: 01.11.15
 * Time: 22:35
 * To change this template use File | Settings | File Templates.
 */
?>
<div class="winner-last-battle-widget-content">
    <div class="headline-battle">
        <h3>
            <?php echo $this->translate('Winner Last Battle'); ?>
        </h3>
    </div>
    <?php if (!empty($this->winUserId)) { ?>
    <div class="winner">
        <div class="win-user-photo"
             style="background-image: url(<?php echo $this->user->getPhotoUrl('thumb.profile') ?>)">
        </div>
        <div class="player-data">
            <div class="percent"><?php echo $this->userScore['percent'] . "%"; ?></div>
<!--            <div class="title">--><?php //echo $this->user; ?><!--</div>-->
<!--            <div class="score">--><?php //echo $this->translate('Score'); ?><!--: --><?php //echo $this->userScore['scores']; ?><!--</div>-->
<!--            <div class="won">--><?php //echo $this->translate('Won'); ?><!--: --><?php //echo $this->userScore['win']; ?><!--</div>-->
<!--            <div class="lost">--><?php //echo $this->translate('Lost'); ?><!--: --><?php //echo $this->userScore['loss']; ?><!--</div>-->
        </div>
    </div>
    <?php } else { ?>
    <div class="tip photobattle">
            <span>
                <?php echo $this->translate("You didn't vote yet"); ?>
            </span>
    </div>
    <?php } ?>
</div>