<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2011 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 3 of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at <http://www.gnu.org/licenses/>.
 *
 * PHP version 5
 * @copyright  Torben Stoffer 2009, MEN AT WORK 2011
 * @package    Language
 * @license    GNU/LGPL
 * @filesource
 */ 

/**
 * Legends
 */
$GLOBALS['TL_LANG']['tl_page']['piwik_legend'] = 'Piwik';

/**
 * Fields
 */
$GLOBALS['TL_LANG']['tl_page']['piwikEnabled'] = array('Include Piwik javascript tag into the site', 'Adds the Piwik javascript tag to the site.');
$GLOBALS['TL_LANG']['tl_page']['piwikCountAdmins'] = array('Include users', 'Include users who are logged in into the TYPOlight backend into the statistic.');
$GLOBALS['TL_LANG']['tl_page']['piwikCountUsers'] = array('Include members', 'Include members who are logged in into the TYPOlight frontend into the statistic.');
$GLOBALS['TL_LANG']['tl_page']['piwikPath'] = array('URL of the Piwik installation', "The absolute URL to Piwik installation, with optional server.");
$GLOBALS['TL_LANG']['tl_page']['piwikSiteID'] = array('Site ID', 'The ID of the site that was created in Piwik.');
$GLOBALS['TL_LANG']['tl_page']['piwikPageName'] = array('Use page title', 'Use the page title instead of the alias in the statistic.');
$GLOBALS['TL_LANG']['tl_page']['piwik404'] = array('Show reference to <em>404 Page not found</em> seperate', 'You have the possibility to show references to <em>404 Page not found</em> in the piwik statistic seperate. So you can find "dead links" easier.');


?>