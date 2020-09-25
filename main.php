<?php

include 'parser.php';

class ComputorV2
{

  public $parser;

  function __construct()
  {
    $this->parser = new Parser();
  }

  public function prompter()
  {
    while (true) {
      $input = readline('> ');
      $this->parser->parse($input);
    }
  }

}

$app = new ComputorV2();
$app->prompter();
