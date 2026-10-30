'use strict';

const test = require('node:test');
const assert = require('node:assert/strict');
const h = require('./_helpers.cjs');

/**
 * O pacote é um agregador, sem código em src/. Por isso não roda PHPStan:
 * docs/AUTOMACAO.md, seções "composer.json" e "phpstan.neon".
 */
test.describe('phpstan.neon', () => {
    test('não existe (o pacote não tem código em src/ para analisar)', () => {
        assert.ok(!h.exists('phpstan.neon'), 'phpstan.neon não deveria existir');
        assert.ok(!h.exists('phpstan.neon.dist'), 'phpstan.neon.dist não deveria existir');
    });

    test('não existe arquivo de baseline do PHPStan', () => {
        assert.deepEqual(h.namesIn('.').filter((n) => /phpstan|baseline.*\.neon$/i.test(n) && !/^\.phpstan\.cache$/.test(n)), []);
    });

    test('o pacote não tem a pasta src/', () => {
        assert.ok(!h.exists('src'), 'src/ não deveria existir: o pacote é um agregador');
    });
});
