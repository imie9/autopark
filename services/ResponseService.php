<?php
/**
 * Created by PhpStorm.
 * User: imie
 * Date: 03.12.18
 * Time: 0:42
 */

namespace app\services;


/**
 * Class ResponseService
 * @package app\services
 */
class ResponseService extends ResponseDataService
{

    /**
     * @return array
     */
    protected function response(): array
    {
        $_data_instance = static::getInstance();
        return $_data_instance->get();
    }

    /**
     * @param $errors
     */
    protected function errors($errors)
    {
        $_data_instance = static::getInstance();
        $_data_instance->setErrors($errors);
    }

    /**
     * @param $data
     */
    protected function data($data)
    {
        $_data_instance = static::getInstance();
        $_data_instance->setData($data);
    }

    /**
     * @param $success
     */
    protected function success($success)
    {
        $_data_instance = static::getInstance();
        $_data_instance->setSuccess($success);
    }

}