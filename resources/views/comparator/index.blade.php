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
            	<div class="row item col-md-12" v-for="product in products" v-bind:style="prodotto">
				    <div class="col-md-2" v-bind:style="thumbnail">
				        <img :src="product.largeimageurl" width="180" height="180" v-bind:alt="product.title" v-bind:style="img"/>
				    </div>
			        <div class="col-md-7">
			            <h3 class="product-title" v-bind:style="producttitle">@{{ product.title }}</h3>
			            <p class="product-info" v-bind:style="productinfo">@{{ product.feature | truncate(700) }}</p>
			        </div>    
	                <div class="col-md-1" v-bind:style="prezzo">
	                    <span class="lead" v-bind:style="lead">$@{{ product.lowestnewprice }}</span>
	                </div>
	                <div class="col-md-2">
	                	<span>
	                    	<a class="btn btn-success" href="#">Avvisami quando il prezzo scende</a>
	                    	<a class="btn btn-success" href="#">Acquista subito asin @{{ product.asin }}</a>
	                    </span>
	                </div>
				</div>
            </div>






	    </div>



	    <!-- Vue.js for scout search box-->
		<!--script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.26/vue.min.js"></script-->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.4.4/vue.min.js"></script>
		<!--script src="https://cdnjs.cloudflare.com/ajax/libs/vue-resource/1.0.1/vue-resource.min.js"></script-->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/vue-resource/1.3.4/vue-resource.min.js"></script>
		<script src="/js/app-search.js"></script>

		<!--style>
			// .s-product { border:1px solid #CCC; margin:0; padding: 20px 0; }
			// .thumbnail.s { margin:0; border:none; padding:0 20px;}
			// .product-title.s { margin-top: 0; text-align: left;}
			// .product-info.s { margin-top: 5px; text-align: left;}
			// (prezzo) .cont-lead.s { position: relative; top: 50%; transform: translateY(-50%); }
			// .lead.s {margin:0;}
		</style-->









	    
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



@endsection
