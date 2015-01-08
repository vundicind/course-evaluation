<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Specialty;

/**
 * SpecialtySearch represents the model behind the search form about `app\models\Specialty`.
 */
class SpecialtySearch extends Specialty
{
    public $faculty;
    
    public $studyCycle;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name', 'code', 'faculty', 'studyCycle'], 'safe'],
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
        $query = Specialty::find();
        $query->joinWith(['faculty', 'studyCycle']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        $dataProvider->sort->attributes['faculty'] = [
            'asc' => ['faculty.name' => SORT_ASC],
            'desc' => ['faculty.name' => SORT_DESC],
        ];        

        $dataProvider->sort->attributes['studyCycle'] = [
            'asc' => ['studyCycle.name' => SORT_ASC],
            'desc' => ['studyCycle.name' => SORT_DESC],
        ];        
        
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['id' => $this->id]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'faculty.name', $this->faculty])
            ->andFilterWhere(['like', 'studyCycle.name', $this->studyCycle]);            

        return $dataProvider;
    }
}
