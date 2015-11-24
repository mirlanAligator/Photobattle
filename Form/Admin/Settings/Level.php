<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Mirlan
 * Date: 08.11.15
 * Time: 14:57
 * To change this template use File | Settings | File Templates.
 */
class Photobattle_Form_Admin_Settings_Level extends Authorization_Form_Admin_Level_Abstract
{
    public function init()
    {
        parent::init();

        // My stuff
        $this->setTitle('Member Level Settings')
                ->setDescription("These settings are applied on a per member level basis. Start by selecting the member level you want to modify, then adjust the settings for that level below.");

        // Element: view
        $this->addElement('Radio', 'view', array(
                                                'label' => 'To allow to view Battles?',
                                                'description' => 'You want to allow participants to view battle? If it is set in not, some other tuning properties on this page can not be applied.',
                                                'multiOptions' => array(
                                                    1 => 'Yes, allow viewing of battles.',
                                                    0 => "No, you don't allow to view battle.",
                                                ),
                                                'value' => 1,
                                           ));

        // Element: vote
        $this->addElement('Radio', 'vote', array(
                                                'label' => 'Allow Voting of Battles?',
                                                'description' => 'Do you want to let members vote battles? If set to no, some other settings on this page may not apply.',
                                                'multiOptions' => array(
                                                    1 => 'Yes, allow voting of battles.',
                                                    0 => 'No, do not allow battles to be voted.',
                                                ),
                                                'value' =>  1,
                                           ));

    }
}
