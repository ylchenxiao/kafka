<?php

namespace app\commands;

use yii\console\Controller;

 
/**

 * This command echoes the first argument that you have entered.

 *

 * This command is provided as an example for you to learn how to create console commands.

 *

 * @author Qiang Xue <qiang.xue@gmail.com>

 * @since 2.0

 */

class KafkaController extends Controller

{

    /**

     * This command echoes what you have entered as the message.

     * @param string $message the message to be echoed.

     */

    public function actionConsume()

    {

        \Yii::$app->asyncLog->consumer($this, 'callback');

 

    }

 

    public function callback($message)

    {

        \Yii::info($message, 'testkafka');

        \Yii::$app->log->setflushInterval(1);

    }

 

}