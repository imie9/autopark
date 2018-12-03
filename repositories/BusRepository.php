<?php
/**
 * Created by PhpStorm.
 * User: imie
 * Date: 02.12.18
 * Time: 22:33
 */

namespace app\repositories;


use app\models\Bus;
use app\models\Driver;
use yii\base\ErrorException;

class BusRepository implements BusRepositoryInterface
{
    /**
     * @var Bus
     */
    protected $bus;

    /**
     * BusRepository constructor.
     * @param Bus $bus
     */
    public function __construct(Bus $bus)
    {
        $this->bus = $bus;
    }

    /**
     * @return Bus[]
     */
    public function list(): array
    {
        $result = null;

        return $this->bus->find()->all();
    }

    /**
     * @param Bus $bus
     * @return Bus|null
     */
    public function find(Bus $bus)
    {
        $condition = $bus->attributes;
        unset($condition['id']);
        return $this->bus::findOne($condition);
    }


    /**
     * @param int $id
     * @return array|false
     * @throws \yii\db\Exception
     */
    public function fastestForDriver(int $id)
    {
        $sql = "SELECT 
                  MAX(avg_speed) AS speed 
                FROM buses
                  JOIN driver_bus db ON buses.id = db.bus_id
                  JOIN drivers d ON db.driver_id = d.id
                WHERE d.id = $id";

        $result = \Yii::$app->db->createCommand($sql)
            ->queryOne();
        return $result;
    }

    /**
     * @param Bus $bus
     * @param Driver|null $driver
     * @return Bus
     * @throws ErrorException
     */
    public function create(Bus $bus, Driver $driver = null): Bus
    {
        if (!$bus->save()) {
            throw new ErrorException("Bus $bus->name not saved");
        }
        return $bus;
    }
}