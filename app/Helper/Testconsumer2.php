<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require __DIR__ . '/../../vendor/autoload.php';

use longlang\phpkafka\Consumer\Consumer;
use longlang\phpkafka\Consumer\ConsumerConfig;

$config = new ConsumerConfig();
$config->setBroker('b-2.mskkafkacluster.ooub6r.c4.kafka.us-east-1.amazonaws.com:9092');
$config->setTopic('MSKTutorialTopic');
$config->setGroupId('my-consumer-group2');
$config->setClientId('123456');
$uniqueInstanceId = gethostname() . '-' . getmypid();
$config->setGroupInstanceId($uniqueInstanceId);

$consumer = new Consumer($config);

while (true) {
    try {
        $message = $consumer->consume();
        if ($message) {
            $timestamp = date('Y-m-d H:i:s');
            $value = $message->getValue();
            echo "Received at $timestamp: $value\n";
        }
    } catch (\Throwable $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}
?>
