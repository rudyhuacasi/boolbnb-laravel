<?php

namespace App\Functions;

class Helpers
{

  public static function getCSV(string $file)
  {
    $labels = [];
    $result = [];

    $row = 1;
    if (($handle = fopen($file, "r")) !== FALSE) {

      while (($data = fgetcsv($handle)) !== FALSE) {

        $current_row = [];
        if ($row === 1) {
          foreach ($data as $label) {
            $labels[] = trim(strtolower($label));
          }
        } else {
          foreach ($data as $key => $value) {
            $current_key = $labels[$key];
            $current_row[$current_key] = $value;
          }
          array_push($result, $current_row);
        }

        $row++;
      }

      fclose($handle);

      return $result;
    }
  }
}
