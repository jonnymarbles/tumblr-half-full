<?

namespace Boggle;

class Boggle
{
  // Given a little more time, I probably would have implemented
  // a new class called something like SearchableMatrix to help
  // with the searching and manipulating of $gameBoard

	protected $gameBoard = [];

  protected $gameBoardLetterIndices;

  public function __construct($gameBoard = []) {
    $this->setGameBoard([
      ['A', 'R', 'T', 'Y'],
      ['E', 'A', 'O', 'N'],
      ['Y', 'S', 'T', 'D'],
      ['E', 'C', 'I', 'C']
    ]);
  }

  /**
   * Determines whether or not the given word exists in the $gameBoard.
   *
   * @param string $word
   *
   * @return boolean
   */
  public function wordIsInGameBoard($word) {
    // just in case
    if (strlen($word) == 0) {
      return false;
    }

    // make word uppercase
    $word = strtoupper($word);

    // get all the info we need
    $gameBoard = $this->getGameBoard();
    $gameBoardLetterIndices = $this->getGameBoardLetterIndices();
    $wordAsArr = str_split($word);

    // do the search
    $coordsHistory = []; // to ensure we don't reuse coords/tiles
    $nextValidLetterCoords = null; // will be set inside loop upon 2nd iteration
    for ($letterNumber = 0; $letterNumber < count($wordAsArr); $letterNumber++) {
      // make sure current letter exists on board
      if (!isset($gameBoardLetterIndices[$wordAsArr[$letterNumber]])) {
        return false;
      }

      // determine which coords to check for current letter
      if (!$nextValidLetterCoords) {
        $currentLetterCoords = $gameBoardLetterIndices[$wordAsArr[$letterNumber]];
      } else {
        $currentLetterCoords = $nextValidLetterCoords; // valid coords to check from last iteration
      }

      // if the current letter is the last letter, we passed, return true
      $nextValidLetter = isset($wordAsArr[$letterNumber + 1]) ? $wordAsArr[$letterNumber + 1] : '';
      if ($nextValidLetter == '') {
        return true;
      }

      // find valid next letter coords
      $nextValidLetterCoords = [];
      if (isset($gameBoardLetterIndices[$nextValidLetter])) {
        $nextLetterProspectiveCoords = $gameBoardLetterIndices[$nextValidLetter];

        // iterate over prospective coords to see which ones are valid to check on next iteration
        foreach ($nextLetterProspectiveCoords as $nextLetteRProspectiveCoord) {
          $prospectiveI = $nextLetteRProspectiveCoord[0];
          $prospectiveJ = $nextLetteRProspectiveCoord[1];

          // make sure prospective coord is no more than +/-1 away from at least one current coord
          $prospectiveCoordIsCloseEnough = false;
          foreach ($currentLetterCoords as $currentLetterCoord) {
            $currI = $currentLetterCoord[0];
            $currJ = $currentLetterCoord[1];

            if (
              (abs($currI - $prospectiveI) == 1 && $currJ == $prospectiveJ) ||
              (abs($currJ - $prospectiveJ) == 1 && $currI == $prospectiveI)
            ) {
              $prospectiveCoordIsCloseEnough = true;
            }
          }

          // make sure prospective coord has not already been traversed
          $prospectiveCoordIsInHistory = false;
          foreach ($coordsHistory as $coordHistory) {
            $historyI = $coordHistory[0];
            $historyJ = $coordHistory[1];

            if ($prospectiveI == $historyI && $prospectiveJ == $historyJ) {
              $prospectiveCoordIsInHistory = true;
            }
          }

          // only add prospective to next-valid if it passes both tests
          if ($prospectiveCoordIsCloseEnough && !$prospectiveCoordIsInHistory) {
            $nextValidLetterCoords[] = [$prospectiveI, $prospectiveJ];
          }
        }
      }

      // if there are no nextValidLetterCoords, we've failed
      if (count($nextValidLetterCoords) === 0) {
        return false;
      }

      // add nextValidLetterCoords to history
      foreach ($nextValidLetterCoords as $coord) {
        $coordsHistory[] = $coord;
      }
    }

    return false;
  }

  /**
   * Generates array of indices in $gameBoard that each letter can be found.
   * Basically like an index look-up table for letters.
   *
   * @return []
   */
  protected function getGameBoardLetterIndices() {
    if ($this->gameBoardLetterIndices) {
      return $this->gameBoardLetterIndices;
    }

    $gameBoardLetterIndices = [];
    $gameBoard = $this->getGameBoard();
    for ($i = 0; $i < count($gameBoard); $i++) {
      for ($j = 0; $j < count($gameBoard); $j++) {
        $currentLetter = $gameBoard[$i][$j];

        // if letter is new to array, add it
        if (!isset($gameBoardLetterIndices[$currentLetter])) {
          $gameBoardLetterIndices[$currentLetter] = [];
        }

        // save indices for letter
        array_push($gameBoardLetterIndices[$currentLetter], [$i, $j]);
      }
    }

    return $gameBoardLetterIndices;
  }

  /**
   * Returns gameBoard.
   *
   * @return []
   */
  public function getGameBoard() {
    return $this->gameBoard;
  }

  /**
   * Sets custom $gameBoard for play.
   *
   * @param [] $gameBoard (e.g.: see default $gameBoard in constructor)
   *
   * @return boolean
   */
  public function setGameBoard($gameBoard) {
    // verify it's an array
    if (!is_array($gameBoard)) {
      return false;
    }

    // verify gameboard
    if (!self::gameboardIsValid($gameBoard)) {
      return false;
    }

    // make sure it's uppercase for consistency sake
    for ($i = 0; $i < count($gameBoard); $i++) {
      for ($j = 0; $j < count($gameBoard[$i]); $j++) {
        $gameBoard[$i][$j] = strtoupper($gameBoard[$i][$j]);
      }
    }

    // you passed, we'll save it
    $this->gameBoard = $gameBoard;

    return true;
  }

  /** 
   * Returns readable/printable string of $gameBoard.
   *
   * @return string
   */
  public function getPrettyPrintGameBoard() {
    $rows = [];

    foreach ($this->gameBoard as $row) {
      array_push($rows, implode(' ', $row));
    }

    return implode(PHP_EOL, $rows);
  }

  /** 
   * Determines whether or not $gameBoard is valid, meaning
   * it is a square and consists of only alphabetic characters.
   *
   * @param [] $gameBoard (e.g.: see default $gameBoard in constructor)
   *
   * @return boolean
   */
  protected static function gameboardIsValid($gameBoard) {
    // verify it's a square
    for ($i = 0; $i < count($gameBoard); $i++) {
      // make sure row size is correct
      if (count($gameBoard[$i]) != count($gameBoard)) {
        return false;
      }

      // make sure row is all alphabetic characters
      for ($j = 0; $j < count($gameBoard[$i]); $j++) {
        if (!ctype_alpha($gameBoard[$i][$j])) {
          return false;
        }
      }
    }

    return true;
  }
}