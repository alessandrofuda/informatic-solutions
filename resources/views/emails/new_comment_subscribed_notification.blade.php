<!DOCTYPE html>

<html>

	<head>
		<title>Notifica da Informatic-Solutions - Pubblicato nuovo commento su una discussione che segui</title>
	</head>


	<body>
		<p> {{-- dd($subscriber->post->title) --}}
			Ciao {{ $subscriber->name }},<br>
			è stato pubblicato un nuovo commento in una discussione che segui su:<br>
			"<a href="{{ url($subscriber->post->slug) }}"><b>{{ $subscriber->post->title }}</b></a>"
		</p>
		
		<p>
			Commento di <em>{{ $comment->from_user_name }}</em>:<br>
			{{ $comment->body }}
		</p>

		<p><a href="{{ url($subscriber->post->slug) }}">Vai alla discussione.</a></p>

		<p><br></p>
		<p><br></p>
		<p><br></p>

		<p><a href="{{ url('unsubscribe/'. $subscriber->post->slug .'/'. $subscriber->code) }}">Clicca qui per cancellarti da questa discussione</a></p>

		
	</body>

</html>



