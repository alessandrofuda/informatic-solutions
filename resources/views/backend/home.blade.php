@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>
                <div class="panel-body">                    
                
                    
                @if (Auth::user()->is_admin())  
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            ciao <span style="color:red;">{{ ucfirst(Auth::user()->name) }}</span>, sei loggato come <strong>amministratore</strong>.
                        </div>

                        <div class="panel-body">
                            <p>
                            <a class="btn btn-primary btn-sm" href="{{url('backend/comments')}}">Visualizza tutti i commenti</a> <a class="btn btn-primary btn-sm" href="{{url('backend/pending-comments')}}">Solo commenti in moderazione</a>
                            </p>
                            <p>
                            <a class="btn btn-primary btn-sm" href="{{url('backend/users')}}">Visualizza tutti gli utenti</a>
                            </p>
                        </div>
                        
                    </div>

                @elseif (Auth::user()->is_author())

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            ciao <span style="color:red;">{{ ucfirst(Auth::user()->name) }}</span>, sei loggato come <strong>autore</strong>.
                        </div>
                        
                        <div class="panel-body">
                            <p>Visualizza tutti i tuoi articoli</p> 
                        </div>
                    </div>

                @elseif (Auth::user()->is_subscriber())

                    <div class="panel panel-default">
                        <div class="panel-body">
                            <h3 class="title text-center">Il mio Profilo</h3>
                            <table class="table table-striped table-responsive">
                                <tbody>
                                    <tr>
                                        <td class="text-right"><b>Nome</b></td>
                                        <td>{{$user->name}}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-right"><b>E-mail</b></td>
                                        <td>{{$user->email}}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-right"><b>Tipo di profilo</b></td>
                                        <td><i>{{$user->role}}</i></td>
                                    </tr>
                                    <tr>
                                        <td class="text-right"><b>Data di iscrizione</b></td>
                                        <td>{{$date}}</td>
                                    </tr>
                                    <tr>
                                        <td id="reset-psw" class="text-right"><b>Reimposta password</b></td>
                                        <td><a class="btn btn-primary btn-sm" href="{{url('backend/change-my-pswd')}}">Cambia</a></td>
                                    </tr>
                                </tbody>
                            </table>

                            <hr style="margin:80px auto;">

                            <h3 id="my-list" class="title text-center">Oggetti in osservazione</h3>
                            <div class="text-center" style="margin-bottom: 30px;">

                                @if (count($watched_items) < 10)
                                <a class="btn btn-primary btn-sm" style="max-width: 200px; white-space: normal;" href="{{ url('videocitofoni/comparatore-prezzi') }}">Vuoi monitorare altri prodotti? Vai alla lista completa</a>
                                @endif
                            
                            </div>
                            <table class="table table-striped table-responsive">
                                <thead>
                                    <tr>
                                        <th>Nome prodotto</th>
                                        <th>Immagine</th>
                                        <th>Primo Prezzo rilevato*</th>
                                        <th>Ultimo prezzo rilevato**</th>
                                        <th class="text-center">Azione</th>
                                    </tr>
                                </thead>
                                <tbody>

                                @if ( empty($watched_items) )
                                    <tr class="text-center" style="font-weight: bold;">
                                        <td colspan="4" style="line-height: 80px;">Non hai ancora alcun oggetto in osservazione.</td>
                                    </tr>
                                @else
                                    <style>
                                        td {vertical-align: middle!important;} 
                                        .barrato {text-decoration: line-through;}
                                    </style>

                                    @foreach ($watched_items as $watched_item)                                       
                                        <tr>
                                            <td class="product-name {{ $watched_item->removed == 1 ? 'barrato' : '' }}">{{ $watched_item->product->title }}</td>
                                            <td>
                                                <div style="border:1px solid #CCC;">
                                                    <img src="{{$watched_item->product->largeimageurl}}" width="75px"  height="75px"/>
                                                </div>
                                            </td>
                                            <td class="{{ $watched_item->removed == 1 ? 'barrato' : '' }}">
                                                € {{ number_format($watched_item->initialprice, '2', ',', '.') }}
                                            </td>
                                            <?php
                                                $lowestnewprice = number_format($watched_item->product->lowestnewprice, 2, ',', '.'); // !! String !!
                                                $price = number_format($watched_item->product->price, 2, ',', '.'); // !! STRING !!!!!!!!!

                                                if ( ($watched_item->product->lowestnewprice < $watched_item->initialprice) /*|| 
                                                     ($watched_item->product->price < $watched_item->initialprice) */ ) {
                                                    $color = 'green';
                                                } elseif ( ($watched_item->product->lowestnewprice > $watched_item->initialprice) /*|| 
                                                            ($watched_item->product->price > $watched_item->initialprice) */ ) {
                                                    $color = 'red';
                                                } else {
                                                    $color = 'inherit';
                                                }
                                            ?>
                                            <td class="{{ $watched_item->removed == 1 ? 'barrato' : '' }}">
                                                <b style="color:{{ $color }};">€ {{ $lowestnewprice ? : $price }}</b>
                                            </td>
                                            {{--dd($watched_item->id)--}}
                                            @if (Auth::check() && Auth::user()->isInWatchinglist($watched_item->product_id) && !$watched_item->removed)
                                                <td class="text-center">
                                                    <a class="btn btn-success btn-sm min-160" target="_blank" href="http://www.amazon.it/gp/aws/cart/add.html?AWSAccessKeyId={{ env('AWS_ACCESS_KEY_ID') }}&AssociateTag=infsol-21&ASIN.1={{ $watched_item->product->asin }}&Quantity.1=1">Acquista subito</a>
                                                    <a class="btn btn-info btn-sm min-160 margin-top-10" href="/backend/smetti-di-osservare-{{$watched_item->product->asin}}-{{$watched_item->product_id}}">Smetti di osservare</a>
                                                </td>
                                            @else
                                                <td class="text-center">
                                                    <a class="btn btn-warning btn-sm min-160" href="backend/rimetti-in-osservazione-{{$watched_item->product->asin}}-{{$watched_item->product_id}}">Ri-metti in osservazione</a>
                                                    <a class="btn btn-danger btn-sm min-160 margin-top-10" href="/backend/elimina-da-lista-{{ $watched_item->product->asin }}-{{ $watched_item->product_id }}">Elimina dalla lista</a>
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                @endif

                                </tbody>
                            </table>
                            <hr>
                            <div class="note">
                                <b>NOTE:</b><br>
                                <b>* Primo Prezzo rilevato</b> = Prezzo rilevato nel momento in cui l'oggetto è messo nella lista di osservazione.<br/>
                                <b>** Ultimo Prezzo rilevato</b> = Prezzo aggiornato all'ultima ora.
                            </div>
                            <div class="text-center">
                                <a class="btn btn-primary btn-sm" href="{{ url('videocitofoni/comparatore-prezzi') }}">Vai alla lista di tutti i prodotti</a>
                            </div>
                        </div>
                    </div>

                @endif

                

               
                    

                </div>
            </div>


            {{-- <div>Appunti: !! alla fine controllare tutte le routes tramite middleware e ruoli e permessi !! <br>Verificare che ogni profilo (is_admin, is_author, is_subscriber) abbia accesso alle proprie funzionalità/routes !! --> tramite i _construct dei controller. Ogni controller deve avere in alto il _construct con middleware</div> --}}

            
        </div>
        
    </div>
</div>
@endsection
