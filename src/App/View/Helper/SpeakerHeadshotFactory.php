<?php
declare(strict_types=1);

namespace App\View\Helper;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * @codeCoverageIgnore
 */
final class SpeakerHeadshotFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     * @return SpeakerHeadshot
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) : SpeakerHeadshot
    {
        return new SpeakerHeadshot(
            $container->get('config')['phph-site']['s3']['region'],
            $container->get('config')['phph-site']['s3']['bucket']
        );
    }
}
