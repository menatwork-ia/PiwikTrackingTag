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


class PiwikTrackingTag extends Backend
{
	/**
     * Get a page layout and return it as database result object.
     * This is a copy from PageRegular, see comments in parseFrontendTemplate() below for the reason why this is here.
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
        }
        
        // Die if there is no layout at all
        if ($objLayout->numRows < 1)
        {
            $this->log('Could not find layout ID "' . $intId . '"', 'PageRegular getPageLayout()', TL_ERROR);

            header('HTTP/1.1 501 Not Implemented');
            die('No layout specified');
        }

        return $objLayout;
    } 

       
    public function outputFrontendTemplate($strContent, $strTemplate) {
        global $objPage;
		
		$objLayout = $this->getPageLayout($objPage->layout);
		
		if($objLayout->piwikEnabled) 
		{
			if(!$objLayout->piwikCountAdmins AND $this->Input->Cookie('BE_USER_AUTH'))
				$jsTag = "<!-- PiwikTrackingTag: Tracking users disabled -->\n";
			elseif(!$objLayout->piwikCountUsers AND FE_USER_LOGGED_IN)
				$jsTag = "<!-- PiwikTrackingTag: Tracking members disabled -->\n";
			else
			{
				$url 		= $objLayout->piwikPath;
				$extensions	= str_replace(' ', '', $objLayout->piwikExtensions);
			
				$jsTag  = "<!-- indexer::stop -->\n";
				$jsTag .= "<script type=\"text/javascript\">\n";
				$jsTag .= "<!--//--><![CDATA[//><!--\n";
				$jsTag .= "	document.write(unescape(\"%3Cscript src='" . $url . "piwik.js' type='text/javascript'%3E%3C/script%3E\"));\n";
				$jsTag .= "	window.addEvent('domready', function() {\n";
				$jsTag .= "		try {\n";
				$jsTag .= "			var piwikTracker = Piwik.getTracker(\"" . $url . "piwik.php\", " . $objLayout->piwikSiteID . ");\n";
				
				if($objLayout->piwik404 AND $objPage->type == 'error_404')
					$jsTag .= "			piwikTracker.setDocumentTitle('404/URL = ' + encodeURIComponent(document.location.pathname+document.location.search) + '/From = ' + encodeURIComponent(document.referrer));\n";
				elseif($objLayout->piwikPageName)
					$jsTag .= "			piwikTracker.setDocumentTitle(\"" . $objPage->title . "\");\n";
				
				if($extensions != '7z,aac,arc,arj,asf,asx,avi,bin,csv,doc,exe,flv,gif,gz,gzip,hqx,jar,jpe,jpeg,js,mp2,mp3,mp4,mpe,mpeg,mov,movie,msi,msp,pdf,phps,png,ppt,qtm,ram,rar,sea,sit,tar,tgz,orrent,txt,wav,wma,wmv,wpd,xls,xml,z,zip')
				{
					$extensions = str_replace(',', '|', $extensions);
				
					$jsTag .= "			piwikTracker.setDownloadExtensions(\"" . $extensions . "\");\n";
				}
				
				$jsTag .= "			piwikTracker.trackPageView();\n";
				$jsTag .= "			piwikTracker.enableLinkTracking();\n";
				$jsTag .= "		} catch( err ) {}\n";
				$jsTag .= "	});\n";
				$jsTag .= "//--><!]]>\n";
				$jsTag .= "</script><noscript><p class=\"invisible\"><img src=\"" . $url . "piwik.php?idsite=" . $objLayout->piwikSiteID . "\" alt=\"\" /></p></noscript>\n";
				$jsTag .= "<!-- indexer::continue -->\n";
			}
			
			$jsTag .= "</body>";
				
			$strContent = str_replace('</body>', $jsTag, $strContent);
		}
		
        return $strContent;
    }  
	
	public function validatePath($strRegexp, $varValue, Widget $objWidget)
	{
		if($strRegexp == 'piwikPath')
		{
			if (!preg_match('/^[a-zA-Z0-9\.\+\/\?#%:,;\{\}\(\)\[\]@&=~_-]*$/', $varValue))
			{
				$objWidget->addError($GLOBALS['TL_LANG']['ERR']['url']);
			
				return true;
			}
			
			$varValue = preg_replace('/\/+$/i', '', $varValue) . '/';
			
			$objRequest = new Request();
			$objRequest->send($varValue . 'piwik.js');
			
			if($objRequest->hasError())
			{
				$objWidget->addError(sprintf($GLOBALS['TL_LANG']['ERR']['piwikPath'], $objRequest->code, $objRequest->error));
			
				return true;
			}
		}
		
		return false;
	}
}

?>