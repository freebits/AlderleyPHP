<?php
declare(strict_types=1);
namespace AlderleyPHP;

class SpamFilter
{
    public static function getProbabilityOfWord(string $word, array $keywords): array
    {
        $hamCount = 0.0;
        $spamCount = 0.0;
        $wordFound = false;
        for ($i=0; $i < count($keywords); $i++) {
            if (strcmp($word, $keywords[$i][0]) == 0) {
                $hamCount = $keywords[$i][1];
                $spamCount = $keywords[$i][2];
                $wordFound = true;
            }
            if ($i == (count($keywords)-1) && $wordFound == false) {
                array_push($keywords[0], $word, 0.0, 0.0);
            }
        }

        if ($spamCount > 0.0 && $hamCount > 0.0) {
            $pOfWord = ($spamCount / ($hamCount + $spamCount)) * 100;
        } elseif ($spamCount == 0.0) {
            $pOfWord = 0.0;
        } else {
            $pOfWord = 1.0;
        }
        return array($pOfWord, $wordFound);
    }

    public static function checkMessage(string $message, array $keywords, float $threshold): int
    {
        $wordList = explode(" ", $message);
        $wordData = array_fill_keys($wordList, 0.0);
        $status = "";
        $pOfSpam = 0.0;
        $wordChances = 0.0;
        $notFound = array();

        foreach ($wordData as $word => $wordProbability) {
            $pOfWord = self::getProbabilityOfWord($word, $keywords);
            $wordData[$word] = $pOfWord[0];
        }

        foreach ($wordData as $word => $wordProbability) {
            $wordChances += $wordData[$word];
            $pOfSpam = $wordChances / count($wordData);
            if ($pOfWord[1] == false) {
                array_push($notFound, $word);
            }
        }

        if ($pOfSpam > $threshold) {
            $status = 1;
            for ($i=0; $i < count($notFound); $i++) {
                self::updateKeyword($word, $keywords, $status);
            }
        } else {
            $status = 0;
            self::updateKeyword($word, $keywords, $status);
        }

        return $status;
    }

    public static function updateKeyword(string $keyword, array $keywords, int $status): void
    {
        for ($j=0; $j < count($keywords); $j++) {
            if (strcmp($keyword, $keywords[$j][0]) == 0) {
                if ($status == 1) {
                    $keywords[$j][1] += 1;
                } else {
                    $keywords[$j][2] += 1;
                }
            }
        }
    }
}
