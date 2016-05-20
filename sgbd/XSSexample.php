<?php
function _e($string){
    return htmlspecialchars($string,ENT_QUOTES,'UTF-8');
}

$name ="<script>alert('SSSs');</script>";
$s=_e($name);
echo $s;
?>