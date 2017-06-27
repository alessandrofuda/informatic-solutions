<!DOCTYPE html>

<html>

<head>
	<title>Notifica da Informatic-Solutions.it - Inviata una richiesta di contatto</title>
</head>


<body>
	<p>Nuovo contatto da http://informatic-solutions.it</p>

	{{-- dd($request) --}}
	
	<p>
		Data: {{ $request->data }}<br>
		IP: {{ $request->ip }}
	</p>

	<p>
		Nome: {{ $request->nome }}<br>
		Cognome: {{ $request->cognome }}<br>
		Mail: {{ $request->email }}<br>
		Telefono: {{ $request->phone }}
	</p>

	<p>
		Sito: {{ $request->sito }}<br>
		Come mi ha trovato: {{ $request->come }}<br>
		Tipo di Servizio: {{ $request->servizio }}<br>
		Tipo di budget: {{ $request->budget }}
	</p>
	
	<p>Messaggio: {{ $request->messaggio }}</p>
	
</body>
</html>



