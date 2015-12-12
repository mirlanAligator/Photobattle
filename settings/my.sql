-- Menus
INSERT IGNORE INTO `engine4_core_menus` (`name`, `type`, `title`, `order`) VALUES  ('photobattle_main', 'standard', 'Photo Battle Navigation Menu', 999) ;

-- Menu items
INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `enabled`, `custom`, `order`) VALUES
('core_main_photobattle', 'photobattle', 'Photo Battle', '', '{"route":"photobattle_general"}', 'core_main', '', 1, 0, 4),
('photobattle_main_battle', 'photobattle', 'Battle', 'Photobattle_Plugin_Menus::canViewPhotobattle', '{"route":"photobattle_general"}', 'photobattle_main', '', 1, 0, 1),
('photobattle_main_myscore', 'photobattle', 'My Score', 'Photobattle_Plugin_Menus::canMyScorePhotobattle', '{"route":"photobattle_general", "action":"score"}', 'photobattle_main', '', 1, 0, 2),
('core_admin_main_plugins_photobattle', 'photobattle', 'Photo Battle', '', '{"route":"admin_default","module":"photobattle","controller":"index"}', 'core_admin_main_plugins', '', 1, 0, 999),
('photobattle_admin_main_manage', 'photobattle', 'View Battles', '', '{"route":"admin_default","module":"photobattle","controller":"index","action":"index"}', 'photobattle_admin_main', '', 1, 0, 1),
('photobattle_admin_main_level', 'photobattle', 'Member Level Settings', '', '{"route":"admin_default","module":"photobattle","controller":"index","action":"level"}', 'photobattle_admin_main', '', 1, 0, 3),
('photobattle_admin_main_score', 'photobattle', 'View Scores', '', '{"route":"admin_default","module":"photobattle","controller":"index","action":"score"}', 'photobattle_admin_main', '', 1, 0, 2),
('photobattle_main_top10', 'photobattle', 'Top 10', 'Photobattle_Plugin_Menus::canTop10Photobattle', '{"route":"photobattle_general", "action":"top10"}', 'photobattle_main', '', 1, 0, 4);

-- Table engine4_photobattle_battles
CREATE TABLE `engine4_photobattle_battles` (
	`battle_id` INT(11) NOT NULL AUTO_INCREMENT,
	`voter_id` INT(11) NOT NULL,
	`player1_id` INT(11) NOT NULL,
	`player2_id` INT(11) NOT NULL,
	`win_id` INT(11) NOT NULL,
	`score_expense` INT(11) NOT NULL,
	`battle_hash` VARCHAR(100) NOT NULL COLLATE 'latin1_swedish_ci',
	`battle_date` DATETIME NOT NULL,
	PRIMARY KEY (`battle_id`),
	INDEX `battle_hash` (`battle_hash`),
	INDEX `voter_id` (`voter_id`),
	INDEX `player1_id` (`player1_id`),
	INDEX `player2_id` (`player2_id`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
AUTO_INCREMENT=1
;

-- Table engine4_photobattle_scores
CREATE TABLE `engine4_photobattle_scores` (
	`score_id` INT(11) NOT NULL AUTO_INCREMENT,
	`user_id` INT(11) NOT NULL,
	`photo_id` INT(11) NOT NULL,
	`scores` INT(11) NOT NULL,
	`percent` INT(11) NOT NULL,
	`win` INT(11) NOT NULL,
	`loss` INT(11) NOT NULL,
	PRIMARY KEY (`score_id`),
	UNIQUE INDEX `user_id` (`user_id`),
	INDEX `photo_id` (`photo_id`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
AUTO_INCREMENT=1
;


