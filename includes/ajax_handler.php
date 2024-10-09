<?php
    namespace ToDoPlugin;
    
    use ToDoPlugin\DbSerializer;

    class AjaxHandler {
        public static function listen() {
            add_action('wp_ajax_list_todo', array( self::class, 'list_todo_callback' ));
            add_action('wp_ajax_nopriv_list_todo', array( self::class, 'list_todo_callback' ));

            add_action('wp_ajax_add_todo', array( self::class, 'add_todo_callback' ));
            add_action('wp_ajax_nopriv_add_todo', array( self::class, 'add_todo_callback' ));
        }
    
        public static function list_todo_callback() {
            if (!isset($_GET['nonce']) || !wp_verify_nonce($_GET['nonce'], 'todo_nonce')) {
                wp_send_json_error('Nonce verification failed');
            }
    
            $tasks = DbSerializer::getAllTasks();
            $res = [];
            foreach ( $tasks as $task ) {
                $res[] = [
                    "id" => $task->id,
                    "title" => $task->title,
                    "status" => $task->status,
                ];
            }

            wp_send_json_success($res);
            wp_die();
        }

        public static function add_todo_callback() {
            if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'todo_nonce')) {
                wp_send_json_error('Nonce verification failed');
            }
    
            DbSerializer::addTask($_POST);

            wp_send_json_success(array("success" => true));
            wp_die();
        }
    }
