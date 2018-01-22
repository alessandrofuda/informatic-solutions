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
                <form id="plaintext-filter" class="form-group" method="POST" action="">
                	{{ csrf_field() }}
                    <div class="input-group input-group-md">
                        <div class="icon-addon addon-md">
                        	<!--label class="sr-only" for="searchbox">Search</label-->
                            <input id="searchbox" type="text" placeholder="Cosa stai cercando?" class="form-control">
                            <span class="glyphicon glyphicon-search search-icon"></span>
                        </div>
                        <!--span class="input-group-btn">
                            <button class="btn btn-default" type="button">Search!</button>
                        </span-->
                    </div>
                </form>
            </div>

            {{-- aggiungere l'autocomplete (cfr laracast site) --}}

            <!--div id="search-alert" class="alert alert-danger" role="alert">
			    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
			    @{{ error }} {{-- @ --> per non confonderlo con le parentesi di blade --}}
			    <button class="close">x</button>
			</div-->
	    </div>

	    <div id="filters" class="text-center">
	    	<form id="filter-brand-price" class="checkbox" method="POST" action="">
	    		{{ csrf_field() }}
	    		<h4>Filtra marca</h4> 


	    		{{-- !empty($request) ? dump($request->brand) : 'no' --}}



	    		@foreach ($brands as $brand)
	    			<label class="checkbox-inline">
	    				<input type="checkbox" name="brand[]" value="{{ $brand->brand }}" {{ (!empty($request->brand) && is_array($request->brand) && in_array($brand->brand, $request->brand)) ? ' checked' : '' }}>
	    				<a href="#">{{ ucfirst(strtolower($brand->brand)) }}</a>
	    			</label>
	    		@endforeach
	    		 
	    		{{-- dd($contents) --}}
	    	<!--/form-->
	    	<hr>
	    	<!--form id="filter-price" class="checkbox"-->
	    		<h4>Prezzo</h4>
	    		<label class="checkbox-inline"><input type="checkbox" name="price[]" value="range-1" {{ (!empty($request->price) && is_array($request->price) && in_array('range-1', $request->price)) ? ' checked' : '' }}>Fino a 100 €</label> 
	    		<label class="checkbox-inline"><input type="checkbox" name="price[]" value="range-2" {{ (!empty($request->price) && is_array($request->price) && in_array('range-2', $request->price)) ? ' checked' : '' }}>da 101 a 200 €</label>
	    		<label class="checkbox-inline"><input type="checkbox" name="price[]" value="range-3" {{ (!empty($request->price) && is_array($request->price) && in_array('range-3', $request->price)) ? ' checked' : '' }}>da 201 a 300 €</label>
	    		<label class="checkbox-inline"><input type="checkbox" name="price[]" value="range-4" {{ (!empty($request->price) && is_array($request->price) && in_array('range-4', $request->price)) ? ' checked' : '' }}>oltre 300 €</label>
	    	</form>
	    	<hr>
	    	<!--div id="filter-popularity"></div-->


{{-- 
https://packagist.org/packages/camilo-manrique/laravel-filter 
https://m.dotdev.co/writing-advanced-eloquent-search-query-filters-de8b6c2598db
--}}


	    </div>

	    <script>
 		 	$(function(){
 		 		$('#filter-brand-price input:checkbox').on('change',function(){
 		 			//var test = [];
 		 			var test = $('#filter-brand-price input:checkbox:checked').serialize(); //.val();
 		 			console.log(test);
            		$('#filter-brand-price').submit();
            	});

            	$('#plaintext-filter').on('keypress', function(e){
            		if(e.which == 13) {
            			console.log('ok keypress on enter');
            			//submit..
            		}
            	});
            	
 		 	});
 		 	
 		 	//console.log(test);
 		</script>


	    	
		    <div id="products">
		        @if(count($contents) <= 0)
		            <p>Non sono presenti prodotti.</p>
		        @else 
		        	<div class="">Prodotti trovati: <span id="total_products">{{ count($contents) }}</span></div>	
	            	<?php $i=0; ?>
	            	
	                @foreach($contents as $content) 
		                @if($i < 18)
			                <div id="$content->asin" class="col-md-4">
			                    @include('comparator.product.product-panel',['content' => $content, 'reviews' => $reviews])
			                </div>

		                	<?php  $i++; ?>
		                
		                    @if($i %3 == 0 && $i > 0)
		                    	<div class="clearfix"></div>
		                    @endif
		                @endif
	                @endforeach

		            <div class="clearfix"></div>
		            
		        @endif

		    </div>
		    <div class="text-center">{{ method_exists($contents, 'links') ? $contents->links() : '' }}</div>
	    </div>
	</div>   
</div>



@endsection
