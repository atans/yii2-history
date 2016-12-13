<?php

namespace atans\hisotry\models;

use Yii;
use yii\behaviors\AttributeBehavior;
use yii\db\ActiveRecord;

/**
 * History model
 *
 * @property integer $id
 * @property string $class
 * @property string $table
 * @property string $event
 * @property string $scenario
 * @property string $key
 * @property string $data
 * @property string $ip
 */
class History extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%activerecord_history}}';
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
            'tableRequired'    => ['table', 'required'],
            'tableLength'      => ['table', 'string', 'max' => 50],

            'eventRequired'    => ['event', 'required'],
            'eventLength'      => ['event', 'string', 'max' => 50],

            'scenarioRequired' => ['scenario', 'required'],
            'scenarioLength'   => ['scenario', 'string', 'max' => 50],

            'dataLength'       => ['data', 'string'],

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
            'table'      => Yii::t('activerecory_history', 'Table'),
            'event'      => Yii::t('activerecory_history', 'Event'),
            'scenario'   => Yii::t('activerecory_history', 'Scenario'),
            'key'        => Yii::t('activerecory_history', 'Key'),
            'data'       => Yii::t('activerecory_history', 'Data'),
            'ip'         => Yii::t('activerecory_history', 'IP'),
            'created_by' => Yii::t('activerecory_history', 'Created By'),
            'created_at' => Yii::t('activerecory_history', 'Created At'),
        ];
    }

    /**
     * Change array to json
     *
     * @param $data
     */
    public function setData($data)
    {
        $this->data = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }

    /**
     * json to array
     *
     * @return array
     */
    public function getData()
    {
        return json_decode($this->data);
    }
}