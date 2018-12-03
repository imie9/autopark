<?php
/**
 * Created by PhpStorm.
 * User: imie
 * Date: 03.12.18
 * Time: 1:44
 */

namespace app\services;

/**
 * Class ResponseDataService
 * Singleton
 * @package app\services
 */
class ResponseDataService
{

    /**
     * @var bool
     */
    private $success = true;

    /**
     * @var array
     */
    private $errors = [];

    /**
     * @var array
     */
    private $data = [];

    /**
     * @var static|null
     */
    private static $_instance = null;

    private function __construct() {}

    protected function __clone() {}

    /**
     * @return ResponseDataService|null
     */
    static public function getInstance()
    {
        if(is_null(self::$_instance))
        {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * @param $errors\
     */
    public function setErrors($errors)
    {
        foreach ($errors as $name => $error) {
            $this->errors[$name] = $error;
        }
    }

    /**
     * @param $data
     */
    public function setData($data)
    {
        $this->data[] = $data;
    }

    /**
     * @param $success
     */
    public function setSuccess($success)
    {
        $this->success = $success;
    }

    /**
     * @return array
     */
    public function get()
    {
        return [
            'success' => $this->success,
            'errors' => $this->errors,
            'data' => $this->data
        ];
    }
}