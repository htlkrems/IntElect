<script type="text/javascript" src="{{asset('js/jquery-2.1.1.min.js')}}"></script>
<link rel="stylesheet" href="{{asset('css/material-icons.css')}}">
<script src="{{asset('js/materialize.min.js')}}"></script>
<link rel="stylesheet" type="text/css" href="{{asset('css/materialize.min.css')}}">
<link rel="icon" type="image/svg+xml" href="{{asset('favicon.svg')}}" sizes="any">
<script type="text/javascript" src="{{asset('js/validation.js')}}"></script>
<script>
$(document).ready(function(){
var message=<?php if(isset($message)) {echo $message;} ?>;
if(message != null){
        switch(message){
                case 0:
                        printMessage('Unbekannter Fehler!', true);
                        break;

		// --- ERROR ---
		case 1:
	                printMessage('Ungültige Zeichen eingegeben!', true);
			break;
		case 2:
			printMessage('Benutzername oder Passwort falsch!', true);
                        break;
		case 3:
                        printMessage('Keine Berechtigung!', true);
                        break;
		case 4:
                        printMessage('Ungültiger Einmalcode!', true);
                        break;
		case 5:
                        printMessage('Einmalcode bereits verwendet!', true);
                        break;
                case 6:
                        printMessage('Ungültig abgestimmt!', true);
                        break;
                case 7:
                        printMessage('Passwörter stimmen nicht überein!', true);
                        break;
                case 8:
                        printMessage('Falsches altes Passwort!', true);
                        break;
		case 9:
                        printMessage('Benutzername bereits vergeben!', true);
			break;
		case 10:
                        printMessage('Zuerst Wahlgruppen von User entfernen!', true);
			break;
		case 11:
			printMessage('Aktion in diesem Zeitraum nicht möglich!', true);
			break;

		// --- SUCCESS ---
		case 51:
                        printMessage('Erfolgreich angemeldet!', false);
                        break;
                case 52:
                        printMessage('Erfolgreich abgemeldet!', false);
                        break;
                case 53:
                        printMessage('Erfolgreich abgestimmt!', false);
                        break;
                case 54:
                        printMessage('Erfolgreich registriert!', false);
                        break;
                case 55:
                        printMessage('Passwort erfolgreich geändert!', false);
                        break;
		case 56:
                        printMessage('Tokens erfolgreich erzeugt!', false);
                        break;
		case 57:
                        printMessage('Erfolgreich erstellt!', false);
                        break;
		case 58:
                        printMessage('Erfolgreich bearbeitet!', false);
                        break;
		case 59:
                        printMessage('Kandidat akzeptiert!', false);
                        break;
		case 60:
                        printMessage('Kandidat ablehnen!', false);
                        break;
		case 61:
                        printMessage('Erfolgreich hinzugefügt!', false);
                        break;
		case 62:
                        printMessage('Erfolgreich entfernt!', false);
                        break;
		case 63:
                        printMessage('Erfolgreich gelöscht!', false);
                        break;

		// --- DEFAULT ---
		default:
			printMessage('Ungültiger Error Code!', true);
			break;
        }
}
});

function printMessage(messageStr, isError){
	if(isError){
		Materialize.toast(messageStr, 4000, 'red');
	} else {
		Materialize.toast(messageStr, 4000, 'blue');
	}
}
</script>
