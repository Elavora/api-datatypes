# Guia de uso

Pacote agregador dos DataTypes Elavora API.

## Instalacao

```bash
composer require elavora/api-datatypes
```

Requisitos: PHP 8.3 ou superior. O pacote nao tem codigo proprio (nao ha `src/`): ele so exige os 13 datatypes
abaixo, todos na versao `^1.0`, e os instala junto com o `elavora/api-datatype-core` `^2.0` e o
`elavora/api-framework` `^2.0`.

## Quando usar

- Usar um conjunto amplo de DataTypes genericos.
- Evitar instalar cada DataType individualmente em prototipos ou apps pequenas.
- Padronizar validacao de valores comuns.

## Exemplo rapido

```php
use Elavora\Api\DataTypes\Brazil\Cpf;
use Elavora\Api\DataTypes\Email;

$cpf = Cpf::from('529.982.247-25');
$cpf->value(); // '52998224725'

$email = Email::from('TEAM@BIFROST.DEV');
$email->value(); // 'team@bifrost.dev'
```

Cada datatype tem a propria pagina de uso, com as regras e os exemplos de entrada valida e invalida (veja a
[lista dos pacotes](#pacotes-incluidos)). O agregador nao muda nenhuma regra.

## Pacotes incluidos

Todos exigem PHP 8.3 ou superior. A coluna "Versao minima" e a restricao do `composer.json` do agregador.

| Pacote | Versao minima | Classe |
| --- | --- | --- |
| `elavora/api-datatype-base64` | `^1.0` | `Elavora\Api\DataTypes\Base64` |
| `elavora/api-datatype-cnpj` | `^1.0` | `Elavora\Api\DataTypes\Brazil\Cnpj` |
| `elavora/api-datatype-cpf` | `^1.0` | `Elavora\Api\DataTypes\Brazil\Cpf` |
| `elavora/api-datatype-date-time` | `^1.0` | `Elavora\Api\DataTypes\DateTime` |
| `elavora/api-datatype-email` | `^1.0` | `Elavora\Api\DataTypes\Email` |
| `elavora/api-datatype-file-name` | `^1.0` | `Elavora\Api\DataTypes\Filesystem\FileName` |
| `elavora/api-datatype-file-path` | `^1.0` | `Elavora\Api\DataTypes\Filesystem\FilePath` |
| `elavora/api-datatype-folder-name` | `^1.0` | `Elavora\Api\DataTypes\Filesystem\FolderName` |
| `elavora/api-datatype-folder-path` | `^1.0` | `Elavora\Api\DataTypes\Filesystem\FolderPath` |
| `elavora/api-datatype-json` | `^1.0` | `Elavora\Api\DataTypes\Json` |
| `elavora/api-datatype-storage-key` | `^1.0` | `Elavora\Api\DataTypes\Storage\StorageKey` |
| `elavora/api-datatype-url` | `^1.0` | `Elavora\Api\DataTypes\Url` |
| `elavora/api-datatype-uuid` | `^1.0` | `Elavora\Api\DataTypes\Uuid` |

Todos estendem `Elavora\Api\DataTypes\AbstractDataType`, do `elavora/api-datatype-core`, e tem `from()`, `isValid()`,
`value()` e `jsonSerialize()`. O `Uuid` tem tambem `generate()`, e o `DateTime`, `now()` e `assertFuture()`.

## Principais pontos de entrada

As classes da coluna "Classe" da tabela acima. O agregador nao define classes proprias.

## Dependencias de runtime

- PHP 8.3 ou superior
- os 13 pacotes `elavora/api-datatype-*` `^1.0` da tabela acima

## O que os testes do agregador conferem

Os testes de `tests/` ficam em `tests/DataTypesTest.php` e conferem que os datatypes funcionam juntos, instalados pelo
agregador. Eles nao repetem as regras de cada datatype (essas ficam nos testes de cada pacote). Resumo do que e
conferido, com os valores esperados:

| Chamada | Resultado esperado |
| --- | --- |
| `Email::from('TEAM@BIFROST.DEV')->value()` | `'team@bifrost.dev'` (o email e normalizado para minusculas) |
| `Url::isValid('https://example.com/docs')` | `true` |
| `Base64::isValid(base64_encode('api'))` | `true` |
| `Json::isValid('{"name":"api"}')` | `true` |
| `Uuid::isValid(Uuid::generate()->value())` | `true` |
| `DateTime::from('2026-05-27 10:30:00')->value()` | `'2026-05-27 10:30:00'` |
| `DateTime::isValid('')` e `DateTime::isValid('not a date')` | `false` |
| `Cpf::from('529.982.247-25')->value()` | `'52998224725'` |
| `Cnpj::from('11.222.333/0001-81')->value()` | `'11222333000181'` |
| `FilePath::isValid('avatars/user.png')`, `FileName::isValid('user.png')`, `FolderName::isValid('avatars')`, `FolderPath::isValid('/var/uploads')`, `StorageKey::isValid('documents/report.pdf')` | `true` |
| `StorageKey::from('documents\\report.pdf')->value()` | `'documents/report.pdf'` (a barra invertida vira `/`) |
| `FileName::isValid('.env')`, `FileName::isValid('user/name.png')`, `FolderName::isValid('some.folder')`, `FolderPath::isValid('/var//uploads')`, `FilePath::isValid('../secret.txt')`, `FilePath::isValid('/secret.txt')`, `StorageKey::isValid('/documents/report.pdf')` | `false` |
| `Email::from('invalid')` | lanca `InvalidArgumentException` |
| `Email::from('team@api.dev')` | instancia de `Elavora\Api\Framework\Contracts\Insertable`, com `value()` igual a `'team@api.dev'` |

## Atualizacao da versao anterior

A versao `1.0.0` do agregador exige PHP 8.3 ou superior e sobe todos os datatypes de `^0.1` para `^1.0`. Antes, o
agregador aceitava PHP 8.1 e os datatypes `^0.1`, que dependem do `elavora/api-datatype-core` `^0.1` e nao funcionam
mais com o framework atual. A versao anterior publicada foi a `v0.2.0`.

Quebras desta versao, que vem dos datatypes `1.0` e valem para **todos** os pacotes da tabela:

- **O construtor nao e mais publico.** Crie o objeto so com `X::from(...)` (ou `Uuid::generate()`, no caso do UUID).
  Trocar `new Email('team@api.dev')` por `Email::from('team@api.dev')`. Chamar `new X(...)` fora da classe lanca
  `Error` do PHP.
- **Valor invalido lanca `InvalidArgumentException`** com a mensagem `Valor invalido para <classe>.`, onde `<classe>`
  e o nome completo da classe. Exemplo: `Email::from('invalid')` lanca `InvalidArgumentException` com a mensagem
  `Valor invalido para Elavora\Api\DataTypes\Email.` Quem captura a excecao da versao anterior, ou compara a mensagem,
  precisa se ajustar. `X::isValid(...)` continua sem lancar excecao.

Para migrar, atualize a restricao do PHP e rode `composer update elavora/api-datatypes`. Se a aplicacao exige datatypes
`^0.1` por conta propria, troque para `^1.0`.

Observacao: o pacote `elavora/api-datatype-storage-key` `1.0.0` esta sendo publicado separadamente. Ate ele aparecer
no Packagist, `composer require elavora/api-datatypes` `^1.0` nao resolve. O agregador `1.0.0` so e publicado depois.

## Validacao no projeto consumidor

Depois de instalar o pacote, rode os testes da aplicacao consumidora.

Para validar o pacote isoladamente (testes, lint e como reproduzir o CI), veja
[Desenvolvimento e testes](DESENVOLVIMENTO.md). Este pacote nao tem codigo proprio (nao ha `src/`), entao nao roda
PHPStan. A automacao, as versoes e os arquivos de qualidade do repositorio estao em
[Automacao do repositorio](AUTOMACAO.md).

## Observacoes

- Mantenha regras de produto fora deste pacote.
- Prefira configurar extensoes no bootstrap da aplicacao.
- Instale apenas os modulos que a aplicacao realmente usa.
