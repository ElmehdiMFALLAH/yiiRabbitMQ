<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m180515_134053_test_table
 */
class m180515_134053_test_table extends Migration
{
      public function safeUp() {
         $this->createTable("user", [
            "id" => Schema::TYPE_PK,
            "name" => Schema::TYPE_STRING,
            "email" => Schema::TYPE_STRING,
         ]);
      }
      public function safeDown() {
         $this->dropTable('user');
      }
}
