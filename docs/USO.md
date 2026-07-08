# Guia de uso

Pacote agregador dos DataTypes Elavora API.

## Instalacao

```bash
composer require elavora/api-datatypes
```

## Quando usar

- Usar um conjunto amplo de DataTypes genericos.
- Evitar instalar cada DataType individualmente em prototipos ou apps pequenas.
- Padronizar validacao de valores comuns.

## Exemplo rapido

```bash
composer require elavora/api-datatypes
```

Instale este pacote quando a aplicacao precisar de varios DataTypes genericos de uma vez.

## Principais pontos de entrada

- Consulte `composer.json` e `README.md` para os pontos de entrada do pacote.

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

## Validacao no projeto consumidor

Depois de instalar o pacote, rode os testes da aplicacao consumidora. Para uma verificacao isolada do pacote, use container:

```bash
docker run --rm -v "${PWD}:/workspace" -w "/workspace/api-datatypes" composer:2 composer validate --strict --no-check-publish
docker run --rm -v "${PWD}:/workspace" -w "/workspace/api-datatypes" composer:2 sh -lc "find . \\( -path ./.git -o -path ./vendor \\) -prune -o -name '*.php' -print0 | xargs -0 -r -n1 php -l"
```

## Observacoes

- Mantenha regras de produto fora deste pacote.
- Prefira configurar extensoes no bootstrap da aplicacao.
- Instale apenas os modulos que a aplicacao realmente usa.