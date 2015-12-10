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
                ->setDescription("PHOTO_BATTLE_FORM_ADMIN_LEVEL_DESCRIPTION");

        // Element: view
        $this->addElement('Radio', 'view', array(
                                                'label' => 'Allow Viewing of Battles?',
                                                'description' => 'Do you want to allow participants to view Battles?',
                                                'multiOptions' => array(
                                                    1 => 'Yes, allow viewing of battles.',
                                                    0 => "No, don't allow",
                                                ),
                                                'value' => 1,
                                           ));

        // Element: vote
        $this->addElement('Radio', 'vote', array(
                                                'label' => 'Allow Voting of Battles?',
                                                'description' => 'Do you want to let members vote battles?',
                                                'multiOptions' => array(
                                                    1 => 'Yes, allow voting of battles.',
                                                    0 => 'No, do not allow battles to be voted.',
                                                ),
                                                'value' =>  1,
                                           ));

        // Element: view page Top10
        $this->addElement('Radio', 'view_top10', array(
                                                'label' => 'Allow Viewing of Top 10 page?',
                                                'description' => 'Do you want to allow participants viewing of Top 10 page?',
                                                'multiOptions' => array(
                                                    1 => 'Yes, allow viewing of Top 10 page.',
                                                    0 => "No, don't allow Top 10 page to be viewed.",
                                                ),
                                                'value' =>  1,
                                           ));


        // Element: view page My Scores
        $this->addElement('Radio', 'view_score', array(
                                                'label' => "Allow Viewing of My Scores page?",
                                                'description' => "Do you want to allow participants viewing of My Scores page?",
                                                'multiOptions' => array(
                                                    1 => "Yes, allow viewing of My Scores page.",
                                                    0 => "No, don't allow viewing of My Scores page.",
                                                ),
                                                'value' =>  1,
                                           ));


        // Element: view page My Scores
        $this->addElement('Radio', 'stranger_score', array(
                                                'label' => "Allow Viewing of other users results?",
                                                'description' => "Do you want to allow this level to view other users results?",
                                                'multiOptions' => array(
                                                    1 => "Yes, allow viewing of results.",
                                                    0 => "No, don't allow results to be viewed.",
                                                ),
                                                'value' =>  1,
                                           ));

    }
}
