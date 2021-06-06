<?php
declare(strict_types=1);

namespace console\controllers;

use Yii;
use yii\console\Controller;

/**
 * Class RbacController
 * @package console\controllers
 */
class RbacController extends Controller
{
    /**
     * @throws \Exception
     */
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        // добавляем роль "client"
        $client = $auth->createRole('client');
        $auth->add($client);

        // добавляем роль "admin"
        // а также все разрешения роли "client"
        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $client);
    }
}