<?php
/*
 * Copyright (c) Sergey Siunov. 2024
 * @email sergey@siunov.ru
 * @link https://siunov.ru
 */

namespace mf\kanban\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "kanban_sticker".
 *
 * @property int $id Sticker ID
 * @property string|null $title Sticker title
 * @property string|null $task_text Sticker task text
 * @property int $position Column when position sticker / kanban_columns.id
 * @property int $priority Order match sticker in column
 * @property int|null $flags Sticker boolean properties
 * @property string|null $created_at
 * @property int $created_by User who create the task
 *
 * @property KanbanProjectSticker[] $kanbanProjectStickers
 * @property KanbanStickerHistory[] $kanbanStickerHistories
 */
class KanbanSticker extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'kanban_sticker';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'task_text'], 'string'],
            [['position', 'created_by'], 'required'],
            [['position', 'priority', 'flags', 'created_by'], 'integer'],
            [['created_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('kanban', 'Sticker ID'),
            'title' => Yii::t('kanban', 'Sticker title'),
            'task_text' => Yii::t('kanban', 'Sticker task text'),
            'position' => Yii::t('kanban', 'Column when position sticker / kanban_columns.id'),
            'priority' => Yii::t('kanban', 'Order match sticker in column'),
            'flags' => Yii::t('kanban', 'Sticker boolean properties'),
            'created_at' => Yii::t('kanban', 'Created At'),
            'created_by' => Yii::t('kanban', 'User who create the task'),
        ];
    }

    /**
     * Gets query for [[KanbanProjectStickers]].
     *
     * @return ActiveQuery
     */
    public function getKanbanProjectStickers()
    {
        return $this->hasMany(KanbanProjectSticker::class, ['sticker_id' => 'id'])->inverseOf('sticker');
    }

    /**
     * Gets query for [[KanbanStickerHistories]].
     *
     * @return ActiveQuery
     */
    public function getKanbanStickerHistories()
    {
        return $this->hasMany(KanbanStickerHistory::class, ['sticker_id' => 'id'])->inverseOf('sticker');
    }
}
