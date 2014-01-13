<?php

/**
 * Contao Open Source CMS
 *
 * @copyright  MEN AT WORK 2014 
 * @package    PiwikTrackingTag
 * @license    GNU/LGPL
 * @filesource
 */

/**
 * Legends
 */
$GLOBALS['TL_LANG']['tl_layout']['piwik_legend'] = 'Piwik';

/**
 * Fields
 */
$GLOBALS['TL_LANG']['tl_layout']['piwikEnabled'] = array('Include Piwik javascript tag into the site', 'Adds the Piwik javascript tag to the site.');
$GLOBALS['TL_LANG']['tl_layout']['piwikCountAdmins'] = array('Include users', 'Include users who are logged in into the TYPOlight backend into the statistic.');
$GLOBALS['TL_LANG']['tl_layout']['piwikCountUsers'] = array('Include members', 'Include members who are logged in into the TYPOlight frontend into the statistic.');
$GLOBALS['TL_LANG']['tl_layout']['piwikPath'] = array('URL of the Piwik installation', "The absolute URL to Piwik installation, with optional server.");
$GLOBALS['TL_LANG']['tl_layout']['piwikSiteID'] = array('Site ID', 'The ID of the site that was created in Piwik.');
$GLOBALS['TL_LANG']['tl_layout']['piwikPageName'] = array('Use page title', 'Use the page title instead of the alias in the statistic.');
$GLOBALS['TL_LANG']['tl_layout']['piwik404'] = array('Show reference to <em>404 Page not found</em> seperate', 'You have the possibility to show references to <em>404 Page not found</em> in the piwik statistic seperate. So you can find "dead links" easier.');
$GLOBALS['TL_LANG']['tl_layout']['piwikTemplate'] = array('Template', 'Here you can select the piwik template. Important: Please note that the asynchronous template is supported from piwik version 1.12.');