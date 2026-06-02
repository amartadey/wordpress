<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" <?php bloginfo('charset'); ?> />
<meta name="format-detection" content="telephone=no">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
<title><?php wp_title('|', true, 'right'); ?></title>
<link rel="shortcut icon" href="<?php echo get_option( 'harmonyair_favicon' ); ?>" />



<link href="<?php echo get_template_directory_uri(); ?>/css/bootstrap.min.css" rel="stylesheet">
<link type="text/css" rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" />
<link href="<?php echo get_template_directory_uri(); ?>/css/superfish.css" rel="stylesheet" type="text/css" />

<!-- Home Slider css -->
<link href="<?php echo get_template_directory_uri(); ?>/css/responsiveslides.css" rel="stylesheet" type="text/css">
<link href="<?php echo get_template_directory_uri(); ?>/css/themes.css" rel="stylesheet" type="text/css">

<!-- Custom CSS -->
<link href="<?php echo get_template_directory_uri(); ?>/css/owl.carousel.css" rel="stylesheet" type="text/css">

<!-- Custom Fonts -->
<link href="<?php echo get_template_directory_uri(); ?>/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link href="https://fonts.googleapis.com/css?family=Raleway:100,200,300,400,500,600,700,800,900,100italic,200italic,300italic,400italic,500italic,600italic,700italic,800italic,900italic," rel="stylesheet"> 

<!-- Jquery CDN -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js" type="text/javascript"></script>
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	
    <!-- Header Start -->
    <header id="header">
        <div class="container">
            <figure class="logo-block">
                <a href="index.html"><img src="<?php bloginfo('template_directory'); ?>/images/logo.png" alt="" title="Harmony Air"/></a>
            </figure>
            
            <nav id="navigation">
                    <div id="nav-wrap">
                        <ul class="sf-menu">
                            <li><a href="air-taxi.html">
                                <img src="<?php bloginfo('template_directory'); ?>/images/plane.png" alt="" />
                                <span>Air Taxi</span>
                                </a>
                            </li>
                            
                            <li><a href="flight-training.html">
                                <img src="<?php bloginfo('template_directory'); ?>/images/flight-training-icon.jpg" alt="" />
                                <span>Flight<br> Training</span>
                                </a>
                            </li>
                            
                            <li><a href="aircraft-mgmt.html">
                                <img src="<?php bloginfo('template_directory'); ?>/images/mgmt-icon.png" alt="" />
                                <span>Aircraft<br> Management</span>
                                </a>
                            </li>
                            
                            <li><a href="https://s01.myfbo.com/link.asp?fbo=joes" target="_blank">
                                <img src="<?php bloginfo('template_directory'); ?>/online-scheduling-icon.png" alt="" />
                                <span>Online<br>Scheduling</span>
                                </a>
                            </li>
                            
                            <li><a href="fleet.html">
                               <img src="<?php bloginfo('template_directory'); ?>/images/fleet.png" alt="" />
                                <span>Fleet</span>
                                </a>
                            </li>
                            
                            <li><a href="about-us.html">
                                <img src="<?php bloginfo('template_directory'); ?>/images/about-us.png" alt="" />
                                <span>About Us</span>
                                </a>
                            </li>
                            <div class="clearfix"></div>
                        </ul>
                    </div>
                </nav>
            
            <a href="tel:6153508550"><div class="call-us-block">
                <h3>Call Now</h3>
                <h4>615 350 8550</h4>
                </div></a>
           <div class="clearfix"></div>
        </div>
    </header>
    <!--Header End -->   

    

