<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "group".
 *
 * @property integer $id
 * @property string $name
 *
 * @property Subgroup $subgroup
 */
class Group extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'group';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'specialty_id'], 'required'],
            [['name'], 'string', 'max' => 50],
            [['specialty_id'], 'integer'],
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
            'specialty_id' => Yii::t('app', 'Specialty ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubgroup()
    {
        return $this->hasOne(Subgroup::className(), ['id' => 'id']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSpecialty()
    {
        return $this->hasOne(Specialty::className(), ['id' => 'specialty_id']);
    }
    
}
