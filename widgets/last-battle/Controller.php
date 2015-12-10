<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Chaghan
 * Date: 22.11.15
 * Time: 11:09
 * To change this template use File | Settings | File Templates.
 */
class Photobattle_Widget_LastBattleController extends Engine_Content_Widget_Abstract
{
    public function indexAction()
    {
        $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();

        if ($viewer->getIdentity() == 0) {
            return $this->setNoRender();
        }

        //        Loading tables and necessary data
        $battleTable = Engine_Api::_()->getDbTable('battles', 'photobattle');
        $scoreTable = Engine_Api::_()->getDbTable('scores', 'photobattle');

        $battle = $battleTable->getLastBattle($viewer);
        $this->view->battle = $battle;
        if (!empty($battle)) {
            $player1 = Engine_Api::_()->getItem('user', $battle->player1_id);
            $player2 = Engine_Api::_()->getItem('user', $battle->player2_id);

            if ($player1->getIdentity() && $player2->getIdentity()) {

                $this->view->player1ScoreData = $scoreTable->getUserScoreData($player1->user_id);
                $this->view->player2ScoreData = $scoreTable->getUserScoreData($player2->user_id);

                $this->view->player1 = $player1;
                $this->view->player2 = $player2;
            }
        }

    }

}