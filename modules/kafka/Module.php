<?php
/**
 * Created by PhpStorm.
 * User: liuxuan
 * Date: 2018/7/18
 * Time: 16:12
 */

namespace app\modules\kafka;

class Module extends \yii\base\Module
{
    public function init()
    {
        parent::init();

        $this->params['foo'] = 'bar';
        // ...  其他初始化代码 ...
    }
}