<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model atans\history\models\History */
/* @var $usernameAttribute string */

$this->title = Yii::t('history', 'History #{id}', ['id' => $model->id]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('history', 'Histories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

/* @var $user yii\db\ActiveRecord|yii\web\IdentityInterface|null */
$user = $model->user;

if (is_null($model->user_id)) {
    $username = null;
} else {
    $username = '';
    if ($user instanceof yii\web\IdentityInterface && $user->hasAttribute($usernameAttribute)) {
        $username .= $user->$usernameAttribute . ' ';
    }

    $username .= '#'. $model->user_id;
}


?>
<div class="history-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="box">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                [
                    'attribute' => 'user_id',
                    'value' => $username,
                ],
                'table',
                'event',
                'model_scenario',
                'key',
                'data:ntext',
                'ip',
                'created_at',
            ],
        ]) ?>
    </div>

</div>
