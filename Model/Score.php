<?php
/**
 * Created by PhpStorm.
 * User: Mirlan
 * Date: 04.11.2015
 * Time: 19:30
 */
class Photobattle_Model_Score extends Core_Model_Item_Abstract
{
    public function getUserDispayName()
    {
        $userName = Engine_Api::_()->getItem('user', $this->user_id)->getTitle();
        return $userName;
    }

    public function getOwnerScore()
    {
        return Engine_Api::_()->getItem('user', $this->user_id);
    }

}