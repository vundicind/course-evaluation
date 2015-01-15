<?php

namespace common\models;

use Yii;
use yii\base\Model;
use common\models\GroupActivity;

/**
 * CourseClasses represents the model which aggreagates all `app\models\GroupActivity` for a group, course and semester.
 */
class CourseClasses extends GroupActivity
{
	public $classes = [];
	
	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
				[['course_id', 'group_id', 'semester_id'], 'integer'],
				[['course_id', 'group_id', 'semester_id'], 'required'],
				[['course_id', 'group_id', 'semester_id'], 'safe'],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function scenarios()
	{
		// bypass scenarios() implementation in the parent class
		return Model::scenarios();
	}
}	