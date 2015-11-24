<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Mirlan
 * Date: 02.11.15
 * Time: 23:01
 * To change this template use File | Settings | File Templates.
 */
class Photobattle_Model_DbTable_Scores extends Engine_Db_Table
{
    protected $_rowClass = 'Photobattle_Model_Score';

    public function getUserScore($user_id)
    {
        if (empty($user_id)) {
            return false;
        }
        $select = $this->select()->where('user_id = ?', $user_id);
        $userScoreData = $this->fetchRow($select);
        if (empty($userScoreData)) {
            return 1400;
        }
        return $userScoreData->scores;
    }

    public function getUserWinsLoss($user_id)
    {
        if (empty($user_id)) {
            return false;
        }
        $select = $this->select()->where('user_id = ?', $user_id);
        $userScore = $this->fetchRow($select);
        if (empty($userScore)) {
            return array('win' => 0, 'loss' => 0);
        }
        return array('win' => $userScore->win, 'loss' => $userScore->loss);
    }

    public function updateUserScore(User_Model_User $user, $newScores, $newPercent, $battleResult)
    {
        if (empty($user)) {
            return false;
        }

        $values = array();

        $select = $this->select()->where('user_id = ?', $user->user_id);

        $values['user_id'] = $user->user_id;
        $values['photo_id'] = $user->photo_id;
        $values['scores'] = $newScores;
        $score = $this->fetchRow($select);

        if (empty($score)) {
            $values['win'] = $battleResult ? 1 : 0;
            $values['loss'] = !$battleResult ? 1 : 0;
            $values['percent'] = $newPercent;
            $this->createScore($values);
        } else {
            $values['win'] = (int)$score->win + (int)$battleResult;
            $values['loss'] = (int)$score->loss + (int)(!$battleResult);
            $values['percent'] = $newPercent;
            $this->updateScore($score, $values);
        }
    }

    public function createScore($values)
    {
        $db = $this->getAdapter();
        try {
            $db->beginTransaction();

            $row = $this->createRow();
            $row->setFromArray($values);
            $row->save();

            $db->commit();
        } catch (Exception $e) {
            $db->rollBack();
            throw $e;
        }
    }

    public function updateScore($row, $values)
    {
        $db = $this->getAdapter();
        try {
            $db->beginTransaction();

            $row->setFromArray($values);
            $row->save();

            $db->commit();
        } catch (Exception $e) {
            $db->rollBack();
            throw $e;
        }
    }

    public function getUserScoreData($user_id)
    {
        if (empty($user_id)) {
            return null;
        }
        $userScoreDataArray = array();
        $select = $this->select()->where('user_id = ?', $user_id);
        $userScoreData = $this->fetchRow($select);

        if (empty($userScoreData)) {
            $userScoreDataArray['scores'] = 1400;
            $userScoreDataArray['win'] = 0;
            $userScoreDataArray['loss'] = 0;
            $userScoreDataArray['percent'] = 0;
            return $userScoreDataArray;
        }

        return $userScoreData->toArray();
    }

    public function getLeaderUsers($gender = 2, $limit = 10)
    {
        $fvaluesTable = Engine_Api::_()->fields()->getTable('user', 'values');
        $userTable = Engine_Api::_()->getItemTable('user');

        $select = $userTable
            ->select()
            ->setIntegrityCheck(false)
            ->from(array('users' => $userTable->info('name')),
            new Zend_Db_Expr('users.*, IF(`bscores`.scores IS NOT NULL, `bscores`.scores, 1400) as scores_f'))
            ->join(array('fvalues' => $fvaluesTable->info('name')),
            "users.user_id = fvalues.item_id AND
                        fvalues.field_id = 5 AND
                        fvalues.value = $gender", array())
            ->joinLeft(array('bscores' => $this->info('name')), 'users.user_id = bscores.user_id', array())
            ->where('users.photo_id <> ?', 0)
            ->where('users.enabled = ?', 1)
            ->order('scores_f DESC')
            ->limit($limit);
        $rows = $userTable->fetchAll($select);
        return $rows;
    }

    //Get User score Row
    public function getUserScoreRow($user_id)
    {
        if (empty($user_id)) {
            return null;
        }

        $select = $this->select()->where('user_id = ?', $user_id);
        $row = $this->fetchRow($select);
        return $row;
    }

    //Get Scores Paginator Select
    public function getScoresPaginatorSelect($params = array())
    {
        if (!empty($params['order'])) {
            $select = $this->select()->order("scores " . $params['order']);
        } else {
            $select = $this->select()->order("scores ASC");
        }
        return $select;
    }

    //get Scores Paginator
    public function getScoresPaginator($params = array())
    {
        $paginator = Zend_Paginator::factory($this->getScoresPaginatorSelect($params));

        if (!empty($params['page'])) {
            $paginator->setCurrentPageNumber($params['page']);
        }

        if (!empty($params['limit'])) {
            $paginator->setItemCountPerPage($params['limit']);
        } else {
            $paginator->setItemCountPerPage(15);
        }

        return $paginator;
    }

    //  Retraces score
    public function retracesScores($battle)
    {
        $winnerId = $battle->win_id;
        $lossId = $winnerId != $battle->player1_id ? $battle->player1_id : $battle->player2_id;

        $scoreWinUser = $this->getUserScoreRow($winnerId);
        $scoreLossUser = $this->getUserScoreRow($lossId);

        // Restore Scores
        if (!empty($scoreWinUser) && !empty($scoreLossUser)) {

            $scoreWinUser->scores = $scoreWinUser->scores - $battle->score_expense;
            $scoreWinUser->win = $scoreWinUser->win - 1;

            $scoreLossUser->scores = $scoreLossUser->scores + $battle->score_expense;
            $scoreLossUser->loss = $scoreLossUser->loss - 1;

            // Update Scores
            $scoreWinUser->save();
            $scoreLossUser->save();
        }
    }

    public function getLeaderUsersPercent($gender = 2, $limit = 10)
    {
        $fvaluesTable = Engine_Api::_()->fields()->getTable('user', 'values');
        $userTable = Engine_Api::_()->getItemTable('user');

        $select = $userTable
            ->select()
            ->setIntegrityCheck(false)
            ->from(array('users' => $userTable->info('name')),
            new Zend_Db_Expr('users.*, IF(`bscores`.percent IS NOT NULL, `bscores`.percent, 0) as percent_f'))
            ->join(array('fvalues' => $fvaluesTable->info('name')),
            "users.user_id = fvalues.item_id AND
                        fvalues.field_id = 5 AND
                        fvalues.value = $gender", array())
            ->joinLeft(array('bscores' => $this->info('name')), 'users.user_id = bscores.user_id', array())
            ->where('users.photo_id <> ?', 0)
            ->where('users.enabled = ?', 1)
            ->order('bscores.percent DESC')
            ->limit($limit);
        $rows = $userTable->fetchAll($select);
        return $rows;
    }

}
