@extends('layouts.comparator')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 col-md-offset-0">
            <div class="panel panel-default">
                <div class="panel-heading text-center">Monitora i tuoi prodotti</div>
                <div class="panel-body"> 
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <h3 class="title text-center">Il mio Profilo</h3>
                            <div class="table-responsive">
                                <table class="table table-striped summary">
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
                            </div>

                            <hr style="margin:80px auto;">

                            <h3 id="my-list" class="title text-center">Oggetti in osservazione</h3>
                            <div class="text-center" style="margin-bottom: 30px;">

                                @if (count($watched_items) < 10)
                                <a class="btn btn-primary btn-sm" style="max-width: 200px; white-space: normal;" href="{{ url('videocitofoni/comparatore-prezzi') }}">Vuoi monitorare altri prodotti? Vai alla lista completa</a>
                                @endif
                            
                            </div>
                            <div class="table-responsive">
                                <table id="watchinglist" class="table table-striped" cellspacing="0" width="100%">  
                                    <thead>
                                        <tr>
                                            <th>Nome prodotto</th>
                                            <th class="no-sort">Immagine</th>
                                            <th>Prezzo originario*</th>
                                            <th>Prezzo attuale**</th>
                                            <th>Delta</th>
                                            <th class="text-center no-sort"></th>
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
                                                <td class="init-price" title="Prezzo rilevato il {{ App\Product::italian_date($watched_item->created_at) }}">
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
                                                    <b style="color:{{ $color }};" title="Prezzo aggiornato al {{ App\Product::italian_date($watched_item->product->updated_at) }}">€ {{ $lowestnewprice ? : $price }}</b>
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
                                                        {{-- vedi: https://webservices.amazon.com/paapi5/documentation/add-to-cart-form.html --}}
                                                        <form method="GET" action="https://www.amazon.it/gp/aws/cart/add.html" target="_blank"> 
                                                            <input type="hidden" name="AWSAccessKeyId" value="{{config('amazon-product.api_key')}}" />
                                                            <input type="hidden" name="AssociateTag" value="{{config('amazon-product.associate_tag')}}" />
                                                            <input type="hidden" name="ASIN.1" value="{{ $watched_item->product->asin }}" />
                                                            <input type="hidden" name="Quantity.1" value="1">
                                                            <button type="submit" class="btn btn-success btn-sm min-160">
                                                                <i class="col-md-2 glyphicon glyphicon-shopping-cart"></i>
                                                                <span class="col-md-10 txt add-to-cart">Acquista subito</span>
                                                            </button>
                                                        </form>
                                                        <a class="btn btn-info btn-sm min-160 margin-5" href="/backend/smetti-di-osservare-{{$watched_item->product->asin}}-{{$watched_item->product_id}}">Smetti di osservare</a>
                                                    </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    @endif

                                    </tbody>
                                </table>

                                <table id="removed" class="table table-striped removed" cellspacing="0" width="100%" style="margin-top:1px; border-bottom: 1px solid #000;">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </thead>
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
                                            <td class="text-center pulsanti">
                                            @if(Auth::check() && Auth::user()->isInWatchinglist($removed->product_id))
                                                <a class="btn btn-warning btn-sm min-160" href="backend/rimetti-in-osservazione-{{$watched_item->product->asin}}-{{$watched_item->product_id}}">Ri-metti in osservazione</a>
                                                <a class="btn btn-danger btn-sm min-160 margin-5" href="/backend/elimina-da-lista-{{ $watched_item->product->asin }}-{{ $watched_item->product_id }}">Elimina dalla lista</a>
                                            @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            
                            <div class="note">
                                <b>NOTE:</b><br>
                                <b>* Prezzo originario</b> = Prezzo rilevato nel momento in cui l'oggetto è stato messo nella lista di osservazione.<br/>
                                <b>** Prezzo attuale</b> = Prezzo aggiornato all'ultima ora.
                            </div>

                            <!--datatables jquery plugin-->
                            <script>
                                $(document).ready(function(){
                                    $('#watchinglist').DataTable({
                                        "columnDefs": [{
                                            "targets": 'no-sort',
                                            "orderable": false,
                                        }],
                                        "paging": false,
                                        "info": false,
                                        "searching": false,
                                        "responsive": {
                                            "details": {
                                                "display": $.fn.dataTable.Responsive.display.childRowImmediate,
                                                "type": ''
                                            } 
                                        }
                                    });

                                    $('#removed').DataTable({
                                        "ordering": false,
                                        "paging": false,
                                        "info": false,
                                        "searching": false,
                                        "responsive": {
                                            "details": {
                                                "display": $.fn.dataTable.Responsive.display.childRowImmediate,
                                                "type": ''
                                            } 
                                        }
                                    }); 
                                });
                            </script>
                            <style>
                                td {vertical-align: middle !important;} 
                                .barrato {text-decoration: line-through;}
                            </style>
                            <script>
                                $(document).ready(function(){
                                    var Col1Width = $('#watchinglist .product-name').outerWidth(true);
                                    var Col2Width = $('#watchinglist .img').outerWidth(true);
                                    var Col3Width = $('#watchinglist .init-price').outerWidth(true);
                                    var Col4Width = $('#watchinglist .actual-price').outerWidth(true);
                                    var Col5Width = $('#watchinglist .delta').outerWidth(true);
                                    var Col6Width = $('#watchinglist .pulsanti').outerWidth(true);
                                    // console.log(Col1Width);
                                    $('#removed .product-name').outerWidth(Col1Width);
                                    $('#removed .img').outerWidth(Col2Width);
                                    $('#removed .init-price').outerWidth(Col3Width);
                                    $('#removed .actual-price').outerWidth(Col4Width);
                                    $('#removed .delta').outerWidth(Col5Width);
                                    $('#removed .pulsanti').outerWidth(Col6Width);
                                });
                            </script>
                            <div class="text-center">
                                <a class="btn btn-primary btn-sm" href="{{ url('videocitofoni/comparatore-prezzi') }}">Vai alla lista di tutti i prodotti</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
