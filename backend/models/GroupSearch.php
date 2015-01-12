<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Group;

/**
 * GroupSearch represents the model behind the search form about `app\models\Group`.
 */
class GroupSearch extends Group
{
    public $specialty;
    
    public $studyForm;
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name', 'specialty', 'studyForm'], 'safe'],
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
        $query = Group::find();
        $query->joinWith(['specialty', 'studyForm']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        $dataProvider->sort->attributes = [
            'name',
            'specialty' => [
                'asc' => ['specialty.name' => SORT_ASC],
                'desc' => ['specialty.name' => SORT_DESC],
            ],
            'studyForm' => [
                'asc' => ['studyForm.name' => SORT_ASC],
                'desc' => ['studyForm.name' => SORT_DESC],
            ],
        ];

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['id' => $this->id]);

        $query->andFilterWhere(['like', 'group.name', $this->name])
            ->andFilterWhere(['like', 'specialty.name', $this->specialty])
            ->andFilterWhere(['like', 'study_form.name', $this->studyForm]);

        return $dataProvider;
    }
}
