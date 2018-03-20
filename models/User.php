<?php

namespace app\models;
use mdm\admin\models\User as UserModel;

class User extends UserModel
{

    #Иначе не дает зполнять пароль в admin/userm/update
      public function getPassword()
    {
        return '';
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['auth_key' => $token]);
    }

//Переопределение для полей пользователя
public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE]],
            ['company_id', 'safe'],
            ['workgroup_id', 'safe'],
            ['username', 'safe'],
            ['displayname', 'safe'],
            ['email', 'email'],
            ['timezone', 'safe'],
            ['password_hash', 'safe'],
            ['password', 'safe'],
        ];
    }

public function attributeLabels()
    {
        return [
            'workgroup_id' => 'Рабочая группа',
            'company_id' => 'Компания',
            'username' => 'Логин',
            'displayname' => 'Отображаемое имя',
            'timezone' => 'Тайм зона'
        ];
    }
}
