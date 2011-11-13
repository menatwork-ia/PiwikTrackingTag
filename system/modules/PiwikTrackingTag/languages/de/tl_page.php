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
 * @package    Language
 * @license    GNU/LGPL
 * @filesource
 */

/**
 * Legends
 */
$GLOBALS['TL_LANG']['tl_page']['piwik_legend'] = 'Piwik';

/**
 * Fields
 */
$GLOBALS['TL_LANG']['tl_page']['piwikEnabled'] = array('Piwik-Javascript-Tag in die Seite einbinden', 'Fügt der Website den Piwik-Javascript-Tag hinzu.');
$GLOBALS['TL_LANG']['tl_page']['piwikCountAdmins'] = array('Benutzer zählen', 'Wählen Sie aus, ob Benutzer, die im Backend eingeloggt sind, in der Statistik berücksichtigt werden.');
$GLOBALS['TL_LANG']['tl_page']['piwikCountUsers'] = array('Mitglieder zählen', 'Wählen Sie aus, ob Mitglieder, die im Frontend eingeloggt sind, in der Statistik berücksichtigt werden.');
$GLOBALS['TL_LANG']['tl_page']['piwikPath'] = array('URL der Piwik-Installation', "Bitte geben Sie die absolute URL zur Piwik-Installation mit Protokoll (z.B. <em>http://</em>) ein.");
$GLOBALS['TL_LANG']['tl_page']['piwikSiteID'] = array('Seiten-ID', 'Die ID der Seite, die in Piwik angelegt wurde.');
$GLOBALS['TL_LANG']['tl_page']['piwikPageName'] = array('Seiten-Titel verwenden', 'Lassen Sie sich in der Piwik-Statstik den Seiten-Titel anstatt des Alias anzeigen.');
$GLOBALS['TL_LANG']['tl_page']['piwik404'] = array('404 Seiten gesondert anzeigen', 'Sie haben die Möglichkeit Verweise auf nicht gefundene Seiten (Seitentyp: <em>404 Seite nicht gefunden</em>) sich in der Piwik-Statistik mit den Verweisen auf diese Seiten gesondert anzeigen zu lassen. So können Sie "tote Links" auf Ihrer Website leichter ausfindig zu machen.');
$GLOBALS['TL_LANG']['tl_page']['piwikExtensions'] = array('Dateiendungen für Download-Liste', 'Hier können Sie die kommagetrennte Liste der Dateiendungen anpassen, die in der Piwik-Statistik als Download gewertet werden. Lassen Sie das Feld leer, um die Standard-Endungen wieder herzustellen.');

?>