<p>SaveStrings<br />
<br />
PRIMA DI QUALSIASI DOMANDA, LEGGERE ATTENTAMENTE LA DOCUMENTAZIONE E FARE DEI TEST TRAMITE BROWSER!<br />
<br />
	è un servizio, che previa registrazione, permette di salvare delle stringhe ( identificate da una "key" ) e recuperarle in un secondo momento.<br />
	Tutte le funzioni di questo servizio sono strutturate da ritornare un JSON contenente:<br />
<br />
	- status ( "ok" o "error" ) <br />
	- value ( se lo status è "ok" ) <br />
	- message ( se lo status è "error" ) <br />
<br />
	il value varia in base al tipo di richiesta<br />
<br />
<br />
	il servizio presenta le seguenti funzioni:<br />
	<br />
	- register.php - permette di registrarsi al servizio con username e passord<br />
		Parametri GET:  <br />
		- username ( string )  <br />
		- password ( string ) <br />
		<br />
		se i parametri sono errati o l'utente è già presente viene ritornato un "error" con il relativo messaggio<br />
<br />
	- getToken.php - permette di recuperare il token da utilizzare per le successive richieste<br />
		Parametri GET:  <br />
		- username ( string )  <br />
		- password ( string ) <br />
		<br />
		<br />
		se i parametri sono errati o user/pass sono sbagliati viene ritornato un in "error" con il relativo messaggio<br />
<br />
		ATTENZIONE!: ogni qual volta che il token viene generato, il token precedente viene cancellato!<br />
<br />
	- setString.php - permette di salvare/impostare una stringa<br />
		Parametri GET:  <br />
		- token ( string )  <br />
		- key ( string ) <br />
		- string ( string ) <br />
		<br />
		<br />
		se i parametri sono errati viene ritornato un in "error" con il relativo messaggio<br />
<br />
<br />
	- getString.php - permette di ritornare una stringa data la sua key<br />
		Parametri GET:  <br />
		- token ( string )  <br />
		- key ( string ) <br />
		<br />
		<br />
		se i parametri sono errati o la key non esiste viene ritornato un in "error" con il relativo messaggio<br />
<br />
<br />
	- deleteString.php - permette di rimuovere una string data la sua key<br />
		Parametri GET:  <br />
		- token ( string )  <br />
		- key ( string ) <br />
		<br />
		<br />
		se i parametri sono errati viene ritornato un in "error" con il relativo messaggio<br />
<br />
<br />
	- getKeys.php - ritorna la lista di key associati al token specificato<br />
		Parametri GET:  <br />
		- token ( string )  <br />
		<br />
		<br />
		se i parametri sono errati viene ritornato un in "error" con il relativo messaggio<br />
<br />
<br />
<br />
<br />
<br />
test:<br />
<br />
http://localhost/SaveStrings/register.php?username=aaa&password=bbb<br />
	registra l'utente "aaa" con password "bbb"<br />
<br />
http://localhost/SaveStrings/getToken.php?username=aaa&password=bbb<br />
	ottiene il token relativo all'utente "aaa" con pass "bbb"<br />
	( immaginiamo -> 697ab188731ec4861e1eb72eca7a18d2 ) <br />
	<br />
http://localhost/SaveStrings/setString.php?token=697ab188731ec4861e1eb72eca7a18d2&key=IDENTIFICATIVO&string=HELLO_WORLD<br />
	permette di settare nell'account relativo al token 697ab188731ec4861e1eb72eca7a18d2 <br />
	una stringa identificata ( key ) da "IDENTIFICATIVO" e contenente "HELLO_WORLD"<br />
<br />
http://localhost/SaveStrings/getString.php?token=697ab188731ec4861e1eb72eca7a18d2&key=IDENTIFICATIVO<br />
	permette di leggere il contenuto della stringa identificata dalla key "IDENTIFICATIVO" <br />
	presente nell'account relativo al token 697ab188731ec4861e1eb72eca7a18d2<br />
	<br />
http://localhost/SaveStrings/deleteString.php?token=697ab188731ec4861e1eb72eca7a18d2&key=IDENTIFICATIVO<br />
	permette di cancellare la stringa identificata dalla key "IDENTIFICATIVO" <br />
	presente nell'account relativo al token 697ab188731ec4861e1eb72eca7a18d2<br />
	<br />
http://localhost/SaveStrings/getKeys.php?token=697ab188731ec4861e1eb72eca7a18d2<br />
	permette di ottenere la lista di tutte le key presenti nell'account relativo al token 697ab188731ec4861e1eb72eca7a18d2<br />
</p>