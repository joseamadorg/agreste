<?php
/** 
 * Atreves Customizer data
 */

function atreves_customizer( $data ) {
	$atreves_elementor_template_list = atreves_get_elementor_templates();
	$atreves_elementor_header_templates = atreves_get_elementor_header_templates();
	return array(
		'panel' => array ( 
			'id' => 'atreves',
			'name' => esc_html__('Atreves Customizer','atreves'),
			'priority' => 10,
			'section' => array(
				'header_setting' => array(
					'name' => esc_html__( 'Header Topbar Setting', 'atreves' ),
					'priority' => 10,
					'fields' => array(
						array(
							'name' => esc_html__( 'Topbar Swicher', 'atreves' ),
							'id' => 'atreves_topbar_switch',
							'default' => false,
							'type' => 'switch',
							'transport'	=> 'refresh'
						),						
						array(
							'name' => esc_html__( 'Show Button', 'atreves' ),
							'id' => 'atreves_show_header_btn',
							'default' => 0,
							'type' => 'switch',
							'transport'	=> 'refresh' 
						),
						array(
							'name' => esc_html__( 'Button Text', 'atreves' ),
							'id' => 'atreves_header_btn_text',
							'default' => esc_html__('Sign in','atreves'),
							'type' => 'text',
							'transport'	=> 'refresh' 
						),
						array(
							'name' => esc_html__( 'Button Link', 'atreves' ),
							'id' => 'atreves_header_btn_link',
							'default' => '#',
							'type' => 'text',
							'transport'	=> 'refresh' 
						),						
						array(
							'name' => esc_html__( 'Button Icon', 'atreves' ),
							'id' => 'atreves_header_btn_icon',
							'default' => esc_html__('fa fa-user-o', 'atreves'),
							'type' => 'text',
							'transport'	=> 'refresh' 
						),
						/** investment button **/	
						array(
							'name' => esc_html__( 'Show Investment Offer Link', 'atreves' ),
							'id' => 'atreves_show_investment_offer_link',
							'default' => 0,
							'type' => 'switch',
							'transport'	=> 'refresh' 
						),
						array(
							'name' => esc_html__( 'Link Text', 'atreves' ),
							'id' => 'atreves_header_link_text',
							'default' => esc_html__('Atreves Offer','atreves'),
							'type' => 'text',
							'transport'	=> 'refresh' 
						),
						array(
							'name' => esc_html__( 'Link Url', 'atreves' ),
							'id' => 'atreves_header_link_url',
							'default' => '#',
							'type' => 'text',
							'transport'	=> 'refresh' 
						),
						/** contact-info **/
						array(
							'name' => esc_html__( 'Show Contact Info', 'atreves' ),
							'id' => 'atreves_show_contact_info',
							'default' => 0,
							'type' => 'switch',
							'transport'	=> 'refresh' 
						),
						array(
							'name' => esc_html__( 'Email Address', 'atreves' ),
							'id' => 'atreves_header_email',
							'default' => esc_html__('info@gmail.com','atreves'),
							'type' => 'text',
							'transport'	=> 'refresh' 
						),
						array(
							'name' => esc_html__( 'Phone Number', 'atreves' ),
							'id' => 'atreves_header_phone',
							'default' => esc_html__('+97657945737', 'atreves'),
							'type' => 'text',
							'transport'	=> 'refresh' 
						)

					) 
				),
				'atreves_topbar_social_profiles_setting' => array(
					'name' => esc_html__( 'Header Social Profiles', 'atreves' ),
					'priority' => 15,
					'fields' => array(
						array(
							'name' => esc_html__( 'Show Social Profiles', 'atreves' ),
							'id' => 'atreves_show_social_profiles',
							'default' => 0,
							'type' => 'switch',
							'transport'	=> 'refresh' 
						),
						array(
							'name' => esc_html__( 'Facebook Url', 'atreves' ),
							'id' => 'atreves_topbar_fb_url',
							'default' => '#',
							'type' => 'text',
							'transport'	=> 'refresh' 
						),
						array(
							'name' => esc_html__( 'Twitter Url', 'atreves' ),
							'id' => 'atreves_topbar_twitter_url',
							'default' => '#',
							'type' => 'text',
							'transport'	=> 'refresh' 
						),
						array(
							'name' => esc_html__( 'Linkedin Url', 'atreves' ),
							'id' => 'atreves_topbar_linkedin_url',
							'default' => '#',
							'type' => 'text',
							'transport'	=> 'refresh' 
						),
						array(
							'name' => esc_html__( 'Instagram Url', 'atreves' ),
							'id' => 'atreves_topbar_instagram_url',
							'default' => '#',
							'type' => 'text',
							'transport'	=> 'refresh' 
						),
					) 
				),
				'header_main_setting' => array(
					'name' => esc_html__( 'Header Setting', 'atreves' ),
					'priority' => 20,
					'fields' => array(
						array(
							'name' => esc_html__( 'Choose Header Style', 'atreves' ),
							'id' => 'choose_default_header',
							'type'     => 'select',
							'choices'  => array(
								'header-style-1' => esc_html__( 'Header Style 1', 'atreves' ),
								'header-style-2' => esc_html__( 'Header Style 2', 'atreves' ),
							),
							'default' => 'header-style-2',
							'transport'	=> 'refresh'
						),
						array(
							'name' => esc_html__( 'Header Type', 'atreves' ),
							'id' => 'choose_default_header',
							'type'     => 'select',
							'choices'  => array(
								'default-header' => esc_html__( 'Default Header', 'atreves' ),
								'elementor-header' => esc_html__( 'Elementor Header', 'atreves' ),
							),
							'default' => 'default-header',
							'transport'	=> 'refresh'
						),
						array(
							'name' => esc_html__( 'Header Elementor Templates', 'atreves' ),
							'id' => 'choose_elementor_header',
							'type'     => 'select',
							'choices'  => $atreves_elementor_header_templates,
							'transport'	=> 'refresh',
							'required' => ['header_source_type',
							'=',
							'e'],
						),
						array(
							'name' => esc_html__( 'Header Logo', 'atreves' ),
							'id' => 'logo',
							'default' => get_template_directory_uri() . '/assets/img/logo/logo.png',
							'type' => 'image',
							'transport'	=> 'refresh' 
						),
						array(
							'name' => esc_html__( 'Header Black Logo', 'atreves' ),
							'id' => 'seconday_logo',
							'default' => get_template_directory_uri() . '/assets/img/logo/logo-black.png',
							'type' => 'image',
							'transport'	=> 'refresh' 
						),
						array(
							'name' => esc_html__( 'Header Retina Logo', 'atreves' ),
							'id' => 'retina_logo',
							'default' => get_template_directory_uri() . '/assets/img/logo/logo@2x.png',
							'type' => 'image',
							'transport'	=> 'refresh' 
						),
						array(
							'name' => esc_html__( 'Header Retina Black Logo', 'atreves' ),
							'id' => 'retina_secondary_logo',
							'default' => get_template_directory_uri() . '/assets/img/logo/logo-black@2x.png',
							'type' => 'image',
							'transport'	=> 'refresh' 
						),
						array(
							'name' => esc_html__( 'Show Header Search', 'atreves' ),
							'id' => 'atreves_header_search_show',
							'default' => 1,
							'type' => 'switch',
							'transport'	=> 'refresh' 
						),	
					) 
				),	
				'banner_main_setting' => array(
					'name' => esc_html__( 'Sub Banner Setting', 'atreves' ),
					'priority' => 20,
					'fields' => array(
						
						array(
							'name' => esc_html__( 'Banner Image', 'atreves' ),
							'id' => 'sub-banner-img',
							'default' => get_template_directory_uri() . '/assets/img/sub-banner-img.jpg',
							'type' => 'image',
							'transport'	=> 'refresh' 
						),
						
					) 
				),	
				'page_title_setting'=> array(
					'name'=> esc_html__('Page Title Setting','atreves'),
					'priority'=> 30,
					'fields'=> array(
						array(
							'name' => esc_html__( 'Choose Breadcrumb Style', 'atreves' ),
							'id' => 'choose_default_breadcrumb',
							'type'     => 'select',
							'choices'  => array(
								'breadcrumb-style-1' => esc_html__( 'Breadcrumb Style 1', 'atreves' ),
								'breadcrumb-style-2' => esc_html__( 'default', 'atreves' ),
							),
							'default' => 'breadcrumb-style-1',
							'transport'	=> 'refresh'
						),
						array(
							'name'=>esc_html__('Breadcrumb BG Color','atreves'),
							'id'=>'breadcrumb_bg_color',
							'default'=> esc_html__('#343a40','atreves'),
							'transport'	=> 'refresh'  
						),
						array(
							'name' => esc_html__( 'Page Title Background Image', 'atreves' ),
							'id' => 'breadcrumb_bg_img',
							'default' => '',
							'type' => 'image',
							'transport'	=> 'refresh' 
						),	
						array(
							'name' => esc_html__( 'Breadcrumb Archive', 'atreves' ),
							'id' => 'breadcrumb_archive',
							'default' => esc_html__('Archive for category','atreves'),
							'type' => 'text',
							'transport'	=> 'refresh' 
						),	
						array(
							'name' => esc_html__( 'Breadcrumb Search', 'atreves' ),
							'id' => 'breadcrumb_search',
							'default' => esc_html__('Search results for','atreves'),
							'type' => 'text',
							'transport'	=> 'refresh' 
						),	
						array(
							'name' => esc_html__( 'Breadcrumb tagged', 'atreves' ),
							'id' => 'breadcrumb_post_tags',
							'default' => esc_html__('Posts tagged','atreves'),
							'type' => 'text',
							'transport'	=> 'refresh' 
						),		
						array(
							'name' => esc_html__( 'Breadcrumb posted by', 'atreves' ),
							'id' => 'breadcrumb_artitle_post_by',
							'default' => esc_html__('Articles posted by','atreves'),
							'type' => 'text',
							'transport'	=> 'refresh' 
						),		
						array(
							'name' => esc_html__( 'Breadcrumb Page Not Found', 'atreves' ),
							'id' => 'breadcrumb_404',
							'default' => esc_html__('Page Not Found','atreves'),
							'type' => 'text',
							'transport'	=> 'refresh' 
						),		
						array(
							'name' => esc_html__( 'Breadcrumb Page', 'atreves' ),
							'id' => 'breadcrumb_page',
							'default' => esc_html__('Page','atreves'),
							'type' => 'text',
							'transport'	=> 'refresh' 
						),			
						array(
							'name' => esc_html__( 'Breadcrumb Shop', 'atreves' ),
							'id' => 'breadcrumb_shop',
							'default' => esc_html__('Shop','atreves'),
							'type' => 'text',
							'transport'	=> 'refresh' 
						),			
						array(
							'name' => esc_html__( 'Breadcrumb Home', 'atreves' ),
							'id' => 'breadcrumb_home',
							'default' => esc_html__('Home','atreves'),
							'type' => 'text',
							'transport'	=> 'refresh' 
						),					
					)
				),
				'blog_setting'=> array(
					'name'=> esc_html__('Blog Setting','atreves'),
					'priority'=> 40,
					'fields'=> array(
						array(
							'name' => esc_html__( 'Show Blog BTN', 'atreves' ),
							'id' => 'atreves_blog_btn_switch',
							'default' => 1,
							'type' => 'switch',
							'transport'	=> 'refresh' 
						),	
						array(
							'name' => esc_html__( 'Show Blog Btn Icon', 'atreves' ),
							'id' => 'atreves_blog_btn_icon_switch',
							'default' => 1,
							'type' => 'switch',
							'transport'	=> 'refresh' 
						),
						array(
							'name' => esc_html__( 'Blog Button text', 'atreves' ),
							'id' => 'atreves_blog_btn',
							'default' => esc_html__('Read More','atreves'),
							'type' => 'text',
							'transport'	=> 'refresh' 
						),							
						array(
							'name' => esc_html__( 'Blog Button Icon', 'atreves' ),
							'id' => 'atreves_blog_btn_icon',
							'default' => esc_html__('fas fa-angle-double-right','atreves'),
							'type' => 'text',
							'transport'	=> 'refresh' 
						),						
						array(
							'name' => esc_html__( 'Blog Title', 'atreves' ),
							'id' => 'breadcrumb_blog_title',
							'default' => esc_html__('Blog','atreves'),
							'type' => 'text',
							'transport'	=> 'refresh' 
						),						
						array(
							'name' => esc_html__( 'Blog Details Title', 'atreves' ),
							'id' => 'breadcrumb_blog_title_details',
							'default' => esc_html__('Blog Details','atreves'),
							'type' => 'text',
							'transport'	=> 'refresh' 
						),

					)
				),
				'atreves_footer_setting' => array(
					'name'=> esc_html__('Footer Setting','atreves'),
					'priority'=> 60,
					'fields'=> array(
						array(
							'name' => esc_html__( 'Footer Elementor Templates', 'atreves' ),
							'id' => 'choose_elementor_footer',
							'type'     => 'select',
							'choices'  => $atreves_elementor_template_list,
							'transport'	=> 'refresh',
							'required' => ['footer_source_type',
							'=',
							'e'],
						),
						array(
							'name' => esc_html__( 'Choose Footer Style', 'atreves' ),
							'id' => 'choose_default_footer',
							'type'     => 'select',
							'choices'  => array(
								'footer-style-1' => esc_html__( 'Footer Style 1', 'atreves' ),
								'footer-style-2' => esc_html__( 'Footer Style 2', 'atreves' ),
								'footer-style-3' => esc_html__( 'Footer Style 3', 'atreves' ),
							),
							'default' => 'footer-style-1',
							'transport'	=> 'refresh'
						),
						array(
							'name' => esc_html__( 'Footer Background Image', 'atreves' ),
							'id' => 'atreves_footer_bg',
							'default' => '',
							'type' => 'image',
							'transport'	=> 'refresh' 
						),
						array(
							'name'=>esc_html__('Footer BG Color','atreves'),
							'id'=>'atreves_footer_bg_color',
							'default'=> esc_html__('#f4f9fc','atreves'),
							'transport'	=> 'refresh'  
						),
						array(
							'name'=>esc_html__('Copy Right','atreves'),
							'id'=>'atreves_copyright',
							'default'=> esc_html__('Copyright &copy; Atreves 2023. All rights reserved','atreves'),
							'type'=>'text',
							'transport'	=> 'refresh'  
						),	
						array(
							'name'=>esc_html__('Enable Scrollup','atreves'),
							'id'=>'atreves_scrollup_switch',
							'default'=> false,
							'type'=>'switch',
							'transport'	=> 'refresh'  
						),						
						array(
							'name'=>esc_html__('Enable Footer Widgets','atreves'),
							'id'=>'atreves_enable_footer_widgets',
							'default'=> true,
							'type'=>'switch',
							'transport'	=> 'refresh'  
						),	
						array(
							'name'=>esc_html__('Enable Preloader','atreves'),
							'id'=>'atreves_preloader_switch',
							'default'=> false,
							'type'=>'switch',
							'transport'	=> 'refresh'  
						)
					)
				),
				'error_page_setting'=> array(
					'name'=> esc_html__('404 Setting','atreves'),
					'priority'=> 90,
					'fields'=> array(
						array(
							'name'=>esc_html__('400 Text','atreves'),
							'id'=>'atreves_error_404_text',
							'default'=> esc_html__('404','atreves'),
							'type'=>'text',
							'transport'	=> 'refresh'  
						),
						array(
							'name'=>esc_html__('Not Found Title','atreves'),
							'id'=>'atreves_error_title',
							'default'=> esc_html__('Page not found','atreves'),
							'type'=>'text',
							'transport'	=> 'refresh'  
						),
						array(
							'name'=>esc_html__('404 Description Text','atreves'),
							'id'=>'atreves_error_desc',
							'default'=> esc_html__('Oops! The page you are looking for does not exist. It might have been moved or deleted','atreves'),
							'type'=>'textarea',
							'transport'	=> 'refresh'  
						),
						array(
							'name'=>esc_html__('404 Link Text','atreves'),
							'id'=>'atreves_error_link_text',
							'default'=> esc_html__('Back To Home','atreves'),
							'type'=>'text',
							'transport'	=> 'refresh'  
						)
						
					)
				),
			),
		)
	);

}

add_filter('atreves_customizer_data', 'atreves_customizer');


