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

    public function getStuLstByClassID($classID){
        $sql = "SELECT * FROM student WHERE classID = ".$classID;
        $result = Tool::pager($sql, 10);
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
        $studentNumber = Tool::getStudentLimitNumber();
        for($i=1;$i<=$studentNumber;$i++){
            $student = new Student();
            $var=sprintf("%03d", $i);
            $id = "GS".$courseID.$var;
            $student->userName = $id;
            $student->userID = $id;
            $student->password = md5("000");
            $student->classID = $courseID;
            $student->insert();
        }
    }
    public function getStudent($classID) {
        $sql = "SELECT * FROM student where classID ='$classID' ";
        $Allresult = Tool::pager($sql, 1000);
        return $Allresult;   
    }
    
}
