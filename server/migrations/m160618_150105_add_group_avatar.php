<?php

use yii\db\Schema;
use yii\db\Migration;

class m160618_150105_add_group_avatar extends Migration
{
    public function up()
    {
        $this->addColumn("{{groups}}", "avatar", 'text after `name`');
    }

    public function down()
    {
        $this->dropColumn("{{groups}}", "avatar");
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
