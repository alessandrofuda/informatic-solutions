<form id="new-article" class="new-article" method="POST">
	{{csrf_field()}}
	<div class="form-group form-inline">
		<label>Id: </label><span class="article-id"> {{ $article->id }}</span>
		<input type="hidden" name="id" value="{{ $article->id }}">
	</div>
	<div id="save-article-slug" class="form-group form-inline">
		<label for="slug">Url:</label> 
		<span class="slug">{{url('/')}}/
			<input type="text" class="form-control url" name="slug" placeholder="Url" value="{{old('slug') ?? $article->slug }}">
			<span class="slug-string">{{ $article->slug }}</span>
		</span> 
		<button class="btn btn-primary btn-xs ok-slug" style="display: none;">Ok</button>
		<button class="btn btn-primary btn-xs change-slug">Modifica</button>
		<div class="url-ajax-resp"></div>
	</div>
	<div class="form-group">
		<label for="title">Titolo</label>
		<input type="text" class="form-control" name="title" placeholder="Titolo" value="{{old('title') ?? $article->title }}">
	</div>
	<div class="form-group">
		<label for="description">Meta Description</label>
		<input type="text" class="form-control" name="description" placeholder="Meta Description" value="{{old('description') ?? $article->description}}">
	</div>
	<div class="form-group">
		<label for="body">Testo</label> {{-- aggiunto script in <head> https://www.tiny.cloud/docs/quick-start/ --}}
		<textarea id="article-body" class="article-body" name="body" placeholder="Testo">{{old('body') ?? $article->body}}</textarea>
		<p class="help-block"></p>
	</div>

	<div class="form-group text-right">
		<span class="switch-label">Pubblicato ?</span>
		<label class="switch">
		  <input type="checkbox" name="published" value="1" {{ $article->active ? 'checked' : '' }}>
		  <span class="slider round"></span>
		</label>
	</div>
	<div class="form-group text-right">
		<div class="validation-error"></div>
		<div class="article-saved"></div>
		<button id="save-article" type="submit" class="btn btn-primary btn-lg">Salva</button>
	</div>
</form>
<script>
	jQuery(document).ready(function(){
		// slug
		$("input[name='slug']").hide();
		$('#save-article-slug button.ok-slug').on('click', function(e){
			e.preventDefault();
			var slug = $("input[name='slug']").val();
			var articleId = $("input[name='id']").val();
			$.ajaxSetup({
			    headers: {
			        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			    }
			});
			$.ajax({
			    method: "POST",
			    url: '{{route('cms-backend.save-article-slug')}}',
			    data: { 
			    		slug:slug,
			    		id:articleId
			    	  },
			    success: function(result){	
		    		$('input.form-control.url').css('display','none');
			    	$('.slug-string').css('display','inline-block');
			    	$('.slug-string').html(result.slug);
			    	$('button.ok-slug').css('display','none');
			    	$('button.change-slug').css('display', 'inline-block');
			    	
			    	$('.url-ajax-resp').html(result.response).show().delay(4000).hide('slow');
			    },
			    error: function(e) {
			    	var err_msg = e.responseJSON.errors.slug[0];
			    	$('.url-ajax-resp').addClass('err').html(err_msg).show().delay(4000).hide('slow');
			    }
			});
		});
		$('button.change-slug').on('click', function(e){
			e.preventDefault();
			$(this).css('display','none');
			$('input.form-control.url').css('display','inline-block');
			$('.slug-string').css('display','none');
			$('button.ok-slug').css('display','inline-block');
		});

		//article
		$('#new-article').submit(function(e){
			e.preventDefault();
			var form = $(this);
			$.ajaxSetup({
			    headers: {
			        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			    }
			});
			$.ajax({
			    method: "POST",
			    url: '{{route('cms-backend.save-article')}}',
			    data: form.serialize(),
			    success: function(result){
			    	console.log(result);
			    	$('.article-saved').html(result.response).show().delay(5000).hide('slow');
			    },
			    error: function(err){
			    	var errors = err.responseJSON.errors;
			    	var validationMessage = '';
			    	$.each(errors, function(key, value){
			    		validationMessage += '<li>'+value+'</li>';
			    	});
			    	$('.validation-error').html('<div class="alert alert-danger"><ul>'+validationMessage+'</ul></div>').show().delay(5000).hide('slow');
			    }
			});
		});

		// published swith
		$("input[name='published']").on('change', function(e) {
			e.preventDefault();
			// var currentArticleId = '{{-- $newArticleId --}}';
			// var published = $(this).prop('checked');
			$.ajaxSetup({
			    headers: {
			        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			    }
			});
			$.ajax({
			    method: "POST",
			    url: '{{route('cms-backend.save-article', ['with_status_definition' => true])}}',
			    data: $('#new-article').serialize(),
			    success: function(result){
			    	console.log(result);
			    	$('.article-saved').html(result.response).show().delay(5000).hide('slow');
			    },
			    error: function(err){
			    	var errors = err.responseJSON.errors;
			    	var validationMessage = '';
			    	$.each(errors, function(key, value){
			    		validationMessage += '<li>'+value+'</li>';
			    	});
			    	$('.validation-error').html('<div class="alert alert-danger"><ul>'+validationMessage+'</ul></div>').show().delay(5000).hide('slow');
			    }
			});
		});
	});
</script>