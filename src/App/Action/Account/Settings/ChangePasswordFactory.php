<?php
declare(strict_types=1);

namespace App\Action\Account\Settings;

use App\Form\Account\ChangePasswordForm;
use App\Service\Authentication\AuthenticationServiceInterface;
use App\Service\User\PhpPasswordHash;
use Doctrine\ORM\EntityManagerInterface;
use Interop\Container\ContainerInterface;
use Zend\Expressive\Helper\UrlHelper;
use Zend\Expressive\Template\TemplateRendererInterface;

/**
 * @codeCoverageIgnore
 */
final class ChangePasswordFactory
{
    /**
     * @param ContainerInterface $container
     * @return ChangePassword
     * @throws \Zend\Form\Exception\InvalidArgumentException
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container) : ChangePassword
    {
        return new ChangePassword(
            $container->get(TemplateRendererInterface::class),
            new ChangePasswordForm(),
            $container->get(UrlHelper::class),
            $container->get(EntityManagerInterface::class),
            $container->get(AuthenticationServiceInterface::class),
            new PhpPasswordHash()
        );
    }
}
