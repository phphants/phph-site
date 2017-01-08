<?php
declare(strict_types=1);

namespace App\Action\Account;

use App\Form\Account\RegisterForm;
use App\Service\GoogleRecaptcha\VerifyGoogleRecaptcha;
use App\Service\User\PhpPasswordHash;
use App\Validator\GoogleRecaptchaValidator;
use Doctrine\ORM\EntityManagerInterface;
use Http\Adapter\Guzzle6\Client;
use Interop\Container\ContainerInterface;
use Zend\Diactoros\Request;
use Zend\Expressive\Helper\UrlHelper;
use Zend\Expressive\Template\TemplateRendererInterface;

/**
 * @codeCoverageIgnore
 */
final class RegisterActionFactory
{
    public function __invoke(ContainerInterface $container) : RegisterAction
    {
        $recaptchaConfig = $container->get('config')['phph-site']['google-recaptcha'];

        return new RegisterAction(
            $container->get(EntityManagerInterface::class),
            new PhpPasswordHash(),
            $container->get(TemplateRendererInterface::class),
            $container->get(UrlHelper::class),
            new RegisterForm(
                new GoogleRecaptchaValidator(
                    new VerifyGoogleRecaptcha(
                        new Client(),
                        (new Request($recaptchaConfig['api-url'], 'POST'))
                            ->withHeader('Content-type', 'application/x-www-form-urlencoded'),
                        $recaptchaConfig['secret-key']
                    )
                ),
                $recaptchaConfig['site-key']
            )
        );
    }
}
