<?php
    namespace ToDoPlugin;

    use ToDoPlugin\DbSerializer;

    class Loader {
        public static function init() {
            register_activation_hook( TODO__PLUGIN_STARTPOINT, array( self::class, 'activate_plugin' ) );
            register_deactivation_hook( TODO__PLUGIN_STARTPOINT, array( self::class, 'deactivate_plugin' ) );
    
            add_action('admin_menu', array( self::class, 'add_admin_page' ));
            add_action('admin_enqueue_scripts', array( self::class, 'add_admin_style' ));
            add_action('wp_enqueue_scripts', array( self::class, 'add_front_script' ));
    
            add_shortcode('todo', array( self::class, 'display_todo_list' )); // [todo]
        }

        public static function activate_plugin() {
            DbSerializer::createTable();
        }

        public static function deactivate_plugin() {
            DbSerializer::dropTable();
        }

        public static function add_admin_page() {
            add_menu_page(
                'ToDo Admin',       // Page title
                'ToDo Plugin',      // Menu title
                'manage_options',   // Capability
                'todo',             // Menu slug
                array(__CLASS__, 'display_admin_page'), // Function to display the page content
                'dashicons-admin-generic',  // Icon URL
            );
        }

        public static function display_admin_page() {
            include(TODO__PLUGIN_DIR . "templates/todo-admin.php");
        }

        public static function add_admin_style() {
            wp_enqueue_style('todo-admin-style', TODO__PLUGIN_DIR_URL . 'assets/admin-style.css');
        }

        public static function add_front_script() {
            wp_enqueue_script('todo-front-script', TODO__PLUGIN_DIR_URL . 'assets/todo-ajax.js', array('jquery'), null, true);

            wp_localize_script('todo-front-script', 'ajaxObj', array(
                'ajaxurl' => admin_url('admin-ajax.php'), // URL to admin-ajax.php
                'nonce' => wp_create_nonce('todo_nonce')
            ));
        }

        public static function display_todo_list() {
            ob_start();

            $template = locate_template('todo/templates/todo-front.php');
            if (!$template) {
                // If the custom template is not found, fall back to the plugin's default template
                $template = TODO__PLUGIN_DIR . 'templates/todo-front.php';
            }
            include($template);

            return ob_get_clean();
        }
    }
