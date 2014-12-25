<!DOCTYPE html />
<html <?php language_attributes(); ?>>
	<head>
		<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>;  charset=<?php bloginfo('charset'); ?>" />
		<title><?php wp_title(); ?></title>
    	<meta name="description" content="<?php bloginfo('description'); ?>">
    	<meta name="author" content="PHK Corporation">
		<meta charset="utf-8">
		<link rel="stylesheet" href="<?php echo esc_url( get_template_directory_uri() ); ?>/style.css" type="text/css">
		<!-- favicon -->
		<link rel="shortcut icon" href="<?php echo esc_url( get_template_directory_uri() ); ?>/favicon.ico" type="image/x-icon">
		<link rel="icon" href="<?php echo esc_url( get_template_directory_uri() ); ?>/favicon.ico" type="image/x-icon">
		<!-- Google Verification -->
		<meta name="google-site-verification" content="F62ATulD8MsdIzYWKfheI1PYUEUZ_nJetMD-cTXwi5Q" />
		
		<!-- Mobile Devices Viewport Resset-->
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
		<meta name="apple-mobile-web-app-capable" content="yes">

	    <link href="<?php echo get_stylesheet_uri(); ?>" rel="stylesheet" media="screen">

		
    	<?php wp_head(); ?>
	</head>
	<body <?php body_class(); ?>>
		<div id="page" class="hfeed site">

			<div id="main" class="site-main">
