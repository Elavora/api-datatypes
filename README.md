# elavora/api-datatypes

[![Packagist Version](https://img.shields.io/packagist/v/elavora/api-datatypes.svg?style=flat-square)](https://packagist.org/packages/elavora/api-datatypes)
[![PHP Version](https://img.shields.io/packagist/php-v/elavora/api-datatypes.svg?style=flat-square)](https://packagist.org/packages/elavora/api-datatypes)
[![Composer Quality](https://github.com/Elavora/api-datatypes/actions/workflows/quality.yml/badge.svg?branch=main)](https://github.com/Elavora/api-datatypes/actions/workflows/quality.yml)
[![CodeQL](https://github.com/Elavora/api-datatypes/actions/workflows/codeql.yml/badge.svg?branch=main)](https://github.com/Elavora/api-datatypes/actions/workflows/codeql.yml)
[![License](https://img.shields.io/packagist/l/elavora/api-datatypes.svg?style=flat-square)](LICENSE)
Pacote agregador dos DataTypes Elavora API.

## Uso

Instale apenas o DataType que sua aplicacao usa:

```bash
composer require elavora/api-datatype-email
composer require elavora/api-datatype-cpf
```

Se quiser todos os DataTypes mantidos pelo Elavora API, use o agregador:

```bash
composer require elavora/api-datatypes
```

```php
use Elavora\Api\DataTypes\Brazil\Cpf;
use Elavora\Api\DataTypes\Email;

$cpf = Cpf::from('529.982.247-25');
$email = Email::from('team@api.dev');
```

Todos os tipos implementam `Elavora\Api\Framework\Contracts\DataType`, por isso
podem ser usados em attributes do framework:

```php
#[RequiredFields(['email' => Email::class, 'cpf' => Cpf::class])]
```
