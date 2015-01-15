<?php

namespace common\models;

use Yii;

// Recomand utilizarea prefixelor/titlurilor onorifice
// http://departments.weber.edu/qsupport&training/Data_Standards/Name.htm
// http://notes.ericwillis.com/2009/11/common-name-prefixes-titles-and-honorifics/

/**
 * This is the model class for table "instructor".
 *
 * @property integer $id
 * @property string $first_name
 * @property string $last_name
 * @property string $middle_name
 */
class Instructor extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'instructor';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['first_name', 'last_name'], 'required'],
            [['last_name'], 'unique', 'targetAttribute' => ['first_name', 'last_name', 'middle_name']],            
            [['first_name', 'last_name', 'middle_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'first_name' => Yii::t('app', 'First Name'),
            'last_name' => Yii::t('app', 'Last Name'),
            'middle_name' => Yii::t('app', 'Middle Name'),
        ];
    }
    
    public function getFullname()
    {
    	return "wwwwww";
    	//return $this->last_name . ' ' . $this->first_name; 
    }
}
