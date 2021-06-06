<?php
declare(strict_types=1);

namespace backend\models;

use common\models\LoginForm as CommonLoginForm;
use common\models\User;
use Yii;

/**
 * Login form
 */
class LoginForm extends CommonLoginForm
{
    /**
     * Logs in a user using the provided username and password.
     *
     * @return bool whether the user is logged in successfully
     */
    public function login() : bool
    {
        if ($this->validate()) {
            $user = $this->getUser();
            $isAdmin = false;
            $roles = Yii::$app->authManager->getRolesByUser($user->id);
            foreach ($roles as $role) {
                if ($role->name === User::ADMIN_ROLE) {
                    $isAdmin = true;
                }
            }
            if ($isAdmin) {
                return Yii::$app->user->login($user, $this->rememberMe ? 3600 * 24 * 30 : 0);
            }
        }
        
        return false;
    }
}
