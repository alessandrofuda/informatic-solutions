@extends('layouts.app')

@section('content')
<div class="container">

	<div class="row">
	    <div class="col-md-12">
	    <div class="row text-center title">
	    	<h1>Confronta <b>{{ ucfirst($slug) }}</b> e monitora i prezzi</h1>
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


@endsection
