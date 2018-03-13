<?php
declare(strict_types=1);

namespace App\Action\Account\Settings;

use App\Form\Account\ChangeProfileForm;
use App\Service\Authentication\AuthenticationServiceInterface;
use App\Service\User\FindUserByEmailInterface;
use App\Validator\UserDoesNotExistValidator;
use Doctrine\ORM\EntityManagerInterface;
use Interop\Container\ContainerInterface;
use Zend\Expressive\Helper\UrlHelper;
use Zend\Expressive\Template\TemplateRendererInterface;

/**
 * @codeCoverageIgnore
 */
final class ChangeProfileHandlerFactory
{
    /**
     * @param ContainerInterface $container
     * @return ChangeProfileHandler
     * @throws \Zend\Form\Exception\InvalidArgumentException
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container) : ChangeProfileHandler
    {
        return new ChangeProfileHandler(
            $container->get(TemplateRendererInterface::class),
            new ChangeProfileForm(new UserDoesNotExistValidator($container->get(FindUserByEmailInterface::class))),
            $container->get(UrlHelper::class),
            $container->get(EntityManagerInterface::class),
            $container->get(AuthenticationServiceInterface::class)
        );
    }
}
