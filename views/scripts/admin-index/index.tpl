<h2>
    <?php echo $this->translate('Photo Battle Plugin') ?>
</h2>

<?php if (count($this->navigation)): ?>
<div class='tabs'>
    <?php
      // Render the menu
    //->setUlClass()
    echo $this->navigation()->menu()->setContainer($this->navigation)->render()
    ?>
</div>
<?php endif; ?>


<script type="text/javascript">

    function multiDelete() {
        return confirm("<?php echo $this->translate('Are you sure you want to delete the selected battles?'); ?>");
    }

    function selectAll() {
        var i;
        var multidelete_form = $('multidelete_form');
        var inputs = multidelete_form.elements;
        for (i = 1; i < inputs.length; i++) {
            if (!inputs[i].disabled) {
                inputs[i].checked = inputs[0].checked;
            }
        }
    }
</script>

<p>
    <?php echo $this->translate("PHOTOBATTLE_VIEWS_SCRIPTS_ADMINMANAGE_INDEX_DESCRIPTION") ?>
</p>

<br/>
<br/>

<?php if (count($this->paginator)) { ?>
<form id='multidelete_form' method="post" action="<?php echo $this->url();?>" onSubmit="return multiDelete()">
    <table class='admin_table'>
        <thead>
        <tr>
            <th class='admin_table_short'><input onclick='selectAll();' type='checkbox' class='checkbox'/></th>
            <th class='admin_table_short'>ID</th>
            <th><?php echo $this->translate("Voter") ?></th>
            <th><?php echo $this->translate("Player - 1") ?></th>
            <th><?php echo $this->translate("Player - 2") ?></th>
            <th><?php echo $this->translate("Winner") ?></th>
            <th><?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'photobattle', 'controller' => 'index',
                                                'action' => 'index', 'page' => $this->page, 'order' => $this->orderSort)
                , $this->translate("Date")); ?></th>
            <th><?php echo $this->translate("Options") ?></th>
        </tr>
        </thead>
        <tbody>
            <?php foreach ($this->paginator as $item): ?>
        <tr>
            <td><input type='checkbox' class='checkbox' name='delete_<?php echo $item->getIdentity(); ?>'
                       value="<?php echo $item->getIdentity(); ?>"/></td>
            <td><?php echo $item->getIdentity(); ?></td>
            <td><?php echo $item->getVoterUserName(); ?></td>
            <td><?php echo $item->getPlayer1UserName(); ?></td>
            <td><?php echo $item->getPlayer2UserName(); ?></td>
            <td><?php echo $item->getWinnerUserName(); ?></td>
            <td><?php echo $this->locale()->toDateTime($item->battle_date) ?></td>
            <td>
                <?php echo $this->htmlLink(
                array('route' => 'admin_default', 'module' => 'photobattle', 'controller' => 'index', 'action' => 'delete', 'id' => $item->battle_id),
                $this->translate("delete"),
                array('class' => 'smoothbox')); ?>
            </td>
        </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <br/>

    <div class='buttons'>
        <button type='submit'><?php echo $this->translate("Delete Selected") ?></button>
    </div>
</form>

<br/>
<div>
    <?php echo $this->paginationControl($this->paginator); ?>
</div>

<?php  } else { ?>
<div class="tip">
    <span>
      <?php echo $this->translate("There are no battles by your members yet.") ?>
    </span>
</div>
<?php } ?>
