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
                }

                //Delete Battles --------------
                $battleTable = Engine_Api::_()->getItemTable('photobattle_battle');
                //Removal of all the battles that the user was
                $battleTable->deleteUserParticipateBattles($user_id);
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
}