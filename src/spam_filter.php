<?php
// message, spam
$dataset = array(
	array('good message', 0.0, 1.0),
    array('good message', 0.0, 1.0),
    array('good message', 0.0, 1.0),
    array('spam message', 1.0, 0.0),
    array('spam message', 1.0, 0.0)
);

// word, occured as ham, occured as spam,
$keywords = array(
	array('good', 1.0, 0.0),
	array('spam', 0.0, 1.0),
	array('message', 1.0, 1.0)
);

function train($dataset, $keywords) {
	$training_words_data = [];
    $training_file = fopen("train", "r") or die("Unable to open file!");
    echo "Opening training file..." . PHP_EOL;

	while($line = fgets($training_file)) {
		$message_data = explode(">>> ", $line);
		
		if($message_data[0] == "ham") {
			array_push($dataset, array(strip_punctuation($message_data[1]), 0.0, 1.0));
        }
        elseif($message_data[0] == "spam") {
			array_push($dataset, array(strip_punctuation($message_data[1]), 1.0, 0.0));
        }
        else {
			echo "error";
        }
    }	
	fclose($training_file);		


	for($i=0; $i < count($dataset); $i++) {
		$tw = explode(" ", $dataset[$i][0]); 
		$training_words = []; 
		foreach($tw as $w) {
			array_push($tw, array($w, $dataset[$i][1], $dataset[$i][2]));
		}
		$word_found = FALSE;
		
		for($j=0; $j < count($training_words); $j++) {
			for($k=0; $k < count($keywords); $k++) {
				if($training_words[$j] === $keywords[$k][0]) {				
					if($training_words[$j][1] > $training_words[$j][2]) {
						$keywords[$k][1] += 1.0;
					}
                else {
                    $keywords[$k][2] += 1.0;
                }
					$word_found = TRUE;
				}
			}
			if(!$word_found) {
				array_push($keywords, $training_words[$j]);
			}	
        }
    }
}

function strip_punctuation($message) {
	$message = strtolower($message);
	$punctuation = array(',', '?', '.', '/', '!');
	$message = str_replace($punctuation, '', $message);
	return $message;
}

function get_probability_of_word($word, $keywords) {
	$amount_of_ham = 0.0;
	$amount_of_spam = 0.0;
	$word_found = FALSE;

	for($i=0; $i < count($keywords); $i++) {
		if(strcmp($word, $keywords[$i][0]) == 0) {
			$amount_of_ham = $keywords[$i][1];
			$amount_of_spam = $keywords[$i][2];
			echo "Word found." . PHP_EOL;
			$word_found = TRUE;
		}
		if($i == (count($keywords)-1) && $word_found == FALSE) {
			echo "Word not found. Added to keywords." . PHP_EOL;
			array_push($keywords[0], $word, 0.0, 0.0);
		}
	}

    // find the probability of spam or ham and
    // average(?) them
    if($amount_of_spam > 0.0 && $amount_of_ham > 0.0) {
        $p_of_word = ($amount_of_spam / count($keywords)) * ($amount_of_ham / count($keywords));
    }
    elseif($amount_of_spam == 0.0) {
        $p_of_word = 0.0;
    }
    else {
        $p_of_word = 1.0;
    }
    return $p_of_word;
}

function check_message($message, $dataset, $keywords) {
	$message = strip_punctuation($message);
	$word_list = explode(" ", $message);
	$words_data = array_fill_keys($word_list, 0.0);
	$status = "";
	$p_of_spam = 0.0;
	$word_chances = 0.0;

	// get the probabilities of words
	// from training data
	foreach($words_data as $word=>$word_probability) {
		$p_of_word = get_probability_of_word($word, $keywords);
		$words_data[$word] = $p_of_word;
	}

	// get the total probability of spam by combining
	// each words probability of spam
	foreach($words_data as $word=>$word_probability) {
		$word_chances += $words_data[$word];
		$p_of_spam = $word_chances / count($words_data);
	}
	if($p_of_spam > 0.60) {
		array_push($dataset, array($message, 1.0));
		$status = "Message is spam." . PHP_EOL;
		echo $status;
	}
	else {
		array_push($dataset, array($message, 0.0));
		$status = "Message is ham." . PHP_EOL;
		echo $status;
	}
	return $status;
	print_r($keywords);
}

$input = readline("Enter a message:");
// train($dataset, $keywords);
check_message($input, $dataset, $keywords);
?>
