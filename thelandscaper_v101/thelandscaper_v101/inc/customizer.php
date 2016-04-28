<?php
/**
*
* Contains methods for customizing the theme customization screen.
* 
* @package The Landscaper
* @link http://codex.wordpress.org/Theme_Customization_API
*/
class TheLandscaper_Customizer {

	/**
	 * Holds the instance of this class.
	 *
	 * @access private
	 * @var    object
	 */
	private static $instance;

	public function __construct() {
		// Enqueue live preview javascript in Theme Customizer admin screen
		add_action( 'customize_preview_init', array( $this, 'thelandscaper_live_preview' ) );

		// Add options to the theme customizer.
		add_action( 'customize_register', array( $this, 'thelandscaper_customize_register' ) );

		// Output Customizer CSS & Custom CSS to WP Head
		add_action( 'wp_head', array( $this, 'thelandscaper_head_callback' ) );

		// Delete the cached data for this feature.
		add_action( 'customize_save_after' . get_stylesheet(), array( $this, 'thelandscaper_cache_delete' ) );

		// Flush the rewrite rules after saving the customizer
		add_action( 'customize_save_after', 'flush_rewrite_rules' );
	}

	/**
	* This hooks into 'customize_register' (available as of WP 3.4) and allows
	* you to add new sections and controls to the Theme Customize screen.
	* 
	* Note: To enable instant preview, we have to actually write a bit of custom
	* javascript. See live_preview() for more.
	*  
	* @see add_action('customize_register',$func)
	*/
	public function thelandscaper_customize_register( $wp_customize ) {

		// Add Custom Panel to Live Customizer for Theme Options
		$wp_customize->add_panel( 'qt_theme_panel', 
			array(
				'title'       	=> esc_html__( 'Theme Options', 'the-landscaper-wp' ),
				'description' 	=> esc_html__( 'All the Theme Options', 'the-landscaper-wp' ),
				'priority'    	=> 10,
			)
		);

		// Add Custom Sections to the Theme Panel
		$wp_customize->add_section( 'qt_section_logo',
			array(
				'title'       	=> esc_html__( 'Logo', 'the-landscaper-wp' ),
				'description' 	=> esc_html__( 'Logo settings.', 'the-landscaper-wp' ),
				'priority'    	=> 10,
				'panel'       	=> 'qt_theme_panel',
			)
		);
		$wp_customize->add_section( 'qt_section_header', 
			array(
				'title' 	  	=> esc_html__( 'Header', 'the-landscaper-wp' ),
				'description' 	=> esc_html__( 'All the Header settings', 'the-landscaper-wp' ),
				'priority'    	=> 15,
				'panel'       	=> 'qt_theme_panel',
			)
		);
	    $wp_customize->add_section( 'qt_section_navigation',
			array(
				'title' 	  	=> esc_html__( 'Navigation', 'the-landscaper-wp' ),
				'description' 	=> esc_html__( 'All the Navigation settings', 'the-landscaper-wp' ),
				'priority' 	  	=> 20,
				'panel'       	=> 'qt_theme_panel',
			)
		);
	    $wp_customize->add_section( 'qt_section_main_title',
			array(
				'title' 	  	=> esc_html__( 'Main Title Area', 'the-landscaper-wp' ),
				'priority' 	  	=> 25,
				'panel'       	=> 'qt_theme_panel',
			)
		);
	    $wp_customize->add_section( 'qt_section_breadcrumbs', 
			array(
				'title'		  	=> esc_html__( 'Breadcrumbs', 'the-landscaper-wp' ),
				'description' 	=> esc_html__( 'All the Breadcrumbs settings', 'the-landscaper-wp' ),
				'priority' 	  	=> 30,
				'panel'       	=> 'qt_theme_panel',
			)
		);
		$wp_customize->add_section( 'qt_section_theme_colors',
			array(
				'title'		  	=> esc_html__( 'Layout &amp; Colors', 'the-landscaper-wp' ),
				'description' 	=> esc_html__( 'Theme Layout and Color Settings', 'the-landscaper-wp' ),
				'priority' 	  	=> 35,
				'panel'       	=> 'qt_theme_panel',
			)
		);
		$wp_customize->add_section( 'qt_section_blog',
			array(
				'title'		  	=> esc_html__( 'Blog', 'the-landscaper-wp' ),
				'description' 	=> esc_html__( 'Blog Post Settings', 'the-landscaper-wp' ),
				'priority' 	  	=> 40,
				'panel'       	=> 'qt_theme_panel',
			)
		);
	    $wp_customize->add_section( 'qt_section_gallery',
			array(
				'title'		  	=> esc_html__( 'Gallery', 'the-landscaper-wp' ),
				'description' 	=> esc_html__( 'Gallery Detail Pages Settings', 'the-landscaper-wp' ),
				'priority' 	  	=> 45,
				'panel'       	=> 'qt_theme_panel',
			)
	    );
	    if( thelandscaper_woocommerce_active() ) {
	        $wp_customize->add_section( 'qt_section_shop',
	        	array(
		            'title'		  	=> esc_html__( 'Shop', 'the-landscaper-wp' ),
		            'description' 	=> esc_html__( 'WooCommerce Shop Settings', 'the-landscaper-wp' ),
		            'priority' 	  	=> 50,
		            'panel'       	=> 'qt_theme_panel',
	        	)
	        );
		}
	    $wp_customize->add_section( 'qt_section_footer',
			array(
				'title'		  	=> esc_html__( 'Footer', 'the-landscaper-wp' ),
				'description' 	=> esc_html__( 'Theme Footer Settings', 'the-landscaper-wp' ),
				'priority' 	  	=> 55,
				'panel'       	=> 'qt_theme_panel',
			)
		);
	    $wp_customize->add_section( 'qt_section_custom',
	    	array(
	            'title'		  	=> esc_html__( 'Custom CSS', 'the-landscaper-wp' ),
	            'description'	=> esc_html__( 'It is recommended to type custom CSS in a text editor and then paste it into the field below', 'the-landscaper-wp' ),
	            'priority' 	  	=> 60,
	            'panel'       	=> 'qt_theme_panel',
	    	)
	    );
	    $wp_customize->add_section( 'qt_section_auto_updates',
	    	array(
	            'title'		  	=> esc_html__( 'Automatic Updates', 'the-landscaper-wp' ),
	            'description'	=> esc_html__( 'You can update the theme with a single click if you fill in these two fields below. You will get notified if there is a new version of the theme. Please be aware that all the changes you make in the code directly will be overwritten. Please make use of the child theme if you need the make customizations.', 'the-landscaper-wp' ),
	            'priority' 	  	=> 65,
	            'panel'       	=> 'qt_theme_panel',
	    	)
	    );
	    

		// Section Settings: Logo
		$wp_customize->add_setting( 'qt_logo' ,
			array( 
				'default' 			=> get_template_directory_uri().'/assets/images/logo.png',
				'transport'			=> 'refresh',
				'type'				=> 'theme_mod',
				'capability'		=> 'edit_theme_options',
				'sanitize_callback' => 'esc_url_raw',
			)
		);
		$wp_customize->add_control( new WP_Customize_Image_Control( 
			$wp_customize, 'qt_logo',
				array(
		            'label' 	 	=> esc_html__('Theme Logo', 'the-landscaper-wp'),
		            'description' 	=> esc_html__( 'Recommended height is not higher than 90 pixels', 'the-landscaper-wp' ),
		            'section' 	 	=> 'qt_section_logo',
		            'settings' 	 	=> 'qt_logo',
					'priority'   	=> 5,
				)
			)
		);

		$wp_customize->add_setting( 'qt_logo_retina', 
			array( 
				'default' 			=> get_template_directory_uri().'/assets/images/logo_2x.png',
				'transport'			=> 'refresh',
				'type'				=> 'theme_mod',
				'capability'		=> 'edit_theme_options',
				'sanitize_callback' => 'esc_url_raw',
			)
		);
		$wp_customize->add_control( new WP_Customize_Image_Control(
			$wp_customize, 'qt_logo_retina',
				array(
	            	'label' 	 	=> esc_html__('Theme Logo Retina (2x)', 'the-landscaper-wp' ),
		            'description' 	=> esc_html__( 'The logo size 2x, for screens with high DPI.', 'the-landscaper-wp' ),
		            'section' 	 	=> 'qt_section_logo',
		            'settings' 	 	=> 'qt_logo_retina',
					'priority'   	=> 10,
				) 
			)
		);

		$wp_customize->add_setting( 'qt_logo_margin_top', 
				array(
			    	'd1efault' 			=> '0',
			    	'transport'			=> 'refresh',
			    	'type'				=> 'theme_mod',
			    	'capability'		=> 'edit_theme_options',
			    	'sanitize_callback' => 'thelandscaper_sanitize_text',
				)
			);
			$wp_customize->add_control( 'qt_logo_margin_top', 
				array(
				    'label' 			=> esc_html__( 'Top Margin Logo', 'the-landscaper-wp'),
				    'description' 		=> esc_html__( 'In pixels', 'the-landscaper-wp' ),
			    	'type'		        => 'number',
				    'section' 			=> 'qt_section_logo',
				    'settings' 			=> 'qt_logo_margin_top',
				    'priority' 			=> 15,
				    'input_attrs' 		=> array(
						'min' 		=> 0,
						'max'  		=> 100,
						'step' 		=> 5,
					),
				)
			);


		// Section Settings: Header
		$wp_customize->add_setting( 'qt_topbar',
			array(
	        	'default'  			=> 'show',
	        	'transport'			=> 'refresh',
	        	'type'				=> 'theme_mod',
	        	'capability'		=> 'edit_theme_options',
	        	'sanitize_callback' => 'thelandscaper_sanitize_select',
	    	)
		);
		$wp_customize->add_control( 'qt_topbar',
			array(
				'label'    			=> esc_html__( 'Show or hide the topbar', 'the-landscaper-wp' ),
				'section'  			=> 'qt_section_header',
				'settings' 			=> 'qt_topbar',
				'type'     			=> 'select',
				'choices'  			=> array(
					'show'  		=> esc_html__( 'Show', 'the-landscaper-wp' ),
					'hide' 			=> esc_html__( 'Hide', 'the-landscaper-wp' ),
				),
				'priority' 			=> 5,
			)
		);

		$wp_customize->add_setting( 'qt_topbar_bg',
			array( 
				'default' 			=> '#3a3a3a',
			    'transport'			=> 'postMessage',
			    'type'				=> 'theme_mod',
			    'capability'		=> 'edit_theme_options',
				'sanitize_callback' => 'sanitize_hex_color',
			)
		);
		$wp_customize->add_control( new WP_Customize_Color_Control( 
			$wp_customize, 'qt_topbar_bg',
				array(
					'label'       	=> esc_html__( 'Topbar Background Color', 'the-landscaper-wp' ),
					'section'     	=> 'qt_section_header',
					'settings'    	=> 'qt_topbar_bg',
					'priority'    	=> 10,
				)
			)
		);

		$wp_customize->add_setting( 'qt_topbar_textcolor',
			array(
			    'default'     		=> '#7d7d7d',
		        'transport'			=> 'postMessage',
		        'type'				=> 'theme_mod',
		        'capability'		=> 'edit_theme_options',
			    'sanitize_callback' => 'sanitize_hex_color'
			)
		);
		$wp_customize->add_control( new WP_Customize_Color_Control( 
			$wp_customize, 'qt_topbar_textcolor', 
				array(
					'label'       	=> esc_html__( 'Topbar Text Color', 'the-landscaper-wp' ),
					'section'     	=> 'qt_section_header',
					'settings'    	=> 'qt_topbar_textcolor',
					'priority'    	=> 20,
				)
			)
		);


		// Section Settings: Navigation
		$wp_customize->add_setting( 'qt_nav_position',
			array(
	        	'default'  			=> 'static',
	        	'transport'			=> 'refresh',
	        	'type'				=> 'theme_mod',
	        	'capability'		=> 'edit_theme_options',
	        	'sanitize_callback' => 'thelandscaper_sanitize_select',
	    	)
		);
		$wp_customize->add_control( 'qt_nav_position', 
			array(
				'label'    			=> esc_html__( 'Sticky or Static Navigation', 'the-landscaper-wp' ),
				'section'  			=> 'qt_section_navigation',
				'settings' 			=> 'qt_nav_position',
				'type'     			=> 'select',
				'choices'  			=> array(
					'static'  		=> esc_html__( 'Static', 'the-landscaper-wp' ),
					'sticky' 		=> esc_html__( 'Sticky', 'the-landscaper-wp' ),
				),
				'priority' 			=> 5,
			)
		);

		$wp_customize->add_setting( 'qt_nav_layout',
			array(
	        	'default'  			=> 'default',
	        	'transport'			=> 'refresh',
	        	'type'				=> 'theme_mod',
	        	'capability'		=> 'edit_theme_options',
	        	'sanitize_callback' => 'thelandscaper_sanitize_select',
	    	)
		);
		$wp_customize->add_control( 'qt_nav_layout',
			array(
				'label'    			=> esc_html__( 'Default or Wide Navigation', 'the-landscaper-wp' ),
				'section'  			=> 'qt_section_navigation',
				'settings' 			=> 'qt_nav_layout',
				'type'     			=> 'select',
				'choices'  			=> array(
					'default'  		=> esc_html__( 'Default', 'the-landscaper-wp'),
					'wide' 			=> esc_html__( 'Wide', 'the-landscaper-wp'),
				),
				'priority' 			=> 10,
			)
		);

		$wp_customize->add_setting( 'qt_nav_bg',
			array(
				'default' 			=> '#a2c046',
				'transport'			=> 'postMessage',
				'type'				=> 'theme_mod',
				'capability'		=> 'edit_theme_options',
			    'sanitize_callback' => 'sanitize_hex_color',
			)
		);
		$wp_customize->add_control( new WP_Customize_Color_Control( 
			$wp_customize, 'qt_nav_bg', 
				array(
					'label'         => esc_html__( 'Navigation Background Color', 'the-landscaper-wp' ),
					'section'     	=> 'qt_section_navigation',
					'settings'    	=> 'qt_nav_bg',
					'priority'    	=> 15,
				)
			)
		);
		$wp_customize->add_setting( 'qt_nav_mobile_bg',
			array(
				'default' 			=> '#a2c046',
				'transport'			=> 'postMessage',
				'type'				=> 'theme_mod',
				'capability'		=> 'edit_theme_options',
			    'sanitize_callback' => 'sanitize_hex_color',
			)
		);
		$wp_customize->add_control( new WP_Customize_Color_Control( 
			$wp_customize, 'qt_nav_mobile_bg', 
				array(
					'label'         => esc_html__( 'Mobile Navigation Background Color', 'the-landscaper-wp' ),
					'section'     	=> 'qt_section_navigation',
					'settings'    	=> 'qt_nav_mobile_bg',
					'priority'    	=> 20,
				)
			)
		);

		$wp_customize->add_setting( 'qt_nav_textcolor',
			array(
			    'default'    		=> '#ffffff',
			    'transport'			=> 'postMessage',
			    'type'				=> 'theme_mod',
			    'capability'		=> 'edit_theme_options',
			    'sanitize_callback' => 'sanitize_hex_color',
			)
		);
		$wp_customize->add_control( new WP_Customize_Color_Control( 
			$wp_customize, 'qt_nav_textcolor',
				array(
					'label'      	=> esc_html__( 'Navigation Text Color', 'the-landscaper-wp' ),
					'section'     	=> 'qt_section_navigation',
					'settings'    	=> 'qt_nav_textcolor',
					'priority'    	=> 25,
				)
			)
		);
		$wp_customize->add_setting( 'qt_nav_mobile_textcolor',
			array(
			    'default'    		=> '#ffffff',
			    'transport'			=> 'postMessage',
			    'type'				=> 'theme_mod',
			    'capability'		=> 'edit_theme_options',
			    'sanitize_callback' => 'sanitize_hex_color',
			)
		);
		$wp_customize->add_control( new WP_Customize_Color_Control( 
			$wp_customize, 'qt_nav_mobile_textcolor',
				array(
					'label'      	=> esc_html__( 'Mobile Navigation Text Color', 'the-landscaper-wp' ),
					'section'     	=> 'qt_section_navigation',
					'settings'    	=> 'qt_nav_mobile_textcolor',
					'priority'    	=> 30,
				)
			)
		);

		$wp_customize->add_setting( 'qt_nav_submenu_bg', 
			array(
				'default' 			=> '#434343',
				'transport'			=> 'postMessage',
				'type'				=> 'theme_mod',
				'capability'		=> 'edit_theme_options',
		    	'sanitize_callback' => 'sanitize_hex_color',
			)
		);
		$wp_customize->add_control( new WP_Customize_Color_Control( 
			$wp_customize, 'qt_nav_submenu_bg', 
				array(
					'label'       	=> esc_html__( 'Sub Menu Background Color', 'the-landscaper-wp' ),
					'section'     	=> 'qt_section_navigation',
					'settings'    	=> 'qt_nav_submenu_bg',
					'priority'    	=> 35,
				)
			)
		);
		$wp_customize->add_setting( 'qt_nav_mobile_submenu_bg',
			array(
			    'default'    		=> '#9ab643',
			    'transport'			=> 'postMessage',
			    'type'				=> 'theme_mod',
			    'capability'		=> 'edit_theme_options',
			    'sanitize_callback' => 'sanitize_hex_color',
			)
		);
		$wp_customize->add_control( new WP_Customize_Color_Control( 
			$wp_customize, 'qt_nav_mobile_submenu_bg',
				array(
					'label'      	=> esc_html__( 'Mobile Submnu BG Color', 'the-landscaper-wp' ),
					'section'     	=> 'qt_section_navigation',
					'settings'    	=> 'qt_nav_mobile_submenu_bg',
					'priority'    	=> 40,
				)
			)
		);

		$wp_customize->add_setting( 'qt_nav_submenu_textcolor',
			array(
		    	'default'     		=> '#999999',
		    	'transport'			=> 'postMessage',
		    	'type'				=> 'theme_mod',
		    	'capability'		=> 'edit_theme_options',
		    	'sanitize_callback' => 'sanitize_hex_color',
			)
		);
		$wp_customize->add_control( new WP_Customize_Color_Control( 
			$wp_customize, 'qt_nav_submenu_textcolor',
				array(
					'label'       	=> esc_html__( 'Sub Menu Text Color', 'the-landscaper-wp' ),
					'section'     	=> 'qt_section_navigation',
					'settings'    	=> 'qt_nav_submenu_textcolor',
					'priority'    	=> 45,
				)
			)
		);
		$wp_customize->add_setting( 'qt_nav_mobile_submenu_textcolor',
			array(
			    'default'    		=> '#ffffff',
			    'transport'			=> 'postMessage',
			    'type'				=> 'theme_mod',
			    'capability'		=> 'edit_theme_options',
			    'sanitize_callback' => 'thelandscaper_sanitize_text',
			)
		);
		$wp_customize->add_control( new WP_Customize_Color_Control( 
			$wp_customize, 'qt_nav_mobile_submenu_textcolor',
				array(
					'label'      	=> esc_html__( 'Mobile Submenu Text Color', 'the-landscaper-wp' ),
					'section'     	=> 'qt_section_navigation',
					'settings'    	=> 'qt_nav_mobile_submenu_textcolor',
					'priority'    	=> 50,
				)
			)
		);


		// Section Settings: Main Title Area
		$wp_customize->add_setting( 'qt_maintitle_color',
			array(
		    	'default'     		=> '#333333',
		    	'transport'			=> 'postMessage',
		    	'type'				=> 'theme_mod',
		    	'capability'		=> 'edit_theme_options',
		    	'sanitize_callback' => 'sanitize_hex_color',
			)
		);
		$wp_customize->add_control( new WP_Customize_Color_Control( 
			$wp_customize, 'qt_maintitle_color',
				array(
					'label'      	=> esc_html__( 'Page title Text Color', 'the-landscaper-wp' ),
					'section'    	=> 'qt_section_main_title',
					'settings'   	=> 'qt_maintitle_color',
					'priority'   	=> 5,
				)
			)
		);

		$wp_customize->add_setting( 'qt_subtitle_color',
			array(
		    	'default'     		=> '#999999',
		    	'transport'			=> 'postMessage',
		    	'type'				=> 'theme_mod',
		    	'capability'		=> 'edit_theme_options',
		    	'sanitize_callback' => 'sanitize_hex_color',
			)
		);
		$wp_customize->add_control( new WP_Customize_Color_Control( 
			$wp_customize, 'qt_subtitle_color',
				array(
					'label'      	=> esc_html__( 'Sub Page title Text Color', 'the-landscaper-wp' ),
					'section'    	=> 'qt_section_main_title',
					'settings'   	=> 'qt_subtitle_color',
					'priority'   	=> 10,
				)
			)
		);

		$wp_customize->add_setting( 'qt_maintitle_align', 
			array(
	        	'default'  			=> 'left',
	        	'transport'			=> 'refresh',
	        	'type'				=> 'theme_mod',
	        	'capability'		=> 'edit_theme_options',
	        	'sanitize_callback' => 'thelandscaper_sanitize_select',
	    	)
		);
		$wp_customize->add_control( 'qt_maintitle_align', 
			array(
				'label'    			=> esc_html__( 'Align Title & Subtitle', 'the-landscaper-wp' ),
				'section'  			=> 'qt_section_main_title',
				'settings' 			=> 'qt_maintitle_align',
				'type'    			=> 'select',
				'choices'  			=> array(
					'left'  		=> esc_html__( 'Left', 'the-landscaper-wp'),
					'center' 		=> esc_html__( 'Center', 'the-landscaper-wp'),
					'right' 	    => esc_html__( 'Right', 'the-landscaper-wp'),
				),
				'priority' 			=> 15,
			)
		);

		$wp_customize->add_setting( 'qt_maintitle_bgcolor',
			array(
		    	'default'     		=> '#f2f2f2',
		    	'transport'			=> 'postMessage',
		    	'type'				=> 'theme_mod',
		    	'capability'		=> 'edit_theme_options',
		    	'sanitize_callback' => 'sanitize_hex_color',
			)
		);
		$wp_customize->add_control( new WP_Customize_Color_Control( 
			$wp_customize, 'qt_maintitle_bgcolor',
				array(
					'label'      	=> esc_html__( 'Main Title Background Color', 'the-landscaper-wp' ),
					'section'    	=> 'qt_section_main_title',
					'settings'   	=> 'qt_maintitle_bgcolor',
					'priority'   	=> 20,
				)
			)
		);

		$wp_customize->add_setting( 'qt_maintitle_layout',
			array(
	        	'default'  			=> 'small',
	        	'transport'			=> 'refresh',
	        	'type'				=> 'theme_mod',
	        	'capability'		=> 'edit_theme_options',
	        	'sanitize_callback' => 'thelandscaper_sanitize_select',
	    	)
		);
		$wp_customize->add_control( 'qt_maintitle_layout', 
			array(
				'label'    			=> esc_html__( 'Main Title Height', 'the-landscaper-wp' ),
				'section'  			=> 'qt_section_main_title',
				'settings' 			=> 'qt_maintitle_layout',
				'type'    			=> 'select',
				'choices'  			=> array(
					'small'  		=> esc_html__( 'Small', 'the-landscaper-wp'),
					'large' 		=> esc_html__( 'Large', 'the-landscaper-wp'),
				),
				'priority' 			=> 25,
			)
		);

		$wp_customize->add_setting( 'qt_maintitle_bgimage',
			array(
				'default' 	 		=> get_template_directory_uri().'/assets/images/texture_1.png',
				'transport'			=> 'refresh',
				'type'				=> 'theme_mod',
				'capability'		=> 'edit_theme_options',
				'sanitize_callback' => 'esc_url_raw',
			)
		);
		$wp_customize->add_control( new WP_Customize_Image_Control( 
			$wp_customize, 'qt_maintitle_bgimage', 
				array(
		            'label' 	 	=> esc_html__('Background Pattern', 'the-landscaper-wp' ),
		            'section' 	 	=> 'qt_section_main_title',
		            'settings' 	 	=> 'qt_maintitle_bgimage',
					'priority'   	=> 30,
				)
			)
		);


		// Section Settings: Breadcrumbs
		$wp_customize->add_setting( 'qt_breadcrumbs_textcolor', 
			array(
			    'default'    		=> '#999999',
			    'transport'	  		=> 'postMessage',
			    'type'				=> 'theme_mod',
			    'capability'		=> 'edit_theme_options',
			    'sanitize_callback' => 'sanitize_hex_color',
			)
		);
		$wp_customize->add_control( new WP_Customize_Color_Control( 
			$wp_customize, 'qt_breadcrumbs_textcolor', 
				array(
					'label'      	=> esc_html__( 'Breadcrumbs Text Color', 'the-landscaper-wp' ),
					'section'    	=> 'qt_section_breadcrumbs',
					'settings'   	=> 'qt_breadcrumbs_textcolor',
					'priority'   	=> 5,
				)
			)
		);

		$wp_customize->add_setting( 'qt_breadcrumbs_activecolor', 
			array(
			    'default'    		=> '#a2c046',
			    'transport'	  		=> 'postMessage',
			    'type'				=> 'theme_mod',
			    'capability'		=> 'edit_theme_options',
			    'sanitize_callback' => 'sanitize_hex_color',
			)
		);
		$wp_customize->add_control( new WP_Customize_Color_Control( 
			$wp_customize, 'qt_breadcrumbs_activecolor',
				array(
					'label'      	=> esc_html__( 'Breadcrumbs Active Color', 'the-landscaper-wp' ),
					'section'    	=> 'qt_section_breadcrumbs',
					'settings'   	=> 'qt_breadcrumbs_activecolor',
					'priority'   	=> 10,
				)
			)
		);

		$wp_customize->add_setting( 'qt_breadcrumbs_align', 
			array(
	        	'default'  			=> 'left',
	        	'transport'			=> 'refresh',
	        	'type'				=> 'theme_mod',
	        	'capability'		=> 'edit_theme_options',
	        	'sanitize_callback' => 'thelandscaper_sanitize_select',
	    	)
		);
		$wp_customize->add_control( 'qt_breadcrumbs_align', 
			array(
				'label'    			=> esc_html__( 'Align Text', 'the-landscaper-wp' ),
				'section'  			=> 'qt_section_breadcrumbs',
				'settings' 			=> 'qt_breadcrumbs_align',
				'type'    			=> 'select',
				'choices'  			=> array(
					'left'  		=> esc_html__( 'Left', 'the-landscaper-wp' ),
					'center' 		=> esc_html__( 'Center', 'the-landscaper-wp' ),
					'right' 	    => esc_html__( 'Right', 'the-landscaper-wp' ),
				),
				'priority' 			=> 15,
			)
		);
		$wp_customize->add_setting( 'qt_breadcrumbs', 
			array(
	        	'default'  			=> 'show',
	        	'transport'			=> 'refresh',
	        	'type'				=> 'theme_mod',
	        	'capability'		=> 'edit_theme_options',
	        	'sanitize_callback' => 'thelandscaper_sanitize_select',
	    	)
		);
		$wp_customize->add_control( 'qt_breadcrumbs', 
			array(
				'label'    			=> esc_html__( 'Show or Hide the Breadcrumbs', 'the-landscaper-wp' ),
				'section'  			=> 'qt_section_breadcrumbs',
				'settings' 			=> 'qt_breadcrumbs',
				'type'    			=> 'select',
				'choices'  			=> array(
					'show'  		=> esc_html__( 'Show', 'the-landscaper-wp' ),
					'hide' 			=> esc_html__( 'Hide', 'the-landscaper-wp' ),
				),
				'priority' 			=> 20,
			)
		);


		// Section Settings: Theme Layout & Colors
		$wp_customize->add_setting( 'qt_theme_layout', 
			array(
	        	'default'  			=> 'wide',
	        	'transport'			=> 'refresh',
	        	'type'				=> 'theme_mod',
	        	'capability'		=> 'edit_theme_options',
	        	'sanitize_callback' => 'thelandscaper_sanitize_select',
	    	)
		);
		$wp_customize->add_control( 'qt_theme_layout', 
			array(
				'label'    			=> esc_html__( 'Layout', 'the-landscaper-wp' ),
				'section'  			=> 'qt_section_theme_colors',
				'settings' 			=> 'qt_theme_layout',
				'type'    			=> 'select',
				'choices'  			=> array(
					'wide'  		=> esc_html__( 'Wide', 'the-landscaper-wp' ),
					'boxed' 		=> esc_html__( 'Boxed', 'the-landscaper-wp' ),
				),
				'priority' 			=> 5,
			)
		);

		$wp_customize->add_setting( 'qt_boxed_bg', 
			array(
				'default' 			=> '#ffffff',
				'transport'			=> 'refresh',
				'type'				=> 'theme_mod',
				'capability'		=> 'edit_theme_options',
				'sanitize_callback' => 'sanitize_hex_color',
			)
		);
		$wp_customize->add_control( new WP_Customize_Color_Control( 
			$wp_customize, 'qt_boxed_bg', 
				array(
					'label'       	=> esc_html__( 'Theme Background Color', 'the-landscaper-wp' ),
					'description' 	=> esc_html__( 'Changes the background of the content area', 'the-landscaper-wp' ),
					'section'     	=> 'qt_section_theme_colors',
					'settings'	  	=> 'qt_boxed_bg',
					'priority'    	=> 10,
				)
			)
		);

		$wp_customize->add_setting( 'qt_theme_textcolor', 
			array(
			    'default'     		=> '#a5a5a5',
			    'transport'	  		=> 'postMessage',
			    'type'				=> 'theme_mod',
			    'capability'		=> 'edit_theme_options',
			    'sanitize_callback' => 'sanitize_hex_color',
			)
		);
		$wp_customize->add_control( new WP_Customize_Color_Control( 
			$wp_customize, 'qt_theme_textcolor', 
				array(
					'label'       	=> esc_html__( 'Text Color', 'the-landscaper-wp' ),
					'section'     	=> 'qt_section_theme_colors',
					'settings'    	=> 'qt_theme_textcolor',
					'priority'    	=> 15,
				)
			)
		);

		$wp_customize->add_setting( 'qt_theme_primary_color', 
			array(
		    	'default'     		=> '#a2c046',
		    	'transport'			=> 'postMessage',
		    	'type'				=> 'theme_mod',
		    	'capability'		=> 'edit_theme_options',
		    	'sanitize_callback' => 'sanitize_hex_color',
			)
		);
		$wp_customize->add_control( new WP_Customize_Color_Control( 
			$wp_customize, 'qt_theme_primary_color', 
				array(
					'label'       	=> esc_html__( 'Primary Color', 'the-landscaper-wp' ),
					'section'     	=> 'qt_section_theme_colors',
					'settings'    	=> 'qt_theme_primary_color',
					'priority'    	=> 20,
				)
			)
		);

		$wp_customize->add_setting( 'qt_theme_primary_btncolor', 
			array(
		     	'default'     		=> '#a2c046',
		     	'transport'			=> 'postMessage',
		     	'type'				=> 'theme_mod',
		     	'capability'		=> 'edit_theme_options',
			    'sanitize_callback' => 'sanitize_hex_color',
			)
		);
		$wp_customize->add_control( new WP_Customize_Color_Control( 
			$wp_customize, 'qt_theme_primary_btncolor', 
				array(
					'label'       	=> esc_html__( 'Button Background Color', 'the-landscaper-wp' ),
					'section'     	=> 'qt_section_theme_colors',
					'settings'    	=> 'qt_theme_primary_btncolor',
					'priority'    	=> 25,
				)
			)
		);

		$wp_customize->add_setting( 'qt_theme_primary_btntext', 
			array(
		     	'default'     		=> '#ffffff',
		     	'transport'			=> 'postMessage',
		     	'type'				=> 'theme_mod',
		     	'capability'		=> 'edit_theme_options',
			    'sanitize_callback' => 'sanitize_hex_color',
			)
		);
		$wp_customize->add_control( new WP_Customize_Color_Control( 
			$wp_customize, 'qt_theme_primary_btntext', 
				array(
					'label'       	=> esc_html__( 'Button Text Color', 'the-landscaper-wp' ),
					'section'     	=> 'qt_section_theme_colors',
					'settings'    	=> 'qt_theme_primary_btntext',
					'priority'    	=> 30,
				)
			)
		);

		$wp_customize->add_setting( 'qt_theme_widgettitle', 
			array(
		     	'default'     		=> '#9fc612',
		     	'transport'			=> 'postMessage',
		     	'type'				=> 'theme_mod',
		     	'capability'		=> 'edit_theme_options',
			    'sanitize_callback' => 'sanitize_hex_color',
			)
		);
		$wp_customize->add_control( new WP_Customize_Color_Control( 
			$wp_customize, 'qt_theme_widgettitle', 
				array(
					'label'       	=> esc_html__( 'Widget Title Color', 'the-landscaper-wp' ),
					'section'     	=> 'qt_section_theme_colors',
					'settings'    	=> 'qt_theme_widgettitle',
					'priority'    	=> 35,
				)
			)
		);

		$wp_customize->add_setting( 'qt_theme_widgettitle_span', 
			array(
		     	'default'     		=> '#464646',
		     	'transport'			=> 'postMessage',
		     	'type'				=> 'theme_mod',
		     	'capability'		=> 'edit_theme_options',
			    'sanitize_callback' => 'sanitize_hex_color',
			)
		);
		$wp_customize->add_control( new WP_Customize_Color_Control( 
			$wp_customize, 'qt_theme_widgettitle_span', 
				array(
					'label'       	=> esc_html__( 'First Word from Widget Title', 'the-landscaper-wp' ),
					'section'     	=> 'qt_section_theme_colors',
					'settings'    	=> 'qt_theme_widgettitle_span',
					'priority'    	=> 40,
				)
			)
		);

		$wp_customize->add_setting( 'qt_theme_widgettitle_border', 
			array(
	        	'default'  			=> 'dashed',
	        	'transport'			=> 'refresh',
	        	'type'				=> 'theme_mod',
	        	'capability'		=> 'edit_theme_options',
	        	'sanitize_callback' => 'thelandscaper_sanitize_select',
	    	)
	    );
		$wp_customize->add_control( 'qt_theme_widgettitle_border', 
			array(
				'label'    			=> esc_html__( 'Theme Border Style', 'the-landscaper-wp' ),
				'section'  			=> 'qt_section_theme_colors',
				'settings' 			=> 'qt_theme_widgettitle_border',
				'type'    			=> 'select',
				'choices' 			=> array(
					'solid' 		=> esc_html__( 'Solid', 'the-landscaper-wp' ),
					'dashed' 	 	=> esc_html__( 'Dashed', 'the-landscaper-wp' ),
					'dotted'		=> esc_html__( 'Dotted', 'the-landscaper-wp' ),
				),
				'priority' 			=> 45,
			)
		);


		// Section Settings: Blog
		$wp_customize->add_setting( 'qt_blog_share', 
			array(
	        	'default'  			=> 'show',
	        	'transport'			=> 'refresh',
	        	'type'				=> 'theme_mod',
	        	'capability'		=> 'edit_theme_options',
	        	'sanitize_callback' => 'thelandscaper_sanitize_select',
	    	)
	    );
		$wp_customize->add_control( 'qt_blog_share', 
			array(
				'label'    			=> esc_html__( 'Display the Share Buttons', 'the-landscaper-wp' ),
				'section'  			=> 'qt_section_blog',
				'settings' 			=> 'qt_blog_share',
				'type'    			=> 'select',
				'choices' 			=> array(
					'show' 			=> esc_html__( 'Show', 'the-landscaper-wp'),
					'hide'  		=> esc_html__( 'Hide', 'the-landscaper-wp'),
				),
				'priority' 			=> 1,
			)
		);
		$wp_customize->add_setting( 'qt_blog_tooltip', 
			array(
				'default'			=> 'Share',
		    	'transport'			=> 'refresh',
		    	'type'				=> 'theme_mod',
		    	'capability'		=> 'edit_theme_options',
		    	'sanitize_callback' => 'thelandscaper_sanitize_text',
			)
		);
		$wp_customize->add_control( 'qt_blog_tooltip', 
			array(
			    'label' 			=> esc_html__( 'Share Tooltip Text', 'the-landscaper-wp' ),
			    'section' 			=> 'qt_section_blog',
			    'settings' 			=> 'qt_blog_tooltip',
			    'type' 				=> 'text',
			    'priority' 			=> 5,
			)
		);
		$wp_customize->add_setting( 'qt_blog_twitter', 
			array(
				'default'			=> 'Twitter',
		    	'transport'			=> 'refresh',
		    	'type'				=> 'theme_mod',
		    	'capability'		=> 'edit_theme_options',
		    	'sanitize_callback' => 'thelandscaper_sanitize_text',
			)
		);
		$wp_customize->add_control( 'qt_blog_twitter', 
			array(
			    'label' 			=> esc_html__( 'Twitter Button Text', 'the-landscaper-wp' ),
			    'section' 			=> 'qt_section_blog',
			    'settings' 			=> 'qt_blog_twitter',
			    'type' 				=> 'text',
			    'priority' 			=> 10,
			)
		);
		$wp_customize->add_setting( 'qt_blog_facebook', 
			array(
				'default'			=> 'Facebook',
		    	'transport'			=> 'refresh',
		    	'type'				=> 'theme_mod',
		    	'capability'		=> 'edit_theme_options',
		    	'sanitize_callback' => 'thelandscaper_sanitize_text',
			)
		);
		$wp_customize->add_control( 'qt_blog_facebook', 
			array(
			    'label' 			=> esc_html__( 'Facebook Button Text', 'the-landscaper-wp' ),
			    'section' 			=> 'qt_section_blog',
			    'settings' 			=> 'qt_blog_facebook',
			    'type' 				=> 'text',
			    'priority' 			=> 15,
			)
		);
		$wp_customize->add_setting( 'qt_blog_googleplus', 
			array(
				'default'			=> 'Google+',
		    	'transport'			=> 'refresh',
		    	'type'				=> 'theme_mod',
		    	'capability'		=> 'edit_theme_options',
		    	'sanitize_callback' => 'thelandscaper_sanitize_text',
			)
		);
		$wp_customize->add_control( 'qt_blog_googleplus', 
			array(
			    'label' 			=> esc_html__( 'Google+ Button Text', 'the-landscaper-wp' ),
			    'section' 			=> 'qt_section_blog',
			    'settings' 			=> 'qt_blog_googleplus',
			    'type' 				=> 'text',
			    'priority' 			=> 20,
			)
		);
		$wp_customize->add_setting( 'qt_blog_linkedin', 
			array(
				'default'			=> 'LinkedIn',
		    	'transport'			=> 'refresh',
		    	'type'				=> 'theme_mod',
		    	'capability'		=> 'edit_theme_options',
		    	'sanitize_callback' => 'thelandscaper_sanitize_text',
			)
		);
		$wp_customize->add_control( 'qt_blog_linkedin', 
			array(
			    'label' 			=> esc_html__( 'LinkedIn Button Text', 'the-landscaper-wp' ),
			    'section' 			=> 'qt_section_blog',
			    'settings' 			=> 'qt_blog_linkedin',
			    'type' 				=> 'text',
			    'priority' 			=> 25,
			)
		);


		// Section Settings: Gallery
		$wp_customize->add_setting( 'qt_gallery_title', 
			array(
	        	'default'  			=> 'actual_title',
	        	'transport'			=> 'refresh',
	        	'type'				=> 'theme_mod',
	        	'capability'		=> 'edit_theme_options',
	        	'sanitize_callback' => 'thelandscaper_sanitize_select',
	    	)
	    );
		$wp_customize->add_control( 'qt_gallery_title', 
			array(
				'label'    			=> esc_html__( 'Position of the Page Title', 'the-landscaper-wp' ),
				'section'  			=> 'qt_section_gallery',
				'settings' 			=> 'qt_gallery_title',
				'type'    			=> 'select',
				'choices' 			=> array(
					'actual_title' 	=> esc_html__( 'Show Actual Item Title', 'the-landscaper-wp' ),
					'custom_title'  => esc_html__( 'Show Custom Title', 'the-landscaper-wp' ),
				),
				'priority' 			=> 1,
			)
		);

		$wp_customize->add_setting( 'qt_gallery_maintitle', 
			array(
		    	'default' 			=> 'Gallery',
		    	'transport'			=> 'refresh',
		    	'type'				=> 'theme_mod',
		    	'capability'		=> 'edit_theme_options',
		    	'sanitize_callback' => 'thelandscaper_sanitize_text',
			)
		);
		$wp_customize->add_control( 'qt_gallery_maintitle', 
			array(
			    'label' 			=> esc_html__( 'Gallery Main Title', 'the-landscaper-wp' ),
			    'section' 			=> 'qt_section_gallery',
			    'settings' 			=> 'qt_gallery_maintitle',
			    'priority' 			=> 5,
			)
		);

		$wp_customize->add_setting( 'qt_gallery_subtitle', 
			array(
		    	'default' 			=> 'A selection of our best work',
		    	'transport'			=> 'refresh',
		    	'type'				=> 'theme_mod',
		    	'capability'		=> 'edit_theme_options',
		    	'sanitize_callback' => 'thelandscaper_sanitize_text',
			)
		);
		$wp_customize->add_control( 'qt_gallery_subtitle', 
			array(
			    'label' 			=> esc_html__( 'Gallery Sub Title', 'the-landscaper-wp' ),
			    'section' 			=> 'qt_section_gallery',
			    'settings' 			=> 'qt_gallery_subtitle',
			    'priority' 			=> 10,
			)
		);

		$wp_customize->add_setting( 'qt_gallery_slug', 
			array(
		    	'default' 			=> 'gallery',
		    	'transport'			=> 'refresh',
		    	'type'				=> 'theme_mod',
		    	'capability'		=> 'edit_theme_options',
		    	'sanitize_callback' => 'thelandscaper_sanitize_gallery_slug',
			)
		);
		$wp_customize->add_control( 'qt_gallery_slug', 
			array(
			    'label' 			=> esc_html__( 'Gallery Slug ( Changes the URL )', 'the-landscaper-wp' ),
			    'description'		=> esc_html__( 'If you see a 404 after, go to Settings - Permalinks and click on Save Changes', 'the-landscaper-wp' ),
			    'section' 			=> 'qt_section_gallery',
			    'settings' 			=> 'qt_gallery_slug',
			    'priority' 			=> 15,
			)
		);

		$wp_customize->add_setting( 'qt_gallery_nav', 
			array(
	        	'default'  			=> 'show',
	        	'transport'			=> 'refresh',
	        	'type'				=> 'theme_mod',
	        	'capability'		=> 'edit_theme_options',
	        	'sanitize_callback' => 'thelandscaper_sanitize_select',
	    	)
	    );
		$wp_customize->add_control( 'qt_gallery_nav', 
			array(
				'label'    			=> esc_html__( 'Display the Gallery Navigation', 'the-landscaper-wp' ),
				'section'  			=> 'qt_section_gallery',
				'settings' 			=> 'qt_gallery_nav',
				'type'    			=> 'select',
				'choices' 			=> array(
					'show' 	=> esc_html__( 'Show', 'the-landscaper-wp'),
					'hide'  => esc_html__( 'Hide', 'the-landscaper-wp'),
				),
				'priority' 			=> 20,
			)
		);

		$wp_customize->add_setting( 'qt_gallery_prevtext', 
			array(
		    	'default' 			=> 'Previous',
		    	'transport'			=> 'refresh',
		    	'type'				=> 'theme_mod',
		    	'capability'		=> 'edit_theme_options',
		    	'sanitize_callback' => 'thelandscaper_sanitize_text',
			)
		);
		$wp_customize->add_control( 'qt_gallery_prevtext', 
			array(
			    'label' 			=> esc_html__( 'Previous Button Text', 'the-landscaper-wp'),
			    'section' 			=> 'qt_section_gallery',
			    'settings' 			=> 'qt_gallery_prevtext',
			    'priority' 			=> 25,
			)
		);

		$wp_customize->add_setting( 'qt_gallery_nexttext', 
			array(
		    	'default' 			=> 'Next',
		    	'transport'			=> 'refresh',
		    	'type'				=> 'theme_mod',
		    	'capability'		=> 'edit_theme_options',
		    	'sanitize_callback' => 'thelandscaper_sanitize_text',
			)
		);
		$wp_customize->add_control( 'qt_gallery_nexttext', 
			array(
			    'label' 			=> esc_html__( 'Next Button Text', 'the-landscaper-wp'),
			    'section' 			=> 'qt_section_gallery',
			    'settings' 			=> 'qt_gallery_nexttext',
			    'priority' 			=> 30,
			)
		);

		$wp_customize->add_setting( 'qt_gallery_summarylink', 
			array(
		    	'transport'			=> 'refresh',
		    	'type'				=> 'theme_mod',
		    	'capability'		=> 'edit_theme_options',
		    	'sanitize_callback' => 'esc_url_raw',
			)
		);
		$wp_customize->add_control( 'qt_gallery_summarylink', 
			array(
			    'label'				=> esc_html__( 'Gallery Summary Link', 'the-landscaper-wp' ),
			    'section' 			=> 'qt_section_gallery',
			    'settings' 			=> 'qt_gallery_summarylink',
			    'priority' 			=> 35,
			)
		);

		$wp_customize->add_setting( 'qt_gallery_summarytext',
			array(
				'default'			=> 'View Summary',
				'transport'			=> 'refresh',
				'capability'		=> 'edit_theme_options',
				'type'				=> 'theme_mod',
				'sanitize_callback' => 'thelandscaper_sanitize_text',
			)
		);
		$wp_customize->add_control( 'qt_gallery_summarytext',
			array(
				'label'				=> esc_html__( 'Gallery Summary Text', 'the-landscaper-wp' ),
				'section'			=> 'qt_section_gallery',
				'settings'			=> 'qt_gallery_summarytext',
				'priority'			=> 40,
			)
		);


		// Section Settings: Shop
		if( thelandscaper_woocommerce_active() ) {
			$wp_customize->add_setting( 'qt_shop_products_per_page', 
				array(
			    	'default' 			=> '8',
			    	'transport'			=> 'refresh',
			    	'type'				=> 'theme_mod',
			    	'capability'		=> 'edit_theme_options',
			    	'sanitize_callback' => 'thelandscaper_sanitize_text',
				)
			);
			$wp_customize->add_control( 'qt_shop_products_per_page', 
				array(
				    'label' 			=> esc_html__( 'Products Per Page', 'the-landscaper-wp'),
				    'section' 			=> 'qt_section_shop',
				    'settings' 			=> 'qt_shop_products_per_page',
				    'priority' 			=> 5,
				)
			);

			$wp_customize->add_setting( 'qt_single_product_sidebar', 
				array(
					'default'			=> 'Right',
		        	'transport'			=> 'refresh',
		        	'type'				=> 'theme_mod',
		        	'capability'		=> 'edit_theme_options',
		        	'sanitize_callback' => 'thelandscaper_sanitize_text',
		    	)
		    );
			$wp_customize->add_control( 'qt_single_product_sidebar', 
				array(
					'label'    			=> esc_html__( 'Single Product Pages Sidebar', 'the-landscaper-wp' ),
					'section'  			=> 'qt_section_shop',
					'settings' 			=> 'qt_single_product_sidebar',
					'type'    			=> 'select',
					'choices' 			=> array(
						'Hide'  		=> esc_html__( 'No sidebar', 'the-landscaper-wp'),
						'Left'  		=> esc_html__( 'Left', 'the-landscaper-wp'),
						'Right' 		=> esc_html__( 'Right', 'the-landscaper-wp'),
					),
					'priority' 			=> 10,
				)
			);
		}


		// Section Settings: Footer
		$wp_customize->add_setting( 'qt_footer_columns', 
			array( 
				'default' 			=> 4,
				'transport'			=> 'refresh',
				'type'				=> 'theme_mod',
				'capability'		=> 'edit_theme_options',
				'sanitize_callback' => 'thelandscaper_sanitize_select',
			)
		);
		$wp_customize->add_control( 'qt_footer_columns', 
			array(
				'type'        		=> 'select',
				'priority'    		=> 0,
				'label'       		=> esc_html__( 'Number of Columns', 'the-landscaper-wp' ),
				'description' 		=> esc_html__( 'Select how many columns you want to display in the main footer. Select 0 to hide the top footer.', 'the-landscaper-wp' ),
				'section'     		=> 'qt_section_footer',
				'settings'    		=> 'qt_footer_columns',
				'choices'     		=> range( 0, 4 ),
			)
		);

		$wp_customize->add_setting( 'qt_footer_textcolor', 
			array(
		    	'default'     		=> '#757575',
		    	'transport'	  		=> 'postMessage',
		    	'type'				=> 'theme_mod',
		    	'capability'		=> 'edit_theme_options',
		    	'sanitize_callback' => 'sanitize_hex_color',
			)
		);
		$wp_customize->add_control( new WP_Customize_Color_Control( 
			$wp_customize, 'qt_footer_textcolor', 
				array(
					'label'       	=> esc_html__( 'Text Color', 'the-landscaper-wp' ),
					'section'     	=> 'qt_section_footer',
					'settings'    	=> 'qt_footer_textcolor',
					'priority'    	=> 5,
				)
			)
		);

		$wp_customize->add_setting( 'qt_footer_widgettitle', 
			array(
			    'default'     		=> '#ffffff',
			    'transport'	  		=> 'postMessage',
			    'type'				=> 'theme_mod',
			    'capability'		=> 'edit_theme_options',
			    'sanitize_callback' => 'sanitize_hex_color',
			)
		);
		$wp_customize->add_control( new WP_Customize_Color_Control( 
			$wp_customize, 'qt_footer_widgettitle', 
				array(
					'label'       	=> esc_html__( 'Widget Title Color', 'the-landscaper-wp' ),
					'section'     	=> 'qt_section_footer',
					'settings'    	=> 'qt_footer_widgettitle',
					'priority'    	=> 10,
				)
			)
		);

		$wp_customize->add_setting( 'qt_footer_bgcolor', 
			array(
				'default'			=> '#333333',
			    'transport'			=> 'postMessage',
			    'type'				=> 'theme_mod',
			    'capability'		=> 'edit_theme_options',
			    'sanitize_callback' => 'sanitize_hex_color',
			)
		);
		$wp_customize->add_control( new WP_Customize_Color_Control( 
			$wp_customize, 'qt_footer_bgcolor', 
				array(
					'label'       	=> esc_html__( 'Footer Background Color', 'the-landscaper-wp' ),
					'section'     	=> 'qt_section_footer',
					'settings'    	=> 'qt_footer_bgcolor',
					'priority'    	=> 15,
				)
			)
		);

		$wp_customize->add_setting( 'qt_footer_bgimage', 
			array(
				'transport'			=> 'refresh',
				'type'				=> 'theme_mod',
				'capability'		=> 'edit_theme_options',
		    	'sanitize_callback' => 'esc_url_raw',
			)
		);
		$wp_customize->add_control( new WP_Customize_Image_Control( 
			$wp_customize, 'qt_footer_bgimage', 
				array(
		            'label' 	 	=> esc_html__('Background Pattern', 'the-landscaper-wp' ), 
		            'section' 	 	=> 'qt_section_footer',
		            'settings' 		=> 'qt_footer_bgimage',
					'priority'   	=> 20,
				)
			)
		);

		$wp_customize->add_setting( 'qt_footerbottom_bgcolor', 
			array(
				'default'			=> '#292929',
			    'transport'			=> 'postMessage',
			    'type'				=> 'theme_mod',
			    'capability'		=> 'edit_theme_options',
			    'sanitize_callback' => 'sanitize_hex_color',
			)
		);
		$wp_customize->add_control( new WP_Customize_Color_Control( 
			$wp_customize, 'qt_footerbottom_bgcolor', 
				array(
					'label'       	=> esc_html__( 'Bottom Footer Background Color', 'the-landscaper-wp' ),
					'section'     	=> 'qt_section_footer',
					'settings'    	=> 'qt_footerbottom_bgcolor',
					'priority'    	=> 25,
				)
			)
		);

		$wp_customize->add_setting( 'qt_footerbottom_textcolor', 
			array(
			    'default'     		=> '#656565',
			    'transport'	  		=> 'postMessage',
			    'type'				=> 'theme_mod',
			    'capability'		=> 'edit_theme_options',
			    'sanitize_callback' => 'sanitize_hex_color',
			)
		);
		$wp_customize->add_control( new WP_Customize_Color_Control( 
			$wp_customize, 'qt_footerbottom_textcolor', 
				array(
					'label'       	=> esc_html__( 'Bottom Footer Text Color', 'the-landscaper-wp' ),
					'section'     	=> 'qt_section_footer',
					'settings'    	=> 'qt_footerbottom_textcolor',
					'priority'    	=> 30,
				)
			)
		);

		$wp_customize->add_setting( 'qt_footerbottom_linkcolor', 
			array(
			    'default'     		=> '#e4e4e4',
			    'transport'	  		=> 'postMessage',
			    'type'				=> 'theme_mod',
			    'capability'		=> 'edit_theme_options',
			    'sanitize_callback' => 'sanitize_hex_color',
			)
		);
		$wp_customize->add_control( new WP_Customize_Color_Control( 
			$wp_customize, 'qt_footerbottom_linkcolor', 
				array(
					'label'       	=> esc_html__( 'Bottom Footer Link Color', 'the-landscaper-wp' ),
					'section'     	=> 'qt_section_footer',
					'settings'    	=> 'qt_footerbottom_linkcolor',
					'priority'    	=> 33,
				)
			)
		);

		$wp_customize->add_setting( 'qt_footerbottom_textleft', 
			array(
		    	'default' 			=> 'Copyright 2015 The Landscaper by Qreativethemes',
		    	'transport'			=> 'refresh',
		    	'type'				=> 'theme_mod',
		    	'capability'		=> 'edit_theme_options',
		    	'sanitize_callback' => 'thelandscaper_sanitize_text',
			)
		);
		$wp_customize->add_control( 'qt_footerbottom_textleft', 
			array(
			    'label' 			=> esc_html__( 'Bottom Footer Left Text', 'the-landscaper-wp' ),
			    'section' 			=> 'qt_section_footer',
			    'settings' 			=> 'qt_footerbottom_textleft',
			    'type' 				=> 'text',
			    'priority' 			=> 35,
			)
		);

		$wp_customize->add_setting( 'qt_footerbottom_textmiddle', 
			array(
				'default'			=> 'Middle Text',
		    	'transport'			=> 'refresh',
		    	'type'				=> 'theme_mod',
		    	'capability'		=> 'edit_theme_options',
		    	'sanitize_callback' => 'thelandscaper_sanitize_text',
			)
		);
		$wp_customize->add_control( 'qt_footerbottom_textmiddle', 
			array(
			    'label' 			=> esc_html__( 'Bottom Footer Middle Text', 'the-landscaper-wp' ),
			    'section' 			=> 'qt_section_footer',
			    'settings' 			=> 'qt_footerbottom_textmiddle',
			    'type' 				=> 'text',
			    'priority' 			=> 40,
			)
		);

		$wp_customize->add_setting( 'qt_footerbottom_textright', 
			array(
		    	'default' 			=> 'For emergency tree removal 123-777-456',
		    	'transport'			=> 'refresh',
		    	'type'				=> 'theme_mod',
		    	'capability'		=> 'edit_theme_options',
		    	'sanitize_callback' => 'thelandscaper_sanitize_text',
			)
		);
		$wp_customize->add_control( 'qt_footerbottom_textright', 
			array(
		    	'label' 			=> esc_html__( 'Bottom Footer Right Text', 'the-landscaper-wp' ),
		    	'section' 			=> 'qt_section_footer',
		    	'settings' 			=> 'qt_footerbottom_textright',
		    	'type' 				=> 'text',
		    	'priority' 			=> 45,
			)
		);


		// Section Settings: Custom
		$wp_customize->add_setting( 'qt_custom_css', 
			array(
		    	'transport'			=> 'refresh',
		    	'type'				=> 'theme_mod',
		    	'capability'		=> 'edit_theme_options',
		    	'sanitize_callback' => 'thelandscaper_sanitize_textarea',
			)
		);
		$wp_customize->add_control( 'qt_custom_css', 
			array(
		    	'label' 			=> esc_html__( 'Custom CSS', 'the-landscaper-wp' ),
		    	'section' 			=> 'qt_section_custom',
		    	'settings' 			=> 'qt_custom_css',
		    	'type' 				=> 'textarea',
		    	'priority' 			=> 5,
			)
		);


		// Section Settings: Automatic Updates
		$wp_customize->add_setting( 'qt_auto_updates_username', 
			array(
		    	'transport'			=> 'refresh',
		    	'type'				=> 'theme_mod',
		    	'capability'		=> 'edit_theme_options',
		    	'sanitize_callback' => 'thelandscaper_sanitize_text',
			)
		);
		$wp_customize->add_control( 'qt_auto_updates_username', 
			array(
			    'label' 			=> esc_html__( 'Envato (Themeforest) Username', 'the-landscaper-wp' ),
			    'section' 			=> 'qt_section_auto_updates',
			    'settings' 			=> 'qt_auto_updates_username',
			    'type' 				=> 'text',
			    'priority' 			=> 5,
			)
		);

		$wp_customize->add_setting( 'qt_auto_updates_api_key', 
			array(
		    	'transport'			=> 'refresh',
		    	'type'				=> 'theme_mod',
		    	'capability'		=> 'edit_theme_options',
		    	'sanitize_callback' => 'thelandscaper_sanitize_text',
			)
		);
		$wp_customize->add_control( 'qt_auto_updates_api_key', 
			array(
			    'label' 			=> esc_html__( 'Envato (Themeforest) API Key', 'the-landscaper-wp' ),
			    'description'		=> esc_html__( 'Go to settings in your envato account, then to API Keys (last menu item from the sidebar) to generate a new API key and paste it in here', 'the-landscaper-wp' ),
			    'section' 			=> 'qt_section_auto_updates',
			    'settings' 			=> 'qt_auto_updates_api_key',
			    'type' 				=> 'text',
			    'priority' 			=> 10,
			)
		);

		$wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
		$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
	}

	/**
	 * Formats the primary styles for output.
	 *
	 * @since  1.0.0
	 * @return string
	 */
	public function thelandscaper_get_primary_styles() {
		// Get all the Theme Mods

		// Top Margin Logo
		$qt_logo_margin_top			  = get_theme_mod( 'qt_logo_margin_top' );

		// Topbar
		$topbar_bg 					  = get_theme_mod( 'qt_topbar_bg', '#3a3a3a' );
		$topbar_textcolor 			  = get_theme_mod( 'qt_topbar_textcolor', '#7d7d7d' );
		$topbar_textcolor_adjust      = thelandscaper_adjust_color( $topbar_textcolor, -25);
		$topbar_textcolor_hover 	  = thelandscaper_adjust_color( $topbar_textcolor, 150);

		// Mobile Navigation
		$nav_mobile_bg 				  = get_theme_mod( 'qt_nav_mobile_bg' , '#a2c046' );
		$nav_mobile_bg_adjust 		  = thelandscaper_adjust_color( $nav_mobile_bg, 10 );
		$nav_mobile_textcolor 		  = get_theme_mod( 'qt_nav_mobile_textcolor', '#ffffff' );
		$nav_mobile_submenu_bg 		  = get_theme_mod( 'qt_nav_submenu_bg', '#9ab643' );
		$nav_mobile_submenu_textcolor = get_theme_mod( 'qt_nav_mobile_submenu_textcolor', '#ffffff' );

		// Desktop Navigation
		$nav_bg 					  = get_theme_mod( 'qt_nav_bg', '#a2c046' );
		$nav_bg_adjust 				  = thelandscaper_adjust_color( $nav_bg, 25 );
		$nav_textcolor 				  = get_theme_mod( 'qt_nav_textcolor', '#ffffff' );
		$nav_submenu_bgcolor 		  = get_theme_mod( 'qt_nav_submenu_bg', '#434343' );
		$nav_submenu_bgcolor_adjust	  = thelandscaper_adjust_color( $nav_submenu_bgcolor, -9 );
		$nav_submenu_textcolor 		  = get_theme_mod( 'qt_nav_submenu_textcolor', '#999999' );
		$nav_submenu_textcolor_adjust = thelandscaper_adjust_color( $nav_submenu_textcolor, 100 );

		// Page Header
		$maintitle_align 			  = get_theme_mod( 'qt_maintitle_align' , 'left' );
		$maintitle_bgcolor 			  = get_theme_mod( 'qt_maintitle_bgcolor', '#f2f2f2' );
		$maintitle_bgimage 			  = get_theme_mod( 'qt_maintitle_bgimage', get_template_directory_uri().'/assets/images/texture_1.png' );
		$maintitle_color 			  = get_theme_mod( 'qt_maintitle_color', '#333333' );
		$subtitle_color  			  = get_theme_mod( 'qt_subtitle_color', '#999999' );

		// Breadcrumbs
		$breadcrumbs_align 			  = get_theme_mod( 'qt_breadcrumbs_align' , 'left' );
		$breadcrumbs_textcolor 		  = get_theme_mod( 'qt_breadcrumbs_textcolor', '#a5a5a5' );
		$breadcrumbs_text_hover		  = thelandscaper_adjust_color( $breadcrumbs_textcolor, -10 );
		$breadcrumbs_activecolor 	  = get_theme_mod( 'qt_breadcrumbs_activecolor', '#a2c046' );

		// Theme Colors -- Primary 
		$theme_primary_color 		  = get_theme_mod( 'qt_theme_primary_color', '#a2c046' );
		$theme_primary_color_adjust   = thelandscaper_adjust_color( $theme_primary_color, -10);

		// Theme Colors -- Button Background
		$theme_btn_color 			  = get_theme_mod( 'qt_theme_primary_btncolor', '#a2c046' );
		$theme_btn_color_adjust 	  = thelandscaper_adjust_color( $theme_btn_color, -10 );

		// Theme Colors -- Button Text Color
		$theme_btn_textcolor		  = get_theme_mod( 'qt_theme_primary_btntext', '#ffffff' );

		// Theme Colors -- Text Color
		$theme_textcolor 			  = get_theme_mod( 'qt_theme_textcolor', '#a5a5a5' );

		// Theme Colors -- Widget Title Color
		$widget_title_color 		  = get_theme_mod( 'qt_theme_widgettitle', '#9fc612' );

		// Theme Colors -- First Span Widget Title Color
		$widget_title_span_color 	  = get_theme_mod( 'qt_theme_widgettitle_span', '#464646' );

		// Theme Colors -- Theme Border Style
		$widget_border_style 		  = get_theme_mod( 'qt_theme_widgettitle_border', 'dashed' );

		// Footer
		$footer_bg 					  = get_theme_mod( 'qt_footer_bgcolor' );
		$footer_bgimage 			  = get_theme_mod( 'qt_footer_bgimage' );
		$footer_textcolor 			  = get_theme_mod( 'qt_footer_textcolor', '#757575' );
		$footer_widget_title 		  = get_theme_mod( 'qt_footer_widgettitle', '#ffffff' );
		$footer_bottom_bg 			  = get_theme_mod( 'qt_footerbottom_bgcolor', '#292929' );
		$footer_bottom_textcolor 	  = get_theme_mod( 'qt_footerbottom_textcolor', '#777777' );
		$footer_bottom_linkcolor 	  = get_theme_mod( 'qt_footerbottom_linkcolor', '#e4e4e4' );
		$footer_bottom_linkcolor_adjust = thelandscaper_adjust_color( $footer_bottom_linkcolor, 50 );

		// Boxed Layout
		$boxed_bg 					  = get_theme_mod( 'qt_boxed_bg', '#ffffff' );

		// Build Up the Styles
		$thelandscaper_style = '';

		// Logo
		$thelandscaper_style = ".header .navigation .navbar-brand img { margin-top: {$qt_logo_margin_top}px; }";

		// Topbar
		$thelandscaper_style .= "@media(max-width: 992px) { .topbar { background-color: {$topbar_bg}; } }";
		$thelandscaper_style .= ".topbar, .topbar a, .topbar .tagline, .topbar .widget-icon-box .title, .topbar .widget-icon-box .subtitle { color: {$topbar_textcolor}; }";
		$thelandscaper_style .= ".topbar .fa, .topbar .widget-icon-box .fa, .topbar .widget-social-icons a { color: {$topbar_textcolor_adjust}; }";
		$thelandscaper_style .= ".topbar .widget-icon-box:hover .fa, .topbar .widget-social-icons a:hover .fa, .topbar .menu > li.menu-item-has-children:hover > a { color: {$topbar_textcolor_hover}; }";

		// Navigation
		$thelandscaper_style .= ".main-navigation { background-color: {$nav_mobile_bg}; }";
		$thelandscaper_style .= ".main-navigation>li>a { color: {$nav_mobile_textcolor}; border-color: {$nav_mobile_bg_adjust}; }";
		$thelandscaper_style .= ".main-navigation>li>.sub-menu li a { color: {$nav_mobile_submenu_textcolor}; background-color: {$nav_mobile_submenu_bg}; }";

		$thelandscaper_style .= "@media(min-width: 992px) {";
		$thelandscaper_style .= ".header { background-color: {$topbar_bg}; }";
		$thelandscaper_style .= ".main-navigation, .header.header-wide .main-navigation::after { background-color: {$nav_bg}; }";
		$thelandscaper_style .= ".main-navigation>li:hover>a::after, .main-navigation>li:focus>a::after, .main-navigation>li.current-menu-item>a::after, .main-navigation>li.current-menu-item>a:hover::after, .main-navigation>li.current-menu-parent>a::after, .main-navigation>li.cuurent-menu-parent>a:hover::after, .navigation ul>li>a::before { background-color: {$nav_bg_adjust}; }";
		$thelandscaper_style .= ".main-navigation>li>a { color: {$nav_textcolor}; }";
		$thelandscaper_style .= ".main-navigation>li>.sub-menu li a { color: {$nav_submenu_textcolor}; background-color: {$nav_submenu_bgcolor}; }";
		$thelandscaper_style .= ".main-navigation>li>.sub-menu li:hover > a { color: {$nav_submenu_textcolor_adjust}; background-color: {$nav_submenu_bgcolor_adjust}; border-bottom-color: {$nav_submenu_bgcolor_adjust}; }";
		$thelandscaper_style .= "}";

		// Page Header
		$thelandscaper_style .= ".page-header { text-align: {$maintitle_align}; background-color: {$maintitle_bgcolor}; background-image: url('{$maintitle_bgimage}'); }";
		$thelandscaper_style .= ".page-header .main-title { color: {$maintitle_color}; }";
		$thelandscaper_style .= ".page-header .sub-title { color: {$subtitle_color}; }";

		// Breadcrumbs
		$thelandscaper_style .= ".breadcrumbs { text-align: {$breadcrumbs_align}; }";
		$thelandscaper_style .= ".breadcrumbs a { color: {$breadcrumbs_textcolor}; }";
		$thelandscaper_style .= ".breadcrumbs a:hover { color: {$breadcrumbs_text_hover}; }";
		$thelandscaper_style .= ".breadcrumbs span>span { color: {$breadcrumbs_activecolor}; }";

		// Theme Colors -- Primary 
		$thelandscaper_style .= "
			a,
			.dropcap,
			.post-item .title > a:hover,
			.testimonials .testimonial .author-location,
			.post .post-left-meta .box.date .day,
			.post .post-title a:hover,
			.w-footer .icon-box .fa,
			.content .icon-box .fa,
			.opening-times ul li.today,
			.woocommerce-page div.product p.price,
			.testimonials .testimonial-person .testimonial-location,
			.woocommerce div.product .star-rating span::before,
			body.woocommerce-page .woocommerce-error:before,
			body.woocommerce-page .woocommerce-info:before,
			body.woocommerce-page .woocommerce-message:before { color: {$theme_primary_color}; }";

		$thelandscaper_style .= "
			.w-footer .icon-box:hover .fa,
			.content .icon-box:hover .fa,
			a:hover { color: {$theme_primary_color_adjust}; }
		";

		$thelandscaper_style .= "
			.counter.count-box .count-icon .fa,
			.carousel-indicators li.active,
			.qt-table thead td,
			.opening-times ul span.right.label { background-color: {$theme_primary_color}; }";

		$thelandscaper_style .= "
			.client-logos img:hover,
			.cta-button:hover,
			.brochure-box:hover,
			.carousel-indicators li.active,
			.wpcf7-text:focus,
			.wpcf7-textarea:focus,
			.comment-form .comment-form-author input:focus,
			.comment-form .comment-form-email input:focus,
			.comment-form .comment-form-url input:focus,
			.comment-form .comment-form-comment textarea:focus { border-color: {$theme_primary_color}; }";

		$thelandscaper_style .= ".woocommerce div.product div.images img:hover, .woocommerce ul.products li.product a:hover img { outline-color: {$theme_primary_color}; }";
		$thelandscaper_style .= ".woocommerce .widget_product_categories .product-categories li a { border-color: {$theme_primary_color_adjust}; }";
		$thelandscaper_style .= ".counter.count-box .count-icon .fa::after { border-top-color: {$theme_primary_color}; }";
		$thelandscaper_style .= "
			.counter.count-box:hover .count-icon .fa { background-color: {$theme_primary_color_adjust}; }
			.counter.count-box:hover .count-icon .fa::after { border-top-color: {$theme_primary_color_adjust}; }";

		// Theme Colors -- Button Background
		$thelandscaper_style .= "
			.btn-primary,
			.wpcf7-submit,
			button,
			input[type='button'],
			input[type='reset'],
			input[type='submit'],
			.jumbotron .carousel-indicators li.active,
			.post-item .vertical-center span,
			.post-item .label-wrap .label,
			.testimonials .testimonial-control,
			.testimonials .testimonial-control:first-of-type::before,
			.testimonials .testimonial-control:last-of-type::before,
			.cta-button,
			.brochure-box,
			.project-navigation a,
			.pagination a.current,
			.pagination span.current,
			.sidebar .widget.widget_nav_menu .menu li:hover,
			.sidebar .widget.widget_nav_menu .menu li.current-menu-item a,
			.sidebar .widget.widget_nav_menu .menu li a:hover,
			.panel-group .accordion-toggle[aria-expanded=".'true'."],
			.panel-group .accordion-toggle::before,
			.panel-group .accordion-toggle.active,
			.woocommerce a.button,
			.woocommerce input.button,
			.woocommerce input.button.alt,
			.woocommerce button.button,
			.woocommerce span.onsale,
			.woocommerce ul.products li.product .onsale,
			.woocommerce nav.woocommerce-pagination ul li span.current,
			.woocommerce-page div.product form.cart .button.single_add_to_cart_button,
			.woocommerce div.product .woocommerce-tabs ul.tabs li.active,
			.woocommerce-cart .wc-proceed-to-checkout a.checkout-button,
			.woocommerce .widget_price_filter .ui-slider .ui-slider-handle,
			.woocommerce .widget_product_categories .product-categories li a { background-color: {$theme_btn_color}; color: {$theme_btn_textcolor}; }";

		// Button Background Hover
		$thelandscaper_style .= "
			.btn-primary:hover,
			.wpcf7-submit:hover,
			button:hover,
			input[type='button']:hover,
			input[type='reset']:hover,
			input[type='submit']:hover,
			.post-item .vertical-center span:hover,
			.post-item .label-wrap .label:hover,
			.testimonials .testimonial-control:hover,
			.testimonials .testimonial-control:first-of-type:hover::before,
			.testimonials .testimonial-control:last-of-type:hover::before,
			.project-navigation a:hover,
			.pagination a:hover,
			.project-navigation a:focus,
			.woocommerce a.button:hover,
			.woocommerce input.button:hover,
			.woocommerce input.button.alt:hover,
			.woocommerce button.button:hover,
			.woocommerce span.onsale:hover,
			.woocommerce ul.products li.product .onsale:hover, 
			.woocommerce-page div.product form.cart .button.single_add_to_cart_button:hover,
			.woocommerce-cart .wc-proceed-to-checkout a.checkout-button:hover,
			.woocommerce nav.woocommerce-pagination ul li a:hover,
			.woocommerce nav.woocommerce-pagination ul li a:focus,
			.woocommerce div.product .woocommerce-tabs ul.tabs li:hover,
			body.woocommerce-page .woocommerce-error a.button:hover,
			body.woocommerce-page .woocommerce-info a.button:hover,
			body.woocommerce-page .woocommerce-message a.button:hover,
			.woocommerce .widget_product_categories .product-categories li a:hover { background-color: {$theme_btn_color_adjust}; color: {$theme_btn_textcolor}; }";

		$thelandscaper_style .= "
			.woocommerce nav.woocommerce-pagination ul li span.current,
			.jumbotron .carousel-indicators li.active { border-color: {$theme_btn_color}; }";

		$thelandscaper_style .= ".post-item .label-wrap .label::after { border-top-color: {$theme_btn_color}; }";
		$thelandscaper_style .= "
			.pagination a:hover,
			.woocommerce nav.woocommerce-pagination ul li a:hover,
			.woocommerce nav.woocommerce-pagination ul li a:focus,
			.woocommerce div.product .woocommerce-tabs ul.tabs li.active,
			.woocommerce div.product .woocommerce-tabs ul.tabs li:hover,
			.woocommerce .widget_product_categories .product-categories li a { border-color: {$theme_btn_color_adjust}; }";

		$thelandscaper_style .= ".post-item .label-wrap .label:hover::after { border-top-color: {$theme_btn_color_adjust}; }";

		// Theme Colors -- Text Color
		$thelandscaper_style .= "body, .content a.icon-box .subtitle { color: {$theme_textcolor}; }";

		// Theme Colors -- Widget Title Color
		$thelandscaper_style .= ".widget-title { color: {$widget_title_color}; }";

		// Theme Colors -- First Span Widget Title Color
		$thelandscaper_style .= ".content .widget-title span.light { color: {$widget_title_span_color}; }";

		// Theme Colors -- Theme Borders
		$thelandscaper_style .= ".content .widget-title, .custom-title, .project-navigation, .post-meta-data, .woocommerce-page .product .summary.entry-summary p.price, .pagination, .woocommerce-pagination { border-style: {$widget_border_style}; }";

		// Footer
		$thelandscaper_style .= ".main-footer { background-color: {$footer_bg }; background-image: url('{$footer_bgimage}'); }";
		$thelandscaper_style .= ".main-footer, .main-footer p, .main-footer .widget_nav_menu ul>li>a { color: {$footer_textcolor}; }";
		$thelandscaper_style .= ".footer .widget-title { color: {$footer_widget_title}; }";
		$thelandscaper_style .= ".bottom-footer { background-color: {$footer_bottom_bg}; }";
		$thelandscaper_style .= ".bottom-footer p { color: {$footer_bottom_textcolor}; }";
		$thelandscaper_style .= ".bottom-footer a { color: {$footer_bottom_linkcolor}; }";
		$thelandscaper_style .= ".bottom-footer a:hover { color: {$footer_bottom_linkcolor_adjust}; }";

		// Boxed Layout
		$thelandscaper_style .= ".layout-boxed { background-color: {$boxed_bg}; };";

		return str_replace( array( "\r", "\n", "\t" ), '', $thelandscaper_style );
	}

	/**
	 * Callback for 'wp_head' that outputs the CSS for this feature.
	 *
	 * @since  1.0.0
	 * @return void
	 */
	public function thelandscaper_head_callback() {

		$stylesheet = get_stylesheet();
		
		/* Get the cached style. */
		$thelandscaper_style = wp_cache_get( "{$stylesheet}_custom_colors" );
		
		/* If the style is available, output it and return. */
		if ( !empty( $thelandscaper_style ) ) {
			echo $thelandscaper_style;
			return;
		}
		$thelandscaper_style = $this->thelandscaper_get_primary_styles();
		
		/* Put the final style output together. */
		$thelandscaper_style = "\n" . '<style id="customizer-css" type="text/css">' . trim( $thelandscaper_style ) . '</style>' . "\n";
		
		/* Cache the style, so we don't have to process this on each page load. */
		wp_cache_set( "{$stylesheet}_custom_colors", $thelandscaper_style );
		
		/* Output the custom style. */
		echo $thelandscaper_style; // sanitized from each theme option

		// Get the Custom CSS Theme option
		$custom_css = get_theme_mod( 'qt_custom_css' );

		// Wrap around <style> tags
		if ( strlen( $custom_css ) ) {
			echo '<style id="custom-css" type="text/css">' . PHP_EOL;
			echo $custom_css . PHP_EOL; // already sanitized
			echo '</style>' . PHP_EOL;
		}

		// Add wp inline style
		wp_add_inline_style( 'custom-css', 'thelandscaper_customizer_css', 30 );
	}

	/**
	 * Deletes the cached style CSS that's output into the header.
	 *
	 * @since  1.0.0
	 * @return void
	 */
	public function thelandscaper_cache_delete() {
		wp_cache_delete( get_stylesheet() . '_custom_colors' );
	}

	/**
	 * Returns the instance.
	 *
	 * @since  1.0.0
	 * @return object
	 */
	public static function thelandscaper_instance() {
		if ( !self::$instance )
			self::$instance = new self;
		return self::$instance;
	}

	/**
	* This outputs the javascript needed to automate the live settings preview.
	* Also keep in mind that this function isn't necessary unless your settings 
	* are using 'transport'=>'postMessage' instead of the default 'transport'
	* => 'refresh'
	* 
	* Used by hook: 'customize_preview_init'
	* 
	* @see add_action('customize_preview_init',$func)
	* @since Version 1.0
	*/
	public function thelandscaper_live_preview() {
		wp_enqueue_script( 'thelandscaper-customizer-js', get_template_directory_uri() . '/assets/js/customizer.js', array(
			'jquery',
			'customize-preview'
		), '', true );
	}

	/**
	 * Generate a lighter/darker color for a hover color
	 */
	public static function thelandscaper_adjust_color($hex, $steps) {
	    // Steps should be between -255 and 255. Negative = darker, positive = lighter
	    $steps = max(-255, min(255, $steps));

	    // Normalize into a six character long hex string
	    $hex = str_replace('#', '', $hex);
	    if (strlen($hex) == 3) {
	        $hex = str_repeat(substr($hex,0,1), 2).str_repeat(substr($hex,1,1), 2).str_repeat(substr($hex,2,1), 2);
	    }

	    // Split into three parts: R, G and B
	    $color_parts = str_split($hex, 2);
	    $return = '#';

	    foreach ($color_parts as $color) {
	        $color   = hexdec($color); // Convert to decimal
	        $color   = max(0,min(255,$color + $steps)); // Adjust color
	        $return .= str_pad(dechex($color), 2, '0', STR_PAD_LEFT); // Make two char hex code
	    }

	    return $return;
	}
}


/**
 * Adds sanitization callback function: select
 */
if( ! function_exists( 'thelandscaper_sanitize_select' ) ) {
	function thelandscaper_sanitize_select( $input, $setting ) {
		// Ensure input is a slug
		$input = sanitize_key( $input );
		// Get list of choices from the control
		// associated with the setting
		$choices = $setting->manager->get_control( $setting->id )->choices;
		// If the input is a valid key, return it;
		// otherwise, return the default
		return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
	}
}

/**
 * Adds sanitization callback function: text
 */
if( ! function_exists( 'thelandscaper_sanitize_text' ) ) {
	function thelandscaper_sanitize_text( $input ) {
	    return wp_kses_post( force_balance_tags( $input ) );
	}
}

/**
 * Adds sanitization callback function: textarea
 */
if( ! function_exists( 'thelandscaper_sanitize_textarea' ) ) {
	function thelandscaper_sanitize_textarea( $input ) {
	    return esc_textarea( $input );
	}
}

/**
 * Adds sanitization callback function: gallery slug
 */
if( ! function_exists( 'thelandscaper_sanitize_gallery_slug' ) ) {
	function thelandscaper_sanitize_gallery_slug( $slug ) {
		$slug = trim( $slug );
		return sanitize_title( $slug, 'gallery' );
	}
}

TheLandscaper_Customizer::thelandscaper_instance();