<?php

class Photobattle_IndexController extends Core_Controller_Action_Standard
{
    public function indexAction()
    {
        //        $this->debugging();
        $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
//        print_die(Engine_Api::_()->fields()->getFieldsValuesByAlias($viewer));
        print_die(Engine_Api::_()->fields()->getFieldsOptions($viewer));
        if ($viewer->getIdentity()) {

//            $this->getPlayUsers();
            // Permissions
            if ($this->_helper->requireAuth()->setAuthParams('photobattle', $viewer, 'view')->isValid()) {

                // Get Vote permissions
                $permissionsTable = Engine_Api::_()->getDbtable('permissions', 'authorization');
                $this->view->votePermission = $votePermission = $permissionsTable->
                    getAllowed('photobattle', $viewer->level_id, 'vote');

                if ($votePermission) {
                    if ($this->getRequest()->isPost()) {
                        $this->vote();
                    }
                }

                //        Loading tables and necessary data
                $this->view->gender = $gender = Engine_Api::_()->photobattle()->getGender($viewer, 'index');
                $scoreTable = Engine_Api::_()->getItemTable('photobattle_score');

                $players = $this->getPlayUsers($viewer, $gender);
//                print_die($players);

                if (!empty($players)) {

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
            } else {
                $this->view->noPermission = true;
            }
        }


        if (!$this->getRequest()->isPost() && !$this->getRequest()->getParam('format') == 'html') {
            $this->_helper->content
                ->setEnabled();
        }
    }


    public function vote()
    {
        // check User sign in
        if (!$this->_helper->requireUser()->isValid()) {
            return false;
        }

        try {

            //Get Data of play
            $wonUserId = $this->getParam('won');
            $lossUserId = $this->getParam('loss');
            $wonPlayer = $this->getParam('wonplayer');

            // Check get request
            if (empty($wonPlayer) || empty($wonUserId) || empty($lossUserId)) {
                return false;
            }
            //Get users Models
            $wonUser = Engine_Api::_()->getItem('user', $wonUserId);
            $lossUser = Engine_Api::_()->getItem('user', $lossUserId);

            // Check user empty
            if (empty($wonUser) || empty($lossUser)) {
                return false;
            }


            $battleTable = Engine_Api::_()->getDbTable('battles', 'photobattle');
            $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();

            //Update Users Score
            $scoreTable = Engine_Api::_()->getItemTable('photobattle_score');
            $wonUserScore = $scoreTable->getUserScore($wonUser->user_id);
            $lossUserScore = $scoreTable->getUserScore($lossUser->user_id);

            $wonUserWinsLoss = $scoreTable->getUserWinsLoss($wonUser->user_id);
            $lossUserWinsLoss = $scoreTable->getUserWinsLoss($lossUser->user_id);

            //get new Users Scores
            $wonUserNewScore = $this->getNewScore($wonUserScore, $lossUserScore, 1);
            $lossUserNewScore = $this->getNewScore($lossUserScore, $wonUserScore, 0);

            $wonUserNewPercent = $this->getNewPercent($wonUserWinsLoss['win'], $wonUserWinsLoss['loss'], 1);
            $lossUserNewPercent = $this->getNewPercent($lossUserWinsLoss['win'], $lossUserWinsLoss['loss'], 0);

            //            print_die($wonUserNewPercent);
            //flow calculation
            $score_expense = $wonUserNewScore - $wonUserScore;

            //Create battle
            $battleTable->createBattle($wonPlayer, $wonUser, $lossUser, $viewer, $score_expense);

            //Update Users Score
            $scoreTable->updateUserScore($wonUser, $wonUserNewScore, $wonUserNewPercent, true);
            $scoreTable->updateUserScore($lossUser, $lossUserNewScore, $lossUserNewPercent, false);
            return true;
        } catch (Exception $e) {
            throw $e;
        }

    }

    private function getPlayUsers($viewer, $gender)
    {
        $battleTable = Engine_Api::_()->getItemTable('photobattle_battle');

        $players = $battleTable->getPlayUsers($viewer, $gender);

        $pbSession = Engine_Api::_()->photobattle()->getsession();

        if (!empty($pbSession->players)) {
            $result = $pbSession->players;
        } else {
            $result = $players;
        }
        $pbSession->players = $battleTable->getPlayUsers($viewer, $gender, $players['battle_hash_c']);
//        print_arr($pbSession->players);
        return $result;

    }


    public function scoreAction()
    {
        // check User sign in
        if (!$this->_helper->requireUser()->isValid()) {
            return;
        }

        $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();

        $scoreTable = Engine_Api::_()->getItemTable('photobattle_score');
        $battlesTable = Engine_Api::_()->getItemTable('photobattle_battle');

        $this->view->page = $page = $this->_getParam('page', 1);
        $this->view->paginator = $battlesTable->getBattlesPaginator(
            array('page' => $page, 'limit' => 10, 'order' => 'ASC')
        );

        // Render
        $this->_helper->content
            ->setEnabled();
    }

    public function top10Action()
    {
        // check User sign in
        if (!$this->_helper->requireUser()->isValid()) {
            return;
        }

        $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();

        // Get View permissions
        $permissionsTable = Engine_Api::_()->getDbtable('permissions', 'authorization');
        $this->view->permission = $votePermission = $permissionsTable->
        getAllowed('photobattle', $viewer->level_id, 'view_top10');
//        print_die($this->view->votePermission);

        //        Loading tables and necessary data
        $scoreTable = Engine_Api::_()->getDbTable('scores', 'photobattle');
        $this->view->gender = $gender = Engine_Api::_()->photobattle()->getGender($viewer, 'top10');

//        Get Top 10
        $topUsers = $scoreTable->getLeaderUsersPercent($gender, 10);

//        Output to view
        $this->view->topUsers = $topUsers;

        // Render
        $this->_helper->content
            ->setEnabled();


    }

    public function genderAction()
    {
        // check User sign in
        if (!$this->_helper->requireUser()->isValid()) {
            return;
        }

        $actions = array('index', 'top10');

        // Set gender to settings
        if ($this->getRequest()->isGet()) {
            $action = $this->getParam('a');

//            Check getting actions
            if (empty($action) || !in_array($action, $actions)) {
                return $this->_helper->redirector->gotoRoute(array('action' => 'index'));
            }

            $viewer = Engine_Api::_()->user()->getViewer();
            $gender = $this->_getParam('g');

            if (!empty($gender)) {
                $userSettings = Engine_Api::_()->getDbTable('settings', 'user');
                if ($action == 'index') {
                    $sess = Engine_Api::_()->photobattle()->getSession();
                    $sess->players = array();
                    $userSettings->setSetting($viewer, 'photobattle.gender', $gender);
                } else {
                    $userSettings->setSetting($viewer, "photobattle.gender-$action", $gender);
                }
            }
        }
        return $this->_helper->redirector->gotoRoute(array('action' => $action));
    }

    public function renderwidgetAction()
    {
        if ($this->getRequest()->isPost()) {
            $photoBattleWidgets = array('winner-last-battle', 'top-leader');
            $widgetName = $this->getParam('widget');
            //            print_die(in_array($widgetName, $photoBattleWidgets));

            if (!empty($widgetName) && in_array($widgetName, $photoBattleWidgets)) {
                //                print_die($widgetName);
                $this->view->widgetName = $widgetName;
            }
        }

    }

    private function getExpectedScore($playerScore, $oppenentScore)
    {
        return 1.0 / (1.0 + pow(10, ($oppenentScore - $playerScore) / 400));
    }

    private function getNewScore($playerScore, $oppenentScore, $battleResult, $k = 32)
    {
        return (int)round($playerScore + $k * ($battleResult - $this->getExpectedScore($playerScore, $oppenentScore)));
    }

    private function getNewPercent($playerWons, $playerLosses, $battleResult)
    {
        if ($battleResult) {
            $playerWons = $playerWons + 1;
        } else {
            $playerLosses = $playerLosses + 1;
        }

        $percent = round((100 / ($playerWons + $playerLosses)) * $playerWons);
        //$percent = round($percent, 2, PHP_ROUND_HALF_EVEN);
        return $percent;
    }


}
