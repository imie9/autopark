<?php

use yii\db\Migration;

/**
 * Class m181201_160739_relations
 */
class m181201_160739_relations extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('driver_bus', [
            'id'         => $this->primaryKey(8),
            'driver_id'  => $this->integer(8)->notNull(),
            'bus_id'  => $this->integer(8)->notNull(),
        ]);
        $this->addForeignKey(
            'fk-rel-driver-id',
            'driver_bus',
            'driver_id',
            'drivers',
            'id',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk-rel-bus-id',
            'driver_bus',
            'bus_id',
            'buses',
            'id',
            'CASCADE'
        );
        $this->createIndex('idx_driver_id_driver_bus', 'driver_bus', ['driver_id']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('driver_bus');
    }
}
