<?php

require __DIR__.'/vendor/autoload.php';

use BGPHP\BgProcessing\Command\RegisterUser;
use BGPHP\BgProcessing\Handler\RegisterUserHandler;
use BGPHP\BgProcessing\Normalizer\RegisterUserNormalizer;
use Bernard\Producer;
use League\Tactician\Bernard\QueueMiddleware;
use League\Tactician\CommandBus;
use Bernard\Driver\PheanstalkDriver;
use Normalt\Normalizer\AggregateNormalizer;
use Pheanstalk\Pheanstalk;
use League\Tactician\Handler\Locator\InMemoryLocator;
use League\Tactician\Handler\CommandNameExtractor\ClassNameExtractor;
use League\Tactician\Handler\MethodNameInflector\HandleClassNameInflector;

$pheanstalk = new Pheanstalk('beanstalkd');

$driver = new PheanstalkDriver($pheanstalk);

$normalizer = new AggregateNormalizer([
    new RegisterUserNormalizer(),
    new \Bernard\Normalizer\EnvelopeNormalizer(),
]);

$queueFactory = new \Bernard\QueueFactory\PersistentFactory($driver, new \Bernard\Serializer($normalizer));

$producer = new Producer($queueFactory, new \Symfony\Component\EventDispatcher\EventDispatcher());

$queueMiddleware = new QueueMiddleware($producer);

$locator = new InMemoryLocator();
$locator->addHandler(new RegisterUserHandler(), RegisterUser::class);
$handlerMiddleware = new League\Tactician\Handler\CommandHandlerMiddleware(
    new ClassNameExtractor(),
    $locator,
    new HandleClassNameInflector()
);

$commandBus = new CommandBus([
    $queueMiddleware,
    $handlerMiddleware,
]);
