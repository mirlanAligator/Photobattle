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
    public function getGender($viewer, $action = 'index')
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

    public function getSession()
    {
        $viewer = Engine_Api::_()->user()->getViewer();
        $viewer_id = $viewer->getIdentity();
        if (!$viewer_id) {
            return null;
        }
        $session = new Zend_Session_Namespace("PhotoBattleSessionUser_$viewer_id");
        return $session;
    }

    public function getGenderFieldId()
    {
        $fMetaTable = Engine_Api::_()->fields()->getTable('user', 'meta');
        $select = $fMetaTable->select()->where('type = ?', 'gender');
        $meta = $fMetaTable->fetchRow($select);
        return $meta->field_id;
    }

    public function getGenders()
    {
        $fOptionTable = Engine_Api::_()->fields()->getTable('user', 'options');
        $getderFieldId = $this->getGenderFieldId();
        $select = $fOptionTable->select()->where('field_id = ?', $getderFieldId);
        $genders = $fOptionTable->fetchAll($select);
        return $genders;
    }

    public function getGenderRow($optionId)
    {
        $fOptionTable = Engine_Api::_()->fields()->getTable('user', 'options');
        $select = $fOptionTable->select()->where('option_id = ?', $optionId);
        $genderRow = $fOptionTable->fetchRow($select);
        return $genderRow;
    }
}
 
