<?php

function filled_out($form_vars) {
  // test that each variable has a value
  foreach ($form_vars as $key => $value)   {
     if (!isset($key) || ($value == '')) {
        //echo "Make sure you enter a " . $key;
        return false;
     }
  }
  return true;
}

?>
