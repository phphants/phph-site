<?php
declare(strict_types=1);

namespace App\Service\Speaker;

use Aws\S3\S3Client;
use Interop\Container\ContainerInterface;
use League\Flysystem\AwsS3v3\AwsS3Adapter;
use League\Flysystem\Filesystem;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * @codeCoverageIgnore
 */
final class MoveSpeakerHeadshotFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     * @return FlysystemMoveSpeakerHeadshot
     * @throws \InvalidArgumentException
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $container,
        $requestedName,
        array $options = null
    ) : FlysystemMoveSpeakerHeadshot {
        return new FlysystemMoveSpeakerHeadshot(
            new Filesystem(
                new AwsS3Adapter(
                    new S3Client($container->get('config')['phph-site']['s3']),
                    $container->get('config')['phph-site']['s3']['bucket']
                )
            )
        );
    }
}
