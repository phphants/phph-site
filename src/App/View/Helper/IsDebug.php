<?php
declare(strict_types=1);

namespace App\View\Helper;

use Zend\View\Helper\AbstractHelper;

final class IsDebug extends AbstractHelper
{
    /**
     * @var bool
     */
    private $isDebug;

    public function __construct(bool $isDebug)
    {
        $this->isDebug = $isDebug;
    }

    public function __invoke() : bool
    {
        return $this->isDebug;
    }
}
