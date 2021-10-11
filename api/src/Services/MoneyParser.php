<?php

namespace App\Services;

use App\Entity\Expense;
use App\Exceptions\ParseExpenseException;
use DateTime;
use DateTimeInterface;
use Throwable;

class MoneyParser
{
    private const MONTHES = [
        'января' => 'january',
        'февраля' => 'february',
        'марта' => 'march',
        'апреля' => 'april',
        'мая' => 'may',
        'июня' => 'june',
        'июля' => 'july',
        'августа' => 'august',
        'сентября' => 'september',
        'октября' => 'october',
        'ноября' => 'november',
        'декабря' => 'december',
    ];

    private const WEEK_DAYS = [
        'сегодня' => 'now',
        'вчера' => '-1 day',
        'понедельник' => 'last monday',
        'вторник' => 'last tuesday',
        'среда' => 'last wednesday',
        'четверг' => 'last thursday',
        'пятница' => 'last friday',
        'суббота' => 'last saturday',
        'воскресенье' => 'last sunday',
    ];

    public function parseExpense(string $expression): Expense
    {
        [$value, $category, $date] = $this->parseExpression($expression);

        return (new Expense())
            ->setValue($value)
            ->setCategory($category)
            ->setCreatedAt($date)
        ;
    }

    private function tokenize(string $expression): array
    {
        return explode(' ', $expression);
    }

    private function normalize(array $tokens)
    {
        $tokensCount = count($tokens);
        switch (true) {
            case $tokensCount < 2:
                throw ParseExpenseException::badInput();
            case $tokensCount === 2:
                $value = $tokens[0];
                $category = $tokens[1];
                $date = new DateTime();
                break;
            default:
                $value = $tokens[0];

                if ($this->isMonthName($tokens[2])) {
                    $date = $this->parseDate("{$tokens[1]} {$tokens[2]}");
                    $category = implode(' ', array_slice($tokens, 3));
                } else {
                    $date = $this->parseDate($tokens[1]);
                    $category = implode(' ', array_slice($tokens, 2));
                }

                break;
        }

        return [(float) $value, trim(strtolower($category)), $date];
    }

    private function isMonthName(string $string): bool
    {
        return array_key_exists($string, self::MONTHES);
    }

    private function shouldBeNumeric(string $value): void
    {
        $isNumeric = (bool) preg_match('/^(\d+(\.\d+)?)$/', $value);
        if (!$isNumeric) {
            throw ParseExpenseException::shouldBeNumeric();
        }
    }

    private function shouldBePositive(string $value): void
    {
        $isPositive = (float) $value > 0;

        if (!$isPositive) {
            throw ParseExpenseException::shouldBePositive();
        }
    }

    private function shouldNotBeEmpty(?string $value): void
    {
        if (strlen($value) === 0) {
            throw ParseExpenseException::stringIsEmpty();
        }
    }

    private function dateShouldBeInPastOrNow(DateTimeInterface $date): bool
    {
        $now = new DateTime();

        if ($now->getTimestamp() >= $date->getTimestamp()) {
            return true;
        }

        throw ParseExpenseException::dateInFuture();
    }

    private function parseDate(string $string): DateTimeInterface
    {
        $value = $string;
        if (array_key_exists($string, self::WEEK_DAYS)) {
            $value = self::WEEK_DAYS[$string];
        }

        if (preg_match('/^(\d){4}\-(\d){2}\-(\d){2}$/', $string)) {
            $value = $string;
        }

        $tokens = explode(' ', $string);
        if (count($tokens) === 2 && $this->isMonthName($tokens[1])) {
            $value = $tokens[0];
            $value .= ' ';
            $value .= self::MONTHES[$tokens[1]];
            $value .= ' ';
            $value .= (new DateTime())->format('Y');
        }

        try {
            return new DateTime($value);
        } catch (Throwable $e) {
            throw ParseExpenseException::wrongDate($e);
        }
    }

    /**
     * @param string $expression
     *
     * @return array
     */
    private function parseExpression(string $expression): array
    {
        $expression = trim(strtolower($expression));

        $tokens = $this->tokenize($expression);

        $this->shouldBeNumeric($tokens[0]);
        $this->shouldBePositive($tokens[0]);

        [$value, $category, $date] = $this->normalize($tokens);

        $this->shouldNotBeEmpty($category);
        $this->dateShouldBeInPastOrNow($date);

        return [$value, $category, $date];
    }
}
