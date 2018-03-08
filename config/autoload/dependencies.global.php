<?php
declare(strict_types=1);

use Zend\Expressive\Application;
use Zend\Expressive\Container\ApplicationFactory;
use Zend\Expressive\Helper;

return [
    'dependencies' => [
        'abstract_factories' => [
            \Zend\ServiceManager\AbstractFactory\ReflectionBasedAbstractFactory::class,
        ],
        'invokables' => [
            Helper\ServerUrlHelper::class => Helper\ServerUrlHelper::class,
        ],
        'factories' => [
            Application::class => ApplicationFactory::class,
            Helper\UrlHelper::class => Helper\UrlHelperFactory::class,
            App\Service\User\FindUserByEmailInterface::class => App\Service\User\FindUserByEmailFactory::class,
            App\Service\User\FindUserByUuidInterface::class => App\Service\User\FindUserByUuidFactory::class,
            App\Service\Meetup\FindMeetupByUuidInterface::class => App\Service\Meetup\FindMeetupByUuidFactory::class,
            App\Service\Meetup\MeetupsServiceInterface::class => App\Service\Meetup\MeetupsServiceFactory::class,
            App\Service\Meetup\GetAllMeetupsInterface::class => App\Service\Meetup\GetAllMeetupsFactory::class,
            App\Service\Location\GetAllLocationsInterface::class => App\Service\Location\GetAllLocationsFactory::class,
            App\Service\Location\FindLocationByUuidInterface::class => App\Service\Location\FindLocationByUuidFactory::class,
            App\Service\Speaker\GetAllSpeakersInterface::class => App\Service\Speaker\GetAllSpeakersFactory::class,
            App\Service\Speaker\FindSpeakerByUuidInterface::class => App\Service\Speaker\FindSpeakerByUuidFactory::class,
            App\Service\Speaker\MoveSpeakerHeadshotInterface::class => App\Service\Speaker\MoveSpeakerHeadshotFactory::class,
            App\Service\Talk\FindTalkByUuidInterface::class => App\Service\Talk\FindTalkByUuidFactory::class,
            App\Service\Talk\FindTalksWithVideoInterface::class => App\Service\Talk\FindTalksWithVideoFactory::class,
            App\Service\Authentication\AuthenticationServiceInterface::class => App\Service\Authentication\Factory::class,
            App\Service\Authorization\AuthorizationServiceInterface::class => App\Service\Authorization\Factory::class,
            App\Service\Twitter\TwitterAuthenticationInterface::class => App\Service\Twitter\TwitterAuthenticationFactory::class,
            App\Service\GitHub\GitHubAuthenticationInterface::class => App\Service\GitHub\GitHubAuthenticationFactory::class,
            Doctrine\ORM\EntityManagerInterface::class => ContainerInteropDoctrine\EntityManagerFactory::class,
        ],
        'delegators' => [
            Zend\View\HelperPluginManager::class => [
                App\View\HelperPluginManagerDelegatorFactory::class
            ],
        ],
    ],
];
