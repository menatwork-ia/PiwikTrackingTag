<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

/**
 * Contao Open Source CMS
 *
 * @copyright  MEN AT WORK 2013 
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
$GLOBALS['TL_DCA']['tl_page']['subpalettes']['piwikEnabled'] = 'piwikPath,piwikSiteID,piwikVisitorCookieTimeout,piwikDownloadClasses,piwikExtensions,piwikCountAdmins,piwikCountUsers,piwikPageName,piwik404';

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
			'default' => $GLOBALS['TL_PIWIK'],
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
		'piwikVisitorCookieTimeout' => array(
			'label' => &$GLOBALS['TL_LANG']['tl_page']['piwikVisitorCookieTimeout'],
			'inputType' => 'text',
			'exclude' => true,
			'eval' => array('rgxp' => 'digit', 'tl_class' => 'w50')
		),
		'piwikDownloadClasses' => array(
			'label' => &$GLOBALS['TL_LANG']['tl_page']['piwikDownloadClasses'],
			'inputType' => 'text',
			'exclude' => true,
			'eval' => array('tl_class' => 'w50')
		)        
	)
);

class tl_page_PiwikTrackingTag extends Backend
{

    public function extensions($value)
    {
        if (trim($value) == '')
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