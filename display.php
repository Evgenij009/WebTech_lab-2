<?php

define("LEVELS", array("first-level", "second-level", "third-level", "fourth-level", "fifth-level"));
define("FIRST_LEVEL", 1);
define("LAST_LEVEL", 5);
define("NOT_ENOUGH_ELEMENTS", "Пожалуйста, введите не менее 20 значений.");


function buildArray()
{
  $size = 0;
  $counter = FIRST_LEVEL;
  $multidimensional_array = array();
  $next_level = &$multidimensional_array;
  foreach (LEVELS as $level) {
    $level_data = preg_split("[ ]", $_POST[$level]);
    $level_nums = array();
    foreach ($level_data as $level_data_str) {
      $level_data_str = trim($level_data_str);
      $level_nums[] = $level_data_str;
      $size++;
    }
    $next_level = $level_nums;
    if ($counter++ != LAST_LEVEL) {
      $next_level[] = array();
      $next_level = &$next_level[count($next_level) - 1];
    }
  }
  if ($size < 20) {
    return NOT_ENOUGH_ELEMENTS;
  }
  return $multidimensional_array;
}

function printLevelArray($multidimensional_array)
{
  $counter = 1;
  $next_level = $multidimensional_array;
  do {
    echo "<h2 style=\"color: " . "black" . "\">";
    foreach ($next_level as $next_level_elem) {
      if (!is_array($next_level_elem)) {
        echo $next_level_elem . "   ";
      }
    }
    $last_elem = count($next_level) - 1;
    echo "</h2>";
    if ($counter < LAST_LEVEL) {
      $next_level = $next_level[$last_elem];
    }
  } while (++$counter <= LAST_LEVEL);
}

function get_full_array($multidimensional_array)
{
  $full_array = array();
  $counter = FIRST_LEVEL;
  $next_level = $multidimensional_array;
  do {
    foreach ($next_level as $next_level_elem) {
      if (!is_array($next_level_elem)) {
        $full_array[] = $next_level_elem;
      }
    }
    if ($counter != 5) {
      $next_level = $next_level[count($next_level) - 1];
    }
  } while (++$counter <= LAST_LEVEL);
  return $full_array;
}

function workArray(&$multidimensional_array)
{
  $full_array = get_full_array($multidimensional_array);
  $full_array = processingArray($full_array);
  sort($full_array);
  $counter = FIRST_LEVEL;
  $next_level = &$multidimensional_array;
  $first_index = 0;
  do {
    $length = count($next_level);
    $last_elem = $next_level[$length - 1];
    $next_level = array_slice($full_array, $first_index, $length - 1);
    $first_index += $length - 1;
    if ($counter != 5) {
      $next_level[] = $last_elem;
      $next_level = &$next_level[$length - 1];
    } else {
      $next_level[] = $full_array[count($full_array) - 1];
    }
  } while (++$counter <= LAST_LEVEL);
}

function processingArray($array_elemets)
{
  foreach ($array_elemets as $key => $element) {
    if (is_numeric($element)) {
      // echo "$element  =  ";
      if (ctype_digit($element)) {
        unset($array_elemets[$key]);
        // echo "delete-";
      } elseif (strval((float)$element) == (string)$element) {
        $element =  round($element, 2);
        $array_elemets[$key] = $element;
      }
      // echo $element;
      // echo "<br>";
    } elseif (is_string($element)) {
      $array_elemets[$key] = mb_strtoupper($element);
    }
  }
  return $array_elemets;
}



?>

<div class="logs">
  <?php
  $array = buildArray();
  if (!is_array($array)) {
    echo "<h1>" . $array . "</h1>";
    return;
  }
  ?>
</div>

<div class="level-array">
  <?php
  echo "<h1>Исходный:</h1>";
  printLevelArray($array);
  echo "<h1>Итог:</h1>";
  workArray($array);
  printLevelArray($array);

  // echo "<pre>";
  // print_r($array);
  // echo "</pre>";
  ?>
</div>
