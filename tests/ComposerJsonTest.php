<?php

declare(strict_types=1);

namespace Elavora\Api\DataTypes\Tests;

use PHPUnit\Framework\TestCase;

/**
 * Campos do composer.json do agregador depois do upgrade para os datatypes 1.0.
 *
 * @see docs/USO.md
 * @see docs/AUTOMACAO.md#composerjson
 */
final class ComposerJsonTest extends TestCase
{
    private const DATATYPES = [
        'base64',
        'cnpj',
        'cpf',
        'date-time',
        'email',
        'file-name',
        'file-path',
        'folder-name',
        'folder-path',
        'json',
        'storage-key',
        'url',
        'uuid',
    ];

    /** @var array<string, mixed> */
    private array $composer;

    protected function setUp(): void
    {
        $this->composer = json_decode(
            (string) file_get_contents(dirname(__DIR__) . '/composer.json'),
            true,
            flags: JSON_THROW_ON_ERROR,
        );
    }

    public function testRequiresPhp83(): void
    {
        self::assertSame('>=8.3', $this->composer['require']['php'] ?? null);
    }

    public function testRequiresTheThirteenDatatypesAtVersion1(): void
    {
        foreach (self::DATATYPES as $name) {
            self::assertSame(
                '^1.0',
                $this->composer['require']["elavora/api-datatype-{$name}"] ?? null,
                "elavora/api-datatype-{$name} deveria ser ^1.0",
            );
        }
    }

    public function testRequiresNoOtherPackage(): void
    {
        $expected = ['php'];
        foreach (self::DATATYPES as $name) {
            $expected[] = "elavora/api-datatype-{$name}";
        }
        $actual = array_keys($this->composer['require'] ?? []);
        sort($expected);
        sort($actual);

        self::assertSame($expected, $actual);
    }

    public function testBranchAliasIs10Dev(): void
    {
        self::assertSame('1.0-dev', $this->composer['extra']['branch-alias']['dev-main'] ?? null);
    }

    public function testHasNoProductionAutoload(): void
    {
        self::assertArrayNotHasKey('autoload', $this->composer);
    }

    public function testAutoloadDevIsUnchanged(): void
    {
        self::assertSame(
            ['Elavora\\Api\\DataTypes\\Tests\\' => 'tests/'],
            $this->composer['autoload-dev']['psr-4'] ?? null,
        );
    }

    public function testHasNoRepositories(): void
    {
        self::assertArrayNotHasKey('repositories', $this->composer);
    }
}
