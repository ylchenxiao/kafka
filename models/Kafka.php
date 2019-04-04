<?php

/**

 * Kafka.php.

 * User: liuxuan

 * Date: 2019/4/3 

 * Time: 11:04

 * Desc: Kafka服务

 */

 

namespace app\models;


use yii\base\InvalidConfigException;


class Kafka

{

    public $broker_list = '106.13.79.145:9092';//配置kafka，可以用逗号隔开多个kafka

    public $topic = 'test';

    public $partition = 0;

 

    protected $producer = null;

    protected $consumer = null;

 

    public function __construct()

    {

        if (empty($this->broker_list)) {

            throw new InvalidConfigException("broker not config");

        }

        $rk = new \RdKafka\Producer();

        if (empty($rk)) {

            throw new InvalidConfigException("producer error");

        }

        $rk->setLogLevel(LOG_DEBUG);

        if (!$rk->addBrokers($this->broker_list)) {

            throw new InvalidConfigException("producer error");

        }

        $this->producer = $rk;

    }

 

    /**

     * 生产者

     * @param array $messages

     * @return mixed

     */

    public function send($messages = [])

    {

        $topic = $this->producer->newTopic($this->topic);

        return $topic->produce(RD_KAFKA_PARTITION_UA, $this->partition, json_encode($messages));

    }

 

    /**

     * 消费者

     */

    public function consumer($object, $callback){

        $conf = new \RdKafka\Conf();

        $conf->set('group.id', 0);

        $conf->set('metadata.broker.list', $this->broker_list);

 

        $topicConf = new \RdKafka\TopicConf();

        $topicConf->set('auto.offset.reset', 'smallest');

 

        $conf->setDefaultTopicConf($topicConf);

 

        $consumer = new \RdKafka\KafkaConsumer($conf);

 

        $consumer->subscribe([$this->topic]);

 

        echo "waiting for messages.....\n";

        while(true) {

            $message = $consumer->consume(120*1000);

            switch ($message->err) {

                case RD_KAFKA_RESP_ERR_NO_ERROR:

                    echo "message payload....";

                    $object->$callback($message->payload);

                    break;

            }

            sleep(1);

        }

    }

}