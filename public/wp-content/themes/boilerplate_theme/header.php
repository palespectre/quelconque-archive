<!DOCTYPE html>
<html <?php language_attributes(); ?> class="js">
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>

  <!-- Theme color in mobile browser-->
  <meta name="theme-color" content="#00677b">

  <link rel="profile" href="http://gmpg.org/xfn/11">
  <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

  <?php wp_head(); ?>

</head>

<body <?php body_class('no-js'); ?>>

  <div class="main-container">

    <header id="header">

      <?php // Delete supheader if you dont need it ?>
      <div id="supheader">
        <div class="container-fluid">
          <div class="row end-xs">
            <?php

              if(HAS_WPML) language_selector();

              if ( has_nav_menu( 'supheader' )) {
                echo wp_nav_menu( array(
                  'container' => '',
                  'theme_location' => 'supheader',
                ) );
              }
            ?>
          </div>
        </div>
      </div>

      <div class="container-fluid">
        <nav>        
          <div id="logo"><?php echo get_logo();?></div>

          <?php

              if ( has_nav_menu( 'primary' )) {
                echo wp_nav_menu( array(
                  'container' => '',
                  'menu_id' => 'mainnav',
                  'theme_location' => 'primary',
                ) );
              }
          ?>

          <button id="open-mobile-menu"><span class="default">Menu</span><span class="closing">Fermer X</span></button>
          <div id="mobile-menu">
            <?php

                if ( has_nav_menu( 'mobile' )) {
                  echo wp_nav_menu( array(
                    'container' => '',
                    'menu_id' => 'mobile',
                    'theme_location' => 'mobile',
                  ) );
                }
            ?>
          </div>

          
        </nav>
      </div>
    </header>
    <main>
      <div data-barba="wrapper" class="mod_scale_fluid">