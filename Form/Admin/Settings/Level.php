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

        // Element: view page Top10
        $this->addElement('Radio', 'view_top10', array(
                                                'label' => 'To allow viewing of the     Top 10 page?',
                                                'description' => 'Do you want to permit to participants viewing of the Top10 page? If set to no, some other settings on this page may not apply.',
                                                'multiOptions' => array(
                                                    1 => 'Yes I allow viewing of the Top10 page.',
                                                    0 => "No, I don't allow viewing of the Top10 page.",
                                                ),
                                                'value' =>  1,
                                           ));


        // Element: view page My Scores
        $this->addElement('Radio', 'view_score', array(
                                                'label' => "To allow viewing of the My Scores page?",
                                                'description' => "Do you want to permit to participants viewing of the My Scores page? If set to no, some other settings on this page may not apply.",
                                                'multiOptions' => array(
                                                    1 => "Yes I allow viewing of the My Scores page",
                                                    0 => "No, I don't allow viewing of the My Scores page.",
                                                ),
                                                'value' =>  1,
                                           ));


        // Element: view page My Scores
        $this->addElement('Radio', 'stranger_score', array(
                                                'label' => "To allow viewing of results of battle of other users?",
                                                'description' => "You want to allow this level to view results of battle of other users? If set to no, some other settings on this page may not apply.",
                                                'multiOptions' => array(
                                                    1 => "Yes I allow to view results of battle of other users.",
                                                    0 => "No, I don't allow to view results of battle of other users.",
                                                ),
                                                'value' =>  1,
                                           ));

    }
}
