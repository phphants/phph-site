<?php

namespace Phph\Site\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class VideosController extends AbstractActionController
{
    protected $videos = array(
        array(
            'code' => 'j2zosvPs1UI',
            'title' => 'Enabling Agile through enabling BDD in PHP projects ',
            'speaker' => 'Konstantin Kudryashov',
            'date' => '9th April 2014',
        ),
        array(
            'code' => 'sY_cKzwyC5k',
            'title' => 'What RabbitMQ Can Do For You',
            'speaker' => 'James Titcumb',
            'date' => '9th April 2014',
        ),
        array(
            'code' => '4t5EKEZz724',
            'title' => 'Functional PHP',
            'speaker' => 'Simon Holywell',
            'date' => '12th February 2014',
        ),
        array(
            'code' => '2A-r_VmLIWw',
            'title' => 'Why Open Source is good for you (and your organisation)',
            'speaker' => 'Michael Cullum',
            'date' => '8th January 2014',
        ),
        array(
            'code' => 'Ayh39Vac0vs',
            'title' => 'HOW TO DEVELOP YOUR DEVELOPMENT OF BEING A DEVELOPER WITHOUT DOING ANY DEVELOPMENT',
            'speaker' => 'Phil Bennett',
            'date' => '11th December 2013',
        ),
        array(
            'code' => 'KjhYc3uO3kY',
            'title' => 'PHP and Enums',
            'speaker' => 'Gareth Evans',
            'date' => '11th December 2013',
        ),
        array(
            'code' => 'NnhkNhM3aDQ',
            'title' => 'Errors, Exceptions and Logging',
            'speaker' => 'James Titcumb',
            'date' => '9th October 2013',
        ),
        array(
            'code' => 'nnDUSkvdvWg',
            'title' => 'Composer Tutorial',
            'speaker' => 'James Titcumb',
            'date' => '11th September 2013',
        ),
        array(
            'code' => '3yHiQ2tIcoQ',
            'title' => 'PHP FIG: Standardising PHP',
            'speaker' => 'Michael Cullum',
            'date' => '11th September 2013',
        ),
    );

    public function indexAction()
    {
        return array('videos' => $this->videos);
    }
}
