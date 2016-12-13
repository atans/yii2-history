<?php

namespace atans\history;

use Yii;
use yii\base\BootstrapInterface;
use yii\web\Application as WebApplication;
use yii\i18n\PhpMessageSource;

class Bootstrap implements BootstrapInterface
{
    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        if ($app instanceof WebApplication) {
            if (! isset($app->i18n->translations['history*'])) {
                $app->i18n->translations['history*'] = [
                    'class'    => PhpMessageSource::className(),
                    'basePath' => __DIR__ . '/messages',
                ];
            }

        }
    }
}
