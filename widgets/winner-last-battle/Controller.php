<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Mirlan
 * Date: 02.11.15
 * Time: 16:53
 * To change this template use File | Settings | File Templates.
 */
class Photobattle_Widget_WinnerLastBattleController extends Engine_Content_Widget_Abstract
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

        $winUserId = $battleTable->getWinnerLastBattleUserId($viewer);
        $this->view->winUserId = $winUserId;
        if (!empty($winUserId)) {
            $user = Engine_Api::_()->getItem('user', $winUserId);
            $userScore = $scoreTable->getUserScoreData($user->user_id);

            $this->view->user = $user;
            $this->view->userScore = $userScore;
        }
    }
}
 
