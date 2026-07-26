# elavora/api-datatypes

Pacote agregador dos DataTypes Elavora API.

## Requisitos

- PHP 8.3 ou superior.
- Demais requisitos declarados em [`composer.json`](composer.json).

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

Consulte o [guia de uso](docs/USO.md) para validar o pacote localmente.
