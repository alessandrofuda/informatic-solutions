{{-- dd($content->LargeImage->URL) --}}

@if(isset($content->largeimageurl) || trim($content->largeimageurl) != '' )  
    <img alt="Immagine di {{ $content->title }}"
    	 title="{{ $content->title }}" 
         class="img-responsive"
         src="{{ asset($content->largeimageurl) }}" height="{{ $content->largeimageheight }}" width="{{ $content->largeimagewidth }}" />
@else
    <img alt="Ancora non abbiamo nessuna immagine per {{ $content->title }}"
    	 title="Immagine non disponibile per il prodotto {{ $content->title }}" 
         class="img-responsive"
         src="{{ asset('/images-comp/immagine-non-disponibile.jpg') }}"/>
@endif