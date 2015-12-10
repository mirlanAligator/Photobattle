<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Mirlan
 * Date: 01.11.15
 * Time: 22:35
 * To change this template use File | Settings | File Templates.
 */
$userScore = array();
?>

<div class="top-leader-widget-content">
    <div class="headline">
        <h2>
            <?php echo $this->translate('Top Leaders') . " " . $this->translate($this->genderLabel); ?>
        </h2>
    </div>
    <div id="top-users">
        <?php if (!empty($this->topUsers)) { ?>
        <?php foreach ($this->topUsers as $user) { ?>
            <div id="top-user">
                <div class="top-user-photo">
                    <?php
                    if ($this->viewer->getIdentity() && $this->viewer->approved) {
                        echo $this->htmlLink($user->getHref(), $this->itemPhoto($user, 'thumb.icon'));
                    } else {
                        echo $this->itemPhoto($user, 'thumb.icon');
                    }
                    ?>
                </div>
                <div class="user-data">
                    <div class="percent"><?php echo round($user->percent_f , 2, PHP_ROUND_HALF_EVEN) . "%"; ?></div>
                    <!--                    <div class="title">-->
                        <?php //echo $this->htmlLink($user->getHref(), $user->displayname); ?><!--</div>-->
                    <!--                    --><?php //$userScore = $this->scoreTable->getUserScoreData($user->user_id) ?>
                    <!--                    <div class="score">--><?php //echo $this->translate('Score'); ?>
                    <!--                        : --><?php //echo $userScore['scores']; ?><!--</div>-->
                    <!--                    <div class="won">--><?php //echo $this->translate('Won'); ?><!--: -->
                        <?php //echo $userScore['win']; ?><!--</div>-->
                    <!--                    <div class="lost">--><?php //echo $this->translate('Lost'); ?><!--: -->
                        <?php //echo $userScore['loss']; ?><!--</div>-->
                </div>
            </div>
            <?php } ?>
        <?php } ?>
    </div>
</div>