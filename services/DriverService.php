<?php
/**
 * Created by PhpStorm.
 * User: imie
 * Date: 01.12.18
 * Time: 19:43
 */

namespace app\services;


use app\models\Driver;
use app\models\Bus;
use app\repositories\DriverRepository;
use yii\db\Exception;

/**
 * Class DriverService
 * @package app\services
 */
class DriverService extends ResponseService
{
    /**
     * @var DriverRepository
     */
    protected $driverRepository;

    /**
     * DriverService constructor.
     * @param Driver $driver
     */
    public function __construct(Driver $driver)
    {
        $this->driverRepository = new DriverRepository($driver);
    }

    /**
     * @return Driver[]
     */
    public function list(): array
    {
        $drivers = $this->driverRepository->list();
        $this->data($drivers);
        return $this->response();
    }

    /**
     * @param $request
     * @return array
     */
    public function minTravelTimeById($request): array
    {
        if (!empty($request['id']) && !empty($request['kms'])) {
            $id = $request['id'];
            $kms = $request['kms'];
            $driver = $this->driverRepository->findById($id);
            if (!empty($driver)) {
                $busService = new BusService(new Bus());
                $speed = $busService->getFastest($driver);
                if ($speed !== null) {
                    $result = $driver->attributes;
                    $birth = new \DateTime($driver['birth_date']);
                    $now = new \DateTime();
                    $result['age'] =  $birth->diff($now)->y;
                    $result['birth_date'] = $birth->format('d.m.Y');
                    $result['travel_time'] =  ceil($kms / ($speed * 8));
                    $this->data($result);
                }
            } else {
                $this->success(false);
                $this->errors(['driver' => ['not found']]);
            }
        } else {
            $this->success(false);
            $this->errors(['id' => ['required']]);
            $this->errors(['kms' => ['required']]);
        }

        return $this->response();
    }

    /**
     * @param array $request
     * @return array
     */
    public function minTravelTimeList(array $request): array
    {
        $limit = null;
        $offset = null;
        if (!empty($request['limit']) && $request['limit'] !== null
            && !empty($request['offset']) && $request['offset'] !== null) {
            $limit = $request['limit'];
            $offset = $request['offset'];
        }

        if (!empty($request['kms'])) {
            $kms = $request['kms'];
            try {
                $drivers = $this->driverRepository->listWithFastestBus($limit, $offset);
                foreach ($drivers as $index => $driver) {
                    $drivers[$index]['travel_time'] = ceil($kms / ($driver['avg_speed'] * 8));
                    $birth = new \DateTime($driver['birth_date']);
                    $now = new \DateTime();
                    $drivers[$index]['age'] =  $birth->diff($now)->y;
                    $drivers[$index]['birth_date'] =  $birth->format('d.m.Y');
                }

                $this->data($drivers);
            } catch (Exception $e) {
                $this->success(false);
                $this->errors(['list' => $e->getMessage()]);
            }
        } else {
            $this->success(false);
            $this->errors(['kms' => ['Must be greater than 0']]);
        }


        return $this->response();
    }

    /**
     * @param array $request
     * @return array
     */
    public function create(array $request): array
    {
        if (!empty($request['buses'])) {
            $buses = $request['buses'];
            unset($request['buses']);
        } else {
            $this->errors(["buses" => "required"]);
            return $this->response();
        }

        if (!empty($request['birth_date'])) {
            $request['birth_date'] = date('Y-m-d', strtotime($request['birth_date']));
        }

        try {
            $driver_object = new Driver($request);

            $driver = $this->driverRepository->find($driver_object);

            if (is_null($driver)) {
                if (!$driver_object->validate()) {
                    $this->success(false);
                    $this->errors($driver_object->getErrors());
                }

                $driver = $this->driverRepository->create($driver_object);
            }

            if ($driver && !empty($buses)) {
                $busService = new BusService(new Bus());
                $busService->createMany($buses, $driver);
            }

            $driver_arr = $driver->toArray();
            $driver_arr['buses'] = $driver->buses;

            $this->data($driver_arr);

        } catch (\ErrorException $e) {
            $this->success(false);
            $this->errors(['driver' => [$e->getMessage()]]);
        }

        return $this->response();
    }

}