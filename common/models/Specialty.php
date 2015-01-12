<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "specialty".
 *
 * @property integer $id
 * @property string $name
 * @property integer $faculty_id
 * @property integer $study_cycle_id
 *
 * @property StudyCycle $studyCycle
 * @property Faculty $faculty
 */
class Specialty extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'specialty';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'faculty_id', 'study_cycle_id'], 'required'],
            [['faculty_id', 'study_cycle_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['code'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'code' => Yii::t('app', 'Code'),
            'faculty_id' => Yii::t('app', 'Faculty ID'),
            'study_cycle_id' => Yii::t('app', 'Study Cycle ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudyCycle()
    {
        return $this->hasOne(StudyCycle::className(), ['id' => 'study_cycle_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFaculty()
    {
        return $this->hasOne(Faculty::className(), ['id' => 'faculty_id']);
    }
}
