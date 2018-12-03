<?php
/**
 * Created by PhpStorm.
 * User: imie
 * Date: 01.12.18
 * Time: 19:22
 */

namespace app\models;


use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class Driver
 * @package app\models
 *
 * @property int    $id
 * @property string $name
 * @property string $birth_date
 */
class Driver extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'drivers';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'birth_date'], 'required'],
            [['name'], 'string', 'max' => 64],
            [['birth_date'], 'string', 'max' => 64],
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
            'birth_date' => 'Birth date'
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getBuses() {
        return $this->hasMany(Bus::className(), ['id' => 'bus_id'])
            ->viaTable('driver_bus', ['driver_id' => 'id']);
    }

}