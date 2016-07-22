<?php

/**
 * This is the model class for table "race_index".
 *
 * The followings are the available columns in table 'race_index':
 * @property integer $indexID
 * @property string $name
 * @property string $createTime
 */
class RaceIndex extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'race_index';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, createTime', 'required'),
            array('name', 'length', 'max' => 30),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('indexID, name, createTime', 'safe', 'on' => 'search'),
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
            'indexID' => 'Index',
            'name' => 'Name',
            'createTime' => 'Create Time',
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

        $criteria->compare('indexID', $this->indexID);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('createTime', $this->createTime, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function deleteRaceIndex($raceIndex) {
        RaceIndex::model()->deleteAll('indexID=?', array($raceIndex));
        $race = Race::model()->findAll('indexID=?', array($raceIndex));
        foreach ($race as $v){
          AnswerRecord::model()->delete('raceID=?', array($v['raceID']));  
        }
        Race::model()->deleteAll('indexID=?', array($raceIndex));
    }

    public function addRaceIndex($name) {
        $raceIndex = new RaceIndex();
        $raceIndex->name = $name;
        $raceIndex->createTime = date("Y-m-d  H:i:s");
        $raceIndex->insert();
    }

    public function getAllRaceIndex() {
        $sql = "SELECT * FROM race_index ORDER BY indexID DESC";
        $result = Tool::pager($sql, 20);
        return $result;
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return RaceIndex the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
