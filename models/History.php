<?php

namespace atans\history\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\AttributeBehavior;
use yii\db\ActiveRecord;
use yii\web\Application as WebApplication;

/**
 * History model
 *
 * @property integer $id
 * @property string $class
 * @property string $table
 * @property integer $user_id
 * @property string $event
 * @property string $model_scenario
 * @property string $key
 * @property string $data
 * @property string $ip
 * @property string $created_at
 */
class History extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%history}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class'      => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                ],
                'value'      => date('Y-m-d H:i:s'),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            'userIdPattern' => ['user_id', 'integer'],

            'tableRequired'    => ['table', 'required'],
            'tableLength'      => ['table', 'string', 'max' => 50],

            'eventRequired'    => ['event', 'required'],
            'eventLength'      => ['event', 'string', 'max' => 50],

            'modelScenarioRequired' => ['model_scenario', 'required'],
            'modelScenarioLength'   => ['model_scenario', 'string', 'max' => 50],

            'ipLength'         => ['ip', 'string', 'max' => 42],

            'createdAtPattern' => ['created_at', 'date', 'format' => 'php:Y-m-d H:i:s'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id'        => Yii::t('history', 'User ID'),
            'table'          => Yii::t('history', 'Table'),
            'event'          => Yii::t('history', 'Event'),
            'model_scenario' => Yii::t('history', 'Scenario'),
            'key'            => Yii::t('history', 'Key'),
            'data'           => Yii::t('history', 'Data'),
            'ip'             => Yii::t('history', 'IP'),
            'created_at'     => Yii::t('history', 'Created At'),
        ];
    }

    /**
     * Change array to json
     *
     * @param $data
     */
    public function setData(array $data)
    {
        $this->data = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }

    /**
     * Get data
     *
     * @return string
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Get data as array
     *
     * @return array
     */
    public function getDataAsArray()
    {
        return json_decode($this->data);
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if (! $this->getIsNewRecord()) {
            throw new NotSupportedException('Update is not allowed');
        }

        if (Yii::$app instanceof WebApplication) {
            $this->ip = Yii::$app->request->userIP;

            if (! Yii::$app->user->getIsGuest() && ($userId = Yii::$app->getUser()->getId())) {
                $this->user_id = $userId;
            }
        }

        return parent::beforeSave($insert);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Yii::$app->user->identityClass, ['id' => 'user_id']);
    }
}