<!DOCTYPE html>

<html>

	<head>
		<title>Notifica da Informatic-Solutions - Iscritto un nuovo utente al comparatore</title>
	</head>


	<body>
		<p> Informatic-solutions:un nuovo utente verificato è stato inserito in database:</p>
		<p>
			Id: {{ $user->id }}<br>
			Nome utente: {{ $user->name }}<br>
			Email: {{ $user->email }}<br>
			Profilo: {{ $user->role }}<br>
			Data di registrazione: {{ $user->updated_at }}<br>
		</p>
		

		<p><br></p>
		<p><br></p>
		<p><br></p>
		
	</body>

</html>



