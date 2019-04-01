<?php
/**
 * Created by PhpStorm.
 * Date: 3/19/19
 * Time: 10:33 AM
 */

class OutputUtils {
    
    static $display_errors = array();
    
    static function note_display_error($message, $priority=0) {
        self::$display_errors[] = array('message'=>$message, 'priority'=>$priority);
    }
    
    static function errors_exist() {
        return count(self::$display_errors) > 0;
    }
    
    static function get_display_errors() {
        return self::$display_errors;
    }

    // Ajax response utils

    static function writeAjaxSuccess($message, $data = null) {
        header('Content-Type: application/json');
        echo json_encode(array('valid'=>true, 'message'=>$message, 'data'=>$data));
        exit();
    }

    static function writeAjaxError($message) {
        header('Content-Type: application/json');
        echo json_encode(array('valid'=>false, 'message'=>$message, 'data'=>null));
        exit();
    }
    
}