<?php

/**
 * Contao Open Source CMS
 * 
 * Copyright (C) 2005-2013 Leo Feyer
 * 
 * @package PiwikTrackingTag
 * @link    https://contao.org
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	'PiwikTrackingTag' => 'system/modules/PiwikTrackingTag/PiwikTrackingTag.php',
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'mod_piwikTrackingTag' => 'system/modules/PiwikTrackingTag/templates',
));
