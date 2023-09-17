<?php
namespace App\Helper;

use longlang\phpkafka\Producer\Producer;
use longlang\phpkafka\Producer\ProducerConfig;

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
            $key = uniqid('', true);

            // Send the custom message to the Kafka topic
            $producer->send($topic, $key, $message);

            echo "Message sent successfully.";
        } catch (\Exception $e) {
            // Handle the exception, e.g., log the error.
            echo "Error: " . $e->getMessage();
        }
    }
}
?>



