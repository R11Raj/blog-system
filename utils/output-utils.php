<?php
/**
 * Created by PhpStorm.
 * Date: 3/19/19
 * Time: 10:33 AM
 */

class OutputUtils {
    
    static $display_errors = array();
    static $page_mode='';
    static function note_display_error($message, $priority=0) {
        self::$display_errors[] = array('message'=>$message, 'priority'=>$priority);
    }
    
    static function errors_exist() {
        return count(self::$display_errors) > 0;
    }
    
    static function get_display_errors() {
        return self::$display_errors;
    }

    static function get_page_mode(){
        return self::$page_mode;
    }

    static function set_page_mode($mode){
        self::$page_mode=$mode;
    }
}
?>