<?php
/**
 * Created by PhpStorm.
 * User: imie
 * Date: 01.12.18
 * Time: 19:46
 */
namespace app\repositories;


use app\models\Driver;
use yii\base\ErrorException;

class DriverRepository implements DriverRepositoryInterface
{
    protected $driver;

    public function __construct(Driver $driver)
    {
        $this->driver = $driver;
    }

    /**
     * @return Driver[]
     */
    public function list(): array
    {
        return $this->driver->find()->with('buses')->orderBy(['name' => SORT_ASC])->asArray()->all();
    }

    /**
     * @param int $limit
     * @param int $offset
     * @return array
     * @throws \yii\db\Exception
     */
    public function listWithFastestBus(int $limit = null, int $offset = null): array
    {
        $sql = 'SELECT
                  d.id as driver_id,
                  d.name,
                  d.birth_date,
                  b.avg_speed
                FROM drivers AS d
                  JOIN driver_bus db ON d.id = db.driver_id
                  JOIN buses b ON db.bus_id = b.id
                WHERE avg_speed = (
                                   SELECT MAX(avg_speed)
                                       FROM (
                                              SELECT
                                                d.id as driver_id2,
                                                b.avg_speed
                                              FROM drivers AS d
                                                JOIN driver_bus db ON d.id = db.driver_id
                                                JOIN buses b ON db.bus_id = b.id
                                        ) AS s
                                    WHERE s.driver_id2 = driver_id)
                ORDER BY avg_speed
                DESC ';
        if ($limit !== null) {
            $sql .= "LIMIT $limit\n";
        }
        if ($offset !== null) {
            $sql .= "OFFSET $offset";
        }

        $result = \Yii::$app->db->createCommand($sql)
            ->queryAll();
        return $result;
    }

    /**
     * @param Driver $driver
     * @return Driver
     * @throws ErrorException
     */
    public function create(Driver $driver): Driver
    {
        if (!$driver->save()) {
            throw new ErrorException('Driver not saved');
        }
        return $driver;
    }

    /**
     * @param int $id
     * @return Driver|null
     */
    public function findById(int $id)
    {
        return $this->driver::findOne(['id' => $id]);
    }

    /**
     * @param Driver $driver
     * @return Driver|null
     */
    public function find(Driver $driver)
    {
        $condition = $driver->attributes;
        unset($condition['id']);
        return $this->driver::findOne($condition);
    }
}