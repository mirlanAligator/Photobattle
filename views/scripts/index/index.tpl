<?php
$onClick = $this->votePermission ? 'onclick="Photobattle.votePhoto(this)"' : '';
$cursorStyle = $this->votePermission ? 'cursor: pointer"' : '';
?>
<?php if ($this->viewer->getIdentity()) { ?>
<?php if (!$this->noPermission) { ?>
    <!-- Select gender-->
    <div class="select-gender">
        <?php foreach ($this->genders as $gender) {
        echo $this->htmlLink(array('action' => 'gender', 'g' => $gender->option_id, 'a' => 'index'), $this->translate($gender->label), array('class' => $this->gender == $gender->option_id
            ? 'active' : "no-active"));
    } ?>
    </div>

    <!--   Description  --------    -->
    <div class="battle-desciption headline-battle">
        <h3>
            <?php echo $this->translate("BATTLE_DESCRIPTION"); ?>
        </h3>
    </div>

    <!--        Vote Permission -->
    <?php if (!$this->votePermission) { ?>
        <div class="tip photobattle">
                    <span>
                        <?php echo $this->translate("You have no permission to vote!"); ?>
                    </span>
        </div>
        <?php } ?>
    <!--            -------------------->

    <div class="battle-players">

        <!--        Loader-->
        <div class="battle-loader" style="background-image:
        url(./application/modules/Photobattle/externals/images/loading.gif); display: none"></div>
        <?php if (!$this->noPlayers) { ?>

        <!---------------    Player1 ------->
        <div id="player1" class="player">
            <div class="user-photo">
                <div class="photo" <?php echo $onClick; ?> won="<?php echo $this->user1->user_id ?>"
                     loss="<?php echo $this->user2->user_id; ?>" wonplayer="1" <?php echo $cursorStyle; ?>
                     style="background-image: url(<?php echo $this->user1->getPhotoUrl() ?>);
                         <?php echo $cursorStyle; ?>">
                </div>
            </div>

            <div class="player-data">
                <div class="percent"><?php echo $this->user1Score['percent'] . "%"; ?></div>
                <!--                <div class="title">--><?php //echo $this->user1; ?><!--</div>-->
                <!--                <div class="score">--><?php //echo $this->translate('Score'); ?>
                <!--                    : --><?php //echo $this->user1Score['scores']; ?><!--</div>-->
                <!--                                <div class="won">--><?php //echo $this->translate('Won'); ?><!--:-->
                <!--                    --><?php //echo $this->user1Score['win']; ?><!--</div>-->
                <!--                                <div class="lost">--><?php //echo $this->translate('Lost'); ?>
                <!--                                    : --><?php //echo $this->user1Score['loss']; ?><!--</div>-->
            </div>

        </div>
        <!--        --------------------------------->

        <div id="player-or"><h2 class="h-or"><?php echo strtoupper($this->translate(' or ')); ?></h2></div>

        <!---------------    Player2 ------->
        <div id="player2" class="player">
            <div class="user-photo">
                <div class="photo" <?php echo $onClick; ?> loss="<?php echo $this->user1->user_id ?>"
                     won="<?php echo $this->user2->user_id; ?>" wonplayer="2" <?php echo $cursorStyle; ?>
                     style="background-image: url(<?php echo $this->user2->getPhotoUrl() ?>);
                         <?php echo $cursorStyle; ?>">
                    <!--                         --><?php //echo $this->itemPhoto($this->user2, null); ?>
                </div>
            </div>
            <div class="player-data">
                <div class="percent"><?php echo $this->user2Score['percent'] . "%"; ?></div>
                <!--                <div class="title">--><?php //echo $this->user2; ?><!--</div>-->
                <!--                <div class="score">--><?php //echo $this->translate('Score'); ?>
                <!--                    : --><?php //echo $this->user2Score['scores']; ?><!--</div>-->
                <!--                                <div class="won">--><?php //echo $this->translate('Won'); ?><!--:-->
                <!--                    --><?php //echo $this->user2Score['win']; ?><!--</div>-->
                <!--                                <div class="lost">--><?php //echo $this->translate('Lost'); ?>
                <!--                                    : --><?php //echo $this->user2Score['loss']; ?><!--</div>-->
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

    <?php } else { ?>
    <div class="tip photobattle">
                <span>
                    <?php echo $this->translate("You have no power for involvement in a photo battles"); ?>
                </span>
    </div>
    <?php } ?>

<?php } else { ?>
<div class="tip photobattle">
    <span><?php echo $this->translate('REGISTERED_AND_SIGNIN'); ?></span>
</div>
<?php } ?>