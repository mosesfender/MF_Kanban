<?php
/*
 * Copyright (c) Sergey Siunov. 2024
 * @email sergey@siunov.ru
 * @link https://siunov.ru
 */

use yii\db\Migration;

/**
 * Handles the creation of table `{{%project}}`.
 */
class m240616_215042_create_project_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('kanban_project', [
            'id'          => $this->primaryKey(),
            'title'       => $this->text()->null()->comment('Project title'),
            'description' => $this->text()->null()->comment('Project description'),
            'settings'    => $this->text()->null()->comment('Project settings'),
            'flags'       => $this->bigInteger(20)->null()->defaultValue(0)->comment('Project boolean properties'),
            'created_at'  => 'DATETIME DEFAULT CURRENT_TIMESTAMP',
            'updated_at'  => 'DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP'
        ],                 'COMMENT="Project list"');
        
        $this->createTable('kanban_user_project', [
            'user_id'    => $this->integer(11)->notNull()->comment('Project owner id / user.id'),
            'project_id' => $this->integer(11)->notNull()->comment('Project id / kanban_project.id'),
        ],                 'COMMENT="Link project with user"');
        
        $this->addForeignKey('FK_user_project_user_id', 'kanban_user_project', 'user_id',
                             'user', 'id', 'CASCADE');
        $this->addForeignKey('FK_user_project_project_id', 'kanban_user_project', 'project_id',
                             'kanban_project', 'id', 'CASCADE');
        
        $this->createTable('kanban_sticker', [
            'id'         => $this->primaryKey()->comment('Sticker ID'),
            'title'      => $this->text()->null()->comment('Sticker title'),
            'task_text'  => $this->text()->null()->comment('Sticker task text'),
            'position'   => $this->integer()->notNull()->comment('Column when position sticker / kanban_columns.id'),
            'priority'   => $this->integer()->notNull()->defaultValue(1)->comment('Order match sticker in column'),
            'flags'      => $this->bigInteger(20)->null()->defaultValue(0)->comment('Sticker boolean properties'),
            'created_at' => 'DATETIME DEFAULT CURRENT_TIMESTAMP',
            'created_by' => $this->integer()->notNull()->comment('User who create the task')
        ],                 'COMMENT="Project stickers"');
        
        $this->createTable('kanban_project_sticker', [
            'project_id' => $this->integer(11)->notNull()->comment('Project ID / kanban_project.id'),
            'sticker_id' => $this->integer(11)->notNull()->comment('Sticker ID / kanban_sticker.id'),
        ],                 'COMMENT="Sticker list in project"');
    
        $this->addForeignKey('FK_project_sticker_project_id', 'kanban_project_sticker', 'project_id',
                             'kanban_project', 'id', 'CASCADE');
        $this->addForeignKey('FK_project_sticker_sticker_id', 'kanban_project_sticker', 'sticker_id',
                             'kanban_sticker', 'id', 'CASCADE');
        
        $this->createTable('kanban_sticker_history', [
            'sticker_id' => $this->integer()->notNull()->comment('Sticker ID from kanban_sticker.id'),
            'field'      => "enum ('title', 'task_text', 'flags', 'position', 'priority') NOT NULL COMMENT 'Changed field'",
            'changed_at' => 'DATETIME DEFAULT CURRENT_TIMESTAMP',
            'changed_by' => $this->integer()->notNull()->comment('User who modified the task')
        ],                 'COMMENT="History changed of sticker"');
    
        $this->addForeignKey('FK_sticker_history_sticker_id', 'kanban_sticker_history', 'sticker_id',
                             'kanban_sticker', 'id', 'CASCADE');
        
        $this->createTable('kanban_dict_columns', [
            'id'        => $this->primaryKey(),
            'def_title' => $this->text()->null()->comment('Default column title'),
            'def_descr' => $this->text()->null()->comment('Default column description'),
        ],                 'COMMENT="Dictionary default project columns"');
        
        $this->db->createCommand('INSERT INTO `kanban_dict_columns` (`def_title`, `def_descr`) VALUES '
                                 . '("Execute", "Tasks that need to be worked on"),'
                                 . '("Work", "Tasks at work"),'
                                 . '("Specify", "Need more information"),'
                                 . '("Does", "Tasks completed but not tested"),'
                                 . '("Test", "Testing tasks"),'
                                 . '("Management", "Tasks subject to approval by the project manager"),'
                                 . '("Finish", "Completed tasks")'
        )->execute();
        
    }
    
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('FK_sticker_history_sticker_id', 'kanban_sticker_history');
        $this->dropForeignKey('FK_project_sticker_project_id', 'kanban_project_sticker');
        $this->dropForeignKey('FK_project_sticker_sticker_id', 'kanban_project_sticker');
        $this->dropForeignKey('FK_user_project_user_id', 'kanban_user_project');
        $this->dropForeignKey('FK_user_project_project_id', 'kanban_user_project');
        $this->dropTable('kanban_dict_columns');
        $this->dropTable('kanban_sticker_history');
        $this->dropTable('kanban_project_sticker');
        $this->dropTable('kanban_sticker');
        $this->dropTable('kanban_user_project');
        $this->dropTable('kanban_project');
    }
}
