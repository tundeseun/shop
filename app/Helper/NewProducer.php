<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
//require __DIR__ . '/../../vendor/autoload.php'; // Adjust the path to include the library

namespace App\Helper;
use longlang\phpkafka\Producer\Producer;
use longlang\phpkafka\Producer\ProducerConfig;
use longlang\phpkafka\Protocol\RecordBatch\RecordHeader;

class ProducerTest
{
    public function sendMessage($message)
    {


try {
    $config = new ProducerConfig();
    $config->setBootstrapServer('b-2.mskkafkacluster.ooub6r.c4.kafka.us-east-1.amazonaws.com:9092');
    $config->setUpdateBrokers(true);
    $config->setAcks(-1);
    $producer = new Producer($config);
    $topic = 'MSKTutorialTopic';
    //$value = 'Product Sent Now'; // Message indicating the successful addition of a product
    $key = uniqid('', true);
   // $producer->send($topic, $message, $key);

    // Set headers using an array of RecordHeader objects
    $headers = [
        new RecordHeader('event_type', 'product_added'), // Indicate the type of event
        new RecordHeader('product_id', '9021337810'), // Include product ID or any relevant information
    ];
    $producer->send($topic, $message, $key, $headers);

    // Log success
    echo "Message sent successfully.";
} catch (\Exception $e) {
    // Log and handle the error
    echo "Error: " . $e->getMessage();
    // Optionally, log the error to a log file for further investigation
    // file_put_contents('error.log', "Error: " . $e->getMessage(), FILE_APPEND);
}

}
}

$producerTest = new ProducerTest();

// Send the custom message
$messageToSend = 'Product added to cart successfully!';
$producerTest->sendMessage($messageToSend);

?>
