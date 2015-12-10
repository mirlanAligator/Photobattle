<?php

/**
 * @category   Application_Extensions
 * @package    Photo Battle
 * @copyright  Copyright 2015 Mirlan
 */
class Photobattle_Installer extends Engine_Package_Installer_Module
{
    public function onInstall()
    {
        $this->_addPhotobattleIndexPage();
        $this->_addPhotobattleScorePage();
        $this->_addPhotobattleTop10Page();
        $this->_addPhotobattlePermissions();

        parent::onInstall();
    }

    protected function _addPhotobattleIndexPage()
    {
        $db = $this->getDb();

        // profile page
        $page_id = $db->select()
            ->from('engine4_core_pages', 'page_id')
            ->where('name = ?', 'photobattle_index_index')
            ->limit(1)
            ->query()
            ->fetchColumn();

        // insert if it doesn't exist yet
        if (!$page_id) {
            // Insert page

            $db->insert('engine4_core_pages', array(
                'name' => 'photobattle_index_index',
                'displayname' => 'Photo Battle Home Page',
                'title' => 'Photo Battle Home',
                'description' => 'Мain page Photo Battle.',
                'custom' => 0,
            ));
            $page_id = $db->lastInsertId();

            // Insert top
            $db->insert('engine4_core_content', array(
                'type' => 'container',
                'name' => 'top',
                'page_id' => $page_id,
                'order' => 1,
            ));
            $top_id = $db->lastInsertId();

            // Insert main
            $db->insert('engine4_core_content', array(
                'type' => 'container',
                'name' => 'main',
                'page_id' => $page_id,
                'order' => 2,
            ));
            $main_id = $db->lastInsertId();

            // Insert top-middle
            $db->insert('engine4_core_content', array(
                'type' => 'container',
                'name' => 'middle',
                'page_id' => $page_id,
                'parent_content_id' => $top_id,
            ));
            $top_middle_id = $db->lastInsertId();

            // Insert main-middle
            $db->insert('engine4_core_content', array(
                'type' => 'container',
                'name' => 'middle',
                'page_id' => $page_id,
                'parent_content_id' => $main_id,
                'order' => 6,
            ));
            $main_middle_id = $db->lastInsertId();

            // Insert main-right
            $db->insert('engine4_core_content', array(
                'type' => 'container',
                'name' => 'right',
                'page_id' => $page_id,
                'parent_content_id' => $main_id,
                'order' => 5,
            ));
            $main_right_id = $db->lastInsertId();

            // Insert menu
            $db->insert('engine4_core_content', array(
                'type' => 'widget',
                'name' => 'photobattle.menu-main',
                'page_id' => $page_id,
                'parent_content_id' => $top_middle_id,
                'order' => 1,
            ));

            // Insert content
            $db->insert('engine4_core_content', array(
                'type' => 'widget',
                'name' => 'core.content',
                'page_id' => $page_id,
                'parent_content_id' => $main_middle_id,
                'order' => 1,
            ));

            // Insert winner-last-battle
            $db->insert('engine4_core_content', array(
                'type' => 'widget',
                'name' => 'photobattle.winner-last-battle',
                'page_id' => $page_id,
                'parent_content_id' => $main_right_id,
                'order' => 9,
            ));

            // Insert photobattle.last-battle
            $db->insert('engine4_core_content', array(
                'type' => 'widget',
                'name' => 'photobattle.last-battle',
                'page_id' => $page_id,
                'parent_content_id' => $main_right_id,
                'order' => 10,
            ));

            // Insert photobattle.next-battle
            $db->insert('engine4_core_content', array(
                'type' => 'widget',
                'name' => 'photobattle.next-battle',
                'page_id' => $page_id,
                'parent_content_id' => $main_right_id,
                'order' => 11,
            ));

            // Insert top-leader
            $db->insert('engine4_core_content', array(
                'type' => 'widget',
                'name' => 'photobattle.top-leader',
                'page_id' => $page_id,
                'parent_content_id' => $main_middle_id,
                'order' => 7,
            ));
        }
    }


    protected function _addPhotobattleScorePage()
    {
        $db = $this->getDb();

        // profile page
        $page_id = $db->select()
            ->from('engine4_core_pages', 'page_id')
            ->where('name = ?', 'photobattle_index_score')
            ->limit(1)
            ->query()
            ->fetchColumn();

        // insert if it doesn't exist yet
        if (!$page_id) {
            // Insert page
            $db->insert('engine4_core_pages', array(
                'name' => 'photobattle_index_score',
                'displayname' => 'Photo Battle My Score',
                'title' => 'Photo Battle Score',
                'description' => 'Photo Battle page Score.',
                'custom' => 0,
            ));
            $page_id = $db->lastInsertId();

            // Insert top
            $db->insert('engine4_core_content', array(
                'type' => 'container',
                'name' => 'top',
                'page_id' => $page_id,
                'order' => 1,
            ));
            $top_id = $db->lastInsertId();

            // Insert main
            $db->insert('engine4_core_content', array(
                'type' => 'container',
                'name' => 'main',
                'page_id' => $page_id,
                'order' => 2,
            ));
            $main_id = $db->lastInsertId();

            // Insert top-middle
            $db->insert('engine4_core_content', array(
                'type' => 'container',
                'name' => 'middle',
                'page_id' => $page_id,
                'parent_content_id' => $top_id,
                'order' => 6,
            ));
            $top_middle_id = $db->lastInsertId();

            // Insert main-middle
            $db->insert('engine4_core_content', array(
                'type' => 'container',
                'name' => 'middle',
                'page_id' => $page_id,
                'parent_content_id' => $main_id,
                'order' => 6,
            ));
            $main_middle_id = $db->lastInsertId();

            // Insert main-left
            $db->insert('engine4_core_content', array(
                'type' => 'container',
                'name' => 'left',
                'page_id' => $page_id,
                'parent_content_id' => $main_id,
                'order' => 4,
            ));
            $main_left_id = $db->lastInsertId();


            // Insert main-right
            $db->insert('engine4_core_content', array(
                'type' => 'container',
                'name' => 'right',
                'page_id' => $page_id,
                'parent_content_id' => $main_id,
                'order' => 5,
            ));
            $main_right_id = $db->lastInsertId();

            // Insert menu
            $db->insert('engine4_core_content', array(
                'type' => 'widget',
                'name' => 'photobattle.menu-main',
                'page_id' => $page_id,
                'parent_content_id' => $top_middle_id,
                'order' => 1,
            ));

            // Insert content
            $db->insert('engine4_core_content', array(
                'type' => 'widget',
                'name' => 'core.content',
                'page_id' => $page_id,
                'parent_content_id' => $main_middle_id,
                'order' => 1,
            ));

            // Insert top 10
            $db->insert('engine4_core_content', array(
                'type' => 'widget',
                'name' => 'photobattle.gutter-photo',
                'page_id' => $page_id,
                'parent_content_id' => $main_left_id,
                'order' => 6,
            ));
        }
    }

    protected function _addPhotobattleTop10Page()
    {
        $db = $this->getDb();

        // profile page
        $page_id = $db->select()
            ->from('engine4_core_pages', 'page_id')
            ->where('name = ?', 'photobattle_index_top10')
            ->limit(1)
            ->query()
            ->fetchColumn();

        // insert if it doesn't exist yet
        if (!$page_id) {
            // Insert page
            $db->insert('engine4_core_pages', array(
                'name' => 'photobattle_index_top10',
                'displayname' => 'Photo Battle Top 10',
                'title' => 'Photo Battle Top 10',
                'description' => 'Photo Battle page Top 10.',
                'custom' => 0,
            ));
            $page_id = $db->lastInsertId();

            // Insert top
            $db->insert('engine4_core_content', array(
                'type' => 'container',
                'name' => 'top',
                'page_id' => $page_id,
                'order' => 1,
            ));
            $top_id = $db->lastInsertId();

            // Insert main
            $db->insert('engine4_core_content', array(
                'type' => 'container',
                'name' => 'main',
                'page_id' => $page_id,
                'order' => 2,
            ));
            $main_id = $db->lastInsertId();

            // Insert top-middle
            $db->insert('engine4_core_content', array(
                'type' => 'container',
                'name' => 'middle',
                'page_id' => $page_id,
                'parent_content_id' => $top_id,
                'order' => 6,
            ));
            $top_middle_id = $db->lastInsertId();

            // Insert main-middle
            $db->insert('engine4_core_content', array(
                'type' => 'container',
                'name' => 'middle',
                'page_id' => $page_id,
                'parent_content_id' => $main_id,
                'order' => 6,
            ));
            $main_middle_id = $db->lastInsertId();

            // Insert main-right
            $db->insert('engine4_core_content', array(
                'type' => 'container',
                'name' => 'right',
                'page_id' => $page_id,
                'parent_content_id' => $main_id,
                'order' => 5,
            ));
            $main_right_id = $db->lastInsertId();

            // Insert menu
            $db->insert('engine4_core_content', array(
                'type' => 'widget',
                'name' => 'photobattle.menu-main',
                'page_id' => $page_id,
                'parent_content_id' => $top_middle_id,
                'order' => 1,
            ));

            // Insert content
            $db->insert('engine4_core_content', array(
                'type' => 'widget',
                'name' => 'core.content',
                'page_id' => $page_id,
                'parent_content_id' => $main_middle_id,
                'order' => 1,
            ));

            // Insert top 10
            $db->insert('engine4_core_content', array(
                'type' => 'widget',
                'name' => 'photobattle.winner-last-battle',
                'page_id' => $page_id,
                'parent_content_id' => $main_right_id,
                'order' => 7,
            ));
        }
    }

    protected function _addPhotobattlePermissions()
    {
        //
        $db = $this->getDb();
        $levels = $db->select()
            ->from('engine4_authorization_levels', 'level_id')
            ->query()
            ->fetchAll();

        // Insert Permissions
        foreach ($levels as $level) {
            $level_id = $level['level_id'];
            //--------------------------------- view
            $permissionView = $db->select()->from('engine4_authorization_permissions')
                ->where('level_id = ?', $level_id)
                ->where('type = ?', 'photobattle')
                ->where('name = ?', 'view')
                ->limit(1)->query()->fetchAll();

            if (!count($permissionView)) {
                $db->insert('engine4_authorization_permissions', array(
                    'level_id' => $level_id,
                    'type' => 'photobattle',
                    'name' => 'view',
                    'value' => 1
                ));
            }

            //--------------------------------- vote
            $permissionVote = $db->select()->from('engine4_authorization_permissions')
                ->where('level_id = ?', $level_id)
                ->where('type = ?', 'photobattle')
                ->where('name = ?', 'vote')
                ->limit(1)->query()->fetchAll();

            if (!count($permissionVote)) {
                $db->insert('engine4_authorization_permissions', array(
                    'level_id' => $level_id,
                    'type' => 'photobattle',
                    'name' => 'vote',
                    'value' => 1
                ));
            }

            //--------------------------------- view_score
            $permissionVote = $db->select()->from('engine4_authorization_permissions')
                ->where('level_id = ?', $level_id)
                ->where('type = ?', 'photobattle')
                ->where('name = ?', 'view_score')
                ->limit(1)->query()->fetchAll();

            if (!count($permissionVote)) {
                $db->insert('engine4_authorization_permissions', array(
                    'level_id' => $level_id,
                    'type' => 'photobattle',
                    'name' => 'view_score',
                    'value' => 1
                ));
            }

            //--------------------------------- view_top10
            $permissionVote = $db->select()->from('engine4_authorization_permissions')
                ->where('level_id = ?', $level_id)
                ->where('type = ?', 'photobattle')
                ->where('name = ?', 'view_top10')
                ->limit(1)->query()->fetchAll();

            if (!count($permissionVote)) {
                $db->insert('engine4_authorization_permissions', array(
                    'level_id' => $level_id,
                    'type' => 'photobattle',
                    'name' => 'view_top10',
                    'value' => 1
                ));
            }

            //--------------------------------- stranger_score
            $permissionVote = $db->select()->from('engine4_authorization_permissions')
                ->where('level_id = ?', $level_id)
                ->where('type = ?', 'photobattle')
                ->where('name = ?', 'stranger_score')
                ->limit(1)->query()->fetchAll();

            if (!count($permissionVote)) {
                $db->insert('engine4_authorization_permissions', array(
                    'level_id' => $level_id,
                    'type' => 'photobattle',
                    'name' => 'stranger_score',
                    'value' => 1
                ));
            }

        }
    }
}

?>