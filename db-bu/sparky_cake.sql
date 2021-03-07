-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 14, 2018 at 02:08 PM
-- Server version: 5.6.38
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sparky_cake`
--

-- --------------------------------------------------------

--
-- Table structure for table `twiz_configuration`
--

CREATE TABLE `twiz_configuration` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `value` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `twiz_configuration`
--

INSERT INTO `twiz_configuration` (`id`, `name`, `value`) VALUES
(1, 'website_name', 'Thoroughwiz'),
(2, 'website_url', 'https://www.twizfigs.com'),
(3, 'email', 'support@thoroughwiz.com'),
(4, 'activation', 'true'),
(5, 'resend_activation_threshold', '0'),
(6, 'language', 'models/languages/en.php'),
(7, 'template', 'models/site-templates/default.css');

-- --------------------------------------------------------

--
-- Table structure for table `twiz_filters`
--

CREATE TABLE `twiz_filters` (
  `id` int(11) NOT NULL,
  `userid` int(10) NOT NULL,
  `filtername` varchar(25) CHARACTER SET utf8 NOT NULL,
  `troublelines` varchar(3) CHARACTER SET utf8 NOT NULL,
  `offtracks` varchar(3) CHARACTER SET utf8 NOT NULL,
  `samesur` varchar(3) CHARACTER SET utf8 NOT NULL,
  `maxraces` int(2) NOT NULL,
  `finpos` int(2) NOT NULL,
  `todaydistminus` int(3) NOT NULL,
  `todaydistplus` int(3) NOT NULL,
  `maxdays` int(4) NOT NULL,
  `parttimeodds` int(3) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `twiz_filters`
--

INSERT INTO `twiz_filters` (`id`, `userid`, `filtername`, `troublelines`, `offtracks`, `samesur`, `maxraces`, `finpos`, `todaydistminus`, `todaydistplus`, `maxdays`, `parttimeodds`) VALUES
(1, 0, 'default', 'no', 'no', 'no', 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `twiz_pages`
--

CREATE TABLE `twiz_pages` (
  `id` int(11) NOT NULL,
  `page` varchar(150) NOT NULL,
  `private` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `twiz_pages`
--

INSERT INTO `twiz_pages` (`id`, `page`, `private`) VALUES
(1, 'account.php', 1),
(2, 'activate-account.php', 0),
(3, 'admin_configuration.php', 1),
(5, 'admin_pages.php', 1),
(7, 'admin_permissions.php', 1),
(9, 'admin_users.php', 1),
(10, 'forgot-password.php', 0),
(11, 'index.php', 0),
(13, 'login.php', 0),
(15, 'register.php', 0),
(16, 'resend-activation.php', 0),
(22, 'about.php', 0),
(27, 'contact.php', 0),
(28, 'faq.php', 0),
(29, 'footer.php', 0),
(31, 'header.php', 0),
(35, 'page_admin.php', 1),
(38, 'privacy.php', 0),
(43, 'style_block.php', 0),
(46, 'terms.php', 0),
(47, 'meta.php', 0),
(73, 'user-login.php', 0),
(74, 'user-register.php', 0),
(78, 'product_admin.php', 1),
(79, 'logout.php', 1),
(80, 'admin_user.php', 1),
(81, 'admin_page.php', 1),
(82, 'admin_permission.php', 1),
(83, 'access.php', 1),
(84, 'product.php', 1),
(85, 'single-access.php', 1),
(86, 'single-product.php', 1),
(87, 'user_charge.php', 1),
(88, 'user_charge_subscription.php', 1),
(90, 'user_cancel_subscription.php', 0),
(93, 'user-forgot-password.php', 0),
(95, 'user-resend-activation.php', 0),
(99, 'user-update-account.php', 0),
(100, 'user_charge_package_10.php', 0),
(101, 'confirm-password.php', 0),
(102, 'deny-password.php', 0),
(103, 'contact-submit.php', 0),
(105, 'user-profile.php', 1),
(114, 'product_free_sample.php', 0),
(115, 'user-delete-sheets.php', 1),
(116, 'page_admin_harness.php', 1),
(117, 'product_admin_harness.php', 1),
(118, 'promo-access.php', 1),
(119, 'promo-product.php', 0),
(126, 'upload_admin_harness.php', 0),
(129, 'filtersDump.php', 0),
(131, 'assets.php', 1),
(132, 'modals.php', 0),
(133, 'test.php', 0);

-- --------------------------------------------------------

--
-- Table structure for table `twiz_permissions`
--

CREATE TABLE `twiz_permissions` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `access_level` varchar(50) NOT NULL,
  `description` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `twiz_permissions`
--

INSERT INTO `twiz_permissions` (`id`, `name`, `access_level`, `description`) VALUES
(1, 'Administrator', 'Administrative Access', 'Full application control.  Modify all accounts.'),
(2, 'Base Member', 'Base Access', 'Single purchase option.  Modify own account.'),
(3, 'Subscription Member', 'Subscription Access', 'Unlimited sheet access.  Modify own account.'),
(4, 'Quickie', 'Temporary Access', 'Access granted to base members for a one-time sheet process.'),
(5, 'Developer', 'Development Areas', 'A playground for the developers of this site.');

-- --------------------------------------------------------

--
-- Table structure for table `twiz_permission_page_matches`
--

CREATE TABLE `twiz_permission_page_matches` (
  `id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  `page_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `twiz_permission_page_matches`
--

INSERT INTO `twiz_permission_page_matches` (`id`, `permission_id`, `page_id`) VALUES
(8, 1, 1),
(9, 1, 35),
(10, 1, 3),
(11, 1, 5),
(12, 1, 7),
(13, 1, 9),
(52, 1, 80),
(53, 1, 81),
(54, 1, 82),
(55, 2, 1),
(56, 3, 1),
(58, 2, 87),
(59, 1, 78),
(60, 4, 85),
(61, 4, 86),
(62, 3, 83),
(63, 3, 84),
(64, 1, 79),
(65, 2, 79),
(66, 3, 79),
(67, 4, 79),
(69, 2, 88),
(70, 4, 1),
(71, 4, 87),
(72, 4, 88),
(74, 2, 83),
(75, 1, 105),
(76, 2, 105),
(77, 3, 105),
(78, 4, 105),
(79, 1, 115),
(80, 2, 115),
(81, 3, 115),
(82, 1, 116),
(83, 1, 117),
(88, 1, 83),
(89, 1, 84),
(90, 1, 85),
(91, 1, 86),
(92, 1, 87),
(93, 1, 88),
(94, 1, 118),
(95, 1, 131),
(96, 5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `twiz_users`
--

CREATE TABLE `twiz_users` (
  `id` int(11) NOT NULL,
  `password` varchar(225) NOT NULL,
  `email` varchar(150) NOT NULL,
  `activation_token` varchar(225) NOT NULL,
  `last_activation_request` int(11) NOT NULL,
  `lost_password_request` tinyint(1) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `title` varchar(150) NOT NULL,
  `sign_up_stamp` int(11) NOT NULL,
  `last_sign_in_stamp` int(11) NOT NULL,
  `pay_status` tinyint(1) NOT NULL DEFAULT '0',
  `trial` tinyint(1) NOT NULL DEFAULT '0',
  `stripe_id` varchar(20) NOT NULL DEFAULT '0',
  `plan_id` varchar(20) NOT NULL DEFAULT '0',
  `pass_change` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `twiz_users`
--

INSERT INTO `twiz_users` (`id`, `password`, `email`, `activation_token`, `last_activation_request`, `lost_password_request`, `active`, `title`, `sign_up_stamp`, `last_sign_in_stamp`, `pay_status`, `trial`, `stripe_id`, `plan_id`, `pass_change`) VALUES
(8, '67d22476cde447971c3b8aef8040191dd9457c6a76e18755f54a894b2f3c11e27', 'sparkhw@gmail.com', '0fa09a4a8c44580cc71ca515c04a35b0', 1457196042, 0, 1, 'Administrator', 1457196042, 1523466658, 0, 0, '0', '0', 0),
(28, 'bf2759e336dc33cb30e05b6e0639b08e47850adc375c74251d7d9020139b44057', 'kimmi1211@gmail.com', 'f0cf49d605779dd4b72f9dc6f1a148c2', 1462571248, 0, 1, 'Base Member', 1462571248, 1462928477, 0, 0, 'cus_8P50VFGdy906XJ', '0', 0),
(29, '6857a10af2dedca1ec470f5ef0eecd9fc249175847dd48a05a7e787e6457f42a8', 'mistylwood@gmail.com', 'f74c38fb970d3442329bd748b37d1463', 1462577416, 0, 1, 'Base Member', 1462577416, 1510241189, 0, 0, 'cus_BjlVzpZwlfqZyG', '0', 1),
(31, '873dc876e0880588cb4bfb84ba4dae976a38364df4e5ff2786b52a522bee43bc7', 'wsfrazier61@gmail.com', 'e6ea815d9a2a4085e7120e32f76d916d', 1462584795, 0, 1, 'Base Member', 1462584795, 1465619801, 0, 0, 'cus_8P8kG1GOjU60S5', '0', 0),
(32, '0e63de3952be6681e15b9f04268efc7bce8c9ad113476bebc602b03b88b6b190f', 'dwood@lcrhelp.com', '2ef6b25dde28a93eb34c0574725b7f0a', 1462584864, 0, 1, 'Administrator', 1462584864, 1523640824, 0, 0, 'cus_8P8ffDMm9a1eTz', '0', 0),
(33, 'dd5322614e466b9701f2121d693778ac812912d9f8b0e75c6da3264270c88c0b8', 'georgecovino865@yahoo.com', '052b370cba6bca5087559b696d86a139', 1463743363, 0, 1, 'Base Member', 1463743363, 1481978825, 0, 0, '0', '0', 0),
(34, '662c0e57166e87321d0c5d32e6bdcf093cd355887d50b2dfc65446d482def4241', 'jkyser2@gmail.com', 'ea812151e186216d7bd0e4c5479c7813', 1464909360, 0, 1, 'Base Member', 1464909360, 1464909418, 0, 0, '0', '0', 0),
(35, 'be87c614548abe6559ebec0966059a2797210ff40b4f641d2d2ca3569adfec680', 'jd.deson@gmail.com', '677ca47fa4f186668b97c726ec7b6813', 1465139585, 0, 1, 'Base Member', 1465139585, 1522506757, 0, 0, 'cus_8aE8nrDLzZyT9p', '0', 0),
(36, '8375a4ae7b44bf18c163de9c26b781dbb70bdb64339ce80f522d4296570ed6b46', 'dailyr0318@gmail.com', '7fd922f29d3157bd67538a9de62b7570', 1465681938, 0, 1, 'Base Member', 1465681938, 1465682161, 0, 0, '0', '0', 0),
(37, '29a8e354ba9d65f94906c0f6e029019c43c78206f1688b8b509696b2aca5bd0bb', 'hal102@cox.net', 'e621652b73de0fa5466bfcfc4c118d48', 1465787679, 0, 1, 'Base Member', 1465787679, 1465787778, 0, 0, '0', '0', 0),
(38, 'ac1596d5f6941689e421f4c37984881b44d710279306b0ef15082208383903ea5', 'pmj61@aol.com', 'ed67fb5fa367090a290b58612d312d7b', 1466433083, 0, 0, 'Base Member', 1466433083, 0, 0, 0, '0', '0', 0),
(39, 'fcf062c01e2027abefebf9499408b38654dc9211dfad5dbbb7981303415db0dd1', 'haroonr25@hotmail.com', '16d5309affa18800691971e1c78f3593', 1466875990, 0, 0, 'Base Member', 1466875990, 0, 0, 0, '0', '0', 0),
(40, '9a93783b61880a973b1c876acd5650f62fa231d7fc205e8cf69cd1e8a9aed703b', 'toad42@sbcglobal.net', '994872ffdfc88636b13dbd6d36b18ad3', 1466975955, 0, 1, 'Base Member', 1466975955, 1466976002, 0, 0, '0', '0', 0),
(41, '54fc7740f074a26707354c8395af9f54f2cbbfab6f3b7a2a8c7638518f5e64e7d', 'cncontractingcorp@yahoo.com', '7df98271310934d8c93efd14895b8aed', 1468211732, 0, 1, 'Base Member', 1468211732, 1479824676, 0, 0, '0', '0', 0),
(42, 'eb18a15665dcee55ca6e4f3c24e15cc1962e572e18717bdce605897b00fbb8c3d', 'philb561@gmail.com', 'ca5b1de4425892a79f489424000fbe57', 1468265866, 0, 1, 'Base Member', 1468265866, 1468265996, 0, 0, '0', '0', 0),
(43, '4eb565637826cf4c4bac5213dfb045255da5bc0db24bc162fbba2252dc3e79d98', 'jerryone@peoplepc.com', 'da482c759d06142a51d1e2e9132333a2', 1468521048, 0, 1, 'Base Member', 1468521048, 1468693014, 0, 0, '0', '0', 0),
(44, 'a52d2a8a037bc303b63292bf2ee44067c79661d98a3bf96dc89ea41e4cfbbc22e', 'eveandlarry@aol.com', 'd9755459620b44b9c40c1ca3f6586bee', 1468661844, 0, 0, 'Base Member', 1468661844, 0, 0, 0, '0', '0', 0),
(45, '5be93bf6ab6e46e38c3eadc9ed67b6519d08db6fef81e09983b4b97c7977752e8', 'jerry.gossett2@gmail.com', 'b2914366290ec8e7efc52f2165b0c491', 1469456514, 0, 1, 'Base Member', 1469456514, 1470173868, 0, 0, '0', '0', 0),
(46, '5f26857e8ac824cda14138408d2d64b5975a25f9b712d80b309ca05aaf8d232e1', 'asparco803@yahoo.com', '285ee925314579b311f988b46a807c82', 1469619104, 0, 1, 'Base Member', 1469619104, 1469620348, 0, 0, '0', '0', 0),
(47, 'cee79fc5464a437ff7cf44ac84ae57b870afc851a468d0596538f4b260d9069b3', 'mcmike924@aol.com', '29f7334e81039041e77648333a4d446d', 1471205307, 0, 1, 'Base Member', 1471205307, 1471205411, 0, 0, '0', '0', 0),
(48, 'dd57c5bcf5b6c152e688f44cf884e2895121c8d929347d96a37a83390491aa205', 'angelocurry@gmail.com', 'c77156affd577efb8dbe354bd49e4aa0', 1472397022, 0, 1, 'Base Member', 1472397022, 1472397077, 0, 0, '0', '0', 0),
(49, '78bdbe2b98baaf9d6fd49da9d4938dfafe2136754111f99eaf04527fdf5ea682c', 'blueskies7@aol.com', '4504118190386efcf176f32c53329462', 1472871827, 0, 1, 'Base Member', 1472871061, 1473121292, 0, 0, 'cus_97jyzrUkZa1eZY', '0', 0),
(50, '350b1b1120253f1777e8c088c007fd47b952fc5bb9b3a6d2ff6a1f76338805ada', 'curazao300@gmail.com', '52ce0b32e74517d6a769baa2d3786c65', 1473024224, 0, 0, 'Base Member', 1473024224, 0, 0, 0, '0', '0', 0),
(51, '143a9ac28d2b2a39fac7e670da7a43561454b69dfb9306bca6908be27be56b627', 'lisacannon2601@gmail.com', '4426c16e7420d99e8e08e12bb88b8b37', 1473029279, 0, 1, 'Base Member', 1473029279, 1473031646, 0, 0, 'cus_98QUL3PUglTyzB', '0', 0),
(52, 'ac5345184ee316fbb6463104e04a213e65821dfd537f4bb583fd7e21047d9f4c1', 'hunterpao@yahoo.com', 'e2f258a725137ed3049f20295dec19c7', 1473982414, 0, 1, 'Base Member', 1473982414, 1497905684, 0, 0, 'cus_9DK9sj3jVgNQQW', '0', 0),
(53, 'bf7932c3f5b9cd39b89ca7101e2353d968bd17ac48e8d15ad33ab8c6cfa81f885', 'avine@verizon.net', '6c274ccbbfedb55a860d5c9c2804d165', 1474665453, 0, 1, 'Base Member', 1474665453, 1474665540, 0, 0, '0', '0', 0),
(54, '53cf4b118a6ca50b00b30bed4f994700e87794be8886776686478c184ce47abc7', 'dezme12@gmail.com', '9c962af9a6ecf3f8905ba4accd264da0', 1474810996, 0, 1, 'Base Member', 1474810996, 1497739771, 0, 0, 'cus_9G9TPsyrLh1Rnq', '0', 0),
(55, 'd5662360b83788bd4a3ea2a266101c22340997cbc84a962012b28d8ab62303a2a', 'lwthomas3@verizon.net', '84fa4158112e085793a77dbc71fe44db', 1475293681, 0, 1, 'Base Member', 1475293681, 1521124928, 0, 0, 'cus_9IF51n3J6FNXwJ', '0', 0),
(56, 'bfcfed98f96f32f4a638b7f79ee383db45abe18ba2580d85672974e34aa761eeb', 'budroyale@hotmail.com', 'a8060d74d783b1721f37204a1a6fce4f', 1476211981, 0, 1, 'Base Member', 1476211981, 1476212330, 0, 0, '0', '0', 0),
(57, 'd5fabbc5f99396c02aa8619efba8fa71f1b6e8149a5a9d146bba1200e67e20e19', 'terrygolf1313@gmail.com', 'c4fd850b8f844316e4810095f6b24e23', 1477831591, 0, 1, 'Base Member', 1477831591, 1478021760, 0, 0, '0', '0', 0),
(58, 'e4938715d465880f6b0ca1299e2060023c8e03f80054908ad1eb2f11eb3f3eda2', 'naskorhan@live.com', 'a228e89d0d0b486083c02fa1bef5be7d', 1481238831, 0, 0, 'Base Member', 1481238831, 0, 0, 0, '0', '0', 0),
(59, 'b372272e1d70d769a8e79af0fec91ee9689c32f95a1ac29810e8ecb1a8466a6c8', 'britoandresss@gmail.com', '8fb6a0f3ae2a021cdfbde0eeb8715a40', 1485250337, 0, 1, 'Base Member', 1485250337, 1485610232, 0, 0, '0', '0', 0),
(60, 'f47e5319eaf3555d0bac429aa35ab010de195679ef33be64c7fa3ee76a95f2d26', 'aljomomar@hotmail.com', 'f33132a99b33defcc0450a4444717efb', 1485395835, 0, 1, 'Base Member', 1485395835, 1485396108, 0, 0, '0', '0', 0),
(61, '85ae2a9bb62390b8176b02ead836f78bb95090781ce30a459b0c440c8d7f138d7', 'crisante123@comcast.net', '9740d3cbef50ea9a324a8f1765aa4ece', 1486423796, 0, 1, 'Base Member', 1486423796, 1486423915, 0, 0, '0', '0', 0),
(62, 'f71f65b9de89192e848a0bee8ee4f5daea9f420cfb95781796baad5ff086b21c0', 'darrell_tvedt@msn.com', '239f08d1f93d002e18f6e2503b8d034a', 1488930633, 0, 0, 'Base Member', 1488930633, 0, 0, 0, '0', '0', 0),
(63, '6b117a0aad5cf08fdeacb8008e82b90934e87b8849af3d11245783f47934e4f76', 'csantillan46@gmail.com', 'd4ab68edf7e1696134f81b785d19e207', 1489130476, 0, 1, 'Base Member', 1489130476, 1489186405, 0, 0, 'cus_AGTU9maaRs0U4a', '0', 0),
(64, '7a9a290ea0b7bfecc235743bae15226d954af5cbe1033ab5dd8624edc5948f331', 'zackmorrissmith@gmail.com', '4da2805532497349844e2d51dda7ea33', 1489159973, 0, 0, 'Base Member', 1489159973, 0, 0, 0, '0', '0', 0),
(65, '793695f56d806cf01e500e3473077dab7d43323458821883f898a9b37ba9522db', 'j.arsanis1943@icloud.com', 'bf46cd8fc5af279f7408cbf40c36e0cc', 1491645345, 0, 1, 'Base Member', 1491645345, 1491645894, 0, 0, '0', '0', 0),
(66, 'e86184f959ac10ceea8e8db4b4994cc142ec9300e6d053a22a4d3c60fb1b8581b', 'melvynarthur@gmail.com', 'ff7b403de4394324c50d580fe2edfe52', 1491869140, 0, 1, 'Base Member', 1491869140, 1491869564, 0, 0, '0', '0', 0),
(67, '48491cad9a5f1369da96d7f9eb252d6d584b594802379a20c64b9f72ceda6396f', 'hesnotmypres@yahoo.com', 'f86d9cb94a9014b174a48c60d0ba742e', 1492723162, 0, 1, 'Base Member', 1492723162, 1492780514, 0, 0, '0', '0', 0),
(68, '57f158a752835c73d074f014f864c0cb6392a341dd16ae2ca5c1de1f470c86605', 'josegagui_2007@yahoo.com', '14c3bec947ccae43e07d6d8d73a3ef3b', 1493034897, 0, 1, 'Base Member', 1493034897, 1493088506, 0, 0, 'cus_AXADmKniKvvYWA', '0', 0),
(69, '2a6cc8c1da6346979674aaffdb86c302f6b99fe1d1f6485bea04eff399def1057', 'john.friedrich1240@gmail.com', '277da5f3ed4e47f9493057cd2375fd1a', 1493938761, 0, 0, 'Base Member', 1493938761, 0, 0, 0, '0', '0', 0),
(70, '46e33a35785d8b7e2162e4b74e3ab64e6938220a0aaf745b1f20911349f011eb6', 'buckwild@cox.net', '97040273042eea2620246789c65951f2', 1494258068, 0, 1, 'Base Member', 1494258068, 1494258293, 0, 0, '0', '0', 0),
(71, '86d3d3a974c75c6c36aea4588506f9fe8518f5265d7346152d118ade0bc21b868', 'anawolski@printexdirect.com', 'f9d79043e9486d1b47a98f953ce7c92c', 1496316935, 0, 1, 'Base Member', 1496316935, 1523415401, 0, 0, 'cus_AlOU7waZYcDOWZ', '0', 0),
(72, 'c43df42f3ebf5f41cb3483c4ed7973fed2c171d051e10fa2c04f389e611f6b322', 'carmine789@outlook.com', 'b076b6837696da4205813856acbc46f0', 1497192682, 0, 0, 'Base Member', 1497192682, 0, 0, 0, '0', '0', 0),
(73, '8d66d10070801fb0423920e0b2778dfca6bb8f56519d7b81254edb3331f8114a1', 'scottquinngb5@gmail.com', 'aa417c445d1fe9c503c8da60bbf1a1ec', 1500144988, 0, 1, 'Base Member', 1500144988, 1500145055, 0, 0, '0', '0', 0),
(74, '3a16f926c5c37536bc387e9c52608e7e784bdc9f661e9c9fd697ef563770798a9', 'johnschef77@gmail.com', 'd13e00331343e30b405726cf59aeb66f', 1500325810, 0, 1, 'Base Member', 1500325810, 1500405572, 0, 0, '0', '0', 0),
(75, '6018e9be4b8037d8b4486b2c58f57eb255ce268f93553ead07c8819b807542753', 'waderussell9@gmail.com', 'd3cbdb2d0b998c4e0142d382fee5e1e5', 1502634085, 0, 1, 'Base Member', 1502634085, 1506876589, 0, 0, 'cus_BCmdnxTY72jStq', '0', 0),
(76, 'f3610ff49a8f93fe34c8ddb40c55171d352f9ec7475a6970aa162572316759427', 'ajrs777@gmail.com', '0a6400618f1afee214e01b707569546c', 1503274219, 0, 1, 'Base Member', 1503274219, 1503274314, 0, 0, '0', '0', 0),
(77, 'b2d009eb785b9145e5a875e9c3cab899dd0c101aad8ed5017e2441609d3570e35', 'lrboni@aol.com', 'e44b62b2e26b069dbf2e180bf557ab75', 1503373562, 0, 1, 'Base Member', 1503277725, 1505342846, 0, 0, 'cus_BFzMYQMxu4ClbB', '0', 0),
(78, '795907f612c1932cf9a4dd654f3d8ff78a5a8dc4a02f4d005e67e75ed5b905d23', 'thomasr711@gmail.com', '93e635cfece8e398687a01349e9ab71c', 1503435552, 0, 1, 'Base Member', 1503435552, 1503435631, 0, 0, '0', '0', 0),
(79, 'e2132ae674e370135b9da9c306901d10d28000e03d761e97e4c197af77c163e49', 'mchaelnaranjo@yahoo.com', '025a14c00101c434f7729f6293f36878', 1504337129, 0, 1, 'Base Member', 1504337129, 1504349603, 0, 0, '0', '0', 0),
(80, 'f1d46de54ecb5f7423d8d6d1e3e3d96b5a97dd7826add8bcf15a899b46f71d0d3', 'samgross37@gmail.com', '162d05433a81ee343f902b99d4e7b9ca', 1508767853, 0, 0, 'Base Member', 1508767853, 0, 0, 0, '0', '0', 0),
(81, 'cbcf910cf73eeaa9cacf934d5d629c5049ed404f95f88ddbd71fdb4faf4518176', 'drm3228@aol.com', '3ef67d2d0f0ac97b823e2f825628fc5e', 1510052288, 0, 1, 'Base Member', 1510052288, 1510052981, 0, 0, '0', '0', 0),
(82, 'd03eb2844ed2f188bb9e7e77c077625c906d84e9b734dab55192e1a255d0f4610', 'loweman27@mail.ru', 'd1962c83c981ddfa647e857d99d66d0d', 1511188709, 0, 0, 'Base Member', 1511188709, 0, 0, 0, '0', '0', 0),
(83, '6d4fd3f7262d7b8a0f368c2d7e080ca46b4c59c679c0ca2b0d785d4942b77482a', 'leninlugo@gmail.com', '4de10f95c5c2f3cad74d5305463c34bf', 1511711469, 0, 1, 'Base Member', 1511710917, 1511717796, 0, 0, 'cus_Bq9FWGc4HPamKc', '0', 0),
(84, '773e49d1bf5898ac49cf414a0f58a2700b7172ee7825fd6b5b6c03beb757f46de', 'estevezjuegos@gmail.com', '343270d0b421982fbe9f2d49cf5aacee', 1512654887, 0, 1, 'Base Member', 1512654887, 1512655266, 0, 0, '0', '0', 0),
(85, '13c03158ac372fcc83eef76b223f8e5c2ba11e7c42e5b0f5fd7570a3316ddc2d9', '5837_ery1971@gmail.com', '994a2be07b4a28bacfc98bc5fa462aef', 1512978753, 0, 0, 'Base Member', 1512978753, 0, 0, 0, '0', '0', 0),
(86, '3939458c37176d9c976cd97425b88e09c44c31f76e6990e3d399b36730682935e', 'selmatpolu5@gmail.com', 'ecb09164ff154642dd42d70f2fbd4702', 1512979594, 0, 0, 'Base Member', 1512979594, 0, 0, 0, '0', '0', 0),
(87, '50fef73690deffe5b649e14aee5588001e01509b8a0799035ccdabefb3d6bde57', 'jakemeneski@gmail.com', 'd6f22cac60976c893d95d012b8b78eba', 1514438147, 0, 1, 'Base Member', 1514438147, 1514439193, 0, 0, '0', '0', 0),
(88, 'af3aa2d6488c6954388f57b71b94e9ce4bea882b09e6ffd35023d63b6290aa022', 'dboudinking@hotmail.com', 'b9bc2e04211212fa04ff2abf91f272df', 1516222218, 0, 1, 'Base Member', 1516222218, 1516222675, 0, 0, '0', '0', 0),
(89, '06995ae1ea9b1f8f23ce91e97849701b06d6719f933f91b3dbad819837f48fa04', 'docstyles69@gmail.com', '917e3cf053e07d66d15016f85fc023da', 1516741929, 0, 1, 'Base Member', 1516741929, 1523466773, 0, 0, '0', '0', 0),
(90, 'e8eca770d4083c7df75dd4e56b71c85289f4d24432db6f281a16a8f443dc40bd0', 'andrewkivia@hotmail.com', '33a7234368e107937e74ffa2f5d0cc7e', 1517684397, 0, 1, 'Base Member', 1517684397, 1517684787, 0, 0, '0', '0', 0),
(91, 'f25f27b77fb2782b7ef433d8c13197a073ace622c537c17aa281bc8fb0aee7c6f', 'ancan1216@gmail.com', '7bad7f72a6deca63f0c67651c4bb71e7', 1518302263, 0, 1, 'Base Member', 1518302263, 1518907432, 0, 0, 'cus_CIj05PqqtH0GDe', '0', 0),
(92, '374bdccc5737de567164588b1337bb803949705043533f0d214b3b03e05661f58', 'qtheone@yahoo.com', 'e366cc7dbeb9b4af0cf7834b73616975', 1519536937, 0, 1, 'Base Member', 1519536937, 1519538076, 0, 0, '0', '0', 0),
(93, '5311dc25ee9b9f885e26e2ed1365a72c49c5204ac54923103784fa91058e02804', 'martyzee@excite.com', '78c878f7b2cf851e0cf788f427c1345c', 1520435123, 0, 1, 'Base Member', 1520435123, 1520435263, 0, 0, '0', '0', 0),
(94, '95a0170d865d2b98f1a31f89313ff8b114f4268678f80c49ea4cf39be6def2fa0', 'dwood45@stny.rr.com', '3d6c9cdf6bbe8ab7669c36c7e50e5fca', 1523640532, 1, 0, 'Base Member', 1523377658, 0, 0, 0, '0', '0', 1),
(95, '21a6f3b8fdeebb17483be8aec2409fce8198386d22da2e09279f979a80f21335c', 'dwood.lcrhelp@gmail.com', '9c99816e6a30cb71b8ea4786dc4a0947', 1523378194, 1, 1, 'Base Member', 1523378039, 1523393329, 0, 0, '0', '0', 1),
(96, 'f60b5014e05e510fd8caaa3c6eac2b740adeeee244f901419f925218d9188bc2d', 'seounitedstates@gmail.com', '7e3aca2740b957e95971500e8ef1532e', 1523396907, 0, 1, 'Base Member', 1523396845, 1523397669, 0, 0, '0', '0', 0);

-- --------------------------------------------------------

--
-- Table structure for table `twiz_user_credits`
--

CREATE TABLE `twiz_user_credits` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `credits` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `twiz_user_credits`
--

INSERT INTO `twiz_user_credits` (`id`, `user_id`, `credits`) VALUES
(32, 8, 0),
(53, 29, 50),
(113, 89, 0),
(55, 31, 4),
(52, 28, 0),
(56, 32, 0),
(57, 33, 0),
(58, 34, 0),
(59, 35, 10),
(60, 36, 0),
(61, 37, 0),
(62, 38, 0),
(63, 39, 0),
(64, 40, 0),
(65, 41, 0),
(66, 42, 0),
(67, 43, 0),
(68, 44, 0),
(69, 45, 0),
(70, 46, 0),
(71, 47, 0),
(72, 48, 0),
(73, 49, 8),
(74, 50, 0),
(75, 51, 2),
(76, 52, 2),
(77, 53, 0),
(78, 54, 2),
(79, 55, 0),
(80, 56, 0),
(81, 57, 0),
(82, 58, 0),
(83, 59, 0),
(84, 60, 0),
(85, 61, 0),
(86, 62, 0),
(87, 63, 1),
(88, 64, 0),
(89, 65, 0),
(90, 66, 0),
(91, 67, 0),
(92, 68, 0),
(93, 69, 0),
(94, 70, 0),
(95, 71, 8),
(96, 72, 0),
(97, 73, 0),
(98, 74, 0),
(99, 75, 3),
(100, 76, 0),
(101, 77, 7),
(102, 78, 0),
(103, 79, 0),
(104, 80, 0),
(105, 81, 0),
(106, 82, 0),
(107, 83, 0),
(108, 84, 0),
(109, 85, 0),
(110, 86, 0),
(111, 87, 0),
(112, 88, 0),
(114, 90, 0),
(115, 91, 0),
(116, 92, 0),
(117, 93, 0),
(118, 94, 0),
(119, 95, 0),
(120, 96, 0);

-- --------------------------------------------------------

--
-- Table structure for table `twiz_user_permission_matches`
--

CREATE TABLE `twiz_user_permission_matches` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `twiz_user_permission_matches`
--

INSERT INTO `twiz_user_permission_matches` (`id`, `user_id`, `permission_id`) VALUES
(127, 8, 1),
(246, 28, 2),
(248, 29, 2),
(250, 31, 2),
(253, 31, 4),
(254, 32, 1),
(255, 33, 2),
(256, 34, 2),
(257, 35, 2),
(258, 35, 4),
(259, 36, 2),
(260, 37, 2),
(261, 38, 2),
(262, 39, 2),
(263, 40, 2),
(264, 41, 2),
(265, 42, 2),
(266, 43, 2),
(267, 44, 2),
(268, 45, 2),
(269, 46, 2),
(270, 47, 2),
(271, 48, 2),
(272, 49, 2),
(273, 49, 4),
(274, 50, 2),
(275, 51, 2),
(276, 51, 4),
(277, 52, 2),
(279, 53, 2),
(280, 52, 4),
(281, 54, 2),
(282, 55, 2),
(285, 56, 2),
(286, 54, 4),
(287, 57, 2),
(288, 58, 2),
(289, 59, 2),
(290, 60, 2),
(291, 61, 2),
(292, 62, 2),
(293, 63, 2),
(294, 64, 2),
(295, 63, 4),
(296, 65, 2),
(297, 66, 2),
(298, 67, 2),
(299, 68, 2),
(302, 69, 2),
(303, 70, 2),
(304, 71, 2),
(306, 72, 2),
(307, 73, 2),
(308, 74, 2),
(309, 75, 2),
(312, 76, 2),
(313, 77, 2),
(315, 78, 2),
(317, 79, 2),
(319, 77, 4),
(320, 75, 4),
(321, 80, 2),
(322, 81, 2),
(324, 82, 2),
(326, 29, 4),
(327, 30, 4),
(331, 83, 2),
(332, 84, 2),
(334, 85, 2),
(335, 86, 2),
(336, 87, 2),
(337, 71, 4),
(338, 88, 2),
(339, 89, 2),
(340, 90, 2),
(341, 91, 2),
(343, 8, 5),
(344, 92, 2),
(345, 93, 2),
(346, 94, 2),
(347, 95, 2),
(348, 96, 2);

-- --------------------------------------------------------

--
-- Table structure for table `twiz_user_sheets`
--

CREATE TABLE `twiz_user_sheets` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `sheet` varchar(25) NOT NULL,
  `race_track` varchar(30) NOT NULL,
  `race_date` date NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Users and sheets';

--
-- Dumping data for table `twiz_user_sheets`
--

INSERT INTO `twiz_user_sheets` (`id`, `user_id`, `sheet`, `race_track`, `race_date`, `time`) VALUES
(1, 1, '1', 'default', '0000-00-00', '0000-00-00 00:00:00'),
(10919, 32, 'kee20180414ppsXML.xml', 'KEENELAND', '2018-04-14', '2018-04-13 17:35:39'),
(10918, 32, 'op20180414ppsXML.xml', 'OAKLAWN PARK', '2018-04-14', '2018-04-13 17:35:23');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `twiz_configuration`
--
ALTER TABLE `twiz_configuration`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `twiz_filters`
--
ALTER TABLE `twiz_filters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `twiz_pages`
--
ALTER TABLE `twiz_pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `twiz_permissions`
--
ALTER TABLE `twiz_permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `twiz_permission_page_matches`
--
ALTER TABLE `twiz_permission_page_matches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `twiz_users`
--
ALTER TABLE `twiz_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `twiz_user_credits`
--
ALTER TABLE `twiz_user_credits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `twiz_user_permission_matches`
--
ALTER TABLE `twiz_user_permission_matches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `twiz_user_sheets`
--
ALTER TABLE `twiz_user_sheets`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `twiz_configuration`
--
ALTER TABLE `twiz_configuration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `twiz_filters`
--
ALTER TABLE `twiz_filters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `twiz_pages`
--
ALTER TABLE `twiz_pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=134;

--
-- AUTO_INCREMENT for table `twiz_permissions`
--
ALTER TABLE `twiz_permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `twiz_permission_page_matches`
--
ALTER TABLE `twiz_permission_page_matches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT for table `twiz_users`
--
ALTER TABLE `twiz_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT for table `twiz_user_credits`
--
ALTER TABLE `twiz_user_credits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

--
-- AUTO_INCREMENT for table `twiz_user_permission_matches`
--
ALTER TABLE `twiz_user_permission_matches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=349;

--
-- AUTO_INCREMENT for table `twiz_user_sheets`
--
ALTER TABLE `twiz_user_sheets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10920;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
