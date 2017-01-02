<?php
declare(strict_types = 1);

namespace App\Form\Account;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UploadedFileInterface;
use Zend\Filter\File\RenameUpload;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\Form\Element\Csrf;
use Zend\Form\Element\File;
use Zend\Form\Element\Submit;
use Zend\Form\Element\Text;
use Zend\Form\Element\Textarea;
use Zend\Form\Form;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Validator\File\ImageSize;
use Zend\Validator\File\IsImage;

class SpeakerForm extends Form implements InputFilterProviderInterface
{
    public function __construct()
    {
        parent::__construct('speakerForm');

        $this->add((new Text('name'))->setLabel('Name'));
        $this->add((new Text('twitter'))->setLabel('Twitter Handle'));
        $this->add((new Textarea('biography'))->setLabel('Biography'));
        $this->add((new File('imageFilename'))->setLabel('Headshot (must be square)'));

        $this->add((new Submit('submit'))->setValue('Save'));
        $this->add(new Csrf('speakerForm_csrf', [
            'csrf_options' => [
                'timeout' => 120,
            ],
        ]));
    }

    public function getInputFilterSpecification() : array
    {
        return [
            'name' => [
                'required' => true,
                'filters' => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                ],
            ],
            'twitter' => [
                'required' => false,
                'filters' => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                ],
            ],
            'biography' => [
                'required' => true,
                'filters' => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                ],
            ],
            'imageFilename' => [
                'required' => false,
                'validators' => [
                    [
                        'name' => IsImage::class,
                        'options' => [
                            'magicFile' => false,
                        ],
                    ],
                    [
                        'name' => ImageSize::class,
                        'options' => [
                            'minWidth' => 200,
                            'maxWidth' => 200,
                            'minHeight' => 200,
                            'maxHeight' => 200,
                        ],
                    ],
                ],
            ],
        ];
    }

    /**
     * Wraps set data but also injects uploaded files from a PSR-7 compatible request
     *
     * @param string[] $parsedBody
     * @param UploadedFileInterface[] $uploadedFiles
     * @return SpeakerForm
     * @throws \Zend\Form\Exception\InvalidArgumentException
     */
    public function setDataWithUploadedFiles(array $parsedBody, array $uploadedFiles) : self
    {
        foreach ($uploadedFiles as $key => $uploadedFile) {
            $parsedBody[$key] = $this->uploadedFileToArray($uploadedFile);
        }
        return $this->setData($parsedBody);
    }

    private function uploadedFileToArray(UploadedFileInterface $uploadedFile)
    {
        try {
            $tmpName = $uploadedFile->getStream()->getMetadata('uri');
        } catch (\RuntimeException $exception) {
            $tmpName = null;
        }
        return [
            'tmp_name' => $tmpName,
            'name' => $uploadedFile->getClientFilename(),
            'type' => $uploadedFile->getClientMediaType(),
            'size' => $uploadedFile->getSize(),
            'error' => $uploadedFile->getError()
        ];
    }
}
