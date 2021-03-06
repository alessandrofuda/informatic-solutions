@extends('layouts.comparator')

@section('content')
<div class="container-fluid">

	<div class="row">
	    <div class="col-md-12">
		    <div class="row text-center title">
		    	<div class="col-md-12">
		    		<h1 class="title-text">
		    			Confronta <b>{{ ucfirst($slug) }}</b> e monitora i prezzi
		    			<span style="display:block; font-size:14px;">{{$current_page ? 'Pagina: '.$current_page : ''}}</span>
		    		</h1>
			    	@if(!empty($post_title))
			    		<h2 class="sub-title-link">
			    			<a href="{{ url($slug) }}">{{ $post_title }}</a>
			    		</h2>
			    	@endif
		    	</div>
		    </div>
		</div>
		<div class="col-md-12">
		    <div id="search" class="row text-center search">
		    	<div class="well well-sm">
	                <form id="plaintext-filter" class="form-group" method="POST" action="">
	                	{{ csrf_field() }}
	                    <div class="input-group input-group-md">
	                        <div class="icon-addon addon-md">
	                        	<!--label class="sr-only" for="searchbox">Search</label-->
	                            <input id="q" class="form-control" type="text" name="q" value="{{ (!empty($request->q)) ? $request->q : ''}}" placeholder="Cosa stai cercando?" >
	                            <span class="glyphicon glyphicon-search search-icon"></span>
	                        </div>
	                        <!--span class="input-group-btn">
	                            <button class="btn btn-default" type="button">Search!</button>
	                        </span-->
	                    </div>
	                </form>
	            </div>
		    </div>
		    <div id="filters" class="text-center">
		    	@if (!empty($brands) )
		    		<div class="btn btn-default" data-toggle="collapse" data-target="#brands">Filtra per marca</div> 
			    	<form id="filter-brand-price" class="checkbox" method="POST" action="">
			    		{{ csrf_field() }}
			    		<div id="brands" class="brands collapse">
				    		@foreach ($brands as $brand)
				    			<label class="checkbox-inline">
				    				<input type="checkbox" name="brand[]" value="{{ $brand['brand'] }}" {{ (!empty($request->brand) && is_array($request->brand) && in_array($brand['brand'], $request->brand)) ? ' checked' : '' }}>
				    				<a href="#">{!! mb_strtoupper(trim($brand['brand'], '- ')) !!}</a>
				    			</label>
				    		@endforeach	
			    		</div>
			    		<div class="prices">
			    			<label class="checkbox-inline">Filtra per prezzo:</label>
			    			<label class="checkbox-inline"><input type="checkbox" name="price[]" value="range-1" {{ (!empty($request->price) && is_array($request->price) && in_array('range-1', $request->price)) ? ' checked' : '' }}>Fino a 100 €</label> 
			    			<label class="checkbox-inline"><input type="checkbox" name="price[]" value="range-2" {{ (!empty($request->price) && is_array($request->price) && in_array('range-2', $request->price)) ? ' checked' : '' }}>da 101 a 200 €</label>
			    			<label class="checkbox-inline"><input type="checkbox" name="price[]" value="range-3" {{ (!empty($request->price) && is_array($request->price) && in_array('range-3', $request->price)) ? ' checked' : '' }}>da 201 a 300 €</label>
			    			<label class="checkbox-inline"><input type="checkbox" name="price[]" value="range-4" {{ (!empty($request->price) && is_array($request->price) && in_array('range-4', $request->price)) ? ' checked' : '' }}>oltre 300 €</label>
			    		</div>
			    	</form>
		    	@endif
		    	<hr>
		    </div>

		    <script>
	 		 	$(document).ready(function() {
	 		 		$('#filter-brand-price input:checkbox').on('change',function(){
	 		 			//var test = [];
	 		 			var test = $('#filter-brand-price input:checkbox:checked').serialize(); //.val();
	 		 			// console.log(test);
	            		$('#filter-brand-price').submit();
	            	});

	            	if ($('#filter-brand-price .brands input:checkbox:checked').length > 0 ) {
	            		$('#brands').addClass('in');  // collapsible visible
	            	}

	            	// autocomplete in search field
	            	$('#q').autocomplete({
		  				source: '{{ url("search/autocomplete") }}',
		  				minLength: 3,
		  				select: function(event, ui) {
		  					if(ui.item){
		  						$('#q').val(ui.item.value);
		  					}
		  					$('#plaintext-filter').submit();
		  				},
					});


	            	$('#plaintext-filter').on('keypress', function(e){
	            		if(e.which == 13) {
	            			// console.log('ok: keypress on enter');
	            			$('#plaintext-filter').submit();
	            		}
	            	});
	            	
	 		 	});
	 		 	
	 		</script>
	    	
		    <div id="products">
		        @if(count($contents) <= 0)
		            <p>Non sono presenti prodotti.</p>
		        @else 
		        	<div class="col-md-12 products-found" style="text-align: right;">
		        		<p>Prodotti trovati: <span id="total_products">{{ $all_products_number }}</span></p>
		        	</div>	
	            	<?php $i=0; ?>
	            	
	                @foreach($contents as $content) 
		                @if($i < 18)
			                <div id="{{$content->asin}}" class="col-md-4">
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
		    <div class="text-center pagination-wrap">
		    	{{ method_exists($contents, 'links') ? $contents->links() : '' }}
		    </div>
	    </div>
	</div>   
</div>


@endsection
