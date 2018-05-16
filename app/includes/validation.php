<?php
function validateInputs($inputs){
      $regex= 'ABCDEFGHIJKLMNOPQRSTUVWXYZÄÖÜabcdefghijklmnopqrstuvwxyzäöü0123456789._# -ß';
      for($i=0; $i < sizeof($inputs); $i++){
              for($c=0; $c < strlen($inputs[$i]); $c++){
                      if(!in_array($inputs[$i][$c], str_split($regex))){
                              return false;
                      }
              }
      }
      return true;
}
?>
