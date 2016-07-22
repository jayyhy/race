<?php

/**
 * 这个类继承了 CFormModel ，为表单模型的派生类，封装了关于登陆的数据及业务逻辑
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LoginForm extends CFormModel
{    //表单模型
	public $username;      //用户名
	public $password;	   //密码
	public $rememberMe;		//记住密码
        public $usertype;       //用户种类
	private $_identity;     //身份

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	//rules方法中指定任何一条验证规则(验证规则是用于检查用户输入的数据)
	public function rules()
	{
		return array(
			// username and password are required
			array('usertype,username, password', 'required'),     //usertype,username 和 password 为必填项
			// rememberMe needs to be a boolean
			array('rememberMe', 'boolean'),       //rememberMe 应该是一个布尔值
			// password needs to be authenticated
			array('password', 'authenticate'),    //password 应被验证（authenticated）
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'rememberMe'=>'Remember me next time',
		);
	}

	/**
	 * Authenticates the password.
	 * This is the 'authenticate' validator as declared in rules().
	 */
	public function authenticate($attribute,$params)
	{	//当没有input errors时，一个UserIdentity的对象被创建，username、password被传入构造函数。Useridentity对象的authenticate()方法被调用
		if(!$this->hasErrors()){
                    $this->_identity=new UserIdentity($this->username,$this->password);
                    $this->_identity->setUserType($this->usertype);
                    if(!$this->_identity->authenticate()){
                        $this->addError('password','非法的用户名或密码.');     //添加错误消息
                    }
		}
	}

	/**
	 * Logs in the user using the given username and password in the model.
	 * @return boolean whether login is successful
	 */
	public function login()
	{
            if($this->_identity===null)
            {
                $this->_identity=new UserIdentity($this->username,$this->password);
                $this->_identity->setUserType($this->usertype);      //设置用户种类
                $this->_identity->authenticate();
            }
		if($this->_identity->errorCode===UserIdentity::ERROR_NONE)
		{
			$duration=$this->rememberMe ? 3600*24*30 : 0; // 30 days
			Yii::app()->user->login($this->_identity,$duration);     //调用Yii::app()->user->login()保存数据（session）
			
			$cookie = new CHttpCookie('usernamecookie',$this->username);     //用户名cookie
			$cookie->expire = time()+60*60*24*30; //有限期30天 
			Yii::app()->request->cookies['mycookie']=$cookie;
			
			$cookie = new CHttpCookie('usertypecookie',$this->usertype);     //用户类型cookie
			$cookie->expire = time()+60*60*24*30; //有限期30天
			Yii::app()->request->cookies['usertypecookie']=$cookie;
			
			if(!empty($this->rememberMe))
			{
				$cookie = new CHttpCookie('remcookie',$this->rememberMe);
				$cookie->expire = time()+60*60*24*30; //有限期30天
				Yii::app()->request->cookies['remcookie']=$cookie;
			}else {                                            //清空cookie
				$cookie=Yii::app()->request->getCookies();
				unset($cookie['remcookie']);
				$cookie=Yii::app()->request->getCookies();
				unset($cookie['mycookie']);
				$cookie=Yii::app()->request->getCookies();
				unset($cookie['usertypecookie']);
			}
			
			
			
			
			
			return true;
		}
		else
			return false;
	}
}
