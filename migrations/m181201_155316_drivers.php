<?php

use yii\db\Migration;

/**
 * Class m181201_155316_drivers
 */
class m181201_155316_drivers extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('drivers', [
            'id'         => $this->primaryKey(8),
            'name'  => $this->string(64)->notNull(),
            'birth_date' => $this->timestamp()->notNull(),
        ]);
        $this->createIndex('idx_name_drivers', 'drivers', ['name']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('drivers');
    }
}
