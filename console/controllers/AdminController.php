<?php
declare(strict_types=1);

namespace console\controllers;

use common\models\UserForm;
use Yii;
use yii\console\Controller;
use yii\console\ExitCode;

/**
 * Class AdminController
 *
 * @package console\controllers
 */
class AdminController extends Controller
{
    /**
     * @return int
     * @throws \yii\base\InvalidConfigException
     */
    public function actionCreate() : int
    {
        /** @var UserForm $model */
        $model = Yii::createObject([
            'class' => UserForm::class,
        ]);

        $attributes = $model->safeAttributes();
        foreach ($attributes as $attribute) {
            $label = $model->getAttributeLabel($attribute);
            //Запрашиваем значение, пока оно не пройдёт валидацию
            do {
                $value = $this->prompt("{$label}:");
                $model->{$attribute} = $value;
                if (!$model->validate($attribute)) {
                    $this->stderr('Ошибка: ' . var_export($model->getErrors($attribute), true) . PHP_EOL);
                    continue;
                }
                break;
            } while (true);
        }

        if ($model->validate()) {
            $user = $model->save();
            $this->stdout("ID нового пользователя: {$user->id}" . PHP_EOL);
        }

        return ExitCode::OK;
    }
}
