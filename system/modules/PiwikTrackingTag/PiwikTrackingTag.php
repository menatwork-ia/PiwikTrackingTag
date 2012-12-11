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
 * PiwikTrackingTag
 */
class PiwikTrackingTag extends Backend
{

    // Template name
    protected $strTemplate = 'mod_piwikTrackingTag';

    /**
     * Get a page layout and return it as database result object.
     * This is a copy from PageRegular, see comments in parseFrontendTemplate() below for the reason why this is here.
     * 
     * @param integer
     * @return object
     */
    protected function getPageLayout($intId)
    {
        $objLayout = $this->Database->prepare("SELECT * FROM tl_layout WHERE id=?")
                ->limit(1)
                ->execute($intId);

        // Fallback layout
        if ($objLayout->numRows < 1)
        {
            $objLayout = $this->Database->prepare("SELECT * FROM tl_layout WHERE fallback=?")
                    ->limit(1)
                    ->execute(1);

            if ($objLayout->numRows < 1)
            {
                return FALSE;
            }
        }

        return $objLayout;
    }

    /**
     * Find the root page
     * 
     * @param int $intId 
     */
    protected function getRootPage($intId)
    {
        $intRootId = $this->getParentPage($intId);
        return $this->Database->prepare("SELECT * FROM tl_page WHERE id=?")->execute($intRootId);
    }

    /**
     * Get parent page 
     * 
     * @param int $intId
     * @return object DatabaseResult 
     */
    protected function getParentPage($intId)
    {
        $objResult = $this->Database->prepare("SELECT id, pid FROM tl_page WHERE id=?")->execute($intId);

        if ($objResult->pid == 0)
        {
            return $objResult->id;
        }
        else
        {
            return $this->getParentPage($objResult->pid);
        }
    }

    /**
     * Create Piwik JS
     * 
     * @global object $objPage
     * @param object $objPage
     * @param object $objLayout
     * @param PageRegular $pageRegular
     * @return void
     */
    public function generatePage($objPage, $objLayout, PageRegular $pageRegular)
    {
        // Load blacklist for piwik
        if (strlen($GLOBALS["TL_CONFIG"]['piwik_ip_blacklist']) == 0 || !is_array($arrIPBlacklist = deserialize($GLOBALS["TL_CONFIG"]['piwik_ip_blacklist'])))
        {
            $arrIPBlacklist = array();
        }
       
        // Check if current ip is part of the blacklist
        foreach ($arrIPBlacklist as $key => $value)
        {
            $strPattern = str_replace(array('*', '.'), array('([1-9]?[0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5]){1}', '\.'), $value["ip"]);
                        
            if(preg_match("/".$strPattern."/", $this->Environment->ip))
            {
                // Tracking page disabled
                $GLOBALS['TL_MOOTOOLS'][] = "<!-- PiwikTrackingTag: Tracking for IP " . $value["ip"] . " disabled -->";
                return;
            }
        }

        // Load blacklist for piwik
        if (strlen($GLOBALS["TL_CONFIG"]['piwik_blacklist']) == 0 || !is_array($arrBlacklist = deserialize($GLOBALS["TL_CONFIG"]['piwik_blacklist'])))
        {
            $arrBlacklist = array();
        }

        // Check if current page is part of the blacklist
        foreach ($arrBlacklist as $key => $value)
        {
            $value["url"] = preg_replace("/^http(s){0,1}:\/\//", '', $value["url"]);
            $value["url"] = str_replace(array('/'), array('\\/'), $value["url"]);
            $value["url"] = "http(s){0,1}:\/\/" . $value["url"];
                       
            if (preg_match("/^".$value["url"]."/", $this->Environment->base) == true)
            {
                // Tracking page disabled
                $GLOBALS['TL_MOOTOOLS'][] = "<!-- PiwikTrackingTag: Tracking for page " . $value["url"] . " disabled -->";
                return;
            }
        }
        

        // Get current page
        global $objPage;

        // Find root page
        $objRootPage = $this->getRootPage($objPage->id);
        // Load layout informations
        $objLayout = $this->getPageLayout($objPage->layout);

        if ($objPage->piwikEnabled)
        {
            $objSettings = $objPage;
        }
        elseif ($objRootPage->piwikEnabled)
        {
            $objSettings = $objRootPage;
        }
        elseif ($objLayout != FALSE && $objLayout->piwikEnabled)
        {
            $objSettings = $objLayout;
        }
        else
        {
            return;
        }

        // Check if user/members should not be counted
        if (!$objSettings->piwikCountAdmins AND $this->Input->Cookie('BE_USER_AUTH'))
        {
            // Tracking users disabled
            $GLOBALS['TL_MOOTOOLS'][] = "<!-- PiwikTrackingTag: Tracking users disabled -->";
        }
        elseif (!$objSettings->piwikCountUsers AND FE_USER_LOGGED_IN)
        {
            // Tracking members disabled
            $GLOBALS['TL_MOOTOOLS'][] = "<!-- PiwikTrackingTag: Tracking members disabled -->";
        }
        else
        {
            // Create Piwiki JS
            $objTemplate = new FrontendTemplate($this->strTemplate);
            $objTemplate->id = $objSettings->piwikSiteID;
            $objTemplate->title = $objPage->title;
            $objTemplate->url = $objSettings->piwikPath;
            $objTemplate->trimUrl = preg_replace("^(http://|https://)^i", "", $objSettings->piwikPath);
            $objTemplate->extensions = str_replace(array(' ', ','), array('', '|'), $objSettings->piwikExtensions);
            $objTemplate->track404 = $objSettings->piwik404 == TRUE && $objPage->type == 'error_404';
            $objTemplate->trackName = $objSettings->piwikPageName == true;

            $GLOBALS['TL_MOOTOOLS'][] = $objTemplate->parse();
        }

        return;
    }

    /**
     * Check if the address is realy a http or https address and if there is a server with piwik. 
     * 
     * @param string $strRegexp
     * @param string $varValue
     * @param Widget $objWidget
     * @return boolean 
     */
    public function validatePath($strRegexp, $varValue, Widget $objWidget)
    {
        if ($strRegexp == 'piwikPath')
        {
            if ($objWidget->value == $varValue)
            {
                return true;
            }

            if (!preg_match('/^[a-zA-Z0-9\.\+\/\?#%:,;\{\}\(\)\[\]@&=~_-]*$/', $varValue))
            {
                $objWidget->addError($GLOBALS['TL_LANG']['ERR']['url']);

                return true;
            }

            $varValue = preg_replace('/\/+$/i', '', $varValue) . '/';

            $objRequest = new Request();
            $objRequest->send($varValue . 'piwik.js');

            if ($objRequest->hasError())
            {
                $objWidget->addError(sprintf($GLOBALS['TL_LANG']['ERR']['piwikPath'], $objRequest->code, $objRequest->error));

                return true;
            }
        }

        return false;
    }

    /**
     * Check if a url contains 'http://' or 'https://'
     * 
     * @param string $strRegexp
     * @param mixed $varValue
     * @param Widget $objWidget
     * @return boolean 
     */
    public function validateUrl($strRegexp, $varValue, Widget $objWidget)
    {
        if ($strRegexp == 'absoluteUrl')
        {
            if (!preg_match('/^(http:\/\/|https:\/\/)[a-zA-Z0-9\.\+\/\?#%:,;\{\}\(\)\[\]@&=~_-]*$/', $varValue))
            {
                $objWidget->addError($GLOBALS['TL_LANG']['ERR']['url']);

                return true;
            }
        }

        return false;
    }

    /**
     * Check if we have a ip
     * 
     * @param string $strRegexp
     * @param mixed $varValue
     * @param Widget $objWidget
     * @return boolean 
     */
    public function validateIP($strRegexp, $varValue, Widget $objWidget)
    {
        if ($strRegexp == 'IP')
        {
            $strPreg = "/^(([1-9]?[0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5]|\*).){3}([1-9]?[0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5]|\*)$/";

            if (preg_match($strPreg, $varValue))
            {
                return true;
            }
            
            $objWidget->addError($GLOBALS['TL_LANG']['ERR']['ip']);
        }

        return false;
    }

    /**
     * Check the required extensions and files for syncCto
     * 
     * @param string $strContent
     * @param string $strTemplate
     * @return string
     */
    public function checkExtensions($strContent, $strTemplate)
    {
        if ($strTemplate == 'be_main')
        {
            if (!is_array($_SESSION["TL_INFO"]))
            {
                $_SESSION["TL_INFO"] = array();
            }

            // required extensions
            $arrRequiredExtensions = array(
                'MultiColumnWizard' => 'multicolumnwizard'
            );
            
            // check for required extensions
            foreach ($arrRequiredExtensions as $key => $val)
            {
                if (!in_array($val, $this->Config->getActiveModules()))
                {
                    $_SESSION["TL_INFO"] = array_merge($_SESSION["TL_INFO"], array($val => 'Please install the required extension <strong>' . $key . '</strong>'));
                }
                else
                {
                    if (is_array($_SESSION["TL_INFO"]) && key_exists($val, $_SESSION["TL_INFO"]))
                    {
                        unset($_SESSION["TL_INFO"][$val]);
                    }
                }
            }
        }

        return $strContent;
    }
}

?>