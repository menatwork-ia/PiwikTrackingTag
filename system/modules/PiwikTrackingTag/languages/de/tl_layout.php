<?php

/**
 * Contao Open Source CMS
 *
 * @copyright  MEN AT WORK 2013 
 * @package    PiwikTrackingTag
 * @license    GNU/LGPL
 * @filesource
 */

/**
 * Legends
 */
$GLOBALS['TL_LANG']['tl_layout']['piwik_legend'] = 'Piwik';

/**
 * Fields
 */
$GLOBALS['TL_LANG']['tl_layout']['piwikEnabled'] = array('Piwik-Javascript-Tag in die Seite einbinden', 'Fügt der Website den Piwik-Javascript-Tag hinzu.');
$GLOBALS['TL_LANG']['tl_layout']['piwikCountAdmins'] = array('Benutzer zählen', 'Wählen Sie aus, ob Benutzer, die im Backend eingeloggt sind, in der Statistik berücksichtigt werden.');
$GLOBALS['TL_LANG']['tl_layout']['piwikCountUsers'] = array('Mitglieder zählen', 'Wählen Sie aus, ob Mitglieder, die im Frontend eingeloggt sind, in der Statistik berücksichtigt werden.');
$GLOBALS['TL_LANG']['tl_layout']['piwikPath'] = array('URL der Piwik-Installation', "Bitte geben Sie die absolute URL zur Piwik-Installation mit Protokoll (z.B. <em>http://</em>) ein.");
$GLOBALS['TL_LANG']['tl_layout']['piwikSiteID'] = array('Seiten-ID', 'Die ID der Seite, die in Piwik angelegt wurde.');
$GLOBALS['TL_LANG']['tl_layout']['piwikPageName'] = array('Seiten-Titel verwenden', 'Lassen Sie sich in der Piwik-Statstik den Seiten-Titel anstatt des Alias anzeigen.');
$GLOBALS['TL_LANG']['tl_layout']['piwik404'] = array('404 Seiten gesondert anzeigen', 'Sie haben die Möglichkeit Verweise auf nicht gefundene Seiten (Seitentyp: <em>404 Seite nicht gefunden</em>) sich in der Piwik-Statistik mit den Verweisen auf diese Seiten gesondert anzeigen zu lassen. So können Sie "tote Links" auf Ihrer Website leichter ausfindig zu machen.');
$GLOBALS['TL_LANG']['tl_layout']['piwikExtensions'] = array('Dateiendungen für Download-Liste', 'Hier können Sie die kommagetrennte Liste der Dateiendungen anpassen, die in der Piwik-Statistik als Download gewertet werden. Lassen Sie das Feld leer, um die Standard-Endungen wieder herzustellen.');
$GLOBALS['TL_LANG']['tl_layout']['piwikVisitorCookieTimeout'] = array('Besucher-Cookie Timeout', 'Hier können Sie Lebenszeit des Besucher-Cookies in Sekunden einstellen. 0 bedeutet, dass der default Wert von Piwik verwendet wird (2 Jahre).');
$GLOBALS['TL_LANG']['tl_layout']['piwikDownloadClasses'] = array('Download Klassen', 'Hier können Sie die kommagetrennte Liste der Klassen angeben, die Piwik als Download-Klasse verwenden soll. Ist dieses Feld leer wird der default Wert verwendet ("piwik_download").');
$GLOBALS['TL_LANG']['tl_layout']['piwikTemplate'] = array('Template', 'Hier können Sie das Piwiktemplate auswählen. Wichtig: Bitte beachten Sie, dass das asynchrone Template erst ab Piwik Version 1.12 unterstützt wird.');