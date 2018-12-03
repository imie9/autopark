<?php
/**
 * Created by PhpStorm.
 * User: imie
 * Date: 01.12.18
 * Time: 16:12
 */

namespace app\controllers;

use app\models\Driver;
use app\services\DriverService;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\base\Module;

/**
 * Class DriverController
 * @package app\controllers
 */
class DriverController extends Controller
{

    /**
     * @var array
     */
    private $request;

    /**
     * @var DriverService
     */
    private $driverService;

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['create'],
                'rules' => [
                    [
                        'actions' => ['create'],
                        'allow' => true,
                    ],
                ],
            ],
        ];
    }

    /**
     * @param $action
     * @return bool
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction($action)
    {
        $this->request = $result = (array)json_decode(\Yii::$app->request->getRawBody(), true);

        $this->enableCsrfValidation = false;

        return parent::beforeAction($action);
    }

    /**
     * @return array
     */
    protected function verbs()
    {
        return [
            'list' => ['GET'],
            'create' => ['POST']
        ];
    }

    /**
     * @return array
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * DriverController constructor.
     * @param string $id
     * @param Module $module
     * @param array $config
     * @param Driver $driver
     */
    public function __construct(string $id, Module $module, array $config = [], Driver $driver)
    {
        $this->driverService = new DriverService($driver);
        parent::__construct($id, $module, $config);
    }

    public function actionIndex() {}


    /**
     * @return array
     */
    public function actionCreate(): array
    {
        return $this->driverService->create($this->request);
    }

    /**
     * @return array
     */
    public function actionList(): array
    {
        return $this->driverService->list();
    }

    /**
     * @return array
     */
    public function actionMinTravelTimeList(): array
    {
        return $this->driverService->minTravelTimeList($this->request);
    }

    /**
     * @return array
     */
    public function actionMinTravelTimeById(): array
    {
        return $this->driverService->minTravelTimeById($this->request);
    }
}