<?php


$this->load->helper("security");

$pages = array(
	array("home", "Home")
);

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
		<!-- Prevent search engines from indexing this page. -->
		<meta name="robots" content="noindex">
		
        <title>FreshersTV Administration</title>

        <!-- Load CSS  -->
        <link href="<?=base_url();?>assets/css/bootstrap.css" rel="stylesheet" type="text/css">
        <link href="<?=base_url();?>assets/css/general.css" rel="stylesheet" type="text/css">
		
		<!-- Load page specific CSS -->
		<?php foreach($css as $a):	?>
		<link href="<?=base_url();?>assets/css/page/<?=$a?>.css" rel="stylesheet" type="text/css">
		<?php endforeach; ?>
        
		
        <!-- Load JS  -->
        <script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
        <script src="<?=base_url();?>assets/js/underscore-min.js" type="text/javascript"></script>
        <script src="<?=base_url();?>assets/js/backbone-min.js" type="text/javascript"></script>
		<script src="http://www.google.com/recaptcha/api/js/recaptcha_ajax.js" type="text/javascript"></script>
        <script src="<?=base_url();?>assets/js/jquery-ui-1.10.3.custom.min.js" type="text/javascript"></script>	
        <script src="<?=base_url();?>assets/js/jquery.tjenkinson.recaptcha.js" type="text/javascript"></script>
        <script src="<?=base_url();?>assets/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="<?=base_url();?>assets/js/smart-dropdown.js" type="text/javascript"></script>
		
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
    <body data-baseurl="<?=htmlent(base_url());?>">
        <!-- =======[Nav]======= --> 
        <nav id="main-navbar" class="navbar navbar-default navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">       

                    <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-links">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <a href="<?=base_url();?>" class="navbar-brand">FreshersTV Administration</a>

                </div>
                <div class="navbar-collapse collapse" id="navbar-links">
                    <ul class="nav navbar-nav">
						<?php foreach($pages as $a): ?>
                        <li class="<?php if($a[0] == $current_page){echo("active");}?>"><a href="<?=base_url();?><?=htmlent($a[0])?>"><?=htmlent($a[1])?></a></li>
                        <?php endforeach; ?>
                    </ul>
					<div class="action-buttons navbar-right">
<?php if (!$logged_in): ?>
						<a class="btn btn-info navbar-btn" href="<?=base_url();?>login">Log In &raquo;</a>
<?php else: ?>
						<a class="btn btn-info navbar-btn" href="<?=base_url();?>logout">Log Out &raquo;</a>
<?php endif; ?>
					</div>
                </div>
            </div>
        </nav>
        <div id="wrap">

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
                        <a href="http://freshers.tv/" target="_blank">Main Site</a>
                    </li>
                </ul>
            </div>
        </footer>
		<div id="fb-root"></div>
    </body>
	
</html>