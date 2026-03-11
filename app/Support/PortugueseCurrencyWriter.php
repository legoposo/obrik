<?php

namespace App\Support;

class PortugueseCurrencyWriter
{
    /**
     * @var array<int, string>
     */
    protected const UNITS = [
        0 => 'zero',
        1 => 'um',
        2 => 'dois',
        3 => 'tres',
        4 => 'quatro',
        5 => 'cinco',
        6 => 'seis',
        7 => 'sete',
        8 => 'oito',
        9 => 'nove',
    ];

    /**
     * @var array<int, string>
     */
    protected const TEENS = [
        10 => 'dez',
        11 => 'onze',
        12 => 'doze',
        13 => 'treze',
        14 => 'quatorze',
        15 => 'quinze',
        16 => 'dezesseis',
        17 => 'dezessete',
        18 => 'dezoito',
        19 => 'dezenove',
    ];

    /**
     * @var array<int, string>
     */
    protected const TENS = [
        2 => 'vinte',
        3 => 'trinta',
        4 => 'quarenta',
        5 => 'cinquenta',
        6 => 'sessenta',
        7 => 'setenta',
        8 => 'oitenta',
        9 => 'noventa',
    ];

    /**
     * @var array<int, string>
     */
    protected const HUNDREDS = [
        1 => 'cento',
        2 => 'duzentos',
        3 => 'trezentos',
        4 => 'quatrocentos',
        5 => 'quinhentos',
        6 => 'seiscentos',
        7 => 'setecentos',
        8 => 'oitocentos',
        9 => 'novecentos',
    ];

    /**
     * @var array<int, array{singular: string, plural: string}>
     */
    protected const SCALES = [
        0 => ['singular' => '', 'plural' => ''],
        1 => ['singular' => 'mil', 'plural' => 'mil'],
        2 => ['singular' => 'milhao', 'plural' => 'milhoes'],
        3 => ['singular' => 'bilhao', 'plural' => 'bilhoes'],
        4 => ['singular' => 'trilhao', 'plural' => 'trilhoes'],
    ];

    public static function toWords(float|int|string|null $amount): string
    {
        $normalized = number_format((float) ($amount ?? 0), 2, '.', '');
        [$integerPart, $fractionPart] = explode('.', $normalized);

        $integers = (int) $integerPart;
        $cents = (int) $fractionPart;

        $realWords = self::formatCurrencyPart($integers, 'real', 'reais');
        $centWords = self::formatCurrencyPart($cents, 'centavo', 'centavos');

        if ($integers > 0 && $cents > 0) {
            return $realWords.' e '.$centWords;
        }

        if ($integers > 0) {
            return $realWords;
        }

        if ($cents > 0) {
            return $centWords;
        }

        return 'zero real';
    }

    protected static function formatCurrencyPart(int $value, string $singular, string $plural): string
    {
        $words = self::convertNumber($value);
        $currencyLabel = $value === 1 ? $singular : $plural;

        if ($value >= 1000000 && $value % 1000000 === 0) {
            return $words.' de '.$currencyLabel;
        }

        return $words.' '.$currencyLabel;
    }

    protected static function convertNumber(int $value): string
    {
        if ($value === 0) {
            return self::UNITS[0];
        }

        $groups = [];

        while ($value > 0) {
            $groups[] = $value % 1000;
            $value = intdiv($value, 1000);
        }

        $parts = [];

        for ($scale = count($groups) - 1; $scale >= 0; $scale--) {
            $group = $groups[$scale];

            if ($group === 0) {
                continue;
            }

            if ($scale === 1 && $group === 1) {
                $parts[] = 'mil';
                continue;
            }

            $groupWords = self::convertHundreds($group);
            $scaleLabel = self::scaleLabel($scale, $group);

            $parts[] = trim($groupWords.' '.$scaleLabel);
        }

        return self::joinParts($parts);
    }

    protected static function convertHundreds(int $value): string
    {
        if ($value === 100) {
            return 'cem';
        }

        $parts = [];
        $hundreds = intdiv($value, 100);
        $remainder = $value % 100;

        if ($hundreds > 0) {
            $parts[] = self::HUNDREDS[$hundreds];
        }

        if ($remainder >= 10 && $remainder <= 19) {
            $parts[] = self::TEENS[$remainder];

            return implode(' e ', $parts);
        }

        $tens = intdiv($remainder, 10);
        $units = $remainder % 10;

        if ($tens > 1) {
            $parts[] = self::TENS[$tens];
        }

        if ($units > 0) {
            $parts[] = self::UNITS[$units];
        }

        if ($hundreds === 0 && $remainder < 10 && $units > 0) {
            return self::UNITS[$units];
        }

        return implode(' e ', $parts);
    }

    protected static function scaleLabel(int $scale, int $groupValue): string
    {
        if ($scale === 0) {
            return '';
        }

        $labels = self::SCALES[$scale] ?? ['singular' => '', 'plural' => ''];

        return $groupValue === 1 ? $labels['singular'] : $labels['plural'];
    }

    /**
     * @param  list<string>  $parts
     */
    protected static function joinParts(array $parts): string
    {
        $count = count($parts);

        if ($count === 1) {
            return $parts[0];
        }

        if ($count === 2) {
            return $parts[0].' e '.$parts[1];
        }

        $last = array_pop($parts);

        return implode(', ', $parts).' e '.$last;
    }
}