<?php
if (!function_exists('array_group_by')) {
	/**
	 * Groups an array by a given key.
	 *
	 * Groups an array into arrays by a given key, or set of keys, shared between all array members.
	 *
	 * Based on {@author Jake Zatecky}'s {@link https://github.com/jakezatecky/array_group_by array_group_by()} function.
	 * This variant allows $key to be closures.
	 *
	 * @param array $array   The array to have grouping performed on.
	 * @param mixed $key,... The key to group or split by. Can be a _string_,
	 *                       an _integer_, a _float_, or a _callable_.
	 *
	 *                       If the key is a callback, it must return
	 *                       a valid key from the array.
	 *
	 *                       If the key is _NULL_, the iterated element is skipped.
	 *
	 *                       ```
	 *                       string|int callback ( mixed $item )
	 *                       ```
	 *
	 * @return array|null Returns a multidimensional array or `null` if `$key` is invalid.
	 */
	function array_group_by(array $array, $key)
	{
		if (!is_string($key) && !is_int($key) && !is_float($key) && !is_callable($key) ) {
			trigger_error('array_group_by(): The key should be a string, an integer, or a callback', E_USER_ERROR);
			return null;
		}
		$func = (!is_string($key) && is_callable($key) ? $key : null);
		$_key = $key;
		// Load the new array, splitting by the target key
		$grouped = [];
		foreach ($array as $value) {
			$key = null;
			if (is_callable($func)) {
				$key = call_user_func($func, $value);
			} elseif (is_object($value) && isset($value->{$_key})) {
				$key = $value->{$_key};
			} elseif (isset($value[$_key])) {
				$key = $value[$_key];
			}
			if ($key === null) {
				continue;
			}
			$grouped[$key][] = $value;
		}
		// Recursively build a nested grouping if more parameters are supplied
		// Each grouped array value is grouped according to the next sequential key
		if (func_num_args() > 2) {
			$args = func_get_args();
			foreach ($grouped as $key => $value) {
				$params = array_merge([ $value ], array_slice($args, 2, func_num_args()));
				$grouped[$key] = call_user_func_array('array_group_by', $params);
			}
		}
		return $grouped;
	}
}

// $arr = array( 
//     array('answer_id' => 21, 'question_id' => 21, 'user_id' => 'admin', 'vote' => 1), 
//     array('answer_id' => 21, 'question_id' => 21, 'user_id' => 'jylee', 'vote' => 1), 
//     array('answer_id' => 21, 'question_id' => 21, 'user_id' => 'chljy33', 'vote' => 1), 
//     array('answer_id' => 22, 'question_id' => 21, 'user_id' => NULL, 'vote' => 0), 
// ); 



//$arr1 = array();
$arr2 = array( 
    array('answer_id' => 21, 'question_id' => 21, 'user_id' => 'admin', 'vote' => 1), 
    array('answer_id' => 21, 'question_id' => 21, 'user_id' => 'jylee', 'vote' => 1), 
    array('answer_id' => 21, 'question_id' => 21, 'user_id' => 'chljy33', 'vote' => -1), 
    array('answer_id' => 22, 'question_id' => 21, 'user_id' => NULL, 'vote' => 0), 
);

$grouped = array_group_by($arr2, 'answer_id');

print_r($grouped);
echo "<br>";

foreach ($grouped as &$value) {
    $initial = array_shift($value); 
    $initial['votesum'] = $initial['vote'];
    
    $t = array_reduce($value, function($result, $item) { 
        if($item['user_id'] == 'chljy33'){
            $result['myuser'] = $item['user_id'];
            $result['myvote'] = $item['vote'];
        }
        $result['votesum'] += $item['vote'];  
    
        return $result; 
    }, $initial); 
    echo "<br>";
    print_r($t);
}


//a.answer_id, a.question_id, a.user_id, a.content, a.create_date
//, a.modify_date, a.label, a.title, v.user_id, IFNULL(v.vote, 0) AS vote
?>