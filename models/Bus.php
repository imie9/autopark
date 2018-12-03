<?php
/**
 * Created by PhpStorm.
 * User: imie
 * Date: 01.12.18
 * Time: 19:33
 */

namespace app\models;


use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class Bus
 * @package app\models
 *
 * @property int    $id
 * @property string $name
 * @property int    $avg_speed
 */
class Bus extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'buses';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'avg_speed'], 'required'],
            [['name'], 'string', 'max' => 64],
            [['avg_speed'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'birth_date' => 'Birth date',
            'buses' => 'Buses'
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getDrivers() {
        return $this->hasMany(Bus::className(), ['id' => 'driver_id'])
            ->viaTable('driver_bus', ['bus_id' => 'id']);
    }
}