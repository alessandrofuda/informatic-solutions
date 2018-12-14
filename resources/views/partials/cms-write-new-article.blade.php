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
		<label for="article-body">Testo</label> {{-- aggiunto script in <head> https://www.tiny.cloud/docs/quick-start/ --}}
		<textarea id="article-body" class="article-body" name="article-body" placeholder="Testo"></textarea>
		<p class="help-block">Example block-level help text here.</p>
	</div>

	<div class="form-group text-right">
		<span class="switch-label">Pubblicato ?</span>
		<label class="switch">
		  <input type="checkbox" checked>
		  <span class="slider round"></span>
		</label>
	</div>


	<div class="form-group text-right">
		<button type="submit" class="btn btn-primary btn-lg">Salva</button>
	</div>
</form>