<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "group_activity".
 *
 * @property integer $id
 * @property integer $group_id
 * @property integer $activity_type_id
 * @property integer $course_id
 * @property integer $instructor_id
 * @property integer $subgroup
 *
 * @property Instructor $instructor
 * @property ActivityType $activityType
 * @property Course $course
 * @property Group $group
 */
class GroupActivity extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'group_activity';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['group_id', 'activity_type_id', 'course_id', 'instructor_id', 'subgroup'], 'required'],
            [['group_id', 'activity_type_id', 'course_id', 'instructor_id', 'subgroup'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'group_id' => Yii::t('app', 'Group ID'),
            'activity_type_id' => Yii::t('app', 'Activity Type ID'),
            'course_id' => Yii::t('app', 'Course ID'),
            'instructor_id' => Yii::t('app', 'Instructor ID'),
            'subgroup' => Yii::t('app', 'Subgroup'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInstructor()
    {
        return $this->hasOne(Instructor::className(), ['id' => 'instructor_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActivityType()
    {
        return $this->hasOne(ActivityType::className(), ['id' => 'activity_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCourse()
    {
        return $this->hasOne(Course::className(), ['id' => 'course_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroup()
    {
        return $this->hasOne(Group::className(), ['id' => 'group_id']);
    }
}
