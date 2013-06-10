<!-- indexer::stop -->
<script type="text/javascript">
/* <![CDATA[ */
var _paq = _paq || [];
<?php if($this->track404 == true): ?>
_paq.push(['setDocumentTitle', '404/URL = ' + encodeURIComponent(document.location.pathname+document.location.search) + '/From = ' + encodeURIComponent(document.referrer)]);
<?php endif; ?><?php if($this->trackName): ?>
_paq.push(['setDocumentTitle', document.title]);
<?php endif; ?><?php if($this->setVisitorCookieTimeout): ?>
_paq.push(['setVisitorCookieTimeout', <?php echo $this->visitorCookieTimeout; ?>]);
<?php endif; ?><?php if($this->downloadClasses): ?>
_paq.push(['setDownloadClasses', [<?php echo $this->downloadClasses; ?>]]);
<?php endif; ?>
_paq.push(['setDownloadExtensions', '<?php echo $this->extensions; ?>']);
<?php if($this->isSearch): ?>
_paq.push(['trackSiteSearch', "<?php echo $this->searchWords; ?>", false, false]);
<?php else: ?>
_paq.push(["trackPageView"]);
<?php endif; ?>
_paq.push(["enableLinkTracking"]);
try {
  (function() {
    var u=(("https:" == document.location.protocol) ? "https" : "http") + "://<?php echo $this->trimUrl; ?>";
    _paq.push(["setTrackerUrl", u+"piwik.php"]);
    _paq.push(["setSiteId", "<?php echo $this->id; ?>"]);
    var d=document, g=d.createElement("script"), s=d.getElementsByTagName("script")[0]; g.type="text/javascript";
    g.defer=true; g.async=true; g.src=u+"piwik.js"; s.parentNode.insertBefore(g,s);
  })();    
}catch( err ) {}
/* ]]> */
</script>
<noscript><p class="invisible"><?php if (preg_match('/bot|crawl|slurp|spider/i', $_SERVER['HTTP_USER_AGENT'])): /*do nothing*/ else: ?><img src="<?php echo $this->url; ?>piwik.php?idsite=<?php echo $this->id; ?>&amp;rec=1" alt="" /><?php endif;?></p></noscript>
<!-- indexer::continue -->