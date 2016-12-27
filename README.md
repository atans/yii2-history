Yii2 History Extension
===================
An active record history extension for yii2

# Installation

### 1.Download

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
composer require atans/yii2-history
```

or add

```
"atans/yii2-history": "*"
```

to the require section of your `composer.json` file.

Then run

```
composer update
```


### 2.Update database schema

```
$ php yii migrate/up --migrationPath=@vendor/atans/yii2-history/migrations
```


# Usage

```php

namespace frontend\models\User;

class User extends \yii\db\ActiveRecord
{
        /**
         * @inheritdoc
         */
        public function behaviors()
        {
            return [
                'history' => [
                    'class'      => \atans\history\behaviors\HistoryBehavior::className(),
                    
                    // Options
                    'allowEvents' => [..],
                    'ignoreFields' => [...],
                    'extraFields' => [...],
                    'debug' => true, // Show the errors
                ],
            ];
        }

}

```
