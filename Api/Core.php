<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Mirlan
 * Date: 06.11.15
 * Time: 18:45
 * To change this template use File | Settings | File Templates.
 */

class Photobattle_Api_Core extends Core_Api_Abstract
{
    public function getGender($viewer, $action)
    {
        $userSettings = Engine_Api::_()->getDbTable('settings', 'user');
        if ($action == 'index') {
            $gender = $userSettings->getSetting($viewer, 'photobattle.gender');
        } else {
            $gender = $userSettings->getSetting($viewer, "photobattle.gender-$action");
        }

        if (empty($gender)) {
            return 2;
        }

        return $gender;
    }

    public function getSession() {
        $session = new Zend_Session_Namespace('PhotoBattleSession');
        return $session;
    }
}
 
