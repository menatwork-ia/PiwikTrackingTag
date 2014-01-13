<?php

/**
 * Contao Open Source CMS
 *
 * @copyright  MEN AT WORK 2014
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
    protected $strTemplate = 'mod_piwikTrackingTagSynchron';

    protected $strScriptType = 'TL_MOOTOOLS';

    /**
    * Load the database object
    */
    public function __construct()
    {
        if (version_compare(VERSION, 3, '>='))
        {
            $this->strScriptType = 'TL_BODY';
        }

        parent::__construct();
    }

    /**
     * Get a list with all piwik templates.
     *
     * @return array
     */
    public function findPiwikTemplates($objDC, $blnOneDimension = false)
    {
        $arrReturn = array();

        // Get all templates
        $arrTeplates = $this->getTemplateGroup('mod_piwik');

        // Get path
        foreach ($arrTeplates as $key => $value)
        {
            // Clean up
            $mixPath = $this->getTemplate($value);

            // Remove TL_ROOT
            $mixPath = str_replace(array(TL_ROOT), '', $mixPath);
            // Remove system/modules and co from path
            if (stripos($mixPath, 'system/modules') !== false)
            {
                $mixPath = str_replace(array('system/modules', 'templates'), '', $mixPath);
            }

            $mixPath = explode('/', $mixPath);
            array_pop($mixPath);
            $mixPath = implode("/", array_filter($mixPath));

            if ($blnOneDimension)
            {
                $arrReturn[$value] = $value;
            }
            else
            {
                $arrReturn[$mixPath][$value] = $value;
            }
        }

        return $arrReturn;
    }

    /**
     * If we have no value set the 'mod_piwikTrackingTagSynchron' as default.
     *
     * @param mixed $arrValue
     * @param object $objDC
     *
     * @return mixed
     */
    public function setDefaultValue($arrValue, $objDC)
    {
        if (empty($arrValue))
        {
            return 'mod_piwikTrackingTagSynchron';
        }

        return $arrValue;
    }

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
        $objResult = $this->Database->prepare("SELECT id, pid, type FROM tl_page WHERE id=?")->execute($intId);

        if ($objResult->pid == 0 || $objResult->type == 'root')
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
            // Check if we have an empty value
            if(strlen( $value["ip"]) == 0)
            {
                continue;
            }

            $strPattern = str_replace(array('*', '.'), array('([1-9]?[0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5]){1}', '\.'), $value["ip"]);

            if(preg_match("/".$strPattern."/", $this->Environment->ip))
            {
                // Tracking page disabled
                $GLOBALS[$this->strScriptType][] = "<!-- PiwikTrackingTag: Tracking for IP " . $value["ip"] . " disabled -->";
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
            // Check if we have an empty value
            if(strlen( $value["url"]) == 0)
            {
                continue;
            }

            $value["url"] = preg_replace("/^http(s){0,1}:\/\//", '', $value["url"]);
            $strReadable = $value["url"];
            $value["url"] = str_replace(array('/', '*'), array('\\/', '.*'), $value["url"]);
            $value["url"] = "http(s){0,1}:\/\/" . $value["url"];

            if (preg_match("/^".$value["url"]."/", $this->Environment->base) == true)
            {
                // Tracking page disabled
                $GLOBALS[$this->strScriptType][] = "<!-- PiwikTrackingTag: Tracking for page http(s)://" . $strReadable . " disabled -->";
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
            $this->setCurrentTemplate($objPage->piwikTemplate);
        }
        elseif ($objRootPage->piwikEnabled)
        {
            $objSettings = $objRootPage;
            $this->setCurrentTemplate($objRootPage->piwikTemplate);
        }
        elseif ($objLayout != FALSE && $objLayout->piwikEnabled)
        {
            $objSettings = $objLayout;
            $this->setCurrentTemplate($objLayout->piwikTemplate);
        }
        else
        {
            return;
        }

        // Check if user/members should not be counted
        if (!$objSettings->piwikCountAdmins AND $this->Input->Cookie('BE_USER_AUTH'))
        {
            // Tracking users disabled
            $GLOBALS[$this->strScriptType][] = "<!-- PiwikTrackingTag: Tracking users disabled -->";
        }
        elseif (!$objSettings->piwikCountUsers AND FE_USER_LOGGED_IN)
        {
            // Tracking members disabled
            $GLOBALS[$this->strScriptType][] = "<!-- PiwikTrackingTag: Tracking members disabled -->";
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
            $objTemplate->visitorCookieTimeout = $objSettings->piwikVisitorCookieTimeout;
            $objTemplate->setVisitorCookieTimeout = ($objSettings->piwikVisitorCookieTimeout >0)? true : false;
            if($objSettings->piwikDownloadClasses)
            {
                $arrDownloadClasses = trimsplit(',', $objSettings->piwikDownloadClasses);
                $objTemplate->downloadClasses = "'".implode("','", $arrDownloadClasses)."'";
            }

            // Add some values for the search
            $strKeywords = $this->Input->get('keywords');
            if(strlen($strKeywords) != 0)
            {
                // If query type 'and' use spaces if 'or' use comma
                $strReplace = ($this->Input->get('query_type') == 'and' || $this->Input->get('query_type') == '') ? ' ' : ',';

                $objTemplate->isSearch = true;
                $objTemplate->searchWords = str_replace(array(' ', '\'', '"'), array($strReplace, '', ''), $this->Input->get('keywords'));
            }
            else
            {
                 $objTemplate->isSearch = false;
                 $objTemplate->searchWords = '';
            }

            $GLOBALS[$this->strScriptType][] = $objTemplate->parse();
        }

        return;
    }

    /**
     * Check if we have a valid value and if the template exist.
     *
     * @param string $strTemplate
     */
    protected function setCurrentTemplate($strTemplate)
    {
        // Load all templates
        $arrTemplates = $this->findPiwikTemplates(null, true);

        // Check if we have a valid value
        if (!empty($strTemplate) && in_array($strTemplate, $arrTemplates))
        {
            $this->strTemplate = $strTemplate;
            return;
        }

        // Check if we have another in the theme template folder
        $arrTemplates = $this->findPiwikTemplates(null, false);

        // If we have no value and a theme template use it
        if (empty($strTemplate) && key_exists('templates', $arrTemplates))
        {
            $this->strTemplate = array_shift($arrTemplates['templates']);
            return;
        }

        $this->strTemplate = 'mod_piwikTrackingTagSynchron';
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
            if (!preg_match('/^(http:\/\/|https:\/\/)[a-zA-Z0-9\.\+\/\?\*#%:,;\{\}\(\)\[\]@&=~_-]*$/', $varValue))
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