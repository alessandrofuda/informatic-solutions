{{--rating--}}
<div id="punteggio" itemscope itemtype="https://schema.org/AggregateRating" itemprop="aggregateRating">
  	<meta itemprop="bestRating" content="5"/>
  	<meta itemprop="ratingValue" content="{{ $voto_medio }}"/>
  	<meta itemprop="ratingCount" content="{{ $numero_voti }}"/> 
  	<fieldset id="stelle" class="rating">
	    <input class="stars" type="radio" id="star5" name="rating" value="5" checked="checked" />
	    <label class = "full" for="star5" title="Valutazione: ottimo"></label>
	    <input class="stars" type="radio" id="star4" name="rating" value="4" />
	    <label class = "full" for="star4" title="Valutazione: buono"></label>
	    <input class="stars" type="radio" id="star3" name="rating" value="3" />
	    <label class = "full" for="star3" title="Valutazione: discreto"></label>
	    <input class="stars" type="radio" id="star2" name="rating" value="2" />
	    <label class = "full" for="star2" title="Valutazione: sufficiente"></label>
	    <input class="stars" type="radio" id="star1" name="rating" value="1" />
	    <label class = "full" for="star1" title="Valutazione: scarso"></label>
  	</fieldset>
  <div class="voto">Voto:{{ $voto_medio }}/5 (<span class="votes_numb">{{ $numero_voti }}</span> voti)</div>   
</div>