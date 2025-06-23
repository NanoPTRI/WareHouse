<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Data Order</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
            padding: 0;
            margin: 0;
            color: #000;
        }

        .container {
            width: 100%;
        }

        h3 {
            margin-top: 10px;
            margin-bottom: 5px;
            text-align: center;
            width: 100%;
            font-size: 16px;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            margin: 0 -10px;
        }

        .col {
            flex: 1;
            padding: 0 10px;
            min-width: 150px;
            margin-bottom: 0px;
        }

        .col-6 {
            padding: 0 10px;
        }

        .card {
            border: 1px solid #ccc;
            margin-bottom: 0px;
            padding: 10px;
            page-break-inside: avoid;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 5px;
            margin-bottom: 10px;
        }

        .card-body {
            padding: 4px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 0px;
        }

        th, td {
            border: 1px solid #000;
            padding: 4px;
            text-align: center;
            font-size: 11px;
        }

        .text-center {
            text-align: center;
        }

        @media print {
            @page {
                size: A5 landscape;
                margin: 0;
                padding: 0;
            }

            .fas.fa-print {
                display: none !important;
            }

            a[href]:after {
                content: "" !important;
            }

            body {
                padding: 0.5cm;
            }


            .card {
                border: 1px solid #000 !important; /* pastikan border muncul */
                box-shadow: none !important; /* hapus shadow agar tidak kabur di print */
            }



            table, th, td {
                border: 1px solid #000 !important;
                border-collapse: collapse;
            }

            .table th, .table td {
                padding: 2px;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <article class="card">
        <header class="card-header">
            <h3>CHECK LIST PENGIRIMAN BARANG JADI  (CHECKER...)</h3>
            <a href="{{ route('admin.transaction.print',$data->id) }}" target="_blank">
                <i class="fas fa-print" style="font-size: 25px;"></i>
            </a>
        </header>

        <div class="card-body">
            <div class="row">
                <div class="col">
                    <p><strong>TANGGAL :</strong> {{ \Carbon\Carbon::parse($data->tanggal_pengiriman)->translatedFormat('d F y') }}</p>
                    <p><strong>TUJUAN :</strong> {{ $data->tujuan }}</p>
                    <p><strong>EXPEDISI :</strong> {{ $data->expedisi }}</p>
                    <!-- \Carbon\Carbon::parse($data->mulai)->format('H:i') .'/'. \Carbon\Carbon::parse($data->sampai)->format('H:i') -->
                </div>
                <div class="col">
                    <p><strong>SOPIR :</strong> {{ $data->supir }}</p>
                    <p><strong>NO. MOBIL :</strong> {{ $data->no_mobil }}</p>
                    <p><strong>NO.LOADING :</strong> {{ $data->no_loading }}</p>
                </div>
                <div class="col">
                    <p><strong>NO. CONT :</strong> {{ $data->no_cont }}</p>
                    <p><strong>MULAI MUAT :</strong> {{ \Carbon\Carbon::parse($data->mulai)->format('H:i') }}</p>
                </div>
            </div>

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
                    @foreach($inventori as $key => $inven)
                        @php
                            $subtotal = array_sum($pallet[$inven->PartID]);
                            $totalSum += $subtotal;
                        @endphp
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $inven->OtherID }}</td>
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
                            <td>{{ $subtotal }}</td>
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
                        <td colspan="{{ 10 + 2 }}" class="text-center">Sub Total</td>
                        <td>{{ $totalSum }}</td>
                        <td></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-6">
                <p><strong>* LIST INI HARUS DILAMPIRKAN WAKTU TANDA TANGAN DAN DI FILE BERSAMA SURAT JALAN</strong></p>
            </div>
            <div class="col">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>CHECKER</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><br><br><br></td>
                        </tr>
                        <tr>
                            <td><br></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </article>
    <div style="display: flex; justify-content: space-between; width: 100%;">
        <p><strong>(1-2-004) REVISI</strong></p>
        <p><strong>PT. RINNAI INDONESIA</strong></p>
    </div>
</div>
<script>
    window.onload = function () {
        window.print();
    };
</script>

</body>
</html>
