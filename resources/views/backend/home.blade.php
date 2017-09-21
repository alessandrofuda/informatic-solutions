@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 col-md-offset-0">
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
                            <table class="table table-striped table-responsive summary">
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
                            <table id="watchinglist" class="table table-striped table-responsive">
                                <thead>
                                    <tr>
                                        <th>Nome prodotto</th>
                                        <th class="no-sort">Immagine</th>
                                        <th>Prezzo originario*</th>
                                        <th>Prezzo attuale**</th>
                                        <th>Delta</th>
                                        <th class="text-center no-sort">Azione</th>
                                    </tr>
                                </thead>
                                <tbody>

                                @if ( empty($watched_items) )
                                    <tr class="text-center" style="font-weight: bold;">
                                        <td colspan="4" style="line-height: 80px;">Non hai ancora alcun oggetto in osservazione.</td>
                                    </tr>
                                @else
                                    @foreach ($watched_items as $watched_item)                                       
                                        <tr>
                                            <td class="product-name">
                                                {{ $watched_item->product->title }}
                                            </td>
                                            <td class="img">
                                                <div style="border:1px solid #CCC;">
                                                    <img src="{{$watched_item->product->largeimageurl}}" width="75px"  height="75px"/>
                                                </div>
                                            </td>
                                            <td class="init-price">
                                                € {{ number_format($watched_item->initialprice, '2', ',', '.') }}
                                            </td>

                                            @php
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
                                            @endphp

                                            <td class="actual-price">
                                                <b style="color:{{ $color }};">€ {{ $lowestnewprice ? : $price }}</b>
                                            </td>

                                            @php
                                                $actual_price = floatval(str_replace(',', '.', $lowestnewprice ? : $price)); // attenzione a virgola!!!
                                                $original_price = $watched_item->initialprice;
                                                $diff = $actual_price - $original_price;
                                                $sign = $diff <= 0 ? '':'+';
                                                $col = $diff <= 0 ? ($diff == 0 ? 'inherit':'green'): 'red';
                                                $bold = $diff < 0 ? 'bold':'normal';
                                                $delta = number_format($diff, 2, ',', '.');
                                            @endphp

                                            <td class="delta" style="color:{{ $col }}; font-weight:{{ $bold }};">
                                                {{ $sign . $delta }}
                                            </td>
                                            {{--dd($watched_item->id)--}}
                                            @if (Auth::check() && Auth::user()->isInWatchinglist($watched_item->product_id)) {{-- && !$watched_item->removed --}}
                                                <td class="text-center pulsanti">
                                                    <a class="btn btn-success btn-sm min-160" target="_blank" href="http://www.amazon.it/gp/aws/cart/add.html?AWSAccessKeyId={{ env('AWS_ACCESS_KEY_ID') }}&AssociateTag=infsol-21&ASIN.1={{ $watched_item->product->asin }}&Quantity.1=1">Acquista subito</a>
                                                    <a class="btn btn-info btn-sm min-160 margin-top-10" href="/backend/smetti-di-osservare-{{$watched_item->product->asin}}-{{$watched_item->product_id}}">Smetti di osservare</a>
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                @endif

                                </tbody>
                            </table>

                            <!--h3 id="my-list" class="title text-center">Oggetti temporaneamente rimossi dalla lista di osservazione</h3-->
                            <table id="removed" class="table table-striped table-responsive removed" style="margin-top:1px; border-bottom: 1px solid #000;">
                                <tbody>
                                    @foreach($removeds as $removed)
                                    <tr>
                                        <td class="product-name barrato">{{ $removed->product->title }}</td>
                                        <td class="img">
                                            <div style="border:1px solid #CCC; opacity: 0.3;">
                                                <img src="{{$removed->product->largeimageurl}}" width="75px"  height="75px"/>
                                            </div>
                                        </td>
                                        <td class="init-price barrato">
                                            € {{ number_format($removed->initialprice, '2', ',', '.') }}
                                        </td>
                                        @php
                                            $lowestnewprice_r = number_format($removed->product->lowestnewprice, 2, ',', '.'); // !! String !!
                                            $price_r = number_format($removed->product->price, 2, ',', '.'); // !! STRING !!!!!!!!!
                                        @endphp
                                        <td class="actual-price barrato">€ {{ $lowestnewprice_r ? : $price_r }}</td>
                                        <td class="delta"> ... </td>
                                        @if(Auth::check() && Auth::user()->isInWatchinglist($removed->product_id))
                                        <td class="text-center pulsanti">
                                            <a class="btn btn-warning btn-sm min-160" href="backend/rimetti-in-osservazione-{{$watched_item->product->asin}}-{{$watched_item->product_id}}">Ri-metti in osservazione</a>
                                            <a class="btn btn-danger btn-sm min-160 margin-top-10" href="/backend/elimina-da-lista-{{ $watched_item->product->asin }}-{{ $watched_item->product_id }}">Elimina dalla lista</a>
                                        </td>
                                        @endif
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            
                            <div class="note">
                                <b>NOTE:</b><br>
                                <b>* Prezzo originario</b> = Prezzo rilevato nel momento in cui l'oggetto è stato messo nella lista di osservazione.<br/>
                                <b>** Prezzo attuale</b> = Prezzo aggiornato all'ultima ora.
                            </div>

                            <!--datatables jquery plugin-->
                            <script type="text/javascript">
                                $(document).ready(function(){
                                    $('#watchinglist').DataTable({
                                        "columnDefs": [{
                                            "targets": 'no-sort',
                                            "orderable": false,
                                        }],
                                        "paging": false,
                                        "info": false,
                                        "searching": false,
                                    });
                                });
                            </script>
                            <style>
                                td {vertical-align: middle !important;} 
                                .barrato {text-decoration: line-through;}
                            </style>
                            <script>
                                $(document).ready(function(){
                                    var Col1Width = $('#watchinglist .product-name').width();
                                    var Col2Width = $('#watchinglist .img').width();
                                    var Col3Width = $('#watchinglist .init-price').width();
                                    var Col4Width = $('#watchinglist .actual-price').width();
                                    var Col5Width = $('#watchinglist .delta').width();
                                    var Col6Width = $('#watchinglist .pulsanti').width();
                                    console.log(Col1Width);
                                    $('#removed .product-name').width(Col1Width -10);
                                    $('#removed .img').width(Col2Width);
                                    $('#removed .init-price').width(Col3Width);
                                    $('#removed .actual-price').width(Col4Width);
                                    $('#removed .delta').width(Col5Width);
                                    $('#removed .pulsanti').width(Col6Width);
                                    // console.log(x);
                                });
                            </script>
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
