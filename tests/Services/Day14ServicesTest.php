<?php

namespace App\Tests\Services;

use App\Services\Day14Services;
use PHPUnit\Framework\TestCase;

class Day14ServicesTest extends TestCase
{
    private array $pairs = [
        '',
        'CH -> B',
        'HH -> N',
        'CB -> H',
        'NH -> C',
        'HB -> C',
        'HC -> B',
        'HN -> C',
        'NN -> C',
        'BH -> H',
        'NC -> B',
        'NB -> B',
        'BN -> B',
        'BB -> N',
        'BC -> B',
        'CC -> N',
        'CN -> C'
    ];

    public function testGetPairsInsertion()
    {
        $service = new Day14Services();

        $expectedPairs = [
            'CH' => 'B',
            'HH' => 'N',
            'CB' => 'H',
            'NH' => 'C',
            'HB' => 'C',
            'HC' => 'B',
            'HN' => 'C',
            'NN' => 'C',
            'BH' => 'H',
            'NC' => 'B',
            'NB' => 'B',
            'BN' => 'B',
            'BB' => 'N',
            'BC' => 'B',
            'CC' => 'N',
            'CN' => 'C',
        ];

        $this->assertEquals($expectedPairs, $service->getPairsInsertion($this->pairs));
    }

    public function testUpdateTemplate()
    {
        $service = new Day14Services();

        $template = 'NNCB';
        $expectedTemplate = 'NCNBCHB';
        $pairs = $service->getPairsInsertion($this->pairs);

        $service->updateTemplate($template, $pairs);

        $this->assertEquals($expectedTemplate, $template);
    }

    public function testCountMinMaxChar()
    {
        $service = new Day14Services();
        $template = 'NCNBCHB';

        $this->assertEquals(['min' => 1, 'max' => 2], $service->countMinMaxChar($template));
    }

    public function testGetInitialPairs()
    {
        $service = new Day14Services();
        $template = 'NNCB';

        $calculatedPairs = [];
        $expectedPairs = ['NN' => 1, 'NC' => 1, 'CB' => 1];
        $service->getInitialPairs($template, $calculatedPairs);

        $this->assertEquals($expectedPairs, $calculatedPairs);
    }

    public function testUpdateCalculatedPairs()
    {
        $service = new Day14Services();
        $template = 'NBCCNBBBCBHCB';

        $pairs = $service->getPairsInsertion($this->pairs);
        $calculatedPairs = [];
        $expectedPairs = [
            'NB' => 4,
            'BB' => 4,
            'BC' => 3,
            'CN' => 2,
            'NC' => 1,
            'CC' => 1,
            'BN' => 2,
            'CH' => 2,
            'HB' => 3,
            'BH' => 1,
            'HH' => 1
        ];
        $service->getInitialPairs($template, $calculatedPairs);

        $service->updatePairs($pairs, $calculatedPairs);

        $this->assertEquals($expectedPairs, $calculatedPairs);
    }

    public function testCountMinMaxCharInArrayKeys()
    {
        $service = new Day14Services();
        $template = 'NBCCNBBBCBHCB';

        $pairs = $service->getPairsInsertion($this->pairs);
        $calculatedPairs = [];
        $service->getInitialPairs($template, $calculatedPairs);
        $service->updatePairs($pairs, $calculatedPairs);

        $expectedCharCount = [
            'N' => 5,
            'B' => 11,
            'C' => 5,
            'H' => 4
        ];

        $minMax = $service->countMinMaxCharInArrayKeys($calculatedPairs, $template);

        $this->assertEquals(min($expectedCharCount), $minMax['min']);
    }
}