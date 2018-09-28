<?

require_once "./vendor/autoload.php";

use AnagramFinder\AnagramFinder;

$results = AnagramFinder::getAnagrams(
  [ "tumblr", "terse", "rest", "tears", "steer", "street" ],
  'trees'
);

var_dump($results);

// Expected result = [ "terse", "steer" ]
