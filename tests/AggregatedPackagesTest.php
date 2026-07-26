<?php

declare(strict_types=1);

namespace Elavora\Api\DataTypes\Tests;

use Elavora\Api\DataTypes\Base64;
use Elavora\Api\DataTypes\Brazil\Cnpj;
use Elavora\Api\DataTypes\Brazil\Cpf;
use Elavora\Api\DataTypes\DateTime;
use Elavora\Api\DataTypes\Email;
use Elavora\Api\DataTypes\Filesystem\FileName;
use Elavora\Api\DataTypes\Filesystem\FilePath;
use Elavora\Api\DataTypes\Filesystem\FolderName;
use Elavora\Api\DataTypes\Filesystem\FolderPath;
use Elavora\Api\DataTypes\Json;
use Elavora\Api\DataTypes\Storage\StorageKey;
use Elavora\Api\DataTypes\Url;
use Elavora\Api\DataTypes\Uuid;
use Elavora\Api\Framework\Contracts\DataType;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class AggregatedPackagesTest extends TestCase
{
    /**
     * @param class-string<DataType> $dataType
     */
    #[DataProvider('dataTypes')]
    public function testProvidesEveryDeclaredDataType(string $dataType): void
    {
        self::assertTrue(is_subclass_of($dataType, DataType::class));
    }

    /**
     * @return iterable<string, array{class-string<DataType>}>
     */
    public static function dataTypes(): iterable
    {
        yield 'base64' => [Base64::class];
        yield 'cnpj' => [Cnpj::class];
        yield 'cpf' => [Cpf::class];
        yield 'date-time' => [DateTime::class];
        yield 'email' => [Email::class];
        yield 'file-name' => [FileName::class];
        yield 'file-path' => [FilePath::class];
        yield 'folder-name' => [FolderName::class];
        yield 'folder-path' => [FolderPath::class];
        yield 'json' => [Json::class];
        yield 'storage-key' => [StorageKey::class];
        yield 'url' => [Url::class];
        yield 'uuid' => [Uuid::class];
    }
}
