<p align="center">
    <a href="http://www.yiiframework.com/" target="_blank">
        <img src="http://static.yiiframework.com/files/logo/yii.png" width="400" alt="Yii Framework" />
    </a>
</p>

[![Donate](https://img.shields.io/badge/Donate-PayPal-green.svg)](https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=contact@inquid.co&item_name=Yii2+extensions+support&item_number=22+Campaign&amount=5%2e00&currency_code=USD)

Google Debugger for Yii
=======================
Use Google Cloud Logger into your Yii projects

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist inquid/yii2-google-debugger "*"
```

or add

```
"inquid/yii2-google-debugger": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply generate a service account with Cloud Debugger Agent permissions and configure your target as the following:

```php
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                'googleCloud' => [
                    'class' => 'inquid\google_debugger\GoogleCloudLogger',
                    'categories' => ['cat1','cat2'], //Your categories to log
                    'levels' => ['info', 'trace', 'warning', 'error'],
                    'except' => ['yii\web\HttpException:*', 'yii\i18n\I18N\*'],
                    'prefix' => function () {
                        $url = !Yii::$app->request->isConsoleRequest ? Yii::$app->request->getUrl() : null;
                        return sprintf('[%s][%s]', Yii::$app->id, $url);
                    },
                    'projectId' => 'project-id',
                    'loggerInstance' => 'instance-log',
                    'clientSecretPath' => '../google_credentials.json' //path to your service account credentials
                ]
            ],
        ],
```

And thats it! log as you may log using Yii
```php
Yii::debug('start calculating average revenue',GoogleCloudLogger::CATEGORY);
Yii::warning('Warning');
Yii::info('Info');
Yii::error('Error');
```

And check them in https://console.cloud.google.com/logs/viewer?project=your_project_id

SUPPORT
-----
[![paypal](https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif)](https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=contact@inquid.co&item_name=Yii2+extensions+support&item_number=22+Campaign&amount=5%2e00&currency_code=USD)

