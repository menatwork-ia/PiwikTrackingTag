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
 * Palettes
 */
$GLOBALS['TL_DCA']['tl_page']['palettes']['root'] = str_replace('{publish_legend', '{piwik_legend},piwikEnabled;{publish_legend', $GLOBALS['TL_DCA']['tl_page']['palettes']['root']);
$GLOBALS['TL_DCA']['tl_page']['palettes']['__selector__'][] = 'piwikEnabled';

/**
 * Subpalettes
 */
$GLOBALS['TL_DCA']['tl_page']['subpalettes']['piwikEnabled'] = 'piwikPath,piwikSiteID,piwikExtensions,piwikCountAdmins,piwikCountUsers,piwikPageName,piwik404';

/**
 * Fields
 */ 
$GLOBALS['TL_DCA']['tl_page']['fields'] = array_merge(
	$GLOBALS['TL_DCA']['tl_page']['fields'], array(
		'piwikEnabled' => array(
			'label' => &$GLOBALS['TL_LANG']['tl_page']['piwikEnabled'],
			'inputType' => 'checkbox',
			'exclude' => true,
			'eval' => array('submitOnChange' => true)
		),
		'piwikPath' => array(
			'label' => &$GLOBALS['TL_LANG']['tl_page']['piwikPath'],
			'inputType' => 'text',
			'exclude' => true,
			'eval' => array('mandatory' => true, 'rgxp' => 'piwikPath', 'trailingSlash' => true, 'tl_class' => 'w50')
		),
		'piwikSiteID' => array(
			'label' => &$GLOBALS['TL_LANG']['tl_page']['piwikSiteID'],
			'inputType' => 'text',
			'exclude' => true,
			'eval' => array('mandatory' => true, 'rgxp' => 'digit', 'tl_class' => 'w50', 'maxlength' => 4)
		),
		'piwikExtensions' => array(
			'label' => &$GLOBALS['TL_LANG']['tl_page']['piwikExtensions'],
			// 'default' => '7z,aac,arc,arj,asf,asx,avi,bin,csv,doc,exe,flv,gif,gz,gzip,hqx,jar,jpe,jpeg,js,mp2,mp3,mp4,mpe,mpeg,mov,movie,msi,msp,pdf,phps,png,ppt,qtm,ram,rar,sea,sit,tar,tgz,orrent,txt,wav,wma,wmv,wpd,xls,xml,z,zip',
			'default' => array_keys($GLOBALS['TL_PIWIK']),
			'inputType' => 'textarea',
			'exclude' => true,
			'eval' => array('tl_class' => 'long clr', 'style' => 'height:50px;', 'alwaysSave' => true),
			'load_callback'	=> array(
				array('tl_page_PiwikTrackingTag', 'extensions')
			),
			'save_callback'	=> array(
				array('tl_page_PiwikTrackingTag', 'extensions')
			)
		),
		'piwikCountAdmins' => array(
			'label' => &$GLOBALS['TL_LANG']['tl_page']['piwikCountAdmins'],
			'inputType' => 'checkbox',
			'exclude' => true,
			'eval' => array('tl_class' => 'w50')
		),
		'piwikCountUsers' => array(
			'label'	=> &$GLOBALS['TL_LANG']['tl_page']['piwikCountUsers'],
			'default' => '1',
			'inputType' => 'checkbox',
			'exclude' => true,
			'eval' => array('tl_class' => 'w50')
		),
		'piwikPageName' => array(
			'label' => &$GLOBALS['TL_LANG']['tl_page']['piwikPageName'],
			'inputType' => 'checkbox',
			'exclude' => true,
			'eval' => array('tl_class' => 'w50')
		),
		'piwik404' => array(
			'label' => &$GLOBALS['TL_LANG']['tl_page']['piwik404'],
			'inputType' => 'checkbox',
			'exclude' => true,
			'eval' => array('tl_class' => 'w50')
		),
	)
);

class tl_page_PiwikTrackingTag extends Backend
{
	public function extensions($value)
	{
		if(trim($value) == '')
		{
			return $GLOBALS['TL_DCA']['tl_page']['fields']['piwikExtensions']['default'];
		}
		else
		{
			return $value;
		}
	}
}


?>