<?php

enum Move: string
{
    case Rock = 'A';
    case Paper = 'B';
    case Scissors = 'C';

    public function score(): int
    {
        return match ($this) {
            Move::Rock => 1,
            Move::Paper => 2,
            Move::Scissors => 3,
        };
    }

    public function counterMove(Result $result): Move
    {
        return match ($result) {
            Result::Draw => $this,
            Result::Win => $this->beatBy(),
            Result::Lose => $this->beats(),
        };
    }

    public function beats(): Move
    {
        return match($this) {
            Move::Rock => Move::Scissors,
            Move::Paper => Move::Rock,
            Move::Scissors => Move::Paper,
        };
    }

    public function beatBy(): Move
    {
        return match($this) {
            Move::Rock => Move::Paper,
            Move::Paper => Move::Scissors,
            Move::Scissors => Move::Rock,
        };
    }
}

enum Result: string
{
    case Win = 'Z';
    case Draw = 'Y';
    case Lose = 'X';
}

$handle = fopen(__DIR__ . '/input.txt', 'r');

$rounds = [];
$totalScore = 0;

while (!feof($handle)) {
    $line = fgets($handle);
    if (!$line) {
        break;
    }
    $moves = explode(' ', $line);
    $opponentMove = Move::tryFrom(trim($moves[0]));
    $result = Result::tryFrom(trim($moves[1]));
    $yourMove = $opponentMove->counterMove($result);
    $score = $yourMove->score();

    if ($opponentMove == $yourMove) {
        $score += 3; // draw
    } elseif ($opponentMove == Move::Rock && $yourMove == Move::Paper) {
        $score += 6; // you win
    } elseif ($opponentMove == Move::Rock && $yourMove == Move::Scissors) {
        $score += 0; // they win
    } elseif ($opponentMove == Move::Paper && $yourMove == Move::Rock) {
        $score += 0; // they win
    } elseif ($opponentMove == Move::Paper && $yourMove == Move::Scissors) {
        $score += 6; // you win
    } elseif ($opponentMove == Move::Scissors && $yourMove == Move::Rock) {
        $score += 6; // you win
    } elseif ($opponentMove == Move::Scissors && $yourMove == Move::Paper) {
        $score += 0; // they win
    }

    // echo "they played $opponentMove->name you want to $result->name, you play $yourMove->name | score $score\n";

    $rounds[] = $score;
    $totalScore += $score;
}

echo "Your total rock, paper, scissors score: $totalScore\n";

?>
