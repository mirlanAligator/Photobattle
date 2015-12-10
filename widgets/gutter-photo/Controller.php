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
        $viewer = Engine_Api::_()->user()->getViewer();
        if ($viewer->getIdentity() == 0) {
            return $this->setNoRender();
        }

                //check Permission
        $permissionsTable = Engine_Api::_()->getDbtable('permissions', 'authorization');
        $permission = $votePermission = $permissionsTable->
            getAllowed('photobattle', $viewer->level_id, 'view_score');
        if (!$permission) {
            return $this->setNoRender();
        }

        //scheck user photo_id
        if ($viewer->photo_id == 0) {
            return $this->setNoRender();
        }

        if (Engine_Api::_()->core()->hasSubject('user')) {
            $this->view->user = $user = Engine_Api::_()->user()->getViewer();


            $user = Engine_Api::_()->core()->getSubject('user');

            $scoreTable = Engine_Api::_()->getItemTable('photobattle_score');
            $userValues = Engine_Api::_()->fields()->getFieldsValuesByAlias($user);
            $gender = $userValues['gender'];


            $this->view->user = $user;
            $this->view->userScore = $scoreTable->getUserScoreData($user->user_id);
            $this->view->userPlace = $scoreTable->getUserPlace($gender, $user->user_id);
        }
    }
}

