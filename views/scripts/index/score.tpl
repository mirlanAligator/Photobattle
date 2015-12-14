<div class="my-score-page-content">
  <!--    Check view Permision-->
  <?php if ($this->permission) { ?>
    <?php if ($this->permissionOtherMyScores) { ?>
    <?php if ($this->viewer->photo_id != 0) { ?>

      <div class="photobattle-my-scores-mobile">
        <div class="my-scores">
            <div class="my-photo">
              <?php echo $this->itemPhoto($this->user, 'thumb.profile') ?>
            </div>
            <div class="my-data">
              <div class="title"><?php echo $this->htmlLink($this->user->getHref(), $this->user->displayname); ?></div>
              <div class="percent"><?php echo $this->userScore['percent'] . "%"; ?></div>
              <div class="win"><?php echo $this->translate('Wins') . " : " . $this->userScore['win']; ?></div>
              <div class="loss"><?php echo $this->translate('Losses') . " : " . $this->userScore['loss']; ?></div>
              <div class="place"><?php echo $this->translate('Place') . " : " . $this->userPlace; ?></div>
            </div>
        </div>
      </div>

      <?php if ($this->viewer->getIdentity() == $this->user->getIdentity()) { ?>
        <div class="headline">
          <h2>
            <?php echo $this->translate('My Battles'); ?>
          </h2>
        </div>
      <?php } else { ?>
        <div class="headline">
          <h2>
            <?php echo $this->translate('Battles'); ?>
          </h2>
        </div>
      <?php } ?>

      <?php if (count($this->paginator)) { ?>
        <div class="my-scores">
          <div class="heading-score">
            <div class="winner"><?php echo $this->translate('Winner'); ?></div>
            <div class="loser"><?php echo $this->translate('Loser'); ?></div>
            <div class="voter"><?php echo $this->translate('Voter'); ?></div>
          </div>

          <div class="body-score">

            <?php foreach ($this->paginator as $battle) { ?>
              <div class="winner-user score-user">
                <div class="user-photo">
                  <?php echo $this->itemPhoto($battle->getWinnerUser(), 'thumb.icon'); ?>
                </div>
                <div class="user-name">
                  <?php echo $this->user->getIdentity() != $battle->getWinnerUser()->getIdentity() && $this->permissionOtherMyScores ?
                    $this->htmlLink(array('action' => 'score', 'user' => $battle->getWinnerUser()->getIdentity()),
                      $battle->getWinnerUser()->getTitle())
                    : $battle->getWinnerUser()->getTitle();
                  ?>
                </div>
              </div>

              <div class="loser-user score-user">
                <div class="user-photo">
                  <?php echo $this->itemPhoto($battle->getLoserUser(), 'thumb.icon'); ?>
                </div>
                <div class="user-name">
                  <?php echo $this->user->getIdentity() != $battle->getLoserUser()->getIdentity() && $this->permissionOtherMyScores ?
                    $this->htmlLink(array('action' => 'score', 'user' => $battle->getLoserUser()->getIdentity()),
                      $battle->getLoserUser()->getTitle()) : $battle->getLoserUser()->getTitle();
                  ?>
                </div>
              </div>

              <div class="voter-user score-user">
                <div class="user-photo">
                  <?php echo $this->itemPhoto($battle->getVoterUser(), 'thumb.icon'); ?>
                </div>
                <div class="user-name">
                  <?php echo ($this->user->getIdentity() != $battle->getVoterUser()->getIdentity() &&
                    $battle->getVoterUser()->photo_id != 0) && $this->permissionOtherMyScores ?
                    $this->htmlLink(array('action' => 'score', 'user' => $battle->getVoterUser()->getIdentity()),
                      $battle->getVoterUser()->getTitle())
                    : $battle->getVoterUser()->getTitle();
                  ?>
                </div>
              </div>

            <?php } ?>
          </div>
          <br/>
          <br/>
          <?php echo $this->paginationControl($this->paginator); ?>
        </div>
      <?php } else { ?>

        <?php if ($this->viewer->getIdentity() == $this->user->getIdentity()) { ?>
        <div class="tip photobattle">
            <span>
                <?php echo $this->translate("You didn't participate in one battle yet."); ?>
            </span>
        </div>
        <?php } else {?>
          <div class="tip photobattle">
            <span>
          <?php echo $this->translate("This user has not participated in a battle yet."); ?>
            </span>
          </div>
        <?php } ?>

      <?php } ?>

      <!--    Photo Id = 0-->
    <?php } else { ?>
      <div class="headline">
        <h2>
          <?php echo $this->translate("My Scores"); ?>
        </h2>
      </div>
      <div class="tip photobattle">
        <span>
            <?php echo $this->translate("NO_PHOTO"); ?>
        </span>
      </div>
    <?php } ?>

        <!--     else permissionOtherMyScores = 0-->
      <?php } else { ?>
        <div class="headline">
          <h2>
            <?php echo $this->translate("My Scores"); ?>
          </h2>
        </div>
        <div class="tip photobattle">
            <span>
                <?php echo $this->translate("You do not have permission to view battles."); ?>
            </span>
        </div>
      <?php } ?>

    <!--     else permission = 0-->
  <?php } else { ?>
    <div class="headline">
      <h2>
        <?php echo $this->translate("My Scores"); ?>
      </h2>
    </div>
    <div class="tip photobattle">
        <span>
            <?php echo $this->translate("You do not have a permission to view this page."); ?>
        </span>
    </div>
  <?php } ?>
</div>
