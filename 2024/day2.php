<?php

# Part 1
$safe = 0;

$input = file_get_contents('day2.txt');
$reports = array_map("trim", array_filter(explode("\n", $input)));

foreach($reports as $report) {
    $nums = explode(" ", $report);

    if ($nums[0] == $nums[1])
        continue; // Unsafe must in/decrease
    $isInc = $nums[0] < $nums[1];

    for($i = 1; $i < count($nums); $i++) {

        $dist = $nums[$i] - $nums[$i-1];
        $step = abs($dist);
        if ($step < 1 || $step > 3)
            continue 2; // Unsafe only step 1,2,3 allowed

        if ($isInc & $dist < 0)
            continue 2; // Unsafe must increase
        if (!$isInc & $dist > 0)
            continue 2; // Unsafe must decrease
    }

    $safe ++;
}

echo "Safe $safe\n";


# Part 2
$safe = 0;

$input = file_get_contents('day2.txt');
$reports = array_map("trim", array_filter(explode("\n", $input)));

foreach($reports as $report) {
    $nums = explode(" ", $report);
    $error = 0;
    $isInc = null;

    for($i = 1; $i < count($nums); $i++) {
        if ($error === 2)
            break;

        $dist = $nums[$i] - $nums[$i-1];

        if ($isInc === null) {
            if ($dist > 0)
                $isInc = true;
            elseif ($dist < 0)
                $isInc = false;
            else {
                $error++; // Unsafe must in/decrease
                continue;
            }
        }

        $step = abs($dist);
        if ($step < 1 || $step > 3) {
            $error++; // Unsafe only step 1,2,3 allowed
            continue;
        }
        if ($isInc & $dist < 0) {
            $error++; // Unsafe must increase
            continue;
        }
        if (!$isInc & $dist > 0) {
            $error++; // Unsafe must decrease
            continue;
        }
    }
    if ($error < 2)
        $safe ++;
}

echo "Safe $safe\n";