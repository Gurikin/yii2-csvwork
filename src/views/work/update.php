<?php

use yii\helpers\Html;
use app\models\Post;

/* @var $this yii\web\View */
/* @var $model app\models\InputReestr */

$this->title = 'Изменить строку номер: ' . $model['stringNumber'];

$this->params['breadcrumbs'][] = ['label' => 'CSVList', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model['stringNumber'], 'url' => ['view', 'id' => $model['stringNumber']]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="post-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
