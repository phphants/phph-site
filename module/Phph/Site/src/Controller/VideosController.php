<?php

namespace Phph\Site\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class VideosController extends AbstractActionController
{
    protected $videos = [
        [
            'code' => 'P9TReLHjLTM',
            'title' => 'Generated Power - PHP 5.5 Generators',
            'speaker' => 'Mark Baker',
            'date' => '10th June 2015',
        ],
        [
            'code' => 'ONIPTP1nVZ0',
            'title' => 'Voodoo PHP',
            'speaker' => 'Marco Pivetta',
            'date' => '13th May 2015',
        ],
        [
            'code' => 'NrUsD8yAAIE',
            'title' => 'Debugging: past, present and future',
            'speaker' => 'Derick Rethans',
            'date' => '8th April 2015',
        ],
        [
            'code' => 'HNdDuDuxZOM',
            'title' => 'Your API is a UI',
            'speaker' => 'Christopher Hoult',
            'date' => '11th March 2015',
        ],
        [
            'code' => 'Pze7HZL2w0Y',
            'title' => 'Test Strategies &amp;&amp; Process',
            'speaker' => 'Owen Beresford',
            'date' => '11th February 2015',
        ],
        [
            'code' => 'Ch8hu0A0yB0',
            'title' => "Don't code, bake. An introduction to CakePHP",
            'speaker' => 'David Yell',
            'date' => '8th October 2014',
        ],
        [
            'code' => 'ChEJQdlVtLU',
            'title' => 'Introducing the OWASP Top 10',
            'speaker' => 'Gary Hockin',
            'date' => '10th September 2014',
        ],
        [
            'code' => 'Wwg8lT2pxU0',
            'title' => 'Bring Your Application Into 2014',
            'speaker' => 'Michael Heap',
            'date' => '14th May 2014',
        ],
        [
            'code' => 'j2zosvPs1UI',
            'title' => 'Enabling Agile through enabling BDD in PHP projects',
            'speaker' => 'Konstantin Kudryashov',
            'date' => '9th April 2014',
        ],
        [
            'code' => 'sY_cKzwyC5k',
            'title' => 'What RabbitMQ Can Do For You',
            'speaker' => 'James Titcumb',
            'date' => '9th April 2014',
        ],
        [
            'code' => '4t5EKEZz724',
            'title' => 'Functional PHP',
            'speaker' => 'Simon Holywell',
            'date' => '12th February 2014',
        ],
        [
            'code' => '2A-r_VmLIWw',
            'title' => 'Why Open Source is good for you (and your organisation)',
            'speaker' => 'Michael Cullum',
            'date' => '8th January 2014',
        ],
        [
            'code' => 'Ayh39Vac0vs',
            'title' => 'HOW TO DEVELOP YOUR DEVELOPMENT OF BEING A DEVELOPER WITHOUT DOING ANY DEVELOPMENT',
            'speaker' => 'Phil Bennett',
            'date' => '11th December 2013',
        ],
        [
            'code' => 'KjhYc3uO3kY',
            'title' => 'PHP and Enums',
            'speaker' => 'Gareth Evans',
            'date' => '11th December 2013',
        ],
        [
            'code' => 'NnhkNhM3aDQ',
            'title' => 'Errors, Exceptions and Logging',
            'speaker' => 'James Titcumb',
            'date' => '9th October 2013',
        ],
        [
            'code' => 'nnDUSkvdvWg',
            'title' => 'Composer Tutorial',
            'speaker' => 'James Titcumb',
            'date' => '11th September 2013',
        ],
        [
            'code' => '3yHiQ2tIcoQ',
            'title' => 'PHP FIG: Standardising PHP',
            'speaker' => 'Michael Cullum',
            'date' => '11th September 2013',
        ],
    ];

    public function indexAction()
    {
        return ['videos' => $this->videos];
    }
}
