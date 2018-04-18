<?php
function getFirst($text, $number=2) {
  // regular expression to find typical sentence endings
  $pattern = '/([.?!]["\']?)\s/';
  // use regex to insert break indicator
  $text = preg_replace($pattern, '$1bRE@kH3re', $text);
  // use break indicator to create array of sentences
  $sentences = preg_split('/bRE@kH3re/', $text);
  // check relative length of array and requested number
  $howMany = count($sentences);
  $number = $howMany >= $number ? $number : $howMany;
  // rebuild extract and return as single string
  $remainder = array_splice($sentences, $number);
  $result = array();
  $result[0] = implode(' ', $sentences);
  $result[1] = empty($remainder) ? false : true;
  return $result;
  }
?>