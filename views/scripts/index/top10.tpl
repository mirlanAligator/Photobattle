<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Mirlan
 * Date: 01.11.15
 * Time: 22:35
 * To change this template use File | Settings | File Templates.
 */
$userScore = array();
$i = 0;
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
        <?php foreach ($this->genders as $gender) {
        echo $this->htmlLink(array('action' => 'gender', 'g' => $gender->option_id, 'a' => 'top10'), $this->translate($gender->label), array('class' => $this->gender == $gender->option_id
            ? 'active' : "no-active"));
    } ?>
    </div>


    <div id="top10-users">
        <?php if (count($this->topUsers)) { ?>
        <?php foreach ($this->topUsers as $user) { $i++ ?>
            <div id="top10-user">
                <div class="top10-user-photo">
                    <!--                        --><?php //echo $this->htmlLink($user->getHref(), $this->itemPhoto($user, 'thumb.profile')); ?>
                    <a href="<?php echo $user->getHref(); ?>">
                        <div class="photo" style="background-image: url(<?php echo $user->getPhotoUrl(); ?>)">
                        </div>
                    </a>
                </div>
                <div class="user-data">
                    <div class="percent"><?php echo round($user->percent_f , 2, PHP_ROUND_HALF_EVEN) . "%"; ?></div>
                    <div class="place"><?php echo "$i." . $this->translate("Place"); ?></div>
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