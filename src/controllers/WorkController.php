<?php
/**
 * Created by PhpStorm.
 * User: gurik
 * Date: 16.10.2018
 * Time: 10:57
 */

namespace gurikin\csvwork\controllers;

use gurikin\csvwork\models\CSVModel;
use yii;
use yii\web\Controller;
use yii\data\Pagination;
use yii\data\ArrayDataProvider;


class WorkController extends Controller
{
    public $filename = __DIR__."/../source/source.csv";


    public function actionIndex() {

        $csv = new CSVModel($this->filename);

        $model = $csv->getModel();

        $filteredModel = $csv->filter($model, 'address');
        $filteredModel = $csv->filter($filteredModel, 'name');


        $namefilter = Yii::$app->request->getQueryParam('filtername', '');
        $addressfilter = Yii::$app->request->getQueryParam('filteraddress', '');

        $searchModel = ['id' => null, 'name' => $namefilter, 'address' => $addressfilter];

        $dataProvider = new ArrayDataProvider([
            'key'=>'stringNumber',
            'allModels' => $filteredModel,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'attributes' => ['id', 'name'],
            ],
        ]);

        return $this->render('index',[
            'csvprovider' => $dataProvider,
            'searchModel' => $searchModel
        ]);
    }

    /**
     * Displays a single string from source csv model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $csv = new CSVModel($this->filename);
        $model = $csv->findOne($id);

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $csv = new CSVModel($this->filename);
        $csv->delete($id);

        return $this->redirect(['work/index']);
    }

    public function actionUpdate($id)
    {
        $modelSource = $this->findModel($id);
        $csv = $modelSource['csv'];
        $model = $modelSource['model'];

        $post = Yii::$app->request->post();
        if (isset($post['csvStringForm'])) {

            $model['id'] = $post['csvStringForm']['id'];
            $model['name'] = $post['csvStringForm']['name'];
            $model['address'] = $post['csvStringForm']['address'];

            if ($csv->save($model) !== false) {
                return $this->redirect(['view', 'id' => $model['stringNumber']]);
            } else {
                echo "<h1>Сохранение не удалось!</h1>";
            }
            return $this->redirect(['view', 'id' => $model['stringNumber']]);
        }
        return $this->render('update', [
            'model' => $model
        ]);
    }

    /**
     * Finds the string in the csv file based on its number.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Array - the string from the csv file
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $csv = new CSVModel($this->filename);
        if (($model = $csv->findOne($id)) !== null) {
            return array('csv'=>$csv,'model'=>$model);
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}