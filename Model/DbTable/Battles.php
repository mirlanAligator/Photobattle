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

    private function getPlayUsersSelect($viewer, $gender, $sessBattleHash = null)
    {
        $viewer_id = $viewer->user_id;
        $userTable = Engine_Api::_()->getItemTable('user');
        $battleTable = Engine_Api::_()->getDbTable('battles', 'photobattle');
        $valuessTable = Engine_Api::_()->fields()->getTable('user', 'values');

        $select = $userTable
            ->select()
            ->setIntegrityCheck(false)
            ->from(array('users1' => $userTable->info('name')), array('user1' => 'users1.user_id', 'user2' => 'users2.user_id',
            'battle_hash_c' => new Zend_Db_Expr("IF(users1.user_id > users2.user_id, CONCAT($viewer_id, users1.user_id + users2.user_id, users1.password, users2.password), CONCAT($viewer_id, users1.user_id + users2.user_id, users2.password, users1.password))")))
            ->join(array('users2' => $userTable->info('name')),
            "users1.photo_id <> 0 AND
        users2.photo_id <> 0 AND
        users1.user_id <> $viewer_id AND
        users2.user_id <> $viewer_id AND
        users1.enabled = 1 AND
        users2.enabled = 1 AND
        users1.approved = 1 AND
        users2.approved = 1 AND
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
            'battles.battle_hash = ' . new Zend_Db_Expr("IF(users1.user_id > users2.user_id,
             CONCAT($viewer_id, users1.user_id + users2.user_id, users1.password, users2.password),
             CONCAT($viewer_id, users1.user_id + users2.user_id, users2.password, users1.password))"), array())
            ->where(new Zend_Db_Expr('battles.battle_hash IS NULL'))
            ->group(new Zend_Db_Expr('battle_hash_c'))
            ->order("RAND()");
        if (!$sessBattleHash) {
            $select->limit(1);
        }
        return $select;
    }

    public function getPlayUsers($viewer, $gender, $sessBattleHash = null)
    {
        $select = $this->getPlayUsersSelect($viewer, $gender, $sessBattleHash);
        $userTable = Engine_Api::_()->getItemTable('user');
        if (!$sessBattleHash) {
            $row = $userTable->fetchAll($select)->toArray();
            $users = empty($row) ? null : $row[0];
            return $users;
        } else {
            $select = new Zend_Db_Expr("SELECT * FROM ($select) AS pbs WHERE (pbs.battle_hash_c <> '$sessBattleHash') LIMIT 1");
            $row = $this->getDefaultAdapter()->fetchAll($select . "");
            $users = empty($row) ? null : $row[0];
            return $users;
        }
    }

    public function createBattle($wonPlayer, $wonUser, $lossUser, $viewer, $score_expense)
    {
        //    Formation values
        $values = array();
        $summIds = $wonUser->user_id + $lossUser->user_id;
        $values['battle_hash'] = $wonUser->user_id > $lossUser->user_id ?
            $viewer->user_id . $summIds . $wonUser->password . $lossUser->password :
            $viewer->user_id . $summIds . $lossUser->password . $wonUser->password;

        //            Check battle exists
        if (!$this->battleHashExists($values['battle_hash'])) {
            $values['voter_id'] = $viewer->user_id;
            $values['player1_id'] = (int)$wonPlayer == 1 ? $wonUser->user_id : $lossUser->user_id;
            $values['player2_id'] = (int)$wonPlayer == 2 ? $wonUser->user_id : $lossUser->user_id;
            $values['win_id'] = $wonUser->user_id;
            $values['score_expense'] = $score_expense;
            $values['battle_date'] = date('Y-m-d H:i:s');

            $battle = $this->createRow();
            $battle->setFromArray($values);
            $battle->save();
        }
        return $battle->getIdentity();
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
        $i = 0;
        $select = $this->getMyBattleSelect(array('user_id' => $user_id));
        $battles = $this->fetchAll($select);

        if (!count($battles)) {
            return $i;
        }

        try {
            foreach ($battles as $battle) {
                $battle->delete();
                $i++;
            }
        } catch (Exception $e) {
            throw $e;
        }
        return $i;
        //        $where1 = $this->getAdapter()->quoteInto('player1_id = ?', $user_id);
        //        $where2 = $this->getAdapter()->quoteInto('player2_id = ?', $user_id);

        //        return $this->delete($where1) + $this->delete($where2);
    }

    //Removal of all the battles that the user has voted
    public function deleteUserVotedBattles($user_id)
    {
        if (empty($user_id)) {
            return null;
        }
        $i = 0;
        $select = $this->select()->where('voter_id = ?', $user_id);
        $battles = $this->fetchAll($select);

        if (!count($battles)) {
            return $i;
        }

        try {
            foreach ($battles as $battle) {
                $battle->delete();
                $i++;
            }
        } catch (Exception $e) {
            throw $e;
        }
        return $i;
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

    public function getMyBattleSelect($params)
    {
        $select = $this
            ->select()
            ->from(array('pbattles' => $this->info('name')))
            ->where('pbattles.player1_id = ?', $params['user_id'])
            ->orWhere('pbattles.player2_id = ?', $params['user_id']);
        return $select;
    }

    // Get Paginator Battles
    public function getBattlesPaginator($params = array(), $select)
    {
        $paginator = Zend_Paginator::factory($select);

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


 
