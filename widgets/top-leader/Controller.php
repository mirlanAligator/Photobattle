<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Mirlan
 * Date: 02.11.15
 * Time: 16:37
 * To change this template use File | Settings | File Templates.
 */
class Photobattle_Widget_TopLeaderController extends Engine_Content_Widget_Abstract
{
    public function indexAction()
    {
        //        Loading tables and necessary data
        $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
        $scoreTable = Engine_Api::_()->getDbTable('scores', 'photobattle');
        $gender = Engine_Api::_()->photobattle()->getGender($viewer);

        $topUsers = $scoreTable->getLeaderUsersPercent($gender, 10);

        if (!count($topUsers)) {
            return $this->setNoRender();
        }

        $this->view->topUsers = $topUsers;

    }
}

