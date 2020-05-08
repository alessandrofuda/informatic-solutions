@extends('layouts.comparator')

@section('content')

<div id="comment-filter" class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading text-center">
                    Filtro Commenti 
                </div>
                
                <div class="panel-body">
                	<h2 class="col-md-12">Impostazioni Filtro</h2>
                	<form class="filtered-keyword_form" action="{{route('admin.comments.store-filter-keywords')}}" method="POST">
                		
                		@csrf
					  	
					  	<div class="form-group has-success has-feedback">
					  		<label class="control-label col-sm-12" for="key-list">Il filtro elimina i commenti che contengono queste parole chiave.</label>
					    	<label class="control-label col-sm-12" for="key-list">Inserire keywords da filtrare, <u>separate da virgola</u>.</label>
						    <div class="col-sm-12">
						    	<textarea type="text" class="form-control" id="key-list" name="keywords-list" placeholder="Inserisci qui le parole chiave, separate da virgola">{{ $filtered_keywords_list }}</textarea>
							</div>
					  	</div>
					  	<div class="form-group col-md-12">
					  		<button type="submit" class="btn btn-primary">Aggiorna lista</button>
					  	</div>
					</form>
                    <div class="form-group col-md-6">
                        <a class="btn btn-link btn-info" href="{{route('admin.home')}}" style="position:relative; bottom:-15px; padding-left:0;">
                            <span class="glyphicon glyphicon-arrow-left"></span> Torna alla dashboard
                        </a>
                    </div>
            		<div class="form-group col-md-6 text-right">
            			<a class="btn btn-danger" href="{{route('admin.comments.run-spam-filter')}}">
            				<span class="glyphicon glyphicon-exclamation-sign"></span> Avvia Filtro Manualmente
            			</a>
            		</div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection