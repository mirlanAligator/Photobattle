<?php
/**
 * @category   Application_Extensions
 * @package    Photo Battle
 * @copyright  Copyright 2015 Mirlan
 * @license    GNU
 */

class Photobattle_Plugin_Core
{
    public function onUserUpdateAfter($event)
    {
        $user = $event->getPayload();
        if ($user instanceof User_Model_User) {

            $user_id = $user->getIdentity();

            //Get user for file_id = photo_id
            $scoreTable = Engine_Api::_()->getItemTable('photobattle_score');
            $userScore = $scoreTable->getUserScoreRow($user_id);

            if (!empty($userScore)) {

                // Delete scores -------------
                if ($userScore->photo_id != $user->photo_id) {
                    $userScore->delete();

                    //Delete Battles --------------
                    $battleTable = Engine_Api::_()->getItemTable('photobattle_battle');
                    //Removal of all the battles that the user was
                    $battleTable->deleteUserParticipateBattles($user_id);
                }
            }
        }

    }

    public function onUserDeleteBefore($event)
    {
        $user = $event->getPayload();
        if ($user instanceof User_Model_User) {
            $user_id = $user->getIdentity();

            // Delete scores -------------
            $scoreTable = Engine_Api::_()->getDbTable('scores', 'photobattle');
            $userScore = $scoreTable->getUserScoreRow($user_id);
            if (!empty($userScore)) {
                $userScore->delete();
            }

            //Delete Battles --------------
            $battleTable = Engine_Api::_()->getDbTable('battles', 'photobattle');
            //Removal of all the battles that the user was
            $battleTable->deleteUserParticipateBattles($user_id);
            //Removal of all the battles that the user has voted
            $battleTable->deleteUserVotedBattles($user_id);
        }
    }

    public function onPhotobattleBattleDeleteBefore(Engine_Hooks_Event $event)
    {
        $battle = $event->getPayload();

        if ($battle instanceof Photobattle_Model_Battle) {

            //  Retraces the scores
            $scoreTable = Engine_Api::_()->getItemTable('photobattle_score');
            $scoreTable->retracesScores($battle);
        }
    }

    public function onPhotobattleScoreDeleteBefore(Engine_Hooks_Event $event)
    {
        $score = $event->getPayload();

        if ($score instanceof Photobattle_Model_Score) {

            // Removal of battles that involved party
            $owner = $score->getOwnerScore();
            $battleTable = Engine_Api::_()->getItemTable('photobattle_battle');

            if (!empty($owner)) {
                $battleTable->deleteUserParticipateBattles($owner->getIdentity());
            }
        }
    }
}