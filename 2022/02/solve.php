<?php

enum Move: string
{
    case Rock = 'rock';
    case Paper = 'paper';
    case Scissors = 'scissors';

    public function score(): int
    {
        return match ($this) {
            Move::Rock => 1,
            Move::Paper => 2,
            Move::Scissors => 3,
        };
    }

    public static function fromString(string $string): static
    {
        return match ($string) {
            'A' => static::Rock,
            'B' => static::Paper,
            'C' => static::Scissors,
            'X' => static::Rock,
            'Y' => static::Paper,
            'Z' => static::Scissors,
        };
    }
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
    $opponentMove = Move::fromString(trim($moves[0]));
    $yourMove = Move::fromString(trim($moves[1]));

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

    $rounds[] = $score;
    $totalScore += $score;
}

echo "Your total rock, paper, scissors score: $totalScore\n";

?>
