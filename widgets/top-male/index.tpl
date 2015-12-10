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

<div class="top10-male-widget-content">
    <div class="headline">
        <h2>
            <?php echo $this->translate('Top_10_Male_Description'); ?>
        </h2>
    </div>
    <div id="top-users">
        <?php if (!empty($this->topUsers)) { ?>
        <?php foreach ($this->topUsers as $user) { ?>
            <div id="top-user">
                <div class="top-user-photo">
                    <?php echo $this->htmlLink($user->getHref(), $this->itemPhoto($user, 'thumb.icon')); ?>
                </div>
                <div class="user-data">
                    <div class="percent"><?php echo $user->percent_f . "%"; ?></div>
                </div>
            </div>
            <?php } ?>
        <?php } ?>
    </div>
</div>