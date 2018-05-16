function validateform(){
 var regex= 'ABCDEFGHIJKLMNOPQRSTUVWXYZÄÖÜabcdefghijklmnopqrstuvwxyzäöü0123456789._# -ß';
 var inputList=document.getElementsByClassName('tovalidate');
  for (var i = 0, length = inputList.length; i < length; i++) {
     for (var c = 0, lengthS = inputList[i].value.length; c < lengthS; c++) {
     if(!regex.includes(inputList[i].value[c])){
        Materialize.toast('Ungültige Zeichen eingegeben!', 4000);
        return false;
     }
    }
  }
  return true;
}
