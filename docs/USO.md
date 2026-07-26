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

- As dependencias diretas e suas faixas suportadas estao declaradas em [`composer.json`](../composer.json).

## Validacao no projeto consumidor

Execute os comandos a partir da raiz do clone:

```bash
docker run --rm -v "${PWD}:/workspace" -w /workspace composer:2 composer update --no-interaction --no-progress --prefer-dist
docker run --rm -v "${PWD}:/workspace" -w /workspace composer:2 composer check
```

## Observacoes

- Para poucos tipos, prefira instalar somente os pacotes necessarios.
- O agregador nao adiciona regras alem das implementadas pelos pacotes individuais.
