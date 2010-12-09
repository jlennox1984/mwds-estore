-- phpMyAdmin SQL Dump
-- version 2.8.0.1
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: Aug 20, 2007 at 02:12 PM
-- Server version: 4.1.20
-- PHP Version: 4.3.11
-- 
-- Database: `jom5_storefontdemo`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `jos_banner`
-- 

CREATE TABLE `jos_banner` (
  `bid` int(11) NOT NULL auto_increment,
  `cid` int(11) NOT NULL default '0',
  `type` varchar(90) NOT NULL default 'banner',
  `name` text NOT NULL,
  `imptotal` int(11) NOT NULL default '0',
  `impmade` int(11) NOT NULL default '0',
  `clicks` int(11) NOT NULL default '0',
  `imageurl` varchar(100) NOT NULL default '',
  `clickurl` varchar(200) NOT NULL default '',
  `date` datetime default NULL,
  `showBanner` tinyint(1) NOT NULL default '0',
  `checked_out` tinyint(1) NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `editor` varchar(150) default NULL,
  `custombannercode` text,
  `catid` int(10) unsigned NOT NULL default '0',
  `description` text NOT NULL,
  `sticky` tinyint(1) unsigned NOT NULL default '0',
  `ordering` int(11) NOT NULL default '0',
  `publish_up` datetime NOT NULL default '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL default '0000-00-00 00:00:00',
  `tags` text NOT NULL,
  `params` text NOT NULL,
  PRIMARY KEY  (`bid`),
  KEY `viewbanner` (`showBanner`),
  KEY `idx_banner_catid` (`catid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `jos_banner`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `jos_bannerclient`
-- 

CREATE TABLE `jos_bannerclient` (
  `cid` int(11) NOT NULL auto_increment,
  `name` text NOT NULL,
  `contact` text NOT NULL,
  `email` varchar(255) NOT NULL default '',
  `extrainfo` text NOT NULL,
  `checked_out` tinyint(1) NOT NULL default '0',
  `checked_out_time` time default NULL,
  `editor` varchar(150) default NULL,
  PRIMARY KEY  (`cid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `jos_bannerclient`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `jos_bannertrack`
-- 

CREATE TABLE `jos_bannertrack` (
  `track_date` date NOT NULL default '0000-00-00',
  `track_type` int(10) unsigned NOT NULL default '0',
  `banner_id` int(10) unsigned NOT NULL default '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `jos_bannertrack`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `jos_categories`
-- 

CREATE TABLE `jos_categories` (
  `id` int(11) NOT NULL auto_increment,
  `parent_id` int(11) NOT NULL default '0',
  `title` text NOT NULL,
  `name` text NOT NULL,
  `image` varchar(255) NOT NULL default '',
  `section` varchar(150) NOT NULL default '',
  `image_position` varchar(90) NOT NULL default '',
  `description` text NOT NULL,
  `published` tinyint(1) NOT NULL default '0',
  `checked_out` int(11) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `editor` varchar(150) default NULL,
  `ordering` int(11) NOT NULL default '0',
  `access` tinyint(3) unsigned NOT NULL default '0',
  `count` int(11) NOT NULL default '0',
  `params` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `cat_idx` (`section`,`published`,`access`),
  KEY `idx_section` (`section`),
  KEY `idx_access` (`access`),
  KEY `idx_checkout` (`checked_out`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- 
-- Dumping data for table `jos_categories`
-- 

INSERT INTO `jos_categories` VALUES (1, 0, 'General', 'General', '', '1', 'left', '', 1, 0, '0000-00-00 00:00:00', NULL, 1, 0, 0, '');

-- --------------------------------------------------------

-- 
-- Table structure for table `jos_components`
-- 

CREATE TABLE `jos_components` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(150) NOT NULL default '',
  `link` varchar(255) NOT NULL default '',
  `menuid` int(11) unsigned NOT NULL default '0',
  `parent` int(11) unsigned NOT NULL default '0',
  `admin_menu_link` varchar(255) NOT NULL default '',
  `admin_menu_alt` text NOT NULL,
  `option` varchar(50) NOT NULL default '',
  `ordering` int(11) NOT NULL default '0',
  `admin_menu_img` varchar(255) NOT NULL default '',
  `iscore` tinyint(4) NOT NULL default '0',
  `params` text NOT NULL,
  `enabled` tinyint(4) NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=35 ;

-- 
-- Dumping data for table `jos_components`
-- 

INSERT INTO `jos_components` VALUES (1, 'Banners', '', 0, 0, '', 'Banner Management', 'com_banners', 0, 'js/ThemeOffice/component.png', 0, '', 1);
INSERT INTO `jos_components` VALUES (2, 'Banners', '', 0, 1, 'option=com_banners', 'Active Banners', 'com_banners', 1, 'js/ThemeOffice/edit.png', 0, '', 1);
INSERT INTO `jos_components` VALUES (3, 'Clients', '', 0, 1, 'option=com_banners&c=client', 'Manage Clients', 'com_banners', 2, 'js/ThemeOffice/categories.png', 0, '', 1);
INSERT INTO `jos_components` VALUES (4, 'Web Links', 'option=com_weblinks', 0, 0, '', 'Manage Weblinks', 'com_weblinks', 0, 'js/ThemeOffice/component.png', 0, '', 1);
INSERT INTO `jos_components` VALUES (5, 'Links', '', 0, 4, 'option=com_weblinks', 'View existing weblinks', 'com_weblinks', 1, 'js/ThemeOffice/edit.png', 0, '', 1);
INSERT INTO `jos_components` VALUES (6, 'Categories', '', 0, 4, 'option=com_categories&section=com_weblinks', 'Manage weblink categories', '', 2, 'js/ThemeOffice/categories.png', 0, '', 1);
INSERT INTO `jos_components` VALUES (7, 'Contacts', 'option=com_contact', 0, 0, '', 'Edit contact details', 'com_contact', 0, 'js/ThemeOffice/component.png', 1, '', 1);
INSERT INTO `jos_components` VALUES (8, 'Contacts', '', 0, 7, 'option=com_contact', 'Edit contact details', 'com_contact', 0, 'js/ThemeOffice/edit.png', 1, '', 1);
INSERT INTO `jos_components` VALUES (9, 'Categories', '', 0, 7, 'option=com_categories&section=com_contact_details', 'Manage contact categories', '', 2, 'js/ThemeOffice/categories.png', 1, '', 1);
INSERT INTO `jos_components` VALUES (10, 'Polls', 'option=com_poll', 0, 0, 'option=com_poll', 'Manage Polls', 'com_poll', 0, 'js/ThemeOffice/component.png', 0, '', 1);
INSERT INTO `jos_components` VALUES (11, 'News Feeds', 'option=com_newsfeeds', 0, 0, '', 'News Feeds Management', 'com_newsfeeds', 0, 'js/ThemeOffice/component.png', 0, '', 1);
INSERT INTO `jos_components` VALUES (12, 'Feeds', '', 0, 11, 'option=com_newsfeeds', 'Manage News Feeds', 'com_newsfeeds', 1, 'js/ThemeOffice/edit.png', 0, '', 1);
INSERT INTO `jos_components` VALUES (13, 'Categories', '', 0, 11, 'option=com_categories&section=com_newsfeeds', 'Manage Categories', '', 2, 'js/ThemeOffice/categories.png', 0, '', 1);
INSERT INTO `jos_components` VALUES (14, 'Login', 'option=com_login', 0, 0, '', '', 'com_login', 0, '', 1, '', 1);
INSERT INTO `jos_components` VALUES (15, 'Search', 'option=com_search', 0, 0, '', '', 'com_search', 0, '', 1, '', 1);
INSERT INTO `jos_components` VALUES (16, 'Categories', '', 0, 1, 'option=com_categories&section=com_banner', 'Categories', '', 3, '', 1, '', 1);
INSERT INTO `jos_components` VALUES (17, 'Wrapper', 'option=com_wrapper', 0, 0, '', 'Wrapper', 'com_wrapper', 0, '', 1, '', 1);
INSERT INTO `jos_components` VALUES (18, 'Mail To', '', 0, 0, '', '', 'com_mailto', 0, '', 1, '', 1);
INSERT INTO `jos_components` VALUES (19, 'Media Manager', '', 0, 0, 'option=com_media', 'Media Manager', 'com_media', 0, '', 1, 'upload_extensions=bmp,csv,doc,epg,gif,ico,jpg,odg,odp,ods,odt,pdf,png,ppt,swf,txt,xcf,xls,BMP,CSV,DOC,EPG,GIF,ICO,JPG,ODG,ODP,ODS,ODT,PDF,PNG,PPT,SWF,TXT,XCF,XLS\nupload_maxsize=10000000\n\n', 1);
INSERT INTO `jos_components` VALUES (20, 'Articles', 'option=com_content', 0, 0, '', '', 'com_content', 0, '', 1, 'shownoauth=0\nlink_titles=0\nreadmore=1\nvote=0\nhideAuthor=0\nhideCreateDate=0\nhideModifyDate=0\nhidePdf=0\nhidePrint=0\nhideEmail=0\nicons=1\nhits=1\n\n', 1);
INSERT INTO `jos_components` VALUES (21, 'Configuration Manager', '', 0, 0, '', 'Configuration', 'com_config', 0, '', 1, '', 1);
INSERT INTO `jos_components` VALUES (22, 'Installation Manager', '', 0, 0, '', 'Installer', 'com_installer', 0, '', 1, '', 1);
INSERT INTO `jos_components` VALUES (23, 'Lanuage Manager', '', 0, 0, '', 'Lanaguages', 'com_languages', 0, '', 1, '', 1);
INSERT INTO `jos_components` VALUES (24, 'Mass mail', '', 0, 0, '', 'Mass Mail', 'com_massmail', 0, '', 1, '', 1);
INSERT INTO `jos_components` VALUES (25, 'Menu Editor', '', 0, 0, '', 'Menu Editor', 'com_menus', 0, '', 1, '', 1);
INSERT INTO `jos_components` VALUES (26, 'Menu Manager', '', 0, 0, '', 'Menu Manager', 'com_menumanager', 0, '', 1, '', 1);
INSERT INTO `jos_components` VALUES (27, 'Messaging', '', 0, 0, '', 'Messages', 'com_messages', 0, '', 1, '', 1);
INSERT INTO `jos_components` VALUES (28, 'Modules Manager', '', 0, 0, '', 'Modules', 'com_modules', 0, '', 1, '', 1);
INSERT INTO `jos_components` VALUES (29, 'Plugin Manager', '', 0, 0, '', 'Plugins', 'com_plugins', 0, '', 1, '', 1);
INSERT INTO `jos_components` VALUES (30, 'Statistics', '', 0, 0, '', 'Statistics', 'com_statistics', 0, '', 1, '', 1);
INSERT INTO `jos_components` VALUES (31, 'Template Manager', '', 0, 0, '', 'Templates', 'com_templates', 0, '', 1, '', 1);
INSERT INTO `jos_components` VALUES (32, 'User Manager', '', 0, 0, '', 'Users', 'com_users', 0, '', 1, 'allowUserRegistration=1\nnew_usertype=Registered\nuseractivation=1\nfrontend_userparams=1\n\n', 1);
INSERT INTO `jos_components` VALUES (33, 'Cache Manager', '', 0, 0, '', 'Cache', 'com_cache', 0, '', 1, '', 1);
INSERT INTO `jos_components` VALUES (34, 'Control Panel', '', 0, 0, '', 'Control Panel', 'com_cpanel', 0, '', 1, '', 1);

-- --------------------------------------------------------

-- 
-- Table structure for table `jos_contact_details`
-- 

CREATE TABLE `jos_contact_details` (
  `id` int(11) NOT NULL auto_increment,
  `name` text NOT NULL,
  `con_position` text,
  `address` text,
  `suburb` text,
  `state` text,
  `country` text,
  `postcode` varchar(255) default NULL,
  `telephone` varchar(255) default NULL,
  `fax` varchar(255) default NULL,
  `misc` mediumtext,
  `image` varchar(255) default NULL,
  `imagepos` varchar(60) default NULL,
  `email_to` varchar(255) default NULL,
  `default_con` tinyint(1) unsigned NOT NULL default '0',
  `published` tinyint(1) unsigned NOT NULL default '0',
  `checked_out` int(11) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL default '0',
  `params` text NOT NULL,
  `user_id` int(11) NOT NULL default '0',
  `catid` int(11) NOT NULL default '0',
  `access` tinyint(3) unsigned NOT NULL default '0',
  `mobile` varchar(255) NOT NULL default '',
  `webpage` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `jos_contact_details`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `jos_content`
-- 

CREATE TABLE `jos_content` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `title` text NOT NULL,
  `title_alias` text NOT NULL,
  `introtext` mediumtext NOT NULL,
  `fulltext` mediumtext NOT NULL,
  `state` tinyint(3) NOT NULL default '0',
  `sectionid` int(11) unsigned NOT NULL default '0',
  `mask` int(11) unsigned NOT NULL default '0',
  `catid` int(11) unsigned NOT NULL default '0',
  `created` datetime NOT NULL default '0000-00-00 00:00:00',
  `created_by` int(11) unsigned NOT NULL default '0',
  `created_by_alias` text NOT NULL,
  `modified` datetime NOT NULL default '0000-00-00 00:00:00',
  `modified_by` int(11) unsigned NOT NULL default '0',
  `checked_out` int(11) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `publish_up` datetime NOT NULL default '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL default '0000-00-00 00:00:00',
  `images` text NOT NULL,
  `urls` text NOT NULL,
  `attribs` text NOT NULL,
  `version` int(11) unsigned NOT NULL default '1',
  `parentid` int(11) unsigned NOT NULL default '0',
  `ordering` int(11) NOT NULL default '0',
  `metakey` text NOT NULL,
  `metadesc` text NOT NULL,
  `access` int(11) unsigned NOT NULL default '0',
  `hits` int(11) unsigned NOT NULL default '0',
  `metadata` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `idx_section` (`sectionid`),
  KEY `idx_access` (`access`),
  KEY `idx_checkout` (`checked_out`),
  KEY `idx_state` (`state`),
  KEY `idx_catid` (`catid`),
  KEY `idx_mask` (`mask`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- 
-- Dumping data for table `jos_content`
-- 

INSERT INTO `jos_content` VALUES (1, 'Welcome to the Mahsie OSS Demo Site', 'Welcome to the Mahsie OSS Demo Site', '<p style="font-family: Arial,Helvetica,sans-serif; font-size: 12px">Mahsie Open Source Solutions Inc. is dedicated to bringing open source to those who need it most:  charities, non-profit organizations and small businesses.  Our initial line of open source solutions is designed for sectors and organizations for whom essential business tools were previously unavailable or unaffordable.  </p><p style="font-family: Arial,Helvetica,sans-serif; font-size: 12px">This site has been built to demonstrate the various open source applications Mahsie is currently implementing for our clients.  To find out more about Mahsie OSS Inc., please visit our <a href="http://www.mahsie.com">main web site</a> .  </p><p style="font-family: Arial,Helvetica,sans-serif; font-size: 12px">&nbsp;</p><p style="font-family: Arial,Helvetica,sans-serif; font-size: 12px">This site effectively demonstrates our key applications:</p><table border="0" cellspacing="3" cellpadding="2" width="90%"><tbody><tr><td width="50%"> <strong>Content Management System</strong> - This demonstration site is built using the Joomla Content Management System. It acts as a ''wrapper'' and common interface for our other applications, which are accessible from the menu above <strong>(Demo CRM is integrated with demo ERP).</strong><br /></td><td width="50%"><strong>Customer Relationship Management</strong> - This Customer Relationship Mangement application is built using the most established, mature and supported open source CRM suites, VTiger CRM. It is also integrated with the Mahsie ERP system and is the base for the fundraising, membership management and school registration systems. <br /></td></tr><tr><td> <strong>Enterprise Resource Planning </strong>- Mahsie took the very best open source Enterprise Resource Planning (ERP) system - webERP - and merged it with other applications to create an end-to-end solution for any business. Together with our customized VTiger CRM, our modified webERP system tracks everything from leads, quotes, orders, sales, inventory, shipping, warehousing, manufacturing, production and finance in one suite. It comes with various preformatted reports and several reporting tools and functions. Built around an industrial grade relational database, this is the perfect solution for any small to medium sized organization.</td><td> <strong>School Registration </strong>- the Mahsie School Registration System is designed for any school or organization that has ongoing classes to schedule. Track students, courses, teachers, transcripts and payments with one system - and more.  Built around a modified VTiger CRM installation<br /></td></tr><tr><td> <strong>Membership Registration System</strong> - Our Membership Registration System is perfect for any membership-based group. Easily track membership payments, individuals and families, multiple addresses, contact details, requests, forms and more.  Another modified VTiger CRM product.<br /></td><td> <strong>Fundraising Management System<em>(coming soon)</em></strong> - Our Fundraising Management System takes the best from VTiger CRM 5 and other fundraising systems and combines them into onto application. It tracks multiple, complex, many-to-many relationships between people and organizations, and includes features to manage campaigns and donations - both in-kind and in cash.</td></tr></tbody></table>', '', 1, 1, 0, 1, '2007-02-11 12:25:35', 62, '', '2007-02-20 00:59:51', 62, 0, '0000-00-00 00:00:00', '2007-02-08 01:00:00', '2009-02-27 05:00:00', '', '', 'pageclass_sfx=\nitem_title=1\nlink_titles=\nintrotext=1\nsection=0\nsection_link=0\ncategory=0\ncategory_link=0\nrating=\nauthor=\ncreatedate=\nmodifydate=\npdf=\nprint=\nemail=\nlanguage=en-GB\nkeyref=', 8, 0, 1, '', '', 0, 0, 'robots=\nauthor=');

-- --------------------------------------------------------

-- 
-- Table structure for table `jos_content_frontpage`
-- 

CREATE TABLE `jos_content_frontpage` (
  `content_id` int(11) NOT NULL default '0',
  `ordering` int(11) NOT NULL default '0',
  PRIMARY KEY  (`content_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `jos_content_frontpage`
-- 

INSERT INTO `jos_content_frontpage` VALUES (1, 1);

-- --------------------------------------------------------

-- 
-- Table structure for table `jos_content_rating`
-- 

CREATE TABLE `jos_content_rating` (
  `content_id` int(11) NOT NULL default '0',
  `rating_sum` int(11) unsigned NOT NULL default '0',
  `rating_count` int(11) unsigned NOT NULL default '0',
  `lastip` varchar(150) NOT NULL default '',
  PRIMARY KEY  (`content_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `jos_content_rating`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `jos_core_acl_aro`
-- 

CREATE TABLE `jos_core_acl_aro` (
  `id` int(11) NOT NULL auto_increment,
  `section_value` varchar(240) NOT NULL default '0',
  `value` varchar(240) NOT NULL default '',
  `order_value` int(11) NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `hidden` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `__section_value_value_aro` (`section_value`(100),`value`(100)),
  KEY `jos_gacl_hidden_aro` (`hidden`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

-- 
-- Dumping data for table `jos_core_acl_aro`
-- 

INSERT INTO `jos_core_acl_aro` VALUES (10, 'users', '62', 0, 'Administrator', 0);
INSERT INTO `jos_core_acl_aro` VALUES (11, 'users', '63', 0, 'Gareth Spanglett', 0);

-- --------------------------------------------------------

-- 
-- Table structure for table `jos_core_acl_aro_groups`
-- 

CREATE TABLE `jos_core_acl_aro_groups` (
  `id` int(11) NOT NULL auto_increment,
  `parent_id` int(11) NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `lft` int(11) NOT NULL default '0',
  `rgt` int(11) NOT NULL default '0',
  `value` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `jos_gacl_parent_id_aro_groups` (`parent_id`),
  KEY `jos_gacl_lft_rgt_aro_groups` (`lft`,`rgt`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;

-- 
-- Dumping data for table `jos_core_acl_aro_groups`
-- 

INSERT INTO `jos_core_acl_aro_groups` VALUES (17, 0, 'ROOT', 1, 22, 'ROOT');
INSERT INTO `jos_core_acl_aro_groups` VALUES (28, 17, 'USERS', 2, 21, 'USERS');
INSERT INTO `jos_core_acl_aro_groups` VALUES (29, 28, 'Public Frontend', 3, 12, 'Public Frontend');
INSERT INTO `jos_core_acl_aro_groups` VALUES (18, 29, 'Registered', 4, 11, 'Registered');
INSERT INTO `jos_core_acl_aro_groups` VALUES (19, 18, 'Author', 5, 10, 'Author');
INSERT INTO `jos_core_acl_aro_groups` VALUES (20, 19, 'Editor', 6, 9, 'Editor');
INSERT INTO `jos_core_acl_aro_groups` VALUES (21, 20, 'Publisher', 7, 8, 'Publisher');
INSERT INTO `jos_core_acl_aro_groups` VALUES (30, 28, 'Public Backend', 13, 20, 'Public Backend');
INSERT INTO `jos_core_acl_aro_groups` VALUES (23, 30, 'Manager', 14, 19, 'Manager');
INSERT INTO `jos_core_acl_aro_groups` VALUES (24, 23, 'Administrator', 15, 18, 'Administrator');
INSERT INTO `jos_core_acl_aro_groups` VALUES (25, 24, 'Super Administrator', 16, 17, 'Super Administrator');

-- --------------------------------------------------------

-- 
-- Table structure for table `jos_core_acl_aro_sections`
-- 

CREATE TABLE `jos_core_acl_aro_sections` (
  `section_id` int(11) NOT NULL auto_increment,
  `value` varchar(230) NOT NULL default '',
  `order_value` int(11) NOT NULL default '0',
  `name` varchar(230) NOT NULL default '',
  `hidden` int(11) NOT NULL default '0',
  PRIMARY KEY  (`section_id`),
  UNIQUE KEY `value_aro_sections` (`value`),
  UNIQUE KEY `jos_gacl_value_aro_sections` (`value`),
  KEY `hidden_aro_sections` (`hidden`),
  KEY `jos_gacl_hidden_aro_sections` (`hidden`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

-- 
-- Dumping data for table `jos_core_acl_aro_sections`
-- 

INSERT INTO `jos_core_acl_aro_sections` VALUES (10, 'users', 1, 'Users', 0);

-- --------------------------------------------------------

-- 
-- Table structure for table `jos_core_acl_groups_aro_map`
-- 

CREATE TABLE `jos_core_acl_groups_aro_map` (
  `group_id` int(11) NOT NULL default '0',
  `section_value` varchar(240) NOT NULL default '',
  `aro_id` int(11) NOT NULL default '0',
  UNIQUE KEY `group_id_aro_id_groups_aro_map` (`group_id`,`section_value`,`aro_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `jos_core_acl_groups_aro_map`
-- 

INSERT INTO `jos_core_acl_groups_aro_map` VALUES (25, '', 10);
INSERT INTO `jos_core_acl_groups_aro_map` VALUES (25, '', 11);

-- --------------------------------------------------------

-- 
-- Table structure for table `jos_core_log_items`
-- 

CREATE TABLE `jos_core_log_items` (
  `time_stamp` date NOT NULL default '0000-00-00',
  `item_table` varchar(50) NOT NULL default '',
  `item_id` int(11) unsigned NOT NULL default '0',
  `hits` int(11) unsigned NOT NULL default '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `jos_core_log_items`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `jos_core_log_searches`
-- 

CREATE TABLE `jos_core_log_searches` (
  `search_term` text NOT NULL,
  `hits` int(11) unsigned NOT NULL default '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `jos_core_log_searches`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `jos_groups`
-- 

CREATE TABLE `jos_groups` (
  `id` tinyint(3) unsigned NOT NULL default '0',
  `name` varchar(150) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `jos_groups`
-- 

INSERT INTO `jos_groups` VALUES (0, 'Public');
INSERT INTO `jos_groups` VALUES (1, 'Registered');
INSERT INTO `jos_groups` VALUES (2, 'Special');

-- --------------------------------------------------------

-- 
-- Table structure for table `jos_menu`
-- 

CREATE TABLE `jos_menu` (
  `id` int(11) NOT NULL auto_increment,
  `menutype` varchar(225) default NULL,
  `name` text,
  `link` text,
  `type` varchar(150) NOT NULL default '',
  `published` tinyint(1) NOT NULL default '0',
  `parent` int(11) unsigned NOT NULL default '0',
  `componentid` int(11) unsigned NOT NULL default '0',
  `sublevel` int(11) default '0',
  `ordering` int(11) default '0',
  `checked_out` int(11) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `pollid` int(11) NOT NULL default '0',
  `browserNav` tinyint(4) default '0',
  `access` tinyint(3) unsigned NOT NULL default '0',
  `utaccess` tinyint(3) unsigned NOT NULL default '0',
  `params` text NOT NULL,
  `lft` int(11) unsigned NOT NULL default '0',
  `rgt` int(11) unsigned NOT NULL default '0',
  `home` int(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `componentid` (`componentid`,`menutype`,`published`,`access`),
  KEY `menutype` (`menutype`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

-- 
-- Dumping data for table `jos_menu`
-- 

INSERT INTO `jos_menu` VALUES (1, 'mainmenu', 'Home', 'index.php?option=com_content&view=frontpage', 'component', 1, 0, 20, 0, 1, 0, '0000-00-00 00:00:00', 0, 0, 0, 3, 'header=Welcome to the Mahsie OSS Demo Site\nshow_header=0\ntitle=Welcome to the Mahsie OSS Demo Site\nleading=1\nintro=0\ncolumns=1\nlink=1\norderby_pri=\norderby_sec=front\npagination=2\npagination_results=0\ncategory=0\ncategory_link=0\nitem_title=1\nlink_titles=\nreadmore=\nrating=\nauthor=\ncreatedate=\nmodifydate=\npdf=0\nprint=0\nemail=0\nsecure=0\nmenu_image=-1\npageclass_sfx=\n\n', 0, 0, 1);
INSERT INTO `jos_menu` VALUES (2, 'topmenu', 'CRM', 'index.php?option=com_wrapper&view=wrapper', 'component', 1, 0, 17, 0, 2, 0, '0000-00-00 00:00:00', 0, 0, 0, 0, 'url=http://demo.mahsie.com/FINAL_DEMO/internal/vtiger_crm/index.php\npage_title=1\nheader=Store Front CRM\nscrolling=auto\nwidth=100%\nheight=500\nheight_auto=1\nadd=1\nmenu_image=-1\npageclass_sfx=\n\n', 0, 0, 0);
INSERT INTO `jos_menu` VALUES (3, 'topmenu', 'Home', '1', 'menulink', 1, 0, 0, 0, 1, 0, '0000-00-00 00:00:00', 0, 0, 0, 0, 'menu_item=1\n\n', 0, 0, 0);
INSERT INTO `jos_menu` VALUES (4, 'topmenu', 'ERP', 'index.php?option=com_wrapper&view=wrapper', 'component', 1, 0, 17, 0, 3, 0, '0000-00-00 00:00:00', 0, 0, 0, 0, 'url=http://demo.mahsie.com/FINAL_DEMO/internal/webERP/index.php\npage_title=1\nheader=Mahsie ERP\nscrolling=auto\nwidth=100%\nheight=500\nheight_auto=1\nadd=1\nmenu_image=-1\npageclass_sfx=\n\n', 0, 0, 0);
INSERT INTO `jos_menu` VALUES (5, 'topmenu', 'School Registration System', 'index.php?option=com_wrapper&view=wrapper', 'component', 0, 0, 17, 0, 4, 0, '0000-00-00 00:00:00', 0, 0, 0, 0, 'url=http://demo.mahsie.com/studentregsys/index.php\npage_title=1\nheader=\nscrolling=no\nwidth=100%\nheight=500\nheight_auto=1\nadd=1\nmenu_image=-1\npageclass_sfx=\n\n', 0, 0, 0);
INSERT INTO `jos_menu` VALUES (6, 'topmenu', 'Fundraising System', 'index.php?option=com_wrapper&view=wrapper', 'component', 0, 0, 17, 0, 5, 0, '0000-00-00 00:00:00', 0, 0, 0, 0, 'url=http://demo.mahsie,com/fundregsys\npage_title=1\nheader=\nscrolling=auto\nwidth=100%\nheight=500\nheight_auto=0\nadd=1\nmenu_image=-1\npageclass_sfx=\n\n', 0, 0, 0);
INSERT INTO `jos_menu` VALUES (7, 'topmenu', 'Membership Registration System', 'index.php?option=com_wrapper&view=wrapper', 'component', 0, 0, 17, 0, 6, 0, '0000-00-00 00:00:00', 0, 0, 0, 0, 'url=http://demo.mahsie.com/membershipsys/\npage_title=1\nheader=\nscrolling=no\nwidth=100%\nheight=500\nheight_auto=1\nadd=1\nmenu_image=-1\npageclass_sfx=\n\n', 0, 0, 0);
INSERT INTO `jos_menu` VALUES (8, 'topmenu', 'Mahsie OSS Web Site', 'http://www.mahsie.com', 'url', 0, 0, 0, 0, 7, 0, '0000-00-00 00:00:00', 0, 0, 0, 0, 'menu_image=-1\n\n', 0, 0, 0);

-- --------------------------------------------------------

-- 
-- Table structure for table `jos_menu_types`
-- 

CREATE TABLE `jos_menu_types` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `menutype` varchar(225) NOT NULL default '',
  `title` text NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `menutype` (`menutype`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- 
-- Dumping data for table `jos_menu_types`
-- 

INSERT INTO `jos_menu_types` VALUES (1, 'mainmenu', 'Main Menu', 'The main menu for the site');
INSERT INTO `jos_menu_types` VALUES (2, 'topmenu', 'Top Menu', 'Top Menu');

-- --------------------------------------------------------

-- 
-- Table structure for table `jos_messages`
-- 

CREATE TABLE `jos_messages` (
  `message_id` int(10) unsigned NOT NULL auto_increment,
  `user_id_from` int(10) unsigned NOT NULL default '0',
  `user_id_to` int(10) unsigned NOT NULL default '0',
  `folder_id` int(10) unsigned NOT NULL default '0',
  `date_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `state` int(11) NOT NULL default '0',
  `priority` int(1) unsigned NOT NULL default '0',
  `subject` text NOT NULL,
  `message` text NOT NULL,
  PRIMARY KEY  (`message_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `jos_messages`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `jos_messages_cfg`
-- 

CREATE TABLE `jos_messages_cfg` (
  `user_id` int(10) unsigned NOT NULL default '0',
  `cfg_name` text NOT NULL,
  `cfg_value` text NOT NULL,
  UNIQUE KEY `idx_user_var_name` (`user_id`,`cfg_name`(100))
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `jos_messages_cfg`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `jos_modules`
-- 

CREATE TABLE `jos_modules` (
  `id` int(11) NOT NULL auto_increment,
  `title` text NOT NULL,
  `content` text NOT NULL,
  `ordering` int(11) NOT NULL default '0',
  `position` varchar(150) default NULL,
  `checked_out` int(11) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `published` tinyint(1) NOT NULL default '0',
  `module` varchar(150) default NULL,
  `numnews` int(11) NOT NULL default '0',
  `access` tinyint(3) unsigned NOT NULL default '0',
  `showtitle` tinyint(3) unsigned NOT NULL default '1',
  `params` text NOT NULL,
  `iscore` tinyint(4) NOT NULL default '0',
  `client_id` tinyint(4) NOT NULL default '0',
  `control` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `published` (`published`,`access`),
  KEY `newsfeeds` (`module`,`published`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=38 ;

-- 
-- Dumping data for table `jos_modules`
-- 

INSERT INTO `jos_modules` VALUES (3, 'Main Menu', '', 2, 'left', 0, '0000-00-00 00:00:00', 0, 'mod_mainmenu', 0, 0, 1, 'menutype=mainmenu\nmoduleclass_sfx=_menu\n', 1, 0, '');
INSERT INTO `jos_modules` VALUES (9, 'Login', '', 1, 'login', 0, '0000-00-00 00:00:00', 1, 'mod_login', 0, 0, 1, '', 1, 1, '');
INSERT INTO `jos_modules` VALUES (18, 'Popular', '', 3, 'cpanel', 0, '0000-00-00 00:00:00', 1, 'mod_popular', 0, 2, 1, '', 0, 1, '');
INSERT INTO `jos_modules` VALUES (19, 'Recent added Articles', '', 4, 'cpanel', 0, '0000-00-00 00:00:00', 1, 'mod_latest', 0, 2, 1, '', 0, 1, '');
INSERT INTO `jos_modules` VALUES (20, 'Menu Stats', '', 5, 'cpanel', 0, '0000-00-00 00:00:00', 1, 'mod_stats', 0, 2, 1, '', 0, 1, '');
INSERT INTO `jos_modules` VALUES (21, 'Unread Messages', '', 1, 'header', 0, '0000-00-00 00:00:00', 1, 'mod_unread', 0, 2, 1, '', 1, 1, '');
INSERT INTO `jos_modules` VALUES (22, 'Online Users', '', 2, 'header', 0, '0000-00-00 00:00:00', 1, 'mod_online', 0, 2, 1, '', 1, 1, '');
INSERT INTO `jos_modules` VALUES (23, 'Toolbar', '', 1, 'toolbar', 0, '0000-00-00 00:00:00', 1, 'mod_toolbar', 0, 2, 1, '', 1, 1, '');
INSERT INTO `jos_modules` VALUES (24, 'Quick Icons', '', 1, 'icon', 0, '0000-00-00 00:00:00', 1, 'mod_quickicon', 0, 2, 1, '', 1, 1, '');
INSERT INTO `jos_modules` VALUES (27, 'Logged in Users', '', 2, 'cpanel', 0, '0000-00-00 00:00:00', 1, 'mod_logged', 0, 2, 1, '', 0, 1, '');
INSERT INTO `jos_modules` VALUES (29, 'Footer', '', 0, 'footer', 0, '0000-00-00 00:00:00', 1, 'mod_footer', 0, 0, 1, '', 1, 1, '');
INSERT INTO `jos_modules` VALUES (31, 'Breadcrumbs', '', 1, 'breadcrumb', 0, '0000-00-00 00:00:00', 1, 'mod_breadcrumbs', 0, 0, 1, 'moduleclass_sfx=\ncache=0\nshowHome=1\nhomeText=Home\nshowComponent=1\nseparator=\n\n', 1, 0, '');
INSERT INTO `jos_modules` VALUES (33, 'Admin Menu', '', 1, 'menu', 0, '0000-00-00 00:00:00', 1, 'mod_menu', 0, 2, 1, '', 0, 1, '');
INSERT INTO `jos_modules` VALUES (34, 'Admin SubMenu', '', 1, 'submenu', 0, '0000-00-00 00:00:00', 1, 'mod_submenu', 0, 2, 1, '', 0, 1, '');
INSERT INTO `jos_modules` VALUES (35, 'User Status', '', 1, 'status', 0, '0000-00-00 00:00:00', 1, 'mod_status', 0, 2, 1, '', 0, 1, '');
INSERT INTO `jos_modules` VALUES (36, 'Title', '', 1, 'title', 0, '0000-00-00 00:00:00', 1, 'mod_title', 0, 2, 1, '', 0, 1, '');
INSERT INTO `jos_modules` VALUES (37, 'topmenu', '', 1, 'user3', 0, '0000-00-00 00:00:00', 1, 'mod_mainmenu', 0, 0, 1, 'menutype=topmenu\nmenu_style=list\nstartLevel=0\nendLevel=0\nshowAllChildren=0\nwindow_open=\ncache=0\nclass_sfx=\nmoduleclass_sfx=\nmenu_images=0\nmenu_images_align=0\nexpand_menu=0\nactivate_parent=0\nfull_active_id=0\nindent_image=0\nindent_image1=\nindent_image2=\nindent_image3=\nindent_image4=\nindent_image5=\nindent_image6=\nspacer=\nend_spacer=\n\n', 0, 0, '');

-- --------------------------------------------------------

-- 
-- Table structure for table `jos_modules_menu`
-- 

CREATE TABLE `jos_modules_menu` (
  `moduleid` int(11) NOT NULL default '0',
  `menuid` int(11) NOT NULL default '0',
  PRIMARY KEY  (`moduleid`,`menuid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `jos_modules_menu`
-- 

INSERT INTO `jos_modules_menu` VALUES (3, 0);
INSERT INTO `jos_modules_menu` VALUES (31, 0);
INSERT INTO `jos_modules_menu` VALUES (37, 0);

-- --------------------------------------------------------

-- 
-- Table structure for table `jos_newsfeeds`
-- 

CREATE TABLE `jos_newsfeeds` (
  `catid` int(11) NOT NULL default '0',
  `id` int(11) NOT NULL auto_increment,
  `name` text NOT NULL,
  `link` text NOT NULL,
  `filename` varchar(200) default NULL,
  `published` tinyint(1) NOT NULL default '0',
  `numarticles` int(11) unsigned NOT NULL default '1',
  `cache_time` int(11) unsigned NOT NULL default '3600',
  `checked_out` tinyint(3) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL default '0',
  `rtl` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `published` (`published`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `jos_newsfeeds`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `jos_plugins`
-- 

CREATE TABLE `jos_plugins` (
  `id` int(11) NOT NULL auto_increment,
  `name` text NOT NULL,
  `element` text NOT NULL,
  `folder` varchar(100) NOT NULL default '',
  `access` tinyint(3) unsigned NOT NULL default '0',
  `ordering` int(11) NOT NULL default '0',
  `published` tinyint(3) NOT NULL default '0',
  `iscore` tinyint(3) NOT NULL default '0',
  `client_id` tinyint(3) NOT NULL default '0',
  `checked_out` int(11) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `params` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `idx_folder` (`published`,`client_id`,`access`,`folder`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=34 ;

-- 
-- Dumping data for table `jos_plugins`
-- 

INSERT INTO `jos_plugins` VALUES (1, 'Content - Image', 'image', 'content', 0, -10000, 1, 1, 0, 0, '0000-00-00 00:00:00', '');
INSERT INTO `jos_plugins` VALUES (2, 'Content - Pagebreak', 'pagebreak', 'content', 0, 10000, 1, 1, 0, 0, '0000-00-00 00:00:00', '');
INSERT INTO `jos_plugins` VALUES (4, 'Content - SEF', 'sef', 'content', 0, 3, 1, 0, 0, 0, '0000-00-00 00:00:00', '');
INSERT INTO `jos_plugins` VALUES (5, 'Content - Rating', 'vote', 'content', 0, 4, 1, 1, 0, 0, '0000-00-00 00:00:00', '');
INSERT INTO `jos_plugins` VALUES (6, 'Search - Content', 'content', 'search', 0, 1, 1, 1, 0, 0, '0000-00-00 00:00:00', '');
INSERT INTO `jos_plugins` VALUES (7, 'Search - Weblinks', 'weblinks', 'search', 0, 2, 1, 1, 0, 0, '0000-00-00 00:00:00', '');
INSERT INTO `jos_plugins` VALUES (8, 'Content - Code Highlighter (Joomla)', 'code', 'content', 0, 2, 0, 0, 0, 0, '0000-00-00 00:00:00', '');
INSERT INTO `jos_plugins` VALUES (9, 'Editor - No Editor', 'none', 'editors', 0, 0, 1, 1, 0, 0, '0000-00-00 00:00:00', '');
INSERT INTO `jos_plugins` VALUES (10, 'Editor - TinyMCE 2.0', 'tinymce', 'editors', 0, 0, 1, 1, 0, 0, '0000-00-00 00:00:00', 'theme=advanced\r\ncleanup=1\r\ncompressed=0\r\ntext_direction=ltr\r\ninvalid_elements=applet\r\ncontent_css=1\r\ncontent_css_custom=\r\nnewlines=0\r\ntoolbar=top\r\nsmilies=1\r\ntable=1\r\nflash=1\r\nhr=1\r\nfullscreen=1\r\nhtml_height=550\r\nhtml_width=750\r\npreview=1\r\npreview_height=550\r\npreview_width=750\r\nsearchreplace=1\r\ninsertdate=1\r\nformat_date=%Y-%m-%d\r\ninserttime=1\r\nformat_time=%H:%M:%S');
INSERT INTO `jos_plugins` VALUES (11, 'Editor Button - Image', 'image', 'editors-xtd', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', '');
INSERT INTO `jos_plugins` VALUES (12, 'Editor Button - Pagebreak', 'pagebreak', 'editors-xtd', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', '');
INSERT INTO `jos_plugins` VALUES (13, 'Search - Contacts', 'contacts', 'search', 0, 3, 1, 1, 0, 0, '0000-00-00 00:00:00', '');
INSERT INTO `jos_plugins` VALUES (14, 'Search - Categories', 'categories', 'search', 0, 4, 1, 0, 0, 0, '0000-00-00 00:00:00', '');
INSERT INTO `jos_plugins` VALUES (15, 'Search - Sections', 'sections', 'search', 0, 5, 1, 0, 0, 0, '0000-00-00 00:00:00', '');
INSERT INTO `jos_plugins` VALUES (16, 'Content - Email Cloaking', 'emailcloak', 'content', 0, 5, 1, 0, 0, 0, '0000-00-00 00:00:00', '');
INSERT INTO `jos_plugins` VALUES (17, 'Content - Code Hightlighter (GeSHi)', 'geshi', 'content', 0, 5, 0, 0, 0, 0, '0000-00-00 00:00:00', '');
INSERT INTO `jos_plugins` VALUES (18, 'Search - Newsfeeds', 'newsfeeds', 'search', 0, 6, 1, 0, 0, 0, '0000-00-00 00:00:00', '');
INSERT INTO `jos_plugins` VALUES (19, 'Content - Load Module', 'loadmodule', 'content', 0, 6, 1, 0, 0, 0, '0000-00-00 00:00:00', '');
INSERT INTO `jos_plugins` VALUES (20, 'Authentication - Joomla', 'joomla', 'authentication', 0, 1, 1, 1, 0, 0, '0000-00-00 00:00:00', '');
INSERT INTO `jos_plugins` VALUES (21, 'Authentication - LDAP', 'ldap', 'authentication', 0, 2, 0, 1, 0, 0, '0000-00-00 00:00:00', '');
INSERT INTO `jos_plugins` VALUES (22, 'Authentication - GMail', 'gmail', 'authentication', 0, 4, 0, 0, 0, 0, '0000-00-00 00:00:00', '');
INSERT INTO `jos_plugins` VALUES (23, 'System - Joomla Request', 'joomla.request', 'system', 0, 2, 1, 1, 0, 0, '0000-00-00 00:00:00', '');
INSERT INTO `jos_plugins` VALUES (25, 'Content - Page Navigation', 'pagenavigation', 'content', 0, 2, 1, 1, 0, 0, '0000-00-00 00:00:00', '');
INSERT INTO `jos_plugins` VALUES (26, 'Editor - XStandard Lite 1.7', 'xstandard', 'editors', 0, 0, 1, 1, 0, 0, '0000-00-00 00:00:00', '');
INSERT INTO `jos_plugins` VALUES (27, 'XML-RPC - Joomla', 'joomla', 'xmlrpc', 0, 7, 1, 1, 0, 0, '0000-00-00 00:00:00', '');
INSERT INTO `jos_plugins` VALUES (28, 'XML-RPC - Blogger API', 'blogger', 'xmlrpc', 0, 7, 1, 1, 0, 0, '0000-00-00 00:00:00', '');
INSERT INTO `jos_plugins` VALUES (30, 'Editor Button - Readmore', 'readmore', 'editors-xtd', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', '');
INSERT INTO `jos_plugins` VALUES (31, 'User - Joomla!', 'joomla', 'user', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', '');
INSERT INTO `jos_plugins` VALUES (32, 'Authentication - OpenID', 'openid', 'authentication', 0, 3, 0, 0, 0, 0, '0000-00-00 00:00:00', '');
INSERT INTO `jos_plugins` VALUES (33, 'System - Debug', 'debug', 'system', 0, 2, 1, 0, 0, 0, '0000-00-00 00:00:00', '');

-- --------------------------------------------------------

-- 
-- Table structure for table `jos_poll_data`
-- 

CREATE TABLE `jos_poll_data` (
  `id` int(11) NOT NULL auto_increment,
  `pollid` int(11) NOT NULL default '0',
  `text` text NOT NULL,
  `hits` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `pollid` (`pollid`,`text`(1))
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `jos_poll_data`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `jos_poll_date`
-- 

CREATE TABLE `jos_poll_date` (
  `id` bigint(20) NOT NULL auto_increment,
  `date` datetime NOT NULL default '0000-00-00 00:00:00',
  `vote_id` int(11) NOT NULL default '0',
  `poll_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `poll_id` (`poll_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `jos_poll_date`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `jos_poll_menu`
-- 

CREATE TABLE `jos_poll_menu` (
  `pollid` int(11) NOT NULL default '0',
  `menuid` int(11) NOT NULL default '0',
  PRIMARY KEY  (`pollid`,`menuid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `jos_poll_menu`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `jos_polls`
-- 

CREATE TABLE `jos_polls` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `title` text NOT NULL,
  `voters` int(9) NOT NULL default '0',
  `checked_out` int(11) NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `published` tinyint(1) NOT NULL default '0',
  `access` int(11) NOT NULL default '0',
  `lag` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `jos_polls`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `jos_sections`
-- 

CREATE TABLE `jos_sections` (
  `id` int(11) NOT NULL auto_increment,
  `title` text NOT NULL,
  `name` text NOT NULL,
  `image` text NOT NULL,
  `scope` varchar(50) NOT NULL default '',
  `image_position` varchar(90) NOT NULL default '',
  `description` text NOT NULL,
  `published` tinyint(1) NOT NULL default '0',
  `checked_out` int(11) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL default '0',
  `access` tinyint(3) unsigned NOT NULL default '0',
  `count` int(11) NOT NULL default '0',
  `params` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `idx_scope` (`scope`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- 
-- Dumping data for table `jos_sections`
-- 

INSERT INTO `jos_sections` VALUES (1, 'General', 'General', '', 'content', 'left', '', 1, 0, '0000-00-00 00:00:00', 1, 0, 1, '');

-- --------------------------------------------------------

-- 
-- Table structure for table `jos_session`
-- 

CREATE TABLE `jos_session` (
  `username` varchar(150) default '',
  `time` varchar(14) default '',
  `session_id` varchar(200) NOT NULL default '0',
  `guest` tinyint(4) default '1',
  `userid` int(11) default '0',
  `usertype` varchar(150) default '',
  `gid` tinyint(3) unsigned NOT NULL default '0',
  `client_id` tinyint(3) unsigned NOT NULL default '0',
  `data` text,
  PRIMARY KEY  (`session_id`),
  KEY `whosonline` (`guest`,`usertype`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `jos_session`
-- 

INSERT INTO `jos_session` VALUES ('', '1187478999', '5158f7057d164c2238ecf1a720ba02ad', 1, 0, '', 0, 0, NULL);

-- --------------------------------------------------------

-- 
-- Table structure for table `jos_stats_agents`
-- 

CREATE TABLE `jos_stats_agents` (
  `agent` varchar(255) NOT NULL default '',
  `type` tinyint(1) unsigned NOT NULL default '0',
  `hits` int(11) unsigned NOT NULL default '1'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `jos_stats_agents`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `jos_template_positions`
-- 

CREATE TABLE `jos_template_positions` (
  `id` int(11) NOT NULL auto_increment,
  `position` varchar(150) NOT NULL default '',
  `description` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=35 ;

-- 
-- Dumping data for table `jos_template_positions`
-- 

INSERT INTO `jos_template_positions` VALUES (1, 'left', '');
INSERT INTO `jos_template_positions` VALUES (2, 'right', '');
INSERT INTO `jos_template_positions` VALUES (3, 'top', '');
INSERT INTO `jos_template_positions` VALUES (4, 'bottom', '');
INSERT INTO `jos_template_positions` VALUES (5, 'inset', '');
INSERT INTO `jos_template_positions` VALUES (6, 'banner', '');
INSERT INTO `jos_template_positions` VALUES (7, 'header', '');
INSERT INTO `jos_template_positions` VALUES (8, 'footer', '');
INSERT INTO `jos_template_positions` VALUES (9, 'newsflash', '');
INSERT INTO `jos_template_positions` VALUES (10, 'legals', '');
INSERT INTO `jos_template_positions` VALUES (11, 'pathway', '');
INSERT INTO `jos_template_positions` VALUES (12, 'breadcrumb', '');
INSERT INTO `jos_template_positions` VALUES (13, 'toolbar', '');
INSERT INTO `jos_template_positions` VALUES (14, 'menu', '');
INSERT INTO `jos_template_positions` VALUES (15, 'cpanel', '');
INSERT INTO `jos_template_positions` VALUES (16, 'user1', '');
INSERT INTO `jos_template_positions` VALUES (17, 'user2', '');
INSERT INTO `jos_template_positions` VALUES (18, 'user3', '');
INSERT INTO `jos_template_positions` VALUES (19, 'user4', '');
INSERT INTO `jos_template_positions` VALUES (20, 'user5', '');
INSERT INTO `jos_template_positions` VALUES (21, 'user6', '');
INSERT INTO `jos_template_positions` VALUES (22, 'user7', '');
INSERT INTO `jos_template_positions` VALUES (23, 'user8', '');
INSERT INTO `jos_template_positions` VALUES (24, 'user9', '');
INSERT INTO `jos_template_positions` VALUES (25, 'advert1', '');
INSERT INTO `jos_template_positions` VALUES (26, 'advert2', '');
INSERT INTO `jos_template_positions` VALUES (27, 'advert3', '');
INSERT INTO `jos_template_positions` VALUES (28, 'icon', '');
INSERT INTO `jos_template_positions` VALUES (29, 'debug', '');
INSERT INTO `jos_template_positions` VALUES (30, 'submenu', '');
INSERT INTO `jos_template_positions` VALUES (31, 'status', '');
INSERT INTO `jos_template_positions` VALUES (32, 'title', '');
INSERT INTO `jos_template_positions` VALUES (33, 'syndicate', '');
INSERT INTO `jos_template_positions` VALUES (34, 'cp_shell', '');

-- --------------------------------------------------------

-- 
-- Table structure for table `jos_templates_menu`
-- 

CREATE TABLE `jos_templates_menu` (
  `template` text NOT NULL,
  `menuid` int(11) NOT NULL default '0',
  `client_id` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`template`(255),`menuid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `jos_templates_menu`
-- 

INSERT INTO `jos_templates_menu` VALUES ('rhuk_milkyway', 0, 0);
INSERT INTO `jos_templates_menu` VALUES ('khepri', 0, 1);

-- --------------------------------------------------------

-- 
-- Table structure for table `jos_users`
-- 

CREATE TABLE `jos_users` (
  `id` int(11) NOT NULL auto_increment,
  `name` text NOT NULL,
  `username` varchar(150) NOT NULL default '',
  `email` varchar(100) NOT NULL default '',
  `password` varchar(100) NOT NULL default '',
  `usertype` varchar(75) NOT NULL default '',
  `block` tinyint(4) NOT NULL default '0',
  `sendEmail` tinyint(4) default '0',
  `gid` tinyint(3) unsigned NOT NULL default '1',
  `registerDate` datetime NOT NULL default '0000-00-00 00:00:00',
  `lastvisitDate` datetime NOT NULL default '0000-00-00 00:00:00',
  `activation` varchar(100) NOT NULL default '',
  `params` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `usertype` (`usertype`),
  KEY `idx_name` (`name`(255))
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=64 ;

-- 
-- Dumping data for table `jos_users`
-- 

INSERT INTO `jos_users` VALUES (62, 'Administrator', 'admin', 'jmoncrieff@mahsie.com', '33802c9074fcc311eb76af0e7df3185c', 'Super Administrator', 0, 1, 25, '2007-01-31 12:00:35', '2007-03-26 13:32:05', '', '');
INSERT INTO `jos_users` VALUES (63, 'Gareth Spanglett', 'gareth', 'gareth@mahsie.com', '1cc4e9a2f44b20ebf711479e2cb3b7fe', 'Super Administrator', 0, 0, 25, '2007-02-07 15:31:18', '2007-03-27 18:49:17', '', 'admin_language=en-GB\nlanguage=en-GB\neditor=xstandard\nhelpsite=\ntimezone=-5\n\n');

-- --------------------------------------------------------

-- 
-- Table structure for table `jos_weblinks`
-- 

CREATE TABLE `jos_weblinks` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `catid` int(11) NOT NULL default '0',
  `sid` int(11) NOT NULL default '0',
  `title` text NOT NULL,
  `url` varchar(250) NOT NULL default '',
  `description` text NOT NULL,
  `date` datetime NOT NULL default '0000-00-00 00:00:00',
  `hits` int(11) NOT NULL default '0',
  `published` tinyint(1) NOT NULL default '0',
  `checked_out` int(11) NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL default '0',
  `archived` tinyint(1) NOT NULL default '0',
  `approved` tinyint(1) NOT NULL default '1',
  `params` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `catid` (`catid`,`published`,`archived`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `jos_weblinks`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `wiki_archive`
-- 

CREATE TABLE `wiki_archive` (
  `ar_namespace` int(11) NOT NULL default '0',
  `ar_title` varchar(255) character set latin1 collate latin1_bin NOT NULL default '',
  `ar_text` mediumblob NOT NULL,
  `ar_comment` tinyblob NOT NULL,
  `ar_user` int(5) unsigned NOT NULL default '0',
  `ar_user_text` varchar(255) character set latin1 collate latin1_bin NOT NULL default '',
  `ar_timestamp` varchar(14) character set latin1 collate latin1_bin NOT NULL default '',
  `ar_minor_edit` tinyint(1) NOT NULL default '0',
  `ar_flags` tinyblob NOT NULL,
  `ar_rev_id` int(8) unsigned default NULL,
  `ar_text_id` int(8) unsigned default NULL,
  KEY `name_title_timestamp` (`ar_namespace`,`ar_title`,`ar_timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `wiki_archive`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `wiki_categorylinks`
-- 

CREATE TABLE `wiki_categorylinks` (
  `cl_from` int(8) unsigned NOT NULL default '0',
  `cl_to` varchar(255) character set latin1 collate latin1_bin NOT NULL default '',
  `cl_sortkey` varchar(86) character set latin1 collate latin1_bin NOT NULL default '',
  `cl_timestamp` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  UNIQUE KEY `cl_from` (`cl_from`,`cl_to`),
  KEY `cl_sortkey` (`cl_to`,`cl_sortkey`),
  KEY `cl_timestamp` (`cl_to`,`cl_timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `wiki_categorylinks`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `wiki_externallinks`
-- 

CREATE TABLE `wiki_externallinks` (
  `el_from` int(8) unsigned NOT NULL default '0',
  `el_to` blob NOT NULL,
  `el_index` blob NOT NULL,
  KEY `el_from` (`el_from`,`el_to`(40)),
  KEY `el_to` (`el_to`(60),`el_from`),
  KEY `el_index` (`el_index`(60))
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `wiki_externallinks`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `wiki_hitcounter`
-- 

CREATE TABLE `wiki_hitcounter` (
  `hc_id` int(10) unsigned NOT NULL default '0'
) ENGINE=HEAP DEFAULT CHARSET=latin1 MAX_ROWS=25000;

-- 
-- Dumping data for table `wiki_hitcounter`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `wiki_image`
-- 

CREATE TABLE `wiki_image` (
  `img_name` varchar(255) character set latin1 collate latin1_bin NOT NULL default '',
  `img_size` int(8) unsigned NOT NULL default '0',
  `img_width` int(5) NOT NULL default '0',
  `img_height` int(5) NOT NULL default '0',
  `img_metadata` mediumblob NOT NULL,
  `img_bits` int(3) NOT NULL default '0',
  `img_media_type` enum('UNKNOWN','BITMAP','DRAWING','AUDIO','VIDEO','MULTIMEDIA','OFFICE','TEXT','EXECUTABLE','ARCHIVE') default NULL,
  `img_major_mime` enum('unknown','application','audio','image','text','video','message','model','multipart') NOT NULL default 'unknown',
  `img_minor_mime` varchar(32) NOT NULL default 'unknown',
  `img_description` tinyblob NOT NULL,
  `img_user` int(5) unsigned NOT NULL default '0',
  `img_user_text` varchar(255) character set latin1 collate latin1_bin NOT NULL default '',
  `img_timestamp` varchar(14) character set latin1 collate latin1_bin NOT NULL default '',
  PRIMARY KEY  (`img_name`),
  KEY `img_size` (`img_size`),
  KEY `img_timestamp` (`img_timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `wiki_image`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `wiki_imagelinks`
-- 

CREATE TABLE `wiki_imagelinks` (
  `il_from` int(8) unsigned NOT NULL default '0',
  `il_to` varchar(255) character set latin1 collate latin1_bin NOT NULL default '',
  UNIQUE KEY `il_from` (`il_from`,`il_to`),
  KEY `il_to` (`il_to`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `wiki_imagelinks`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `wiki_interwiki`
-- 

CREATE TABLE `wiki_interwiki` (
  `iw_prefix` char(32) NOT NULL default '',
  `iw_url` char(127) NOT NULL default '',
  `iw_local` tinyint(1) NOT NULL default '0',
  `iw_trans` tinyint(1) NOT NULL default '0',
  UNIQUE KEY `iw_prefix` (`iw_prefix`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `wiki_interwiki`
-- 

INSERT INTO `wiki_interwiki` VALUES ('abbenormal', 'http://www.ourpla.net/cgi-bin/pikie.cgi?$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('acadwiki', 'http://xarch.tu-graz.ac.at/autocad/wiki/$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('acronym', 'http://www.acronymfinder.com/af-query.asp?String=exact&Acronym=$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('advogato', 'http://www.advogato.org/$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('aiwiki', 'http://www.ifi.unizh.ch/ailab/aiwiki/aiw.cgi?$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('alife', 'http://news.alife.org/wiki/index.php?$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('annotation', 'http://bayle.stanford.edu/crit/nph-med.cgi/$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('annotationwiki', 'http://www.seedwiki.com/page.cfm?wikiid=368&doc=$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('arxiv', 'http://www.arxiv.org/abs/$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('aspienetwiki', 'http://aspie.mela.de/Wiki/index.php?title=$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('bemi', 'http://bemi.free.fr/vikio/index.php?$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('benefitswiki', 'http://www.benefitslink.com/cgi-bin/wiki.cgi?$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('brasilwiki', 'http://rio.ifi.unizh.ch/brasilienwiki/index.php/$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('bridgeswiki', 'http://c2.com/w2/bridges/$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('c2find', 'http://c2.com/cgi/wiki?FindPage&value=$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('cache', 'http://www.google.com/search?q=cache:$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('ciscavate', 'http://ciscavate.org/index.php/$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('cliki', 'http://ww.telent.net/cliki/$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('cmwiki', 'http://www.ourpla.net/cgi-bin/wiki.pl?$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('codersbase', 'http://www.codersbase.com/$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('commons', 'http://commons.wikimedia.org/wiki/$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('consciousness', 'http://teadvus.inspiral.org/', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('corpknowpedia', 'http://corpknowpedia.org/wiki/index.php/$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('creationmatters', 'http://www.ourpla.net/cgi-bin/wiki.pl?$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('dejanews', 'http://www.deja.com/=dnc/getdoc.xp?AN=$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('demokraatia', 'http://wiki.demokraatia.ee/', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('dictionary', 'http://www.dict.org/bin/Dict?Database=*&Form=Dict1&Strategy=*&Query=$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('disinfopedia', 'http://www.disinfopedia.org/wiki.phtml?title=$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('diveintoosx', 'http://diveintoosx.org/$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('docbook', 'http://docbook.org/wiki/moin.cgi/$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('dolphinwiki', 'http://www.object-arts.com/wiki/html/Dolphin/$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('drumcorpswiki', 'http://www.drumcorpswiki.com/index.php/$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('dwjwiki', 'http://www.suberic.net/cgi-bin/dwj/wiki.cgi?$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('eÃ„â€°ei', 'http://www.ikso.net/cgi-bin/wiki.pl?$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('echei', 'http://www.ikso.net/cgi-bin/wiki.pl?$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('ecxei', 'http://www.ikso.net/cgi-bin/wiki.pl?$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('efnetceewiki', 'http://purl.net/wiki/c/$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('efnetcppwiki', 'http://purl.net/wiki/cpp/$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('efnetpythonwiki', 'http://purl.net/wiki/python/$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('efnetxmlwiki', 'http://purl.net/wiki/xml/$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('elibre', 'http://enciclopedia.us.es/index.php/$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('eljwiki', 'http://elj.sourceforge.net/phpwiki/index.php/$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('emacswiki', 'http://www.emacswiki.org/cgi-bin/wiki.pl?$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('eokulturcentro', 'http://esperanto.toulouse.free.fr/wakka.php?wiki=$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('evowiki', 'http://www.evowiki.org/index.php/$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('finalempire', 'http://final-empire.sourceforge.net/cgi-bin/wiki.pl?$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('firstwiki', 'http://firstwiki.org/index.php/$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('foldoc', 'http://www.foldoc.org/foldoc/foldoc.cgi?$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('foxwiki', 'http://fox.wikis.com/wc.dll?Wiki~$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('fr.be', 'http://fr.wikinations.be/$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('fr.ca', 'http://fr.ca.wikinations.org/$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('fr.fr', 'http://fr.fr.wikinations.org/$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('fr.org', 'http://fr.wikinations.org/$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('freebsdman', 'http://www.FreeBSD.org/cgi/man.cgi?apropos=1&query=$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('gamewiki', 'http://gamewiki.org/wiki/index.php/$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('gej', 'http://www.esperanto.de/cgi-bin/aktivikio/wiki.pl?$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('gentoo-wiki', 'http://gentoo-wiki.com/$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('globalvoices', 'http://cyber.law.harvard.edu/dyn/globalvoices/wiki/$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('gmailwiki', 'http://www.gmailwiki.com/index.php/$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('google', 'http://www.google.com/search?q=$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('googlegroups', 'http://groups.google.com/groups?q=$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('gotamac', 'http://www.got-a-mac.org/$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('greencheese', 'http://www.greencheese.org/$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('hammondwiki', 'http://www.dairiki.org/HammondWiki/index.php3?$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('haribeau', 'http://wiki.haribeau.de/cgi-bin/wiki.pl?$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('herzkinderwiki', 'http://www.herzkinderinfo.de/Mediawiki/index.php/$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('hewikisource', 'http://he.wikisource.org/wiki/$1', 1, 0);
INSERT INTO `wiki_interwiki` VALUES ('hrwiki', 'http://www.hrwiki.org/index.php/$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('iawiki', 'http://www.IAwiki.net/$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('imdb', 'http://us.imdb.com/Title?$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('infosecpedia', 'http://www.infosecpedia.org/pedia/index.php/$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('jargonfile', 'http://sunir.org/apps/meta.pl?wiki=JargonFile&redirect=$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('jefo', 'http://www.esperanto-jeunes.org/vikio/index.php?$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('jiniwiki', 'http://www.cdegroot.com/cgi-bin/jini?$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('jspwiki', 'http://www.ecyrd.com/JSPWiki/Wiki.jsp?page=$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('kerimwiki', 'http://wiki.oxus.net/$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('kmwiki', 'http://www.voght.com/cgi-bin/pywiki?$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('knowhow', 'http://www2.iro.umontreal.ca/~paquetse/cgi-bin/wiki.cgi?$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('lanifexwiki', 'http://opt.lanifex.com/cgi-bin/wiki.pl?$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('lasvegaswiki', 'http://wiki.gmnow.com/index.php/$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('linuxwiki', 'http://www.linuxwiki.de/$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('lojban', 'http://www.lojban.org/tiki/tiki-index.php?page=$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('lqwiki', 'http://wiki.linuxquestions.org/wiki/$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('lugkr', 'http://lug-kr.sourceforge.net/cgi-bin/lugwiki.pl?$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('lutherwiki', 'http://www.lutheranarchives.com/mw/index.php/$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('mathsongswiki', 'http://SeedWiki.com/page.cfm?wikiid=237&doc=$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('mbtest', 'http://www.usemod.com/cgi-bin/mbtest.pl?$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('meatball', 'http://www.usemod.com/cgi-bin/mb.pl?$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('mediazilla', 'http://bugzilla.wikipedia.org/$1', 1, 0);
INSERT INTO `wiki_interwiki` VALUES ('memoryalpha', 'http://www.memory-alpha.org/en/index.php/$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('metaweb', 'http://www.metaweb.com/wiki/wiki.phtml?title=$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('metawiki', 'http://sunir.org/apps/meta.pl?$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('metawikipedia', 'http://meta.wikimedia.org/wiki/$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('moinmoin', 'http://purl.net/wiki/moin/$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('mozillawiki', 'http://wiki.mozilla.org/index.php/$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('muweb', 'http://www.dunstable.com/scripts/MuWebWeb?$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('netvillage', 'http://www.netbros.com/?$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('oeis', 'http://www.research.att.com/cgi-bin/access.cgi/as/njas/sequences/eisA.cgi?Anum=$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('openfacts', 'http://openfacts.berlios.de/index.phtml?title=$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('openwiki', 'http://openwiki.com/?$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('opera7wiki', 'http://nontroppo.org/wiki/$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('orgpatterns', 'http://www.bell-labs.com/cgi-user/OrgPatterns/OrgPatterns?$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('osi reference model', 'http://wiki.tigma.ee/', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('pangalacticorg', 'http://www.pangalactic.org/Wiki/$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('patwiki', 'http://gauss.ffii.org/$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('personaltelco', 'http://www.personaltelco.net/index.cgi/$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('phpwiki', 'http://phpwiki.sourceforge.net/phpwiki/index.php?$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('pikie', 'http://pikie.darktech.org/cgi/pikie?$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('pmeg', 'http://www.bertilow.com/pmeg/$1.php', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('ppr', 'http://c2.com/cgi/wiki?$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('purlnet', 'http://purl.oclc.org/NET/$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('pythoninfo', 'http://www.python.org/cgi-bin/moinmoin/$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('pythonwiki', 'http://www.pythonwiki.de/$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('pywiki', 'http://www.voght.com/cgi-bin/pywiki?$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('raec', 'http://www.raec.clacso.edu.ar:8080/raec/Members/raecpedia/$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('revo', 'http://purl.org/NET/voko/revo/art/$1.html', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('rfc', 'http://www.rfc-editor.org/rfc/rfc$1.txt', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('s23wiki', 'http://is-root.de/wiki/index.php/$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('scoutpedia', 'http://www.scoutpedia.info/index.php/$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('seapig', 'http://www.seapig.org/$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('seattlewiki', 'http://seattlewiki.org/wiki/$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('seattlewireless', 'http://seattlewireless.net/?$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('seeds', 'http://www.IslandSeeds.org/wiki/$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('senseislibrary', 'http://senseis.xmp.net/?$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('shakti', 'http://cgi.algonet.se/htbin/cgiwrap/pgd/ShaktiWiki/$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('slashdot', 'http://slashdot.org/article.pl?sid=$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('smikipedia', 'http://www.smikipedia.org/$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('sockwiki', 'http://wiki.socklabs.com/$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('sourceforge', 'http://sourceforge.net/$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('squeak', 'http://minnow.cc.gatech.edu/squeak/$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('strikiwiki', 'http://ch.twi.tudelft.nl/~mostert/striki/teststriki.pl?$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('susning', 'http://www.susning.nu/$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('svgwiki', 'http://www.protocol7.com/svg-wiki/default.asp?$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('tavi', 'http://tavi.sourceforge.net/$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('tejo', 'http://www.tejo.org/vikio/$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('terrorwiki', 'http://www.liberalsagainstterrorism.com/wiki/index.php/$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('theopedia', 'http://www.theopedia.com/$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('tmbw', 'http://www.tmbw.net/wiki/index.php/$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('tmnet', 'http://www.technomanifestos.net/?$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('tmwiki', 'http://www.EasyTopicMaps.com/?page=$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('turismo', 'http://www.tejo.org/turismo/$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('twiki', 'http://twiki.org/cgi-bin/view/$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('twistedwiki', 'http://purl.net/wiki/twisted/$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('uea', 'http://www.tejo.org/uea/$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('unreal', 'http://wiki.beyondunreal.com/wiki/$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('ursine', 'http://ursine.ca/$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('usej', 'http://www.tejo.org/usej/$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('usemod', 'http://www.usemod.com/cgi-bin/wiki.pl?$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('visualworks', 'http://wiki.cs.uiuc.edu/VisualWorks/$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('warpedview', 'http://www.warpedview.com/index.php/$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('webdevwikinl', 'http://www.promo-it.nl/WebDevWiki/index.php?page=$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('webisodes', 'http://www.webisodes.org/$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('webseitzwiki', 'http://webseitz.fluxent.com/wiki/$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('why', 'http://clublet.com/c/c/why?$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('wiki', 'http://c2.com/cgi/wiki?$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('wikia', 'http://www.wikia.com/wiki/index.php/$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('wikibooks', 'http://en.wikibooks.org/wiki/$1', 1, 0);
INSERT INTO `wiki_interwiki` VALUES ('wikicities', 'http://www.wikicities.com/index.php/$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('wikif1', 'http://www.wikif1.org/$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('wikimedia', 'http://wikimediafoundation.org/wiki/$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('wikinews', 'http://en.wikinews.org/wiki/$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('wikinfo', 'http://www.wikinfo.org/wiki.php?title=$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('wikiquote', 'http://en.wikiquote.org/wiki/$1', 1, 0);
INSERT INTO `wiki_interwiki` VALUES ('wikisource', 'http://sources.wikipedia.org/wiki/$1', 1, 0);
INSERT INTO `wiki_interwiki` VALUES ('wikispecies', 'http://species.wikipedia.org/wiki/$1', 1, 0);
INSERT INTO `wiki_interwiki` VALUES ('wikitravel', 'http://wikitravel.org/en/$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('wikiworld', 'http://WikiWorld.com/wiki/index.php/$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('wikt', 'http://en.wiktionary.org/wiki/$1', 1, 0);
INSERT INTO `wiki_interwiki` VALUES ('wiktionary', 'http://en.wiktionary.org/wiki/$1', 1, 0);
INSERT INTO `wiki_interwiki` VALUES ('wlug', 'http://www.wlug.org.nz/$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('wlwiki', 'http://winslowslair.supremepixels.net/wiki/index.php/$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('ypsieyeball', 'http://sknkwrks.dyndns.org:1957/writewiki/wiki.pl?$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('zwiki', 'http://www.zwiki.org/$1', 0, 0);
INSERT INTO `wiki_interwiki` VALUES ('zzz wiki', 'http://wiki.zzz.ee/', 0, 0);

-- --------------------------------------------------------

-- 
-- Table structure for table `wiki_ipblocks`
-- 

CREATE TABLE `wiki_ipblocks` (
  `ipb_id` int(8) NOT NULL auto_increment,
  `ipb_address` varchar(40) character set latin1 collate latin1_bin NOT NULL default '',
  `ipb_user` int(8) unsigned NOT NULL default '0',
  `ipb_by` int(8) unsigned NOT NULL default '0',
  `ipb_reason` tinyblob NOT NULL,
  `ipb_timestamp` varchar(14) character set latin1 collate latin1_bin NOT NULL default '',
  `ipb_auto` tinyint(1) NOT NULL default '0',
  `ipb_expiry` varchar(14) character set latin1 collate latin1_bin NOT NULL default '',
  `ipb_range_start` varchar(32) NOT NULL default '',
  `ipb_range_end` varchar(32) NOT NULL default '',
  PRIMARY KEY  (`ipb_id`),
  KEY `ipb_address` (`ipb_address`),
  KEY `ipb_user` (`ipb_user`),
  KEY `ipb_range` (`ipb_range_start`(8),`ipb_range_end`(8))
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `wiki_ipblocks`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `wiki_job`
-- 

CREATE TABLE `wiki_job` (
  `job_id` int(9) unsigned NOT NULL auto_increment,
  `job_cmd` varchar(255) NOT NULL default '',
  `job_namespace` int(11) NOT NULL default '0',
  `job_title` varchar(255) character set latin1 collate latin1_bin NOT NULL default '',
  `job_params` blob NOT NULL,
  PRIMARY KEY  (`job_id`),
  KEY `job_cmd` (`job_cmd`,`job_namespace`,`job_title`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `wiki_job`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `wiki_logging`
-- 

CREATE TABLE `wiki_logging` (
  `log_type` varchar(10) NOT NULL default '',
  `log_action` varchar(10) NOT NULL default '',
  `log_timestamp` varchar(14) NOT NULL default '19700101000000',
  `log_user` int(10) unsigned NOT NULL default '0',
  `log_namespace` int(11) NOT NULL default '0',
  `log_title` varchar(255) character set latin1 collate latin1_bin NOT NULL default '',
  `log_comment` varchar(255) NOT NULL default '',
  `log_params` blob NOT NULL,
  KEY `type_time` (`log_type`,`log_timestamp`),
  KEY `user_time` (`log_user`,`log_timestamp`),
  KEY `page_time` (`log_namespace`,`log_title`,`log_timestamp`),
  KEY `times` (`log_timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `wiki_logging`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `wiki_math`
-- 

CREATE TABLE `wiki_math` (
  `math_inputhash` varchar(16) NOT NULL default '',
  `math_outputhash` varchar(16) NOT NULL default '',
  `math_html_conservativeness` tinyint(1) NOT NULL default '0',
  `math_html` text,
  `math_mathml` text,
  UNIQUE KEY `math_inputhash` (`math_inputhash`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `wiki_math`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `wiki_objectcache`
-- 

CREATE TABLE `wiki_objectcache` (
  `keyname` varchar(255) character set latin1 collate latin1_bin NOT NULL default '',
  `value` mediumblob,
  `exptime` datetime default NULL,
  UNIQUE KEY `keyname` (`keyname`),
  KEY `exptime` (`exptime`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `wiki_objectcache`
-- 

INSERT INTO `wiki_objectcache` VALUES (0x64656d6f5f6a6f6d353a6d65737361676573, 0xbdbdd9761b579628f88eaf08b3758ba48b840880b325e59235d8cad494a4944ab74bcd1500026458400432224012b6bcd67dbacfbd6eff48bff6ebfd94fa92def3d927004ace5ab7ca2b53449cb3cf3ced79a7a7bdc1e1c1e96ff5e9c9e9466f565e67e3a6ec6f7c579ff6fba71b3fff7caff7f16342c9495326f0ddfff811737b070efca2cac67985c983c3bb0a25f0592504988d1a84851a1e0fcbc5caef13f93d4f2f336a6a70baf1b62a7f8162a72b4075de30d0b12424bffd76fee2ddb3d78f5f3dfbfd77ea12147f3c1a6575fd295bee8ecad93cadb23a9b4275d918fa54e765515315a71bd7f477df1718e79349947be273677951e2981a01c9e9ef91079957d9759edd08c07cb5853abdce2497fb7118e5666935ba927cee498ff267693e6db25b6a791fd6eadd5596ccd3babe29ab713229ab64e35e6f23b94aeb6498654552674583ab71afdfa54afaa192bc9966daadb75a03c213649fbbd35c8caa2c6d60b22e9aabaa6ca0ccc5158ffb10a6e4bcacaae54eb22c17d0e47596a453801e2f132a04fbe05e2f4947a37251347537f909a04669b1d924b3f413c0164bd82d55d60d7383ede0524d3359de034d4da2e43d481e8fb3f14ddac8241d4b0a8e9552a779dd58c506ab333738b2a9bbcc12d8bba7b879ddbca55a190cad82bd7c3ecf46793a3dfda0757fb6563e7eec769e2f9a459525a3abb4b8cc6a2cd75ce535d79e16e3246fea04a6b8843a705adea5d34f9c79934fa7d06282156183575995ed74b048a3bd2390743e871d916c6e6e0ecb29740d7e24794140a17367d908964f3af119ab4cca091c3e4cd5bec1916cca0e2d40de24595ae7703ea1bff37cf4298183d4ed741ecc1fbd98d09adea4bc7baa0c8f75e8d2a42a673c33360bc9144656ed24a32956b4f1bee0b5d14ed6f9381ba615ad35afd565552ee67aa6c7e3e407fda68320f9d3f212fa5e2da3954c280bb6b4db0b7546db440eccbf067838aad0bb2a6dcaaad6fbcdae95955c3a64d3695a35f9689ad5766470057cda3ea5e54591ceb27a9e8e685bf63995a6a84eb660ef5bf6b6ab1cc654eb3eec1dc2609f94b3615ec0b8c6793d9fa64b5c341c7a3ade49c67063e1c07692399c3e1ee44e329c96a34f7971b9439bab5ed6e53cc16abb1d3963d072559537c9b8bce1f9c7bb28192e13be01a168926289a459ceb31d8258d4b011b0c33b09dc2298924e26745bd280ba6e0430a81ac7a847f47c09039a2551f27104395a54152ca4cee713fe4c6c1a62e87136491753837eca9f01fa28829ee08548cf501ff6c22b4ea591249c756a177828342be186cfb3b1b67e7e05b3551653bc925cce415408eba47bf774e3b5fcecb720caa65ecce76505d3f6f47b04c08b46cfa703c44502603cfa30f163f83b4ae1477273f9bece9ea64d3a4cebec9502c355524e26ddaf34f8fe051d2700f8098fa6cc399c409883096c4238a2c5e50227e7c1f0d1bdde83fbc347583376c3eac03db2aebb69c3371a3ebcdd3553a36bc3f76a4e5d4e13bd82ea788324e9353c40e9709ae9f5f00a1ed3f443fe293f0d67a6eb4e5a5116d1f93be49306c9bb51fa914037ada339e8454713870c2daf9ed03d022b6f327c21a920a43c2ba8abd92e26f2dd57e2454d47a6d61b6d3a9debe63f718db92b84beb1b8beaf4fe5bc73afea06878227b3396d972af4c5879da7a7603f6403b231c96fd7577b9337570903ac548b488af4ff2de22be5a26e575d2f86337eefa1dc0f65c89e5fa57931ce6ee116cca40e984f4235c291266ce062086f63ba18c135ab98196d11ba71709f08d2902631206f31ae02f6cf4d5a8d7549ee28efa0107db4c27841f2b37f57517cf1dd63d06a1e6eca4bd8a1f4bc1cc0c01e0058595c3e7a8fd5dceb310204f8a5d5c705608f7df3e0bec03e1856c9fd47adae55e5742a57cd09a43ee14b015387293ca3d314ce0fe299788818c1eec001fdf9676cf8f45eff33a1d85bfc9d348055602262171f3f6e7f97d4e52c2b0bd8b953b85910b5c1aaa05b70bf73c309b562cfbaf41e508097d6f00d6244a1c9c1e77b83952607da64c0318b510e774f7402de00de02b55a1ace4231965f69112e5c38d5d834ac6401c781f6d63edd6934c5384136bd845456c98bb788b0017e5f1b4205580fe0b3041470b14d9e8204be6191975d3bf3d0245e1a23c5c877f55443068e512f1d42dc26f43e42952fdeda652470d88861e7fb30ae5df86f73536f449c6978e4478b1ac90fc1a5a036dc7e50c372060790f7e6cd55492b86a355641aa118994e965983ab8850e33263307c3ef2a69b7cc8188d848a33c6cae1506226b65e2c6659958fd229ac689835420a1340d18a269f2c617a66f7a1866e72be185d61b36e7e11b980e9adaf602dc68c51003505f5d165d84d0473a4c3b0322ac45626593685aec08392c3fb34cdae11c704ec7e068dd7dc5fc2c09962c461375823204053c0563dba8b3b1076425e7ce619f213049383e84d5ef0d0d2eb3287a6054b2f8bc9821680ee46becbe39ed6ddcd4dbdc935c3a8ca0872abdec6c3b9427e02dcbc8a7f1dd02f7e57fc6f7cb4f81133fc0876133edd9e161690ec16f62e9fa93dac843711f480a694b01ebd841854d1b90ee519a536ba2a81d6d3f7ff3a9de6e36ee72d4f31e441264e094d0d160ce81f77c37a069dff1be296a3bbbb4c942623df2796e8de3b5a85cdcd7b3d9e732cb8b88c7f1dd2af059374d107f569d1948412331ad823dad5d20272b56cdd1546ed318904c81fe3624ba408f9beeb7d26c2b09b20b108d35ac3aeb9ccafa10c9e5be872cdc8384ce469b20154d9bd3efcb3217be7fb749c1249aff7c4dbac9ae57cf83340d02b9d2903d4cbe344e8d394a95f5bb62afbc722235211566e9acff03eeff0f9aee4adc763be018f70320f8d01ed995fc2addaed9c671974db50386c583696f667ff401e49693b60aa50218c7a862f88bb546d6b405d8070678a250fa09ee7f0cd9bd2e69ae950a2ad9155d12e8d0489f662a38bbc0cd9a2295de9784dd0ad3ea3bb13abc72ea58d3d3d504f3e97155644e445411bdcadbddcef000cf3c9f4659fa70376810c927930890148edf4adebd43f82d5fb8077ca623aa67e029d860bc99b8d60bb1dbdff216f08b8e4d2ef48619c348020cf1b9e1769985e860e3376b21b7c6d61eae09f0a961026aac1159f964805de5ce5002f13856f83e1f3ddce8b463a974eeb1257912e0a6b1876084e39f31bb2db394e0ed198d07a27bb4d91eb926c4cf2fa8a6e6fa237e1f980f36cd705d0e77657f080c3f6af6c41072731b38a6628c9903841d2b7a4becf9069d095430ec561d76a595dc32abd497033a778977f07db2983d3f7e3bb572f0119010a382cac31b8b827496078f5437ea029e5c0850346172b0111129473fb3b09aed3926e55588dbc0034031f2a5854c0843f11c20143da355a0be038e506c81bae0f5e491cea922e4dc0a21344d290158687a38263476799d6b44526223243b7a91147df43439f225a07666eeb15d46a3c87eff91a34bc041168429b8ce4c74eaebb17ed025de29dd159b90309a5819b8f715bbefc1ecc1f21aa66c31b354867410338487aa7327e723b3fffbc9e11f33942c5053911b4898a53b7004b7d5d366e3b638b8a07d11d28045ba308ff061c23da35c9a298ca1195d3c70fa092783a0f5576896cb98a27bec5090482690259051cf6cf3491f390802cc14e1b33855edc1b74133934b071a68b71c6bd339082b8a27888f2ac96517dcac2dd262b693b19aeacf742cac85a09424190f95c115cfae44990475b00ea053d3b40e5d98b40a0949e8d03832486b763832ffacf3ffff65b519fcac4fcfefb29a22f553e5ce0f351df9737746557753bbc6df0455aa9e2c59ca088d30a73c86f2c735b9921c90c2d4caebbd146cfe7e16ee6e9a1dd80773a340fb43d96e7fa6eaa1cb1461a5187e87a2021b10b937ce457aee4a3427810dfe5f5155da9702cc7b4ad917144ff2027153a87981020b663d855f58cb97479d141e4b41aa7b043f8a50e07e06d39cd47cbcf73fa430c652463703b840ec9c9e3316ce1e320d7f34e32ca09919ad353be98a65587697f3a1bf07264da995fb3f1b6ddce3cc1c527c147694e0c21d1d957f21ef9a648e9deebdbad706f906cdddbdf8e8b38862d8a271456c4431b3c70b838e1a9c9e1dd68f219dd0ac234e8876a1491d49e5e405a1bc6567aef30623b01e68f3c543c19ca2aa5355814e193901b2058105184670769a2e9b2a3fd0dab8fec2a253b89490f645196b538ef5fdaaef89022b432c3842f873b06102a92ad00f9344c8b9afad8ded3e5747c51d33aeb6c408af1428f05a2c9e7ebb2b986f2530d77d12890e29894f8b47d0f6685f7f1e6a0ed1671f370cf908c839f7c6409f256ebd41932e5e060d264132e8db5f201c0fb997010ba72278b8a4ae705e36f300b9d94247954c488c8297ce17a0154405aabf25356a850d1906b4e4ee2f49315701dde418f5ffc49891c3f6cc3406888384264301219a5a44d7d6a57eae2b2ca10c932c101a4243e69df03195d7412e40f907be10be021320e986ef77d9f6887e0b8051a0e1dcccf1341b1594e32cb66434028aef2b9d02cccc284838cccba81225bcb71cad235781ce0bdd72fca52949eb3f48bb26ab85342967ee1743c4901371b1b5971bcd79e6eda542382025461be54ec2046c1c2e65144684ef8402a8ce843629b8db2e9ca0751d2843f911485cf0fc95b1457e7f4c00083e9219242ee5c3ceb5b82aa45e24d66505061e68138465b77dbb5dd282b8f3a7710387cc834610edb77cce51be99b59d26b4e8f49ba68ae10719ab489ad3daca8c92e4b4413ee48e9f9949edc1592b2d43d142022ced5a0bd54238363ae82f2ed11a7edaea91b3e47bea983907d71055328f29a03c70ec80b6d65498421dfeba19c90a9c4de71f404f299aa8c04cdae269a2fad8ee526bdf555d1cc305f18eb4224cdaa5a5f132f6d5367f0dc1aaff874e3b39c02397cf2350a5f78f2397355b479d83eb4f21eee6bba524d369b949af8646bbb8edab6bbe809209e1522b174e4689d0f61a1373737118f3e4589f2e34983177a7a4db24545aa9587385c62738c070fabf2069ed7cd9a0f3053ad7c92a4d92e0aab5f95bf02229326f793e73972246fe1d7793a49ab9cdabbc2b78a64949b9be757f9a48134a07b60e6498c8c3b6f73f32c4351e8e626915c449f42e293a69aee5291dd3328b40529b3b14b0044e9f11c49d757e968fb3becca8b67a1492ebfbeb109b470b5aeb5e7079b9b54d35fca0231f4b2c20a4fe1ce83c77929826f9c80d0e504ce7383c4b4abcbaa7983af3f7689793774c365cc00506507aa16e5fe506d5ec954e7385befca725aff4b9556d5778e10d9dcecea4e28a78b59a16c0ef9a2b7ab3f2089f35dea307826253bd1fcc40350e5c524af66ab5fbd817d5ecc1715bf78c8337da2a39031f82bed4f9dcebd9e9d765ffa82a78ff24e37defca5d544b8d5697b7362e2528f5aa0862eee1f077902231d88b7678087148c99c9c39052073b7825cf5840522abf12b0451c052a768834819f5562f18bfc363054a56f46ab2247a0a0a51eb3aac84ec85b14703dd68de88074a06c8d0f22ae2fbf850689dd1f97b871693273667f3b0aa3d3a63080b4b01b84fb844f90217c07473c2fb305bf48d4693aef2dca78c8d2052ccc84071d78196d9d35d44fa2a9912fbfae06d4265a5c5efd9354b55d96aef34a0ca312da336e44ba4e5825a11379c507cb74b6faa10e15f5f6435af22cea6c6b3351898b6139a6bb7b8058f23923003b81c387eb431bc2d191483f2115ecf80a29538528b2209ead707061355bf30503f132866ea7f3ae8cf7157312a432c053a6b88f5138841423ee9192370d72f180f8b98695e9a84c9bf9222badec2089226f20a1c4ca0691ebff148eeea0d37921a719fef72d6037dfb2bc0628e3cd4670888409a0e21332d2f141f50b342ac75987e4764414223334b9b7df351cc5cf7ae0521ff2ac43c37824113fbf4139abbc5edc4ddf4cb775c5707dc2d5237a6010988c2bfd630100fe0a4f22f7761cd00b5fb11719233ef5d39a33c002be1be18beb96eeaedd6e75c6125254327a4595ac76325cefad8213f8212849cfe3bf9817578345bac91362aa6a3727c4c294893106e59ddd6cc233e22a96a107fdc2f64ad48be12fa2228a27ca6fc3f6bcf91edf5197495d8e8eef9efbd6bc273f1917f146a487745ab2e2977219a3bb2be3b6a7e5b8279c0862f7cadd53873bfb4b976247aed5458d3bb87536bbc96339b5cc03a5a73170b46829e33dd161f6a7e8304a1bbc9129e786794ccc874cf9800b479a15c4704f017952a6fc12adbb01185b895fb795b986d9600163ebad1695b6d641779a6ead1cc930320596fd295f6a72dda9bea2003a1ca3f5ea01954f22635ecb3de1a2c642bf969243ef73c34a0e46f8f1852ba4424aa833f685e49a90ad8f235de9ccbc3bed9c26cc255f8b19b446a19d8c1a6a3f818bc2cda23b088965ac1e12cbf28ac4eb67d240db73a952ea5bd437adfc138969884ce186ca4e5bc0986614c94bfc20d0ab9c759ee40d464ab8deadaf4ac0cfc719695b6b19a0cee89ba6b7f6b56319656722fd2949461ecb3773ba61029f1333c4e1948167adfb8e967fd4ce413aae9c2fabfcf28a29d1bd20b1cfbd721b6172266d1db862c60d3a0edc20cb7493e9c095eb8253145d8e23df17de1992e03468f671f3cb9e2b4c6c82486c343c5cf2a8f294f525507d575028d2ada18ac63240bc8eeef593ad9a44cbf45c8c33b845a6f5b6e983303240bb8af5862b3e1c5ca1e825cdb26a94a36406791f709d213faee6ceb11e08de58a4ad5a4885ac9d869acc48bd7759a0d031d41eb98db07f67395da80b770ddf54a51e2cec0f503a13a2d260327314f73489c803e68b2120ced0dc8c0475c8ee9cc1f256909fe14c30cbb4db5195b0a76f92d76fde25e7efbf7ff5e25df2e4cddb9fce5efcf0e3bb674f930f6fcefe927c78f1eec737efdf256f9f9dbd7a717efee2cdeba021b6b2ecb27e7dbeec06ffa105c4f7cc6618e88729e19d3456d6ea26061673721d0faafe0fafdc7fedfa74fed8faacdf9cffdb166d2048154c1fcd2963029ab8d9a8027d8e5ab0a8e8d2ed863b81ee78c1dbed81148526977ad40255b2e58418affce2b6ea744a45aece906a551ab72a7c11ff906c5c02eb1a55e7910c1e5576f90e48995b7e8d16a6d0221ade24090b1c28d14876a9472dd0dd4535fd02f89ea58ae62add77028742c15ab186130f49c9fa3620aa4ed2c3d19a72d02c6a5fb77ee28854293be8edec8744a7cdd3a3d4ccebb043e9d7a5a364752808c7d20f5f320949c79c824232d70d3629b1442c36a4f60d094552f8b1b121582923a99780dadd724f09fd2d473403639169e24d9117e37c442d00827969c61be504efa28c3500885d1df4555aaddca4f569e70109b1feb18033fce841d390b239fc7970dfa5b3c01591236865b22858d96883c0fb04bed1edbc5a9efff5252c1060c06820c17d6798c129108902679313e66124db68ff9f9d893f34406450df3100a0e2efea37f77943cfd253648417e3a024bbcf69bb88ca5bea01260e590dceffc6e166a3f8d731fd2279cf9acf2333a5902fb7474f2c8f719c01da44b01a126f823a0bbaf2a4112c854f15b386e2440a393a0e0fe11a3a4ef0afa7c6a88b3eb82efcba806d7ea1d76948667990deb28315e88b51604822d2fb13f2cd5a921e45a4da45194dd7ebfba922fa255bacdda4a41b161adf5bad21684640f50f1f3e15fb1de3423d7cd8a14d86bad079c1b4b1d21026248f3538bb89e0e68a94cb60f266a567383eecc69fec4410a8a8d7ea9a9cb12601bf85dcbfb0ff68c8fee938c48dc213a11db40b8cd3e52e46551081fc182fd9d85fb1fdd04c82cc78cd3344b967f93a9928a788ed1aa51dd167ecb3ae9c287d3ba3371d9e702b4eac6662fc0b85462dc06a7d6074eb94595424106cb7773799f78d9d2204cc677a46c7228bf45981bd4f4083b0b3019dd3e9a88d498e22c978c6ed45b6a94a9cba04a738959e2dde858062e1246ec76b8d4d587d761203b917b583cf6850c3d0d94d348d3be894377afd50f0c249b4039491a0076b750d7843d7cd1d0b4ad5d78d573be543190e97cfe313710dcd00d169aab6475f53b5459d7712c80eb34ed0811d2ebdd62d4c86d4bb01f0f374984ff36619ebdbeefbd6956ddd3f70a9a28c64b785e221628d0c3fcd30798f9303468164e8564882ce3637acdc2c1b6adb0e655ea7b3617eb9488da6a5598b929df9d2c94a11affefd0ede4934fe3c1d0bcc1d65027672d0162fb3b6922a5da4c983fcd178b5330feee78f887db554fd2b2d41d68a73a024e6554e0c13a01246f070419be958a80ed194479545b5a7a893562b390a7412617603042b4af4a48697a4f7e2ecbfdc8388e40cf41a2833eca59af312d1634b9fd7a3690a585b652fd061a0fe7fc80a34a3b8181b941d3c4ba9ef4ac2352d8110ca56746238795527a6056eaf165a213d4be1d547eb516106d641e38734e9f2aa66014f0dd7ad90e958cb0ecee80daa00a5b58344968f1ee55609d253da8163b420a6d3657ecdc22c780a910fb591c01d0b5784e881b0466ca8d86a91dd302f737a1f5521e169795320f3523ec7ee132f8e67a85e819485b2acc97a3066870b2373c59c9e4c69806e2d6823c5ecce6ee77b66e3a22a276f14ca46b541575cc83816b3132b56e5ec4e64825bb85ab0aa9a62e3dcda4ea7cd79759526acbdcfb34af47357ae8f672200733f71f7e0ef5d580b54729cf2b3b42f20e10d12be3429ef31241eba29120c8ec7d8aa6af72a9b8a1aea00514ad19cbb6a9af9e9fdfb3320c5bbc82947515eda2dabcbfbf875ff472874fa4c2ab9c027b6ac70fa9ac53c9a938f828fa1e6465024333402fbe2709fc13e5f3c640326e984cf0349911391922b31d1d7c2c504066814f8332ec989a7ca3ed4968291f3e0c8262f333a53a4e891f05b9e6c843583f89ecc6230893fe6049b4ae91dae463b0dbffdebcb3319109d232bea9bc29a6430fb96e266ae1fc1255b92b5ddaa03d039aee330d8487e787cf6fac5eb1f4e13e5fa285f1c1fd545b35b4e76511ed23134305277ea08170abd65c0ddbc43874add2ccc807e4a604f8e045db12accab02600edd9855138657c7bc713f3cc9daf6abebc0a18eac75782417484163c3d2124aba6d1559a508e98a0e5a6b5334a8e741082a74e3c137bbbbc93b64af93ae928e12f9e42a09a2ad4dda97e4408078094040ecee1aa30a6b45bce5d2fb5ba0f689db4d7b4e09cf678e5c7b16384cc792231728710cc67a67ac13b6a1fd44049c3874ff506a93cbccd83441c4b64ea864b38989304a5c6a46a720f1c138bf06047d39cd1e6edce4e3e60a90a36cb6f1e8dbe4cd9cf56dbbc963bbdd01a3acf9a2aecd6401f79c1a39a1822b2179a828829a7be9d424ccd21b56cca08a1635cbe248d64ecab0e69e25e7bd0cbdc5472d6f04afe07f69def0d5638b0c5d5cd2a285ab1e0d2eb8cec6b8bd74f93153b6ac3ec14687613fd2cd43f322c6e6b02ccfe5a7cd9918e3cb9df02a7c217f8c2000995959e15e7f6ffd12c33ce9895723a4a8b09dc26ef2ba94c21ddbc1783db221ac698106ecd024a07e689e34116d0d336f183818c33a51fb52151548b3840ca2c5fce80e0390bce820387289c4dcdfeba3ecb40d0b68382288c5a7129e4c9965662cb56af7f64f2a566db7e1bdbf7404ade2b50c9a214225215290d4a5a8d08ef2794ecf9b4c310aa43a24549c4f97d14caa66c13e3ecffcd36535ad49b6a4818331b73aadf32fa38ff1a76eb40d1dbb08b6e179f445000df91c40ebacd277cd163b68fd04431f859b374b239ef7e5f1274c86f4ace886243bbf6c56ab3c03cb8892ca0c653064e3b1c8982e6996f352d1b0899a369ade139ba2dd5c6584f3ad13a6ce45962e0855c053d0f87c622a458727cc1dac927b1f1ebf7bf2233c9fefcf9f9d21136da743b60411578de89a7b6f1ffff0ecdd8b772f9f85d9bef7e4c7c7af7f78f6f4cdd993b3678f519c81d72e023e7bfae2dd534821cb2e4d7873b6434a9ca1aa8bf7672f8dafd44263ba9dcebdd7cf3e206ca7f38c30b44db8fa16b3595a2d4fb992f3f7af5e3d3efb893f5ebd78fde60cdbe9749ec82ddb08325656a7a4ac70ea3b73f1ecd5e3172f3b37e415c4a77f78f19717c444736f60a1d608349382928a52714de4871a1c28f2e06cc0106b70cfaf78aa0a4693a829d908ce1f6a4f26d3f492b563906f13dc2189e23a6953c54e9260ce12ff1f9d9549050715cd4ea3458d5a62ff299dceee2e697db1ee6fcbff127491b09a1d1e4e076a7b76f6b76767bffffedb6fd372944e17d5f474c58dd57d9cfedf7fef749e67d998bc41908dbecc159a0da326e2283b5d5f1f619722fbaed9f29db003decfc848a7ce087670c0048088e14876298bc1481c8d88b8ef54cad8fa521dee103edc83b60cfcb59fad5706e7fa020fb17f0e7a27de60885fe9cb6068278568e1e9fae9a3d655f5893acd8beb0646181c97f0d7595b8be99f38a7f1b13444131f0b94a00436f5f1be2413f7d3d8baa46e07803ba2dfa3745bdde43344b6e13cdc5c6585c139b7192cda570450c55afe370d173f6842958f1541e0a2ddb236d3100d5495cfa95e0244d189f24847068930148ceacd7f6bc5b035f68386ef355ecf7abddf4a6d4a9c69e55165346f0ac90615d4dbc11af8644b1daf11b7cf9b6460e3a8b8b36ddbea369feca6c8c803d4049087853ac1792c6976b71360d5e4ce7981f6c22a1aa29815ee55b3f322031f542e9e935c7e362f0b4f8a5119d21128e012b3e6c92ec992c3f0017a3449e728d3aa0aedd893e7c8120b4906594e81d8566b6282c49424241dad40eef60483a8cf7ef85e0f4c1b6602ff75af64129ec37fdd1f09f4d8406598359102978b2a30160e10454d492f0df66e861caa6856067b5fae64774ff792f94b21e1ca1f2acba41ba0367f08ba2ff8ca93e11f021f2878f587c0f7a52f677f08fa40a07ff843d08702fdbdd25f064d869063d9a5f3fc36338de917a418af30a4422a9aa88499f90a2285be005fc38b39cba2e3e04aec1addfcbe083db913fa50f6e19fdf3efb21dc4404048739ad55acfec47dba9dcf89bc590e516a5fcdd2e97a18ddf1e7e5e48e5afa02f1a3baa4da3788bb34b6c83c45deae13855ed44d39abd0ef85480448c79752c52e417c4e0853a7df5b5b321c011e9696fa521163094973ae88cdecd86928f4d5e787e028e3b6b682dd0b5a6a9c5fe60dda25eb9e8b141cf0b00b447b705a4109139717bc4a8817ac964f9b34b924f6ba5d273ab7e3ec3a1f65823a8db37a54e57303227939e61b6e95b441ac33d8c774fa6b097387ade8fe7ccae909662421474f065c411341a70df380a4c4a5d98465b7f3b286776598a7eec2a745e08c0473a283a145c84f5bd881021e528f5af076827ded9678b2065af6d680fdee249a75377c4f8fccabb458a4d33f50c20cc4a9856105b86a163f880a0e9bf4b24a6761a665046f43facaac4a1919470fcf080a1b27e897f38b057a7255f038be086a267de1fc7db53f035d20452ba0540e5b9eb1a03b8bedebe0cfaf16f8c2ffb152f45aecab5618329c2427d9c2bd458c28f4af07133347c7594054e5d974bcfdc54af9463e3147be77543941b4bf96dec22b937da5da239a77e8ebdbb282eb16e837dc25ec1761342deb6c314fe65765533aaf4848df20db132e0764e561ff4bb8f0bedcd031350453f9122e957a04289f6b696a695f680bd583ac9d95c3e695bb6cabda75b9bf067a37d6190372aace46c9d6bdbe0978a908721858fb5121e9667649472b90bcdf504a7efe44114a0601b2ec4ad0fce7fadbee31cac51bf6d21c25115012d2fa514d8042f83b0e37aa79207d2e00c99a9b7177522c9c76d3f3e4b57ddaad21206e96601227f785016f5d4612769a1597cd95cec5cbac40721e9de3858cfe60b580abfa8035d2cda5671b342f0607b3194cb0413c770de0d6181c40f1c4204e7c1d73d85f19eab04e89dfbb28c413e7915643004980481464d0fb4a3d7c1b417f8040bc12ef6c872b656e4321dd8ebee1bf27adfcd51a965faee1a7560db63e9729ba5622037a3d1de723d84e894f3c5e05e61b9c2ed922bb13c8e4762fcb9b0433129185ac03b697e74740d1be0a3dd0ee5ad52878be137c5f1f8550b9c1db5ccceb14fdb52fc64664ba4fdbf80eacca26daa2822691faa96d6b2c04b7bd939e6ad3af53c69f7e787b8e72bb34ba32a0182260750314abf409e1d46b84ef136aba0db3b452040efd8ff0276167415527ba86e382321ed46b3dd36110a36378774d7b714d63e164e9e89fca372bd4c54507eb8b6a2f8edabd187fa1ae5637a6695839cc7b29df5feb8396bbb30f0ab06e2a7aadbacae23274020d7134615de1fd3b0a6b4f8e577af2a5dafc7488ae52930be274249bc8a527e25ecda97587e292b13bd3bdfe2abd2ce0891c2596777721d3b57f572db256013f5fec3918a7f0559612364abe6050c252af19543ebb8ceb222a4012c8627ca672b6c1fa523aaffdd55db6ae1a7f4bf8cd751cf6567cf904b05d53fb048c145ea3e9d7e04d4df91cf0a716fcc92abc8ca43fd00660105c32ea99bb53a29d79e236e64a139ab11b64e888414ebf5ee0460b7cc8da05fc42b6f739dd4cd8040c824ac67d73ab304be7700f2ef83d0704e1870cf045dc95b07baeb32513a48b3a7805b182b2c11c03c5ef394df7c7d91511c61334d8077a144ad4ec596a16aaf852e981961e7cb1b4bb0d02d701cdb0cbb1e22ffee108304900f27bab8617633a4517528ab69c5b0a0bbf49c327ee45cf1d1da2157460e7f8a16da3ca281031e6cc3b2ab1fb4967ff2ff914edc82b35452c17779498e9c67985f8f257800bc10eff821efadb3b8440f48dded36e2beed673730cef4ab3304eee998c2871c9876de0dd540f9ddf3cb9505ece196dab18e9702333362e06f418f9296385d6f681457ac490006c13279e382f5b6953ce60d38f50beb0dd5eb5a612a748fd5eeb7e44f5755be7c35609bd1b0fbe78374655b8ce0a41919b171dea6c7a19f15bf478d005dbe2f7e0c3c00ccfe082f1d0c307bae11055af8cc777ec81609dffb1c8422fded3b7b0f25e3c8df61325920a8beca70ffadbeeaabc2e793fa5c4a3d24ebd387fc37474c219117efecb3cbba4a5653e9d2328a1a76f261392779609725193f3372ff43dbabbaca3a45072b1c4d30b2b41158cd58a4a5b9f92956ba043fb680a8cdc4f9776bc0acba8fd114ed8a7a28d537b38f576f5345d4e6d094ed6011a4bf4c9b45c8c97c94d96a2e0f3ee023d5986f3abb4f5c644607415a3872aed4232992e4a387ca4c4bef5343938dadb4bfefdbfff3fc9516f6fef2fdb77d744d73259baa74bd48045fb305fd5eb64ff50aa3ad8ff7255446aec933ca79caeabeb43323891baf60fbe5cd78122a11fd65403f5f4a59ec1d197eb39d28d718e0e6f9011c4d3f5f8ee22c77714f9feee222777147972e716eaeb717f1e467667fd7dda4648531c1cdc0dd453a0c32f00f515e8e80b40c6a439d8bb1b685fb3e822003c252f93665160eca118698d4ac900f016200d80e91f3997037df9df49fdc91610b830d3b2230876fbcee2fb72a6025f691dd4895e15cf519fdc1d541d3d1a42e9989f000a52a5c92c2d16135484ae5a5800c2ee1a179d5c9b462f2fe65768661d288b5013d95fc76293597abb220b269221bdcd678b19f10993d44b86f55902cc23430ad6f3dc5f49da2acfdd43afbd0ed702f604f031466ab8fc428d7dedf713d24bfb400f583676e5c288a372bc6d0e64d7dcdd00df6688f094cddd50fbb2acaf16d326ff32e8810cedad1364af053c34c04ae94d636e2280f318c95bc7d20e3dd49a4da3cd95d9c808b737f3a624e76915a01b23e459a9f2376ea2b28a2a46bf8a45937a24e34d2be97815d4240f4e48b90eacaf87fdf9349fa3a3f72bc8fd95c2954c977796322ed659d990c26eef78ef7ffdbf7782ef6b8e3682ee2dd9a5ee9d650ef48dd4264ea085e4c9930fac82f4c72b3a34f438aae8c39d05e8d121be455ce09f6dd85ea2f608a87edd5d24194002231f11da34af32b7b2b825519eceea0c75ae19866edd597c57df0a51b9f803250ee594fef464f8c422a67119ecc3ad117e7a8efe86aace1a6de1caf0d9b8d8322e76c4c5b49421af463a22e737ad56743cc85c0949e3b4aa10b13492f3f0ee72bbe6bf6574b5283e2d9dedfc178bf5b51867ae2d56e5a8c938baaad83d34ac4c0862f2244a454c97c103900ed6b8aec329d02f84742946f736cdc9b92be5d0de639ccc8a2474d9c42f4d95a1adddb846c992e9b6120b6eca466df4d05bce89155b11221c12e54162b0bf53eb2bbc787da3d0d5136a27c18e9aebe058f042a6b6904bc470c8d7edc1fa4cb1cec89e2f1b3451a2e7b94685efb031f68829e0538e5600d7e96cac81b2671eb9f3f5572bed6bb7883b1fc3db922092938dd239beed1aed82620ab2bc823312cd31b65fbb188fe03820a95f86d6b7c7c4925f06ef4be52a2efd32f4401fa2d78cff617e8420518a0d764f076b29876d38ee2f050012627dba64a1e96595ceaf34a44b74d7d678ab78ee528f75d45beca4b0dd3cbc4dd0fbc2cbf1d7c3f6f544bc29b2dd11baca26bd35927ba0d27a5d565f283dd0d2ef6eca7fbe34bd9dc8777987915dfef9f2075a5ed4f4c85928f1ceff587923c1de5539da6aa6d5d7cb1ceb0bb7d2e64a0d61cb5ca5d55cf5124f88840edf61c368eaba03bd0ab4a285b50ad256c3321193681b109324d2a839f76a089ac845c4138a41caf72a3b5721d7208c26e3ade729ced9a462ffae282a9da3b757dd4ee79c9f18401241d8c4ce11d14ca7b4444d7ead6a1ecc58a4ac644d1e97c53b7bb86cd819b689819981a3baa7ac7317eef77053624a49ec22b32c66fe18f1b8514d7c45b02b1ad22651ec9bd587491943ef38c38bee888a17f848a477b8be4c98ff1316d513a7974a1cac2f41c8876e94765349c83dfa42f175b4d9970b2863e9553aaacaaf835bece327a8eb9268a8f12f171ae884b3ecb309c55a13de5e389d8528dd4d1f5939ce0ce34015bc77c803e6ac121ea878c35a8958fbef38147daa19ed3a062b757805405520c42ade487abb067db6e15c1435605aeaba4777f63b494fa20cdd5e685fe4dda90ccc4b2047308cce07e173c3746a9b77a00cb3ef5de2c91a6851443b167537460c875f2b646eb445ab6eb5d8812f4606f3ba32dc2fb6a17748ef321a7d5b1f04e6f2472327dbe8a376f1d6e980ec8ee45687a3389e8fee86cb3d5c1edddbcbd170046b904d26394519a539df3f8cf4d4135edd32f8b585abea366997b2cd40752afda5c6d1d0b19f08337e92b4b2e272b8c110d3d54c3664d324d6fb446cf727e4a93f892674b93a677f13c2b33d9dac1f9623472384ea81b56637c4b55a18d30a0359432a2666bc3e18042fd5211eacc5e23387376688b3e2c6346fd8887131c767819c7c127e614e222c8a06e7d5e84a23c4bac9d8951147c552b31f72324fd6cbb9daa2dcf8ca399e79e41c6196556afba4b5c08e2d257c5d5eb36f42a800c34b3d7a534c9714e71ab3a95a69a83d0ab3444dd12322d9c6401b1d76da0fd4c7b578d8e98630bea25a5a994371fe727e53069a06d380162574c5a319aaf8dce58851ceb44e0dd877c84081ac0c1738767630ef9617ea2c4a9f8c1b0a63cd767c38878c00d5a586af8a28560911c57ed8d928116d5983cfa3bc46abd1b1da3f8aeb1b7e06c9d6a8b67024dc270bad73280ef6471ce909a7c556805c2aabf782d09dd485afd2682c1d944359576faa943833b084187025f9fbab97ea4e9c83d2e6335121a41da12109c91133bbaeb030e39deb3ca51e5900a799ad1dbb56cfdc62eeb0992e0f81c2efe936a2010dcb5b3600dea118771c32501de092657887232944b6a16c14bac63d8473a2424106a621fec24ed02fa5c0043a7de45597fc63fe829efbd7d56a0551d34b831ea8b33b5c0e18f60b3984c44b65c3c9a52c22d94162643df6130d33d2bdecae866de36d70ffb7df68a6c97413fd7262677fff9d6361857b623d54376c7376ff311e3ae78afb1aa885acc17209ddeb1c92049b731cf538f2cf98b0b9bcc5f34a29d4fb984d739d536eab8cbda998079f67e4bff8930bc785366de2cae4e6e6a62b01d9ba800c886f221313f7427189d53538096364e82d14ba136b44ea94b8ed243a81969ea7ffd05f8fff2a0826a479537875272400089a0de35fc7f4ab5aa416aac77f9ee06736268f3f8292e2f7a95e68a8438cf62bb62603757ecab1aa318e13994693bf360af2dadfb035c5d2ec4acdcab39f87564426ab417df970c17a24a33e673363bd7d3037b3c0c827c464a02a42380572aac030ea5ecf424ab3e136601af924da1f6c2631897cef89614b1ebcd887c6512f78988fc799e82ceffdb17e7ca7fdb82c1333c16ddb8a8baf65b65565b3f39f7f265a8b5c935f2d66c3cf23baa63862b1ccaceb1c87ec6ef5f1e00ff6d15c8172dc6f2a80a1cb6a34defe4f1b812c3c5e59b4d58884fecbf73bc9ab17af9e11b3e93479805eeac96528fdd08380e528fa7161eeea48fddda549edea1caef5a92560234c90d9aa2463d8ab13648dc73b55f77845d584331295e3cc3b4e895450b77feb360fa2580a80617259cd8e1483825d994b9771a9fb033ec36a1d008720f845e0280a88372c2d948d39a7122f69a71248ae619f96aa2dc3377cca1334ede485f7cfe49e1f9c841d6ce98ade3d8ec105d7084d1010213b8c8be564a5db19a9e7b682dcefdd5c95125c332d961c0884505b0d5c85a4b7b405e73571614a3072ef8c9c8ae90307182c4664cb515afd89fd09c1de42a7b55009bc508f56f6ead330da8f1f1fdc1730f6482b446098e73a5c58c7767d9dea858b0e05ed3e44ee277e9cbaa0d2e2471b675096fe79958fd3e5ca07aeee0f682582ca4862df8a54e4246b463441b4eb340781cbe807952fcb4bd849e4fd951a3884cdd57940c821f3ff1e6e5c66cd86784c7ce85fc04b2a8b0fe07da920c911dc57f9889c203c80071f37011c62a8816f24ba161e6eb033ef7a83e51f0f3782eb810d741ffe95d2c56266250ff6fe48893cb3021883e7eb05ca9502ab25081716f87f6c5064c4871b0338edb3f496b5a51e6ea0dcdc2aeaad6f99975e6b1a36c50fa1c8408aa0bfa33545ab749c975a92c274fa25c1edba768ae939cc00447e60230fa629a0b8b801b5e423efdbe0c17dcaffa7fbf0e1c307ebc24a3398f908fe7195b38ba3ce83fbb8191fe9c5f743d9384fe9f8ec3d9657eb12b1bc4211b93f794f9ca1907a9c421b2f8afaa2d727f9c2daa568d4bb8a7ca0e38077d582dc3bb2fb4f0af560318525ad185b0c31094bb8ae52ef97348a81ad6f8900631852ed00263f8684e5ac5cb0bb9b7a0db4d67ce2809571c160430b1f6a556bdcc79025d108f3304a72375c2feb727e777d36ac3d1fa554f91b0caef191ac71521e652798096722ce11c6b75a529bd967169c5e750c050b84768561daf085430a38b5d040abc02ecee93927c9be085ed1b01e62f85d86249dfa1a96756c7ed570eac712cf319a2a00e3edb91b7056c4101ecb6c934327987bc2126257d0d126aa77b3b56e03438bc7ab90bb2d95d67ded7cf47a6fc12595c0ede4e23d6d9f06d6871b4aa8d8565d336900a78a37adc0036d93ce86aa453b10ef5c9905a4f7fd2166945857a6241d2bc8fb56a7429fe384572a07c779774dcd0115d6c998c255c6ee0285760f9e024718ab3b1b7798538000c62d088e5e5bcbad0c27c75a650694db1c4706cdc336cf81872bf0a7d146af7731f63194082b7c429c5d1c10ef14172e6660a5e0b8cb4a0c42c8108e68bb34476797b640d149a8771b3ce821442beecb174f93cf9f13d2ea87bf0eedc1cfb3b80b0b0c0e9fcfb25fc5fa4e08248a654e9e73256e94ced88fd012722f1c4d8df568720864dd77b04240e30cbe44cfc9493fb9923cb90f7e14af98eee731ff34627920be31d57b9182e7e3acf51337f48f1400a75e4c43cc214c4a5cda112735e548ca5ff9aaeac6526bf5b88fa9e4ca56faf72cada679669f983d4dcd6dcc4bb2b7d3934e99d9a546856335fac944627692cbc9193a2c226f70f806239b2a336f71ca51d268a3148e058f07dc1fccec124e8dc41913ffb2c312be661ac7e525b57f9a6c8d16d576f2d00cb734be7d8b07b5d3d9c2e1ac834473aa8cbc14296cf20ac042a4a7aecd70e0796a3812cf070d2017b1978dd38d5d5b7601a8af8479dbaa77df3e5d00a583c3c841bcb0b0945b604144e5d1bfa2db473a762a0bf86365ac9f586e423b7d6b41c794cc19a74b33987871095390b98ea00d24272692cabe9829a83a22f7400bdda44bc373a20a8294966b407f8b51161ef729ecab741af94def1f04e779743f13ba6aacfff04a4858a216832d177a9099a7e6304f0861f3a6475e3baaa550a02c744852b4895536d08ba9a0c342ff1a8dd2535734fe22219e1b73e47e995fcaa16328bd4290ab371b66e371a480b227609e0bf6527f9f58a61de4e79ea8b2ae6002cc002ddae986fc22d30ccd052c56fd150e8ec52119ca4324fe3775a80e04397a050bc1c4ac16f3be78bcd6853eba5b2383a59a99e3f7fadda89bf0d46bd87644005fe614b169a61eec588baf4ddae3c571ea67c3ee5598aabf61741df14ce3ae5b82e3c8e7e2100efd18712474741a42b75f1538d669ed58105d6bec3244f80df1158e24a7d6cbd7f03e6af8f22aba2e7b47f474c4b797f2063cf79cd9135bd008dd5ad47087001d5b7e0719b7d70850d960da30288d225faff9a32714289a99d351e06c6692e96293f759384b08459eefc3cebcbc8a6f41da7e2e8da7290c175d5fda687162b0afb8cfc8fb1fb7eb16b8ab28c18bd9ac1c42e64584ff1c1dc7011658de91d72cc4a9591640d4df77c859c17b80825ff1b611619da0b75469574e33cb60c2de6c49d32c2d4433ed1d191c27aa9fe57e4f33645abc2cf44802fde2b7174299fb68617d6e59a457132c0541297bb0dbb6e916495bdc53e756fb20a4c13d4914b4dc06a46f4042aa7ccd0414a5ea722236ffba142061d9a6e176e8c6cd1425730a390438a951b14cdcb524761d350f52e29c90aa1c13b0ec5d5fa74718591c755a4483dd76670d5f23afcef36689784451063c6ea0b02e46ab5b464acd6038df84edee258b3d8a98c8cf87132cd26c58fc6d89f9e6047f5ed42762da4543068d3bea5adc02a5c2d82206b606af8b7b2ad3ae5c3b9ce1f70c4fc6d9618d78637e8702c1ab745e87eec24e1ae640ca229e9532775ddf4b6919afe570dd17b032a8eba1b2ff63f4ddc1693657c5a40c680d592bb6fc3af439095ed11080642f0223195d746d172ca38a029f6962087cc68916ec8600a66971b9c0d3620f2967110d42d1a2bc37ef8104626947fbe53b6448d10db2b9d076881990576442616903131797aaeef0680cd1c8c44326ca55c5790b55a31e942b762cc9f712f934b23b090d376c47f357c0b12d7d7e411a563e9c346d15899afce22deb8dd92336f7e3c6f97f9b3c7629c70c82df8c21f8e09f01163bee73b9dcf082344296be33ace085a96c9c2b59a13f432e23a37e661fb487e6b4e714bfd927734dc62d28231bbb20e71933bfb45bc11c3554624e3cfbca6fd21c3c13ec81d926663e2ce716a5a687da137db2ba86d2fc77a7074fe4f294fedd19e0bf8017d01fc8b9c9b24fa7fc67a74f7fb01cfd85dc19e0af57a7f217cad25f2ccd3f760e35457f4099256cb953feb3a3c7efd49f435e83d2eca0f6d494ce34e4f60344697c18189895e115094e5e0f356457c80c68305ef9df13ebb1edfffac57c11c07007bc2f8601b0bd031138628d5934b24521cbacc7bc1e6a188417e7dfbfb61a6a0dc8a237870568997bc49a36c0541cc59c9003a2e9a2765a4e2f006bce472d449e13c33bb267708acaaf01c2d7b0c1f8c1b4db8d2d7242727278bf387c5f08cbb96371ce493ec9413aa1477f4e8bf8d711fd529979fc85508b69fc6b9f7e2d5b3f0ff1276cf752f60d7e285eddb3cc22bdce2f236388564a5f219dc8e674237c50378af817f5c2d825fa1327ec658aecd57a0a37aa9a1f228fd0685f22b9394a7aa314a046e7622d0a73d4ff12a3f728fa724c2b9650980e56961c1342951ab1c14e59f1f9479a65482ac8a8eb03afe08e1323c3df7b7dce0e7d968660f38bc3870375f07cd75bcba098a3a641ac09426f705726e6656a7c1be5c490b53afc86c9c9e1a960f9a9067d3747c5a456a3205eece08b0e79bf1c7dad30117e7d6581bccc61ae6bf390425f1ac58e636a17baa1f003ca9feaf978196bafe05e7a19a9a91c0b8c9e29f7fc272a26d18af0c2f641e6f44da0b77edbd7cf5a2c3a51f7ffafadeeb77fdadefa39ddfdf5f1eefff96fb7c77bbbff763b997cfcd7ed7bf7eba7362ea805f12e2a36f872c43084b348e354b2298d9a67cafaeec2b6b34e5dd36823633695d063ec2c74107a6e9d3ce6675065b2b84554ac2a2f24c5d029e0cf220374792861126191e8dc186687a07180ae7d7961a3d4134e3489c8890822b455ec0f608dca5f24e752c24699b7d964214f3a850c1e65ba181dc48e3538de1c39e319a17fb120dba1047bd78e28e1d3b0b18b1c3f4d05cbb60e24ba089dfb1aa1f3453b5a823c5599d5a03819d6301ededd8881c883269bb4ef82f872e5466c28be1615b3f88027bc7f4c97cc1424f95554d2fe4c95b728ca0691bce65eddc246522c3064389316255d3e1c0bb2eb2615fa60614b4ef63949a918eb05071b5900bd2d3ecbc5430b91e1d369870591c857411a5ff418457b09c0f35628934ca255e52ea60087b5e9b01a25e957686442ec4d50bf8d574935455ac1c998b972a301be6912e8c21d972c9909b1bf51636451acacbfa9e5ae4ce2b82c02a184b355946e8be17b8fcaa8e35c74d448dd8bd83c3ed6dbb0bcd5f7fe2547aaa4a967c6281daecb80b91e10413d4b45ab0231089a896979a96a3c009f17b66555ae7c2c19c29a81050f0b8fc93e8e34a52411dd454991df7d2ccaf780b6479720c13192437d80b20f868f5877d236709acc3d1ec4f117b0641795a6795bbf039a8178b0df44ddc2b0ed7351f6e5e99da1ea291162a3b2fc8466b1b040a43f4c8799a349c7d1e9bb5177616b3951fc3412c52b808fe180ea60d630bc925039c5f5e6fd4a3bde6d0a2e1fa64d27333973b136ad2f0e17c680529b9b9b3f9962e08d934fb7068494292983418170a984fa22b741dc7c607186bd522e542e811b47be648f940b6386f48ff6439cb535fd03d010fd4c6436aa95ad0f1329bfd6ad8832a9aa0c4c973baa348b85784d3ab41d34c8632de25a927898eb3ea24330d41385924d1bd6d8e6871790c78e6f7e48fc2420099642da8bc6256e5598b1a9d307d801620452b843538c89447b56848ad04738db5db74f71b2bc0aae1e149d52822ab2e9320ac2fda69ac3dd968d63557ef4f78609ee3cbae97f7676f6e68c25432458b630b24c8291563ada68249ff269c9b86d075dcc69584b54a7834f8fa1cec47908f2f0fba15c3779d138a608592cc441ee4e4267ebb07314f131a459409c6c89c27fae04ee0bc8697b04d8e3ef68693bb2041c469e062e574b6dcafebcfa14a735e56b539c45eaa007fd4f43ff7cd428744d9010b6e78fbb813ce47a863e762b8db057af4c01878151adbabe68d5517c2eb21fe6784366108ee0b3a5c66ad34992d05251728f818b32dcb8fc1c70e82f47571f4490812cdd7317172ce1cf3f2b6f12f727c17eb62dfff1638704b3c4e1ba2b4c195fdda19eb7e169ffec9e79a8ab916e4a158dc64d227441c56caf441b3fcc6441749f5e699a3f2e4793128e384bb0105579022bb19836eb837ccee3209fa65f7181c3fe6ffda3fae287050ad5f173b34ee8836d06bcf2287a3936a62ef178d5d6b6dbe93c7c98fcc0cefacd800923ae7f6b9d4125c5999a1db4028e3ef13e222ecce97f941c62012086f4f10fd6fcfcf15f9d3a097cf982b810adf9a1007d69717f4a54c4a4bc6f15efe2c15f20de13ea93a03db4a571e4d4337dce74adcc36e7043181fcf2113c51a18a10a1cd29fd52a8553c65637ccf0025c8dde1fa949116181dae7d4e48528e5fc7e63789e5934f232d3011c2ea983112ba91459aacdaaec38c437bfa7abac9d6d37c1c62e6055521f1103b5dfe691bb19695068d3b7a145c53920918b47c1a0eb440979f944e8d3a875af1a84ccc9db1760e5c49c76b3b92f908c106bf38254168a24260d2b5cdc5012650ff41b98ec3302f2a380715dc6369a551c8b905af4458773bef96f3cc295585812bd68eb64b78bdb0a19b53f850553f2b806a942b2a8afb7e142650f8ca76a0a157f12f9a48e157f9dfacf2547d4ad156be2a712f5a04f4238dc985af9364de5146f14ae8193235ef8032c4724f6a6646292b70ae3623ed67635785af99b199284be3884565c2238517a8484cd70dac7f7857693bdc82121719a3dd41edcb887a5ad856e56ccbd25b53bb55dc632298451fe85452ebb39b63b63ae46e385e402835255c261ccc56f839ff5864b07fe980cd24721e603a4e55a4a301b908a7424468e0107bda67ec5cc8fde443d95c5d0cd3f105207a73c6f5c840382d369be4a6ca59f08ea122485b105bbf4a1856c49eceded22a6b6673c8a4caf6bf561932b95b55f5a52abc01d50d1c9a789080900c2cd32ab03008949858179194f1edeb1f627f622c5e64a296a25ff07da89777aa5e5191e57ebb938caff33910f69712b396ab6ac2868656a7d92d3c23a159ec39a725511a0193ccf79acdba318ded6b124a4cb2db6cb42095423311426d079ca1fb67cf1e3f452b9e323060fd7eb9f28c4a921a928106de8c8b699a286bd03a5d2f8b26bd8d3bcd69a1d3c7022beccdbe7c6764eb9e4eadf2ad97e9bbecefe6b190ca2cd893836b0036b1248616fabd1678db898096f0e9740d2ee35fd4ecf202d1e33883261edfed3b349d006fd4379aa094957b20096a0122cc5cadcd53017b0744f10acb1f7e090d402511bf57b6ff0cc52d39eaa1a3edd50ebe54bce2a2bb45582907afa47243891456ce50d5b6db7970553dd2c10292a88e625b9fb4c4f28df1e4a6e9bc366784a48589169b244e1803583e0dc8b796ca6ee76911bc445f61a4ecaf952139302bb9935b8dbfbf788ee62f94c94262c601851140116345dd9838586890cc86dee3a04745779b50bb2104a3554b47a5436c411ee6b89bbce1c8d4aaa9cc962838d5e36c9202aedd0554129f6afc832e0ae16f3b361624f90032f0294152f0572b10cac04d810697ef33035eb780e9fd010192733c6d8fa1ef10e907235922005a0baa628684c922f3ae2ac52bb3464296c90fba02e50a25c6337b0009a65ba237111e1c959050fd182cb134971fe88f6f87990eb2be26b362d416882232c9a6e9d78a688dbaed69b830f1e531fa5f163cfd34daa28831a02beca0908817015a2986a46386f15eb3821da39ed9bc086bb1afba5d24493772316d12bc4ab1ef155ca6d38cbc1875430d65a54ae6280408614e833aad6d7605e64a28f974c3393aa7cb5c3020468c8f5bdc70e5aa9235a47faa5379c849c287b19d08bf273a960c2a77685863e697613c5feee6a25e901860942af21b04378083c2233d26fd7e4403293277b08127714eda09cd065706a4b937461bf76004a83e16d0d07dc78c0643076104c3c5a559be1a9169daaba27e94134edec68f77f05062a7f18154d4fbfdd94bd3ae93c915c73181e11ff49b446b4520d8c780b14ca57810731d10c9a2ef2fa5072eee83fcd1bd1eaa11b696d6d925920f09b8eccf50600e6825b990f849d958385970acaff3316987b1bc404ad3f964961caa3692b70ce211ee88413dc2b63c6ce4cd15c5e02a4cacf3aa2c824563f8a0b19645392ccb4fdd1133568e508cf8adca2cf45ac2eb83c214e2adc1e79a8b25f5a73cc4c545f700c85944bceddbfb7656b5895fd81e6780865ed046539653784259ab856d87924fd9b286a21db8b01f9235f31b728fb4b5fd1d24fdbc396fc84b106ec3cd8f02f1b8aad2e5d666777367f3d552a2bc637e28823cd72f157ba784186d6f1d4c3ec729feb7cd2a33365b5abb5a674bb86f3fb5eb2bb81b98b5ae1b7715799ad730c175b0e0c5266bbddef150cd9527e56a74fca776a5dc0d0f108a9914aa5d682a93a1facdcc56d459803547937432752dcd474c379a120eecbbd29b2554ac42ec990bff8bdc45579ef873edb22594550e3c8c04767d7ae9251f3b7805ca9d3343f78e7467011e821ac3ddd6fcffe7b6c0ecef75d58bb0416147e9eeba9dd0acdb09224da378ca7e47411db849da7564329891de242ef8badc7e2894208e2f529a5052f81212391a6e1158e2ae6b06369eb082db8dfd2b34869678e12655a9ffd886e16bc2e65885745db7236e38dc880dd1c312331e86439dc563c155f88ae5a96ad77a05b5bea5a8e76a94534edc84b80aa4b976050fb102ce0ae55c317efddaa5c6b88e6caeb2ae107a6bb8abd8598603e1f5e13b604c9e6fca150569b1dcd707d8d58f02f276dd33bc105870beda21ba10da256e646d43bbaac61bee0f3fa63b2b395389bdd643b7dafa9a18a56bd732815ad820856b416ead1d3b3a75ebae3f65ad2b64b1abae70dad0bf02f8df30e83c1b27ae164474249dae69e4b11dd139bb87d9097278dcb2288167d70b4da9781ce206a16ab18780aba468d6dde2cfb15014f232e2d7ab398594b76a596d4ceee876b555eb9e171db396da0131db5d8d70f3a139dbeaf4ddd20597e235c040d1fe2a88d659333232f59aa6a3303728550dc5c8a49d6357ae292d512de132d312f0b0c1d44f55bba95de617f706a1f727926fa8a72e44fc11cba582565f3489980fc7ac55eb27dae0ede90b6a5081466b1dbb098632aaea754b7e767e9e60b6a022eb0a6204a075db112349df5db4d98d5fded50ac8bea8715b232a60b727624ba1525237a7a435cb4482bb4425626b4ab3467ebbe802ca8ad6bf1a4c61ac2ae5b2b84517b3189af2762dff68adb99ad03070b8bd909f37a4eba15dc3c84fca1dcf30975e370151e915d434348ce3fa62591ef9dac232a6b5074cc9533f6e73ccf26f9b8de926c9b3dbd4d974d25d69e266e5f8a6be7372f5adef1eadde17c716d837eb27866efb2f55a06c306611ad54a24ad15facc380daa5d75d5e51490458dffb11d477b9062b89f794006915c62241ee41d9f0ff8832e334519d2642b3ac1b292ebef19199f458bc6204bf7433804b6240e29094357bb331771398a2b75653262153c1394fd91f2d705381e847d071c3a8ded52ad7ead98001540ac2e3eadf39ae088e26e53a6bfd6422f43a73cc96134e31f5f923fe1e9bc238a22cd83b5f1e100d853f96f2d3d23c1438082fed5a63364a678d1ae8faeabdd6c380c3a49baa826fa4a5f370dc8b551e50207589ccd34afca8107dfd354508945d95a4073157469d8cd16b2bf829d36ee3b768a6ae801c0610a477c2bcec31ab2badeb123a45f67f4a31efa096525a2c778caf912e9a52e408d3254f1cdce6a875233606c9e6e6e6a280bd512367a5f3ad1273001a69b7a003e8ba0ee691f54ee7dbc7093a75112325ed43cb3788f8572369af785843e52d6e685104ad47f357a92e1fd1833432c1ea1dd3bf0cfe5671aae855ab2eb3d0c91939184615010af18afa738133a593291379748c8eb04d658364dbd43eb72456e0a9ccab4c07aab0a2251d8c4b397ce265ccdcc7913b5ab4b1650b5459885139e3ede56c4f7c5102ee76484b5cd3b1922075e49a4411415ce47e47ac2b8ae3507682ac6d5c2ed02f4e492a689fb222686cb3eb5a5c5ff1d99e2320c5b264b62057a6385ded15f23aec855950f2ab6cc98e7211971436f965096b1794eb6c59a8e7b0bba0f3c8bd1bca09c6556ad8b79a79f4eb087f568adbd4a08add94b48a823916e9f78529657d24643574e6ea3e5457493cb2ceb2b4a8834a2f5219d13ab39b40f26c0dddea089548de4b194eb9fa1361cc923ac10c2dea3f892717a917d709c6589120b69316c10bb038737d305455b66f901fdaf11e63d3645cc108f2111bad15d9ed9cc5dba2283da181cfcbb979a5fdae23724cdd0f4b3a5d630c8fa2c26a545d638ffd59c046991eee5040547275d10d6f16747fbdb197dc6e78e4c3bb74bdfe4af2c70f5bb434796402a66d9037172889bdb86a66539587fef8eed54b9c75d86abc655162804ef5debefec16a9372f80f971c0c58ecd92abb85f359617420e8e5f64af1722c21bb06e408205805d131a15c55ed34df4b5a782eb24a72f675932e51339deebf35fdac73f3d7da0b23bc46dd03cefad22083c345e4b0bfccc45a1876ebbbecefc9169130e405583aaa26e1af94cd686f4c8ba5a89ceea57fde97b64094a50bcf59fa2531768347a23d97609e5a2da55e75424105da6665710a9a8c9b91d53139620f36571819661523029038112dd685e0d44610264e798d1aa886f3a02511a4d86609b9262119302eb179ad363df8d206f98f133b8dcbac46250dba129265862ecc4dc6a897e60e6b0aa2188e042745fc4876b6d43fc3cf3fab775dd4e9fb6c28b5f8359e11bbab9894dbddce8be04896aedde132dc5d74c9b1a4c42b2f6fd67871e3b5483737713b4d5614cf02f288592e7dbaf1db6ff0549c1651feefbfcb9e816243590af82ac2d709e539bc1abde8913e2dd98fe0633031cfa30c2c840b456d57ed01bc30480e47dec10b0cd7374b2982d5b5054727ddd850dc2b1e60339a1e7aecb057f88a4cd125371256be0eb086db9f84a261bf62bed3e21d280ca799d12524e239ab330c7a2c7a6ed0d79d8bd04e5029870cd850f6766a1ac090529e3a7dc75b2ad94230d6d5c3f4edd0d19bbc1897374adf6c953095c4a0c1029cb72dc4c26b3903fb3879b78d75e9b631adb8017fb37cf4dfffc7ff94438569856d84db46349fa5b47f2ba8349da1ad7bbded30a4db265a565e2cb8703555dac22934737fbe3782f53f510cedf3bcd753a7def8305bc400f11a61ca15115b405d8fd7e67a9c59aff77ffbedede31fc48ee133336a633613af149c59a8d7598ae0130055a272c0a29a9efef61b5671fef6f113a8e734aa54bc9e22d2f3fbef2de9c547f312110dd30e6ccf0e6cb9725e712fa0d952a116d41456abacaae5376456c08e3bea84df54402e088b446cb7c94657052930e1a2a30b7d0c4327fa5d8c2191ca86a83b98e89e4d60bb899886882efc9ef4035f2a0badf1ba34ce21d965b080dcec9fa05aa4211005abf2d4687fac874c8102cdb837c02970b6260b7419a01643c15288f5d183fc5921ccf348f0edc0ae29afb29939900a3ea368eb6a2f0a8e76d33b116f564c77b21350c23fc5bff00e5ebf9127702342bbc97f56e7c99fa19ad8387b2cbd35187946555db9b1fcf8a8dfc1be605f7d49e5e28b0c68100c07c92e6c82a96050b829f4baec9a8590f7e54dbbbc8d5b9369d01d243b9d2ed3880c2e583f7eec868b40ba6d7ac33d71e846e9283a98a22faaa06d2b25f26b421505854297104f243979c2e9c9d953a7ab65712cec1e908d1f4e1de9c0f0663f71975141f343022e0e9b708d2e4b94900b223abd9d4b364be5606ce6bb99633fd8a99363460b3706f21103b5b02e23da853ca5141808f4e08f8f82268738dc5a8f1f43cb5c04edef2b45b317aae2eeb613558452797e95f7824dd0b9ea1317ed4a4521013d8467182691cf03ecd34fb1610e3dc5dc42f0e57020fb953ac3946523bacb392177ebcc5e763a6525516c802c2e589da72431116e0501262ab26de2e28619de6d9ac3561bb6432e4bbaebe8813b2635193fc1e15d199bf99f0984d18dc667c339f5a1f818769f33cc1eb4769fa7acd7ec39eab26900edd3cdcdba30c365d276e51fde4e75477068c577f1893683e7d30d737da43842e9d8ac64ecc4eed6d97b5918ca34f826e0235e0495f1b0fa536fdbdfa7b55863d0ef5e9169cba41f15e3789af8825e919079b3fe3053f60a9129788994819855514e700fdd336843578fe496f19799a23be670755fb89ca631b5ba87698b13fbca26adc84280817d56bd45d60ee9dd2e8a609023aa841c37a9534e30d07ad092e34cd37ba18b10cf1f69a97eca920decd406dde61b782836763a6c79a86f1c2a7ddde2e387dcaca59a0e70187266551509af27cbb8b36a966c919f429afd8e68850af34e35de1cb4e8b0b2db26a5b3d881eab6c39b30422daa137b4fb127c76bec127ff2a69fa2f92265d9ac3e4f8ba69b3ca65b2815c1344b3e55a04bce3ee85ce04e4e271946aaa2b74ef8f8a7c4787d7cfee4c50befe572cd40a81899d3d4b07d6fd3314cdf0c755da13b2de3441ea71309062fb77db78128ea63cdf10ecc314d2c240becfad5dc5a55ae4599b15983333ba9a4becc741c3120431af4d6f7d9bc91a23444daec1e52077128a6229cea8ec070a93a90b25a1d7c892e0b0af32799e618ef482b77d3a494aaf6c58f36a0ae98a55e908e5b2f219d3e69cafc98769327c4d0656df579364523ba1d8fbe107a1445033af02d99c7b58383ff68730e2b6ad8cd592aaeb10f45e1962d1dd969cd884c4f441d93636da241b684b196e868d39ce4fdc4794d3db6d860c86b63b8107b017db54682630f5d5d66a69e7a34f8c20dc7a01abc8b46df0971c3e44616bb8744b91b03d788bec527ecae90120db76aecb9d09b80029dc5278b6b83ceb23d51edb60c3fd24851ba3cdedad4b02fd173254824e08b5066a36ee85db3ab92b0d725ed0f9d237ae2fd1b1199682996af5e285e97d7f12f5aa96b7232b2e693fb65ca4a54f4305a2d715351162dbd26b710b8cb7c7cab3d33bcc17b30b8cea379341b9c3d2baa9635fde0a418f7ad14340313808f44a23d8aec138b4969692211b50cfa89fba4aa4c042e7b455d7ed38c04f9bee43ecf83e38cd7a6522148c2637730ac3409f8b5c82b5372b0458eb500a4a657ccd8b2a9f56a1002721ebec260bd77343cfaee33f4d879797baf0a1bba25441942a7f5add37bb04a16330c9456325b7d3f0ac93e260a0fa53c0c916cc965b1add6f2b88319fea29c5cdc080fe08276fac5d9130d2aeb6c2d513c706709ec980f440b851205a13371bfd660505087116aa8281f7acd44da4a577b1ca91e197a7ec0c75f1e70500ba5590bb5f5ad36eb067aef5ae9c69d15f0ccd1e844a6d1effbf29aa305f0892575549900981afb84397d23c13dedd711fd2ae54688bfa0a1379ff4c75fb43b6fa6e3365bf4cd741cb345c92546ae2e714af979a48e32bee23783ec973c3f0917f9fbb466b328c4cdbc63eb7d29a0ae4383434c65d745398702ae1fa57da87b781280aa9f321585c59e9f060ed23b97216684b94154650b4ae9438a62f008169191b04abb119f4847fd5666b512138be0b9fb244467dd32eb29b8a57798800dfe3561a2b63b01332492e726639f0ec4b1225c2562521121632b4ae48186fb11373c24498f00842dd037cb770c36c4bc2131e411260ff11859584a8f8ad552b07ec1845894167596ecfa0911903120a220425e417ad98b56366ed5879ea810aa28d567c84d5e5f4521f982114fce6f4f649427d6ae2c64270f12ec3ca69cb6786acc876aad94ae2f0a013533d15c5ea4f68af30e64d05ae34553a81f61b7492dc1f782e9a6b79de0769cb60c2e0fdb4c0913515782bdf2a8a731638448f00444d7b5374d591ace8a9ea17e8a669aec99ca8420c8d94cf0ec64a6672cc61372c824d96f01d3231f3c1c37e7b0ed788f31d59afdf4b09369b5ca13d35064884fd1d73479068377cfdcfa61ddca03e3b423c71e47cc92f94e613af1252dabb4caa142e39e0d332299c9226d8a9ef6238ef8184d7365055809835d959744f9222ead6609a477ac1880ef9b7a9bc3f81eaa7121464f1c1c13b78af8643ca1a268452b5c867d4928702758ea80526bb4b34473a4da815262125271a2585b21ba83df3a0d06bd2adf92bab86e0de49c02f1dc00351fd2f7146a7751b186c07e08311a4ab89af0e8a0c29f8b90becf49c1fc42478eb19ed509e6495b2c806c2e06c0d7e16e1f2bc10dcac71db20f9ce341720ec0b302ddaa7543efa0d2c851aa0b227110e59bee1a86bf13cd7e94ca995c3d3935c989fee827b1e3c6e45f8a613dff2e390f92a87b83e4de897527d83e7d2529bf25064d40eb30290969879c561322bc6bbce01e626bdf26e2c7688b1d0ea75340499e91eca1e6575502c1b09088f82112179aae487a0de455b808fa676ac4c7fa43d998b5f4afb394bcd05049a04fe1c61587cec8766bf77117036ce624ba3c3e1436b0f935aa2dee307bb3d0474e2e472a29a17ecd6d98399d43bd2e761dcd8b7f12358ece2643c42a9aa333486232dd4f93543bba2a514d0ec95921bb55eea70a80d44b5ce0cbfc5ac60ff7a5e97b5016d35dc814b7f3455d9ae516b8e295fca47343997339e6baf48cf1571618e058012b2b182bfbfb3d537f5581f3300634b6cef13fe5b48ad7ab117df2b0a5e381c3320b851f6f7c17918040f8d64436b8637dbfad8c6e88bfe81cf3a78ffbd0dbebaba75db1291323f03ad82dfbf0f01d4a31b34a0c13cf8ee723ee5f7b7be055df7507171b2a847971e4dcaba9de3b715053edd2772666350ecb326b043dc047e49b98dfd19736ca45edfde2fcfbfff8bf134d3717aeb2b294d816e5430140fb9d341f33641a0b1dcd5c6b64e284b273becffd6f6e073ef0208a4d9bb663e989cf1848860f4b80d05bcf05af92d894dbb6d6f9753a5a8663429ff060c0522fc3dc53aa310e032d7c2a5917a100554a1674ab5fbc9de873577c2ec813b6259fd4af7e28b58be39eeea24ab0b818157df47df5d5be285afacfa66a1357111c46a1df0a7233959856493f4007175247724c01afa23dee1074318368d84c32a116583f298acbae3b140dc6e5a7e19a5eeb31ad3c6e176b48bd55c348aaf2b31a5f5ca24b378a56afec6637b7a8a39c0601cd7bf600cbb1630029caebc01a3a0ca5709021bac88120b32ad5470d303a45ec92d0aa097403bb0b684f4bdd4d7e54f952e3020299f7b7afcdd869d89c54b3c37dfa3d55f1e4581bd2b4f0c6c2d0b2718b4d6bd6a6469486d323395e91275e03a3413da8f3fa426a382b3216e7fcb1e5f618902c468ee90263bd26d25aa02d0ba38257104310d5c1c8173d797cffcf6e20e20f5d848df3791e0d2bde522bcc60abc6b6c871dfbb5b6f0f8ade773253d48bff3bd19c46991b10d7c6aa618d5df4682ca25691b6d4e58e7375d4b9eb4840673ba66a110e2a52084d0861e30d81db3bca197ab854f45ca8f61e11ac49777b779b7be024d4f7d9f572dd059cf7ee23dd567a146bcff6a1c6d3abf7553fac07bfe798e9aeb39e657b098496f0fc4b4953ae0ebe146fed141171bcddea47a4101d2eea559d68c8b85d72bc8bca6da2db65e2130f3d60d0ddee8978a4f20c1bdb621a2cc591a01c8a9c689639d6678a410e1587cac8057fd690f8271f658a827290c60c256162679a9aed2d2b44e9fe8182f470d7195c6444e4b173d6ae9b0f198df77c4c52729354bf5d0ce11d134a1075a81c51568c8679b798ceba457ed5bd2cafefc309aab25fef9387b7ee647499ff69341b3f3ccb001f86e3f52fe3e1c33955f72f63c0b51f3e1ea2d79451f32fb81d2fe044d70f4d3ff1af4396f10ab9f6bdfff8eb50bdd9ec73f05b4b47535d497f2e3f7183fd75385bba8032c7a6726deac87f1de2274ea260024f8268133703e7bb3a4edc7d122ad1874207b1c8479f86a9794d0400277bd5bacfbdf856eb3a3393661dc459b05f3684df809454c754c5d039575f80330a55448b7de1392a07e2958f2ff0551d310a61c4bb9830d7380818143e1b5db42cfd4e349e606441976cd5d93cadb04e7a31363ecb793d6ad5719116ea16ed71a1ae61ce461a5815ddc000c27e6f9fe44bdf21532ab838aabf435f82b0e1d1934cb57464fb774882cf50491255ff0956498ab391e9aaa28b3f7214360dfc2eb59ce6a43e451962caffdec0966b44911d2b9e6f947c502dc8f1d31a48df9c3435981724670d4b2ea8107287b049e75f654d48ec132ac251c814c37d69311cda0420cddc54b9537865365eeb460d6eecf22478255c8ecd465011229a823578cfca34194c3fc0e0bc75c384612b3a61e843306ec9662d47afb70f8654d3f051b2c54c424ce8510246342cb68dd97936623f947e8ba33c5368e32752ed5b024a3c141d9256697384294ccdf5b5280f3252648ecf092d34761577312a069b8403163c5d13d87ddf171896166c180d32ca107a39c0c82e922a79e3ec46b1d4a32a671236196f163c41ac0153af7696ce96968fcfda6aad387bae17e61234c01f13163cb6e7ffa0159e2378e457b08b69cabe0ddb3ec8424083c80853de5be80febd82614d5a8adff8c086a036f286f2732d94d6bb52f70ad9bbe7aefb0d57cb4da0191c4238fcf602e31d1587cc5cee68469e55ce521365595e83ad1d5ece25cec086b5fdcc507875a6a4957200e36254f6a59ec8a0cca94daaf1cb1bd09919d841964b7f369ca913c4f5dac4a1d744420f4d73a87bf3b328a983b862174ea3258986a50bfe1d4f826c15d58cdb1cd498a94283d6b029f45b35beca2e921066335ce0d19ffd06f8b26acb11db1232845af56298433ef3ec3f6f12affeca8056a2cf19e7b6757ea3a6c955a35c53a6e41986621c55c262fb84988b025401629fe6cd5f94758c2691a4c19d70fc26eb5038a432a06c262b21ef90b91a3412cf5d2596474ed283396b0e693279419e2d9582f7abc64b742b2be85db615d380b761f1bb8f7f7a344ec1153c1ea6ce020e4d3bbb618b6eb0a28137591258d2da7ffbd9093ccb25003122b64f82b2fc9812626922ada35348e480b872f11121fdfa812713fa4ad2b711897683f3e73114c9fb264da8e5de56b5ca7e3a39d46bf83612cfbfd90ecb40ed78d47e79ab61ea254e8f0670e6f0c5e74cb303236e1a54c449460ad1c86841c5d532f3f908430f9e45bca845f87f47e88ff28f7daf423d09ec2a29cce0387d5560b88f955463852d853661b51afe0df87213f470bfc556aa30d325be3da815b018c131aa83cdafe23de747351e0390d9b8da9243b2b3cdd9218f0343b6be80f5ebc400cf49be6bca7b4db19b91d2d82960d274482e853ab8fd5bfade86ef8e669e76f0db1dd3ff46d32fb9cd4c7112b77dbe55a1c918d77bd78103151f5cb26fbd7d8a9be0c9e81ddc0c0e36a512d789c5f27234035eb871bb39b5d79b050c597b5b7eb0d31f9a643b3eab63c3a33c4d1430b8c5142dad4d76810c31a9dc2de516fb22228702663fa08bc2c2fef73a73f63930f83f1d8b3dfe13fde9dc4682c2f3f763b0feec3001ee94bb23262d38cdaff2f19ebe37ac591a95df7644db42c233777df759affa2d9e17316664755e0f0706f998194df41bc57a90439b393fd4c81cf9584e4dbea9a2bddc5d4f6e66407d3c8bef42cdc839562c1c48a6e35f405339f4f97621453851b82de528e1881f2248c498c7f9de6d2c94ae5817b291d0aeefc3567b590ce1076d64651a2a1b14ed7fd176fddd44ad91037be4fd2f1e0bd261a85bbadac6469f1cfd195a4ccd769b8821da0bd17189e519c6c8486f08ff01f266464460fdd4a3ddeb404152ece57a2139493449ec9d3d591ba881d87b65ce56a8c8370876b4953dcc2b13e95e7c6b45725365fb36a24c03c67b6e7d9e90c171a728fb056d1bf0e12e5bc6087b3b9a0c8e1c40296cf4185e9a4d67644093d73ad3bfc5a7cd79233287621aefade6226da518f8fe4de8094895409808f7f4a81a301899ea4a3e02684ae0b7303ee7608ba3127430b53eea70ba414bbea3a608e18804016d17d53ecc2b49ae62da9e48982e433758d2f412c19b9c02c7d840f294fe31b587660f8f65c7b4c77a0b68989b69f78870df7eff53fa3e25fb2f5f3cfef5513e21412dfc1df8f1fb755763b36926ceabc7a72c5580eb6e367dbcfdc271f9b93b7a8dcdc2ebd1fd2d3ba3451afc1a6e46b8449387ee10330b2d914a31aecaf2984cc32e564259f937bfb6ecf13246f0dbd4e78cbdfb71d132b6ef3a4027d67764d726cb94df2166e390711b05d673d6146a2769e3fcd768a4880542b9519050fa29a422031737c849627e4ae45f449ec48785a06a77f3212e20ed9778ecb9d67cd84b48eaac908ff0ff85573ab3ce73324589539c31fe18ea44f2785d98f1cb3a3061fba310cb416a94d10091cce49399de2c6b2592bf180e34e8b59300276611a7eedb20e88a387f81aa94297dc0fc9ba81a0becad547d5dd182e0f3f15913c4766d8d8e259f84f1267a76d6f67e439dcf3d131616ca4c240a52bf3b59a221c09cf1abbb6d0d35a73eb9ba813df52f283a60884b5bccfdf3a7df81b57886a304281aa20e59c1f2c1d655ee7a3b45a022e55d41c0dc2f323a1d8cf24dea19bdb80c81149e0b07f54f4b0555558275443ff596d059249860c2dce659db31e86e9abaae547457a5a35a106611968a29fc5480bf54035c89f968e54e662fd39fb0ab680fac43b0538b5ad4b9cc5e026865fdf341570868ed43df7db1a826259e8051166732b79d7799afc50969718015c236da40586c0f0a129f90966f347ba0ea366f495140c979cd64f4835b5d55bc474831a46183124072cada7e94420eba65e37394c41fb79b1b22454d3c69f43a11047492f1c0664e3ca3aee67e2538f5aa0481b7f615d192a186eef71fb6d29b038050f26a97e4677280450902b9f2bd4e7f3b5f0aa2942c327ccc25e32d45bfa9ffa2631f257a04f1279722718228d759f06470ac01af270482d82129bcbced32a17316ea8ad449da835b51d87da8a8480be501d034f1427c1a0ade72cde47cc0ba8e8266706ac04bd32c907625cdf89b19ff37b48eeced40daa9ed8f36c96cfef50ed40e98d18155350873fa8d3d1d6508a143964fecfb379fc8bb0f079635669ed6fba6b694e2d92784f532c94789f8088cea768591773a7dc876ae5e68f80f5bf3f640e01200f6b75ed424f8c39ce2cbeb3351df09aeb26c6b5e109c1710886b340fd7042a1d587146a6dee10104a54287ae9827167fda6a79362273b1633efa5d5a198d3b5c160f0bf773cd67ca7b3b9f9bde81a04ea80dc81a43709b9411365d99dc47bdacf6ba51028a62f24431d7cac717a00a5fd737a9d9e8faa7cdea0866b8aca229b9b9d8e8ec2c558813e6618c787dc42b16575837af98d29c9fce74c3b5f77342b3edcdac9be1ae8c21d34ab25faf09d61b0756291cb81836105313b3423146a4c39e6ddda79d275b9ca7f492984bb6db62b18e806615034962a23865984dc629024e2d488679896631bda57cd05e388171655d305aee42cb3178971e43a6bfeb9909ad21ea9805786ea4ab2c757c3bbd284b0951311ddf54e183ee42496454bd6c08d0357d7d852850721c9064d77de15dc94c486c4ad4857342a93710f4e3776158165b8c0c43c8ca259b181068128e3520d5354ab1b48377115c56f566d42665fb51a7f223bfd6d087687b37aaf47cb305954544d5b618a2e89564d914b0ec4fda8b36eb031a28cc87ee4ef8c5202275bb4195a3f7976ca9b611e0209ed1fa1dacf4d413371054b8a084339e59dadafdcd6bddeedbdfe0e6a52fce5fb6d7de5a0265336969adb3ae8e72d41366ad18a24db7cfe210c1c1687a71c0e2c555cc7b685ff021c742be828ff1fa62e609a4e71e5c58218ec0747edfab1e0e08fd72ca347829fd6eba4a53c42def410896e28c66538c25828274ac31e38649fe5d7761fbb05bd698151132e4d46d1946a4c50cb3a63064e3a2b209124b7f32d9c7575f8d8f9f6db44e34e7cd61f983837f39fcffc1313a368109417a52048d516957e8e5208245259fa1c3e31136d34a833f803135c9c050277df36c04b333f3f1142b1ce2f0bd6c8607fdc18a2ad496786a940f6622edc4e3cceec9c8dee7e4815333e3c5ed01a5a9b88bf4db95b4e380383cd19b11793289083d6c5a3a0e1a5f026d23b8a7cd96c32c2bf9950b054d1cf11da45c5ec5d8995c6c105eb6483fc8232ec8e1461043c46bb91a78f1e4936ea6631dce808bc992aed04250571a563ba0963f295f38f453a254f0575e42aa2ee769edd2ad14acea47782ca2c0da88f03722e7a30ddea0ef84127ae3541fc65f3de3116e6e313487dbe2629a01bcf5dc84a65ea002dc2e2036d9b0da7799098b16f19c43ee9b07a91c9b8d11d1cbc918b39ce764acc7fe6cc60d9032c0b2d5656dc8478a1814304a2462913c14439632530fa2c0e8c4e21c3ff5c0e2f80ae0354ef977298d0af8f09c706c4270b5b38da54d2b02f3bcbd94fc0aeb59b233e2b27a4d6999a0223dd43f1f15224dc6834e4dcc6556052e4f4b26dfe7acc302685d85b75fc5709bbf22480ae3f4898b3556f0b383e119fd850c0fda491c26f771f9e9062307d6e0b7f0a30ec617823df9c7d7f9e3c7d7dfefd4b6af648f22f5879e142ac082e9c866f6f7f55c337b740a0694b9fd704618e8958630b5d54e7a5e63f72fbc6bb206f8deb3c4d5187b16ce8cdf1c17f5267ec25263a154f9fd9ca1d18f51a2593f66a3abb184ed3e293d09de8ccea31797857c188707ca07353f5bf7eafb793f842acb70a3531e35e520ffac6f567d58f88b56e1e2e9999e4ea363c0d6a041ce342255fca0633ebd1a406886404685b214cc1132e152c43cc039caa6138db05d240aa39ac520378f02591cdece107ea9da0b7bbca14ac8edb5507fed0bed3f02055a9b4105908e932e1b5647ae42255090d88f3750e4cc6d76b7010e65c241714fdb6a248a9b932b256c61b1c33f639cb5bc9708346acb3bc0419dc58689a0e59dc7a282a4ca7a10505c49530b803b66a3cb57d1e3b7da2fb4d7433deaea67d59879a5af53a1f472d20e6bbc13ef59ab5e7ff983211ac0bb675fed797c268e38c6d430ee2577e35057b858a2a636ff3b6af896d4bb873789d31b22be06ed3b176f89d265067f101d728c22663385f0c575d72af261efac4a5dd2efbfb1e0d018cb5f625cda19e960be874ab2ebea0bd47dfa8aee5fa9ab8a25fd4e0eed03eefe3c24d9d86aaa4fb9d41516aea7671f59ae774578e7c7a123228dde2a0c65f54970b4c1a3e7093a014df0c6b0691dfb3e5aa1bb71179d09b225dd911a7587c349df5d4065bfc01ec5c34f0d90e47fda3ec69abde6bea396becb3380bdbc3781cd2c777c8e1c1a6e49c996331dc55e9a5cd2d7c3e5fe7c502f785f89dc7c643e4474dc15cf630c9efc381bac7f4e19ae8e262e593e0d070ba644fbba4c36956e5119b828ba8c50c2a77b5829eb4c35798058d052c9959b01274cb29980976dadb03c9b05af6408300481da1f99065261e0946f660bc3718c5a762b5ee62e71c867a605c56d5c1c9d7ab529e1a940bfaf3aeea7ea83a28259c6e3cf8667737b846386d1c48b2bb6bcaaf2a31aaf191a0dde45c4ed5ccfcf0da9e7641bf838a86e56d9dffaa7be9199bcb7900ef34ed48dce9ac3860135e4c5e8b628fbe1474aa51275a624ddeebfd49efcd77578bd9b040e70133f19c8bed1753f417a7388ac15c6455255edc616ccff0431c0c13b92250a70113a5923ab0a8aa045355b809a9551d849bfe93fa0848fdafb05f8336cd09272698da862a2713518184aaded0c7fffaff6c7d05c82cf18f78db045bc42b40346ae55ba21f702474c9ee1bef15b69d0f1cf664ebfdbb27db61fbac717e276ed0569ddfe16a3177e1582ca38a205f7a575e92cd332bfb13383a4c4b2b1151272f24904b1dec01f479c5b2a49f548c87538a8e40e54f7863a98ff64223ee70fc84adc08836833fad4882c15a2dec695b52cdaa1f25843fe3c7c7e0a59ededbb896b220dea6f5ebe8e8ce1ae13a67d57502861456abc0be2ba88879567a3f08eddee4638e018fa4d033752d8a9c67922786ec3d2943be30661aceddacafc4ef07ba0ec73b8914f283d986854f5ead8afd78205141971e2ba5a0830cb40f895d3fe745e48983c2281a19176ac4474eefa15a6fd2d0bf1be471cf243676b803115360ad1aaa71dfd7685ac9610c07be4ae191262d857caa40f05f6557e2ddf01e1db22b5e4ce113602d9dc1bf6d538161753adde65169ce6a97ef73f9495a8c96353b51c3353a4b6f02a30ab685ba55316316da9adb7e8d601d298a50e3e2b7efb3b9ef6cded874125b9f9c57308915456df75b2e32ef19ec8bbea0df292b26087a4f73f14b5807d8f41c058bdf8003920da33f52898dc564d98334015c76f27063433559512bf911f928c677e6c1fdf451b2954e6926d1a9fb6912f256ca923e1afa4679f4272cb86da262ec16465ac9274b5dbb3ff36782a68797553abf8a76040dd6ad16bea274752165c073c0f3d15a5469ab28c9a9952ed253564990fd979254dbef21bebb852ab1e3f718565cb2129fa7a584b5412e256a535cf45ce08448b34a8272f9f159d9861d4af48f5b252560b3fa31f6db4d9db2794309569d174309895927f22e7bf1b12cb2a07f59a03766b95e51e745eece0dccc0f885892a3ab2ce67b88a07a1129e975a5d4352556a5dd944cf61e43db2f6ab5407eef8e19e96a5ae481459d2bfa4a04efce2104e1efc5f0f6c59a2f786ab2da7c25f1f68d51c1c8433eebcee297898a1e187e8f84212781e4efd0e8011b5c40578ecf1ee993a9141d456b2f56c250a57df6a83c3c76e837859ae50a4396e1bffac745d7a4313add11a6abd3b301e37cfde0b8bb554e2d5be62e36275f873d78f6b90395c294fdb0b6696776afc35e8f16793cf7759172353a55e8db14e854878c94c5f469658a56c983537e4400ee9921ba710bc3e407bf233dc56bbd71fc3cc72cbfab6eceb4963d33d9d54f6553836cd5e44efa42e56f8ea1d85baec65d76d4f57134ba56b8a8ca75735d7907f0cfb936b705be670cf3c1389af68ee92c9e44d6340ee843a45d3a06fb8eaf9c7b07c5c75e58cbd94edece6a116cd3992729a959f4e03d5c91e5e19879442a67dd4371da558318b0a4e3e86a3c405cdc40a9fd6af8486e73a6e3e2a7a8e1670a626794846d8fbf70e92d3e4e77bfd447cd9d2c81450f6dbe189d866e46334ccb868349f0c32ec234470102dafe03fce1b3a1cb90698282a0d1946bcdf6a67218523a7d5f229509d0a9add8ee0fae6dd73b43ab0d3e441410e9c49e8293f6d66b512d5bb5a99aa0397c01618ba9cc916baf36575e18f2a277e572db3db34385782ef84121263b1e21c2c3225a856bede3b3bfd63a115cd2a3dd8ea7fc7662a21a71f4ccff1a235fbf6a396d5b9c6ffaec586ddc4ccade8f396cb26e95639f23347f2d01ee22cc0ef6da19fdee7639907d2d278f1545d41be2f88b39b9beb664948ccd465e0808ced24b867138756a548284c3953644c79613b1c214f1c794d97c64c76120471f467aec8f1f194667507c0122c3845d750019c65070e41a050e8ddd307fd7da18cc55f57022fefb7b2db71978f5bf981f57bd22e6959c7fca4aafe7a4f378c9a09863af60364509fc6f3a8a9e694210cdb83f756e0c9f1ad62620edee93db3ae3e2f95ef52987a4e95f0c5c706fd8d4718a89cf7177584a60f3573982377516e3ac691de7ebf173b61d70d340e7b4f8a857815e8affb673568709e6cfda5a4d5a843a15553307126944a682276af4418889a83d5a226452e009d534737a5ce56a27f04b3223118f514a86ed50e21f42d5b9d6166bdd4e758e3d9a20be3d4e26385b8de640e43da52411f8cc387254194acdddfd15827d444a7d57acb46a8ca31b0911809251654563c90b58d2118ef43b589c8aa3e728450656c88c3ca46fd95392b4ab223e203aafe6c643385e1e9e34236ff55706066267b79dd21445d47228426df483b3e1ab6da09ca1884ff7d5542636c8793b977bb235888b6c31d80e76291b266b5545387f31326d83c2c5ae82ebc01bd7d630809a5b3a2a70ff1f8bfa96bae6acd11addb27d0b3617b837e5b4cc8386dd055d0ba90094e219e49f551664f8c32c9f1b5842bb693c4332000a2a986387e399615274126492083f767eda437a60ac63cceccc65b12f9dbeccbb7857467ec9b23326637a500bdf2163eb60fad9a813c4d7da06e9eaaa4951ce00b9406cb5bfb5a7fa33ce2bd4571563237a460989c45764afa900fd1bd793794ca01b5cd6f591e092b37bfb567195f30b97db90ff42aab3a4eb81d3159fc3d126682c17c10ab7e81a705570585b964ddc335444a3df6526116c791bbab31072617adbaf5e9b57ca8a83d6c7821a3625e62b0de9107f7d4091bb406d34cec1f69a23af1b35a24bc7bb87fd5a714ec2e8cefcec7be913067a28f147c55e691a1cf8e86dac474c3e059a1a7c3da9914934c0560d89b16b61614a88297355c2c350361d1f98d062d27bf25f41e8ccbae6d8679700c8a81d2fc37effaf9aac3c741e4f0d1ca389e90158b1e717c5e1721277ec7fbae94faba408597f7ae7ae70befc88147def0fca85af22f1a0f0a815a58d891a6b7d0b3fede6a018fa7c6b7a18984f95ae420cd40905d91cd29fa5c6713577987506ea325488c401241baf9676e7b62eb2e589da5b980c687319c5dd86894f760fe483647610642dc8f9b6cc85a8874e13a5d0aaa85deb50e8669244723efcf5ef2d38d82400037735cd1cd21e1f838abe7889a0f330c4680cefb4714c512bad67d707ffe48899de2c69145ee8bf1558e19e230e103979aac4b8e969f9513e689e7ab613373347152c1d5967c1ae34abee179179788780d2c3851f09fd9529474e07d501bc9f74118dfd32f33cbeb1bc005cf22ac34aa5e8d2fd447940a4c454ddba02852b186804372871e7a0d29960de3789fdc865ee8abfde0f161120a6617f378fb8acab8642512839222b489da3c89018a9a3095151b54734da4aae641a37f5f9b8decde6c52eac847195d1a11b45de6271ce3485a6073228b7fe02dc5bbf168b3713822fb21d11d1c076aeae2bd230d17d9bea06c664d024ba791c71dd2f634cdc73b10a870906dddd4c9c09e45a9d4948103f1baf1b2a714eca8056626b9c76b1da3b61d224ddcd476e3150222c1e9f2a09118323f64284c43a8c69a3210b1b68f71efbfeaa0fda8056972e1bd7fca433bb2021661e7d7ad4dc8760672036880561abc68dad56c4284ea486c0a448117e9c2148c14d7b8c884cf20be03e0456f541f0d6f5489dfd88d17cbd6e4e0e02eee86effa0e265c8bc280d87e3a1e876d4fde4e18d95888bc30452f300bd7fcb32efc22daff1f3fee840345667b469856225c0d2e1ae3aa91cee5a29fc38e25ffbfef4ad5e2a622fc9050243fa654f18513b53da915e700d5a2955d27211d0f7ffffd94629dfe32879a8d8307803b5f829e17979fe1c125222a2e0613b9a6e06e5f4bc2505b058812ccd96c88ba2c8a9a7ae975e33be13aaf16b51e13bb586d6ba509017c933c654ad15427ed9838fbc6b069139fca1c3638758a36e8a580118d7b9d0e9a15b1accc42d95078a7bd0dc2f94482a7da4511b6022fdbd2482b515e54532c51e4400761775962c943a9b6557d09ea30aaeb5f6aa817a83dafc4ece22fbfcbe721e061a20763d3cbf136919a6cd8c339da1a8428e24fcecfeffff93ce6e98743cfedbb768f5991cb647c8de2c5b8e139ee2b035bb00f12dd432b3b68c6a7619c5be10b4405abc75ccb2a288e1d4a27386271c176a7aaecc5de2bdd734ad1165293da3421a42ed240588f044ca5390d7aead80a74e1036f13b1860d013b6bd8b512a4331ef708eed472967447351fffee2fb5a0ad7246316ccc88ec19b12d2056ba975d720670fabc2cefcfcaa21c96e5272e0fe4f57c5e8a130a8379e560c2cb0cb9bff855219beb2f2f4b4316c597f7d72e4f90e4fd815592f08251dce4971c6deabe29a93b0df53d8387c3218824c2cb979e14d4cf803937bd2c8c96882a1b25a970c2438bbec432c11154df4af786eb177efa6cef598df8360b1f1b517b17ac14f5dce9f99ca5056afa29d5b6efe1492bc77c3ee8bb4f9a39d44a700541686c28c719c67ed217fcb1f1a318e0d4efdda8a806b6ec1dec99d539e79882b831d1c4a035f2f3858cd5f198365bb7f3be3061a6d4e1b986a26913fc288c456e0a3b9c7df911f7eec9bbb397c9bf262fb349933c5195a8fe604ddf6791ddf7ab4c24f4eb060b9bc691ccf82a3c116f3adc3257555fe5737515491afe7dbf905655f969318f3c84bda2a55d59aa78893197d6d9ac1a48cd0bdf85109df5d46d40b3fcd29dbdc6e2cbe08c103e5e6bf0d5b6b6df214d06941877cc866a0bd6926c97fe1bfcbbcd9847c4ca44cfda59726fb06df7fadfd20ac36063cf776b8d03c93f707471f66e46aa00070821bfd7014d1dd0f40ea05f5c4dbfdc55d32faea65fa6ebbafceb9574997fb4ebf8f56a775408c4a8b803e24aa35e5e7dba03a2bed489b9bc03a2b9118846ed29ff1630fdf80bf7827c7a556ce4064b32ee5d58dc607be2e148f7352e6ec1978feeae220f8adfe23fc86b28c48217a9e3a3cabdff468192e4121f1cad8d8fc1e24392e3b119a5e17358dae9eeaa744df5750f2208ef80f50e219c68f4e3eb5528935119f144e76fddebe33fb2c9a5febafdbb2765389286ef6ce292061e68c2ef11dcdfec33c777a7f10ae307daf958191e0a7e20739d557619a7b7a5993dcd88462fb0967680496a7ae47e332c69cf34aa72d9dbdbc75066e4719bf497840dc416528ba28934ccebceb76e5b7c50a6ea7dbc033f135289b88e3a3fa4e08c81f5fad1e8d60fdc08203ea29bd3470c1be3e76cb27fb8e9fc2a1d66248d32ba1a51928e76af65f9f9c4d825c3527cf2f070c28357ca23b7ced72d7bb4230d61428fabc84faf22c81d311d18960da27642ea032d8bdb7d8be93b529df49d634a8f372d3bd343fc67364f8b65acbb8f5da0581d48f1a7dbca7bfa10a940f529fc44ac16357040e974ca119783bbe85676bf957de4b295982210759d1526c9682ddd2cdd685311777d6172882d17155659ca87023acb9aab72bc6b51c74fd0a363c60281880fc94ece998f12c4e8c771359cbf52912f46f5ac7238756e8a9211193acc189f19a5f0b2e5ac187b37460d1a91370a854d1af22c4b53132b27fe90fabf1e42cf031a83e6e49f0ea147dee297eb7c39eb66c25b5e178912566d583eac307dd7c36295d9b830459bf63715cba6680aad4a7f76e73c7c9848d60e6ca86f92870f29bc5188c4d596927793a764550e4b7999352e8e2f8d35d2f45a091f886302b28774802c08fd01278a9ab125e35a5cc102d381198d82ea02299b91ac1c0512fc6cc6348d088e6086e889358b2ef23cbe76e960d124263203e2fd309f57e51c9089260a6366067451e7944edd17561e62787875afe9626c1bec2bc2fd6cee05d85cf96bfdd6ed1604715d3b9a51b5de24f425b9c8f1588769baf8ee2005ff1fec0e16bdab3b54ed97bb536541d6f0012d26ae3244f4e51d250f26b69d6081e7884c79a3307ae335745d7476a6a8068cc482052fc50bd6c2ac46e6101864a10801401097b1f2a82eb108929663aae42dbfdca42c1a7405d4b7280b57702f06e90a873b9db10e816a600089302ca76321e50fa955f17a2c0afe8a70730616f40145d82b8b8b8f43f364a0d08a5e8a2e6a48d7da52d5ba83e3b5a163e2803a6b74e9c8a6498d433f4c892f417dd7f86d2eb0b2e3aaafb929a93bea09c53bbfd9d38c3bddb6b06195a80d8a0b7b5a4064c05ddc4cfe8af6c01768503063261605aa573910a5a3de0409b9057a6b5b943e9f2f8a9186dd902402384ddcb6c476bcd63d9ad4fb062464b7f0cb8c41d6f21575dcaa091d702db5bab7ad4ac4c63c2d3e7da13a38c4b8358bec46c2ab1ba66bc71ba60f3175def4837545280613e38bae1cb22a1522214a47c80a7c4eccbd106a3a04956dddc90452a2039b10db57101f4e96670d532c44f2b1d90c7dab3b1af361062e17e1657c299fa7ae37da488b3da5b9c21981c2afe1a7310fb401bfaec7611ddc441a084dbede3ee2ba3f8a5a2155c6518d49eb40421a7feb3a669c08991aef9d1213ae99f655d256bf7effff01, '2007-02-02 03:51:23');
INSERT INTO `wiki_objectcache` VALUES (0x64656d6f5f6a6f6d353a6d657373616765732d737461747573, 0x2bb632b752cac94f4cc9cc4b57b20600, '2007-02-01 03:52:22');
INSERT INTO `wiki_objectcache` VALUES (0x64656d6f5f6a6f6d353a7063616368653a6964686173683a312d302131213021302121656e2132, 0xa5556d4fdb3010fede5fe15adafaa97969698b9c34d384189b0462d3d8f6619a2a37b9241e8e13c50e0521fefbcea62dd0691a50f5fdeefcdcf3f85e7acec211a30d6f35b475679ace506bb9d56cc2687501d786461a2d87078cc64d122f45816fc9196482ff109782945c93258022ba4b53d03aefa4bc214269c3a584cc8bfd65822f3cd68b7d046892a35ae94e1a624a203127650bf99c96c634ccf72b30dc5b216e631378755bf8f697bfcdb7f88644df8c667a71d2890c284925d77a3e40a2d02a2e89c16f03628491b0076a0b724e559dd752d62b9a58f74013e78c7d9e90bc6e5123be57dc885a117c765aa8c289b2d844d7b959f1163c27bb1767e26acd956256a321b50729d1e6c632cd65cd0d6b45519aa8e26d21d450426ed8a4b98e68f2737b4fa805393bf6426570ed3565f3ee5eed19176af19917f096574dc41dfedce672bfd709e721dd5cce31bac8daccc80918630560dd5a03194dec49abf557ec23f70419285ee1b175e0621b6883e27294ec4290d8476b2fee64124b91fc55ebd56ae56dd53c14e523c886618fe4a2e85a77bb0b7d0fac9f57edd7e0eed4fb4918d9841129b4bb122c290a7ab1a80fefbfecafc081ecd07d9846f4fe8760c585dc99056baab8f2ad3cdbd40f3d36e44ad59d4a9f3b67afc4fea71c7400d7402c8aedac9d02f8d85abd5edc1f0ec9577e851d2714b95f6524e5a99b4453924bb8211954f5e2775d4d58e33c4c64b8b84a160e837ed80ff0d107d51f11ae32d45401b670d5905110cc82511006e349383a20c361d273db10776175ca55d1e1b09d0a75a969c459c06eefd017a2ef881b28ea56c063c7cc3a6a65704af5b9ccce7821521a2d59601103770a895d60f24d8ea7e9adf510c3be43abede688dc8a0ebda917d00dc4852dc76669a3c17e4c2dd91d922e16aa4622d147764bf15385a21ec75ab1c7ebaa6f710edc3fc498bd6cc30e36fb35122cb4fc676c8fa15d838c0f9f0562e7667d621ab23d3bd6016d2f72d32f4fea168e43fc9c0658b7bb3f, '2007-02-02 03:51:24');

-- --------------------------------------------------------

-- 
-- Table structure for table `wiki_oldimage`
-- 

CREATE TABLE `wiki_oldimage` (
  `oi_name` varchar(255) character set latin1 collate latin1_bin NOT NULL default '',
  `oi_archive_name` varchar(255) character set latin1 collate latin1_bin NOT NULL default '',
  `oi_size` int(8) unsigned NOT NULL default '0',
  `oi_width` int(5) NOT NULL default '0',
  `oi_height` int(5) NOT NULL default '0',
  `oi_bits` int(3) NOT NULL default '0',
  `oi_description` tinyblob NOT NULL,
  `oi_user` int(5) unsigned NOT NULL default '0',
  `oi_user_text` varchar(255) character set latin1 collate latin1_bin NOT NULL default '',
  `oi_timestamp` varchar(14) character set latin1 collate latin1_bin NOT NULL default '',
  KEY `oi_name` (`oi_name`(10))
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `wiki_oldimage`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `wiki_page`
-- 

CREATE TABLE `wiki_page` (
  `page_id` int(8) unsigned NOT NULL auto_increment,
  `page_namespace` int(11) NOT NULL default '0',
  `page_title` varchar(255) character set latin1 collate latin1_bin NOT NULL default '',
  `page_restrictions` tinyblob NOT NULL,
  `page_counter` bigint(20) unsigned NOT NULL default '0',
  `page_is_redirect` tinyint(1) unsigned NOT NULL default '0',
  `page_is_new` tinyint(1) unsigned NOT NULL default '0',
  `page_random` double unsigned NOT NULL default '0',
  `page_touched` varchar(14) character set latin1 collate latin1_bin NOT NULL default '',
  `page_latest` int(8) unsigned NOT NULL default '0',
  `page_len` int(8) unsigned NOT NULL default '0',
  PRIMARY KEY  (`page_id`),
  UNIQUE KEY `name_title` (`page_namespace`,`page_title`),
  KEY `page_random` (`page_random`),
  KEY `page_len` (`page_len`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1367 ;

-- 
-- Dumping data for table `wiki_page`
-- 

INSERT INTO `wiki_page` VALUES (1, 0, 0x4d61696e5f50616765, '', 4, 0, 0, 0.976523329487, 0x3230303730313331323030363034, 1, 455);
INSERT INTO `wiki_page` VALUES (2, 8, 0x316d6f766564746f32, 0x7379736f70, 0, 0, 0, 0.719991790582, 0x3230303730313331323030363035, 2, 22);
INSERT INTO `wiki_page` VALUES (3, 8, 0x316d6f766564746f325f7265646972, 0x7379736f70, 0, 0, 0, 0.086272164275, 0x3230303730313331323030363035, 3, 36);
INSERT INTO `wiki_page` VALUES (4, 8, 0x4d6f6e6f626f6f6b2e637373, 0x7379736f70, 0, 0, 0, 0.106191495436, 0x3230303730313331323030363035, 4, 71);
INSERT INTO `wiki_page` VALUES (5, 8, 0x4d6f6e6f626f6f6b2e6a73, 0x7379736f70, 0, 0, 0, 0.780779263905, 0x3230303730313331323030363035, 5, 3353);
INSERT INTO `wiki_page` VALUES (6, 8, 0x41626f7574, 0x7379736f70, 0, 0, 0, 0.782356086477, 0x3230303730313331323030363035, 6, 5);
INSERT INTO `wiki_page` VALUES (7, 8, 0x41626f757470616765, 0x7379736f70, 0, 0, 0, 0.001600082455, 0x3230303730313331323030363035, 7, 13);
INSERT INTO `wiki_page` VALUES (8, 8, 0x41626f757473697465, 0x7379736f70, 0, 0, 0, 0.685671249972, 0x3230303730313331323030363035, 8, 18);
INSERT INTO `wiki_page` VALUES (9, 8, 0x4163636573736b65792d636f6d7061726573656c656374656476657273696f6e73, 0x7379736f70, 0, 0, 0, 0.559230977107, 0x3230303730313331323030363035, 9, 1);
INSERT INTO `wiki_page` VALUES (10, 8, 0x4163636573736b65792d64696666, 0x7379736f70, 0, 0, 0, 0.671494695607, 0x3230303730313331323030363035, 10, 1);
INSERT INTO `wiki_page` VALUES (11, 8, 0x4163636573736b65792d6d696e6f7265646974, 0x7379736f70, 0, 0, 0, 0.865152154419, 0x3230303730313331323030363035, 11, 1);
INSERT INTO `wiki_page` VALUES (12, 8, 0x4163636573736b65792d70726576696577, 0x7379736f70, 0, 0, 0, 0.04600825307, 0x3230303730313331323030363035, 12, 1);
INSERT INTO `wiki_page` VALUES (13, 8, 0x4163636573736b65792d73617665, 0x7379736f70, 0, 0, 0, 0.161152691678, 0x3230303730313331323030363035, 13, 1);
INSERT INTO `wiki_page` VALUES (14, 8, 0x4163636573736b65792d736561726368, 0x7379736f70, 0, 0, 0, 0.621582372616, 0x3230303730313331323030363035, 14, 1);
INSERT INTO `wiki_page` VALUES (15, 8, 0x4163636d61696c74657874, 0x7379736f70, 0, 0, 0, 0.373679140241, 0x3230303730313331323030363035, 15, 42);
INSERT INTO `wiki_page` VALUES (16, 8, 0x4163636d61696c7469746c65, 0x7379736f70, 0, 0, 0, 0.689445664915, 0x3230303730313331323030363035, 16, 14);
INSERT INTO `wiki_page` VALUES (17, 8, 0x416363745f6372656174696f6e5f7468726f74746c655f686974, 0x7379736f70, 0, 0, 0, 0.809499954858, 0x3230303730313331323030363035, 17, 69);
INSERT INTO `wiki_page` VALUES (18, 8, 0x416374696f6e636f6d706c657465, 0x7379736f70, 0, 0, 0, 0.398753643589, 0x3230303730313331323030363035, 18, 15);
INSERT INTO `wiki_page` VALUES (19, 8, 0x41646465647761746368, 0x7379736f70, 0, 0, 0, 0.274683627015, 0x3230303730313331323030363035, 19, 18);
INSERT INTO `wiki_page` VALUES (20, 8, 0x4164646564776174636874657874, 0x7379736f70, 0, 0, 0, 0.549065865305, 0x3230303730313331323030363035, 20, 372);
INSERT INTO `wiki_page` VALUES (21, 8, 0x41646467726f7570, 0x7379736f70, 0, 0, 0, 0.302062546218, 0x3230303730313331323030363035, 21, 9);
INSERT INTO `wiki_page` VALUES (22, 8, 0x41646467726f75706c6f67656e747279, 0x7379736f70, 0, 0, 0, 0.334519797776, 0x3230303730313331323030363035, 22, 14);
INSERT INTO `wiki_page` VALUES (23, 8, 0x41646473656374696f6e, 0x7379736f70, 0, 0, 0, 0.999388896182, 0x3230303730313331323030363035, 23, 1);
INSERT INTO `wiki_page` VALUES (24, 8, 0x41646d696e6973747261746f7273, 0x7379736f70, 0, 0, 0, 0.801592948425, 0x3230303730313331323030363035, 24, 22);
INSERT INTO `wiki_page` VALUES (25, 8, 0x416c6c61727469636c6573, 0x7379736f70, 0, 0, 0, 0.771655676045, 0x3230303730313331323030363035, 25, 12);
INSERT INTO `wiki_page` VALUES (26, 8, 0x416c6c696e6e616d657370616365, 0x7379736f70, 0, 0, 0, 0.833607498423, 0x3230303730313331323030363035, 26, 24);
INSERT INTO `wiki_page` VALUES (27, 8, 0x416c6c6c6f677374657874, 0x7379736f70, 0, 0, 0, 0.31532466066, 0x3230303730313331323030363035, 27, 166);
INSERT INTO `wiki_page` VALUES (28, 8, 0x416c6c6d65737361676573, 0x7379736f70, 0, 0, 0, 0.368525763483, 0x3230303730313331323030363035, 28, 15);
INSERT INTO `wiki_page` VALUES (29, 8, 0x416c6c6d6573736167657363757272656e74, 0x7379736f70, 0, 0, 0, 0.562322719591, 0x3230303730313331323030363035, 29, 12);
INSERT INTO `wiki_page` VALUES (30, 8, 0x416c6c6d6573736167657364656661756c74, 0x7379736f70, 0, 0, 0, 0.55064618617, 0x3230303730313331323030363035, 30, 12);
INSERT INTO `wiki_page` VALUES (31, 8, 0x416c6c6d6573736167657366696c746572, 0x7379736f70, 0, 0, 0, 0.508254884001, 0x3230303730313331323030363035, 31, 20);
INSERT INTO `wiki_page` VALUES (32, 8, 0x416c6c6d657373616765736d6f646966696564, 0x7379736f70, 0, 0, 0, 0.789080006828, 0x3230303730313331323030363035, 32, 18);
INSERT INTO `wiki_page` VALUES (33, 8, 0x416c6c6d657373616765736e616d65, 0x7379736f70, 0, 0, 0, 0.605167498107, 0x3230303730313331323030363035, 33, 4);
INSERT INTO `wiki_page` VALUES (34, 8, 0x416c6c6d657373616765736e6f74737570706f727465644442, 0x7379736f70, 0, 0, 0, 0.258670125289, 0x3230303730313331323030363035, 34, 72);
INSERT INTO `wiki_page` VALUES (35, 8, 0x416c6c6d657373616765736e6f74737570706f727465645549, 0x7379736f70, 0, 0, 0, 0.362616647009, 0x3230303730313331323030363035, 35, 95);
INSERT INTO `wiki_page` VALUES (36, 8, 0x416c6c6d6573736167657374657874, 0x7379736f70, 0, 0, 0, 0.927947472075, 0x3230303730313331323030363036, 36, 72);
INSERT INTO `wiki_page` VALUES (37, 8, 0x416c6c6e6f6e61727469636c6573, 0x7379736f70, 0, 0, 0, 0.842925501317, 0x3230303730313331323030363036, 37, 16);
INSERT INTO `wiki_page` VALUES (38, 8, 0x416c6c6e6f74696e6e616d657370616365, 0x7379736f70, 0, 0, 0, 0.421498827554, 0x3230303730313331323030363036, 38, 31);
INSERT INTO `wiki_page` VALUES (39, 8, 0x416c6c6f77656d61696c, 0x7379736f70, 0, 0, 0, 0.088651187702, 0x3230303730313331323030363036, 39, 30);
INSERT INTO `wiki_page` VALUES (40, 8, 0x416c6c7061676573, 0x7379736f70, 0, 0, 0, 0.626806352651, 0x3230303730313331323030363036, 40, 9);
INSERT INTO `wiki_page` VALUES (41, 8, 0x416c6c706167657366726f6d, 0x7379736f70, 0, 0, 0, 0.086716816784, 0x3230303730313331323030363036, 41, 26);
INSERT INTO `wiki_page` VALUES (42, 8, 0x416c6c70616765736e657874, 0x7379736f70, 0, 0, 0, 0.151268238153, 0x3230303730313331323030363036, 42, 4);
INSERT INTO `wiki_page` VALUES (43, 8, 0x416c6c7061676573707265666978, 0x7379736f70, 0, 0, 0, 0.722276804245, 0x3230303730313331323030363036, 43, 26);
INSERT INTO `wiki_page` VALUES (44, 8, 0x416c6c706167657370726576, 0x7379736f70, 0, 0, 0, 0.635956425579, 0x3230303730313331323030363036, 44, 8);
INSERT INTO `wiki_page` VALUES (45, 8, 0x416c6c70616765737375626d6974, 0x7379736f70, 0, 0, 0, 0.049426045723, 0x3230303730313331323030363036, 45, 2);
INSERT INTO `wiki_page` VALUES (46, 8, 0x416c706861696e6465786c696e65, 0x7379736f70, 0, 0, 0, 0.345309125132, 0x3230303730313331323030363036, 46, 8);
INSERT INTO `wiki_page` VALUES (47, 8, 0x416c72656164795f62757265617563726174, 0x7379736f70, 0, 0, 0, 0.377118788535, 0x3230303730313331323030363036, 47, 33);
INSERT INTO `wiki_page` VALUES (48, 8, 0x416c72656164795f73746577617264, 0x7379736f70, 0, 0, 0, 0.123170266749, 0x3230303730313331323030363036, 48, 30);
INSERT INTO `wiki_page` VALUES (49, 8, 0x416c72656164795f7379736f70, 0x7379736f70, 0, 0, 0, 0.888297152804, 0x3230303730313331323030363036, 49, 37);
INSERT INTO `wiki_page` VALUES (50, 8, 0x416c72656164796c6f67676564696e, 0x7379736f70, 0, 0, 0, 0.47011798101, 0x3230303730313331323030363036, 50, 58);
INSERT INTO `wiki_page` VALUES (51, 8, 0x416c7265616479726f6c6c6564, 0x7379736f70, 0, 0, 0, 0.370039593181, 0x3230303730313331323030363036, 51, 193);
INSERT INTO `wiki_page` VALUES (52, 8, 0x416e6369656e747061676573, 0x7379736f70, 0, 0, 0, 0.7816645715, 0x3230303730313331323030363036, 52, 12);
INSERT INTO `wiki_page` VALUES (53, 8, 0x416e64, 0x7379736f70, 0, 0, 0, 0.025806038689, 0x3230303730313331323030363036, 53, 3);
INSERT INTO `wiki_page` VALUES (54, 8, 0x416e6f6e656469747761726e696e67, 0x7379736f70, 0, 0, 0, 0.354171358227, 0x3230303730313331323030363036, 54, 84);
INSERT INTO `wiki_page` VALUES (55, 8, 0x416e6f6e6e6f74696365, 0x7379736f70, 0, 0, 0, 0.301775003872, 0x3230303730313331323030363036, 55, 1);
INSERT INTO `wiki_page` VALUES (56, 8, 0x416e6f6e74616c6b, 0x7379736f70, 0, 0, 0, 0.87807049868, 0x3230303730313331323030363036, 56, 16);
INSERT INTO `wiki_page` VALUES (57, 8, 0x416e6f6e74616c6b7061676574657874, 0x7379736f70, 0, 0, 0, 0.610756651263, 0x3230303730313331323030363036, 57, 443);
INSERT INTO `wiki_page` VALUES (58, 8, 0x416e6f6e796d6f7573, 0x7379736f70, 0, 0, 0, 0.740032059653, 0x3230303730313331323030363036, 58, 33);
INSERT INTO `wiki_page` VALUES (59, 8, 0x417072, 0x7379736f70, 0, 0, 0, 0.219582308991, 0x3230303730313331323030363036, 59, 3);
INSERT INTO `wiki_page` VALUES (60, 8, 0x417072696c, 0x7379736f70, 0, 0, 0, 0.222026660098, 0x3230303730313331323030363036, 60, 5);
INSERT INTO `wiki_page` VALUES (61, 8, 0x41727469636c65, 0x7379736f70, 0, 0, 0, 0.501095230683, 0x3230303730313331323030363036, 61, 12);
INSERT INTO `wiki_page` VALUES (62, 8, 0x41727469636c65657869737473, 0x7379736f70, 0, 0, 0, 0.417509702636, 0x3230303730313331323030363036, 62, 105);
INSERT INTO `wiki_page` VALUES (63, 8, 0x41727469636c6570616765, 0x7379736f70, 0, 0, 0, 0.417069489834, 0x3230303730313331323030363036, 63, 17);
INSERT INTO `wiki_page` VALUES (64, 8, 0x41727469636c657469746c6573, 0x7379736f70, 0, 0, 0, 0.778143033132, 0x3230303730313331323030363036, 64, 29);
INSERT INTO `wiki_page` VALUES (65, 8, 0x417567, 0x7379736f70, 0, 0, 0, 0.862576150399, 0x3230303730313331323030363036, 65, 3);
INSERT INTO `wiki_page` VALUES (66, 8, 0x417567757374, 0x7379736f70, 0, 0, 0, 0.638312590144, 0x3230303730313331323030363036, 66, 6);
INSERT INTO `wiki_page` VALUES (67, 8, 0x4175746f626c6f636b6572, 0x7379736f70, 0, 0, 0, 0.678158951974, 0x3230303730313331323030363036, 67, 126);
INSERT INTO `wiki_page` VALUES (68, 8, 0x426164616363657373, 0x7379736f70, 0, 0, 0, 0.602845328797, 0x3230303730313331323030363036, 68, 16);
INSERT INTO `wiki_page` VALUES (69, 8, 0x42616461636365737374657874, 0x7379736f70, 0, 0, 0, 0.373373591835, 0x3230303730313331323030363036, 69, 92);
INSERT INTO `wiki_page` VALUES (70, 8, 0x42616461727469636c656572726f72, 0x7379736f70, 0, 0, 0, 0.273592922067, 0x3230303730313331323030363036, 70, 45);
INSERT INTO `wiki_page` VALUES (71, 8, 0x42616466696c656e616d65, 0x7379736f70, 0, 0, 0, 0.241424412677, 0x3230303730313331323030363036, 71, 35);
INSERT INTO `wiki_page` VALUES (72, 8, 0x42616466696c6574797065, 0x7379736f70, 0, 0, 0, 0.438305526364, 0x3230303730313331323030363036, 72, 45);
INSERT INTO `wiki_page` VALUES (73, 8, 0x426164697061646472657373, 0x7379736f70, 0, 0, 0, 0.453338975949, 0x3230303730313331323030363036, 73, 18);
INSERT INTO `wiki_page` VALUES (74, 8, 0x4261647175657279, 0x7379736f70, 0, 0, 0, 0.832029930951, 0x3230303730313331323030363036, 74, 25);
INSERT INTO `wiki_page` VALUES (75, 8, 0x426164717565727974657874, 0x7379736f70, 0, 0, 0, 0.990666729123, 0x3230303730313331323030363036, 75, 273);
INSERT INTO `wiki_page` VALUES (76, 8, 0x426164726574797065, 0x7379736f70, 0, 0, 0, 0.11968112531, 0x3230303730313331323030363036, 76, 39);
INSERT INTO `wiki_page` VALUES (77, 8, 0x426164736967, 0x7379736f70, 0, 0, 0, 0.78128511403, 0x3230303730313331323030363036, 77, 39);
INSERT INTO `wiki_page` VALUES (78, 8, 0x4261647469746c65, 0x7379736f70, 0, 0, 0, 0.298964649262, 0x3230303730313331323030363036, 78, 9);
INSERT INTO `wiki_page` VALUES (79, 8, 0x4261647469746c6574657874, 0x7379736f70, 0, 0, 0, 0.024443629659, 0x3230303730313331323030363036, 79, 172);
INSERT INTO `wiki_page` VALUES (80, 8, 0x426c616e6b6e616d657370616365, 0x7379736f70, 0, 0, 0, 0.564521057744, 0x3230303730313331323030363036, 80, 6);
INSERT INTO `wiki_page` VALUES (81, 8, 0x426c6f636b656474657874, 0x7379736f70, 0, 0, 0, 0.688551398954, 0x3230303730313331323030363036, 81, 430);
INSERT INTO `wiki_page` VALUES (82, 8, 0x426c6f636b65647469746c65, 0x7379736f70, 0, 0, 0, 0.948310118077, 0x3230303730313331323030363036, 82, 15);
INSERT INTO `wiki_page` VALUES (83, 8, 0x426c6f636b6970, 0x7379736f70, 0, 0, 0, 0.133321515647, 0x3230303730313331323030363036, 83, 10);
INSERT INTO `wiki_page` VALUES (84, 8, 0x426c6f636b697073756363657373737562, 0x7379736f70, 0, 0, 0, 0.459783358214, 0x3230303730313331323030363036, 84, 15);
INSERT INTO `wiki_page` VALUES (85, 8, 0x426c6f636b69707375636365737374657874, 0x7379736f70, 0, 0, 0, 0.371712833476, 0x3230303730313331323030363036, 85, 129);
INSERT INTO `wiki_page` VALUES (86, 8, 0x426c6f636b697074657874, 0x7379736f70, 0, 0, 0, 0.606830521408, 0x3230303730313331323030363036, 86, 275);
INSERT INTO `wiki_page` VALUES (87, 8, 0x426c6f636b6c696e6b, 0x7379736f70, 0, 0, 0, 0.673536580345, 0x3230303730313331323030363036, 87, 5);
INSERT INTO `wiki_page` VALUES (88, 8, 0x426c6f636b6c6973746c696e65, 0x7379736f70, 0, 0, 0, 0.408050418129, 0x3230303730313331323030363036, 88, 22);
INSERT INTO `wiki_page` VALUES (89, 8, 0x426c6f636b6c6f67656e747279, 0x7379736f70, 0, 0, 0, 0.505913364499, 0x3230303730313331323030363036, 89, 42);
INSERT INTO `wiki_page` VALUES (90, 8, 0x426c6f636b6c6f6770616765, 0x7379736f70, 0, 0, 0, 0.934918119361, 0x3230303730313331323030363036, 90, 9);
INSERT INTO `wiki_page` VALUES (91, 8, 0x426c6f636b6c6f6774657874, 0x7379736f70, 0, 0, 0, 0.31650786887, 0x3230303730313331323030363036, 91, 206);
INSERT INTO `wiki_page` VALUES (92, 8, 0x426f6c645f73616d706c65, 0x7379736f70, 0, 0, 0, 0.919611562296, 0x3230303730313331323030363036, 92, 9);
INSERT INTO `wiki_page` VALUES (93, 8, 0x426f6c645f746970, 0x7379736f70, 0, 0, 0, 0.886138629249, 0x3230303730313331323030363036, 93, 9);
INSERT INTO `wiki_page` VALUES (94, 8, 0x426f6f6b736f7572636573, 0x7379736f70, 0, 0, 0, 0.596104885267, 0x3230303730313331323030363036, 94, 12);
INSERT INTO `wiki_page` VALUES (95, 8, 0x426f6f6b736f7572636574657874, 0x7379736f70, 0, 0, 0, 0.919354800509, 0x3230303730313331323030363036, 95, 140);
INSERT INTO `wiki_page` VALUES (96, 8, 0x42726f6b656e726564697265637473, 0x7379736f70, 0, 0, 0, 0.030862748599, 0x3230303730313331323030363036, 96, 16);
INSERT INTO `wiki_page` VALUES (97, 8, 0x42726f6b656e72656469726563747374657874, 0x7379736f70, 0, 0, 0, 0.118022245208, 0x3230303730313331323030363036, 97, 51);
INSERT INTO `wiki_page` VALUES (98, 8, 0x4275677265706f727473, 0x7379736f70, 0, 0, 0, 0.374492116767, 0x3230303730313331323030363036, 98, 11);
INSERT INTO `wiki_page` VALUES (99, 8, 0x4275677265706f72747370616765, 0x7379736f70, 0, 0, 0, 0.649035474599, 0x3230303730313331323030363036, 99, 19);
INSERT INTO `wiki_page` VALUES (100, 8, 0x427572656175637261746c6f67, 0x7379736f70, 0, 0, 0, 0.801275685312, 0x3230303730313331323030363036, 100, 14);
INSERT INTO `wiki_page` VALUES (101, 8, 0x427572656175637261746c6f67656e747279, 0x7379736f70, 0, 0, 0, 0.350809302634, 0x3230303730313331323030363036, 101, 45);
INSERT INTO `wiki_page` VALUES (102, 8, 0x427964617465, 0x7379736f70, 0, 0, 0, 0.785691008601, 0x3230303730313331323030363036, 102, 7);
INSERT INTO `wiki_page` VALUES (103, 8, 0x42796e616d65, 0x7379736f70, 0, 0, 0, 0.957854987399, 0x3230303730313331323030363036, 103, 7);
INSERT INTO `wiki_page` VALUES (104, 8, 0x427973697a65, 0x7379736f70, 0, 0, 0, 0.026774344823, 0x3230303730313331323030363036, 104, 7);
INSERT INTO `wiki_page` VALUES (105, 8, 0x4361636865646572726f72, 0x7379736f70, 0, 0, 0, 0.400689881892, 0x3230303730313331323030363036, 105, 80);
INSERT INTO `wiki_page` VALUES (106, 8, 0x43616e63656c, 0x7379736f70, 0, 0, 0, 0.247258341895, 0x3230303730313331323030363036, 106, 6);
INSERT INTO `wiki_page` VALUES (107, 8, 0x43616e6e6f7464656c657465, 0x7379736f70, 0, 0, 0, 0.726546874351, 0x3230303730313331323030363036, 107, 96);
INSERT INTO `wiki_page` VALUES (108, 8, 0x43616e74726f6c6c6261636b, 0x7379736f70, 0, 0, 0, 0.299621874379, 0x3230303730313331323030363036, 108, 65);
INSERT INTO `wiki_page` VALUES (109, 8, 0x43617465676f72696573, 0x7379736f70, 0, 0, 0, 0.530503095029, 0x3230303730313331323030363036, 109, 10);
INSERT INTO `wiki_page` VALUES (110, 8, 0x43617465676f7269657331, 0x7379736f70, 0, 0, 0, 0.917302050506, 0x3230303730313331323030363036, 110, 8);
INSERT INTO `wiki_page` VALUES (111, 8, 0x43617465676f726965737061676574657874, 0x7379736f70, 0, 0, 0, 0.794051701536, 0x3230303730313331323030363036, 111, 43);
INSERT INTO `wiki_page` VALUES (112, 8, 0x43617465676f7279, 0x7379736f70, 0, 0, 0, 0.634381278901, 0x3230303730313331323030363036, 112, 8);
INSERT INTO `wiki_page` VALUES (113, 8, 0x43617465676f72795f686561646572, 0x7379736f70, 0, 0, 0, 0.634945812247, 0x3230303730313331323030363036, 113, 25);
INSERT INTO `wiki_page` VALUES (114, 8, 0x43617465676f727961727469636c65636f756e74, 0x7379736f70, 0, 0, 0, 0.901367238389, 0x3230303730313331323030363036, 114, 39);
INSERT INTO `wiki_page` VALUES (115, 8, 0x43617465676f727961727469636c65636f756e7431, 0x7379736f70, 0, 0, 0, 0.963395894181, 0x3230303730313331323030363036, 115, 37);
INSERT INTO `wiki_page` VALUES (116, 8, 0x436174736570617261746f72, 0x7379736f70, 0, 0, 0, 0.824857687432, 0x3230303730313331323030363036, 116, 1);
INSERT INTO `wiki_page` VALUES (117, 8, 0x4368616e676564, 0x7379736f70, 0, 0, 0, 0.755450560235, 0x3230303730313331323030363036, 117, 7);
INSERT INTO `wiki_page` VALUES (118, 8, 0x4368616e676567726f75706c6f67656e747279, 0x7379736f70, 0, 0, 0, 0.401787308454, 0x3230303730313331323030363037, 118, 16);
INSERT INTO `wiki_page` VALUES (119, 8, 0x4368616e676570617373776f7264, 0x7379736f70, 0, 0, 0, 0.116327077374, 0x3230303730313331323030363037, 119, 15);
INSERT INTO `wiki_page` VALUES (120, 8, 0x4368616e676573, 0x7379736f70, 0, 0, 0, 0.839979758329, 0x3230303730313331323030363037, 120, 7);
INSERT INTO `wiki_page` VALUES (121, 8, 0x436c656172796f75726361636865, 0x7379736f70, 0, 0, 0, 0.150373086501, 0x3230303730313331323030363037, 121, 463);
INSERT INTO `wiki_page` VALUES (122, 8, 0x436f6c756d6e73, 0x7379736f70, 0, 0, 0, 0.006074931661, 0x3230303730313331323030363037, 122, 8);
INSERT INTO `wiki_page` VALUES (123, 8, 0x436f6d7061726573656c656374656476657273696f6e73, 0x7379736f70, 0, 0, 0, 0.409299030829, 0x3230303730313331323030363037, 123, 25);
INSERT INTO `wiki_page` VALUES (124, 8, 0x436f6e6669726d, 0x7379736f70, 0, 0, 0, 0.405687657302, 0x3230303730313331323030363037, 124, 7);
INSERT INTO `wiki_page` VALUES (125, 8, 0x436f6e6669726d5f7075726765, 0x7379736f70, 0, 0, 0, 0.524215300801, 0x3230303730313331323030363037, 125, 33);
INSERT INTO `wiki_page` VALUES (126, 8, 0x436f6e6669726d5f70757267655f627574746f6e, 0x7379736f70, 0, 0, 0, 0.018217143507, 0x3230303730313331323030363037, 126, 2);
INSERT INTO `wiki_page` VALUES (127, 8, 0x436f6e6669726d64656c657465, 0x7379736f70, 0, 0, 0, 0.549675246763, 0x3230303730313331323030363037, 127, 14);
INSERT INTO `wiki_page` VALUES (128, 8, 0x436f6e6669726d64656c65746574657874, 0x7379736f70, 0, 0, 0, 0.112470289332, 0x3230303730313331323030363037, 128, 248);
INSERT INTO `wiki_page` VALUES (129, 8, 0x436f6e6669726d6564697474657874, 0x7379736f70, 0, 0, 0, 0.478746921169, 0x3230303730313331323030363037, 129, 157);
INSERT INTO `wiki_page` VALUES (130, 8, 0x436f6e6669726d656469747469746c65, 0x7379736f70, 0, 0, 0, 0.732508358492, 0x3230303730313331323030363037, 130, 36);
INSERT INTO `wiki_page` VALUES (131, 8, 0x436f6e6669726d656d61696c, 0x7379736f70, 0, 0, 0, 0.215894082143, 0x3230303730313331323030363037, 131, 22);
INSERT INTO `wiki_page` VALUES (132, 8, 0x436f6e6669726d656d61696c5f626f6479, 0x7379736f70, 0, 0, 0, 0.781507974431, 0x3230303730313331323030363037, 132, 340);
INSERT INTO `wiki_page` VALUES (133, 8, 0x436f6e6669726d656d61696c5f6572726f72, 0x7379736f70, 0, 0, 0, 0.366868354715, 0x3230303730313331323030363037, 133, 46);
INSERT INTO `wiki_page` VALUES (134, 8, 0x436f6e6669726d656d61696c5f696e76616c6964, 0x7379736f70, 0, 0, 0, 0.40993238511, 0x3230303730313331323030363037, 134, 53);
INSERT INTO `wiki_page` VALUES (135, 8, 0x436f6e6669726d656d61696c5f6c6f67676564696e, 0x7379736f70, 0, 0, 0, 0.136818127392, 0x3230303730313331323030363037, 135, 43);
INSERT INTO `wiki_page` VALUES (136, 8, 0x436f6e6669726d656d61696c5f73656e64, 0x7379736f70, 0, 0, 0, 0.276392804395, 0x3230303730313331323030363037, 136, 24);
INSERT INTO `wiki_page` VALUES (137, 8, 0x436f6e6669726d656d61696c5f73656e646661696c6564, 0x7379736f70, 0, 0, 0, 0.850519111682, 0x3230303730313331323030363037, 137, 71);
INSERT INTO `wiki_page` VALUES (138, 8, 0x436f6e6669726d656d61696c5f73656e74, 0x7379736f70, 0, 0, 0, 0.593400369742, 0x3230303730313331323030363037, 138, 25);
INSERT INTO `wiki_page` VALUES (139, 8, 0x436f6e6669726d656d61696c5f7375626a656374, 0x7379736f70, 0, 0, 0, 0.691104389988, 0x3230303730313331323030363037, 139, 40);
INSERT INTO `wiki_page` VALUES (140, 8, 0x436f6e6669726d656d61696c5f73756363657373, 0x7379736f70, 0, 0, 0, 0.54209220103, 0x3230303730313331323030363037, 140, 78);
INSERT INTO `wiki_page` VALUES (141, 8, 0x436f6e6669726d656d61696c5f74657874, 0x7379736f70, 0, 0, 0, 0.943693938188, 0x3230303730313331323030363037, 141, 281);
INSERT INTO `wiki_page` VALUES (142, 8, 0x436f6e6669726d70726f74656374, 0x7379736f70, 0, 0, 0, 0.182717460556, 0x3230303730313331323030363037, 142, 18);
INSERT INTO `wiki_page` VALUES (143, 8, 0x436f6e6669726d70726f7465637474657874, 0x7379736f70, 0, 0, 0, 0.892044809357, 0x3230303730313331323030363037, 143, 40);
INSERT INTO `wiki_page` VALUES (144, 8, 0x436f6e6669726d7265637265617465, 0x7379736f70, 0, 0, 0, 0.368900263699, 0x3230303730313331323030363037, 144, 170);
INSERT INTO `wiki_page` VALUES (145, 8, 0x436f6e6669726d756e70726f74656374, 0x7379736f70, 0, 0, 0, 0.465721426849, 0x3230303730313331323030363037, 145, 20);
INSERT INTO `wiki_page` VALUES (146, 8, 0x436f6e6669726d756e70726f7465637474657874, 0x7379736f70, 0, 0, 0, 0.333917628404, 0x3230303730313331323030363037, 146, 42);
INSERT INTO `wiki_page` VALUES (147, 8, 0x436f6e746578746368617273, 0x7379736f70, 0, 0, 0, 0.021352284862, 0x3230303730313331323030363037, 147, 17);
INSERT INTO `wiki_page` VALUES (148, 8, 0x436f6e746578746c696e6573, 0x7379736f70, 0, 0, 0, 0.588978271165, 0x3230303730313331323030363037, 148, 14);
INSERT INTO `wiki_page` VALUES (149, 8, 0x436f6e74726962732d73686f77686964656d696e6f72, 0x7379736f70, 0, 0, 0, 0.544408690146, 0x3230303730313331323030363037, 149, 14);
INSERT INTO `wiki_page` VALUES (150, 8, 0x436f6e74726962736c696e6b, 0x7379736f70, 0, 0, 0, 0.245770608929, 0x3230303730313331323030363037, 150, 8);
INSERT INTO `wiki_page` VALUES (151, 8, 0x436f6e74726962737562, 0x7379736f70, 0, 0, 0, 0.505244725458, 0x3230303730313331323030363037, 151, 6);
INSERT INTO `wiki_page` VALUES (152, 8, 0x436f6e747269627574696f6e73, 0x7379736f70, 0, 0, 0, 0.020914376367, 0x3230303730313331323030363037, 152, 18);
INSERT INTO `wiki_page` VALUES (153, 8, 0x436f70797269676874, 0x7379736f70, 0, 0, 0, 0.802689669361, 0x3230303730313331323030363037, 153, 30);
INSERT INTO `wiki_page` VALUES (154, 8, 0x436f7079726967687470616765, 0x7379736f70, 0, 0, 0, 0.621991633708, 0x3230303730313331323030363037, 154, 18);
INSERT INTO `wiki_page` VALUES (155, 8, 0x436f70797269676874706167656e616d65, 0x7379736f70, 0, 0, 0, 0.947553120599, 0x3230303730313331323030363037, 155, 22);
INSERT INTO `wiki_page` VALUES (156, 8, 0x436f707972696768747761726e696e67, 0x7379736f70, 0, 0, 0, 0.262221717132, 0x3230303730313331323030363037, 156, 415);
INSERT INTO `wiki_page` VALUES (157, 8, 0x436f707972696768747761726e696e6732, 0x7379736f70, 0, 0, 0, 0.558942698773, 0x3230303730313331323030363037, 157, 403);
INSERT INTO `wiki_page` VALUES (158, 8, 0x436f756c646e7472656d6f7665, 0x7379736f70, 0, 0, 0, 0.114157234701, 0x3230303730313331323030363037, 158, 28);
INSERT INTO `wiki_page` VALUES (159, 8, 0x4372656174656163636f756e74, 0x7379736f70, 0, 0, 0, 0.139641962764, 0x3230303730313331323030363037, 159, 14);
INSERT INTO `wiki_page` VALUES (160, 8, 0x4372656174656163636f756e746d61696c, 0x7379736f70, 0, 0, 0, 0.897013858484, 0x3230303730313331323030363037, 160, 9);
INSERT INTO `wiki_page` VALUES (161, 8, 0x43726561746561727469636c65, 0x7379736f70, 0, 0, 0, 0.373910906571, 0x3230303730313331323030363037, 161, 14);
INSERT INTO `wiki_page` VALUES (162, 8, 0x43726561746564, 0x7379736f70, 0, 0, 0, 0.427844745918, 0x3230303730313331323030363037, 162, 7);
INSERT INTO `wiki_page` VALUES (163, 8, 0x4372656469747370616765, 0x7379736f70, 0, 0, 0, 0.418918617861, 0x3230303730313331323030363037, 163, 12);
INSERT INTO `wiki_page` VALUES (164, 8, 0x437572, 0x7379736f70, 0, 0, 0, 0.553252592889, 0x3230303730313331323030363037, 164, 3);
INSERT INTO `wiki_page` VALUES (165, 8, 0x43757272656e746576656e7473, 0x7379736f70, 0, 0, 0, 0.434163321423, 0x3230303730313331323030363037, 165, 14);
INSERT INTO `wiki_page` VALUES (166, 8, 0x43757272656e746576656e74732d75726c, 0x7379736f70, 0, 0, 0, 0.398929735324, 0x3230303730313331323030363037, 166, 14);
INSERT INTO `wiki_page` VALUES (167, 8, 0x43757272656e74726576, 0x7379736f70, 0, 0, 0, 0.285447918056, 0x3230303730313331323030363037, 167, 16);
INSERT INTO `wiki_page` VALUES (168, 8, 0x43757272656e747265766973696f6e6c696e6b, 0x7379736f70, 0, 0, 0, 0.712769800613, 0x3230303730313331323030363037, 168, 21);
INSERT INTO `wiki_page` VALUES (169, 8, 0x44617461, 0x7379736f70, 0, 0, 0, 0.35845278613, 0x3230303730313331323030363037, 169, 4);
INSERT INTO `wiki_page` VALUES (170, 8, 0x44617461626173656572726f72, 0x7379736f70, 0, 0, 0, 0.706103660437, 0x3230303730313331323030363037, 170, 14);
INSERT INTO `wiki_page` VALUES (171, 8, 0x4461746564656661756c74, 0x7379736f70, 0, 0, 0, 0.48595529565, 0x3230303730313331323030363037, 171, 13);
INSERT INTO `wiki_page` VALUES (172, 8, 0x44617465666f726d6174, 0x7379736f70, 0, 0, 0, 0.399214389129, 0x3230303730313331323030363037, 172, 11);
INSERT INTO `wiki_page` VALUES (173, 8, 0x4461746574696d65, 0x7379736f70, 0, 0, 0, 0.936142993347, 0x3230303730313331323030363037, 173, 13);
INSERT INTO `wiki_page` VALUES (174, 8, 0x44626572726f7274657874, 0x7379736f70, 0, 0, 0, 0.943001678935, 0x3230303730313331323030363037, 174, 236);
INSERT INTO `wiki_page` VALUES (175, 8, 0x44626572726f7274657874636c, 0x7379736f70, 0, 0, 0, 0.041079842154, 0x3230303730313331323030363037, 175, 144);
INSERT INTO `wiki_page` VALUES (176, 8, 0x44656164656e647061676573, 0x7379736f70, 0, 0, 0, 0.177603901089, 0x3230303730313331323030363037, 176, 14);
INSERT INTO `wiki_page` VALUES (177, 8, 0x4465627567, 0x7379736f70, 0, 0, 0, 0.542849186797, 0x3230303730313331323030363037, 177, 5);
INSERT INTO `wiki_page` VALUES (178, 8, 0x446563, 0x7379736f70, 0, 0, 0, 0.101000517775, 0x3230303730313331323030363037, 178, 3);
INSERT INTO `wiki_page` VALUES (179, 8, 0x446563656d626572, 0x7379736f70, 0, 0, 0, 0.208418769588, 0x3230303730313331323030363037, 179, 8);
INSERT INTO `wiki_page` VALUES (180, 8, 0x44656661756c74, 0x7379736f70, 0, 0, 0, 0.266678775861, 0x3230303730313331323030363037, 180, 7);
INSERT INTO `wiki_page` VALUES (181, 8, 0x44656661756c746e73, 0x7379736f70, 0, 0, 0, 0.70418075663, 0x3230303730313331323030363037, 181, 38);
INSERT INTO `wiki_page` VALUES (182, 8, 0x446566656d61696c7375626a656374, 0x7379736f70, 0, 0, 0, 0.636470989998, 0x3230303730313331323030363037, 182, 19);
INSERT INTO `wiki_page` VALUES (183, 8, 0x44656c657465, 0x7379736f70, 0, 0, 0, 0.964605033012, 0x3230303730313331323030363037, 183, 6);
INSERT INTO `wiki_page` VALUES (184, 8, 0x44656c6574655f616e645f6d6f7665, 0x7379736f70, 0, 0, 0, 0.568078485975, 0x3230303730313331323030363037, 184, 15);
INSERT INTO `wiki_page` VALUES (185, 8, 0x44656c6574655f616e645f6d6f76655f636f6e6669726d, 0x7379736f70, 0, 0, 0, 0.797828895122, 0x3230303730313331323030363037, 185, 20);
INSERT INTO `wiki_page` VALUES (186, 8, 0x44656c6574655f616e645f6d6f76655f726561736f6e, 0x7379736f70, 0, 0, 0, 0.796283436124, 0x3230303730313331323030363037, 186, 28);
INSERT INTO `wiki_page` VALUES (187, 8, 0x44656c6574655f616e645f6d6f76655f74657874, 0x7379736f70, 0, 0, 0, 0.926170508818, 0x3230303730313331323030363037, 187, 122);
INSERT INTO `wiki_page` VALUES (188, 8, 0x44656c657465636f6d6d656e74, 0x7379736f70, 0, 0, 0, 0.140130420595, 0x3230303730313331323030363037, 188, 19);
INSERT INTO `wiki_page` VALUES (189, 8, 0x44656c6574656461727469636c65, 0x7379736f70, 0, 0, 0, 0.375119200534, 0x3230303730313331323030363037, 189, 16);
INSERT INTO `wiki_page` VALUES (190, 8, 0x44656c65746564726576, 0x7379736f70, 0, 0, 0, 0.98296268888, 0x3230303730313331323030363037, 190, 9);
INSERT INTO `wiki_page` VALUES (191, 8, 0x44656c657465647265766973696f6e, 0x7379736f70, 0, 0, 0, 0.356972448032, 0x3230303730313331323030363037, 191, 24);
INSERT INTO `wiki_page` VALUES (192, 8, 0x44656c6574656474657874, 0x7379736f70, 0, 0, 0, 0.027394699324, 0x3230303730313331323030363037, 192, 63);
INSERT INTO `wiki_page` VALUES (193, 8, 0x44656c657465647768696c6565646974696e67, 0x7379736f70, 0, 0, 0, 0.15648926544, 0x3230303730313331323030363037, 193, 62);
INSERT INTO `wiki_page` VALUES (194, 8, 0x44656c657465696d67, 0x7379736f70, 0, 0, 0, 0.899472637012, 0x3230303730313331323030363038, 194, 3);
INSERT INTO `wiki_page` VALUES (195, 8, 0x44656c657465696d67636f6d706c6574656c79, 0x7379736f70, 0, 0, 0, 0.109236341084, 0x3230303730313331323030363038, 195, 33);
INSERT INTO `wiki_page` VALUES (196, 8, 0x44656c65746570616765, 0x7379736f70, 0, 0, 0, 0.488296628484, 0x3230303730313331323030363038, 196, 11);
INSERT INTO `wiki_page` VALUES (197, 8, 0x44656c657465737562, 0x7379736f70, 0, 0, 0, 0.963030913546, 0x3230303730313331323030363038, 197, 15);
INSERT INTO `wiki_page` VALUES (198, 8, 0x44656c6574657468697370616765, 0x7379736f70, 0, 0, 0, 0.349914675661, 0x3230303730313331323030363038, 198, 16);
INSERT INTO `wiki_page` VALUES (199, 8, 0x44656c6574696f6e6c6f67, 0x7379736f70, 0, 0, 0, 0.087946955795, 0x3230303730313331323030363038, 199, 12);
INSERT INTO `wiki_page` VALUES (200, 8, 0x44656c6c6f6770616765, 0x7379736f70, 0, 0, 0, 0.606557510127, 0x3230303730313331323030363038, 200, 12);
INSERT INTO `wiki_page` VALUES (201, 8, 0x44656c6c6f677061676574657874, 0x7379736f70, 0, 0, 0, 0.572219720289, 0x3230303730313331323030363038, 201, 45);
INSERT INTO `wiki_page` VALUES (202, 8, 0x4465737466696c656e616d65, 0x7379736f70, 0, 0, 0, 0.820960563268, 0x3230303730313331323030363038, 202, 20);
INSERT INTO `wiki_page` VALUES (203, 8, 0x446576656c6f70657274657874, 0x7379736f70, 0, 0, 0, 0.584079367457, 0x3230303730313331323030363038, 203, 97);
INSERT INTO `wiki_page` VALUES (204, 8, 0x446576656c6f7065727469746c65, 0x7379736f70, 0, 0, 0, 0.936348503428, 0x3230303730313331323030363038, 204, 25);
INSERT INTO `wiki_page` VALUES (205, 8, 0x44696666, 0x7379736f70, 0, 0, 0, 0.498758386605, 0x3230303730313331323030363038, 205, 4);
INSERT INTO `wiki_page` VALUES (206, 8, 0x446966666572656e6365, 0x7379736f70, 0, 0, 0, 0.971909368331, 0x3230303730313331323030363038, 206, 30);
INSERT INTO `wiki_page` VALUES (207, 8, 0x446973616d626967756174696f6e73, 0x7379736f70, 0, 0, 0, 0.538575363288, 0x3230303730313331323030363038, 207, 20);
INSERT INTO `wiki_page` VALUES (208, 8, 0x446973616d626967756174696f6e7370616765, 0x7379736f70, 0, 0, 0, 0.713692988033, 0x3230303730313331323030363038, 208, 17);
INSERT INTO `wiki_page` VALUES (209, 8, 0x446973616d626967756174696f6e7374657874, 0x7379736f70, 0, 0, 0, 0.540952677512, 0x3230303730313331323030363038, 209, 235);
INSERT INTO `wiki_page` VALUES (210, 8, 0x446973636c61696d657270616765, 0x7379736f70, 0, 0, 0, 0.752815529013, 0x3230303730313331323030363038, 210, 26);
INSERT INTO `wiki_page` VALUES (211, 8, 0x446973636c61696d657273, 0x7379736f70, 0, 0, 0, 0.818577647772, 0x3230303730313331323030363038, 211, 11);
INSERT INTO `wiki_page` VALUES (212, 8, 0x446f75626c65726564697265637473, 0x7379736f70, 0, 0, 0, 0.387778481585, 0x3230303730313331323030363038, 212, 16);
INSERT INTO `wiki_page` VALUES (213, 8, 0x446f75626c6572656469726563747374657874, 0x7379736f70, 0, 0, 0, 0.353328956818, 0x3230303730313331323030363038, 213, 193);
INSERT INTO `wiki_page` VALUES (214, 8, 0x446f776e6c6f6164, 0x7379736f70, 0, 0, 0, 0.181082787327, 0x3230303730313331323030363038, 214, 8);
INSERT INTO `wiki_page` VALUES (215, 8, 0x4561757468656e7473656e74, 0x7379736f70, 0, 0, 0, 0.548404435241, 0x3230303730313331323030363038, 215, 217);
INSERT INTO `wiki_page` VALUES (216, 8, 0x45646974, 0x7379736f70, 0, 0, 0, 0.690999124022, 0x3230303730313331323030363038, 216, 4);
INSERT INTO `wiki_page` VALUES (217, 8, 0x456469742d65787465726e616c6c79, 0x7379736f70, 0, 0, 0, 0.429258423927, 0x3230303730313331323030363038, 217, 44);
INSERT INTO `wiki_page` VALUES (218, 8, 0x456469742d65787465726e616c6c792d68656c70, 0x7379736f70, 0, 0, 0, 0.736829861075, 0x3230303730313331323030363038, 218, 103);
INSERT INTO `wiki_page` VALUES (219, 8, 0x45646974636f6d6d656e74, 0x7379736f70, 0, 0, 0, 0.406819517652, 0x3230303730313331323030363038, 219, 34);
INSERT INTO `wiki_page` VALUES (220, 8, 0x45646974636f6e666c696374, 0x7379736f70, 0, 0, 0, 0.883851858755, 0x3230303730313331323030363038, 220, 17);
INSERT INTO `wiki_page` VALUES (221, 8, 0x4564697463757272656e74, 0x7379736f70, 0, 0, 0, 0.861164859404, 0x3230303730313331323030363038, 221, 37);
INSERT INTO `wiki_page` VALUES (222, 8, 0x4564697467726f7570, 0x7379736f70, 0, 0, 0, 0.427910387, 0x3230303730313331323030363038, 222, 10);
INSERT INTO `wiki_page` VALUES (223, 8, 0x4564697468656c70, 0x7379736f70, 0, 0, 0, 0.261790382684, 0x3230303730313331323030363038, 223, 12);
INSERT INTO `wiki_page` VALUES (224, 8, 0x4564697468656c7070616765, 0x7379736f70, 0, 0, 0, 0.094923642681, 0x3230303730313331323030363038, 224, 12);
INSERT INTO `wiki_page` VALUES (225, 8, 0x45646974696e67, 0x7379736f70, 0, 0, 0, 0.403977737583, 0x3230303730313331323030363038, 225, 10);
INSERT INTO `wiki_page` VALUES (226, 8, 0x45646974696e67636f6d6d656e74, 0x7379736f70, 0, 0, 0, 0.704076231823, 0x3230303730313331323030363038, 226, 20);
INSERT INTO `wiki_page` VALUES (227, 8, 0x45646974696e676f6c64, 0x7379736f70, 0, 0, 0, 0.989837248435, 0x3230303730313331323030363038, 227, 146);
INSERT INTO `wiki_page` VALUES (228, 8, 0x45646974696e6773656374696f6e, 0x7379736f70, 0, 0, 0, 0.183204462926, 0x3230303730313331323030363038, 228, 20);
INSERT INTO `wiki_page` VALUES (229, 8, 0x4564697473656374696f6e, 0x7379736f70, 0, 0, 0, 0.294023920913, 0x3230303730313331323030363038, 229, 4);
INSERT INTO `wiki_page` VALUES (230, 8, 0x4564697473656374696f6e68696e74, 0x7379736f70, 0, 0, 0, 0.544624685407, 0x3230303730313331323030363038, 230, 16);
INSERT INTO `wiki_page` VALUES (231, 8, 0x456469747468697370616765, 0x7379736f70, 0, 0, 0, 0.922237194123, 0x3230303730313331323030363038, 231, 14);
INSERT INTO `wiki_page` VALUES (232, 8, 0x45646974746f6f6c73, 0x7379736f70, 0, 0, 0, 0.486160034308, 0x3230303730313331323030363038, 232, 61);
INSERT INTO `wiki_page` VALUES (233, 8, 0x456469747573657267726f7570, 0x7379736f70, 0, 0, 0, 0.962464696783, 0x3230303730313331323030363038, 233, 16);
INSERT INTO `wiki_page` VALUES (234, 8, 0x456d61696c, 0x7379736f70, 0, 0, 0, 0.932157026429, 0x3230303730313331323030363038, 234, 6);
INSERT INTO `wiki_page` VALUES (235, 8, 0x456d61696c61757468656e74696361746564, 0x7379736f70, 0, 0, 0, 0.511894674693, 0x3230303730313331323030363038, 235, 44);
INSERT INTO `wiki_page` VALUES (236, 8, 0x456d61696c636f6e6669726d6c696e6b, 0x7379736f70, 0, 0, 0, 0.844943188807, 0x3230303730313331323030363038, 236, 27);
INSERT INTO `wiki_page` VALUES (237, 8, 0x456d61696c666f726c6f7374, 0x7379736f70, 0, 0, 0, 0.568422095054, 0x3230303730313331323030363038, 237, 252);
INSERT INTO `wiki_page` VALUES (238, 8, 0x456d61696c66726f6d, 0x7379736f70, 0, 0, 0, 0.061188529731, 0x3230303730313331323030363038, 238, 4);
INSERT INTO `wiki_page` VALUES (239, 8, 0x456d61696c6d657373616765, 0x7379736f70, 0, 0, 0, 0.366137610457, 0x3230303730313331323030363038, 239, 7);
INSERT INTO `wiki_page` VALUES (240, 8, 0x456d61696c6e6f7461757468656e74696361746564, 0x7379736f70, 0, 0, 0, 0.199243114216, 0x3230303730313331323030363038, 240, 120);
INSERT INTO `wiki_page` VALUES (241, 8, 0x456d61696c70616765, 0x7379736f70, 0, 0, 0, 0.604194980389, 0x3230303730313331323030363038, 241, 11);
INSERT INTO `wiki_page` VALUES (242, 8, 0x456d61696c7061676574657874, 0x7379736f70, 0, 0, 0, 0.733809516374, 0x3230303730313331323030363038, 242, 265);
INSERT INTO `wiki_page` VALUES (243, 8, 0x456d61696c73656e64, 0x7379736f70, 0, 0, 0, 0.349027483779, 0x3230303730313331323030363038, 243, 4);
INSERT INTO `wiki_page` VALUES (244, 8, 0x456d61696c73656e74, 0x7379736f70, 0, 0, 0, 0.614491202657, 0x3230303730313331323030363038, 244, 11);
INSERT INTO `wiki_page` VALUES (245, 8, 0x456d61696c73656e7474657874, 0x7379736f70, 0, 0, 0, 0.361073552736, 0x3230303730313331323030363038, 245, 34);
INSERT INTO `wiki_page` VALUES (246, 8, 0x456d61696c7375626a656374, 0x7379736f70, 0, 0, 0, 0.575098132086, 0x3230303730313331323030363038, 246, 7);
INSERT INTO `wiki_page` VALUES (247, 8, 0x456d61696c746f, 0x7379736f70, 0, 0, 0, 0.472178541357, 0x3230303730313331323030363038, 247, 2);
INSERT INTO `wiki_page` VALUES (248, 8, 0x456d61696c75736572, 0x7379736f70, 0, 0, 0, 0.305675625391, 0x3230303730313331323030363038, 248, 16);
INSERT INTO `wiki_page` VALUES (249, 8, 0x456d70747966696c65, 0x7379736f70, 0, 0, 0, 0.325976808353, 0x3230303730313331323030363038, 249, 144);
INSERT INTO `wiki_page` VALUES (250, 8, 0x456e6f7469665f626f6479, 0x7379736f70, 0, 0, 0, 0.403109103548, 0x3230303730313331323030363038, 250, 692);
INSERT INTO `wiki_page` VALUES (251, 8, 0x456e6f7469665f6c61737476697369746564, 0x7379736f70, 0, 0, 0, 0.915457114197, 0x3230303730313331323030363038, 251, 45);
INSERT INTO `wiki_page` VALUES (252, 8, 0x456e6f7469665f6d61696c6572, 0x7379736f70, 0, 0, 0, 0.90203659466, 0x3230303730313331323030363038, 252, 32);
INSERT INTO `wiki_page` VALUES (253, 8, 0x456e6f7469665f6e65777061676574657874, 0x7379736f70, 0, 0, 0, 0.48682648786, 0x3230303730313331323030363038, 253, 19);
INSERT INTO `wiki_page` VALUES (254, 8, 0x456e6f7469665f7265736574, 0x7379736f70, 0, 0, 0, 0.12993422604, 0x3230303730313331323030363038, 254, 22);
INSERT INTO `wiki_page` VALUES (255, 8, 0x456e6f7469665f7375626a656374, 0x7379736f70, 0, 0, 0, 0.320925499658, 0x3230303730313331323030363038, 255, 70);
INSERT INTO `wiki_page` VALUES (256, 8, 0x456e7465726c6f636b726561736f6e, 0x7379736f70, 0, 0, 0, 0.365267591416, 0x3230303730313331323030363038, 256, 84);
INSERT INTO `wiki_page` VALUES (257, 8, 0x4572726f72, 0x7379736f70, 0, 0, 0, 0.790179166042, 0x3230303730313331323030363038, 257, 5);
INSERT INTO `wiki_page` VALUES (258, 8, 0x4572726f72706167657469746c65, 0x7379736f70, 0, 0, 0, 0.28397738408, 0x3230303730313331323030363038, 258, 5);
INSERT INTO `wiki_page` VALUES (259, 8, 0x45786265666f7265626c616e6b, 0x7379736f70, 0, 0, 0, 0.803353412036, 0x3230303730313331323030363038, 259, 33);
INSERT INTO `wiki_page` VALUES (260, 8, 0x4578626c616e6b, 0x7379736f70, 0, 0, 0, 0.456222772638, 0x3230303730313331323030363038, 260, 14);
INSERT INTO `wiki_page` VALUES (261, 8, 0x4578636f6e74656e74, 0x7379736f70, 0, 0, 0, 0.499662797762, 0x3230303730313331323030363038, 261, 17);
INSERT INTO `wiki_page` VALUES (262, 8, 0x4578636f6e74656e74617574686f72, 0x7379736f70, 0, 0, 0, 0.28188909112, 0x3230303730313331323030363038, 262, 53);
INSERT INTO `wiki_page` VALUES (263, 8, 0x457869662d617065727475726576616c7565, 0x7379736f70, 0, 0, 0, 0.683896264422, 0x3230303730313331323030363038, 263, 8);
INSERT INTO `wiki_page` VALUES (264, 8, 0x457869662d617274697374, 0x7379736f70, 0, 0, 0, 0.176128235072, 0x3230303730313331323030363038, 264, 6);
INSERT INTO `wiki_page` VALUES (265, 8, 0x457869662d6269747370657273616d706c65, 0x7379736f70, 0, 0, 0, 0.301050633608, 0x3230303730313331323030363038, 265, 18);
INSERT INTO `wiki_page` VALUES (266, 8, 0x457869662d6272696768746e65737376616c7565, 0x7379736f70, 0, 0, 0, 0.894249037046, 0x3230303730313331323030363038, 266, 10);
INSERT INTO `wiki_page` VALUES (267, 8, 0x457869662d6366617061747465726e, 0x7379736f70, 0, 0, 0, 0.885428712446, 0x3230303730313331323030363038, 267, 11);
INSERT INTO `wiki_page` VALUES (268, 8, 0x457869662d636f6c6f727370616365, 0x7379736f70, 0, 0, 0, 0.112530295343, 0x3230303730313331323030363038, 268, 11);
INSERT INTO `wiki_page` VALUES (269, 8, 0x457869662d636f6c6f7273706163652d31, 0x7379736f70, 0, 0, 0, 0.167776477732, 0x3230303730313331323030363038, 269, 4);
INSERT INTO `wiki_page` VALUES (270, 8, 0x457869662d636f6c6f7273706163652d666666662e68, 0x7379736f70, 0, 0, 0, 0.212644171596, 0x3230303730313331323030363038, 270, 6);
INSERT INTO `wiki_page` VALUES (271, 8, 0x457869662d636f6d706f6e656e7473636f6e66696775726174696f6e, 0x7379736f70, 0, 0, 0, 0.540721740739, 0x3230303730313331323030363038, 271, 25);
INSERT INTO `wiki_page` VALUES (272, 8, 0x457869662d636f6d706f6e656e7473636f6e66696775726174696f6e2d30, 0x7379736f70, 0, 0, 0, 0.830814129734, 0x3230303730313331323030363038, 272, 14);
INSERT INTO `wiki_page` VALUES (273, 8, 0x457869662d636f6d706f6e656e7473636f6e66696775726174696f6e2d31, 0x7379736f70, 0, 0, 0, 0.658500221476, 0x3230303730313331323030363039, 273, 1);
INSERT INTO `wiki_page` VALUES (274, 8, 0x457869662d636f6d706f6e656e7473636f6e66696775726174696f6e2d32, 0x7379736f70, 0, 0, 0, 0.549602203897, 0x3230303730313331323030363039, 274, 2);
INSERT INTO `wiki_page` VALUES (275, 8, 0x457869662d636f6d706f6e656e7473636f6e66696775726174696f6e2d33, 0x7379736f70, 0, 0, 0, 0.165903317513, 0x3230303730313331323030363039, 275, 2);
INSERT INTO `wiki_page` VALUES (276, 8, 0x457869662d636f6d706f6e656e7473636f6e66696775726174696f6e2d34, 0x7379736f70, 0, 0, 0, 0.118551838941, 0x3230303730313331323030363039, 276, 1);
INSERT INTO `wiki_page` VALUES (277, 8, 0x457869662d636f6d706f6e656e7473636f6e66696775726174696f6e2d35, 0x7379736f70, 0, 0, 0, 0.172560964941, 0x3230303730313331323030363039, 277, 1);
INSERT INTO `wiki_page` VALUES (278, 8, 0x457869662d636f6d706f6e656e7473636f6e66696775726174696f6e2d36, 0x7379736f70, 0, 0, 0, 0.650616070761, 0x3230303730313331323030363039, 278, 1);
INSERT INTO `wiki_page` VALUES (279, 8, 0x457869662d636f6d7072657373656462697473706572706978656c, 0x7379736f70, 0, 0, 0, 0.642295772123, 0x3230303730313331323030363039, 279, 22);
INSERT INTO `wiki_page` VALUES (280, 8, 0x457869662d636f6d7072657373696f6e, 0x7379736f70, 0, 0, 0, 0.881456703672, 0x3230303730313331323030363039, 280, 18);
INSERT INTO `wiki_page` VALUES (281, 8, 0x457869662d636f6d7072657373696f6e2d31, 0x7379736f70, 0, 0, 0, 0.631682149634, 0x3230303730313331323030363039, 281, 12);
INSERT INTO `wiki_page` VALUES (282, 8, 0x457869662d636f6d7072657373696f6e2d36, 0x7379736f70, 0, 0, 0, 0.75852536632, 0x3230303730313331323030363039, 282, 4);
INSERT INTO `wiki_page` VALUES (283, 8, 0x457869662d636f6e7472617374, 0x7379736f70, 0, 0, 0, 0.362695499259, 0x3230303730313331323030363039, 283, 8);
INSERT INTO `wiki_page` VALUES (284, 8, 0x457869662d636f6e74726173742d30, 0x7379736f70, 0, 0, 0, 0.872796417565, 0x3230303730313331323030363039, 284, 6);
INSERT INTO `wiki_page` VALUES (285, 8, 0x457869662d636f6e74726173742d31, 0x7379736f70, 0, 0, 0, 0.17004622696, 0x3230303730313331323030363039, 285, 4);
INSERT INTO `wiki_page` VALUES (286, 8, 0x457869662d636f6e74726173742d32, 0x7379736f70, 0, 0, 0, 0.955152445675, 0x3230303730313331323030363039, 286, 4);
INSERT INTO `wiki_page` VALUES (287, 8, 0x457869662d636f70797269676874, 0x7379736f70, 0, 0, 0, 0.436534510548, 0x3230303730313331323030363039, 287, 16);
INSERT INTO `wiki_page` VALUES (288, 8, 0x457869662d637573746f6d72656e6465726564, 0x7379736f70, 0, 0, 0, 0.397933762039, 0x3230303730313331323030363039, 288, 23);
INSERT INTO `wiki_page` VALUES (289, 8, 0x457869662d637573746f6d72656e64657265642d30, 0x7379736f70, 0, 0, 0, 0.359756828358, 0x3230303730313331323030363039, 289, 14);
INSERT INTO `wiki_page` VALUES (290, 8, 0x457869662d637573746f6d72656e64657265642d31, 0x7379736f70, 0, 0, 0, 0.948574299515, 0x3230303730313331323030363039, 290, 14);
INSERT INTO `wiki_page` VALUES (291, 8, 0x457869662d6461746574696d65, 0x7379736f70, 0, 0, 0, 0.772959069304, 0x3230303730313331323030363039, 291, 25);
INSERT INTO `wiki_page` VALUES (292, 8, 0x457869662d6461746574696d656469676974697a6564, 0x7379736f70, 0, 0, 0, 0.897095567441, 0x3230303730313331323030363039, 292, 27);
INSERT INTO `wiki_page` VALUES (293, 8, 0x457869662d6461746574696d656f726967696e616c, 0x7379736f70, 0, 0, 0, 0.145263657209, 0x3230303730313331323030363039, 293, 32);
INSERT INTO `wiki_page` VALUES (294, 8, 0x457869662d64657669636573657474696e676465736372697074696f6e, 0x7379736f70, 0, 0, 0, 0.494227178886, 0x3230303730313331323030363039, 294, 27);
INSERT INTO `wiki_page` VALUES (295, 8, 0x457869662d6469676974616c7a6f6f6d726174696f, 0x7379736f70, 0, 0, 0, 0.18778253206, 0x3230303730313331323030363039, 295, 18);
INSERT INTO `wiki_page` VALUES (296, 8, 0x457869662d6578696676657273696f6e, 0x7379736f70, 0, 0, 0, 0.119358270386, 0x3230303730313331323030363039, 296, 12);
INSERT INTO `wiki_page` VALUES (297, 8, 0x457869662d6578706f737572656269617376616c7565, 0x7379736f70, 0, 0, 0, 0.572804006467, 0x3230303730313331323030363039, 297, 13);
INSERT INTO `wiki_page` VALUES (298, 8, 0x457869662d6578706f73757265696e646578, 0x7379736f70, 0, 0, 0, 0.282210502965, 0x3230303730313331323030363039, 298, 14);
INSERT INTO `wiki_page` VALUES (299, 8, 0x457869662d6578706f737572656d6f6465, 0x7379736f70, 0, 0, 0, 0.309924970676, 0x3230303730313331323030363039, 299, 13);
INSERT INTO `wiki_page` VALUES (300, 8, 0x457869662d6578706f737572656d6f64652d30, 0x7379736f70, 0, 0, 0, 0.065222859697, 0x3230303730313331323030363039, 300, 13);
INSERT INTO `wiki_page` VALUES (301, 8, 0x457869662d6578706f737572656d6f64652d31, 0x7379736f70, 0, 0, 0, 0.275031267433, 0x3230303730313331323030363039, 301, 15);
INSERT INTO `wiki_page` VALUES (302, 8, 0x457869662d6578706f737572656d6f64652d32, 0x7379736f70, 0, 0, 0, 0.410290324027, 0x3230303730313331323030363039, 302, 12);
INSERT INTO `wiki_page` VALUES (303, 8, 0x457869662d6578706f7375726570726f6772616d, 0x7379736f70, 0, 0, 0, 0.808915015204, 0x3230303730313331323030363039, 303, 16);
INSERT INTO `wiki_page` VALUES (304, 8, 0x457869662d6578706f7375726570726f6772616d2d30, 0x7379736f70, 0, 0, 0, 0.756556358259, 0x3230303730313331323030363039, 304, 11);
INSERT INTO `wiki_page` VALUES (305, 8, 0x457869662d6578706f7375726570726f6772616d2d31, 0x7379736f70, 0, 0, 0, 0.371049896847, 0x3230303730313331323030363039, 305, 6);
INSERT INTO `wiki_page` VALUES (306, 8, 0x457869662d6578706f7375726570726f6772616d2d32, 0x7379736f70, 0, 0, 0, 0.541903369691, 0x3230303730313331323030363039, 306, 14);
INSERT INTO `wiki_page` VALUES (307, 8, 0x457869662d6578706f7375726570726f6772616d2d33, 0x7379736f70, 0, 0, 0, 0.089766391393, 0x3230303730313331323030363039, 307, 17);
INSERT INTO `wiki_page` VALUES (308, 8, 0x457869662d6578706f7375726570726f6772616d2d34, 0x7379736f70, 0, 0, 0, 0.444518575457, 0x3230303730313331323030363039, 308, 16);
INSERT INTO `wiki_page` VALUES (309, 8, 0x457869662d6578706f7375726570726f6772616d2d35, 0x7379736f70, 0, 0, 0, 0.289361034991, 0x3230303730313331323030363039, 309, 47);
INSERT INTO `wiki_page` VALUES (310, 8, 0x457869662d6578706f7375726570726f6772616d2d36, 0x7379736f70, 0, 0, 0, 0.978883868113, 0x3230303730313331323030363039, 310, 49);
INSERT INTO `wiki_page` VALUES (311, 8, 0x457869662d6578706f7375726570726f6772616d2d37, 0x7379736f70, 0, 0, 0, 0.486961947072, 0x3230303730313331323030363039, 311, 67);
INSERT INTO `wiki_page` VALUES (312, 8, 0x457869662d6578706f7375726570726f6772616d2d38, 0x7379736f70, 0, 0, 0, 0.780336285219, 0x3230303730313331323030363039, 312, 66);
INSERT INTO `wiki_page` VALUES (313, 8, 0x457869662d6578706f7375726574696d65, 0x7379736f70, 0, 0, 0, 0.584808345356, 0x3230303730313331323030363039, 313, 13);
INSERT INTO `wiki_page` VALUES (314, 8, 0x457869662d6578706f7375726574696d652d666f726d6174, 0x7379736f70, 0, 0, 0, 0.056779560249, 0x3230303730313331323030363039, 314, 11);
INSERT INTO `wiki_page` VALUES (315, 8, 0x457869662d66696c65736f75726365, 0x7379736f70, 0, 0, 0, 0.442385128837, 0x3230303730313331323030363039, 315, 11);
INSERT INTO `wiki_page` VALUES (316, 8, 0x457869662d66696c65736f757263652d33, 0x7379736f70, 0, 0, 0, 0.399041962255, 0x3230303730313331323030363039, 316, 3);
INSERT INTO `wiki_page` VALUES (317, 8, 0x457869662d666c617368, 0x7379736f70, 0, 0, 0, 0.387214006951, 0x3230303730313331323030363039, 317, 5);
INSERT INTO `wiki_page` VALUES (318, 8, 0x457869662d666c617368656e65726779, 0x7379736f70, 0, 0, 0, 0.980228170089, 0x3230303730313331323030363039, 318, 12);
INSERT INTO `wiki_page` VALUES (319, 8, 0x457869662d666c61736870697876657273696f6e, 0x7379736f70, 0, 0, 0, 0.526595443965, 0x3230303730313331323030363039, 319, 26);
INSERT INTO `wiki_page` VALUES (320, 8, 0x457869662d666e756d626572, 0x7379736f70, 0, 0, 0, 0.472846064139, 0x3230303730313331323030363039, 320, 8);
INSERT INTO `wiki_page` VALUES (321, 8, 0x457869662d666e756d6265722d666f726d6174, 0x7379736f70, 0, 0, 0, 0.629448799322, 0x3230303730313331323030363039, 321, 4);
INSERT INTO `wiki_page` VALUES (322, 8, 0x457869662d666f63616c6c656e677468, 0x7379736f70, 0, 0, 0, 0.668222515107, 0x3230303730313331323030363039, 322, 17);
INSERT INTO `wiki_page` VALUES (323, 8, 0x457869662d666f63616c6c656e6774682d666f726d6174, 0x7379736f70, 0, 0, 0, 0.517157451465, 0x3230303730313331323030363039, 323, 5);
INSERT INTO `wiki_page` VALUES (324, 8, 0x457869662d666f63616c6c656e677468696e33356d6d66696c6d, 0x7379736f70, 0, 0, 0, 0.215611173991, 0x3230303730313331323030363039, 324, 26);
INSERT INTO `wiki_page` VALUES (325, 8, 0x457869662d666f63616c706c616e657265736f6c7574696f6e756e6974, 0x7379736f70, 0, 0, 0, 0.128844293052, 0x3230303730313331323030363039, 325, 27);
INSERT INTO `wiki_page` VALUES (326, 8, 0x457869662d666f63616c706c616e657265736f6c7574696f6e756e69742d32, 0x7379736f70, 0, 0, 0, 0.930116229475, 0x3230303730313331323030363039, 326, 6);
INSERT INTO `wiki_page` VALUES (327, 8, 0x457869662d666f63616c706c616e65787265736f6c7574696f6e, 0x7379736f70, 0, 0, 0, 0.757552098157, 0x3230303730313331323030363039, 327, 24);
INSERT INTO `wiki_page` VALUES (328, 8, 0x457869662d666f63616c706c616e65797265736f6c7574696f6e, 0x7379736f70, 0, 0, 0, 0.135893651375, 0x3230303730313331323030363039, 328, 24);
INSERT INTO `wiki_page` VALUES (329, 8, 0x457869662d6761696e636f6e74726f6c, 0x7379736f70, 0, 0, 0, 0.166586645499, 0x3230303730313331323030363039, 329, 13);
INSERT INTO `wiki_page` VALUES (330, 8, 0x457869662d6761696e636f6e74726f6c2d30, 0x7379736f70, 0, 0, 0, 0.427022510189, 0x3230303730313331323030363039, 330, 4);
INSERT INTO `wiki_page` VALUES (331, 8, 0x457869662d6761696e636f6e74726f6c2d31, 0x7379736f70, 0, 0, 0, 0.05237260462, 0x3230303730313331323030363039, 331, 11);
INSERT INTO `wiki_page` VALUES (332, 8, 0x457869662d6761696e636f6e74726f6c2d32, 0x7379736f70, 0, 0, 0, 0.808869352129, 0x3230303730313331323030363039, 332, 12);
INSERT INTO `wiki_page` VALUES (333, 8, 0x457869662d6761696e636f6e74726f6c2d33, 0x7379736f70, 0, 0, 0, 0.931921990571, 0x3230303730313331323030363039, 333, 13);
INSERT INTO `wiki_page` VALUES (334, 8, 0x457869662d6761696e636f6e74726f6c2d34, 0x7379736f70, 0, 0, 0, 0.426695657421, 0x3230303730313331323030363039, 334, 14);
INSERT INTO `wiki_page` VALUES (335, 8, 0x457869662d677073616c746974756465, 0x7379736f70, 0, 0, 0, 0.170516985593, 0x3230303730313331323030363039, 335, 8);
INSERT INTO `wiki_page` VALUES (336, 8, 0x457869662d677073616c746974756465726566, 0x7379736f70, 0, 0, 0, 0.065088205213, 0x3230303730313331323030363039, 336, 18);
INSERT INTO `wiki_page` VALUES (337, 8, 0x457869662d67707361726561696e666f726d6174696f6e, 0x7379736f70, 0, 0, 0, 0.816387897055, 0x3230303730313331323030363039, 337, 16);
INSERT INTO `wiki_page` VALUES (338, 8, 0x457869662d677073646174657374616d70, 0x7379736f70, 0, 0, 0, 0.991611736491, 0x3230303730313331323030363039, 338, 8);
INSERT INTO `wiki_page` VALUES (339, 8, 0x457869662d6770736465737462656172696e67, 0x7379736f70, 0, 0, 0, 0.119892472115, 0x3230303730313331323030363039, 339, 22);
INSERT INTO `wiki_page` VALUES (340, 8, 0x457869662d6770736465737462656172696e67726566, 0x7379736f70, 0, 0, 0, 0.199844897485, 0x3230303730313331323030363039, 340, 36);
INSERT INTO `wiki_page` VALUES (341, 8, 0x457869662d6770736465737464697374616e6365, 0x7379736f70, 0, 0, 0, 0.233768373434, 0x3230303730313331323030363039, 341, 23);
INSERT INTO `wiki_page` VALUES (342, 8, 0x457869662d6770736465737464697374616e6365726566, 0x7379736f70, 0, 0, 0, 0.359904177554, 0x3230303730313331323030363039, 342, 37);
INSERT INTO `wiki_page` VALUES (343, 8, 0x457869662d677073646573746c61746974756465, 0x7379736f70, 0, 0, 0, 0.63573611218, 0x3230303730313331323030363039, 343, 20);
INSERT INTO `wiki_page` VALUES (344, 8, 0x457869662d677073646573746c61746974756465726566, 0x7379736f70, 0, 0, 0, 0.450173319636, 0x3230303730313331323030363039, 344, 37);
INSERT INTO `wiki_page` VALUES (345, 8, 0x457869662d677073646573746c6f6e676974756465, 0x7379736f70, 0, 0, 0, 0.878206388231, 0x3230303730313331323030363039, 345, 24);
INSERT INTO `wiki_page` VALUES (346, 8, 0x457869662d677073646573746c6f6e676974756465726566, 0x7379736f70, 0, 0, 0, 0.396709794805, 0x3230303730313331323030363039, 346, 38);
INSERT INTO `wiki_page` VALUES (347, 8, 0x457869662d677073646966666572656e7469616c, 0x7379736f70, 0, 0, 0, 0.765764365784, 0x3230303730313331323030363039, 347, 27);
INSERT INTO `wiki_page` VALUES (348, 8, 0x457869662d677073646972656374696f6e2d6d, 0x7379736f70, 0, 0, 0, 0.273771008503, 0x3230303730313331323030363039, 348, 18);
INSERT INTO `wiki_page` VALUES (349, 8, 0x457869662d677073646972656374696f6e2d74, 0x7379736f70, 0, 0, 0, 0.035362977356, 0x3230303730313331323030363039, 349, 14);
INSERT INTO `wiki_page` VALUES (350, 8, 0x457869662d677073646f70, 0x7379736f70, 0, 0, 0, 0.939551739473, 0x3230303730313331323030363130, 350, 21);
INSERT INTO `wiki_page` VALUES (351, 8, 0x457869662d677073696d67646972656374696f6e, 0x7379736f70, 0, 0, 0, 0.390349810457, 0x3230303730313331323030363130, 351, 18);
INSERT INTO `wiki_page` VALUES (352, 8, 0x457869662d677073696d67646972656374696f6e726566, 0x7379736f70, 0, 0, 0, 0.863763928132, 0x3230303730313331323030363130, 352, 32);
INSERT INTO `wiki_page` VALUES (353, 8, 0x457869662d6770736c61746974756465, 0x7379736f70, 0, 0, 0, 0.085850831665, 0x3230303730313331323030363130, 353, 8);
INSERT INTO `wiki_page` VALUES (354, 8, 0x457869662d6770736c617469747564652d6e, 0x7379736f70, 0, 0, 0, 0.217837884814, 0x3230303730313331323030363130, 354, 14);
INSERT INTO `wiki_page` VALUES (355, 8, 0x457869662d6770736c617469747564652d73, 0x7379736f70, 0, 0, 0, 0.927545440847, 0x3230303730313331323030363130, 355, 14);
INSERT INTO `wiki_page` VALUES (356, 8, 0x457869662d6770736c61746974756465726566, 0x7379736f70, 0, 0, 0, 0.532917933732, 0x3230303730313331323030363130, 356, 23);
INSERT INTO `wiki_page` VALUES (357, 8, 0x457869662d6770736c6f6e676974756465, 0x7379736f70, 0, 0, 0, 0.420821470488, 0x3230303730313331323030363130, 357, 9);
INSERT INTO `wiki_page` VALUES (358, 8, 0x457869662d6770736c6f6e6769747564652d65, 0x7379736f70, 0, 0, 0, 0.483272129395, 0x3230303730313331323030363130, 358, 14);
INSERT INTO `wiki_page` VALUES (359, 8, 0x457869662d6770736c6f6e6769747564652d77, 0x7379736f70, 0, 0, 0, 0.45099468358, 0x3230303730313331323030363130, 359, 14);
INSERT INTO `wiki_page` VALUES (360, 8, 0x457869662d6770736c6f6e676974756465726566, 0x7379736f70, 0, 0, 0, 0.491040383018, 0x3230303730313331323030363130, 360, 22);
INSERT INTO `wiki_page` VALUES (361, 8, 0x457869662d6770736d6170646174756d, 0x7379736f70, 0, 0, 0, 0.282757803487, 0x3230303730313331323030363130, 361, 25);
INSERT INTO `wiki_page` VALUES (362, 8, 0x457869662d6770736d6561737572656d6f6465, 0x7379736f70, 0, 0, 0, 0.232057705359, 0x3230303730313331323030363130, 362, 16);
INSERT INTO `wiki_page` VALUES (363, 8, 0x457869662d6770736d6561737572656d6f64652d32, 0x7379736f70, 0, 0, 0, 0.098490373545, 0x3230303730313331323030363130, 363, 25);
INSERT INTO `wiki_page` VALUES (364, 8, 0x457869662d6770736d6561737572656d6f64652d33, 0x7379736f70, 0, 0, 0, 0.166957958682, 0x3230303730313331323030363130, 364, 25);
INSERT INTO `wiki_page` VALUES (365, 8, 0x457869662d67707370726f63657373696e676d6574686f64, 0x7379736f70, 0, 0, 0, 0.298312618812, 0x3230303730313331323030363130, 365, 29);
INSERT INTO `wiki_page` VALUES (366, 8, 0x457869662d677073736174656c6c69746573, 0x7379736f70, 0, 0, 0, 0.073661954584, 0x3230303730313331323030363130, 366, 31);
INSERT INTO `wiki_page` VALUES (367, 8, 0x457869662d6770737370656564, 0x7379736f70, 0, 0, 0, 0.497462812903, 0x3230303730313331323030363130, 367, 21);
INSERT INTO `wiki_page` VALUES (368, 8, 0x457869662d67707373706565642d6b, 0x7379736f70, 0, 0, 0, 0.979953449602, 0x3230303730313331323030363130, 368, 19);
INSERT INTO `wiki_page` VALUES (369, 8, 0x457869662d67707373706565642d6d, 0x7379736f70, 0, 0, 0, 0.155152020794, 0x3230303730313331323030363130, 369, 14);
INSERT INTO `wiki_page` VALUES (370, 8, 0x457869662d67707373706565642d6e, 0x7379736f70, 0, 0, 0, 0.51295822397, 0x3230303730313331323030363130, 370, 5);
INSERT INTO `wiki_page` VALUES (371, 8, 0x457869662d6770737370656564726566, 0x7379736f70, 0, 0, 0, 0.818459104932, 0x3230303730313331323030363130, 371, 10);
INSERT INTO `wiki_page` VALUES (372, 8, 0x457869662d677073737461747573, 0x7379736f70, 0, 0, 0, 0.656608630932, 0x3230303730313331323030363130, 372, 15);
INSERT INTO `wiki_page` VALUES (373, 8, 0x457869662d6770737374617475732d61, 0x7379736f70, 0, 0, 0, 0.178750008392, 0x3230303730313331323030363130, 373, 23);
INSERT INTO `wiki_page` VALUES (374, 8, 0x457869662d6770737374617475732d76, 0x7379736f70, 0, 0, 0, 0.437061144321, 0x3230303730313331323030363130, 374, 28);
INSERT INTO `wiki_page` VALUES (375, 8, 0x457869662d67707374696d657374616d70, 0x7379736f70, 0, 0, 0, 0.886752967223, 0x3230303730313331323030363130, 375, 23);
INSERT INTO `wiki_page` VALUES (376, 8, 0x457869662d677073747261636b, 0x7379736f70, 0, 0, 0, 0.623107244257, 0x3230303730313331323030363130, 376, 21);
INSERT INTO `wiki_page` VALUES (377, 8, 0x457869662d677073747261636b726566, 0x7379736f70, 0, 0, 0, 0.368508394448, 0x3230303730313331323030363130, 377, 35);
INSERT INTO `wiki_page` VALUES (378, 8, 0x457869662d67707376657273696f6e6964, 0x7379736f70, 0, 0, 0, 0.706483325069, 0x3230303730313331323030363130, 378, 15);
INSERT INTO `wiki_page` VALUES (379, 8, 0x457869662d696d6167656465736372697074696f6e, 0x7379736f70, 0, 0, 0, 0.315106441223, 0x3230303730313331323030363130, 379, 11);
INSERT INTO `wiki_page` VALUES (380, 8, 0x457869662d696d6167656c656e677468, 0x7379736f70, 0, 0, 0, 0.935756171321, 0x3230303730313331323030363130, 380, 6);
INSERT INTO `wiki_page` VALUES (381, 8, 0x457869662d696d616765756e697175656964, 0x7379736f70, 0, 0, 0, 0.851470757457, 0x3230303730313331323030363130, 381, 15);
INSERT INTO `wiki_page` VALUES (382, 8, 0x457869662d696d6167657769647468, 0x7379736f70, 0, 0, 0, 0.525451091421, 0x3230303730313331323030363130, 382, 5);
INSERT INTO `wiki_page` VALUES (383, 8, 0x457869662d69736f7370656564726174696e6773, 0x7379736f70, 0, 0, 0, 0.981005469059, 0x3230303730313331323030363130, 383, 16);
INSERT INTO `wiki_page` VALUES (384, 8, 0x457869662d6a706567696e7465726368616e6765666f726d6174, 0x7379736f70, 0, 0, 0, 0.561053404179, 0x3230303730313331323030363130, 384, 18);
INSERT INTO `wiki_page` VALUES (385, 8, 0x457869662d6a706567696e7465726368616e6765666f726d61746c656e677468, 0x7379736f70, 0, 0, 0, 0.834006538236, 0x3230303730313331323030363130, 385, 18);
INSERT INTO `wiki_page` VALUES (386, 8, 0x457869662d6c69676874736f75726365, 0x7379736f70, 0, 0, 0, 0.530780286158, 0x3230303730313331323030363130, 386, 12);
INSERT INTO `wiki_page` VALUES (387, 8, 0x457869662d6c69676874736f757263652d30, 0x7379736f70, 0, 0, 0, 0.585003480387, 0x3230303730313331323030363130, 387, 7);
INSERT INTO `wiki_page` VALUES (388, 8, 0x457869662d6c69676874736f757263652d31, 0x7379736f70, 0, 0, 0, 0.047479978342, 0x3230303730313331323030363130, 388, 8);
INSERT INTO `wiki_page` VALUES (389, 8, 0x457869662d6c69676874736f757263652d3130, 0x7379736f70, 0, 0, 0, 0.869520845507, 0x3230303730313331323030363130, 389, 14);
INSERT INTO `wiki_page` VALUES (390, 8, 0x457869662d6c69676874736f757263652d3131, 0x7379736f70, 0, 0, 0, 0.412456938688, 0x3230303730313331323030363130, 390, 5);
INSERT INTO `wiki_page` VALUES (391, 8, 0x457869662d6c69676874736f757263652d3132, 0x7379736f70, 0, 0, 0, 0.868554096821, 0x3230303730313331323030363130, 391, 39);
INSERT INTO `wiki_page` VALUES (392, 8, 0x457869662d6c69676874736f757263652d3133, 0x7379736f70, 0, 0, 0, 0.335581522798, 0x3230303730313331323030363130, 392, 40);
INSERT INTO `wiki_page` VALUES (393, 8, 0x457869662d6c69676874736f757263652d3134, 0x7379736f70, 0, 0, 0, 0.963146909948, 0x3230303730313331323030363130, 393, 41);
INSERT INTO `wiki_page` VALUES (394, 8, 0x457869662d6c69676874736f757263652d3135, 0x7379736f70, 0, 0, 0, 0.72629170827, 0x3230303730313331323030363130, 394, 37);
INSERT INTO `wiki_page` VALUES (395, 8, 0x457869662d6c69676874736f757263652d3137, 0x7379736f70, 0, 0, 0, 0.331975929201, 0x3230303730313331323030363130, 395, 16);
INSERT INTO `wiki_page` VALUES (396, 8, 0x457869662d6c69676874736f757263652d3138, 0x7379736f70, 0, 0, 0, 0.408240927682, 0x3230303730313331323030363130, 396, 16);
INSERT INTO `wiki_page` VALUES (397, 8, 0x457869662d6c69676874736f757263652d3139, 0x7379736f70, 0, 0, 0, 0.898364597983, 0x3230303730313331323030363130, 397, 16);
INSERT INTO `wiki_page` VALUES (398, 8, 0x457869662d6c69676874736f757263652d32, 0x7379736f70, 0, 0, 0, 0.389976485678, 0x3230303730313331323030363130, 398, 11);
INSERT INTO `wiki_page` VALUES (399, 8, 0x457869662d6c69676874736f757263652d3230, 0x7379736f70, 0, 0, 0, 0.590769584311, 0x3230303730313331323030363130, 399, 3);
INSERT INTO `wiki_page` VALUES (400, 8, 0x457869662d6c69676874736f757263652d3231, 0x7379736f70, 0, 0, 0, 0.912994240449, 0x3230303730313331323030363130, 400, 3);
INSERT INTO `wiki_page` VALUES (401, 8, 0x457869662d6c69676874736f757263652d3232, 0x7379736f70, 0, 0, 0, 0.266287806794, 0x3230303730313331323030363130, 401, 3);
INSERT INTO `wiki_page` VALUES (402, 8, 0x457869662d6c69676874736f757263652d3233, 0x7379736f70, 0, 0, 0, 0.883468780886, 0x3230303730313331323030363130, 402, 3);
INSERT INTO `wiki_page` VALUES (403, 8, 0x457869662d6c69676874736f757263652d3234, 0x7379736f70, 0, 0, 0, 0.769735353221, 0x3230303730313331323030363130, 403, 19);
INSERT INTO `wiki_page` VALUES (404, 8, 0x457869662d6c69676874736f757263652d323535, 0x7379736f70, 0, 0, 0, 0.66262273102, 0x3230303730313331323030363130, 404, 18);
INSERT INTO `wiki_page` VALUES (405, 8, 0x457869662d6c69676874736f757263652d33, 0x7379736f70, 0, 0, 0, 0.9876759873, 0x3230303730313331323030363130, 405, 29);
INSERT INTO `wiki_page` VALUES (406, 8, 0x457869662d6c69676874736f757263652d34, 0x7379736f70, 0, 0, 0, 0.826704671174, 0x3230303730313331323030363130, 406, 5);
INSERT INTO `wiki_page` VALUES (407, 8, 0x457869662d6c69676874736f757263652d39, 0x7379736f70, 0, 0, 0, 0.606449450163, 0x3230303730313331323030363130, 407, 12);
INSERT INTO `wiki_page` VALUES (408, 8, 0x457869662d6d616b65, 0x7379736f70, 0, 0, 0, 0.469287320345, 0x3230303730313331323030363130, 408, 19);
INSERT INTO `wiki_page` VALUES (409, 8, 0x457869662d6d616b652d76616c7565, 0x7379736f70, 0, 0, 0, 0.5831150043, 0x3230303730313331323030363130, 409, 2);
INSERT INTO `wiki_page` VALUES (410, 8, 0x457869662d6d616b65726e6f7465, 0x7379736f70, 0, 0, 0, 0.191192975487, 0x3230303730313331323030363130, 410, 18);
INSERT INTO `wiki_page` VALUES (411, 8, 0x457869662d6d6178617065727475726576616c7565, 0x7379736f70, 0, 0, 0, 0.261742626814, 0x3230303730313331323030363130, 411, 21);
INSERT INTO `wiki_page` VALUES (412, 8, 0x457869662d6d65746572696e676d6f6465, 0x7379736f70, 0, 0, 0, 0.057399331096, 0x3230303730313331323030363130, 412, 13);
INSERT INTO `wiki_page` VALUES (413, 8, 0x457869662d6d65746572696e676d6f64652d30, 0x7379736f70, 0, 0, 0, 0.9114924083, 0x3230303730313331323030363130, 413, 7);
INSERT INTO `wiki_page` VALUES (414, 8, 0x457869662d6d65746572696e676d6f64652d31, 0x7379736f70, 0, 0, 0, 0.159343262965, 0x3230303730313331323030363130, 414, 7);
INSERT INTO `wiki_page` VALUES (415, 8, 0x457869662d6d65746572696e676d6f64652d32, 0x7379736f70, 0, 0, 0, 0.051681821905, 0x3230303730313331323030363130, 415, 21);
INSERT INTO `wiki_page` VALUES (416, 8, 0x457869662d6d65746572696e676d6f64652d323535, 0x7379736f70, 0, 0, 0, 0.339557298676, 0x3230303730313331323030363130, 416, 5);
INSERT INTO `wiki_page` VALUES (417, 8, 0x457869662d6d65746572696e676d6f64652d33, 0x7379736f70, 0, 0, 0, 0.844436624971, 0x3230303730313331323030363130, 417, 4);
INSERT INTO `wiki_page` VALUES (418, 8, 0x457869662d6d65746572696e676d6f64652d34, 0x7379736f70, 0, 0, 0, 0.545165129976, 0x3230303730313331323030363130, 418, 9);
INSERT INTO `wiki_page` VALUES (419, 8, 0x457869662d6d65746572696e676d6f64652d35, 0x7379736f70, 0, 0, 0, 0.878788490563, 0x3230303730313331323030363130, 419, 7);
INSERT INTO `wiki_page` VALUES (420, 8, 0x457869662d6d65746572696e676d6f64652d36, 0x7379736f70, 0, 0, 0, 0.330442770155, 0x3230303730313331323030363130, 420, 7);
INSERT INTO `wiki_page` VALUES (421, 8, 0x457869662d6d6f64656c, 0x7379736f70, 0, 0, 0, 0.168957800776, 0x3230303730313331323030363130, 421, 12);
INSERT INTO `wiki_page` VALUES (422, 8, 0x457869662d6d6f64656c2d76616c7565, 0x7379736f70, 0, 0, 0, 0.069736685669, 0x3230303730313331323030363130, 422, 2);
INSERT INTO `wiki_page` VALUES (423, 8, 0x457869662d6f656366, 0x7379736f70, 0, 0, 0, 0.847620817868, 0x3230303730313331323030363130, 423, 32);
INSERT INTO `wiki_page` VALUES (424, 8, 0x457869662d6f7269656e746174696f6e, 0x7379736f70, 0, 0, 0, 0.286339820261, 0x3230303730313331323030363130, 424, 11);
INSERT INTO `wiki_page` VALUES (425, 8, 0x457869662d6f7269656e746174696f6e2d31, 0x7379736f70, 0, 0, 0, 0.561540046034, 0x3230303730313331323030363131, 425, 6);
INSERT INTO `wiki_page` VALUES (426, 8, 0x457869662d6f7269656e746174696f6e2d32, 0x7379736f70, 0, 0, 0, 0.37588080632, 0x3230303730313331323030363131, 426, 20);
INSERT INTO `wiki_page` VALUES (427, 8, 0x457869662d6f7269656e746174696f6e2d33, 0x7379736f70, 0, 0, 0, 0.83020120335, 0x3230303730313331323030363131, 427, 13);
INSERT INTO `wiki_page` VALUES (428, 8, 0x457869662d6f7269656e746174696f6e2d34, 0x7379736f70, 0, 0, 0, 0.219030528585, 0x3230303730313331323030363131, 428, 18);
INSERT INTO `wiki_page` VALUES (429, 8, 0x457869662d6f7269656e746174696f6e2d35, 0x7379736f70, 0, 0, 0, 0.740697221599, 0x3230303730313331323030363131, 429, 39);
INSERT INTO `wiki_page` VALUES (430, 8, 0x457869662d6f7269656e746174696f6e2d36, 0x7379736f70, 0, 0, 0, 0.802801334312, 0x3230303730313331323030363131, 430, 15);
INSERT INTO `wiki_page` VALUES (431, 8, 0x457869662d6f7269656e746174696f6e2d37, 0x7379736f70, 0, 0, 0, 0.493684523963, 0x3230303730313331323030363131, 431, 38);
INSERT INTO `wiki_page` VALUES (432, 8, 0x457869662d6f7269656e746174696f6e2d38, 0x7379736f70, 0, 0, 0, 0.930481987452, 0x3230303730313331323030363131, 432, 16);
INSERT INTO `wiki_page` VALUES (433, 8, 0x457869662d70686f746f6d6574726963696e746572707265746174696f6e, 0x7379736f70, 0, 0, 0, 0.879759640047, 0x3230303730313331323030363131, 433, 17);
INSERT INTO `wiki_page` VALUES (434, 8, 0x457869662d70686f746f6d6574726963696e746572707265746174696f6e2d32, 0x7379736f70, 0, 0, 0, 0.153623869907, 0x3230303730313331323030363131, 434, 3);
INSERT INTO `wiki_page` VALUES (435, 8, 0x457869662d70686f746f6d6574726963696e746572707265746174696f6e2d36, 0x7379736f70, 0, 0, 0, 0.021164873821, 0x3230303730313331323030363131, 435, 5);
INSERT INTO `wiki_page` VALUES (436, 8, 0x457869662d706978656c7864696d656e73696f6e, 0x7379736f70, 0, 0, 0, 0.539283593759, 0x3230303730313331323030363131, 436, 19);
INSERT INTO `wiki_page` VALUES (437, 8, 0x457869662d706978656c7964696d656e73696f6e, 0x7379736f70, 0, 0, 0, 0.294117841503, 0x3230303730313331323030363131, 437, 17);
INSERT INTO `wiki_page` VALUES (438, 8, 0x457869662d706c616e6172636f6e66696775726174696f6e, 0x7379736f70, 0, 0, 0, 0.17910773966, 0x3230303730313331323030363131, 438, 16);
INSERT INTO `wiki_page` VALUES (439, 8, 0x457869662d706c616e6172636f6e66696775726174696f6e2d31, 0x7379736f70, 0, 0, 0, 0.663285794834, 0x3230303730313331323030363131, 439, 13);
INSERT INTO `wiki_page` VALUES (440, 8, 0x457869662d706c616e6172636f6e66696775726174696f6e2d32, 0x7379736f70, 0, 0, 0, 0.120084724347, 0x3230303730313331323030363131, 440, 13);
INSERT INTO `wiki_page` VALUES (441, 8, 0x457869662d7072696d6172796368726f6d617469636974696573, 0x7379736f70, 0, 0, 0, 0.691558824132, 0x3230303730313331323030363131, 441, 29);
INSERT INTO `wiki_page` VALUES (442, 8, 0x457869662d7265666572656e6365626c61636b7768697465, 0x7379736f70, 0, 0, 0, 0.820988944426, 0x3230303730313331323030363131, 442, 40);
INSERT INTO `wiki_page` VALUES (443, 8, 0x457869662d72656c61746564736f756e6466696c65, 0x7379736f70, 0, 0, 0, 0.808875168888, 0x3230303730313331323030363131, 443, 18);
INSERT INTO `wiki_page` VALUES (444, 8, 0x457869662d7265736f6c7574696f6e756e6974, 0x7379736f70, 0, 0, 0, 0.783066955332, 0x3230303730313331323030363131, 444, 26);
INSERT INTO `wiki_page` VALUES (445, 8, 0x457869662d726f77737065727374726970, 0x7379736f70, 0, 0, 0, 0.271466733204, 0x3230303730313331323030363131, 445, 24);
INSERT INTO `wiki_page` VALUES (446, 8, 0x457869662d73616d706c6573706572706978656c, 0x7379736f70, 0, 0, 0, 0.320580158978, 0x3230303730313331323030363131, 446, 20);
INSERT INTO `wiki_page` VALUES (447, 8, 0x457869662d73617475726174696f6e, 0x7379736f70, 0, 0, 0, 0.898112053193, 0x3230303730313331323030363131, 447, 10);
INSERT INTO `wiki_page` VALUES (448, 8, 0x457869662d73617475726174696f6e2d30, 0x7379736f70, 0, 0, 0, 0.24411545863, 0x3230303730313331323030363131, 448, 6);
INSERT INTO `wiki_page` VALUES (449, 8, 0x457869662d73617475726174696f6e2d31, 0x7379736f70, 0, 0, 0, 0.722087671748, 0x3230303730313331323030363131, 449, 14);
INSERT INTO `wiki_page` VALUES (450, 8, 0x457869662d73617475726174696f6e2d32, 0x7379736f70, 0, 0, 0, 0.073876082845, 0x3230303730313331323030363131, 450, 15);
INSERT INTO `wiki_page` VALUES (451, 8, 0x457869662d7363656e656361707475726574797065, 0x7379736f70, 0, 0, 0, 0.402140130335, 0x3230303730313331323030363131, 451, 18);
INSERT INTO `wiki_page` VALUES (452, 8, 0x457869662d7363656e6563617074757265747970652d30, 0x7379736f70, 0, 0, 0, 0.189347987793, 0x3230303730313331323030363131, 452, 8);
INSERT INTO `wiki_page` VALUES (453, 8, 0x457869662d7363656e6563617074757265747970652d31, 0x7379736f70, 0, 0, 0, 0.890550533006, 0x3230303730313331323030363131, 453, 9);
INSERT INTO `wiki_page` VALUES (454, 8, 0x457869662d7363656e6563617074757265747970652d32, 0x7379736f70, 0, 0, 0, 0.296009134989, 0x3230303730313331323030363131, 454, 8);
INSERT INTO `wiki_page` VALUES (455, 8, 0x457869662d7363656e6563617074757265747970652d33, 0x7379736f70, 0, 0, 0, 0.380377651046, 0x3230303730313331323030363131, 455, 11);
INSERT INTO `wiki_page` VALUES (456, 8, 0x457869662d7363656e6574797065, 0x7379736f70, 0, 0, 0, 0.161643976433, 0x3230303730313331323030363131, 456, 10);
INSERT INTO `wiki_page` VALUES (457, 8, 0x457869662d7363656e65747970652d31, 0x7379736f70, 0, 0, 0, 0.176244482749, 0x3230303730313331323030363131, 457, 29);
INSERT INTO `wiki_page` VALUES (458, 8, 0x457869662d73656e73696e676d6574686f64, 0x7379736f70, 0, 0, 0, 0.465699040574, 0x3230303730313331323030363131, 458, 14);
INSERT INTO `wiki_page` VALUES (459, 8, 0x457869662d73656e73696e676d6574686f642d31, 0x7379736f70, 0, 0, 0, 0.919449686433, 0x3230303730313331323030363131, 459, 9);
INSERT INTO `wiki_page` VALUES (460, 8, 0x457869662d73656e73696e676d6574686f642d32, 0x7379736f70, 0, 0, 0, 0.893106622424, 0x3230303730313331323030363131, 460, 26);
INSERT INTO `wiki_page` VALUES (461, 8, 0x457869662d73656e73696e676d6574686f642d33, 0x7379736f70, 0, 0, 0, 0.309347839008, 0x3230303730313331323030363131, 461, 26);
INSERT INTO `wiki_page` VALUES (462, 8, 0x457869662d73656e73696e676d6574686f642d34, 0x7379736f70, 0, 0, 0, 0.587359339893, 0x3230303730313331323030363131, 462, 28);
INSERT INTO `wiki_page` VALUES (463, 8, 0x457869662d73656e73696e676d6574686f642d35, 0x7379736f70, 0, 0, 0, 0.784722355371, 0x3230303730313331323030363131, 463, 28);
INSERT INTO `wiki_page` VALUES (464, 8, 0x457869662d73656e73696e676d6574686f642d37, 0x7379736f70, 0, 0, 0, 0.482701776759, 0x3230303730313331323030363131, 464, 16);
INSERT INTO `wiki_page` VALUES (465, 8, 0x457869662d73656e73696e676d6574686f642d38, 0x7379736f70, 0, 0, 0, 0.369217049358, 0x3230303730313331323030363131, 465, 30);
INSERT INTO `wiki_page` VALUES (466, 8, 0x457869662d73686172706e657373, 0x7379736f70, 0, 0, 0, 0.473628177395, 0x3230303730313331323030363131, 466, 9);
INSERT INTO `wiki_page` VALUES (467, 8, 0x457869662d73686172706e6573732d30, 0x7379736f70, 0, 0, 0, 0.178802998652, 0x3230303730313331323030363131, 467, 6);
INSERT INTO `wiki_page` VALUES (468, 8, 0x457869662d73686172706e6573732d31, 0x7379736f70, 0, 0, 0, 0.906307363135, 0x3230303730313331323030363131, 468, 4);
INSERT INTO `wiki_page` VALUES (469, 8, 0x457869662d73686172706e6573732d32, 0x7379736f70, 0, 0, 0, 0.690677486034, 0x3230303730313331323030363131, 469, 4);
INSERT INTO `wiki_page` VALUES (470, 8, 0x457869662d73687574746572737065656476616c7565, 0x7379736f70, 0, 0, 0, 0.490679557526, 0x3230303730313331323030363131, 470, 13);
INSERT INTO `wiki_page` VALUES (471, 8, 0x457869662d736f667477617265, 0x7379736f70, 0, 0, 0, 0.18171585229, 0x3230303730313331323030363131, 471, 13);
INSERT INTO `wiki_page` VALUES (472, 8, 0x457869662d736f6674776172652d76616c7565, 0x7379736f70, 0, 0, 0, 0.246035629562, 0x3230303730313331323030363131, 472, 2);
INSERT INTO `wiki_page` VALUES (473, 8, 0x457869662d7370617469616c6672657175656e6379726573706f6e7365, 0x7379736f70, 0, 0, 0, 0.125794712931, 0x3230303730313331323030363131, 473, 26);
INSERT INTO `wiki_page` VALUES (474, 8, 0x457869662d737065637472616c73656e7369746976697479, 0x7379736f70, 0, 0, 0, 0.349707022139, 0x3230303730313331323030363131, 474, 20);
INSERT INTO `wiki_page` VALUES (475, 8, 0x457869662d737472697062797465636f756e7473, 0x7379736f70, 0, 0, 0, 0.557703844996, 0x3230303730313331323030363131, 475, 26);
INSERT INTO `wiki_page` VALUES (476, 8, 0x457869662d73747269706f666673657473, 0x7379736f70, 0, 0, 0, 0.633717609405, 0x3230303730313331323030363131, 476, 19);
INSERT INTO `wiki_page` VALUES (477, 8, 0x457869662d7375626a65637461726561, 0x7379736f70, 0, 0, 0, 0.170364481264, 0x3230303730313331323030363131, 477, 12);
INSERT INTO `wiki_page` VALUES (478, 8, 0x457869662d7375626a65637464697374616e6365, 0x7379736f70, 0, 0, 0, 0.89280096073, 0x3230303730313331323030363131, 478, 16);
INSERT INTO `wiki_page` VALUES (479, 8, 0x457869662d7375626a65637464697374616e63652d76616c7565, 0x7379736f70, 0, 0, 0, 0.843116457972, 0x3230303730313331323030363131, 479, 9);
INSERT INTO `wiki_page` VALUES (480, 8, 0x457869662d7375626a65637464697374616e636572616e6765, 0x7379736f70, 0, 0, 0, 0.765540704425, 0x3230303730313331323030363131, 480, 22);
INSERT INTO `wiki_page` VALUES (481, 8, 0x457869662d7375626a65637464697374616e636572616e67652d30, 0x7379736f70, 0, 0, 0, 0.444311846885, 0x3230303730313331323030363131, 481, 7);
INSERT INTO `wiki_page` VALUES (482, 8, 0x457869662d7375626a65637464697374616e636572616e67652d31, 0x7379736f70, 0, 0, 0, 0.910029765781, 0x3230303730313331323030363131, 482, 5);
INSERT INTO `wiki_page` VALUES (483, 8, 0x457869662d7375626a65637464697374616e636572616e67652d32, 0x7379736f70, 0, 0, 0, 0.654085942682, 0x3230303730313331323030363131, 483, 10);
INSERT INTO `wiki_page` VALUES (484, 8, 0x457869662d7375626a65637464697374616e636572616e67652d33, 0x7379736f70, 0, 0, 0, 0.232656738384, 0x3230303730313331323030363131, 484, 12);
INSERT INTO `wiki_page` VALUES (485, 8, 0x457869662d7375626a6563746c6f636174696f6e, 0x7379736f70, 0, 0, 0, 0.064544617408, 0x3230303730313331323030363131, 485, 16);
INSERT INTO `wiki_page` VALUES (486, 8, 0x457869662d73756273656374696d65, 0x7379736f70, 0, 0, 0, 0.987091737163, 0x3230303730313331323030363131, 486, 19);
INSERT INTO `wiki_page` VALUES (487, 8, 0x457869662d73756273656374696d656469676974697a6564, 0x7379736f70, 0, 0, 0, 0.916374816291, 0x3230303730313331323030363131, 487, 28);
INSERT INTO `wiki_page` VALUES (488, 8, 0x457869662d73756273656374696d656f726967696e616c, 0x7379736f70, 0, 0, 0, 0.146098311069, 0x3230303730313331323030363131, 488, 27);
INSERT INTO `wiki_page` VALUES (489, 8, 0x457869662d7472616e7366657266756e6374696f6e, 0x7379736f70, 0, 0, 0, 0.385684668641, 0x3230303730313331323030363131, 489, 17);
INSERT INTO `wiki_page` VALUES (490, 8, 0x457869662d75736572636f6d6d656e74, 0x7379736f70, 0, 0, 0, 0.26637143237, 0x3230303730313331323030363131, 490, 13);
INSERT INTO `wiki_page` VALUES (491, 8, 0x457869662d776869746562616c616e6365, 0x7379736f70, 0, 0, 0, 0.683738502744, 0x3230303730313331323030363131, 491, 13);
INSERT INTO `wiki_page` VALUES (492, 8, 0x457869662d776869746562616c616e63652d30, 0x7379736f70, 0, 0, 0, 0.738353603198, 0x3230303730313331323030363131, 492, 18);
INSERT INTO `wiki_page` VALUES (493, 8, 0x457869662d776869746562616c616e63652d31, 0x7379736f70, 0, 0, 0, 0.953206975791, 0x3230303730313331323030363131, 493, 20);
INSERT INTO `wiki_page` VALUES (494, 8, 0x457869662d7768697465706f696e74, 0x7379736f70, 0, 0, 0, 0.994210987924, 0x3230303730313331323030363131, 494, 24);
INSERT INTO `wiki_page` VALUES (495, 8, 0x457869662d787265736f6c7574696f6e, 0x7379736f70, 0, 0, 0, 0.64314876552, 0x3230303730313331323030363131, 495, 21);
INSERT INTO `wiki_page` VALUES (496, 8, 0x457869662d78797265736f6c7574696f6e2d63, 0x7379736f70, 0, 0, 0, 0.768924926997, 0x3230303730313331323030363131, 496, 6);
INSERT INTO `wiki_page` VALUES (497, 8, 0x457869662d78797265736f6c7574696f6e2d69, 0x7379736f70, 0, 0, 0, 0.946023565808, 0x3230303730313331323030363131, 497, 6);
INSERT INTO `wiki_page` VALUES (498, 8, 0x457869662d7963626372636f656666696369656e7473, 0x7379736f70, 0, 0, 0, 0.289940742649, 0x3230303730313331323030363131, 498, 46);
INSERT INTO `wiki_page` VALUES (499, 8, 0x457869662d7963626372706f736974696f6e696e67, 0x7379736f70, 0, 0, 0, 0.597488499376, 0x3230303730313331323030363131, 499, 19);
INSERT INTO `wiki_page` VALUES (500, 8, 0x457869662d796362637273756273616d706c696e67, 0x7379736f70, 0, 0, 0, 0.292974268433, 0x3230303730313331323030363131, 500, 27);
INSERT INTO `wiki_page` VALUES (501, 8, 0x457869662d797265736f6c7574696f6e, 0x7379736f70, 0, 0, 0, 0.9227685476, 0x3230303730313331323030363131, 501, 19);
INSERT INTO `wiki_page` VALUES (502, 8, 0x4578706972696e67626c6f636b, 0x7379736f70, 0, 0, 0, 0.571157879226, 0x3230303730313331323030363131, 502, 10);
INSERT INTO `wiki_page` VALUES (503, 8, 0x4578706c61696e636f6e666c696374, 0x7379736f70, 0, 0, 0, 0.45922986039, 0x3230303730313331323030363132, 503, 330);
INSERT INTO `wiki_page` VALUES (504, 8, 0x4578706f7274, 0x7379736f70, 0, 0, 0, 0.661318598032, 0x3230303730313331323030363132, 504, 12);
INSERT INTO `wiki_page` VALUES (505, 8, 0x4578706f72746375726f6e6c79, 0x7379736f70, 0, 0, 0, 0.075363968047, 0x3230303730313331323030363132, 505, 55);
INSERT INTO `wiki_page` VALUES (506, 8, 0x4578706f72746e6f686973746f7279, 0x7379736f70, 0, 0, 0, 0.923086729971, 0x3230303730313331323030363132, 506, 116);
INSERT INTO `wiki_page` VALUES (507, 8, 0x4578706f727474657874, 0x7379736f70, 0, 0, 0, 0.765759631218, 0x3230303730313331323030363132, 507, 568);
INSERT INTO `wiki_page` VALUES (508, 8, 0x45787465726e616c64626572726f72, 0x7379736f70, 0, 0, 0, 0.45623732628, 0x3230303730313331323030363132, 508, 114);
INSERT INTO `wiki_page` VALUES (509, 8, 0x4578746c696e6b5f73616d706c65, 0x7379736f70, 0, 0, 0, 0.886938798744, 0x3230303730313331323030363132, 509, 33);
INSERT INTO `wiki_page` VALUES (510, 8, 0x4578746c696e6b5f746970, 0x7379736f70, 0, 0, 0, 0.022292665935, 0x3230303730313331323030363132, 510, 39);
INSERT INTO `wiki_page` VALUES (511, 8, 0x466171, 0x7379736f70, 0, 0, 0, 0.123259178447, 0x3230303730313331323030363132, 511, 3);
INSERT INTO `wiki_page` VALUES (512, 8, 0x46617170616765, 0x7379736f70, 0, 0, 0, 0.751909191979, 0x3230303730313331323030363132, 512, 11);
INSERT INTO `wiki_page` VALUES (513, 8, 0x466562, 0x7379736f70, 0, 0, 0, 0.643293396835, 0x3230303730313331323030363132, 513, 3);
INSERT INTO `wiki_page` VALUES (514, 8, 0x4665627275617279, 0x7379736f70, 0, 0, 0, 0.305578669408, 0x3230303730313331323030363132, 514, 8);
INSERT INTO `wiki_page` VALUES (515, 8, 0x466565646c696e6b73, 0x7379736f70, 0, 0, 0, 0.253486436439, 0x3230303730313331323030363132, 515, 5);
INSERT INTO `wiki_page` VALUES (516, 8, 0x46696c65636f70796572726f72, 0x7379736f70, 0, 0, 0, 0.821119626116, 0x3230303730313331323030363132, 516, 33);
INSERT INTO `wiki_page` VALUES (517, 8, 0x46696c6564656c6574656572726f72, 0x7379736f70, 0, 0, 0, 0.418019845041, 0x3230303730313331323030363132, 517, 27);
INSERT INTO `wiki_page` VALUES (518, 8, 0x46696c6564657363, 0x7379736f70, 0, 0, 0, 0.880405062852, 0x3230303730313331323030363132, 518, 7);
INSERT INTO `wiki_page` VALUES (519, 8, 0x46696c65657869737473, 0x7379736f70, 0, 0, 0, 0.697316852898, 0x3230303730313331323030363132, 519, 99);
INSERT INTO `wiki_page` VALUES (520, 8, 0x46696c656578697374732d666f7262696464656e, 0x7379736f70, 0, 0, 0, 0.861053146832, 0x3230303730313331323030363132, 520, 120);
INSERT INTO `wiki_page` VALUES (521, 8, 0x46696c656578697374732d7368617265642d666f7262696464656e, 0x7379736f70, 0, 0, 0, 0.765643755318, 0x3230303730313331323030363132, 521, 150);
INSERT INTO `wiki_page` VALUES (522, 8, 0x46696c65696e666f, 0x7379736f70, 0, 0, 0, 0.978223360057, 0x3230303730313331323030363132, 522, 32);
INSERT INTO `wiki_page` VALUES (523, 8, 0x46696c656d697373696e67, 0x7379736f70, 0, 0, 0, 0.645369182422, 0x3230303730313331323030363132, 523, 12);
INSERT INTO `wiki_page` VALUES (524, 8, 0x46696c656e616d65, 0x7379736f70, 0, 0, 0, 0.877688266404, 0x3230303730313331323030363132, 524, 8);
INSERT INTO `wiki_page` VALUES (525, 8, 0x46696c656e6f74666f756e64, 0x7379736f70, 0, 0, 0, 0.242472452803, 0x3230303730313331323030363132, 525, 25);
INSERT INTO `wiki_page` VALUES (526, 8, 0x46696c6572656e616d656572726f72, 0x7379736f70, 0, 0, 0, 0.672122128315, 0x3230303730313331323030363132, 526, 35);
INSERT INTO `wiki_page` VALUES (527, 8, 0x46696c6573, 0x7379736f70, 0, 0, 0, 0.58657077538, 0x3230303730313331323030363132, 527, 5);
INSERT INTO `wiki_page` VALUES (528, 8, 0x46696c65736f75726365, 0x7379736f70, 0, 0, 0, 0.422402655114, 0x3230303730313331323030363132, 528, 6);
INSERT INTO `wiki_page` VALUES (529, 8, 0x46696c65737461747573, 0x7379736f70, 0, 0, 0, 0.722515852268, 0x3230303730313331323030363132, 529, 16);
INSERT INTO `wiki_page` VALUES (530, 8, 0x46696c6575706c6f61646564, 0x7379736f70, 0, 0, 0, 0.42927218125, 0x3230303730313331323030363132, 530, 331);
INSERT INTO `wiki_page` VALUES (531, 8, 0x46696c6575706c6f616473756d6d617279, 0x7379736f70, 0, 0, 0, 0.639139772913, 0x3230303730313331323030363132, 531, 8);
INSERT INTO `wiki_page` VALUES (532, 8, 0x466f726d6572726f72, 0x7379736f70, 0, 0, 0, 0.876448385139, 0x3230303730313331323030363132, 532, 28);
INSERT INTO `wiki_page` VALUES (533, 8, 0x467269646179, 0x7379736f70, 0, 0, 0, 0.390428516692, 0x3230303730313331323030363132, 533, 6);
INSERT INTO `wiki_page` VALUES (534, 8, 0x476574696d6167656c697374, 0x7379736f70, 0, 0, 0, 0.741505260976, 0x3230303730313331323030363132, 534, 18);
INSERT INTO `wiki_page` VALUES (535, 8, 0x476f, 0x7379736f70, 0, 0, 0, 0.581312570364, 0x3230303730313331323030363132, 535, 2);
INSERT INTO `wiki_page` VALUES (536, 8, 0x476f6f676c65736561726368, 0x7379736f70, 0, 0, 0, 0.674727972797, 0x3230303730313331323030363132, 536, 660);
INSERT INTO `wiki_page` VALUES (537, 8, 0x476f746163636f756e74, 0x7379736f70, 0, 0, 0, 0.499737790764, 0x3230303730313331323030363132, 537, 27);
INSERT INTO `wiki_page` VALUES (538, 8, 0x476f746163636f756e746c696e6b, 0x7379736f70, 0, 0, 0, 0.049864523041, 0x3230303730313331323030363132, 538, 6);
INSERT INTO `wiki_page` VALUES (539, 8, 0x47726f75702d61646d696e2d64657363, 0x7379736f70, 0, 0, 0, 0.330517037075, 0x3230303730313331323030363132, 539, 53);
INSERT INTO `wiki_page` VALUES (540, 8, 0x47726f75702d61646d696e2d6e616d65, 0x7379736f70, 0, 0, 0, 0.638020754188, 0x3230303730313331323030363132, 540, 13);
INSERT INTO `wiki_page` VALUES (541, 8, 0x47726f75702d616e6f6e2d64657363, 0x7379736f70, 0, 0, 0, 0.968145102703, 0x3230303730313331323030363132, 541, 15);
INSERT INTO `wiki_page` VALUES (542, 8, 0x47726f75702d616e6f6e2d6e616d65, 0x7379736f70, 0, 0, 0, 0.289148000443, 0x3230303730313331323030363132, 542, 9);
INSERT INTO `wiki_page` VALUES (543, 8, 0x47726f75702d627572656175637261742d64657363, 0x7379736f70, 0, 0, 0, 0.674527833955, 0x3230303730313331323030363132, 543, 43);
INSERT INTO `wiki_page` VALUES (544, 8, 0x47726f75702d627572656175637261742d6e616d65, 0x7379736f70, 0, 0, 0, 0.999144692599, 0x3230303730313331323030363132, 544, 10);
INSERT INTO `wiki_page` VALUES (545, 8, 0x47726f75702d6c6f67676564696e2d64657363, 0x7379736f70, 0, 0, 0, 0.618092892495, 0x3230303730313331323030363132, 545, 23);
INSERT INTO `wiki_page` VALUES (546, 8, 0x47726f75702d6c6f67676564696e2d6e616d65, 0x7379736f70, 0, 0, 0, 0.190508826362, 0x3230303730313331323030363132, 546, 4);
INSERT INTO `wiki_page` VALUES (547, 8, 0x47726f75702d737465776172642d64657363, 0x7379736f70, 0, 0, 0, 0.486001888833, 0x3230303730313331323030363132, 547, 11);
INSERT INTO `wiki_page` VALUES (548, 8, 0x47726f75702d737465776172642d6e616d65, 0x7379736f70, 0, 0, 0, 0.52525810782, 0x3230303730313331323030363132, 548, 7);
INSERT INTO `wiki_page` VALUES (549, 8, 0x47726f757073, 0x7379736f70, 0, 0, 0, 0.06880580133, 0x3230303730313331323030363132, 549, 11);
INSERT INTO `wiki_page` VALUES (550, 8, 0x47726f7570732d61646467726f7570, 0x7379736f70, 0, 0, 0, 0.323691081302, 0x3230303730313331323030363132, 550, 9);
INSERT INTO `wiki_page` VALUES (551, 8, 0x47726f7570732d616c72656164792d657869737473, 0x7379736f70, 0, 0, 0, 0.397752756687, 0x3230303730313331323030363132, 551, 35);
INSERT INTO `wiki_page` VALUES (552, 8, 0x47726f7570732d6564697467726f7570, 0x7379736f70, 0, 0, 0, 0.114630622001, 0x3230303730313331323030363132, 552, 10);
INSERT INTO `wiki_page` VALUES (553, 8, 0x47726f7570732d6564697467726f75702d6465736372697074696f6e, 0x7379736f70, 0, 0, 0, 0.081971644797, 0x3230303730313331323030363132, 553, 45);
INSERT INTO `wiki_page` VALUES (554, 8, 0x47726f7570732d6564697467726f75702d6e616d65, 0x7379736f70, 0, 0, 0, 0.710457183532, 0x3230303730313331323030363132, 554, 11);
INSERT INTO `wiki_page` VALUES (555, 8, 0x47726f7570732d6564697467726f75702d707265616d626c65, 0x7379736f70, 0, 0, 0, 0.996468563775, 0x3230303730313331323030363132, 555, 163);
INSERT INTO `wiki_page` VALUES (556, 8, 0x47726f7570732d6578697374696e67, 0x7379736f70, 0, 0, 0, 0.52245574056, 0x3230303730313331323030363132, 556, 15);
INSERT INTO `wiki_page` VALUES (557, 8, 0x47726f7570732d67726f75702d65646974, 0x7379736f70, 0, 0, 0, 0.775048286589, 0x3230303730313331323030363132, 557, 16);
INSERT INTO `wiki_page` VALUES (558, 8, 0x47726f7570732d6c6f6f6b75702d67726f7570, 0x7379736f70, 0, 0, 0, 0.58128125269, 0x3230303730313331323030363132, 558, 19);
INSERT INTO `wiki_page` VALUES (559, 8, 0x47726f7570732d6e6f6e616d65, 0x7379736f70, 0, 0, 0, 0.33903243107, 0x3230303730313331323030363132, 559, 33);
INSERT INTO `wiki_page` VALUES (560, 8, 0x47726f7570732d7461626c65686561646572, 0x7379736f70, 0, 0, 0, 0.609427751608, 0x3230303730313331323030363132, 560, 35);
INSERT INTO `wiki_page` VALUES (561, 8, 0x477565737374696d657a6f6e65, 0x7379736f70, 0, 0, 0, 0.993779605036, 0x3230303730313331323030363132, 561, 20);
INSERT INTO `wiki_page` VALUES (562, 8, 0x486561646c696e655f73616d706c65, 0x7379736f70, 0, 0, 0, 0.52597985619, 0x3230303730313331323030363132, 562, 13);
INSERT INTO `wiki_page` VALUES (563, 8, 0x486561646c696e655f746970, 0x7379736f70, 0, 0, 0, 0.332656760495, 0x3230303730313331323030363132, 563, 16);
INSERT INTO `wiki_page` VALUES (564, 8, 0x48656c70, 0x7379736f70, 0, 0, 0, 0.201199190712, 0x3230303730313331323030363132, 564, 4);
INSERT INTO `wiki_page` VALUES (565, 8, 0x48656c7070616765, 0x7379736f70, 0, 0, 0, 0.790948307267, 0x3230303730313331323030363132, 565, 13);
INSERT INTO `wiki_page` VALUES (566, 8, 0x48696465, 0x7379736f70, 0, 0, 0, 0.533689763001, 0x3230303730313331323030363132, 566, 4);
INSERT INTO `wiki_page` VALUES (567, 8, 0x48696465726573756c7473, 0x7379736f70, 0, 0, 0, 0.124780628039, 0x3230303730313331323030363132, 567, 12);
INSERT INTO `wiki_page` VALUES (568, 8, 0x48696465746f63, 0x7379736f70, 0, 0, 0, 0.368960796602, 0x3230303730313331323030363132, 568, 4);
INSERT INTO `wiki_page` VALUES (569, 8, 0x48697374, 0x7379736f70, 0, 0, 0, 0.581908508469, 0x3230303730313331323030363132, 569, 4);
INSERT INTO `wiki_page` VALUES (570, 8, 0x486973746669727374, 0x7379736f70, 0, 0, 0, 0.110694438552, 0x3230303730313331323030363132, 570, 8);
INSERT INTO `wiki_page` VALUES (571, 8, 0x486973746c617374, 0x7379736f70, 0, 0, 0, 0.332351829324, 0x3230303730313331323030363132, 571, 6);
INSERT INTO `wiki_page` VALUES (572, 8, 0x486973746c6567656e64, 0x7379736f70, 0, 0, 0, 0.324533736935, 0x3230303730313331323030363132, 572, 221);
INSERT INTO `wiki_page` VALUES (573, 8, 0x486973746f7279, 0x7379736f70, 0, 0, 0, 0.148097862032, 0x3230303730313331323030363132, 573, 12);
INSERT INTO `wiki_page` VALUES (574, 8, 0x486973746f72795f636f70797269676874, 0x7379736f70, 0, 0, 0, 0.761535589742, 0x3230303730313331323030363132, 574, 1);
INSERT INTO `wiki_page` VALUES (575, 8, 0x486973746f72795f73686f7274, 0x7379736f70, 0, 0, 0, 0.822484924978, 0x3230303730313331323030363132, 575, 7);
INSERT INTO `wiki_page` VALUES (576, 8, 0x486973746f72797761726e696e67, 0x7379736f70, 0, 0, 0, 0.075764459121, 0x3230303730313331323030363132, 576, 56);
INSERT INTO `wiki_page` VALUES (577, 8, 0x48725f746970, 0x7379736f70, 0, 0, 0, 0.906840488544, 0x3230303730313331323030363132, 577, 31);
INSERT INTO `wiki_page` VALUES (578, 8, 0x49676e6f72657761726e696e67, 0x7379736f70, 0, 0, 0, 0.100769015052, 0x3230303730313331323030363132, 578, 36);
INSERT INTO `wiki_page` VALUES (579, 8, 0x49676e6f72657761726e696e6773, 0x7379736f70, 0, 0, 0, 0.343782841024, 0x3230303730313331323030363132, 579, 19);
INSERT INTO `wiki_page` VALUES (580, 8, 0x496c6c6567616c66696c656e616d65, 0x7379736f70, 0, 0, 0, 0.317220408093, 0x3230303730313331323030363132, 580, 125);
INSERT INTO `wiki_page` VALUES (581, 8, 0x496c7375626d6974, 0x7379736f70, 0, 0, 0, 0.399036602946, 0x3230303730313331323030363132, 581, 6);
INSERT INTO `wiki_page` VALUES (582, 8, 0x496d6167655f73616d706c65, 0x7379736f70, 0, 0, 0, 0.855796340484, 0x3230303730313331323030363133, 582, 11);
INSERT INTO `wiki_page` VALUES (583, 8, 0x496d6167655f746970, 0x7379736f70, 0, 0, 0, 0.218697834372, 0x3230303730313331323030363133, 583, 14);
INSERT INTO `wiki_page` VALUES (584, 8, 0x496d6167656c696e6b73, 0x7379736f70, 0, 0, 0, 0.966435336554, 0x3230303730313331323030363133, 584, 5);
INSERT INTO `wiki_page` VALUES (585, 8, 0x496d6167656c697374, 0x7379736f70, 0, 0, 0, 0.007960622789, 0x3230303730313331323030363133, 585, 9);
INSERT INTO `wiki_page` VALUES (586, 8, 0x496d6167656c697374616c6c, 0x7379736f70, 0, 0, 0, 0.167238428336, 0x3230303730313331323030363133, 586, 3);
INSERT INTO `wiki_page` VALUES (587, 8, 0x496d6167656c697374666f7275736572, 0x7379736f70, 0, 0, 0, 0.369968467715, 0x3230303730313331323030363133, 587, 38);
INSERT INTO `wiki_page` VALUES (588, 8, 0x496d6167656c69737474657874, 0x7379736f70, 0, 0, 0, 0.71894405721, 0x3230303730313331323030363133, 588, 38);
INSERT INTO `wiki_page` VALUES (589, 8, 0x496d6167656d617873697a65, 0x7379736f70, 0, 0, 0, 0.996420243445, 0x3230303730313331323030363133, 589, 43);
INSERT INTO `wiki_page` VALUES (590, 8, 0x496d61676570616765, 0x7379736f70, 0, 0, 0, 0.05671910572, 0x3230303730313331323030363133, 590, 15);
INSERT INTO `wiki_page` VALUES (591, 8, 0x496d6167657265766572746564, 0x7379736f70, 0, 0, 0, 0.481241055955, 0x3230303730313331323030363133, 591, 41);
INSERT INTO `wiki_page` VALUES (592, 8, 0x496d6764656c657465, 0x7379736f70, 0, 0, 0, 0.807397807688, 0x3230303730313331323030363133, 592, 3);
INSERT INTO `wiki_page` VALUES (593, 8, 0x496d6764657363, 0x7379736f70, 0, 0, 0, 0.573655077194, 0x3230303730313331323030363133, 593, 4);
INSERT INTO `wiki_page` VALUES (594, 8, 0x496d67686973746c6567656e64, 0x7379736f70, 0, 0, 0, 0.165553778825, 0x3230303730313331323030363133, 594, 176);
INSERT INTO `wiki_page` VALUES (595, 8, 0x496d67686973746f7279, 0x7379736f70, 0, 0, 0, 0.200324131218, 0x3230303730313331323030363133, 595, 12);
INSERT INTO `wiki_page` VALUES (596, 8, 0x496d676c6567656e64, 0x7379736f70, 0, 0, 0, 0.935369252858, 0x3230303730313331323030363133, 596, 44);
INSERT INTO `wiki_page` VALUES (597, 8, 0x496d6d6f62696c655f6e616d657370616365, 0x7379736f70, 0, 0, 0, 0.564738882096, 0x3230303730313331323030363133, 597, 78);
INSERT INTO `wiki_page` VALUES (598, 8, 0x496d706f7274, 0x7379736f70, 0, 0, 0, 0.470062821972, 0x3230303730313331323030363133, 598, 12);
INSERT INTO `wiki_page` VALUES (599, 8, 0x496d706f72746661696c6564, 0x7379736f70, 0, 0, 0, 0.785898639718, 0x3230303730313331323030363133, 599, 17);
INSERT INTO `wiki_page` VALUES (600, 8, 0x496d706f7274686973746f7279636f6e666c696374, 0x7379736f70, 0, 0, 0, 0.890914469042, 0x3230303730313331323030363133, 600, 72);
INSERT INTO `wiki_page` VALUES (601, 8, 0x496d706f7274696e67, 0x7379736f70, 0, 0, 0, 0.912641248031, 0x3230303730313331323030363133, 601, 12);
INSERT INTO `wiki_page` VALUES (602, 8, 0x496d706f7274696e74657277696b69, 0x7379736f70, 0, 0, 0, 0.022218856897, 0x3230303730313331323030363133, 602, 16);
INSERT INTO `wiki_page` VALUES (603, 8, 0x496d706f72746e6f66696c65, 0x7379736f70, 0, 0, 0, 0.858640477728, 0x3230303730313331323030363133, 603, 28);
INSERT INTO `wiki_page` VALUES (604, 8, 0x496d706f72746e6f736f7572636573, 0x7379736f70, 0, 0, 0, 0.716545258032, 0x3230303730313331323030363133, 604, 86);
INSERT INTO `wiki_page` VALUES (605, 8, 0x496d706f72746e6f74657874, 0x7379736f70, 0, 0, 0, 0.681559602337, 0x3230303730313331323030363133, 605, 16);
INSERT INTO `wiki_page` VALUES (606, 8, 0x496d706f727473756363657373, 0x7379736f70, 0, 0, 0, 0.863986862263, 0x3230303730313331323030363133, 606, 17);
INSERT INTO `wiki_page` VALUES (607, 8, 0x496d706f727474657874, 0x7379736f70, 0, 0, 0, 0.36829295841, 0x3230303730313331323030363133, 607, 118);
INSERT INTO `wiki_page` VALUES (608, 8, 0x496d706f727475706c6f61646572726f72, 0x7379736f70, 0, 0, 0, 0.546096301052, 0x3230303730313331323030363133, 608, 86);
INSERT INTO `wiki_page` VALUES (609, 8, 0x496e66696e697465626c6f636b, 0x7379736f70, 0, 0, 0, 0.285016439479, 0x3230303730313331323030363133, 609, 8);
INSERT INTO `wiki_page` VALUES (610, 8, 0x496e666f5f73686f7274, 0x7379736f70, 0, 0, 0, 0.004353060484, 0x3230303730313331323030363133, 610, 11);
INSERT INTO `wiki_page` VALUES (611, 8, 0x496e666f7375627469746c65, 0x7379736f70, 0, 0, 0, 0.976306899265, 0x3230303730313331323030363133, 611, 20);
INSERT INTO `wiki_page` VALUES (612, 8, 0x496e7465726e616c6572726f72, 0x7379736f70, 0, 0, 0, 0.337244662198, 0x3230303730313331323030363133, 612, 14);
INSERT INTO `wiki_page` VALUES (613, 8, 0x496e746c, 0x7379736f70, 0, 0, 0, 0.826375797335, 0x3230303730313331323030363133, 613, 19);
INSERT INTO `wiki_page` VALUES (614, 8, 0x496e76616c6964656d61696c61646472657373, 0x7379736f70, 0, 0, 0, 0.952406135611, 0x3230303730313331323030363133, 614, 137);
INSERT INTO `wiki_page` VALUES (615, 8, 0x496e76657274, 0x7379736f70, 0, 0, 0, 0.973263971304, 0x3230303730313331323030363133, 615, 16);
INSERT INTO `wiki_page` VALUES (616, 8, 0x49705f72616e67655f696e76616c6964, 0x7379736f70, 0, 0, 0, 0.583282324166, 0x3230303730313331323030363133, 616, 17);
INSERT INTO `wiki_page` VALUES (617, 8, 0x497061646472657373, 0x7379736f70, 0, 0, 0, 0.056484791831, 0x3230303730313331323030363133, 617, 10);
INSERT INTO `wiki_page` VALUES (618, 8, 0x49706164726573736f72757365726e616d65, 0x7379736f70, 0, 0, 0, 0.906788649759, 0x3230303730313331323030363133, 618, 22);
INSERT INTO `wiki_page` VALUES (619, 8, 0x4970625f6578706972795f696e76616c6964, 0x7379736f70, 0, 0, 0, 0.889636544496, 0x3230303730313331323030363133, 619, 20);
INSERT INTO `wiki_page` VALUES (620, 8, 0x497062657870697279, 0x7379736f70, 0, 0, 0, 0.471635301765, 0x3230303730313331323030363133, 620, 6);
INSERT INTO `wiki_page` VALUES (621, 8, 0x4970626c6f636b6c697374, 0x7379736f70, 0, 0, 0, 0.425115533889, 0x3230303730313331323030363133, 621, 42);
INSERT INTO `wiki_page` VALUES (622, 8, 0x4970626c6f636b6c697374656d707479, 0x7379736f70, 0, 0, 0, 0.462400406127, 0x3230303730313331323030363133, 622, 23);
INSERT INTO `wiki_page` VALUES (623, 8, 0x4970626f7074696f6e73, 0x7379736f70, 0, 0, 0, 0.055763189031, 0x3230303730313331323030363133, 623, 155);
INSERT INTO `wiki_page` VALUES (624, 8, 0x4970626f74686572, 0x7379736f70, 0, 0, 0, 0.912911913352, 0x3230303730313331323030363133, 624, 10);
INSERT INTO `wiki_page` VALUES (625, 8, 0x4970626f746865726f7074696f6e, 0x7379736f70, 0, 0, 0, 0.234316089031, 0x3230303730313331323030363133, 625, 5);
INSERT INTO `wiki_page` VALUES (626, 8, 0x497062726561736f6e, 0x7379736f70, 0, 0, 0, 0.439803491359, 0x3230303730313331323030363133, 626, 6);
INSERT INTO `wiki_page` VALUES (627, 8, 0x4970627375626d6974, 0x7379736f70, 0, 0, 0, 0.851947562667, 0x3230303730313331323030363133, 627, 15);
INSERT INTO `wiki_page` VALUES (628, 8, 0x4970757375626d6974, 0x7379736f70, 0, 0, 0, 0.438123830138, 0x3230303730313331323030363133, 628, 20);
INSERT INTO `wiki_page` VALUES (629, 8, 0x49707573756363657373, 0x7379736f70, 0, 0, 0, 0.423659033047, 0x3230303730313331323030363133, 629, 18);
INSERT INTO `wiki_page` VALUES (630, 8, 0x4973626e, 0x7379736f70, 0, 0, 0, 0.694077653976, 0x3230303730313331323030363133, 630, 4);
INSERT INTO `wiki_page` VALUES (631, 8, 0x49737265646972656374, 0x7379736f70, 0, 0, 0, 0.527530175346, 0x3230303730313331323030363133, 631, 13);
INSERT INTO `wiki_page` VALUES (632, 8, 0x497374656d706c617465, 0x7379736f70, 0, 0, 0, 0.118138218434, 0x3230303730313331323030363133, 632, 9);
INSERT INTO `wiki_page` VALUES (633, 8, 0x4974616c69635f73616d706c65, 0x7379736f70, 0, 0, 0, 0.695123961629, 0x3230303730313331323030363133, 633, 11);
INSERT INTO `wiki_page` VALUES (634, 8, 0x4974616c69635f746970, 0x7379736f70, 0, 0, 0, 0.306732299024, 0x3230303730313331323030363133, 634, 11);
INSERT INTO `wiki_page` VALUES (635, 8, 0x4974656d696e76616c69646e616d65, 0x7379736f70, 0, 0, 0, 0.914268901614, 0x3230303730313331323030363133, 635, 39);
INSERT INTO `wiki_page` VALUES (636, 8, 0x4a616e, 0x7379736f70, 0, 0, 0, 0.420630510002, 0x3230303730313331323030363133, 636, 3);
INSERT INTO `wiki_page` VALUES (637, 8, 0x4a616e75617279, 0x7379736f70, 0, 0, 0, 0.718047397871, 0x3230303730313331323030363133, 637, 7);
INSERT INTO `wiki_page` VALUES (638, 8, 0x4a756c, 0x7379736f70, 0, 0, 0, 0.648051074986, 0x3230303730313331323030363133, 638, 3);
INSERT INTO `wiki_page` VALUES (639, 8, 0x4a756c79, 0x7379736f70, 0, 0, 0, 0.319116558565, 0x3230303730313331323030363134, 639, 4);
INSERT INTO `wiki_page` VALUES (640, 8, 0x4a756d70746f, 0x7379736f70, 0, 0, 0, 0.111631490711, 0x3230303730313331323030363134, 640, 8);
INSERT INTO `wiki_page` VALUES (641, 8, 0x4a756d70746f6e617669676174696f6e, 0x7379736f70, 0, 0, 0, 0.979751488037, 0x3230303730313331323030363134, 641, 10);
INSERT INTO `wiki_page` VALUES (642, 8, 0x4a756d70746f736561726368, 0x7379736f70, 0, 0, 0, 0.337896644003, 0x3230303730313331323030363134, 642, 6);
INSERT INTO `wiki_page` VALUES (643, 8, 0x4a756e, 0x7379736f70, 0, 0, 0, 0.803572236243, 0x3230303730313331323030363134, 643, 3);
INSERT INTO `wiki_page` VALUES (644, 8, 0x4a756e65, 0x7379736f70, 0, 0, 0, 0.534283372195, 0x3230303730313331323030363134, 644, 4);
INSERT INTO `wiki_page` VALUES (645, 8, 0x4c6167676564736c6176656d6f6465, 0x7379736f70, 0, 0, 0, 0.076615102864, 0x3230303730313331323030363134, 645, 45);
INSERT INTO `wiki_page` VALUES (646, 8, 0x4c6172676566696c65, 0x7379736f70, 0, 0, 0, 0.219056525778, 0x3230303730313331323030363134, 646, 80);
INSERT INTO `wiki_page` VALUES (647, 8, 0x4c6172676566696c65736572766572, 0x7379736f70, 0, 0, 0, 0.689297085916, 0x3230303730313331323030363134, 647, 59);
INSERT INTO `wiki_page` VALUES (648, 8, 0x4c617374, 0x7379736f70, 0, 0, 0, 0.776286131692, 0x3230303730313331323030363134, 648, 4);
INSERT INTO `wiki_page` VALUES (649, 8, 0x4c6173746d6f646966696564, 0x7379736f70, 0, 0, 0, 0.048000500899, 0x3230303730313331323030363134, 649, 31);
INSERT INTO `wiki_page` VALUES (650, 8, 0x4c6173746d6f6469666965646279, 0x7379736f70, 0, 0, 0, 0.011390730122, 0x3230303730313331323030363134, 650, 37);
INSERT INTO `wiki_page` VALUES (651, 8, 0x4c6963656e7365, 0x7379736f70, 0, 0, 0, 0.739862337323, 0x3230303730313331323030363134, 651, 9);
INSERT INTO `wiki_page` VALUES (652, 8, 0x4c696e656e6f, 0x7379736f70, 0, 0, 0, 0.451463923767, 0x3230303730313331323030363134, 652, 8);
INSERT INTO `wiki_page` VALUES (653, 8, 0x4c696e6b5f73616d706c65, 0x7379736f70, 0, 0, 0, 0.92739883289, 0x3230303730313331323030363134, 653, 10);
INSERT INTO `wiki_page` VALUES (654, 8, 0x4c696e6b5f746970, 0x7379736f70, 0, 0, 0, 0.448296952493, 0x3230303730313331323030363134, 654, 13);
INSERT INTO `wiki_page` VALUES (655, 8, 0x4c696e6b6c697374737562, 0x7379736f70, 0, 0, 0, 0.868149221026, 0x3230303730313331323030363134, 655, 15);
INSERT INTO `wiki_page` VALUES (656, 8, 0x4c696e6b707265666978, 0x7379736f70, 0, 0, 0, 0.071986945152, 0x3230303730313331323030363134, 656, 31);
INSERT INTO `wiki_page` VALUES (657, 8, 0x4c696e6b7368657265, 0x7379736f70, 0, 0, 0, 0.121674003385, 0x3230303730313331323030363134, 657, 33);
INSERT INTO `wiki_page` VALUES (658, 8, 0x4c696e6b73746f696d616765, 0x7379736f70, 0, 0, 0, 0.981170344441, 0x3230303730313331323030363134, 658, 38);
INSERT INTO `wiki_page` VALUES (659, 8, 0x4c696e6b747261696c, 0x7379736f70, 0, 0, 0, 0.312878980377, 0x3230303730313331323030363134, 659, 18);
INSERT INTO `wiki_page` VALUES (660, 8, 0x4c697374666f726d, 0x7379736f70, 0, 0, 0, 0.316809415732, 0x3230303730313331323030363134, 660, 4);
INSERT INTO `wiki_page` VALUES (661, 8, 0x4c697374696e67636f6e74696e756573616262726576, 0x7379736f70, 0, 0, 0, 0.62657257776, 0x3230303730313331323030363134, 661, 6);
INSERT INTO `wiki_page` VALUES (662, 8, 0x4c697374726564697265637473, 0x7379736f70, 0, 0, 0, 0.243163039354, 0x3230303730313331323030363134, 662, 14);
INSERT INTO `wiki_page` VALUES (663, 8, 0x4c6973747573657273, 0x7379736f70, 0, 0, 0, 0.08313864539, 0x3230303730313331323030363134, 663, 9);
INSERT INTO `wiki_page` VALUES (664, 8, 0x4c6f616468697374, 0x7379736f70, 0, 0, 0, 0.350274332843, 0x3230303730313331323030363134, 664, 20);
INSERT INTO `wiki_page` VALUES (665, 8, 0x4c6f6164696e67726576, 0x7379736f70, 0, 0, 0, 0.137691257005, 0x3230303730313331323030363134, 665, 25);
INSERT INTO `wiki_page` VALUES (666, 8, 0x4c6f63616c74696d65, 0x7379736f70, 0, 0, 0, 0.260913602354, 0x3230303730313331323030363134, 666, 10);
INSERT INTO `wiki_page` VALUES (667, 8, 0x4c6f636b62746e, 0x7379736f70, 0, 0, 0, 0.280145370919, 0x3230303730313331323030363134, 667, 13);
INSERT INTO `wiki_page` VALUES (668, 8, 0x4c6f636b636f6e6669726d, 0x7379736f70, 0, 0, 0, 0.758509753673, 0x3230303730313331323030363134, 668, 40);
INSERT INTO `wiki_page` VALUES (669, 8, 0x4c6f636b6462, 0x7379736f70, 0, 0, 0, 0.954754493274, 0x3230303730313331323030363134, 669, 13);
INSERT INTO `wiki_page` VALUES (670, 8, 0x4c6f636b646273756363657373737562, 0x7379736f70, 0, 0, 0, 0.888653959464, 0x3230303730313331323030363134, 670, 23);
INSERT INTO `wiki_page` VALUES (671, 8, 0x4c6f636b64627375636365737374657874, 0x7379736f70, 0, 0, 0, 0.260889905406, 0x3230303730313331323030363134, 671, 99);
INSERT INTO `wiki_page` VALUES (672, 8, 0x4c6f636b646274657874, 0x7379736f70, 0, 0, 0, 0.033668690086, 0x3230303730313331323030363134, 672, 294);
INSERT INTO `wiki_page` VALUES (673, 8, 0x4c6f636b6e6f636f6e6669726d, 0x7379736f70, 0, 0, 0, 0.742592232765, 0x3230303730313331323030363134, 673, 39);
INSERT INTO `wiki_page` VALUES (674, 8, 0x4c6f67, 0x7379736f70, 0, 0, 0, 0.538461048398, 0x3230303730313331323030363134, 674, 4);
INSERT INTO `wiki_page` VALUES (675, 8, 0x4c6f67656d707479, 0x7379736f70, 0, 0, 0, 0.101925816041, 0x3230303730313331323030363134, 675, 25);
INSERT INTO `wiki_page` VALUES (676, 8, 0x4c6f67696e, 0x7379736f70, 0, 0, 0, 0.388303624734, 0x3230303730313331323030363134, 676, 6);
INSERT INTO `wiki_page` VALUES (677, 8, 0x4c6f67696e656e64, 0x7379736f70, 0, 0, 0, 0.98969752512, 0x3230303730313331323030363134, 677, 0);
INSERT INTO `wiki_page` VALUES (678, 8, 0x4c6f67696e6572726f72, 0x7379736f70, 0, 0, 0, 0.075591734502, 0x3230303730313331323030363134, 678, 11);
INSERT INTO `wiki_page` VALUES (679, 8, 0x4c6f67696e706167657469746c65, 0x7379736f70, 0, 0, 0, 0.291264450025, 0x3230303730313331323030363134, 679, 10);
INSERT INTO `wiki_page` VALUES (680, 8, 0x4c6f67696e70726f626c656d, 0x7379736f70, 0, 0, 0, 0.690222572706, 0x3230303730313331323030363134, 680, 64);
INSERT INTO `wiki_page` VALUES (681, 8, 0x4c6f67696e70726f6d7074, 0x7379736f70, 0, 0, 0, 0.426618738898, 0x3230303730313331323030363134, 681, 56);
INSERT INTO `wiki_page` VALUES (682, 8, 0x4c6f67696e7265716c696e6b, 0x7379736f70, 0, 0, 0, 0.248570705115, 0x3230303730313331323030363134, 682, 6);
INSERT INTO `wiki_page` VALUES (683, 8, 0x4c6f67696e7265717061676574657874, 0x7379736f70, 0, 0, 0, 0.759935825658, 0x3230303730313331323030363134, 683, 32);
INSERT INTO `wiki_page` VALUES (684, 8, 0x4c6f67696e7265717469746c65, 0x7379736f70, 0, 0, 0, 0.513710340058, 0x3230303730313331323030363134, 684, 14);
INSERT INTO `wiki_page` VALUES (685, 8, 0x4c6f67696e73756363657373, 0x7379736f70, 0, 0, 0, 0.320495044904, 0x3230303730313331323030363134, 685, 52);
INSERT INTO `wiki_page` VALUES (686, 8, 0x4c6f67696e737563636573737469746c65, 0x7379736f70, 0, 0, 0, 0.699376463079, 0x3230303730313331323030363134, 686, 16);
INSERT INTO `wiki_page` VALUES (687, 8, 0x4c6f676f7574, 0x7379736f70, 0, 0, 0, 0.551115112985, 0x3230303730313331323030363134, 687, 7);
INSERT INTO `wiki_page` VALUES (688, 8, 0x4c6f676f757474657874, 0x7379736f70, 0, 0, 0, 0.360299920949, 0x3230303730313331323030363134, 688, 274);
INSERT INTO `wiki_page` VALUES (689, 8, 0x4c6f676f75747469746c65, 0x7379736f70, 0, 0, 0, 0.896231404157, 0x3230303730313331323030363134, 689, 11);
INSERT INTO `wiki_page` VALUES (690, 8, 0x4c6f6e656c797061676573, 0x7379736f70, 0, 0, 0, 0.373474483923, 0x3230303730313331323030363134, 690, 14);
INSERT INTO `wiki_page` VALUES (691, 8, 0x4c6f6e67706167656572726f72, 0x7379736f70, 0, 0, 0, 0.88157563045, 0x3230303730313331323030363134, 691, 144);
INSERT INTO `wiki_page` VALUES (692, 8, 0x4c6f6e677061676573, 0x7379736f70, 0, 0, 0, 0.672598759091, 0x3230303730313331323030363134, 692, 10);
INSERT INTO `wiki_page` VALUES (693, 8, 0x4c6f6e67706167657761726e696e67, 0x7379736f70, 0, 0, 0, 0.215940507919, 0x3230303730313331323030363134, 693, 193);
INSERT INTO `wiki_page` VALUES (694, 8, 0x4d61696c6572726f72, 0x7379736f70, 0, 0, 0, 0.737237806226, 0x3230303730313331323030363134, 694, 22);
INSERT INTO `wiki_page` VALUES (695, 8, 0x4d61696c6d7970617373776f7264, 0x7379736f70, 0, 0, 0, 0.236096348672, 0x3230303730313331323030363134, 695, 15);
INSERT INTO `wiki_page` VALUES (696, 8, 0x4d61696c6e6f6c6f67696e, 0x7379736f70, 0, 0, 0, 0.744079009214, 0x3230303730313331323030363134, 696, 15);
INSERT INTO `wiki_page` VALUES (697, 8, 0x4d61696c6e6f6c6f67696e74657874, 0x7379736f70, 0, 0, 0, 0.944087473154, 0x3230303730313331323030363134, 697, 150);
INSERT INTO `wiki_page` VALUES (698, 8, 0x4d61696e70616765, 0x7379736f70, 0, 0, 0, 0.7101459472, 0x3230303730313331323030363134, 698, 9);
INSERT INTO `wiki_page` VALUES (699, 8, 0x4d61696e70616765646f63666f6f746572, 0x7379736f70, 0, 0, 0, 0.936402490091, 0x3230303730313331323030363134, 699, 394);
INSERT INTO `wiki_page` VALUES (700, 8, 0x4d61696e7061676574657874, 0x7379736f70, 0, 0, 0, 0.487919885412, 0x3230303730313331323030363134, 700, 59);
INSERT INTO `wiki_page` VALUES (701, 8, 0x4d616b657379736f70, 0x7379736f70, 0, 0, 0, 0.766539904621, 0x3230303730313331323030363134, 701, 24);
INSERT INTO `wiki_page` VALUES (702, 8, 0x4d616b657379736f706661696c, 0x7379736f70, 0, 0, 0, 0.07019775936, 0x3230303730313331323030363134, 702, 84);
INSERT INTO `wiki_page` VALUES (703, 8, 0x4d616b657379736f706e616d65, 0x7379736f70, 0, 0, 0, 0.578407583395, 0x3230303730313331323030363134, 703, 17);
INSERT INTO `wiki_page` VALUES (704, 8, 0x4d616b657379736f706f6b, 0x7379736f70, 0, 0, 0, 0.489290851915, 0x3230303730313331323030363134, 704, 31);
INSERT INTO `wiki_page` VALUES (705, 8, 0x4d616b657379736f707375626d6974, 0x7379736f70, 0, 0, 0, 0.916523355979, 0x3230303730313331323030363134, 705, 27);
INSERT INTO `wiki_page` VALUES (706, 8, 0x4d616b657379736f7074657874, 0x7379736f70, 0, 0, 0, 0.458538717288, 0x3230303730313331323030363134, 706, 168);
INSERT INTO `wiki_page` VALUES (707, 8, 0x4d616b657379736f707469746c65, 0x7379736f70, 0, 0, 0, 0.181093099847, 0x3230303730313331323030363134, 707, 24);
INSERT INTO `wiki_page` VALUES (708, 8, 0x4d6172, 0x7379736f70, 0, 0, 0, 0.955030822582, 0x3230303730313331323030363134, 708, 3);
INSERT INTO `wiki_page` VALUES (709, 8, 0x4d61726368, 0x7379736f70, 0, 0, 0, 0.998984856288, 0x3230303730313331323030363134, 709, 5);
INSERT INTO `wiki_page` VALUES (710, 8, 0x4d61726b6173706174726f6c6c656464696666, 0x7379736f70, 0, 0, 0, 0.712415168392, 0x3230303730313331323030363134, 710, 17);
INSERT INTO `wiki_page` VALUES (711, 8, 0x4d61726b6173706174726f6c6c65646c696e6b, 0x7379736f70, 0, 0, 0, 0.019678015452, 0x3230303730313331323030363134, 711, 4);
INSERT INTO `wiki_page` VALUES (712, 8, 0x4d61726b6173706174726f6c6c656474657874, 0x7379736f70, 0, 0, 0, 0.216054195912, 0x3230303730313331323030363134, 712, 30);
INSERT INTO `wiki_page` VALUES (713, 8, 0x4d61726b65646173706174726f6c6c6564, 0x7379736f70, 0, 0, 0, 0.04122951599, 0x3230303730313331323030363134, 713, 19);
INSERT INTO `wiki_page` VALUES (714, 8, 0x4d61726b65646173706174726f6c6c65646572726f72, 0x7379736f70, 0, 0, 0, 0.351490395071, 0x3230303730313331323030363134, 714, 24);
INSERT INTO `wiki_page` VALUES (715, 8, 0x4d61726b65646173706174726f6c6c65646572726f7274657874, 0x7379736f70, 0, 0, 0, 0.303779701393, 0x3230303730313331323030363134, 715, 52);
INSERT INTO `wiki_page` VALUES (716, 8, 0x4d61726b65646173706174726f6c6c656474657874, 0x7379736f70, 0, 0, 0, 0.073751122095, 0x3230303730313331323030363134, 716, 51);
INSERT INTO `wiki_page` VALUES (717, 8, 0x4d61746368746f74616c73, 0x7379736f70, 0, 0, 0, 0.562157386965, 0x3230303730313331323030363134, 717, 63);
INSERT INTO `wiki_page` VALUES (718, 8, 0x4d617468, 0x7379736f70, 0, 0, 0, 0.724450025752, 0x3230303730313331323030363134, 718, 4);
INSERT INTO `wiki_page` VALUES (719, 8, 0x4d6174685f6261645f6f7574707574, 0x7379736f70, 0, 0, 0, 0.498640360071, 0x3230303730313331323030363134, 719, 46);
INSERT INTO `wiki_page` VALUES (720, 8, 0x4d6174685f6261645f746d70646972, 0x7379736f70, 0, 0, 0, 0.184921847701, 0x3230303730313331323030363134, 720, 44);
INSERT INTO `wiki_page` VALUES (721, 8, 0x4d6174685f6661696c757265, 0x7379736f70, 0, 0, 0, 0.082420536232, 0x3230303730313331323030363135, 721, 15);
INSERT INTO `wiki_page` VALUES (722, 8, 0x4d6174685f696d6167655f6572726f72, 0x7379736f70, 0, 0, 0, 0.058620739827, 0x3230303730313331323030363135, 722, 86);
INSERT INTO `wiki_page` VALUES (723, 8, 0x4d6174685f6c6578696e675f6572726f72, 0x7379736f70, 0, 0, 0, 0.42838962962, 0x3230303730313331323030363135, 723, 12);
INSERT INTO `wiki_page` VALUES (724, 8, 0x4d6174685f6e6f7465787663, 0x7379736f70, 0, 0, 0, 0.387746752769, 0x3230303730313331323030363135, 724, 62);
INSERT INTO `wiki_page` VALUES (725, 8, 0x4d6174685f73616d706c65, 0x7379736f70, 0, 0, 0, 0.374436132931, 0x3230303730313331323030363135, 725, 19);
INSERT INTO `wiki_page` VALUES (726, 8, 0x4d6174685f73796e7461785f6572726f72, 0x7379736f70, 0, 0, 0, 0.234464077673, 0x3230303730313331323030363135, 726, 12);
INSERT INTO `wiki_page` VALUES (727, 8, 0x4d6174685f746970, 0x7379736f70, 0, 0, 0, 0.436217420679, 0x3230303730313331323030363135, 727, 28);
INSERT INTO `wiki_page` VALUES (728, 8, 0x4d6174685f756e6b6e6f776e5f6572726f72, 0x7379736f70, 0, 0, 0, 0.24171206469, 0x3230303730313331323030363135, 728, 13);
INSERT INTO `wiki_page` VALUES (729, 8, 0x4d6174685f756e6b6e6f776e5f66756e6374696f6e, 0x7379736f70, 0, 0, 0, 0.493133889612, 0x3230303730313331323030363135, 729, 16);
INSERT INTO `wiki_page` VALUES (730, 8, 0x4d6179, 0x7379736f70, 0, 0, 0, 0.946877246569, 0x3230303730313331323030363135, 730, 3);
INSERT INTO `wiki_page` VALUES (731, 8, 0x4d61795f6c6f6e67, 0x7379736f70, 0, 0, 0, 0.79562753932, 0x3230303730313331323030363135, 731, 3);
INSERT INTO `wiki_page` VALUES (732, 8, 0x4d656469615f73616d706c65, 0x7379736f70, 0, 0, 0, 0.112145006642, 0x3230303730313331323030363135, 732, 11);
INSERT INTO `wiki_page` VALUES (733, 8, 0x4d656469615f746970, 0x7379736f70, 0, 0, 0, 0.948287873313, 0x3230303730313331323030363135, 733, 15);
INSERT INTO `wiki_page` VALUES (734, 8, 0x4d656469617761726e696e67, 0x7379736f70, 0, 0, 0, 0.705638025584, 0x3230303730313331323030363135, 734, 105);
INSERT INTO `wiki_page` VALUES (735, 8, 0x4d65746164617461, 0x7379736f70, 0, 0, 0, 0.043160542487, 0x3230303730313331323030363135, 735, 8);
INSERT INTO `wiki_page` VALUES (736, 8, 0x4d657461646174612d636f6c6c61707365, 0x7379736f70, 0, 0, 0, 0.296931701148, 0x3230303730313331323030363135, 736, 21);
INSERT INTO `wiki_page` VALUES (737, 8, 0x4d657461646174612d657870616e64, 0x7379736f70, 0, 0, 0, 0.296274875188, 0x3230303730313331323030363135, 737, 21);
INSERT INTO `wiki_page` VALUES (738, 8, 0x4d657461646174612d6669656c6473, 0x7379736f70, 0, 0, 0, 0.898175344943, 0x3230303730313331323030363135, 738, 227);
INSERT INTO `wiki_page` VALUES (739, 8, 0x4d657461646174612d68656c70, 0x7379736f70, 0, 0, 0, 0.914270523656, 0x3230303730313331323030363135, 739, 233);
INSERT INTO `wiki_page` VALUES (740, 8, 0x4d657461646174615f70616765, 0x7379736f70, 0, 0, 0, 0.966949135104, 0x3230303730313331323030363135, 740, 18);
INSERT INTO `wiki_page` VALUES (741, 8, 0x4d696d65736561726368, 0x7379736f70, 0, 0, 0, 0.86967328511, 0x3230303730313331323030363135, 741, 11);
INSERT INTO `wiki_page` VALUES (742, 8, 0x4d696d6574797065, 0x7379736f70, 0, 0, 0, 0.303628249029, 0x3230303730313331323030363135, 742, 10);
INSERT INTO `wiki_page` VALUES (743, 8, 0x4d696e6c656e677468, 0x7379736f70, 0, 0, 0, 0.428885461183, 0x3230303730313331323030363135, 743, 42);
INSERT INTO `wiki_page` VALUES (744, 8, 0x4d696e6f7265646974, 0x7379736f70, 0, 0, 0, 0.634297600364, 0x3230303730313331323030363135, 744, 20);
INSERT INTO `wiki_page` VALUES (745, 8, 0x4d696e6f72656469746c6574746572, 0x7379736f70, 0, 0, 0, 0.934570311257, 0x3230303730313331323030363135, 745, 1);
INSERT INTO `wiki_page` VALUES (746, 8, 0x4d697373696e6761727469636c65, 0x7379736f70, 0, 0, 0, 0.982150406439, 0x3230303730313331323030363135, 746, 318);
INSERT INTO `wiki_page` VALUES (747, 8, 0x4d697373696e67636f6d6d656e7474657874, 0x7379736f70, 0, 0, 0, 0.034493387404, 0x3230303730313331323030363135, 747, 29);
INSERT INTO `wiki_page` VALUES (748, 8, 0x4d697373696e67696d616765, 0x7379736f70, 0, 0, 0, 0.146014706652, 0x3230303730313331323030363135, 748, 35);
INSERT INTO `wiki_page` VALUES (749, 8, 0x4d697373696e6773756d6d617279, 0x7379736f70, 0, 0, 0, 0.115933757984, 0x3230303730313331323030363135, 749, 116);
INSERT INTO `wiki_page` VALUES (750, 8, 0x4d6f6e646179, 0x7379736f70, 0, 0, 0, 0.666535176107, 0x3230303730313331323030363135, 750, 6);
INSERT INTO `wiki_page` VALUES (751, 8, 0x4d6f7265646f74646f74646f74, 0x7379736f70, 0, 0, 0, 0.643966932569, 0x3230303730313331323030363135, 751, 7);
INSERT INTO `wiki_page` VALUES (752, 8, 0x4d6f737463617465676f72696573, 0x7379736f70, 0, 0, 0, 0.061178377933, 0x3230303730313331323030363135, 752, 33);
INSERT INTO `wiki_page` VALUES (753, 8, 0x4d6f7374696d61676573, 0x7379736f70, 0, 0, 0, 0.346422417667, 0x3230303730313331323030363135, 753, 21);
INSERT INTO `wiki_page` VALUES (754, 8, 0x4d6f73746c696e6b6564, 0x7379736f70, 0, 0, 0, 0.725695669106, 0x3230303730313331323030363135, 754, 20);
INSERT INTO `wiki_page` VALUES (755, 8, 0x4d6f73746c696e6b656463617465676f72696573, 0x7379736f70, 0, 0, 0, 0.71233517768, 0x3230303730313331323030363135, 755, 25);
INSERT INTO `wiki_page` VALUES (756, 8, 0x4d6f73747265766973696f6e73, 0x7379736f70, 0, 0, 0, 0.019579873435, 0x3230303730313331323030363135, 756, 32);
INSERT INTO `wiki_page` VALUES (757, 8, 0x4d6f7665, 0x7379736f70, 0, 0, 0, 0.467824018496, 0x3230303730313331323030363135, 757, 4);
INSERT INTO `wiki_page` VALUES (758, 8, 0x4d6f766561727469636c65, 0x7379736f70, 0, 0, 0, 0.469100090499, 0x3230303730313331323030363135, 758, 9);
INSERT INTO `wiki_page` VALUES (759, 8, 0x4d6f766564746f, 0x7379736f70, 0, 0, 0, 0.281023064718, 0x3230303730313331323030363135, 759, 8);
INSERT INTO `wiki_page` VALUES (760, 8, 0x4d6f76656c6f6770616765, 0x7379736f70, 0, 0, 0, 0.75423536259, 0x3230303730313331323030363135, 760, 8);
INSERT INTO `wiki_page` VALUES (761, 8, 0x4d6f76656c6f677061676574657874, 0x7379736f70, 0, 0, 0, 0.023466490375, 0x3230303730313331323030363135, 761, 30);
INSERT INTO `wiki_page` VALUES (762, 8, 0x4d6f76656e6f6c6f67696e, 0x7379736f70, 0, 0, 0, 0.515169741091, 0x3230303730313331323030363135, 762, 13);
INSERT INTO `wiki_page` VALUES (763, 8, 0x4d6f76656e6f6c6f67696e74657874, 0x7379736f70, 0, 0, 0, 0.160499444451, 0x3230303730313331323030363135, 763, 81);
INSERT INTO `wiki_page` VALUES (764, 8, 0x4d6f766570616765, 0x7379736f70, 0, 0, 0, 0.414889304679, 0x3230303730313331323030363135, 764, 9);
INSERT INTO `wiki_page` VALUES (765, 8, 0x4d6f76657061676562746e, 0x7379736f70, 0, 0, 0, 0.803603251566, 0x3230303730313331323030363135, 765, 9);
INSERT INTO `wiki_page` VALUES (766, 8, 0x4d6f76657061676574616c6b74657874, 0x7379736f70, 0, 0, 0, 0.784044640207, 0x3230303730313331323030363135, 766, 300);
INSERT INTO `wiki_page` VALUES (767, 8, 0x4d6f76657061676574657874, 0x7379736f70, 0, 0, 0, 0.406755466139, 0x3230303730313331323030363135, 767, 787);
INSERT INTO `wiki_page` VALUES (768, 8, 0x4d6f7665726561736f6e, 0x7379736f70, 0, 0, 0, 0.820949190586, 0x3230303730313331323030363135, 768, 6);
INSERT INTO `wiki_page` VALUES (769, 8, 0x4d6f766574616c6b, 0x7379736f70, 0, 0, 0, 0.419512919685, 0x3230303730313331323030363135, 769, 25);
INSERT INTO `wiki_page` VALUES (770, 8, 0x4d6f76657468697370616765, 0x7379736f70, 0, 0, 0, 0.208971291446, 0x3230303730313331323030363135, 770, 14);
INSERT INTO `wiki_page` VALUES (771, 8, 0x4d775f6d6174685f68746d6c, 0x7379736f70, 0, 0, 0, 0.362992208965, 0x3230303730313331323030363135, 771, 28);
INSERT INTO `wiki_page` VALUES (772, 8, 0x4d775f6d6174685f6d6174686d6c, 0x7379736f70, 0, 0, 0, 0.126078246281, 0x3230303730313331323030363135, 772, 33);
INSERT INTO `wiki_page` VALUES (773, 8, 0x4d775f6d6174685f6d6f6465726e, 0x7379736f70, 0, 0, 0, 0.986925447088, 0x3230303730313331323030363135, 773, 31);
INSERT INTO `wiki_page` VALUES (774, 8, 0x4d775f6d6174685f706e67, 0x7379736f70, 0, 0, 0, 0.516869114519, 0x3230303730313331323030363135, 774, 17);
INSERT INTO `wiki_page` VALUES (775, 8, 0x4d775f6d6174685f73696d706c65, 0x7379736f70, 0, 0, 0, 0.763174372703, 0x3230303730313331323030363135, 775, 31);
INSERT INTO `wiki_page` VALUES (776, 8, 0x4d775f6d6174685f736f75726365, 0x7379736f70, 0, 0, 0, 0.99629570802, 0x3230303730313331323030363135, 776, 35);
INSERT INTO `wiki_page` VALUES (777, 8, 0x4d79636f6e74726973, 0x7379736f70, 0, 0, 0, 0.099323765253, 0x3230303730313331323030363135, 777, 16);
INSERT INTO `wiki_page` VALUES (778, 8, 0x4d7970616765, 0x7379736f70, 0, 0, 0, 0.367121193773, 0x3230303730313331323030363135, 778, 7);
INSERT INTO `wiki_page` VALUES (779, 8, 0x4d7974616c6b, 0x7379736f70, 0, 0, 0, 0.415943413183, 0x3230303730313331323030363135, 779, 7);
INSERT INTO `wiki_page` VALUES (780, 8, 0x4e616d657370616365, 0x7379736f70, 0, 0, 0, 0.384524984993, 0x3230303730313331323030363135, 780, 10);
INSERT INTO `wiki_page` VALUES (781, 8, 0x4e616d65737061636573616c6c, 0x7379736f70, 0, 0, 0, 0.336928012946, 0x3230303730313331323030363135, 781, 3);
INSERT INTO `wiki_page` VALUES (782, 8, 0x4e617669676174696f6e, 0x7379736f70, 0, 0, 0, 0.968146861893, 0x3230303730313331323030363135, 782, 10);
INSERT INTO `wiki_page` VALUES (783, 8, 0x4e6279746573, 0x7379736f70, 0, 0, 0, 0.029009125469, 0x3230303730313331323030363135, 783, 8);
INSERT INTO `wiki_page` VALUES (784, 8, 0x4e63617465676f72696573, 0x7379736f70, 0, 0, 0, 0.955314543172, 0x3230303730313331323030363135, 784, 13);
INSERT INTO `wiki_page` VALUES (785, 8, 0x4e6368616e676573, 0x7379736f70, 0, 0, 0, 0.913658377886, 0x3230303730313331323030363135, 785, 10);
INSERT INTO `wiki_page` VALUES (786, 8, 0x4e657761727469636c65, 0x7379736f70, 0, 0, 0, 0.616847913254, 0x3230303730313331323030363135, 786, 5);
INSERT INTO `wiki_page` VALUES (787, 8, 0x4e657761727469636c6574657874, 0x7379736f70, 0, 0, 0, 0.583306285221, 0x3230303730313331323030363135, 787, 231);
INSERT INTO `wiki_page` VALUES (788, 8, 0x4e657761727469636c6574657874616e6f6e, 0x7379736f70, 0, 0, 0, 0.248038886761, 0x3230303730313331323030363135, 788, 22);
INSERT INTO `wiki_page` VALUES (789, 8, 0x4e657762696573, 0x7379736f70, 0, 0, 0, 0.115819997284, 0x3230303730313331323030363135, 789, 7);
INSERT INTO `wiki_page` VALUES (790, 8, 0x4e6577696d61676573, 0x7379736f70, 0, 0, 0, 0.680050669768, 0x3230303730313331323030363135, 790, 20);
INSERT INTO `wiki_page` VALUES (791, 8, 0x4e65776d65737361676573646966666c696e6b, 0x7379736f70, 0, 0, 0, 0.979518579258, 0x3230303730313331323030363135, 791, 28);
INSERT INTO `wiki_page` VALUES (792, 8, 0x4e65776d657373616765736c696e6b, 0x7379736f70, 0, 0, 0, 0.873874314595, 0x3230303730313331323030363135, 792, 12);
INSERT INTO `wiki_page` VALUES (793, 8, 0x4e657770616765, 0x7379736f70, 0, 0, 0, 0.931269964091, 0x3230303730313331323030363135, 793, 8);
INSERT INTO `wiki_page` VALUES (794, 8, 0x4e6577706167656c6574746572, 0x7379736f70, 0, 0, 0, 0.480570549271, 0x3230303730313331323030363135, 794, 1);
INSERT INTO `wiki_page` VALUES (795, 8, 0x4e65777061676573, 0x7379736f70, 0, 0, 0, 0.073033721954, 0x3230303730313331323030363135, 795, 9);
INSERT INTO `wiki_page` VALUES (796, 8, 0x4e657770617373776f7264, 0x7379736f70, 0, 0, 0, 0.037415853117, 0x3230303730313331323030363135, 796, 13);
INSERT INTO `wiki_page` VALUES (797, 8, 0x4e657774616c6b736570657261746f72, 0x7379736f70, 0, 0, 0, 0.31009384272, 0x3230303730313331323030363135, 797, 2);
INSERT INTO `wiki_page` VALUES (798, 8, 0x4e65777469746c65, 0x7379736f70, 0, 0, 0, 0.128877478365, 0x3230303730313331323030363135, 798, 12);
INSERT INTO `wiki_page` VALUES (799, 8, 0x4e657775736572736f6e6c79, 0x7379736f70, 0, 0, 0, 0.049162023582, 0x3230303730313331323030363135, 799, 17);
INSERT INTO `wiki_page` VALUES (800, 8, 0x4e657777696e646f77, 0x7379736f70, 0, 0, 0, 0.434553199889, 0x3230303730313331323030363136, 800, 21);
INSERT INTO `wiki_page` VALUES (801, 8, 0x4e657874, 0x7379736f70, 0, 0, 0, 0.597361521433, 0x3230303730313331323030363136, 801, 4);
INSERT INTO `wiki_page` VALUES (802, 8, 0x4e65787464696666, 0x7379736f70, 0, 0, 0, 0.261029027148, 0x3230303730313331323030363136, 802, 13);
INSERT INTO `wiki_page` VALUES (803, 8, 0x4e6578746e, 0x7379736f70, 0, 0, 0, 0.691145852957, 0x3230303730313331323030363136, 803, 7);
INSERT INTO `wiki_page` VALUES (804, 8, 0x4e65787470616765, 0x7379736f70, 0, 0, 0, 0.934028249877, 0x3230303730313331323030363136, 804, 14);
INSERT INTO `wiki_page` VALUES (805, 8, 0x4e6578747265766973696f6e, 0x7379736f70, 0, 0, 0, 0.498486534051, 0x3230303730313331323030363136, 805, 17);
INSERT INTO `wiki_page` VALUES (806, 8, 0x4e6c696e6b73, 0x7379736f70, 0, 0, 0, 0.566009685342, 0x3230303730313331323030363136, 806, 8);
INSERT INTO `wiki_page` VALUES (807, 8, 0x4e6f61727469636c6574657874, 0x7379736f70, 0, 0, 0, 0.761106361753, 0x3230303730313331323030363136, 807, 201);
INSERT INTO `wiki_page` VALUES (808, 8, 0x4e6f61727469636c6574657874616e6f6e, 0x7379736f70, 0, 0, 0, 0.069450273242, 0x3230303730313331323030363136, 808, 21);
INSERT INTO `wiki_page` VALUES (809, 8, 0x4e6f636f6e6e656374, 0x7379736f70, 0, 0, 0, 0.44065279696, 0x3230303730313331323030363136, 809, 110);
INSERT INTO `wiki_page` VALUES (810, 8, 0x4e6f636f6e7472696273, 0x7379736f70, 0, 0, 0, 0.973915551508, 0x3230303730313331323030363136, 810, 46);
INSERT INTO `wiki_page` VALUES (811, 8, 0x4e6f636f6f6b6965736c6f67696e, 0x7379736f70, 0, 0, 0, 0.775736457429, 0x3230303730313331323030363136, 811, 103);
INSERT INTO `wiki_page` VALUES (812, 8, 0x4e6f636f6f6b6965736e6577, 0x7379736f70, 0, 0, 0, 0.533774310934, 0x3230303730313331323030363136, 812, 195);
INSERT INTO `wiki_page` VALUES (813, 8, 0x4e6f63726561746574657874, 0x7379736f70, 0, 0, 0, 0.276674710075, 0x3230303730313331323030363136, 813, 154);
INSERT INTO `wiki_page` VALUES (814, 8, 0x4e6f6372656174657469746c65, 0x7379736f70, 0, 0, 0, 0.731221275967, 0x3230303730313331323030363136, 814, 21);
INSERT INTO `wiki_page` VALUES (815, 8, 0x4e6f6372656174697665636f6d6d6f6e73, 0x7379736f70, 0, 0, 0, 0.07207145812, 0x3230303730313331323030363136, 815, 55);
INSERT INTO `wiki_page` VALUES (816, 8, 0x4e6f63726564697473, 0x7379736f70, 0, 0, 0, 0.231600773325, 0x3230303730313331323030363136, 816, 49);
INSERT INTO `wiki_page` VALUES (817, 8, 0x4e6f6462, 0x7379736f70, 0, 0, 0, 0.251678664002, 0x3230303730313331323030363136, 817, 28);
INSERT INTO `wiki_page` VALUES (818, 8, 0x4e6f6475626c696e636f7265, 0x7379736f70, 0, 0, 0, 0.219054741125, 0x3230303730313331323030363136, 818, 50);
INSERT INTO `wiki_page` VALUES (819, 8, 0x4e6f656d61696c, 0x7379736f70, 0, 0, 0, 0.603737033181, 0x3230303730313331323030363136, 819, 50);
INSERT INTO `wiki_page` VALUES (820, 8, 0x4e6f656d61696c7072656673, 0x7379736f70, 0, 0, 0, 0.642102130212, 0x3230303730313331323030363136, 820, 70);
INSERT INTO `wiki_page` VALUES (821, 8, 0x4e6f656d61696c74657874, 0x7379736f70, 0, 0, 0, 0.829998766987, 0x3230303730313331323030363136, 821, 105);
INSERT INTO `wiki_page` VALUES (822, 8, 0x4e6f656d61696c7469746c65, 0x7379736f70, 0, 0, 0, 0.50346358823, 0x3230303730313331323030363136, 822, 17);
INSERT INTO `wiki_page` VALUES (823, 8, 0x4e6f676f6d61746368, 0x7379736f70, 0, 0, 0, 0.336607226522, 0x3230303730313331323030363136, 823, 68);
INSERT INTO `wiki_page` VALUES (824, 8, 0x4e6f686973746f7279, 0x7379736f70, 0, 0, 0, 0.897825225362, 0x3230303730313331323030363136, 824, 39);
INSERT INTO `wiki_page` VALUES (825, 8, 0x4e6f696d616765, 0x7379736f70, 0, 0, 0, 0.962416966154, 0x3230303730313331323030363136, 825, 40);
INSERT INTO `wiki_page` VALUES (826, 8, 0x4e6f696d6167652d6c696e6b74657874, 0x7379736f70, 0, 0, 0, 0.180550829266, 0x3230303730313331323030363136, 826, 9);
INSERT INTO `wiki_page` VALUES (827, 8, 0x4e6f696d61676573, 0x7379736f70, 0, 0, 0, 0.043226460317, 0x3230303730313331323030363136, 827, 15);
INSERT INTO `wiki_page` VALUES (828, 8, 0x4e6f6c6963656e7365, 0x7379736f70, 0, 0, 0, 0.629496175011, 0x3230303730313331323030363136, 828, 13);
INSERT INTO `wiki_page` VALUES (829, 8, 0x4e6f6c696e6b7368657265, 0x7379736f70, 0, 0, 0, 0.929612750142, 0x3230303730313331323030363136, 829, 22);
INSERT INTO `wiki_page` VALUES (830, 8, 0x4e6f6c696e6b73746f696d616765, 0x7379736f70, 0, 0, 0, 0.6813432779, 0x3230303730313331323030363136, 830, 42);
INSERT INTO `wiki_page` VALUES (831, 8, 0x4e6f6c6f67696e, 0x7379736f70, 0, 0, 0, 0.062210862377, 0x3230303730313331323030363136, 831, 23);
INSERT INTO `wiki_page` VALUES (832, 8, 0x4e6f6c6f67696e6c696e6b, 0x7379736f70, 0, 0, 0, 0.346130356507, 0x3230303730313331323030363136, 832, 17);
INSERT INTO `wiki_page` VALUES (833, 8, 0x4e6f6e616d65, 0x7379736f70, 0, 0, 0, 0.973336681201, 0x3230303730313331323030363136, 833, 41);
INSERT INTO `wiki_page` VALUES (834, 8, 0x4e6f6e65666f756e64, 0x7379736f70, 0, 0, 0, 0.269880615655, 0x3230303730313331323030363136, 834, 245);
INSERT INTO `wiki_page` VALUES (835, 8, 0x4e6f6e756e69636f646562726f77736572, 0x7379736f70, 0, 0, 0, 0.110172698893, 0x3230303730313331323030363136, 835, 198);
INSERT INTO `wiki_page` VALUES (836, 8, 0x4e6f7370656369616c7061676574657874, 0x7379736f70, 0, 0, 0, 0.09037748292, 0x3230303730313331323030363136, 836, 122);
INSERT INTO `wiki_page` VALUES (837, 8, 0x4e6f73756368616374696f6e, 0x7379736f70, 0, 0, 0, 0.336964600264, 0x3230303730313331323030363136, 837, 14);
INSERT INTO `wiki_page` VALUES (838, 8, 0x4e6f73756368616374696f6e74657874, 0x7379736f70, 0, 0, 0, 0.627401494719, 0x3230303730313331323030363136, 838, 61);
INSERT INTO `wiki_page` VALUES (839, 8, 0x4e6f737563687370656369616c70616765, 0x7379736f70, 0, 0, 0, 0.766652870935, 0x3230303730313331323030363136, 839, 20);
INSERT INTO `wiki_page` VALUES (840, 8, 0x4e6f7375636875736572, 0x7379736f70, 0, 0, 0, 0.370827520362, 0x3230303730313331323030363136, 840, 80);
INSERT INTO `wiki_page` VALUES (841, 8, 0x4e6f737563687573657273686f7274, 0x7379736f70, 0, 0, 0, 0.056944015391, 0x3230303730313331323030363136, 841, 55);
INSERT INTO `wiki_page` VALUES (842, 8, 0x4e6f7461636365707461626c65, 0x7379736f70, 0, 0, 0, 0.688993229285, 0x3230303730313331323030363136, 842, 68);
INSERT INTO `wiki_page` VALUES (843, 8, 0x4e6f74616e61727469636c65, 0x7379736f70, 0, 0, 0, 0.918451782977, 0x3230303730313331323030363136, 843, 18);
INSERT INTO `wiki_page` VALUES (844, 8, 0x4e6f74617267657474657874, 0x7379736f70, 0, 0, 0, 0.704215429462, 0x3230303730313331323030363136, 844, 73);
INSERT INTO `wiki_page` VALUES (845, 8, 0x4e6f7461726765747469746c65, 0x7379736f70, 0, 0, 0, 0.693976589168, 0x3230303730313331323030363136, 845, 9);
INSERT INTO `wiki_page` VALUES (846, 8, 0x4e6f7465, 0x7379736f70, 0, 0, 0, 0.674427837075, 0x3230303730313331323030363136, 846, 22);
INSERT INTO `wiki_page` VALUES (847, 8, 0x4e6f746578746d617463686573, 0x7379736f70, 0, 0, 0, 0.849877092781, 0x3230303730313331323030363136, 847, 20);
INSERT INTO `wiki_page` VALUES (848, 8, 0x4e6f7469746c656d617463686573, 0x7379736f70, 0, 0, 0, 0.904616503551, 0x3230303730313331323030363136, 848, 21);
INSERT INTO `wiki_page` VALUES (849, 8, 0x4e6f746c6f67676564696e, 0x7379736f70, 0, 0, 0, 0.777013987618, 0x3230303730313331323030363136, 849, 13);
INSERT INTO `wiki_page` VALUES (850, 8, 0x4e6f75736572737065636966696564, 0x7379736f70, 0, 0, 0, 0.823337026144, 0x3230303730313331323030363136, 850, 31);
INSERT INTO `wiki_page` VALUES (851, 8, 0x4e6f76, 0x7379736f70, 0, 0, 0, 0.957291426406, 0x3230303730313331323030363136, 851, 3);
INSERT INTO `wiki_page` VALUES (852, 8, 0x4e6f76656d626572, 0x7379736f70, 0, 0, 0, 0.368945624131, 0x3230303730313331323030363136, 852, 8);
INSERT INTO `wiki_page` VALUES (853, 8, 0x4e6f77617463686c697374, 0x7379736f70, 0, 0, 0, 0.644895862827, 0x3230303730313331323030363136, 853, 36);
INSERT INTO `wiki_page` VALUES (854, 8, 0x4e6f77696b695f73616d706c65, 0x7379736f70, 0, 0, 0, 0.070177313983, 0x3230303730313331323030363136, 854, 30);
INSERT INTO `wiki_page` VALUES (855, 8, 0x4e6f77696b695f746970, 0x7379736f70, 0, 0, 0, 0.140083517592, 0x3230303730313331323030363136, 855, 22);
INSERT INTO `wiki_page` VALUES (856, 8, 0x4e7265766973696f6e73, 0x7379736f70, 0, 0, 0, 0.119643383616, 0x3230303730313331323030363136, 856, 12);
INSERT INTO `wiki_page` VALUES (857, 8, 0x4e737461622d63617465676f7279, 0x7379736f70, 0, 0, 0, 0.084439161464, 0x3230303730313331323030363136, 857, 8);
INSERT INTO `wiki_page` VALUES (858, 8, 0x4e737461622d68656c70, 0x7379736f70, 0, 0, 0, 0.471468807209, 0x3230303730313331323030363136, 858, 4);
INSERT INTO `wiki_page` VALUES (859, 8, 0x4e737461622d696d616765, 0x7379736f70, 0, 0, 0, 0.601831664465, 0x3230303730313331323030363136, 859, 4);
INSERT INTO `wiki_page` VALUES (860, 8, 0x4e737461622d6d61696e, 0x7379736f70, 0, 0, 0, 0.355222686291, 0x3230303730313331323030363136, 860, 7);
INSERT INTO `wiki_page` VALUES (861, 8, 0x4e737461622d6d65646961, 0x7379736f70, 0, 0, 0, 0.054769401838, 0x3230303730313331323030363136, 861, 10);
INSERT INTO `wiki_page` VALUES (862, 8, 0x4e737461622d6d6564696177696b69, 0x7379736f70, 0, 0, 0, 0.847355688535, 0x3230303730313331323030363136, 862, 7);
INSERT INTO `wiki_page` VALUES (863, 8, 0x4e737461622d7370656369616c, 0x7379736f70, 0, 0, 0, 0.672613829775, 0x3230303730313331323030363136, 863, 7);
INSERT INTO `wiki_page` VALUES (864, 8, 0x4e737461622d74656d706c617465, 0x7379736f70, 0, 0, 0, 0.743683899214, 0x3230303730313331323030363136, 864, 8);
INSERT INTO `wiki_page` VALUES (865, 8, 0x4e737461622d75736572, 0x7379736f70, 0, 0, 0, 0.48211487972, 0x3230303730313331323030363136, 865, 9);
INSERT INTO `wiki_page` VALUES (866, 8, 0x4e737461622d7770, 0x7379736f70, 0, 0, 0, 0.83735673606, 0x3230303730313331323030363136, 866, 12);
INSERT INTO `wiki_page` VALUES (867, 8, 0x4e756d617574686f7273, 0x7379736f70, 0, 0, 0, 0.022666061164, 0x3230303730313331323030363136, 867, 40);
INSERT INTO `wiki_page` VALUES (868, 8, 0x4e756d6265725f6f665f7761746368696e675f75736572735f524376696577, 0x7379736f70, 0, 0, 0, 0.901873063052, 0x3230303730313331323030363136, 868, 4);
INSERT INTO `wiki_page` VALUES (869, 8, 0x4e756d6265725f6f665f7761746368696e675f75736572735f7061676576696577, 0x7379736f70, 0, 0, 0, 0.166768442333, 0x3230303730313331323030363136, 869, 20);
INSERT INTO `wiki_page` VALUES (870, 8, 0x4e756d6564697473, 0x7379736f70, 0, 0, 0, 0.208327389359, 0x3230303730313331323030363136, 870, 29);
INSERT INTO `wiki_page` VALUES (871, 8, 0x4e756d74616c6b617574686f7273, 0x7379736f70, 0, 0, 0, 0.722400529119, 0x3230303730313331323030363136, 871, 48);
INSERT INTO `wiki_page` VALUES (872, 8, 0x4e756d74616c6b6564697473, 0x7379736f70, 0, 0, 0, 0.916629077181, 0x3230303730313331323030363136, 872, 37);
INSERT INTO `wiki_page` VALUES (873, 8, 0x4e756d7761746368657273, 0x7379736f70, 0, 0, 0, 0.647749905993, 0x3230303730313331323030363136, 873, 22);
INSERT INTO `wiki_page` VALUES (874, 8, 0x4e7669657773, 0x7379736f70, 0, 0, 0, 0.669419861671, 0x3230303730313331323030363136, 874, 8);
INSERT INTO `wiki_page` VALUES (875, 8, 0x4f6374, 0x7379736f70, 0, 0, 0, 0.473578187688, 0x3230303730313331323030363136, 875, 3);
INSERT INTO `wiki_page` VALUES (876, 8, 0x4f63746f626572, 0x7379736f70, 0, 0, 0, 0.052695945671, 0x3230303730313331323030363136, 876, 7);
INSERT INTO `wiki_page` VALUES (877, 8, 0x4f6b, 0x7379736f70, 0, 0, 0, 0.557620408066, 0x3230303730313331323030363136, 877, 2);
INSERT INTO `wiki_page` VALUES (878, 8, 0x4f6c6470617373776f7264, 0x7379736f70, 0, 0, 0, 0.871637217338, 0x3230303730313331323030363136, 878, 13);
INSERT INTO `wiki_page` VALUES (879, 8, 0x4f726967, 0x7379736f70, 0, 0, 0, 0.582001965841, 0x3230303730313331323030363136, 879, 4);
INSERT INTO `wiki_page` VALUES (880, 8, 0x4f727068616e73, 0x7379736f70, 0, 0, 0, 0.924920299088, 0x3230303730313331323030363137, 880, 14);
INSERT INTO `wiki_page` VALUES (881, 8, 0x4f74686572636f6e7472696273, 0x7379736f70, 0, 0, 0, 0.104776813054, 0x3230303730313331323030363137, 881, 20);
INSERT INTO `wiki_page` VALUES (882, 8, 0x4f746865726c616e677561676573, 0x7379736f70, 0, 0, 0, 0.727010796603, 0x3230303730313331323030363137, 882, 18);
INSERT INTO `wiki_page` VALUES (883, 8, 0x4f7468657273, 0x7379736f70, 0, 0, 0, 0.483976392138, 0x3230303730313331323030363137, 883, 6);
INSERT INTO `wiki_page` VALUES (884, 8, 0x506167656d6f766564737562, 0x7379736f70, 0, 0, 0, 0.277442462175, 0x3230303730313331323030363137, 884, 14);
INSERT INTO `wiki_page` VALUES (885, 8, 0x506167656d6f76656474657874, 0x7379736f70, 0, 0, 0, 0.222895997472, 0x3230303730313331323030363137, 885, 32);
INSERT INTO `wiki_page` VALUES (886, 8, 0x506167657469746c65, 0x7379736f70, 0, 0, 0, 0.495898600535, 0x3230303730313331323030363137, 886, 17);
INSERT INTO `wiki_page` VALUES (887, 8, 0x50617373776f726472656d696e64657274657874, 0x7379736f70, 0, 0, 0, 0.161397599102, 0x3230303730313331323030363137, 887, 389);
INSERT INTO `wiki_page` VALUES (888, 8, 0x50617373776f726472656d696e6465727469746c65, 0x7379736f70, 0, 0, 0, 0.467930006968, 0x3230303730313331323030363137, 888, 35);
INSERT INTO `wiki_page` VALUES (889, 8, 0x50617373776f726473656e74, 0x7379736f70, 0, 0, 0, 0.18529155881, 0x3230303730313331323030363137, 889, 113);
INSERT INTO `wiki_page` VALUES (890, 8, 0x50617373776f7264746f6f73686f7274, 0x7379736f70, 0, 0, 0, 0.404717014663, 0x3230303730313331323030363137, 890, 64);
INSERT INTO `wiki_page` VALUES (891, 8, 0x50657266636163686564, 0x7379736f70, 0, 0, 0, 0.323538151953, 0x3230303730313331323030363137, 891, 66);
INSERT INTO `wiki_page` VALUES (892, 8, 0x5065726664697361626c6564, 0x7379736f70, 0, 0, 0, 0.398081126609, 0x3230303730313331323030363137, 892, 127);
INSERT INTO `wiki_page` VALUES (893, 8, 0x5065726664697361626c6564737562, 0x7379736f70, 0, 0, 0, 0.358059506907, 0x3230303730313331323030363137, 893, 29);
INSERT INTO `wiki_page` VALUES (894, 8, 0x5065726d616c696e6b, 0x7379736f70, 0, 0, 0, 0.620191435956, 0x3230303730313331323030363137, 894, 14);
INSERT INTO `wiki_page` VALUES (895, 8, 0x506572736f6e616c746f6f6c73, 0x7379736f70, 0, 0, 0, 0.939155401422, 0x3230303730313331323030363137, 895, 14);
INSERT INTO `wiki_page` VALUES (896, 8, 0x506f70756c61727061676573, 0x7379736f70, 0, 0, 0, 0.84352501567, 0x3230303730313331323030363137, 896, 13);
INSERT INTO `wiki_page` VALUES (897, 8, 0x506f7274616c, 0x7379736f70, 0, 0, 0, 0.245735376699, 0x3230303730313331323030363137, 897, 16);
INSERT INTO `wiki_page` VALUES (898, 8, 0x506f7274616c2d75726c, 0x7379736f70, 0, 0, 0, 0.115898403961, 0x3230303730313331323030363137, 898, 24);
INSERT INTO `wiki_page` VALUES (899, 8, 0x506f7374636f6d6d656e74, 0x7379736f70, 0, 0, 0, 0.893106549016, 0x3230303730313331323030363137, 899, 14);
INSERT INTO `wiki_page` VALUES (900, 8, 0x506f77657265646279, 0x7379736f70, 0, 0, 0, 0.884749949141, 0x3230303730313331323030363137, 900, 93);
INSERT INTO `wiki_page` VALUES (901, 8, 0x506f776572736561726368, 0x7379736f70, 0, 0, 0, 0.099659541628, 0x3230303730313331323030363137, 901, 6);
INSERT INTO `wiki_page` VALUES (902, 8, 0x506f77657273656172636874657874, 0x7379736f70, 0, 0, 0, 0.969741124471, 0x3230303730313331323030363137, 902, 80);
INSERT INTO `wiki_page` VALUES (903, 8, 0x507265666572656e636573, 0x7379736f70, 0, 0, 0, 0.4681109563, 0x3230303730313331323030363137, 903, 11);
INSERT INTO `wiki_page` VALUES (904, 8, 0x507265666978696e646578, 0x7379736f70, 0, 0, 0, 0.330964854196, 0x3230303730313331323030363137, 904, 12);
INSERT INTO `wiki_page` VALUES (905, 8, 0x50726566732d68656c702d656d61696c, 0x7379736f70, 0, 0, 0, 0.348386576353, 0x3230303730313331323030363137, 905, 131);
INSERT INTO `wiki_page` VALUES (906, 8, 0x50726566732d68656c702d656d61696c2d656e6f746966, 0x7379736f70, 0, 0, 0, 0.91983826094, 0x3230303730313331323030363137, 906, 86);
INSERT INTO `wiki_page` VALUES (907, 8, 0x50726566732d68656c702d7265616c6e616d65, 0x7379736f70, 0, 0, 0, 0.344320846171, 0x3230303730313331323030363137, 907, 111);
INSERT INTO `wiki_page` VALUES (908, 8, 0x50726566732d6d697363, 0x7379736f70, 0, 0, 0, 0.498217418147, 0x3230303730313331323030363137, 908, 4);
INSERT INTO `wiki_page` VALUES (909, 8, 0x50726566732d706572736f6e616c, 0x7379736f70, 0, 0, 0, 0.641248648339, 0x3230303730313331323030363137, 909, 12);
INSERT INTO `wiki_page` VALUES (910, 8, 0x50726566732d7263, 0x7379736f70, 0, 0, 0, 0.813347428961, 0x3230303730313331323030363137, 910, 14);
INSERT INTO `wiki_page` VALUES (911, 8, 0x50726566736e6f6c6f67696e, 0x7379736f70, 0, 0, 0, 0.467252220633, 0x3230303730313331323030363137, 911, 13);
INSERT INTO `wiki_page` VALUES (912, 8, 0x50726566736e6f6c6f67696e74657874, 0x7379736f70, 0, 0, 0, 0.825307042733, 0x3230303730313331323030363137, 912, 68);
INSERT INTO `wiki_page` VALUES (913, 8, 0x50726566737265736574, 0x7379736f70, 0, 0, 0, 0.792486317768, 0x3230303730313331323030363137, 913, 41);
INSERT INTO `wiki_page` VALUES (914, 8, 0x50726576696577, 0x7379736f70, 0, 0, 0, 0.819867155773, 0x3230303730313331323030363137, 914, 7);
INSERT INTO `wiki_page` VALUES (915, 8, 0x50726576696577636f6e666c696374, 0x7379736f70, 0, 0, 0, 0.980151100808, 0x3230303730313331323030363137, 915, 102);
INSERT INTO `wiki_page` VALUES (916, 8, 0x507265766965776e6f7465, 0x7379736f70, 0, 0, 0, 0.456481171552, 0x3230303730313331323030363137, 916, 73);
INSERT INTO `wiki_page` VALUES (917, 8, 0x50726576696f757364696666, 0x7379736f70, 0, 0, 0, 0.401198497143, 0x3230303730313331323030363137, 917, 17);
INSERT INTO `wiki_page` VALUES (918, 8, 0x50726576696f75737265766973696f6e, 0x7379736f70, 0, 0, 0, 0.102061213618, 0x3230303730313331323030363137, 918, 17);
INSERT INTO `wiki_page` VALUES (919, 8, 0x507265766e, 0x7379736f70, 0, 0, 0, 0.284241723964, 0x3230303730313331323030363137, 919, 11);
INSERT INTO `wiki_page` VALUES (920, 8, 0x5072696e74, 0x7379736f70, 0, 0, 0, 0.638734733017, 0x3230303730313331323030363137, 920, 5);
INSERT INTO `wiki_page` VALUES (921, 8, 0x5072696e7461626c6576657273696f6e, 0x7379736f70, 0, 0, 0, 0.670840645377, 0x3230303730313331323030363137, 921, 17);
INSERT INTO `wiki_page` VALUES (922, 8, 0x5072696e747375627469746c65, 0x7379736f70, 0, 0, 0, 0.111222219545, 0x3230303730313331323030363137, 922, 17);
INSERT INTO `wiki_page` VALUES (923, 8, 0x50726976616379, 0x7379736f70, 0, 0, 0, 0.71205506115, 0x3230303730313331323030363137, 923, 14);
INSERT INTO `wiki_page` VALUES (924, 8, 0x5072697661637970616765, 0x7379736f70, 0, 0, 0, 0.094174736948, 0x3230303730313331323030363137, 924, 22);
INSERT INTO `wiki_page` VALUES (925, 8, 0x50726f74656374, 0x7379736f70, 0, 0, 0, 0.582789797477, 0x3230303730313331323030363137, 925, 7);
INSERT INTO `wiki_page` VALUES (926, 8, 0x50726f746563742d64656661756c74, 0x7379736f70, 0, 0, 0, 0.245440015132, 0x3230303730313331323030363137, 926, 9);
INSERT INTO `wiki_page` VALUES (927, 8, 0x50726f746563742d6c6576656c2d6175746f636f6e6669726d6564, 0x7379736f70, 0, 0, 0, 0.149829255871, 0x3230303730313331323030363137, 927, 24);
INSERT INTO `wiki_page` VALUES (928, 8, 0x50726f746563742d6c6576656c2d7379736f70, 0x7379736f70, 0, 0, 0, 0.93889179443, 0x3230303730313331323030363137, 928, 11);
INSERT INTO `wiki_page` VALUES (929, 8, 0x50726f746563742d74657874, 0x7379736f70, 0, 0, 0, 0.544640297111, 0x3230303730313331323030363137, 929, 167);
INSERT INTO `wiki_page` VALUES (930, 8, 0x50726f746563742d756e636861696e, 0x7379736f70, 0, 0, 0, 0.258156341339, 0x3230303730313331323030363137, 930, 23);
INSERT INTO `wiki_page` VALUES (931, 8, 0x50726f746563742d7669657774657874, 0x7379736f70, 0, 0, 0, 0.338040277559, 0x3230303730313331323030363137, 931, 135);
INSERT INTO `wiki_page` VALUES (932, 8, 0x50726f74656374636f6d6d656e74, 0x7379736f70, 0, 0, 0, 0.809813362304, 0x3230303730313331323030363137, 932, 21);
INSERT INTO `wiki_page` VALUES (933, 8, 0x50726f74656374656461727469636c65, 0x7379736f70, 0, 0, 0, 0.415223879571, 0x3230303730313331323030363137, 933, 18);
INSERT INTO `wiki_page` VALUES (934, 8, 0x50726f74656374656470616765, 0x7379736f70, 0, 0, 0, 0.615476035352, 0x3230303730313331323030363137, 934, 14);
INSERT INTO `wiki_page` VALUES (935, 8, 0x50726f746563746564706167657761726e696e67, 0x7379736f70, 0, 0, 0, 0.103111351197, 0x3230303730313331323030363137, 935, 201);
INSERT INTO `wiki_page` VALUES (936, 8, 0x50726f74656374656474657874, 0x7379736f70, 0, 0, 0, 0.081778809923, 0x3230303730313331323030363137, 936, 182);
INSERT INTO `wiki_page` VALUES (937, 8, 0x50726f746563746c6f6770616765, 0x7379736f70, 0, 0, 0, 0.556095605158, 0x3230303730313331323030363137, 937, 14);
INSERT INTO `wiki_page` VALUES (938, 8, 0x50726f746563746c6f6774657874, 0x7379736f70, 0, 0, 0, 0.475705079963, 0x3230303730313331323030363137, 938, 91);
INSERT INTO `wiki_page` VALUES (939, 8, 0x50726f746563746d6f76656f6e6c79, 0x7379736f70, 0, 0, 0, 0.803350096576, 0x3230303730313331323030363137, 939, 23);
INSERT INTO `wiki_page` VALUES (940, 8, 0x50726f7465637470616765, 0x7379736f70, 0, 0, 0, 0.541976810078, 0x3230303730313331323030363137, 940, 12);
INSERT INTO `wiki_page` VALUES (941, 8, 0x50726f74656374737562, 0x7379736f70, 0, 0, 0, 0.592657208524, 0x3230303730313331323030363137, 941, 17);
INSERT INTO `wiki_page` VALUES (942, 8, 0x50726f746563747468697370616765, 0x7379736f70, 0, 0, 0, 0.879838808339, 0x3230303730313331323030363137, 942, 17);
INSERT INTO `wiki_page` VALUES (943, 8, 0x50726f7879626c6f636b6572, 0x7379736f70, 0, 0, 0, 0.480179755683, 0x3230303730313331323030363137, 943, 13);
INSERT INTO `wiki_page` VALUES (944, 8, 0x50726f7879626c6f636b726561736f6e, 0x7379736f70, 0, 0, 0, 0.836135331961, 0x3230303730313331323030363137, 944, 173);
INSERT INTO `wiki_page` VALUES (945, 8, 0x50726f7879626c6f636b73756363657373, 0x7379736f70, 0, 0, 0, 0.508227702791, 0x3230303730313331323030363137, 945, 5);
INSERT INTO `wiki_page` VALUES (946, 8, 0x5075626d656475726c, 0x7379736f70, 0, 0, 0, 0.636985957472, 0x3230303730313331323030363137, 946, 95);
INSERT INTO `wiki_page` VALUES (947, 8, 0x516262726f777365, 0x7379736f70, 0, 0, 0, 0.825442318987, 0x3230303730313331323030363137, 947, 6);
INSERT INTO `wiki_page` VALUES (948, 8, 0x516265646974, 0x7379736f70, 0, 0, 0, 0.992622729485, 0x3230303730313331323030363137, 948, 4);
INSERT INTO `wiki_page` VALUES (949, 8, 0x516266696e64, 0x7379736f70, 0, 0, 0, 0.845637120519, 0x3230303730313331323030363137, 949, 4);
INSERT INTO `wiki_page` VALUES (950, 8, 0x51626d796f7074696f6e73, 0x7379736f70, 0, 0, 0, 0.503799429449, 0x3230303730313331323030363137, 950, 8);
INSERT INTO `wiki_page` VALUES (951, 8, 0x516270616765696e666f, 0x7379736f70, 0, 0, 0, 0.141542492436, 0x3230303730313331323030363137, 951, 7);
INSERT INTO `wiki_page` VALUES (952, 8, 0x5162706167656f7074696f6e73, 0x7379736f70, 0, 0, 0, 0.053940290216, 0x3230303730313331323030363137, 952, 9);
INSERT INTO `wiki_page` VALUES (953, 8, 0x516273657474696e6773, 0x7379736f70, 0, 0, 0, 0.932051032049, 0x3230303730313331323030363137, 953, 8);
INSERT INTO `wiki_page` VALUES (954, 8, 0x51627370656369616c7061676573, 0x7379736f70, 0, 0, 0, 0.939850116144, 0x3230303730313331323030363137, 954, 13);
INSERT INTO `wiki_page` VALUES (955, 8, 0x52616e646f6d70616765, 0x7379736f70, 0, 0, 0, 0.9531057146, 0x3230303730313331323030363137, 955, 11);
INSERT INTO `wiki_page` VALUES (956, 8, 0x52616e646f6d706167652d75726c, 0x7379736f70, 0, 0, 0, 0.265409014655, 0x3230303730313331323030363137, 956, 14);
INSERT INTO `wiki_page` VALUES (957, 8, 0x52616e67655f626c6f636b5f64697361626c6564, 0x7379736f70, 0, 0, 0, 0.516921657857, 0x3230303730313331323030363137, 957, 53);
INSERT INTO `wiki_page` VALUES (958, 8, 0x52635f63617465676f72696573, 0x7379736f70, 0, 0, 0, 0.615118507533, 0x3230303730313331323030363137, 958, 39);
INSERT INTO `wiki_page` VALUES (959, 8, 0x52635f63617465676f726965735f616e79, 0x7379736f70, 0, 0, 0, 0.166785688464, 0x3230303730313331323030363137, 959, 3);
INSERT INTO `wiki_page` VALUES (960, 8, 0x526368696465, 0x7379736f70, 0, 0, 0, 0.422689843727, 0x3230303730313331323030363137, 960, 71);
INSERT INTO `wiki_page` VALUES (961, 8, 0x52636c696e6b73, 0x7379736f70, 0, 0, 0, 0.620780201362, 0x3230303730313331323030363138, 961, 44);
INSERT INTO `wiki_page` VALUES (962, 8, 0x52636c69737466726f6d, 0x7379736f70, 0, 0, 0, 0.351708676331, 0x3230303730313331323030363138, 962, 33);
INSERT INTO `wiki_page` VALUES (963, 8, 0x52636c6975, 0x7379736f70, 0, 0, 0, 0.760849111705, 0x3230303730313331323030363138, 963, 31);
INSERT INTO `wiki_page` VALUES (964, 8, 0x52636c6f6164657272, 0x7379736f70, 0, 0, 0, 0.717553715499, 0x3230303730313331323030363138, 964, 22);
INSERT INTO `wiki_page` VALUES (965, 8, 0x52636c737562, 0x7379736f70, 0, 0, 0, 0.30212800278, 0x3230303730313331323030363138, 965, 27);
INSERT INTO `wiki_page` VALUES (966, 8, 0x52636e6f7465, 0x7379736f70, 0, 0, 0, 0.160552816394, 0x3230303730313331323030363138, 966, 80);
INSERT INTO `wiki_page` VALUES (967, 8, 0x52636e6f746566726f6d, 0x7379736f70, 0, 0, 0, 0.231185543803, 0x3230303730313331323030363138, 967, 62);
INSERT INTO `wiki_page` VALUES (968, 8, 0x5263706174726f6c64697361626c6564, 0x7379736f70, 0, 0, 0, 0.600005976768, 0x3230303730313331323030363138, 968, 30);
INSERT INTO `wiki_page` VALUES (969, 8, 0x5263706174726f6c64697361626c656474657874, 0x7379736f70, 0, 0, 0, 0.025648420475, 0x3230303730313331323030363138, 969, 56);
INSERT INTO `wiki_page` VALUES (970, 8, 0x526373686f7768696465616e6f6e73, 0x7379736f70, 0, 0, 0, 0.532292168214, 0x3230303730313331323030363138, 970, 18);
INSERT INTO `wiki_page` VALUES (971, 8, 0x526373686f7768696465626f7473, 0x7379736f70, 0, 0, 0, 0.071420322915, 0x3230303730313331323030363138, 971, 7);
INSERT INTO `wiki_page` VALUES (972, 8, 0x526373686f77686964656c6975, 0x7379736f70, 0, 0, 0, 0.474856909923, 0x3230303730313331323030363138, 972, 18);
INSERT INTO `wiki_page` VALUES (973, 8, 0x526373686f77686964656d696e65, 0x7379736f70, 0, 0, 0, 0.047150411104, 0x3230303730313331323030363138, 973, 11);
INSERT INTO `wiki_page` VALUES (974, 8, 0x526373686f77686964656d696e6f72, 0x7379736f70, 0, 0, 0, 0.003684509945, 0x3230303730313331323030363138, 974, 14);
INSERT INTO `wiki_page` VALUES (975, 8, 0x526373686f776869646570617472, 0x7379736f70, 0, 0, 0, 0.950416448389, 0x3230303730313331323030363138, 975, 18);
INSERT INTO `wiki_page` VALUES (976, 8, 0x526561646f6e6c79, 0x7379736f70, 0, 0, 0, 0.305795038533, 0x3230303730313331323030363138, 976, 15);
INSERT INTO `wiki_page` VALUES (977, 8, 0x526561646f6e6c795f6c6167, 0x7379736f70, 0, 0, 0, 0.285631957046, 0x3230303730313331323030363138, 977, 98);
INSERT INTO `wiki_page` VALUES (978, 8, 0x526561646f6e6c7974657874, 0x7379736f70, 0, 0, 0, 0.0832023804, 0x3230303730313331323030363138, 978, 216);
INSERT INTO `wiki_page` VALUES (979, 8, 0x526561646f6e6c797761726e696e67, 0x7379736f70, 0, 0, 0, 0.41771260372, 0x3230303730313331323030363138, 979, 202);
INSERT INTO `wiki_page` VALUES (980, 8, 0x526563656e746368616e676573, 0x7379736f70, 0, 0, 0, 0.25610144593, 0x3230303730313331323030363138, 980, 14);
INSERT INTO `wiki_page` VALUES (981, 8, 0x526563656e746368616e6765732d75726c, 0x7379736f70, 0, 0, 0, 0.481757973347, 0x3230303730313331323030363138, 981, 21);
INSERT INTO `wiki_page` VALUES (982, 8, 0x526563656e746368616e676573616c6c, 0x7379736f70, 0, 0, 0, 0.844709180834, 0x3230303730313331323030363138, 982, 3);
INSERT INTO `wiki_page` VALUES (983, 8, 0x526563656e746368616e676573636f756e74, 0x7379736f70, 0, 0, 0, 0.855548707156, 0x3230303730313331323030363138, 983, 25);
INSERT INTO `wiki_page` VALUES (984, 8, 0x526563656e746368616e6765736c696e6b6564, 0x7379736f70, 0, 0, 0, 0.694356066187, 0x3230303730313331323030363138, 984, 15);
INSERT INTO `wiki_page` VALUES (985, 8, 0x526563656e746368616e67657374657874, 0x7379736f70, 0, 0, 0, 0.531323664105, 0x3230303730313331323030363138, 985, 55);
INSERT INTO `wiki_page` VALUES (986, 8, 0x5265637265617465, 0x7379736f70, 0, 0, 0, 0.325936296537, 0x3230303730313331323030363138, 986, 8);
INSERT INTO `wiki_page` VALUES (987, 8, 0x5265646972656374656466726f6d, 0x7379736f70, 0, 0, 0, 0.258336363378, 0x3230303730313331323030363138, 987, 20);
INSERT INTO `wiki_page` VALUES (988, 8, 0x5265646972656374696e67746f, 0x7379736f70, 0, 0, 0, 0.749469771759, 0x3230303730313331323030363138, 988, 24);
INSERT INTO `wiki_page` VALUES (989, 8, 0x526564697265637470616765737562, 0x7379736f70, 0, 0, 0, 0.338614088267, 0x3230303730313331323030363138, 989, 13);
INSERT INTO `wiki_page` VALUES (990, 8, 0x52656d656d6265726d7970617373776f7264, 0x7379736f70, 0, 0, 0, 0.896414068956, 0x3230303730313331323030363138, 990, 11);
INSERT INTO `wiki_page` VALUES (991, 8, 0x52656d6f7665636865636b6564, 0x7379736f70, 0, 0, 0, 0.210349079103, 0x3230303730313331323030363138, 991, 35);
INSERT INTO `wiki_page` VALUES (992, 8, 0x52656d6f7665647761746368, 0x7379736f70, 0, 0, 0, 0.140587390695, 0x3230303730313331323030363138, 992, 22);
INSERT INTO `wiki_page` VALUES (993, 8, 0x52656d6f766564776174636874657874, 0x7379736f70, 0, 0, 0, 0.72305553693, 0x3230303730313331323030363138, 993, 56);
INSERT INTO `wiki_page` VALUES (994, 8, 0x52656d6f76696e67636865636b6564, 0x7379736f70, 0, 0, 0, 0.675453130345, 0x3230303730313331323030363138, 994, 42);
INSERT INTO `wiki_page` VALUES (995, 8, 0x52656e616d6567726f75706c6f67656e747279, 0x7379736f70, 0, 0, 0, 0.865234849559, 0x3230303730313331323030363138, 995, 22);
INSERT INTO `wiki_page` VALUES (996, 8, 0x52657365747072656673, 0x7379736f70, 0, 0, 0, 0.174259364775, 0x3230303730313331323030363138, 996, 5);
INSERT INTO `wiki_page` VALUES (997, 8, 0x526573746f72656c696e6b, 0x7379736f70, 0, 0, 0, 0.376593456591, 0x3230303730313331323030363138, 997, 16);
INSERT INTO `wiki_page` VALUES (998, 8, 0x526573746f72656c696e6b31, 0x7379736f70, 0, 0, 0, 0.411983505588, 0x3230303730313331323030363138, 998, 16);
INSERT INTO `wiki_page` VALUES (999, 8, 0x526573747269637465647068656164696e67, 0x7379736f70, 0, 0, 0, 0.29876431533, 0x3230303730313331323030363138, 999, 24);
INSERT INTO `wiki_page` VALUES (1000, 8, 0x5265737472696374696f6e2d65646974, 0x7379736f70, 0, 0, 0, 0.769039721675, 0x3230303730313331323030363138, 1000, 4);
INSERT INTO `wiki_page` VALUES (1001, 8, 0x5265737472696374696f6e2d6d6f7665, 0x7379736f70, 0, 0, 0, 0.679627984205, 0x3230303730313331323030363138, 1001, 4);
INSERT INTO `wiki_page` VALUES (1002, 8, 0x526573756c747370657270616765, 0x7379736f70, 0, 0, 0, 0.354201385983, 0x3230303730313331323030363138, 1002, 14);
INSERT INTO `wiki_page` VALUES (1003, 8, 0x52657472696576656466726f6d, 0x7379736f70, 0, 0, 0, 0.585942291896, 0x3230303730313331323030363138, 1003, 19);
INSERT INTO `wiki_page` VALUES (1004, 8, 0x52657475726e746f, 0x7379736f70, 0, 0, 0, 0.281958378553, 0x3230303730313331323030363138, 1004, 13);
INSERT INTO `wiki_page` VALUES (1005, 8, 0x5265747970656e6577, 0x7379736f70, 0, 0, 0, 0.999331327428, 0x3230303730313331323030363138, 1005, 20);
INSERT INTO `wiki_page` VALUES (1006, 8, 0x526575706c6f6164, 0x7379736f70, 0, 0, 0, 0.687900035365, 0x3230303730313331323030363138, 1006, 9);
INSERT INTO `wiki_page` VALUES (1007, 8, 0x526575706c6f616464657363, 0x7379736f70, 0, 0, 0, 0.202400135214, 0x3230303730313331323030363138, 1007, 26);
INSERT INTO `wiki_page` VALUES (1008, 8, 0x5265762d64656c657465642d636f6d6d656e74, 0x7379736f70, 0, 0, 0, 0.493533344979, 0x3230303730313331323030363138, 1008, 17);
INSERT INTO `wiki_page` VALUES (1009, 8, 0x5265762d64656c657465642d746578742d7065726d697373696f6e, 0x7379736f70, 0, 0, 0, 0.457466737804, 0x3230303730313331323030363138, 1009, 198);
INSERT INTO `wiki_page` VALUES (1010, 8, 0x5265762d64656c657465642d746578742d76696577, 0x7379736f70, 0, 0, 0, 0.384785128169, 0x3230303730313331323030363138, 1010, 248);
INSERT INTO `wiki_page` VALUES (1011, 8, 0x5265762d64656c657465642d75736572, 0x7379736f70, 0, 0, 0, 0.064136120437, 0x3230303730313331323030363138, 1011, 18);
INSERT INTO `wiki_page` VALUES (1012, 8, 0x5265762d64656c756e64656c, 0x7379736f70, 0, 0, 0, 0.314931603286, 0x3230303730313331323030363138, 1012, 9);
INSERT INTO `wiki_page` VALUES (1013, 8, 0x52657664656c6574652d686964652d636f6d6d656e74, 0x7379736f70, 0, 0, 0, 0.310377609736, 0x3230303730313331323030363138, 1013, 17);
INSERT INTO `wiki_page` VALUES (1014, 8, 0x52657664656c6574652d686964652d72657374726963746564, 0x7379736f70, 0, 0, 0, 0.349301429791, 0x3230303730313331323030363138, 1014, 52);
INSERT INTO `wiki_page` VALUES (1015, 8, 0x52657664656c6574652d686964652d74657874, 0x7379736f70, 0, 0, 0, 0.703321516153, 0x3230303730313331323030363138, 1015, 18);
INSERT INTO `wiki_page` VALUES (1016, 8, 0x52657664656c6574652d686964652d75736572, 0x7379736f70, 0, 0, 0, 0.763842110175, 0x3230303730313331323030363138, 1016, 25);
INSERT INTO `wiki_page` VALUES (1017, 8, 0x52657664656c6574652d6c6567656e64, 0x7379736f70, 0, 0, 0, 0.683105589606, 0x3230303730313331323030363138, 1017, 26);
INSERT INTO `wiki_page` VALUES (1018, 8, 0x52657664656c6574652d6c6f67, 0x7379736f70, 0, 0, 0, 0.726104294362, 0x3230303730313331323030363138, 1018, 12);
INSERT INTO `wiki_page` VALUES (1019, 8, 0x52657664656c6574652d6c6f67656e747279, 0x7379736f70, 0, 0, 0, 0.667151045475, 0x3230303730313331323030363138, 1019, 38);
INSERT INTO `wiki_page` VALUES (1020, 8, 0x52657664656c6574652d73656c6563746564, 0x7379736f70, 0, 0, 0, 0.315465545952, 0x3230303730313331323030363138, 1020, 29);
INSERT INTO `wiki_page` VALUES (1021, 8, 0x52657664656c6574652d7375626d6974, 0x7379736f70, 0, 0, 0, 0.592492906418, 0x3230303730313331323030363138, 1021, 26);
INSERT INTO `wiki_page` VALUES (1022, 8, 0x52657664656c6574652d74657874, 0x7379736f70, 0, 0, 0, 0.066691638478, 0x3230303730313331323030363138, 1022, 312);
INSERT INTO `wiki_page` VALUES (1023, 8, 0x5265766572746564, 0x7379736f70, 0, 0, 0, 0.448000700913, 0x3230303730313331323030363138, 1023, 28);
INSERT INTO `wiki_page` VALUES (1024, 8, 0x526576657274696d67, 0x7379736f70, 0, 0, 0, 0.056156598135, 0x3230303730313331323030363138, 1024, 3);
INSERT INTO `wiki_page` VALUES (1025, 8, 0x5265766572746d6f7665, 0x7379736f70, 0, 0, 0, 0.526560734959, 0x3230303730313331323030363138, 1025, 6);
INSERT INTO `wiki_page` VALUES (1026, 8, 0x52657665727470616765, 0x7379736f70, 0, 0, 0, 0.162483029559, 0x3230303730313331323030363138, 1026, 121);
INSERT INTO `wiki_page` VALUES (1027, 8, 0x526576686973746f7279, 0x7379736f70, 0, 0, 0, 0.592665209999, 0x3230303730313331323030363138, 1027, 16);
INSERT INTO `wiki_page` VALUES (1028, 8, 0x5265766973696f6e61736f66, 0x7379736f70, 0, 0, 0, 0.864576679535, 0x3230303730313331323030363138, 1028, 17);
INSERT INTO `wiki_page` VALUES (1029, 8, 0x5265766973696f6e61736f66776974686c696e6b, 0x7379736f70, 0, 0, 0, 0.426378623867, 0x3230303730313331323030363138, 1029, 34);
INSERT INTO `wiki_page` VALUES (1030, 8, 0x5265766973696f6e64656c657465, 0x7379736f70, 0, 0, 0, 0.904413310703, 0x3230303730313331323030363138, 1030, 25);
INSERT INTO `wiki_page` VALUES (1031, 8, 0x5265766e6f74666f756e64, 0x7379736f70, 0, 0, 0, 0.901285573376, 0x3230303730313331323030363138, 1031, 18);
INSERT INTO `wiki_page` VALUES (1032, 8, 0x5265766e6f74666f756e6474657874, 0x7379736f70, 0, 0, 0, 0.763755182652, 0x3230303730313331323030363138, 1032, 113);
INSERT INTO `wiki_page` VALUES (1033, 8, 0x52666375726c, 0x7379736f70, 0, 0, 0, 0.517373117776, 0x3230303730313331323030363138, 1033, 33);
INSERT INTO `wiki_page` VALUES (1034, 8, 0x526967687473, 0x7379736f70, 0, 0, 0, 0.779197614193, 0x3230303730313331323030363138, 1034, 7);
INSERT INTO `wiki_page` VALUES (1035, 8, 0x5269676874736c6f6774657874, 0x7379736f70, 0, 0, 0, 0.998801953776, 0x3230303730313331323030363138, 1035, 40);
INSERT INTO `wiki_page` VALUES (1036, 8, 0x526f6c6c6261636b, 0x7379736f70, 0, 0, 0, 0.506176689312, 0x3230303730313331323030363138, 1036, 15);
INSERT INTO `wiki_page` VALUES (1037, 8, 0x526f6c6c6261636b5f73686f7274, 0x7379736f70, 0, 0, 0, 0.773367959073, 0x3230303730313331323030363138, 1037, 8);
INSERT INTO `wiki_page` VALUES (1038, 8, 0x526f6c6c6261636b6661696c6564, 0x7379736f70, 0, 0, 0, 0.258591273906, 0x3230303730313331323030363138, 1038, 15);
INSERT INTO `wiki_page` VALUES (1039, 8, 0x526f6c6c6261636b6c696e6b, 0x7379736f70, 0, 0, 0, 0.384144415672, 0x3230303730313331323030363138, 1039, 8);
INSERT INTO `wiki_page` VALUES (1040, 8, 0x526f7773, 0x7379736f70, 0, 0, 0, 0.359952124158, 0x3230303730313331323030363138, 1040, 5);
INSERT INTO `wiki_page` VALUES (1041, 8, 0x5361747572646179, 0x7379736f70, 0, 0, 0, 0.980943731154, 0x3230303730313331323030363138, 1041, 8);
INSERT INTO `wiki_page` VALUES (1042, 8, 0x5361766561727469636c65, 0x7379736f70, 0, 0, 0, 0.189522977114, 0x3230303730313331323030363139, 1042, 9);
INSERT INTO `wiki_page` VALUES (1043, 8, 0x53617665647072656673, 0x7379736f70, 0, 0, 0, 0.731536537615, 0x3230303730313331323030363139, 1043, 33);
INSERT INTO `wiki_page` VALUES (1044, 8, 0x5361766566696c65, 0x7379736f70, 0, 0, 0, 0.780572322769, 0x3230303730313331323030363139, 1044, 9);
INSERT INTO `wiki_page` VALUES (1045, 8, 0x5361766567726f7570, 0x7379736f70, 0, 0, 0, 0.175265859556, 0x3230303730313331323030363139, 1045, 10);
INSERT INTO `wiki_page` VALUES (1046, 8, 0x536176657072656673, 0x7379736f70, 0, 0, 0, 0.734106901916, 0x3230303730313331323030363139, 1046, 4);
INSERT INTO `wiki_page` VALUES (1047, 8, 0x536176657573657267726f757073, 0x7379736f70, 0, 0, 0, 0.02212631319, 0x3230303730313331323030363139, 1047, 16);
INSERT INTO `wiki_page` VALUES (1048, 8, 0x53636172797472616e73636c75646564697361626c6564, 0x7379736f70, 0, 0, 0, 0.744180283995, 0x3230303730313331323030363139, 1048, 36);
INSERT INTO `wiki_page` VALUES (1049, 8, 0x53636172797472616e73636c7564656661696c6564, 0x7379736f70, 0, 0, 0, 0.27038116707, 0x3230303730313331323030363139, 1049, 37);
INSERT INTO `wiki_page` VALUES (1050, 8, 0x53636172797472616e73636c756465746f6f6c6f6e67, 0x7379736f70, 0, 0, 0, 0.294695505046, 0x3230303730313331323030363139, 1050, 24);
INSERT INTO `wiki_page` VALUES (1051, 8, 0x536561726368, 0x7379736f70, 0, 0, 0, 0.088023073028, 0x3230303730313331323030363139, 1051, 6);
INSERT INTO `wiki_page` VALUES (1052, 8, 0x536561726368636f6e7461696e696e67, 0x7379736f70, 0, 0, 0, 0.419098657553, 0x3230303730313331323030363139, 1052, 38);
INSERT INTO `wiki_page` VALUES (1053, 8, 0x53656172636864697361626c6564, 0x7379736f70, 0, 0, 0, 0.217778412184, 0x3230303730313331323030363139, 1053, 143);
INSERT INTO `wiki_page` VALUES (1054, 8, 0x53656172636866756c6c74657874, 0x7379736f70, 0, 0, 0, 0.72371369705, 0x3230303730313331323030363139, 1054, 16);
INSERT INTO `wiki_page` VALUES (1055, 8, 0x5365617263686e616d6564, 0x7379736f70, 0, 0, 0, 0.557193536613, 0x3230303730313331323030363139, 1055, 33);
INSERT INTO `wiki_page` VALUES (1056, 8, 0x5365617263687175657279, 0x7379736f70, 0, 0, 0, 0.106156349862, 0x3230303730313331323030363139, 1056, 14);
INSERT INTO `wiki_page` VALUES (1057, 8, 0x536561726368726573756c7473, 0x7379736f70, 0, 0, 0, 0.076709937257, 0x3230303730313331323030363139, 1057, 14);
INSERT INTO `wiki_page` VALUES (1058, 8, 0x536561726368726573756c747368656164, 0x7379736f70, 0, 0, 0, 0.671121927265, 0x3230303730313331323030363139, 1058, 6);
INSERT INTO `wiki_page` VALUES (1059, 8, 0x536561726368726573756c7474657874, 0x7379736f70, 0, 0, 0, 0.475436640675, 0x3230303730313331323030363139, 1059, 100);
INSERT INTO `wiki_page` VALUES (1060, 8, 0x53656374696f6e6c696e6b, 0x7379736f70, 0, 0, 0, 0.024699953323, 0x3230303730313331323030363139, 1060, 3);
INSERT INTO `wiki_page` VALUES (1061, 8, 0x53656c6563746e6577657276657273696f6e666f7264696666, 0x7379736f70, 0, 0, 0, 0.431628786526, 0x3230303730313331323030363139, 1061, 37);
INSERT INTO `wiki_page` VALUES (1062, 8, 0x53656c6563746f6c64657276657273696f6e666f7264696666, 0x7379736f70, 0, 0, 0, 0.874213705828, 0x3230303730313331323030363139, 1062, 38);
INSERT INTO `wiki_page` VALUES (1063, 8, 0x53656c666d6f7665, 0x7379736f70, 0, 0, 0, 0.380455399447, 0x3230303730313331323030363139, 1063, 74);
INSERT INTO `wiki_page` VALUES (1064, 8, 0x53656d6970726f746563746564706167657761726e696e67, 0x7379736f70, 0, 0, 0, 0.086355877716, 0x3230303730313331323030363139, 1064, 80);
INSERT INTO `wiki_page` VALUES (1065, 8, 0x536570, 0x7379736f70, 0, 0, 0, 0.170159339436, 0x3230303730313331323030363139, 1065, 3);
INSERT INTO `wiki_page` VALUES (1066, 8, 0x53657074656d626572, 0x7379736f70, 0, 0, 0, 0.223029260622, 0x3230303730313331323030363139, 1066, 9);
INSERT INTO `wiki_page` VALUES (1067, 8, 0x53657276657274696d65, 0x7379736f70, 0, 0, 0, 0.284840871799, 0x3230303730313331323030363139, 1067, 11);
INSERT INTO `wiki_page` VALUES (1068, 8, 0x53657373696f6e5f6661696c5f70726576696577, 0x7379736f70, 0, 0, 0, 0.188024338609, 0x3230303730313331323030363139, 1068, 166);
INSERT INTO `wiki_page` VALUES (1069, 8, 0x53657373696f6e5f6661696c5f707265766965775f68746d6c, 0x7379736f70, 0, 0, 0, 0.926269266171, 0x3230303730313331323030363139, 1069, 333);
INSERT INTO `wiki_page` VALUES (1070, 8, 0x53657373696f6e6661696c757265, 0x7379736f70, 0, 0, 0, 0.718636955969, 0x3230303730313331323030363139, 1070, 194);
INSERT INTO `wiki_page` VALUES (1071, 8, 0x5365745f7269676874735f6661696c, 0x7379736f70, 0, 0, 0, 0.791052465599, 0x3230303730313331323030363139, 1071, 81);
INSERT INTO `wiki_page` VALUES (1072, 8, 0x5365745f757365725f726967687473, 0x7379736f70, 0, 0, 0, 0.100688785848, 0x3230303730313331323030363139, 1072, 15);
INSERT INTO `wiki_page` VALUES (1073, 8, 0x53657462757265617563726174666c6167, 0x7379736f70, 0, 0, 0, 0.855032338056, 0x3230303730313331323030363139, 1073, 19);
INSERT INTO `wiki_page` VALUES (1074, 8, 0x53657473746577617264666c6167, 0x7379736f70, 0, 0, 0, 0.666591278185, 0x3230303730313331323030363139, 1074, 16);
INSERT INTO `wiki_page` VALUES (1075, 8, 0x5368617265646465736372697074696f6e666f6c6c6f7773, 0x7379736f70, 0, 0, 0, 0.983190841196, 0x3230303730313331323030363139, 1075, 1);
INSERT INTO `wiki_page` VALUES (1076, 8, 0x53686172656475706c6f6164, 0x7379736f70, 0, 0, 0, 0.898374620412, 0x3230303730313331323030363139, 1076, 63);
INSERT INTO `wiki_page` VALUES (1077, 8, 0x53686172656475706c6f616477696b69, 0x7379736f70, 0, 0, 0, 0.105442324992, 0x3230303730313331323030363139, 1077, 42);
INSERT INTO `wiki_page` VALUES (1078, 8, 0x53686172656475706c6f616477696b692d6c696e6b74657874, 0x7379736f70, 0, 0, 0, 0.518620477645, 0x3230303730313331323030363139, 1078, 21);
INSERT INTO `wiki_page` VALUES (1079, 8, 0x53686f72747061676573, 0x7379736f70, 0, 0, 0, 0.982949927173, 0x3230303730313331323030363139, 1079, 11);
INSERT INTO `wiki_page` VALUES (1080, 8, 0x53686f77, 0x7379736f70, 0, 0, 0, 0.751200227458, 0x3230303730313331323030363139, 1080, 4);
INSERT INTO `wiki_page` VALUES (1081, 8, 0x53686f77626967696d616765, 0x7379736f70, 0, 0, 0, 0.235229061785, 0x3230303730313331323030363139, 1081, 47);
INSERT INTO `wiki_page` VALUES (1082, 8, 0x53686f7764696666, 0x7379736f70, 0, 0, 0, 0.25403727291, 0x3230303730313331323030363139, 1082, 12);
INSERT INTO `wiki_page` VALUES (1083, 8, 0x53686f7768696465626f7473, 0x7379736f70, 0, 0, 0, 0.018112468773, 0x3230303730313331323030363139, 1083, 9);
INSERT INTO `wiki_page` VALUES (1084, 8, 0x53686f77696e67726573756c7473, 0x7379736f70, 0, 0, 0, 0.518485395195, 0x3230303730313331323030363139, 1084, 63);
INSERT INTO `wiki_page` VALUES (1085, 8, 0x53686f77696e67726573756c74736e756d, 0x7379736f70, 0, 0, 0, 0.113237536734, 0x3230303730313331323030363139, 1085, 57);
INSERT INTO `wiki_page` VALUES (1086, 8, 0x53686f776c617374, 0x7379736f70, 0, 0, 0, 0.127931882853, 0x3230303730313331323030363139, 1086, 29);
INSERT INTO `wiki_page` VALUES (1087, 8, 0x53686f776c69766570726576696577, 0x7379736f70, 0, 0, 0, 0.742059905801, 0x3230303730313331323030363139, 1087, 12);
INSERT INTO `wiki_page` VALUES (1088, 8, 0x53686f7770726576696577, 0x7379736f70, 0, 0, 0, 0.208920749109, 0x3230303730313331323030363139, 1088, 12);
INSERT INTO `wiki_page` VALUES (1089, 8, 0x53686f77746f63, 0x7379736f70, 0, 0, 0, 0.918422572814, 0x3230303730313331323030363139, 1089, 4);
INSERT INTO `wiki_page` VALUES (1090, 8, 0x53696465626172, 0x7379736f70, 0, 0, 0, 0.384725268708, 0x3230303730313331323030363139, 1090, 202);
INSERT INTO `wiki_page` VALUES (1091, 8, 0x5369675f746970, 0x7379736f70, 0, 0, 0, 0.291443297415, 0x3230303730313331323030363139, 1091, 29);
INSERT INTO `wiki_page` VALUES (1092, 8, 0x5369676e7570656e64, 0x7379736f70, 0, 0, 0, 0.601362028894, 0x3230303730313331323030363139, 1092, 16);
INSERT INTO `wiki_page` VALUES (1093, 8, 0x536974656e6f74696365, 0x7379736f70, 0, 0, 0, 0.615021263478, 0x3230303730313331323030363139, 1093, 1);
INSERT INTO `wiki_page` VALUES (1094, 8, 0x536974657374617473, 0x7379736f70, 0, 0, 0, 0.343099575569, 0x3230303730313331323030363139, 1094, 23);
INSERT INTO `wiki_page` VALUES (1095, 8, 0x53697465737461747374657874, 0x7379736f70, 0, 0, 0, 0.860926633099, 0x3230303730313331323030363139, 1095, 572);
INSERT INTO `wiki_page` VALUES (1096, 8, 0x536974657375627469746c65, 0x7379736f70, 0, 0, 0, 0.70832381873, 0x3230303730313331323030363139, 1096, 0);
INSERT INTO `wiki_page` VALUES (1097, 8, 0x53697465737570706f7274, 0x7379736f70, 0, 0, 0, 0.047599172861, 0x3230303730313331323030363139, 1097, 9);
INSERT INTO `wiki_page` VALUES (1098, 8, 0x53697465737570706f72742d75726c, 0x7379736f70, 0, 0, 0, 0.592541991318, 0x3230303730313331323030363139, 1098, 20);
INSERT INTO `wiki_page` VALUES (1099, 8, 0x536974657469746c65, 0x7379736f70, 0, 0, 0, 0.028976877356, 0x3230303730313331323030363139, 1099, 12);
INSERT INTO `wiki_page` VALUES (1100, 8, 0x5369746575736572, 0x7379736f70, 0, 0, 0, 0.658114644935, 0x3230303730313331323030363139, 1100, 20);
INSERT INTO `wiki_page` VALUES (1101, 8, 0x536974657573657273, 0x7379736f70, 0, 0, 0, 0.704420260301, 0x3230303730313331323030363139, 1101, 23);
INSERT INTO `wiki_page` VALUES (1102, 8, 0x536b696e, 0x7379736f70, 0, 0, 0, 0.762261736547, 0x3230303730313331323030363139, 1102, 4);
INSERT INTO `wiki_page` VALUES (1103, 8, 0x536b696e70726576696577, 0x7379736f70, 0, 0, 0, 0.674233371573, 0x3230303730313331323030363139, 1103, 9);
INSERT INTO `wiki_page` VALUES (1104, 8, 0x536f726273, 0x7379736f70, 0, 0, 0, 0.399907912335, 0x3230303730313331323030363139, 1104, 11);
INSERT INTO `wiki_page` VALUES (1105, 8, 0x536f7262735f6372656174655f6163636f756e745f726561736f6e, 0x7379736f70, 0, 0, 0, 0.675577906951, 0x3230303730313331323030363139, 1105, 114);
INSERT INTO `wiki_page` VALUES (1106, 8, 0x536f726273726561736f6e, 0x7379736f70, 0, 0, 0, 0.397692043355, 0x3230303730313331323030363139, 1106, 85);
INSERT INTO `wiki_page` VALUES (1107, 8, 0x536f7572636566696c656e616d65, 0x7379736f70, 0, 0, 0, 0.768193221823, 0x3230303730313331323030363139, 1107, 15);
INSERT INTO `wiki_page` VALUES (1108, 8, 0x5370616d5f626c616e6b696e67, 0x7379736f70, 0, 0, 0, 0.658130268139, 0x3230303730313331323030363139, 1108, 45);
INSERT INTO `wiki_page` VALUES (1109, 8, 0x5370616d5f726576657274696e67, 0x7379736f70, 0, 0, 0, 0.533396608338, 0x3230303730313331323030363139, 1109, 52);
INSERT INTO `wiki_page` VALUES (1110, 8, 0x5370616d626f745f757365726e616d65, 0x7379736f70, 0, 0, 0, 0.584132874612, 0x3230303730313331323030363139, 1110, 22);
INSERT INTO `wiki_page` VALUES (1111, 8, 0x5370616d70726f74656374696f6e6d61746368, 0x7379736f70, 0, 0, 0, 0.438733490572, 0x3230303730313331323030363139, 1111, 56);
INSERT INTO `wiki_page` VALUES (1112, 8, 0x5370616d70726f74656374696f6e74657874, 0x7379736f70, 0, 0, 0, 0.304118061579, 0x3230303730313331323030363139, 1112, 114);
INSERT INTO `wiki_page` VALUES (1113, 8, 0x5370616d70726f74656374696f6e7469746c65, 0x7379736f70, 0, 0, 0, 0.134766809344, 0x3230303730313331323030363139, 1113, 22);
INSERT INTO `wiki_page` VALUES (1114, 8, 0x5370656369616c6c6f677469746c656c6162656c, 0x7379736f70, 0, 0, 0, 0.411744188766, 0x3230303730313331323030363139, 1114, 6);
INSERT INTO `wiki_page` VALUES (1115, 8, 0x5370656369616c6c6f67757365726c6162656c, 0x7379736f70, 0, 0, 0, 0.10893933594, 0x3230303730313331323030363139, 1115, 5);
INSERT INTO `wiki_page` VALUES (1116, 8, 0x5370656369616c70616765, 0x7379736f70, 0, 0, 0, 0.297607976633, 0x3230303730313331323030363139, 1116, 12);
INSERT INTO `wiki_page` VALUES (1117, 8, 0x5370656369616c7061676573, 0x7379736f70, 0, 0, 0, 0.994892766598, 0x3230303730313331323030363139, 1117, 13);
INSERT INTO `wiki_page` VALUES (1118, 8, 0x537068656164696e67, 0x7379736f70, 0, 0, 0, 0.219549327129, 0x3230303730313331323030363139, 1118, 27);
INSERT INTO `wiki_page` VALUES (1119, 8, 0x53716c68696464656e, 0x7379736f70, 0, 0, 0, 0.225381924409, 0x3230303730313331323030363139, 1119, 18);
INSERT INTO `wiki_page` VALUES (1120, 8, 0x53746174697374696373, 0x7379736f70, 0, 0, 0, 0.350512320561, 0x3230303730313331323030363139, 1120, 10);
INSERT INTO `wiki_page` VALUES (1121, 8, 0x53746f72656476657273696f6e, 0x7379736f70, 0, 0, 0, 0.923842106047, 0x3230303730313331323030363139, 1121, 14);
INSERT INTO `wiki_page` VALUES (1122, 8, 0x537475627468726573686f6c64, 0x7379736f70, 0, 0, 0, 0.919921735209, 0x3230303730313331323030363139, 1122, 27);
INSERT INTO `wiki_page` VALUES (1123, 8, 0x53756263617465676f72696573, 0x7379736f70, 0, 0, 0, 0.87131675521, 0x3230303730313331323030363230, 1123, 13);
INSERT INTO `wiki_page` VALUES (1124, 8, 0x53756263617465676f7279636f756e74, 0x7379736f70, 0, 0, 0, 0.287486918622, 0x3230303730313331323030363230, 1124, 44);
INSERT INTO `wiki_page` VALUES (1125, 8, 0x53756263617465676f7279636f756e7431, 0x7379736f70, 0, 0, 0, 0.848825991502, 0x3230303730313331323030363230, 1125, 41);
INSERT INTO `wiki_page` VALUES (1126, 8, 0x5375626a656374, 0x7379736f70, 0, 0, 0, 0.031381020276, 0x3230303730313331323030363230, 1126, 16);
INSERT INTO `wiki_page` VALUES (1127, 8, 0x5375626a65637470616765, 0x7379736f70, 0, 0, 0, 0.449265630556, 0x3230303730313331323030363230, 1127, 12);
INSERT INTO `wiki_page` VALUES (1128, 8, 0x5375636365737366756c75706c6f6164, 0x7379736f70, 0, 0, 0, 0.743849606104, 0x3230303730313331323030363230, 1128, 17);
INSERT INTO `wiki_page` VALUES (1129, 8, 0x53756d6d617279, 0x7379736f70, 0, 0, 0, 0.438706248077, 0x3230303730313331323030363230, 1129, 7);
INSERT INTO `wiki_page` VALUES (1130, 8, 0x53756e646179, 0x7379736f70, 0, 0, 0, 0.062945555541, 0x3230303730313331323030363230, 1130, 6);
INSERT INTO `wiki_page` VALUES (1131, 8, 0x5379736f7074657874, 0x7379736f70, 0, 0, 0, 0.809380520525, 0x3230303730313331323030363230, 1131, 93);
INSERT INTO `wiki_page` VALUES (1132, 8, 0x5379736f707469746c65, 0x7379736f70, 0, 0, 0, 0.830573124027, 0x3230303730313331323030363230, 1132, 21);
INSERT INTO `wiki_page` VALUES (1133, 8, 0x5461626c65666f726d, 0x7379736f70, 0, 0, 0, 0.440597857541, 0x3230303730313331323030363230, 1133, 5);
INSERT INTO `wiki_page` VALUES (1134, 8, 0x5461676c696e65, 0x7379736f70, 0, 0, 0, 0.1241623546, 0x3230303730313331323030363230, 1134, 17);
INSERT INTO `wiki_page` VALUES (1135, 8, 0x54616c6b, 0x7379736f70, 0, 0, 0, 0.175940202142, 0x3230303730313331323030363230, 1135, 10);
INSERT INTO `wiki_page` VALUES (1136, 8, 0x54616c6b657869737473, 0x7379736f70, 0, 0, 0, 0.968977073116, 0x3230303730313331323030363230, 1136, 155);
INSERT INTO `wiki_page` VALUES (1137, 8, 0x54616c6b70616765, 0x7379736f70, 0, 0, 0, 0.037166342574, 0x3230303730313331323030363230, 1137, 17);
INSERT INTO `wiki_page` VALUES (1138, 8, 0x54616c6b706167656d6f766564, 0x7379736f70, 0, 0, 0, 0.964286326742, 0x3230303730313331323030363230, 1138, 43);
INSERT INTO `wiki_page` VALUES (1139, 8, 0x54616c6b706167656e6f746d6f766564, 0x7379736f70, 0, 0, 0, 0.663332087116, 0x3230303730313331323030363230, 1139, 59);
INSERT INTO `wiki_page` VALUES (1140, 8, 0x54616c6b7061676574657874, 0x7379736f70, 0, 0, 0, 0.172276659557, 0x3230303730313331323030363230, 1140, 31);
INSERT INTO `wiki_page` VALUES (1141, 8, 0x54656d706c6174657375736564, 0x7379736f70, 0, 0, 0, 0.49176233683, 0x3230303730313331323030363230, 1141, 28);
INSERT INTO `wiki_page` VALUES (1142, 8, 0x54657874626f7873697a65, 0x7379736f70, 0, 0, 0, 0.994948074408, 0x3230303730313331323030363230, 1142, 7);
INSERT INTO `wiki_page` VALUES (1143, 8, 0x546578746d617463686573, 0x7379736f70, 0, 0, 0, 0.280259454131, 0x3230303730313331323030363230, 1143, 17);
INSERT INTO `wiki_page` VALUES (1144, 8, 0x54686973697364656c65746564, 0x7379736f70, 0, 0, 0, 0.539193322508, 0x3230303730313331323030363230, 1144, 19);
INSERT INTO `wiki_page` VALUES (1145, 8, 0x5468756d626e61696c2d6d6f7265, 0x7379736f70, 0, 0, 0, 0.739569053043, 0x3230303730313331323030363230, 1145, 7);
INSERT INTO `wiki_page` VALUES (1146, 8, 0x5468756d626e61696c5f6572726f72, 0x7379736f70, 0, 0, 0, 0.274425115734, 0x3230303730313331323030363230, 1146, 28);
INSERT INTO `wiki_page` VALUES (1147, 8, 0x5468756d6273697a65, 0x7379736f70, 0, 0, 0, 0.083826938682, 0x3230303730313331323030363230, 1147, 15);
INSERT INTO `wiki_page` VALUES (1148, 8, 0x5468757273646179, 0x7379736f70, 0, 0, 0, 0.276176284485, 0x3230303730313331323030363230, 1148, 8);
INSERT INTO `wiki_page` VALUES (1149, 8, 0x54696d657a6f6e656c6567656e64, 0x7379736f70, 0, 0, 0, 0.004678235303, 0x3230303730313331323030363230, 1149, 9);
INSERT INTO `wiki_page` VALUES (1150, 8, 0x54696d657a6f6e656f6666736574, 0x7379736f70, 0, 0, 0, 0.827866816495, 0x3230303730313331323030363230, 1150, 8);
INSERT INTO `wiki_page` VALUES (1151, 8, 0x54696d657a6f6e6574657874, 0x7379736f70, 0, 0, 0, 0.559788350689, 0x3230303730313331323030363230, 1151, 67);
INSERT INTO `wiki_page` VALUES (1152, 8, 0x5469746c656d617463686573, 0x7379736f70, 0, 0, 0, 0.724397433697, 0x3230303730313331323030363230, 1152, 21);
INSERT INTO `wiki_page` VALUES (1153, 8, 0x546f63, 0x7379736f70, 0, 0, 0, 0.595274907953, 0x3230303730313331323030363230, 1153, 8);
INSERT INTO `wiki_page` VALUES (1154, 8, 0x546f672d6175746f706174726f6c, 0x7379736f70, 0, 0, 0, 0.378988162752, 0x3230303730313331323030363230, 1154, 30);
INSERT INTO `wiki_page` VALUES (1155, 8, 0x546f672d656469746f6e64626c636c69636b, 0x7379736f70, 0, 0, 0, 0.059820568343, 0x3230303730313331323030363230, 1155, 39);
INSERT INTO `wiki_page` VALUES (1156, 8, 0x546f672d6564697473656374696f6e, 0x7379736f70, 0, 0, 0, 0.989174800978, 0x3230303730313331323030363230, 1156, 39);
INSERT INTO `wiki_page` VALUES (1157, 8, 0x546f672d6564697473656374696f6e6f6e7269676874636c69636b, 0x7379736f70, 0, 0, 0, 0.622966739294, 0x3230303730313331323030363230, 1157, 77);
INSERT INTO `wiki_page` VALUES (1158, 8, 0x546f672d656469747769647468, 0x7379736f70, 0, 0, 0, 0.397997569915, 0x3230303730313331323030363230, 1158, 23);
INSERT INTO `wiki_page` VALUES (1159, 8, 0x546f672d656e6f7469666d696e6f726564697473, 0x7379736f70, 0, 0, 0, 0.609261902644, 0x3230303730313331323030363230, 1159, 39);
INSERT INTO `wiki_page` VALUES (1160, 8, 0x546f672d656e6f74696672657665616c61646472, 0x7379736f70, 0, 0, 0, 0.657154390775, 0x3230303730313331323030363230, 1160, 46);
INSERT INTO `wiki_page` VALUES (1161, 8, 0x546f672d656e6f7469667573657274616c6b7061676573, 0x7379736f70, 0, 0, 0, 0.624549338632, 0x3230303730313331323030363230, 1161, 43);
INSERT INTO `wiki_page` VALUES (1162, 8, 0x546f672d656e6f74696677617463686c6973747061676573, 0x7379736f70, 0, 0, 0, 0.255748506052, 0x3230303730313331323030363230, 1162, 25);
INSERT INTO `wiki_page` VALUES (1163, 8, 0x546f672d65787465726e616c64696666, 0x7379736f70, 0, 0, 0, 0.994633288364, 0x3230303730313331323030363230, 1163, 28);
INSERT INTO `wiki_page` VALUES (1164, 8, 0x546f672d65787465726e616c656469746f72, 0x7379736f70, 0, 0, 0, 0.503243077948, 0x3230303730313331323030363230, 1164, 30);
INSERT INTO `wiki_page` VALUES (1165, 8, 0x546f672d66616e6379736967, 0x7379736f70, 0, 0, 0, 0.718151546904, 0x3230303730313331323030363230, 1165, 39);
INSERT INTO `wiki_page` VALUES (1166, 8, 0x546f672d666f7263656564697473756d6d617279, 0x7379736f70, 0, 0, 0, 0.278482343089, 0x3230303730313331323030363230, 1166, 44);
INSERT INTO `wiki_page` VALUES (1167, 8, 0x546f672d686964656d696e6f72, 0x7379736f70, 0, 0, 0, 0.753776855895, 0x3230303730313331323030363230, 1167, 34);
INSERT INTO `wiki_page` VALUES (1168, 8, 0x546f672d686967686c6967687462726f6b656e, 0x7379736f70, 0, 0, 0, 0.821265565143, 0x3230303730313331323030363230, 1168, 115);
INSERT INTO `wiki_page` VALUES (1169, 8, 0x546f672d6a757374696679, 0x7379736f70, 0, 0, 0, 0.29868541959, 0x3230303730313331323030363230, 1169, 18);
INSERT INTO `wiki_page` VALUES (1170, 8, 0x546f672d6d696e6f7264656661756c74, 0x7379736f70, 0, 0, 0, 0.130556177847, 0x3230303730313331323030363230, 1170, 31);
INSERT INTO `wiki_page` VALUES (1171, 8, 0x546f672d6e6f6361636865, 0x7379736f70, 0, 0, 0, 0.423803277802, 0x3230303730313331323030363230, 1171, 20);
INSERT INTO `wiki_page` VALUES (1172, 8, 0x546f672d6e756d62657268656164696e6773, 0x7379736f70, 0, 0, 0, 0.411133150119, 0x3230303730313331323030363230, 1172, 20);
INSERT INTO `wiki_page` VALUES (1173, 8, 0x546f672d707265766965776f6e6669727374, 0x7379736f70, 0, 0, 0, 0.085405904389, 0x3230303730313331323030363230, 1173, 26);
INSERT INTO `wiki_page` VALUES (1174, 8, 0x546f672d707265766965776f6e746f70, 0x7379736f70, 0, 0, 0, 0.361279233515, 0x3230303730313331323030363230, 1174, 28);
INSERT INTO `wiki_page` VALUES (1175, 8, 0x546f672d72656d656d62657270617373776f7264, 0x7379736f70, 0, 0, 0, 0.791290779049, 0x3230303730313331323030363230, 1175, 24);
INSERT INTO `wiki_page` VALUES (1176, 8, 0x546f672d73686f776a756d706c696e6b73, 0x7379736f70, 0, 0, 0, 0.291951558643, 0x3230303730313331323030363230, 1176, 36);
INSERT INTO `wiki_page` VALUES (1177, 8, 0x546f672d73686f776e756d626572737761746368696e67, 0x7379736f70, 0, 0, 0, 0.297740710478, 0x3230303730313331323030363230, 1177, 33);
INSERT INTO `wiki_page` VALUES (1178, 8, 0x546f672d73686f77746f63, 0x7379736f70, 0, 0, 0, 0.81790438362, 0x3230303730313331323030363230, 1178, 60);
INSERT INTO `wiki_page` VALUES (1179, 8, 0x546f672d73686f77746f6f6c626172, 0x7379736f70, 0, 0, 0, 0.949649870633, 0x3230303730313331323030363230, 1179, 30);
INSERT INTO `wiki_page` VALUES (1180, 8, 0x546f672d756e6465726c696e65, 0x7379736f70, 0, 0, 0, 0.841493287688, 0x3230303730313331323030363230, 1180, 16);
INSERT INTO `wiki_page` VALUES (1181, 8, 0x546f672d7573656c69766570726576696577, 0x7379736f70, 0, 0, 0, 0.11332850174, 0x3230303730313331323030363230, 1181, 44);
INSERT INTO `wiki_page` VALUES (1182, 8, 0x546f672d7573656e65777263, 0x7379736f70, 0, 0, 0, 0.577416351606, 0x3230303730313331323030363230, 1182, 36);
INSERT INTO `wiki_page` VALUES (1183, 8, 0x546f672d77617463686372656174696f6e73, 0x7379736f70, 0, 0, 0, 0.879825513097, 0x3230303730313331323030363230, 1183, 34);
INSERT INTO `wiki_page` VALUES (1184, 8, 0x546f672d776174636864656661756c74, 0x7379736f70, 0, 0, 0, 0.980249651331, 0x3230303730313331323030363230, 1184, 32);
INSERT INTO `wiki_page` VALUES (1185, 8, 0x546f6f6c626f78, 0x7379736f70, 0, 0, 0, 0.116161158823, 0x3230303730313331323030363230, 1185, 7);
INSERT INTO `wiki_page` VALUES (1186, 8, 0x546f6f6c7469702d636f6d7061726573656c656374656476657273696f6e73, 0x7379736f70, 0, 0, 0, 0.123864764179, 0x3230303730313331323030363230, 1186, 75);
INSERT INTO `wiki_page` VALUES (1187, 8, 0x546f6f6c7469702d64696666, 0x7379736f70, 0, 0, 0, 0.051881186044, 0x3230303730313331323030363230, 1187, 48);
INSERT INTO `wiki_page` VALUES (1188, 8, 0x546f6f6c7469702d6d696e6f7265646974, 0x7379736f70, 0, 0, 0, 0.588265999193, 0x3230303730313331323030363230, 1188, 33);
INSERT INTO `wiki_page` VALUES (1189, 8, 0x546f6f6c7469702d70726576696577, 0x7379736f70, 0, 0, 0, 0.522451199496, 0x3230303730313331323030363230, 1189, 60);
INSERT INTO `wiki_page` VALUES (1190, 8, 0x546f6f6c7469702d7265637265617465, 0x7379736f70, 0, 0, 0, 0.955196211448, 0x3230303730313331323030363230, 1190, 0);
INSERT INTO `wiki_page` VALUES (1191, 8, 0x546f6f6c7469702d73617665, 0x7379736f70, 0, 0, 0, 0.623683993302, 0x3230303730313331323030363230, 1191, 25);
INSERT INTO `wiki_page` VALUES (1192, 8, 0x546f6f6c7469702d736561726368, 0x7379736f70, 0, 0, 0, 0.619129325136, 0x3230303730313331323030363230, 1192, 27);
INSERT INTO `wiki_page` VALUES (1193, 8, 0x546f6f6c7469702d7761746368, 0x7379736f70, 0, 0, 0, 0.524559310642, 0x3230303730313331323030363230, 1193, 39);
INSERT INTO `wiki_page` VALUES (1194, 8, 0x547261636b6261636b, 0x7379736f70, 0, 0, 0, 0.150164550415, 0x3230303730313331323030363230, 1194, 16);
INSERT INTO `wiki_page` VALUES (1195, 8, 0x547261636b6261636b626f78, 0x7379736f70, 0, 0, 0, 0.607399505954, 0x3230303730313331323030363230, 1195, 69);
INSERT INTO `wiki_page` VALUES (1196, 8, 0x547261636b6261636b64656c6574656f6b, 0x7379736f70, 0, 0, 0, 0.934870917119, 0x3230303730313331323030363230, 1196, 39);
INSERT INTO `wiki_page` VALUES (1197, 8, 0x547261636b6261636b65786365727074, 0x7379736f70, 0, 0, 0, 0.582496091493, 0x3230303730313331323030363230, 1197, 37);
INSERT INTO `wiki_page` VALUES (1198, 8, 0x547261636b6261636b6c696e6b, 0x7379736f70, 0, 0, 0, 0.069432639289, 0x3230303730313331323030363230, 1198, 9);
INSERT INTO `wiki_page` VALUES (1199, 8, 0x547261636b6261636b72656d6f7665, 0x7379736f70, 0, 0, 0, 0.078322069758, 0x3230303730313331323030363230, 1199, 14);
INSERT INTO `wiki_page` VALUES (1200, 8, 0x5472796578616374, 0x7379736f70, 0, 0, 0, 0.418006258294, 0x3230303730313331323030363230, 1200, 15);
INSERT INTO `wiki_page` VALUES (1201, 8, 0x54756573646179, 0x7379736f70, 0, 0, 0, 0.675356806629, 0x3230303730313331323030363230, 1201, 7);
INSERT INTO `wiki_page` VALUES (1202, 8, 0x55636c696e6b73, 0x7379736f70, 0, 0, 0, 0.570407632091, 0x3230303730313331323030363230, 1202, 48);
INSERT INTO `wiki_page` VALUES (1203, 8, 0x55636e6f7465, 0x7379736f70, 0, 0, 0, 0.038620808869, 0x3230303730313331323030363231, 1203, 72);
INSERT INTO `wiki_page` VALUES (1204, 8, 0x5563746f70, 0x7379736f70, 0, 0, 0, 0.235052583671, 0x3230303730313331323030363231, 1204, 6);
INSERT INTO `wiki_page` VALUES (1205, 8, 0x556964, 0x7379736f70, 0, 0, 0, 0.087060790956, 0x3230303730313331323030363231, 1205, 8);
INSERT INTO `wiki_page` VALUES (1206, 8, 0x556e626c6f636b6970, 0x7379736f70, 0, 0, 0, 0.401012690916, 0x3230303730313331323030363231, 1206, 12);
INSERT INTO `wiki_page` VALUES (1207, 8, 0x556e626c6f636b697074657874, 0x7379736f70, 0, 0, 0, 0.156265381497, 0x3230303730313331323030363231, 1207, 90);
INSERT INTO `wiki_page` VALUES (1208, 8, 0x556e626c6f636b6c696e6b, 0x7379736f70, 0, 0, 0, 0.447430648133, 0x3230303730313331323030363231, 1208, 7);
INSERT INTO `wiki_page` VALUES (1209, 8, 0x556e626c6f636b6c6f67656e747279, 0x7379736f70, 0, 0, 0, 0.294170168255, 0x3230303730313331323030363231, 1209, 12);
INSERT INTO `wiki_page` VALUES (1210, 8, 0x556e63617465676f72697a656463617465676f72696573, 0x7379736f70, 0, 0, 0, 0.206299251997, 0x3230303730313331323030363231, 1210, 24);
INSERT INTO `wiki_page` VALUES (1211, 8, 0x556e63617465676f72697a65647061676573, 0x7379736f70, 0, 0, 0, 0.842162582516, 0x3230303730313331323030363231, 1211, 19);
INSERT INTO `wiki_page` VALUES (1212, 8, 0x556e64656c657465, 0x7379736f70, 0, 0, 0, 0.820019908119, 0x3230303730313331323030363231, 1212, 18);
INSERT INTO `wiki_page` VALUES (1213, 8, 0x556e64656c6574655f73686f7274, 0x7379736f70, 0, 0, 0, 0.2916229723, 0x3230303730313331323030363231, 1213, 17);
INSERT INTO `wiki_page` VALUES (1214, 8, 0x556e64656c6574655f73686f727431, 0x7379736f70, 0, 0, 0, 0.924904577071, 0x3230303730313331323030363231, 1214, 17);
INSERT INTO `wiki_page` VALUES (1215, 8, 0x556e64656c65746561727469636c65, 0x7379736f70, 0, 0, 0, 0.640189574937, 0x3230303730313331323030363231, 1215, 20);
INSERT INTO `wiki_page` VALUES (1216, 8, 0x556e64656c65746562746e, 0x7379736f70, 0, 0, 0, 0.691438234969, 0x3230303730313331323030363231, 1216, 8);
INSERT INTO `wiki_page` VALUES (1217, 8, 0x556e64656c6574656461727469636c65, 0x7379736f70, 0, 0, 0, 0.863560350407, 0x3230303730313331323030363231, 1217, 17);
INSERT INTO `wiki_page` VALUES (1218, 8, 0x556e64656c657465647265766973696f6e73, 0x7379736f70, 0, 0, 0, 0.468345012853, 0x3230303730313331323030363231, 1218, 21);
INSERT INTO `wiki_page` VALUES (1219, 8, 0x556e64656c6574656474657874, 0x7379736f70, 0, 0, 0, 0.342851096668, 0x3230303730313331323030363231, 1219, 120);
INSERT INTO `wiki_page` VALUES (1220, 8, 0x556e64656c657465686973746f7279, 0x7379736f70, 0, 0, 0, 0.103331064063, 0x3230303730313331323030363231, 1220, 276);
INSERT INTO `wiki_page` VALUES (1221, 8, 0x556e64656c657465686973746f72796e6f61646d696e, 0x7379736f70, 0, 0, 0, 0.966535723699, 0x3230303730313331323030363231, 1221, 239);
INSERT INTO `wiki_page` VALUES (1222, 8, 0x556e64656c65746570616765, 0x7379736f70, 0, 0, 0, 0.211747113035, 0x3230303730313331323030363231, 1222, 30);
INSERT INTO `wiki_page` VALUES (1223, 8, 0x556e64656c6574657061676574657874, 0x7379736f70, 0, 0, 0, 0.343180912367, 0x3230303730313331323030363231, 1223, 132);
INSERT INTO `wiki_page` VALUES (1224, 8, 0x556e64656c6574657265766973696f6e, 0x7379736f70, 0, 0, 0, 0.045548229509, 0x3230303730313331323030363231, 1224, 25);
INSERT INTO `wiki_page` VALUES (1225, 8, 0x556e64656c6574657265766973696f6e73, 0x7379736f70, 0, 0, 0, 0.349026388855, 0x3230303730313331323030363231, 1225, 21);
INSERT INTO `wiki_page` VALUES (1226, 8, 0x556e6465726c696e652d616c77617973, 0x7379736f70, 0, 0, 0, 0.052592096274, 0x3230303730313331323030363231, 1226, 6);
INSERT INTO `wiki_page` VALUES (1227, 8, 0x556e6465726c696e652d64656661756c74, 0x7379736f70, 0, 0, 0, 0.523012808713, 0x3230303730313331323030363231, 1227, 15);
INSERT INTO `wiki_page` VALUES (1228, 8, 0x556e6465726c696e652d6e65766572, 0x7379736f70, 0, 0, 0, 0.911333836563, 0x3230303730313331323030363231, 1228, 5);
INSERT INTO `wiki_page` VALUES (1229, 8, 0x556e6578706563746564, 0x7379736f70, 0, 0, 0, 0.513535122731, 0x3230303730313331323030363231, 1229, 28);
INSERT INTO `wiki_page` VALUES (1230, 8, 0x556e69742d706978656c, 0x7379736f70, 0, 0, 0, 0.024165765824, 0x3230303730313331323030363231, 1230, 2);
INSERT INTO `wiki_page` VALUES (1231, 8, 0x556e6c6f636b62746e, 0x7379736f70, 0, 0, 0, 0.201658058337, 0x3230303730313331323030363231, 1231, 15);
INSERT INTO `wiki_page` VALUES (1232, 8, 0x556e6c6f636b636f6e6669726d, 0x7379736f70, 0, 0, 0, 0.889215209581, 0x3230303730313331323030363231, 1232, 42);
INSERT INTO `wiki_page` VALUES (1233, 8, 0x556e6c6f636b6462, 0x7379736f70, 0, 0, 0, 0.674029287038, 0x3230303730313331323030363231, 1233, 15);
INSERT INTO `wiki_page` VALUES (1234, 8, 0x556e6c6f636b646273756363657373737562, 0x7379736f70, 0, 0, 0, 0.966375045045, 0x3230303730313331323030363231, 1234, 21);
INSERT INTO `wiki_page` VALUES (1235, 8, 0x556e6c6f636b64627375636365737374657874, 0x7379736f70, 0, 0, 0, 0.898107732467, 0x3230303730313331323030363231, 1235, 31);
INSERT INTO `wiki_page` VALUES (1236, 8, 0x556e6c6f636b646274657874, 0x7379736f70, 0, 0, 0, 0.906756669108, 0x3230303730313331323030363231, 1236, 227);
INSERT INTO `wiki_page` VALUES (1237, 8, 0x556e70726f74656374, 0x7379736f70, 0, 0, 0, 0.701027573525, 0x3230303730313331323030363231, 1237, 9);
INSERT INTO `wiki_page` VALUES (1238, 8, 0x556e70726f74656374636f6d6d656e74, 0x7379736f70, 0, 0, 0, 0.100263109081, 0x3230303730313331323030363231, 1238, 23);
INSERT INTO `wiki_page` VALUES (1239, 8, 0x556e70726f74656374656461727469636c65, 0x7379736f70, 0, 0, 0, 0.405707926708, 0x3230303730313331323030363231, 1239, 20);
INSERT INTO `wiki_page` VALUES (1240, 8, 0x556e70726f74656374737562, 0x7379736f70, 0, 0, 0, 0.077191329149, 0x3230303730313331323030363231, 1240, 19);
INSERT INTO `wiki_page` VALUES (1241, 8, 0x556e70726f746563747468697370616765, 0x7379736f70, 0, 0, 0, 0.65748974949, 0x3230303730313331323030363231, 1241, 19);
INSERT INTO `wiki_page` VALUES (1242, 8, 0x556e7573656463617465676f72696573, 0x7379736f70, 0, 0, 0, 0.802916099282, 0x3230303730313331323030363231, 1242, 17);
INSERT INTO `wiki_page` VALUES (1243, 8, 0x556e7573656463617465676f7269657374657874, 0x7379736f70, 0, 0, 0, 0.373093882756, 0x3230303730313331323030363231, 1243, 90);
INSERT INTO `wiki_page` VALUES (1244, 8, 0x556e75736564696d61676573, 0x7379736f70, 0, 0, 0, 0.541440501798, 0x3230303730313331323030363231, 1244, 12);
INSERT INTO `wiki_page` VALUES (1245, 8, 0x556e75736564696d6167657374657874, 0x7379736f70, 0, 0, 0, 0.288837114297, 0x3230303730313331323030363231, 1245, 140);
INSERT INTO `wiki_page` VALUES (1246, 8, 0x556e7761746368, 0x7379736f70, 0, 0, 0, 0.967089902625, 0x3230303730313331323030363231, 1246, 7);
INSERT INTO `wiki_page` VALUES (1247, 8, 0x556e776174636865647061676573, 0x7379736f70, 0, 0, 0, 0.922001295631, 0x3230303730313331323030363231, 1247, 15);
INSERT INTO `wiki_page` VALUES (1248, 8, 0x556e77617463687468697370616765, 0x7379736f70, 0, 0, 0, 0.198188566773, 0x3230303730313331323030363231, 1248, 13);
INSERT INTO `wiki_page` VALUES (1249, 8, 0x55706461746564, 0x7379736f70, 0, 0, 0, 0.20611246623, 0x3230303730313331323030363231, 1249, 9);
INSERT INTO `wiki_page` VALUES (1250, 8, 0x557064617465646d61726b6572, 0x7379736f70, 0, 0, 0, 0.330519852778, 0x3230303730313331323030363231, 1250, 27);
INSERT INTO `wiki_page` VALUES (1251, 8, 0x55706c6f6164, 0x7379736f70, 0, 0, 0, 0.777489742023, 0x3230303730313331323030363231, 1251, 11);
INSERT INTO `wiki_page` VALUES (1252, 8, 0x55706c6f61645f6469726563746f72795f726561645f6f6e6c79, 0x7379736f70, 0, 0, 0, 0.154716214842, 0x3230303730313331323030363231, 1252, 59);
INSERT INTO `wiki_page` VALUES (1253, 8, 0x55706c6f616462746e, 0x7379736f70, 0, 0, 0, 0.153129365638, 0x3230303730313331323030363231, 1253, 11);
INSERT INTO `wiki_page` VALUES (1254, 8, 0x55706c6f6164636f7272757074, 0x7379736f70, 0, 0, 0, 0.554298192481, 0x3230303730313331323030363231, 1254, 90);
INSERT INTO `wiki_page` VALUES (1255, 8, 0x55706c6f616464697361626c6564, 0x7379736f70, 0, 0, 0, 0.129136210864, 0x3230303730313331323030363231, 1255, 16);
INSERT INTO `wiki_page` VALUES (1256, 8, 0x55706c6f616464697361626c656474657874, 0x7379736f70, 0, 0, 0, 0.528873376127, 0x3230303730313331323030363231, 1256, 39);
INSERT INTO `wiki_page` VALUES (1257, 8, 0x55706c6f6164656466696c6573, 0x7379736f70, 0, 0, 0, 0.014210863819, 0x3230303730313331323030363231, 1257, 14);
INSERT INTO `wiki_page` VALUES (1258, 8, 0x55706c6f61646564696d616765, 0x7379736f70, 0, 0, 0, 0.57726690903, 0x3230303730313331323030363231, 1258, 17);
INSERT INTO `wiki_page` VALUES (1259, 8, 0x55706c6f61646572726f72, 0x7379736f70, 0, 0, 0, 0.424989588288, 0x3230303730313331323030363231, 1259, 12);
INSERT INTO `wiki_page` VALUES (1260, 8, 0x55706c6f61646c696e6b, 0x7379736f70, 0, 0, 0, 0.743593890221, 0x3230303730313331323030363231, 1260, 13);
INSERT INTO `wiki_page` VALUES (1261, 8, 0x55706c6f61646c6f67, 0x7379736f70, 0, 0, 0, 0.003946414116, 0x3230303730313331323030363231, 1261, 10);
INSERT INTO `wiki_page` VALUES (1262, 8, 0x55706c6f61646c6f6770616765, 0x7379736f70, 0, 0, 0, 0.262811931147, 0x3230303730313331323030363231, 1262, 10);
INSERT INTO `wiki_page` VALUES (1263, 8, 0x55706c6f61646c6f677061676574657874, 0x7379736f70, 0, 0, 0, 0.786670378813, 0x3230303730313331323030363231, 1263, 48);
INSERT INTO `wiki_page` VALUES (1264, 8, 0x55706c6f61646e657776657273696f6e, 0x7379736f70, 0, 0, 0, 0.239524802443, 0x3230303730313331323030363231, 1264, 38);
INSERT INTO `wiki_page` VALUES (1265, 8, 0x55706c6f61646e6f6c6f67696e, 0x7379736f70, 0, 0, 0, 0.80185667509, 0x3230303730313331323030363231, 1265, 13);
INSERT INTO `wiki_page` VALUES (1266, 8, 0x55706c6f61646e6f6c6f67696e74657874, 0x7379736f70, 0, 0, 0, 0.314707087907, 0x3230303730313331323030363231, 1266, 60);
INSERT INTO `wiki_page` VALUES (1267, 8, 0x55706c6f61647363726970746564, 0x7379736f70, 0, 0, 0, 0.289183887708, 0x3230303730313331323030363231, 1267, 95);
INSERT INTO `wiki_page` VALUES (1268, 8, 0x55706c6f616474657874, 0x7379736f70, 0, 0, 0, 0.880945462501, 0x3230303730313331323030363231, 1268, 455);
INSERT INTO `wiki_page` VALUES (1269, 8, 0x55706c6f61647669727573, 0x7379736f70, 0, 0, 0, 0.671462808408, 0x3230303730313331323030363231, 1269, 38);
INSERT INTO `wiki_page` VALUES (1270, 8, 0x55706c6f61647761726e696e67, 0x7379736f70, 0, 0, 0, 0.075794144785, 0x3230303730313331323030363231, 1270, 14);
INSERT INTO `wiki_page` VALUES (1271, 8, 0x5573656e657763617465676f727970616765, 0x7379736f70, 0, 0, 0, 0.549476393619, 0x3230303730313331323030363231, 1271, 70);
INSERT INTO `wiki_page` VALUES (1272, 8, 0x557365725f7269676874735f736574, 0x7379736f70, 0, 0, 0, 0.16635959064, 0x3230303730313331323030363231, 1272, 35);
INSERT INTO `wiki_page` VALUES (1273, 8, 0x557365726373736a73796f7563616e70726576696577, 0x7379736f70, 0, 0, 0, 0.047430772544, 0x3230303730313331323030363231, 1273, 90);
INSERT INTO `wiki_page` VALUES (1274, 8, 0x5573657263737370726576696577, 0x7379736f70, 0, 0, 0, 0.611035268943, 0x3230303730313331323030363231, 1274, 85);
INSERT INTO `wiki_page` VALUES (1275, 8, 0x55736572657869737473, 0x7379736f70, 0, 0, 0, 0.396552723487, 0x3230303730313331323030363231, 1275, 64);
INSERT INTO `wiki_page` VALUES (1276, 8, 0x55736572696e76616c69646373736a737469746c65, 0x7379736f70, 0, 0, 0, 0.186796476134, 0x3230303730313331323030363231, 1276, 164);
INSERT INTO `wiki_page` VALUES (1277, 8, 0x557365726a7370726576696577, 0x7379736f70, 0, 0, 0, 0.25416604655, 0x3230303730313331323030363231, 1277, 100);
INSERT INTO `wiki_page` VALUES (1278, 8, 0x557365726c6f67696e, 0x7379736f70, 0, 0, 0, 0.425211644732, 0x3230303730313331323030363231, 1278, 23);
INSERT INTO `wiki_page` VALUES (1279, 8, 0x557365726c6f676f7574, 0x7379736f70, 0, 0, 0, 0.952485880057, 0x3230303730313331323030363231, 1279, 7);
INSERT INTO `wiki_page` VALUES (1280, 8, 0x557365726d61696c65726572726f72, 0x7379736f70, 0, 0, 0, 0.235623449287, 0x3230303730313331323030363231, 1280, 27);
INSERT INTO `wiki_page` VALUES (1281, 8, 0x557365726e616d65, 0x7379736f70, 0, 0, 0, 0.659644598662, 0x3230303730313331323030363231, 1281, 9);
INSERT INTO `wiki_page` VALUES (1282, 8, 0x5573657270616765, 0x7379736f70, 0, 0, 0, 0.953007087798, 0x3230303730313331323030363231, 1282, 14);
INSERT INTO `wiki_page` VALUES (1283, 8, 0x55736572726967687473, 0x7379736f70, 0, 0, 0, 0.693336292623, 0x3230303730313331323030363232, 1283, 22);
INSERT INTO `wiki_page` VALUES (1284, 8, 0x557365727269676874732d656469747573657267726f7570, 0x7379736f70, 0, 0, 0, 0.140453741666, 0x3230303730313331323030363232, 1284, 16);
INSERT INTO `wiki_page` VALUES (1285, 8, 0x557365727269676874732d67726f757073617661696c61626c65, 0x7379736f70, 0, 0, 0, 0.988067900121, 0x3230303730313331323030363232, 1285, 17);
INSERT INTO `wiki_page` VALUES (1286, 8, 0x557365727269676874732d67726f75707368656c70, 0x7379736f70, 0, 0, 0, 0.37303998907, 0x3230303730313331323030363232, 1286, 150);
INSERT INTO `wiki_page` VALUES (1287, 8, 0x557365727269676874732d67726f7570736d656d626572, 0x7379736f70, 0, 0, 0, 0.567300975216, 0x3230303730313331323030363232, 1287, 10);
INSERT INTO `wiki_page` VALUES (1288, 8, 0x557365727269676874732d6c6f67636f6d6d656e74, 0x7379736f70, 0, 0, 0, 0.771480348301, 0x3230303730313331323030363232, 1288, 38);
INSERT INTO `wiki_page` VALUES (1289, 8, 0x557365727269676874732d6c6f6f6b75702d75736572, 0x7379736f70, 0, 0, 0, 0.486516277821, 0x3230303730313331323030363232, 1289, 18);
INSERT INTO `wiki_page` VALUES (1290, 8, 0x557365727269676874732d757365722d656469746e616d65, 0x7379736f70, 0, 0, 0, 0.128477149537, 0x3230303730313331323030363232, 1290, 17);
INSERT INTO `wiki_page` VALUES (1291, 8, 0x557365727374617473, 0x7379736f70, 0, 0, 0, 0.275200349525, 0x3230303730313331323030363232, 1291, 15);
INSERT INTO `wiki_page` VALUES (1292, 8, 0x55736572737461747374657874, 0x7379736f70, 0, 0, 0, 0.621084172716, 0x3230303730313331323030363232, 1292, 98);
INSERT INTO `wiki_page` VALUES (1293, 8, 0x56617269616e746e616d652d7372, 0x7379736f70, 0, 0, 0, 0.599703637384, 0x3230303730313331323030363232, 1293, 2);
INSERT INTO `wiki_page` VALUES (1294, 8, 0x56617269616e746e616d652d73722d6563, 0x7379736f70, 0, 0, 0, 0.904121810295, 0x3230303730313331323030363232, 1294, 5);
INSERT INTO `wiki_page` VALUES (1295, 8, 0x56617269616e746e616d652d73722d656c, 0x7379736f70, 0, 0, 0, 0.851419229559, 0x3230303730313331323030363232, 1295, 5);
INSERT INTO `wiki_page` VALUES (1296, 8, 0x56617269616e746e616d652d73722d6a63, 0x7379736f70, 0, 0, 0, 0.156824214457, 0x3230303730313331323030363232, 1296, 5);
INSERT INTO `wiki_page` VALUES (1297, 8, 0x56617269616e746e616d652d73722d6a6c, 0x7379736f70, 0, 0, 0, 0.583400645958, 0x3230303730313331323030363232, 1297, 5);
INSERT INTO `wiki_page` VALUES (1298, 8, 0x56617269616e746e616d652d7a68, 0x7379736f70, 0, 0, 0, 0.610570524822, 0x3230303730313331323030363232, 1298, 2);
INSERT INTO `wiki_page` VALUES (1299, 8, 0x56617269616e746e616d652d7a682d636e, 0x7379736f70, 0, 0, 0, 0.038067831776, 0x3230303730313331323030363232, 1299, 2);
INSERT INTO `wiki_page` VALUES (1300, 8, 0x56617269616e746e616d652d7a682d686b, 0x7379736f70, 0, 0, 0, 0.745010777729, 0x3230303730313331323030363232, 1300, 2);
INSERT INTO `wiki_page` VALUES (1301, 8, 0x56617269616e746e616d652d7a682d7367, 0x7379736f70, 0, 0, 0, 0.568219388278, 0x3230303730313331323030363232, 1301, 2);
INSERT INTO `wiki_page` VALUES (1302, 8, 0x56617269616e746e616d652d7a682d7477, 0x7379736f70, 0, 0, 0, 0.896014694321, 0x3230303730313331323030363232, 1302, 2);
INSERT INTO `wiki_page` VALUES (1303, 8, 0x56657273696f6e, 0x7379736f70, 0, 0, 0, 0.415356182365, 0x3230303730313331323030363232, 1303, 7);
INSERT INTO `wiki_page` VALUES (1304, 8, 0x56657273696f6e7265717569726564, 0x7379736f70, 0, 0, 0, 0.070075369429, 0x3230303730313331323030363232, 1304, 32);
INSERT INTO `wiki_page` VALUES (1305, 8, 0x56657273696f6e726571756972656474657874, 0x7379736f70, 0, 0, 0, 0.010683208691, 0x3230303730313331323030363232, 1305, 77);
INSERT INTO `wiki_page` VALUES (1306, 8, 0x56696577636f756e74, 0x7379736f70, 0, 0, 0, 0.491725204481, 0x3230303730313331323030363232, 1306, 37);
INSERT INTO `wiki_page` VALUES (1307, 8, 0x5669657764656c65746564, 0x7379736f70, 0, 0, 0, 0.611226022012, 0x3230303730313331323030363232, 1307, 8);
INSERT INTO `wiki_page` VALUES (1308, 8, 0x5669657764656c6574656470616765, 0x7379736f70, 0, 0, 0, 0.511289744707, 0x3230303730313331323030363232, 1308, 18);
INSERT INTO `wiki_page` VALUES (1309, 8, 0x56696577707265766e657874, 0x7379736f70, 0, 0, 0, 0.850825766673, 0x3230303730313331323030363232, 1309, 20);
INSERT INTO `wiki_page` VALUES (1310, 8, 0x5669657773, 0x7379736f70, 0, 0, 0, 0.79088649004, 0x3230303730313331323030363232, 1310, 5);
INSERT INTO `wiki_page` VALUES (1311, 8, 0x56696577736f75726365, 0x7379736f70, 0, 0, 0, 0.660160331791, 0x3230303730313331323030363232, 1311, 11);
INSERT INTO `wiki_page` VALUES (1312, 8, 0x56696577736f75726365666f72, 0x7379736f70, 0, 0, 0, 0.479078302327, 0x3230303730313331323030363232, 1312, 6);
INSERT INTO `wiki_page` VALUES (1313, 8, 0x5669657774616c6b70616765, 0x7379736f70, 0, 0, 0, 0.492045343427, 0x3230303730313331323030363232, 1313, 15);
INSERT INTO `wiki_page` VALUES (1314, 8, 0x57616e74656463617465676f72696573, 0x7379736f70, 0, 0, 0, 0.946263076603, 0x3230303730313331323030363232, 1314, 17);
INSERT INTO `wiki_page` VALUES (1315, 8, 0x57616e7465647061676573, 0x7379736f70, 0, 0, 0, 0.530299405452, 0x3230303730313331323030363232, 1315, 12);
INSERT INTO `wiki_page` VALUES (1316, 8, 0x5761746368, 0x7379736f70, 0, 0, 0, 0.080050819168, 0x3230303730313331323030363232, 1316, 5);
INSERT INTO `wiki_page` VALUES (1317, 8, 0x576174636864657461696c73, 0x7379736f70, 0, 0, 0, 0.134868414652, 0x3230303730313331323030363232, 1317, 104);
INSERT INTO `wiki_page` VALUES (1318, 8, 0x5761746368656469746c697374, 0x7379736f70, 0, 0, 0, 0.382575053086, 0x3230303730313331323030363232, 1318, 270);
INSERT INTO `wiki_page` VALUES (1319, 8, 0x57617463686c697374, 0x7379736f70, 0, 0, 0, 0.328601855124, 0x3230303730313331323030363232, 1319, 12);
INSERT INTO `wiki_page` VALUES (1320, 8, 0x57617463686c697374616c6c31, 0x7379736f70, 0, 0, 0, 0.311276573384, 0x3230303730313331323030363232, 1320, 3);
INSERT INTO `wiki_page` VALUES (1321, 8, 0x57617463686c697374616c6c32, 0x7379736f70, 0, 0, 0, 0.559871668774, 0x3230303730313331323030363232, 1321, 3);
INSERT INTO `wiki_page` VALUES (1322, 8, 0x57617463686c697374636f6e7461696e73, 0x7379736f70, 0, 0, 0, 0.997558489515, 0x3230303730313331323030363232, 1322, 33);
INSERT INTO `wiki_page` VALUES (1323, 8, 0x57617463686c697374737562, 0x7379736f70, 0, 0, 0, 0.698375645645, 0x3230303730313331323030363232, 1323, 15);
INSERT INTO `wiki_page` VALUES (1324, 8, 0x57617463686d6574686f642d6c697374, 0x7379736f70, 0, 0, 0, 0.220291496583, 0x3230303730313331323030363232, 1324, 39);
INSERT INTO `wiki_page` VALUES (1325, 8, 0x57617463686d6574686f642d726563656e74, 0x7379736f70, 0, 0, 0, 0.142501670583, 0x3230303730313331323030363232, 1325, 39);
INSERT INTO `wiki_page` VALUES (1326, 8, 0x57617463686e6f6368616e6765, 0x7379736f70, 0, 0, 0, 0.44696043569, 0x3230303730313331323030363232, 1326, 67);
INSERT INTO `wiki_page` VALUES (1327, 8, 0x57617463686e6f6c6f67696e, 0x7379736f70, 0, 0, 0, 0.794570918829, 0x3230303730313331323030363232, 1327, 13);
INSERT INTO `wiki_page` VALUES (1328, 8, 0x57617463686e6f6c6f67696e74657874, 0x7379736f70, 0, 0, 0, 0.804644347729, 0x3230303730313331323030363232, 1328, 69);
INSERT INTO `wiki_page` VALUES (1329, 8, 0x576174636874686973, 0x7379736f70, 0, 0, 0, 0.280683249509, 0x3230303730313331323030363232, 1329, 15);
INSERT INTO `wiki_page` VALUES (1330, 8, 0x57617463687468697370616765, 0x7379736f70, 0, 0, 0, 0.914784216872, 0x3230303730313331323030363232, 1330, 15);
INSERT INTO `wiki_page` VALUES (1331, 8, 0x5765646e6573646179, 0x7379736f70, 0, 0, 0, 0.929903023577, 0x3230303730313331323030363232, 1331, 9);
INSERT INTO `wiki_page` VALUES (1332, 8, 0x57656c636f6d656372656174696f6e, 0x7379736f70, 0, 0, 0, 0.304829796574, 0x3230303730313331323030363232, 1332, 104);
INSERT INTO `wiki_page` VALUES (1333, 8, 0x576861746c696e6b7368657265, 0x7379736f70, 0, 0, 0, 0.762060418692, 0x3230303730313331323030363232, 1333, 15);
INSERT INTO `wiki_page` VALUES (1334, 8, 0x57686974656c69737461636374657874, 0x7379736f70, 0, 0, 0, 0.603464634319, 0x3230303730313331323030363232, 1334, 124);
INSERT INTO `wiki_page` VALUES (1335, 8, 0x57686974656c6973746163637469746c65, 0x7379736f70, 0, 0, 0, 0.07362882955, 0x3230303730313331323030363232, 1335, 40);
INSERT INTO `wiki_page` VALUES (1336, 8, 0x57686974656c6973746564697474657874, 0x7379736f70, 0, 0, 0, 0.801443617505, 0x3230303730313331323030363232, 1336, 54);
INSERT INTO `wiki_page` VALUES (1337, 8, 0x57686974656c697374656469747469746c65, 0x7379736f70, 0, 0, 0, 0.150506363287, 0x3230303730313331323030363232, 1337, 22);
INSERT INTO `wiki_page` VALUES (1338, 8, 0x57686974656c6973747265616474657874, 0x7379736f70, 0, 0, 0, 0.734975303642, 0x3230303730313331323030363232, 1338, 54);
INSERT INTO `wiki_page` VALUES (1339, 8, 0x57686974656c697374726561647469746c65, 0x7379736f70, 0, 0, 0, 0.180961088352, 0x3230303730313331323030363232, 1339, 22);
INSERT INTO `wiki_page` VALUES (1340, 8, 0x5769647468686569676874, 0x7379736f70, 0, 0, 0, 0.19554780112, 0x3230303730313331323030363232, 1340, 5);
INSERT INTO `wiki_page` VALUES (1341, 8, 0x57696b69706564696170616765, 0x7379736f70, 0, 0, 0, 0.181896191969, 0x3230303730313331323030363232, 1341, 17);
INSERT INTO `wiki_page` VALUES (1342, 8, 0x576c6865616465722d656e6f746966, 0x7379736f70, 0, 0, 0, 0.461143690801, 0x3230303730313331323030363232, 1342, 33);
INSERT INTO `wiki_page` VALUES (1343, 8, 0x576c6865616465722d73686f7775706461746564, 0x7379736f70, 0, 0, 0, 0.820624898162, 0x3230303730313331323030363232, 1343, 83);
INSERT INTO `wiki_page` VALUES (1344, 8, 0x576c68696465, 0x7379736f70, 0, 0, 0, 0.964942718428, 0x3230303730313331323030363232, 1344, 4);
INSERT INTO `wiki_page` VALUES (1345, 8, 0x576c6869646573686f77626f7473, 0x7379736f70, 0, 0, 0, 0.267175429199, 0x3230303730313331323030363232, 1345, 13);
INSERT INTO `wiki_page` VALUES (1346, 8, 0x576c6869646573686f776f776e, 0x7379736f70, 0, 0, 0, 0.097877797487, 0x3230303730313331323030363232, 1346, 12);
INSERT INTO `wiki_page` VALUES (1347, 8, 0x576c6e6f7465, 0x7379736f70, 0, 0, 0, 0.558267564226, 0x3230303730313331323030363232, 1347, 58);
INSERT INTO `wiki_page` VALUES (1348, 8, 0x576c7361766564, 0x7379736f70, 0, 0, 0, 0.620119472209, 0x3230303730313331323030363232, 1348, 42);
INSERT INTO `wiki_page` VALUES (1349, 8, 0x576c73686f77, 0x7379736f70, 0, 0, 0, 0.607166385138, 0x3230303730313331323030363232, 1349, 4);
INSERT INTO `wiki_page` VALUES (1350, 8, 0x576c73686f776c617374, 0x7379736f70, 0, 0, 0, 0.994506592902, 0x3230303730313331323030363232, 1350, 29);
INSERT INTO `wiki_page` VALUES (1351, 8, 0x57726f6e675f776651756572795f706172616d73, 0x7379736f70, 0, 0, 0, 0.850124030222, 0x3230303730313331323030363232, 1351, 68);
INSERT INTO `wiki_page` VALUES (1352, 8, 0x57726f6e6770617373776f7264, 0x7379736f70, 0, 0, 0, 0.978800949801, 0x3230303730313331323030363232, 1352, 45);
INSERT INTO `wiki_page` VALUES (1353, 8, 0x57726f6e6770617373776f7264656d707479, 0x7379736f70, 0, 0, 0, 0.369464631274, 0x3230303730313331323030363232, 1353, 45);
INSERT INTO `wiki_page` VALUES (1354, 8, 0x596f75686176656e65776d65737361676573, 0x7379736f70, 0, 0, 0, 0.838126112456, 0x3230303730313331323030363232, 1354, 17);
INSERT INTO `wiki_page` VALUES (1355, 8, 0x596f75686176656e65776d657373616765736d756c7469, 0x7379736f70, 0, 0, 0, 0.362382983497, 0x3230303730313331323030363232, 1355, 27);
INSERT INTO `wiki_page` VALUES (1356, 8, 0x596f757264696666, 0x7379736f70, 0, 0, 0, 0.448198869486, 0x3230303730313331323030363232, 1356, 11);
INSERT INTO `wiki_page` VALUES (1357, 8, 0x596f7572646f6d61696e6e616d65, 0x7379736f70, 0, 0, 0, 0.414823339373, 0x3230303730313331323030363232, 1357, 11);
INSERT INTO `wiki_page` VALUES (1358, 8, 0x596f7572656d61696c, 0x7379736f70, 0, 0, 0, 0.822280536616, 0x3230303730313331323030363232, 1358, 8);
INSERT INTO `wiki_page` VALUES (1359, 8, 0x596f75726c616e6775616765, 0x7379736f70, 0, 0, 0, 0.575218758347, 0x3230303730313331323030363232, 1359, 9);
INSERT INTO `wiki_page` VALUES (1360, 8, 0x596f75726e616d65, 0x7379736f70, 0, 0, 0, 0.735730653526, 0x3230303730313331323030363232, 1360, 8);
INSERT INTO `wiki_page` VALUES (1361, 8, 0x596f75726e69636b, 0x7379736f70, 0, 0, 0, 0.763283998442, 0x3230303730313331323030363232, 1361, 9);
INSERT INTO `wiki_page` VALUES (1362, 8, 0x596f757270617373776f7264, 0x7379736f70, 0, 0, 0, 0.435544817669, 0x3230303730313331323030363232, 1362, 8);
INSERT INTO `wiki_page` VALUES (1363, 8, 0x596f757270617373776f7264616761696e, 0x7379736f70, 0, 0, 0, 0.235338356338, 0x3230303730313331323030363232, 1363, 15);
INSERT INTO `wiki_page` VALUES (1364, 8, 0x596f75727265616c6e616d65, 0x7379736f70, 0, 0, 0, 0.679849970034, 0x3230303730313331323030363233, 1364, 11);
INSERT INTO `wiki_page` VALUES (1365, 8, 0x596f757274657874, 0x7379736f70, 0, 0, 0, 0.243265572065, 0x3230303730313331323030363233, 1365, 9);
INSERT INTO `wiki_page` VALUES (1366, 8, 0x596f757276617269616e74, 0x7379736f70, 0, 0, 0, 0.248586473116, 0x3230303730313331323030363233, 1366, 7);

-- --------------------------------------------------------

-- 
-- Table structure for table `wiki_pagelinks`
-- 

CREATE TABLE `wiki_pagelinks` (
  `pl_from` int(8) unsigned NOT NULL default '0',
  `pl_namespace` int(11) NOT NULL default '0',
  `pl_title` varchar(255) character set latin1 collate latin1_bin NOT NULL default '',
  UNIQUE KEY `pl_from` (`pl_from`,`pl_namespace`,`pl_title`),
  KEY `pl_namespace` (`pl_namespace`,`pl_title`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `wiki_pagelinks`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `wiki_querycache`
-- 

CREATE TABLE `wiki_querycache` (
  `qc_type` char(32) NOT NULL default '',
  `qc_value` int(5) unsigned NOT NULL default '0',
  `qc_namespace` int(11) NOT NULL default '0',
  `qc_title` char(255) character set latin1 collate latin1_bin NOT NULL default '',
  KEY `qc_type` (`qc_type`,`qc_value`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `wiki_querycache`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `wiki_recentchanges`
-- 

CREATE TABLE `wiki_recentchanges` (
  `rc_id` int(8) NOT NULL auto_increment,
  `rc_timestamp` varchar(14) character set latin1 collate latin1_bin NOT NULL default '',
  `rc_cur_time` varchar(14) character set latin1 collate latin1_bin NOT NULL default '',
  `rc_user` int(10) unsigned NOT NULL default '0',
  `rc_user_text` varchar(255) character set latin1 collate latin1_bin NOT NULL default '',
  `rc_namespace` int(11) NOT NULL default '0',
  `rc_title` varchar(255) character set latin1 collate latin1_bin NOT NULL default '',
  `rc_comment` varchar(255) character set latin1 collate latin1_bin NOT NULL default '',
  `rc_minor` tinyint(3) unsigned NOT NULL default '0',
  `rc_bot` tinyint(3) unsigned NOT NULL default '0',
  `rc_new` tinyint(3) unsigned NOT NULL default '0',
  `rc_cur_id` int(10) unsigned NOT NULL default '0',
  `rc_this_oldid` int(10) unsigned NOT NULL default '0',
  `rc_last_oldid` int(10) unsigned NOT NULL default '0',
  `rc_type` tinyint(3) unsigned NOT NULL default '0',
  `rc_moved_to_ns` tinyint(3) unsigned NOT NULL default '0',
  `rc_moved_to_title` varchar(255) character set latin1 collate latin1_bin NOT NULL default '',
  `rc_patrolled` tinyint(3) unsigned NOT NULL default '0',
  `rc_ip` varchar(15) NOT NULL default '',
  PRIMARY KEY  (`rc_id`),
  KEY `rc_timestamp` (`rc_timestamp`),
  KEY `rc_namespace_title` (`rc_namespace`,`rc_title`),
  KEY `rc_cur_id` (`rc_cur_id`),
  KEY `new_name_timestamp` (`rc_new`,`rc_namespace`,`rc_timestamp`),
  KEY `rc_ip` (`rc_ip`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `wiki_recentchanges`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `wiki_revision`
-- 

CREATE TABLE `wiki_revision` (
  `rev_id` int(8) unsigned NOT NULL auto_increment,
  `rev_page` int(8) unsigned NOT NULL default '0',
  `rev_text_id` int(8) unsigned NOT NULL default '0',
  `rev_comment` tinyblob NOT NULL,
  `rev_user` int(5) unsigned NOT NULL default '0',
  `rev_user_text` varchar(255) character set latin1 collate latin1_bin NOT NULL default '',
  `rev_timestamp` varchar(14) character set latin1 collate latin1_bin NOT NULL default '',
  `rev_minor_edit` tinyint(1) unsigned NOT NULL default '0',
  `rev_deleted` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`rev_page`,`rev_id`),
  UNIQUE KEY `rev_id` (`rev_id`),
  KEY `rev_timestamp` (`rev_timestamp`),
  KEY `page_timestamp` (`rev_page`,`rev_timestamp`),
  KEY `user_timestamp` (`rev_user`,`rev_timestamp`),
  KEY `usertext_timestamp` (`rev_user_text`,`rev_timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1367 ;

-- 
-- Dumping data for table `wiki_revision`
-- 

INSERT INTO `wiki_revision` VALUES (1, 1, 1, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363034, 0, 0);
INSERT INTO `wiki_revision` VALUES (2, 2, 2, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363035, 0, 0);
INSERT INTO `wiki_revision` VALUES (3, 3, 3, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363035, 0, 0);
INSERT INTO `wiki_revision` VALUES (4, 4, 4, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363035, 0, 0);
INSERT INTO `wiki_revision` VALUES (5, 5, 5, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363035, 0, 0);
INSERT INTO `wiki_revision` VALUES (6, 6, 6, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363035, 0, 0);
INSERT INTO `wiki_revision` VALUES (7, 7, 7, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363035, 0, 0);
INSERT INTO `wiki_revision` VALUES (8, 8, 8, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363035, 0, 0);
INSERT INTO `wiki_revision` VALUES (9, 9, 9, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363035, 0, 0);
INSERT INTO `wiki_revision` VALUES (10, 10, 10, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363035, 0, 0);
INSERT INTO `wiki_revision` VALUES (11, 11, 11, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363035, 0, 0);
INSERT INTO `wiki_revision` VALUES (12, 12, 12, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363035, 0, 0);
INSERT INTO `wiki_revision` VALUES (13, 13, 13, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363035, 0, 0);
INSERT INTO `wiki_revision` VALUES (14, 14, 14, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363035, 0, 0);
INSERT INTO `wiki_revision` VALUES (15, 15, 15, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363035, 0, 0);
INSERT INTO `wiki_revision` VALUES (16, 16, 16, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363035, 0, 0);
INSERT INTO `wiki_revision` VALUES (17, 17, 17, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363035, 0, 0);
INSERT INTO `wiki_revision` VALUES (18, 18, 18, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363035, 0, 0);
INSERT INTO `wiki_revision` VALUES (19, 19, 19, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363035, 0, 0);
INSERT INTO `wiki_revision` VALUES (20, 20, 20, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363035, 0, 0);
INSERT INTO `wiki_revision` VALUES (21, 21, 21, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363035, 0, 0);
INSERT INTO `wiki_revision` VALUES (22, 22, 22, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363035, 0, 0);
INSERT INTO `wiki_revision` VALUES (23, 23, 23, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363035, 0, 0);
INSERT INTO `wiki_revision` VALUES (24, 24, 24, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363035, 0, 0);
INSERT INTO `wiki_revision` VALUES (25, 25, 25, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363035, 0, 0);
INSERT INTO `wiki_revision` VALUES (26, 26, 26, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363035, 0, 0);
INSERT INTO `wiki_revision` VALUES (27, 27, 27, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363035, 0, 0);
INSERT INTO `wiki_revision` VALUES (28, 28, 28, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363035, 0, 0);
INSERT INTO `wiki_revision` VALUES (29, 29, 29, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363035, 0, 0);
INSERT INTO `wiki_revision` VALUES (30, 30, 30, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363035, 0, 0);
INSERT INTO `wiki_revision` VALUES (31, 31, 31, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363035, 0, 0);
INSERT INTO `wiki_revision` VALUES (32, 32, 32, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363035, 0, 0);
INSERT INTO `wiki_revision` VALUES (33, 33, 33, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363035, 0, 0);
INSERT INTO `wiki_revision` VALUES (34, 34, 34, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363035, 0, 0);
INSERT INTO `wiki_revision` VALUES (35, 35, 35, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363035, 0, 0);
INSERT INTO `wiki_revision` VALUES (36, 36, 36, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363035, 0, 0);
INSERT INTO `wiki_revision` VALUES (37, 37, 37, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363036, 0, 0);
INSERT INTO `wiki_revision` VALUES (38, 38, 38, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363036, 0, 0);
INSERT INTO `wiki_revision` VALUES (39, 39, 39, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363036, 0, 0);
INSERT INTO `wiki_revision` VALUES (40, 40, 40, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363036, 0, 0);
INSERT INTO `wiki_revision` VALUES (41, 41, 41, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363036, 0, 0);
INSERT INTO `wiki_revision` VALUES (42, 42, 42, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363036, 0, 0);
INSERT INTO `wiki_revision` VALUES (43, 43, 43, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363036, 0, 0);
INSERT INTO `wiki_revision` VALUES (44, 44, 44, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363036, 0, 0);
INSERT INTO `wiki_revision` VALUES (45, 45, 45, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363036, 0, 0);
INSERT INTO `wiki_revision` VALUES (46, 46, 46, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363036, 0, 0);
INSERT INTO `wiki_revision` VALUES (47, 47, 47, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363036, 0, 0);
INSERT INTO `wiki_revision` VALUES (48, 48, 48, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363036, 0, 0);
INSERT INTO `wiki_revision` VALUES (49, 49, 49, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363036, 0, 0);
INSERT INTO `wiki_revision` VALUES (50, 50, 50, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363036, 0, 0);
INSERT INTO `wiki_revision` VALUES (51, 51, 51, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363036, 0, 0);
INSERT INTO `wiki_revision` VALUES (52, 52, 52, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363036, 0, 0);
INSERT INTO `wiki_revision` VALUES (53, 53, 53, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363036, 0, 0);
INSERT INTO `wiki_revision` VALUES (54, 54, 54, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363036, 0, 0);
INSERT INTO `wiki_revision` VALUES (55, 55, 55, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363036, 0, 0);
INSERT INTO `wiki_revision` VALUES (56, 56, 56, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363036, 0, 0);
INSERT INTO `wiki_revision` VALUES (57, 57, 57, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363036, 0, 0);
INSERT INTO `wiki_revision` VALUES (58, 58, 58, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363036, 0, 0);
INSERT INTO `wiki_revision` VALUES (59, 59, 59, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363036, 0, 0);
INSERT INTO `wiki_revision` VALUES (60, 60, 60, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363036, 0, 0);
INSERT INTO `wiki_revision` VALUES (61, 61, 61, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363036, 0, 0);
INSERT INTO `wiki_revision` VALUES (62, 62, 62, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363036, 0, 0);
INSERT INTO `wiki_revision` VALUES (63, 63, 63, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363036, 0, 0);
INSERT INTO `wiki_revision` VALUES (64, 64, 64, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363036, 0, 0);
INSERT INTO `wiki_revision` VALUES (65, 65, 65, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363036, 0, 0);
INSERT INTO `wiki_revision` VALUES (66, 66, 66, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363036, 0, 0);
INSERT INTO `wiki_revision` VALUES (67, 67, 67, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363036, 0, 0);
INSERT INTO `wiki_revision` VALUES (68, 68, 68, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363036, 0, 0);
INSERT INTO `wiki_revision` VALUES (69, 69, 69, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363036, 0, 0);
INSERT INTO `wiki_revision` VALUES (70, 70, 70, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363036, 0, 0);
INSERT INTO `wiki_revision` VALUES (71, 71, 71, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363036, 0, 0);
INSERT INTO `wiki_revision` VALUES (72, 72, 72, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363036, 0, 0);
INSERT INTO `wiki_revision` VALUES (73, 73, 73, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363036, 0, 0);
INSERT INTO `wiki_revision` VALUES (74, 74, 74, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363036, 0, 0);
INSERT INTO `wiki_revision` VALUES (75, 75, 75, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363036, 0, 0);
INSERT INTO `wiki_revision` VALUES (76, 76, 76, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363036, 0, 0);
INSERT INTO `wiki_revision` VALUES (77, 77, 77, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363036, 0, 0);
INSERT INTO `wiki_revision` VALUES (78, 78, 78, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363036, 0, 0);
INSERT INTO `wiki_revision` VALUES (79, 79, 79, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363036, 0, 0);
INSERT INTO `wiki_revision` VALUES (80, 80, 80, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363036, 0, 0);
INSERT INTO `wiki_revision` VALUES (81, 81, 81, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363036, 0, 0);
INSERT INTO `wiki_revision` VALUES (82, 82, 82, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363036, 0, 0);
INSERT INTO `wiki_revision` VALUES (83, 83, 83, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363036, 0, 0);
INSERT INTO `wiki_revision` VALUES (84, 84, 84, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363036, 0, 0);
INSERT INTO `wiki_revision` VALUES (85, 85, 85, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363036, 0, 0);
INSERT INTO `wiki_revision` VALUES (86, 86, 86, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363036, 0, 0);
INSERT INTO `wiki_revision` VALUES (87, 87, 87, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363036, 0, 0);
INSERT INTO `wiki_revision` VALUES (88, 88, 88, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363036, 0, 0);
INSERT INTO `wiki_revision` VALUES (89, 89, 89, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363036, 0, 0);
INSERT INTO `wiki_revision` VALUES (90, 90, 90, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363036, 0, 0);
INSERT INTO `wiki_revision` VALUES (91, 91, 91, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363036, 0, 0);
INSERT INTO `wiki_revision` VALUES (92, 92, 92, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363036, 0, 0);
INSERT INTO `wiki_revision` VALUES (93, 93, 93, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363036, 0, 0);
INSERT INTO `wiki_revision` VALUES (94, 94, 94, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363036, 0, 0);
INSERT INTO `wiki_revision` VALUES (95, 95, 95, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363036, 0, 0);
INSERT INTO `wiki_revision` VALUES (96, 96, 96, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363036, 0, 0);
INSERT INTO `wiki_revision` VALUES (97, 97, 97, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363036, 0, 0);
INSERT INTO `wiki_revision` VALUES (98, 98, 98, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363036, 0, 0);
INSERT INTO `wiki_revision` VALUES (99, 99, 99, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363036, 0, 0);
INSERT INTO `wiki_revision` VALUES (100, 100, 100, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363036, 0, 0);
INSERT INTO `wiki_revision` VALUES (101, 101, 101, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363036, 0, 0);
INSERT INTO `wiki_revision` VALUES (102, 102, 102, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363036, 0, 0);
INSERT INTO `wiki_revision` VALUES (103, 103, 103, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363036, 0, 0);
INSERT INTO `wiki_revision` VALUES (104, 104, 104, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363036, 0, 0);
INSERT INTO `wiki_revision` VALUES (105, 105, 105, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363036, 0, 0);
INSERT INTO `wiki_revision` VALUES (106, 106, 106, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363036, 0, 0);
INSERT INTO `wiki_revision` VALUES (107, 107, 107, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363036, 0, 0);
INSERT INTO `wiki_revision` VALUES (108, 108, 108, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363036, 0, 0);
INSERT INTO `wiki_revision` VALUES (109, 109, 109, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363036, 0, 0);
INSERT INTO `wiki_revision` VALUES (110, 110, 110, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363036, 0, 0);
INSERT INTO `wiki_revision` VALUES (111, 111, 111, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363036, 0, 0);
INSERT INTO `wiki_revision` VALUES (112, 112, 112, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363036, 0, 0);
INSERT INTO `wiki_revision` VALUES (113, 113, 113, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363036, 0, 0);
INSERT INTO `wiki_revision` VALUES (114, 114, 114, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363036, 0, 0);
INSERT INTO `wiki_revision` VALUES (115, 115, 115, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363036, 0, 0);
INSERT INTO `wiki_revision` VALUES (116, 116, 116, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363036, 0, 0);
INSERT INTO `wiki_revision` VALUES (117, 117, 117, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363036, 0, 0);
INSERT INTO `wiki_revision` VALUES (118, 118, 118, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363037, 0, 0);
INSERT INTO `wiki_revision` VALUES (119, 119, 119, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363037, 0, 0);
INSERT INTO `wiki_revision` VALUES (120, 120, 120, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363037, 0, 0);
INSERT INTO `wiki_revision` VALUES (121, 121, 121, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363037, 0, 0);
INSERT INTO `wiki_revision` VALUES (122, 122, 122, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363037, 0, 0);
INSERT INTO `wiki_revision` VALUES (123, 123, 123, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363037, 0, 0);
INSERT INTO `wiki_revision` VALUES (124, 124, 124, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363037, 0, 0);
INSERT INTO `wiki_revision` VALUES (125, 125, 125, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363037, 0, 0);
INSERT INTO `wiki_revision` VALUES (126, 126, 126, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363037, 0, 0);
INSERT INTO `wiki_revision` VALUES (127, 127, 127, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363037, 0, 0);
INSERT INTO `wiki_revision` VALUES (128, 128, 128, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363037, 0, 0);
INSERT INTO `wiki_revision` VALUES (129, 129, 129, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363037, 0, 0);
INSERT INTO `wiki_revision` VALUES (130, 130, 130, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363037, 0, 0);
INSERT INTO `wiki_revision` VALUES (131, 131, 131, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363037, 0, 0);
INSERT INTO `wiki_revision` VALUES (132, 132, 132, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363037, 0, 0);
INSERT INTO `wiki_revision` VALUES (133, 133, 133, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363037, 0, 0);
INSERT INTO `wiki_revision` VALUES (134, 134, 134, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363037, 0, 0);
INSERT INTO `wiki_revision` VALUES (135, 135, 135, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363037, 0, 0);
INSERT INTO `wiki_revision` VALUES (136, 136, 136, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363037, 0, 0);
INSERT INTO `wiki_revision` VALUES (137, 137, 137, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363037, 0, 0);
INSERT INTO `wiki_revision` VALUES (138, 138, 138, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363037, 0, 0);
INSERT INTO `wiki_revision` VALUES (139, 139, 139, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363037, 0, 0);
INSERT INTO `wiki_revision` VALUES (140, 140, 140, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363037, 0, 0);
INSERT INTO `wiki_revision` VALUES (141, 141, 141, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363037, 0, 0);
INSERT INTO `wiki_revision` VALUES (142, 142, 142, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363037, 0, 0);
INSERT INTO `wiki_revision` VALUES (143, 143, 143, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363037, 0, 0);
INSERT INTO `wiki_revision` VALUES (144, 144, 144, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363037, 0, 0);
INSERT INTO `wiki_revision` VALUES (145, 145, 145, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363037, 0, 0);
INSERT INTO `wiki_revision` VALUES (146, 146, 146, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363037, 0, 0);
INSERT INTO `wiki_revision` VALUES (147, 147, 147, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363037, 0, 0);
INSERT INTO `wiki_revision` VALUES (148, 148, 148, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363037, 0, 0);
INSERT INTO `wiki_revision` VALUES (149, 149, 149, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363037, 0, 0);
INSERT INTO `wiki_revision` VALUES (150, 150, 150, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363037, 0, 0);
INSERT INTO `wiki_revision` VALUES (151, 151, 151, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363037, 0, 0);
INSERT INTO `wiki_revision` VALUES (152, 152, 152, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363037, 0, 0);
INSERT INTO `wiki_revision` VALUES (153, 153, 153, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363037, 0, 0);
INSERT INTO `wiki_revision` VALUES (154, 154, 154, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363037, 0, 0);
INSERT INTO `wiki_revision` VALUES (155, 155, 155, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363037, 0, 0);
INSERT INTO `wiki_revision` VALUES (156, 156, 156, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363037, 0, 0);
INSERT INTO `wiki_revision` VALUES (157, 157, 157, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363037, 0, 0);
INSERT INTO `wiki_revision` VALUES (158, 158, 158, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363037, 0, 0);
INSERT INTO `wiki_revision` VALUES (159, 159, 159, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363037, 0, 0);
INSERT INTO `wiki_revision` VALUES (160, 160, 160, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363037, 0, 0);
INSERT INTO `wiki_revision` VALUES (161, 161, 161, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363037, 0, 0);
INSERT INTO `wiki_revision` VALUES (162, 162, 162, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363037, 0, 0);
INSERT INTO `wiki_revision` VALUES (163, 163, 163, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363037, 0, 0);
INSERT INTO `wiki_revision` VALUES (164, 164, 164, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363037, 0, 0);
INSERT INTO `wiki_revision` VALUES (165, 165, 165, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363037, 0, 0);
INSERT INTO `wiki_revision` VALUES (166, 166, 166, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363037, 0, 0);
INSERT INTO `wiki_revision` VALUES (167, 167, 167, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363037, 0, 0);
INSERT INTO `wiki_revision` VALUES (168, 168, 168, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363037, 0, 0);
INSERT INTO `wiki_revision` VALUES (169, 169, 169, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363037, 0, 0);
INSERT INTO `wiki_revision` VALUES (170, 170, 170, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363037, 0, 0);
INSERT INTO `wiki_revision` VALUES (171, 171, 171, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363037, 0, 0);
INSERT INTO `wiki_revision` VALUES (172, 172, 172, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363037, 0, 0);
INSERT INTO `wiki_revision` VALUES (173, 173, 173, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363037, 0, 0);
INSERT INTO `wiki_revision` VALUES (174, 174, 174, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363037, 0, 0);
INSERT INTO `wiki_revision` VALUES (175, 175, 175, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363037, 0, 0);
INSERT INTO `wiki_revision` VALUES (176, 176, 176, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363037, 0, 0);
INSERT INTO `wiki_revision` VALUES (177, 177, 177, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363037, 0, 0);
INSERT INTO `wiki_revision` VALUES (178, 178, 178, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363037, 0, 0);
INSERT INTO `wiki_revision` VALUES (179, 179, 179, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363037, 0, 0);
INSERT INTO `wiki_revision` VALUES (180, 180, 180, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363037, 0, 0);
INSERT INTO `wiki_revision` VALUES (181, 181, 181, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363037, 0, 0);
INSERT INTO `wiki_revision` VALUES (182, 182, 182, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363037, 0, 0);
INSERT INTO `wiki_revision` VALUES (183, 183, 183, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363037, 0, 0);
INSERT INTO `wiki_revision` VALUES (184, 184, 184, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363037, 0, 0);
INSERT INTO `wiki_revision` VALUES (185, 185, 185, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363037, 0, 0);
INSERT INTO `wiki_revision` VALUES (186, 186, 186, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363037, 0, 0);
INSERT INTO `wiki_revision` VALUES (187, 187, 187, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363037, 0, 0);
INSERT INTO `wiki_revision` VALUES (188, 188, 188, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363037, 0, 0);
INSERT INTO `wiki_revision` VALUES (189, 189, 189, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363037, 0, 0);
INSERT INTO `wiki_revision` VALUES (190, 190, 190, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363037, 0, 0);
INSERT INTO `wiki_revision` VALUES (191, 191, 191, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363037, 0, 0);
INSERT INTO `wiki_revision` VALUES (192, 192, 192, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363037, 0, 0);
INSERT INTO `wiki_revision` VALUES (193, 193, 193, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363037, 0, 0);
INSERT INTO `wiki_revision` VALUES (194, 194, 194, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363037, 0, 0);
INSERT INTO `wiki_revision` VALUES (195, 195, 195, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363038, 0, 0);
INSERT INTO `wiki_revision` VALUES (196, 196, 196, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363038, 0, 0);
INSERT INTO `wiki_revision` VALUES (197, 197, 197, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363038, 0, 0);
INSERT INTO `wiki_revision` VALUES (198, 198, 198, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363038, 0, 0);
INSERT INTO `wiki_revision` VALUES (199, 199, 199, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363038, 0, 0);
INSERT INTO `wiki_revision` VALUES (200, 200, 200, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363038, 0, 0);
INSERT INTO `wiki_revision` VALUES (201, 201, 201, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363038, 0, 0);
INSERT INTO `wiki_revision` VALUES (202, 202, 202, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363038, 0, 0);
INSERT INTO `wiki_revision` VALUES (203, 203, 203, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363038, 0, 0);
INSERT INTO `wiki_revision` VALUES (204, 204, 204, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363038, 0, 0);
INSERT INTO `wiki_revision` VALUES (205, 205, 205, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363038, 0, 0);
INSERT INTO `wiki_revision` VALUES (206, 206, 206, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363038, 0, 0);
INSERT INTO `wiki_revision` VALUES (207, 207, 207, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363038, 0, 0);
INSERT INTO `wiki_revision` VALUES (208, 208, 208, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363038, 0, 0);
INSERT INTO `wiki_revision` VALUES (209, 209, 209, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363038, 0, 0);
INSERT INTO `wiki_revision` VALUES (210, 210, 210, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363038, 0, 0);
INSERT INTO `wiki_revision` VALUES (211, 211, 211, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363038, 0, 0);
INSERT INTO `wiki_revision` VALUES (212, 212, 212, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363038, 0, 0);
INSERT INTO `wiki_revision` VALUES (213, 213, 213, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363038, 0, 0);
INSERT INTO `wiki_revision` VALUES (214, 214, 214, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363038, 0, 0);
INSERT INTO `wiki_revision` VALUES (215, 215, 215, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363038, 0, 0);
INSERT INTO `wiki_revision` VALUES (216, 216, 216, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363038, 0, 0);
INSERT INTO `wiki_revision` VALUES (217, 217, 217, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363038, 0, 0);
INSERT INTO `wiki_revision` VALUES (218, 218, 218, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363038, 0, 0);
INSERT INTO `wiki_revision` VALUES (219, 219, 219, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363038, 0, 0);
INSERT INTO `wiki_revision` VALUES (220, 220, 220, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363038, 0, 0);
INSERT INTO `wiki_revision` VALUES (221, 221, 221, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363038, 0, 0);
INSERT INTO `wiki_revision` VALUES (222, 222, 222, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363038, 0, 0);
INSERT INTO `wiki_revision` VALUES (223, 223, 223, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363038, 0, 0);
INSERT INTO `wiki_revision` VALUES (224, 224, 224, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363038, 0, 0);
INSERT INTO `wiki_revision` VALUES (225, 225, 225, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363038, 0, 0);
INSERT INTO `wiki_revision` VALUES (226, 226, 226, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363038, 0, 0);
INSERT INTO `wiki_revision` VALUES (227, 227, 227, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363038, 0, 0);
INSERT INTO `wiki_revision` VALUES (228, 228, 228, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363038, 0, 0);
INSERT INTO `wiki_revision` VALUES (229, 229, 229, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363038, 0, 0);
INSERT INTO `wiki_revision` VALUES (230, 230, 230, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363038, 0, 0);
INSERT INTO `wiki_revision` VALUES (231, 231, 231, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363038, 0, 0);
INSERT INTO `wiki_revision` VALUES (232, 232, 232, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363038, 0, 0);
INSERT INTO `wiki_revision` VALUES (233, 233, 233, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363038, 0, 0);
INSERT INTO `wiki_revision` VALUES (234, 234, 234, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363038, 0, 0);
INSERT INTO `wiki_revision` VALUES (235, 235, 235, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363038, 0, 0);
INSERT INTO `wiki_revision` VALUES (236, 236, 236, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363038, 0, 0);
INSERT INTO `wiki_revision` VALUES (237, 237, 237, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363038, 0, 0);
INSERT INTO `wiki_revision` VALUES (238, 238, 238, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363038, 0, 0);
INSERT INTO `wiki_revision` VALUES (239, 239, 239, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363038, 0, 0);
INSERT INTO `wiki_revision` VALUES (240, 240, 240, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363038, 0, 0);
INSERT INTO `wiki_revision` VALUES (241, 241, 241, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363038, 0, 0);
INSERT INTO `wiki_revision` VALUES (242, 242, 242, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363038, 0, 0);
INSERT INTO `wiki_revision` VALUES (243, 243, 243, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363038, 0, 0);
INSERT INTO `wiki_revision` VALUES (244, 244, 244, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363038, 0, 0);
INSERT INTO `wiki_revision` VALUES (245, 245, 245, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363038, 0, 0);
INSERT INTO `wiki_revision` VALUES (246, 246, 246, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363038, 0, 0);
INSERT INTO `wiki_revision` VALUES (247, 247, 247, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363038, 0, 0);
INSERT INTO `wiki_revision` VALUES (248, 248, 248, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363038, 0, 0);
INSERT INTO `wiki_revision` VALUES (249, 249, 249, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363038, 0, 0);
INSERT INTO `wiki_revision` VALUES (250, 250, 250, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363038, 0, 0);
INSERT INTO `wiki_revision` VALUES (251, 251, 251, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363038, 0, 0);
INSERT INTO `wiki_revision` VALUES (252, 252, 252, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363038, 0, 0);
INSERT INTO `wiki_revision` VALUES (253, 253, 253, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363038, 0, 0);
INSERT INTO `wiki_revision` VALUES (254, 254, 254, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363038, 0, 0);
INSERT INTO `wiki_revision` VALUES (255, 255, 255, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363038, 0, 0);
INSERT INTO `wiki_revision` VALUES (256, 256, 256, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363038, 0, 0);
INSERT INTO `wiki_revision` VALUES (257, 257, 257, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363038, 0, 0);
INSERT INTO `wiki_revision` VALUES (258, 258, 258, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363038, 0, 0);
INSERT INTO `wiki_revision` VALUES (259, 259, 259, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363038, 0, 0);
INSERT INTO `wiki_revision` VALUES (260, 260, 260, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363038, 0, 0);
INSERT INTO `wiki_revision` VALUES (261, 261, 261, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363038, 0, 0);
INSERT INTO `wiki_revision` VALUES (262, 262, 262, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363038, 0, 0);
INSERT INTO `wiki_revision` VALUES (263, 263, 263, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363038, 0, 0);
INSERT INTO `wiki_revision` VALUES (264, 264, 264, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363038, 0, 0);
INSERT INTO `wiki_revision` VALUES (265, 265, 265, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363038, 0, 0);
INSERT INTO `wiki_revision` VALUES (266, 266, 266, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363038, 0, 0);
INSERT INTO `wiki_revision` VALUES (267, 267, 267, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363038, 0, 0);
INSERT INTO `wiki_revision` VALUES (268, 268, 268, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363038, 0, 0);
INSERT INTO `wiki_revision` VALUES (269, 269, 269, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363038, 0, 0);
INSERT INTO `wiki_revision` VALUES (270, 270, 270, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363038, 0, 0);
INSERT INTO `wiki_revision` VALUES (271, 271, 271, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363038, 0, 0);
INSERT INTO `wiki_revision` VALUES (272, 272, 272, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363038, 0, 0);
INSERT INTO `wiki_revision` VALUES (273, 273, 273, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363038, 0, 0);
INSERT INTO `wiki_revision` VALUES (274, 274, 274, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363039, 0, 0);
INSERT INTO `wiki_revision` VALUES (275, 275, 275, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363039, 0, 0);
INSERT INTO `wiki_revision` VALUES (276, 276, 276, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363039, 0, 0);
INSERT INTO `wiki_revision` VALUES (277, 277, 277, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363039, 0, 0);
INSERT INTO `wiki_revision` VALUES (278, 278, 278, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363039, 0, 0);
INSERT INTO `wiki_revision` VALUES (279, 279, 279, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363039, 0, 0);
INSERT INTO `wiki_revision` VALUES (280, 280, 280, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363039, 0, 0);
INSERT INTO `wiki_revision` VALUES (281, 281, 281, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363039, 0, 0);
INSERT INTO `wiki_revision` VALUES (282, 282, 282, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363039, 0, 0);
INSERT INTO `wiki_revision` VALUES (283, 283, 283, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363039, 0, 0);
INSERT INTO `wiki_revision` VALUES (284, 284, 284, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363039, 0, 0);
INSERT INTO `wiki_revision` VALUES (285, 285, 285, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363039, 0, 0);
INSERT INTO `wiki_revision` VALUES (286, 286, 286, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363039, 0, 0);
INSERT INTO `wiki_revision` VALUES (287, 287, 287, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363039, 0, 0);
INSERT INTO `wiki_revision` VALUES (288, 288, 288, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363039, 0, 0);
INSERT INTO `wiki_revision` VALUES (289, 289, 289, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363039, 0, 0);
INSERT INTO `wiki_revision` VALUES (290, 290, 290, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363039, 0, 0);
INSERT INTO `wiki_revision` VALUES (291, 291, 291, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363039, 0, 0);
INSERT INTO `wiki_revision` VALUES (292, 292, 292, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363039, 0, 0);
INSERT INTO `wiki_revision` VALUES (293, 293, 293, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363039, 0, 0);
INSERT INTO `wiki_revision` VALUES (294, 294, 294, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363039, 0, 0);
INSERT INTO `wiki_revision` VALUES (295, 295, 295, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363039, 0, 0);
INSERT INTO `wiki_revision` VALUES (296, 296, 296, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363039, 0, 0);
INSERT INTO `wiki_revision` VALUES (297, 297, 297, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363039, 0, 0);
INSERT INTO `wiki_revision` VALUES (298, 298, 298, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363039, 0, 0);
INSERT INTO `wiki_revision` VALUES (299, 299, 299, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363039, 0, 0);
INSERT INTO `wiki_revision` VALUES (300, 300, 300, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363039, 0, 0);
INSERT INTO `wiki_revision` VALUES (301, 301, 301, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363039, 0, 0);
INSERT INTO `wiki_revision` VALUES (302, 302, 302, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363039, 0, 0);
INSERT INTO `wiki_revision` VALUES (303, 303, 303, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363039, 0, 0);
INSERT INTO `wiki_revision` VALUES (304, 304, 304, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363039, 0, 0);
INSERT INTO `wiki_revision` VALUES (305, 305, 305, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363039, 0, 0);
INSERT INTO `wiki_revision` VALUES (306, 306, 306, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363039, 0, 0);
INSERT INTO `wiki_revision` VALUES (307, 307, 307, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363039, 0, 0);
INSERT INTO `wiki_revision` VALUES (308, 308, 308, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363039, 0, 0);
INSERT INTO `wiki_revision` VALUES (309, 309, 309, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363039, 0, 0);
INSERT INTO `wiki_revision` VALUES (310, 310, 310, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363039, 0, 0);
INSERT INTO `wiki_revision` VALUES (311, 311, 311, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363039, 0, 0);
INSERT INTO `wiki_revision` VALUES (312, 312, 312, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363039, 0, 0);
INSERT INTO `wiki_revision` VALUES (313, 313, 313, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363039, 0, 0);
INSERT INTO `wiki_revision` VALUES (314, 314, 314, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363039, 0, 0);
INSERT INTO `wiki_revision` VALUES (315, 315, 315, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363039, 0, 0);
INSERT INTO `wiki_revision` VALUES (316, 316, 316, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363039, 0, 0);
INSERT INTO `wiki_revision` VALUES (317, 317, 317, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363039, 0, 0);
INSERT INTO `wiki_revision` VALUES (318, 318, 318, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363039, 0, 0);
INSERT INTO `wiki_revision` VALUES (319, 319, 319, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363039, 0, 0);
INSERT INTO `wiki_revision` VALUES (320, 320, 320, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363039, 0, 0);
INSERT INTO `wiki_revision` VALUES (321, 321, 321, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363039, 0, 0);
INSERT INTO `wiki_revision` VALUES (322, 322, 322, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363039, 0, 0);
INSERT INTO `wiki_revision` VALUES (323, 323, 323, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363039, 0, 0);
INSERT INTO `wiki_revision` VALUES (324, 324, 324, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363039, 0, 0);
INSERT INTO `wiki_revision` VALUES (325, 325, 325, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363039, 0, 0);
INSERT INTO `wiki_revision` VALUES (326, 326, 326, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363039, 0, 0);
INSERT INTO `wiki_revision` VALUES (327, 327, 327, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363039, 0, 0);
INSERT INTO `wiki_revision` VALUES (328, 328, 328, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363039, 0, 0);
INSERT INTO `wiki_revision` VALUES (329, 329, 329, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363039, 0, 0);
INSERT INTO `wiki_revision` VALUES (330, 330, 330, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363039, 0, 0);
INSERT INTO `wiki_revision` VALUES (331, 331, 331, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363039, 0, 0);
INSERT INTO `wiki_revision` VALUES (332, 332, 332, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363039, 0, 0);
INSERT INTO `wiki_revision` VALUES (333, 333, 333, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363039, 0, 0);
INSERT INTO `wiki_revision` VALUES (334, 334, 334, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363039, 0, 0);
INSERT INTO `wiki_revision` VALUES (335, 335, 335, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363039, 0, 0);
INSERT INTO `wiki_revision` VALUES (336, 336, 336, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363039, 0, 0);
INSERT INTO `wiki_revision` VALUES (337, 337, 337, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363039, 0, 0);
INSERT INTO `wiki_revision` VALUES (338, 338, 338, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363039, 0, 0);
INSERT INTO `wiki_revision` VALUES (339, 339, 339, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363039, 0, 0);
INSERT INTO `wiki_revision` VALUES (340, 340, 340, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363039, 0, 0);
INSERT INTO `wiki_revision` VALUES (341, 341, 341, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363039, 0, 0);
INSERT INTO `wiki_revision` VALUES (342, 342, 342, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363039, 0, 0);
INSERT INTO `wiki_revision` VALUES (343, 343, 343, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363039, 0, 0);
INSERT INTO `wiki_revision` VALUES (344, 344, 344, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363039, 0, 0);
INSERT INTO `wiki_revision` VALUES (345, 345, 345, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363039, 0, 0);
INSERT INTO `wiki_revision` VALUES (346, 346, 346, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363039, 0, 0);
INSERT INTO `wiki_revision` VALUES (347, 347, 347, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363039, 0, 0);
INSERT INTO `wiki_revision` VALUES (348, 348, 348, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363039, 0, 0);
INSERT INTO `wiki_revision` VALUES (349, 349, 349, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363039, 0, 0);
INSERT INTO `wiki_revision` VALUES (350, 350, 350, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363130, 0, 0);
INSERT INTO `wiki_revision` VALUES (351, 351, 351, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363130, 0, 0);
INSERT INTO `wiki_revision` VALUES (352, 352, 352, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363130, 0, 0);
INSERT INTO `wiki_revision` VALUES (353, 353, 353, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363130, 0, 0);
INSERT INTO `wiki_revision` VALUES (354, 354, 354, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363130, 0, 0);
INSERT INTO `wiki_revision` VALUES (355, 355, 355, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363130, 0, 0);
INSERT INTO `wiki_revision` VALUES (356, 356, 356, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363130, 0, 0);
INSERT INTO `wiki_revision` VALUES (357, 357, 357, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363130, 0, 0);
INSERT INTO `wiki_revision` VALUES (358, 358, 358, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363130, 0, 0);
INSERT INTO `wiki_revision` VALUES (359, 359, 359, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363130, 0, 0);
INSERT INTO `wiki_revision` VALUES (360, 360, 360, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363130, 0, 0);
INSERT INTO `wiki_revision` VALUES (361, 361, 361, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363130, 0, 0);
INSERT INTO `wiki_revision` VALUES (362, 362, 362, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363130, 0, 0);
INSERT INTO `wiki_revision` VALUES (363, 363, 363, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363130, 0, 0);
INSERT INTO `wiki_revision` VALUES (364, 364, 364, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363130, 0, 0);
INSERT INTO `wiki_revision` VALUES (365, 365, 365, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363130, 0, 0);
INSERT INTO `wiki_revision` VALUES (366, 366, 366, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363130, 0, 0);
INSERT INTO `wiki_revision` VALUES (367, 367, 367, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363130, 0, 0);
INSERT INTO `wiki_revision` VALUES (368, 368, 368, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363130, 0, 0);
INSERT INTO `wiki_revision` VALUES (369, 369, 369, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363130, 0, 0);
INSERT INTO `wiki_revision` VALUES (370, 370, 370, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363130, 0, 0);
INSERT INTO `wiki_revision` VALUES (371, 371, 371, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363130, 0, 0);
INSERT INTO `wiki_revision` VALUES (372, 372, 372, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363130, 0, 0);
INSERT INTO `wiki_revision` VALUES (373, 373, 373, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363130, 0, 0);
INSERT INTO `wiki_revision` VALUES (374, 374, 374, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363130, 0, 0);
INSERT INTO `wiki_revision` VALUES (375, 375, 375, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363130, 0, 0);
INSERT INTO `wiki_revision` VALUES (376, 376, 376, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363130, 0, 0);
INSERT INTO `wiki_revision` VALUES (377, 377, 377, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363130, 0, 0);
INSERT INTO `wiki_revision` VALUES (378, 378, 378, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363130, 0, 0);
INSERT INTO `wiki_revision` VALUES (379, 379, 379, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363130, 0, 0);
INSERT INTO `wiki_revision` VALUES (380, 380, 380, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363130, 0, 0);
INSERT INTO `wiki_revision` VALUES (381, 381, 381, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363130, 0, 0);
INSERT INTO `wiki_revision` VALUES (382, 382, 382, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363130, 0, 0);
INSERT INTO `wiki_revision` VALUES (383, 383, 383, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363130, 0, 0);
INSERT INTO `wiki_revision` VALUES (384, 384, 384, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363130, 0, 0);
INSERT INTO `wiki_revision` VALUES (385, 385, 385, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363130, 0, 0);
INSERT INTO `wiki_revision` VALUES (386, 386, 386, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363130, 0, 0);
INSERT INTO `wiki_revision` VALUES (387, 387, 387, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363130, 0, 0);
INSERT INTO `wiki_revision` VALUES (388, 388, 388, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363130, 0, 0);
INSERT INTO `wiki_revision` VALUES (389, 389, 389, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363130, 0, 0);
INSERT INTO `wiki_revision` VALUES (390, 390, 390, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363130, 0, 0);
INSERT INTO `wiki_revision` VALUES (391, 391, 391, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363130, 0, 0);
INSERT INTO `wiki_revision` VALUES (392, 392, 392, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363130, 0, 0);
INSERT INTO `wiki_revision` VALUES (393, 393, 393, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363130, 0, 0);
INSERT INTO `wiki_revision` VALUES (394, 394, 394, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363130, 0, 0);
INSERT INTO `wiki_revision` VALUES (395, 395, 395, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363130, 0, 0);
INSERT INTO `wiki_revision` VALUES (396, 396, 396, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363130, 0, 0);
INSERT INTO `wiki_revision` VALUES (397, 397, 397, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363130, 0, 0);
INSERT INTO `wiki_revision` VALUES (398, 398, 398, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363130, 0, 0);
INSERT INTO `wiki_revision` VALUES (399, 399, 399, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363130, 0, 0);
INSERT INTO `wiki_revision` VALUES (400, 400, 400, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363130, 0, 0);
INSERT INTO `wiki_revision` VALUES (401, 401, 401, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363130, 0, 0);
INSERT INTO `wiki_revision` VALUES (402, 402, 402, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363130, 0, 0);
INSERT INTO `wiki_revision` VALUES (403, 403, 403, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363130, 0, 0);
INSERT INTO `wiki_revision` VALUES (404, 404, 404, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363130, 0, 0);
INSERT INTO `wiki_revision` VALUES (405, 405, 405, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363130, 0, 0);
INSERT INTO `wiki_revision` VALUES (406, 406, 406, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363130, 0, 0);
INSERT INTO `wiki_revision` VALUES (407, 407, 407, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363130, 0, 0);
INSERT INTO `wiki_revision` VALUES (408, 408, 408, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363130, 0, 0);
INSERT INTO `wiki_revision` VALUES (409, 409, 409, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363130, 0, 0);
INSERT INTO `wiki_revision` VALUES (410, 410, 410, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363130, 0, 0);
INSERT INTO `wiki_revision` VALUES (411, 411, 411, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363130, 0, 0);
INSERT INTO `wiki_revision` VALUES (412, 412, 412, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363130, 0, 0);
INSERT INTO `wiki_revision` VALUES (413, 413, 413, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363130, 0, 0);
INSERT INTO `wiki_revision` VALUES (414, 414, 414, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363130, 0, 0);
INSERT INTO `wiki_revision` VALUES (415, 415, 415, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363130, 0, 0);
INSERT INTO `wiki_revision` VALUES (416, 416, 416, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363130, 0, 0);
INSERT INTO `wiki_revision` VALUES (417, 417, 417, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363130, 0, 0);
INSERT INTO `wiki_revision` VALUES (418, 418, 418, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363130, 0, 0);
INSERT INTO `wiki_revision` VALUES (419, 419, 419, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363130, 0, 0);
INSERT INTO `wiki_revision` VALUES (420, 420, 420, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363130, 0, 0);
INSERT INTO `wiki_revision` VALUES (421, 421, 421, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363130, 0, 0);
INSERT INTO `wiki_revision` VALUES (422, 422, 422, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363130, 0, 0);
INSERT INTO `wiki_revision` VALUES (423, 423, 423, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363130, 0, 0);
INSERT INTO `wiki_revision` VALUES (424, 424, 424, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363130, 0, 0);
INSERT INTO `wiki_revision` VALUES (425, 425, 425, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363130, 0, 0);
INSERT INTO `wiki_revision` VALUES (426, 426, 426, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363131, 0, 0);
INSERT INTO `wiki_revision` VALUES (427, 427, 427, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363131, 0, 0);
INSERT INTO `wiki_revision` VALUES (428, 428, 428, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363131, 0, 0);
INSERT INTO `wiki_revision` VALUES (429, 429, 429, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363131, 0, 0);
INSERT INTO `wiki_revision` VALUES (430, 430, 430, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363131, 0, 0);
INSERT INTO `wiki_revision` VALUES (431, 431, 431, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363131, 0, 0);
INSERT INTO `wiki_revision` VALUES (432, 432, 432, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363131, 0, 0);
INSERT INTO `wiki_revision` VALUES (433, 433, 433, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363131, 0, 0);
INSERT INTO `wiki_revision` VALUES (434, 434, 434, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363131, 0, 0);
INSERT INTO `wiki_revision` VALUES (435, 435, 435, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363131, 0, 0);
INSERT INTO `wiki_revision` VALUES (436, 436, 436, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363131, 0, 0);
INSERT INTO `wiki_revision` VALUES (437, 437, 437, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363131, 0, 0);
INSERT INTO `wiki_revision` VALUES (438, 438, 438, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363131, 0, 0);
INSERT INTO `wiki_revision` VALUES (439, 439, 439, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363131, 0, 0);
INSERT INTO `wiki_revision` VALUES (440, 440, 440, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363131, 0, 0);
INSERT INTO `wiki_revision` VALUES (441, 441, 441, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363131, 0, 0);
INSERT INTO `wiki_revision` VALUES (442, 442, 442, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363131, 0, 0);
INSERT INTO `wiki_revision` VALUES (443, 443, 443, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363131, 0, 0);
INSERT INTO `wiki_revision` VALUES (444, 444, 444, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363131, 0, 0);
INSERT INTO `wiki_revision` VALUES (445, 445, 445, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363131, 0, 0);
INSERT INTO `wiki_revision` VALUES (446, 446, 446, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363131, 0, 0);
INSERT INTO `wiki_revision` VALUES (447, 447, 447, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363131, 0, 0);
INSERT INTO `wiki_revision` VALUES (448, 448, 448, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363131, 0, 0);
INSERT INTO `wiki_revision` VALUES (449, 449, 449, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363131, 0, 0);
INSERT INTO `wiki_revision` VALUES (450, 450, 450, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363131, 0, 0);
INSERT INTO `wiki_revision` VALUES (451, 451, 451, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363131, 0, 0);
INSERT INTO `wiki_revision` VALUES (452, 452, 452, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363131, 0, 0);
INSERT INTO `wiki_revision` VALUES (453, 453, 453, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363131, 0, 0);
INSERT INTO `wiki_revision` VALUES (454, 454, 454, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363131, 0, 0);
INSERT INTO `wiki_revision` VALUES (455, 455, 455, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363131, 0, 0);
INSERT INTO `wiki_revision` VALUES (456, 456, 456, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363131, 0, 0);
INSERT INTO `wiki_revision` VALUES (457, 457, 457, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363131, 0, 0);
INSERT INTO `wiki_revision` VALUES (458, 458, 458, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363131, 0, 0);
INSERT INTO `wiki_revision` VALUES (459, 459, 459, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363131, 0, 0);
INSERT INTO `wiki_revision` VALUES (460, 460, 460, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363131, 0, 0);
INSERT INTO `wiki_revision` VALUES (461, 461, 461, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363131, 0, 0);
INSERT INTO `wiki_revision` VALUES (462, 462, 462, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363131, 0, 0);
INSERT INTO `wiki_revision` VALUES (463, 463, 463, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363131, 0, 0);
INSERT INTO `wiki_revision` VALUES (464, 464, 464, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363131, 0, 0);
INSERT INTO `wiki_revision` VALUES (465, 465, 465, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363131, 0, 0);
INSERT INTO `wiki_revision` VALUES (466, 466, 466, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363131, 0, 0);
INSERT INTO `wiki_revision` VALUES (467, 467, 467, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363131, 0, 0);
INSERT INTO `wiki_revision` VALUES (468, 468, 468, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363131, 0, 0);
INSERT INTO `wiki_revision` VALUES (469, 469, 469, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363131, 0, 0);
INSERT INTO `wiki_revision` VALUES (470, 470, 470, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363131, 0, 0);
INSERT INTO `wiki_revision` VALUES (471, 471, 471, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363131, 0, 0);
INSERT INTO `wiki_revision` VALUES (472, 472, 472, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363131, 0, 0);
INSERT INTO `wiki_revision` VALUES (473, 473, 473, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363131, 0, 0);
INSERT INTO `wiki_revision` VALUES (474, 474, 474, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363131, 0, 0);
INSERT INTO `wiki_revision` VALUES (475, 475, 475, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363131, 0, 0);
INSERT INTO `wiki_revision` VALUES (476, 476, 476, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363131, 0, 0);
INSERT INTO `wiki_revision` VALUES (477, 477, 477, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363131, 0, 0);
INSERT INTO `wiki_revision` VALUES (478, 478, 478, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363131, 0, 0);
INSERT INTO `wiki_revision` VALUES (479, 479, 479, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363131, 0, 0);
INSERT INTO `wiki_revision` VALUES (480, 480, 480, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363131, 0, 0);
INSERT INTO `wiki_revision` VALUES (481, 481, 481, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363131, 0, 0);
INSERT INTO `wiki_revision` VALUES (482, 482, 482, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363131, 0, 0);
INSERT INTO `wiki_revision` VALUES (483, 483, 483, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363131, 0, 0);
INSERT INTO `wiki_revision` VALUES (484, 484, 484, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363131, 0, 0);
INSERT INTO `wiki_revision` VALUES (485, 485, 485, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363131, 0, 0);
INSERT INTO `wiki_revision` VALUES (486, 486, 486, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363131, 0, 0);
INSERT INTO `wiki_revision` VALUES (487, 487, 487, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363131, 0, 0);
INSERT INTO `wiki_revision` VALUES (488, 488, 488, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363131, 0, 0);
INSERT INTO `wiki_revision` VALUES (489, 489, 489, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363131, 0, 0);
INSERT INTO `wiki_revision` VALUES (490, 490, 490, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363131, 0, 0);
INSERT INTO `wiki_revision` VALUES (491, 491, 491, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363131, 0, 0);
INSERT INTO `wiki_revision` VALUES (492, 492, 492, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363131, 0, 0);
INSERT INTO `wiki_revision` VALUES (493, 493, 493, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363131, 0, 0);
INSERT INTO `wiki_revision` VALUES (494, 494, 494, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363131, 0, 0);
INSERT INTO `wiki_revision` VALUES (495, 495, 495, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363131, 0, 0);
INSERT INTO `wiki_revision` VALUES (496, 496, 496, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363131, 0, 0);
INSERT INTO `wiki_revision` VALUES (497, 497, 497, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363131, 0, 0);
INSERT INTO `wiki_revision` VALUES (498, 498, 498, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363131, 0, 0);
INSERT INTO `wiki_revision` VALUES (499, 499, 499, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363131, 0, 0);
INSERT INTO `wiki_revision` VALUES (500, 500, 500, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363131, 0, 0);
INSERT INTO `wiki_revision` VALUES (501, 501, 501, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363131, 0, 0);
INSERT INTO `wiki_revision` VALUES (502, 502, 502, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363131, 0, 0);
INSERT INTO `wiki_revision` VALUES (503, 503, 503, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363132, 0, 0);
INSERT INTO `wiki_revision` VALUES (504, 504, 504, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363132, 0, 0);
INSERT INTO `wiki_revision` VALUES (505, 505, 505, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363132, 0, 0);
INSERT INTO `wiki_revision` VALUES (506, 506, 506, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363132, 0, 0);
INSERT INTO `wiki_revision` VALUES (507, 507, 507, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363132, 0, 0);
INSERT INTO `wiki_revision` VALUES (508, 508, 508, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363132, 0, 0);
INSERT INTO `wiki_revision` VALUES (509, 509, 509, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363132, 0, 0);
INSERT INTO `wiki_revision` VALUES (510, 510, 510, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363132, 0, 0);
INSERT INTO `wiki_revision` VALUES (511, 511, 511, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363132, 0, 0);
INSERT INTO `wiki_revision` VALUES (512, 512, 512, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363132, 0, 0);
INSERT INTO `wiki_revision` VALUES (513, 513, 513, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363132, 0, 0);
INSERT INTO `wiki_revision` VALUES (514, 514, 514, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363132, 0, 0);
INSERT INTO `wiki_revision` VALUES (515, 515, 515, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363132, 0, 0);
INSERT INTO `wiki_revision` VALUES (516, 516, 516, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363132, 0, 0);
INSERT INTO `wiki_revision` VALUES (517, 517, 517, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363132, 0, 0);
INSERT INTO `wiki_revision` VALUES (518, 518, 518, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363132, 0, 0);
INSERT INTO `wiki_revision` VALUES (519, 519, 519, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363132, 0, 0);
INSERT INTO `wiki_revision` VALUES (520, 520, 520, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363132, 0, 0);
INSERT INTO `wiki_revision` VALUES (521, 521, 521, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363132, 0, 0);
INSERT INTO `wiki_revision` VALUES (522, 522, 522, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363132, 0, 0);
INSERT INTO `wiki_revision` VALUES (523, 523, 523, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363132, 0, 0);
INSERT INTO `wiki_revision` VALUES (524, 524, 524, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363132, 0, 0);
INSERT INTO `wiki_revision` VALUES (525, 525, 525, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363132, 0, 0);
INSERT INTO `wiki_revision` VALUES (526, 526, 526, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363132, 0, 0);
INSERT INTO `wiki_revision` VALUES (527, 527, 527, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363132, 0, 0);
INSERT INTO `wiki_revision` VALUES (528, 528, 528, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363132, 0, 0);
INSERT INTO `wiki_revision` VALUES (529, 529, 529, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363132, 0, 0);
INSERT INTO `wiki_revision` VALUES (530, 530, 530, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363132, 0, 0);
INSERT INTO `wiki_revision` VALUES (531, 531, 531, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363132, 0, 0);
INSERT INTO `wiki_revision` VALUES (532, 532, 532, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363132, 0, 0);
INSERT INTO `wiki_revision` VALUES (533, 533, 533, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363132, 0, 0);
INSERT INTO `wiki_revision` VALUES (534, 534, 534, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363132, 0, 0);
INSERT INTO `wiki_revision` VALUES (535, 535, 535, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363132, 0, 0);
INSERT INTO `wiki_revision` VALUES (536, 536, 536, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363132, 0, 0);
INSERT INTO `wiki_revision` VALUES (537, 537, 537, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363132, 0, 0);
INSERT INTO `wiki_revision` VALUES (538, 538, 538, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363132, 0, 0);
INSERT INTO `wiki_revision` VALUES (539, 539, 539, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363132, 0, 0);
INSERT INTO `wiki_revision` VALUES (540, 540, 540, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363132, 0, 0);
INSERT INTO `wiki_revision` VALUES (541, 541, 541, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363132, 0, 0);
INSERT INTO `wiki_revision` VALUES (542, 542, 542, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363132, 0, 0);
INSERT INTO `wiki_revision` VALUES (543, 543, 543, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363132, 0, 0);
INSERT INTO `wiki_revision` VALUES (544, 544, 544, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363132, 0, 0);
INSERT INTO `wiki_revision` VALUES (545, 545, 545, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363132, 0, 0);
INSERT INTO `wiki_revision` VALUES (546, 546, 546, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363132, 0, 0);
INSERT INTO `wiki_revision` VALUES (547, 547, 547, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363132, 0, 0);
INSERT INTO `wiki_revision` VALUES (548, 548, 548, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363132, 0, 0);
INSERT INTO `wiki_revision` VALUES (549, 549, 549, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363132, 0, 0);
INSERT INTO `wiki_revision` VALUES (550, 550, 550, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363132, 0, 0);
INSERT INTO `wiki_revision` VALUES (551, 551, 551, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363132, 0, 0);
INSERT INTO `wiki_revision` VALUES (552, 552, 552, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363132, 0, 0);
INSERT INTO `wiki_revision` VALUES (553, 553, 553, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363132, 0, 0);
INSERT INTO `wiki_revision` VALUES (554, 554, 554, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363132, 0, 0);
INSERT INTO `wiki_revision` VALUES (555, 555, 555, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363132, 0, 0);
INSERT INTO `wiki_revision` VALUES (556, 556, 556, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363132, 0, 0);
INSERT INTO `wiki_revision` VALUES (557, 557, 557, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363132, 0, 0);
INSERT INTO `wiki_revision` VALUES (558, 558, 558, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363132, 0, 0);
INSERT INTO `wiki_revision` VALUES (559, 559, 559, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363132, 0, 0);
INSERT INTO `wiki_revision` VALUES (560, 560, 560, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363132, 0, 0);
INSERT INTO `wiki_revision` VALUES (561, 561, 561, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363132, 0, 0);
INSERT INTO `wiki_revision` VALUES (562, 562, 562, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363132, 0, 0);
INSERT INTO `wiki_revision` VALUES (563, 563, 563, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363132, 0, 0);
INSERT INTO `wiki_revision` VALUES (564, 564, 564, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363132, 0, 0);
INSERT INTO `wiki_revision` VALUES (565, 565, 565, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363132, 0, 0);
INSERT INTO `wiki_revision` VALUES (566, 566, 566, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363132, 0, 0);
INSERT INTO `wiki_revision` VALUES (567, 567, 567, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363132, 0, 0);
INSERT INTO `wiki_revision` VALUES (568, 568, 568, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363132, 0, 0);
INSERT INTO `wiki_revision` VALUES (569, 569, 569, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363132, 0, 0);
INSERT INTO `wiki_revision` VALUES (570, 570, 570, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363132, 0, 0);
INSERT INTO `wiki_revision` VALUES (571, 571, 571, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363132, 0, 0);
INSERT INTO `wiki_revision` VALUES (572, 572, 572, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363132, 0, 0);
INSERT INTO `wiki_revision` VALUES (573, 573, 573, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363132, 0, 0);
INSERT INTO `wiki_revision` VALUES (574, 574, 574, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363132, 0, 0);
INSERT INTO `wiki_revision` VALUES (575, 575, 575, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363132, 0, 0);
INSERT INTO `wiki_revision` VALUES (576, 576, 576, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363132, 0, 0);
INSERT INTO `wiki_revision` VALUES (577, 577, 577, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363132, 0, 0);
INSERT INTO `wiki_revision` VALUES (578, 578, 578, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363132, 0, 0);
INSERT INTO `wiki_revision` VALUES (579, 579, 579, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363132, 0, 0);
INSERT INTO `wiki_revision` VALUES (580, 580, 580, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363132, 0, 0);
INSERT INTO `wiki_revision` VALUES (581, 581, 581, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363132, 0, 0);
INSERT INTO `wiki_revision` VALUES (582, 582, 582, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363133, 0, 0);
INSERT INTO `wiki_revision` VALUES (583, 583, 583, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363133, 0, 0);
INSERT INTO `wiki_revision` VALUES (584, 584, 584, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363133, 0, 0);
INSERT INTO `wiki_revision` VALUES (585, 585, 585, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363133, 0, 0);
INSERT INTO `wiki_revision` VALUES (586, 586, 586, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363133, 0, 0);
INSERT INTO `wiki_revision` VALUES (587, 587, 587, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363133, 0, 0);
INSERT INTO `wiki_revision` VALUES (588, 588, 588, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363133, 0, 0);
INSERT INTO `wiki_revision` VALUES (589, 589, 589, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363133, 0, 0);
INSERT INTO `wiki_revision` VALUES (590, 590, 590, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363133, 0, 0);
INSERT INTO `wiki_revision` VALUES (591, 591, 591, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363133, 0, 0);
INSERT INTO `wiki_revision` VALUES (592, 592, 592, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363133, 0, 0);
INSERT INTO `wiki_revision` VALUES (593, 593, 593, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363133, 0, 0);
INSERT INTO `wiki_revision` VALUES (594, 594, 594, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363133, 0, 0);
INSERT INTO `wiki_revision` VALUES (595, 595, 595, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363133, 0, 0);
INSERT INTO `wiki_revision` VALUES (596, 596, 596, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363133, 0, 0);
INSERT INTO `wiki_revision` VALUES (597, 597, 597, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363133, 0, 0);
INSERT INTO `wiki_revision` VALUES (598, 598, 598, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363133, 0, 0);
INSERT INTO `wiki_revision` VALUES (599, 599, 599, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363133, 0, 0);
INSERT INTO `wiki_revision` VALUES (600, 600, 600, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363133, 0, 0);
INSERT INTO `wiki_revision` VALUES (601, 601, 601, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363133, 0, 0);
INSERT INTO `wiki_revision` VALUES (602, 602, 602, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363133, 0, 0);
INSERT INTO `wiki_revision` VALUES (603, 603, 603, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363133, 0, 0);
INSERT INTO `wiki_revision` VALUES (604, 604, 604, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363133, 0, 0);
INSERT INTO `wiki_revision` VALUES (605, 605, 605, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363133, 0, 0);
INSERT INTO `wiki_revision` VALUES (606, 606, 606, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363133, 0, 0);
INSERT INTO `wiki_revision` VALUES (607, 607, 607, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363133, 0, 0);
INSERT INTO `wiki_revision` VALUES (608, 608, 608, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363133, 0, 0);
INSERT INTO `wiki_revision` VALUES (609, 609, 609, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363133, 0, 0);
INSERT INTO `wiki_revision` VALUES (610, 610, 610, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363133, 0, 0);
INSERT INTO `wiki_revision` VALUES (611, 611, 611, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363133, 0, 0);
INSERT INTO `wiki_revision` VALUES (612, 612, 612, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363133, 0, 0);
INSERT INTO `wiki_revision` VALUES (613, 613, 613, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363133, 0, 0);
INSERT INTO `wiki_revision` VALUES (614, 614, 614, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363133, 0, 0);
INSERT INTO `wiki_revision` VALUES (615, 615, 615, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363133, 0, 0);
INSERT INTO `wiki_revision` VALUES (616, 616, 616, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363133, 0, 0);
INSERT INTO `wiki_revision` VALUES (617, 617, 617, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363133, 0, 0);
INSERT INTO `wiki_revision` VALUES (618, 618, 618, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363133, 0, 0);
INSERT INTO `wiki_revision` VALUES (619, 619, 619, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363133, 0, 0);
INSERT INTO `wiki_revision` VALUES (620, 620, 620, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363133, 0, 0);
INSERT INTO `wiki_revision` VALUES (621, 621, 621, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363133, 0, 0);
INSERT INTO `wiki_revision` VALUES (622, 622, 622, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363133, 0, 0);
INSERT INTO `wiki_revision` VALUES (623, 623, 623, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363133, 0, 0);
INSERT INTO `wiki_revision` VALUES (624, 624, 624, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363133, 0, 0);
INSERT INTO `wiki_revision` VALUES (625, 625, 625, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363133, 0, 0);
INSERT INTO `wiki_revision` VALUES (626, 626, 626, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363133, 0, 0);
INSERT INTO `wiki_revision` VALUES (627, 627, 627, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363133, 0, 0);
INSERT INTO `wiki_revision` VALUES (628, 628, 628, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363133, 0, 0);
INSERT INTO `wiki_revision` VALUES (629, 629, 629, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363133, 0, 0);
INSERT INTO `wiki_revision` VALUES (630, 630, 630, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363133, 0, 0);
INSERT INTO `wiki_revision` VALUES (631, 631, 631, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363133, 0, 0);
INSERT INTO `wiki_revision` VALUES (632, 632, 632, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363133, 0, 0);
INSERT INTO `wiki_revision` VALUES (633, 633, 633, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363133, 0, 0);
INSERT INTO `wiki_revision` VALUES (634, 634, 634, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363133, 0, 0);
INSERT INTO `wiki_revision` VALUES (635, 635, 635, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363133, 0, 0);
INSERT INTO `wiki_revision` VALUES (636, 636, 636, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363133, 0, 0);
INSERT INTO `wiki_revision` VALUES (637, 637, 637, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363133, 0, 0);
INSERT INTO `wiki_revision` VALUES (638, 638, 638, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363133, 0, 0);
INSERT INTO `wiki_revision` VALUES (639, 639, 639, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363134, 0, 0);
INSERT INTO `wiki_revision` VALUES (640, 640, 640, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363134, 0, 0);
INSERT INTO `wiki_revision` VALUES (641, 641, 641, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363134, 0, 0);
INSERT INTO `wiki_revision` VALUES (642, 642, 642, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363134, 0, 0);
INSERT INTO `wiki_revision` VALUES (643, 643, 643, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363134, 0, 0);
INSERT INTO `wiki_revision` VALUES (644, 644, 644, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363134, 0, 0);
INSERT INTO `wiki_revision` VALUES (645, 645, 645, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363134, 0, 0);
INSERT INTO `wiki_revision` VALUES (646, 646, 646, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363134, 0, 0);
INSERT INTO `wiki_revision` VALUES (647, 647, 647, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363134, 0, 0);
INSERT INTO `wiki_revision` VALUES (648, 648, 648, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363134, 0, 0);
INSERT INTO `wiki_revision` VALUES (649, 649, 649, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363134, 0, 0);
INSERT INTO `wiki_revision` VALUES (650, 650, 650, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363134, 0, 0);
INSERT INTO `wiki_revision` VALUES (651, 651, 651, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363134, 0, 0);
INSERT INTO `wiki_revision` VALUES (652, 652, 652, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363134, 0, 0);
INSERT INTO `wiki_revision` VALUES (653, 653, 653, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363134, 0, 0);
INSERT INTO `wiki_revision` VALUES (654, 654, 654, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363134, 0, 0);
INSERT INTO `wiki_revision` VALUES (655, 655, 655, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363134, 0, 0);
INSERT INTO `wiki_revision` VALUES (656, 656, 656, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363134, 0, 0);
INSERT INTO `wiki_revision` VALUES (657, 657, 657, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363134, 0, 0);
INSERT INTO `wiki_revision` VALUES (658, 658, 658, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363134, 0, 0);
INSERT INTO `wiki_revision` VALUES (659, 659, 659, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363134, 0, 0);
INSERT INTO `wiki_revision` VALUES (660, 660, 660, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363134, 0, 0);
INSERT INTO `wiki_revision` VALUES (661, 661, 661, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363134, 0, 0);
INSERT INTO `wiki_revision` VALUES (662, 662, 662, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363134, 0, 0);
INSERT INTO `wiki_revision` VALUES (663, 663, 663, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363134, 0, 0);
INSERT INTO `wiki_revision` VALUES (664, 664, 664, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363134, 0, 0);
INSERT INTO `wiki_revision` VALUES (665, 665, 665, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363134, 0, 0);
INSERT INTO `wiki_revision` VALUES (666, 666, 666, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363134, 0, 0);
INSERT INTO `wiki_revision` VALUES (667, 667, 667, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363134, 0, 0);
INSERT INTO `wiki_revision` VALUES (668, 668, 668, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363134, 0, 0);
INSERT INTO `wiki_revision` VALUES (669, 669, 669, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363134, 0, 0);
INSERT INTO `wiki_revision` VALUES (670, 670, 670, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363134, 0, 0);
INSERT INTO `wiki_revision` VALUES (671, 671, 671, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363134, 0, 0);
INSERT INTO `wiki_revision` VALUES (672, 672, 672, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363134, 0, 0);
INSERT INTO `wiki_revision` VALUES (673, 673, 673, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363134, 0, 0);
INSERT INTO `wiki_revision` VALUES (674, 674, 674, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363134, 0, 0);
INSERT INTO `wiki_revision` VALUES (675, 675, 675, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363134, 0, 0);
INSERT INTO `wiki_revision` VALUES (676, 676, 676, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363134, 0, 0);
INSERT INTO `wiki_revision` VALUES (677, 677, 677, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363134, 0, 0);
INSERT INTO `wiki_revision` VALUES (678, 678, 678, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363134, 0, 0);
INSERT INTO `wiki_revision` VALUES (679, 679, 679, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363134, 0, 0);
INSERT INTO `wiki_revision` VALUES (680, 680, 680, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363134, 0, 0);
INSERT INTO `wiki_revision` VALUES (681, 681, 681, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363134, 0, 0);
INSERT INTO `wiki_revision` VALUES (682, 682, 682, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363134, 0, 0);
INSERT INTO `wiki_revision` VALUES (683, 683, 683, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363134, 0, 0);
INSERT INTO `wiki_revision` VALUES (684, 684, 684, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363134, 0, 0);
INSERT INTO `wiki_revision` VALUES (685, 685, 685, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363134, 0, 0);
INSERT INTO `wiki_revision` VALUES (686, 686, 686, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363134, 0, 0);
INSERT INTO `wiki_revision` VALUES (687, 687, 687, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363134, 0, 0);
INSERT INTO `wiki_revision` VALUES (688, 688, 688, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363134, 0, 0);
INSERT INTO `wiki_revision` VALUES (689, 689, 689, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363134, 0, 0);
INSERT INTO `wiki_revision` VALUES (690, 690, 690, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363134, 0, 0);
INSERT INTO `wiki_revision` VALUES (691, 691, 691, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363134, 0, 0);
INSERT INTO `wiki_revision` VALUES (692, 692, 692, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363134, 0, 0);
INSERT INTO `wiki_revision` VALUES (693, 693, 693, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363134, 0, 0);
INSERT INTO `wiki_revision` VALUES (694, 694, 694, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363134, 0, 0);
INSERT INTO `wiki_revision` VALUES (695, 695, 695, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363134, 0, 0);
INSERT INTO `wiki_revision` VALUES (696, 696, 696, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363134, 0, 0);
INSERT INTO `wiki_revision` VALUES (697, 697, 697, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363134, 0, 0);
INSERT INTO `wiki_revision` VALUES (698, 698, 698, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363134, 0, 0);
INSERT INTO `wiki_revision` VALUES (699, 699, 699, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363134, 0, 0);
INSERT INTO `wiki_revision` VALUES (700, 700, 700, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363134, 0, 0);
INSERT INTO `wiki_revision` VALUES (701, 701, 701, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363134, 0, 0);
INSERT INTO `wiki_revision` VALUES (702, 702, 702, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363134, 0, 0);
INSERT INTO `wiki_revision` VALUES (703, 703, 703, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363134, 0, 0);
INSERT INTO `wiki_revision` VALUES (704, 704, 704, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363134, 0, 0);
INSERT INTO `wiki_revision` VALUES (705, 705, 705, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363134, 0, 0);
INSERT INTO `wiki_revision` VALUES (706, 706, 706, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363134, 0, 0);
INSERT INTO `wiki_revision` VALUES (707, 707, 707, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363134, 0, 0);
INSERT INTO `wiki_revision` VALUES (708, 708, 708, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363134, 0, 0);
INSERT INTO `wiki_revision` VALUES (709, 709, 709, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363134, 0, 0);
INSERT INTO `wiki_revision` VALUES (710, 710, 710, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363134, 0, 0);
INSERT INTO `wiki_revision` VALUES (711, 711, 711, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363134, 0, 0);
INSERT INTO `wiki_revision` VALUES (712, 712, 712, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363134, 0, 0);
INSERT INTO `wiki_revision` VALUES (713, 713, 713, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363134, 0, 0);
INSERT INTO `wiki_revision` VALUES (714, 714, 714, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363134, 0, 0);
INSERT INTO `wiki_revision` VALUES (715, 715, 715, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363134, 0, 0);
INSERT INTO `wiki_revision` VALUES (716, 716, 716, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363134, 0, 0);
INSERT INTO `wiki_revision` VALUES (717, 717, 717, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363134, 0, 0);
INSERT INTO `wiki_revision` VALUES (718, 718, 718, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363134, 0, 0);
INSERT INTO `wiki_revision` VALUES (719, 719, 719, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363134, 0, 0);
INSERT INTO `wiki_revision` VALUES (720, 720, 720, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363134, 0, 0);
INSERT INTO `wiki_revision` VALUES (721, 721, 721, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363135, 0, 0);
INSERT INTO `wiki_revision` VALUES (722, 722, 722, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363135, 0, 0);
INSERT INTO `wiki_revision` VALUES (723, 723, 723, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363135, 0, 0);
INSERT INTO `wiki_revision` VALUES (724, 724, 724, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363135, 0, 0);
INSERT INTO `wiki_revision` VALUES (725, 725, 725, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363135, 0, 0);
INSERT INTO `wiki_revision` VALUES (726, 726, 726, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363135, 0, 0);
INSERT INTO `wiki_revision` VALUES (727, 727, 727, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363135, 0, 0);
INSERT INTO `wiki_revision` VALUES (728, 728, 728, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363135, 0, 0);
INSERT INTO `wiki_revision` VALUES (729, 729, 729, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363135, 0, 0);
INSERT INTO `wiki_revision` VALUES (730, 730, 730, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363135, 0, 0);
INSERT INTO `wiki_revision` VALUES (731, 731, 731, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363135, 0, 0);
INSERT INTO `wiki_revision` VALUES (732, 732, 732, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363135, 0, 0);
INSERT INTO `wiki_revision` VALUES (733, 733, 733, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363135, 0, 0);
INSERT INTO `wiki_revision` VALUES (734, 734, 734, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363135, 0, 0);
INSERT INTO `wiki_revision` VALUES (735, 735, 735, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363135, 0, 0);
INSERT INTO `wiki_revision` VALUES (736, 736, 736, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363135, 0, 0);
INSERT INTO `wiki_revision` VALUES (737, 737, 737, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363135, 0, 0);
INSERT INTO `wiki_revision` VALUES (738, 738, 738, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363135, 0, 0);
INSERT INTO `wiki_revision` VALUES (739, 739, 739, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363135, 0, 0);
INSERT INTO `wiki_revision` VALUES (740, 740, 740, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363135, 0, 0);
INSERT INTO `wiki_revision` VALUES (741, 741, 741, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363135, 0, 0);
INSERT INTO `wiki_revision` VALUES (742, 742, 742, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363135, 0, 0);
INSERT INTO `wiki_revision` VALUES (743, 743, 743, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363135, 0, 0);
INSERT INTO `wiki_revision` VALUES (744, 744, 744, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363135, 0, 0);
INSERT INTO `wiki_revision` VALUES (745, 745, 745, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363135, 0, 0);
INSERT INTO `wiki_revision` VALUES (746, 746, 746, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363135, 0, 0);
INSERT INTO `wiki_revision` VALUES (747, 747, 747, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363135, 0, 0);
INSERT INTO `wiki_revision` VALUES (748, 748, 748, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363135, 0, 0);
INSERT INTO `wiki_revision` VALUES (749, 749, 749, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363135, 0, 0);
INSERT INTO `wiki_revision` VALUES (750, 750, 750, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363135, 0, 0);
INSERT INTO `wiki_revision` VALUES (751, 751, 751, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363135, 0, 0);
INSERT INTO `wiki_revision` VALUES (752, 752, 752, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363135, 0, 0);
INSERT INTO `wiki_revision` VALUES (753, 753, 753, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363135, 0, 0);
INSERT INTO `wiki_revision` VALUES (754, 754, 754, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363135, 0, 0);
INSERT INTO `wiki_revision` VALUES (755, 755, 755, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363135, 0, 0);
INSERT INTO `wiki_revision` VALUES (756, 756, 756, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363135, 0, 0);
INSERT INTO `wiki_revision` VALUES (757, 757, 757, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363135, 0, 0);
INSERT INTO `wiki_revision` VALUES (758, 758, 758, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363135, 0, 0);
INSERT INTO `wiki_revision` VALUES (759, 759, 759, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363135, 0, 0);
INSERT INTO `wiki_revision` VALUES (760, 760, 760, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363135, 0, 0);
INSERT INTO `wiki_revision` VALUES (761, 761, 761, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363135, 0, 0);
INSERT INTO `wiki_revision` VALUES (762, 762, 762, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363135, 0, 0);
INSERT INTO `wiki_revision` VALUES (763, 763, 763, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363135, 0, 0);
INSERT INTO `wiki_revision` VALUES (764, 764, 764, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363135, 0, 0);
INSERT INTO `wiki_revision` VALUES (765, 765, 765, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363135, 0, 0);
INSERT INTO `wiki_revision` VALUES (766, 766, 766, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363135, 0, 0);
INSERT INTO `wiki_revision` VALUES (767, 767, 767, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363135, 0, 0);
INSERT INTO `wiki_revision` VALUES (768, 768, 768, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363135, 0, 0);
INSERT INTO `wiki_revision` VALUES (769, 769, 769, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363135, 0, 0);
INSERT INTO `wiki_revision` VALUES (770, 770, 770, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363135, 0, 0);
INSERT INTO `wiki_revision` VALUES (771, 771, 771, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363135, 0, 0);
INSERT INTO `wiki_revision` VALUES (772, 772, 772, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363135, 0, 0);
INSERT INTO `wiki_revision` VALUES (773, 773, 773, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363135, 0, 0);
INSERT INTO `wiki_revision` VALUES (774, 774, 774, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363135, 0, 0);
INSERT INTO `wiki_revision` VALUES (775, 775, 775, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363135, 0, 0);
INSERT INTO `wiki_revision` VALUES (776, 776, 776, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363135, 0, 0);
INSERT INTO `wiki_revision` VALUES (777, 777, 777, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363135, 0, 0);
INSERT INTO `wiki_revision` VALUES (778, 778, 778, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363135, 0, 0);
INSERT INTO `wiki_revision` VALUES (779, 779, 779, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363135, 0, 0);
INSERT INTO `wiki_revision` VALUES (780, 780, 780, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363135, 0, 0);
INSERT INTO `wiki_revision` VALUES (781, 781, 781, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363135, 0, 0);
INSERT INTO `wiki_revision` VALUES (782, 782, 782, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363135, 0, 0);
INSERT INTO `wiki_revision` VALUES (783, 783, 783, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363135, 0, 0);
INSERT INTO `wiki_revision` VALUES (784, 784, 784, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363135, 0, 0);
INSERT INTO `wiki_revision` VALUES (785, 785, 785, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363135, 0, 0);
INSERT INTO `wiki_revision` VALUES (786, 786, 786, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363135, 0, 0);
INSERT INTO `wiki_revision` VALUES (787, 787, 787, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363135, 0, 0);
INSERT INTO `wiki_revision` VALUES (788, 788, 788, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363135, 0, 0);
INSERT INTO `wiki_revision` VALUES (789, 789, 789, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363135, 0, 0);
INSERT INTO `wiki_revision` VALUES (790, 790, 790, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363135, 0, 0);
INSERT INTO `wiki_revision` VALUES (791, 791, 791, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363135, 0, 0);
INSERT INTO `wiki_revision` VALUES (792, 792, 792, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363135, 0, 0);
INSERT INTO `wiki_revision` VALUES (793, 793, 793, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363135, 0, 0);
INSERT INTO `wiki_revision` VALUES (794, 794, 794, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363135, 0, 0);
INSERT INTO `wiki_revision` VALUES (795, 795, 795, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363135, 0, 0);
INSERT INTO `wiki_revision` VALUES (796, 796, 796, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363135, 0, 0);
INSERT INTO `wiki_revision` VALUES (797, 797, 797, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363135, 0, 0);
INSERT INTO `wiki_revision` VALUES (798, 798, 798, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363135, 0, 0);
INSERT INTO `wiki_revision` VALUES (799, 799, 799, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363135, 0, 0);
INSERT INTO `wiki_revision` VALUES (800, 800, 800, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363136, 0, 0);
INSERT INTO `wiki_revision` VALUES (801, 801, 801, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363136, 0, 0);
INSERT INTO `wiki_revision` VALUES (802, 802, 802, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363136, 0, 0);
INSERT INTO `wiki_revision` VALUES (803, 803, 803, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363136, 0, 0);
INSERT INTO `wiki_revision` VALUES (804, 804, 804, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363136, 0, 0);
INSERT INTO `wiki_revision` VALUES (805, 805, 805, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363136, 0, 0);
INSERT INTO `wiki_revision` VALUES (806, 806, 806, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363136, 0, 0);
INSERT INTO `wiki_revision` VALUES (807, 807, 807, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363136, 0, 0);
INSERT INTO `wiki_revision` VALUES (808, 808, 808, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363136, 0, 0);
INSERT INTO `wiki_revision` VALUES (809, 809, 809, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363136, 0, 0);
INSERT INTO `wiki_revision` VALUES (810, 810, 810, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363136, 0, 0);
INSERT INTO `wiki_revision` VALUES (811, 811, 811, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363136, 0, 0);
INSERT INTO `wiki_revision` VALUES (812, 812, 812, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363136, 0, 0);
INSERT INTO `wiki_revision` VALUES (813, 813, 813, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363136, 0, 0);
INSERT INTO `wiki_revision` VALUES (814, 814, 814, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363136, 0, 0);
INSERT INTO `wiki_revision` VALUES (815, 815, 815, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363136, 0, 0);
INSERT INTO `wiki_revision` VALUES (816, 816, 816, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363136, 0, 0);
INSERT INTO `wiki_revision` VALUES (817, 817, 817, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363136, 0, 0);
INSERT INTO `wiki_revision` VALUES (818, 818, 818, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363136, 0, 0);
INSERT INTO `wiki_revision` VALUES (819, 819, 819, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363136, 0, 0);
INSERT INTO `wiki_revision` VALUES (820, 820, 820, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363136, 0, 0);
INSERT INTO `wiki_revision` VALUES (821, 821, 821, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363136, 0, 0);
INSERT INTO `wiki_revision` VALUES (822, 822, 822, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363136, 0, 0);
INSERT INTO `wiki_revision` VALUES (823, 823, 823, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363136, 0, 0);
INSERT INTO `wiki_revision` VALUES (824, 824, 824, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363136, 0, 0);
INSERT INTO `wiki_revision` VALUES (825, 825, 825, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363136, 0, 0);
INSERT INTO `wiki_revision` VALUES (826, 826, 826, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363136, 0, 0);
INSERT INTO `wiki_revision` VALUES (827, 827, 827, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363136, 0, 0);
INSERT INTO `wiki_revision` VALUES (828, 828, 828, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363136, 0, 0);
INSERT INTO `wiki_revision` VALUES (829, 829, 829, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363136, 0, 0);
INSERT INTO `wiki_revision` VALUES (830, 830, 830, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363136, 0, 0);
INSERT INTO `wiki_revision` VALUES (831, 831, 831, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363136, 0, 0);
INSERT INTO `wiki_revision` VALUES (832, 832, 832, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363136, 0, 0);
INSERT INTO `wiki_revision` VALUES (833, 833, 833, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363136, 0, 0);
INSERT INTO `wiki_revision` VALUES (834, 834, 834, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363136, 0, 0);
INSERT INTO `wiki_revision` VALUES (835, 835, 835, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363136, 0, 0);
INSERT INTO `wiki_revision` VALUES (836, 836, 836, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363136, 0, 0);
INSERT INTO `wiki_revision` VALUES (837, 837, 837, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363136, 0, 0);
INSERT INTO `wiki_revision` VALUES (838, 838, 838, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363136, 0, 0);
INSERT INTO `wiki_revision` VALUES (839, 839, 839, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363136, 0, 0);
INSERT INTO `wiki_revision` VALUES (840, 840, 840, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363136, 0, 0);
INSERT INTO `wiki_revision` VALUES (841, 841, 841, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363136, 0, 0);
INSERT INTO `wiki_revision` VALUES (842, 842, 842, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363136, 0, 0);
INSERT INTO `wiki_revision` VALUES (843, 843, 843, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363136, 0, 0);
INSERT INTO `wiki_revision` VALUES (844, 844, 844, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363136, 0, 0);
INSERT INTO `wiki_revision` VALUES (845, 845, 845, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363136, 0, 0);
INSERT INTO `wiki_revision` VALUES (846, 846, 846, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363136, 0, 0);
INSERT INTO `wiki_revision` VALUES (847, 847, 847, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363136, 0, 0);
INSERT INTO `wiki_revision` VALUES (848, 848, 848, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363136, 0, 0);
INSERT INTO `wiki_revision` VALUES (849, 849, 849, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363136, 0, 0);
INSERT INTO `wiki_revision` VALUES (850, 850, 850, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363136, 0, 0);
INSERT INTO `wiki_revision` VALUES (851, 851, 851, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363136, 0, 0);
INSERT INTO `wiki_revision` VALUES (852, 852, 852, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363136, 0, 0);
INSERT INTO `wiki_revision` VALUES (853, 853, 853, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363136, 0, 0);
INSERT INTO `wiki_revision` VALUES (854, 854, 854, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363136, 0, 0);
INSERT INTO `wiki_revision` VALUES (855, 855, 855, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363136, 0, 0);
INSERT INTO `wiki_revision` VALUES (856, 856, 856, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363136, 0, 0);
INSERT INTO `wiki_revision` VALUES (857, 857, 857, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363136, 0, 0);
INSERT INTO `wiki_revision` VALUES (858, 858, 858, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363136, 0, 0);
INSERT INTO `wiki_revision` VALUES (859, 859, 859, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363136, 0, 0);
INSERT INTO `wiki_revision` VALUES (860, 860, 860, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363136, 0, 0);
INSERT INTO `wiki_revision` VALUES (861, 861, 861, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363136, 0, 0);
INSERT INTO `wiki_revision` VALUES (862, 862, 862, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363136, 0, 0);
INSERT INTO `wiki_revision` VALUES (863, 863, 863, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363136, 0, 0);
INSERT INTO `wiki_revision` VALUES (864, 864, 864, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363136, 0, 0);
INSERT INTO `wiki_revision` VALUES (865, 865, 865, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363136, 0, 0);
INSERT INTO `wiki_revision` VALUES (866, 866, 866, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363136, 0, 0);
INSERT INTO `wiki_revision` VALUES (867, 867, 867, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363136, 0, 0);
INSERT INTO `wiki_revision` VALUES (868, 868, 868, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363136, 0, 0);
INSERT INTO `wiki_revision` VALUES (869, 869, 869, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363136, 0, 0);
INSERT INTO `wiki_revision` VALUES (870, 870, 870, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363136, 0, 0);
INSERT INTO `wiki_revision` VALUES (871, 871, 871, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363136, 0, 0);
INSERT INTO `wiki_revision` VALUES (872, 872, 872, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363136, 0, 0);
INSERT INTO `wiki_revision` VALUES (873, 873, 873, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363136, 0, 0);
INSERT INTO `wiki_revision` VALUES (874, 874, 874, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363136, 0, 0);
INSERT INTO `wiki_revision` VALUES (875, 875, 875, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363136, 0, 0);
INSERT INTO `wiki_revision` VALUES (876, 876, 876, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363136, 0, 0);
INSERT INTO `wiki_revision` VALUES (877, 877, 877, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363136, 0, 0);
INSERT INTO `wiki_revision` VALUES (878, 878, 878, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363136, 0, 0);
INSERT INTO `wiki_revision` VALUES (879, 879, 879, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363136, 0, 0);
INSERT INTO `wiki_revision` VALUES (880, 880, 880, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363136, 0, 0);
INSERT INTO `wiki_revision` VALUES (881, 881, 881, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363137, 0, 0);
INSERT INTO `wiki_revision` VALUES (882, 882, 882, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363137, 0, 0);
INSERT INTO `wiki_revision` VALUES (883, 883, 883, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363137, 0, 0);
INSERT INTO `wiki_revision` VALUES (884, 884, 884, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363137, 0, 0);
INSERT INTO `wiki_revision` VALUES (885, 885, 885, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363137, 0, 0);
INSERT INTO `wiki_revision` VALUES (886, 886, 886, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363137, 0, 0);
INSERT INTO `wiki_revision` VALUES (887, 887, 887, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363137, 0, 0);
INSERT INTO `wiki_revision` VALUES (888, 888, 888, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363137, 0, 0);
INSERT INTO `wiki_revision` VALUES (889, 889, 889, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363137, 0, 0);
INSERT INTO `wiki_revision` VALUES (890, 890, 890, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363137, 0, 0);
INSERT INTO `wiki_revision` VALUES (891, 891, 891, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363137, 0, 0);
INSERT INTO `wiki_revision` VALUES (892, 892, 892, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363137, 0, 0);
INSERT INTO `wiki_revision` VALUES (893, 893, 893, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363137, 0, 0);
INSERT INTO `wiki_revision` VALUES (894, 894, 894, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363137, 0, 0);
INSERT INTO `wiki_revision` VALUES (895, 895, 895, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363137, 0, 0);
INSERT INTO `wiki_revision` VALUES (896, 896, 896, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363137, 0, 0);
INSERT INTO `wiki_revision` VALUES (897, 897, 897, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363137, 0, 0);
INSERT INTO `wiki_revision` VALUES (898, 898, 898, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363137, 0, 0);
INSERT INTO `wiki_revision` VALUES (899, 899, 899, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363137, 0, 0);
INSERT INTO `wiki_revision` VALUES (900, 900, 900, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363137, 0, 0);
INSERT INTO `wiki_revision` VALUES (901, 901, 901, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363137, 0, 0);
INSERT INTO `wiki_revision` VALUES (902, 902, 902, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363137, 0, 0);
INSERT INTO `wiki_revision` VALUES (903, 903, 903, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363137, 0, 0);
INSERT INTO `wiki_revision` VALUES (904, 904, 904, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363137, 0, 0);
INSERT INTO `wiki_revision` VALUES (905, 905, 905, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363137, 0, 0);
INSERT INTO `wiki_revision` VALUES (906, 906, 906, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363137, 0, 0);
INSERT INTO `wiki_revision` VALUES (907, 907, 907, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363137, 0, 0);
INSERT INTO `wiki_revision` VALUES (908, 908, 908, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363137, 0, 0);
INSERT INTO `wiki_revision` VALUES (909, 909, 909, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363137, 0, 0);
INSERT INTO `wiki_revision` VALUES (910, 910, 910, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363137, 0, 0);
INSERT INTO `wiki_revision` VALUES (911, 911, 911, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363137, 0, 0);
INSERT INTO `wiki_revision` VALUES (912, 912, 912, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363137, 0, 0);
INSERT INTO `wiki_revision` VALUES (913, 913, 913, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363137, 0, 0);
INSERT INTO `wiki_revision` VALUES (914, 914, 914, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363137, 0, 0);
INSERT INTO `wiki_revision` VALUES (915, 915, 915, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363137, 0, 0);
INSERT INTO `wiki_revision` VALUES (916, 916, 916, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363137, 0, 0);
INSERT INTO `wiki_revision` VALUES (917, 917, 917, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363137, 0, 0);
INSERT INTO `wiki_revision` VALUES (918, 918, 918, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363137, 0, 0);
INSERT INTO `wiki_revision` VALUES (919, 919, 919, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363137, 0, 0);
INSERT INTO `wiki_revision` VALUES (920, 920, 920, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363137, 0, 0);
INSERT INTO `wiki_revision` VALUES (921, 921, 921, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363137, 0, 0);
INSERT INTO `wiki_revision` VALUES (922, 922, 922, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363137, 0, 0);
INSERT INTO `wiki_revision` VALUES (923, 923, 923, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363137, 0, 0);
INSERT INTO `wiki_revision` VALUES (924, 924, 924, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363137, 0, 0);
INSERT INTO `wiki_revision` VALUES (925, 925, 925, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363137, 0, 0);
INSERT INTO `wiki_revision` VALUES (926, 926, 926, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363137, 0, 0);
INSERT INTO `wiki_revision` VALUES (927, 927, 927, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363137, 0, 0);
INSERT INTO `wiki_revision` VALUES (928, 928, 928, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363137, 0, 0);
INSERT INTO `wiki_revision` VALUES (929, 929, 929, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363137, 0, 0);
INSERT INTO `wiki_revision` VALUES (930, 930, 930, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363137, 0, 0);
INSERT INTO `wiki_revision` VALUES (931, 931, 931, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363137, 0, 0);
INSERT INTO `wiki_revision` VALUES (932, 932, 932, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363137, 0, 0);
INSERT INTO `wiki_revision` VALUES (933, 933, 933, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363137, 0, 0);
INSERT INTO `wiki_revision` VALUES (934, 934, 934, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363137, 0, 0);
INSERT INTO `wiki_revision` VALUES (935, 935, 935, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363137, 0, 0);
INSERT INTO `wiki_revision` VALUES (936, 936, 936, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363137, 0, 0);
INSERT INTO `wiki_revision` VALUES (937, 937, 937, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363137, 0, 0);
INSERT INTO `wiki_revision` VALUES (938, 938, 938, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363137, 0, 0);
INSERT INTO `wiki_revision` VALUES (939, 939, 939, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363137, 0, 0);
INSERT INTO `wiki_revision` VALUES (940, 940, 940, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363137, 0, 0);
INSERT INTO `wiki_revision` VALUES (941, 941, 941, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363137, 0, 0);
INSERT INTO `wiki_revision` VALUES (942, 942, 942, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363137, 0, 0);
INSERT INTO `wiki_revision` VALUES (943, 943, 943, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363137, 0, 0);
INSERT INTO `wiki_revision` VALUES (944, 944, 944, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363137, 0, 0);
INSERT INTO `wiki_revision` VALUES (945, 945, 945, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363137, 0, 0);
INSERT INTO `wiki_revision` VALUES (946, 946, 946, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363137, 0, 0);
INSERT INTO `wiki_revision` VALUES (947, 947, 947, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363137, 0, 0);
INSERT INTO `wiki_revision` VALUES (948, 948, 948, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363137, 0, 0);
INSERT INTO `wiki_revision` VALUES (949, 949, 949, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363137, 0, 0);
INSERT INTO `wiki_revision` VALUES (950, 950, 950, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363137, 0, 0);
INSERT INTO `wiki_revision` VALUES (951, 951, 951, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363137, 0, 0);
INSERT INTO `wiki_revision` VALUES (952, 952, 952, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363137, 0, 0);
INSERT INTO `wiki_revision` VALUES (953, 953, 953, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363137, 0, 0);
INSERT INTO `wiki_revision` VALUES (954, 954, 954, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363137, 0, 0);
INSERT INTO `wiki_revision` VALUES (955, 955, 955, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363137, 0, 0);
INSERT INTO `wiki_revision` VALUES (956, 956, 956, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363137, 0, 0);
INSERT INTO `wiki_revision` VALUES (957, 957, 957, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363137, 0, 0);
INSERT INTO `wiki_revision` VALUES (958, 958, 958, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363137, 0, 0);
INSERT INTO `wiki_revision` VALUES (959, 959, 959, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363137, 0, 0);
INSERT INTO `wiki_revision` VALUES (960, 960, 960, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363137, 0, 0);
INSERT INTO `wiki_revision` VALUES (961, 961, 961, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363138, 0, 0);
INSERT INTO `wiki_revision` VALUES (962, 962, 962, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363138, 0, 0);
INSERT INTO `wiki_revision` VALUES (963, 963, 963, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363138, 0, 0);
INSERT INTO `wiki_revision` VALUES (964, 964, 964, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363138, 0, 0);
INSERT INTO `wiki_revision` VALUES (965, 965, 965, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363138, 0, 0);
INSERT INTO `wiki_revision` VALUES (966, 966, 966, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363138, 0, 0);
INSERT INTO `wiki_revision` VALUES (967, 967, 967, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363138, 0, 0);
INSERT INTO `wiki_revision` VALUES (968, 968, 968, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363138, 0, 0);
INSERT INTO `wiki_revision` VALUES (969, 969, 969, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363138, 0, 0);
INSERT INTO `wiki_revision` VALUES (970, 970, 970, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363138, 0, 0);
INSERT INTO `wiki_revision` VALUES (971, 971, 971, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363138, 0, 0);
INSERT INTO `wiki_revision` VALUES (972, 972, 972, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363138, 0, 0);
INSERT INTO `wiki_revision` VALUES (973, 973, 973, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363138, 0, 0);
INSERT INTO `wiki_revision` VALUES (974, 974, 974, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363138, 0, 0);
INSERT INTO `wiki_revision` VALUES (975, 975, 975, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363138, 0, 0);
INSERT INTO `wiki_revision` VALUES (976, 976, 976, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363138, 0, 0);
INSERT INTO `wiki_revision` VALUES (977, 977, 977, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363138, 0, 0);
INSERT INTO `wiki_revision` VALUES (978, 978, 978, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363138, 0, 0);
INSERT INTO `wiki_revision` VALUES (979, 979, 979, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363138, 0, 0);
INSERT INTO `wiki_revision` VALUES (980, 980, 980, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363138, 0, 0);
INSERT INTO `wiki_revision` VALUES (981, 981, 981, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363138, 0, 0);
INSERT INTO `wiki_revision` VALUES (982, 982, 982, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363138, 0, 0);
INSERT INTO `wiki_revision` VALUES (983, 983, 983, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363138, 0, 0);
INSERT INTO `wiki_revision` VALUES (984, 984, 984, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363138, 0, 0);
INSERT INTO `wiki_revision` VALUES (985, 985, 985, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363138, 0, 0);
INSERT INTO `wiki_revision` VALUES (986, 986, 986, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363138, 0, 0);
INSERT INTO `wiki_revision` VALUES (987, 987, 987, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363138, 0, 0);
INSERT INTO `wiki_revision` VALUES (988, 988, 988, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363138, 0, 0);
INSERT INTO `wiki_revision` VALUES (989, 989, 989, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363138, 0, 0);
INSERT INTO `wiki_revision` VALUES (990, 990, 990, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363138, 0, 0);
INSERT INTO `wiki_revision` VALUES (991, 991, 991, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363138, 0, 0);
INSERT INTO `wiki_revision` VALUES (992, 992, 992, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363138, 0, 0);
INSERT INTO `wiki_revision` VALUES (993, 993, 993, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363138, 0, 0);
INSERT INTO `wiki_revision` VALUES (994, 994, 994, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363138, 0, 0);
INSERT INTO `wiki_revision` VALUES (995, 995, 995, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363138, 0, 0);
INSERT INTO `wiki_revision` VALUES (996, 996, 996, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363138, 0, 0);
INSERT INTO `wiki_revision` VALUES (997, 997, 997, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363138, 0, 0);
INSERT INTO `wiki_revision` VALUES (998, 998, 998, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363138, 0, 0);
INSERT INTO `wiki_revision` VALUES (999, 999, 999, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363138, 0, 0);
INSERT INTO `wiki_revision` VALUES (1000, 1000, 1000, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363138, 0, 0);
INSERT INTO `wiki_revision` VALUES (1001, 1001, 1001, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363138, 0, 0);
INSERT INTO `wiki_revision` VALUES (1002, 1002, 1002, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363138, 0, 0);
INSERT INTO `wiki_revision` VALUES (1003, 1003, 1003, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363138, 0, 0);
INSERT INTO `wiki_revision` VALUES (1004, 1004, 1004, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363138, 0, 0);
INSERT INTO `wiki_revision` VALUES (1005, 1005, 1005, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363138, 0, 0);
INSERT INTO `wiki_revision` VALUES (1006, 1006, 1006, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363138, 0, 0);
INSERT INTO `wiki_revision` VALUES (1007, 1007, 1007, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363138, 0, 0);
INSERT INTO `wiki_revision` VALUES (1008, 1008, 1008, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363138, 0, 0);
INSERT INTO `wiki_revision` VALUES (1009, 1009, 1009, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363138, 0, 0);
INSERT INTO `wiki_revision` VALUES (1010, 1010, 1010, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363138, 0, 0);
INSERT INTO `wiki_revision` VALUES (1011, 1011, 1011, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363138, 0, 0);
INSERT INTO `wiki_revision` VALUES (1012, 1012, 1012, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363138, 0, 0);
INSERT INTO `wiki_revision` VALUES (1013, 1013, 1013, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363138, 0, 0);
INSERT INTO `wiki_revision` VALUES (1014, 1014, 1014, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363138, 0, 0);
INSERT INTO `wiki_revision` VALUES (1015, 1015, 1015, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363138, 0, 0);
INSERT INTO `wiki_revision` VALUES (1016, 1016, 1016, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363138, 0, 0);
INSERT INTO `wiki_revision` VALUES (1017, 1017, 1017, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363138, 0, 0);
INSERT INTO `wiki_revision` VALUES (1018, 1018, 1018, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363138, 0, 0);
INSERT INTO `wiki_revision` VALUES (1019, 1019, 1019, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363138, 0, 0);
INSERT INTO `wiki_revision` VALUES (1020, 1020, 1020, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363138, 0, 0);
INSERT INTO `wiki_revision` VALUES (1021, 1021, 1021, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363138, 0, 0);
INSERT INTO `wiki_revision` VALUES (1022, 1022, 1022, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363138, 0, 0);
INSERT INTO `wiki_revision` VALUES (1023, 1023, 1023, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363138, 0, 0);
INSERT INTO `wiki_revision` VALUES (1024, 1024, 1024, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363138, 0, 0);
INSERT INTO `wiki_revision` VALUES (1025, 1025, 1025, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363138, 0, 0);
INSERT INTO `wiki_revision` VALUES (1026, 1026, 1026, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363138, 0, 0);
INSERT INTO `wiki_revision` VALUES (1027, 1027, 1027, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363138, 0, 0);
INSERT INTO `wiki_revision` VALUES (1028, 1028, 1028, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363138, 0, 0);
INSERT INTO `wiki_revision` VALUES (1029, 1029, 1029, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363138, 0, 0);
INSERT INTO `wiki_revision` VALUES (1030, 1030, 1030, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363138, 0, 0);
INSERT INTO `wiki_revision` VALUES (1031, 1031, 1031, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363138, 0, 0);
INSERT INTO `wiki_revision` VALUES (1032, 1032, 1032, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363138, 0, 0);
INSERT INTO `wiki_revision` VALUES (1033, 1033, 1033, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363138, 0, 0);
INSERT INTO `wiki_revision` VALUES (1034, 1034, 1034, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363138, 0, 0);
INSERT INTO `wiki_revision` VALUES (1035, 1035, 1035, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363138, 0, 0);
INSERT INTO `wiki_revision` VALUES (1036, 1036, 1036, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363138, 0, 0);
INSERT INTO `wiki_revision` VALUES (1037, 1037, 1037, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363138, 0, 0);
INSERT INTO `wiki_revision` VALUES (1038, 1038, 1038, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363138, 0, 0);
INSERT INTO `wiki_revision` VALUES (1039, 1039, 1039, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363138, 0, 0);
INSERT INTO `wiki_revision` VALUES (1040, 1040, 1040, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363138, 0, 0);
INSERT INTO `wiki_revision` VALUES (1041, 1041, 1041, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363138, 0, 0);
INSERT INTO `wiki_revision` VALUES (1042, 1042, 1042, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363138, 0, 0);
INSERT INTO `wiki_revision` VALUES (1043, 1043, 1043, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363139, 0, 0);
INSERT INTO `wiki_revision` VALUES (1044, 1044, 1044, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363139, 0, 0);
INSERT INTO `wiki_revision` VALUES (1045, 1045, 1045, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363139, 0, 0);
INSERT INTO `wiki_revision` VALUES (1046, 1046, 1046, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363139, 0, 0);
INSERT INTO `wiki_revision` VALUES (1047, 1047, 1047, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363139, 0, 0);
INSERT INTO `wiki_revision` VALUES (1048, 1048, 1048, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363139, 0, 0);
INSERT INTO `wiki_revision` VALUES (1049, 1049, 1049, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363139, 0, 0);
INSERT INTO `wiki_revision` VALUES (1050, 1050, 1050, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363139, 0, 0);
INSERT INTO `wiki_revision` VALUES (1051, 1051, 1051, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363139, 0, 0);
INSERT INTO `wiki_revision` VALUES (1052, 1052, 1052, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363139, 0, 0);
INSERT INTO `wiki_revision` VALUES (1053, 1053, 1053, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363139, 0, 0);
INSERT INTO `wiki_revision` VALUES (1054, 1054, 1054, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363139, 0, 0);
INSERT INTO `wiki_revision` VALUES (1055, 1055, 1055, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363139, 0, 0);
INSERT INTO `wiki_revision` VALUES (1056, 1056, 1056, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363139, 0, 0);
INSERT INTO `wiki_revision` VALUES (1057, 1057, 1057, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363139, 0, 0);
INSERT INTO `wiki_revision` VALUES (1058, 1058, 1058, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363139, 0, 0);
INSERT INTO `wiki_revision` VALUES (1059, 1059, 1059, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363139, 0, 0);
INSERT INTO `wiki_revision` VALUES (1060, 1060, 1060, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363139, 0, 0);
INSERT INTO `wiki_revision` VALUES (1061, 1061, 1061, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363139, 0, 0);
INSERT INTO `wiki_revision` VALUES (1062, 1062, 1062, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363139, 0, 0);
INSERT INTO `wiki_revision` VALUES (1063, 1063, 1063, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363139, 0, 0);
INSERT INTO `wiki_revision` VALUES (1064, 1064, 1064, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363139, 0, 0);
INSERT INTO `wiki_revision` VALUES (1065, 1065, 1065, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363139, 0, 0);
INSERT INTO `wiki_revision` VALUES (1066, 1066, 1066, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363139, 0, 0);
INSERT INTO `wiki_revision` VALUES (1067, 1067, 1067, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363139, 0, 0);
INSERT INTO `wiki_revision` VALUES (1068, 1068, 1068, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363139, 0, 0);
INSERT INTO `wiki_revision` VALUES (1069, 1069, 1069, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363139, 0, 0);
INSERT INTO `wiki_revision` VALUES (1070, 1070, 1070, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363139, 0, 0);
INSERT INTO `wiki_revision` VALUES (1071, 1071, 1071, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363139, 0, 0);
INSERT INTO `wiki_revision` VALUES (1072, 1072, 1072, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363139, 0, 0);
INSERT INTO `wiki_revision` VALUES (1073, 1073, 1073, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363139, 0, 0);
INSERT INTO `wiki_revision` VALUES (1074, 1074, 1074, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363139, 0, 0);
INSERT INTO `wiki_revision` VALUES (1075, 1075, 1075, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363139, 0, 0);
INSERT INTO `wiki_revision` VALUES (1076, 1076, 1076, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363139, 0, 0);
INSERT INTO `wiki_revision` VALUES (1077, 1077, 1077, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363139, 0, 0);
INSERT INTO `wiki_revision` VALUES (1078, 1078, 1078, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363139, 0, 0);
INSERT INTO `wiki_revision` VALUES (1079, 1079, 1079, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363139, 0, 0);
INSERT INTO `wiki_revision` VALUES (1080, 1080, 1080, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363139, 0, 0);
INSERT INTO `wiki_revision` VALUES (1081, 1081, 1081, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363139, 0, 0);
INSERT INTO `wiki_revision` VALUES (1082, 1082, 1082, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363139, 0, 0);
INSERT INTO `wiki_revision` VALUES (1083, 1083, 1083, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363139, 0, 0);
INSERT INTO `wiki_revision` VALUES (1084, 1084, 1084, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363139, 0, 0);
INSERT INTO `wiki_revision` VALUES (1085, 1085, 1085, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363139, 0, 0);
INSERT INTO `wiki_revision` VALUES (1086, 1086, 1086, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363139, 0, 0);
INSERT INTO `wiki_revision` VALUES (1087, 1087, 1087, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363139, 0, 0);
INSERT INTO `wiki_revision` VALUES (1088, 1088, 1088, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363139, 0, 0);
INSERT INTO `wiki_revision` VALUES (1089, 1089, 1089, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363139, 0, 0);
INSERT INTO `wiki_revision` VALUES (1090, 1090, 1090, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363139, 0, 0);
INSERT INTO `wiki_revision` VALUES (1091, 1091, 1091, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363139, 0, 0);
INSERT INTO `wiki_revision` VALUES (1092, 1092, 1092, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363139, 0, 0);
INSERT INTO `wiki_revision` VALUES (1093, 1093, 1093, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363139, 0, 0);
INSERT INTO `wiki_revision` VALUES (1094, 1094, 1094, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363139, 0, 0);
INSERT INTO `wiki_revision` VALUES (1095, 1095, 1095, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363139, 0, 0);
INSERT INTO `wiki_revision` VALUES (1096, 1096, 1096, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363139, 0, 0);
INSERT INTO `wiki_revision` VALUES (1097, 1097, 1097, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363139, 0, 0);
INSERT INTO `wiki_revision` VALUES (1098, 1098, 1098, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363139, 0, 0);
INSERT INTO `wiki_revision` VALUES (1099, 1099, 1099, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363139, 0, 0);
INSERT INTO `wiki_revision` VALUES (1100, 1100, 1100, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363139, 0, 0);
INSERT INTO `wiki_revision` VALUES (1101, 1101, 1101, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363139, 0, 0);
INSERT INTO `wiki_revision` VALUES (1102, 1102, 1102, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363139, 0, 0);
INSERT INTO `wiki_revision` VALUES (1103, 1103, 1103, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363139, 0, 0);
INSERT INTO `wiki_revision` VALUES (1104, 1104, 1104, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363139, 0, 0);
INSERT INTO `wiki_revision` VALUES (1105, 1105, 1105, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363139, 0, 0);
INSERT INTO `wiki_revision` VALUES (1106, 1106, 1106, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363139, 0, 0);
INSERT INTO `wiki_revision` VALUES (1107, 1107, 1107, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363139, 0, 0);
INSERT INTO `wiki_revision` VALUES (1108, 1108, 1108, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363139, 0, 0);
INSERT INTO `wiki_revision` VALUES (1109, 1109, 1109, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363139, 0, 0);
INSERT INTO `wiki_revision` VALUES (1110, 1110, 1110, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363139, 0, 0);
INSERT INTO `wiki_revision` VALUES (1111, 1111, 1111, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363139, 0, 0);
INSERT INTO `wiki_revision` VALUES (1112, 1112, 1112, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363139, 0, 0);
INSERT INTO `wiki_revision` VALUES (1113, 1113, 1113, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363139, 0, 0);
INSERT INTO `wiki_revision` VALUES (1114, 1114, 1114, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363139, 0, 0);
INSERT INTO `wiki_revision` VALUES (1115, 1115, 1115, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363139, 0, 0);
INSERT INTO `wiki_revision` VALUES (1116, 1116, 1116, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363139, 0, 0);
INSERT INTO `wiki_revision` VALUES (1117, 1117, 1117, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363139, 0, 0);
INSERT INTO `wiki_revision` VALUES (1118, 1118, 1118, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363139, 0, 0);
INSERT INTO `wiki_revision` VALUES (1119, 1119, 1119, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363139, 0, 0);
INSERT INTO `wiki_revision` VALUES (1120, 1120, 1120, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363139, 0, 0);
INSERT INTO `wiki_revision` VALUES (1121, 1121, 1121, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363139, 0, 0);
INSERT INTO `wiki_revision` VALUES (1122, 1122, 1122, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363139, 0, 0);
INSERT INTO `wiki_revision` VALUES (1123, 1123, 1123, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363139, 0, 0);
INSERT INTO `wiki_revision` VALUES (1124, 1124, 1124, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363230, 0, 0);
INSERT INTO `wiki_revision` VALUES (1125, 1125, 1125, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363230, 0, 0);
INSERT INTO `wiki_revision` VALUES (1126, 1126, 1126, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363230, 0, 0);
INSERT INTO `wiki_revision` VALUES (1127, 1127, 1127, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363230, 0, 0);
INSERT INTO `wiki_revision` VALUES (1128, 1128, 1128, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363230, 0, 0);
INSERT INTO `wiki_revision` VALUES (1129, 1129, 1129, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363230, 0, 0);
INSERT INTO `wiki_revision` VALUES (1130, 1130, 1130, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363230, 0, 0);
INSERT INTO `wiki_revision` VALUES (1131, 1131, 1131, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363230, 0, 0);
INSERT INTO `wiki_revision` VALUES (1132, 1132, 1132, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363230, 0, 0);
INSERT INTO `wiki_revision` VALUES (1133, 1133, 1133, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363230, 0, 0);
INSERT INTO `wiki_revision` VALUES (1134, 1134, 1134, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363230, 0, 0);
INSERT INTO `wiki_revision` VALUES (1135, 1135, 1135, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363230, 0, 0);
INSERT INTO `wiki_revision` VALUES (1136, 1136, 1136, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363230, 0, 0);
INSERT INTO `wiki_revision` VALUES (1137, 1137, 1137, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363230, 0, 0);
INSERT INTO `wiki_revision` VALUES (1138, 1138, 1138, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363230, 0, 0);
INSERT INTO `wiki_revision` VALUES (1139, 1139, 1139, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363230, 0, 0);
INSERT INTO `wiki_revision` VALUES (1140, 1140, 1140, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363230, 0, 0);
INSERT INTO `wiki_revision` VALUES (1141, 1141, 1141, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363230, 0, 0);
INSERT INTO `wiki_revision` VALUES (1142, 1142, 1142, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363230, 0, 0);
INSERT INTO `wiki_revision` VALUES (1143, 1143, 1143, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363230, 0, 0);
INSERT INTO `wiki_revision` VALUES (1144, 1144, 1144, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363230, 0, 0);
INSERT INTO `wiki_revision` VALUES (1145, 1145, 1145, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363230, 0, 0);
INSERT INTO `wiki_revision` VALUES (1146, 1146, 1146, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363230, 0, 0);
INSERT INTO `wiki_revision` VALUES (1147, 1147, 1147, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363230, 0, 0);
INSERT INTO `wiki_revision` VALUES (1148, 1148, 1148, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363230, 0, 0);
INSERT INTO `wiki_revision` VALUES (1149, 1149, 1149, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363230, 0, 0);
INSERT INTO `wiki_revision` VALUES (1150, 1150, 1150, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363230, 0, 0);
INSERT INTO `wiki_revision` VALUES (1151, 1151, 1151, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363230, 0, 0);
INSERT INTO `wiki_revision` VALUES (1152, 1152, 1152, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363230, 0, 0);
INSERT INTO `wiki_revision` VALUES (1153, 1153, 1153, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363230, 0, 0);
INSERT INTO `wiki_revision` VALUES (1154, 1154, 1154, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363230, 0, 0);
INSERT INTO `wiki_revision` VALUES (1155, 1155, 1155, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363230, 0, 0);
INSERT INTO `wiki_revision` VALUES (1156, 1156, 1156, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363230, 0, 0);
INSERT INTO `wiki_revision` VALUES (1157, 1157, 1157, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363230, 0, 0);
INSERT INTO `wiki_revision` VALUES (1158, 1158, 1158, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363230, 0, 0);
INSERT INTO `wiki_revision` VALUES (1159, 1159, 1159, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363230, 0, 0);
INSERT INTO `wiki_revision` VALUES (1160, 1160, 1160, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363230, 0, 0);
INSERT INTO `wiki_revision` VALUES (1161, 1161, 1161, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363230, 0, 0);
INSERT INTO `wiki_revision` VALUES (1162, 1162, 1162, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363230, 0, 0);
INSERT INTO `wiki_revision` VALUES (1163, 1163, 1163, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363230, 0, 0);
INSERT INTO `wiki_revision` VALUES (1164, 1164, 1164, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363230, 0, 0);
INSERT INTO `wiki_revision` VALUES (1165, 1165, 1165, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363230, 0, 0);
INSERT INTO `wiki_revision` VALUES (1166, 1166, 1166, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363230, 0, 0);
INSERT INTO `wiki_revision` VALUES (1167, 1167, 1167, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363230, 0, 0);
INSERT INTO `wiki_revision` VALUES (1168, 1168, 1168, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363230, 0, 0);
INSERT INTO `wiki_revision` VALUES (1169, 1169, 1169, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363230, 0, 0);
INSERT INTO `wiki_revision` VALUES (1170, 1170, 1170, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363230, 0, 0);
INSERT INTO `wiki_revision` VALUES (1171, 1171, 1171, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363230, 0, 0);
INSERT INTO `wiki_revision` VALUES (1172, 1172, 1172, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363230, 0, 0);
INSERT INTO `wiki_revision` VALUES (1173, 1173, 1173, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363230, 0, 0);
INSERT INTO `wiki_revision` VALUES (1174, 1174, 1174, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363230, 0, 0);
INSERT INTO `wiki_revision` VALUES (1175, 1175, 1175, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363230, 0, 0);
INSERT INTO `wiki_revision` VALUES (1176, 1176, 1176, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363230, 0, 0);
INSERT INTO `wiki_revision` VALUES (1177, 1177, 1177, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363230, 0, 0);
INSERT INTO `wiki_revision` VALUES (1178, 1178, 1178, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363230, 0, 0);
INSERT INTO `wiki_revision` VALUES (1179, 1179, 1179, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363230, 0, 0);
INSERT INTO `wiki_revision` VALUES (1180, 1180, 1180, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363230, 0, 0);
INSERT INTO `wiki_revision` VALUES (1181, 1181, 1181, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363230, 0, 0);
INSERT INTO `wiki_revision` VALUES (1182, 1182, 1182, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363230, 0, 0);
INSERT INTO `wiki_revision` VALUES (1183, 1183, 1183, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363230, 0, 0);
INSERT INTO `wiki_revision` VALUES (1184, 1184, 1184, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363230, 0, 0);
INSERT INTO `wiki_revision` VALUES (1185, 1185, 1185, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363230, 0, 0);
INSERT INTO `wiki_revision` VALUES (1186, 1186, 1186, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363230, 0, 0);
INSERT INTO `wiki_revision` VALUES (1187, 1187, 1187, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363230, 0, 0);
INSERT INTO `wiki_revision` VALUES (1188, 1188, 1188, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363230, 0, 0);
INSERT INTO `wiki_revision` VALUES (1189, 1189, 1189, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363230, 0, 0);
INSERT INTO `wiki_revision` VALUES (1190, 1190, 1190, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363230, 0, 0);
INSERT INTO `wiki_revision` VALUES (1191, 1191, 1191, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363230, 0, 0);
INSERT INTO `wiki_revision` VALUES (1192, 1192, 1192, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363230, 0, 0);
INSERT INTO `wiki_revision` VALUES (1193, 1193, 1193, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363230, 0, 0);
INSERT INTO `wiki_revision` VALUES (1194, 1194, 1194, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363230, 0, 0);
INSERT INTO `wiki_revision` VALUES (1195, 1195, 1195, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363230, 0, 0);
INSERT INTO `wiki_revision` VALUES (1196, 1196, 1196, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363230, 0, 0);
INSERT INTO `wiki_revision` VALUES (1197, 1197, 1197, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363230, 0, 0);
INSERT INTO `wiki_revision` VALUES (1198, 1198, 1198, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363230, 0, 0);
INSERT INTO `wiki_revision` VALUES (1199, 1199, 1199, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363230, 0, 0);
INSERT INTO `wiki_revision` VALUES (1200, 1200, 1200, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363230, 0, 0);
INSERT INTO `wiki_revision` VALUES (1201, 1201, 1201, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363230, 0, 0);
INSERT INTO `wiki_revision` VALUES (1202, 1202, 1202, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363230, 0, 0);
INSERT INTO `wiki_revision` VALUES (1203, 1203, 1203, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363231, 0, 0);
INSERT INTO `wiki_revision` VALUES (1204, 1204, 1204, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363231, 0, 0);
INSERT INTO `wiki_revision` VALUES (1205, 1205, 1205, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363231, 0, 0);
INSERT INTO `wiki_revision` VALUES (1206, 1206, 1206, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363231, 0, 0);
INSERT INTO `wiki_revision` VALUES (1207, 1207, 1207, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363231, 0, 0);
INSERT INTO `wiki_revision` VALUES (1208, 1208, 1208, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363231, 0, 0);
INSERT INTO `wiki_revision` VALUES (1209, 1209, 1209, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363231, 0, 0);
INSERT INTO `wiki_revision` VALUES (1210, 1210, 1210, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363231, 0, 0);
INSERT INTO `wiki_revision` VALUES (1211, 1211, 1211, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363231, 0, 0);
INSERT INTO `wiki_revision` VALUES (1212, 1212, 1212, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363231, 0, 0);
INSERT INTO `wiki_revision` VALUES (1213, 1213, 1213, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363231, 0, 0);
INSERT INTO `wiki_revision` VALUES (1214, 1214, 1214, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363231, 0, 0);
INSERT INTO `wiki_revision` VALUES (1215, 1215, 1215, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363231, 0, 0);
INSERT INTO `wiki_revision` VALUES (1216, 1216, 1216, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363231, 0, 0);
INSERT INTO `wiki_revision` VALUES (1217, 1217, 1217, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363231, 0, 0);
INSERT INTO `wiki_revision` VALUES (1218, 1218, 1218, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363231, 0, 0);
INSERT INTO `wiki_revision` VALUES (1219, 1219, 1219, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363231, 0, 0);
INSERT INTO `wiki_revision` VALUES (1220, 1220, 1220, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363231, 0, 0);
INSERT INTO `wiki_revision` VALUES (1221, 1221, 1221, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363231, 0, 0);
INSERT INTO `wiki_revision` VALUES (1222, 1222, 1222, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363231, 0, 0);
INSERT INTO `wiki_revision` VALUES (1223, 1223, 1223, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363231, 0, 0);
INSERT INTO `wiki_revision` VALUES (1224, 1224, 1224, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363231, 0, 0);
INSERT INTO `wiki_revision` VALUES (1225, 1225, 1225, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363231, 0, 0);
INSERT INTO `wiki_revision` VALUES (1226, 1226, 1226, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363231, 0, 0);
INSERT INTO `wiki_revision` VALUES (1227, 1227, 1227, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363231, 0, 0);
INSERT INTO `wiki_revision` VALUES (1228, 1228, 1228, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363231, 0, 0);
INSERT INTO `wiki_revision` VALUES (1229, 1229, 1229, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363231, 0, 0);
INSERT INTO `wiki_revision` VALUES (1230, 1230, 1230, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363231, 0, 0);
INSERT INTO `wiki_revision` VALUES (1231, 1231, 1231, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363231, 0, 0);
INSERT INTO `wiki_revision` VALUES (1232, 1232, 1232, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363231, 0, 0);
INSERT INTO `wiki_revision` VALUES (1233, 1233, 1233, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363231, 0, 0);
INSERT INTO `wiki_revision` VALUES (1234, 1234, 1234, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363231, 0, 0);
INSERT INTO `wiki_revision` VALUES (1235, 1235, 1235, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363231, 0, 0);
INSERT INTO `wiki_revision` VALUES (1236, 1236, 1236, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363231, 0, 0);
INSERT INTO `wiki_revision` VALUES (1237, 1237, 1237, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363231, 0, 0);
INSERT INTO `wiki_revision` VALUES (1238, 1238, 1238, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363231, 0, 0);
INSERT INTO `wiki_revision` VALUES (1239, 1239, 1239, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363231, 0, 0);
INSERT INTO `wiki_revision` VALUES (1240, 1240, 1240, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363231, 0, 0);
INSERT INTO `wiki_revision` VALUES (1241, 1241, 1241, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363231, 0, 0);
INSERT INTO `wiki_revision` VALUES (1242, 1242, 1242, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363231, 0, 0);
INSERT INTO `wiki_revision` VALUES (1243, 1243, 1243, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363231, 0, 0);
INSERT INTO `wiki_revision` VALUES (1244, 1244, 1244, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363231, 0, 0);
INSERT INTO `wiki_revision` VALUES (1245, 1245, 1245, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363231, 0, 0);
INSERT INTO `wiki_revision` VALUES (1246, 1246, 1246, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363231, 0, 0);
INSERT INTO `wiki_revision` VALUES (1247, 1247, 1247, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363231, 0, 0);
INSERT INTO `wiki_revision` VALUES (1248, 1248, 1248, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363231, 0, 0);
INSERT INTO `wiki_revision` VALUES (1249, 1249, 1249, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363231, 0, 0);
INSERT INTO `wiki_revision` VALUES (1250, 1250, 1250, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363231, 0, 0);
INSERT INTO `wiki_revision` VALUES (1251, 1251, 1251, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363231, 0, 0);
INSERT INTO `wiki_revision` VALUES (1252, 1252, 1252, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363231, 0, 0);
INSERT INTO `wiki_revision` VALUES (1253, 1253, 1253, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363231, 0, 0);
INSERT INTO `wiki_revision` VALUES (1254, 1254, 1254, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363231, 0, 0);
INSERT INTO `wiki_revision` VALUES (1255, 1255, 1255, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363231, 0, 0);
INSERT INTO `wiki_revision` VALUES (1256, 1256, 1256, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363231, 0, 0);
INSERT INTO `wiki_revision` VALUES (1257, 1257, 1257, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363231, 0, 0);
INSERT INTO `wiki_revision` VALUES (1258, 1258, 1258, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363231, 0, 0);
INSERT INTO `wiki_revision` VALUES (1259, 1259, 1259, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363231, 0, 0);
INSERT INTO `wiki_revision` VALUES (1260, 1260, 1260, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363231, 0, 0);
INSERT INTO `wiki_revision` VALUES (1261, 1261, 1261, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363231, 0, 0);
INSERT INTO `wiki_revision` VALUES (1262, 1262, 1262, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363231, 0, 0);
INSERT INTO `wiki_revision` VALUES (1263, 1263, 1263, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363231, 0, 0);
INSERT INTO `wiki_revision` VALUES (1264, 1264, 1264, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363231, 0, 0);
INSERT INTO `wiki_revision` VALUES (1265, 1265, 1265, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363231, 0, 0);
INSERT INTO `wiki_revision` VALUES (1266, 1266, 1266, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363231, 0, 0);
INSERT INTO `wiki_revision` VALUES (1267, 1267, 1267, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363231, 0, 0);
INSERT INTO `wiki_revision` VALUES (1268, 1268, 1268, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363231, 0, 0);
INSERT INTO `wiki_revision` VALUES (1269, 1269, 1269, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363231, 0, 0);
INSERT INTO `wiki_revision` VALUES (1270, 1270, 1270, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363231, 0, 0);
INSERT INTO `wiki_revision` VALUES (1271, 1271, 1271, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363231, 0, 0);
INSERT INTO `wiki_revision` VALUES (1272, 1272, 1272, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363231, 0, 0);
INSERT INTO `wiki_revision` VALUES (1273, 1273, 1273, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363231, 0, 0);
INSERT INTO `wiki_revision` VALUES (1274, 1274, 1274, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363231, 0, 0);
INSERT INTO `wiki_revision` VALUES (1275, 1275, 1275, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363231, 0, 0);
INSERT INTO `wiki_revision` VALUES (1276, 1276, 1276, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363231, 0, 0);
INSERT INTO `wiki_revision` VALUES (1277, 1277, 1277, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363231, 0, 0);
INSERT INTO `wiki_revision` VALUES (1278, 1278, 1278, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363231, 0, 0);
INSERT INTO `wiki_revision` VALUES (1279, 1279, 1279, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363231, 0, 0);
INSERT INTO `wiki_revision` VALUES (1280, 1280, 1280, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363231, 0, 0);
INSERT INTO `wiki_revision` VALUES (1281, 1281, 1281, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363231, 0, 0);
INSERT INTO `wiki_revision` VALUES (1282, 1282, 1282, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363231, 0, 0);
INSERT INTO `wiki_revision` VALUES (1283, 1283, 1283, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363231, 0, 0);
INSERT INTO `wiki_revision` VALUES (1284, 1284, 1284, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363232, 0, 0);
INSERT INTO `wiki_revision` VALUES (1285, 1285, 1285, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363232, 0, 0);
INSERT INTO `wiki_revision` VALUES (1286, 1286, 1286, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363232, 0, 0);
INSERT INTO `wiki_revision` VALUES (1287, 1287, 1287, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363232, 0, 0);
INSERT INTO `wiki_revision` VALUES (1288, 1288, 1288, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363232, 0, 0);
INSERT INTO `wiki_revision` VALUES (1289, 1289, 1289, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363232, 0, 0);
INSERT INTO `wiki_revision` VALUES (1290, 1290, 1290, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363232, 0, 0);
INSERT INTO `wiki_revision` VALUES (1291, 1291, 1291, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363232, 0, 0);
INSERT INTO `wiki_revision` VALUES (1292, 1292, 1292, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363232, 0, 0);
INSERT INTO `wiki_revision` VALUES (1293, 1293, 1293, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363232, 0, 0);
INSERT INTO `wiki_revision` VALUES (1294, 1294, 1294, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363232, 0, 0);
INSERT INTO `wiki_revision` VALUES (1295, 1295, 1295, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363232, 0, 0);
INSERT INTO `wiki_revision` VALUES (1296, 1296, 1296, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363232, 0, 0);
INSERT INTO `wiki_revision` VALUES (1297, 1297, 1297, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363232, 0, 0);
INSERT INTO `wiki_revision` VALUES (1298, 1298, 1298, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363232, 0, 0);
INSERT INTO `wiki_revision` VALUES (1299, 1299, 1299, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363232, 0, 0);
INSERT INTO `wiki_revision` VALUES (1300, 1300, 1300, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363232, 0, 0);
INSERT INTO `wiki_revision` VALUES (1301, 1301, 1301, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363232, 0, 0);
INSERT INTO `wiki_revision` VALUES (1302, 1302, 1302, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363232, 0, 0);
INSERT INTO `wiki_revision` VALUES (1303, 1303, 1303, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363232, 0, 0);
INSERT INTO `wiki_revision` VALUES (1304, 1304, 1304, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363232, 0, 0);
INSERT INTO `wiki_revision` VALUES (1305, 1305, 1305, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363232, 0, 0);
INSERT INTO `wiki_revision` VALUES (1306, 1306, 1306, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363232, 0, 0);
INSERT INTO `wiki_revision` VALUES (1307, 1307, 1307, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363232, 0, 0);
INSERT INTO `wiki_revision` VALUES (1308, 1308, 1308, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363232, 0, 0);
INSERT INTO `wiki_revision` VALUES (1309, 1309, 1309, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363232, 0, 0);
INSERT INTO `wiki_revision` VALUES (1310, 1310, 1310, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363232, 0, 0);
INSERT INTO `wiki_revision` VALUES (1311, 1311, 1311, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363232, 0, 0);
INSERT INTO `wiki_revision` VALUES (1312, 1312, 1312, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363232, 0, 0);
INSERT INTO `wiki_revision` VALUES (1313, 1313, 1313, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363232, 0, 0);
INSERT INTO `wiki_revision` VALUES (1314, 1314, 1314, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363232, 0, 0);
INSERT INTO `wiki_revision` VALUES (1315, 1315, 1315, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363232, 0, 0);
INSERT INTO `wiki_revision` VALUES (1316, 1316, 1316, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363232, 0, 0);
INSERT INTO `wiki_revision` VALUES (1317, 1317, 1317, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363232, 0, 0);
INSERT INTO `wiki_revision` VALUES (1318, 1318, 1318, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363232, 0, 0);
INSERT INTO `wiki_revision` VALUES (1319, 1319, 1319, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363232, 0, 0);
INSERT INTO `wiki_revision` VALUES (1320, 1320, 1320, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363232, 0, 0);
INSERT INTO `wiki_revision` VALUES (1321, 1321, 1321, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363232, 0, 0);
INSERT INTO `wiki_revision` VALUES (1322, 1322, 1322, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363232, 0, 0);
INSERT INTO `wiki_revision` VALUES (1323, 1323, 1323, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363232, 0, 0);
INSERT INTO `wiki_revision` VALUES (1324, 1324, 1324, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363232, 0, 0);
INSERT INTO `wiki_revision` VALUES (1325, 1325, 1325, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363232, 0, 0);
INSERT INTO `wiki_revision` VALUES (1326, 1326, 1326, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363232, 0, 0);
INSERT INTO `wiki_revision` VALUES (1327, 1327, 1327, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363232, 0, 0);
INSERT INTO `wiki_revision` VALUES (1328, 1328, 1328, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363232, 0, 0);
INSERT INTO `wiki_revision` VALUES (1329, 1329, 1329, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363232, 0, 0);
INSERT INTO `wiki_revision` VALUES (1330, 1330, 1330, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363232, 0, 0);
INSERT INTO `wiki_revision` VALUES (1331, 1331, 1331, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363232, 0, 0);
INSERT INTO `wiki_revision` VALUES (1332, 1332, 1332, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363232, 0, 0);
INSERT INTO `wiki_revision` VALUES (1333, 1333, 1333, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363232, 0, 0);
INSERT INTO `wiki_revision` VALUES (1334, 1334, 1334, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363232, 0, 0);
INSERT INTO `wiki_revision` VALUES (1335, 1335, 1335, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363232, 0, 0);
INSERT INTO `wiki_revision` VALUES (1336, 1336, 1336, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363232, 0, 0);
INSERT INTO `wiki_revision` VALUES (1337, 1337, 1337, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363232, 0, 0);
INSERT INTO `wiki_revision` VALUES (1338, 1338, 1338, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363232, 0, 0);
INSERT INTO `wiki_revision` VALUES (1339, 1339, 1339, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363232, 0, 0);
INSERT INTO `wiki_revision` VALUES (1340, 1340, 1340, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363232, 0, 0);
INSERT INTO `wiki_revision` VALUES (1341, 1341, 1341, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363232, 0, 0);
INSERT INTO `wiki_revision` VALUES (1342, 1342, 1342, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363232, 0, 0);
INSERT INTO `wiki_revision` VALUES (1343, 1343, 1343, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363232, 0, 0);
INSERT INTO `wiki_revision` VALUES (1344, 1344, 1344, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363232, 0, 0);
INSERT INTO `wiki_revision` VALUES (1345, 1345, 1345, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363232, 0, 0);
INSERT INTO `wiki_revision` VALUES (1346, 1346, 1346, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363232, 0, 0);
INSERT INTO `wiki_revision` VALUES (1347, 1347, 1347, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363232, 0, 0);
INSERT INTO `wiki_revision` VALUES (1348, 1348, 1348, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363232, 0, 0);
INSERT INTO `wiki_revision` VALUES (1349, 1349, 1349, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363232, 0, 0);
INSERT INTO `wiki_revision` VALUES (1350, 1350, 1350, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363232, 0, 0);
INSERT INTO `wiki_revision` VALUES (1351, 1351, 1351, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363232, 0, 0);
INSERT INTO `wiki_revision` VALUES (1352, 1352, 1352, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363232, 0, 0);
INSERT INTO `wiki_revision` VALUES (1353, 1353, 1353, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363232, 0, 0);
INSERT INTO `wiki_revision` VALUES (1354, 1354, 1354, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363232, 0, 0);
INSERT INTO `wiki_revision` VALUES (1355, 1355, 1355, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363232, 0, 0);
INSERT INTO `wiki_revision` VALUES (1356, 1356, 1356, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363232, 0, 0);
INSERT INTO `wiki_revision` VALUES (1357, 1357, 1357, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363232, 0, 0);
INSERT INTO `wiki_revision` VALUES (1358, 1358, 1358, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363232, 0, 0);
INSERT INTO `wiki_revision` VALUES (1359, 1359, 1359, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363232, 0, 0);
INSERT INTO `wiki_revision` VALUES (1360, 1360, 1360, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363232, 0, 0);
INSERT INTO `wiki_revision` VALUES (1361, 1361, 1361, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363232, 0, 0);
INSERT INTO `wiki_revision` VALUES (1362, 1362, 1362, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363232, 0, 0);
INSERT INTO `wiki_revision` VALUES (1363, 1363, 1363, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363232, 0, 0);
INSERT INTO `wiki_revision` VALUES (1364, 1364, 1364, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363233, 0, 0);
INSERT INTO `wiki_revision` VALUES (1365, 1365, 1365, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363233, 0, 0);
INSERT INTO `wiki_revision` VALUES (1366, 1366, 1366, '', 0, 0x4d6564696157696b692064656661756c74, 0x3230303730313331323030363233, 0, 0);

-- --------------------------------------------------------

-- 
-- Table structure for table `wiki_searchindex`
-- 

CREATE TABLE `wiki_searchindex` (
  `si_page` int(8) unsigned NOT NULL default '0',
  `si_title` varchar(255) NOT NULL default '',
  `si_text` mediumtext NOT NULL,
  UNIQUE KEY `si_page` (`si_page`),
  FULLTEXT KEY `si_title` (`si_title`),
  FULLTEXT KEY `si_text` (`si_text`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `wiki_searchindex`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `wiki_site_stats`
-- 

CREATE TABLE `wiki_site_stats` (
  `ss_row_id` int(8) unsigned NOT NULL default '0',
  `ss_total_views` bigint(20) unsigned default '0',
  `ss_total_edits` bigint(20) unsigned default '0',
  `ss_good_articles` bigint(20) unsigned default '0',
  `ss_total_pages` bigint(20) default '-1',
  `ss_users` bigint(20) default '-1',
  `ss_admins` int(10) default '-1',
  `ss_images` int(10) default '0',
  UNIQUE KEY `ss_row_id` (`ss_row_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `wiki_site_stats`
-- 

INSERT INTO `wiki_site_stats` VALUES (1, 4, 0, 0, 1366, 2, -1, 0);

-- --------------------------------------------------------

-- 
-- Table structure for table `wiki_templatelinks`
-- 

CREATE TABLE `wiki_templatelinks` (
  `tl_from` int(8) unsigned NOT NULL default '0',
  `tl_namespace` int(11) NOT NULL default '0',
  `tl_title` varchar(255) character set latin1 collate latin1_bin NOT NULL default '',
  UNIQUE KEY `tl_from` (`tl_from`,`tl_namespace`,`tl_title`),
  KEY `tl_namespace` (`tl_namespace`,`tl_title`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `wiki_templatelinks`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `wiki_text`
-- 

CREATE TABLE `wiki_text` (
  `old_id` int(8) unsigned NOT NULL auto_increment,
  `old_text` mediumblob NOT NULL,
  `old_flags` tinyblob NOT NULL,
  PRIMARY KEY  (`old_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1367 ;

-- 
-- Dumping data for table `wiki_text`
-- 

INSERT INTO `wiki_text` VALUES (1, 0x3c6269673e2727274d6564696157696b6920686173206265656e207375636365737366756c6c7920696e7374616c6c65642e2727273c2f6269673e0a0a436f6e73756c7420746865205b687474703a2f2f6d6574612e77696b6970656469612e6f72672f77696b692f4d6564696157696b695f55736572253237735f4775696465205573657227732047756964655d20666f7220696e666f726d6174696f6e206f6e207573696e67207468652077696b6920736f6674776172652e0a0a3d3d2047657474696e672073746172746564203d3d0a0a2a205b687474703a2f2f7777772e6d6564696177696b692e6f72672f77696b692f48656c703a436f6e66696775726174696f6e5f73657474696e677320436f6e66696775726174696f6e2073657474696e6773206c6973745d0a2a205b687474703a2f2f7777772e6d6564696177696b692e6f72672f77696b692f48656c703a464151204d6564696157696b69204641515d0a2a205b687474703a2f2f6d61696c2e77696b6970656469612e6f72672f6d61696c6d616e2f6c697374696e666f2f6d6564696177696b692d616e6e6f756e6365204d6564696157696b692072656c65617365206d61696c696e67206c6973745d, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (2, 0x5b5b24315d5d206d6f76656420746f205b5b24325d5d, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (3, 0x5b5b24315d5d206d6f76656420746f205b5b24325d5d206f766572207265646972656374, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (4, 0x2f2a206564697420746869732066696c6520746f20637573746f6d697a6520746865206d6f6e6f626f6f6b20736b696e20666f722074686520656e746972652073697465202a2f, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (5, 0x2f2a20746f6f6c7469707320616e6420616363657373206b657973202a2f0a7461203d206e6577204f626a65637428293b0a74615b2770742d7573657270616765275d203d206e657720417272617928272e272c274d792075736572207061676527293b0a74615b2770742d616e6f6e7573657270616765275d203d206e657720417272617928272e272c275468652075736572207061676520666f722074686520697020796f755c2772652065646974696e6720617327293b0a74615b2770742d6d7974616c6b275d203d206e657720417272617928276e272c274d792074616c6b207061676527293b0a74615b2770742d616e6f6e74616c6b275d203d206e657720417272617928276e272c2744697363757373696f6e2061626f75742065646974732066726f6d2074686973206970206164647265737327293b0a74615b2770742d707265666572656e636573275d203d206e65772041727261792827272c274d7920707265666572656e63657327293b0a74615b2770742d77617463686c697374275d203d206e657720417272617928276c272c27546865206c697374206f6620706167657320796f755c277265206d6f6e69746f72696e6720666f72206368616e6765732e27293b0a74615b2770742d6d79636f6e74726973275d203d206e6577204172726179282779272c274c697374206f66206d7920636f6e747269627574696f6e7327293b0a74615b2770742d6c6f67696e275d203d206e657720417272617928276f272c27596f752061726520656e636f75726167656420746f206c6f6720696e2c206974206973206e6f74206d616e6461746f727920686f77657665722e27293b0a74615b2770742d616e6f6e6c6f67696e275d203d206e657720417272617928276f272c27596f752061726520656e636f75726167656420746f206c6f6720696e2c206974206973206e6f74206d616e6461746f727920686f77657665722e27293b0a74615b2770742d6c6f676f7574275d203d206e657720417272617928276f272c274c6f67206f757427293b0a74615b2763612d74616c6b275d203d206e6577204172726179282774272c2744697363757373696f6e2061626f75742074686520636f6e74656e74207061676527293b0a74615b2763612d65646974275d203d206e6577204172726179282765272c27596f752063616e2065646974207468697320706167652e20506c656173652075736520746865207072657669657720627574746f6e206265666f726520736176696e672e27293b0a74615b2763612d61646473656374696f6e275d203d206e657720417272617928272b272c27416464206120636f6d6d656e7420746f20746869732064697363757373696f6e2e27293b0a74615b2763612d76696577736f75726365275d203d206e6577204172726179282765272c275468697320706167652069732070726f7465637465642e20596f752063616e20766965772069747320736f757263652e27293b0a74615b2763612d686973746f7279275d203d206e6577204172726179282768272c27506173742076657273696f6e73206f66207468697320706167652e27293b0a74615b2763612d70726f74656374275d203d206e657720417272617928273d272c2750726f746563742074686973207061676527293b0a74615b2763612d64656c657465275d203d206e6577204172726179282764272c2744656c6574652074686973207061676527293b0a74615b2763612d756e64656c657465275d203d206e6577204172726179282764272c27526573746f72652074686520656469747320646f6e6520746f20746869732070616765206265666f7265206974207761732064656c6574656427293b0a74615b2763612d6d6f7665275d203d206e657720417272617928276d272c274d6f76652074686973207061676527293b0a74615b2763612d7761746368275d203d206e6577204172726179282777272c274164642074686973207061676520746f20796f75722077617463686c69737427293b0a74615b2763612d756e7761746368275d203d206e6577204172726179282777272c2752656d6f7665207468697320706167652066726f6d20796f75722077617463686c69737427293b0a74615b27736561726368275d203d206e6577204172726179282766272c2753656172636820746869732077696b6927293b0a74615b27702d6c6f676f275d203d206e65772041727261792827272c274d61696e205061676527293b0a74615b276e2d6d61696e70616765275d203d206e657720417272617928277a272c27566973697420746865204d61696e205061676527293b0a74615b276e2d706f7274616c275d203d206e65772041727261792827272c2741626f7574207468652070726f6a6563742c207768617420796f752063616e20646f2c20776865726520746f2066696e64207468696e677327293b0a74615b276e2d63757272656e746576656e7473275d203d206e65772041727261792827272c2746696e64206261636b67726f756e6420696e666f726d6174696f6e206f6e2063757272656e74206576656e747327293b0a74615b276e2d726563656e746368616e676573275d203d206e6577204172726179282772272c27546865206c697374206f6620726563656e74206368616e67657320696e207468652077696b692e27293b0a74615b276e2d72616e646f6d70616765275d203d206e6577204172726179282778272c274c6f616420612072616e646f6d207061676527293b0a74615b276e2d68656c70275d203d206e65772041727261792827272c2754686520706c61636520746f2066696e64206f75742e27293b0a74615b276e2d73697465737570706f7274275d203d206e65772041727261792827272c27537570706f727420757327293b0a74615b27742d776861746c696e6b7368657265275d203d206e657720417272617928276a272c274c697374206f6620616c6c2077696b692070616765732074686174206c696e6b206865726527293b0a74615b27742d726563656e746368616e6765736c696e6b6564275d203d206e657720417272617928276b272c27526563656e74206368616e67657320696e207061676573206c696e6b65642066726f6d2074686973207061676527293b0a74615b27666565642d727373275d203d206e65772041727261792827272c27525353206665656420666f722074686973207061676527293b0a74615b27666565642d61746f6d275d203d206e65772041727261792827272c2741746f6d206665656420666f722074686973207061676527293b0a74615b27742d636f6e747269627574696f6e73275d203d206e65772041727261792827272c275669657720746865206c697374206f6620636f6e747269627574696f6e73206f662074686973207573657227293b0a74615b27742d656d61696c75736572275d203d206e65772041727261792827272c2753656e642061206d61696c20746f2074686973207573657227293b0a74615b27742d75706c6f6164275d203d206e6577204172726179282775272c2755706c6f616420696d61676573206f72206d656469612066696c657327293b0a74615b27742d7370656369616c7061676573275d203d206e6577204172726179282771272c274c697374206f6620616c6c207370656369616c20706167657327293b0a74615b2763612d6e737461622d6d61696e275d203d206e6577204172726179282763272c27566965772074686520636f6e74656e74207061676527293b0a74615b2763612d6e737461622d75736572275d203d206e6577204172726179282763272c2756696577207468652075736572207061676527293b0a74615b2763612d6e737461622d6d65646961275d203d206e6577204172726179282763272c275669657720746865206d65646961207061676527293b0a74615b2763612d6e737461622d7370656369616c275d203d206e65772041727261792827272c27546869732069732061207370656369616c20706167652c20796f752063616e5c2774206564697420746865207061676520697473656c662e27293b0a74615b2763612d6e737461622d7770275d203d206e6577204172726179282761272c2756696577207468652070726f6a656374207061676527293b0a74615b2763612d6e737461622d696d616765275d203d206e6577204172726179282763272c27566965772074686520696d616765207061676527293b0a74615b2763612d6e737461622d6d6564696177696b69275d203d206e6577204172726179282763272c2756696577207468652073797374656d206d65737361676527293b0a74615b2763612d6e737461622d74656d706c617465275d203d206e6577204172726179282763272c2756696577207468652074656d706c61746527293b0a74615b2763612d6e737461622d68656c70275d203d206e6577204172726179282763272c2756696577207468652068656c70207061676527293b0a74615b2763612d6e737461622d63617465676f7279275d203d206e6577204172726179282763272c2756696577207468652063617465676f7279207061676527293b, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (6, 0x41626f7574, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (7, 0x50726f6a6563743a41626f7574, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (8, 0x41626f7574207b7b534954454e414d457d7d, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (9, 0x76, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (10, 0x76, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (11, 0x69, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (12, 0x70, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (13, 0x73, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (14, 0x66, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (15, 0x5468652070617373776f726420666f72202224312220686173206265656e2073656e7420746f2024322e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (16, 0x50617373776f72642073656e742e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (17, 0x536f7272792c20796f75206861766520616c72656164792063726561746564202431206163636f756e74732e20596f752063616e2774206d616b6520616e79206d6f72652e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (18, 0x416374696f6e20636f6d706c657465, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (19, 0x416464656420746f2077617463686c697374, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (20, 0x546865207061676520225b5b3a24315d5d2220686173206265656e20616464656420746f20796f7572205b5b5370656369616c3a57617463686c6973747c77617463686c6973745d5d2e0a467574757265206368616e67657320746f2074686973207061676520616e6420697473206173736f6369617465642054616c6b20706167652077696c6c206265206c69737465642074686572652c0a616e642074686520706167652077696c6c2061707065617220272727626f6c64656427272720696e20746865205b5b5370656369616c3a526563656e746368616e6765737c6c697374206f6620726563656e74206368616e6765735d5d20746f0a6d616b652069742065617369657220746f207069636b206f75742e0a0a3c703e496620796f752077616e7420746f2072656d6f76652074686520706167652066726f6d20796f75722077617463686c697374206c617465722c20636c69636b2022556e77617463682220696e2074686520736964656261722e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (21, 0x4164642047726f7570, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (22, 0x41646465642067726f7570202432, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (23, 0x2b, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (24, 0x50726f6a6563743a41646d696e6973747261746f7273, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (25, 0x416c6c2061727469636c6573, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (26, 0x416c6c20706167657320282431206e616d65737061636529, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (27, 0x436f6d62696e656420646973706c6179206f662075706c6f61642c2064656c6574696f6e2c2070726f74656374696f6e2c20626c6f636b696e672c20616e64207379736f70206c6f67732e0a596f752063616e206e6172726f7720646f776e2074686520766965772062792073656c656374696e672061206c6f6720747970652c207468652075736572206e616d652c206f722074686520616666656374656420706167652e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (28, 0x53797374656d206d65737361676573, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (29, 0x43757272656e742074657874, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (30, 0x44656661756c742074657874, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (31, 0x4d657373616765206e616d652066696c7465723a, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (32, 0x53686f77206f6e6c79206d6f646966696564, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (33, 0x4e616d65, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (34, 0x5370656369616c3a416c6c6d657373616765732063616e6e6f742062652075736564206265636175736520776755736544617461626173654d65737361676573206973206f66662e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (35, 0x596f75722063757272656e7420696e74657266616365206c616e6775616765203c623e24313c2f623e206973206e6f7420737570706f72746564206279205370656369616c3a416c6c6d65737361676573206174207468697320736974652e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (36, 0x546869732069732061206c697374206f662073797374656d206d6573736167657320617661696c61626c6520696e20746865204d6564696157696b693a206e616d6573706163652e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (37, 0x416c6c206e6f6e2d61727469636c6573, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (38, 0x416c6c20706167657320286e6f7420696e202431206e616d65737061636529, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (39, 0x456e61626c6520652d6d61696c2066726f6d206f74686572207573657273, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (40, 0x416c6c207061676573, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (41, 0x446973706c6179207061676573207374617274696e672061743a, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (42, 0x4e657874, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (43, 0x446973706c61792070616765732077697468207072656669783a, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (44, 0x50726576696f7573, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (45, 0x476f, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (46, 0x243120746f202432, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (47, 0x54686973207573657220697320616c726561647920612062757265617563726174, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (48, 0x54686973207573657220697320616c726561647920612073746577617264, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (49, 0x54686973207573657220697320616c726561647920616e2061646d696e6973747261746f72, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (50, 0x3c7374726f6e673e557365722024312c20796f752061726520616c7265616479206c6f6767656420696e213c2f7374726f6e673e3c6272202f3e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (51, 0x43616e6e6f7420726f6c6c6261636b206c6173742065646974206f66205b5b24315d5d0a6279205b5b557365723a24327c24325d5d20285b5b557365722074616c6b3a24327c54616c6b5d5d293b20736f6d656f6e6520656c73652068617320656469746564206f7220726f6c6c6564206261636b20746865207061676520616c72656164792e0a0a4c617374206564697420776173206279205b5b557365723a24337c24335d5d20285b5b557365722074616c6b3a24337c54616c6b5d5d292e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (52, 0x4f6c64657374207061676573, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (53, 0x616e64, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (54, 0x596f7520617265206e6f74206c6f6767656420696e2e20596f757220495020616464726573732077696c6c206265207265636f7264656420696e207468697320706167652773206564697420686973746f72792e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (55, 0x2d, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (56, 0x54616c6b20666f722074686973204950, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (57, 0x2d2d2d2d272754686973206973207468652064697363757373696f6e207061676520666f7220616e20616e6f6e796d6f757320757365722077686f20686173206e6f74206372656174656420616e206163636f756e7420796574206f722077686f20646f6573206e6f74207573652069742e205765207468657265666f7265206861766520746f2075736520746865206e756d65726963616c205b5b495020616464726573735d5d20746f206964656e746966792068696d2f6865722e205375636820616e20495020616464726573732063616e20626520736861726564206279207365766572616c2075736572732e20496620796f752061726520616e20616e6f6e796d6f7573207573657220616e64206665656c207468617420697272656c6576616e7420636f6d6d656e74732068617665206265656e20646972656374656420617420796f752c20706c65617365205b5b5370656369616c3a557365726c6f67696e7c63726561746520616e206163636f756e74206f72206c6f6720696e5d5d20746f2061766f69642066757475726520636f6e667573696f6e2077697468206f7468657220616e6f6e796d6f75732075736572732e2727, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (58, 0x416e6f6e796d6f75732075736572287329206f66207b7b534954454e414d457d7d, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (59, 0x417072, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (60, 0x417072696c, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (61, 0x436f6e74656e742070616765, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (62, 0x412070616765206f662074686174206e616d6520616c7265616479206578697374732c206f72207468650a6e616d6520796f7520686176652063686f73656e206973206e6f742076616c69642e0a506c656173652063686f6f736520616e6f74686572206e616d652e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (63, 0x5669657720636f6e74656e742070616765, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (64, 0x41727469636c6573207374617274696e67207769746820272724312727, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (65, 0x417567, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (66, 0x417567757374, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (67, 0x4175746f626c6f636b6564206265636175736520796f7572204950206164647265737320686173206265656e20726563656e746c79207573656420627920225b5b557365723a24317c24315d5d222e2054686520726561736f6e20676976656e20666f72202431277320626c6f636b2069733a2022272727243227272722, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (68, 0x5065726d697373696f6e206572726f72, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (69, 0x54686520616374696f6e20796f75206861766520726571756573746564206973206c696d697465640a746f2075736572732077697468207468652022243222207065726d697373696f6e2061737369676e65642e0a5365652024312e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (70, 0x5468697320616374696f6e2063616e6e6f7420626520706572666f726d6564206f6e207468697320706167652e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (71, 0x46696c65206e616d6520686173206265656e206368616e67656420746f20222431222e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (72, 0x222e243122206973206e6f742061207265636f6d6d656e64656420696d6167652066696c6520666f726d61742e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (73, 0x496e76616c69642049502061646472657373, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (74, 0x4261646c7920666f726d656420736561726368207175657279, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (75, 0x576520636f756c64206e6f742070726f6365737320796f75722071756572792e0a546869732069732070726f6261626c79206265636175736520796f75206861766520617474656d7074656420746f2073656172636820666f7220610a776f7264206665776572207468616e207468726565206c657474657273206c6f6e672c207768696368206973206e6f742079657420737570706f727465642e0a497420636f756c6420616c736f206265207468617420796f752068617665206d69737479706564207468652065787072657373696f6e2c20666f720a6578616d706c6520226669736820616e6420616e64207363616c6573222e0a506c656173652074727920616e6f746865722071756572792e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (76, 0x5468652070617373776f72647320796f7520656e746572656420646f206e6f74206d617463682e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (77, 0x496e76616c696420726177207369676e61747572653b20636865636b2048544d4c20746167732e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (78, 0x426164207469746c65, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (79, 0x546865207265717565737465642070616765207469746c652077617320696e76616c69642c20656d7074792c206f7220616e20696e636f72726563746c79206c696e6b656420696e7465722d6c616e6775616765206f7220696e7465722d77696b69207469746c652e204974206d617920636f6e7461696e206f6e65206d6f726520636861726163746572732077686963682063616e6e6f74206265207573656420696e207469746c65732e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (80, 0x284d61696e29, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (81, 0x596f75722075736572206e616d65206f72204950206164647265737320686173206265656e20626c6f636b65642062792024312e0a54686520726561736f6e20676976656e20697320746869733a3c6272202f3e2727243227273c703e596f75206d617920636f6e74616374202431206f72206f6e65206f6620746865206f746865720a5b5b50726f6a6563743a41646d696e6973747261746f72737c61646d696e6973747261746f72735d5d20746f20646973637573732074686520626c6f636b2e0a0a4e6f7465207468617420796f75206d6179206e6f7420757365207468652022652d6d61696c2074686973207573657222206665617475726520756e6c65737320796f75206861766520612076616c696420652d6d61696c2061646472657373207265676973746572656420696e20796f7572205b5b5370656369616c3a507265666572656e6365737c7573657220707265666572656e6365735d5d2e0a0a596f757220495020616464726573732069732024332e20506c6561736520696e636c7564652074686973206164647265737320696e20616e79207175657269657320796f75206d616b652e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (82, 0x5573657220697320626c6f636b6564, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (83, 0x426c6f636b2075736572, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (84, 0x426c6f636b20737563636565646564, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (85, 0x5b5b7b7b6e733a5370656369616c7d7d3a436f6e747269627574696f6e732f24317c24315d5d20686173206265656e20626c6f636b65642e0a3c6272202f3e536565205b5b7b7b6e733a5370656369616c7d7d3a4970626c6f636b6c6973747c495020626c6f636b206c6973745d5d20746f2072657669657720626c6f636b732e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (86, 0x5573652074686520666f726d2062656c6f7720746f20626c6f636b207772697465206163636573730a66726f6d20612073706563696669632049502061646472657373206f7220757365726e616d652e0a546869732073686f756c6420626520646f6e65206f6e6c79206f6e6c7920746f2070726576656e742076616e64616c69736d2c20616e6420696e0a6163636f7264616e63652077697468205b5b50726f6a6563743a506f6c6963797c706f6c6963795d5d2e0a46696c6c20696e206120737065636966696320726561736f6e2062656c6f772028666f72206578616d706c652c20636974696e6720706172746963756c61720a7061676573207468617420776572652076616e64616c697a6564292e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (87, 0x626c6f636b, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (88, 0x24312c20243220626c6f636b65642024332028243429, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (89, 0x626c6f636b656420225b5b24315d5d22207769746820616e206578706972792074696d65206f66202432, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (90, 0x426c6f636b5f6c6f67, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (91, 0x546869732069732061206c6f67206f66207573657220626c6f636b696e6720616e6420756e626c6f636b696e6720616374696f6e732e204175746f6d61746963616c6c790a626c6f636b65642049502061646472657373657320617265206e6f74206c69737465642e2053656520746865205b5b5370656369616c3a4970626c6f636b6c6973747c495020626c6f636b206c6973745d5d20666f720a746865206c697374206f662063757272656e746c79206f7065726174696f6e616c2062616e7320616e6420626c6f636b732e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (92, 0x426f6c642074657874, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (93, 0x426f6c642074657874, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (94, 0x426f6f6b20736f7572636573, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (95, 0x42656c6f772069732061206c697374206f66206c696e6b7320746f206f7468657220736974657320746861740a73656c6c206e657720616e64207573656420626f6f6b732c20616e64206d617920616c736f2068617665206675727468657220696e666f726d6174696f6e0a61626f757420626f6f6b7320796f7520617265206c6f6f6b696e6720666f722e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (96, 0x42726f6b656e20726564697265637473, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (97, 0x54686520666f6c6c6f77696e6720726564697265637473206c696e6b20746f206e6f6e2d6578697374656e742070616765733a, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (98, 0x427567207265706f727473, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (99, 0x50726f6a6563743a4275675f7265706f727473, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (100, 0x427572656175637261745f6c6f67, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (101, 0x4368616e6765642067726f7570206d656d6265727368697020666f722024312066726f6d20243220746f202433, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (102, 0x62792064617465, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (103, 0x6279206e616d65, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (104, 0x62792073697a65, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (105, 0x54686520666f6c6c6f77696e6720697320612063616368656420636f7079206f66207468652072657175657374656420706167652c20616e64206d6179206e6f7420626520757020746f20646174652e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (106, 0x43616e63656c, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (107, 0x436f756c64206e6f742064656c657465207468652070616765206f722066696c65207370656369666965642e20284974206d6179206861766520616c7265616479206265656e2064656c6574656420627920736f6d656f6e6520656c73652e29, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (108, 0x43616e6e6f742072657665727420656469743b206c61737420636f6e7472696275746f72206973206f6e6c7920617574686f72206f66207468697320706167652e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (109, 0x43617465676f72696573, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (110, 0x43617465676f7279, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (111, 0x54686520666f6c6c6f77696e672063617465676f7269657320657869737420696e207468652077696b692e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (112, 0x63617465676f7279, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (113, 0x41727469636c657320696e2063617465676f72792022243122, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (114, 0x5468657265206172652024312061727469636c657320696e20746869732063617465676f72792e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (115, 0x54686572652069732024312061727469636c6520696e20746869732063617465676f72792e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (116, 0x7c, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (117, 0x6368616e676564, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (118, 0x4368616e6765642067726f7570202432, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (119, 0x4368616e67652070617373776f7264, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (120, 0x6368616e676573, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (121, 0x2727274e6f74653a27272720416674657220736176696e672c20796f75206d6179206861766520746f2062797061737320796f75722062726f77736572277320636163686520746f2073656520746865206368616e6765732e202727274d6f7a696c6c61202f2046697265666f78202f205361666172693a27272720686f6c6420646f776e20272753686966742727207768696c6520636c69636b696e6720272752656c6f616427272c206f722070726573732027274374726c2d53686966742d52272720282727436d642d53686966742d522727206f6e204170706c65204d6163293b2027272749453a27272720686f6c642027274374726c2727207768696c6520636c69636b696e672027275265667265736827272c206f722070726573732027274374726c2d463527273b202727274b6f6e717565726f723a2727273a2073696d706c7920636c69636b2074686520272752656c6f6164272720627574746f6e2c206f72207072657373202727463527273b202727274f70657261272727207573657273206d6179206e65656420746f20636f6d706c6574656c7920636c65617220746865697220636163686520696e202727546f6f6c7326726172723b507265666572656e63657327272e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (122, 0x436f6c756d6e733a, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (123, 0x436f6d706172652073656c65637465642076657273696f6e73, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (124, 0x436f6e6669726d, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (125, 0x436c65617220746865206361636865206f66207468697320706167653f0a0a2431, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (126, 0x4f4b, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (127, 0x436f6e6669726d2064656c657465, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (128, 0x596f75206172652061626f757420746f207065726d616e656e746c792064656c657465206120706167650a6f7220696d61676520616c6f6e67207769746820616c6c206f662069747320686973746f72792066726f6d207468652064617461626173652e0a506c6561736520636f6e6669726d207468617420796f7520696e74656e6420746f20646f20746869732c207468617420796f7520756e6465727374616e64207468650a636f6e73657175656e6365732c20616e64207468617420796f752061726520646f696e67207468697320696e206163636f7264616e636520776974680a5b5b50726f6a6563743a506f6c6963795d5d2e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (129, 0x596f75206d75737420636f6e6669726d20796f757220652d6d61696c2061646472657373206265666f72652065646974696e672070616765732e20506c656173652073657420616e642076616c696461746520796f757220652d6d61696c2061646472657373207468726f75676820796f7572205b5b5370656369616c3a507265666572656e6365737c7573657220707265666572656e6365735d5d2e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (130, 0x452d6d61696c20636f6e6669726d6174696f6e20726571756972656420746f2065646974, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (131, 0x436f6e6669726d20452d6d61696c2061646472657373, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (132, 0x536f6d656f6e652c2070726f6261626c7920796f752066726f6d20495020616464726573732024312c20686173207265676973746572656420616e0a6163636f756e7420222432222077697468207468697320652d6d61696c2061646472657373206f6e207b7b534954454e414d457d7d2e0a0a546f20636f6e6669726d20746861742074686973206163636f756e74207265616c6c7920646f65732062656c6f6e6720746f20796f7520616e642061637469766174650a652d6d61696c206665617475726573206f6e207b7b534954454e414d457d7d2c206f70656e2074686973206c696e6b20696e20796f75722062726f777365723a0a0a24330a0a49662074686973206973202a6e6f742a20796f752c20646f6e277420666f6c6c6f7720746865206c696e6b2e205468697320636f6e6669726d6174696f6e20636f64650a77696c6c206578706972652061742024342e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (133, 0x536f6d657468696e672077656e742077726f6e6720736176696e6720796f757220636f6e6669726d6174696f6e2e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (134, 0x496e76616c696420636f6e6669726d6174696f6e20636f64652e2054686520636f6465206d6179206861766520657870697265642e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (135, 0x596f757220652d6d61696c206164647265737320686173206e6f77206265656e20636f6e6669726d65642e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (136, 0x4d61696c206120636f6e6669726d6174696f6e20636f6465, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (137, 0x436f756c64206e6f742073656e6420636f6e6669726d6174696f6e206d61696c2e20436865636b206164647265737320666f7220696e76616c696420636861726163746572732e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (138, 0x436f6e6669726d6174696f6e20652d6d61696c2073656e742e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (139, 0x7b7b534954454e414d457d7d20652d6d61696c206164647265737320636f6e6669726d6174696f6e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (140, 0x596f757220652d6d61696c206164647265737320686173206265656e20636f6e6669726d65642e20596f75206d6179206e6f77206c6f6720696e20616e6420656e6a6f79207468652077696b692e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (141, 0x546869732077696b69207265717569726573207468617420796f752076616c696461746520796f757220652d6d61696c20616464726573730a6265666f7265207573696e6720652d6d61696c2066656174757265732e2041637469766174652074686520627574746f6e2062656c6f7720746f2073656e64206120636f6e6669726d6174696f6e0a6d61696c20746f20796f757220616464726573732e20546865206d61696c2077696c6c20696e636c7564652061206c696e6b20636f6e7461696e696e67206120636f64653b206c6f6164207468650a6c696e6b20696e20796f75722062726f7773657220746f20636f6e6669726d207468617420796f757220652d6d61696c20616464726573732069732076616c69642e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (142, 0x436f6e6669726d2070726f74656374696f6e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (143, 0x446f20796f75207265616c6c792077616e7420746f2070726f74656374207468697320706167653f, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (144, 0x55736572205b5b557365723a24317c24315d5d20285b5b557365722074616c6b3a24317c74616c6b5d5d292064656c6574656420746869732061727469636c6520616674657220796f7520737461727465642065646974696e67207769746820726561736f6e3a0a3a202727243227270a506c6561736520636f6e6669726d2074686174207265616c6c792077616e7420746f20726563726561746520746869732061727469636c652e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (145, 0x436f6e6669726d20756e70726f74656374696f6e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (146, 0x446f20796f75207265616c6c792077616e7420746f20756e70726f74656374207468697320706167653f, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (147, 0x436f6e7465787420706572206c696e653a, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (148, 0x4c696e657320706572206869743a, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (149, 0x2431206d696e6f72206564697473, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (150, 0x636f6e7472696273, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (151, 0x466f72202431, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (152, 0x5573657220636f6e747269627574696f6e73, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (153, 0x436f6e74656e7420697320617661696c61626c6520756e6465722024312e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (154, 0x50726f6a6563743a436f7079726967687473, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (155, 0x7b7b534954454e414d457d7d20636f70797269676874, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (156, 0x506c65617365206e6f7465207468617420616c6c20636f6e747269627574696f6e7320746f207b7b534954454e414d457d7d2061726520636f6e7369646572656420746f2062652072656c656173656420756e64657220746865202432202873656520243120666f722064657461696c73292e20496620796f7520646f6e27742077616e7420796f75722077726974696e6720746f20626520656469746564206d657263696c6573736c7920616e6420726564697374726962757465642061742077696c6c2c207468656e20646f6e2774207375626d697420697420686572652e3c6272202f3e0a596f752061726520616c736f2070726f6d6973696e67207573207468617420796f752077726f7465207468697320796f757273656c662c206f7220636f706965642069742066726f6d2061207075626c696320646f6d61696e206f722073696d696c61722066726565207265736f757263652e0a3c7374726f6e673e444f204e4f54205355424d495420434f50595249474854454420574f524b20574954484f5554205045524d495353494f4e213c2f7374726f6e673e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (157, 0x506c65617365206e6f7465207468617420616c6c20636f6e747269627574696f6e7320746f207b7b534954454e414d457d7d206d6179206265206564697465642c20616c74657265642c206f722072656d6f766564206279206f7468657220636f6e7472696275746f72732e20496620796f7520646f6e27742077616e7420796f75722077726974696e6720746f20626520656469746564206d657263696c6573736c792c207468656e20646f6e2774207375626d697420697420686572652e3c6272202f3e0a596f752061726520616c736f2070726f6d6973696e67207573207468617420796f752077726f7465207468697320796f757273656c662c206f7220636f706965642069742066726f6d20610a7075626c696320646f6d61696e206f722073696d696c61722066726565207265736f75726365202873656520243120666f722064657461696c73292e0a3c7374726f6e673e444f204e4f54205355424d495420434f50595249474854454420574f524b20574954484f5554205045524d495353494f4e213c2f7374726f6e673e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (158, 0x436f756c646e27742072656d6f7665206974656d20272431272e2e2e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (159, 0x437265617465206163636f756e74, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (160, 0x627920652d6d61696c, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (161, 0x4372656174652061727469636c65, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (162, 0x63726561746564, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (163, 0x506167652063726564697473, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (164, 0x637572, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (165, 0x43757272656e74206576656e7473, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (166, 0x43757272656e74206576656e7473, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (167, 0x43757272656e74207265766973696f6e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (168, 0x766965772063757272656e74207265766973696f6e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (169, 0x44617461, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (170, 0x4461746162617365206572726f72, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (171, 0x4e6f20707265666572656e6365, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (172, 0x4461746520666f726d6174, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (173, 0x4461746520616e642074696d65, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (174, 0x412064617461626173652071756572792073796e746178206572726f7220686173206f636375727265642e0a54686973206d617920696e64696361746520612062756720696e2074686520736f6674776172652e0a546865206c61737420617474656d70746564206461746162617365207175657279207761733a0a3c626c6f636b71756f74653e3c74743e24313c2f74743e3c2f626c6f636b71756f74653e0a66726f6d2077697468696e2066756e6374696f6e20223c74743e24323c2f74743e222e0a4d7953514c2072657475726e6564206572726f7220223c74743e24333a2024343c2f74743e222e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (175, 0x412064617461626173652071756572792073796e746178206572726f7220686173206f636375727265642e0a546865206c61737420617474656d70746564206461746162617365207175657279207761733a0a222431220a66726f6d2077697468696e2066756e6374696f6e20222432222e0a4d7953514c2072657475726e6564206572726f72202224333a20243422, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (176, 0x446561642d656e64207061676573, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (177, 0x4465627567, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (178, 0x446563, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (179, 0x446563656d626572, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (180, 0x64656661756c74, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (181, 0x53656172636820696e207468657365206e616d657370616365732062792064656661756c743a, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (182, 0x7b7b534954454e414d457d7d20652d6d61696c, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (183, 0x44656c657465, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (184, 0x44656c65746520616e64206d6f7665, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (185, 0x5965732c2064656c657465207468652070616765, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (186, 0x44656c6574656420746f206d616b652077617920666f72206d6f7665, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (187, 0x3d3d44656c6574696f6e2072657175697265643d3d0a0a5468652064657374696e6174696f6e2061727469636c6520225b5b24315d5d2220616c7265616479206578697374732e20446f20796f752077616e7420746f2064656c65746520697420746f206d616b652077617920666f7220746865206d6f76653f, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (188, 0x526561736f6e20666f722064656c6574696f6e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (189, 0x64656c6574656420225b5b24315d5d22, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (190, 0x5b64656c657465645d, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (191, 0x44656c65746564206f6c64207265766973696f6e2024312e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (192, 0x2224312220686173206265656e2064656c657465642e0a53656520243220666f722061207265636f7264206f6620726563656e742064656c6574696f6e732e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (193, 0x5761726e696e673a2054686973207061676520686173206265656e2064656c6574656420616674657220796f7520737461727465642065646974696e6721, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (194, 0x64656c, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (195, 0x44656c65746520616c6c207265766973696f6e73206f6620746869732066696c65, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (196, 0x44656c6574652070616765, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (197, 0x2844656c6574696e67202224312229, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (198, 0x44656c65746520746869732070616765, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (199, 0x64656c6574696f6e206c6f67, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (200, 0x44656c6574696f6e5f6c6f67, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (201, 0x42656c6f772069732061206c697374206f6620746865206d6f737420726563656e742064656c6574696f6e732e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (202, 0x44657374696e6174696f6e2066696c656e616d65, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (203, 0x54686520616374696f6e20796f752068617665207265717565737465642063616e206f6e6c792062650a706572666f726d656420627920757365727320776974682022646576656c6f70657222206361706162696c6974792e0a5365652024312e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (204, 0x446576656c6f70657220616363657373207265717569726564, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (205, 0x64696666, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (206, 0x28446966666572656e6365206265747765656e207265766973696f6e7329, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (207, 0x446973616d626967756174696f6e207061676573, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (208, 0x54656d706c6174653a646973616d626967, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (209, 0x54686520666f6c6c6f77696e67207061676573206c696e6b20746f2061203c693e646973616d626967756174696f6e20706167653c2f693e2e20546865792073686f756c64206c696e6b20746f2074686520617070726f70726961746520746f70696320696e73746561642e3c6272202f3e412070616765206973207472656174656420617320646973616d626967756174696f6e206966206974206973206c696e6b65642066726f6d2024312e3c6272202f3e4c696e6b732066726f6d206f74686572206e616d6573706163657320617265203c693e6e6f743c2f693e206c697374656420686572652e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (210, 0x50726f6a6563743a47656e6572616c5f646973636c61696d6572, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (211, 0x446973636c61696d657273, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (212, 0x446f75626c6520726564697265637473, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (213, 0x4561636820726f7720636f6e7461696e73206c696e6b7320746f2074686520666972737420616e64207365636f6e642072656469726563742c2061732077656c6c20617320746865206669727374206c696e65206f6620746865207365636f6e6420726564697265637420746578742c20757375616c6c7920676976696e672074686520227265616c222074617267657420706167652c207768696368207468652066697273742072656469726563742073686f756c6420706f696e7420746f2e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (214, 0x646f776e6c6f6164, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (215, 0x4120636f6e6669726d6174696f6e20652d6d61696c20686173206265656e2073656e7420746f20746865206e6f6d696e6174656420652d6d61696c20616464726573732e0a4265666f726520616e79206f74686572206d61696c2069732073656e7420746f20746865206163636f756e742c20796f752077696c6c206861766520746f20666f6c6c6f772074686520696e737472756374696f6e7320696e2074686520652d6d61696c2c0a746f20636f6e6669726d207468617420746865206163636f756e742069732061637475616c6c7920796f7572732e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (216, 0x45646974, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (217, 0x4564697420746869732066696c65207573696e6720616e2065787465726e616c206170706c69636174696f6e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (218, 0x53656520746865205b687474703a2f2f6d6574612e77696b696d656469612e6f72672f77696b692f48656c703a45787465726e616c5f656469746f727320736574757020696e737472756374696f6e735d20666f72206d6f726520696e666f726d6174696f6e2e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (219, 0x546865206564697420636f6d6d656e74207761733a20223c693e24313c2f693e222e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (220, 0x4564697420636f6e666c6963743a202431, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (221, 0x45646974207468652063757272656e742076657273696f6e206f6620746869732070616765, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (222, 0x456469742047726f7570, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (223, 0x45646974696e672068656c70, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (224, 0x48656c703a45646974696e67, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (225, 0x45646974696e67202431, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (226, 0x45646974696e672024312028636f6d6d656e7429, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (227, 0x3c7374726f6e673e5741524e494e473a20596f75206172652065646974696e6720616e206f75742d6f662d646174650a7265766973696f6e206f66207468697320706167652e0a496620796f7520736176652069742c20616e79206368616e676573206d6164652073696e63652074686973207265766973696f6e2077696c6c206265206c6f73742e3c2f7374726f6e673e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (228, 0x45646974696e67202431202873656374696f6e29, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (229, 0x65646974, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (230, 0x456469742073656374696f6e3a202431, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (231, 0x4564697420746869732070616765, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (232, 0x3c212d2d205465787420686572652077696c6c2062652073686f776e2062656c6f77206564697420616e642075706c6f616420666f726d732e202d2d3e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (233, 0x4564697420557365722047726f757073, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (234, 0x452d6d61696c, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (235, 0x596f757220652d6d61696c2061646472657373207761732061757468656e74696361746564206f6e2024312e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (236, 0x436f6e6669726d20796f757220652d6d61696c2061646472657373, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (237, 0x3c646976207374796c653d2277696474683a3330656d223e2a204f7074696f6e616c2e20416e20652d6d61696c206c657473206f746865727320636f6e7461637420796f75206f6e2074686973207369746520776974686f75742072657665616c696e6720796f757220616464726573732c20616e64206c6574732075732073656e6420796f752061206e65772070617373776f726420696620796f7520666f726765742069742e3c6272202f3e3c6272202f3e596f7572207265616c206e616d652077696c6c206265207573656420746f206769766520796f75206174747269627574696f6e20666f7220796f757220776f726b2e3c2f6469763e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (238, 0x46726f6d, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (239, 0x4d657373616765, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (240, 0x596f757220652d6d61696c2061646472657373206973203c7374726f6e673e6e6f74207965742061757468656e746963617465643c2f7374726f6e673e2e204e6f20652d6d61696c0a77696c6c2062652073656e7420666f7220616e79206f662074686520666f6c6c6f77696e672066656174757265732e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (241, 0x452d6d61696c2075736572, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (242, 0x4966207468697320757365722068617320656e746572656420612076616c696420652d6d61696c206164647265737320696e0a686973206f7220686572207573657220707265666572656e6365732c2074686520666f726d2062656c6f772077696c6c2073656e6420612073696e676c65206d6573736167652e0a54686520652d6d61696c206164647265737320796f7520656e746572656420696e20796f7572207573657220707265666572656e6365732077696c6c206170706561720a617320746865202246726f6d222061646472657373206f6620746865206d61696c2c20736f2074686520726563697069656e742077696c6c2062652061626c650a746f207265706c792e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (243, 0x53656e64, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (244, 0x452d6d61696c2073656e74, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (245, 0x596f757220652d6d61696c206d65737361676520686173206265656e2073656e742e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (246, 0x5375626a656374, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (247, 0x546f, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (248, 0x452d6d61696c20746869732075736572, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (249, 0x5468652066696c6520796f752075706c6f61646564207365656d7320746f20626520656d7074792e2054686973206d696768742062652064756520746f2061207479706f20696e207468652066696c65206e616d652e20506c6561736520636865636b207768657468657220796f75207265616c6c792077616e7420746f2075706c6f616420746869732066696c652e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (250, 0x4465617220245741544348494e47555345524e414d452c0a0a746865207b7b534954454e414d457d7d20706167652024504147455449544c4520686173206265656e20244348414e4745444f5243524541544544206f6e2024504147454544495444415445206279202450414745454449544f522c207365652024504147455449544c455f55524c20666f72207468652063757272656e742076657273696f6e2e0a0a244e4557504147450a0a456469746f7227732073756d6d6172793a20245041474553554d4d4152592024504147454d494e4f52454449540a0a436f6e746163742074686520656469746f723a0a6d61696c3a202450414745454449544f525f454d41494c0a77696b693a202450414745454449544f525f57494b490a0a54686572652077696c6c206265206e6f206f74686572206e6f74696669636174696f6e7320696e2063617365206f662066757274686572206368616e67657320756e6c65737320796f75207669736974207468697320706167652e20596f7520636f756c6420616c736f20726573657420746865206e6f74696669636174696f6e20666c61677320666f7220616c6c20796f75722077617463686564207061676573206f6e20796f75722077617463686c6973742e0a0a20202020202020202020202020596f757220667269656e646c79207b7b534954454e414d457d7d206e6f74696669636174696f6e2073797374656d0a0a2d2d0a546f206368616e676520796f75722077617463686c6973742073657474696e67732c2076697369740a7b7b5345525645527d7d7b7b6c6f63616c75726c3a5370656369616c3a57617463686c6973742f656469747d7d0a0a466565646261636b20616e64206675727468657220617373697374616e63653a0a7b7b5345525645527d7d7b7b6c6f63616c75726c3a48656c703a436f6e74656e74737d7d, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (251, 0x53656520243120666f7220616c6c206368616e6765732073696e636520796f7572206c6173742076697369742e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (252, 0x7b7b534954454e414d457d7d204e6f74696669636174696f6e204d61696c6572, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (253, 0x546869732069732061206e657720706167652e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (254, 0x4d61726b20616c6c2070616765732076697369746564, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (255, 0x7b7b534954454e414d457d7d20706167652024504147455449544c4520686173206265656e20244348414e4745444f5243524541544544206279202450414745454449544f52, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (256, 0x456e746572206120726561736f6e20666f7220746865206c6f636b2c20696e636c7564696e6720616e20657374696d6174650a6f66207768656e20746865206c6f636b2077696c6c2062652072656c6561736564, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (257, 0x4572726f72, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (258, 0x4572726f72, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (259, 0x636f6e74656e74206265666f726520626c616e6b696e67207761733a2027243127, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (260, 0x706167652077617320656d707479, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (261, 0x636f6e74656e74207761733a2027243127, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (262, 0x636f6e74656e74207761733a20272431272028616e6420746865206f6e6c7920636f6e7472696275746f7220776173202724322729, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (263, 0x4170657274757265, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (264, 0x417574686f72, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (265, 0x426974732070657220636f6d706f6e656e74, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (266, 0x4272696768746e657373, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (267, 0x434641207061747465726e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (268, 0x436f6c6f72207370616365, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (269, 0x73524742, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (270, 0x464646462e48, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (271, 0x4d65616e696e67206f66206561636820636f6d706f6e656e74, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (272, 0x646f6573206e6f74206578697374, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (273, 0x59, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (274, 0x4362, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (275, 0x4372, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (276, 0x52, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (277, 0x47, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (278, 0x42, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (279, 0x496d61676520636f6d7072657373696f6e206d6f6465, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (280, 0x436f6d7072657373696f6e20736368656d65, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (281, 0x556e636f6d70726573736564, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (282, 0x4a504547, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (283, 0x436f6e7472617374, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (284, 0x4e6f726d616c, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (285, 0x536f6674, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (286, 0x48617264, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (287, 0x436f7079726967687420686f6c646572, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (288, 0x437573746f6d20696d6167652070726f63657373696e67, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (289, 0x4e6f726d616c2070726f63657373, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (290, 0x437573746f6d2070726f63657373, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (291, 0x46696c65206368616e6765206461746520616e642074696d65, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (292, 0x4461746520616e642074696d65206f66206469676974697a696e67, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (293, 0x4461746520616e642074696d65206f6620646174612067656e65726174696f6e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (294, 0x4465766963652073657474696e6773206465736372697074696f6e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (295, 0x4469676974616c207a6f6f6d20726174696f, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (296, 0x457869662076657273696f6e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (297, 0x4578706f737572652062696173, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (298, 0x4578706f7375726520696e646578, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (299, 0x4578706f73757265206d6f6465, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (300, 0x4175746f206578706f73757265, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (301, 0x4d616e75616c206578706f73757265, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (302, 0x4175746f20627261636b6574, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (303, 0x4578706f737572652050726f6772616d, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (304, 0x4e6f7420646566696e6564, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (305, 0x4d616e75616c, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (306, 0x4e6f726d616c2070726f6772616d, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (307, 0x4170657274757265207072696f72697479, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (308, 0x53687574746572207072696f72697479, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (309, 0x43726561746976652070726f6772616d202862696173656420746f77617264206465707468206f66206669656c6429, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (310, 0x416374696f6e2070726f6772616d202862696173656420746f776172642066617374207368757474657220737065656429, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (311, 0x506f727472616974206d6f64652028666f7220636c6f736575702070686f746f73207769746820746865206261636b67726f756e64206f7574206f6620666f63757329, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (312, 0x4c616e647363617065206d6f64652028666f72206c616e6473636170652070686f746f73207769746820746865206261636b67726f756e6420696e20666f63757329, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (313, 0x4578706f737572652074696d65, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (314, 0x2431207365632028243229, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (315, 0x46696c6520736f75726365, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (316, 0x445343, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (317, 0x466c617368, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (318, 0x466c61736820656e65726779, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (319, 0x537570706f7274656420466c6173687069782076657273696f6e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (320, 0x46204e756d626572, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (321, 0x662f2431, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (322, 0x4c656e7320666f63616c206c656e677468, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (323, 0x2431206d6d, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (324, 0x466f63616c206c656e67746820696e203335206d6d2066696c6d, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (325, 0x466f63616c20706c616e65207265736f6c7574696f6e20756e6974, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (326, 0x696e63686573, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (327, 0x466f63616c20706c616e652058207265736f6c7574696f6e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (328, 0x466f63616c20706c616e652059207265736f6c7574696f6e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (329, 0x5363656e6520636f6e74726f6c, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (330, 0x4e6f6e65, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (331, 0x4c6f77206761696e207570, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (332, 0x48696768206761696e207570, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (333, 0x4c6f77206761696e20646f776e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (334, 0x48696768206761696e20646f776e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (335, 0x416c746974756465, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (336, 0x416c746974756465207265666572656e6365, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (337, 0x4e616d65206f66204750532061726561, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (338, 0x4750532064617465, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (339, 0x42656172696e67206f662064657374696e6174696f6e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (340, 0x5265666572656e636520666f722062656172696e67206f662064657374696e6174696f6e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (341, 0x44697374616e636520746f2064657374696e6174696f6e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (342, 0x5265666572656e636520666f722064697374616e636520746f2064657374696e6174696f6e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (343, 0x4c617469747564652064657374696e6174696f6e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (344, 0x5265666572656e636520666f72206c61746974756465206f662064657374696e6174696f6e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (345, 0x4c6f6e676974756465206f662064657374696e6174696f6e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (346, 0x5265666572656e636520666f72206c6f6e676974756465206f662064657374696e6174696f6e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (347, 0x47505320646966666572656e7469616c20636f7272656374696f6e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (348, 0x4d61676e6574696320646972656374696f6e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (349, 0x5472756520646972656374696f6e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (350, 0x4d6561737572656d656e7420707265636973696f6e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (351, 0x446972656374696f6e206f6620696d616765, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (352, 0x5265666572656e636520666f7220646972656374696f6e206f6620696d616765, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (353, 0x4c61746974756465, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (354, 0x4e6f727468206c61746974756465, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (355, 0x536f757468206c61746974756465, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (356, 0x4e6f727468206f7220536f757468204c61746974756465, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (357, 0x4c6f6e676974756465, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (358, 0x45617374206c6f6e676974756465, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (359, 0x57657374206c6f6e676974756465, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (360, 0x45617374206f722057657374204c6f6e676974756465, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (361, 0x47656f64657469632073757276657920646174612075736564, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (362, 0x4d6561737572656d656e74206d6f6465, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (363, 0x322d64696d656e73696f6e616c206d6561737572656d656e74, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (364, 0x332d64696d656e73696f6e616c206d6561737572656d656e74, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (365, 0x4e616d65206f66204750532070726f63657373696e67206d6574686f64, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (366, 0x536174656c6c69746573207573656420666f72206d6561737572656d656e74, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (367, 0x5370656564206f6620475053207265636569766572, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (368, 0x4b696c6f6d65747265732070657220686f7572, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (369, 0x4d696c65732070657220686f7572, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (370, 0x4b6e6f7473, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (371, 0x537065656420756e6974, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (372, 0x526563656976657220737461747573, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (373, 0x4d6561737572656d656e7420696e2070726f6772657373, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (374, 0x4d6561737572656d656e7420696e7465726f7065726162696c697479, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (375, 0x4750532074696d65202861746f6d696320636c6f636b29, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (376, 0x446972656374696f6e206f66206d6f76656d656e74, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (377, 0x5265666572656e636520666f7220646972656374696f6e206f66206d6f76656d656e74, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (378, 0x475053207461672076657273696f6e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (379, 0x496d616765207469746c65, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (380, 0x486569676874, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (381, 0x556e6971756520696d616765204944, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (382, 0x5769647468, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (383, 0x49534f20737065656420726174696e67, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (384, 0x4f666673657420746f204a50454720534f49, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (385, 0x4279746573206f66204a5045472064617461, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (386, 0x4c6967687420736f75726365, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (387, 0x556e6b6e6f776e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (388, 0x4461796c69676874, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (389, 0x436c6f7564792077656174686572, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (390, 0x5368616465, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (391, 0x4461796c6967687420666c756f72657363656e74202844203537303020e2809320373130304b29, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (392, 0x44617920776869746520666c756f72657363656e7420284e203436303020e2809320353430304b29, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (393, 0x436f6f6c20776869746520666c756f72657363656e74202857203339303020e2809320343530304b29, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (394, 0x576869746520666c756f72657363656e7420285757203332303020e2809320333730304b29, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (395, 0x5374616e64617264206c696768742041, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (396, 0x5374616e64617264206c696768742042, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (397, 0x5374616e64617264206c696768742043, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (398, 0x466c756f72657363656e74, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (399, 0x443535, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (400, 0x443635, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (401, 0x443735, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (402, 0x443530, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (403, 0x49534f2073747564696f2074756e677374656e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (404, 0x4f74686572206c6967687420736f75726365, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (405, 0x54756e677374656e2028696e63616e64657363656e74206c6967687429, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (406, 0x466c617368, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (407, 0x46696e652077656174686572, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (408, 0x43616d657261206d616e756661637475726572, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (409, 0x2431, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (410, 0x4d616e756661637475726572206e6f746573, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (411, 0x4d6178696d756d206c616e64206170657274757265, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (412, 0x4d65746572696e67206d6f6465, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (413, 0x556e6b6e6f776e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (414, 0x41766572616765, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (415, 0x43656e746572576569676874656441766572616765, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (416, 0x4f74686572, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (417, 0x53706f74, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (418, 0x4d756c746953706f74, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (419, 0x5061747465726e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (420, 0x5061727469616c, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (421, 0x43616d657261206d6f64656c, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (422, 0x2431, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (423, 0x4f70746f656c656374726f6e696320636f6e76657273696f6e20666163746f72, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (424, 0x4f7269656e746174696f6e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (425, 0x4e6f726d616c, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (426, 0x466c697070656420686f72697a6f6e74616c6c79, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (427, 0x526f746174656420313830c2b0, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (428, 0x466c697070656420766572746963616c6c79, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (429, 0x526f7461746564203930c2b02043435720616e6420666c697070656420766572746963616c6c79, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (430, 0x526f7461746564203930c2b0204357, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (431, 0x526f7461746564203930c2b020435720616e6420666c697070656420766572746963616c6c79, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (432, 0x526f7461746564203930c2b020434357, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (433, 0x506978656c20636f6d706f736974696f6e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (434, 0x524742, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (435, 0x5943624372, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (436, 0x56616c696e6420696d61676520686569676874, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (437, 0x56616c696420696d616765207769647468, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (438, 0x4461746120617272616e67656d656e74, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (439, 0x6368756e6b7920666f726d6174, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (440, 0x706c616e617220666f726d6174, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (441, 0x4368726f6d617469636974696573206f66207072696d61726974696573, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (442, 0x50616972206f6620626c61636b20616e64207768697465207265666572656e63652076616c756573, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (443, 0x52656c6174656420617564696f2066696c65, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (444, 0x556e6974206f66205820616e642059207265736f6c7574696f6e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (445, 0x4e756d626572206f6620726f777320706572207374726970, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (446, 0x4e756d626572206f6620636f6d706f6e656e7473, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (447, 0x53617475726174696f6e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (448, 0x4e6f726d616c, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (449, 0x4c6f772073617475726174696f6e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (450, 0x486967682073617475726174696f6e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (451, 0x5363656e6520636170747572652074797065, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (452, 0x5374616e64617264, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (453, 0x4c616e647363617065, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (454, 0x506f727472616974, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (455, 0x4e69676874207363656e65, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (456, 0x5363656e652074797065, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (457, 0x41206469726563746c792070686f746f6772617068656420696d616765, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (458, 0x53656e73696e67206d6574686f64, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (459, 0x556e646566696e6564, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (460, 0x4f6e652d6368697020636f6c6f7220617265612073656e736f72, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (461, 0x54776f2d6368697020636f6c6f7220617265612073656e736f72, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (462, 0x54687265652d6368697020636f6c6f7220617265612073656e736f72, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (463, 0x436f6c6f722073657175656e7469616c20617265612073656e736f72, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (464, 0x5472696c696e6561722073656e736f72, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (465, 0x436f6c6f722073657175656e7469616c206c696e6561722073656e736f72, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (466, 0x53686172706e657373, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (467, 0x4e6f726d616c, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (468, 0x536f6674, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (469, 0x48617264, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (470, 0x53687574746572207370656564, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (471, 0x536f6674776172652075736564, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (472, 0x2431, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (473, 0x5370617469616c206672657175656e637920726573706f6e7365, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (474, 0x537065637472616c2073656e7369746976697479, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (475, 0x42797465732070657220636f6d70726573736564207374726970, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (476, 0x496d6167652064617461206c6f636174696f6e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (477, 0x5375626a6563742061726561, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (478, 0x5375626a6563742064697374616e6365, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (479, 0x2431206d6574726573, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (480, 0x5375626a6563742064697374616e63652072616e6765, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (481, 0x556e6b6e6f776e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (482, 0x4d6163726f, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (483, 0x436c6f73652076696577, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (484, 0x44697374616e742076696577, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (485, 0x5375626a656374206c6f636174696f6e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (486, 0x4461746554696d65207375627365636f6e6473, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (487, 0x4461746554696d654469676974697a6564207375627365636f6e6473, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (488, 0x4461746554696d654f726967696e616c207375627365636f6e6473, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (489, 0x5472616e736665722066756e6374696f6e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (490, 0x5573657220636f6d6d656e7473, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (491, 0x57686974652042616c616e6365, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (492, 0x4175746f2077686974652062616c616e6365, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (493, 0x4d616e75616c2077686974652062616c616e6365, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (494, 0x576869746520706f696e74206368726f6d61746963697479, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (495, 0x486f72697a6f6e74616c207265736f6c7574696f6e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (496, 0x243120647063, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (497, 0x243120647069, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (498, 0x436f6c6f72207370616365207472616e73666f726d6174696f6e206d617472697820636f656666696369656e7473, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (499, 0x5920616e64204320706f736974696f6e696e67, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (500, 0x53756273616d706c696e6720726174696f206f66205920746f2043, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (501, 0x566572746963616c207265736f6c7574696f6e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (502, 0x65787069726573202431, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (503, 0x536f6d656f6e6520656c736520686173206368616e676564207468697320706167652073696e636520796f7520737461727465642065646974696e672069742e0a5468652075707065722074657874206172656120636f6e7461696e7320746865207061676520746578742061732069742063757272656e746c79206578697374732e0a596f7572206368616e676573206172652073686f776e20696e20746865206c6f776572207465787420617265612e0a596f752077696c6c206861766520746f206d6572676520796f7572206368616e67657320696e746f20746865206578697374696e6720746578742e0a3c623e4f6e6c793c2f623e20746865207465787420696e20746865207570706572207465787420617265612077696c6c206265207361766564207768656e20796f750a70726573732022536176652070616765222e3c6272202f3e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (504, 0x4578706f7274207061676573, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (505, 0x496e636c756465206f6e6c79207468652063757272656e74207265766973696f6e2c206e6f74207468652066756c6c20686973746f7279, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (506, 0x2d2d2d2d0a2727274e6f74653a272727206578706f7274696e67207468652066756c6c20686973746f7279206f66207061676573207468726f756768207468697320666f726d20686173206265656e2064697361626c65642064756520746f20706572666f726d616e636520726561736f6e732e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (507, 0x596f752063616e206578706f727420746865207465787420616e642065646974696e6720686973746f7279206f66206120706172746963756c61722070616765206f720a736574206f66207061676573207772617070656420696e20736f6d6520584d4c2e20546869732063616e20626520696d706f7274656420696e746f20616e6f746865722077696b69207573696e67204d6564696157696b690a76696120746865205370656369616c3a496d706f727420706167652e0a0a546f206578706f72742070616765732c20656e74657220746865207469746c657320696e20746865207465787420626f782062656c6f772c206f6e65207469746c6520706572206c696e652c20616e640a73656c656374207768657468657220796f752077616e74207468652063757272656e742076657273696f6e2061732077656c6c20617320616c6c206f6c642076657273696f6e732c20776974682074686520706167650a686973746f7279206c696e65732c206f72206a757374207468652063757272656e742076657273696f6e20776974682074686520696e666f2061626f757420746865206c61737420656469742e0a0a496e20746865206c6174746572206361736520796f752063616e20616c736f207573652061206c696e6b2c20652e672e205b5b7b7b6e733a5370656369616c7d7d3a4578706f72742f7b7b4d6564696177696b693a6d61696e706167657d7d5d5d20666f72207468652070616765207b7b4d6564696177696b693a6d61696e706167657d7d2e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (508, 0x5468657265207761732065697468657220616e2065787465726e616c2061757468656e7469636174696f6e206461746162617365206572726f72206f7220796f7520617265206e6f7420616c6c6f77656420746f2075706461746520796f75722065787465726e616c206163636f756e742e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (509, 0x687474703a2f2f7777772e6578616d706c652e636f6d206c696e6b207469746c65, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (510, 0x45787465726e616c206c696e6b202872656d656d62657220687474703a2f2f2070726566697829, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (511, 0x464151, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (512, 0x50726f6a6563743a464151, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (513, 0x466562, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (514, 0x4665627275617279, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (515, 0x466565643a, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (516, 0x436f756c64206e6f7420636f70792066696c65202224312220746f20222432222e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (517, 0x436f756c64206e6f742064656c6574652066696c6520222431222e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (518, 0x53756d6d617279, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (519, 0x412066696c6520776974682074686973206e616d652065786973747320616c72656164792c20706c6561736520636865636b20243120696620796f7520617265206e6f74207375726520696620796f752077616e7420746f206368616e67652069742e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (520, 0x412066696c6520776974682074686973206e616d652065786973747320616c72656164793b20706c6561736520676f206261636b20616e642075706c6f616420746869732066696c6520756e6465722061206e6577206e616d652e205b5b496d6167653a24317c7468756d627c63656e7465727c24315d5d, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (521, 0x412066696c6520776974682074686973206e616d652065786973747320616c726561647920696e20746865207368617265642066696c65207265706f7369746f72793b20706c6561736520676f206261636b20616e642075706c6f616420746869732066696c6520756e6465722061206e6577206e616d652e205b5b496d6167653a24317c7468756d627c63656e7465727c24315d5d, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (522, 0x24314b422c204d494d4520747970653a203c636f64653e24323c2f636f64653e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (523, 0x46696c65206d697373696e67, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (524, 0x46696c656e616d65, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (525, 0x436f756c64206e6f742066696e642066696c6520222431222e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (526, 0x436f756c64206e6f742072656e616d652066696c65202224312220746f20222432222e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (527, 0x46696c6573, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (528, 0x536f75726365, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (529, 0x436f7079726967687420737461747573, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (530, 0x46696c652024312075706c6f61646564207375636365737366756c6c792e0a506c6561736520666f6c6c6f772074686973206c696e6b3a20243220746f20746865206465736372697074696f6e207061676520616e642066696c6c0a696e20696e666f726d6174696f6e2061626f7574207468652066696c652c20737563682061732077686572652069742063616d652066726f6d2c207768656e206974207761730a6372656174656420616e642062792077686f6d2c20616e6420616e797468696e6720656c736520796f75206d6179206b6e6f772061626f75742069742e204966207468697320697320616e20696d6167652c20796f752063616e20696e73657274206974206c696b6520746869733a203c74743e3c6e6f77696b693e5b5b496d6167653a24317c7468756d627c4465736372697074696f6e5d5d3c2f6e6f77696b693e3c2f74743e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (531, 0x53756d6d6172793a, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (532, 0x4572726f723a20636f756c64206e6f74207375626d697420666f726d, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (533, 0x467269646179, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (534, 0x6665746368696e672066696c65206c697374, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (535, 0x476f, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (536, 0x0a3c666f726d206d6574686f643d226765742220616374696f6e3d22687474703a2f2f7777772e676f6f676c652e636f6d2f736561726368222069643d22676f6f676c65736561726368223e0a202020203c696e70757420747970653d2268696464656e22206e616d653d22646f6d61696e73222076616c75653d227b7b5345525645527d7d22202f3e0a202020203c696e70757420747970653d2268696464656e22206e616d653d226e756d222076616c75653d22353022202f3e0a202020203c696e70757420747970653d2268696464656e22206e616d653d226965222076616c75653d22243222202f3e0a202020203c696e70757420747970653d2268696464656e22206e616d653d226f65222076616c75653d22243222202f3e0a0a202020203c696e70757420747970653d227465787422206e616d653d2271222073697a653d22333122206d61786c656e6774683d22323535222076616c75653d22243122202f3e0a202020203c696e70757420747970653d227375626d697422206e616d653d2262746e47222076616c75653d22243322202f3e0a20203c6469763e0a202020203c696e70757420747970653d22726164696f22206e616d653d2273697465736561726368222069643d226777696b69222076616c75653d227b7b5345525645527d7d2220636865636b65643d22636865636b656422202f3e3c6c6162656c20666f723d226777696b69223e7b7b534954454e414d457d7d3c2f6c6162656c3e0a202020203c696e70757420747970653d22726164696f22206e616d653d2273697465736561726368222069643d2267575757222076616c75653d2222202f3e3c6c6162656c20666f723d2267575757223e5757573c2f6c6162656c3e0a20203c2f6469763e0a3c2f666f726d3e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (537, 0x416c726561647920676f7420616e206163636f756e743f2024312e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (538, 0x4c6f6720696e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (539, 0x547275737465642075736572732061626c6520746f20626c6f636b20757365727320616e642064656c6574652061727469636c6573, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (540, 0x41646d696e6973747261746f72, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (541, 0x416e6f6e796d6f7573207573657273, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (542, 0x416e6f6e796d6f7573, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (543, 0x54686520627572656175637261742067726f75702069732061626c6520746f206d616b65207379736f7073, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (544, 0x42757265617563726174, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (545, 0x47656e6572616c206c6f6767656420696e207573657273, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (546, 0x55736572, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (547, 0x46756c6c20616363657373, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (548, 0x53746577617264, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (549, 0x557365722067726f757073, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (550, 0x4164642067726f7570, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (551, 0x412067726f7570206f662074686174206e616d6520616c726561647920657869737473, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (552, 0x456469742067726f7570, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (553, 0x47726f7570206465736372697074696f6e20286d6178203235352063686172616374657273293a3c6272202f3e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (554, 0x47726f7570206e616d653a, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (555, 0x496620746865206e616d65206f72206465736372697074696f6e207374617274732077697468206120636f6c6f6e2c207468650a72656d61696e6465722077696c6c20626520747265617465642061732061206d657373616765206e616d652c20616e642068656e63652074686520746578742077696c6c206265206c6f63616c697365640a7573696e6720746865204d6564696157696b69206e616d657370616365, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (556, 0x4578697374696e672067726f757073, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (557, 0x4578697374696e672067726f7570733a, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (558, 0x4d616e6167652067726f757020726967687473, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (559, 0x506c65617365207370656369667920612076616c69642067726f7570206e616d65, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (560, 0x4944207c7c204e616d65207c7c204465736372697074696f6e207c7c20526967687473, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (561, 0x46696c6c20696e2066726f6d2062726f77736572, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (562, 0x486561646c696e652074657874, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (563, 0x4c6576656c203220686561646c696e65, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (564, 0x48656c70, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (565, 0x48656c703a436f6e74656e7473, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (566, 0x48696465, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (567, 0x4869646520726573756c7473, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (568, 0x68696465, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (569, 0x68697374, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (570, 0x4561726c69657374, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (571, 0x4c6174657374, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (572, 0x446966662073656c656374696f6e3a206d61726b2074686520726164696f20626f786573206f66207468652076657273696f6e7320746f20636f6d7061726520616e642068697420656e746572206f722074686520627574746f6e2061742074686520626f74746f6d2e3c6272202f3e0a4c6567656e643a202863757229203d20646966666572656e636520776974682063757272656e742076657273696f6e2c0a286c61737429203d20646966666572656e6365207769746820707265636564696e672076657273696f6e2c204d203d206d696e6f7220656469742e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (573, 0x5061676520686973746f7279, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (574, 0x2d, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (575, 0x486973746f7279, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (576, 0x5761726e696e673a20546865207061676520796f75206172652061626f757420746f2064656c65746520686173206120686973746f72793a, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (577, 0x486f72697a6f6e74616c206c696e6520287573652073706172696e676c7929, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (578, 0x49676e6f7265207761726e696e6720616e6420736176652066696c6520616e797761792e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (579, 0x49676e6f726520616e79207761726e696e6773, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (580, 0x5468652066696c656e616d65202224312220636f6e7461696e732063686172616374657273207468617420617265206e6f7420616c6c6f77656420696e2070616765207469746c65732e20506c656173652072656e616d65207468652066696c6520616e64207472792075706c6f6164696e6720697420616761696e2e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (581, 0x536561726368, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (582, 0x4578616d706c652e6a7067, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (583, 0x456d62656464656420696d616765, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (584, 0x4c696e6b73, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (585, 0x46696c65206c697374, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (586, 0x616c6c, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (587, 0x546869732073686f7773206f6e6c7920696d616765732075706c6f616465642062792024312e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (588, 0x42656c6f772069732061206c697374206f662024312066696c657320736f727465642024322e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (589, 0x4c696d697420696d61676573206f6e20696d616765206465736372697074696f6e20706167657320746f3a, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (590, 0x5669657720696d6167652070616765, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (591, 0x52657665727420746f206561726c6965722076657273696f6e20776173207375636365737366756c2e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (592, 0x64656c, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (593, 0x64657363, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (594, 0x4c6567656e643a202863757229203d2074686973206973207468652063757272656e742066696c652c202864656c29203d2064656c6574650a74686973206f6c642076657273696f6e2c202872657629203d2072657665727420746f2074686973206f6c642076657273696f6e2e0a3c6272202f3e3c693e436c69636b206f6e206461746520746f20736565207468652066696c652075706c6f61646564206f6e207468617420646174653c2f693e2e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (595, 0x46696c6520686973746f7279, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (596, 0x4c6567656e643a20286465736329203d2073686f772f656469742066696c65206465736372697074696f6e2e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (597, 0x44657374696e6174696f6e207469746c65206973206f662061207370656369616c20747970653b2063616e6e6f74206d6f766520706167657320696e746f2074686174206e616d6573706163652e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (598, 0x496d706f7274207061676573, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (599, 0x496d706f7274206661696c65643a202431, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (600, 0x436f6e666c696374696e6720686973746f7279207265766973696f6e2065786973747320286d6179206861766520696d706f7274656420746869732070616765206265666f726529, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (601, 0x496d706f7274696e67202431, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (602, 0x5472616e7377696b6920696d706f7274, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (603, 0x4e6f20696d706f72742066696c65207761732075706c6f616465642e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (604, 0x4e6f207472616e7377696b6920696d706f727420736f75726365732068617665206265656e20646566696e656420616e642064697265637420686973746f72792075706c6f616473206172652064697361626c65642e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (605, 0x456d707479206f72206e6f2074657874, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (606, 0x496d706f72742073756363656564656421, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (607, 0x506c65617365206578706f7274207468652066696c652066726f6d2074686520736f757263652077696b69207573696e6720746865205370656369616c3a4578706f7274207574696c6974792c207361766520697420746f20796f7572206469736b20616e642075706c6f616420697420686572652e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (608, 0x55706c6f6164206f6620696d706f72742066696c65206661696c65643b2070657268617073207468652066696c6520697320626967676572207468616e2074686520616c6c6f7765642075706c6f61642073697a652e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (609, 0x696e66696e697465, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (610, 0x496e666f726d6174696f6e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (611, 0x496e666f726d6174696f6e20666f722070616765, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (612, 0x496e7465726e616c206572726f72, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (613, 0x496e7465726c616e6775616765206c696e6b73, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (614, 0x54686520652d6d61696c20616464726573732063616e6e6f74206265206163636570746564206173206974206170706561727320746f206861766520616e20696e76616c69640a666f726d61742e20506c6561736520656e74657220612077656c6c2d666f726d61747465642061646472657373206f7220656d7074792074686174206669656c642e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (615, 0x496e766572742073656c656374696f6e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (616, 0x496e76616c69642049502072616e67652e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (617, 0x49502041646472657373, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (618, 0x49502041646472657373206f7220757365726e616d65, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (619, 0x4578706972792074696d6520696e76616c69642e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (620, 0x457870697279, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (621, 0x4c697374206f6620626c6f636b65642049502061646472657373657320616e6420757365726e616d6573, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (622, 0x54686520626c6f636b6c69737420697320656d7074792e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (623, 0x3220686f7572733a3220686f7572732c31206461793a31206461792c3320646179733a3320646179732c31207765656b3a31207765656b2c32207765656b733a32207765656b732c31206d6f6e74683a31206d6f6e74682c33206d6f6e7468733a33206d6f6e7468732c36206d6f6e7468733a36206d6f6e7468732c3120796561723a3120796561722c696e66696e6974653a696e66696e697465, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (624, 0x4f746865722074696d65, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (625, 0x6f74686572, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (626, 0x526561736f6e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (627, 0x426c6f636b20746869732075736572, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (628, 0x556e626c6f636b20746869732061646472657373, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (629, 0x225b5b24315d5d2220756e626c6f636b6564, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (630, 0x4953424e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (631, 0x72656469726563742070616765, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (632, 0x696e636c7573696f6e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (633, 0x4974616c69632074657874, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (634, 0x4974616c69632074657874, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (635, 0x50726f626c656d2077697468206974656d20272431272c20696e76616c6964206e616d652e2e2e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (636, 0x4a616e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (637, 0x4a616e75617279, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (638, 0x4a756c, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (639, 0x4a756c79, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (640, 0x4a756d7020746f3a, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (641, 0x6e617669676174696f6e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (642, 0x736561726368, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (643, 0x4a756e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (644, 0x4a756e65, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (645, 0x5761726e696e673a2050616765206d6179206e6f7420636f6e7461696e20726563656e7420757064617465732e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (646, 0x4974206973207265636f6d6d656e646564207468617420696d61676573206e6f742065786365656420243120627974657320696e2073697a652c20746869732066696c65206973202432206279746573, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (647, 0x546869732066696c6520697320626967676572207468616e207468652073657276657220697320636f6e6669677572656420746f20616c6c6f772e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (648, 0x6c617374, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (649, 0x54686973207061676520776173206c617374206d6f6469666965642024312e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (650, 0x54686973207061676520776173206c617374206d6f6469666965642024312062792024322e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (651, 0x4c6963656e73696e67, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (652, 0x4c696e652024313a, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (653, 0x4c696e6b207469746c65, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (654, 0x496e7465726e616c206c696e6b, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (655, 0x284c697374206f66206c696e6b7329, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (656, 0x2f5e282e2a3f29285b612d7a412d5a5c7838302d5c7866665d2b29242f7344, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (657, 0x54686520666f6c6c6f77696e67207061676573206c696e6b20746f20686572653a, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (658, 0x54686520666f6c6c6f77696e67207061676573206c696e6b20746f20746869732066696c653a, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (659, 0x2f5e285b612d7a5d2b29282e2a29242f7344, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (660, 0x6c697374, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (661, 0x20636f6e742e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (662, 0x4c69737420726564697265637473, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (663, 0x55736572206c697374, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (664, 0x4c6f6164696e67207061676520686973746f7279, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (665, 0x6c6f6164696e67207265766973696f6e20666f722064696666, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (666, 0x4c6f63616c2074696d65, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (667, 0x4c6f636b206461746162617365, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (668, 0x5965732c2049207265616c6c792077616e7420746f206c6f636b207468652064617461626173652e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (669, 0x4c6f636b206461746162617365, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (670, 0x4461746162617365206c6f636b20737563636565646564, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (671, 0x54686520646174616261736520686173206265656e206c6f636b65642e0a3c6272202f3e52656d656d62657220746f2072656d6f766520746865206c6f636b20616674657220796f7572206d61696e74656e616e636520697320636f6d706c6574652e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (672, 0x4c6f636b696e67207468652064617461626173652077696c6c2073757370656e6420746865206162696c697479206f6620616c6c0a757365727320746f20656469742070616765732c206368616e676520746865697220707265666572656e6365732c20656469742074686569722077617463686c697374732c20616e640a6f74686572207468696e677320726571756972696e67206368616e67657320696e207468652064617461626173652e0a506c6561736520636f6e6669726d20746861742074686973206973207768617420796f7520696e74656e6420746f20646f2c20616e64207468617420796f752077696c6c0a756e6c6f636b20746865206461746162617365207768656e20796f7572206d61696e74656e616e636520697320646f6e652e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (673, 0x596f7520646964206e6f7420636865636b2074686520636f6e6669726d6174696f6e20626f782e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (674, 0x4c6f6773, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (675, 0x4e6f206d61746368696e67206974656d7320696e206c6f672e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (676, 0x4c6f6720696e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (677, '', 0x7574662d38);
INSERT INTO `wiki_text` VALUES (678, 0x4c6f67696e206572726f72, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (679, 0x55736572206c6f67696e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (680, 0x3c623e546865726520686173206265656e20612070726f626c656d207769746820796f7572206c6f67696e2e3c2f623e3c6272202f3e54727920616761696e21, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (681, 0x596f75206d757374206861766520636f6f6b69657320656e61626c656420746f206c6f6720696e20746f207b7b534954454e414d457d7d2e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (682, 0x6c6f6720696e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (683, 0x596f75206d75737420243120746f2076696577206f746865722070616765732e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (684, 0x4c6f67696e205265717569726564, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (685, 0x272727596f7520617265206e6f77206c6f6767656420696e20746f207b7b534954454e414d457d7d20617320222431222e272727, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (686, 0x4c6f67696e207375636365737366756c, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (687, 0x4c6f67206f7574, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (688, 0x3c7374726f6e673e596f7520617265206e6f77206c6f67676564206f75742e3c2f7374726f6e673e3c6272202f3e0a596f752063616e20636f6e74696e756520746f20757365207b7b534954454e414d457d7d20616e6f6e796d6f75736c792c206f7220796f752063616e206c6f6720696e0a616761696e206173207468652073616d65206f72206173206120646966666572656e7420757365722e204e6f7465207468617420736f6d65207061676573206d61790a636f6e74696e756520746f20626520646973706c6179656420617320696620796f752077657265207374696c6c206c6f6767656420696e2c20756e74696c20796f7520636c6561720a796f75722062726f777365722063616368652e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (689, 0x55736572206c6f676f7574, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (690, 0x4f727068616e6564207061676573, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (691, 0x3c7374726f6e673e4552524f523a20546865207465787420796f752068617665207375626d6974746564206973202431206b696c6f6279746573200a6c6f6e672c207768696368206973206c6f6e676572207468616e20746865206d6178696d756d206f66202432206b696c6f62797465732e2049742063616e6e6f742062652073617665642e3c2f7374726f6e673e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (692, 0x4c6f6e67207061676573, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (693, 0x3c7374726f6e673e5741524e494e473a20546869732070616765206973202431206b696c6f6279746573206c6f6e673b20736f6d650a62726f7773657273206d617920686176652070726f626c656d732065646974696e6720706167657320617070726f616368696e67206f72206c6f6e676572207468616e2033326b622e0a506c6561736520636f6e736964657220627265616b696e6720746865207061676520696e746f20736d616c6c65722073656374696f6e732e3c2f7374726f6e673e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (694, 0x4572726f722073656e64696e67206d61696c3a202431, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (695, 0x452d6d61696c2070617373776f7264, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (696, 0x4e6f2073656e642061646472657373, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (697, 0x596f75206d757374206265205b5b5370656369616c3a557365726c6f67696e7c6c6f6767656420696e5d5d0a616e64206861766520612076616c696420652d6d61696c206164647265737320696e20796f7572205b5b5370656369616c3a507265666572656e6365737c707265666572656e6365735d5d0a746f2073656e6420652d6d61696c20746f206f746865722075736572732e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (698, 0x4d61696e2050616765, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (699, 0x436f6e73756c7420746865205b687474703a2f2f6d6574612e77696b6970656469612e6f72672f77696b692f4d6564696157696b695f55736572253237735f4775696465205573657227732047756964655d20666f7220696e666f726d6174696f6e206f6e207573696e67207468652077696b6920736f6674776172652e0a0a3d3d2047657474696e672073746172746564203d3d0a0a2a205b687474703a2f2f7777772e6d6564696177696b692e6f72672f77696b692f48656c703a436f6e66696775726174696f6e5f73657474696e677320436f6e66696775726174696f6e2073657474696e6773206c6973745d0a2a205b687474703a2f2f7777772e6d6564696177696b692e6f72672f77696b692f48656c703a464151204d6564696157696b69204641515d0a2a205b687474703a2f2f6d61696c2e77696b6970656469612e6f72672f6d61696c6d616e2f6c697374696e666f2f6d6564696177696b692d616e6e6f756e6365204d6564696157696b692072656c65617365206d61696c696e67206c6973745d, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (700, 0x3c6269673e2727274d6564696157696b6920686173206265656e207375636365737366756c6c7920696e7374616c6c65642e2727273c2f6269673e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (701, 0x4d616b652061207573657220696e746f2061207379736f70, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (702, 0x3c623e55736572202224312220636f756c64206e6f74206265206d61646520696e746f2061207379736f702e202844696420796f7520656e74657220746865206e616d6520636f72726563746c793f293c2f623e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (703, 0x4e616d65206f662074686520757365723a, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (704, 0x3c623e557365722022243122206973206e6f772061207379736f703c2f623e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (705, 0x4d616b652074686973207573657220696e746f2061207379736f70, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (706, 0x5468697320666f726d206973207573656420627920627572656175637261747320746f207475726e206f7264696e61727920757365727320696e746f2061646d696e6973747261746f72732e0a5479706520746865206e616d65206f6620746865207573657220696e2074686520626f7820616e642070726573732074686520627574746f6e20746f206d616b6520746865207573657220616e2061646d696e6973747261746f72, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (707, 0x4d616b652061207573657220696e746f2061207379736f70, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (708, 0x4d6172, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (709, 0x4d61726368, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (710, 0x4d61726b20617320706174726f6c6c6564, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (711, 0x5b24315d, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (712, 0x4d61726b20746869732061727469636c6520617320706174726f6c6c6564, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (713, 0x4d61726b656420617320706174726f6c6c6564, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (714, 0x43616e6e6f74206d61726b20617320706174726f6c6c6564, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (715, 0x596f75206e65656420746f20737065636966792061207265766973696f6e20746f206d61726b20617320706174726f6c6c65642e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (716, 0x5468652073656c6563746564207265766973696f6e20686173206265656e206d61726b656420617320706174726f6c6c65642e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (717, 0x5468652071756572792022243122206d6174636865642024322070616765207469746c65730a616e64207468652074657874206f662024332070616765732e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (718, 0x4d617468, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (719, 0x43616e277420777269746520746f206f7220637265617465206d617468206f7574707574206469726563746f7279, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (720, 0x43616e277420777269746520746f206f7220637265617465206d6174682074656d70206469726563746f7279, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (721, 0x4661696c656420746f207061727365, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (722, 0x504e4720636f6e76657273696f6e206661696c65643b20636865636b20666f7220636f727265637420696e7374616c6c6174696f6e206f66206c617465782c2064766970732c2067732c20616e6420636f6e76657274, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (723, 0x6c6578696e67206572726f72, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (724, 0x4d697373696e672074657876632065786563757461626c653b20706c6561736520736565206d6174682f524541444d4520746f20636f6e6669677572652e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (725, 0x496e7365727420666f726d756c612068657265, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (726, 0x73796e746178206572726f72, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (727, 0x4d617468656d61746963616c20666f726d756c6120284c6154655829, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (728, 0x756e6b6e6f776e206572726f72, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (729, 0x756e6b6e6f776e2066756e6374696f6e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (730, 0x4d6179, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (731, 0x4d6179, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (732, 0x4578616d706c652e6f6767, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (733, 0x4d656469612066696c65206c696e6b, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (734, 0x2727275761726e696e672727273a20546869732066696c65206d617920636f6e7461696e206d616c6963696f757320636f64652c20627920657865637574696e6720697420796f75722073797374656d206d617920626520636f6d70726f6d697365642e0a3c68723e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (735, 0x4d65746164617461, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (736, 0x4869646520657874656e6465642064657461696c73, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (737, 0x53686f7720657874656e6465642064657461696c73, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (738, 0x45584946206d65746164617461206669656c6473206c697374656420696e2074686973206d6573736167652077696c6c0a626520696e636c75646564206f6e20696d616765207061676520646973706c6179207768656e20746865206d65746164617461207461626c650a697320636f6c6c61707365642e204f74686572732077696c6c2062652068696464656e2062792064656661756c742e0a2a206d616b650a2a206d6f64656c0a2a206461746574696d656f726967696e616c0a2a206578706f7375726574696d650a2a20666e756d6265720a2a20666f63616c6c656e677468, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (739, 0x546869732066696c6520636f6e7461696e73206164646974696f6e616c20696e666f726d6174696f6e2c2070726f6261626c792061646465642066726f6d20746865206469676974616c2063616d657261206f72207363616e6e6572207573656420746f20637265617465206f72206469676974697a652069742e204966207468652066696c6520686173206265656e206d6f6469666965642066726f6d20697473206f726967696e616c2073746174652c20736f6d652064657461696c73206d6179206e6f742066756c6c79207265666c65637420746865206d6f64696669656420696d6167652e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (740, 0x57696b6970656469613a4d65746164617461, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (741, 0x4d494d4520736561726368, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (742, 0x4d494d4520747970653a, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (743, 0x46696c65206e616d6573206d757374206265206174206c65617374207468726565206c6574746572732e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (744, 0x546869732069732061206d696e6f722065646974, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (745, 0x6d, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (746, 0x54686520646174616261736520646964206e6f742066696e64207468652074657874206f662061207061676520746861742069742073686f756c64206861766520666f756e642c206e616d656420222431222e0a0a5468697320697320757375616c6c792063617573656420627920666f6c6c6f77696e6720616e206f757464617465642064696666206f7220686973746f7279206c696e6b20746f20610a70616765207468617420686173206265656e2064656c657465642e0a0a49662074686973206973206e6f742074686520636173652c20796f75206d6179206861766520666f756e6420612062756720696e2074686520736f6674776172652e0a506c65617365207265706f7274207468697320746f20616e2061646d696e6973747261746f722c206d616b696e67206e6f7465206f66207468652055524c2e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (747, 0x506c6561736520656e746572206120636f6d6d656e742062656c6f772e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (748, 0x3c623e4d697373696e6720696d6167653c2f623e3c6272202f3e3c693e24313c2f693e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (749, 0x27272752656d696e6465723a27272720596f752068617665206e6f742070726f766964656420616e20656469742073756d6d6172792e20496620796f7520636c69636b205361766520616761696e2c20796f757220656469742077696c6c20626520736176656420776974686f7574206f6e652e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (750, 0x4d6f6e646179, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (751, 0x4d6f72652e2e2e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (752, 0x41727469636c6573207769746820746865206d6f73742063617465676f72696573, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (753, 0x4d6f7374206c696e6b656420746f20696d61676573, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (754, 0x4d6f7374206c696e6b656420746f207061676573, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (755, 0x4d6f7374206c696e6b656420746f2063617465676f72696573, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (756, 0x41727469636c6573207769746820746865206d6f7374207265766973696f6e73, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (757, 0x4d6f7665, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (758, 0x4d6f76652070616765, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (759, 0x6d6f76656420746f, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (760, 0x4d6f7665206c6f67, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (761, 0x42656c6f772069732061206c697374206f662070616765206d6f7665642e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (762, 0x4e6f74206c6f6767656420696e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (763, 0x596f75206d75737420626520612072656769737465726564207573657220616e64205b5b5370656369616c3a557365726c6f67696e7c6c6f6767656420696e5d5d0a746f206d6f7665206120706167652e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (764, 0x4d6f76652070616765, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (765, 0x4d6f76652070616765, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (766, 0x546865206173736f6369617465642074616c6b20706167652c20696620616e792c2077696c6c206265206175746f6d61746963616c6c79206d6f76656420616c6f6e67207769746820697420272727756e6c6573733a2727270a2a596f7520617265206d6f76696e67207468652070616765206163726f7373206e616d657370616365732c0a2a41206e6f6e2d656d7074792074616c6b207061676520616c72656164792065786973747320756e64657220746865206e6577206e616d652c206f720a2a596f7520756e636865636b2074686520626f782062656c6f772e0a0a496e2074686f73652063617365732c20796f752077696c6c206861766520746f206d6f7665206f72206d65726765207468652070616765206d616e75616c6c7920696620646573697265642e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (767, 0x5573696e672074686520666f726d2062656c6f772077696c6c2072656e616d65206120706167652c206d6f76696e6720616c6c0a6f662069747320686973746f727920746f20746865206e6577206e616d652e0a546865206f6c64207469746c652077696c6c206265636f6d652061207265646972656374207061676520746f20746865206e6577207469746c652e0a4c696e6b7320746f20746865206f6c642070616765207469746c652077696c6c206e6f74206265206368616e6765643b206265207375726520746f0a636865636b20666f7220646f75626c65206f722062726f6b656e207265646972656374732e0a596f752061726520726573706f6e7369626c6520666f72206d616b696e6720737572652074686174206c696e6b7320636f6e74696e756520746f0a706f696e7420776865726520746865792061726520737570706f73656420746f20676f2e0a0a4e6f746520746861742074686520706167652077696c6c202727276e6f74272727206265206d6f76656420696620746865726520697320616c72656164790a61207061676520617420746865206e6577207469746c652c20756e6c65737320697420697320656d707479206f72206120726564697265637420616e6420686173206e6f0a70617374206564697420686973746f72792e2054686973206d65616e73207468617420796f752063616e2072656e616d6520612070616765206261636b20746f2077686572650a697420776173206a7573742072656e616d65642066726f6d20696620796f75206d616b652061206d697374616b652c20616e6420796f752063616e6e6f74206f76657277726974650a616e206578697374696e6720706167652e0a0a3c623e5741524e494e47213c2f623e0a546869732063616e2062652061206472617374696320616e6420756e6578706563746564206368616e676520666f72206120706f70756c617220706167653b0a706c65617365206265207375726520796f7520756e6465727374616e642074686520636f6e73657175656e636573206f662074686973206265666f72650a70726f63656564696e672e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (768, 0x526561736f6e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (769, 0x4d6f7665206173736f6369617465642074616c6b2070616765, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (770, 0x4d6f766520746869732070616765, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (771, 0x48544d4c20696620706f737369626c65206f7220656c736520504e47, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (772, 0x4d6174684d4c20696620706f737369626c6520286578706572696d656e74616c29, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (773, 0x5265636f6d6d656e64656420666f72206d6f6465726e2062726f7773657273, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (774, 0x416c776179732072656e64657220504e47, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (775, 0x48544d4c20696620766572792073696d706c65206f7220656c736520504e47, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (776, 0x4c65617665206974206173205465582028666f7220746578742062726f777365727329, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (777, 0x4d7920636f6e747269627574696f6e73, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (778, 0x4d792070616765, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (779, 0x4d792074616c6b, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (780, 0x4e616d6573706163653a, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (781, 0x616c6c, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (782, 0x4e617669676174696f6e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (783, 0x2431206279746573, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (784, 0x24312063617465676f72696573, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (785, 0x2431206368616e676573, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (786, 0x284e657729, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (787, 0x596f7527766520666f6c6c6f7765642061206c696e6b20746f20612070616765207468617420646f65736e2774206578697374207965742e0a546f206372656174652074686520706167652c20737461727420747970696e6720696e2074686520626f782062656c6f770a2873656520746865205b5b50726f6a6563743a48656c707c68656c7020706167655d5d20666f72206d6f726520696e666f292e0a496620796f75206172652068657265206279206d697374616b652c206a75737420636c69636b20796f75722062726f777365722773202727276261636b27272720627574746f6e2e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (788, 0x7b7b696e743a6e657761727469636c65746578747d7d, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (789, 0x6e657762696573, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (790, 0x47616c6c657279206f66206e65772066696c6573, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (791, 0x6469666620746f2070656e756c74696d617465207265766973696f6e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (792, 0x6e6577206d65737361676573, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (793, 0x4e65772070616765, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (794, 0x4e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (795, 0x4e6577207061676573, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (796, 0x4e65772070617373776f72643a, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (797, 0x2c5f, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (798, 0x546f206e6577207469746c65, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (799, 0x20286e6577207573657273206f6e6c7929, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (800, 0x286f70656e7320696e206e65772077696e646f7729, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (801, 0x6e657874, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (802, 0x4e657874206469666620e28692, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (803, 0x6e657874202431, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (804, 0x4e65787420706167652028243129, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (805, 0x4e65776572207265766973696f6ee28692, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (806, 0x2431206c696e6b73, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (807, 0x54686572652069732063757272656e746c79206e6f207465787420696e207468697320706167652c20796f752063616e205b5b7b7b6e733a7370656369616c7d7d3a5365617263682f7b7b504147454e414d457d7d7c73656172636820666f7220746869732070616765207469746c655d5d20696e206f74686572207061676573206f72205b7b7b66756c6c75726c3a7b7b4e414d4553504143457d7d3a7b7b504147454e414d457d7d7c616374696f6e3d656469747d7d2065646974207468697320706167655d2e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (808, 0x7b7b696e743a6e6f61727469636c65746578747d7d, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (809, 0x536f72727921205468652077696b6920697320657870657269656e63696e6720736f6d6520746563686e6963616c20646966666963756c746965732c20616e642063616e6e6f7420636f6e7461637420746865206461746162617365207365727665722e203c6272202f3e0a2431, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (810, 0x4e6f206368616e676573207765726520666f756e64206d61746368696e672074686573652063726974657269612e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (811, 0x7b7b534954454e414d457d7d207573657320636f6f6b69657320746f206c6f6720696e2075736572732e20596f75206861766520636f6f6b6965732064697361626c65642e20506c6561736520656e61626c65207468656d20616e642074727920616761696e2e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (812, 0x5468652075736572206163636f756e742077617320637265617465642c2062757420796f7520617265206e6f74206c6f6767656420696e2e207b7b534954454e414d457d7d207573657320636f6f6b69657320746f206c6f6720696e2075736572732e20596f75206861766520636f6f6b6965732064697361626c65642e20506c6561736520656e61626c65207468656d2c207468656e206c6f6720696e207769746820796f7572206e657720757365726e616d6520616e642070617373776f72642e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (813, 0x54686973207369746520686173207265737472696374656420746865206162696c69747920746f20637265617465206e65772070616765732e0a596f752063616e20676f206261636b20616e64206564697420616e206578697374696e6720706167652c206f72205b5b5370656369616c3a557365726c6f67696e7c6c6f6720696e206f722063726561746520616e206163636f756e745d5d2e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (814, 0x50616765206372656174696f6e206c696d69746564, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (815, 0x437265617469766520436f6d6d6f6e7320524446206d657461646174612064697361626c656420666f722074686973207365727665722e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (816, 0x5468657265206973206e6f206372656469747320696e666f20617661696c61626c6520666f72207468697320706167652e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (817, 0x436f756c64206e6f742073656c656374206461746162617365202431, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (818, 0x4475626c696e20436f726520524446206d657461646174612064697361626c656420666f722074686973207365727665722e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (819, 0x5468657265206973206e6f20652d6d61696c2061646472657373207265636f7264656420666f72207573657220222431222e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (820, 0x3c7374726f6e673e5370656369667920616e20652d6d61696c206164647265737320666f7220746865736520666561747572657320746f20776f726b2e3c2f7374726f6e673e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (821, 0x54686973207573657220686173206e6f742073706563696669656420612076616c696420652d6d61696c20616464726573732c0a6f72206861732063686f73656e206e6f7420746f207265636569766520652d6d61696c2066726f6d206f746865722075736572732e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (822, 0x4e6f20652d6d61696c2061646472657373, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (823, 0x2727275468657265206973206e6f2070616765207469746c656420222431222e27272720596f752063616e205b5b24317c637265617465207468697320706167655d5d2e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (824, 0x5468657265206973206e6f206564697420686973746f727920666f72207468697320706167652e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (825, 0x4e6f2066696c652062792074686973206e616d65206578697374732c20796f752063616e2024312e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (826, 0x75706c6f6164206974, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (827, 0x4e6f7468696e6720746f207365652e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (828, 0x4e6f6e652073656c6563746564, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (829, 0x4e6f207061676573206c696e6b20746f20686572652e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (830, 0x546865726520617265206e6f2070616765732074686174206c696e6b20746f20746869732066696c652e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (831, 0x446f6e277420686176652061206c6f67696e3f2024312e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (832, 0x43726561746520616e206163636f756e74, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (833, 0x596f752068617665206e6f742073706563696669656420612076616c69642075736572206e616d652e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (834, 0x2727274e6f74652727273a20756e7375636365737366756c207365617263686573206172650a6f6674656e2063617573656420627920736561726368696e6720666f7220636f6d6d6f6e20776f726473206c696b652022686176652220616e64202266726f6d222c0a776869636820617265206e6f7420696e64657865642c206f722062792073706563696679696e67206d6f7265207468616e206f6e6520736561726368207465726d20286f6e6c792070616765730a636f6e7461696e696e6720616c6c206f662074686520736561726368207465726d732077696c6c2061707065617220696e2074686520726573756c74292e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (835, 0x3c7374726f6e673e5741524e494e473a20596f75722062726f77736572206973206e6f7420756e69636f646520636f6d706c69616e742e204120776f726b61726f756e6420697320696e20706c61636520746f20616c6c6f7720796f7520746f20736166656c7920656469742061727469636c65733a206e6f6e2d415343494920636861726163746572732077696c6c2061707065617220696e20746865206564697420626f782061732068657861646563696d616c20636f6465732e3c2f7374726f6e673e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (836, 0x596f7520686176652072657175657374656420616e20696e76616c6964207370656369616c20706167652c2061206c697374206f662076616c6964207370656369616c207061676573206d617920626520666f756e64206174205b5b7b7b6e733a7370656369616c7d7d3a5370656369616c70616765735d5d2e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (837, 0x4e6f207375636820616374696f6e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (838, 0x54686520616374696f6e20737065636966696564206279207468652055524c206973206e6f740a7265636f676e697a6564206279207468652077696b69, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (839, 0x4e6f2073756368207370656369616c2070616765, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (840, 0x5468657265206973206e6f207573657220627920746865206e616d6520222431222e20436865636b20796f7572207370656c6c696e672c206f72206372656174652061206e6577206163636f756e742e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (841, 0x5468657265206973206e6f207573657220627920746865206e616d6520222431222e20436865636b20796f7572207370656c6c696e672e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (842, 0x5468652077696b69207365727665722063616e27742070726f76696465206461746120696e206120666f726d617420796f757220636c69656e742063616e20726561642e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (843, 0x4e6f74206120636f6e74656e742070616765, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (844, 0x596f752068617665206e6f74207370656369666965642061207461726765742070616765206f7220757365720a746f20706572666f726d20746869732066756e6374696f6e206f6e2e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (845, 0x4e6f20746172676574, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (846, 0x3c7374726f6e673e4e6f74653a3c2f7374726f6e673e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (847, 0x4e6f20706167652074657874206d617463686573, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (848, 0x4e6f2070616765207469746c65206d617463686573, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (849, 0x4e6f74206c6f6767656420696e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (850, 0x596f75206861766520746f2073706563696679206120757365726e616d652e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (851, 0x4e6f76, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (852, 0x4e6f76656d626572, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (853, 0x596f752068617665206e6f206974656d73206f6e20796f75722077617463686c6973742e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (854, 0x496e73657274206e6f6e2d666f726d617474656420746578742068657265, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (855, 0x49676e6f72652077696b6920666f726d617474696e67, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (856, 0x2431207265766973696f6e73, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (857, 0x43617465676f7279, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (858, 0x48656c70, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (859, 0x46696c65, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (860, 0x41727469636c65, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (861, 0x4d656469612070616765, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (862, 0x4d657373616765, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (863, 0x5370656369616c, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (864, 0x54656d706c617465, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (865, 0x557365722070616765, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (866, 0x50726f6a6563742070616765, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (867, 0x4e756d626572206f662064697374696e637420617574686f7273202861727469636c65293a202431, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (868, 0x5b24315d, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (869, 0x5b2431207761746368696e6720757365722f735d, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (870, 0x4e756d626572206f66206564697473202861727469636c65293a202431, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (871, 0x4e756d626572206f662064697374696e637420617574686f7273202864697363757373696f6e2070616765293a202431, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (872, 0x4e756d626572206f66206564697473202864697363757373696f6e2070616765293a202431, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (873, 0x4e756d626572206f662077617463686572733a202431, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (874, 0x2431207669657773, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (875, 0x4f6374, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (876, 0x4f63746f626572, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (877, 0x4f4b, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (878, 0x4f6c642070617373776f72643a, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (879, 0x6f726967, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (880, 0x4f727068616e6564207061676573, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (881, 0x4261736564206f6e20776f726b2062792024312e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (882, 0x496e206f74686572206c616e677561676573, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (883, 0x6f7468657273, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (884, 0x4d6f766520737563636565646564, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (885, 0x5061676520225b5b24315d5d22206d6f76656420746f20225b5b24325d5d222e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (886, 0x2431202d207b7b534954454e414d457d7d, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (887, 0x536f6d656f6e65202870726f6261626c7920796f752c2066726f6d2049502061646472657373202431290a72657175657374656420746861742077652073656e6420796f752061206e6577207b7b534954454e414d457d7d206c6f67696e2070617373776f726420666f72207b7b5345525645524e414d457d7d2e0a5468652070617373776f726420666f7220757365722022243222206973206e6f7720222433222e0a596f752073686f756c64206c6f6720696e20616e64206368616e676520796f75722070617373776f7264206e6f772e0a0a496620736f6d656f6e6520656c7365206d61646520746869732072657175657374206f7220696620796f7520686176652072656d656d626572656420796f75722070617373776f726420616e640a796f75206e6f206c6f6e676572207769736820746f206368616e67652069742c20796f75206d61792069676e6f72652074686973206d65737361676520616e6420636f6e74696e7565207573696e670a796f7572206f6c642070617373776f72642e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (888, 0x50617373776f72642072656d696e6465722066726f6d207b7b534954454e414d457d7d, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (889, 0x41206e65772070617373776f726420686173206265656e2073656e7420746f2074686520652d6d61696c20616464726573730a7265676973746572656420666f7220222431222e0a506c65617365206c6f6720696e20616761696e20616674657220796f7520726563656976652069742e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (890, 0x596f75722070617373776f726420697320746f6f2073686f72742e204974206d7573742068617665206174206c6561737420243120636861726163746572732e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (891, 0x54686520666f6c6c6f77696e6720646174612069732063616368656420616e64206d6179206e6f7420626520636f6d706c6574656c7920757020746f20646174653a, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (892, 0x536f727279212054686973206665617475726520686173206265656e2074656d706f726172696c792064697361626c6564206265636175736520697420736c6f77732074686520646174616261736520646f776e20746f2074686520706f696e742074686174206e6f206f6e652063616e20757365207468652077696b692e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (893, 0x48657265206973206120736176656420636f70792066726f6d2024313a, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (894, 0x5065726d616e656e74206c696e6b, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (895, 0x506572736f6e616c20746f6f6c73, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (896, 0x506f70756c6172207061676573, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (897, 0x436f6d6d756e69747920706f7274616c, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (898, 0x50726f6a6563743a436f6d6d756e69747920506f7274616c, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (899, 0x506f7374206120636f6d6d656e74, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (900, 0x7b7b534954454e414d457d7d20697320706f7765726564206279205b687474703a2f2f7777772e6d6564696177696b692e6f72672f204d6564696157696b695d2c20616e206f70656e20736f757263652077696b6920656e67696e652e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (901, 0x536561726368, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (902, 0x0a53656172636820696e206e616d65737061636573203a3c6272202f3e0a24313c6272202f3e0a2432204c6973742072656469726563747320266e6273703b2053656172636820666f72202433202439, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (903, 0x507265666572656e636573, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (904, 0x50726566697820696e646578, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (905, 0x2a20452d6d61696c20286f7074696f6e616c293a20456e61626c6573206f746865727320746f20636f6e7461637420796f75207468726f75676820796f75722075736572206f7220757365725f74616c6b207061676520776974686f757420746865206e656564206f662072657665616c696e6720796f7572206964656e746974792e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (906, 0x54686973206164647265737320697320616c736f207573656420746f2073656e6420796f7520652d6d61696c206e6f74696669636174696f6e7320696620796f7520656e61626c656420746865206f7074696f6e732e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (907, 0x2a205265616c206e616d6520286f7074696f6e616c293a20696620796f752063686f6f736520746f2070726f7669646520697420746869732077696c6c206265207573656420666f7220676976696e6720796f75206174747269627574696f6e20666f7220796f757220776f726b2e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (908, 0x4d697363, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (909, 0x557365722070726f66696c65, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (910, 0x526563656e74206368616e676573, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (911, 0x4e6f74206c6f6767656420696e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (912, 0x596f75206d757374206265205b5b5370656369616c3a557365726c6f67696e7c6c6f6767656420696e5d5d20746f20736574207573657220707265666572656e6365732e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (913, 0x507265666572656e6365732068617665206265656e2072657365742066726f6d2073746f726167652e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (914, 0x50726576696577, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (915, 0x546869732070726576696577207265666c6563747320746865207465787420696e207468652075707065720a746578742065646974696e6720617265612061732069742077696c6c2061707065617220696620796f752063686f6f736520746f20736176652e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (916, 0x3c7374726f6e673e54686973206973206f6e6c79206120707265766965773b206368616e6765732068617665206e6f7420796574206265656e207361766564213c2f7374726f6e673e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (917, 0xe286902050726576696f75732064696666, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (918, 0xe286904f6c646572207265766973696f6e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (919, 0x70726576696f7573202431, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (920, 0x5072696e74, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (921, 0x5072696e7461626c652076657273696f6e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (922, 0x2846726f6d207b7b5345525645527d7d29, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (923, 0x5072697661637920706f6c696379, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (924, 0x50726f6a6563743a507269766163795f706f6c696379, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (925, 0x50726f74656374, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (926, 0x2864656661756c7429, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (927, 0x426c6f636b20756e72656769737465726564207573657273, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (928, 0x5379736f7073206f6e6c79, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (929, 0x596f75206d6179207669657720616e64206368616e6765207468652070726f74656374696f6e206c6576656c206865726520666f72207468652070616765203c7374726f6e673e24313c2f7374726f6e673e2e0a506c65617365206265207375726520796f752061726520666f6c6c6f77696e6720746865205b5b50726f6a6563743a50726f74656374656420706167657c70726f6a6563742067756964656c696e65735d5d2e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (930, 0x556e6c6f636b206d6f7665207065726d697373696f6e73, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (931, 0x596f7572206163636f756e7420646f6573206e6f742068617665207065726d697373696f6e20746f206368616e67650a706167652070726f74656374696f6e206c6576656c732e204865726520617265207468652063757272656e742073657474696e677320666f72207468652070616765203c7374726f6e673e24313c2f7374726f6e673e3a, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (932, 0x526561736f6e20666f722070726f74656374696e67, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (933, 0x70726f74656374656420225b5b24315d5d22, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (934, 0x50726f7465637465642070616765, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (935, 0x3c7374726f6e673e5741524e494e473a202054686973207061676520686173206265656e206c6f636b656420736f2074686174206f6e6c792075736572732077697468207379736f702070726976696c656765732063616e20656469742069742e204265207375726520796f752061726520666f6c6c6f77696e6720746865205b5b50726f6a6563743a50726f7465637465645f706167655f67756964656c696e65737c70726f74656374656420706167652067756964656c696e65735d5d2e3c2f7374726f6e673e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (936, 0x54686973207061676520686173206265656e206c6f636b656420746f2070726576656e742065646974696e673b207468657265206172650a61206e756d626572206f6620726561736f6e73207768792074686973206d617920626520736f2c20706c65617365207365650a5b5b50726f6a6563743a50726f74656374656420706167655d5d2e0a0a596f752063616e207669657720616e6420636f70792074686520736f75726365206f66207468697320706167653a, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (937, 0x50726f74656374696f6e5f6c6f67, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (938, 0x42656c6f772069732061206c697374206f662070616765206c6f636b732f756e6c6f636b732e0a536565205b5b50726f6a6563743a50726f74656374656420706167655d5d20666f72206d6f726520696e666f726d6174696f6e2e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (939, 0x50726f746563742066726f6d206d6f766573206f6e6c79, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (940, 0x50726f746563742070616765, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (941, 0x2850726f74656374696e67202224312229, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (942, 0x50726f7465637420746869732070616765, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (943, 0x50726f787920626c6f636b6572, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (944, 0x596f7572204950206164647265737320686173206265656e20626c6f636b6564206265636175736520697420697320616e206f70656e2070726f78792e20506c6561736520636f6e7461637420796f757220496e7465726e657420736572766963652070726f7669646572206f72207465636820737570706f727420616e6420696e666f726d207468656d206f66207468697320736572696f75732073656375726974792070726f626c656d2e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (945, 0x446f6e652e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (946, 0x687474703a2f2f7777772e6e6362692e6e6c6d2e6e69682e676f762f656e7472657a2f71756572792e666367693f636d643d52657472696576652664623d7075626d656426646f70743d4162737472616374266c6973745f756964733d2431, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (947, 0x42726f777365, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (948, 0x45646974, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (949, 0x46696e64, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (950, 0x4d79207061676573, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (951, 0x436f6e74657874, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (952, 0x546869732070616765, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (953, 0x517569636b626172, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (954, 0x5370656369616c207061676573, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (955, 0x52616e646f6d2070616765, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (956, 0x5370656369616c3a52616e646f6d, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (957, 0x546865207379736f70206162696c69747920746f206372656174652072616e676520626c6f636b732069732064697361626c65642e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (958, 0x4c696d697420746f2063617465676f7269657320287365706172617465207769746820227c2229, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (959, 0x416e79, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (960, 0x696e20243420666f726d3b202431206d696e6f722065646974733b202432207365636f6e64617279206e616d657370616365733b202433206d756c7469706c652065646974732e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (961, 0x53686f77206c617374202431206368616e67657320696e206c61737420243220646179733c6272202f3e2433, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (962, 0x53686f77206e6577206368616e676573207374617274696e672066726f6d202431, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (963, 0x3b2024312065646974732066726f6d206c6f6767656420696e207573657273, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (964, 0x4c6f6164696e6720726563656e74206368616e676573, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (965, 0x28746f207061676573206c696e6b65642066726f6d202224312229, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (966, 0x42656c6f772061726520746865206c617374203c7374726f6e673e24313c2f7374726f6e673e206368616e67657320696e206c617374203c7374726f6e673e24323c2f7374726f6e673e20646179732e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (967, 0x42656c6f772061726520746865206368616e6765732073696e6365203c623e24323c2f623e2028757020746f203c623e24313c2f623e2073686f776e292e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (968, 0x526563656e74204368616e67657320506174726f6c2064697361626c6564, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (969, 0x54686520526563656e74204368616e67657320506174726f6c20666561747572652069732063757272656e746c792064697361626c65642e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (970, 0x243120616e6f6e796d6f7573207573657273, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (971, 0x243120626f7473, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (972, 0x2431206c6f676765642d696e207573657273, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (973, 0x2431206d79206564697473, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (974, 0x2431206d696e6f72206564697473, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (975, 0x243120706174726f6c6c6564206564697473, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (976, 0x4461746162617365206c6f636b6564, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (977, 0x54686520646174616261736520686173206265656e206175746f6d61746963616c6c79206c6f636b6564207768696c652074686520736c617665206461746162617365207365727665727320636174636820757020746f20746865206d6173746572, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (978, 0x5468652064617461626173652069732063757272656e746c79206c6f636b656420746f206e657720656e747269657320616e64206f74686572206d6f64696669636174696f6e732c2070726f6261626c7920666f7220726f7574696e65206461746162617365206d61696e74656e616e63652c2061667465722077686963682069742077696c6c206265206261636b20746f206e6f726d616c2e0a0a5468652061646d696e6973747261746f722077686f206c6f636b6564206974206f6666657265642074686973206578706c616e6174696f6e3a202431, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (979, 0x3c7374726f6e673e5741524e494e473a2054686520646174616261736520686173206265656e206c6f636b656420666f72206d61696e74656e616e63652c0a736f20796f752077696c6c206e6f742062652061626c6520746f207361766520796f7572206564697473207269676874206e6f772e20596f75206d6179207769736820746f206375742d6e2d70617374650a746865207465787420696e746f206120746578742066696c6520616e64207361766520697420666f72206c617465722e3c2f7374726f6e673e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (980, 0x526563656e74206368616e676573, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (981, 0x5370656369616c3a526563656e746368616e676573, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (982, 0x616c6c, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (983, 0x5469746c657320696e20726563656e74206368616e6765733a, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (984, 0x52656c61746564206368616e676573, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (985, 0x547261636b20746865206d6f737420726563656e74206368616e67657320746f207468652077696b69206f6e207468697320706167652e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (986, 0x5265637265617465, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (987, 0x28526564697265637465642066726f6d20243129, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (988, 0x5265646972656374696e6720746f205b5b24315d5d2e2e2e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (989, 0x52656469726563742070616765, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (990, 0x52656d656d626572206d65, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (991, 0x52656d6f766520636865636b6564206974656d732066726f6d2077617463686c697374, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (992, 0x52656d6f7665642066726f6d2077617463686c697374, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (993, 0x546865207061676520225b5b3a24315d5d2220686173206265656e2072656d6f7665642066726f6d20796f75722077617463686c6973742e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (994, 0x52656d6f76696e6720726571756573746564206974656d732066726f6d2077617463686c6973742e2e2e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (995, 0x52656e616d65642067726f757020243220746f202433, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (996, 0x5265736574, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (997, 0x24312064656c65746564206564697473, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (998, 0x6f6e652064656c657465642065646974, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (999, 0x52657374726963746564207370656369616c207061676573, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1000, 0x45646974, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1001, 0x4d6f7665, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1002, 0x486974732070657220706167653a, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1003, 0x5265747269657665642066726f6d2022243122, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1004, 0x52657475726e20746f2024312e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1005, 0x526574797065206e65772070617373776f72643a, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1006, 0x52652d75706c6f6164, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1007, 0x52657475726e20746f207468652075706c6f616420666f726d2e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1008, 0x28636f6d6d656e742072656d6f76656429, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1009, 0x3c64697620636c6173733d226d772d7761726e696e6720706c61696e6c696e6b73223e0a546869732070616765207265766973696f6e20686173206265656e2072656d6f7665642066726f6d20746865207075626c69632061726368697665732e0a5468657265206d61792062652064657461696c7320696e20746865205b7b7b66756c6c75726c3a5370656369616c3a4c6f672f64656c6574657c706167653d7b7b504147454e414d45457d7d7d7d2064656c6574696f6e206c6f675d2e0a3c2f6469763e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1010, 0x3c64697620636c6173733d226d772d7761726e696e6720706c61696e6c696e6b73223e0a546869732070616765207265766973696f6e20686173206265656e2072656d6f7665642066726f6d20746865207075626c69632061726368697665732e0a417320616e2061646d696e6973747261746f72206f6e2074686973207369746520796f752063616e20766965772069743b0a7468657265206d61792062652064657461696c7320696e20746865205b7b7b66756c6c75726c3a5370656369616c3a4c6f672f64656c6574657c706167653d7b7b504147454e414d45457d7d7d7d2064656c6574696f6e206c6f675d2e0a3c2f6469763e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1011, 0x28757365726e616d652072656d6f76656429, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1012, 0x73686f772f68696465, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1013, 0x48696465206564697420636f6d6d656e74, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1014, 0x4170706c79207468657365207265737472696374696f6e7320746f207379736f70732061732077656c6c206173206f7468657273, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1015, 0x48696465207265766973696f6e2074657874, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1016, 0x4869646520656469746f72277320757365726e616d652f4950, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1017, 0x536574207265766973696f6e207265737472696374696f6e733a, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1018, 0x4c6f6720636f6d6d656e743a, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1019, 0x6368616e676564207265766973696f6e207669736962696c69747920666f72205b5b24315d5d, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1020, 0x53656c6563746564207265766973696f6e206f66205b5b3a24315d5d3a, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1021, 0x4170706c7920746f2073656c6563746564207265766973696f6e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1022, 0x44656c65746564207265766973696f6e732077696c6c207374696c6c2061707065617220696e20746865207061676520686973746f72792c0a627574207468656972207465787420636f6e74656e74732077696c6c20626520696e61636365737369626c6520746f20746865207075626c69632e0a0a4f746865722061646d696e73206f6e20746869732077696b692077696c6c207374696c6c2062652061626c6520746f20616363657373207468652068696464656e20636f6e74656e7420616e642063616e0a756e64656c65746520697420616761696e207468726f75676820746869732073616d6520696e746572666163652c20756e6c65737320616e206164646974696f6e616c207265737472696374696f6e0a697320706c61636564206279207468652073697465206f70657261746f72732e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1023, 0x526576657274656420746f206561726c696572207265766973696f6e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1024, 0x726576, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1025, 0x726576657274, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1026, 0x5265766572746564206564697473206279205b5b5370656369616c3a436f6e747269627574696f6e732f24327c24325d5d20285b5b557365725f74616c6b3a24327c54616c6b5d5d293b206368616e676564206261636b20746f206c6173742076657273696f6e206279205b5b557365723a24317c24315d5d, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1027, 0x5265766973696f6e20686973746f7279, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1028, 0x5265766973696f6e206173206f66202431, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1029, 0x5265766973696f6e206173206f662024313b2024323c6272202f3e2433207c202434, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1030, 0x44656c6574652f756e64656c657465207265766973696f6e73, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1031, 0x5265766973696f6e206e6f7420666f756e64, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1032, 0x546865206f6c64207265766973696f6e206f6620746865207061676520796f752061736b656420666f7220636f756c64206e6f7420626520666f756e642e0a506c6561736520636865636b207468652055524c20796f75207573656420746f20616363657373207468697320706167652e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1033, 0x687474703a2f2f7777772e696574662e6f72672f7266632f72666324312e747874, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1034, 0x5269676874733a, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1035, 0x546869732069732061206c6f67206f66206368616e67657320746f2075736572207269676874732e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1036, 0x526f6c6c206261636b206564697473, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1037, 0x526f6c6c6261636b, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1038, 0x526f6c6c6261636b206661696c6564, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1039, 0x726f6c6c6261636b, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1040, 0x526f77733a, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1041, 0x5361747572646179, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1042, 0x536176652070616765, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1043, 0x596f757220707265666572656e6365732068617665206265656e2073617665642e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1044, 0x536176652066696c65, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1045, 0x536176652047726f7570, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1046, 0x53617665, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1047, 0x5361766520557365722047726f757073, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1048, 0x5b496e74657277696b69207472616e73636c7564696e672069732064697361626c65645d, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1049, 0x5b54656d706c617465206665746368206661696c656420666f722024313b20736f7272795d, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1050, 0x5b55524c20697320746f6f206c6f6e673b20736f7272795d, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1051, 0x536561726368, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1052, 0x53656172636820666f722061727469636c657320636f6e7461696e696e67202727243127272e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1053, 0x7b7b534954454e414d457d7d207365617263682069732064697361626c65642e20596f752063616e207365617263682076696120476f6f676c6520696e20746865206d65616e74696d652e204e6f7465207468617420746865697220696e6465786573206f66207b7b534954454e414d457d7d20636f6e74656e74206d6179206265206f7574206f6620646174652e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1054, 0x5365617263682066756c6c2074657874, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1055, 0x53656172636820666f722061727469636c6573206e616d6564202727243127272e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1056, 0x466f722071756572792022243122, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1057, 0x53656172636820726573756c7473, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1058, 0x536561726368, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1059, 0x466f72206d6f726520696e666f726d6174696f6e2061626f757420736561726368696e67207b7b534954454e414d457d7d2c20736565205b5b50726f6a6563743a536561726368696e677c536561726368696e67207b7b534954454e414d457d7d5d5d2e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1060, 0xe28692, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1061, 0x53656c6563742061206e657765722076657273696f6e20666f7220636f6d70617269736f6e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1062, 0x53656c65637420616e206f6c6465722076657273696f6e20666f7220636f6d70617269736f6e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1063, 0x536f7572636520616e642064657374696e6174696f6e207469746c657320617265207468652073616d653b2063616e2774206d6f766520612070616765206f76657220697473656c662e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1064, 0x2727274e6f74653a2727272054686973207061676520686173206265656e206c6f636b656420736f2074686174206f6e6c7920726567697374657265642075736572732063616e20656469742069742e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1065, 0x536570, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1066, 0x53657074656d626572, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1067, 0x5365727665722074696d65, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1068, 0x3c7374726f6e673e536f7272792120576520636f756c64206e6f742070726f6365737320796f757220656469742064756520746f2061206c6f7373206f662073657373696f6e20646174612e0a506c656173652074727920616761696e2e204966206974207374696c6c20646f65736e277420776f726b2c20747279206c6f6767696e67206f757420616e64206c6f6767696e67206261636b20696e2e3c2f7374726f6e673e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1069, 0x3c7374726f6e673e536f7272792120576520636f756c64206e6f742070726f6365737320796f757220656469742064756520746f2061206c6f7373206f662073657373696f6e20646174612e3c2f7374726f6e673e0a0a27274265636175736520746869732077696b6920686173207261772048544d4c20656e61626c65642c2074686520707265766965772069732068696464656e20617320612070726563617574696f6e20616761696e7374204a6176615363726970742061747461636b732e27270a0a3c7374726f6e673e496620746869732069732061206c65676974696d617465206564697420617474656d70742c20706c656173652074727920616761696e2e204966206974207374696c6c20646f65736e277420776f726b2c20747279206c6f6767696e67206f757420616e64206c6f6767696e67206261636b20696e2e3c2f7374726f6e673e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1070, 0x5468657265207365656d7320746f20626520612070726f626c656d207769746820796f7572206c6f67696e2073657373696f6e3b0a7468697320616374696f6e20686173206265656e2063616e63656c656420617320612070726563617574696f6e20616761696e73742073657373696f6e2068696a61636b696e672e0a506c656173652068697420226261636b2220616e642072656c6f616420746865207061676520796f752063616d652066726f6d2c207468656e2074727920616761696e2e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1071, 0x3c623e557365722072696768747320666f72202224312220636f756c64206e6f74206265207365742e202844696420796f7520656e74657220746865206e616d6520636f72726563746c793f293c2f623e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1072, 0x536574207573657220726967687473, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1073, 0x536574206275726561756372617420666c6167, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1074, 0x536574207374657761726420666c6167, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1075, 0x2d, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1076, 0x546869732066696c652069732061207368617265642075706c6f616420616e64206d61792062652075736564206279206f746865722070726f6a656374732e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1077, 0x506c65617365207365652074686520243120666f72206675727468657220696e666f726d6174696f6e2e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1078, 0x66696c65206465736372697074696f6e2070616765, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1079, 0x53686f7274207061676573, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1080, 0x53686f77, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1081, 0x446f776e6c6f61642068696768207265736f6c7574696f6e2076657273696f6e202824317824322c202433204b4229, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1082, 0x53686f77206368616e676573, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1083, 0x28243120626f747329, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1084, 0x53686f77696e672062656c6f7720757020746f203c623e24313c2f623e20726573756c7473207374617274696e67207769746820233c623e24323c2f623e2e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1085, 0x53686f77696e672062656c6f77203c623e24333c2f623e20726573756c7473207374617274696e67207769746820233c623e24323c2f623e2e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1086, 0x53686f77206c6173742024312066696c657320736f727465642024322e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1087, 0x4c6976652070726576696577, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1088, 0x53686f772070726576696577, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1089, 0x73686f77, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1090, 0x0a2a206e617669676174696f6e0a2a2a206d61696e706167657c6d61696e706167650a2a2a20706f7274616c2d75726c7c706f7274616c0a2a2a2063757272656e746576656e74732d75726c7c63757272656e746576656e74730a2a2a20726563656e746368616e6765732d75726c7c726563656e746368616e6765730a2a2a2072616e646f6d706167652d75726c7c72616e646f6d706167650a2a2a2068656c70706167657c68656c700a2a2a2073697465737570706f72742d75726c7c73697465737570706f7274, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1091, 0x596f7572207369676e617475726520776974682074696d657374616d70, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1092, 0x7b7b696e743a6c6f67696e656e647d7d, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1093, 0x2d, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1094, 0x7b7b534954454e414d457d7d2073746174697374696373, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1095, 0x54686572652061726520272727243127272720746f74616c20706167657320696e207468652064617461626173652e0a5468697320696e636c75646573202274616c6b222070616765732c2070616765732061626f7574207b7b534954454e414d457d7d2c206d696e696d616c202273747562220a70616765732c207265646972656374732c20616e64206f746865727320746861742070726f6261626c7920646f6e2774207175616c69667920617320636f6e74656e742070616765732e0a4578636c7564696e672074686f73652c207468657265206172652027272724322727272070616765732074686174206172652070726f6261626c79206c65676974696d6174650a636f6e74656e742070616765732e200a0a27272724382727272066696c65732068617665206265656e2075706c6f616465642e0a0a54686572652068617665206265656e206120746f74616c206f6620272727243327272720706167652076696577732c20616e6420272727243427272720706167652065646974730a73696e6365207468652077696b69207761732073657475702e0a5468617420636f6d657320746f20272727243527272720617665726167652065646974732070657220706167652c20616e642027272724362727272076696577732070657220656469742e0a0a546865205b687474703a2f2f6d6574612e77696b696d656469612e6f72672f77696b692f48656c703a4a6f625f7175657565206a6f622071756575655d206c656e6774682069732027272724372727272e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1096, '', 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1097, 0x446f6e6174696f6e73, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1098, 0x50726f6a6563743a5369746520737570706f7274, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1099, 0x7b7b534954454e414d457d7d, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1100, 0x7b7b534954454e414d457d7d2075736572202431, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1101, 0x7b7b534954454e414d457d7d2075736572287329202431, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1102, 0x536b696e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1103, 0x285072657669657729, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1104, 0x534f52425320444e53424c, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1105, 0x596f75722049502061646472657373206973206c697374656420617320616e206f70656e2070726f787920696e20746865205b687474703a2f2f7777772e736f7262732e6e657420534f5242535d20444e53424c2e20596f752063616e6e6f742063726561746520616e206163636f756e74, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1106, 0x596f75722049502061646472657373206973206c697374656420617320616e206f70656e2070726f787920696e20746865205b687474703a2f2f7777772e736f7262732e6e657420534f5242535d20444e53424c2e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1107, 0x536f757263652066696c656e616d65, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1108, 0x416c6c207265766973696f6e7320636f6e7461696e6564206c696e6b7320746f2024312c20626c616e6b696e67, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1109, 0x526576657274696e6720746f206c6173742076657273696f6e206e6f7420636f6e7461696e696e67206c696e6b7320746f202431, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1110, 0x4d6564696157696b69207370616d20636c65616e7570, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1111, 0x54686520666f6c6c6f77696e672074657874206973207768617420747269676765726564206f7572207370616d2066696c7465723a202431, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1112, 0x546865207061676520796f752077616e74656420746f20736176652077617320626c6f636b656420627920746865207370616d2066696c7465722e20546869732069732070726f6261626c79206361757365642062792061206c696e6b20746f20616e2065787465726e616c20736974652e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1113, 0x5370616d2070726f74656374696f6e2066696c746572, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1114, 0x5469746c653a, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1115, 0x557365723a, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1116, 0x5370656369616c2050616765, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1117, 0x5370656369616c207061676573, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1118, 0x5370656369616c20706167657320666f7220616c6c207573657273, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1119, 0x2853514c2071756572792068696464656e29, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1120, 0x53746174697374696373, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1121, 0x53746f7265642076657273696f6e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1122, 0x5468726573686f6c6420666f72207374756220646973706c61793a, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1123, 0x53756263617465676f72696573, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1124, 0x5468657265206172652024312073756263617465676f7269657320746f20746869732063617465676f72792e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1125, 0x54686572652069732024312073756263617465676f727920746f20746869732063617465676f72792e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1126, 0x5375626a6563742f686561646c696e65, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1127, 0x56696577207375626a656374, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1128, 0x5375636365737366756c2075706c6f6164, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1129, 0x53756d6d617279, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1130, 0x53756e646179, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1131, 0x54686520616374696f6e20796f752068617665207265717565737465642063616e206f6e6c792062650a706572666f726d6564206279207573657273207769746820227379736f7022206361706162696c6974792e0a5365652024312e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1132, 0x5379736f7020616363657373207265717569726564, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1133, 0x7461626c65, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1134, 0x46726f6d207b7b534954454e414d457d7d, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1135, 0x44697363757373696f6e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1136, 0x272727546865207061676520697473656c6620776173206d6f766564207375636365737366756c6c792c20627574207468652074616c6b207061676520636f756c64206e6f74206265206d6f7665642062656361757365206f6e6520616c72656164792065786973747320617420746865206e6577207469746c652e20506c65617365206d65726765207468656d206d616e75616c6c792e272727, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1137, 0x4469736375737320746869732070616765, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1138, 0x54686520636f72726573706f6e64696e672074616c6b20706167652077617320616c736f206d6f7665642e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1139, 0x54686520636f72726573706f6e64696e672074616c6b207061676520776173203c7374726f6e673e6e6f743c2f7374726f6e673e206d6f7665642e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1140, 0x3c212d2d204d6564696157696b693a74616c6b7061676574657874202d2d3e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1141, 0x54656d706c617465732075736564206f6e207468697320706167653a, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1142, 0x45646974696e67, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1143, 0x506167652074657874206d617463686573, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1144, 0x56696577206f7220726573746f72652024313f, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1145, 0x456e6c61726765, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1146, 0x4572726f72206372656174696e67207468756d626e61696c3a202431, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1147, 0x5468756d626e61696c2073697a653a, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1148, 0x5468757273646179, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1149, 0x54696d65207a6f6e65, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1150, 0x4f6666736574c2b9, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1151, 0x546865206e756d626572206f6620686f75727320796f7572206c6f63616c2074696d6520646966666572732066726f6d207365727665722074696d652028555443292e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1152, 0x41727469636c65207469746c65206d617463686573, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1153, 0x436f6e74656e7473, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1154, 0x4d61726b2065646974732049206d616b6520617320706174726f6c6c6564, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1155, 0x45646974207061676573206f6e20646f75626c6520636c69636b20284a61766153637269707429, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1156, 0x456e61626c652073656374696f6e2065646974696e6720766961205b656469745d206c696e6b73, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1157, 0x456e61626c652073656374696f6e2065646974696e6720627920726967687420636c69636b696e673c6272202f3e206f6e2073656374696f6e207469746c657320284a61766153637269707429, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1158, 0x4564697420626f78206861732066756c6c207769647468, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1159, 0x452d6d61696c206d6520616c736f20666f72206d696e6f72206564697473206f66207061676573, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1160, 0x52657665616c206d7920652d6d61696c206164647265737320696e206e6f74696669636174696f6e206d61696c73, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1161, 0x452d6d61696c206d65207768656e206d7920757365722074616c6b2070616765206973206368616e676564, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1162, 0x452d6d61696c206d65206f6e2070616765206368616e676573, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1163, 0x5573652065787465726e616c20646966662062792064656661756c74, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1164, 0x5573652065787465726e616c20656469746f722062792064656661756c74, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1165, 0x526177207369676e6174757265732028776974686f7574206175746f6d61746963206c696e6b29, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1166, 0x50726f6d7074206d65207768656e20656e746572696e67206120626c616e6b20656469742073756d6d617279, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1167, 0x48696465206d696e6f7220656469747320696e20726563656e74206368616e676573, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1168, 0x466f726d61742062726f6b656e206c696e6b73203c6120687265663d222220636c6173733d226e6577223e6c696b6520746869733c2f613e2028616c7465726e61746976653a206c696b6520746869733c6120687265663d222220636c6173733d22696e7465726e616c223e3f3c2f613e292e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1169, 0x4a7573746966792070617261677261706873, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1170, 0x4d61726b20616c6c206564697473206d696e6f722062792064656661756c74, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1171, 0x44697361626c6520706167652063616368696e67, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1172, 0x4175746f2d6e756d6265722068656164696e6773, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1173, 0x53686f772070726576696577206f6e2066697273742065646974, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1174, 0x53686f772070726576696577206265666f7265206564697420626f78, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1175, 0x52656d656d626572206163726f73732073657373696f6e73, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1176, 0x456e61626c6520226a756d7020746f22206163636573736962696c697479206c696e6b73, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1177, 0x53686f7720746865206e756d626572206f66207761746368696e67207573657273, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1178, 0x53686f77207461626c65206f6620636f6e74656e74732028666f722070616765732077697468206d6f7265207468616e20332068656164696e677329, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1179, 0x53686f77206564697420746f6f6c62617220284a61766153637269707429, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1180, 0x556e6465726c696e65206c696e6b733a, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1181, 0x557365206c697665207072657669657720284a6176615363726970742920284578706572696d656e74616c29, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1182, 0x456e68616e63656420726563656e74206368616e67657320284a61766153637269707429, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1183, 0x41646420706167657320492063726561746520746f206d792077617463686c697374, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1184, 0x4164642070616765732049206564697420746f206d792077617463686c697374, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1185, 0x546f6f6c626f78, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1186, 0x5365652074686520646966666572656e636573206265747765656e207468652074776f2073656c65637465642076657273696f6e73206f66207468697320706167652e205b616c742d765d, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1187, 0x53686f77207768696368206368616e67657320796f75206d61646520746f2074686520746578742e205b616c742d645d, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1188, 0x4d61726b20746869732061732061206d696e6f722065646974205b616c742d695d, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1189, 0x5072657669657720796f7572206368616e6765732c20706c65617365207573652074686973206265666f726520736176696e6721205b616c742d705d, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1190, '', 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1191, 0x5361766520796f7572206368616e676573205b616c742d735d, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1192, 0x536561726368207b7b534954454e414d457d7d205b616c742d665d, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1193, 0x4164642074686973207061676520746f20796f75722077617463686c697374205b616c742d775d, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1194, 0x3b2024342435203a205b24322024315d, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1195, 0x3c6469762069643d226d775f747261636b6261636b73223e0a547261636b6261636b7320666f7220746869732061727469636c653a3c6272202f3e0a24310a3c2f6469763e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1196, 0x54686520747261636b6261636b20776173207375636365737366756c6c792064656c657465642e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1197, 0x3b2024342435203a205b24322024315d3a203c6e6f77696b693e24333c2f6e6f77696b693e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1198, 0x547261636b6261636b, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1199, 0x20285b24312044656c6574655d29, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1200, 0x547279206578616374206d61746368, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1201, 0x54756573646179, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1202, 0x5669657720746865206c617374202431206368616e6765733b207669657720746865206c61737420243220646179732e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1203, 0x42656c6f7720617265207468697320757365722773206c617374203c623e24313c2f623e206368616e67657320696e20746865206c617374203c623e24323c2f623e20646179732e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1204, 0x2028746f7029, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1205, 0x557365722049443a, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1206, 0x556e626c6f636b2075736572, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1207, 0x5573652074686520666f726d2062656c6f7720746f20726573746f7265207772697465206163636573730a746f20612070726576696f75736c7920626c6f636b65642049502061646472657373206f7220757365726e616d652e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1208, 0x756e626c6f636b, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1209, 0x756e626c6f636b6564202431, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1210, 0x556e63617465676f72697a65642063617465676f72696573, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1211, 0x556e63617465676f72697a6564207061676573, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1212, 0x566965772064656c65746564207061676573, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1213, 0x556e64656c657465202431206564697473, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1214, 0x556e64656c657465206f6e652065646974, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1215, 0x526573746f72652064656c657465642070616765, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1216, 0x526573746f726521, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1217, 0x726573746f72656420225b5b24315d5d22, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1218, 0x2431207265766973696f6e7320726573746f726564, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1219, 0x5b5b3a24317c24315d5d20686173206265656e207375636365737366756c6c7920726573746f7265642e0a536565205b5b5370656369616c3a4c6f672f64656c6574655d5d20666f722061207265636f7264206f6620726563656e742064656c6574696f6e7320616e6420726573746f726174696f6e732e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1220, 0x496620796f7520726573746f72652074686520706167652c20616c6c207265766973696f6e732077696c6c20626520726573746f72656420746f2074686520686973746f72792e0a49662061206e657720706167652077697468207468652073616d65206e616d6520686173206265656e20637265617465642073696e6365207468652064656c6574696f6e2c2074686520726573746f7265640a7265766973696f6e732077696c6c2061707065617220696e20746865207072696f7220686973746f72792c20616e64207468652063757272656e74207265766973696f6e206f6620746865206c69766520706167650a77696c6c206e6f74206265206175746f6d61746963616c6c79207265706c616365642e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1221, 0x546869732061727469636c6520686173206265656e2064656c657465642e2054686520726561736f6e20666f722064656c6574696f6e2069730a73686f776e20696e207468652073756d6d6172792062656c6f772c20616c6f6e6720776974682064657461696c73206f66207468652075736572732077686f2068616420656469746564207468697320706167650a6265666f72652064656c6574696f6e2e205468652061637475616c2074657874206f662074686573652064656c65746564207265766973696f6e73206973206f6e6c7920617661696c61626c6520746f2061646d696e6973747261746f72732e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1222, 0x5669657720616e6420726573746f72652064656c65746564207061676573, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1223, 0x54686520666f6c6c6f77696e672070616765732068617665206265656e2064656c657465642062757420617265207374696c6c20696e20746865206172636869766520616e640a63616e20626520726573746f7265642e205468652061726368697665206d617920626520706572696f646963616c6c7920636c65616e6564206f75742e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1224, 0x44656c65746564207265766973696f6e206173206f66202431, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1225, 0x2431207265766973696f6e73206172636869766564, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1226, 0x416c77617973, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1227, 0x42726f777365722064656661756c74, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1228, 0x4e65766572, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1229, 0x556e65787065637465642076616c75653a20222431223d222432222e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1230, 0x7078, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1231, 0x556e6c6f636b206461746162617365, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1232, 0x5965732c2049207265616c6c792077616e7420746f20756e6c6f636b207468652064617461626173652e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1233, 0x556e6c6f636b206461746162617365, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1234, 0x4461746162617365206c6f636b2072656d6f766564, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1235, 0x54686520646174616261736520686173206265656e20756e6c6f636b65642e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1236, 0x556e6c6f636b696e67207468652064617461626173652077696c6c20726573746f726520746865206162696c697479206f6620616c6c0a757365727320746f20656469742070616765732c206368616e676520746865697220707265666572656e6365732c20656469742074686569722077617463686c697374732c20616e640a6f74686572207468696e677320726571756972696e67206368616e67657320696e207468652064617461626173652e0a506c6561736520636f6e6669726d20746861742074686973206973207768617420796f7520696e74656e6420746f20646f2e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1237, 0x756e70726f74656374, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1238, 0x526561736f6e20666f7220756e70726f74656374696e67, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1239, 0x756e70726f74656374656420225b5b24315d5d22, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1240, 0x28556e70726f74656374696e67202224312229, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1241, 0x556e70726f7465637420746869732070616765, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1242, 0x556e757365642063617465676f72696573, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1243, 0x54686520666f6c6c6f77696e672063617465676f727920706167657320657869737420616c74686f756768206e6f206f746865722061727469636c65206f722063617465676f7279206d616b6520757365206f66207468656d2e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1244, 0x556e757365642066696c6573, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1245, 0x3c703e506c65617365206e6f74652074686174206f7468657220776562207369746573206d6179206c696e6b20746f20616e20696d61676520776974680a61206469726563742055524c2c20616e6420736f206d6179207374696c6c206265206c697374656420686572652064657370697465206265696e670a696e20616374697665207573652e3c2f703e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1246, 0x556e7761746368, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1247, 0x556e77617463686564207061676573, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1248, 0x53746f70207761746368696e67, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1249, 0x285570646174656429, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1250, 0x757064617465642073696e6365206d79206c617374207669736974, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1251, 0x55706c6f61642066696c65, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1252, 0x5468652075706c6f6164206469726563746f72792028243129206973206e6f74207772697461626c6520627920746865207765627365727665722e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1253, 0x55706c6f61642066696c65, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1254, 0x5468652066696c6520697320636f7272757074206f722068617320616e20696e636f727265637420657874656e73696f6e2e20506c6561736520636865636b207468652066696c6520616e642075706c6f616420616761696e2e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1255, 0x55706c6f6164732064697361626c6564, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1256, 0x46696c652075706c6f616473206172652064697361626c6564206f6e20746869732077696b692e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1257, 0x55706c6f616465642066696c6573, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1258, 0x75706c6f6164656420225b5b24315d5d22, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1259, 0x55706c6f6164206572726f72, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1260, 0x55706c6f616420696d61676573, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1261, 0x75706c6f6164206c6f67, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1262, 0x55706c6f61645f6c6f67, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1263, 0x42656c6f772069732061206c697374206f6620746865206d6f737420726563656e742066696c652075706c6f6164732e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1264, 0x5b24312055706c6f61642061206e65772076657273696f6e206f6620746869732066696c655d, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1265, 0x4e6f74206c6f6767656420696e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1266, 0x596f75206d757374206265205b5b5370656369616c3a557365726c6f67696e7c6c6f6767656420696e5d5d0a746f2075706c6f61642066696c65732e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1267, 0x546869732066696c6520636f6e7461696e732048544d4c206f722073637269707420636f64652074686174206d6179206265206572726f6e656f75736c7920626520696e7465727072657465642062792061207765622062726f777365722e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1268, 0x5573652074686520666f726d2062656c6f7720746f2075706c6f61642066696c65732c20746f2076696577206f72207365617263682070726576696f75736c792075706c6f6164656420696d6167657320676f20746f20746865205b5b5370656369616c3a496d6167656c6973747c6c697374206f662075706c6f616465642066696c65735d5d2c2075706c6f61647320616e642064656c6574696f6e732061726520616c736f206c6f6767656420696e20746865205b5b5370656369616c3a4c6f672f75706c6f61647c75706c6f6164206c6f675d5d2e0a0a546f20696e636c7564652074686520696d61676520696e206120706167652c207573652061206c696e6b20696e2074686520666f726d0a2727273c6e6f77696b693e5b5b7b7b6e733a367d7d3a66696c652e6a70675d5d3c2f6e6f77696b693e2727272c0a2727273c6e6f77696b693e5b5b7b7b6e733a367d7d3a66696c652e706e677c616c7420746578745d5d3c2f6e6f77696b693e272727206f720a2727273c6e6f77696b693e5b5b7b7b6e733a2d327d7d3a66696c652e6f67675d5d3c2f6e6f77696b693e27272720666f72206469726563746c79206c696e6b696e6720746f207468652066696c652e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1269, 0x5468652066696c6520636f6e7461696e732061207669727573212044657461696c733a202431, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1270, 0x55706c6f6164207761726e696e67, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1271, 0x310a0a5365742066697273742063686172616374657220746f2022302220746f2064697361626c6520746865206e65772063617465676f72792070616765206c61796f75742e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1272, 0x3c623e557365722072696768747320666f72202224312220757064617465643c2f623e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1273, 0x3c7374726f6e673e5469703a3c2f7374726f6e673e2055736520746865202753686f7720707265766965772720627574746f6e20746f207465737420796f7572206e6577204353532f4a53206265666f726520736176696e672e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1274, 0x27272752656d656d626572207468617420796f7520617265206f6e6c792070726576696577696e6720796f75722075736572204353532c20697420686173206e6f7420796574206265656e20736176656421272727, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1275, 0x557365726e616d6520656e746572656420616c726561647920696e207573652e20506c656173652063686f6f7365206120646966666572656e74206e616d652e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1276, 0x2727275761726e696e673a272727205468657265206973206e6f20736b696e20222431222e2052656d656d626572207468617420637573746f6d202e63737320616e64202e6a73207061676573207573652061206c6f77657263617365207469746c652c20652e672e20557365723a466f6f2f6d6f6e6f626f6f6b2e637373206173206f70706f73656420746f20557365723a466f6f2f4d6f6e6f626f6f6b2e6373732e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1277, 0x27272752656d656d626572207468617420796f7520617265206f6e6c792074657374696e672f70726576696577696e6720796f75722075736572204a6176615363726970742c20697420686173206e6f7420796574206265656e20736176656421272727, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1278, 0x4c6f6720696e202f20637265617465206163636f756e74, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1279, 0x4c6f67206f7574, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1280, 0x4d61696c206f626a6563742072657475726e6564206572726f723a, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1281, 0x557365726e616d653a, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1282, 0x5669657720757365722070616765, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1283, 0x5573657220726967687473206d616e6167656d656e74, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1284, 0x4564697420757365722067726f757073, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1285, 0x417661696c61626c652067726f7570733a, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1286, 0x53656c6563742067726f75707320796f752077616e7420746865207573657220746f2062652072656d6f7665642066726f6d206f7220616464656420746f2e0a556e73656c65637465642067726f7570732077696c6c206e6f74206265206368616e6765642e20596f752063616e20646573656c65637420612067726f75702077697468204354524c202b204c65667420436c69636b, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1287, 0x4d656d626572206f663a, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1288, 0x4368616e6765642067726f7570206d656d626572736869702066726f6d20243120746f202432, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1289, 0x4d616e61676520757365722067726f757073, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1290, 0x456e746572206120757365726e616d653a, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1291, 0x557365722073746174697374696373, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1292, 0x54686572652061726520272727243127272720726567697374657265642075736572732c206f662077686963680a272727243227272720286f722027272724342527272729206172652061646d696e6973747261746f72732028736565202433292e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1293, 0x7372, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1294, 0x73722d6563, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1295, 0x73722d656c, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1296, 0x73722d6a63, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1297, 0x73722d6a6c, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1298, 0x7a68, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1299, 0x636e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1300, 0x686b, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1301, 0x7367, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1302, 0x7477, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1303, 0x56657273696f6e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1304, 0x56657273696f6e202431206f66204d6564696157696b69207265717569726564, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1305, 0x56657273696f6e202431206f66204d6564696157696b6920697320726571756972656420746f20757365207468697320706167652e20536565205b5b5370656369616c3a56657273696f6e5d5d, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1306, 0x54686973207061676520686173206265656e2061636365737365642024312074696d65732e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1307, 0x566965772024313f, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1308, 0x566965772064656c65746564207061676573, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1309, 0x566965772028243129202824322920282433292e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1310, 0x5669657773, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1311, 0x5669657720736f75726365, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1312, 0x666f72202431, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1313, 0x566965772064697363757373696f6e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1314, 0x57616e7465642063617465676f72696573, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1315, 0x57616e746564207061676573, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1316, 0x5761746368, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1317, 0x2a2024312070616765732077617463686564206e6f7420636f756e74696e672074616c6b2070616765730a2a205b5b5370656369616c3a57617463686c6973742f656469747c53686f7720616e64206564697420636f6d706c6574652077617463686c6973745d5d, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1318, 0x48657265277320616e20616c7068616265746963616c206c697374206f6620796f75720a7761746368656420636f6e74656e742070616765732e20436865636b2074686520626f786573206f6620706167657320796f752077616e7420746f2072656d6f76652066726f6d20796f75722077617463686c69737420616e6420636c69636b20746865202772656d6f766520636865636b65642720627574746f6e0a61742074686520626f74746f6d206f66207468652073637265656e202864656c6574696e67206120636f6e74656e74207061676520616c736f2064656c6574657320746865206163636f6d70616e79696e672074616c6b207061676520616e642076696365207665727361292e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1319, 0x4d792077617463686c697374, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1320, 0x616c6c, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1321, 0x616c6c, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1322, 0x596f75722077617463686c69737420636f6e7461696e732024312070616765732e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1323, 0x28666f722075736572202224312229, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1324, 0x636865636b696e67207761746368656420706167657320666f7220726563656e74206564697473, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1325, 0x636865636b696e6720726563656e7420656469747320666f722077617463686564207061676573, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1326, 0x4e6f6e65206f6620796f75722077617463686564206974656d73207761732065646974656420696e207468652074696d6520706572696f6420646973706c617965642e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1327, 0x4e6f74206c6f6767656420696e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1328, 0x596f75206d757374206265205b5b5370656369616c3a557365726c6f67696e7c6c6f6767656420696e5d5d20746f206d6f6469667920796f75722077617463686c6973742e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1329, 0x576174636820746869732070616765, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1330, 0x576174636820746869732070616765, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1331, 0x5765646e6573646179, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1332, 0x3d3d2057656c636f6d652c20243121203d3d0a0a596f7572206163636f756e7420686173206265656e20637265617465642e20446f6e277420666f7267657420746f206368616e676520796f7572207b7b534954454e414d457d7d20707265666572656e6365732e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1333, 0x57686174206c696e6b732068657265, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1334, 0x546f20626520616c6c6f77656420746f20637265617465206163636f756e747320696e20746869732057696b6920796f75206861766520746f205b5b5370656369616c3a557365726c6f67696e7c6c6f675d5d20696e20616e6420686176652074686520617070726f707269617465207065726d697373696f6e732e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1335, 0x596f7520617265206e6f7420616c6c6f77656420746f2063726561746520616e206163636f756e74, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1336, 0x596f75206861766520746f205b5b5370656369616c3a557365726c6f67696e7c6c6f67696e5d5d20746f20656469742070616765732e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1337, 0x4c6f67696e20726571756972656420746f2065646974, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1338, 0x596f75206861766520746f205b5b5370656369616c3a557365726c6f67696e7c6c6f67696e5d5d20746f20726561642070616765732e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1339, 0x4c6f67696e20726571756972656420746f2072656164, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1340, 0x2431782432, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1341, 0x566965772070726f6a6563742070616765, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1342, 0x2a20452d6d61696c206e6f74696669636174696f6e20697320656e61626c65642e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1343, 0x2a2050616765732077686963682068617665206265656e206368616e6765642073696e636520796f75206c6173742076697369746564207468656d206172652073686f776e20696e20272727626f6c64272727, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1344, 0x48696465, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1345, 0x243120626f742065646974732e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1346, 0x2431206d792065646974732e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1347, 0x42656c6f772061726520746865206c617374202431206368616e67657320696e20746865206c617374203c623e24323c2f623e20686f7572732e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1348, 0x5468697320697320612073617665642076657273696f6e206f6620796f75722077617463686c6973742e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1349, 0x53686f77, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1350, 0x53686f77206c61737420243120686f7572732024322064617973202433, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1351, 0x496e636f727265637420706172616d657465727320746f207766517565727928293c6272202f3e0a46756e6374696f6e3a2024313c6272202f3e0a51756572793a202432, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1352, 0x496e636f72726563742070617373776f726420656e74657265642e20506c656173652074727920616761696e2e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1353, 0x50617373776f726420656e74657265642077617320626c616e6b2e20506c656173652074727920616761696e2e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1354, 0x596f75206861766520243120282432292e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1355, 0x596f752068617665206e6577206d65737361676573206f6e202431, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1356, 0x446966666572656e636573, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1357, 0x596f757220646f6d61696e, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1358, 0x452d6d61696c202a, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1359, 0x4c616e67756167653a, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1360, 0x557365726e616d65, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1361, 0x4e69636b6e616d653a, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1362, 0x50617373776f7264, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1363, 0x5265747970652070617373776f7264, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1364, 0x5265616c206e616d65202a, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1365, 0x596f75722074657874, 0x7574662d38);
INSERT INTO `wiki_text` VALUES (1366, 0x56617269616e74, 0x7574662d38);

-- --------------------------------------------------------

-- 
-- Table structure for table `wiki_trackbacks`
-- 

CREATE TABLE `wiki_trackbacks` (
  `tb_id` int(11) NOT NULL auto_increment,
  `tb_page` int(11) default NULL,
  `tb_title` varchar(255) NOT NULL default '',
  `tb_url` varchar(255) NOT NULL default '',
  `tb_ex` text,
  `tb_name` varchar(255) default NULL,
  PRIMARY KEY  (`tb_id`),
  KEY `tb_page` (`tb_page`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `wiki_trackbacks`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `wiki_transcache`
-- 

CREATE TABLE `wiki_transcache` (
  `tc_url` varchar(255) NOT NULL default '',
  `tc_contents` text,
  `tc_time` int(11) NOT NULL default '0',
  UNIQUE KEY `tc_url_idx` (`tc_url`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `wiki_transcache`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `wiki_user`
-- 

CREATE TABLE `wiki_user` (
  `user_id` int(5) unsigned NOT NULL auto_increment,
  `user_name` varchar(255) character set latin1 collate latin1_bin NOT NULL default '',
  `user_real_name` varchar(255) character set latin1 collate latin1_bin NOT NULL default '',
  `user_password` tinyblob NOT NULL,
  `user_newpassword` tinyblob NOT NULL,
  `user_email` tinytext NOT NULL,
  `user_options` blob NOT NULL,
  `user_touched` varchar(14) character set latin1 collate latin1_bin NOT NULL default '',
  `user_token` varchar(32) character set latin1 collate latin1_bin NOT NULL default '',
  `user_email_authenticated` varchar(14) character set latin1 collate latin1_bin default NULL,
  `user_email_token` varchar(32) character set latin1 collate latin1_bin default NULL,
  `user_email_token_expires` varchar(14) character set latin1 collate latin1_bin default NULL,
  `user_registration` varchar(14) character set latin1 collate latin1_bin default NULL,
  PRIMARY KEY  (`user_id`),
  UNIQUE KEY `user_name` (`user_name`),
  KEY `user_email_token` (`user_email_token`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- 
-- Dumping data for table `wiki_user`
-- 

INSERT INTO `wiki_user` VALUES (1, 0x41646d696e, '', 0x6133353831333036313139616230616434373432383762353338306465636464, '', '', 0x717569636b6261723d310a756e6465726c696e653d320a636f6c733d38300a726f77733d32350a7365617263686c696d69743d32300a636f6e746578746c696e65733d350a636f6e7465787463686172733d35300a736b696e3d6d6f6e6f626f6f6b0a6d6174683d310a7263646179733d370a72636c696d69743d35300a686967686c6967687462726f6b656e3d310a737475627468726573686f6c643d300a707265766965776f6e746f703d310a6564697473656374696f6e3d310a6564697473656374696f6e6f6e7269676874636c69636b3d300a73686f77746f633d310a73686f77746f6f6c6261723d310a646174653d300a696d61676573697a653d320a7468756d6273697a653d320a72656d656d62657270617373776f72643d300a656e6f74696677617463686c69737470616765733d300a656e6f7469667573657274616c6b70616765733d310a656e6f7469666d696e6f7265646974733d300a656e6f74696672657665616c616464723d300a73686f776e756d626572737761746368696e673d310a66616e63797369673d300a65787465726e616c656469746f723d300a65787465726e616c646966663d300a73686f776a756d706c696e6b733d310a6e756d62657268656164696e67733d300a7573656c697665707265766965773d300a76617269616e743d656e0a6c616e67756167653d656e0a7365617263684e73303d31, 0x3230303730323031303430353332, 0x3331643765616231363530643636363537393665353737373834396164313463, NULL, NULL, NULL, 0x3230303730313331323030363034);
INSERT INTO `wiki_user` VALUES (2, 0x44656d6f, 0x44656d6f2055736572, 0x3763616665313237333937383261623836376431663031616533666661373638, '', '', 0x717569636b6261723d310a756e6465726c696e653d320a636f6c733d38300a726f77733d32350a7365617263686c696d69743d32300a636f6e746578746c696e65733d350a636f6e7465787463686172733d35300a736b696e3d6d6f6e6f626f6f6b0a6d6174683d310a7263646179733d370a72636c696d69743d35300a686967686c6967687462726f6b656e3d310a737475627468726573686f6c643d300a707265766965776f6e746f703d310a6564697473656374696f6e3d310a6564697473656374696f6e6f6e7269676874636c69636b3d300a73686f77746f633d310a73686f77746f6f6c6261723d310a646174653d300a696d61676573697a653d320a7468756d6273697a653d320a72656d656d62657270617373776f72643d310a656e6f74696677617463686c69737470616765733d300a656e6f7469667573657274616c6b70616765733d310a656e6f7469666d696e6f7265646974733d300a656e6f74696672657665616c616464723d300a73686f776e756d626572737761746368696e673d310a66616e63797369673d300a65787465726e616c656469746f723d300a65787465726e616c646966663d300a73686f776a756d706c696e6b733d310a6e756d62657268656164696e67733d300a7573656c697665707265766965773d300a76617269616e743d656e0a6c616e67756167653d656e0a7365617263684e73303d31, 0x3230303730323031303430343534, 0x6539313230613264353531373236376263643434323732333663643964386339, NULL, NULL, NULL, 0x3230303730323031303430343439);

-- --------------------------------------------------------

-- 
-- Table structure for table `wiki_user_groups`
-- 

CREATE TABLE `wiki_user_groups` (
  `ug_user` int(5) unsigned NOT NULL default '0',
  `ug_group` char(16) NOT NULL default '',
  PRIMARY KEY  (`ug_user`,`ug_group`),
  KEY `ug_group` (`ug_group`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `wiki_user_groups`
-- 

INSERT INTO `wiki_user_groups` VALUES (1, 'bureaucrat');
INSERT INTO `wiki_user_groups` VALUES (1, 'sysop');

-- --------------------------------------------------------

-- 
-- Table structure for table `wiki_user_newtalk`
-- 

CREATE TABLE `wiki_user_newtalk` (
  `user_id` int(5) NOT NULL default '0',
  `user_ip` varchar(40) NOT NULL default '',
  KEY `user_id` (`user_id`),
  KEY `user_ip` (`user_ip`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `wiki_user_newtalk`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `wiki_validate`
-- 

CREATE TABLE `wiki_validate` (
  `val_user` int(11) NOT NULL default '0',
  `val_page` int(11) unsigned NOT NULL default '0',
  `val_revision` int(11) unsigned NOT NULL default '0',
  `val_type` int(11) unsigned NOT NULL default '0',
  `val_value` int(11) default '0',
  `val_comment` varchar(255) NOT NULL default '',
  `val_ip` varchar(20) NOT NULL default '',
  KEY `val_user` (`val_user`,`val_revision`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `wiki_validate`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `wiki_watchlist`
-- 

CREATE TABLE `wiki_watchlist` (
  `wl_user` int(5) unsigned NOT NULL default '0',
  `wl_namespace` int(11) NOT NULL default '0',
  `wl_title` varchar(255) character set latin1 collate latin1_bin NOT NULL default '',
  `wl_notificationtimestamp` varchar(14) character set latin1 collate latin1_bin default NULL,
  UNIQUE KEY `wl_user` (`wl_user`,`wl_namespace`,`wl_title`),
  KEY `namespace_title` (`wl_namespace`,`wl_title`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `wiki_watchlist`
-- 

