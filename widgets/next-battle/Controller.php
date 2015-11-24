<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Chaghan
 * Date: 22.11.15
 * Time: 15:25
 * To change this template use File | Settings | File Templates.
 */

class Photobattle_Widget_NextBattleController extends Engine_Content_Widget_Abstract
{
    public function indexAction()
    {
        $pbSession = Engine_Api::_()->photobattle()->getSession();
        if (!empty($pbSession->players)) {
            $players = $pbSession->players;
            $scoreTable = Engine_Api::_()->getItemTable('photobattle_score');
            //        User1
            $user1 = Engine_Api::_()->getItem('user', $players['user1']);
            $user1Score = $scoreTable->getUserScoreData($user1->user_id);

            //        User2
            $user2 = Engine_Api::_()->getItem('user', $players['user2']);
            $user2Score = $scoreTable->getUserScoreData($user2->user_id);

            //        Output User1 to view
            $this->view->user1 = $user1;
            $this->view->user1Score = $user1Score;

            //        Output User2 to view
            $this->view->user2 = $user2;
            $this->view->user2Score = $user2Score;
        } else {
            $this->view->noPlayers = true;
        }
    }
}