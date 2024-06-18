<?php
/*
 * Copyright (c) Sergey Siunov. 2024
 * @email sergey@siunov.ru
 * @link https://siunov.ru
 */

namespace mf\kanban\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "kanban_dict_columns".
 *
 * @property int         $id
 * @property string|null $def_title Default column title
 * @property string|null $def_descr Default column description
 */
class KanbanDictColumn extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'kanban_dict_columns';
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['def_title', 'def_descr'], 'string'],
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'        => Yii::t('kanban', 'ID'),
            'def_title' => Yii::t('kanban', 'Default column title'),
            'def_descr' => Yii::t('kanban', 'Default column description'),
        ];
    }
}
