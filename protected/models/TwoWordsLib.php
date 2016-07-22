<?php

/**
 * This is the model class for table "two_words_lib".
 *
 * The followings are the available columns in table 'two_words_lib':
 * @property integer $id
 * @property string $spell
 * @property string $yaweiCode
 * @property string $words
 */
class TwoWordsLib extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'two_words_lib';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('spell, yaweiCode, words', 'required'),
			array('spell, yaweiCode', 'length', 'max'=>30),
			array('words', 'length', 'max'=>200),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, spell, yaweiCode, words', 'safe', 'on'=>'search'),
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
			'id' => 'ID',
			'spell' => 'Spell',
			'yaweiCode' => 'Yawei Code',
			'words' => 'Words',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('spell',$this->spell,true);
		$criteria->compare('yaweiCode',$this->yaweiCode,true);
		$criteria->compare('words',$this->words,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function getRandomRecord( $num){
            $sql = "SELECT * FROM `two_words_lib` order by rand() limit ".$num;
            $res = Yii::app()->db->createCommand($sql)->query();
            return $res;
        }
        
        public function change($Lib,$newList){
            $Lib->list = $newList;
            $Lib->update();
        }
        
        public function modify(){
            $Lib = new TwoWordsLib();
            $Lib = TwoWordsLib::model()->findAll("name != 'lib' AND list!= '总复习'");
            foreach ($Lib as $v){
//                switch (Tool::csubstr($v["name"],0 ,1)){
//                    case '声': $this->change($v, "第02-07讲");
//                        break;
//                }
            }
            return 0;
        }

        /**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TwoWordsLib the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
