<?php

/* Load the embedded Redux Framework */


if ( !class_exists( 'ReduxFramework' ) && file_exists( dirname( __FILE__ ) . '/options/ReduxCore/framework.php' ) ) {
    require_once dirname( __FILE__ ) . '/options/ReduxCore/framework.php';
}

/**
 * ReduxFramework Sample Config File
 * */

if ( !class_exists( 'vce_settings_Redux_Framework_config' ) ) {

    class vce_settings_Redux_Framework_config {

        public $args        = array();
        public $sections    = array();
        public $theme;
        public $ReduxFramework;

        public function __construct() {

            if ( !class_exists( 'ReduxFramework' ) ) {
                return;
            }

            // This is needed. Bah WordPress bugs.  ;)
            if ( true == Redux_Helpers::isTheme( __FILE__ ) ) {
                $this->initSettings();
            } else {
                add_action( 'plugins_loaded', array( $this, 'initSettings' ), 10 );
            }

        }

        public function initSettings() {

            // Just for demo purposes. Not needed per say.
            $this->theme = wp_get_theme();

            // Set the default arguments
            $this->setArguments();

            // Set a few help tabs so you can see how it's done
            $this->setHelpTabs();

            // Create the sections and fields
            $this->setSections();

            if ( !isset( $this->args['opt_name'] ) ) { // No errors please
                return;
            }

            // If Redux is running as a plugin, this will remove the demo notice and links
            add_action( 'redux/loaded', array( $this, 'remove_demo' ) );

            // Function to test the compiler hook and demo CSS output.
            // Above 10 is a priority, but 2 in necessary to include the dynamically generated CSS to be sent to the function.
            //add_filter('redux/options/'.$this->args['opt_name'].'/compiler', array( $this, 'compiler_action' ), 10, 2);

            // Change the arguments after they've been declared, but before the panel is created
            //add_filter('redux/options/'.$this->args['opt_name'].'/args', array( $this, 'change_arguments' ) );

            // Change the default value of a field after it's been set, but before it's been useds
            //add_filter('redux/options/'.$this->args['opt_name'].'/defaults', array( $this,'change_defaults' ) );

            // Dynamically add a section. Can be also used to modify sections/fields
            //add_filter('redux/options/' . $this->args['opt_name'] . '/sections', array($this, 'dynamic_section'));

            $this->ReduxFramework = new ReduxFramework( $this->sections, $this->args );
        }

        /**
         * This is a test function that will let you see when the compiler hook occurs.
         * It only runs if a field set with compiler=>true is changed.
         * */
        function compiler_action( $options, $css ) {
            //echo '<h1>The compiler hook has run!';
            //print_r($options); //Option values
            //print_r($css); // Compiler selector CSS values  compiler => array( CSS SELECTORS )

            /*
              // Demo of how to use the dynamic CSS and write your own static CSS file
              $filename = dirname(__FILE__) . '/style' . '.css';
              global $wp_filesystem;
              if( empty( $wp_filesystem ) ) {
                require_once( ABSPATH .'/wp-admin/includes/file.php' );
              WP_Filesystem();
              }

              if( $wp_filesystem ) {
                $wp_filesystem->put_contents(
                    $filename,
                    $css,
                    FS_CHMOD_FILE // predefined mode settings for WP files
                );
              }
             */
        }

        /**
         * Custom function for filtering the sections array. Good for child themes to override or add to the sections.
         * Simply include this function in the child themes functions.php file.
         * NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
         * so you must use get_template_directory_uri() if you want to use any of the built in icons
         * */
        function dynamic_section( $sections ) {
            //$sections = array();
            $sections[] = array(
                'title' => __( 'Section via hook', 'vce_settings' ),
                'desc' => __( '<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'vce_settings' ),
                'icon' => 'el-icon-paper-clip',
                // Leave this as a blank section, no options just some intro text set above.
                'fields' => array()
            );

            return $sections;
        }

        /**
         * Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.
         * */
        function change_arguments( $args ) {
            //$args['dev_mode'] = true;

            return $args;
        }

        /**
         * Filter hook for filtering the default value of any given field. Very useful in development mode.
         * */
        function change_defaults( $defaults ) {
            $defaults['str_replace'] = 'Testing filter hook!';

            return $defaults;
        }

        // Remove the demo link and the notice of integrated demo from the redux-framework plugin
        function remove_demo() {

            // Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
            if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
                remove_filter( 'plugin_row_meta', array( ReduxFrameworkPlugin::instance(), 'plugin_metalinks' ), null, 2 );

                // Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
                remove_action( 'admin_notices', array( ReduxFrameworkPlugin::instance(), 'admin_notices' ) );
            }
        }

        public function setSections() {

            include_once 'sections.php';
            //include_once('sections-ref.php');
        }

        public function setHelpTabs() {

            // Custom page help tabs, displayed using the help API. Tabs are shown in order of definition.

            /*
            $this->args['help_tabs'][] = array(
                'id'        => 'redux-help-tab-1',
                'title'     => __('Theme Information 1', 'vce_settings'),
                'content'   => __('<p>This is the tab content, HTML is allowed.</p>', 'vce_settings')
            );
            */


            /*
            $this->args['help_tabs'][] = array(
                'id'        => 'redux-help-tab-2',
                'title'     => __('Theme Information 2', 'vce_settings'),
                'content'   => __('<p>This is the tab content, HTML is allowed.</p>', 'vce_settings')
            );
            */

            // Set the help sidebar
            //$this->args['help_sidebar'] = __('<p>This is the sidebar content, HTML is allowed.</p>', 'vce_settings');
        }

        /**
         * All the possible arguments for Redux.
         * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
         * */
        public function setArguments() {

            $theme = wp_get_theme(); // For use with some settings. Not necessary.

            $this->args = array (
                'opt_name' => 'vce_settings',
                'allow_sub_menu' => true,
                'admin_bar_icon' => 'dashicons-admin-generic',
                'customizer' => false,
                'default_mark' => '',
                'footer_text' => '',
                'hint-icon' => 'el-icon-question-sign',
                'icon_position' => 'right',
                'icon_size' => 'normal',
                'tip_style_color' => 'cream',
                'tip_position_my' => 'top left',
                'tip_position_at' => 'bottom right',
                'tip_show_duration' => '500',
                'tip_show_event' =>
                array (
                    0 => 'mouseover',
                ),
                'tip_hide_duration' => '500',
                'tip_hide_event' =>
                array (
                    0 => 'mouseleave',
                    1 => 'unfocus',
                ),
                'intro_text' => '',
                'menu_type' => 'menu',
                'output' => false,
                'menu_title' => 'Theme Options',
                'output_tag' => false,
                'page_icon' => 'icon-themes',
                'page_permissions' => 'manage_options',
                'page_slug' => 'vce_options',
                'page_title' => 'Voice Options',
                'save_defaults' => true,
                'show_import_export' => true,
                'update_notice' => false,
                'compiler' => false,
                'page_priority' => '27.11',
                'dev_mode' => false,
                'allow_tracking' => false

            );

            //$theme = wp_get_theme(); // For use with some settings. Not necessary.
            $this->args["display_name"] = 'Voice Options<a href="http://demo.mekshq.com/voice/documentation" target="_blank">Theme Documentation</a>';
            $this->args["display_version"] = '';

            // SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.

            $this->args['share_icons'][] = array(
                'url'   => 'https://www.facebook.com/mekshq',
                'title' => 'Like us on Facebook',
                'icon'  => 'el-icon-facebook'
            );
            $this->args['share_icons'][] = array(
                'url'   => 'http://twitter.com/mekshq',
                'title' => 'Follow us on Twitter',
                'icon'  => 'el-icon-twitter'
            );


        }

    }

    global $reduxConfig;
    $reduxConfig = new vce_settings_Redux_Framework_config();
}



/* Append custom css to redux framework */
if ( !function_exists( 'vce_redux_custom_css' ) ):
    function vce_redux_custom_css() {
        wp_register_style( 'vce-redux-custom-css', CSS_URI.'/theme-options-custom.css', array( 'redux-css' ), THEME_VERSION, 'all' );
        wp_enqueue_style( 'vce-redux-custom-css' );
    }
endif;

add_action( 'redux/page/vce_settings/enqueue', 'vce_redux_custom_css' );


?>
