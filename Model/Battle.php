<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Mirlan
 * Date: 02.11.15
 * Time: 23:00
 * To change this template use File | Settings | File Templates.
 */
class Photobattle_Model_Battle extends Core_Model_Item_Abstract
{
    public function getVoterUserName()
    {
        return Engine_Api::_()->getItem('user', $this->voter_id)->getTitle();
    }

    public function getPlayer1UserName()
    {
        return Engine_Api::_()->getItem('user', $this->player1_id)->getTitle();
    }

    public function getPlayer2UserName()
    {
        return Engine_Api::_()->getItem('user', $this->player2_id)->getTitle();
    }

    public function getWinnerUserName()
    {
        return Engine_Api::_()->getItem('user', $this->win_id)->getTitle();
    }
}

