<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel atans\history\models\HistorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $usernameAttribute string */

$this->title = Yii::t('history', 'Histories');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="history-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="box">
        <?= GridView::widget([
            'summaryOptions' => [
                'class' => 'box-header',
            ],
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                'id',
                [
                    'attribute' => 'user_id',
                    'value' => function($model) use ($usernameAttribute) {
                        if (is_null($model->user_id)) {
                            return null;
                        }

                        /* @var $user yii\db\ActiveRecord|yii\web\IdentityInterface|null */
                        $user = $model->user;
                        $username = '';
                        if ($user instanceof yii\web\IdentityInterface && $user->hasAttribute($usernameAttribute)) {
                            $username .= $user->$usernameAttribute . ' ';
                        }

                        $username .= '#' . $model->user_id;

                        return $username;
                    }
                ],
                'table',
                'event',
                'model_scenario',
                 'key',
                 'data:ntext',
                 'ip',
                 'created_at',

                [
                    'header' => Yii::t('history', 'Actions'),
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{view}',
                ],
            ],
        ]); ?>
    </div>
</div>
