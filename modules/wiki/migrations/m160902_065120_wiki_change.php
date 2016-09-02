<?php

use app\base\Migration;

class m160902_065120_wiki_change extends Migration
{

    public $table = '{{%wiki_history}}';
    
    public function up()
    {
        $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'wiki_id' => $this->integer()->notNull(),
            'user_id' => $this->integer(),
            'content' => $this->text()->defaultValue(''),
            'created_at' => $this->integer(),
            'summary' => $this->string(255)->notNull()->defaultValue(''),
            'host_ip' => $this->char(15)->notNull()->defaultValue(''),
        ]);
        
        if (!$this->isSqlite()) {
            $this->addForeignKey('fk_wiki_id', $this->table, 'wiki_id', '{{%wiki}}', 'id', 'CASCADE');
        }
    }

    public function down()
    {
        $this->dropTable($this->table);
    }

}
