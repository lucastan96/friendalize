-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 10, 2017 at 05:42 PM
-- Server version: 10.1.28-MariaDB
-- PHP Version: 7.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lucastan_friendalize`
--

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `country_id` int(11) NOT NULL,
  `code` varchar(2) NOT NULL DEFAULT '',
  `name` varchar(100) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`country_id`, `code`, `name`) VALUES
(1, 'AF', 'Afghanistan'),
(2, 'AL', 'Albania'),
(3, 'DZ', 'Algeria'),
(4, 'DS', 'American Samoa'),
(5, 'AD', 'Andorra'),
(6, 'AO', 'Angola'),
(7, 'AI', 'Anguilla'),
(8, 'AQ', 'Antarctica'),
(9, 'AG', 'Antigua and Barbuda'),
(10, 'AR', 'Argentina'),
(11, 'AM', 'Armenia'),
(12, 'AW', 'Aruba'),
(13, 'AU', 'Australia'),
(14, 'AT', 'Austria'),
(15, 'AZ', 'Azerbaijan'),
(16, 'BS', 'Bahamas'),
(17, 'BH', 'Bahrain'),
(18, 'BD', 'Bangladesh'),
(19, 'BB', 'Barbados'),
(20, 'BY', 'Belarus'),
(21, 'BE', 'Belgium'),
(22, 'BZ', 'Belize'),
(23, 'BJ', 'Benin'),
(24, 'BM', 'Bermuda'),
(25, 'BT', 'Bhutan'),
(26, 'BO', 'Bolivia'),
(27, 'BA', 'Bosnia and Herzegovina'),
(28, 'BW', 'Botswana'),
(29, 'BV', 'Bouvet Island'),
(30, 'BR', 'Brazil'),
(31, 'IO', 'British Indian Ocean Territory'),
(32, 'BN', 'Brunei Darussalam'),
(33, 'BG', 'Bulgaria'),
(34, 'BF', 'Burkina Faso'),
(35, 'BI', 'Burundi'),
(36, 'KH', 'Cambodia'),
(37, 'CM', 'Cameroon'),
(38, 'CA', 'Canada'),
(39, 'CV', 'Cape Verde'),
(40, 'KY', 'Cayman Islands'),
(41, 'CF', 'Central African Republic'),
(42, 'TD', 'Chad'),
(43, 'CL', 'Chile'),
(44, 'CN', 'China'),
(45, 'CX', 'Christmas Island'),
(46, 'CC', 'Cocos (Keeling) Islands'),
(47, 'CO', 'Colombia'),
(48, 'KM', 'Comoros'),
(49, 'CG', 'Congo'),
(50, 'CK', 'Cook Islands'),
(51, 'CR', 'Costa Rica'),
(52, 'HR', 'Croatia (Hrvatska)'),
(53, 'CU', 'Cuba'),
(54, 'CY', 'Cyprus'),
(55, 'CZ', 'Czech Republic'),
(56, 'DK', 'Denmark'),
(57, 'DJ', 'Djibouti'),
(58, 'DM', 'Dominica'),
(59, 'DO', 'Dominican Republic'),
(60, 'TP', 'East Timor'),
(61, 'EC', 'Ecuador'),
(62, 'EG', 'Egypt'),
(63, 'SV', 'El Salvador'),
(64, 'GQ', 'Equatorial Guinea'),
(65, 'ER', 'Eritrea'),
(66, 'EE', 'Estonia'),
(67, 'ET', 'Ethiopia'),
(68, 'FK', 'Falkland Islands (Malvinas)'),
(69, 'FO', 'Faroe Islands'),
(70, 'FJ', 'Fiji'),
(71, 'FI', 'Finland'),
(72, 'FR', 'France'),
(73, 'FX', 'France, Metropolitan'),
(74, 'GF', 'French Guiana'),
(75, 'PF', 'French Polynesia'),
(76, 'TF', 'French Southern Territories'),
(77, 'GA', 'Gabon'),
(78, 'GM', 'Gambia'),
(79, 'GE', 'Georgia'),
(80, 'DE', 'Germany'),
(81, 'GH', 'Ghana'),
(82, 'GI', 'Gibraltar'),
(83, 'GK', 'Guernsey'),
(84, 'GR', 'Greece'),
(85, 'GL', 'Greenland'),
(86, 'GD', 'Grenada'),
(87, 'GP', 'Guadeloupe'),
(88, 'GU', 'Guam'),
(89, 'GT', 'Guatemala'),
(90, 'GN', 'Guinea'),
(91, 'GW', 'Guinea-Bissau'),
(92, 'GY', 'Guyana'),
(93, 'HT', 'Haiti'),
(94, 'HM', 'Heard and Mc Donald Islands'),
(95, 'HN', 'Honduras'),
(96, 'HK', 'Hong Kong'),
(97, 'HU', 'Hungary'),
(98, 'IS', 'Iceland'),
(99, 'IN', 'India'),
(100, 'IM', 'Isle of Man'),
(101, 'ID', 'Indonesia'),
(102, 'IR', 'Iran (Islamic Republic of)'),
(103, 'IQ', 'Iraq'),
(104, 'IE', 'Ireland'),
(105, 'IL', 'Israel'),
(106, 'IT', 'Italy'),
(107, 'CI', 'Ivory Coast'),
(108, 'JE', 'Jersey'),
(109, 'JM', 'Jamaica'),
(110, 'JP', 'Japan'),
(111, 'JO', 'Jordan'),
(112, 'KZ', 'Kazakhstan'),
(113, 'KE', 'Kenya'),
(114, 'KI', 'Kiribati'),
(115, 'KP', 'Korea, Democratic People\'s Republic of'),
(116, 'KR', 'Korea, Republic of'),
(117, 'XK', 'Kosovo'),
(118, 'KW', 'Kuwait'),
(119, 'KG', 'Kyrgyzstan'),
(120, 'LA', 'Lao People\'s Democratic Republic'),
(121, 'LV', 'Latvia'),
(122, 'LB', 'Lebanon'),
(123, 'LS', 'Lesotho'),
(124, 'LR', 'Liberia'),
(125, 'LY', 'Libyan Arab Jamahiriya'),
(126, 'LI', 'Liechtenstein'),
(127, 'LT', 'Lithuania'),
(128, 'LU', 'Luxembourg'),
(129, 'MO', 'Macau'),
(130, 'MK', 'Macedonia'),
(131, 'MG', 'Madagascar'),
(132, 'MW', 'Malawi'),
(133, 'MY', 'Malaysia'),
(134, 'MV', 'Maldives'),
(135, 'ML', 'Mali'),
(136, 'MT', 'Malta'),
(137, 'MH', 'Marshall Islands'),
(138, 'MQ', 'Martinique'),
(139, 'MR', 'Mauritania'),
(140, 'MU', 'Mauritius'),
(141, 'TY', 'Mayotte'),
(142, 'MX', 'Mexico'),
(143, 'FM', 'Micronesia, Federated States of'),
(144, 'MD', 'Moldova, Republic of'),
(145, 'MC', 'Monaco'),
(146, 'MN', 'Mongolia'),
(147, 'ME', 'Montenegro'),
(148, 'MS', 'Montserrat'),
(149, 'MA', 'Morocco'),
(150, 'MZ', 'Mozambique'),
(151, 'MM', 'Myanmar'),
(152, 'NA', 'Namibia'),
(153, 'NR', 'Nauru'),
(154, 'NP', 'Nepal'),
(155, 'NL', 'Netherlands'),
(156, 'AN', 'Netherlands Antilles'),
(157, 'NC', 'New Caledonia'),
(158, 'NZ', 'New Zealand'),
(159, 'NI', 'Nicaragua'),
(160, 'NE', 'Niger'),
(161, 'NG', 'Nigeria'),
(162, 'NU', 'Niue'),
(163, 'NF', 'Norfolk Island'),
(164, 'MP', 'Northern Mariana Islands'),
(165, 'NO', 'Norway'),
(166, 'OM', 'Oman'),
(167, 'PK', 'Pakistan'),
(168, 'PW', 'Palau'),
(169, 'PS', 'Palestine'),
(170, 'PA', 'Panama'),
(171, 'PG', 'Papua New Guinea'),
(172, 'PY', 'Paraguay'),
(173, 'PE', 'Peru'),
(174, 'PH', 'Philippines'),
(175, 'PN', 'Pitcairn'),
(176, 'PL', 'Poland'),
(177, 'PT', 'Portugal'),
(178, 'PR', 'Puerto Rico'),
(179, 'QA', 'Qatar'),
(180, 'RE', 'Reunion'),
(181, 'RO', 'Romania'),
(182, 'RU', 'Russian Federation'),
(183, 'RW', 'Rwanda'),
(184, 'KN', 'Saint Kitts and Nevis'),
(185, 'LC', 'Saint Lucia'),
(186, 'VC', 'Saint Vincent and the Grenadines'),
(187, 'WS', 'Samoa'),
(188, 'SM', 'San Marino'),
(189, 'ST', 'Sao Tome and Principe'),
(190, 'SA', 'Saudi Arabia'),
(191, 'SN', 'Senegal'),
(192, 'RS', 'Serbia'),
(193, 'SC', 'Seychelles'),
(194, 'SL', 'Sierra Leone'),
(195, 'SG', 'Singapore'),
(196, 'SK', 'Slovakia'),
(197, 'SI', 'Slovenia'),
(198, 'SB', 'Solomon Islands'),
(199, 'SO', 'Somalia'),
(200, 'ZA', 'South Africa'),
(201, 'GS', 'South Georgia South Sandwich Islands'),
(202, 'ES', 'Spain'),
(203, 'LK', 'Sri Lanka'),
(204, 'SH', 'St. Helena'),
(205, 'PM', 'St. Pierre and Miquelon'),
(206, 'SD', 'Sudan'),
(207, 'SR', 'Suriname'),
(208, 'SJ', 'Svalbard and Jan Mayen Islands'),
(209, 'SZ', 'Swaziland'),
(210, 'SE', 'Sweden'),
(211, 'CH', 'Switzerland'),
(212, 'SY', 'Syrian Arab Republic'),
(213, 'TW', 'Taiwan'),
(214, 'TJ', 'Tajikistan'),
(215, 'TZ', 'Tanzania, United Republic of'),
(216, 'TH', 'Thailand'),
(217, 'TG', 'Togo'),
(218, 'TK', 'Tokelau'),
(219, 'TO', 'Tonga'),
(220, 'TT', 'Trinidad and Tobago'),
(221, 'TN', 'Tunisia'),
(222, 'TR', 'Turkey'),
(223, 'TM', 'Turkmenistan'),
(224, 'TC', 'Turks and Caicos Islands'),
(225, 'TV', 'Tuvalu'),
(226, 'UG', 'Uganda'),
(227, 'UA', 'Ukraine'),
(228, 'AE', 'United Arab Emirates'),
(229, 'GB', 'United Kingdom'),
(230, 'US', 'United States'),
(231, 'UM', 'United States minor outlying islands'),
(232, 'UY', 'Uruguay'),
(233, 'UZ', 'Uzbekistan'),
(234, 'VU', 'Vanuatu'),
(235, 'VA', 'Vatican City State'),
(236, 'VE', 'Venezuela'),
(237, 'VN', 'Vietnam'),
(238, 'VG', 'Virgin Islands (British)'),
(239, 'VI', 'Virgin Islands (U.S.)'),
(240, 'WF', 'Wallis and Futuna Islands'),
(241, 'EH', 'Western Sahara'),
(242, 'YE', 'Yemen'),
(243, 'ZR', 'Zaire'),
(244, 'ZM', 'Zambia'),
(245, 'ZW', 'Zimbabwe');

-- --------------------------------------------------------

--
-- Table structure for table `ghost_answer_submit`
--

CREATE TABLE `ghost_answer_submit` (
  `room_id` int(11) NOT NULL,
  `voter` int(11) NOT NULL,
  `voted` int(11) DEFAULT NULL,
  `vote_order` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ghost_game_time`
--

CREATE TABLE `ghost_game_time` (
  `room_id` int(11) NOT NULL,
  `start_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ghost_message`
--

CREATE TABLE `ghost_message` (
  `message_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ghost_message`
--

INSERT INTO `ghost_message` (`message_id`, `content`, `created_at`) VALUES
(1, 'hello', '2017-11-25 13:30:26'),
(2, 'helloooo', '2017-11-25 13:30:30'),
(3, 'hello', '2017-11-25 13:30:32'),
(4, 'hello', '2017-11-25 13:30:36'),
(5, 'hey', '2017-11-25 13:45:28'),
(6, 'hey', '2017-11-25 13:45:30'),
(7, 'hey', '2017-11-25 13:45:31'),
(8, 'hey', '2017-11-25 13:45:33'),
(9, 'hahaha', '2017-11-25 13:45:38'),
(10, 'hi', '2017-11-25 13:49:21'),
(11, 'hello', '2017-11-25 14:07:47'),
(12, 'hey', '2017-11-25 14:09:07'),
(13, 'Hey', '2017-11-27 16:07:38'),
(14, 'Hello', '2017-11-27 16:07:42'),
(15, 'Hiii', '2017-11-27 16:07:54'),
(16, 'Hi faraway', '2017-12-05 15:37:27'),
(17, 'hmm Farwa?', '2017-12-05 15:37:30'),
(18, 'yes shelaine', '2017-12-05 15:37:36'),
(19, 'its a fruit', '2017-12-05 15:37:37'),
(20, 'it can be eaten', '2017-12-05 15:37:37'),
(21, 'I forget mine', '2017-12-05 15:37:45'),
(22, 'its a fruit', '2017-12-05 15:37:59'),
(23, 'Why am i last?', '2017-12-05 15:38:03'),
(24, 'later we vote lucas', '2017-12-05 15:38:08'),
(25, 'Why am i last?', '2017-12-05 15:38:11'),
(26, 'Why am i last?', '2017-12-05 15:38:11'),
(27, 'ok', '2017-12-05 15:38:12'),
(28, 'why not?', '2017-12-05 15:38:16'),
(29, 'its edible', '2017-12-05 15:38:20'),
(30, 'then start a new game', '2017-12-05 15:38:21'),
(31, 'then start a new gamehahaha', '2017-12-05 15:38:22'),
(32, 'what is edible means?', '2017-12-05 15:38:30'),
(33, 'It is orange', '2017-12-05 15:38:35'),
(34, 'ur word?', '2017-12-05 15:38:41'),
(35, 'me too', '2017-12-05 15:38:42'),
(36, 'mine is apple', '2017-12-05 15:38:46'),
(37, 'vote me later ', '2017-12-05 15:38:49'),
(38, 'vote me later then we start new game', '2017-12-05 15:38:53'),
(39, 'me didnt get any', '2017-12-05 15:38:54'),
(40, 'vote me', '2017-12-05 15:38:58'),
(41, 'guys', '2017-12-05 15:39:01'),
(42, 'ok', '2017-12-05 15:39:01'),
(43, 'vote me', '2017-12-05 15:39:05'),
(44, 'it is something you wear', '2017-12-05 15:39:40'),
(45, 'girl wear it', '2017-12-05 15:39:58'),
(46, 'its pretty', '2017-12-05 15:40:03'),
(47, 'I like to wear', '2017-12-05 15:40:10'),
(48, 'it can be long or short', '2017-12-05 15:41:56'),
(49, 'it can be long or short', '2017-12-05 15:41:56'),
(50, 'it can be long or short', '2017-12-05 15:41:59'),
(51, 'it can be long or short', '2017-12-05 15:41:59'),
(52, 'can be fancy or not', '2017-12-05 15:42:06'),
(53, 'Hi', '2017-12-05 15:42:09'),
(54, 'hello', '2017-12-05 15:42:18'),
(55, 'i am lucas', '2017-12-05 15:42:24'),
(56, 'Lucas is short', '2017-12-05 15:42:25'),
(57, 'i am lucas...', '2017-12-05 15:42:29'),
(58, '...', '2017-12-05 15:42:31'),
(59, 'alvin is ugly', '2017-12-05 15:42:36'),
(60, '10 seconds left', '2017-12-05 15:42:41'),
(61, '2', '2017-12-05 15:42:41'),
(62, '1', '2017-12-05 15:42:42'),
(63, '?', '2017-12-05 15:42:44'),
(64, 'Omg', '2017-12-05 15:42:53'),
(65, 'Haha you guys', '2017-12-05 15:57:22'),
(66, 'I know you think i am handsome', '2017-12-05 15:57:33'),
(67, 'hahaha alvinnnnn', '2017-12-05 15:57:42'),
(68, 'ðŸ¤”ðŸ¤”ðŸ¤”', '2017-12-05 15:57:49'),
(69, 'ðŸ‘»', '2017-12-05 15:57:57'),
(70, 'Asdfjkl;', '2017-12-05 15:58:08'),
(71, 'S', '2017-12-05 15:58:09'),
(72, 'S', '2017-12-05 15:58:09'),
(73, 'S', '2017-12-05 15:58:10'),
(74, 'S', '2017-12-05 15:58:10'),
(75, 'hi', '2017-12-05 15:58:27'),
(76, 'you can write on this', '2017-12-05 15:59:47'),
(77, 'its very suitable for DIY projects', '2017-12-05 16:00:07'),
(78, 'Can be colorful', '2017-12-05 16:00:28'),
(79, 'it can hard or soft', '2017-12-05 16:00:42'),
(80, 'I think Lucas is fake one', '2017-12-05 16:00:55'),
(81, 'I think Lucas is fake oneVote him', '2017-12-05 16:00:59'),
(82, 'lol', '2017-12-05 16:01:00'),
(83, 'how do u know', '2017-12-05 16:01:03'),
(84, 'might be alvin', '2017-12-05 16:01:08'),
(85, 'Believe me', '2017-12-05 16:01:14'),
(86, 'I think I will vote alvin', '2017-12-05 16:01:19'),
(87, 'Please', '2017-12-05 16:01:20'),
(88, 'Donâ€™t', '2017-12-05 16:01:22'),
(89, 'u r innocent?', '2017-12-05 16:01:23'),
(90, 'lets vote guys hahah', '2017-12-05 16:01:24'),
(91, 'Farwa', '2017-12-05 16:01:25'),
(92, 'go go go', '2017-12-05 16:01:25'),
(93, 'Be with me', '2017-12-05 16:01:29'),
(94, 'Please', '2017-12-05 16:01:33'),
(95, 'its usually white', '2017-12-05 16:01:45'),
(96, 'u can cut it with scissors haha', '2017-12-05 16:02:00'),
(97, 'You guys just donâ€™t like me ðŸ˜­ðŸ˜­ðŸ˜­ðŸ˜­ðŸ˜­ not because of my description', '2017-12-05 16:02:09'),
(98, 'shhh', '2017-12-05 16:02:16'),
(99, 'can cut it easily with scissor', '2017-12-05 16:02:17'),
(100, 'aww alvin', '2017-12-05 16:02:23'),
(101, 'Believe me', '2017-12-05 16:02:53'),
(102, 'Guys', '2017-12-05 16:02:55'),
(103, 'use it school every day', '2017-12-05 16:03:25'),
(104, 'Itâ€™s lucas', '2017-12-05 16:03:29'),
(105, 'Can write note', '2017-12-05 16:03:36'),
(106, 'its useful', '2017-12-05 16:03:37'),
(107, 'He cant', '2017-12-05 16:03:41'),
(108, 'farwa', '2017-12-05 16:03:46'),
(109, 'Because he wants me die', '2017-12-05 16:03:51'),
(110, 'I think we have the same', '2017-12-05 16:03:53'),
(111, 'So i want to kill him', '2017-12-05 16:03:57'),
(112, 'Help me', '2017-12-05 16:03:59'),
(113, 'ok', '2017-12-05 16:04:01'),
(114, 'Farwa always give me that', '2017-12-05 16:04:02'),
(115, 'vote lucas', '2017-12-05 16:04:03'),
(116, 'Told u all', '2017-12-05 16:04:16'),
(117, 'hahahhaa', '2017-12-05 16:04:44'),
(118, 'Yeah', '2017-12-05 16:04:45'),
(119, 'Join again', '2017-12-05 16:05:08'),
(120, 'ðŸ˜›', '2017-12-05 16:05:10'),
(121, 'Letâ€™s play again another round', '2017-12-05 16:05:15'),
(122, 'sure', '2017-12-05 16:06:30'),
(123, 'why not', '2017-12-05 16:06:38'),
(124, 'yo marcin', '2017-12-05 16:32:55'),
(125, 'i see you!!', '2017-12-05 16:32:58'),
(126, 'Yo Amar :D', '2017-12-05 16:33:04'),
(127, 'time to go homemarcin', '2017-12-05 16:33:11'),
(128, 'In like 12 minutes :P', '2017-12-05 16:33:23'),
(129, 'I AM RONALDO', '2017-12-05 16:33:29'),
(130, 'yo aj', '2017-12-05 16:33:30'),
(131, 'VIVA ESPANA', '2017-12-05 16:33:32'),
(132, 'fuck off', '2017-12-05 16:33:34'),
(133, 'hell yeah ', '2017-12-05 16:33:35'),
(134, 'im in ', '2017-12-05 16:33:37'),
(135, 'bitches ', '2017-12-05 16:33:40'),
(136, 'MESSY SUX!', '2017-12-05 16:33:42'),
(137, 'i am sure its allain', '2017-12-05 16:33:54'),
(138, 'PLAY GHOST', '2017-12-05 16:33:57'),
(139, 'Seems legit.......', '2017-12-05 16:34:05'),
(140, 'its made with trees', '2017-12-05 16:34:30'),
(141, ':D', '2017-12-05 16:34:31'),
(142, 'wood', '2017-12-05 16:34:36'),
(143, 'messy sux balls', '2017-12-05 16:34:50'),
(144, 'balls ', '2017-12-05 16:34:55'),
(145, 'wood', '2017-12-05 16:35:06'),
(146, 'fuck off christano', '2017-12-05 16:35:10'),
(147, 'furniture ', '2017-12-05 16:35:11'),
(148, 'i am better than messy', '2017-12-05 16:35:13'),
(149, 'man united sux ass', '2017-12-05 16:35:19'),
(150, 'CR7', '2017-12-05 16:35:20'),
(151, 'hala madrid!!!!', '2017-12-05 16:35:23'),
(152, 'VIVA ESPANA', '2017-12-05 16:35:30'),
(153, 'KURVA', '2017-12-05 16:35:35'),
(154, 'marcin you are the ghost', '2017-12-05 16:35:36'),
(155, 'bitch ', '2017-12-05 16:35:43'),
(156, 'marcin chipka', '2017-12-05 16:35:44'),
(157, 'NOOOOO', '2017-12-05 16:35:44'),
(158, 'Whos Ghost ?', '2017-12-05 16:35:56'),
(159, 'IDK ', '2017-12-05 16:36:12'),
(160, 'maciin kurrrrwwaaaaaaaaaaa!1', '2017-12-05 16:36:15'),
(161, 'I know whos Bitch ', '2017-12-05 16:36:16'),
(162, 'Spierdalaj :P', '2017-12-05 16:36:22'),
(163, 'VIVA LA ESPANA', '2017-12-05 16:36:23'),
(164, 'zamkininsya!', '2017-12-05 16:36:41'),
(165, 'CR7 BABAY', '2017-12-05 16:36:45'),
(166, 'its paper :D', '2017-12-05 16:36:59'),
(167, 'Thanks guys........ :/', '2017-12-05 16:37:14'),
(168, 'Hogwards  ', '2017-12-05 16:37:15'),
(169, 'VIVA LA ESPANA', '2017-12-05 16:37:22'),
(170, 'hahahaha', '2017-12-05 16:37:24'),
(171, 'fuck no', '2017-12-05 16:37:26'),
(172, 'HALa MADRID!!!!!!', '2017-12-05 16:37:46'),
(173, 'ITS SMOOTH', '2017-12-05 16:37:56'),
(174, 'like my playstyle in football', '2017-12-05 16:38:03'),
(175, 'VIVA LA ESPANA', '2017-12-05 16:38:08'),
(176, 'you are shite', '2017-12-05 16:38:14'),
(177, 'gobshite', '2017-12-05 16:38:18'),
(178, 'MArcin is bitch', '2017-12-05 16:38:29'),
(179, 'shhhhhhhhhhhhhh', '2017-12-05 16:38:31'),
(180, 'dont tell him ', '2017-12-05 16:38:35'),
(181, 'no marcin', '2017-12-05 16:38:37'),
(182, 'is ksrwa', '2017-12-05 16:38:42'),
(183, 'kurwa', '2017-12-05 16:38:44'),
(184, 'I\'m still here dumbass :P', '2017-12-05 16:38:45'),
(185, 'HAHAHA', '2017-12-05 16:38:48'),
(186, 'DONT KICK RONALDO', '2017-12-05 16:39:06'),
(187, 'yo scrum-master', '2017-12-05 16:39:17'),
(188, 'VIVA LA ESPANAO', '2017-12-05 16:39:19'),
(189, 'What????', '2017-12-05 16:39:22'),
(190, 'damn #', '2017-12-05 16:39:22'),
(191, 'boys ', '2017-12-05 16:39:26'),
(192, 'yeah???', '2017-12-05 16:39:31'),
(193, 'this is good ', '2017-12-05 16:39:31'),
(194, 'its time for your bus', '2017-12-05 16:39:33'),
(195, 'Not for me........ SINCE YOU KICKED ME OUT!!!!!!!', '2017-12-05 16:39:48'),
(196, 'Bcsnvmbzxmc', '2017-12-05 19:56:46'),
(197, 'Its an instrument', '2017-12-09 21:56:13'),
(198, 'i have it', '2017-12-09 21:56:34'),
(199, 'it has 6 strings', '2017-12-09 21:56:49'),
(200, 'can use to listem music', '2017-12-09 22:12:19'),
(201, 'its a music service', '2017-12-09 22:12:23'),
(202, 'kyle is using', '2017-12-09 22:12:44'),
(203, 'i think is lucas', '2017-12-09 22:13:06'),
(204, 'ahhah', '2017-12-09 22:13:09'),
(205, 'me too', '2017-12-09 22:13:11'),
(206, 'gg', '2017-12-09 22:13:12'),
(207, 'gg', '2017-12-09 22:13:19'),
(208, 'ok loh', '2017-12-09 22:13:21'),
(209, 'go vote', '2017-12-09 22:13:24'),
(210, 'ðŸ˜¨', '2017-12-09 22:13:24'),
(211, 'ðŸ˜­ðŸ˜­ðŸ˜­', '2017-12-09 22:13:32');

-- --------------------------------------------------------

--
-- Table structure for table `ghost_msg_player_room`
--

CREATE TABLE `ghost_msg_player_room` (
  `message_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `ghost_room`
--

CREATE TABLE `ghost_room` (
  `room_id` int(11) NOT NULL,
  `room_name` text,
  `word_pair_id` int(11) NOT NULL,
  `member_num` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `interest_id` int(11) NOT NULL,
  `difficulty_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ghost_room_players`
--

CREATE TABLE `ghost_room_players` (
  `room_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `word` text NOT NULL,
  `died` int(11) NOT NULL,
  `ready` int(11) NOT NULL,
  `game_order` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ghost_word_pair`
--

CREATE TABLE `ghost_word_pair` (
  `word_pair_id` int(11) NOT NULL,
  `ghost_word` text NOT NULL,
  `civilian_word` text NOT NULL,
  `interest_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ghost_word_pair`
--

INSERT INTO `ghost_word_pair` (`word_pair_id`, `ghost_word`, `civilian_word`, `interest_id`) VALUES
(5, 'Mozart', 'Beethoven', 2),
(6, 'Classical Guitar', 'Acoustic guitar', 2),
(7, 'Adidas', 'Nike', 7),
(8, 'Prague', 'Budapest', 8),
(9, 'Viber', 'WhatsApp', 6),
(10, 'Spotify', 'Apple Music', 2);

-- --------------------------------------------------------

--
-- Table structure for table `institutions`
--

CREATE TABLE `institutions` (
  `institution_id` int(11) NOT NULL,
  `name` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `institutions`
--

INSERT INTO `institutions` (`institution_id`, `name`) VALUES
(1, 'Dundalk Institute of Technology'),
(2, 'Trinity College Dublin'),
(3, 'Dublin Institute of Technology'),
(4, 'Waterford Institute of Technology');

-- --------------------------------------------------------

--
-- Table structure for table `interests`
--

CREATE TABLE `interests` (
  `interest_id` int(11) NOT NULL,
  `name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `interests`
--

INSERT INTO `interests` (`interest_id`, `name`) VALUES
(1, 'None'),
(2, 'Music'),
(3, 'Reading'),
(4, 'Exercise'),
(5, 'Watching Movies'),
(6, 'Socializing'),
(7, 'Shopping'),
(8, 'Travelling'),
(9, 'Sleeping'),
(10, 'Technology'),
(11, 'Sports');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL DEFAULT '1',
  `content` text,
  `images` text,
  `likes` text,
  `time` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`post_id`, `user_id`, `category_id`, `content`, `images`, `likes`, `time`) VALUES
(1, 7, 1, 'Poor pig', 'a0YNjvn_460s_v2.jpg', NULL, '2017-12-05 16:45:35'),
(5, 1, 1, 'Awesome Friendalize team photo!', 'image.jpg', '1,3,5', '2017-12-05 15:46:59'),
(7, 1, 1, 'Singing competition with her~', '6977C7B8-A1BA-4277-B161-B63493E60D83.jpeg', '1', '2017-12-05 15:48:57'),
(11, 8, 1, 'True that!!!!!!!!!', 'you-didnt-attend-the-sprint-demo-and-youre-surprised-about-a-change.jpg', NULL, '2017-12-05 16:42:40'),
(12, 10, 1, 'Anyone wants to hangout tomorrow?', NULL, NULL, '2017-12-06 00:19:43'),
(14, 7, 1, 'Hahaha', '11248800_10153218005963386_7969316355800285303_n.jpg', '4', '2017-12-05 16:44:40'),
(15, 10, 6, '<3 Emma Watson', 'emma watson.jpg', NULL, '2017-12-06 00:20:13'),
(16, 6, 1, 'This is a great website!!!!', 'images.png', NULL, '2017-12-05 16:30:21'),
(17, 1, 6, 'Why am i so handsome??', 'CB992D29-2DD4-448C-B91B-2C73DC0A511A.jpeg', '1,3,5', '2017-12-05 15:33:48');

-- --------------------------------------------------------

--
-- Table structure for table `post_comments`
--

CREATE TABLE `post_comments` (
  `comment_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `post_comments`
--

INSERT INTO `post_comments` (`comment_id`, `post_id`, `user_id`, `comment`, `time`, `status`) VALUES
(4, 17, 5, 'nice picture', '2017-12-05 15:45:47', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(30) DEFAULT NULL,
  `password` char(255) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `first_name` varchar(20) DEFAULT NULL,
  `last_name` varchar(20) DEFAULT NULL,
  `gender` enum('Male','Female','Other') DEFAULT NULL,
  `age` int(3) NOT NULL,
  `country_id` int(11) NOT NULL,
  `profile_pic` varchar(30) DEFAULT 'default.png',
  `user_status` bit(1) NOT NULL DEFAULT b'0',
  `join_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `email`, `first_name`, `last_name`, `gender`, `age`, `country_id`, `profile_pic`, `user_status`, `join_date`) VALUES
(1, 'alvintkm1996', '$2y$10$iay/0ULkY4.w5hRBmTbMGeHhs20r5Qo4D5me/iC.VbDpJXAGRDyv6', 'alvinteo9696@gmail.com', 'Alvin', 'Teo', 'Male', 21, 129, 'user_1.png', b'0', '2017-10-19 15:42:47'),
(3, 'lucastan96', '$2y$10$LlhOglS7MRVq6GoMYLsO7.q4Bo7J6TXLIFHSDVeanho/ftOz2sj0e', 'lucastan96@gmail.com', 'Lucas', 'Tan', 'Male', 21, 133, 'user_3.png', b'1', '2017-10-25 15:42:47'),
(4, 'elaine', '$2y$10$JuTWPHmks8Dym62GRvaQOuPZYSLlWj0azle3bwWJ8PiSc/NcFPYc6', 'elaine@gmail.com', 'Elaine', 'Chong', 'Female', 20, 133, 'user_4.png', b'0', '2017-10-27 15:42:47'),
(5, 'farwa', '$2y$10$Ug97Fjc/jhLoc0ce.s0vJ.me4PCOg4nC9B4CQcr3Nwfl/QFsUrTr2', 'farwaj1@gmail.com', 'Farwa', 'Javed', 'Female', 22, 104, 'user_5.png', b'0', '2017-10-27 15:42:47'),
(6, 'Ghalay', '$2y$10$/D0gUe9eoQUO.GAQ.08eDuunjXpyLIQALS3.uDIDeTXyGxLE4wOaa', 'amarghale2@gmail.com', 'Amar', 'Ghale', 'Male', 22, 104, 'default.png', b'0', '2017-12-05 16:28:30'),
(7, 'Marcin97', '$2y$10$odLtgp2jPFrcmf11N1Bgje0kzDYgsSEDCN0zBLO0qIi1XqRUaEdZW', 'duszynskim97@gmail.com', 'Marcin', 'Duszysnki', 'Male', 20, 176, 'default.png', b'0', '2017-12-05 16:29:57'),
(8, 'ash', '$2y$10$po0LjuXrTsG1STBPXoCeCuZIisAyW2bFRbotn6fql39kf2Vy8mnTW', 'newmail@gmail.com', 'Akshat', 'Jen', 'Male', 99, 99, 'default.png', b'0', '2017-12-05 16:30:17'),
(9, 'CR7', '$2y$10$fAVvw2O6eGYSNsRitK4eouDNqN3PH.8j6uh9gultkT.8NPMMz9dQ.', 'iambetterthanmessy@gmail.com', 'Cristiano', 'Ronaldo', 'Male', 32, 177, 'default.png', b'0', '2017-12-05 16:30:37'),
(10, 'weiwei', '$2y$10$cWhZNVAWUerY4eSvrifcUOxTvjmY6l4Qw2FfspKnAZzoLq/UJmc0m', 'veon.3333@hotmail.com', 'Yap Wei', 'Kho', 'Male', 21, 133, 'default.png', b'0', '2017-12-06 00:18:48'),
(11, 'Jin', '$2y$10$hinXk6s1n9jeaBsKT55.6eN/TSPoBeiMvHwFaM1QO02nPgN9uAVie', 'jin@gmail.com', 'Jin', 'Lim', 'Male', 21, 104, 'default.png', b'0', '2017-12-09 20:47:10');

-- --------------------------------------------------------

--
-- Table structure for table `user_friends`
--

CREATE TABLE `user_friends` (
  `user_id` int(11) NOT NULL,
  `friends` text,
  `requests` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_friends`
--

INSERT INTO `user_friends` (`user_id`, `friends`, `requests`) VALUES
(1, '5,10', NULL),
(3, '5', NULL),
(4, NULL, NULL),
(5, '1,3', NULL),
(6, NULL, NULL),
(7, NULL, NULL),
(8, NULL, NULL),
(9, NULL, NULL),
(10, '1', NULL),
(11, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_institutions`
--

CREATE TABLE `user_institutions` (
  `user_id` int(11) NOT NULL,
  `institution_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_institutions`
--

INSERT INTO `user_institutions` (`user_id`, `institution_id`) VALUES
(1, 1),
(3, 1),
(4, 1),
(7, 1),
(8, 1),
(10, 1),
(11, 1),
(5, 2),
(6, 3),
(9, 3);

-- --------------------------------------------------------

--
-- Table structure for table `user_interests`
--

CREATE TABLE `user_interests` (
  `user_id` int(11) NOT NULL,
  `interests` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_interests`
--

INSERT INTO `user_interests` (`user_id`, `interests`) VALUES
(1, NULL),
(3, '2,3,6,10,5'),
(4, '2,10'),
(5, NULL),
(6, '2,9,6,11,10,8,5'),
(7, '4,2,3,8'),
(8, '4,2,3,7,9,6,11,10,8,5'),
(9, '4,7,6,11,10'),
(10, '4,2,3,7,9,6,11,10,8,5'),
(11, '2,7,9,11,8,5');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`country_id`);

--
-- Indexes for table `ghost_answer_submit`
--
ALTER TABLE `ghost_answer_submit`
  ADD KEY `room_id` (`room_id`),
  ADD KEY `voter` (`voter`);

--
-- Indexes for table `ghost_game_time`
--
ALTER TABLE `ghost_game_time`
  ADD KEY `room_id` (`room_id`);

--
-- Indexes for table `ghost_message`
--
ALTER TABLE `ghost_message`
  ADD PRIMARY KEY (`message_id`);

--
-- Indexes for table `ghost_msg_player_room`
--
ALTER TABLE `ghost_msg_player_room`
  ADD KEY `message_id` (`message_id`),
  ADD KEY `room_id` (`room_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `ghost_room`
--
ALTER TABLE `ghost_room`
  ADD PRIMARY KEY (`room_id`),
  ADD KEY `word_pair_id` (`word_pair_id`),
  ADD KEY `interest_id` (`interest_id`);

--
-- Indexes for table `ghost_room_players`
--
ALTER TABLE `ghost_room_players`
  ADD KEY `user_id` (`user_id`),
  ADD KEY `user_id_2` (`user_id`),
  ADD KEY `room_id` (`room_id`);

--
-- Indexes for table `ghost_word_pair`
--
ALTER TABLE `ghost_word_pair`
  ADD PRIMARY KEY (`word_pair_id`),
  ADD KEY `interest_id` (`interest_id`);

--
-- Indexes for table `institutions`
--
ALTER TABLE `institutions`
  ADD PRIMARY KEY (`institution_id`);

--
-- Indexes for table `interests`
--
ALTER TABLE `interests`
  ADD PRIMARY KEY (`interest_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`) USING BTREE,
  ADD KEY `user_id` (`user_id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `post_comments`
--
ALTER TABLE `post_comments`
  ADD PRIMARY KEY (`comment_id`) USING BTREE,
  ADD KEY `post_id` (`post_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `country_id` (`country_id`);

--
-- Indexes for table `user_friends`
--
ALTER TABLE `user_friends`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user_institutions`
--
ALTER TABLE `user_institutions`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `institution_id` (`institution_id`);

--
-- Indexes for table `user_interests`
--
ALTER TABLE `user_interests`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `country_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=246;

--
-- AUTO_INCREMENT for table `ghost_message`
--
ALTER TABLE `ghost_message`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=212;

--
-- AUTO_INCREMENT for table `ghost_room`
--
ALTER TABLE `ghost_room`
  MODIFY `room_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ghost_word_pair`
--
ALTER TABLE `ghost_word_pair`
  MODIFY `word_pair_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `institutions`
--
ALTER TABLE `institutions`
  MODIFY `institution_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `interests`
--
ALTER TABLE `interests`
  MODIFY `interest_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `post_comments`
--
ALTER TABLE `post_comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ghost_answer_submit`
--
ALTER TABLE `ghost_answer_submit`
  ADD CONSTRAINT `ghost_answer_submit_ibfk_1` FOREIGN KEY (`room_id`) REFERENCES `ghost_room` (`room_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ghost_answer_submit_ibfk_2` FOREIGN KEY (`voter`) REFERENCES `users` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `ghost_game_time`
--
ALTER TABLE `ghost_game_time`
  ADD CONSTRAINT `ghost_game_time_ibfk_1` FOREIGN KEY (`room_id`) REFERENCES `ghost_room` (`room_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ghost_msg_player_room`
--
ALTER TABLE `ghost_msg_player_room`
  ADD CONSTRAINT `ghost_msg_player_room_ibfk_1` FOREIGN KEY (`message_id`) REFERENCES `ghost_message` (`message_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ghost_msg_player_room_ibfk_2` FOREIGN KEY (`room_id`) REFERENCES `ghost_room` (`room_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ghost_msg_player_room_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ghost_room`
--
ALTER TABLE `ghost_room`
  ADD CONSTRAINT `ghost_room_ibfk_1` FOREIGN KEY (`interest_id`) REFERENCES `interests` (`interest_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `room_ibfk_1` FOREIGN KEY (`word_pair_id`) REFERENCES `ghost_word_pair` (`word_pair_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ghost_room_players`
--
ALTER TABLE `ghost_room_players`
  ADD CONSTRAINT `ghost_room_players_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ghost_room_players_ibfk_2` FOREIGN KEY (`room_id`) REFERENCES `ghost_room` (`room_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ghost_word_pair`
--
ALTER TABLE `ghost_word_pair`
  ADD CONSTRAINT `ghost_word_pair_ibfk_1` FOREIGN KEY (`interest_id`) REFERENCES `interests` (`interest_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `posts_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `interests` (`interest_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `post_comments`
--
ALTER TABLE `post_comments`
  ADD CONSTRAINT `post_comments_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `post_comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_friends`
--
ALTER TABLE `user_friends`
  ADD CONSTRAINT `user_friends_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_institutions`
--
ALTER TABLE `user_institutions`
  ADD CONSTRAINT `user_institutions_ibfk_2` FOREIGN KEY (`institution_id`) REFERENCES `institutions` (`institution_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_institutions_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_interests`
--
ALTER TABLE `user_interests`
  ADD CONSTRAINT `user_interests_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
