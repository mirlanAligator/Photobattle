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

<div class="top-10-content">
<!--    HEAD LINE-->
    <div class="headline top-10-description">
        <h2>
            <?php echo $this->translate('Top 10');?>
        </h2>
    </div>

    <!--    Check view Permision-->
    <?php if ($this->permission) { ?>

    <!-- Select gender-->
    <div class="select-gender">
        <?php echo $this->htmlLink(array('action' => 'gender', 'g' => 3, 'a' => 'top10'), $this->translate("Female"), array('class' => $this->gender == 3
        ? 'active' : "no-active")); ?>
        <?php echo $this->htmlLink(array('action' => 'gender', 'g' => 2, 'a' => 'top10'), $this->translate("Male"), array('class' => $this->gender == 2
        ? 'active' : "no-active")); ?>
    </div>


    <div id="top-users">
        <?php if (!empty($this->topUsers)) { ?>
        <?php foreach ($this->topUsers as $user) { ?>
            <div id="top-user">
                <div class="top-user-photo">
                    <?php echo $this->htmlLink($user->getHref(), $this->itemPhoto($user, 'thumb.profile')); ?>
                </div>
                <div class="user-data">
                    <div class="percent"><?php echo $user->percent_f . "%"; ?></div>
                </div>
            </div>
            <?php } ?>
        <?php } else { ?>
        <div class="tip photobattle">
            <span><?php echo $this->translate('Members not'); ?></span>
        </div>
        <?php } ?>
    </div>
    <?php } else { ?>
    <div class="tip photobattle">
        <span><?php echo $this->translate('You do not have permission to view this page.'); ?></span>
    </div>
    <?php }?>
</div>