<!DOCTYPE html>
<html lang="en-US" prefix="og: http://ogp.me/ns#">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title><?php bloginfo('name'); ?></title>
    	<meta name="description" content="<?php bloginfo('description'); ?>">
    	<meta name="author" content="PHK Corporation">
		<meta charset="utf-8">
		<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/style.css" type="text/css">
		<!-- favicon -->
		<link rel="shortcut icon" href="<?php bloginfo('template_directory'); ?>/favicon.ico" type="image/x-icon">
		<link rel="icon" href="<?php bloginfo('template_directory'); ?>/favicon.ico" type="image/x-icon">
		<!-- Google Verification -->
		<meta name="google-site-verification" content="F62ATulD8MsdIzYWKfheI1PYUEUZ_nJetMD-cTXwi5Q" />
		
		<!-- Mobile Devices Viewport Resset-->
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
		<meta name="apple-mobile-web-app-capable" content="yes">

	    <!-- Bootstrap -->
	    <link href="<?php echo get_stylesheet_uri(); ?>" rel="stylesheet" media="screen">
		<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/css/jquery-te-1.4.0.css" type="text/css">
	    <link href="<?php bloginfo('template_directory'); ?>/bootstrap/css/bootstrap-responsive.css" rel="stylesheet" media="screen">
	    <!-- jQuery UI -->
		<?php wp_register_style('jquery-ui', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css');?>
		<?php wp_enqueue_style( 'jquery-ui' );  ?>


		<script type='text/javascript' src='https://www.youtube.com/iframe_api?ver=1.3.0'></script>
		
    	<?php wp_head(); ?>
	</head>
	<body <?php body_class(); ?>>
		<div id="page" class="hfeed site">

			<div id="main" class="site-main">
