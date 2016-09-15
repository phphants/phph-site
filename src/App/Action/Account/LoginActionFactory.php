<?php
declare(strict_types=1);

namespace App\Action\Account;

use App\Form\Account\LoginForm;
use App\Service\Authentication\AuthenticationServiceInterface;
use Interop\Container\ContainerInterface;
use Zend\Expressive\Helper\UrlHelper;
use Zend\Expressive\Template\TemplateRendererInterface;

/**
 * @codeCoverageIgnore
 */
final class LoginActionFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new LoginAction(
            $container->get(AuthenticationServiceInterface::class),
            $container->get(TemplateRendererInterface::class),
            $container->get(UrlHelper::class),
            new LoginForm()
        );
    }
}
