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


	    	
		    <div id="products">
		        @if(count($contents) <= 0)
		            <p>Non sono presenti prodotti.</p>
		        @else 
		        	<div class="">Prodotti trovati: <span id="total_products">0</span></div>	
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
	    </div>
	</div>   
</div>

<!-- ajax call -->
<script>
	$('input#searchbox').keyup(function(){
		var query = $(this).val().toLowerCase();
		// var text = $(this).text().toLowerCase();
		console.log('query:'+query);
		// console.log('text: '+text);


		//$.ajaxSetup({
	    //    headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
	    //});
	    $.ajax({
	    	async: true,
	        // url:'/ajax-search',
	        url:'',
	        type: 'GET',
	        data: {
	        	q:query
	            // name: groupName,
	            // colour: "red"
	        },
	        success: function(response){
	            console.log('Ajax call: success'+response);
	            // console.log(test);
	        },
	        error: function (response) {
	            console.log('Errore ajax '+ response);
	        },
	    });




	});



	

</script>



@endsection
