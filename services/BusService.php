<?php
/**
 * Created by PhpStorm.
 * User: imie
 * Date: 02.12.18
 * Time: 22:32
 */

namespace app\services;


use app\models\Bus;
use app\models\Driver;
use app\repositories\BusRepository;
use yii\db\Exception;

class BusService extends ResponseService
{
    /**
     * @var BusRepository
     */
    protected $busRepository;

    /**
     * BusService constructor.
     * @param Bus $bus
     */
    public function __construct(Bus $bus)
    {
        $this->busRepository = new BusRepository($bus);
    }

    /**
     * @param array $buses
     * @param Driver|null $driver
     * @return array
     */
    public function createMany(array $buses, Driver $driver = null): array
    {
        foreach ($buses as $index => $bus) {
            try {
                $bus_object = new Bus($bus);

                $saved_bus = $this->busRepository->find($bus_object);
                if (is_null($saved_bus)) {
                    if (!$bus_object->validate()) {
                        $this->errors($bus_object->getErrors());
                    }
                    $saved_bus = $this->busRepository->create($bus_object);
                }

                if (!is_null($driver)) {
                    $driver->link('buses', $saved_bus);
                }
            } catch (\ErrorException $e) {
                $this->errors(["bus $bus_object->name" => [$e->getMessage()]]);
            }
        }

        return $buses;
    }


    /**
     * @param Driver $driver
     * @return integer|null
     */
    public function getFastest(Driver $driver) {
        try {
            $bus_speed = $this->busRepository->fastestForDriver($driver->id);
            if (empty($bus_speed['speed']) || !$bus_speed) {
                $this->success(false);
                $this->errors(['bus' => ['no buses found']]);
            }
            return $bus_speed['speed'];
        } catch (Exception $e) {
            $this->success(false);
            $this->errors(['bus' => [$e->getMessage()]]);
        }

        return null;
    }
}