<div>
    <div class="headline">
        <h2>
            <?php echo $this->translate('My Battles'); ?>
        </h2>
    </div>
    <div class="my-scores">
        <?php if ($this->viewer->photo_id) { ?>
        <?php if (count($this->paginator)) { ?>
            <table class='admin_table'>
                <thead>
                <tr>

                    <th><?php echo $this->translate("Voter") ?></th>
                    <th><?php echo $this->translate("Player - 1") ?></th>
                    <th><?php echo $this->translate("Player - 2") ?></th>
                    <th><?php echo $this->translate("Win Player") ?></th>
                    <th><?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'photobattle', 'controller' => 'index',
                            'action' => 'index', 'page' => $this->page, 'order' => $this->orderSort)
                        , $this->translate("Date")); ?></th>

                </tr>
                </thead>
                <tbody>

                    <?php foreach ($this->paginator as $item) { ?>
                <tr>

                    <td><?php echo $item->getVoterUserName(); ?></td>
                    <td><?php echo $item->getPlayer1UserName(); ?></td>
                    <td><?php echo $item->getPlayer2UserName(); ?></td>
                    <td><?php echo $item->getWinnerUserName(); ?></td>
                    <td><?php echo $this->locale()->toDateTime($item->battle_date) ?></td>

                </tr>
                    <?php } ?>
                </tbody>
            </table>

            <br/>
            <br/>

            <div>
                <?php echo $this->paginationControl($this->paginator); ?>
            </div>

            <?php } else { ?>
            <div class="tip">
                <span>
                  <?php echo $this->translate("There are no battle entries by your members yet.") ?>
                </span>
            </div>
            <?php } ?>

        <?php } else { ?>
        <div class="tip photobattle">
            <span>
                <?php echo $this->translate('NO_PHOTO'); ?>
            </span>
        </div>
        <?php } ?>
    </div>

</div>
