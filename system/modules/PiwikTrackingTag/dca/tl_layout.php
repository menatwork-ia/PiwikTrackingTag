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
$GLOBALS['TL_DCA']['tl_layout']['palettes']['__selector__'][] = 'piwikEnabled';
 
foreach($GLOBALS['TL_DCA']['tl_layout']['palettes'] as $k => $v) 
{
	if($k != '__selector__') 
	{
		if(strstr($v, '{expert_legend'))
		{
			$GLOBALS['TL_DCA']['tl_layout']['palettes'][$k] = str_replace('{expert_legend', '{piwik_legend},piwikEnabled;{expert_legend', $v);
		}
		elseif(strstr($v, 'urchinId;'))
		{
			$GLOBALS['TL_DCA']['tl_layout']['palettes'][$k] = str_replace('urchinId;', 'urchinId;piwikEnabled;', $v);
		}
		else
		{
			$GLOBALS['TL_DCA']['tl_layout']['palettes'][$k] = str_replace('urchinId,', 'urchinId;piwikEnabled;', $v);
		}
	}
}


/**
 * Subpalettes
 */
$GLOBALS['TL_DCA']['tl_layout']['subpalettes']['piwikEnabled'] = 'piwikPath,piwikSiteID,piwikExtensions,piwikCountAdmins,piwikCountUsers,piwikPageName,piwik404';


/**
 * Fields
 */ 
$GLOBALS['TL_DCA']['tl_layout']['fields'] = array_merge(
	$GLOBALS['TL_DCA']['tl_layout']['fields'], array(
		'piwikEnabled' => array(
			'label' => &$GLOBALS['TL_LANG']['tl_layout']['piwikEnabled'],
			'inputType' => 'checkbox',
			'exclude' => true,
			'eval' => array('submitOnChange' => true)
		),
		'piwikPath' => array(
			'label' => &$GLOBALS['TL_LANG']['tl_layout']['piwikPath'],
			'inputType' => 'text',
			'exclude' => true,
			'eval' => array('mandatory' => true, 'rgxp' => 'piwikPath', 'trailingSlash' => true, 'tl_class' => 'w50')
		),
		'piwikSiteID' => array(
			'label' => &$GLOBALS['TL_LANG']['tl_layout']['piwikSiteID'],
			'inputType' => 'text',
			'exclude' => true,
			'eval' => array('mandatory' => true, 'rgxp' => 'digit', 'tl_class' => 'w50', 'maxlength' => 4)
		),
		'piwikExtensions' => array(
			'label' => &$GLOBALS['TL_LANG']['tl_layout']['piwikExtensions'],
			// 'default' => '7z,aac,arc,arj,asf,asx,avi,bin,csv,doc,exe,flv,gif,gz,gzip,hqx,jar,jpe,jpeg,js,mp2,mp3,mp4,mpe,mpeg,mov,movie,msi,msp,pdf,phps,png,ppt,qtm,ram,rar,sea,sit,tar,tgz,orrent,txt,wav,wma,wmv,wpd,xls,xml,z,zip',
			//'default' => array_keys($GLOBALS['TL_PIWIK']),
			'default' => $GLOBALS['TL_PIWIK'],
			'inputType' => 'textarea',
			'exclude' => true,
			'eval' => array('tl_class' => 'long clr', 'style' => 'height:50px;', 'alwaysSave' => true),
			'load_callback'	=> array(
				array('tl_layout_PiwikTrackingTag', 'extensions')
			),
			'save_callback'	=> array(
				array('tl_layout_PiwikTrackingTag', 'extensions')
			)
		),
		'piwikCountAdmins' => array(
			'label' => &$GLOBALS['TL_LANG']['tl_layout']['piwikCountAdmins'],
			'inputType' => 'checkbox',
			'exclude' => true,
			'eval' => array('tl_class' => 'w50')
		),
		'piwikCountUsers' => array(
			'label'	=> &$GLOBALS['TL_LANG']['tl_layout']['piwikCountUsers'],
			'default' => '1',
			'inputType' => 'checkbox',
			'exclude' => true,
			'eval' => array('tl_class' => 'w50')
		),
		'piwikPageName' => array(
			'label' => &$GLOBALS['TL_LANG']['tl_layout']['piwikPageName'],
			'inputType' => 'checkbox',
			'exclude' => true,
			'eval' => array('tl_class' => 'w50')
		),
		'piwik404' => array(
			'label' => &$GLOBALS['TL_LANG']['tl_layout']['piwik404'],
			'inputType' => 'checkbox',
			'exclude' => true,
			'eval' => array('tl_class' => 'w50')
		),
	)
);

class tl_layout_PiwikTrackingTag extends Backend
{

    public function extensions($value)
    {
        if (trim($value) == '')
        {
            return $GLOBALS['TL_DCA']['tl_layout']['fields']['piwikExtensions']['default'];
        }
        else
        {
            return $value;
        }
    }

}


?>