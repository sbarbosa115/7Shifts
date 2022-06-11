<?php

declare(strict_types=1);

use CodeTests\Shifts\Utils\Calculator;
use PHPUnit\Framework\TestCase;

class CalculatorTest extends TestCase
{

    public Calculator $calculator;

    public function setUp(): void
    {
        $this->calculator = new Calculator();
    }

    public function testSumNumberFromAStringInput(): void
    {
        $expected = 8;
        $retrieved = $this->calculator->add('1,2,5');
        $this->assertEquals($expected, $retrieved);
    }

    public function inputCanContainNewLineDataProvider(): array
    {
        return [
            [
                'input' => "1\n,2,3",
                'expected' => 6,
            ],
            [
                'input' => "1,\n2,4",
                'expected' => 7,
            ]
        ];
    }

    /**
     *  @dataProvider inputCanContainNewLineDataProvider
     */
    public function testInputCanContainNewLine(string $input, int $expected): void
    {
        $retrieved = $this->calculator->add($input);
        $this->assertEquals($expected, $retrieved);
    }

    public function supportCustomDelimiterDataProvider(): array
    {
        return [
            [
                'input' => "//;\n1;3;4",
                'expected' => 8,
            ],
            [
                'input' => "//$\n1$2$3",
                'expected' => 6,
            ],
            [
                'input' => "//@\n2@3@8",
                'expected' => 13,
            ]
        ];
    }

    /**
     * @dataProvider supportCustomDelimiterDataProvider
     */
    public function testSupportCustomDelimiter(string $input, int $expected): void
    {
        $retrieved = $this->calculator->add($input);
        $this->assertEquals($expected, $retrieved);
    }

    public function negativesAreNotAllowedDataProvider(): array
    {
        return [
            [
                'input' => "//;\n-1;3;4",
                'expected' => 0,
            ],
            [
                'input' => "-1,3,4",
                'expected' => 0,
            ],
        ];
    }

    /**
     * @dataProvider negativesAreNotAllowedDataProvider
     */
    public function testNegativesAreNotAllowed(string $input, int $expected): void
    {
        $this->expectException(InvalidArgumentException::class);

        $retrieved = $this->calculator->add($input);
        $this->assertEquals($expected, $retrieved);
    }

    public function largerNumberThan1000ShouldBeIgnoredDataProvider(): array
    {
        return [
            [
                'input' => "//;\n1001;3;4",
                'expected' => 7,
            ],
            [
                'input' => "//;\n1000;3;4",
                'expected' => 1007,
            ],
        ];
    }

    /**
     * @dataProvider largerNumberThan1000ShouldBeIgnoredDataProvider
     */
    public function testLargerNumberThan1000ShouldBeIgnored(string $input, int $expected): void
    {
        $retrieved = $this->calculator->add($input);
        $this->assertEquals($expected, $retrieved);
    }

    public function delimitersCanBeArbitraryDataProvider(): array
    {
        return [
            [
                'input' => "//***\n1***2***3",
                'expected' => 6,
            ],
            [
                'input' => "//--------------\n1--------------2--------------3",
                'expected' => 6,
            ],
        ];
    }

    /**
     * @dataProvider delimitersCanBeArbitraryDataProvider
     */
    public function testDelimitersCanBeArbitrary(string $input, int $expected): void
    {
        $retrieved = $this->calculator->add($input);
        $this->assertEquals($expected, $retrieved);
    }

    public function allowForMultipleDelimitersDataProvider(): array
    {
        return [
            [
                'input' => "//$,@\n1$2@3",
                'expected' => 6,
            ],
        ];
    }

    /**
     * @dataProvider allowForMultipleDelimitersDataProvider
     */
    public function testAllowForMultipleDelimiters(string $input, int $expected): void
    {
        $retrieved = $this->calculator->add($input);
        $this->assertEquals($expected, $retrieved);
    }

}
