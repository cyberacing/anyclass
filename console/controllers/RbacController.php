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

        // добавляем разрешение "canAccessBackend"
        $canAccessBackend = $auth->createPermission('canAccessBackend');
        $canAccessBackend->description = 'canAccessBackend';
        $auth->add($canAccessBackend);

        // добавляем роль "client"
        $client = $auth->createRole('client');
        $auth->add($client);

        // добавляем роль "admin" и даём роли разрешение "canAccessBackend"
        // а также все разрешения роли "client"
        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $canAccessBackend);
        $auth->addChild($admin, $client);
    }
}