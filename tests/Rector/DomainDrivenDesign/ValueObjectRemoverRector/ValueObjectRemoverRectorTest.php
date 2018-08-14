<?php declare(strict_types=1);

namespace Rector\Tests\Rector\DomainDrivenDesign\ValueObjectRemoverRector;

use Iterator;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;

/**
 * @covers \Rector\Rector\DomainDrivenDesign\ValueObjectRemover\ValueObjectRemoverRector
 * @covers \Rector\Rector\DomainDrivenDesign\ValueObjectRemover\ValueObjectRemoverDocBlockRector
 */
final class ValueObjectRemoverRectorTest extends AbstractRectorTestCase
{
    /**
     * @dataProvider provideWrongToFixedFiles()
     */
    public function test(string $wrong, string $fixed): void
    {
        $this->doTestFileMatchesExpectedContent($wrong, $fixed);
    }

    public function provideWrongToFixedFiles(): Iterator
    {
        yield [__DIR__ . '/Wrong/wrong.php.inc', __DIR__ . '/Correct/correct.php.inc'];
//        yield [__DIR__ . '/Wrong/wrong2.php.inc', __DIR__ . '/Correct/correct2.php.inc'];
//        yield [__DIR__ . '/Wrong/wrong3.php.inc', __DIR__ . '/Correct/correct3.php.inc'];
//        yield [__DIR__ . '/Wrong/wrong4.php.inc', __DIR__ . '/Correct/correct4.php.inc'];
    }

    protected function provideConfig(): string
    {
        return __DIR__ . '/config.yml';
    }
}
