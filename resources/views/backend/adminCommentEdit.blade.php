@extends('layouts.comparator')

@section('content')

<div id="comment-edit" class="container">
    <div class="row">
        <div class="col-md-12 col-md-offset-0">
            <div class="panel panel-default">
                <div class="panel-heading text-center">
                    Modifica commento {{ $comment->id }}
                </div>
                
                <div class="panel-body">

                    <form method="post" action="">
                        
                        {{ csrf_field() }}

                    	<table class="table table-striped">
                    	   
                           <tr>
                               <td class="first-col text-right"><label for="id">Id:</label></td>
                               <td>{{ $comment->id }}</td>
                           </tr>

                           <tr>
                               <td class="first-col text-right"><label for="titolo">Titolo post:</label></td>
                               <td>{{ $comment->post->title }}</td>
                           </tr>

                           <tr>
                               <td class="first-col text-right"><label for="nome">Nome:</label></td>
                               <td><input type="text" name="nome" value="{{ $comment->from_user_name }}"/></td>
                           </tr>

                           <tr>
                               <td class="first-col text-right"><label for="commento">Commento:</label></td>
                               <td><textarea class="form-control" name="commento" rows="8">{{ $comment->body }}</textarea></td>
                           </tr>

                           <tr>
                               <td class="first-col text-right"><label for="scritto-il">Scritto il:</label></td>
                               <td><input type="text" name="scritto-il" value="{{ $comment->created_at }}" /></td>
                           </tr>

                           <tr>
                               <td class="first-col text-right">E-mail:</td>
                               <td>{{ $comment->from_user_email }}</td>
                           </tr>

                           <tr>
                               <td class="first-col text-right">IP:</td>
                               <td>{{ $comment->from_user_ip }}</td>
                           </tr>

                           <tr>
                               <td class="first-col text-right">URL Autore:</td>
                               <td>{{ $comment->from_user_url }}</td>
                           </tr>

                           <tr>
                               <td class="first-col text-right"><label for="pubblicato">Pubblicato:</label></td>
                               <td><input type="checkbox" name="pubblicato" value="1" {{ $comment->comment_approved == 1 ? 'checked' : '' }}></td>
                           </tr>

                           <tr>
                               <td class="first-col text-right">UA:</td>
                               <td>{{ $comment->comment_agent }}</td>
                           </tr>

                           <tr>
                               <td class="first-col text-right"><label for="parent">Commento genitore:</label></td>
                               <td>(da fare){{ $comment->comment_parent }}</td>
                           </tr>
                        </table>   
                            <div class="text-right text-right">
                                <button class="btn btn-primary btn-sm" type="submit">Salva le modifiche</button>
                                <a class="btn btn-danger btn-sm" href="{{ URL::previous() }}">Torna indietro</a> 
                            </div>   
                               

                    	
                    </form>
                </div>
           	</div>
       	</div>
   	</div>
</div>

@endsection