<?php

declare(strict_types=1);

namespace Elavora\Api\DataTypes\Tests;

use Elavora\Api\DataTypes\AbstractDataType;
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
use Elavora\Api\Framework\Contracts\Insertable;
use Error;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

/**
 * Conferem que os datatypes funcionam juntos, instalados pelo agregador.
 *
 * @see docs/USO.md#o-que-os-testes-do-agregador-conferem
 */
final class DataTypesTest extends TestCase
{
    public function testValidatesCommonDataTypes(): void
    {
        self::assertSame('team@bifrost.dev', Email::from('TEAM@BIFROST.DEV')->value());
        self::assertTrue(Url::isValid('https://example.com/docs'));
        self::assertTrue(Base64::isValid(base64_encode('api')));
        self::assertTrue(Json::isValid('{"name":"api"}'));
        self::assertTrue(Uuid::isValid(Uuid::generate()->value()));
    }

    public function testValidatesDateTimeDataType(): void
    {
        self::assertSame(
            '2026-05-27 10:30:00',
            DateTime::from('2026-05-27 10:30:00')->value(),
        );
        self::assertFalse(DateTime::isValid(''));
        self::assertFalse(DateTime::isValid('not a date'));
    }

    public function testValidatesBrazilianDocuments(): void
    {
        self::assertSame('52998224725', Cpf::from('529.982.247-25')->value());
        self::assertSame('11222333000181', Cnpj::from('11.222.333/0001-81')->value());
    }

    public function testValidatesFilesystemDataTypes(): void
    {
        self::assertTrue(FilePath::isValid('avatars/user.png'));
        self::assertTrue(FileName::isValid('user.png'));
        self::assertTrue(FolderName::isValid('avatars'));
        self::assertTrue(FolderPath::isValid('/var/uploads'));
        self::assertTrue(StorageKey::isValid('documents/report.pdf'));
        self::assertSame('documents/report.pdf', StorageKey::from('documents\\report.pdf')->value());

        self::assertFalse(FileName::isValid('.env'));
        self::assertFalse(FileName::isValid('user/name.png'));
        self::assertFalse(FolderName::isValid('some.folder'));
        self::assertFalse(FolderPath::isValid('/var//uploads'));
        self::assertFalse(FilePath::isValid('../secret.txt'));
        self::assertFalse(FilePath::isValid('/secret.txt'));
        self::assertFalse(StorageKey::isValid('/documents/report.pdf'));
    }

    public function testThrowsWhenValueIsInvalid(): void
    {
        $this->expectException(InvalidArgumentException::class);

        Email::from('invalid');
    }

    public function testInvalidValueMessageNamesTheClass(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Valor invalido para Elavora\Api\DataTypes\Email.');

        Email::from('invalid');
    }

    /**
     * @param class-string<AbstractDataType> $class
     */
    #[DataProvider('invalidValues')]
    public function testEveryDataTypeThrowsWithTheDocumentedMessage(string $class, string $value): void
    {
        self::assertFalse($class::isValid($value));

        try {
            $class::from($value);
            self::fail("{$class}::from() deveria lançar InvalidArgumentException");
        } catch (InvalidArgumentException $e) {
            self::assertSame("Valor invalido para {$class}.", $e->getMessage());
        }
    }

    /**
     * @return array<string, array{class-string<AbstractDataType>, string}>
     */
    public static function invalidValues(): array
    {
        return [
            'Base64' => [Base64::class, '***'],
            'Cnpj' => [Cnpj::class, '123'],
            'Cpf' => [Cpf::class, '123'],
            'DateTime' => [DateTime::class, 'not a date'],
            'Email' => [Email::class, 'invalid'],
            'FileName' => [FileName::class, '.env'],
            'FilePath' => [FilePath::class, '../secret.txt'],
            'FolderName' => [FolderName::class, 'some.folder'],
            'FolderPath' => [FolderPath::class, '/var//uploads'],
            'Json' => [Json::class, '{'],
            'StorageKey' => [StorageKey::class, '/documents/report.pdf'],
            'Url' => [Url::class, 'not a url'],
            'Uuid' => [Uuid::class, 'not-a-uuid'],
        ];
    }

    /**
     * @param class-string<AbstractDataType> $class
     */
    #[DataProvider('allDataTypes')]
    public function testConstructorIsNotPublic(string $class): void
    {
        $constructor = (new ReflectionClass($class))->getConstructor();

        self::assertNotNull($constructor);
        self::assertFalse($constructor->isPublic(), "{$class}: o construtor não pode ser público");

        $this->expectException(Error::class);

        new $class('valor');
    }

    /**
     * @param class-string<AbstractDataType> $class
     */
    #[DataProvider('allDataTypes')]
    public function testExtendsAbstractDataTypeFromCore(string $class): void
    {
        self::assertTrue(is_subclass_of($class, AbstractDataType::class), $class);

        foreach (['from', 'isValid', 'value', 'jsonSerialize'] as $method) {
            self::assertTrue(method_exists($class, $method), "{$class}::{$method}() não existe");
        }
    }

    /**
     * @return array<string, array{class-string<AbstractDataType>}>
     */
    public static function allDataTypes(): array
    {
        return [
            'Base64' => [Base64::class],
            'Cnpj' => [Cnpj::class],
            'Cpf' => [Cpf::class],
            'DateTime' => [DateTime::class],
            'Email' => [Email::class],
            'FileName' => [FileName::class],
            'FilePath' => [FilePath::class],
            'FolderName' => [FolderName::class],
            'FolderPath' => [FolderPath::class],
            'Json' => [Json::class],
            'StorageKey' => [StorageKey::class],
            'Url' => [Url::class],
            'Uuid' => [Uuid::class],
        ];
    }

    public function testDataTypesAreInsertable(): void
    {
        $email = Email::from('team@api.dev');

        self::assertInstanceOf(Insertable::class, $email);
        self::assertSame('team@api.dev', $email->value());
    }
}
