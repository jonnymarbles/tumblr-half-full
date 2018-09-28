<?php

namespace tests\AnagramFinder;

use AnagramFinder\AnagramFinder;

class AnagramFinderTest extends \PHPUnit_Framework_TestCase {
	public function test_getAnagrams() {
    $anagrams = AnagramFinder::getAnagrams([ "tumblr", "terse", "rest", "tears", "steer", "street" ], 'trees');
    $this->assertEquals($anagrams, [ "terse", "steer" ]);
	}
}
