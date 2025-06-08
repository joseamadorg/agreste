<?php
/**
 * Custom template tags for this theme
 * Eventually, some of the functionality here could be replaced by core features.
 * @package atreves
*/

//atreves_header_social_profiles
function atreves_header_social_profiles() {
    $atreves_topbar_fb_url             = get_theme_mod('atreves_topbar_fb_url', '#');
    $atreves_topbar_twitter_url       = get_theme_mod('atreves_topbar_twitter_url', '#');
    $atreves_topbar_linkedin_url      = get_theme_mod('atreves_topbar_linkedin_url', '#');
    $atreves_topbar_instagram_url        = get_theme_mod('atreves_topbar_instagram_url', '#');
    $enable_header_social_profile        = get_theme_mod('atreves_show_social_profiles');
    if( $enable_header_social_profile  == true ):
        if ($atreves_topbar_fb_url != '#'): ?>
            <li class="topbar-single-info topbar-social-icon">
                <a href="<?php print esc_url($atreves_topbar_fb_url); ?>"><i class="fa fa-facebook"></i></a>
            </li>
        <?php endif; 
        if ($atreves_topbar_twitter_url != '#'): ?>
            <li class="topbar-single-info topbar-social-icon">
                <a href="<?php print esc_url($atreves_topbar_twitter_url); ?>"><i class="fa fa-twitter"></i></a>
            </li>
        <?php 
        endif; 
        if ($atreves_topbar_linkedin_url != '#'): ?>
            <li class="topbar-single-info topbar-social-icon">
                <a href="<?php print esc_url($atreves_topbar_instagram_url); ?>"><i class="fa fa-linkedin"></i></a>
            </li>
        <?php 
        endif; 
        if ($atreves_topbar_instagram_url != '#'): ?>
            <li class="topbar-single-info topbar-social-icon">
                <a href="<?php print esc_url($atreves_topbar_instagram_url); ?>"><i class="fa fa-instagram"></i></a>
            </li>
        <?php 
        endif; 
    endif;
}


//investion login
function atreves_user_login(){
     // header button
    $enable_header_btn = get_theme_mod('atreves_show_header_btn');
    $enable_header_btn_text = get_theme_mod('atreves_header_btn_text', esc_html__('Sign in', 'atreves'));
    $enable_header_btn_icon = get_theme_mod('atreves_header_btn_icon', esc_html__('fa fa-user-o', 'atreves'));  
    if( $enable_header_btn == true ): ?>
        <?php     
        if (is_user_logged_in()) : ?>
            <li class="topbar-single-info topbar-signin sign-nav ml-3 ml-lg-0">
                <a href="<?php echo wp_logout_url() ?>"><i class="<?php echo esc_attr( $enable_header_btn_icon ); ?>"></i> <?php echo esc_html('Log Out', 'atreves'); ?></a>
            </li>
        <?php
        else : ?>
            <li class="topbar-single-info topbar-signin sign-nav ml-3 ml-lg-0">
                <a href="<?php echo wp_login_url(get_permalink()); ?>"><i class="<?php echo esc_attr( $enable_header_btn_icon ); ?>"></i> <?php echo esc_html( $enable_header_btn_text ); ?></a>
            </li>';
        <?php 
        endif; ?>
    <?php 
    endif; 
}


// atreves header logo
function atreves_header_logo() {
    ?>
    <?php 
    $atreves_logo_on = get_post_meta(get_the_ID(), 'atreves_enable_sec_logo', true);
    $atreves_logo = get_template_directory_uri() . '/assets/img/logo/logo.png';
    $atreves_logo_white = get_template_directory_uri() . '/assets/img/logo/logo-white.png';
    $atreves_retina_logo = get_template_directory_uri().'/assets/img/logo/logo@2x.png';
    $atreves_retina_logo_white = get_template_directory_uri().'/assets/img/logo/logo-white@2x.png';
    $atreves_retina_logo  = get_theme_mod('retina_logo',$atreves_retina_logo);
    $atreves_retina_logo_white  = get_theme_mod('retina_secondary_logo',$atreves_retina_logo_white);
    $atreves_site_logo = get_theme_mod('logo', $atreves_logo);
    $atreves_secondary_logo = get_theme_mod('seconday_logo', $atreves_logo_white);
    ?>
     <?php
    if( has_custom_logo()){
        the_custom_logo();
    }else{
        if($atreves_logo_on === 'on') { ?>
            <a class="standard-logo" href="<?php print esc_url(home_url('/')); ?>">
                <img src="<?php print esc_url($atreves_secondary_logo); ?>" alt="<?php print esc_attr('logo','atreves'); ?>" />
            </a>
            <a class="retina-logo" href="<?php print esc_url(home_url('/')); ?>">
                <img src="<?php print esc_url($atreves_retina_logo_white); ?>" alt="<?php print esc_attr('logo','atreves'); ?>" />
            </a>
        <?php 
        }
        else{ ?>
            <a class="standard-logo" href="<?php print esc_url(home_url('/')); ?>">
                <img src="<?php print esc_url($atreves_site_logo); ?>" alt="<?php print esc_attr('logo','atreves'); ?>" />
            </a>
            <a class="retina-logo" href="<?php print esc_url(home_url('/')); ?>">
                <img src="<?php print esc_url($atreves_retina_logo); ?>" alt="<?php print esc_attr('logo','atreves'); ?>" />
            </a>
        <?php 
        }
    }   
    ?>
    <?php 
} 


//atreves breadcrumb
add_action('atreves_before_main_content', 'atreves_check_breadcrumb');
function atreves_check_breadcrumb() {
    $atreves_breadcrumb_style = get_post_meta( get_the_ID(), 's7template_choice_breadcrumb_style', true );
    $atreves_default_breadcrumb_style = get_theme_mod('choose_default_breadcrumb', 'breadcrumb-style-1' );
    if( $atreves_breadcrumb_style == 'breadcrumb-style-1' ) {
        atreves_breadcrumb_style_1();
    }
    elseif( $atreves_breadcrumb_style == 'breadcrumb-style-2' ) {
        atreves_breadcrumb_style_2();
    }
    else {
        if($atreves_default_breadcrumb_style == 'breadcrumb-style-1'){
            atreves_breadcrumb_style_1();
        }elseif($atreves_default_breadcrumb_style == 'breadcrumb-style-2'){
            atreves_breadcrumb_style_2();
        }
    }
}

//atreves_breadcrumb_style_1
function atreves_breadcrumb_style_1() { 
    $atreves_invisible_breadcrumb = get_post_meta( get_the_ID(), 's7template_invisible_breadcrumb', true );
    if( !$atreves_invisible_breadcrumb ) {
        $breadcrumb_img_from_page = get_post_meta(get_the_ID(), 's7template_breadcrumb_bg_img_from_page', true);
        $breadcrumb_color_from_page = get_post_meta(get_the_ID(), 's7template_breadcrumb_bg_color', true);
        $hide_breadcrumb_bg_img = get_post_meta(get_the_ID(), 's7template_hide_breadcrumb_bg_img', true); 
        $sub_banner_img= get_theme_mod('sub-banner-img');
        if($sub_banner_img !== null && $sub_banner_img ==""){
            $sub_banner_img = get_template_directory_uri() . '/assets/img/sub-banner-img.jpg';
        }
       
        // breadcrumb bg image
        if( empty($hide_breadcrumb_bg_img ) ){

            if( $breadcrumb_img_from_page ){
                $bg_img = get_post_meta(get_the_ID(), 's7template_breadcrumb_bg_img_from_page', true);
                $bg_img = 'background-image :url('.$bg_img.')';   
            }else{
                $bg_img = get_theme_mod('breadcrumb_bg_img');
                $bg_img = 'background-image :url('.$bg_img.')';    
            }    
        }else{
            $bg_img = "";
        } 
        // breadcrumb color
        if( $breadcrumb_color_from_page ){
            $bg_color = get_post_meta(get_the_ID(), 's7template_breadcrumb_bg_color', true);
            $bg_color = 'background-color :'.$bg_color.'';    
        }else{
            $bg_color = get_theme_mod('breadcrumb_bg_color');
            $bg_color = 'background-color :'.$bg_color.'';    
        }
        $breadcrumb_blog_title = get_theme_mod('breadcrumb_blog_title', esc_html__('Blog ', 'atreves'));
        $breadcrumb_blog_title_details = get_theme_mod('breadcrumb_blog_title_details', esc_html__('Blog Details', 'atreves'));
        $atreves_blog_breadcrumb = get_theme_mod('atreves_blog_breadcrumb', '');
        $featured_img = get_the_post_thumbnail_url(get_the_ID(),'full');
        $getBannerSetting = get_post_meta(get_the_ID(),'_elementor_page_settings', true);

        if ( is_front_page() && is_home() ) { ?>
            <!-- page-title area start -->
            <div class="page-title-area overlay-bg style-1" style="<?php if ($featured_img) { ?> background-image: url(<?php the_post_thumbnail_url( 'full' ); }else if (!$featured_img) { ?> background-image: url(<?php print esc_attr($sub_banner_img); } else { print esc_attr( $bg_img ); } ?>); ">
                <div class="container">
                    <div class="row d-flex align-items-center">
                        <div class="col-sm-12 text-center">
                            <h1 class="title"><?php print esc_html($breadcrumb_blog_title); ?></h1>
                            <?php
                                $meta = get_post_meta(get_the_ID(),'my-meta-box', true);
                                if($meta != '') {
                                echo '<p>'. $meta.' </p>';
                                }else { 
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- page-title area end -->
        <?php   
        } elseif ( is_front_page()){?>
        <div class="breadcrumb-area breadcrumb-bg only-front-page breadcrumb-spacing style-1">
        </div>
        <?php
        } elseif ( is_home()){?>
        
            <!-- page-title area start-->
            <div class="page-title-area overlay-bg style-1" style="<?php if (esc_attr( $bg_img )) { ?> background-image: url(<?php print esc_attr($sub_banner_img); } else { print esc_attr( $bg_img ); } ?>); ">
                <div class="container">
                    <div class="row d-flex align-items-center">
                        <div class="col-sm-12 text-center">
                            <?php 
                            if ( is_single() && 'post' == get_post_type() ) { 
                                if ( $atreves_blog_breadcrumb == '' ) { ?>
                                    <h1><?php print esc_html($breadcrumb_blog_title_details); ?></h1>
                                    <?php
                                $meta = get_post_meta(get_the_ID(),'dbt_text', true);
                                if($meta != '') {
                                echo '<p>'. $meta.' </p>';
                                }else { 
                                echo "";
                                }
                            ?>
                                <?php 
                                }
                                else { ?>
                                    <h3><?php print esc_html($atreves_blog_breadcrumb);?></h3>
                                    <?php
                                $meta = get_post_meta(get_the_ID(),'dbt_text', true);
                                if($meta != '') {
                                echo '<p>'. $meta.' </p>';
                                }else { 
                                echo "";
                                }
                            ?>
                                <?php 
                                } ?>
                                
                                <?php 
                            }
                            else { ?>
                                <h3 class="title"><?php wp_title(''); ?></h3>
                                <?php
                                $meta = get_post_meta(get_the_ID(),'dbt_text', true);
                                if($meta != '') {
                                echo '<p>'. $meta.' </p>';
                                }else { 
                                echo "";
                                }
                            ?>
                            <?php 
                            } ?>
                            <ul class="breadcrumb">
                                <?php atreves_breadcrumbs(); ?>
                            </ul>
                        </div>

                    </div>
                </div>
            </div>
            <!-- page-title area end -->
        <?php
        }
        elseif ( is_single() ) { ?>
             <!-- page-title area start -->
             <div class="page-title-area overlay-bg style-1" style="<?php if (esc_attr( $bg_img )) { ?> background-image: url(<?php print esc_attr($sub_banner_img); }else { print esc_attr( $bg_img ); } ?>); ">
                 <div class="container">
                     <div class="row">
                        <div class="col-xl-12 col-lg-12 col-12">
                        <div class="col-sm-12 text-center">
                            <?php 
                            if ( is_single() && 'post' == get_post_type() ) { 
                                if ( $atreves_blog_breadcrumb == '' ) { ?>
                                    <h1><?php echo get_the_title(); ?></h1>
                                    <?php
                                $meta = get_post_meta(get_the_ID(),'dbt_text', true);
                                if($meta != '') {
                                echo '<p>'. $meta.' </p>';
                                }else { 
                                echo "";
                                }
                            ?>
                                <?php 
                                }
                                else { ?>
                                    <h3> <?php print esc_html($atreves_blog_breadcrumb);?></h3>
                                    <?php
                                $meta = get_post_meta(get_the_ID(),'dbt_text', true);
                                if($meta != '') {
                                echo '<p>'. $meta.' </p>';
                                }else { 
                                echo "";
                                }
                            ?>
                                <?php 
                                } ?>
                                <?php 
                            }
                            else { ?>
                                <h3 class="title"><?php echo get_the_title(); ?></h3>
                                <?php
                                $meta = get_post_meta(get_the_ID(),'dbt_text', true);
                                if($meta != '') {
                                echo '<p>'. $meta.' </p>';
                                }else { 
                                echo "";
                                }
                            ?>
                            <?php 
                            } ?>
                         </div>
                         <div class="col-sm-12 text-center">
                             <ul class="breadcrumb">
                                 <?php atreves_breadcrumbs(); ?>
                             </ul>
                         </div>
                        </div>
                     </div>
                 </div>
             </div>
             <!-- page-title area end -->

        <?php
        }
        elseif ( is_archive() ) { ?>
            <!-- page-title area start -->
            <div class="page-title-area overlay-bg style-1" style="<?php if (esc_attr( $bg_img )) { ?> background-image: url(<?php print esc_attr($sub_banner_img); }  else { print esc_attr( $bg_img ); } ?>); ">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-sm-12 text-center">
                           <?php 
                           if ( is_archive() && 'post' == get_post_type() ) { 
                               if ( $atreves_blog_breadcrumb == '' ) { ?>
                                   <h1><?php echo get_the_title(); ?></h1>
                                   <?php
                               $meta = get_post_meta(get_the_ID(),'dbt_text', true);
                               if($meta != '') {
                               echo '<p>'. $meta.' </p>';
                               }else { 
                               echo "";
                               }
                           ?>
                               <?php 
                               }
                               else { ?>
                                   <h3><?php print esc_html($atreves_blog_breadcrumb);?></h3>
                                   <?php
                               $meta = get_post_meta(get_the_ID(),'dbt_text', true);
                               if($meta != '') {
                               echo '<p>'. $meta.' </p>';
                               }else { 
                               echo "";
                               }
                           ?>
                               <?php 
                               } ?>
                               <?php 
                           }
                           else { ?>
                               <h3 class="title"><?php echo get_the_title(); ?></h3>
                               <?php
                               $meta = get_post_meta(get_the_ID(),'dbt_text', true);
                               if($meta != '') {
                               echo '<p>'. $meta.' </p>';
                               }else { 
                               echo "";
                               }
                           ?>
                           <?php 
                           } ?>
                        </div>
                        <div class="col-sm-12 text-center">
                            <ul class="breadcrumb">
                                <?php atreves_breadcrumbs(); ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- page-title area end -->

       <?php
       }
        else {  if(!isset($getBannerSetting['banner_display']) || $getBannerSetting['banner_display'] == ""){ ?>
            <div class="page-title-area overlay-bg style-1" style="<?php if ($featured_img) { ?> background-image: url(<?php the_post_thumbnail_url( 'full' ); } else if (!$featured_img) { ?> background-image: url(<?php print esc_attr($sub_banner_img); }  else { print esc_attr( $bg_img ); } ?>); ">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-sm-12 text-center">
                           <?php 
                            if ( is_single() && 'post' == get_post_type() ) { 
                                if ( $atreves_blog_breadcrumb == '' ) { ?>
                                    <h1 class="title"><?php print esc_html($breadcrumb_blog_title_details); ?></h1>
                                    <?php
                                $meta = get_post_meta(get_the_ID(),'dbt_text', true);
                                if($meta != '') {
                                echo '<p>'. $meta.' </p>';
                                }else { 
                                echo "";
                                }
                            ?>
                                <?php 
                                }
                                else { ?>
                                    <h3 class="title"> <?php print esc_html($atreves_blog_breadcrumb);?></h3>
                                    <?php
                                $meta = get_post_meta(get_the_ID(),'dbt_text', true);
                                if($meta != '') {
                                echo '<p>'. $meta.' </p>';
                                }else { 
                                echo "";
                                }
                            ?>
                                <?php 
                                } ?>
                                
                                <?php 
                            }
                            else { ?>
                                <h3 class="title"><?php wp_title(''); ?></h3>
                                <?php
                                $meta = get_post_meta(get_the_ID(),'dbt_text', true);
                                if($meta != '') {
                                echo '<p>'. $meta.' </p>';
                                }else { 
                                echo "";
                                }
                            ?>
                            <?php 
                            } ?>
                        </div>
                        <div class="col-sm-12 text-center">
                             <ul class="breadcrumb">
                                 <?php atreves_breadcrumbs(); ?>
                             </ul>
                        </div>
                    </div>
                </div>
            </div>
        <?php
        }       
    }
}
}

//atreves_breadcrumb_style_2
function atreves_breadcrumb_style_2() { 
    $atreves_invisible_breadcrumb = get_post_meta( get_the_ID(), 's7template_invisible_breadcrumb', true );
    if( !$atreves_invisible_breadcrumb ) {
        $breadcrumb_img_from_page = get_post_meta(get_the_ID(), 's7template_breadcrumb_bg_img_from_page', true);
        $breadcrumb_color_from_page = get_post_meta(get_the_ID(), 's7template_breadcrumb_bg_color', true);
        $hide_breadcrumb_bg_img = get_post_meta(get_the_ID(), 's7template_hide_breadcrumb_bg_img', true); 

        // breadcrumb bg image
        if( empty($hide_breadcrumb_bg_img ) ){

            if( $breadcrumb_img_from_page ){
                $bg_img = get_post_meta(get_the_ID(), 's7template_breadcrumb_bg_img_from_page', true);
                $bg_img = 'background-image :url('.$bg_img.')';
            }else{
                $bg_img = get_theme_mod('breadcrumb_bg_img');
                $bg_img = 'background-image :url('.$bg_img.')';    
            }    
        }else{
            $bg_img = "";
        }
        
       
        // breadcrumb color
        if( $breadcrumb_color_from_page ){
            $bg_color = get_post_meta(get_the_ID(), 's7template_breadcrumb_bg_color', true);
            $bg_color = 'background-color :'.$bg_color.'';  
        }else{
            $bg_color = get_theme_mod('breadcrumb_bg_color');
            $bg_color = 'background-color :'.$bg_color.'';    
        }

        $breadcrumb_blog_title = get_theme_mod('breadcrumb_blog_title', esc_html__('Blog ', 'atreves'));
        $breadcrumb_blog_title_details = get_theme_mod('breadcrumb_blog_title_details', esc_html__('Blog Details', 'atreves'));

        $atreves_blog_breadcrumb = get_theme_mod('atreves_blog_breadcrumb', '');
        $featured_img = get_the_post_thumbnail_url(get_the_ID(),'full');
        $getBannerSetting = get_post_meta(get_the_ID(),'_elementor_page_settings', true);
        if ( is_front_page() && is_home() ) { ?>

            <!-- page-title area start -->
            <div class="page-title-area overlay-bg style-2" style="<?php if ($featured_img) { ?> background-image: url(<?php the_post_thumbnail_url( 'full' ); } else { print esc_attr( $bg_img ); } ?>); ">
                <div class="container">
                    <div class="row d-flex align-items-center">
                        <div class="col-sm-12 text-center">
                            <h3 class="title"><?php print esc_html($breadcrumb_blog_title); ?></h3>
                            <?php
                                $meta = get_post_meta(get_the_ID(),'dbt_text', true);
                                if($meta != '') {
                                echo '<p>'. $meta.' </p>';
                                }else { 
                                echo "";
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- page-title area end -->
        <?php   
        } elseif ( is_front_page()){?>
        <div class="breadcrumb-area breadcrumb-bg only-front-page breadcrumb-spacing style-2">
        </div>
        <?php
        } elseif ( is_home()){ ?>
            <!-- page-title area start-->
            <div class="page-title-area overlay-bg style-2" style="<?php if (print esc_attr( $bg_img )) { ?> background-image: url(<?php the_post_thumbnail_url( 'full' ); } else { print esc_attr( $bg_img ); } ?>); ">
                <div class="container">
                    <div class="row d-flex align-items-center">
                        <div class="col-sm-12 text-center">
                            <?php 
                            if ( is_single() && 'post' == get_post_type() ) { 
                                if ( $atreves_blog_breadcrumb == '' ) { ?>
                                    <h1><?php print esc_html($breadcrumb_blog_title_details); ?></h1>
                                    <?php
                                $meta = get_post_meta(get_the_ID(),'dbt_text', true);
                                if($meta != '') {
                                echo '<p>'. $meta.' </p>';
                                }else { 
                                echo "";
                                }
                            ?>
                                <?php 
                                }
                                else { ?>
                                    <h3> <?php print esc_html($atreves_blog_breadcrumb);?></h3>
                                    <?php
                                $meta = get_post_meta(get_the_ID(),'dbt_text', true);
                                if($meta != '') {
                                echo '<p>'. $meta.' </p>';
                                }else { 
                                echo "";
                                }
                            ?>
                                <?php 
                                } ?>
                                <?php 
                            }
                            else { ?>
                                <h3 class="title"><?php wp_title('');?></h3>
                                <?php
                                $meta = get_post_meta(get_the_ID(),'dbt_text', true);
                                if($meta != '') {
                                echo '<p>'. $meta.' </p>';
                                }else { 
                                echo "";
                                }
                            ?>
                            <?php 
                            } ?>
                            <ul class="breadcrumb">
                                <?php atreves_breadcrumbs(); ?>
                            </ul>
                        </div>

                    </div>
                </div>
            </div>
            <!-- page-title area end -->
        <?php
        }
        elseif ( is_single() ) { ?>
             <!-- page-title area start -->
             <div class="page-title-area overlay-bg style-2" style="<?php if (print esc_attr( $bg_img )) { ?> background-image: url(<?php the_post_thumbnail_url( 'full' ); } else { print esc_attr( $bg_img ); } ?>); ">
                 <div class="container">
                     <div class="row justify-content-center">
                         <div class="col-sm-12 text-center">
                            <?php 
                            if ( is_single() && 'post' == get_post_type() ) { 
                                if ( $atreves_blog_breadcrumb == '' ) { ?>
                                    <h3><?php wp_title(''); ?></h3>
                                    <?php
                                $meta = get_post_meta(get_the_ID(),'dbt_text', true);
                                if($meta != '') {
                                echo '<p>'. $meta.' </p>';
                                }else { 
                                echo "";
                                }
                            ?>
                                <?php 
                                }
                                else { ?>
                                    <h3> <?php print esc_html($atreves_blog_breadcrumb);?></h3>
                                    <?php
                                $meta = get_post_meta(get_the_ID(),'dbt_text', true);
                                if($meta != '') {
                                echo '<p>'. $meta.' </p>';
                                }else { 
                                echo "";
                                }
                            ?>
                                <?php 
                                } ?>
                                
                                <?php 
                            }
                            else { ?>
                                <h3><?php wp_title(''); ?></h3>
                                <?php
                                $meta = get_post_meta(get_the_ID(),'dbt_text', true);
                                if($meta != '') {
                                echo '<p>'. $meta.' </p>';
                                }else { 
                                echo "";
                                }
                            ?>
                            <?php 
                            } ?>
                         </div>
                         <div class="col-sm-12 text-center">
                             <ul class="breadcrumb">
                                 <?php atreves_breadcrumbs(); ?>
                             </ul>
                         </div>
                     </div>
                 </div>
             </div>
             <!-- page-title area end -->
        <?php
        }
        elseif ( is_archive() ) { ?>
            <!-- page-title area start -->
            <div class="page-title-area overlay-bg style-1" style="<?php if (print esc_attr( $bg_img )) { ?> background-image: url(<?php the_post_thumbnail_url( 'full' ); }else if (!$featured_img) { ?> background-image: url(<?php print esc_attr($sub_banner_img); }  else { print esc_attr( $bg_img ); } ?>); ">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-sm-12 text-center">
                           <?php 
                           if ( is_archive() && 'post' == get_post_type() ) { 
                               if ( $atreves_blog_breadcrumb == '' ) { ?>
                                   <h3><?php wp_title(''); ?></h3>
                                   <?php
                               $meta = get_post_meta(get_the_ID(),'dbt_text', true);
                               if($meta != '') {
                               echo '<p>'. $meta.' </p>';
                               }else { 
                               echo "";
                               }
                           ?>
                               <?php 
                               }
                               else { ?>
                                   <h3> <?php print esc_html($atreves_blog_breadcrumb);?></h3>
                                   <?php
                               $meta = get_post_meta(get_the_ID(),'dbt_text', true);
                               if($meta != '') {
                               echo '<p>'. $meta.' </p>';
                               }else { 
                               echo "";
                               }
                           ?>
                               <?php 
                               } ?>
                               <?php 
                           }
                           else { ?>
                               <h3 class="title"><?php wp_title(''); ?></h3>
                               <?php
                               $meta = get_post_meta(get_the_ID(),'dbt_text', true);
                               if($meta != '') {
                               echo '<p>'. $meta.' </p>';
                               }else { 
                               echo "";
                               }
                           ?>
                           <?php 
                           } ?>
                        </div>
                        <div class="col-sm-12 text-center">
                            <ul class="breadcrumb">
                                <?php atreves_breadcrumbs(); ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- page-title area end -->

       <?php
       }
        else { if(!isset($getBannerSetting['banner_display']) || $getBannerSetting['banner_display'] == ""){ ?>
            <div class="page-title-area overlay-bg style-2" style="<?php if ($featured_img) { ?> background-image: url(<?php the_post_thumbnail_url( 'full' ); } else { print esc_attr( $bg_img ); } ?>); ">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-sm-12 text-center">
                           <?php 
                            if ( is_single() && 'post' == get_post_type() ) { 
                                if ( $atreves_blog_breadcrumb == '' ) { ?>
                                    <h1 class="title"><?php print esc_html($breadcrumb_blog_title_details); ?></h1>
                                    <?php
                                $meta = get_post_meta(get_the_ID(),'dbt_text', true);
                                if($meta != '') {
                                echo '<p>'. $meta.' </p>';
                                }else { 
                                echo "";
                                }
                            ?>
                                <?php 
                                }
                                else { ?>
                                    <h3 class="title"> <?php print esc_html($atreves_blog_breadcrumb);?></h3>
                                    <?php
                                $meta = get_post_meta(get_the_ID(),'dbt_text', true);
                                if($meta != '') {
                                echo '<p>'. $meta.' </p>';
                                }else { 
                                echo "";
                                }
                            ?>
                                <?php 
                                } ?>
                                
                                <?php 
                            }
                            else { ?>
                                <h3 class="title"><?php wp_title(''); ?></h3>
                                <?php
                                $meta = get_post_meta(get_the_ID(),'dbt_text', true);
                                if($meta != '') {
                                echo '<p>'. $meta.' </p>';
                                }else { 
                                echo "";
                                }
                            ?>
                            <?php 
                            } ?>
                        </div>
                        <div class="col-sm-12 text-center">
                             <ul class="breadcrumb">
                                 <?php atreves_breadcrumbs(); ?>
                             </ul>
                        </div>
                    </div>
                </div>
            </div>
        <?php
        }       
    }
}
}
//atreves_breadcrumbs
if(!function_exists('atreves_breadcrumbs')) {
    function _atreves_home_callback($home) {
        return $home;
    }
    function _atreves_breadcrumbs_callback($breadcrumbs) {
        return $breadcrumbs;
    }
    function atreves_breadcrumbs() {
        global $post;
        $breadcrumb_archive = get_theme_mod('breadcrumb_archive', esc_html__('Archive for category ', 'atreves'));
        $breadcrumb_search = get_theme_mod('breadcrumb_search', esc_html__('Search results for ', 'atreves'));
        $breadcrumb_post_tags = get_theme_mod('breadcrumb_post_tags', esc_html__('Posts tagged ', 'atreves'));
        $breadcrumb_artitle_post_by = get_theme_mod('breadcrumb_artitle_post_by', esc_html__('Articles posted by ', 'atreves'));
        $breadcrumb_404 = get_theme_mod('breadcrumb_404', esc_html__('Page Not Found ', 'atreves'));
        $breadcrumb_page = get_theme_mod('breadcrumb_page', esc_html__('Page ', 'atreves'));
        $breadcrumb_shop = get_theme_mod('breadcrumb_shop', esc_html__('Shop ', 'atreves'));
        $breadcrumb_home = get_theme_mod('breadcrumb_home', esc_html__('Home ', 'atreves'));
        $home = '<li class="breadcrumb-list"><a href="'.esc_url(home_url('/')).'" title="'.esc_attr($breadcrumb_home).'">'.esc_html($breadcrumb_home).'</a></li>';
        $showCurrent = 1;               
        $homeLink = esc_url(home_url('/'));
        if ( is_front_page() ) { return; }  // don't display breadcrumbs on the homepage (yet)
        print _atreves_home_callback($home);
        if ( is_category() ) {
            // category section
            $thisCat = get_category(get_query_var('cat'), false);
            if (!empty($thisCat->parent)) print get_category_parents($thisCat->parent, TRUE, ' ' . '/' . ' ');
            print '<li class="active">'.  esc_html($breadcrumb_archive).' "' . single_cat_title('', false) . '"' . '</li>';
        } 
        elseif ( is_search() ) {
            // search section
            print '<li class="active">' .  esc_html($breadcrumb_search).' "' . get_search_query() . '"' .'</li>';
        } 
        elseif ( is_day() ) {
            print '<li class="breadcrumb-list"><a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a></li>';
            print '<li class="breadcrumb-list"><a href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . get_the_time('F') . '</a> </li>';
            print '<li class="active">' . get_the_time('d') .'</li>';
        } 
        elseif ( is_month() ) {
            // monthly archive
            print '<li class="breadcrumb-list"><a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> </li>';
            print '<li class=" active">' . get_the_time('F') .'</li>';
        } 
        elseif ( is_year() ) {
            // yearly archive
            print '<li class="active">'. get_the_time('Y') .'</li>';
        } 
        elseif ( is_single() && !is_attachment() ) {
            // single post or page
            if ( get_post_type() != 'post' ) {
                $post_type = get_post_type_object(get_post_type());
                $slug = $post_type->rewrite;
                print '<li class="breadcrumb-list">';
                if ($slug && isset($slug['slug']) && $post_type && $post_type->labels && $post_type->labels->singular_name) {
                    print '<a href="' . $homeLink . '/?post_type=' . $slug['slug'] . '">' . $post_type->labels->singular_name . '</a>';
                }
                print '</li>';
                if ($showCurrent) print '<li class="active">'. get_the_title() .'</li>';
            } 
            else {
                $cat = get_the_category(); if (isset($cat[0])) {$cat = $cat[0];} else {$cat = false;}
                if ($cat) {$cats = get_category_parents($cat, TRUE, ' ' .' ' . ' ');} else {$cats=false;}
                if (!$showCurrent && $cats) $cats = preg_replace("#^(.+)\s\s$#", "$1", $cats);
                print '<li class="breadcrumb-list tajul_via">'.$cats.'</li>';
                
                if ($showCurrent) print '<li class="active">'. get_the_title() .'</li>';
            }
        } 
        elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
            // some other single item
            $post_type = get_post_type_object(get_post_type());
            print '<li class="breadcrumb-list">' . $post_type->labels->singular_name .'<li>';

            if ( 
              in_array( 
                'woocommerce/woocommerce.php', 
                apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) 
              ) 
            ) {
               if ( is_shop() && !get_query_var('paged') ) {
                    print '<span class="active">'. esc_html($breadcrumb_shop) .'</span>';
                }
            }
        } 
        elseif ( is_attachment() ) {
            // attachment section
            $parent = get_post($post->post_parent);
            $cat = get_the_category($parent->ID); if (isset($cat[0])) {$cat = $cat[0];} else {$cat=false;}
            if ($cat) print get_category_parents($cat, TRUE, ' ' . ' ' . ' ');
            print '<li class="breadcrumb-list"><a href="' . get_permalink($parent) . '">' . $parent->post_title . '</a></li>';
            if ($showCurrent) print  '<li class="active">'. get_the_title() .'</li>';
        } 
        elseif ( is_page() && !$post->post_parent ) {

            // parent page
            if ($showCurrent) 
                print '<li class="breadcrumb-list"><a href="' . get_permalink() . '">'. get_the_title() .'</a></li>';
        } 
        elseif ( is_page() && $post->post_parent ) {
            // child page
            $parent_id  = $post->post_parent;
            $breadcrumbs = array();

            while ($parent_id) {
                $page = get_page($parent_id);
                $breadcrumbs[] = '<li class="breadcrumb-list"><a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a></li>';
                $parent_id  = $page->post_parent;
            }
            $breadcrumbs = array_reverse($breadcrumbs);
            for ($i = 0; $i < count($breadcrumbs); $i++) {
                print _atreves_breadcrumbs_callback($breadcrumbs[$i]);
                if ($i != count($breadcrumbs)-1);
            }
            if ($showCurrent) print '<li class="active">'. get_the_title() .'</li>';
        } 
        elseif ( is_tag() ) {
            // tags archive
            print '<li class="breadcrumb-list">' .  esc_html($breadcrumb_post_tags).' "' . single_tag_title('', false) . '"' . '</li>';
        } 
        elseif ( is_author() ) {
            // author archive 
            global $author;
            $userdata = get_userdata($author);
            print '<li class="breadcrumb-list">' .  esc_html($breadcrumb_artitle_post_by). ' ' . $userdata->display_name . '</li>';
        } 
        elseif ( is_404() ) {
            // 404
            print '<li class="active salim">'. esc_html($breadcrumb_404) .'</li>';
        }
      
        if ( get_query_var('paged') ) {


            if ( 
              in_array( 
                'woocommerce/woocommerce.php', 
                apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) 
              ) 
            ) {
                if ( is_shop() ) {
                    print '<span class="active">'. esc_html($breadcrumb_page) . ' ' . get_query_var('paged') .'</span>';
                }
                else {
                    if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) print '<li class="breadcrumb-list"> (';
                    print  '<li class="active">'.esc_html($breadcrumb_page) . ' ' . get_query_var('paged').'</li>';
                    if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) print ')</li>';
                }
            }
        }
    }
}


//atreves footer
add_action('atreves_footer_style', 'atreves_check_footer', 10);
function atreves_check_footer() {
       $atreves_footer_style = get_post_meta( get_the_ID(), 's7template_choice_footer_style', true );
       $atreves_default_footer_style = get_theme_mod('choose_default_footer', 'footer-style-1' );
       if( $atreves_footer_style == 'footer-style-1' ) {
           atreves_footer_style_1();
       }
       else{
          atreves_footer_style_2();
       }
}


//footer  style 1
function atreves_footer_style_1() {
    $atreves_footer_bg_url_from_page = get_post_meta( get_the_ID(), 's7template_footer_bg', true );
    $atreves_footer_bg_color_from_page = get_post_meta( get_the_ID(), 's7template_footer_bg_color', true );
    $atreves_footer_type = get_theme_mod('footer_source_type');
    $atreves_footer_e = get_theme_mod('atreves_footer_elementor_templates');
    if( $atreves_footer_bg_url_from_page ){
        $bg_img = get_post_meta( get_the_ID(), 's7template_footer_bg', true );
    }else{
        $bg_img = get_theme_mod('atreves_footer_bg');
    }  
    if( $atreves_footer_bg_color_from_page ){
        $bg_color = get_post_meta( get_the_ID(), 's7template_footer_bg_color', true );
    }else{
        $bg_color = get_theme_mod('atreves_footer_bg_color');
    }    
    $enable_footer_widgets = get_theme_mod('atreves_enable_footer_widgets');  
?>
</div>

<!-- footer area start -->
<footer class="footer-area style-2" style="background-image :url(<?php print esc_url($bg_img); ?> );  background-color: <?php print esc_attr( $bg_color ); ?>">
    <?php 
    if($enable_footer_widgets) :
        if( is_active_sidebar( 'footer-widget-1' ) || is_active_sidebar( 'footer-widget-2' ) || is_active_sidebar( 'footer-widget-3' ) || is_active_sidebar( 'footer-widget-4' ) ): ?>
            <div class="footer-top">
                <div class="container">
                    <div class="row custom-gutter">
                    
                        <?php 
                        if ( is_active_sidebar( 'footer-widget-1' ) ): ?>
                            <div class="col-xl-4 col-lg-6 col-md-6">
                                <?php dynamic_sidebar( 'footer-widget-1' ); ?>
                            </div>
                        <?php 
                        endif; ?> 
                        
                        <?php 
                        if ( is_active_sidebar( 'footer-widget-2' ) ): ?>
                            <div class="col-xl-2 col-lg-6 col-md-6">
                                <?php dynamic_sidebar( 'footer-widget-2' ); ?>
                            </div>
                        <?php 
                        endif; ?> 
                        
                        <?php 
                        if ( is_active_sidebar( 'footer-widget-3' ) ): ?>
                            <div class="col-xl-3 col-lg-3 col-md-3">
                                <?php dynamic_sidebar( 'footer-widget-3' ); ?>
                            </div>
                        <?php 
                        endif; ?> 
                        
                        <?php 
                        if ( is_active_sidebar( 'footer-widget-4' ) ): ?>
                            <div class="col-xl-3 col-lg-3 col-md-3">
                                <?php dynamic_sidebar( 'footer-widget-4' ); ?>
                            </div>
                        <?php 
                        endif; ?> 
                    </div>
                </div>
            </div>
        <?php 
        endif; 
    endif; ?>
    <?php
        if ('e' === $atreves_footer_type) {
            echo Elementor\Plugin::instance()
            ->frontend
                ->get_builder_content_for_display($atreves_footer_e);
        }
    ?>
    <div class="footer-bottom">
        <div class="container">
            <div class="row">
                <?php 
                if( is_active_sidebar( 'footer-menu' ) ): ?>  
                  
                    <div class="col-lg-7 text-lg-left text-center">
                          <?php dynamic_sidebar( 'footer-menu' ); ?>
                    </div>
                    <div class="col-lg-5 text-center text-lg-right">
                        <p class="copyright">
                            <?php atreves_copyright_text(); ?>
                        </p>
                    </div>
                <?php 
                else: ?> 
                    <div class="col-lg-12 text-center">
                        <p class="copyright">
                            <?php atreves_copyright_text(); ?>
                        </p>
                    </div>
                <?php 
                endif; ?>
            </div>
        </div>
    </div>
</footer>
<!-- footer area end -->
<?php 
}


//footer  style 2
function atreves_footer_style_2() {
    $atreves_footer_bg_url_from_page = get_post_meta( get_the_ID(), 's7template_footer_bg', true );
    $atreves_footer_bg_color_from_page = get_post_meta( get_the_ID(), 's7template_footer_bg_color', true );
    $atreves_footer_type = get_theme_mod('footer_source_type');
    $atreves_footer_e = get_theme_mod('atreves_footer_elementor_templates');
    if( $atreves_footer_bg_url_from_page ){
            $bg_img = get_post_meta( get_the_ID(), 's7template_footer_bg', true );
    }else{
            $bg_img = get_theme_mod('atreves_footer_bg');
    }  
    if( $atreves_footer_bg_color_from_page ){
            $bg_color = get_post_meta( get_the_ID(), 's7template_footer_bg_color', true );
    }else{
            $bg_color = get_theme_mod('atreves_footer_bg_color');
    }    
    $enable_footer_widgets = get_theme_mod('atreves_enable_footer_widgets');  
?>
</div>

<!-- footer area start -->
<footer class="footer-area style-3" style="background-image :url(<?php print esc_url($bg_img); ?> );  background-color: <?php print esc_attr( $bg_color ); ?>">

    <?php 
    if($enable_footer_widgets) :
        if( is_active_sidebar( 'footer-widget-1' ) || is_active_sidebar( 'footer-widget-2' ) || is_active_sidebar( 'footer-widget-3' ) || is_active_sidebar( 'footer-widget-4' ) ): ?>
            <div class="footer-top">
                <div class="container">
                    <div class="row custom-gutter">
                    
                        <?php 
                        if ( is_active_sidebar( 'footer-widget-1' ) ): ?>
                            <div class="col-xl-4 col-lg-6 col-md-6">
                                <?php dynamic_sidebar( 'footer-widget-1' ); ?>
                            </div>
                        <?php 
                        endif; ?> 
                        
                        <?php 
                        if ( is_active_sidebar( 'footer-widget-2' ) ): ?>
                            <div class="col-xl-2 col-lg-6 col-md-6">
                                <?php dynamic_sidebar( 'footer-widget-2' ); ?>
                            </div>
                        <?php 
                        endif; ?> 
                        
                        <?php 
                        if ( is_active_sidebar( 'footer-widget-3' ) ): ?>
                            <div class="col-xl-3 col-lg-3 col-md-3">
                                <?php dynamic_sidebar( 'footer-widget-3' ); ?>
                            </div>
                        <?php 
                        endif; ?> 
                        
                        <?php 
                        if ( is_active_sidebar( 'footer-widget-4' ) ): ?>
                            <div class="col-xl-3 col-lg-3 col-md-3">
                                <?php dynamic_sidebar( 'footer-widget-4' ); ?>
                            </div>
                        <?php 
                        endif; ?> 
                        
                    </div>
                </div>
            </div>
        <?php 
        endif; 
    endif; ?>
    <?php
        if ('e' === $atreves_footer_type) {
            echo Elementor\Plugin::instance()
            ->frontend
                ->get_builder_content_for_display($atreves_footer_e);
        }
    ?>
    <div class="footer-bottom">
        <div class="container">
            <div class="row">
                <?php 
                if( is_active_sidebar( 'footer-menu' ) ): ?>  
                  
                    <div class="col-lg-7 text-lg-left text-center">
                          <?php dynamic_sidebar( 'footer-menu' ); ?>
                    </div>
                    <div class="col-lg-5 text-center text-lg-right">
                        <p class="copyright">
                            <?php atreves_copyright_text(); ?>
                        </p>
                    </div>

                <?php 
                else: ?>  

                    <div class="col-lg-12 text-center">
                        <p class="copyright">
                            <?php atreves_copyright_text(); ?>
                        </p>
                    </div>
                <?php 
                endif; ?>
            
            </div>
        </div>
    </div>
</footer>
<!-- footer area end -->
<?php 
}


//copyright info
function atreves_copyright_text(){
    echo esc_html(get_theme_mod('atreves_copyright', esc_html__('Copyright &copy; Atreves 2024. All Rights Reserved','atreves')));
}


//back to top area start 
add_action('atreves_footer_style', 'atreves_scrollTop', 15);
function atreves_scrollTop(){
    $scrollTop = get_theme_mod('atreves_scrollup_switch', false);
    if($scrollTop == true) :?>
         <div class="back-to-top">
            <span class="back-top"><i class="fa fa-long-arrow-up"></i></span>
        </div> 
    <?php 
    endif; 
}


//post-format
add_action('admin_print_scripts', 'atreves_scripts_for_admin_panel', 1000);
function atreves_scripts_for_admin_panel(){
    if( get_post_type() == 'post' ) :
    ?>
        <script>
            (function ($) {
            "use strict";
                jQuery(document).ready(function(){
                    var atreves = jQuery("input[name='post_format']:checked").attr('id');
                    if(atreves == 'post-format-video'){
                        jQuery('.cmb2-id--video-url').show();
                    }else{
                        jQuery('.cmb2-id--video-url').hide();
                    }
                    if(atreves == 'post-format-audio'){
                        jQuery('.cmb2-id--audio-url').show();
                    }else{
                        jQuery('.cmb2-id--audio-url').hide();
                    }
                    if(atreves == 'post-format-gallery'){
                        jQuery('.cmb2-id--gallery-images').show();
                    }else{
                        jQuery('.cmb2-id--gallery-images').hide();
                    }

                    jQuery('input[name="post_format"]').change(function(){
                        var atreves = jQuery("input[name='post_format']:checked").attr('id');
                        if(atreves == 'post-format-video'){
                            jQuery('.cmb2-id--video-url').show();
                        }else{
                            jQuery('.cmb2-id--video-url').hide();
                        }
                        if(atreves == 'post-format-audio'){
                            jQuery('.cmb2-id--audio-url').show();
                        }else{
                            jQuery('.cmb2-id--audio-url').hide();
                        }

                        if(atreves == 'post-format-gallery'){
                            jQuery('.cmb2-id--gallery-images').show();
                        }else{
                            jQuery('.cmb2-id--gallery-images').hide();
                        }
                    });
                })
            })(jQuery);
        </script>
    <?php endif;
}