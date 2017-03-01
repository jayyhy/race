<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//crt by LC 2015-4-9

class StudentController extends CController {

    public $layout = '//layouts/studentBar';

    protected function renderJSON($data) {
        header('Content-type: application/json');
        echo CJSON::encode($data);

        foreach (Yii::app()->log->routes as $route) {
            if ($route instanceof CWebLogRoute) {
                $route->enabled = false; // disable any weblogroutes
            }
        }
        Yii::app()->end();
    }

    //公告信息
    public function actionStuNotice() {
        $result = Notice::model()->findNotice();
        $noticeRecord = $result ['noticeLst'];
        $pages = $result ['pages'];
        $studentID = Yii::app()->session['userid_now'];
        $noticeS = Student::model()->findByPK($studentID);
        $noticeS->noticestate = '0';
        $noticeS->update();
        $this->render('stuNotice', array('noticeRecord' => $noticeRecord, 'pages' => $pages));
    }

    //公告内容
    public function ActionNoticeContent() {
        $result = 0;
        if (isset($_GET['action']) && $_GET['action'] == 'edit') {
            $result = 1;
        }
        $id = $_GET['id'];
        $noticeRecord = Notice::model()->find("id= '$id'");
        $this->render('noticeContent', array('noticeRecord' => $noticeRecord));
    }

    public function ActionIndex() {
        $userID = Yii::app()->session['userid_now'];
        $courseID = Student::model()->find("userID=?", array($userID))['classID'];
        Yii::app()->session['student_courseID'] = $courseID;
        $this->render('index');
    }
    public function ActionFristIndex() {
        $userID = Yii::app()->session['userid_now'];
        $courseID = Student::model()->find("userID=?", array($userID))['classID'];
        Yii::app()->session['student_courseID'] = $courseID;
        $showname = Yii::app()->session['userid_now'];
        $this->render('index',array('showname' => $showname));
    }

    public function ActionWaitForStart() {
        $this->renderPartial('waitForStart');
    }

    public function ActionAjaxHertBeatWaitForStart() {
        $timeNow = time();
        $courseID = Yii::app()->session['student_courseID'];
        $course = Course::model()->find("courseID=?", array($courseID));
        $startTime = strtotime($course['startTime']);
        $raceEndTime = strtotime($course['endTime']);
        $nowTime = time();
        if ($raceEndTime > $timeNow) {
            $this->renderJSON(array('nowTime' => $nowTime, 'startTime' => $startTime, 'raceID' => $course['onRaceID']));
        }
        echo 0;
    }

    public function actionRace() {
        $userID = Yii::app()->session['userid_now'];
        $render = "";
        $raceID = $_GET['raceID'];
        $race = Race::model()->find("raceID=?", array($raceID));
        $step = $race['step'];
        $course = Course::model()->find("onRaceID=?", array($raceID));
        $EndTime = strtotime($course['endTime']);
        $startTime = strtotime($course['startTime']);
        $lastRaceIDForStepFour = 0;
        $route = AnswerRecord::model()->find("studentID=? AND raceID=?", array($userID, $raceID));
        $route = $route['recovery'];
        switch ($step) {
            case 1:
                $render = "One";
                break;
            case 2:
                $render = "Two";
                break;
            case 3:
                $render = "Three";
                break;
            case 4:
//                $allRace = Race::model()->findAll("indexID=?", array($race['indexID']));
//                foreach ($allRace as $v) {
//                    if ($v['step'] == 3) {
//                        $lastRaceIDForStepFour = $v['raceID'];
//                    }
//                }
                $render = "Four";
                break;
            case 5:
                $render = "Five";
                break;
            case 6:
                $render = "Six";
                break;
        }
        $this->renderPartial("race" . $render, array("race" => $race, "endTime" => $EndTime, "startTime" => $startTime, 
            "route" => $route   
            ));
    }
    
    public function saveInRealTime(){
        
    }

    public function actionOver() {
        $userID = Yii::app()->session['userid_now'];
        $raceID = $_POST['raceID'];
        $content = $_POST['content'];
        if(isset($_POST['rate'])){
        $rate = $_POST['rate'];
        }
        else{
        $rate = 0;
        }
        $step32 = Race::model()->find('raceID=?',array($raceID));
        $courseID = Student::model()->find("userID=?",array($userID))['classID'];
        $data = AnswerRecord::model()->submitRace($userID, $raceID, $content,$courseID,$rate);
        if($step32['step']==32){
            $raceID = Race::model()->find('indexID=? AND step=?',array($step32['indexID'],3))['raceID'];
            AnswerRecord::model()->submitRace2($userID, $raceID, $content,$courseID,$rate);
        }
        echo $data;
    }

    public function actionAcceptTime(){
        $userID = Yii::app()->session['userid_now'];
        $raceID = $_POST['raceID'];
        $content ="";
        $courseID = Student::model()->find("userID=?",array($userID))['classID'];
        $data = AnswerRecord::model()->submitRace($userID, $raceID, $content,$courseID);
    }
    public function actionSaveroute(){
    $route=$_POST['route'];
    $raceID = $_POST['raceID'];
    $userID = Yii::app()->session['userid_now'];
    AnswerRecord::model()->saveroute($route,$raceID,$userID);
    }
    //sscc是实时存储函数  杨堂堂2017-1-23
    public function actionSscc(){
        $userID = Yii::app()->session['userid_now'];
        $raceID = $_POST['raceID'];
        $content = $_POST['content'];
        $route = $_POST['route'];
        $courseID = Student::model()->find("userID=?",array($userID))['classID'];
        $data = AnswerRecord::model()->ssccing($userID, $raceID, $content,$courseID,$route);
        echo $data;
    }
    }
