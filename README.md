# phph-site

Website for www.phphants.co.uk.

For more information, visit us at [PHP Hampshire](http://phphants.co.uk).

[![Build Status](https://travis-ci.org/phphants/phph-site.svg?branch=master)](https://travis-ci.org/phphants/phph-site) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/phphants/phph-site/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/phphants/phph-site/?branch=master) [![Code Coverage](https://scrutinizer-ci.com/g/phphants/phph-site/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/phphants/phph-site/?branch=master) [![Latest Stable Version](https://poser.pugx.org/phphants/phph-site/v/stable)](https://packagist.org/packages/phphants/phph-site) [![License](https://poser.pugx.org/phphants/phph-site/license)](https://packagist.org/packages/phphants/phph-site)

## Installation

### Prerequisites

 * Docker
 * Docker Compose

### Project setup

First, you need to configure the application:

```bash
cp config/autoload/local.php.dist config/autoload/local.php
```

Edit the configuration file accordingly with API tokens as required.
You'll need to create applications and generate tokens for:

 * Twitter (for social login)
 * GitHub (for social login)
 * Google recaptcha (for registration form captcha)
 * AWS S3 (for avatar storage)

The DB URL for the Docker environment is:

```
postgres://postgres:postgres@phph-postgres/phphants
```

Then, create the docker containers:

```bash
$ docker-compose build
```

And run the environment with:

```bash
$ docker-compose up --abort-on-container-exit --force-recreate
```

Once up and running, you can run the migrations to create the schema:

```bash
$ ./run-in-php-docker.sh vendor/bin/doctrine-migrations migrations:migrate
```

You'll have a blank database now. For testing purposes, you can create
seed data using this command:

```bash
$ ./run-in-php-docker.sh php data/migrations/create-sample-fixtures.php
```

Don't run this on production though! You can now log in with one of two
users:

 * `admin@phphants.co.uk` / `password`
 * `attendee@phphants.co.uk` / `password`

## Front end assets

Front end assets are built using [Gulp](http://gulpjs.com/). The two main useful commands are `gulp` (to watch for
changes) and `gulp build` (a one-off build of front end assets).

#### Initial setup

First, install `gulp-cli` globally, if you haven't already:

```bash
$ npm install gulp-cli -g
```

Then just install the local packages:

```bash
$ npm install
```

#### Watching files for changes

Whilst working on front end assets it is useful to automatically rebuild the CSS/JS. This is the `default` mode of the
`Gulpfile.js` included, so you can just run `gulp` directly:

```bash
$ gulp
[08:50:54] Using gulpfile ~/workspace/phph-site/gulpfile.js
[08:50:54] Starting 'styles'...
[08:50:54] Finished 'styles' after 17 ms
[08:50:54] Starting 'scripts'...
[08:50:54] Finished 'scripts' after 1.17 ms
[08:50:54] Starting 'build'...
[08:50:54] Finished 'build' after 773 μs
[08:50:54] Starting 'default'...
[08:50:54] Finished 'default' after 14 ms

```

Press `Ctrl+C` (Win/Lin) or `Cmd+C` (Mac) when you are finished to exit Gulp.

#### One-off build

If you need to build the front end assets just once, you can run `gulp build` which does the same as `gulp` but exits
immediately after build (no watching files):

```bash
$ gulp build
[08:57:52] Using gulpfile ~/workspace/phph-site/gulpfile.js
[08:57:52] Starting 'styles'...
[08:57:52] Finished 'styles' after 17 ms
[08:57:52] Starting 'scripts'...
[08:57:52] Finished 'scripts' after 1.16 ms
[08:57:52] Starting 'build'...
[08:57:52] Finished 'build' after 793 μs
$
```
