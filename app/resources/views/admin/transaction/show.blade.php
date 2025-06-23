
<div class="container">
    <article class="card">
        <header class="card-header">
            <div class="row justify-content-between align-items-center">
                <h3>Details Data Order </h3>
                <a href="{{route('admin.transaction.print',$data->id)}}" target="_blank">
                    <i class="fas fa-print" style="font-size: 25px;"></i>
                </a>
            </div>
        </header>
        <div class="card-body">
            <h6>Tanggal Dan Tujuan: <span id="fullname"></span></h6>
            <article class="card">
                <div class="card-body row">
                    <div class="col"><strong>Tanggal Pengiriman:</strong><br>
                        <p>{{ \Carbon\Carbon::parse($data->tanggal_pengiriman)->translatedFormat('d F y')
                                    .' '. \Carbon\Carbon::parse($data->mulai)->format('H:i').'/'. \Carbon\Carbon::parse($data->sampai)->format('H:i')}}</p></div>
                    <div class="col"><strong>Tujuan:</strong><br><p>{{$data->tujuan}}</p></div>
                    <div class="col"><strong>Expedisi:</strong><br><p>{{$data->expedisi}}</p></div>
                </div>
            </article>
            <hr>

            <h6>Detail: <span id="fullname"></span></h6>
            <article class="card">
                <div class="card-body row">
                    <div class="col"><strong>Supir:</strong><br><p>{{$data->supir}}</p></div>
                    <div class="col"><strong>No Mobil:</strong><br><p>{{$data->no_mobil}}</p></div>
                    <div class="col"><strong>No Loading:</strong><br><p>{{$data->no_loading}}</p></div>
                    <div class="col"><strong>No Cont:</strong><br><p>{{$data->no_cont}}</p></div>
                </div>
            </article>

            <h6>Supplier: <span id="fullname"></span></h6>
            <article class="card">
                <div class="card-body ">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th rowspan="2">No</th>
                                <th rowspan="2">Type Barang Jadi</th>
                                <th rowspan="2">Qty Minta</th>

                                <th colspan="{{ 10 }}">Qty / Pallet</th>
                                <th rowspan="2">Total</th>
                                <th rowspan="2">Kondisi Packing Barang Jadi</th>
                            </tr>
                            <tr>
                                @for ($i = 1; $i <= 10; $i++)
                                    <th>{{ $i }}</th>
                                @endfor
                            </tr>
                            </thead>
                            <tbody>
                            @php $totalSum = 0; @endphp
                            @php $subtotal = 0; @endphp

                            @foreach($inventori as $key => $inven)
                                @php
                                $subtotal = array_sum($pallet[$inven->PartID]);
                                $totalSum += $subtotal;
                                @endphp
                            <tr>
                                <th>{{$key + 1}}</th>
                                <td>{{$inven->OtherID}}</td>
                                <td>{{$qtyPlan[$inven->PartID]->qty}}</td>

                                @for ($i = 0; $i < 10; $i++)
                                    @if(count($pallet[$inven->PartID]) > 1 && !empty($pallet[$inven->PartID][$i]))
                                        <td>{{ rtrim(rtrim(number_format($pallet[$inven->PartID][$i], 4, '.', ''), '0'), '.')}}</td>
                                    @elseif(count($pallet[$inven->PartID]) == 1 && !empty($pallet[$inven->PartID][$i]))
                                        <td>{{ rtrim(rtrim(number_format($pallet[$inven->PartID][$i], 4, '.', ''), '0'), '.')}}</td>
                                    @else
                                        <td></td>
                                    @endif
                                @endfor
                                <td>{{$subtotal}}</td>
                                <td></td>
                            </tr>
                                @if($maxGroup > 10 && count($pallet[$inven->PartID]) > 10)
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        @for ($i = 10; $i < 20; $i++)
                                            @if(count($pallet[$inven->PartID]) > 1 && !empty($pallet[$inven->PartID][$i]))
                                                <td>{{ rtrim(rtrim(number_format($pallet[$inven->PartID][$i], 4, '.', ''), '0'), '.')}}</td>
                                            @elseif(count($pallet[$inven->PartID]) == 1 && !empty($pallet[$inven->PartID][$i]))
                                                <td>{{ rtrim(rtrim(number_format($pallet[$inven->PartID][$i], 4, '.', ''), '0'), '.')}}</td>
                                            @else
                                                <td></td>
                                            @endif
                                        @endfor
                                        <td></td>
                                        <td></td>
                                    </tr>
                                @endif
                            @endforeach

                            <tr>
                                <td></td>
                                <td colspan="{{10 + 2}}" class="text-center">Sub Total</td>
                                <td>{{$totalSum}}</td>
                            </tr>
                            </tbody>
                        </table>
                </div>
            </article>
        </div>
    </article>
</div>
