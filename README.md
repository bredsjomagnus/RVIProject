
**Scrutinizer**

[![Build Status](https://scrutinizer-ci.com/g/bredsjomagnus/RVIProject/badges/build.png?b=master)](https://scrutinizer-ci.com/g/bredsjomagnus/RVIProject/build-status/master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/bredsjomagnus/RVIProject/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/bredsjomagnus/RVIProject/?branch=master)
<!-- [![Code Coverage](https://scrutinizer-ci.com/g/bredsjomagnus/RVIProject/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/bredsjomagnus/RVIProject/?branch=master) -->

**Travis**

[![Build Status](https://travis-ci.org/bredsjomagnus/RVIProject.svg?branch=master)](https://travis-ci.org/bredsjomagnus/RVIProject)

RVIProject
-------------

Ett skolarbete som bygger på modulen maaa16/commentary

### Commentary
#### För installation av modulen

composer require maaa16/commentary

Konfigurationsfiler

rsync -av vendor/maaa16/commentary/config/commentary* config

#### Route filer

rsync -av vendor/maaa16/commentary/config/route/commentary.php config/route

Det behövs andra route filer till config/route.php. Det finns exempel i vendor/maaa16/commentary/config/route.php.

#### DI service

Lägg till di service i config/di.php. Det finns exempel i vendor/maaa16/commentary/config/di.php.

### Paginator
#### För installation av paginatorn
Denna modul finns inte på packagist utan måste tas härifrån src/Paginator

####License

This software carries a MIT license.
