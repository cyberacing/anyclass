<?php
declare(strict_types=1);

namespace frontend\controllers;

use frontend\models\BuyProductForm;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;

/**
 * Class BuyProductController
 * @package frontend\controllers
 */
class BuyProductController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors() : array
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
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function actionIndex() : string
    {
        /** @var BuyProductForm $buyProductForm */
        $buyProductForm = Yii::createObject([
            'class' => BuyProductForm::class,
        ]);

        if ($buyProductForm->load(Yii::$app->request->post())) {
            if ($buyProductForm->save()) {
                $this->redirect(Url::to(['/invoice']));
            }
        }

        return $this->render('index', [
            'buyProductForm' => $buyProductForm,
        ]);
    }
}
