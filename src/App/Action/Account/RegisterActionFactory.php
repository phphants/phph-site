<?php
declare(strict_types=1);

namespace App\Action\Account;

use App\Form\Account\RegisterForm;
use App\Service\User\PhpPasswordHash;
use Doctrine\ORM\EntityManagerInterface;
use Interop\Container\ContainerInterface;
use Zend\Expressive\Helper\UrlHelper;
use Zend\Expressive\Template\TemplateRendererInterface;

/**
 * @codeCoverageIgnore
 */
final class RegisterActionFactory
{
    public function __invoke(ContainerInterface $container) : RegisterAction
    {
        return new RegisterAction(
            $container->get(EntityManagerInterface::class),
            new PhpPasswordHash(),
            $container->get(TemplateRendererInterface::class),
            $container->get(UrlHelper::class),
            new RegisterForm()
        );
    }
}
