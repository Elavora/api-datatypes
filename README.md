# elavora/api-datatypes

[![Packagist Version](https://img.shields.io/packagist/v/elavora/api-datatypes.svg?style=flat-square)](https://packagist.org/packages/elavora/api-datatypes)
[![PHP Version](https://img.shields.io/packagist/php-v/elavora/api-datatypes.svg?style=flat-square)](https://packagist.org/packages/elavora/api-datatypes)
[![Qualidade](https://github.com/Elavora/api-datatypes/actions/workflows/quality.yml/badge.svg?branch=main)](https://github.com/Elavora/api-datatypes/actions/workflows/quality.yml)
[![CodeQL](https://github.com/Elavora/api-datatypes/actions/workflows/codeql.yml/badge.svg?branch=main)](https://github.com/Elavora/api-datatypes/actions/workflows/codeql.yml)
[![License](https://img.shields.io/packagist/l/elavora/api-datatypes.svg?style=flat-square)](LICENSE)

Pacote agregador dos DataTypes Elavora API.

Guia de uso, com a lista dos pacotes e exemplos: [docs/USO.md](docs/USO.md).

## Uso

Instale apenas o DataType que sua aplicação usa:

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

## Desenvolvimento e testes

Este pacote não tem código próprio (não há `src/`): ele só reúne os DataTypes, e os testes conferem que eles
funcionam juntos. Por isso não roda PHPStan.

Você só precisa de Docker. O ambiente é a imagem `ghcr.io/elavora/php-dev:8.3-latest`: abra o repositório no VS Code
com **Dev Containers: Reopen in Container**, ou rode no PowerShell:

```powershell
docker run --rm --mount "type=bind,source=$($PWD.Path),target=/workspace" -w /workspace ghcr.io/elavora/php-dev:8.3-latest sh -lc 'git config --global --add safe.directory /workspace && composer install --no-interaction --prefer-dist && composer check'
```

Scripts do Composer:

```bash
composer check     # lint e testes
composer test      # testes PHPUnit
composer lint      # sintaxe (elavora-standards lint)
```

O código dos testes segue o padrão PER-CS, com as regras do pacote `elavora/code-standards`. No devcontainer, o arquivo é
formatado ao salvar; no PR, o CI formata o que faltou e commita a correção (`style: organiza o código`).
Os testes rodam no CI, no workflow **Qualidade**, em todo PR. O passo a passo, o que roda no CI e como reproduzi-lo
estão em [Desenvolvimento e testes](docs/DESENVOLVIMENTO.md).

## Como contribuir

1. Crie uma branch a partir da `main` (`feat/...`, `fix/...` ou `docs/...`).
2. Faça commits em português do Brasil, no padrão Conventional Commits (`feat: ...`, `fix: ...`, `docs: ...`).
3. Rode `composer check` antes de abrir o PR.
4. Abra o PR para a `main`, preencha o template e aplique as labels que definem a versão
   ([Versões e release](docs/AUTOMACAO.md#versões-e-release)).
5. Confira o comentário do pipeline de qualidade no PR. Ele não bloqueia o merge, mas quem revisa olha o resultado.

## Versões

Versão `1.0.0`: exige PHP 8.3 ou superior e atualiza os 13 datatypes de `^0.1` para `^1.0` (`base64`, `cnpj`, `cpf`,
`date-time`, `email`, `file-name`, `file-path`, `folder-name`, `folder-path`, `json`, `storage-key`, `url` e `uuid`),
que usam o `elavora/api-datatype-core` `^2.0` e o `elavora/api-framework` `^2.0`. Antes eram PHP 8.1 e `^0.1`, que não
funcionam mais com o framework atual. A versão traz duas quebras, que vêm dos datatypes `1.0`:

- o construtor de cada datatype deixa de ser público: a criação é só por `X::from(...)`;
- valor inválido lança `InvalidArgumentException` com a mensagem `Valor invalido para <classe>.`

Os detalhes, a lista dos pacotes com a versão mínima e a migração estão no
[Guia de uso](docs/USO.md#atualizacao-da-versao-anterior).

Cada PR integrado na `main` gera uma versão automaticamente, conforme as labels do PR: sem a label `release` sai uma
beta (`1.1.0-beta.1`), com ela sai a estável (`1.1.0`). As tags novas não têm o prefixo `v`, e as notas de cada
GitHub Release são geradas em português a partir dos PRs. Veja [Versões e release](docs/AUTOMACAO.md#versões-e-release).

## Documentação

1. [Guia de uso](docs/USO.md): os pacotes que o agregador traz e exemplos.
2. [Desenvolvimento e testes](docs/DESENVOLVIMENTO.md): ambiente, como rodar os testes e o que roda no CI.
3. [Automação do repositório](docs/AUTOMACAO.md): workflows, Dependabot, estilo de código, labels e versões.

## Licença

MIT
