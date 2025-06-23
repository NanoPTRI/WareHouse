
<div class="container">
    <header class="card-header">
        <div class="row justify-content-between align-items-center">
            <h3>Details Data Order </h3>

        </div>
    </header>
    <article class="card">

        <div class="card-body">
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
                        $subtotal = isset($pallet[$inven->PartID]) ? array_sum($pallet[$inven->PartID]) : 0;
                         $totalSum += $subtotal;
                    @endphp
                    <tr>
                        <th>{{$key + 1}}</th>
                        <td>{{$inven->OtherID}}</td>
                        <td>{{$qtyPlan[$inven->PartID]->qty}}</td>
                        @if(!empty($pallet[$inven->PartID]))
                            @for ($i = 0; $i < 10; $i++)
                                @if(isset($pallet[$inven->PartID]) && is_array($pallet[$inven->PartID]) && isset($pallet[$inven->PartID][$i]))
                                    <td>{{ rtrim(rtrim(number_format($pallet[$inven->PartID][$i], 4, '.', ''), '0'), '.')}}</td>
                                @elseif(isset($pallet[$inven->PartID]) && count($pallet[$inven->PartID]) == 1 && isset($pallet[$inven->PartID][$i]))
                                    <td>{{ rtrim(rtrim(number_format($pallet[$inven->PartID][$i], 4, '.', ''), '0'), '.')}}</td>
                                @else
                                    <td></td>
                                @endif
                            @endfor
                        @else
                            @for ($i = 0; $i < 10; $i++)
                            <td></td>
                            @endfor
                        @endif
                        <td>{{$subtotal}}</td>
                        <td></td>
                    </tr>
                    @if(isset($pallet[$inven->PartID]))
                    @if($maxGroup > 10 && count($pallet[$inven->PartID]) > 10)
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            @for ($i = 10; $i < 20; $i++)
                                @if(isset($pallet[$inven->PartID]) && is_array($pallet[$inven->PartID]) && isset($pallet[$inven->PartID][$i]))
                                    <td>{{ rtrim(rtrim(number_format($pallet[$inven->PartID][$i], 4, '.', ''), '0'), '.')}}</td>
                                @elseif(isset($pallet[$inven->PartID]) && count($pallet[$inven->PartID]) == 1 && isset($pallet[$inven->PartID][$i]))
                                    <td>{{ rtrim(rtrim(number_format($pallet[$inven->PartID][$i], 4, '.', ''), '0'), '.')}}</td>
                                @else
                                    <td></td>
                                @endif
                            @endfor
                            <td></td>
                            <td></td>
                        </tr>
                    @endif
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
