<?php
declare(strict_types=1);

namespace App\Service\Speaker;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * @codeCoverageIgnore
 */
final class MoveSpeakerHeadshotFactory implements FactoryInterface
{
    public function __invoke(
        ContainerInterface $container,
        $requestedName,
        array $options = null
    ) : MoveSpeakerHeadshot {
        return new MoveSpeakerHeadshot(
            $container->get('config')['phph-site']['speaker-headshot-path']
        );
    }
}
