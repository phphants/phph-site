<?php
declare(strict_types=1);

namespace App\View\Helper;

use Zend\View\Helper\AbstractHelper;

final class SpeakerHeadshot extends AbstractHelper
{
    /**
     * @var string
     */
    private $region;

    /**
     * @var string
     */
    private $bucket;

    public function __construct(string $region, string $bucket)
    {
        $this->region = $region;
        $this->bucket = $bucket;
    }

    public function __invoke(string $filename): string
    {
        return sprintf('https://s3.%s.amazonaws.com/%s/%s', $this->region, $this->bucket, $filename);
    }
}
