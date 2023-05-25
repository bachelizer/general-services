/*
 Navicat Premium Data Transfer

 Source Server         : general_services
 Source Server Type    : MySQL
 Source Server Version : 100424
 Source Host           : localhost:3309
 Source Schema         : generalservice

 Target Server Type    : MySQL
 Target Server Version : 100424
 File Encoding         : 65001

 Date: 16/04/2023 13:30:09
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for accounts
-- ----------------------------
DROP TABLE IF EXISTS `accounts`;
CREATE TABLE `accounts`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `accounts_user_id_foreign`(`user_id` ASC) USING BTREE,
  CONSTRAINT `accounts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of accounts
-- ----------------------------
INSERT INTO `accounts` VALUES (1, 'admin', 'admin', 2, '2022-09-07 06:02:32', '2022-09-07 06:02:32');
INSERT INTO `accounts` VALUES (2, 'student', 'student', 6, '2022-10-09 02:24:01', '2022-10-09 02:24:01');
INSERT INTO `accounts` VALUES (3, 'op', 'op', 1, '2022-10-25 08:13:09', '2022-10-25 08:13:09');
INSERT INTO `accounts` VALUES (4, 'mis', 'mis', 5, NULL, NULL);

-- ----------------------------
-- Table structure for borrows
-- ----------------------------
DROP TABLE IF EXISTS `borrows`;
CREATE TABLE `borrows`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `borrower_id` int UNSIGNED NOT NULL,
  `borrower_office_id` int UNSIGNED NULL DEFAULT NULL COMMENT 'borrower office id',
  `approver_id` int UNSIGNED NULL DEFAULT NULL,
  `mr_id` int UNSIGNED NULL DEFAULT NULL COMMENT 'm.r from',
  `office_id` int UNSIGNED NOT NULL,
  `equipment_id` int UNSIGNED NOT NULL,
  `qty` int NOT NULL,
  `purpose` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'reason for borrowing equipment',
  `rejection_remarks` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `date_borrowed` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `promise_return_date` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `date_returned` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `approval_status` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `borrows_mr_id_foreign`(`mr_id` ASC) USING BTREE,
  INDEX `borrows_borrower_office_id_foreign`(`borrower_office_id` ASC) USING BTREE,
  CONSTRAINT `borrows_borrower_office_id_foreign` FOREIGN KEY (`borrower_office_id`) REFERENCES `offices` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `borrows_mr_id_foreign` FOREIGN KEY (`mr_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of borrows
-- ----------------------------
INSERT INTO `borrows` VALUES (1, 6, 9, 5, 5, 2, 4, 1, 'gamiton', 'walay vacant', '2023-03-30', '2023-03-31', NULL, 'Rejected', '2023-03-30 08:10:59', '2023-03-30 08:12:12');

-- ----------------------------
-- Table structure for equipments
-- ----------------------------
DROP TABLE IF EXISTS `equipments`;
CREATE TABLE `equipments`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `equipment` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `maintenance_interval` int UNSIGNED NULL DEFAULT NULL COMMENT 'number of days',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 13 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of equipments
-- ----------------------------
INSERT INTO `equipments` VALUES (1, 'HP Desktop', 7);
INSERT INTO `equipments` VALUES (2, 'Cool Aircondition', 7);
INSERT INTO `equipments` VALUES (3, 'TCL', 7);
INSERT INTO `equipments` VALUES (4, 'HP laptop', 7);
INSERT INTO `equipments` VALUES (5, 'TCL 1', 7);
INSERT INTO `equipments` VALUES (6, 'Navarra', 7);
INSERT INTO `equipments` VALUES (7, 'Dell Server', 7);
INSERT INTO `equipments` VALUES (8, 'HP laptop', NULL);
INSERT INTO `equipments` VALUES (10, 'HP Mouse', 31);
INSERT INTO `equipments` VALUES (12, 'HP Monitor', 180);

-- ----------------------------
-- Table structure for inventory
-- ----------------------------
DROP TABLE IF EXISTS `inventory`;
CREATE TABLE `inventory`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `inventory_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'inventory short name',
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'inventory long name',
  `unit` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'liter, sack, bottle, box, sachet',
  `base_stock` int NOT NULL COMMENT 'base stock quantity',
  `available_stock` int NOT NULL COMMENT 'available stock quantity',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of inventory
-- ----------------------------
INSERT INTO `inventory` VALUES (1, 'test', 'test_name', 'kl', 6, 5, '2022-10-22 13:53:27', '2022-10-22 13:53:27');
INSERT INTO `inventory` VALUES (2, 'test', 'test', 'bottle', 3, 3, '2022-10-22 14:13:10', '2022-10-22 14:13:10');

-- ----------------------------
-- Table structure for maintenances
-- ----------------------------
DROP TABLE IF EXISTS `maintenances`;
CREATE TABLE `maintenances`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `request_status` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pending' COMMENT 'Pending/Declined/Approved',
  `request_by_id` int UNSIGNED NOT NULL,
  `serve_by_id` int UNSIGNED NULL DEFAULT NULL COMMENT 'who work the maintenance request',
  `serve_by_3rd_id` int UNSIGNED NULL DEFAULT NULL COMMENT 'served by 3rd party organization',
  `office_id` int UNSIGNED NOT NULL COMMENT 'office whom request',
  `office_equipment_id` int UNSIGNED NOT NULL COMMENT 'equipment within the office of requestee.',
  `service_id` int UNSIGNED NOT NULL COMMENT 'type of service',
  `reason` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `action_taken` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `remarks` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT 'remarks/recommendations',
  `equipment_status` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `date_filed` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'date requested',
  `time_start` varchar(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `time_end` varchar(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `date_served` date NULL DEFAULT NULL,
  `satisfaction` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `3rdparty_id` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `maintenances_request_by_id_foreign`(`request_by_id` ASC) USING BTREE,
  INDEX `maintenances_office_id_foreign`(`office_id` ASC) USING BTREE,
  INDEX `maintenances_office_equipment_id_foreign`(`office_equipment_id` ASC) USING BTREE,
  INDEX `maintenances_service_id_foreign`(`service_id` ASC) USING BTREE,
  INDEX `maintenances_serve_by_id_foreign`(`serve_by_id` ASC) USING BTREE,
  INDEX `maintenances_serve_by_3rd_id_foreign`(`serve_by_3rd_id` ASC) USING BTREE,
  CONSTRAINT `maintenances_office_equipment_id_foreign` FOREIGN KEY (`office_equipment_id`) REFERENCES `office_equipment` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `maintenances_office_id_foreign` FOREIGN KEY (`office_id`) REFERENCES `offices` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `maintenances_request_by_id_foreign` FOREIGN KEY (`request_by_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `maintenances_serve_by_3rd_id_foreign` FOREIGN KEY (`serve_by_3rd_id`) REFERENCES `outsources` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `maintenances_serve_by_id_foreign` FOREIGN KEY (`serve_by_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `maintenances_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of maintenances
-- ----------------------------
INSERT INTO `maintenances` VALUES (1, 'Fulfilled', 5, 2, NULL, 2, 4, 5, 'abugon', 'gi huyopan ra', 'kusog mo hoyop', NULL, '2023-03-30', '01:05', '01:05', '2023-03-30', 'Very Satisfied', '2023-03-30 08:15:49', '2023-03-30 08:17:07', NULL);

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 33 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES (1, '2019_12_14_000001_create_personal_access_tokens_table', 1);
INSERT INTO `migrations` VALUES (2, '2022_07_13_134028_create_offices_table', 1);
INSERT INTO `migrations` VALUES (3, '2022_07_13_140458_create_roles_table', 1);
INSERT INTO `migrations` VALUES (4, '2022_07_13_140711_create_users_table', 1);
INSERT INTO `migrations` VALUES (5, '2022_07_13_141647_create_accounts_table', 1);
INSERT INTO `migrations` VALUES (6, '2022_07_14_143046_create_equipment_types_table', 1);
INSERT INTO `migrations` VALUES (7, '2022_07_14_143654_create_equipments_table', 1);
INSERT INTO `migrations` VALUES (8, '2022_07_15_083303_create_services_table', 1);
INSERT INTO `migrations` VALUES (9, '2022_07_15_083304_create_office_equipment_table', 1);
INSERT INTO `migrations` VALUES (10, '2022_07_15_083305_create_maintenances_table', 1);
INSERT INTO `migrations` VALUES (11, '2022_07_15_084639_create_borrows_table', 1);
INSERT INTO `migrations` VALUES (12, '2022_07_16_232920_add_culomn_office_equipment', 1);
INSERT INTO `migrations` VALUES (13, '2022_07_17_091537_update_maintenances_table', 1);
INSERT INTO `migrations` VALUES (14, '2022_08_25_134446_add_coluomn_to_maintenances', 1);
INSERT INTO `migrations` VALUES (15, '2022_08_25_140003_update_coluomn_to_maintenances', 1);
INSERT INTO `migrations` VALUES (16, '2022_08_27_132954_update_borrows_table', 1);
INSERT INTO `migrations` VALUES (17, '2022_08_27_135249_update_borrows_table', 1);
INSERT INTO `migrations` VALUES (18, '2022_08_30_034754_update_borrows_column', 1);
INSERT INTO `migrations` VALUES (19, '2022_08_30_040304_update_borrows_column', 1);
INSERT INTO `migrations` VALUES (20, '2022_09_04_140236_add_maintenances_column', 1);
INSERT INTO `migrations` VALUES (21, '2022_09_06_072417_add_users_column', 2);
INSERT INTO `migrations` VALUES (22, '2022_09_07_071251_drop_foreign_key_equipments', 2);
INSERT INTO `migrations` VALUES (23, '2022_09_07_071858_drop_table_equipments_type', 2);
INSERT INTO `migrations` VALUES (24, '2022_10_14_063338_update_table_equipments', 2);
INSERT INTO `migrations` VALUES (25, '2022_10_17_082721_add_column_office_equipment', 2);
INSERT INTO `migrations` VALUES (26, '2022_10_20_131510_create_inventory_table', 2);
INSERT INTO `migrations` VALUES (27, '2022_11_14_035352_add_table_outsoure', 2);
INSERT INTO `migrations` VALUES (28, '2022_11_14_040012_add_column_maintenances', 2);
INSERT INTO `migrations` VALUES (29, '2023_03_29_081321_add_column_table_borrows', 3);
INSERT INTO `migrations` VALUES (30, '2023_03_30_005554_add_column_table_borrowa', 4);
INSERT INTO `migrations` VALUES (31, '2023_03_30_011319_add_column_table_borrows', 5);
INSERT INTO `migrations` VALUES (32, '2023_03_30_012057_add_column_table_borrows', 6);

-- ----------------------------
-- Table structure for office_equipment
-- ----------------------------
DROP TABLE IF EXISTS `office_equipment`;
CREATE TABLE `office_equipment`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `office_id` int UNSIGNED NOT NULL COMMENT 'office location',
  `user_id` int UNSIGNED NOT NULL COMMENT 'property custodian',
  `equipment_id` int UNSIGNED NOT NULL,
  `code` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `serial` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` decimal(10, 2) NOT NULL,
  `status` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `supplier` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_disposed` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `maintained_by` int UNSIGNED NULL DEFAULT NULL COMMENT 'base days for regular maintenance, from equipment maintenance_interval',
  `days_maintenance` int UNSIGNED NULL DEFAULT NULL COMMENT 'base days for regular maintenance, from equipment maintenance_interval',
  `maintenance_day` int UNSIGNED NULL DEFAULT NULL COMMENT 'days remaining fro regualr maintenance',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `action_taken` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT 'action taken on regular maintenance',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `office_equipment_office_id_foreign`(`office_id` ASC) USING BTREE,
  INDEX `office_equipment_user_id_foreign`(`user_id` ASC) USING BTREE,
  INDEX `office_equipment_equipment_id_foreign`(`equipment_id` ASC) USING BTREE,
  INDEX `office_equipment_maintained_by_foreign`(`maintained_by` ASC) USING BTREE,
  CONSTRAINT `office_equipment_equipment_id_foreign` FOREIGN KEY (`equipment_id`) REFERENCES `equipments` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `office_equipment_maintained_by_foreign` FOREIGN KEY (`maintained_by`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `office_equipment_office_id_foreign` FOREIGN KEY (`office_id`) REFERENCES `offices` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `office_equipment_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of office_equipment
-- ----------------------------
INSERT INTO `office_equipment` VALUES (1, 3, 1, 3, 'TCL-01', 'SR-12345', 50000.00, '', 'TCL Corp', NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `office_equipment` VALUES (2, 1, 1, 1, 'code number', 'serial number', 10000.00, 'working', 'city build', NULL, NULL, 7, 3, '2022-07-17 07:53:24', '2022-07-17 07:53:24', NULL);
INSERT INTO `office_equipment` VALUES (3, 1, 3, 7, 'Dell Server X1', '000123', 10.00, 'working', 'Dell Inc.', NULL, 3, 7, 7, '2022-09-10 12:40:29', '2022-10-20 12:41:22', 'sasas');
INSERT INTO `office_equipment` VALUES (4, 2, 5, 1, 'HP Desktop 01', '000122', 17.00, 'working', 'Data Land', NULL, 2, 7, 7, '2022-09-10 12:42:36', '2022-10-20 12:36:08', 'sasa');
INSERT INTO `office_equipment` VALUES (5, 1, 2, 12, 'HP Monitor x21', '1544asd561', 1000.00, 'working', 'Ako', NULL, NULL, 180, 177, '2022-10-14 08:37:42', '2022-10-14 08:37:42', NULL);
INSERT INTO `office_equipment` VALUES (6, 1, 2, 4, 'aadasd', 'sgsg', 10000.00, 'working', 'asf', NULL, NULL, 7, 4, '2022-10-14 08:39:49', '2022-10-14 08:39:49', NULL);
INSERT INTO `office_equipment` VALUES (7, 1, 3, 2, 'gsfg', 'sdg', 12345.00, 'working', 'sfsdf', NULL, NULL, NULL, 7, '2022-11-14 08:07:42', '2022-11-14 08:07:42', NULL);

-- ----------------------------
-- Table structure for offices
-- ----------------------------
DROP TABLE IF EXISTS `offices`;
CREATE TABLE `offices`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `office` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of offices
-- ----------------------------
INSERT INTO `offices` VALUES (1, 'General Sevices');
INSERT INTO `offices` VALUES (2, 'Managemnent Information System');
INSERT INTO `offices` VALUES (3, 'Office of the President');
INSERT INTO `offices` VALUES (4, 'Office of the Vice - President');
INSERT INTO `offices` VALUES (5, 'Planning Office');
INSERT INTO `offices` VALUES (6, 'VP-Admin');
INSERT INTO `offices` VALUES (7, 'Registrars Office');
INSERT INTO `offices` VALUES (8, 'Office of Students Affair');
INSERT INTO `offices` VALUES (9, 'Srudent Bodies');
INSERT INTO `offices` VALUES (10, 'Dingdong Services');

-- ----------------------------
-- Table structure for outsources
-- ----------------------------
DROP TABLE IF EXISTS `outsources`;
CREATE TABLE `outsources`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `institution_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of outsources
-- ----------------------------
INSERT INTO `outsources` VALUES (1, 'A&A Services', 'Mr. A B C');
INSERT INTO `outsources` VALUES (2, 'J@T Cleaning Services', 'Mr. John Tall');

-- ----------------------------
-- Table structure for personal_access_tokens
-- ----------------------------
DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE `personal_access_tokens`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `personal_access_tokens_token_unique`(`token` ASC) USING BTREE,
  INDEX `personal_access_tokens_tokenable_type_tokenable_id_index`(`tokenable_type` ASC, `tokenable_id` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of personal_access_tokens
-- ----------------------------

-- ----------------------------
-- Table structure for roles
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `role` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of roles
-- ----------------------------
INSERT INTO `roles` VALUES (1, 'Super Admin');
INSERT INTO `roles` VALUES (2, 'Admin');
INSERT INTO `roles` VALUES (3, 'User');

-- ----------------------------
-- Table structure for services
-- ----------------------------
DROP TABLE IF EXISTS `services`;
CREATE TABLE `services`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `service` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of services
-- ----------------------------
INSERT INTO `services` VALUES (1, 'Repair');
INSERT INTO `services` VALUES (2, 'Installment');
INSERT INTO `services` VALUES (3, 'Maintenance');
INSERT INTO `services` VALUES (4, 'Replacement');
INSERT INTO `services` VALUES (5, 'General Cleaning');
INSERT INTO `services` VALUES (6, 'Transfer of Equipment');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `designation` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `middle_name` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `suffix` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `office_id` int UNSIGNED NOT NULL,
  `role_id` int UNSIGNED NOT NULL,
  `has_acount` tinyint(1) NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `users_office_id_foreign`(`office_id` ASC) USING BTREE,
  INDEX `users_role_id_foreign`(`role_id` ASC) USING BTREE,
  CONSTRAINT `users_office_id_foreign` FOREIGN KEY (`office_id`) REFERENCES `offices` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, 'MR', 'OP', 'Personel', 'O', NULL, 3, 1, NULL, '2022-10-25 08:13:16', '0000-00-00 00:00:00');
INSERT INTO `users` VALUES (2, 'Mr', 'General', 'Services', 'GS', NULL, 1, 1, NULL, NULL, '0000-00-00 00:00:00');
INSERT INTO `users` VALUES (3, 'Engr.', 'Test Last Name', 'Test First Name', 'Test Miiddle Name', NULL, 1, 1, 1, '2022-09-06 07:41:27', '0000-00-00 00:00:00');
INSERT INTO `users` VALUES (4, 'MR', 'Doe', 'JHon', 'Aa', NULL, 8, 3, 1, '2022-09-06 09:02:15', '0000-00-00 00:00:00');
INSERT INTO `users` VALUES (5, 'Mrs', 'Baluis', 'Irene', 'C', NULL, 2, 3, 1, '2022-09-10 12:41:50', '0000-00-00 00:00:00');
INSERT INTO `users` VALUES (6, 'Ms', 'Torralba', 'Name', 'A', NULL, 9, 3, 1, '2022-10-09 02:23:01', '0000-00-00 00:00:00');
INSERT INTO `users` VALUES (7, 'Mr', 'Services', 'DingDong', '.', NULL, 10, 3, 1, '2022-11-14 03:27:04', '0000-00-00 00:00:00');

-- ----------------------------
-- Event structure for update_maintenance_day
-- ----------------------------
DROP EVENT IF EXISTS `update_maintenance_day`;
delimiter ;;
CREATE EVENT `update_maintenance_day`
ON SCHEDULE
EVERY '1' DAY STARTS '2022-10-14 16:55:49'
COMMENT 'Minus 1 on maitenance day'
DO BEGIN
	    UPDATE office_equipment SET maintenance_day = maintenance_day - 1 WHERE maintenance_day != 0;
	END
;;
delimiter ;

SET FOREIGN_KEY_CHECKS = 1;
