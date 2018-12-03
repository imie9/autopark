<?php

use yii\db\Migration;

/**
 * Class m181201_160336_buses
 */
class m181201_160336_buses extends Migration
{
    /**
     * There is no need to sort, then indexes are not needed.
     */
    public function safeUp()
    {
        $this->createTable('buses', [
            'id'         => $this->primaryKey(8),
            'name'  => $this->string(64)->notNull(),
            'avg_speed' => $this->integer(3)->notNull(),
        ]);
        $this->createIndex('idx_avg_speed_buses', 'buses', ['avg_speed']);

        for ($i = 0; $i <= 10; $i++) {
            $this->insert('buses', [
                'name' => 'bus' . $i,
                'avg_speed' => 80 + $i
            ]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('buses');
    }
}
