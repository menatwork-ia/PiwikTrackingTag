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
 * @package    PiwikTrackingTag
 * @license    GNU/LGPL
 * @filesource
 */ 

/**
 * Hooks
 */
$GLOBALS['TL_HOOKS']['generatePage'][] = array('PiwikTrackingTag', 'generatePage');
$GLOBALS['TL_HOOKS']['addCustomRegexp'][] = array('PiwikTrackingTag', 'validatePath');
$GLOBALS['TL_HOOKS']['addCustomRegexp'][] = array('PiwikTrackingTag', 'validateUrl');
$GLOBALS['TL_HOOKS']['addCustomRegexp'][] = array('PiwikTrackingTag', 'validateIP');
$GLOBALS['TL_HOOKS']['parseBackendTemplate'][] = array('PiwikTrackingTag', 'checkExtensions');

/**
 * Download extensions
 */
$GLOBALS['TL_PIWIK'] = '7z,aac,arc,arj,asf,asx,avi,bin,csv,doc,exe,flv,gif,gz,gzip,hqx,jar,jpe,jpeg,js,mp2,mp3,mp4,mpe,mpeg,mov,movie,msi,msp,pdf,phps,png,ppt,qtm,ram,rar,sea,sit,tar,tgz,orrent,txt,wav,wma,wmv,wpd,xls,xml,z,zip';

?>