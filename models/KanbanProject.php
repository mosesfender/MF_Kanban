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
 * This is the model class for table "kanban_project".
 *
 * @property int $id
 * @property string|null $title Project title
 * @property string|null $description Project description
 * @property string|null $settings Project settings
 * @property int|null $flags Project boolean properties
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property KanbanProjectSticker[] $kanbanProjectStickers
 * @property KanbanUserProject[] $kanbanUserProjects
 */
class KanbanProject extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'kanban_project';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'description', 'settings'], 'string'],
            [['flags'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('kanban', 'ID'),
            'title' => Yii::t('kanban', 'Project title'),
            'description' => Yii::t('kanban', 'Project description'),
            'settings' => Yii::t('kanban', 'Project settings'),
            'flags' => Yii::t('kanban', 'Project boolean properties'),
            'created_at' => Yii::t('kanban', 'Created At'),
            'updated_at' => Yii::t('kanban', 'Updated At'),
        ];
    }

    /**
     * Gets query for [[KanbanProjectStickers]].
     *
     * @return ActiveQuery
     */
    public function getKanbanProjectStickers()
    {
        return $this->hasMany(KanbanProjectSticker::class, ['project_id' => 'id'])->inverseOf('project');
    }

    /**
     * Gets query for [[KanbanUserProjects]].
     *
     * @return ActiveQuery
     */
    public function getKanbanUserProjects()
    {
        return $this->hasMany(KanbanUserProject::class, ['project_id' => 'id'])->inverseOf('project');
    }
}
