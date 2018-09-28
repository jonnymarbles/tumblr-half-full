<?

namespace AnagramFinder;

class AnagramFinder
{
  /** 
   * Returns an array of any anagrams of $needle that are found in $haystack.
   *
   * @param [] $haystack
   * @param string $needle
   *
   * @return []
   */
  static function getAnagrams($haystack, $needle) {
    $anagrams = [];

    foreach ($haystack as $word1) {
      if (static::isAnagram($word1, $needle)) {
        array_push($anagrams, $word1);
      }
    }

    return $anagrams;
  }

  /**
   * Returns true if $word1 is an anagram of $word2, else false.
   *
   * @param string $word1
   * @param string $word2
   *
   * @return boolean
   */
  static protected function isAnagram($word1, $word2) {
    // convert strings to arrays
    $word1Arr = str_split($word1);
    $word2Arr = str_split($word2);

    // alphabetize them
    sort($word1Arr);
    sort($word2Arr);

    return $word1Arr == $word2Arr;
  }
}
