<?php
/**
 * Created by PhpStorm.
 * User: imie
 * Date: 02.12.18
 * Time: 22:33
 */

namespace app\repositories;


use app\models\Bus;

interface BusRepositoryInterface
{
    /**
     * @return Bus[]
     */
    public function list(): array;

    /**
     * @param Bus $bus
     * @return Bus
     */
    public function create(Bus $bus): Bus;

    /**
     * @param Bus $bus
     * @return Bus|null
     */
    public function find(Bus $bus);

    /**
     * @param int $id
     * @return array|false
     * @throws \yii\db\Exception
     */
    public function fastestForDriver(int $id);
}