<form id="new-article" class="new-article" method="POST" action="">
	<div class="form-group form-inline">
		<label for="article-slug">Url:</label> {{url('/')}}/<input type="text" class="form-control" name="article-slug" placeholder="Url">
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
		<label for="article-body">Testo</label> {{-- https://www.tiny.cloud/docs/quick-start/ --}}
		<textarea id="article-body" class="article-body" name="article-body" placeholder="Testo"></textarea>
		<p class="help-block">Example block-level help text here.</p>
	</div>



	<div class="checkbox">
		<label>
			<input type="checkbox"> Check me out
		</label>
	</div>



	<button type="submit" class="btn btn-default">Salva</button>
</form>