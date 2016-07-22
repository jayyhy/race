<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
    /**
     * Authenticates a user.
     * The example implementation makes sure if the username and password
     * are both 'demo'.
     * In practical applications, this should be changed to authenticate
     * against some persistent user identity storage (e.g. database).
     * @return boolean whether authentication succeeds.
     */
    
    protected $_userid;
    protected $_usertype;
    
    /*
    public function __construct ($usertype, $username, $password) {
        $this->$usertype = $usertype;
        //$this->$username = $username;
        //$this->$password = $password;
    }
     * 
     */

    public function setUserType($userType) {
        $this->_usertype = $userType;
    }
    
    
    public function authenticate(){
        $user;
        if ($this->_usertype === 'student') {
            $user = Student::model()->find('userID=?', array($this->username));
            if($user === null){
                $this->errorCode=self::ERROR_USERNAME_INVALID;
            }elseif($user->password !== md5($this->password)){                 //先不使用MD5加密
                $this->errorCode=self::ERROR_PASSWORD_INVALID;
            }else{
                $this->errorCode=self::ERROR_NONE;
                $this->_userid = $user->userID;
            }
        } else if ($this->_usertype === 'teacher') {
            $user = Teacher::model()->find('userID=?', array($this->username));
            if($user === null){
                $this->errorCode=self::ERROR_USERNAME_INVALID;
            }elseif($user->password !== md5($this->password)){                 //先不使用MD5加密
                $this->errorCode=self::ERROR_PASSWORD_INVALID;
            }else{
                $this->errorCode=self::ERROR_NONE;
                $this->_userid = $user->userID;
            }
        }else if ($this->_usertype === 'admin') {
            $user = Admin::model()->find('userID=?', array($this->username));
            if($user === null){
                $this->errorCode=self::ERROR_USERNAME_INVALID;
            }elseif($user->password !== md5($this->password)){                 //先不使用MD5加密
                $this->errorCode=self::ERROR_PASSWORD_INVALID;
            }else{
                $this->errorCode=self::ERROR_NONE;
                $this->_userid = $user->userID;
            }
        }
        //echo $this->_usertype;
        return !$this->errorCode;
    }

 
  function getId(){
     return $this->_userid;
 }
 
 
}