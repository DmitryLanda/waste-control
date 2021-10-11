<?php

namespace App\Tests\Service;

use App\Entity\Expense;
use App\Services\MoneyParser;
use DateTime;
use PHPUnit\Framework\TestCase;

class ExpenseParserTest extends TestCase
{
    /**
     * test
     * @dataProvider expenseParserDataProvider
     */
    public function itParsesExpressionsInDifferentFormats(string $expression, array $expectations): void
    {
        $service = new MoneyParser();

        $expense = $service->parseExpense($expression);

        [$value, $category, $date] = $expectations;

        self::assertInstanceOf(Expense::class, $expense);
        self::assertEquals($value, $expense->getValue());
        self::assertEquals($category, $expense->getCategory());
        self::assertEquals($date->format('Y-m-d'), $expense->getCreatedAt()->format('Y-m-d'));
    }

    public function expenseParserDataProvider(): array
    {
        return [
            ['-1500 вчера бар', [-1500, 'бар', new DateTime('-1 day')]],
            ['-137.50 обед', [-137.5, 'обед', new DateTime()]],
            ['300 23 сентября кино', [300, 'кино', new DateTime('23 september')]],
            ['-1500 среда бар', [-1500, 'бар', new DateTime('last wednesday')]],
            ['-100 воскресенье бар', [-100, 'бар', new DateTime('last sunday')]],
            ['-1050 2020-03-15 бар', [-1050, 'бар', new DateTime('2020-03-15')]],
        ];
    }

    /**
     * @test
     * @dataProvider badInputDataProvider
     */
    public function itThrowsExceptionOnFailure(string $expression): void
    {
        self::expectException(\Exception::class);

        $service = new MoneyParser();
        $service->parseExpense($expression);
    }

    public function badInputDataProvider(): array
    {
        return [
            ['-foo вчера бар'],
            ['-137.50.45 обед'],
            ['300 20 хренобря кино'],
            ['-1500'],
            ['-100 23 сентября'],
            ['-1050 завтра бар'],
        ];
    }
}
