<?php
/*
 * Copyright (c) Sergey Siunov. 2024
 * @email sergey@siunov.ru
 * @link https://siunov.ru
 */

namespace mf\kanban\models;

use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "kanban_sticker_history".
 *
 * @property int $sticker_id Sticker ID from kanban_sticker.id
 * @property string $field Changed field
 * @property string|null $changed_at
 * @property int $changed_by User who modified the task
 *
 * @property KanbanSticker $sticker
 */
class KanbanStickerHistory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'kanban_sticker_history';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sticker_id', 'field', 'changed_by'], 'required'],
            [['sticker_id', 'changed_by'], 'integer'],
            [['field'], 'string'],
            [['changed_at'], 'safe'],
            [['sticker_id'], 'exist', 'skipOnError' => true, 'targetClass' => KanbanSticker::class, 'targetAttribute' => ['sticker_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'sticker_id' => Yii::t('kanban', 'Sticker ID from kanban_sticker.id'),
            'field' => Yii::t('kanban', 'Changed field'),
            'changed_at' => Yii::t('kanban', 'Changed At'),
            'changed_by' => Yii::t('kanban', 'User who modified the task'),
        ];
    }

    /**
     * Gets query for [[Sticker]].
     *
     * @return ActiveQuery
     */
    public function getSticker()
    {
        return $this->hasOne(KanbanSticker::class, ['id' => 'sticker_id'])->inverseOf('kanbanStickerHistories');
    }
}
