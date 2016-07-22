<?php

/**
 * This is the model class for table "answer_record".
 *
 * The followings are the available columns in table 'answer_record':
 * @property integer $recordID
 * @property integer $studentID
 * @property string $content
 * @property integer $raceID
 * @property integer $score
 * @property double $rate
 */
class AnswerRecord extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'answer_record';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('studentID, content, raceID, score, rate', 'required'),
            array('studentID, raceID, score', 'numerical', 'integerOnly' => true),
            array('rate', 'numerical'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('recordID, studentID, content, raceID, score, rate', 'safe', 'on' => 'search'),
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
            'recordID' => 'Record',
            'studentID' => 'Student',
            'content' => 'Content',
            'raceID' => 'Race',
            'score' => 'Score',
            'rate' => 'Rate',
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

        $criteria->compare('recordID', $this->recordID);
        $criteria->compare('studentID', $this->studentID);
        $criteria->compare('content', $this->content, true);
        $criteria->compare('raceID', $this->raceID);
        $criteria->compare('score', $this->score);
        $criteria->compare('rate', $this->rate);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function submitRace($studentID, $raceID, $content,$courseID) {
        $record = AnswerRecord::model()->find("studentID = ? AND raceID = ?", array($studentID, $raceID));
        if ($record == "") {
            $record = new AnswerRecord();
            $record->studentID = $studentID;
            $record->raceID= $raceID;
            $record->content = $content;
            $record->courseID = $courseID;
            $result = $record->insert();
        } else {
            $record->content = $content;
            $result = $record->update();
        }
        return $result;
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return AnswerRecord the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
