<?php

namespace app\components;
use yii\rbac\Rule;

/**
 * Проверяем authorID на соответствие с пользователем, переданным через параметры
 */
class WorkgroupRule extends Rule
{
    public $name = 'isInWorkgroup';
    

    /**
     * @param string|int $user the user ID.
     * @param Item $item the role or permission that this rule is associated width.
     * @param array $params parameters passed to ManagerInterface::checkAccess().
     * @return bool a value indicating whether the rule permits the role or permission it is associated with.
     */

     
    public function execute($user, $item, $params)
    {
        // var_dump($params);die;
        // var_dump($params['post']->user_id);die;
        // var_dump($params['post']->user_id == $user);var_dump($user);die;
        
        // return isset($params['post']) ? $params['post']->user_id == $user : false;
    }
}