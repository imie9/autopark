<?php
/**
 * Created by PhpStorm.
 * User: imie
 * Date: 01.12.18
 * Time: 19:49
 */

namespace app\repositories;


use app\models\Driver;
use yii\base\ErrorException;

/**
 * Interface DriverRepositoryInterface
 * @package app\repositories
 */
interface DriverRepositoryInterface
{

    /**
     * @return Driver[]
     */
    public function list(): array;

    /**
     * @param Driver $driver
     * @throws ErrorException
     * @return Driver|false
     */
    public function create(Driver $driver);

    /**
     * @param int $limit
     * @param int $offset
     * @return array
     * @throws \yii\db\Exception
     */
    public function listWithFastestBus(int $limit = null, int $offset = null): array;

    /**
     * @param int $id
     * @return Driver|null
     */
    public function findById(int $id);

    /**
     * @param Driver $driver
     * @return Driver|null
     */
    public function find(Driver $driver);

}