<?php

// connect to the mlm database
function db_connect() {
   $result = new mysqli('localhost', 'ideapale_vsadmin', 'vspass', 'ideapale_vacations');
   if (!$result) {
      return false;
   }
   return $result;
}

?>
