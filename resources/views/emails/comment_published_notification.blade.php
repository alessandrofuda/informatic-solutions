<!DOCTYPE html>

<html>

	<head>
		<title>Notifica da Informatic-Solutions - Nuovo commento pubblicato sul sito</title>
	</head>


	<body>
		<p>Ciao {{ $comment->from_user_name }},</p>

		<p>il tuo commento a "<b>{{ $comment->post->title }}</b>" è stato approvato e pubblicato sul sito Informatic-solutions.it</p>

		<p>Testo del commmento:</p>

		<p><blockquote>{{ $comment->body }}</blockquote></p>

		<p><br></p>

		<p>Vail al commento: <a href="{{ url($comment->post->slug.'#comment-'.$comment->id) }}">{{ url($comment->post->slug) }}</a></p>
		

		
	</body>

</html>



