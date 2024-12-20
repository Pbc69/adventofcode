<?php

// Test
$xmaxCount = new XmaxCountPart2("MAS");
$xmaxCount->setData(testInput());
$xmaxCount->printTable();
echo "Test count: {$xmaxCount->count()}. Must be 9\n";
$xmaxCount->printMatch();

// Puzzle - Part a
$xmaxCount = new XmaxCountPart2("MAS");
$xmaxCount->setData(file_get_contents('day4.txt'));
echo "Puzzle count: {$xmaxCount->count()}\n";


class XmaxCountPart2
{
    public array $hits = [];
    private int $wordLen;
    private int $from;
    private int $to;

    private array $lines;
    private int $counter = 0;
    private int $top = 0;
    private int $right = 0;
    private int $bottom = 0;
    private int $left = 0;

    public function __construct(private string $word)
    {
        $this->wordLen = strlen($word);

        $this->from = round($this->wordLen / 2) - $this->wordLen;
        $this->to = $this->from + $this->wordLen - 1;
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
                if ("A" !== $lines[$y][$x]) {
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
                if ($line[$x] === "A") {
                    if (!$this->inRect($y + $this->from, $x + $this->from)) continue;
                    if (!$this->inRect($y + $this->to, $x + $this->to)) continue;


                    if (!($this->testRightDown($y, $x) || $this->testLeftUp($y, $x))) continue;
                    if (!($this->testRightUp($y, $x) || $this->testLeftDown($y, $x))) continue;

                    // hit

                    $this->hits[$y][$x] ++;
                    $this->hits[$y+1][$x+1] ++;
                    $this->hits[$y+1][$x-1] ++;
                    $this->hits[$y-1][$x+1] ++;
                    $this->hits[$y-1][$x-1] ++;
                    $this->counter++;
                }
            }
        }
        return $this->counter;
    }

    function testRightDown(int $y, int $x): ?bool
    {
        for ($i = $this->from; $i <= $this->to; $i++) {
            $c = $this->lines[$y + $i][$x + $i];
            $m = $this->word[$i - $this->from];
            if ($c !== $m) {
                return false;
            }
        }


        return true;
    }

    function testLeftUp(int $y, int $x): ?bool
    {
        for ($i = $this->from; $i <= $this->to; $i++)
            if ($this->lines[$y - $i][$x - $i] !== $this->word[$i - $this->from])
                return false;

        return true;
    }

    function testRightUp(int $y, int $x): ?bool
    {
        for ($i = $this->from; $i <= $this->to; $i++)
            if ($this->lines[$y - $i][$x + $i] !== $this->word[$i - $this->from])
                return false;

        return true;
    }

    function testLeftDown(int $y, int $x): ?bool
    {
        for ($i = $this->from; $i <= $this->to; $i++)
            if ($this->lines[$y + $i][$x - $i] !== $this->word[$i - $this->from])
                return false;

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
