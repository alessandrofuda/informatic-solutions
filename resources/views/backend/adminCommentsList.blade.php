@extends('layouts.comparator')

@section('content')

<div id="comment-list" class="container" style="padding: 0; font-size: 10px;">
    <div class="row">
        <div class="col-md-12 col-md-offset-0">
            <div class="panel panel-default">
                <div class="panel-heading text-center">
                    @if ( $all === true )
                        <h3>Elenco di tutti i commenti presenti in db</h3>
                        <a href="{{route('admin.pending-comments')}}" class="btn btn-primary btn-sm">Vai ai soli commenti in moderazione</a>
                    @else
                        <h3>Elenco dei commenti in coda di moderazione</h3>
                        <a href="{{route('admin.comments')}}" class="btn btn-primary btn-sm">Vai a tutti i commenti</a>
                    @endif
                </div>
                
                <div class="panel-body">

                		<div class="pagination-wrap text-center">
                			{{ $comments->links() }} <!--pagination-->
                		</div>

                	<table class="table table-striped">
                		<thead>
                            <td><b>Id</b></td>
                			<td><b>Titolo articolo</b></td>
                			<td><b>Autore</b></td>
                            <td><b>E-mail</b></td>
                			<td class="text-center"><b>Commento</b></td>
                			<td><b>Data di creazione</b></td>
                			<td><b>Status</b></td>
                			<td><b>Indirizzo IP</b></td>
                            <td></td>
                		</thead>

                        @if (count($comments) == 0)
                            <div class="alert alert-success text-center" role="alert">Non ci sono commenti</div>
                        @endif
                        

                		@foreach ($comments as $comment)
                		
                		<tr>
                            <td><b>{{ $comment->id }}</b></td>
                			<td>{{ $comment->post->title }}</td>
                			<td>{{ $comment->from_user_name }}</td>
                			<td>{{ $comment->from_user_email }}</td>
                            <td>{{ $comment->body }}</td>
                			<td>{{ date('d/m/Y - H:i' , strtotime($comment->created_at)) }}</td>
                			<td class="text-center">
                				@if ($comment->comment_approved)
                					<span style="color: green;">Pubblicato</span>
                                    <!--a class="btn btn-warning btn-sm btn-v-space"><b>S</b>pubblica</a-->
                				@else 
                					<span style="color: red;">Non pubblicato</span>
                                    <a href="{{ url('admin/publish-comment-'. $comment->id . '?origin='.$origin) }}" class="btn btn-default btn-sm btn-v-space">Pubblica</a>
                				@endif
                			</td>
                			<td class="text-center">{{ $comment->from_user_ip }}

                                {{--@if ($article->is_published && ! Auth::user()->isAdmin())

                                    <div class="btn btn-default" style="white-space: normal;">Solo l'Admin può editare articoli pubblicati</div>

                                @else

                				    
                                        <a class="btn btn-info" href="{{ url('admin/articles/edit/' . $article->id) }}">Modifica</a>
                                    

                    				<form style="display: inline-block;" action="{{ url('admin/articles/delete/' . $article->id) }}" method="post">
    									{{ csrf_field() }}
    									<input class="btn btn-danger" type="submit" name="delete" value="Cancella" onclick="return confirm('Confermare la cancellazione dell\'articolo?')" /> 
                    				</form>

                                @endif --}}

                			</td>
                            <td class="text-center">
                                <a href="{{ url('admin/edit-comment-'. $comment->id . '?origin='.$origin) }}" class="btn btn-primary btn-sm btn-v-space">Modifica</a>
                                <a href="{{ url('admin/delete-comment-'. $comment->id . '?origin='.$origin) }}" class="btn btn-danger btn-sm btn-v-space" onclick="return confirm('Confermare la cancellazione del commento?')" >Elimina</a>
                            </td>

                		</tr>

                		@endforeach

                	</table>

                    <div class="text-center">
                        {{ $comments->links() }}
                    </div>

                	<div class="text-center">
                        <a class="btn btn-primary btn-sm" href="{{ route('admin.home') }}">Torna alla dashboard</a>
                	</div>

                </div>
               	</div>
           	</div>
       	</div>
   	</div>
</div>

@endsection