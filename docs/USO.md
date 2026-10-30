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

Depois de instalar o pacote, rode os testes da aplicacao consumidora.

Para validar o pacote isoladamente (testes, lint e como reproduzir o CI), veja
[Desenvolvimento e testes](DESENVOLVIMENTO.md). Este pacote nao tem codigo proprio (nao ha `src/`), entao nao roda
PHPStan. A automacao, as versoes e os arquivos de qualidade do repositorio estao em
[Automacao do repositorio](AUTOMACAO.md).

## Observacoes

- Mantenha regras de produto fora deste pacote.
- Prefira configurar extensoes no bootstrap da aplicacao.
- Instale apenas os modulos que a aplicacao realmente usa.