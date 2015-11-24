<?php

/**
 * Created by JetBrains PhpStorm.
 * User: Mirlan
 * Date: 02.11.15
 * Time: 23:00
 * To change this template use File | Settings | File Templates.
 */
class Photobattle_Model_DbTable_Battles extends Engine_Db_Table
{
    protected $_rowClass = "Photobattle_Model_Battle";

    public function getPlayUsers($viewer, $gender, $prevBattleHash = "")
    {
        $viewer_id = $viewer->user_id;
        $userTable = Engine_Api::_()->getItemTable('user');
        $battleTable = Engine_Api::_()->getDbTable('battles', 'photobattle');
        $valuessTable = Engine_Api::_()->fields()->getTable('user', 'values');
        $orWhere = $prevBattleHash ? "OR IF(users1.user_id > users2.user_id, CONCAT($viewer_id, users1.password, users2.password), CONCAT($viewer_id, users2.password, users1.password)) = '$prevBattleHash'" : "";
        $select = $userTable
            ->select()
            ->setIntegrityCheck(false)
            ->from(array('users1' => $userTable->info('name')), array('user1' => 'users1.user_id', 'user2' => 'users2.user_id',
            'battle_hash_c' => new Zend_Db_Expr("IF(users1.user_id > users2.user_id, CONCAT($viewer_id, users1.password, users2.password), CONCAT($viewer_id, users2.password, users1.password))")))
            ->join(array('users2' => $userTable->info('name')),
            "users1.photo_id <> 0 AND
        users2.photo_id <> 0 AND
        users1.user_id <> $viewer_id AND
        users2.user_id <> $viewer_id AND
        users1.enabled = 1 AND
        users2.enabled = 1 AND
        users1.user_id <> users2.user_id"
            , array())
            ->join(array('fvalues2' => $valuessTable->info('name')),
            "users2.user_id = fvalues2.item_id AND
        fvalues2.field_id = 5 AND
        fvalues2.value = $gender"
            , array())
            ->join(array('fvalues1' => $valuessTable->info('name')),
            "users1.user_id = fvalues1.item_id AND
        fvalues1.field_id = 5 AND
        fvalues1.value = $gender"
            , array())
            ->joinLeft(array('battles' => $battleTable->info('name')),
            'battles.battle_hash = ' . new Zend_Db_Expr("IF(users1.user_id > users2.user_id, CONCAT($viewer_id, users1.password, users2.password), CONCAT($viewer_id, users2.password, users1.password)) " . $orWhere), array())
            ->where(new Zend_Db_Expr('battles.battle_hash IS NULL'))
            ->group(new Zend_Db_Expr('battle_hash_c'))
            ->order("RAND()")
            ->limit(1);
        $row = $userTable->fetchAll($select)->toArray();
        $users = $row[0];
        return $users;
    }

    public function createBattle($wonPlayer, $wonUser, $lossUser, $viewer, $score_expense)
    {
        //    Formation values
        $values = array();
        $values['battle_hash'] = $wonUser->user_id > $lossUser->user_id ?
            "$viewer->user_id" . $wonUser->password . $lossUser->password :
            "$viewer->user_id" . $lossUser->password . $wonUser->password;

        //    Check battle exists
        if (!$this->battleHashExists($values['battle_hash'])) {
            $values['voter_id'] = $viewer->user_id;
            $values['player1_id'] = (int)$wonPlayer == 1 ? $wonUser->user_id : $lossUser->user_id;
            $values['player2_id'] = (int)$wonPlayer == 2 ? $wonUser->user_id : $lossUser->user_id;
            $values['win_id'] = $wonUser->user_id;
            $values['score_expense'] = $score_expense;
            $values['battle_date'] = date('Y-m-d H:i:s');

            // Set values. Begin Transaction
            $db = $this->getAdapter();
            try {
                $db->beginTransaction();

                $battle = $this->createRow();
                $battle->setFromArray($values);
                $battle->save();

                $db->commit();
            } catch (Exception $e) {
                $db->rollBack();
                throw $e;
            }
        }
    }

    public function getWinnerLastBattleUserId($viewer)
    {
        if (empty($viewer)) {
            return null;
        }
        $select = $this->select()->where('voter_id = ?', $viewer->user_id)->order('battle_id DESC')->limit(1);
        $battle = $this->fetchRow($select);
        return $battle ? $battle->win_id : null;
    }

    public function getLastBattle($viewer)
    {
        if (empty($viewer)) {
            return null;
        }
        $select = $this->select()->where('voter_id = ?', $viewer->user_id)->order('battle_id DESC')->limit(1);
        $battle = $this->fetchRow($select);
        return $battle ? $battle : null;
    }

    //Removal of all the battles that the user was
    public function deleteUserParticipateBattles($user_id)
    {
        if (empty($user_id)) {
            return null;
        }

        $where1 = $this->getAdapter()->quoteInto('player1_id = ?', $user_id);
        $where2 = $this->getAdapter()->quoteInto('player2_id = ?', $user_id);

        return $this->delete($where1) + $this->delete($where2);
    }

    //Removal of all the battles that the user has voted
    public function deleteUserVotedBattles($user_id)
    {
        if (empty($user_id)) {
            return null;
        }

        $where = $this->getAdapter()->quoteInto('voter_id = ?', $user_id);
        $this->view->paginatop(array(''));
        return $this->delete($where);
    }

//    Get Battle select to Paginator
    public function getBattlesSelect($params = array())
    {
        if (!empty($params['order'])) {
            $select = $this->select()->order("battle_date " . $params['order']);
        } else {
            $select = $this->select()->order("battle_date ASC");
        }
        return $select;
    }

    // Get Paginator Battles
    public function getBattlesPaginator($params = array())
    {
        $paginator = Zend_Paginator::factory($this->getBattlesSelect($params));

        if (!empty($params['page'])) {
            $paginator->setCurrentPageNumber($params['page']);
        }

        if (!empty($params['limit'])) {
            $paginator->setItemCountPerPage($params['limit']);
        }

        if (empty($params['limit'])) {
            $paginator->setItemCountPerPage(15);
        }
        return $paginator;
    }

    public function battleHashExists($battleHash)
    {
        $select = $this->select()->where('battle_hash = ?', $battleHash)->limit(1);
        $battle = $this->fetchAll($select);
        return count($battle);
    }
}


 
