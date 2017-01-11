<?php

class UserController extends Controller {

    public function actionUpdatePassword() {      //重置密码
        $result = 'no';
        if (isset($_POST['new1'])) {
            $new1 = $_POST['new1'];
            $defnew = $_POST['defnew'];
            $type = $_GET['type'];
            if ($type == '0')
                $user = Student::model()->find('userID=?', $_GET['userid']);
            else if ($type == '1')
                $user = Teacher::model()->find('userID=?', $_GET['userid']);
            else if ($type == '2')
                $user = Teacher::model()->find('userID=?', $_GET['userid']);
            if ($user) {
                $m = $new1;
                $user->password = md5($new1);
                $result = $user->update();
            } else {
                $result = '0';
            }
            $this->render('forgetpassword', ['result' => $result]);
            return;
        }

        $this->render('updatepassword', ['result' => $result, 'userid' => $_GET['userid'], 'type' => $_GET['type']]);
    }

    public function actionForgetPassword() {     //忘记密码
        $result = 'no';
        $account = '0';
        $type = '0';
        if (isset($_POST['account'])) {
            $account = $_POST['account'];
            $email = $_POST['email'];

            $user = Student::model()->find("userName ='$account'");

            if ($user == null) {
                $type = '1';
                $user = Teacher::model()->find("userName ='$account'");
            }
            if ($user == null) {
                $type = '2';
                $user = Admin::model()->find("userName ='$account'");
            }
            $userid = $user['userID'];

            if ($user != null) {
                if ($user['mail_address'] !== $email) {
                    $result = "email error";
                    $this->render('forgetpassword', ['result' => $result]);
                    return;
                }
                $this->render('updatepassword', ['userid' => $userid, 'type' => $type]);
                return;
            }
        }
        $this->render('forgetpassword', ['result' => $result]);
    }

    protected function setuser(&$login_model) {
        $login_model->attributes = $_POST['LoginForm'];
        if ($login_model->validate() && $login_model->login()) {  //用户名密码session持久化
            $username_now = strtoupper($login_model->username);
            $role_now = $login_model->usertype;
            if ($role_now === 'teacher') {
                $user = (new Teacher())->find("userid='$username_now'");
                $userName = $user->userName;
                Yii::app()->session['userName'] = $userName;
                Yii::app()->session['userid_now'] = $username_now;
                Yii::app()->session['role_now'] = $role_now;
                $this->redirect(['/teacher/raceLst']);
            } else if ($role_now === 'student') {
                $user = (new Student())->find("userid='$username_now'");
                $userName = $user->userName;
                Yii::app()->session['userName'] = $userName;
                Yii::app()->session['userid_now'] = $username_now;
                Yii::app()->session['role_now'] = $role_now;
                $this->redirect(['/student/fristindex']);
            } else if ($role_now === 'admin') {
                $user = (new Admin())->find("userid='$username_now'");
                $userName = $user->userName;
                Yii::app()->session['userName'] = $userName;
                Yii::app()->session['userid_now'] = $username_now;
                Yii::app()->session['role_now'] = $role_now;
                $this->redirect(['/admin/index']);
            }
        }
    }

    public function actionLogin() {
        Yii::app()->session['cfmLogin']=0;
        $login_model = new LoginForm;
        //返回错误内容
        $result = 'no';
        //标记:是否进入账号密码判断逻辑
        $flag = 0;
        if (isset($_POST['LoginForm'])) {
            $userID = $_POST['LoginForm']['username'];
            if ($_POST['LoginForm']['usertype'] == 'teacher') {
                $teacher = Teacher::model()->find("userID = '$userID'");
            } else if ($_POST['LoginForm']['usertype'] == 'student') {
                $student = Student::model()->find("userID = '$userID'");
            }
            if ($flag == 0) {
                $this->setuser($login_model);
            }if ($flag == 1) {
                $result = '此账号已被冻结，请与管理员联系！';
            }if ($flag == 2) {
                $result = '此账号已在别处登录！';
            }
        }
        if (isset($_GET['exit']) && isset($_GET['usertype'])) {
            $userID = Yii::app()->session['userid_now'];
            $this->clearTrace();
        }
        if (!Tool::mainLoginIn()) {
            if (isset($_GET['flag'])) {
                $flag = $_GET['flag'];
                Tool::mainLoginRe($flag);
                $this->renderPartial('error', ['ok' => 'ok']);
            }
            $this->renderPartial('error');
        } else {
            $this->renderPartial('login', array('login_model' => $login_model, 'result' => $result));
        }
    }

    public function actionHideMenu() {
        //记住菜单栏状态
        if (isset($_POST['menuState']))
            Yii::app()->session['menuState'] = $_POST["menuState"];
    }

    protected function clearTrace() {
        Yii::app()->session->clear();
        Yii::app()->session->destroy();
    }

}
