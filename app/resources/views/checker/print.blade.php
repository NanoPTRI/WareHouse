<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Pengiriman</title>
    <style>

        @page {
            size: A4;
            margin: 1cm;
        }

        body {
            font-family: Arial, sans-serif;
        }

        .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        .col-sm-6 {
            flex: 0 0 49%;
            max-width: 49%;
            margin-bottom: 10px;
        }

        .card {
            border: 1px solid #000;
            padding: 0.5rem;
            min-height: 100px;

        }

        .text-center {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #000;
            padding: 2px;
        }

        thead {
            display: table-header-group;
        }

        @media print {
            .card {
                break-inside: avoid;
                page-break-inside: avoid;
            }
        }
    </style>
</head>
<body>

<div class="container">
    @php
        $maxPerCard = 25; // batas maksimal baris per tabel
    @endphp

    @foreach($dataPengiriman as $pengiriman)
        @php
            $chunks = collect($pengiriman->kebutuhuanPengiriman)->chunk($maxPerCard);
        @endphp

        @foreach($chunks as $chunk)
            <div class="col-sm-6">
                <div class="card">
                    <div class="text-center"><strong>{{ $pengiriman->tujuan }}</strong></div>
                    <div class="text-center">{{ $pengiriman->tanggal_pengiriman }}</div>

                    <table>
                        <thead>
                        <tr>
                            <th>Type</th>
                            <th>Qty</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($chunk as $item)
                            <tr>
                                <td>{{ $item->inventori->OtherID }}</td>
                                <td>{{ $item->qty }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach
    @endforeach
</div>

<script>
    window.onload = () => window.print();
</script>

</body>
</html>
