<?php

namespace gurikin\csvwork;
use gurikin\csvwork\models\CSVModel;

/**
 * This is just an example.
 */
class AutoloadExample extends \yii\base\Widget
{
    public function run()
    {
        $source = CSVModel::getSource();
        var_dump($source);
    }
}
