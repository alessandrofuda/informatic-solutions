<form id="new-article" class="new-article" method="POST">
	{{csrf_field()}}
	<div class="form-group form-inline">
		<label>Id: </label><span class="article-id"> {{ $newArticleId }}</span>
		<input type="hidden" name="id" value="{{ $newArticleId }}">
	</div>
	<div id="save-article-slug" class="form-group form-inline">
		<label for="slug">Url:</label> 
		<span class="slug">{{url('/')}}/
			<input type="text" class="form-control url" name="slug" placeholder="Url">
			<span class="slug-string"></span>
		</span> 
		<button class="btn btn-primary btn-xs ok-slug">Ok</button>
		<button class="btn btn-primary btn-xs change-slug" style="display: none;">Modifica</button>
		<div class="url-ajax-resp"></div>
	</div>
	<div class="form-group">
		<label for="title">Titolo</label>
		<input type="text" class="form-control" name="title" placeholder="Titolo">
	</div>
	<div class="form-group">
		<label for="description">Meta Description</label>
		<input type="text" class="form-control" name="description" placeholder="Meta Description">
	</div>
	<div class="form-group">
		<label for="body">Testo</label> {{-- aggiunto script in <head> https://www.tiny.cloud/docs/quick-start/ --}}
		<textarea id="article-body" class="article-body" name="body" placeholder="Testo"></textarea>
		<p class="help-block"></p>
	</div>

	<div class="form-group text-right">
		<span class="switch-label">Pubblicato ?</span>
		<label class="switch">
		  <input type="checkbox" name="published" value="1">
		  <span class="slider round"></span>
		</label>
	</div>
	<div class="form-group text-right">
		<div class="validation-error"></div>
		<button id="save-article" type="submit" class="btn btn-primary btn-lg">Salva</button>
		<div class="article-saved"></div>
	</div>
	<div class="form-group text-right" style="margin-top:100px;">
		<a id="make-new-article" class="btn btn-sm btn-default btn-lg" href="{{ route('cms-backend.make-new-article') }}">Crea un nuovo articolo</a>  (refressha pulendo cache/cookie/sessione - TODO)
	</div>
</form>
<script>
	jQuery(document).ready(function(){
		// slug
		$('#save-article-slug button.ok-slug').on('click', function(e){
			e.preventDefault();
			var slug = $("input[name='slug']").val();
			var articleId = $("input[name='id']").val();
			$.ajax({
			    method: "POST",
			    url: '{{route('cms-backend.save-article-slug')}}',
			    data: { 
		    		slug:slug,
		    		id:articleId
			    },
			    headers: {
			    	'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			    },
			    success: function(result) {	
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

		//save article button
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

		// published switch
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

		//new article button (with session clean)
		// $('#make-new-article').on('click', function(e) {
		// 	e.preventDefault();
		// 	$.ajax({
		// 	    method: "POST",
		// 	    url: '{{-- route('cms-backend.make-new-article') --}}',
		// 	    data: { 
		//     		slug:slug,
		//     		id:articleId
		// 	    },
		// 	    headers: {
		// 	    	'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		// 	    },
		// 	    success: function(result) {	
		    		
		// 	    }
		// 	    // error: function(e) {
			    	
		// 	    // }
		// 	});
		// });
	});
</script>