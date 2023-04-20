/*
 Navicat MySQL Data Transfer

 Source Server         : Local Wamp
 Source Server Type    : MySQL
 Source Server Version : 80031
 Source Host           : localhost:3306
 Source Schema         : avalon4

 Target Server Type    : MySQL
 Target Server Version : 80031
 File Encoding         : 65001

 Date: 20/04/2023 09:06:21
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for menus
-- ----------------------------
DROP TABLE IF EXISTS `menus`;
CREATE TABLE `menus`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `label` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `icon` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `_plugin` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `prefix` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `controller` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `controller_action` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `sort_order` int NOT NULL,
  `active` tinyint UNSIGNED NOT NULL DEFAULT 1,
  `literal` tinyint UNSIGNED NOT NULL DEFAULT 0,
  `visible` tinyint UNSIGNED NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 28 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of menus
-- ----------------------------
INSERT INTO `menus` VALUES (2, 'Menus', 'fas fa-sitemap', '', 'admin', 'Menus', 'index', 905, 1, 0, 1);
INSERT INTO `menus` VALUES (3, 'Pages', 'fas fa-stream', '', 'admin', 'Pages', 'index', 906, 1, 0, 1);
INSERT INTO `menus` VALUES (13, 'Users', 'fas fa-users', 'Avalon', '', 'Users', 'index', 901, 1, 0, 1);
INSERT INTO `menus` VALUES (14, 'Roles', 'fas fa-id-badge', 'Avalon', '', 'Roles', 'index', 902, 1, 0, 1);
INSERT INTO `menus` VALUES (24, 'Dashboard', 'fas fa-columns', '', '', '', 'dashboard', 2, 1, 1, 1);

-- ----------------------------
-- Table structure for pages
-- ----------------------------
DROP TABLE IF EXISTS `pages`;
CREATE TABLE `pages`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `menu_id` int NOT NULL,
  `label` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `icon` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `_plugin` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `prefix` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `controller` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `controller_action` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `sort_order` int UNSIGNED NOT NULL,
  `active` tinyint UNSIGNED NOT NULL DEFAULT 1,
  `literal` tinyint UNSIGNED NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 15 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of pages
-- ----------------------------
INSERT INTO `pages` VALUES (1, 2, 'View All', 'fas fa-eye', '', 'admin', 'menus', 'index', 1, 1, 1);
INSERT INTO `pages` VALUES (2, 2, 'Add Menu', 'fas fa-plus', '', 'admin', 'Menus', 'add', 2, 1, 1);
INSERT INTO `pages` VALUES (3, 3, 'View All', 'fas fa-eye', '', 'admin', 'Pages', 'index', 1, 1, 1);
INSERT INTO `pages` VALUES (4, 3, 'Add Page', 'fas fa-plus', '', 'admin', 'Pages', 'add', 2, 1, 1);
INSERT INTO `pages` VALUES (7, 13, 'View All', 'fas fa-eye', '', 'avalon', 'Users', 'index', 1, 1, 1);
INSERT INTO `pages` VALUES (8, 13, 'Add User', 'fas fa-plus', NULL, 'avalon', 'Users', 'add', 2, 1, 1);
INSERT INTO `pages` VALUES (9, 14, 'View All', 'fas fa-eye', NULL, 'avalon', 'Roles', 'index', 1, 1, 1);
INSERT INTO `pages` VALUES (10, 14, 'Add Role', 'fas fa-plus', NULL, 'avalon', 'Roles', 'add', 2, 1, 1);

-- ----------------------------
-- Table structure for roles
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `label` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 20 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of roles
-- ----------------------------
INSERT INTO `roles` VALUES (1, 'Admin');
INSERT INTO `roles` VALUES (2, 'User');

-- ----------------------------
-- Table structure for user_action_logs
-- ----------------------------
DROP TABLE IF EXISTS `user_action_logs`;
CREATE TABLE `user_action_logs`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int UNSIGNED NOT NULL,
  `controller` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `controller_action` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `entity_id` int NULL DEFAULT NULL,
  `entity_display_field` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `dirty_fields` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL,
  `file_location` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 968 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for user_logins
-- ----------------------------
DROP TABLE IF EXISTS `user_logins`;
CREATE TABLE `user_logins`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int NULL DEFAULT NULL,
  `username` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `created` datetime NOT NULL,
  `success` tinyint UNSIGNED NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 24 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for user_preferences
-- ----------------------------
DROP TABLE IF EXISTS `user_preferences`;
CREATE TABLE `user_preferences`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int UNSIGNED NOT NULL,
  `user_timezone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `role_id` int UNSIGNED NOT NULL,
  `first_name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `last_name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `username` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `login_count` int NULL DEFAULT 0,
  `last_logon` datetime NULL DEFAULT NULL,
  `locked` tinyint UNSIGNED NULL DEFAULT 0,
  `reset_password` tinyint(1) NULL DEFAULT 0,
  `created` datetime NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `modified` datetime NULL DEFAULT NULL,
  `modified_by` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = DYNAMIC;

SET FOREIGN_KEY_CHECKS = 1;
