<?php

namespace atans\history\behaviors;

use Yii;
use atans\hisotry\models\History;
use yii\base\Behavior;
use yii\base\Event;
use yii\base\Exception;
use yii\base\NotSupportedException;
use yii\db\BaseActiveRecord;
use yii\web\Application as WebApplication;

/**
 * History Behavior
 */
class HistoryBehavior extends Behavior
{
    /**
     * @var array
     */
    public $allowEvents = [
        BaseActiveRecord::EVENT_AFTER_INSERT,
        BaseActiveRecord::EVENT_AFTER_UPDATE,
        BaseActiveRecord::EVENT_AFTER_DELETE,
    ];

    /**
     * @var array
     */
    public $ignoreFields = [];

    /**
     * Add extra fields
     *
     * @var array
     */
    public $extraFields = [];

    /**
     * @inheritdoc
     */
    public function events()
    {
        return array_fill_keys($this->allowEvents, 'addHistory');
    }

    /**
     * Add history
     *
     * @param Event $event
     * @throws NotSupportedException
     * @throws \yii\db\Exception
     */
    public function addHistory(Event $event)
    {
        /* @var $owner \yii\db\ActiveRecord */
        $owner = $this->owner;

        $primaryKey = $this->getPrimaryKey();

        $data = $owner->toArray([], $this->extraFields);

        // Remove ignore fields
        if ($this->ignoreFields) {
            foreach ($this->ignoreFields as $ignoreField) {
                unset($data[$ignoreField]);
            }
        }

        $transaction = Yii::$app->getDb()->beginTransaction();

        try {
            $ip = null;

            if (Yii::$app instanceof WebApplication) {
                $ip = Yii::$app->request->userIP;
            }

            $history = new History([
                'event'    => $event->name,
                'table'    => $owner::TableName(),
                'scenario' => $owner->scenario,
                'key'      => $primaryKey,
                'data'     => $data,
                'ip'       => $ip,
            ]);

            if ($history->save()) {
                throw new Exception('History can not save');
            }
        } catch (\Exception $e) {
            $transaction->rollBack();
        }
    }

    /**
     * Get primary key
     *
     * @return string
     * @throws NotSupportedException
     */
    protected function getPrimaryKey()
    {
        /* @var $owner \yii\db\ActiveRecord */
        $owner = $this->owner;

        $primaryKey = $owner->primaryKey();

        if (count($primaryKey) == 1) {
            $field = array_shift($primaryKey);

            return $this->owner->$field;
        }

        throw new NotSupportedException('Composite primary key is not supported.');
    }
}