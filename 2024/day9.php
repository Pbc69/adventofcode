<?php

// Part 1
$input = file_get_contents('day9.txt');
//$input = testInput();

$id = 0;
$blocks = "";
for($i = 0; $i < strlen($input); $i++) {

    $len = (int)$input[$i];

    if ($i % 2 == 0) {
        for($j = 0; $j < $len; $j++) {
            $blocks .= $id;
        }
        $id++;
        if ($id > 9) {
            $id = 0;
        }
    } else {
        for($j = 0; $j < $len; $j++) {
            $blocks .= ".";
        }
    }
}
//echo $blocks."\n";

// move
$end = strlen($blocks) - 1;
for($i = 1; $i < strlen($blocks); $i++) {
    if ($blocks[$i] === ".") {
        for($j = $end; $j > $i; $j--) {
            if ($blocks[$j] !== ".") {
                $blocks[$i] = $blocks[$j];
                $blocks[$j] = ".";
                $end = $j;
                continue 2;
            }
        }
        break; //all done
    }
}
echo $blocks."\n";

// what do to with the checksum? ???? ?
// checksum
$sum = 0;
for($i = 0; $i < strlen($blocks); $i++) {
    if ($blocks[$i] === ".") {
        break;
    }
    $sum += ($i * intval($blocks[$i]));
}
echo $sum."\n";


function testInput() { // 1928
    return "2333133121414131402";
}