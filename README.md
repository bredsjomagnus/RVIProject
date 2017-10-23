
**Scrutinizer**

[![Build Status](https://scrutinizer-ci.com/g/bredsjomagnus/RVIProject/badges/build.png?b=master)](https://scrutinizer-ci.com/g/bredsjomagnus/RVIProject/build-status/master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/bredsjomagnus/RVIProject/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/bredsjomagnus/RVIProject/?branch=master)
<!-- [![Code Coverage](https://scrutinizer-ci.com/g/bredsjomagnus/RVIProject/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/bredsjomagnus/RVIProject/?branch=master) -->

**Travis**

[![Build Status](https://travis-ci.org/bredsjomagnus/RVIProject.svg?branch=master)](https://travis-ci.org/bredsjomagnus/RVIProject)

RVIProject
-------------

Ett skolarbete som bygger på modulen maaa16/commentary

### Commentary för Anax
#### För installation av modulen

composer require maaa16/commentary

#### Konfigurationsfiler

rsync -av vendor/maaa16/commentary/config/commentary* config

#### Route filer

rsync -av vendor/maaa16/commentary/config/route/commentary.php config/route

Det behövs andra route filer till config/route.php. Det finns exempel i vendor/maaa16/commentary/config/route.php.

#### DI service

Lägg till di service i config/di.php. Det finns exempel i vendor/maaa16/commentary/config/di.php.

### Justering av Anax/HTMLForm
Delar av Anax/HTMLForm har redigerats. De filer som redigerats ligger under src/HTMLForm. Ändringen är för att kunna lägga till data-provider i textareas, som då möjliggör användning av [bootstrap-markdown.js](http://github.com/toopay/bootstrap-markdown) v2.10.0 av Taufan Aditya.

### Paginator
Paginator används i vissa fall och installerar man maaa16/commentary enligt ovan behöver man även få med paginatorn.

#### För installation av paginatorn
Denna finns inte på packagist utan måste tas härifrån via src/Paginator

### License

This software carries a MIT license.
