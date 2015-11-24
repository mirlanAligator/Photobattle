<?php
/**
 * @category   Application_Extensions
 * @package    Photo Battle
 * @copyright  Copyright 2015 Mirlan
 * @license    GNU
 */


class Photobattle_Plugin_Menus
{
    public function canViewPhotobattle()
    {
        $viewer = Engine_Api::_()->user()->getViewer();

        if (!$viewer || !$viewer->getIdentity()) {
            return false;
        }
        return true;
    }

    public function canMyScorePhotobattle()
    {
        $viewer = Engine_Api::_()->user()->getViewer();

        if (!$viewer || !$viewer->getIdentity()) {
            return false;
        }
        return true;
    }

    public function canTop10Photobattle()
    {
        $viewer = Engine_Api::_()->user()->getViewer();

        if (!$viewer || !$viewer->getIdentity()) {
            return false;
        }
        return true;
    }

}