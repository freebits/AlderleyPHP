<?php
declare(strict_types=1);
namespace AlderleyPHP;

class AlderleySpamFilter
{

    public static function getProbabilityOfWord(string $word, array $keywords)
    {
        $ham_count = 0.0;
        $spam_count = 0.0;
        $word_found = false;
        for ($i=0; $i < count($keywords); $i++) {
            if (strcmp($word, $keywords[$i][0]) == 0) {
                $ham_count = $keywords[$i][1];
                $spam_count = $keywords[$i][2];
                $word_found = true;
            }
            if ($i == (count($keywords)-1) && $word_found == false) {
                array_push($keywords[0], $word, 0.0, 0.0);
            }
        }

        if ($spam_count > 0.0 && $ham_count > 0.0) {
            $p_of_word = ($spam_count / count($keywords)) * ($ham_count / count($keywords));
        } elseif ($spam_count == 0.0) {
            $p_of_word = 0.0;
        } else {
            $p_of_word = 1.0;
        }
        return array($p_of_word, $word_found);
    }

    public static function checkMessage(string $message, array $keywords, float $threshold)
    {
        $word_list = explode(" ", $message);
        $words_data = array_fill_keys($word_list, 0.0);
        $status = "";
        $p_of_spam = 0.0;
        $word_chances = 0.0;
        $not_found = array();

        foreach ($words_data as $word => $word_probability) {
            $p_of_word = getProbabilityOfWord($word, $keywords);
            $words_data[$word] = $p_of_word[0];
        }

        foreach ($words_data as $word => $word_probability) {
            $word_chances += $words_data[$word];
            $p_of_spam = $word_chances / count($words_data);
            if ($p_of_word[1] == false) {
                array_push($not_found, $word);
            }
        }

        if ($p_of_spam > $threshold) {
            $status = 1;
            for ($i=0; $i < count($not_found); $i++) {
                updateKeyword($word, $keywords, $status);
            }
        } else {
            $status = 0;
            updateKeyword($word, $keywords, $status);
        }

        return $status;
    }

    public static function updateKeyword(string $keyword, array $keywords, int $status)
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
