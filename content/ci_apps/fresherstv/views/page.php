<?php

if (!isset($no_index)) {
	$no_index = FALSE;
}

$this->load->helper("security");

$pages = array();
$pages [] = array("home", "Home");
$pages [] = array("about", "About");
if ($show_map_button) {
	$pages [] = array("map", "Stations Map");
}
$pages [] = array("http://blog.freshers.tv", "Blog", TRUE);
$pages [] = array("fresherstv2012", "FreshersTV 2012");
$pages [] = array("contact", "Contact");

// fix for ie
if (isset($_SERVER['HTTP_USER_AGENT']) && (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== FALSE)) {
	header('X-UA-Compatible: IE=edge,chrome=1');
}

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
<?php if ($no_index):?>
		<!-- Prevent search engines from indexing this page. -->
		<meta name="robots" content="noindex">
<?php endif; ?>
		<meta name="description" content="FreshersTV is an annual collaborative broadcast run by the National Association of Student Television (NaSTA) and a host station. This year the host station is LA1:TV from Lancaster University.">
		<meta property="og:url" content="http://freshers.tv/" />
		<meta property="og:title" content="FreshersTV 2013" />
		<meta property="og:description" content="FreshersTV is an annual collaborative broadcast run by the National Association of Student Television (NaSTA) and a host station. This year the host station is LA1:TV from Lancaster University." />
		<meta property="og:image" content="<?=base_url();?>assets/img/fresherTVLogo_fb.png?fbrefresh=1379166840" />
		<meta property="og:type" content="video.tv_show" />
		<meta property="og:video" content="<?=base_url();?>assets/videos/promo/video-720p.mp4" />
		
        <title>LA1:TV Presents FreshersTV 2013</title>

        <!-- Load CSS  -->
        <link href="<?=base_url();?>assets/css/bootstrap.css" rel="stylesheet" type="text/css">
        <link href="<?=base_url();?>assets/css/flipclock.css" rel="stylesheet" type="text/css">
        <link href="<?=base_url();?>assets/css/general.css?v=2" rel="stylesheet" type="text/css">
		
		<!-- Load page specific CSS -->
		<?php foreach($css as $a):	?>
		<link href="<?=base_url();?>assets/css/page/<?=$a?>.css" rel="stylesheet" type="text/css">
		<?php endforeach; ?>
        
		
        <!-- Load JS  -->	
        <script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
		<script src="<?=base_url();?>assets/js/jquery-ui-1.10.3.custom.min.js" type="text/javascript"></script>
        <script src="<?=base_url();?>assets/js/underscore.js" type="text/javascript"></script>
		<script src="<?=base_url();?>assets/js/backbone.js" type="text/javascript"></script>
		<script src="http://www.google.com/recaptcha/api/js/recaptcha_ajax.js" type="text/javascript"></script>
		<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCWG6Ez8FErHd12sZqc3wvTcauN7QDb56Y&amp;v=3&amp;sensor=false" type="text/javascript"></script>
        <script src="<?=base_url();?>assets/js/jquery.tjenkinson.recaptcha.js" type="text/javascript"></script>
        <script src="<?=base_url();?>assets/js/bootstrap.min.js" type="text/javascript"></script>
		<script src="<?=base_url();?>assets/js/jwplayer/jwplayer.js" type="text/javascript"></script>
		<script src="<?=base_url();?>assets/js/jwplayer/license.js" type="text/javascript"></script>
        <script src="<?=base_url();?>assets/js/embed-facebook.js" type="text/javascript"></script>
        <script src="<?=base_url();?>assets/js/embed-twitter.js" type="text/javascript"></script>
        <script src="<?=base_url();?>assets/js/flipclock/libs/base.js" type="text/javascript"></script>
        <script src="<?=base_url();?>assets/js/flipclock/libs/prefixfree.min.js" type="text/javascript"></script>
        <script src="<?=base_url();?>assets/js/flipclock/flipclock.js" type="text/javascript"></script>
        <script src="<?=base_url();?>assets/js/flipclock/faces/DailyCounter.js" type="text/javascript"></script>
        <script src="<?=base_url();?>assets/js/smart-dropdown.js" type="text/javascript"></script>
        <script src="<?=base_url();?>assets/js/login-dialog.js" type="text/javascript"></script>
        <script src="<?=base_url();?>assets/js/require-js.js" type="text/javascript"></script>
        <script src="<?=base_url();?>assets/js/google-analytics.js" type="text/javascript"></script>
		
		<!-- Load page specific JS -->
		<?php foreach($js as $a):	?>
		<script src="<?=base_url();?>assets/js/page/<?=$a?>.js" type="text/javascript"></script>
		<?php endforeach; ?>
		
        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
            <script src="<?=base_url();?>assets/js/html5shiv.js"></script>
            <script src="<?=base_url();?>assets/js/respond.min.js"></script>
        <![endif]-->

    </head>
    <!--
	    ___       ___       ___       ___       ___   
	   /\__\     /\  \     /\  \     /\  \     /\__\  
	  /:/  /    /::\  \   _\:\__\    \:\  \   /:/ _/_ 
	 /:/__/    /::\:\__\ /\/:/  /    /::\__\ |::L/\__\
	 \:\  \    \/\::/  / \::/  /    /:/\/__/ |::::/  /
	  \:\__\     /:/  /   \:\__\    \/__/     L;;/__/ 
	   \/__/     \/__/     \/__/     
	   
    -->
    <body data-baseurl="<?=htmlent(base_url());?>">
        <!-- =======[Nav]======= --> 
        <div id="main-navbar" class="navbar navbar-default navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">       

                    <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-links">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <a href="<?=base_url();?>" class="navbar-brand">FreshersTV</a>

                </div>
                <nav class="navbar-collapse collapse" id="navbar-links">
                    <ul class="nav navbar-nav">
						<?php foreach($pages as $a):
							$addr = $a[2] ? $a[0] : base_url() . htmlent($a[0]);
						?>
                        <li class="<?php if($a[2] !== TRUE && $a[0] == $current_page){echo("active");}?>"><a href="<?=$addr?>"><?=htmlent($a[1])?></a></li>
                        <?php endforeach; ?>
                    </ul>
					<div class="action-buttons navbar-right">
					<?php if ($show_apply): ?>
						<a class="btn btn-info navbar-btn" href="<?=base_url();?>apply">Application Form &raquo;</a>
					<?php endif; ?>
						<a class="btn btn-info navbar-btn" href="<?=base_url();?>submitvt">Submit VT &raquo;</a>
<?php if (!$logged_in): ?>
						<a class="btn btn-info navbar-btn show-login-dialog" href="<?=base_url();?>login">Log In &raquo;</a>
<?php else: ?>
						<a class="btn btn-info navbar-btn" href="<?=base_url();?>account">Account &raquo;</a>
<?php endif; ?>
					</div>
                </nav>
            </div>
        </div>
        <div id="wrap">
			<!-- =======[Main Logo Header]======= -->
			<div id="main-logo-header">
				<div class="main-logo-container">
					<h1 class="hidden">Freshers TV</h1>
					<a href="<?=base_url();?>"><img src="<?=base_url();?>assets/img/fresherTVLogo_web.png" alt="FreshersTV Logo" /></a>
				</div>
			</div>

            <!-- =======[Social Media]======= -->    
            <div class="container">
                <div class="row" id="social-bar">
                    <div class="span10 offset1 white-panel">
                        <ul class="social-buttons inline">
                            <li>
								<a href="https://twitter.com/FreshersTV" class="twitter-follow-button" data-show-count="true">Follow @FreshersTV</a>								</li>
                            <li>
								<a href="https://twitter.com/share" class="twitter-share-button" data-via="FreshersTV" data-url="<?=base_url();?>" data-lang="en">Tweet</a>
							</li>
                            <li>
                                <div class="fb-like" data-href="https://www.facebook.com/FreshersTV" data-layout="button_count" data-show-faces="false" data-send="true"></div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- =======[Page Specific Content]======= -->
			<div class="container" id="page-<?=htmlent($current_page)?>">
<?=$html?>
			</div>
            <div id="push"></div>
        </div>

        <!-- =======[Footer]======= -->
        <footer id="footer">
            <div class="container">
                <p class="muted credit">Designed and built by Luke Moscrop &amp; Tom Jenkinson.</p>
                <ul class="footer-links">
                    <li>
                        <a href="http://nasta.tv/" target="_blank">Nasta.tv</a>
                    </li>

                    <li class="muted">&middot;</li>

                    <li>
                        <a href="http://la1tv.lusu.co.uk/" target="_blank">LA1:TV</a>
                    </li>

                    <li class="muted">&middot;</li>

                    <li>
                        <a href="http://lusu.co.uk/" target="_blank">LUSU</a>
                    </li>
                </ul>
            </div>
        </footer>
<?=$login_dialog_html?>
		<div id="fb-root"></div>
    </body>
	
</html>