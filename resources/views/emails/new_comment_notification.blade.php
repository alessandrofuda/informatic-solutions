<!DOCTYPE html>

<html>

	<head>
		<title>Notifica da Informatic-Solutions - Inviato nuovo commento per la moderazione</title>
	</head>


	<body>
		<p>Nuovo commento inviato per la moderazione:</p>

		

		<p>Url: <a href="{{ url($comment->post->slug) }}">{{ url($comment->post->slug) }}</a></p>
		{{-- $comment --}}
		
		<p>
			Data: {{ date('d/m/Y - H:i:s', strtotime($comment->created_at)) }}<br>
			IP: {{ $comment->from_user_ip }}<br>
			User Agent: {{ $comment->comment_agent}}
		</p>

		<p>
			Comment Id:{{ $comment->id }}<br>
			Post Id:{{ $comment->on_post }}<br>
			Post title: {{ $comment->post->title }}
		</p>

		<p>
			Nome: {{ $comment->from_user_name }}<br>
			Mail: {{ $comment->from_user_email }}<br>
			<!--Url: {{--  --}}<br>-->
			<!--Commento genitore: {{-- --}} <br>-->
			Commento: {{ $comment->body }}
		</p>

		<p>
			<a href="{{ url('backend/pending-comments') }}">Vai qui per la moderazione</a>
		</p>

		
	</body>

</html>



