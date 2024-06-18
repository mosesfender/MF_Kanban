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
 * This is the model class for table "kanban_project_sticker".
 *
 * @property int $project_id Project ID / kanban_project.id
 * @property int $sticker_id Sticker ID / kanban_sticker.id
 *
 * @property KanbanProject $project
 * @property KanbanSticker $sticker
 */
class KanbanProjectSticker extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'kanban_project_sticker';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['project_id', 'sticker_id'], 'required'],
            [['project_id', 'sticker_id'], 'integer'],
            [['project_id'], 'exist', 'skipOnError' => true, 'targetClass' => KanbanProject::class, 'targetAttribute' => ['project_id' => 'id']],
            [['sticker_id'], 'exist', 'skipOnError' => true, 'targetClass' => KanbanSticker::class, 'targetAttribute' => ['sticker_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'project_id' => Yii::t('kanban', 'Project ID / kanban_project.id'),
            'sticker_id' => Yii::t('kanban', 'Sticker ID / kanban_sticker.id'),
        ];
    }

    /**
     * Gets query for [[Project]].
     *
     * @return ActiveQuery
     */
    public function getProject()
    {
        return $this->hasOne(KanbanProject::class, ['id' => 'project_id'])->inverseOf('kanbanProjectStickers');
    }

    /**
     * Gets query for [[Sticker]].
     *
     * @return ActiveQuery
     */
    public function getSticker()
    {
        return $this->hasOne(KanbanSticker::class, ['id' => 'sticker_id'])->inverseOf('kanbanProjectStickers');
    }
}
