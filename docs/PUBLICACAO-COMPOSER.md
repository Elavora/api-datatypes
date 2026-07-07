# Publicacao Composer

Este documento registra o minimo operacional para publicar e validar o pacote $package.

## Pacote

- Repositorio: $repoUrl
- Packagist: $packagistUrl
- Tipo Composer: $type
- Descricao: Pacote agregador dos DataTypes Elavora API.
- PHP: $php

## Instalacao

``bash
composer require elavora/api-datatypes
``

## Dependencias de runtime

- `elavora/api-datatype-base64` `^0.1`
- `elavora/api-datatype-cnpj` `^0.1`
- `elavora/api-datatype-cpf` `^0.1`
- `elavora/api-datatype-date-time` `^0.1`
- `elavora/api-datatype-email` `^0.1`
- `elavora/api-datatype-file-name` `^0.1`
- `elavora/api-datatype-file-path` `^0.1`
- `elavora/api-datatype-folder-name` `^0.1`
- `elavora/api-datatype-folder-path` `^0.1`
- `elavora/api-datatype-json` `^0.1`
- `elavora/api-datatype-storage-key` `^0.1`
- `elavora/api-datatype-url` `^0.1`
- `elavora/api-datatype-uuid` `^0.1`

## Release

- Tags devem seguir SemVer no formato X.Y.Z.
- O workflow de merge em main cria a tag e publica a release.
- Use a label elease quando a release deve ser estavel.
- Use enhancement para incremento minor e upgrade para incremento major.
- Sem enhancement, dependencies ou upgrade, o workflow incrementa patch.

## Validacao local em container

Execute a partir da raiz do checkout local dos repositorios Elavora:

``bash
docker run --rm -v "${PWD}:/workspace" -w "/workspace/api-datatypes" composer:2 composer validate --strict --no-check-publish
docker run --rm -v "${PWD}:/workspace" -w "/workspace/api-datatypes" composer:2 sh -lc "find . \\( -path ./.git -o -path ./vendor \\) -prune -o -name '*.php' -print0 | xargs -0 -r -n1 php -l"
``

Scripts Composer disponiveis:

- `composer lint`
- `composer test`
- `composer check`

## Packagist

Ao cadastrar no Packagist, use a URL do repositorio GitHub:

``text
https://github.com/Elavora/api-datatypes
``

Depois do cadastro, confirme se o Packagist mostra a ultima tag estavel e teste a instalacao em um container limpo.