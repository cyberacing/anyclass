<?php
declare(strict_types=1);

namespace common\models;

use Exception;
use Yii;
use yii\base\BaseObject;
use yii\base\Model;

/**
 * Class UserForm
 *
 * @package common\models
 */
class UserForm extends Model
{
    /** @var User|null */
    private ?User $user = null;

    /** @var string|null */
    public ?string $username = null;
    /** @var string|null */
    public ?string $email = null;
    /** @var string|null */
    public ?string $password = null;

    /**
     * @inheritdoc
     * @throws \yii\base\InvalidConfigException
     */
    public function rules() : array
    {
        return [
            [['username', 'email', 'password'], 'required'],
            [['username', 'email'], 'string', 'max' => 255],
            [['email'], 'email', 'message' => 'Неверный Email'],
            [
                ['email'],
                'unique',
                'targetClass' => User::class,
                'filter' => ($this->getUser()->getIsNewRecord() ? [] : ['not', ['id' => $this->getUser()->id]]),
            ],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels() : array
    {
        return [
            'username' => Yii::t('app', 'Логин'),
            'email' => Yii::t('app', 'Email'),
            'password' => Yii::t('app', 'Пароль'),
        ];
    }

    /**
     * @return User
     * @throws \yii\base\InvalidConfigException
     */
    public function getUser() : User
    {
        if ($this->user === null) {
            /** @var User $this->user */
            $this->user = Yii::createObject([
                'class' => User::class,
            ]);
        }

        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user) : void
    {
        $this->user = $user;
        $this->setAttributes($this->user->getAttributes($this->safeAttributes()));
    }

    /**
     * @return User
     * @throws \yii\base\InvalidConfigException
     * @throws Exception
     */
    public function save() : User
    {
        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->generateEmailVerificationToken();
        $user->setScenario(User::SCENARIO_ADMIN);
        if (!$user->save()) {
            throw new Exception($user, 'Не удалось создать пользователя');
        }

        return $user;
    }
}
