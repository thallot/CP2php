<?php

class Parser {

  public $regex = [
    'functionDef' => "/^[a-zA-Z]+\([a-zA-Z]+\)/",
    'functionCalc' => "/^[a-zA-Z]+\([[+-]?\d*\.?\d+\)/",

    'matrice' => "/^(\[+[\d,]+\]+)/",
    'complex' => '/^(?=[iI.\d+-])([+-]?(?:[eE][+-]?\d+)?(?![iI.\d]))?([+-]?(?:(?:\d+(?:\.\d*)?|\.\d+)(?:[eE][+-]?\d+)?)?[iI])?/',

    'variable' => "/^[a-zA-Z]+/",
    'number' => "/^[+-]?\d*\.?\d+/",
  ];

  public $error = false;

  public $result;

  public $toParse;

  /* Delete space and replace %d * i by %d i */
  public function initParser(string $str)
  {
    $this->result = [];

    $str = str_replace(' ', '', $str);
    $str = preg_replace('/(\d+)(\*)(i)/', '\\1\\3', $str);
    $this->toParse = $str;
  }

  /* store regex result in array and return substring without regex result */
  public function extractIfMatch(string $regex, string $type)
  {
    $matches = [];
    if (preg_match($regex, $this->toParse, $matches))
    {
      $this->result[] = [$type => current($matches)];
      $this->toParse = substr($this->toParse, strlen(current($matches)));;
    }

  }

  public function useRegex()
  {
    while (strlen($this->toParse) > 0)
    {
      $len = strlen($this->toParse);

      foreach ($this->regex as $type => $regex) {
        $this->extractIfMatch($regex, $type);
      }

      if ($len == strlen($this->toParse)) {
        $this->error = true;
        break ;
      }
    }
  }

  public function parse(string $toParse)
  {
      $this->initParser($toParse);
      $this->useRegex();

      print_r($this->result);
  }
}
