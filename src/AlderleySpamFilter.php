<?php
function sort_dataset_from_file(string $training_file, string $seperator, array $dataset) {
    while ($line = fgets($training_file)) {
        $message_data = explode($seperator, $line);
        if ($message_data[0] == "ham") {
            array_push($dataset, array(strip_punctuation($message_data[1]), 1.0, 0.0));
        } elseif ($message_data[0] == "spam") {
            array_push($dataset, array(strip_punctuation($message_data[1]), 0.0, 1.0));
        } else {
            echo "error";
        }
    }

    return $dataset;
}

function strip_punctuation(string $message) {
    $message = strtolower($message);
    $punctuation = array(',', '?', '.', '/', '!');
    $message = trim(str_replace($punctuation, '', $message));
    return $message;
}

function make_keywords(array $dataset) {
    $keywords = array();
    for ($i=0; $i < count($dataset); $i++) {
        $tw = explode(" ", $dataset[$i]['message']);
        $training_words = array();
        foreach ($tw as $w) {
            array_push($training_words, array($w, $dataset[$i]['ham_flag'], $dataset[$i]['spam_flag']));
        }
        $word_found = false;
        for ($j=0; $j < count($training_words); $j++) {
            for ($k=0; $k < count($keywords); $k++) {
                if ($training_words[$j][0] === $keywords[$k][0]) {
                    if ($training_words[$j][1] > $training_words[$j][2]) {
                        $keywords[$k][1] += 1.0;
                    } else {
                        $keywords[$k][2] += 1.0;
                    }
                    $word_found = true;
                }
            }
            if (!$word_found) {
                array_push($keywords, $training_words[$j]);
            }
        }
    }
    return $keywords;
}

function get_probability_of_word(string $word, array $keywords) {
    $amount_of_ham = 0.0;
    $amount_of_spam = 0.0;
    $word_found = false;
    for ($i=0; $i < count($keywords); $i++) {
        if (strcmp($word, $keywords[$i][0]) == 0) {
            $amount_of_ham = $keywords[$i][1];
            $amount_of_spam = $keywords[$i][2];
            $word_found = true;
        }
        if ($i == (count($keywords)-1) && $word_found == false) {
            array_push($keywords[0], $word, 0.0, 0.0);
        }
    }

    // find the probability of spam or ham and
    // average them
    if ($amount_of_spam > 0.0 && $amount_of_ham > 0.0) {
        $p_of_word = ($amount_of_spam / count($keywords)) * ($amount_of_ham / count($keywords));
    } elseif ($amount_of_spam == 0.0) {
        $p_of_word = 0.0;
    } else {
        $p_of_word = 1.0;
    }
    return $p_of_word;
}

function check_message(string $message, array $keywords) {
    $word_list = explode(" ", $message);
    $words_data = array_fill_keys($word_list, 0.0);
    $status = "";
    $p_of_spam = 0.0;
    $word_chances = 0.0;

    // get the probabilities of words
    // from keywords 
    foreach ($words_data as $word => $word_probability) {
        $p_of_word = get_probability_of_word($word, $keywords);
        $words_data[$word] = $p_of_word;
    }

    // get the total probability of spam by combining
    // each words probability of spam
    foreach ($words_data as $word => $word_probability) {
        $word_chances += $words_data[$word];
        $p_of_spam = $word_chances / count($words_data);
    }
    if ($p_of_spam > 0.60) {
        $status = 1; 
        echo $status.PHP_EOL;
    } else {
        $status = 0;
        echo $status.PHP_EOL;
    }
    return $status;
}
?>
