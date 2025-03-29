<?php

function minMaxSum(array $arr): void
{
    /*
    был конечно вариант отсортировать массив просто по возрастанию
    и расчитать суммы без 0 и последнего элемента, но так наверное было бы не интересно
    так что заранее прошу прощения за код в 10 - 18 строчке
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

    foreach ($arr as $idx => $elem) {
        if ($idx !== $maxValIdx) {
            $sums['minSum'] += $elem;
        }

        if ($idx !== $minValIdx) {
            $sums['maxSum'] += $elem;
        }
    }

    echo implode(' ', $sums);
}

echo "<p> minMaxSum </p>";
minMaxSum([1, 33, 53, 0, 7]);
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
    $selectedPairKeys = [];
    $allKeys          = array_keys($costs);

    foreach ($allKeys as $i) {
        foreach (array_slice($allKeys, $i + 1) as $j) {
            if ($costs[$i] + $costs[$j] === $amount_of_money) {
                $selectedPairKeys[] = $i;
                $selectedPairKeys[] = $j;

                break 2;
            }
        }
    }

    return $selectedPairKeys;
}

echo '<p>iceCreamParlor</p>';
var_dump(iceCreamParlor([1, 4, 5, 8, 2], 12));
echo '<hr />';

function missingNumbers(array $arr, array $brr): array
{
    $arrUniq = array_unique($arr);
    $brrUniq = array_unique($brr);

    $missingNumbers = [];

    foreach ($brrUniq as $brrElem) {
        $isFound = false;

        foreach ($arrUniq as $arrElem) {
            if ($brrElem === $arrElem) {
                $isFound = true;
                break;
            }
        }

        if (!$isFound) {
            $missingNumbers[] = $brrElem;
        }
    }

    return $missingNumbers;
}

echo '<p>missingNumbers</p>';
var_dump(missingNumbers([7, 2, 5, 3, 5, 3], [7, 2, 5, 4, 6, 3, 5, 3]));
echo '<hr />';

function sherlockAndArray(array $arr)
{
    foreach (array_keys($arr) as $idx) {
        $slicedLefPart   = array_slice($arr, 0, $idx);
        $slicedRightPart = array_slice($arr, $idx + 1);

        if (array_sum($slicedLefPart) === array_sum($slicedRightPart)) {
            return $idx;
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
    $rowsCounter            = count($array);
    $verifiedColumns        = array_filter($array, function ($elem) use ($rowsCounter) {
        return count($elem) === $rowsCounter;
    });
    $verifiedColumnsCounter = count($verifiedColumns);

    if ($rowsCounter !== $verifiedColumnsCounter) {
        return 0;
    }

    $mainDiagSum   = 0;
    $secondDiagSum = 0;

    foreach ($array as $idx => $row) {
        $mainDiagSum   += $row[$idx];
        $secondDiagSum += $row[count($row) - 1 - $idx];
    }

    return abs($mainDiagSum - $secondDiagSum);
}

echo '<p>diagonalDifference</p>';
var_dump(diagonalDifference([
    [1, 2, 3,],
    [4, 5, 6,],
    [12, 8, 9,],
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

    foreach ($array as $number) {
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
        echo number_format($counter / $allNumbCounter, 6) . '<br />';
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

function timeConversion(string $s)
{
    $timeStamp = strtotime($s);

    return date('H:i:s', $timeStamp);
}

echo '<p>timeConversion</p>';
var_dump(timeConversion('12:01:00PM'));
echo '<hr />';
