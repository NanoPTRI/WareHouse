@extends('component.app')

@section('content')
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
                                    <table class="table table-bordered" id="planTable" width="100%" cellspacing="0">
                                        <thead>
                                        <tr>
                                            <th style="width:6%">No</th>
                                            <th>Tanggal Pengiriman</th>
                                            <th>Tujuan</th>

                                            <th>Detail</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div> <!-- /.card-body -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modals-detail" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modal">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" data-dismiss="modal">
                        <i class="fa fa-chevron-left"></i> Close
                    </button>
                </div>
            </div>
        </div>
    </div>

<script>
    $(document).ready(function() {
        var table = $('#planTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('transaction.view.get') }}",
                type: 'GET'
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'tanggal_pengiriman', name: 'tanggal_pengiriman' },
                { data: 'tujuan', name: 'tujuan' },

                { data: 'detail', name: 'detail', orderable: false, searchable: true },
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

    function showDetail(id) {
        var urlx = "{{ route('transaction.show', ['id' => '__NUMBER__']) }}".replace('__NUMBER__', id);
        $.ajax({
            url: urlx ,
            method: "GET",
            success: function(response) {
                $("#modal").html(response);
            },
            error: function(xhr) {
                console.error("Terjadi kesalahan:", xhr.responseText);
            }
        });
    }

    function confirmUpdate(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'You won\'t be able to revert this!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, finish it!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('finish-plan-'  + `${id}`).submit();
            }
        });
    }
</script>


@endsection
