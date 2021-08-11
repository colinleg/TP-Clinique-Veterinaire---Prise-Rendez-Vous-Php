<?php
function isWeekend($date) {
      return (date('N', strtotime($date)) >= 6);
}
?>