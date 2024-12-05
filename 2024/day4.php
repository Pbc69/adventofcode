<?php

// Test
$xmaxCount = new XmaxCount("XMAS");
$xmaxCount->setData(testInput());
$xmaxCount->printTable();
echo "Test count: {$xmaxCount->count()}. Must be 18\n";
$xmaxCount->printMatch();

// Puzzle
$xmaxCount = new XmaxCount("XMAS");
$xmaxCount->setData(file_get_contents('day4.txt'));
echo "Puzzle count: {$xmaxCount->count()}\n";


class XmaxCount
{
    public array $hits = [];
    private int $wordLen;
    private int $xyAdd;

    private array $lines;
    private int $counter = 0;
    private int $top = 0;
    private int $right = 0;
    private int $bottom = 0;
    private int $left = 0;

    public function __construct(private string $word)
    {
        $this->wordLen = strlen($word);
        // must be minus 1 because we start from 0 (0 + 3 = 4 chars)
        $this->xyAdd = $this->wordLen - 1;
    }

    public function setData(string $input): self {
        $input = $input;
        $input = str_replace("\r\n", "\n", $input);
        $this->lines = array_map("trim", explode("\n", $input));

        // Rect increasing to bottom
        $this->top = 0;
        $this->right = strlen($this->lines[0]) - 1;
        $this->bottom = count($this->lines) - 1;
        $this->left = 0;

        // init Hit Table
        for ($y = 0; $y < count($this->lines); $y++)
            $this->hits[$y] = array_fill(0, strlen($this->lines[$y]), 0);

        $this->counter = 0;
        return $this;
    }

    public function printTable() {
        $lines = $this->lines;
        for ($y = $this->top; $y <= $this->bottom; $y++) {
            for ($x = $this->left; $x <= $this->right; $x++) {
                if ($this->word[0] !== $lines[$y][$x]) {
                    $lines[$y][$x] = strtolower($lines[$y][$x]);
                }
            }
            echo "$lines[$y]\n";
        }
    }
    public function printHits() {
        for ($y = $this->top; $y <= $this->bottom; $y++) {
            echo implode("", $this->hits[$y])."\n";
        }
    }
    public function printMatch() {
        $lines = $this->lines;
        for ($y = $this->top; $y <= $this->bottom; $y++) {
            for ($x = $this->left; $x <= $this->right; $x++) {
                if ($this->hits[$y][$x] === 0) {
                    $lines[$y][$x] = ".";
                }
            }
            echo "$lines[$y]\n";
        }
    }

    function count(): int
    {
        // Test Rect
        for ($y = $this->top; $y <= $this->bottom; $y++) {
            $line = $this->lines[$y];

            for ($x = $this->left; $x <= $this->right; $x++) {
                if ($line[$x] === $this->word[0]) {
                    $this->testDown($y, $x);
                    $this->testUp($y, $x);

                    $this->testRight($y, $x);
                    $this->testLeft($y, $x);

                    $this->testRightDown($y, $x);
                    $this->testLeftUp($y, $x);

                    $this->testRightUp($y, $x);
                    $this->testLeftDown($y, $x);
                }
            }
        }
        return $this->counter;
    }


    function testRight(int $y, int $x): ?bool
    {
        if (!$this->inRect($y, $x + $this->xyAdd))
            return null;

        for ($i = 1; $i < $this->wordLen; $i++)
            if ($this->lines[$y][$x + $i] !== $this->word[$i])
                return false;

        for ($i = 0; $i < $this->wordLen; $i++)
            $this->hits[$y][$x + $i] ++;
        $this->counter++;
        return true;
    }
    function testLeft(int $y, int $x): ?bool
    {
        if (!$this->inRect($y, $x - $this->xyAdd))
            return null;

        for ($i = 1; $i < $this->wordLen; $i++)
            if ($this->lines[$y][$x - $i] !== $this->word[$i])
                return false;

        for ($i = 0; $i < $this->wordLen; $i++)
            $this->hits[$y][$x - $i] ++;
        $this->counter++;
        return true;
    }

    function testDown(int $y, int $x): ?bool
    {
        if (!$this->inRect($y + $this->xyAdd, $x))
            return null;

        for ($i = 1; $i < $this->wordLen; $i++)
            if ($this->lines[$y + $i][$x] !== $this->word[$i])
                return false;

        for ($i = 0; $i < $this->wordLen; $i++)
            $this->hits[$y + $i][$x] ++;
        $this->counter++;
        return true;
    }

    function testUp(int $y, int $x): ?bool
    {
        if (!$this->inRect($y - $this->xyAdd, $x))
            return null;

        for ($i = 1; $i < $this->wordLen; $i++)
            if ($this->lines[$y - $i][$x] !== $this->word[$i])
                return false;

        for ($i = 0; $i < $this->wordLen; $i++)
            $this->hits[$y - $i][$x] ++;
        $this->counter++;
        return true;
    }

    function testRightDown(int $y, int $x): ?bool
    {
        if (!$this->inRect($y + $this->xyAdd, $x + $this->xyAdd))
            return null;

        for ($i = 1; $i < $this->wordLen; $i++)
            if ($this->lines[$y + $i][$x + $i] !== $this->word[$i])
                return false;

        for ($i = 0; $i < $this->wordLen; $i++)
            $this->hits[$y + $i][$x + $i] ++;
        $this->counter++;
        return true;
    }

    function testLeftUp(int $y, int $x): ?bool
    {
        if (!$this->inRect($y - $this->xyAdd, $x - $this->xyAdd))
            return null;

        for ($i = 1; $i < $this->wordLen; $i++)
            if ($this->lines[$y - $i][$x - $i] !== $this->word[$i])
                return false;

        for ($i = 0; $i < $this->wordLen; $i++)
            $this->hits[$y - $i][$x - $i] ++;
        $this->counter++;
        return true;
    }

    function testRightUp(int $y, int $x): ?bool
    {
        if (!$this->inRect($y - $this->xyAdd, $x + $this->xyAdd))
            return null;

        for ($i = 1; $i < $this->wordLen; $i++)
            if ($this->lines[$y - $i][$x + $i] !== $this->word[$i])
                return false;

        for ($i = 0; $i < $this->wordLen; $i++)
            $this->hits[$y - $i][$x + $i] ++;
        $this->counter++;
        return true;
    }

    function testLeftDown(int $y, int $x): ?bool
    {
        if (!$this->inRect($y + $this->xyAdd, $x - $this->xyAdd))
            return null;

        for ($i = 1; $i < $this->wordLen; $i++)
            if ($this->lines[$y + $i][$x - $i] !== $this->word[$i])
                return false;

        for ($i = 0; $i < $this->wordLen; $i++)
            $this->hits[$y + $i][$x - $i] ++;
        $this->counter++;
        return true;
    }

    public function inRect(int $y, int $x): bool
    {
        return $y >= $this->top && $y <= $this->bottom && $x >= $this->left && $x <= $this->right;
    }



}



function testInput() {
    return "MMMSXXMASM
MSAMXMSMSA
AMXSXMAAMM
MSAMASMSMX
XMASAMXAMM
XXAMMXXAMA
SMSMSASXSS
SAXAMASAAA
MAMMMXMMMM
MXMXAXMASX";
}
