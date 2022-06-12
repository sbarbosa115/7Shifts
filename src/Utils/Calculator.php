<?php

declare(strict_types=1);

namespace CodeTests\Shifts\Utils;

use InvalidArgumentException;

class Calculator
{

    private function extractSeparatorAndCleanInput(string $input): array
    {
        preg_match('/^\/\/(.*?)\\\\n/', $input, $matches);

        if (count($matches)) {
            $inputClean = str_replace($matches[0], '', $input);

            return [
                'separator' => $matches[1],
                'input' => $inputClean
            ];
        }

        return [
            'separator' => ',',
            'input' => $input
        ];
    }

    private function validateNumbersAndAndSum(array $numbers): int
    {
        $total = 0;
        foreach ($numbers as $number) {
            $currentNumber = (int) str_replace('\n', '', $number);

            if ($currentNumber < 0) {
                throw new InvalidArgumentException('Negative numbers are not allowed.');
            }

            if ($currentNumber > 1000) {
                continue;
            }

            $total += $currentNumber;
        }

        return $total;
    }

    private function explodeByRegexPattern(string $separator, string $input): array
    {
        if ($separator === ',') {
            return explode($separator, $input);
        }

        $newMatchesWithoutComma = str_replace(',', '', $separator);
        return preg_split("/[{$newMatchesWithoutComma}]/", $input);
    }

    public function add(string $input): int
    {
        $inputSanitized = $this->extractSeparatorAndCleanInput($input);

        $numbers = $this->explodeByRegexPattern($inputSanitized['separator'], $inputSanitized['input']);

        return $this->validateNumbersAndAndSum($numbers);
    }

}
