<?php
class IndexController extends Controller{
    public function actionIndex(){
        if (Yii::app()->session['role_now'] == 'student') {
            $this->redirect('./index.php?r=student/index');
        } else if(Yii::app()->session['role_now'] == 'teacher'){
            $this->redirect('./index.php?r=teacher/index');
        }else if(Yii::app()->session['role_now'] == 'admin'){
            $this->redirect('./index.php?r=admin/index');
        }
    }
       public function actionTeacher(){
        $this->render('teacher');
    }
}

