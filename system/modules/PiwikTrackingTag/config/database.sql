-- ********************************************************
-- *                                                      *
-- * IMPORTANT NOTE                                       *
-- *                                                      *
-- * Do not import this file manually but use the Contao  *
-- * install tool to create and maintain database tables! *
-- *                                                      *
-- ********************************************************

-- 
-- Table `tl_layout`
-- 

CREATE TABLE `tl_layout` (
  `piwikEnabled` char(1) NOT NULL default '',
  `piwikPath` varchar(255) NOT NULL default '',
  `piwikSiteID` varchar(4) NOT NULL default '',
  `piwikUserToken` varchar(32) NOT NULL default '',
  `piwikCountAdmins` char(1) NOT NULL default '0',
  `piwikCountUsers` char(1) NOT NULL default '1',
  `piwikPageName` char(1) NOT NULL default '0',
  `piwik404` char(1) NOT NULL default '0',
  `piwikExtensions` text NULL,
  `piwikVisitorCookieTimeout` int(10) unsigned NOT NULL default '0',
  `piwikDownloadClasses` varchar(255) NOT NULL default '',
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table `tl_page`
--

CREATE TABLE `tl_page` (
  `piwikEnabled` char(1) NOT NULL default '',
  `piwikPath` varchar(255) NOT NULL default '',
  `piwikSiteID` varchar(4) NOT NULL default '',
  `piwikUserToken` varchar(32) NOT NULL default '',
  `piwikCountAdmins` char(1) NOT NULL default '0',
  `piwikCountUsers` char(1) NOT NULL default '1',
  `piwikPageName` char(1) NOT NULL default '0',
  `piwik404` char(1) NOT NULL default '0',
  `piwikExtensions` text NULL,
  `piwikVisitorCookieTimeout` int(10) unsigned NOT NULL default '0',
  `piwikDownloadClasses` varchar(255) NOT NULL default '',
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
