<?php
/**
 * Created by PhpStorm.
 * Date: 3/19/19
 * Time: 10:29 AM
 */

require_once __DIR__ . '/database.php';
require_once __DIR__ . '/generic-utils.php';
require_once ('output-utils.php');
class UserUtils {

    static function add_user($name,$display_name,$email,$password){
        $db = DatabaseUtils::get_connection();
        try{
            $stmt = $db->prepare( 'INSERT INTO users (name, display_name, email, password) VALUES (:name, :display_name, :email, :password)' );
            $params = array(
                ':name'=>$name,
                ':display_name'=>$display_name,
                ':email'=>$email,
                ':password'=>$password
            );
            $stmt->execute($params);
            //$user_id = $db->lastInsertId();
            return true;
        }
        catch(PDOException $e)
        {
            echo $stmt . "<br>" . $e->getMessage();
        }
    }
    static function check_display_name_availibility($display_name){
        $db = DatabaseUtils::get_connection();
        try{
            $stmt = $db->prepare( 'SELECT * FROM users WHERE display_name=:display_name;');
            $stmt->execute(array(':display_name'=>$display_name));
            if($stmt->rowCount()>0)
                return false;

            return true;
        }
        catch(PDOException $e)
        {
            echo $stmt . "<br>" . $e->getMessage();
        }
    }
    static function check_email_availibility($email){
        $db = DatabaseUtils::get_connection();
        try{
            $stmt = $db->prepare( 'SELECT * FROM users WHERE email=:email;');
            $stmt->execute(array(':email'=>$email));
            if($stmt->rowCount()>0)
                return false;

            return true;
        }
        catch(PDOException $e)
        {
            echo $stmt . "<br>" . $e->getMessage();
        }
    }
    static function getPossiblePermissions() {
        // return a pre-defined array
        return array('write_post', 'edit_post', 'publish_post', 'moderate_comments');
    }
}

class SessionUtils {
    /**
     * @param $username
     * @param $password
     * @return bool or array --- this function will return the user's row if successful, otherwise FALSE 
     * @throws Exception
     */
    static function username_password_check($username, $password) {
        $db = DatabaseUtils::get_connection();
        try{
            // Check username/email
            $stmt = $db->prepare('SELECT * FROM users WHERE email=:username OR display_name=:username');
            $stmt->execute(array(':username'=>$username));
            if ($stmt->rowCount()==0) {
                return false;
            }
        }catch(PDOException $e)
        {
            echo $stmt . "<br>" . $e->getMessage();
        }
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check password validity
        $hash = $row['password'];
        if (!password_verify($password, $hash))
            return false;
        // All is well; return user info
        return $row;
    }
    
    
    /*
     *  user_sessions table in db needed
     *  - session_id INT auto_increment
     *  - user_id       INT
     *  - session_ip    VARCHAR(100)
     *  - session_code  VARCHAR(255)
     *  - is_valid=0|1  TINYNIT
     *  - create_time   INT
     *  - expire_time   INT
     */


    static $user_info = null;
   // static $user_permissions = null;

    static function generate_session_code() {
        return GenericUtils::secure_random_string(100);
    }
    
    static function create_session($user_id,$display_name) {
        // Example: clear all other sessions for this user...
        // $stmt = $db->prepare('UPDATE user_sessions SET is_valid=0 WHERE user_id=:user_id'); $stmt->execute(array(':user_id'=>$user_id));

        // Create session in db
        $session_code = self::generate_session_code();
        $session_ip = $_SERVER['REMOTE_ADDR'];
        $time = time();
        $expire_time = $time + 86400*365;
        $db = DatabaseUtils::get_connection();
        $stmt = $db->prepare('INSERT INTO user_sessions (user_id, session_ip, session_code, is_valid, create_time, expire_time) VALUES (:user_id, :session_ip, :session_code, :is_valid, :create_time, :expire_time)');
        $stmt->execute(array(
            ':user_id'=>$user_id,
            ':session_ip'=>$session_ip,
            ':session_code'=>$session_code,
            ':is_valid'=>1,
            ':create_time'=>$time,
            ':expire_time'=>$expire_time
        ));
        // Create session cookie
        setcookie('app_session_code', $session_code, $expire_time, '/');
    }

    static function check_user_login_status() {
        // Check for cookie
        $session_code = @$_COOKIE['app_session_code'];
        if (!$session_code)
            return false;

        // Check in the database for valid session
        $db = DatabaseUtils::get_connection();
        $stmt = $db->prepare('SELECT user_id FROM user_sessions WHERE session_code=:session_code AND is_valid=1 AND expire_time>:current_time');
        $stmt->execute(array(
            ':session_code'=>$session_code,
            ':current_time'=>time(),
        ));
        if ($stmt->rowCount()==0)
            return false;

        // We seem to have valid session...
        $session_row = $stmt->fetch(PDO::FETCH_ASSOC);
        $user_id = $session_row['user_id'];
        $stmt = $db->prepare('SELECT name, display_name, email FROM users WHERE user_id=:user_id');
        $stmt->execute(array(':user_id'=>$user_id));
        if ($stmt->rowCount()==0)
            return false; // orphaned user session
        $user_row = $stmt->fetch(PDO::FETCH_ASSOC);

        // example: retrieve permissions/role info here, include that in the $user_row output.
        self::$user_info = $user_row;
        // self::$user_permissions = array('editor', 'subscriber', 'admin');

        return $user_row;
    }

    // exercise: create a `SessionUtils::user_has_permission($permission)` function.
    static function user_has_permissions($permission,$user_id){
        $db = DatabaseUtils::get_connection();
        $stmt = $db->prepare('SELECT permission FROM permissions WHERE user_id=:user_id');
        $stmt->execute(array(':user_id'=>$user_id));
        $permissions=$stmt->fetchAll(PDO::FETCH_ASSOC);
        if(array_search($permission,$permissions))
            return true;
        //User has permissions
        return false;
    }
    /*
     * example: dashboard.php
     *  $user_info = SessionUtils::check_user_login_status();
     *  if ($user_info===false) {
     *      header('Location: login.php?error=invalid_session');
     *      exit;
     *  }
     *
     *  // User is valid!
     *  echo 'hi there, ' . $user_info['name'] . '!';
     *
     */
    static function user_permissions($user_id){
        $db = DatabaseUtils::get_connection();
        $stmt = $db->prepare('SELECT permission FROM permissions WHERE user_id=:user_id');
        $stmt->execute(array(':user_id'=>$user_id));
        $permissions=$stmt->fetchAll(PDO::FETCH_ASSOC);
        if(!$permissions)
            return false;
        //User has permissions
        return $permissions;
    }
    static function users_list(){
        $db = DatabaseUtils::get_connection();
        $stmt = $db->prepare('SELECT user_id,NAME,display_name,email FROM users;');
        $stmt->execute();
        if(!$stmt->rowCount()){
            OutputUtils::note_display_error('No users are there',1);
            return false;
        }
        $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    static function get_user_details($user_name){
        $db = DatabaseUtils::get_connection();
        $stmt = $db->prepare('SELECT user_id,NAME,display_name,email FROM users WHERE user_id=:user_name OR display_name=:user_name OR email=:user_name;');
        $stmt->execute(array(':user_name'=> $user_name));
        if($stmt->rowCount()==0){
            OutputUtils::note_display_error('No Such User found');
            return false;
        }
        $result=$stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
}?>