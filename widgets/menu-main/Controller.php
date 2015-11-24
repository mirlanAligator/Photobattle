<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Mirlan
 * Date: 01.11.15
 * Time: 22:33
 * To change this template use File | Settings | File Templates.
 */

class Photobattle_Widget_MenuMainController extends Engine_Content_Widget_Abstract
{
    public function indexAction()
    {
        // Get navigation
        $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')
                ->getNavigation('photobattle_main');
//        if (count($this->view->navigation) == 1) {
//            $this->view->navigation = null;
//        }
    }
}
