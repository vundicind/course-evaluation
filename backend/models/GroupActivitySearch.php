<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\GroupActivity;

/**
 * GroupActivitySearch represents the model behind the search form about `app\models\GroupActivity`.
 */
class GroupActivitySearch extends GroupActivity
{
    public $group;
    
    public $activityType;
    
    public $course;
    
    public $instructor;
    
    public $semester;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'group_id', 'activity_type_id', 'course_id', 'instructor_id', 'semester_id', 'subgroup'], 'integer'],
            [['group', 'activityType', 'course', 'instructor', 'semester'], 'safe'],
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

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = GroupActivity::find();
        $query->joinWith(['group', 'activityType', 'course', 'instructor', 'semester']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        $dataProvider->sort->attributes = [
            'group' => [
                'asc' => ['group.name' => SORT_ASC],
                'desc' => ['group.name' => SORT_DESC],
            ],
            'activityType' => [
                'asc' => ['activityType.name' => SORT_ASC],
                'desc' => ['activityType.name' => SORT_DESC],
            ],
            'course' => [
                'asc' => ['course.name' => SORT_ASC],
                'desc' => ['course.name' => SORT_DESC],
            ],
            'instructor' => [
            //http://www.yiiframework.com/doc-2.0/yii-data-sort.html
            //http://www.yiiframework.com/wiki/621/filter-sort-by-calculated-related-fields-in-gridview-yii-2-0/
                'asc' => ['instructor.last_name' => SORT_ASC],
                'desc' => ['instructor.last_name' => SORT_DESC],
            ],
            'semester' => [
                'asc' => ['semester.name' => SORT_ASC],
                'desc' => ['semester.name' => SORT_DESC],
            ],
        ];

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['id' => $this->id]);
        
        $query->andFilterWhere(['like', 'group.name', $this->group])
            ->andFilterWhere(['like', 'activity_type.name', $this->activityType])
            ->andFilterWhere(['like', 'course.name', $this->course])
            ->andFilterWhere(['like', 'instructor.last_name', $this->instructor])
            ->andFilterWhere(['like', 'semester.name', $this->semester]);

        return $dataProvider;
    }
}
