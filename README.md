# phph-site

Website for www.phphants.co.uk.

For more information, visit us at [PHP Hampshire](http://phphants.co.uk).

[![Build Status](https://travis-ci.org/phphants/phph-site.svg?branch=master)](https://travis-ci.org/phphants/phph-site) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/phphants/phph-site/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/phphants/phph-site/?branch=master) [![Code Coverage](https://scrutinizer-ci.com/g/phphants/phph-site/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/phphants/phph-site/?branch=master) [![Latest Stable Version](https://poser.pugx.org/phphants/phph-site/v/stable)](https://packagist.org/packages/phphants/phph-site) [![License](https://poser.pugx.org/phphants/phph-site/license)](https://packagist.org/packages/phphants/phph-site)

## Installation

### PHP Dependencies

```bash
git clone https://github.com/phphants/phph-site.git
cd phph-site
composer install
vendor/bin/doctrine-migrations migrate
```

### Front end assets

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

### Virtual Host

Afterwards, set up a virtual host to point to to the `public/` directory of the project. For example in Apache:

```apacheconfig
<VirtualHost *:80>
  ServerName phph.localhost
  DocumentRoot /path/to/phph-site/public
</VirtualHost>
```
