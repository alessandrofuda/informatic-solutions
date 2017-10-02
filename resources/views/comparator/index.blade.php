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
                            <input type="text" placeholder="Cosa stai cercando?" class="form-control" v-model="query">
                        </div>
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button" @click="search()" v-if="!loading">Search!</button>
                            <button class="btn btn-default" type="button" disabled="disabled" v-if="loading">Searching...</button>
                        </span>
                    </div>
                </div>
            </div>



            <div id="search-alert" class="alert alert-danger" role="alert" v-if="error">
			    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
			    @{{ error }} {{-- @ --> per non confonderlo con le parentesi di blade --}}
			    <button class="close" v-on:click="error = !error">x</button>
			</div>



			<!-- search results-->
            <div id="products" class="row">
            	<div class="item col-md-12" v-for="product in products">
				    <div class="col-md-2 thumbnail">
				        <img class="" src="@{{ product.largeimageurl }}" width="200" height="200" alt="@{{ product.title }}" />
				    </div>
			        <div class="col-md-6">
			            <h3 class="product-title">@{{ product.title }}</h3>
			            <p class="product-info">@{{ product.feature }}</p>
			        </div>    
	                <div class="col-md-2">
	                    <p class="lead">$@{{ product.lowestnewprice }}</p>
	                </div>
	                <div class="col-md-2">
	                    <a class="btn btn-success" href="#">Avvisami quando il prezzo scende</a>
	                    <a class="btn btn-success" href="#">Acquista subito</a>
	                </div>
				</div>
            </div>






	    </div>


	    
	        @if(count($contents) <= 0)
	            <p>Non sono presenti prodotti.</p>
	        @else 
	        		
	            	<?php $i=0; ?>
	            	{{--dd($contents)--}}
	                @foreach($contents as $content) 
		                @if($i < 18) {{--18 item per pag--}}
			                <div id="{{ $content->asin }}" class="col-md-4">
			                    @include('comparator.product.product-panel',['content' => $content, 'reviews' => $reviews])
			                </div>

		                	<?php  $i++; ?>
		                
		                    @if($i %3 == 0 && $i > 0)
		                    	<div class="clearfix"></div>
		                    @endif
		                @endif
	                @endforeach

	            <div class="clearfix"></div>

	            {{-- !!  $products->links() !!--}}

	        @endif
	    </div>
	</div>   
</div>

<!-- Vue.js for scout search box-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.26/vue.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue-resource/1.0.1/vue-resource.min.js"></script>
<script src="/js/app-search.js"></script>


@endsection
