<?php

namespace app\modules\kafka\controllers;

use Yii;
use yii\filters\AccessControl;


class KafkaProducerController extends Controller
{
    public function actionIndex(){
    	//Yii::$app->asyncLog->send(['this is IndexController,'.date('y-md H:i:s',time())]);
    	echo 1;die;
    }
}
