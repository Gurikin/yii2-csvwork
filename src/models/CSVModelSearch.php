<?php
/**
 * Created by PhpStorm.
 * User: gurik
 * Date: 28.08.2018
 * Time: 6:58
 */

namespace gurikin\csvwork\models;

use gurikin\csvwork\models\CSVModel;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;


class CSVModelSearch extends CSVModel
{

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name', 'address'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
     * @return ArrayDataProvider
     */
    public function search()
    {
        $model = parent::getModel();

        $filteredresultData = array_filter($model, 'filter');

        // add conditions that should always apply here

        $dataProvider = new ArrayDataProvider([
            'allModels' => $model,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'attributes' => ['id', 'name'],
            ],
        ]);

        return $dataProvider;
    }

    public function filter($item) {
        $mailfilter = Yii::$app->request->getQueryParam('filteremail', '');
        if (strlen($mailfilter) > 0) {
            if (strpos($item['email'], $mailfilter) != false) {
                return true;
            } else {
                return false;
            }
        } else {
            return true;
        }
    }
}