<?

namespace tests\Boggle;

use Boggle\Boggle;

class BoggleTest extends \PHPUnit_Framework_TestCase {
  public function test_setGameBoard() {
    $boggleGame = new Boggle();

    // base case (a square board)
    $this->assertTrue(
      $boggleGame->setGameBoard(
        [
          ['I', 'T', 'H', 'N', 'K', 'T'],
          ['U', 'M', 'B', 'L', 'R', 'S'],
          ['E', 'E', 'M', 'S', 'L', 'I'],
          ['K', 'E', 'A', 'C', 'O', 'O'],
          ['L', 'P', 'L', 'A', 'C', 'E'],
          ['T', 'O', 'W', 'O', 'R', 'K'],
        ]
      )
    );

    // bad characters
    $this->assertFalse(
      $boggleGame->setGameBoard(
        [
          ['I', 'T', 'H', 'N', 'K', 'T'],
          ['U', '!', 'B', 'L', 'R', 'S'],
          ['E', 'E', ' ', 'S', 'L', 'I'],
          ['K', 'E', 'A', 'C', 'O', 'O'],
          ['L', 'P', 'L', 'A', 'C', 'E'],
          ['T', 'O', 'W', 'O', 'R', 'K'],
        ]
      )
    );

    // non-square case
    $this->assertFalse(
      $boggleGame->setGameBoard(
        [
          ['I', 'T', 'H', 'N', 'K', 'T'],
          ['U', 'M', 'B', 'L', 'R', 'S'],
        ]
      )
    );

    // non-square case #2
    $this->assertFalse(
      $boggleGame->setGameBoard(
        [
          ['I', 'T'],
          ['U', 'M', 'B'],
        ]
      )
    );

    // string case
    $this->assertFalse(
      $boggleGame->setGameBoard('')
    );
  }

  public function testGetPrettyPrintGameBoard() {
    $boggleGame = new Boggle();

    $expectedOutput =
      'A R T Y' . PHP_EOL . 
      'E A O N' . PHP_EOL . 
      'Y S T D' . PHP_EOL . 
      'E C I C'
    ;

    $this->assertEquals(
      $expectedOutput,
      $boggleGame->getPrettyPrintGameBoard()
    );
  }

  public function testSetGameBoardAndPrettyPrintGameBoardWithLowerCaseLetters() {
    $boggleGame = new Boggle();
    $boggleGame->setGameBoard(
      [
        ['I', 'T', 'H', 'N'],
        ['U', 'm', 'B', 'L'],
        ['E', 'E', 'm', 'S'],
        ['K', 'E', 'A', 'C']
      ]
    );

    $expectedOutput =
      'I T H N' . PHP_EOL . 
      'U M B L' . PHP_EOL . 
      'E E M S' . PHP_EOL . 
      'K E A C'
    ;

    // base case (a square board)
    $this->assertEquals(
      $expectedOutput,
      $boggleGame->getPrettyPrintGameBoard()
    );
  }

  public function testWordIsInGameBoard() {
    $boggleGame = new Boggle();

    $this->assertTrue($boggleGame->wordIsInGameBoard('arty'));
    $this->assertTrue($boggleGame->wordIsInGameBoard('tony'));
    $this->assertTrue($boggleGame->wordIsInGameBoard('notice'));
    $this->assertTrue($boggleGame->wordIsInGameBoard('year'));
    $this->assertFalse($boggleGame->wordIsInGameBoard('stand'));
    $this->assertFalse($boggleGame->wordIsInGameBoard('party'));
    $this->assertFalse($boggleGame->wordIsInGameBoard('stick'));
  }

  public function testWordIsInGameBoardWeirdCasesQuickly() {
    $boggleGame = new Boggle();

    $boggleGame->setGameBoard([
      ['A', 'A', 'A'],
      ['E', 'B', 'D'],
      ['T', 'A', 'A']
    ]);

    $this->assertTrue($boggleGame->wordIsInGameBoard('a'));
    $this->assertTrue($boggleGame->wordIsInGameBoard('b'));
    $this->assertTrue($boggleGame->wordIsInGameBoard('t'));
    $this->assertTrue($boggleGame->wordIsInGameBoard('ab'));
    $this->assertTrue($boggleGame->wordIsInGameBoard('ba'));
    $this->assertTrue($boggleGame->wordIsInGameBoard('bet'));
    $this->assertTrue($boggleGame->wordIsInGameBoard('tab'));
    $this->assertTrue($boggleGame->wordIsInGameBoard('baa'));
    $this->assertFalse($boggleGame->wordIsInGameBoard(''));
    $this->assertFalse($boggleGame->wordIsInGameBoard('bad'));
    $this->assertFalse($boggleGame->wordIsInGameBoard('bed'));
    $this->assertFalse($boggleGame->wordIsInGameBoard('tad'));
    $this->assertFalse($boggleGame->wordIsInGameBoard('dab'));
  }

  public function testWordIsInGameBoardWithAlmostDupes() {
    $boggleGame = new Boggle();

    $boggleGame->setGameBoard([
      ['A', 'R', 'T'],
      ['R', 'D', 'S'],
      ['T', 'Y', 'M']
    ]);

    $this->assertTrue($boggleGame->wordIsInGameBoard('arty'));
    $this->assertTrue($boggleGame->wordIsInGameBoard('arts'));
    $this->assertFalse($boggleGame->wordIsInGameBoard('artsy'));
  }
}
