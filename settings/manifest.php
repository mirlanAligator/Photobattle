<?php return array(
    'package' =>
    array(
        'type' => 'module',
        'name' => 'photobattle',
        'version' => '4.0.0',
        'path' => 'application/modules/Photobattle',
        'title' => 'Photo Battle',
        'description' => 'Photo Battle Plugin',
        'author' => 'Mirlan',

        'callback' => array(
            'path' => 'application/modules/Photobattle/settings/install.php',
            'class' => 'Photobattle_Installer',
        ),

        'actions' =>
        array(
            0 => 'install',
            1 => 'upgrade',
            2 => 'refresh',
            3 => 'enable',
            4 => 'disable',
        ),
        'directories' =>
        array(
            0 => 'application/modules/Photobattle',
        ),
        'files' =>
        array(
            0 => 'application/languages/en/photobattle.csv',
        ),
    ),
    // Routes --------------------------------------------------------------------
    'routes' => array(
        'photobattle_general' => array(
            'route' => 'photobattle/:action/*',
            'defaults' => array(
                'module' => 'photobattle',
                'controller' => 'index',
                'action' => 'index',
            ),
        )
    ),
    // Items --------------------------------------------------------------------
    'items' => array(
        'photobattle_score',
        'photobattle_battle'
    ),

    // Hooks --------------------------------------------------------------------
    'hooks' => array(
        array(
            'event' => 'onUserUpdateAfter',
            'resource' => 'Photobattle_Plugin_Core'
        ),

        array(
            'event' => 'onUserDeleteBefore',
            'resource' => 'Photobattle_Plugin_Core',
        ),

        array(
            'event' => 'onPhotobattleBattleDeleteBefore',
            'resource' => 'Photobattle_Plugin_Core',
        ),

        array(
            'event' => 'onPhotobattleScoreDeleteBefore',
            'resource' => 'Photobattle_Plugin_Core',
        ),
    ),
); ?>