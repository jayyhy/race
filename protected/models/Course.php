<?php

/**
 * This is the model class for table "course".
 *
 * The followings are the available columns in table 'course':
 * @property integer $courseID
 * @property string $createTime
 * @property string $name
 */
class Course extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'course';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('createTime, name', 'required'),
            array('name', 'length', 'max' => 30),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('courseID, createTime, name', 'safe', 'on' => 'search'),
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
            'courseID' => 'Course',
            'createTime' => 'Create Time',
            'name' => 'Name',
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

        $criteria->compare('courseID', $this->courseID);
        $criteria->compare('createTime', $this->createTime, true);
        $criteria->compare('name', $this->name, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function getAllLst() {
        $sql = "SELECT * FROM course";
        $result = Tool::pager($sql, 1);
        return $result;
    }

    public function getAllLstDesc() {
        $sql = "SELECT * FROM course ORDER BY courseID DESC";
        $result = Yii::app()->db->createCommand($sql)->query();
        foreach ($result as $k => $v) {
            if ($k === 0) {
                $re = $v;
            }
        }
        return $re;
    }

    public function addRaceCourse($courseName) {
        $course = new Course();
        $course->name = $courseName;
        $course->createTime = date("Y-m-d  H:i:s");
        $course->insert();
    }

    public function startRace($raceID, $teacherID,$CDTime) {
        $courseID = Teacher::model()->find("userID=?", array($teacherID))['classID'];
        $course = Course::model()->find("courseID=?", array($courseID));
        $step = Race::model()->find("raceID=?", array($raceID))['step'];
        if($step == 3){
            $indexID = Race::model()->find("raceID=?", array($raceID))['indexID'];
            $currentTime2 = Race::model()->find("indexID=? AND step=?", array($indexID,32))['time'];
            $currentTime = Race::model()->find("raceID=?", array($raceID))['time'];
            $currentTime = $currentTime + $currentTime2;
            $startTime = date("Y-m-d  H:i:s",time()+$CDTime);
            $endTime = date("Y-m-d  H:i:s", (time()+$CDTime + ($currentTime))); 
        }  else {
            $currentTime = Race::model()->find("raceID=?", array($raceID))['time'];
            $startTime = date("Y-m-d  H:i:s",time()+$CDTime);
            $endTime = date("Y-m-d  H:i:s", (time()+$CDTime + ($currentTime))); 
        }      
        $course->startTime = $startTime;
        $course->onRaceID = $raceID;
        $course->endTime = $endTime;
        $course->update();
    }

     public function isOpen($teacherID){
            $courseID = Teacher::model()->find("userID=?",array($teacherID))['classID'];
            $course = Course::model()->find("courseID=?",array($courseID));
            if($course['onRaceID']!=0){
                return $course['endTime'];
            }else{
                return 0;
            }
        }

    public function overRace($teacherID) {
        $courseID = Teacher::model()->find("userID=?", array($teacherID))['classID'];
        $course = Course::model()->find("courseID=?", array($courseID));
        $course->onRaceID = 0;
        $course->startTime = null;
        $course->endTime = null;
        $course->update();
    }
    
    public function getNowOnStep($teacherID){
        $courseID = Teacher::model()->find("userID=?", array($teacherID))['classID'];
        $course = Course::model()->find("courseID=?", array($courseID));
        $race = Race::model()->find("raceID=?", array($course['onRaceID']));
        return $race['step'];
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Course the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
