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