<?

require_once "./vendor/autoload.php";

use Boggle\Boggle;

$boggle = new Boggle();

$wordToCheck = isset($argv[1]) ? $argv[1] : '';

if ($wordToCheck) {
  $result = $boggle->wordIsInGameBoard($wordToCheck) ? 'true' : 'false';
  echo strtolower($wordToCheck) . ' => ' . $result . PHP_EOL;
}

die;