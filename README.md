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
'targets' => [
	...
	'googleCloud' => [
		'class' => 'inquid\google_debugger\GoogleCloudLogger',
		'categories' => ['... your categories ...'],
		'levels' => ['info', 'trace', 'warning','error'],
		'except' => ['yii\web\HttpException:*', 'yii\i18n\I18N\*'],
		'prefix' => function () {
			$url = !Yii::$app->request->isConsoleRequest ? Yii::$app->request->getUrl() : null;
			return sprintf('[%s][%s]', Yii::$app->id, $url);
		},
		'projectId' => '... your project id ...',
		'loggerInstance' => '... name of your app ...',
		'clientSecretPath' => '../google_credentials.json' //path to your credentials
	]
	...
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

