<?php
$this->load->helper("security");

$pages = array(
	array("home", "Home"),
	array("about", "About"),
	array("fresherstv2012", "Freshers TV 2012")
);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">

        <title>LA1:TV Presents FreshersTV 2013</title>

        <!-- Load CSS  -->
        <link href="<?=base_url();?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="<?=base_url();?>assets/css/flipclock.css" rel="stylesheet" type="text/css">
        <link href="<?=base_url();?>assets/css/general.css" rel="stylesheet" type="text/css">
		
		<!-- Load page specific CSS -->
		<?php foreach($css as $a):	?>
		<link href="<?=base_url();?>assets/css/page/<?=$a?>.css" rel="stylesheet" type="text/css">
		<?php endforeach; ?>
        
		
        <!-- Load JS  -->
        <script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
        <script src="<?=base_url();?>assets/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="<?=base_url();?>assets/js/embed-facebook.js" type="text/javascript"></script>
        <script src="<?=base_url();?>assets/js/embed-twitter.js" type="text/javascript"></script>
        <script src="<?=base_url();?>assets/js/flipclock/libs/base.js" type="text/javascript"></script>
        <script src="<?=base_url();?>assets/js/flipclock/libs/prefixfree.min.js" type="text/javascript"></script>
        <script src="<?=base_url();?>assets/js/flipclock/flipclock.js" type="text/javascript"></script>
        <script src="<?=base_url();?>assets/js/flipclock/faces/DailyCounter.js" type="text/javascript"></script>
		
		<!-- Load page specific JS -->
		<?php foreach($js as $a):	?>
		<script src="<?=base_url();?>assets/js/page/<?=$a?>.js" type="text/javascript"></script>
		<?php endforeach; ?>
		
        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
            <script src="./assets/js/html5shiv.js"></script>
            <script src="./assets/js/respond.min.js"></script>
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
    <body>
        <!-- =======[Nav]======= --> 
        <div class="navbar navbar-default navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">       

                    <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-main">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <a href="." class="navbar-brand">Freshers TV</a>

                </div>
                <div class="navbar-collapse collapse" id="navbar-main">
                    <ul class="nav navbar-nav">
						<?php foreach($pages as $a): ?>
                        <li class="<?php if($a[0] == $current_page){echo("active");}?>"><a href="<?=base_url();?><?=htmlent($a[0])?>"><?=htmlent($a[1])?></a></li>
                        <?php endforeach; ?>
                    </ul>

                    <div class="navbar-form navbar-right">
                        <a class="btn btn-success" href="#">Application Form &raquo;</a>
                    </div>

                </div>
            </div>
        </div>
        <div id="wrap">
			<!-- =======[Main Logo Header]======= -->
			<div id="main-logo-header">
				<div class="main-logo-container">
					<h1 class="hidden">Freshers TV</h1>
					<img src="<?=base_url();?>assets/img/fresherTVLogo_web.png" />
				</div>
			</div>

            <!-- =======[Social Media]======= -->    
            <div class="container">
                <div class="row" id="social-bar">
                    <div class="span10 offset1 white-panel">
                        <ul class="social-buttons inline">
                            <li>
                                <iframe allowtransparency="true" frameborder="0" scrolling="no" src="http://platform.twitter.com/widgets/follow_button.1375828408.html#_=1377809470479&amp;id=twitter-widget-1&amp;lang=en&amp;screen_name=FreshersTV&amp;show_count=true&amp;show_screen_name=true&amp;size=m" class="twitter-follow-button twitter-follow-button" title="Twitter Follow Button" data-twttr-rendered="true" style="width: 242px; height: 20px;"></iframe>
                            </li>
                            <li>
                                <iframe allowtransparency="true" frameborder="0" scrolling="no" src="http://platform.twitter.com/widgets/tweet_button.1375828408.html#_=1377809470473&amp;count=horizontal&amp;id=twitter-widget-0&amp;lang=en&amp;original_referer=http%3A%2F%2Ffreshers.tv&amp;size=m&amp;text=LA1TV%20Presents%20FreshersTV%202013&amp;url=http%3A%2F%2Ffreshers.tv" class="twitter-share-button twitter-count-horizontal" title="Twitter Tweet Button" data-twttr-rendered="true" style="width: 110px; height: 20px;"></iframe>
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
                <p class="muted credit">Designed and built by Luke Moscrop &amp; Tom Jenkinson</p>
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
		<div id="fb-root"></div>
    </body>
	
</html>