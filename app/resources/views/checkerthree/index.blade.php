@extends('component.app')

@section('content')
    <style>
        .btn-outline-warning.text-warning:hover {
            color: white !important;
        }
    </style>
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0"> <small>{{$title}}</small></h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('index') }}">Kembali</a></li>
                            <li class="breadcrumb-item active">{{ $title }}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="card mb-2">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="paketTables" width="100%" cellspacing="0">
                                        <thead>
                                        <tr>
                                            <th style="width:6%">No</th>
                                            <th>Tanggal Pengiriman</th>
                                            <th>Tujuan</th>
                                            <th>Expedisi</th>
                                            <th>Mulai</th>
                                            <th>Sampai</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="exampleModalXL" tabindex="-1" aria-labelledby="exampleModalXLLabel">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="m1">Checker Finish</h5>
                    <button type="button" class="close" style="margin-left: 1rem;" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="checker3">
                </div>
                <div class="modal-footer">
                    <span class="text-capitalize font-weight-bolder font-italic text-danger">
                        **Scan QR-Code Pallet**
                    </span><br>
                </div>

            </div>
        </div>
    </div>

<script>
    let key = '';
    let tuju = '';
    function modal(insi, tujuan){
        key = insi;
        tuju = tujuan ? tujuan : tuju;
        const url = '{{ route('checkerthree.get.modal', ['id' => '__id__']) }}'.replace('__id__', insi);
        $.ajax({
            url: url,
            method: 'GET',
            success: function(response) {
                $('#checker3').html(response);
                setTimeout(() => {
                    $('#codes').val("").focus();
                }, 800);

                $('#exampleModalXL')
                    // .off('shown.bs.modal')
                    // .on('shown.bs.modal', function () {
                    //     const $codes = $('#codes');
                    //     if ($codes.length && $codes.is(':visible')) {
                    //         $codes.val('').trigger('focus');
                    //     }
                    // })
                    .modal('show');
                $('#m1').text("Checker Finish - "+tuju);
            },
            error: function(xhr) {
                console.error(xhr.responseText);
            }
        });
    }

    $(document).ready(function() {

        var table = $('#paketTables').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('checkerthree.get') }}",
                type: 'GET'
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'tanggal_pengiriman', name: 'tanggal_pengiriman' },
                { data: 'tujuan', name: 'tujuan' },
                { data: 'expedisi', name: 'expedisi' },
                { data: 'mulai', name: 'mulai' },
                { data: 'sampai', name: 'sampai' },
                { data: 'action', name: 'action', orderable: false, searchable: true }
            ],
            responsive: true,
            autoWidth: false,
            language: {
                processing: "Loading Data...",
                search: "Search:",
                lengthMenu: "Show _MENU_ entries",
                info: "Showing _START_ to _END_ of _TOTAL_ entries",
                infoEmpty: "No entries to show",
                infoFiltered: "(filtered from _MAX_ total entries)",
                paginate: {
                    first: "First",
                    last: "Last",
                    next: "Next",
                    previous: "Previous"
                },
                zeroRecords: "No matching records found"
            }
        });


    });


</script>

@endsection
