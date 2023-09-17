<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require __DIR__ . '/../../vendor/autoload.php';

echo "Script started\n";

use longlang\phpkafka\Consumer\ConsumeMessage;
use longlang\phpkafka\Consumer\Consumer;
use longlang\phpkafka\Consumer\ConsumerConfig;

function consume(ConsumeMessage $message)
{
    try {
        // Your message processing logic here
        var_dump($message->getKey() . ':' . $message->getValue());
        
        // By default, messages are auto-committed, but if you want to manually commit:
        // $message->getConsumer()->ack($message);
    } catch (\Exception $e) {
        // Handle any exceptions that occur during message processing
        echo "Error processing message: " . $e->getMessage() . "\n";
    }
}

$config = new ConsumerConfig();
$config->setBroker('b-2.mskkafkacluster.ooub6r.c4.kafka.us-east-1.amazonaws.com:9092');
$config->setTopic('MSKTutorialTopic'); // Set the topic using setTopic
$config->setGroupId('order-processing-group'); // Set a unique and descriptive Group ID
$config->setClientId('order-consumer');
$config->setInterval(0.1);

$consumer = new Consumer($config, 'consume');

// Start the consumer loop, but set a maximum number of iterations to avoid an endless loop.
$maxIterations = 1000; // Set an appropriate value for your use case.
$iterationCount = 0;

while ($iterationCount < $maxIterations) {
    $consumer->consume();
    $iterationCount++;
}

// This point will be reached after consuming the specified number of messages or iterations.
echo "Script finished after consuming $iterationCount messages\n";
