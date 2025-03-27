<?php

function minMaxSum(array $arr): void
{
    /*
    был конечно вариант отсортировать массив просто по возрастанию
    и расчитать суммы без 0 и последнего элемента, но так наверное было бы не интересно
    так что заранее прошу прощения за код в 9 - 16 строчке
    */
    function findIdx($arr, $findIdxCallback)
    {
        return array_reduce($arr, function ($accumIdx, $elem) use ($arr, $findIdxCallback) {
            return $findIdxCallback($arr[$accumIdx], $elem) ? $accumIdx : array_search($elem, $arr);
        }, 0);
    }

    $maxValIdx = findIdx($arr, fn($a, $b) => $a > $b);
    $minValIdx = findIdx($arr, fn($a, $b) => $a < $b);

    $sums = ['minSum' => 0, 'maxSum' => 0];

    for ($i = 0; $i < count($arr); $i++) {
        if ($i !== $maxValIdx) {
            $sums['minSum'] += $arr[$i];
        }

        if ($i !== $minValIdx) {
            $sums['maxSum'] += $arr[$i];
        }
    }

    echo implode(' ', $sums);
}

echo "<p> minMaxSum </p>";
minMaxSum([1, 33, 33, 6, 7]);
echo '<hr />';

function sumOfArrayElements(array $arr): int
{
    return array_reduce($arr, fn($accum, $elem) => $accum += $elem);
}

echo '<p>SumOfArrayElements</p>';
echo sumOfArrayElements([1, 2, 3]);
echo '<hr />';

function iceCreamParlor(array $costs, int $amount_of_money)
{
    $indices = [];

    for ($i = 0; $i < count($costs); $i++) {
        if ($i !== count($costs) - 1) {
            for ($j = $i + 1; $j < count($costs); $j++) {
                if ($costs[$i] + $costs[$j] === $amount_of_money) {
                    $indices[] = $i;
                    $indices[] = $j;

                    break 2;
                }
            }
        }
    }

    return $indices;
}

echo '<p>iceCreamParlor</p>';
var_dump(iceCreamParlor([1, 4, 5, 8, 2], 12));
echo '<hr />';

function missingNumbers(array $arr, array $brr): array
{
    $arrUniq = array_unique($arr);
    $brrUniq = array_unique($brr);

    $missingNumbers = [];

    for ($i = 0; $i < count($brrUniq); $i++) {
        $isFound = false;

        for ($j = 0; $j < count($arrUniq); $j++) {
            if ($brrUniq[$i] === $arrUniq[$j]) {
                $isFound = true;
                break;
            }
        }

        if (!$isFound) {
            $missingNumbers[] = $brrUniq[$i];
        }
    }

    return $missingNumbers;
}

echo '<p>missingNumbers</p>';
var_dump(missingNumbers([7, 2, 5, 3, 5, 3], [7, 2, 5, 4, 6, 3, 5, 3]));
echo '<hr />';

function sherlockAndArray(array $arr)
{
    for ($i = 1; $i < count($arr) - 1; $i++) {
        $slicedLefPart   = array_slice($arr, 0, $i);
        $slicedRightPart = array_slice($arr, $i + 1);
        $getSum          = fn($accum, $elem) => $accum += $elem;
        $lefPartSum      = array_reduce($slicedLefPart, $getSum);
        $rightPartSum    = array_reduce($slicedRightPart, $getSum);

        if ($lefPartSum === $rightPartSum) {
            return $i;
        }
    }
    return false;
}

echo '<p>sherlockAndArray</p>';
var_dump(sherlockAndArray([5, 6, 8, 11]));
echo '<hr />';

function recursiveDigitSum(int $number): int
{
    if (!is_array($number)) {
        $number = array_map(fn($elem) => +$elem, mb_str_split((string) $number));
    }

    if (count($number) === 1) {
        return $number[0];
    }

    return recursiveDigitSum(array_reduce($number, fn($accum, $elem) => $accum += $elem));
}

echo '<p>recursiveDigitSum</p>';
echo recursiveDigitSum(365);
echo '<hr />';

function diagonalDifference(array $array): int
{
    $mainDiagSum   = 0;
    $secondDiagSum = 0;
    $arrayLength   = count($array);

    // Честно признаюсь, что подсмотрел решение с поиском суммы побочной диагонали

    for ($i = 0; $i < count($array); $i++) {
        $mainDiagSum   += $array[$i][$i];
        $secondDiagSum += $array[$i][$arrayLength - 1 - $i];
    }

    return abs($mainDiagSum - $secondDiagSum);
}

echo '<p>diagonalDifference</p>';
var_dump(diagonalDifference([
    [1, 2, 3,],
    [4, 5, 6,],
    [9, 8, 9,],
]));
echo '<hr />';

function plusMinus(array $array): void
{
    $allNumbCounter = count($array);

    $counters = [
        'negNumbCounter' => 0,
        'zerNumbCounter' => 0,
        'posNumbCounter' => 0,
    ];

    for ($i = 0; $i < $allNumbCounter; $i++) {
        $number = $array[$i];

        switch (true) {
            case $number < 0:
                $counters['negNumbCounter']++;
                break;
            case $number === 0:
                $counters['zerNumbCounter']++;
                break;
            default:
                $counters['posNumbCounter']++;
        }
    }

    foreach ($counters as $counter) {
        printf("%.6f <br/>", $counter / $allNumbCounter);
    }
}

echo '<p>plusMinus</p>';
plusMinus([1, 1, 0, -1, -1]);
echo '<hr />';

function birthdayCakeCandles(array $candels)
{
    //findIdx задекларировал внутри самой первой задачи
    $tallestCandleIdx = findIdx($candels, fn($a, $b) => $a > $b);
    $tallestCandleVal = $candels[$tallestCandleIdx];
    $counter          = 0;
    /*
    Если индекс вхождения самой высокой свечи - это count(candels) - 1
    то значит последний элемент массива и он не дублируется
    возвращаю хардкодом 1
    */
    if ($tallestCandleIdx === count($candels) - 1) {
        return 1;
    }

    for ($i = $tallestCandleIdx; $i < count($candels); $i++) {
        if ($candels[$i] === $tallestCandleVal) {
            $counter++;
        }
    }
    return $counter;
}

echo '<p>birthdayCakeCandles</p>';
var_dump(birthdayCakeCandles([4, 5, 5, 3]));
echo '<hr />';

function timeConversion(string $s) {
    $timeStamp = strtotime($s);

    return date('H:i:s', $timeStamp);
}

echo '<p>timeConversion</p>';
var_dump(timeConversion('12:01:00PM'));
echo '<hr />';