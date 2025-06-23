@extends('admin.component.app')
@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ $title }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">{{ $title }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-header bg-secondary">

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="mb-4 col-lg-2 col-6">
                    <label for="date" class="form-label">Pilih Tanggal</label>
                    <input type="date" class="form-control" id="date" name="date" />
                </div>
                <table class="table table-bordered" id="viewDataYourCreated">
                    <thead>
                    <tr>
                        <th style="width:6%">No</th>
                        <th>Tanggal Pengiriman</th>
                        <th>Tujuan</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <!-- Data akan dimuat di sini -->
                    </tbody>
                </table>
            </div>

        </div>
    </section>
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
            const today = new Date().toISOString().split('T')[0];
            $('#date').val(today);

            var table = $('#viewDataYourCreated').DataTable({
                processing: true,
                serverSide: true,
                ajax: function(data, callback, settings) {
                    var date = $('#date').val();
                    var urlx = "{{ route('admin.transaction.getrunning', ['date' => '__NUMBER__']) }}"
                        .replace('__NUMBER__', date);
                    $.get(urlx, data)
                        .done(function(res) {
                            callback(res);
                        })
                        .fail(function() {
                            console.error('Gagal load data');
                        });
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'tanggal_pengiriman', name: 'tanggal_pengiriman' },
                    { data: 'tujuan', name: 'tujuan' },
                    { data: 'action', name: 'action', orderable: false, searchable: true }
                ],
                responsive: true,
                autoWidth: false,
            });
            $('#date').change(function() {
                table.ajax.reload();
            });
        });

        function confirmDelete(itemId) {
            Swal.fire({
                title: 'Are you sure?',
                text: 'You won\'t be able to revert this!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-item-'  + `${itemId}`).submit();
                }
            });
        }

        function showDetail(id) {
            var urlx = "{{ route('admin.transaction.detail', ['id' => '__NUMBER__']) }}".replace('__NUMBER__', id);
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
    </script>

    <!-- End view -->
@endsection
