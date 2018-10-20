<?php

namespace gurikin\csvwork;

use yii;
use yii\base\BootstrapInterface;

class CSVWorkBootstrap implements BootstrapInterface
{
    public function bootstrap($app)
    {
        //Правила маршрутизации
        $app->getUrlManager()->addRules([
            'csvwork' => 'csvwork\work\index',
        ], false);

        $app->setModule('csvwork', 'gurikin\csvwork\Module');
    }
}