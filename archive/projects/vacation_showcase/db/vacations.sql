-- phpMyAdmin SQL Dump
-- version 2.11.6
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 31, 2009 at 07:20 PM
-- Server version: 5.0.51
-- PHP Version: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `vacations`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(5) NOT NULL auto_increment,
  `username` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'vacations', 'dcf6c06de116fce0fb982eee39eb493e4fcd2c08');

-- --------------------------------------------------------

--
-- Table structure for table `home_page`
--

CREATE TABLE `home_page` (
  `id` int(5) NOT NULL auto_increment,
  `date` varchar(60) NOT NULL,
  `location` varchar(200) NOT NULL,
  `location2` varchar(200) NOT NULL,
  `headline` varchar(50) NOT NULL,
  `par1` text NOT NULL,
  `par2` text NOT NULL,
  `footer` text NOT NULL,
  `aboutus_desc` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `home_page`
--

INSERT INTO `home_page` (`id`, `date`, `location`, `location2`, `headline`, `par1`, `par2`, `footer`, `aboutus_desc`) VALUES
(1, 'Sunday, May 3 from 12-6pm', 'Hiller Aviation Museum', 'Los Angeles (101@Holly Exit)', 'NOW is the time!', '<p>Come to the <strong>2009 Vacation Showcase</strong> and you can plan and book that vacation you so well deserve. It has been a tough year for all of us and there is no better time than now to see that at this Vacation Expo you can find a vacation you can afford. There are travel deals available that we have not seen in years and Peninsula Travel Experts can find the best that work for you.</p>', '<p>With lots of travel resources in one place, you''ll find it easy and fun to plan and book your next dream vacation. Take advantage of Special Day of Show Offers including discounts and upgrades along with additional amenities. In most cases, we can combine promotional offers and past passenger savings from our cruise and tour partners - giving you the best vacation AND unbeatable value you can''t find anywhere else.</p>', '<p><strong>Free</strong> Travel Seminars</p>\r\n<p>and</p>\r\n<p><em>Exclusive Travel Specials and Discounts on:</em></p>\r\n<p>Cruises, Vacation Packages, Tours</p>', 'Peninsula Travel Experts is a networking group of local San Francisco mid-peninsula travel specialists who have more than 50 years of combined experience from personal travel, hotel inspection trips and travel destination seminars/certification. We take our job of planning travel for our important clients very serious and carry it out with the highest integrity.');

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `mailid` int(11) NOT NULL,
  `path` char(100) NOT NULL,
  `mimetype` char(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`mailid`, `path`, `mimetype`) VALUES
(2, 'chart.gif', 'image/gif'),
(3, 'chart.gif', 'image/gif'),
(3, 'pyramid.gif', 'image/gif'),
(27, 'chart.gif', 'image/gif');

-- --------------------------------------------------------

--
-- Table structure for table `lists`
--

CREATE TABLE `lists` (
  `listid` int(11) NOT NULL auto_increment,
  `listname` char(20) NOT NULL,
  `blurb` varchar(255) default NULL,
  PRIMARY KEY  (`listid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

--
-- Dumping data for table `lists`
--

INSERT INTO `lists` (`listid`, `listname`, `blurb`) VALUES
(5, 'Expo Visitors', 'People Visiting'),
(6, 'Expo Vendors', 'Vendors at Expo'),
(19, 'Test Lists', 'test list info'),
(21, 'Public Relations', 'dfgdfgdfg'),
(22, 'Cool Dudes', 'sdfsdf');

-- --------------------------------------------------------

--
-- Table structure for table `mail`
--

CREATE TABLE `mail` (
  `mailid` int(11) NOT NULL auto_increment,
  `email` char(100) NOT NULL,
  `subject` char(100) NOT NULL,
  `listid` int(11) NOT NULL,
  `status` char(10) NOT NULL,
  `sent` datetime default NULL,
  `modified` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`mailid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;

--
-- Dumping data for table `mail`
--

INSERT INTO `mail` (`mailid`, `email`, `subject`, `listid`, `status`, `sent`, `modified`) VALUES
(15, 'admin@localhost', 'Test Email', 19, 'SENT', '2009-10-31 02:58:38', '2009-10-31 02:58:38'),
(16, 'admin@localhost', 'mail2', 19, 'SENT', '2009-10-31 03:05:00', '2009-10-31 03:05:00'),
(17, 'admin@localhost', 'mail3', 19, 'SENT', '2009-10-31 03:10:28', '2009-10-31 03:10:28'),
(18, 'admin@localhost', 'mail3', 19, 'SENT', '2009-10-31 03:12:51', '2009-10-31 03:12:51'),
(19, 'admin@localhost', 'ghgfh', 6, 'SENT', '2009-10-31 03:16:14', '2009-10-31 03:16:14'),
(20, 'admin@localhost', 'Text mail', 6, 'SENT', '2009-10-31 03:17:26', '2009-10-31 03:17:26'),
(21, 'admin@localhost', 'HTML email', 6, 'SENT', '2009-10-31 03:18:02', '2009-10-31 03:18:02'),
(22, 'admin@localhost', 'HTML email', 19, 'SENT', '2009-10-31 03:19:23', '2009-10-31 03:19:23'),
(23, 'admin@localhost', 'Text email', 19, 'SENT', '2009-10-31 03:19:58', '2009-10-31 03:19:58'),
(24, 'admin@localhost', 'yyyyy', 19, 'SENT', '2009-10-31 03:26:54', '2009-10-31 03:26:54'),
(25, 'admin@localhost', 'fhgfhgf', 6, 'SENT', '2009-10-31 03:31:50', '2009-10-31 03:31:50'),
(26, 'admin@localhost', 'hjghjh', 5, 'SENT', '2009-10-31 03:32:12', '2009-10-31 03:32:12'),
(27, 'admin@localhost', 'No Login Email Test', 5, 'SENT', '2009-10-31 05:34:05', '2009-10-31 05:34:05'),
(28, 'admin@localhost', 'yyyyyyyyyyyyyyyyyyyyyyyyy', 5, 'SENT', '2009-10-31 05:37:19', '2009-10-31 05:37:19'),
(29, '', 'Yo I rock', 21, 'SENT', '2009-10-31 15:38:02', '2009-10-31 15:38:02'),
(30, '', 'YO whatup i want pick-aaaaap', 22, 'SENT', '2009-10-31 16:48:01', '2009-10-31 16:48:01');

-- --------------------------------------------------------

--
-- Table structure for table `participants`
--

CREATE TABLE `participants` (
  `id` int(5) NOT NULL auto_increment,
  `name` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `extra_line` varchar(500) NOT NULL,
  `link` varchar(200) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `participants`
--

INSERT INTO `participants` (`id`, `name`, `description`, `extra_line`, `link`) VALUES
(1, 'Carnival Cruise Lines', 'Every one of Carnival''s "Fun Ships"® is a unique floating resort designed with your fun in mind. Venture out of your spacious stateroom and experience the outdoor areas, restaurants, friendly casino, relaxing lounges, invigorating spa and exciting nightclubs, plus new supper clubs and some upscale surprises.', '', 'www.carnival.com'),
(2, 'Disney Destinations ††', 'Since 1952, Disney Destinations have played just home to Disney''s beloved characters. Wherever a Guest experience takes place - in a Disney park, on the high seas with Disney Cruise Line or on a guided tour of exotic locales with Adventures by Disney, Disney is dedicated to the promise that its Cast members turn the ordinary into the extraordinary. Making dreams come true every day is central to the Guest experience with Disney Destinations. ', '†† Includes Adventures by Disney, Disney Cruise Line and Disney Resorts.', 'www.disney.com'),
(3, 'Holland America Line', 'Step away from the everyday into a world of elegance and comfort. Spacious and luxurious, the five-star ships of Holland America Line deliver the finest in dining, accommodations, service, activities and award-winning enrichment programs. This is cruising the way it was meant to be.', '', ''),
(4, 'Insight Vacations', 'The travel professionals at Insight Vacations have mastered the art of touring in style. Carefully chosen itineraries and impeccable service standards let you savor the vibrant culture, exquisite art, delectable dining, historical wonders, fantastic architecture and breathtaking sights of the world''s greatest destinations. ', '', ''),
(5, 'Pleasant Holidays', 'With almost 50 years experience, Pleasant Holidays specializes\r\nin vacations to Hawaii, Mexico, Caribbean, Europe, Australia,\r\nNew Zealand, Asia, South Pacific, Las Vegas and Costa Rica.\r\nThese travel brands offer a wide variety of travel products from\r\neconomy to luxury vacation packages at affordable prices, while\r\ndelivering exceptional customer service. The Pleasant Holidays\r\nbrands have sold over 9 million vacation packages since 1959.', '', ''),
(6, 'Royal Caribbean International', 'Get ready to be amazed. As soon as you board a Royal Caribbean ship, you''ll see that this isn''t an ordinary cruise. Royal Caribbean gives you an experience packed with adventure and discovery. You''ll always have plenty to do, and have a great time doing it! What are you waiting for? It''s time to get out there.  \r\n\r\nRoyal Caribbean currently has 20 ships with three sisterships currently being the largest in the world. RCCL is an industry leader in innovative, unexpected onboard activities and amenities, from fleetwide rock-climbing walls to state-of-the-art fitness centers and spas to dedicated Internet connections in guest staterooms. In 2010 RCCL will introduce the largest oceanliner in the world.', '', ''),
(7, 'Collette Tours', 'From Branson to Beijing, Collette Vacations travels to more than 150 destinations on all seven continents. Collette also offer Explorations by Collette, small-group tours with a maximum of only 16 - 24 passengers that wander off the beaten path. Exploration tours feature boutique hotels, outdoor activities and interaction with local people.', '', ''),
(8, 'Wine Tours of the World', 'Wine Tours of the World is a full-service tour operator.  They specialize in hand-crafting custom itineraries to the top wine regions around the world. You decide who travels with you. You can travel solo, in couples or with many. They will pick the transportation type that best suits the size of your group. You may travel by private car, rail, bicycle, moped or limo.', '', ''),
(9, 'Apple Vacations', 'dvdsvdsvdscds dsf dsfdsf dsfdfdsfdsfdsf tytr ytr ytrh b fdb\r\ndvbfd bvcb vcb vcbvxcb x fgvfgf g  gtt tretrgfdgfdhfdgjhgf', '', 'www.applevacations.com'),
(10, 'Mexico Unlimited', 'Whether you are looking for a white sand beach on which to relax, or fascinating Aztec and Mayan ruins to explore, Mexico Unlimited, in business since 1985, prides itself in bringing together all the elements necessary to assure you an enjoyable and hassle-free vacation. Their company motto, "Quality Vacations at Economy Prices".', '', ''),
(11, 'Seabourn', 'The Yachts of Seabourn have earned international renown for unmatched style, elegance and grace on the seas. Each of the three existing yachts - Pride, Spirit and Legend - are ultra-luxury, all-suite vessels that accent voyages with extraordinary levels of personalized service, including a staff-to-guest ratio of nearly one-to-one. The same will be true on a new class of three Seabourn yachts whose anticipated launch begins with Seabourn Odyssey in June 2009.', '', ''),
(12, 'Club Med', 'Club Med all-inclusive family vacations. With resorts around the\r\nworld for families, couples, groups of friends or traveling\r\nsolo. Club Med. Where happiness means the world. Cuisine,\r\ncocktails and carefree activities are there whenever you want\r\nthem. And thanks to Club MedÃƒÂ¯Ã‚Â¿Ã‚Â½s global collection of resorts,\r\nyouÃƒÂ¯Ã‚Â¿Ã‚Â½re also free to enjoy these pleasures in over 80 locations\r\nworldwide.', '', 'www.clubmed.com'),
(14, 'New Vendor NEW', 'fgfdgfdgfdgfd', '', '65665');

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `id` int(5) NOT NULL auto_increment,
  `presenter` varchar(55) NOT NULL,
  `startTime` time NOT NULL,
  `endTime` time NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=44 ;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`id`, `presenter`, `startTime`, `endTime`) VALUES
(38, 'Norwegian / Carnival / Holland America Cruises', '12:20:00', '12:50:00'),
(39, 'Collete Vacations', '13:00:00', '13:20:00'),
(40, 'All-Inclusive Vacations / Apple Vacations', '13:30:00', '13:50:00'),
(42, 'Disney Vacations & Cruises', '14:00:00', '14:20:00');

-- --------------------------------------------------------

--
-- Table structure for table `subscribers`
--

CREATE TABLE `subscribers` (
  `email` char(100) NOT NULL,
  `realname` char(100) NOT NULL,
  `mimetype` char(1) NOT NULL,
  `password` char(40) NOT NULL,
  `admin` tinyint(4) NOT NULL,
  PRIMARY KEY  (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subscribers`
--

INSERT INTO `subscribers` (`email`, `realname`, `mimetype`, `password`, `admin`) VALUES
('admin@localhost', 'Administrative User', 'H', 'd033e22ae348aeb5660fc2140aec35850c4da997', 1),
('zeckdude@gmail.com', 'Chris', 'H', 'f13d3592f9ade91d39a0796d666f73b76a3da2a7', 0),
('chrisseckler@gmail.com', 'Chris Seckler', 'T', '', 0),
('zeckduder@yahoo.com', 'fgfdgfd', 'H', '', 0),
('mhmh1985@gmail.com', 'Martino', 'H', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `sub_lists`
--

CREATE TABLE `sub_lists` (
  `email` char(100) NOT NULL,
  `listid` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sub_lists`
--

INSERT INTO `sub_lists` (`email`, `listid`) VALUES
('chrisseckler@gmail.com', 19),
('cfgc', 6),
('cfgc', 5),
('mhmh1985@gmail.com', 22),
('fgfg', 19),
('zeckduder@yahoo.com', 5),
('zeckdude@gmail.com', 21);

-- --------------------------------------------------------

--
-- Table structure for table `travelagents`
--

CREATE TABLE `travelagents` (
  `travelagent_id` int(5) NOT NULL auto_increment,
  `name` varchar(50) NOT NULL,
  `company_name` varchar(100) NOT NULL,
  `phone` varchar(30) NOT NULL,
  `email` varchar(100) NOT NULL,
  `cst` int(10) NOT NULL,
  PRIMARY KEY  (`travelagent_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `travelagents`
--

INSERT INTO `travelagents` (`travelagent_id`, `name`, `company_name`, `phone`, `email`, `cst`) VALUES
(1, 'Pam Harper Horst', 'Pams Path to Travel', '6503636156', 'pam@pamstravel.net', 2076527),
(2, 'Perdana Anwar', 'whatever', '56784322', 'sdsd@dsds.com', 56732),
(3, 'dsfsdf', 'sdfsdf', '43534534', 'sdfsdf@dfsdf.com', 345234),
(5, 'dfdsf', 'sfd', '345435', 'sfdsf@sfds.com65', 546634),
(6, 'fgfdgfd', 'hjkhjkhjk', '5435435', 'tjghj@dfgfdg.com', 576657),
(7, 'fhgfh', 'wqeqwewq', 'vbvcb@sfsf.com', 'zzzz@aaa.com', 45454),
(8, 'gfdg', 'dfgfdg', '576577', 'sfddsf@sfdsf.com', 7657),
(9, 'ghjghjghj', 'ssfdsf', '67876876', 'sfds@sfdsf.com', 456546);
