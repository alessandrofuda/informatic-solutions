<form id="new-article" class="new-article" method="POST" action="">
	{{csrf_field()}}
	<div class="form-group form-inline">
		<label>Id: </label><span class="article-id"> {{ $newArticleId }}</span>
		<input type="hidden" name="article-id" value="{{ $newArticleId }}">
	</div>
	<div id="new-article-slug" class="form-group form-inline">
		<label for="article-slug">Url:</label> 
		<span class="slug">{{url('/')}}/
			<input type="text" class="form-control url" name="article-slug" placeholder="Url">
			<span class="slug-string"></span>
		</span> 
		<button class="btn btn-primary btn-xs ok-slug">Ok</button>
		<button class="btn btn-primary btn-xs change-slug" style="display: none;">Modifica</button>
		<div class="url-ajax-resp"></div>
	</div>
	<div class="form-group">
		<label for="article-title">Titolo</label>
		<input type="text" class="form-control" name="article-title" placeholder="Titolo">
	</div>
	<div class="form-group">
		<label for="meta-description">Meta Description</label>
		<input type="text" class="form-control" name="meta-description" placeholder="Meta Description">
	</div>
	<div class="form-group">
		<label for="article-body">Testo</label> {{-- aggiunto script in <head> https://www.tiny.cloud/docs/quick-start/ --}}
		<textarea id="article-body" class="article-body" name="article-body" placeholder="Testo"></textarea>
		<p class="help-block">Example block-level help text here.</p>
	</div>

	<div class="form-group text-right">
		<span class="switch-label">Pubblicato ?</span>
		<label class="switch">
		  <input type="checkbox" name="published" value="">
		  <span class="slider round"></span>
		</label>
	</div>


	<div class="form-group text-right">
		<button id="save-article" type="submit" class="btn btn-primary btn-lg">Salva</button>
		<div class="article-saved"></div>
	</div>
</form>
<script>
	jQuery(document).ready(function(){
		// slug
		$('#new-article-slug button.ok-slug').on('click', function(e){
			e.preventDefault();
			var slug = $("input[name='article-slug']").val();
			var articleId = $("input[name='article-id']").val();
			$.ajaxSetup({
			    headers: {
			        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			    }
			});
			$.ajax({
			    method: "POST",
			    url: '{{route('cms-backend.new-article-slug-post')}}',
			    data: { 
			    		slug:slug,
			    		id:articleId
			    	  },
			    success: function(result){
			    	// console.log(result.response);
			    	// console.log(result.slug);
			    	$('input.form-control.url').css('display','none');
			    	$('.slug-string').css('display','inline-block');
			    	$('.slug-string').html(result.slug);
			    	$('button.ok-slug').css('display','none');
			    	$('button.change-slug').css('display', 'inline-block');
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
		$('#new-article').submit( function(e){
			e.preventDefault();
			var form = $(this);
			$.ajaxSetup({
			    headers: {
			        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			    }
			});
			$.ajax({
			    method: "POST",
			    url: '{{route('cms-backend.new-article-post')}}',
			    data: form.serialize(),
			    success: function(result){
			    	console.log(result);
			    	$('.article-saved').html(result.response).show().delay(4000).hide('slow');
			    }
			});
		});
	});
</script>