<?php

/**
 * This is the model class for table "answer_record".
 *
 * The followings are the available columns in table 'answer_record':
 * @property integer $recordID
 * @property string $studentID
 * @property string $content
 * @property integer $raceID
 * @property integer $score
 * @property double $rate
 * @property integer $courseID
 * @property integer $indexID
 * @property integer $accept_time
 */
class AnswerRecord extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'answer_record';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('studentID, content, raceID, rate, courseID, indexID', 'required'),
			array('raceID, score, courseID, indexID, accept_time', 'numerical', 'integerOnly'=>true),
			array('rate', 'numerical'),
			array('studentID', 'length', 'max'=>30),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('recordID, studentID, content, raceID, score, rate, courseID, indexID, accept_time', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'recordID' => 'Record',
			'studentID' => 'Student',
			'content' => 'Content',
			'raceID' => 'Race',
			'score' => 'Score',
			'rate' => 'Rate',
			'courseID' => 'Course',
			'indexID' => 'Index',
			'accept_time' => 'Accept Time',
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
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('recordID',$this->recordID);
		$criteria->compare('studentID',$this->studentID,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('raceID',$this->raceID);
		$criteria->compare('score',$this->score);
		$criteria->compare('rate',$this->rate);
		$criteria->compare('courseID',$this->courseID);
		$criteria->compare('indexID',$this->indexID);
		$criteria->compare('accept_time',$this->accept_time);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AnswerRecord the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function submitRace($studentID, $raceID, $content, $courseID) {
        $record = AnswerRecord::model()->find("studentID = ? AND raceID = ?", array($studentID, $raceID));
        $indexID = Race::model()->find("raceID=?",array($raceID))['indexID'];
        $accepttime = microtime(true)*10000;
        error_log($accepttime);
        if ($record == "") {
            $record = new AnswerRecord();
            $record->studentID = $studentID;
            $record->raceID = $raceID;
            $record->content = $content;
            $record->courseID = $courseID;
            $record->indexID = $indexID;
            $record->accept_time = $accepttime;
            $result = $record->insert();
        } else {
            $record->content = $content;
            $result = $record->update();
        }
        return $result;
    }

    public function markScore($stuID, $raceID, $mark, $rate) {
        $answer = AnswerRecord::model()->find("studentID=? AND raceID=?", array($stuID, $raceID));
        $result = 0;
        if ($answer != '') {
            $answer->score = $mark;
            $answer->rate = $rate;
            $result = $answer->update();
            return $result;
        }else{
            return $result;
        }
    }
    
    public function getAllScoreByStudentIDAndIndexID($studentID,$indexID){
        $answers = AnswerRecord::model()->findAll('studentID=? AND indexID=?',array($studentID,$indexID));
        $totalScore = 0;
        foreach ($answers as $v){
            $totalScore+=$v['score'];
        }
        return $totalScore;
    }
}
