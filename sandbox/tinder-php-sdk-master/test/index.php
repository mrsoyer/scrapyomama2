<?php
require '../../vendor/autoload.php';

$tinder = new \Pecee\Http\Service\Tinder('100005991630712', 'EAAGm0PX4ZCpsBAOYzZBkwlKAknJVQRYBEE1IzacMgeTCNTZA5vHhbdn3so6gyqDcnZCwHlQH19XSxNywhUIkayFn1wLvNkPczavBaSsMte30KSjv8OiWOwZBiJOp38IHqQqck6M1u85b8IWURaZC33YvfJtGQMhaZCVwefORdUXaCnNO2fZBFu2vBEopWzpsz5LXRY8FgwGUyx9vZB4p27TqxZBqHRY8bZC4SdosGxQNZC6ZCbwZDZD');

var_dump($tinder->getUser());

var_dump($tinder->updateProfile(array('age_filter_min' => 26, 'gender' => 1, 'age_filter_max' => 18, 'distance_filter' => 14)));