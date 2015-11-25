<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Chaghan
 * Date: 25.11.15
 * Time: 12:00
 * To change this template use File | Settings | File Templates.
 */
class Photobattle_Widget_GutterPhotoController extends Engine_Content_Widget_Abstract
{
    public function indexAction()
    {
        // check User sign in
//        print_die('Hello');
        $this->view->score = 'My Score';
        $viewer = Engine_Api::_()->user()->getViewer();

        $scoreTable = Engine_Api::_()->getDbTable('scores', 'photobattle');
        $this->view->viewer = $viewer;
        $this->view->viewerScore = $scoreTable->getUserScoreData($viewer->user_id);

    }
}

