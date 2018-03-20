<?php
namespace app\models;
//use mdm\admin\models\form\Signup as SignupForm;
use yii\base\Model;

class Signup extends Model{

    public $username;
    public $email;
    public $password;
    public $displayname;
    public $company_id;
    public $timezone;

    public static function tableName()
    {
        return 'user';
    }

    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => 'mdm\admin\models\User', 'message' => 'Пользователь с таким логином уже существует!'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => 'mdm\admin\models\User', 'message' => 'Такой email уже занят другим пользователем'],

            ['displayname', 'required'],
            ['company_id', 'required'],
            ['timezone', 'required'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if ($this->validate()) {
            $user = new User();
            $user->username = $this->username;
            $user->email = $this->email;
            $user->displayname = $this->displayname;
            $user->company_id = $this->company_id;
            $user->timezone = $this->timezone;
            $user->setPassword($this->password);
            $user->generateAuthKey();
            if ($user->save()) {
                return $user;
            }
        }

        return null;
    }

    public function attributeLabels()
    {
        return [
            'company_id' => 'Компания',
            'username' => 'Логин',
            'displayname' => 'Отображаемое имя',
            'password' => 'Пароль',
            'timezone' => 'Тайм Зона',

        ];
    }


}