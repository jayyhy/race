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
            array('indexID, step, content, score, time, resourseID, fileName', 'required'),
            array('indexID, step, score, time, resourseID', 'numerical', 'integerOnly' => true),
            array('fileName', 'length', 'max' => 30),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('raceID, indexID, step, content, score, time, resourseID, fileName,is_over', 'safe', 'on' => 'search'),
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

    public function addRace($indexID, $step, $content, $score, $time, $resourceID, $fileName) {
        $result = Race::model()->find("indexID=? AND step =?", array($indexID, $step));
        if ($result == "") {
            $race = new Race();
            $race->time = $time;
            $race->indexID = $indexID;
            $race->step = $step;
            $race->content = $content;
            $race->score = $score;
            $race->resourseID = $resourceID;
            $race->fileName = $fileName;
            $race->is_over = 0;
            $race->insert();
        } else {
            $result->time = $time;
            $result->indexID = $indexID;
            $result->step = $step;
            $result->content = $content;
            $result->score = $score;
            $result->resourseID = $resourceID;
            $result->fileName = $fileName;
            $result->is_over = 0;
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
