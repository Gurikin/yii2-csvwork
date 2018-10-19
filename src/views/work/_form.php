<?php

use yii\helpers\Html;
use kartik\builder\Form;

foreach ($model as $key=>$value) {
    $attributes = [
        $key=>['label'=>$key, 'value'=>$value]
    ];
}


echo Html::beginForm('', '', ['class'=>'form-horizontal']);
echo Form::widget([
    // formName is mandatory for non active forms
    // you can get all attributes in your controller
    // using $_POST['kvform']
    'formName'=>'csvStringForm',

    // default grid columns
    'columns'=>1,

    // set global attribute defaults
    'attributeDefaults'=>[
        'type'=>Form::INPUT_TEXT,
        'labelOptions'=>['class'=>'col-md-3'],
        'inputContainer'=>['class'=>'col-md-9'],
        'container'=>['class'=>'form-group'],
    ],

    'attributes'=>[
        'id'=>['label'=>'Id', 'value'=>$model['id']],
        'name'=>['label'=>'Name', 'value'=>$model['name']],
        'address'=>['label'=>'Address', 'value'=>$model['address']],
        'actions'=>[
            'type'=>Form::INPUT_RAW,
            'value'=>'<div style="text-align: right; margin-top: 20px">' .
                Html::resetButton('Reset', ['class'=>'btn btn-secondary']) . ' ' .
                Html::button('Save', ['type'=>'submit', 'class'=>'btn btn-primary']) .
                '</div>'
        ]
    ]
]);
echo Html::endForm();
