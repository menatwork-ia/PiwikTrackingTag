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
 * Add to palette
 */
$GLOBALS['TL_DCA']['tl_settings']['palettes']['default'] .= ';{piwik_legend:hide},piwik_blacklist,piwik_ip_blacklist'; 

$GLOBALS['TL_DCA']['tl_settings']['fields']['piwik_blacklist'] = array
(
	'label' 		=> &$GLOBALS['TL_LANG']['tl_settings']['piwikBlacklist'], 
	'exclude' 		=> true, 
	'inputType' 		=> 'multiColumnWizard',
	'eval' 			=> array
	(
		'columnFields' => array
		(
			'url' => array
			(
				'label'                 => &$GLOBALS['TL_LANG']['tl_settings']['piwikUrl'],
				'exclude'               => true,
				'inputType'             => 'text',
				'eval' 			=> array('style' => 'width:600px', 'rgxp' => 'absoluteUrl', 'trailingSlash' => false)
			),
		)
	)
);

$GLOBALS['TL_DCA']['tl_settings']['fields']['piwik_ip_blacklist'] = array
(
	'label' 		=> &$GLOBALS['TL_LANG']['tl_settings']['piwikIpBlacklist'], 
	'exclude' 		=> true, 
	'inputType' 		=> 'multiColumnWizard',
	'eval' 			=> array
	(
		'columnFields' => array
		(
			'ip' => array
			(
				'label'                 => &$GLOBALS['TL_LANG']['tl_settings']['piwikIP'],
				'exclude'               => true,
				'inputType'             => 'text',
				'eval' 			=> array('style' => 'width:600px', 'rgxp' => 'IP')
			),
		)
	)
);


?>