<?php

/**
 * This is the model class for table "race".
 *
 * The followings are the available columns in table 'race':
 * @property integer $raceID
 * @property integer $indexID
 * @property integer $step
 * @property string $content
 * @property integer $score
 * @property integer $time
 * @property integer $resourseID
 * @property string $fileName
 */
class Race extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'race';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('indexID, step, raceName, content, score, time, resourseID, fileName', 'required'),
            array('indexID, step, score, time, resourseID', 'numerical', 'integerOnly' => true),
            array('fileName','raceName', 'length', 'max' => 30),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('raceID, indexID, step, raceName, content, score, time, resourseID, fileName,is_over', 'safe', 'on' => 'search'),
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
            'raceID' => 'Race',
            'indexID' => 'Index',
            'step' => 'Step',
            'raceName' =>'Race Name',
            'content' => 'Content',
            'score' => 'Score',
            'time' => 'Time',
            'resourseID' => 'Resourse',
            'fileName' => 'File Name',
            'is_over' => 'Is_over',
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

        $criteria->compare('raceID', $this->raceID);
        $criteria->compare('indexID', $this->indexID);
        $criteria->compare('step', $this->step);
        $criteria->compare('step', $this->raceName);
        $criteria->compare('content', $this->content, true);
        $criteria->compare('score', $this->score);
        $criteria->compare('time', $this->time);
        $criteria->compare('resourseID', $this->resourseID);
        $criteria->compare('fileName', $this->fileName, true);
        $criteria->compare('is_over', $this->fileName, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
    
    public function stepName($step){
        if($step == "0"){
            $i="试音";
            return $i;
        }
        if($step=='1'){
            $i="文字校对";
            return $i;
        }else if($step=='2'){
            $i="文本速录";
            return $i;
        }else if($step=='3'){
            $i="实时速录";
            return $i;
        }else if($step=='4'){
            $i="会议公文整理";
            return $i;
        }else if($step=='5'){
            $i="蒙目速录";
            return $i;
        }else if($step=='6'){
            $i="模拟办公管理";
            return $i;
        }        
    }

    public function addRace($indexID, $step, $raceName, $content, $score, $time, $resourceID, $fileName) {
        $stepName=  Race::model()->stepName($step);
        $teacherID = Yii::app()->session['userid_now'];
        $classID = Teacher::model()->find("userID=?", array($teacherID))['classID'];
        $result = Race::model()->find("indexID=? AND step =?", array($indexID, $step));
        if ($result == "") {
            $race = new Race();
            $race->time = $time;
            $race->indexID = $indexID;
            $race->step = $step;
            if($raceName!==""){
                $race->raceName=$raceName;
            }else{
                $race->raceName=$stepName;
            }
            $race->content = $content;
            $race->score = $score;
            $race->resourseID = $resourceID;
            $race->fileName = $fileName;
            $race->is_over = 0;
            $race->classID = $classID;
            $race->insert();
        } else {
            $result->time = $time;
            $result->indexID = $indexID;
            $result->step = $step;
            if($raceName!==""){
                $result->raceName=$raceName;
            }else{
                $result->raceName=$stepName;
            }
            $result->content = $content;
            $result->score = $score;
            $result->resourseID = $resourceID;
            $result->fileName = $fileName;
            $result->is_over = 0;
            $result->classID = $classID;
            $result->update();
        }
    }
    public function isover($indexID,$step){
            $ste = $step-1;
            $result = Race::model()->find("indexID=? AND step =?", array($indexID, $ste));
            $result->is_over = 1;
            $result->update();
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Race the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
