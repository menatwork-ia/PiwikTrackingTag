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
$GLOBALS['TL_DCA']['tl_layout']['subpalettes']['piwikEnabled'] = 'piwikPath,piwikSiteID,piwikTemplate,piwikVisitorCookieTimeout,piwikDownloadClasses,piwikExtensions,piwikCountAdmins,piwikCountUsers,piwikPageName,piwik404';


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
		'piwikTemplate' => array(
			'label' => &$GLOBALS['TL_LANG']['tl_layout']['piwikTemplate'],
			'inputType' => 'select',
			'exclude' => true,
			'options_callback' => array('PiwikTrackingTag', 'findPiwikTemplates'),
			'load_callback' => array(array('PiwikTrackingTag', 'setDefaultValue')),
			'eval' => array('mandatory' => true, 'tl_class' => 'w50', 'chosen'=> true, 'alwaysSave' => true)
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
        'piwikVisitorCookieTimeout' => array(
			'label' => &$GLOBALS['TL_LANG']['tl_layout']['piwikVisitorCookieTimeout'],
			'inputType' => 'text',
			'exclude' => true,
			'eval' => array('rgxp' => 'digit', 'tl_class' => 'w50')
		),
		'piwikDownloadClasses' => array(
			'label' => &$GLOBALS['TL_LANG']['tl_layout']['piwikDownloadClasses'],
			'inputType' => 'text',
			'exclude' => true,
			'eval' => array('tl_class' => 'w50')
		)
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