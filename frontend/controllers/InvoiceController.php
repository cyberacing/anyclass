<?php
declare(strict_types=1);

namespace frontend\controllers;

use Yii;
use common\models\Invoice;
use yii\filters\AccessControl;
use yii\web\Controller;

/**
 * Class InvoiceController
 * @package frontend\controllers
 */
class InvoiceController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Invoice models.
     * @return string
     */
    public function actionIndex() : string
    {
        $user = Yii::$app->user->identity;
        $invoices = Invoice::find()->byUserId($user->id)->all();

        return $this->render('index', [
            'invoices' => $invoices,
        ]);
    }
}
