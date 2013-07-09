<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2013 Leo Feyer
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
	'mod_piwikTrackingTagSynchron'  => 'system/modules/PiwikTrackingTag/templates',
	'mod_piwikTrackingTagAsynchron' => 'system/modules/PiwikTrackingTag/templates',
));