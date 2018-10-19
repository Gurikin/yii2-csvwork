<?php
use yii\widgets\Pjax;

Pjax::begin([]);

echo \kartik\grid\GridView::widget([
    'dataProvider' => $csvprovider,
    'filterModel' => $searchModel,
    'columns' => [
        [
            'attribute' => 'id',
            'label' => 'N°',
        ],
        [
            'attribute' => 'name',
            'label' => 'Имя пользователя',
            'filter' => '<input class="form-control" name="filtername" value="'. $searchModel['name'] .'" type="text">',
        ],
        [
            'attribute' => 'address',
            'label' => 'Адрес пользователя',
            'filter' => '<input class="form-control" name="filteraddress" value="'. $searchModel['address'] .'" type="text">',
        ],
        'actionColumn' => [
            'class' => 'yii\grid\ActionColumn',
            'header' => 'Действия',
        ],
    ],
]);

Pjax::end();
