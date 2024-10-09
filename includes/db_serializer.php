<?php
    namespace ToDoPlugin;
    
    global $wpdb;
    DbSerializer::$table_name = $wpdb->prefix . 'todo';

    class DbSerializer {
        public static $table_name;

        public static function createTable() {
            global $wpdb;       
            $charset_collate = $wpdb->get_charset_collate();
            $table_name = self::$table_name;

            $sql = "CREATE TABLE $table_name (
                id INT NOT NULL AUTO_INCREMENT,
                title varchar(50) NOT NULL,
                status varchar(10) NOT NULL,
                PRIMARY KEY  (id)
            ) $charset_collate;";

            require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
            dbDelta( $sql );
        }

        public static function dropTable() {
            global $wpdb;
            $table_name = self::$table_name;

            $wpdb->query( "DROP TABLE IF EXISTS $table_name" );
        }

        public static function addTask($_post) {
            global $wpdb;

            $wpdb->insert(self::$table_name, array('title' => $_post['title'], 'status' => $_post['status']), array("%s", "%s"));
        }

        public static function getAllTasks() {
            global $wpdb;
            $table_name = self::$table_name;

            return $wpdb->get_results("SELECT * from $table_name");
        }
    }
