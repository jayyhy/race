<?php

/**
 * This is the model class for table "student".
 *
 * The followings are the available columns in table 'student':
 * @property string $userID
 * @property string $userName
 * @property string $password
 * @property String $mail_address
 * @property string $classID
 * @property string $sex
 * @property string $age
 * @property string $mail_address
 * @property string $phone_number
 */
class Student extends CActiveRecord {

    //会彻底删除该学生的所有记录，谨慎使用
    /**
     * 
     * @param type $userID 要删除的学生的ID
     */
    public function delStuRes($userID) {
        AnswerRecord::model()->deleteAll('createPerson = ?', array($userID));
        ExamRecord::model()->deleteAll('studentID = ?', array($userID));
        SuiteRecord::model()->deleteAll('studentID = ?', array($userID));
    }

    public function insertStu($userID, $userName, $sex, $age, $pass, $mail_address, $phone_number, $classID) {
        $newStu = new Student();
        $newStu->userID = strtoupper($userID);
        $newStu->userName = $userName;
        $newStu->sex = $sex;
        $newStu->age = $age;
        $newStu->password = md5($pass);
        $newStu->mail_address = $mail_address;
        $newStu->phone_number = $phone_number;
        $newStu->classID = $classID;
        $oldstu = Student::model()->findAll("userID = '$userID'");
        if (count($oldstu) > 0)
            return 'no';
        else
            return $newStu->insert();
    }

    public function getStuLst($type, $value) {
        $order = " order by userID ASC";
        if ($type != "" && $type != "is_delete")
            $condition = " WHERE $type = '$value' AND is_delete = 0";
        else if ($type == "is_delete")
            $condition = " WHERE is_delete = 1";
        else
            $condition = " WHERE is_delete = 0";
        $select = "SELECT * FROM student";
        $sql = $select . $condition . $order;
        $criteria = new CDbCriteria();
        $result = Yii::app()->db->createCommand($sql)->query();
        $pages = new CPagination($result->rowCount);
        $pages->pageSize = 10;
        $pages->applyLimit($criteria);
        $result = Yii::app()->db->createCommand($sql . " LIMIT :offset,:limit");
        $result->bindValue(':offset', $pages->currentPage * $pages->pageSize);
        $result->bindValue(':limit', $pages->pageSize);
        $stuLst = $result->query();
        return ['stuLst' => $stuLst, 'pages' => $pages,];
    }
    
    public function getForbidStuByClass($classID){
        $order = " order by userID ASC";
        $condition = " WHERE forbidspeak=1 and classID=".$classID;
        $select = "SELECT * FROM student";
        $sql = $select . $condition . $order;
        $criteria = new CDbCriteria();
        $result = Yii::app()->db->createCommand($sql)->query();
        $pages = new CPagination($result->rowCount);
        $pages->pageSize = 5;
        $pages->applyLimit($criteria);
        $result = Yii::app()->db->createCommand($sql . " LIMIT :offset,:limit");
        $result->bindValue(':offset', $pages->currentPage * $pages->pageSize);
        $result->bindValue(':limit', $pages->pageSize);
        $stuLst = $result->query();
        return ['stuLst' => $stuLst, 'pages' => $pages,];
        
    }

    public function findClassByStudentID($studentID) {
        $student = $this->find("userid = '$studentID'");
        return $student['classID'];
//    }
//    public function getAnswerRecordAll($suiteID){
//        $userID = Yii::app()->session['userid_now'];
//        foreach (Tool::$EXER_TYPE as $type) {
//            switch ($type) {
//                case 'choice':
//                    $result['choice']['0']['title'] = '选择题';
//                    break;
//                case 'filling':
//                    $result['filling']['0']['title'] = '填空题';
//                    break;
//                case 'question':
//                    $result['question']['0']['title'] = '问答题';
//                    break;
//                default:
//                    $exerAll = Suite::model()->getSuiteExerByType( $suiteID, $type);
//                    foreach ($exerAll as $row) {
//                        $result[$type][$row['exerciseID']]['title'] = $row['title'];
//                        $record = SuiteRecord::model()->find('suiteID=? and studentID=?',[$suiteID,$userID]);
//                        $theAns = AnswerRecord::getAnswerID($record->recordID, $type, $row['exerciseID']);
//
//                        if($theAns == NULL){
//                            //echo '************************************************';
//                            //echo $record->recordID;
//                            //echo $type;
//                            //echo $row['exerciseID'];
//                            $result[$type][$row['exerciseID']]['accomplish'] = 0;
//                            $result[$type][$row['exerciseID']]['correct'] = 0;
//                        } else{
//                            $result[$type][$row['exerciseID']]['accomplish'] = $theAns->ratio_accomplish;
//                            $result[$type][$row['exerciseID']]['correct'] = $theAns->ratio_correct;
//                        }
//                    }
//                    break;
//            }
//        }
        //recordID, exerciseID, type




        return $result;
    }

    public function getAnswerRecordSub() {
        $type = Yii::app()->session['type'];
        $allClasswork = SuiteRecord::getClassworkAll($type);
        $result = array();
        foreach ($allClasswork as $classworkOne) {
            $suiteID = $classworkOne['suiteID'];
            $theSuite = Suite::model()->find('suiteID=?', array($suiteID));
            $result["$suiteID"]['recordID'] = $classworkOne['recordID'];
            $result["$suiteID"]['suiteName'] = $theSuite->suiteName;
            $result["$suiteID"]['accomplish'] = $this->getAccomplish($suiteID);
            $result["$suiteID"]['correct'] = $this->getCorrect($suiteID);
            //echo $result["$suiteID"]['suiteName'];
            //echo $suiteID;
        }
        return $result;
    }

    protected function getAccomplish($suiteID) {
        /*
          $exerNum = Suite::model()->getExerNum($suiteID);
          $answerNum = AnswerRecord::model()->getAnswerNum($suiteID);
          $exerSum = 0;
          $answerSum = 0;
          foreach (Tool::$EXER_TYPE as $type) {
          $exerSum += $exerNum[$type];
          $answerSum +=$answerNum[$type];
          }
          return $answerSum / $exerSum;

         * 
         */
        //改用直接查询数据库。。。
        $userID = Yii::app()->session['userid_now'];
        $record = SuiteRecord::model()->find('suiteID=? and studentID=?', array($suiteID, $userID));
        return $record == NULL ? 0 : $record->ratio_accomplish;
    }

    protected function getCorrect($suiteID) {
        /*
          $answerCorrect = AnswerRecord::model()->getAnswerCorrect($suiteID);
          $ratioSum = 0;
          //print_r($answerCorrect);
          foreach (Tool::$EXER_TYPE as $type) {
          if(isset($answerCorrect[$type])){
          foreach ($answerCorrect[$type] as $ratio){
          $ratioSum += $ratio;
          }
          }
          }
          $exerNum = Suite::model()->getExerNum($suiteID);
          $exerSum = 0;
          foreach (Tool::$EXER_TYPE as $type) {
          $exerSum += $exerNum[$type];
          }
          return $ratioSum / $exerSum;
         * 
         * 同样，直接改成查询数据库
         */
        $userID = Yii::app()->session['userid_now'];
        $record = SuiteRecord::model()->find('suiteID=? and studentID=?', array($suiteID, $userID));
        return $record == NULL ? 0 : $record->ratio_correct;
    }

//    public function getAnswerRecordByType($type){
//        //返回页面progress需要的某题型所有信息,根据题型。type = listen 、look、key、knlg
//        $allClasswork = SuiteRecord::getClassworkAll();
//        foreach ($allClasswork as $classwork){
//            $recordID = $classwork['recordID'];
//            $suiteID = $classwork['suiteID'];
//            $exerAll = Suite::model()->getSuiteExerByType( $suiteID, $type);
//            foreach ($exerAll as $exer){
//                $exerID = $exer['exerciseID'];
//                $result["$suiteID"]["$type"]["$exerID"]['title'] = $exer['title'];
//                
//                echo '$recordID='.$recordID.' ';
//                echo '$type='.$type.' ';
//                echo '$exerID='.$exerID.' ';
//                echo "\n";
//                //for debug
//                 
//                $answer = AnswerRecord::getAnswer($recordID, $type, $exerID);
//                if($answer == NULL){
//                    $result["$suiteID"]["$type"]["$exerID"]['accomplish'] = 0;
//                    $result["$suiteID"]["$type"]["$exerID"]['correct'] = 0;
//                } else {
//                    $result["$suiteID"]["$type"]["$exerID"]['accomplish'] = $answer -> ratio_accomplish;
//                    $result["$suiteID"]["$type"]["$exerID"]['correct'] = $answer -> ratio_correct;
//                }
//            }
//        }
//        //$result['exer'] = get
//        return $result;
//    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'student';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('userID, userName, password, classID,mail_address', 'required'),
            array('userID, userName, password, classID,mail_address', 'length', 'max' => 30),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('userID, userName, password, classID,mail_address', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'userID' => 'User',
            'userName' => 'User Name',
            'password' => 'Password',
            'mail_address' => 'mail_address',
            'classID' => 'Class',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('userID', $this->userID, true);
        $criteria->compare('userName', $this->userName, true);
        $criteria->compare('password', $this->password, true);
        $criteria->compare('mail_address', $this->mail_address, true);
        $criteria->compare('classID', $this->classID, true);
        $criteria->compare('sex', $this->sex, true);
        $criteria->compare('age', $this->age, true);
        $criteria->compare('mail_address', $this->mail_address, true);
        $criteria->compare('phone_number', $this->phone_number, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public static function isLogin($userID,$login){
        $student = new Student();
        $student = $student->find("userID = '$userID'");
        $student->is_login = $login;
        $result = $student->update();
        return $result;
    }
    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Student the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function addRaceStudent($courseID){
        for($i=1;$i<=Tool::$studentNumber;$i++){
            $student = new Student();
            $var=sprintf("%03d", $i);
            $id = "GS".$var."C".$courseID;
            $student->userName = $id;
            $student->userID = $id;
            $student->password = md5("000");
            $student->classID = $courseID;
            $student->insert();
        }
    }
    
    public function findStudentByClass($classID){
        $student = new Student();
        $student = $student->findAll("classID='$classID'");
        return $student;
    }

}
