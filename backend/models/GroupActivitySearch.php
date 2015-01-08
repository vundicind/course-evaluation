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
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'group_id', 'activity_type_id', 'course_id', 'instructor_id', 'semester_id', 'subgroup'], 'integer'],
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

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'group_id' => $this->group_id,
            'activity_type_id' => $this->activity_type_id,
            'course_id' => $this->course_id,
            'instructor_id' => $this->instructor_id,
            'semester_id' => $this->semester_id,
            'subgroup' => $this->subgroup,
        ]);

        return $dataProvider;
    }
}
