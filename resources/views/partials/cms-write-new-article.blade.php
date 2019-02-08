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
		<span class="status-notification" style="display: inline-block;">status notification pubblicato/non pubblicato (a scomparsa..)</span>
		<span class="switch-label">Pubblicato ?</span>
		<label class="switch">
		  <input type="checkbox" name="published" value="0">
		  <span class="slider round"></span>
		</label>
	</div>


	<div class="form-group text-right">
		<div class="validation-error"></div>
		<button id="save-article" type="submit" class="btn btn-primary btn-lg">Salva</button>
		<div class="article-saved"></div>
	</div>
</form>
<script>
	jQuery(document).ready(function(){
		// slug
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
			    	// console.log(result.response);
			    	// console.log(result.slug);
			    	if(result.status != 204) {
			    		$('input.form-control.url').css('display','none');
				    	$('.slug-string').css('display','inline-block');
				    	$('.slug-string').html(result.slug);
				    	$('button.ok-slug').css('display','none');
				    	$('button.change-slug').css('display', 'inline-block');
			    	}
			    	
			    	$('.url-ajax-resp').html(result.response).show().delay(4000).hide('slow');
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
			    error: function(data){
			    	var errors = $.parseJSON(data.responseText);
			    	var validationMessage = '';
			    	console.log(errors);
			    	$.each(errors, function(key, value){
			    		validationMessage += '<li>'+value+'</li>';
			    	});
			    	$('.validation-error').html('<div class="alert alert-danger"><ul>'+validationMessage+'</ul></div>').show().delay(5000).hide('slow');
			    }
			});
		});

		// published swith
		$("input[name='published']").on('change', function(e) {
			
			alert( $(this).prop('checked') );
			
			if($(this).prop('checked')){
				$(this).val(1);
			} else {
				$(this).val(0);
			}

			alert('val= '+ $(this).val());
		});
	});
</script>