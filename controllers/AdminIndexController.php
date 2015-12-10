<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Mirlan
 * Date: 06.11.15
 * Time: 21:48
 * To change this template use File | Settings | File Templates.
 */
class Photobattle_AdminIndexController extends Core_Controller_Action_Admin
{
    public function indexAction()
    {
        // Menu
        $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')
                ->getNavigation('photobattle_admin_main', array(), 'photobattle_admin_main_manage');

        $battleTable = Engine_Api::_()->getItemTable('photobattle_battle');
        // In the presence request post
        if ($this->getRequest()->isPost()) {
            $values = $this->getRequest()->getPost();

            // Delete selected battles
            if (!empty($values)) {
                $db = $battleTable->getAdapter();
                try {
                    $db->beginTransaction();

                    foreach ($values as $key => $value) {
                        if ($key == 'delete_' . $value) {
                            $battle = Engine_Api::_()->getItem('photobattle_battle', $value);

                            //  Retraces the scores
                            $scoreTable = Engine_Api::_()->getItemTable('photobattle_score');
                            $scoreTable->retracesScores($battle);

                            $battle->delete();
                        }
                    }

                    $db->commit();
                } catch (Exception $e) {
                    $db->rollBack();
                    throw $e;
                }
            }
        }

        $this->view->page = $page = $this->_getParam('page', 1);

        $order = $this->_getParam('order', "DESC");
        $this->view->orderSort = $orderSort = $order == "ASC" ? "DESC" : "ASC";
        $paginatopSelect = $battleTable->getBattlesSelect(array('page' => $page, 'limit' => 15, 'order' => $order));
        $this->view->paginator = $battleTable
                ->getBattlesPaginator(array('page' => $page, 'limit' => 15, 'order' => $order), $paginatopSelect);
    }

    public function deleteAction()
    {
        // In smoothbox
        $this->_helper->layout->setLayout('admin-simple');
        $id = $this->_getParam('id');
        $this->view->battle_id = $id;

        // Check post
        if ($this->getRequest()->isPost()) {
            $db = Engine_Db_Table::getDefaultAdapter();
            $db->beginTransaction();

            try
            {
                $battle = Engine_Api::_()->getItem('photobattle_battle', $id);

                //  Retraces the scores
                $scoreTable = Engine_Api::_()->getItemTable('photobattle_score');
                $scoreTable->retracesScores($battle);

                // delete the Battle entry into the database
                $battle->delete();
                $db->commit();
            }

            catch (Exception $e)
            {
                $db->rollBack();
                throw $e;
            }

            $this->_forward('success', 'utility', 'core', array(
                                                               'smoothboxClose' => 10,
                                                               'parentRefresh' => 10,
                                                               'messages' => array('')
                                                          ));
        }

        // Output
        $this->renderScript('admin-index/delete.tpl');
    }

    public function scoreAction()
    {
        $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')
                ->getNavigation('photobattle_admin_main', array(), 'photobattle_admin_main_score');

        $scoreTable = Engine_Api::_()->getItemTable('photobattle_score');
        // In the presence request post
        if ($this->getRequest()->isPost()) {
            $values = $this->getRequest()->getPost();

            // Delete selected scores
            if (!empty($values)) {
                $db = $scoreTable->getAdapter();
                try {
                    $db->beginTransaction();

                    foreach ($values as $key => $value) {
                        if ($key == 'delete_' . $value) {
                            $score = Engine_Api::_()->getItem('photobattle_score', $value);

                            // Removal of battles that involved party
                            $owner = $score->getOwnerScore();
                            $battleTable = Engine_Api::_()->getItemTable('photobattle_battle');

                            if (!empty($owner)) {
                                $battleTable->deleteUserParticipateBattles($owner->getIdentity());
                            }

                            //Score Delete
                            $score->delete();
                        }
                    }

                    $db->commit();
                } catch (Exception $e) {
                    $db->rollBack();
                    throw $e;
                }
            }
        }

        $order = $this->_getParam('order', "DESC");
        $this->view->orderSort = $order == "ASC" ? "DESC" : "ASC";

        $this->view->page = $page = $this->_getParam('page', 1);

        $this->view->paginator = $scoreTable->getScoresPaginator(array('page' => $page, 'limit' => 15,
                                                                      'order' => $order));
    }

    public function deletescoreAction()
    {
        // In smoothbox
        $this->_helper->layout->setLayout('admin-simple');
        $id = $this->_getParam('id');
        $this->view->score_id = $id;

        // Check post
        if ($this->getRequest()->isPost()) {
            $db = Engine_Db_Table::getDefaultAdapter();
            $db->beginTransaction();

            try
            {
                $score = Engine_Api::_()->getItem('photobattle_score', $id);

                // Removal of battles that involved party
                $battleTable = Engine_Api::_()->getItemTable('photobattle_battle');
                $owner = $score->getOwnerScore();

                if (!empty($owner)) {
                    $battleTable->deleteUserParticipateBattles($owner->getIdentity());
                }

                // delete the Score entry into the database
                $score->delete();
                $db->commit();
            }

            catch (Exception $e)
            {
                $db->rollBack();
                throw $e;
            }

            $this->_forward('success', 'utility', 'core', array(
                                                               'smoothboxClose' => 10,
                                                               'parentRefresh' => 10,
                                                               'messages' => array('')
                                                          ));
        }

        // Output
        $this->renderScript('admin-index/deletescore.tpl');
    }

    public function levelAction()
    {
        $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')
                ->getNavigation('photobattle_admin_main', array(), 'photobattle_admin_main_level');

        // Get level id
        if (null !== ($id = $this->_getParam('id'))) {
            $level = Engine_Api::_()->getItem('authorization_level', $id);
        } else {
            $level = Engine_Api::_()->getItemTable('authorization_level')->getDefaultLevel();
        }
        if (!$level instanceof Authorization_Model_Level) {
            throw new Engine_Exception('missing level');
        }

        $id = $level->level_id;

        // Make form
        $this->view->form = $form = new Photobattle_Form_Admin_Settings_Level(array(
                                                                                   'public' => (in_array($level->type, array('public'))),
                                                                                   'moderator' => (in_array($level->type, array('admin', 'moderator'))),
                                                                              ));
        $form->level_id->setValue($id);

        // Populate values
        $permissionsTable = Engine_Api::_()->getDbtable('permissions', 'authorization');
        $form->populate($permissionsTable->getAllowed('photobattle', $id, array_keys($form->getValues())));


        // Check post
        if (!$this->getRequest()->isPost()) {
            return;
        }

        // Check validitiy
        if (!$form->isValid($this->getRequest()->getPost())) {
            return;
        }

        //Process
        $values = $form->getValues();

        $db = $permissionsTable->getAdapter();
        $db->beginTransaction();

        try
        {
            // Set permissions
            $permissionsTable->setAllowed('photobattle', $id, $values);

            // Commit
            $db->commit();
        }

        catch (Exception $e)
        {
            $db->rollBack();
            throw $e;
        }

        // Notice
        $form->addNotice('Your changes have been saved.');
    }

}

