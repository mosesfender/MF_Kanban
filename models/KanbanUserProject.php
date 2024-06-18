<?php
/*
 * Copyright (c) Sergey Siunov. 2024
 * @email sergey@siunov.ru
 * @link https://siunov.ru
 */

namespace mf\kanban\models;

use yii\web\IdentityInterface as User;
use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "kanban_user_project".
 *
 * @property int $user_id Project owner id / user.id
 * @property int $project_id Project id / kanban_project.id
 *
 * @property KanbanProject $project
 * @property User $user
 */
class KanbanUserProject extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'kanban_user_project';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'project_id'], 'required'],
            [['user_id', 'project_id'], 'integer'],
            [['project_id'], 'exist', 'skipOnError' => true, 'targetClass' => KanbanProject::class, 'targetAttribute' => ['project_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'user_id' => Yii::t('kanban', 'Project owner id / user.id'),
            'project_id' => Yii::t('kanban', 'Project id / kanban_project.id'),
        ];
    }

    /**
     * Gets query for [[Project]].
     *
     * @return ActiveQuery
     */
    public function getProject()
    {
        return $this->hasOne(KanbanProject::class, ['id' => 'project_id'])->inverseOf('kanbanUserProjects');
    }

    /**
     * Gets query for [[User]].
     *
     * @return ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id'])->inverseOf('kanbanUserProjects');
    }
}
