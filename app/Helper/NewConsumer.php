<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require __DIR__ . '/../../vendor/autoload.php';

use longlang\phpkafka\Consumer\Consumer;
use longlang\phpkafka\Consumer\ConsumerConfig;
use longlang\phpkafka\Consumer\ConsumeMessage;

// Define the callback function to process messages
function processMessage(ConsumeMessage $message) {
    echo 'Key: ' . $message->getKey() . '<br>';
    echo 'Value: ' . $message->getValue() . '<br>';
    echo '<hr>';
}

// Configure Kafka consumer
$config = new ConsumerConfig();
$config->setBootstrapServer('b-2.mskkafkacluster.ooub6r.c4.kafka.us-east-1.amazonaws.com:9092,b-1.mskkafkacluster.ooub6r.c4.kafka.us-east-1.amazonaws.com:9092');
$config->setTopic('MSKTutorialTopic');
$config->setGroupId('my-consumer-group'); // Change this to your consumer group
$config->setInterval(0.1);

// Set a unique group instance ID using Server Hostname and Process ID
$uniqueInstanceId = gethostname() . '-' . getmypid();
$config->setGroupInstanceId($uniqueInstanceId);

$consumer = new Consumer($config, 'processMessage');

// Start consuming messages
try {
    $consumer->start();
    
    if (!$consumer->isConsumed()) {
        echo "No messages found in the topic.<br>";
        sleep(1); // Sleep for a second before retrying
    }else {
        echo "Data Received.<br>";
    }    
} catch (\Throwable $e) {
    echo "Error: " . $e->getMessage();
}
?>
