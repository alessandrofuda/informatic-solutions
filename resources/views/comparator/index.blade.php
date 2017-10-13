@extends('layouts.app')

@section('content')
<div class="container">

	<div class="row">
		<div class="col-md-12">
			<div class="row text-center title">
				<h1>Confronta <b>{{ ucfirst($slug) }}</b> e monitora i prezzi</h1>
			</div>



			<div id="search" class="row text-center search">
				<div class="well well-sm">
					<div class="form-group">
						<div class="input-group input-group-md">
							<div class="icon-addon addon-md">
								<label class="sr-only" for="searchbox">Search</label>
								<input id="searchbox" type="text" placeholder="Cosa stai cercando?" class="form-control">
								<span class="glyphicon glyphicon-search search-icon"></span>
							</div>
                <!--span class="input-group-btn">
                    <button class="btn btn-default" type="button">Search!</button>
                </span-->
            </div>
        </div>
    </div>



    <!--div id="search-alert" class="alert alert-danger" role="alert">
	    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
	    @{{ error }} {{-- @ --> per non confonderlo con le parentesi di blade --}}
	    <button class="close">x</button>
	</div-->
</div>






{{-- trovato filtri in vue.js: https://vuejsexamples.com/vue-directive-supporting-isotope-layout-filtering-and-sorting/ --}}






<div id="products">
	{{-- @if(count($contents) <= 0) --}}
	<!--p>Non sono presenti prodotti.</p-->
	{{-- @else --}} 
	<div class="">Prodotti trovati: <span id="total_products">0 - DA FARE -</span></div>	
        	<?php // $i=0; 
        	?>
        	
        	{{-- @foreach($contents as $content) --}} 
        	{{-- @if($i < 18) --}}
        	<div v-for="product in products" :id="product.asin" class="col-md-4">
        		{{-- ELIMINATO INCLUDE PERCHE NON UTILIZZABILE CON VUEJS @include('comparator.product.product-panel',['content' => product, 'reviews' => $reviews]) --}}

        		<div class="panel panel-primary">
        			{{-- new product notification --> last week --}}
        			{{-- @if ( $content->created_at >= \Carbon\Carbon::now()->subDays(7) ) --}}  
<!--div class="new-cont"></div>
	<div class="new">NUOVO</div-->
		{{-- @endif --}}
		<div class="panel-body">
			<div class="img-cont">
				<!--a href="{{-- route('product.view', $product->slug)--}}" title="{{-- $content->title --}}"-->
				{{-- @include('comparator.product.product-image',['content' => $content]) --}}
				<!--/a-->
			</div>
			<div class="caption">        
				<h3 class="product-title">@{{ product.title }}</h3>

				<div class="product-info">
					<b>Marca:</b> @{{ product.brand }} - <b>Colore:</b> {{-- !empty($content->color) ? $content->color : 'tutti' --}}
					<div class="product-summary">
						<span v-if="product.feature" class="abstract">
							{{-- @if (!empty($content->feature)) --}}
							{{-- str_limit($content->feature, $limit = 250, $end = '...') --}}
								@{{ product.feature | truncate(250)}} 
							{{-- @else --}}
								
							{{-- @endif --}}

						</span>
						<span v-else class="abstract">
							Non è ancora presente una descrizione per questo prodotto.
						</span>
						<div class="row modal-buttons">
							<div class="col-md-6">
								<!-- Trigger the modal with a button -->
								<button type="button" class="btn btn-info btn-xs" data-toggle="modal" :data-target="'#myModal-'+product.asin">Descrizione prodotto</button>
							</div>
							<div class="col-md-6">
								<button type="button" class="btn btn-info btn-xs" data-toggle="modal" :data-target="'#dettagli-'+product.asin">Vai ai dettagli</button>
							</div>
						</div>

						<!-- Modal 1 descrizione-->
						<div :id="'myModal-'+product.asin" class="modal fade" role="dialog">
							<div class="modal-dialog">

								<!-- Modal 1 content-->
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal">&times;</button>
										<h4 class="modal-title">@{{ product.title }}</h4>
									</div>
									<div class="modal-body">
										<div class="img-cont-modal">
											<!--a href="{{-- route('product.view', $product->slug)--}}" title="{{-- $content->title --}}"-->
											{{-- @include('comparator.product.product-image',['content' => $content]) --}}
											<!--/a-->
										</div>
										<p>@{!! str_replace('. ', '.</p><p>', product.feature) !!}</p>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-default" data-dismiss="modal">Chiudi</button>
									</div>
								</div>

							</div>
						</div><!--#myModal-->
						<!--Modal 2 dettagli-->
						<div :id="'dettagli-'+product.asin" class="modal fade" role="dialog">
							<div class="modal-dialog">

								<!-- Modal 2 content-->
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal">&times;</button>
										<h4 class="modal-title">Descrizione dettagliata di:<br>@{{ product.title }}</h4>
									</div>
									<div class="modal-body">

										<p> {{-- 	!!! IMPORTANTE !!! rendere sempre le CHIAMATE CONDIZIONALI--}}
											{!! isset($content->editorialreviewcontent) ? $content->editorialreviewcontent : 'Ancora nessun dettaglio inserito dal venditore.' !!} {{--!! str_replace('. ', '.</p><p>', $string) !!--}}
										</p>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-default" data-dismiss="modal">Chiudi e torna</button>
									</div>
								</div>

							</div>
						</div><!--#dettagli-->
					</div><!--.product-summary-->
				</div><!--product-info-->
				<div class="row product-price">
					<?php 

					if (!empty($content->price)) {  
						$prezzo_listino = $content->price; 
					} else {
						$prezzo_listino = null;
					}


					if (!empty($content->lowestnewprice)) {
						$prezzo_applicato = $content->lowestnewprice; 
					} else {
						$prezzo_applicato = null;
					}

					?>

					@if ($prezzo_listino !== null && ($prezzo_listino > $prezzo_applicato) ) 
					<span class="price-cont">
						<span class="original-price-cont">
							<span class="orig-price">
								€ {{ number_format($prezzo_listino, '2', ',', '.') }}
							</span>
						</span>
						<i class="glyphicon glyphicon-share-alt"></i>
					</span>
					<span class="price-disc" title="Prezzo aggiornato al: {{-- App\Product::italian_date($content->updated_at) --}}">
						€ {{ number_format($prezzo_applicato, '2', ',', '.') }}
					</span>

					@elseif ($prezzo_listino <= $prezzo_applicato)

					{{-- @if ($prezzo_applicato !== null || !empty($prezzo_applicato)) --}}
					<span class="price" title="Prezzo aggiornato al: {{-- App\Product::italian_date($content->updated_at) --}}">€ {{ number_format($prezzo_applicato, '2', ',', '.') }}</span>
					@else 
					<span class="not-available-price">Prezzo non disponibile</span>
					{{-- @endif --}}

					@endif
				</div><!--.product-price-->
				<div class="row product-buttons">
					<div class="col-md-12"> 
						@if(Auth::check() && Auth::user()->isInWatchinglist($content->id))
						<a class="col-md-12 btn btn-danger" style="white-space: normal !important;" href="'../backend/smetti-di-osservare-'+ product.asin + '-' + product.id">
							<i class="col-md-2 glyphicon glyphicon-remove-sign"></i>
							<span style="line-height: 45px;" class="col-md-10 txt">Smetti di osservare</span>	                    	
						</a>
						@else
						<a class="col-md-12 btn btn-success" style="white-space: normal !important;" :href="'../backend/metti-in-osservazione-' + product.asin + '-' + product.id">
							<i class="col-md-2 glyphicon glyphicon-eye-open"></i>
							<span class="col-md-10 txt">Avvisami quando<br>il prezzo scende</span>
						</a>
						@endif

						<a class="col-md-12 btn btn-primary" target="_blank" :href="'http://www.amazon.it/gp/aws/cart/add.html?AWSAccessKeyId={{ env('AWS_ACCESS_KEY_ID') }}&AssociateTag=infsol-21&ASIN.1=' + product.asin + '&Quantity.1=1'">
							<i class="col-md-2 glyphicon glyphicon-shopping-cart"></i>
							<span class="col-md-10 txt">Aggiungi al Carrello e<br>acquista subito</span>
						</a>
					</div>
				</div><!--.product-buttons-->
				<div class="row review-button">
					<div class="col-md-12"> 
						<div :id="'rating-' + product.asin"></div>
 
						<?php
        		//$asin = $content->asin;
        		//$rev_asin = $reviews->$asin;
        		//dd($rev_asin);
        		//if (isset($rev_asin) && !empty($rev_asin[0]) ) {
        		//	$voto_string = str_ireplace(' stelle', '', $rev_asin[1][0]);
        		//	$voto_array = explode('su', $voto_string);
        		//	$voto_numb = (float) str_ireplace(',', '.', trim($voto_array[0]));
        		//} else {
        			$voto_numb = rand(3,5);  //spara un voto a caso !!
        		//	echo '<style>#rating-'.$asin.'.j-rating{display:none;}</style>';
        		//}


        			?>
        			{{-- dump($voto_string) --}}
        			<!--script type="text/javascript">
        				$(document).ready(function(e) {
        					$("#rating- + product.asin").jRatingAdvance({
		              stars: 5,  // number of stars          
		              size: "14px",  // size of stars
		              buttons_color: "#CCC",  // default color
		              active_color: "#2ab27b",  // active color
		              text: true,  // shows text next to the rating control
		              rating: {{ $voto_numb }}
		          });
        				});
        			</script-->

        			@if ( !empty($rev_asin[0]) )
        			<button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#reviews-@{{ product.asin }}">Leggi tutte le Recensioni</button>
        			@else
        			<button type="button" class="btn btn-info btn-xs disabled" data-toggle="modal" data-target="{{--#reviews- $content->asin --}}">Ancora nessuna recensione</button>
        			@endif

        		</div>
        	</div><!--.review-button-->

        	<!--Modal 3 recensioni-->
        	<div :id="'reviews-'+product.asin" class="modal fade" role="dialog">
        		<div class="modal-dialog">

        			<!-- Modal 3 content-->
        			<div class="modal-content">
        				<div class="modal-header">
        					<button type="button" class="close" data-dismiss="modal">&times;</button>
        					<h4 class="modal-title">Recensioni su: <b>@{{ product.title }}</b></h4>
        				</div>
        				<div class="modal-body">

        					<p> {{-- 	!!! IMPORTANTE !!! rendere sempre le CHIAMATE CONDIZIONALI--}}

        						<?php 	
        						$n = 1; 

				        			if (!empty($rev_asin)) {  // !!! IMPORTANT !!
				        				
				        				$revisioni = $rev_asin[0]; //$reviews->$asin[0];
				        			} 

				        			?>

				        			@if (!empty($revisioni))
				        			@foreach($revisioni as $review)

					        			<?php // togliere questo blocco e modificare le variabili subito all'insert nel db
					        			$review[0] = str_ireplace(' stelle', '', $review[0]);
					        			$review[1] = str_ireplace('amazon', '', $review[1]);
					        			$review[2] = str_ireplace('cliente amazon', 'Utente anonimo', $review[2]);
					        			$review[3] = str_ireplace('il ', '', $review[3]);
					        			$review[4] = str_ireplace('amazon', '', $review[4]);

					        			$votorev = explode('su', str_ireplace(',', '.', $review[0]));
					        			$votoreview = (float) trim($votorev[0]);

					        			?>
					        			
					        			<p>
					        				<p>
					        					Voto: 
					        					<span :id="'rating-' + product.asin + '-{{ $n }}'" style="position: relative!important;"></span>
					        					<span class="suffix">su 5.</span>
					        					<!--script type="text/javascript">
					        						$(document).ready(function(e) {
					        							$("#rating- + product.asin + '-{{ $n }}'").jRatingAdvance({
										              stars: 5,  // number of stars          
										              size: "14px",  // size of stars
										              buttons_color: "#CCC",  // default color
										              active_color: "#2ab27b",  // active color
										              text: true,  // shows text next to the rating control
										              rating: {{ $votoreview }}  
										          });
					        						});
					        					</script-->
					        					<!--b>{{-- $review[0] --}}</b-->
					        					<br><br>
					        					<b>{{ $review[1] }}</b><br>
					        					Recensito e valutato da <b>{{ $review[2] }}</b>, il <b>{{ $review[3] }}</b>:<br>
					        					<p class="review">{{ $review[4] }}</p>
					        					<br><hr><br>
					        				</p>
					        				<?php $n++ ?>
					        				@endforeach

					        				{{--@endforeach--}}

					        				@else

					        				<p>Ancora nessuna recensione per questo prodotto.</p>

					        				@endif




					        			</p>
					        		</div>
					        		<div class="modal-footer">
					        			<button type="button" class="btn btn-default" data-dismiss="modal">Chiudi e torna</button>
					        		</div>
					        	</div>

					        </div>
					    </div><!--#dettagli-->


					</div>
				</div>
			</div>


		</div>

                	<?php  //$i++; 
                	?>

                	{{-- @if($i %3 == 0 && $i > 0) --}}
                	<div class="clearfix"></div>
                	{{-- @endif --}}
                	{{-- @endif --}}
                	{{-- @endforeach --}}

                	<div class="clearfix"></div>

                	{{-- @endif --}}

                </div>
            </div>
        </div>   
    </div>




    <script>
    	new Vue({
    		el: '#app',
    		data: {
    			message: 'Hello!',
    			products: {!! $prod_json !!},
    		}
    	});
    </script>



    @endsection
