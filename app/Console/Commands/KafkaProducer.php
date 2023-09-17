<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Kafka\Producer;
use Kafka\Message;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class KafkaProducer extends Command
{
    protected $signature = 'kafka:produce';
    protected $description = 'Produce a message to Kafka';

    public function handle()
    {
        // Create the logger
        $logger = new Logger('my_logger');
        $logger->pushHandler(new StreamHandler('php://stdout'));

        // Create a Kafka producer
        $producer = new Producer();

        // Set the broker list
        $producer->setBrokerList('b-2.mskkafkacluster.ooub6r.c4.kafka.us-east-1.amazonaws.com:9092,b-1.mskkafkacluster.ooub6r.c4.kafka.us-east-1.amazonaws.com:9092');

        // Produce a message
        $message = new Message('Your message payload');
        $message->setTopic('MSKTutorialTopic');
        $message->setPartition(0); // Set the partition (adjust as needed)

        $producer->setLogger($logger);

        $producer->send([$message]);

        // Optionally, wait for delivery reports or errors
        $producer->poll(0);

        // Set up a delivery report callback
        $producer->setDeliveryReport(function ($kafka, $message) {
            if ($message->err) {
                $this->error("Message delivery failed: " . rd_kafka_err2str($message->err));
            } else {
                $this->info("Message delivered to partition {$message->partition} at offset {$message->offset}");
            }
        });

        // Wait for any outstanding messages to be delivered and delivery reports to be received.
        $producer->flush(10000); // Adjust the timeout as needed
    }
}
