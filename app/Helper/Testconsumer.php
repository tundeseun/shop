<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require __DIR__ . '/../../vendor/autoload.php'; 
//echo "data received <br>";


use longlang\phpkafka\Consumer\Consumer;
use longlang\phpkafka\Consumer\ConsumerConfig;



$config = new ConsumerConfig();
$config->setBroker('b-2.mskkafkacluster.ooub6r.c4.kafka.us-east-1.amazonaws.com:9092');
$config->setTopic('MSKTutorialTopic');
$config->setGroupId('my-consumer-group');
$config->setClientId('9021337810'); // client ID. Use different settings for different consumers.
$uniqueInstanceId = gethostname() . '-' . getmypid();
$config->setGroupInstanceId($uniqueInstanceId);

//$config->setGroupInstanceId(''); // group instance ID. Use different settings for different consumers.
$consumer = new Consumer($config);
while (true) {
    try {
        $message = $consumer->consume();
        if ($message) {
           // echo "Test data received <br>";
           // var_dump($message->getKey() . ':' . $message->getValue());
print_r($message->getValue());

             $consumer->ack($message); // Commit manually
            break;
        }
        sleep(1);
    } catch (\Throwable $e) {
        echo "Error: " . $e->getMessage() . "<br>";
        sleep(1);
    }
}

?>