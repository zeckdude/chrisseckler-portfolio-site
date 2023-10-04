-- phpMyAdmin SQL Dump
-- version 2.11.6
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 15, 2009 at 07:25 AM
-- Server version: 5.0.51
-- PHP Version: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `auction`
--

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `image_id` tinyint(4) NOT NULL auto_increment,
  `image_filename` varchar(400) NOT NULL,
  PRIMARY KEY  (`image_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`image_id`, `image_filename`) VALUES
(1, 'alberto_korda_guerrillero_heroico.jpg'),
(2, 'annie_leibowitz_rolling_stones.jpg'),
(3, 'ansel_adams_jeffrey_pine.jpg'),
(4, 'berenice_abbott_flatiron_building.jpg'),
(5, 'dave_hill_untitled.jpg'),
(6, 'diane_arbus_identical_twins.jpg'),
(7, 'dorothea_lange_migrant_mother.jpg'),
(8, 'edward_curtis_indian.jpg'),
(9, 'henri_cartier_bresson_palais_royal.jpg'),
(10, 'james_nachtwey_torture_in_rwanda.jpg'),
(11, 'joey_lawrence_untitled.jpg'),
(12, 'margaret_bourke_white_inmates_at_buchenwald.jpg'),
(13, 'mary_ellen_mark_amanda_and_her_cousin.jpg'),
(14, 'pete_turner_new_dawn.jpg'),
(15, 'pete_turner_the_quiet_american.jpg'),
(16, 'richard_avedon_beekeeper.jpg'),
(17, 'robert_capa_d_day.jpg'),
(18, 'robert_frank_was_ist_das.jpg'),
(19, 'walker_evans_allie_mae_burroughs.jpg'),
(20, 'Sunset.jpg'),
(21, 'andyincar.jpg'),
(22, 'Water_lilies.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `photographerimgs`
--

CREATE TABLE `photographerimgs` (
  `photographerimg_id` tinyint(4) NOT NULL auto_increment,
  `photographerimg_filename` varchar(400) NOT NULL,
  PRIMARY KEY  (`photographerimg_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `photographerimgs`
--

INSERT INTO `photographerimgs` (`photographerimg_id`, `photographerimg_filename`) VALUES
(1, 'annie_leibowitz.jpg'),
(2, 'ansel_adams.jpg'),
(3, 'berenice_abbott.jpg'),
(4, 'dave_hill.jpg'),
(5, 'diane_arbus.jpg'),
(6, 'dorothea_lange.jpg'),
(7, 'edward_curtis.jpg'),
(8, 'henri_cartier_bresson.jpg'),
(9, 'joey_lawrence.jpg'),
(10, 'margaret_bourke_white.jpg'),
(11, 'pete_turner.jpg'),
(12, 'richard_avedon.jpg'),
(13, 'robert_frank.jpg'),
(14, 'walker_evans.jpg'),
(15, 'alberto_korda.jpg'),
(16, 'james_nachtwey.jpg'),
(17, 'mary_ellen_mark.jpg'),
(18, 'robert_capa.jpg'),
(19, 'Anton_Gravatar.jpg'),
(20, 'andyincar.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `photographers`
--

CREATE TABLE `photographers` (
  `photographer_id` tinyint(4) NOT NULL auto_increment,
  `photographer_name` varchar(30) NOT NULL,
  `photographer_image` varchar(50) NOT NULL,
  `photographer_desc` varchar(500) NOT NULL,
  `photographer_sitelink` varchar(200) NOT NULL,
  `photographerimg_id` tinyint(4) NOT NULL,
  PRIMARY KEY  (`photographer_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;

--
-- Dumping data for table `photographers`
--

INSERT INTO `photographers` (`photographer_id`, `photographer_name`, `photographer_image`, `photographer_desc`, `photographer_sitelink`, `photographerimg_id`) VALUES
(0, 'Annie Leibowitz', 'annie_leibowitz.jpg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis eget egestas quam. Ut ornare, ipsum congue sagittis eleifend, metus sem malesuada turpis, non imperdiet orci tellus in nunc. Sed ut justo ante, sed pretium erat. ', '', 1),
(2, 'Ansel Adams', 'ansel_adams.jpg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis eget egestas quam. Ut ornare, ipsum congue sagittis eleifend, metus sem malesuada turpis, non imperdiet orci tellus in nunc. Sed ut justo ante, sed pretium erat. ', '', 2),
(3, 'Berenice Abbott', 'berenice_abbott.jpg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis eget egestas quam. Ut ornare, ipsum congue sagittis eleifend, metus sem malesuada turpis, non imperdiet orci tellus in nunc. Sed ut justo ante, sed pretium erat. ', '', 3),
(4, 'Dave Hill', 'dave_hill.jpg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis eget egestas quam. Ut ornare, ipsum congue sagittis eleifend, metus sem malesuada turpis, non imperdiet orci tellus in nunc. Sed ut justo ante, sed pretium erat. ', '', 4),
(5, 'Diane Arbus', 'diane_arbus.jpg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis eget egestas quam. Ut ornare, ipsum congue sagittis eleifend, metus sem malesuada turpis, non imperdiet orci tellus in nunc. Sed ut justo ante, sed pretium erat. ', '', 5),
(6, 'Dorothea Lange', 'dorothea_lange.jpg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis eget egestas quam. Ut ornare, ipsum congue sagittis eleifend, metus sem malesuada turpis, non imperdiet orci tellus in nunc. Sed ut justo ante, sed pretium erat. ', '', 6),
(7, 'Edward Curtis', 'edward_curtis.jpg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis eget egestas quam. Ut ornare, ipsum congue sagittis eleifend, metus sem malesuada turpis, non imperdiet orci tellus in nunc. Sed ut justo ante, sed pretium erat. ', '', 7),
(8, 'Henri Cartier-Bresson', 'henri_cartier_bresson.jpg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis eget egestas quam. Ut ornare, ipsum congue sagittis eleifend, metus sem malesuada turpis, non imperdiet orci tellus in nunc. Sed ut justo ante, sed pretium erat. ', '', 8),
(9, 'Joey Lawrence', 'joey_lawrence.jpg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis eget egestas quam. Ut ornare, ipsum congue sagittis eleifend, metus sem malesuada turpis, non imperdiet orci tellus in nunc. Sed ut justo ante, sed pretium erat. ', '', 9),
(10, 'Margaret Bourke-White', 'margaret_bourke_white.jpg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis eget egestas quam. Ut ornare, ipsum congue sagittis eleifend, metus sem malesuada turpis, non imperdiet orci tellus in nunc. Sed ut justo ante, sed pretium erat. ', '', 10),
(11, 'Pete Turner', 'pete_turner.jpg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis eget egestas quam. Ut ornare, ipsum congue sagittis eleifend, metus sem malesuada turpis, non imperdiet orci tellus in nunc. Sed ut justo ante, sed pretium erat. ', '', 11),
(12, 'Richard Avedon', 'richard_avedon.jpg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis eget egestas quam. Ut ornare, ipsum congue sagittis eleifend, metus sem malesuada turpis, non imperdiet orci tellus in nunc. Sed ut justo ante, sed pretium erat. ', '', 12),
(13, 'Robert Frank', 'robert_frank.jpg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis eget egestas quam. Ut ornare, ipsum congue sagittis eleifend, metus sem malesuada turpis, non imperdiet orci tellus in nunc. Sed ut justo ante, sed pretium erat. ', '', 13),
(14, 'Walker Evans', 'walker_evans.jpg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis eget egestas quam. Ut ornare, ipsum congue sagittis eleifend, metus sem malesuada turpis, non imperdiet orci tellus in nunc. Sed ut justo ante, sed pretium erat. ', '', 14),
(15, 'Alberto Korda', 'alberto_korda.jpg', 'vsdvsdvsd', '', 15),
(16, 'James Nachtwey', 'james_nachtwey.jpg', 'sdfsdfsd', '', 16),
(17, 'Mary Ellen Mark', 'mary_ellen_mark.jpg', 'sfdfsdfsd', '', 17),
(18, 'Robert Capa', 'robert_capa.jpg', 'fgdfgdfg', '', 18),
(30, '', '', '', '', 3);

-- --------------------------------------------------------

--
-- Table structure for table `photos`
--

CREATE TABLE `photos` (
  `photo_id` tinyint(4) NOT NULL auto_increment,
  `photo_title` varchar(50) NOT NULL,
  `photo_desc` varchar(500) NOT NULL,
  `photo_signed` tinyint(1) NOT NULL,
  `photo_dateshot` int(4) NOT NULL,
  `photo_price` int(8) NOT NULL,
  `photo_worth` int(8) NOT NULL,
  `photo_width` int(4) NOT NULL,
  `photo_height` int(4) NOT NULL,
  `photographer_id` tinyint(4) NOT NULL,
  `style_id` tinyint(4) NOT NULL,
  `type_id` tinyint(4) NOT NULL,
  `image_id` tinyint(4) NOT NULL,
  PRIMARY KEY  (`photo_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=32 ;

--
-- Dumping data for table `photos`
--

INSERT INTO `photos` (`photo_id`, `photo_title`, `photo_desc`, `photo_signed`, `photo_dateshot`, `photo_price`, `photo_worth`, `photo_width`, `photo_height`, `photographer_id`, `style_id`, `type_id`, `image_id`) VALUES
(1, 'Rolling Stone Cover', 'Its a basin', 0, 0, 10, 0, 0, 0, 0, 3, 2, 2),
(2, 'Jeffrey Pine', 'Its some fountains', 0, 0, 10, 0, 0, 0, 2, 2, 1, 3),
(4, 'Untitled', 'Its a Maiko', 0, 0, 25, 0, 0, 0, 4, 3, 2, 5),
(5, 'Identical Twins', 'Shes on the phone again', 0, 0, 2, 0, 0, 0, 5, 2, 2, 6),
(6, 'Migrant Mother', 'Ooh look at all the goodies', 0, 0, 55, 0, 0, 0, 6, 1, 1, 7),
(7, 'Indian', 'Yo whatup Monk', 0, 0, 40, 0, 0, 0, 7, 3, 3, 8),
(8, 'Palais Royal', 'Whats a Ryonji', 0, 0, 3, 0, 0, 0, 8, 2, 1, 9),
(9, 'Torture in Rwanda', 'asdasd', 0, 0, 45, 0, 0, 0, 16, 3, 1, 10),
(10, 'Untitled', 'czxcx', 0, 0, 22, 0, 0, 0, 9, 2, 3, 11),
(11, 'Inmates at Buchenwald', 'sfsdfdf', 0, 0, 500, 0, 0, 0, 10, 1, 3, 12),
(12, 'Amanda and her Cousin', 'asdasds', 0, 0, 245, 0, 0, 0, 17, 2, 1, 13),
(13, 'New Dawn', 'sfsdfsd', 0, 0, 600, 0, 0, 0, 11, 1, 1, 14),
(14, 'The Quiet American', 'xcvxcv', 0, 0, 1000, 0, 0, 0, 11, 3, 3, 15),
(15, 'Beekeeper', 'fsdsdf', 0, 0, 555, 0, 0, 0, 12, 2, 3, 16),
(16, 'D-Day 1944', 'asdasdasd', 0, 0, 700, 0, 0, 0, 18, 3, 2, 17),
(17, 'Was ist das?', 'sdfsdfsd', 0, 0, 225, 0, 0, 0, 13, 3, 1, 18),
(18, 'Allie Mae Burroughs', 'sfsdfsdf', 0, 0, 35, 0, 0, 0, 14, 3, 1, 19),
(19, 'Guerrillero Heroico', 'dfsdfsdfs', 0, 0, 20, 0, 0, 0, 15, 3, 2, 1),
(21, 'Flat Iron Building', 'sdfsdfsd', 0, 0, 10, 0, 0, 0, 3, 2, 1, 4);

-- --------------------------------------------------------

--
-- Table structure for table `styles`
--

CREATE TABLE `styles` (
  `style_id` tinyint(4) NOT NULL auto_increment,
  `style_name` varchar(50) NOT NULL,
  `style_desc` varchar(500) NOT NULL,
  PRIMARY KEY  (`style_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `styles`
--

INSERT INTO `styles` (`style_id`, `style_name`, `style_desc`) VALUES
(1, 'B&W', ''),
(2, 'Wildlife', ''),
(3, 'Photo Journalism', ''),
(4, 'New Style', '');

-- --------------------------------------------------------

--
-- Table structure for table `types`
--

CREATE TABLE `types` (
  `type_id` tinyint(4) NOT NULL auto_increment,
  `type_name` varchar(50) NOT NULL,
  `type_desc` varchar(500) NOT NULL,
  PRIMARY KEY  (`type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `types`
--

INSERT INTO `types` (`type_id`, `type_name`, `type_desc`) VALUES
(1, 'Digital Print', ''),
(2, 'Metallic Print', ''),
(3, 'Other Print', ''),
(4, 'Golden', '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` tinyint(4) NOT NULL auto_increment,
  `user_email` varchar(50) NOT NULL,
  `user_password` varchar(20) NOT NULL,
  `user_firstname` varchar(50) NOT NULL,
  `user_middlename` varchar(50) NOT NULL,
  `user_lastname` varchar(100) NOT NULL,
  `user_address` varchar(200) NOT NULL,
  `user_phone` varchar(50) NOT NULL,
  `user_cc` varchar(20) NOT NULL,
  `user_cv2` int(3) NOT NULL,
  PRIMARY KEY  (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `users`
--

