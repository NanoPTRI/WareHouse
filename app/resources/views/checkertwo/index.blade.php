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
                                    <table class="table table-bordered" id="checkerTable" width="100%" cellspacing="0">
                                        <thead>
                                        <tr>
                                            <th style="width:6%">No</th>
                                            <th>Tanggal Pengiriman</th>
                                            <th>Tujuan</th>
                                            <th>Ekspedisi</th>
                                            <th>Mulai</th>
                                            <th>Sampai</th>
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

    <div class="modal fade" id="firstModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-x2">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="m1">Pallet Scan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="pallet">QR-Code Pallet*</label>
                                <input type="text" class="form-control" name="pallet" id="pallet" placeholder="SCAN QR-CODE PALLET" autofocus>
                                @error('pallet') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <span class="text-capitalize font-weight-bolder font-italic text-danger">
                        **Scan Pallet First Before to the next process**
                    </span><br>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="secondModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header align-items-center">
                    <h5 class="modal-title" id="m2">Form Input Pallet Same Type</h5>
                    <div style="display: flex; padding: 0px">
                        <button class="btn btn-primary rounded-circle text-uppercase d-flex align-items-center justify-content-center"
                                style="width: 50px; height: 50px;" id="customButton">
                            Retail
                        </button>

                        <button type="button" class="close" style="margin-left: 1rem;" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="item">QR-Code Item*</label>
                                <input type="text" class="form-control" name="item" id="item" placeholder="SCAN QR-CODE ITEM" required>
                                @error('item') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>
                            <div class="form-group">
                                <label for="OtherID">Type</label>
                                <input type="text" class="form-control" name="OtherID" id="OtherID" placeholder="TYPE" readonly>
                                @error('OtherID') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="table-responsive" style="max-height: 70vh">
                                <table class="table table-bordered" id="kebutuhanTable" width="100%" cellspacing="0">
                                    <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Type</th>
                                        <th>Qty Plan</th>
                                    </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <span class="text-capitalize font-weight-bolder font-italic text-danger">
                        **Scan Barcode Item**
                    </span><br>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="thirdModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="m3">Form Input Costum Pallet</h5>
                    <div style="display: flex; padding: 0px">
                        <button class="btn btn-primary rounded-circle text-uppercase d-flex align-items-center justify-content-center"
                                style="width: 50px; height: 50px;" id="basicButton">
                            FULL
                        </button>
                        <button type="button" class="close" style="margin-left: 1rem;" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="item2">QR-Code Item*</label>
                                <input type="text" class="form-control" name="item2" id="item2" placeholder="SCAN QR-CODE ITEM">
                            </div>
                            <div class="form-group">
                                <label for="type2">Type</label>
                                <input type="text" class="form-control" name="type2" id="type2" placeholder="TYPE" readonly>
                            </div>
                            <div class="form-group">
                                <label for="qty2">Qty</label>
                                <input type="number" class="form-control" name="qty2" id="qty2" placeholder="QUANTITY" min="0">
                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="customTable" width="100%" cellspacing="0">
                                    <thead>
                                    <tr>
                                        <th>Type</th>
                                        <th>Qty</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                            <div style="width:100%;" class="d-flex justify-content-end">
                                <button class="btn btn-primary" id="saveCustomButton" onclick="saveCustom();">Simpan</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <span class="text-capitalize font-weight-bolder font-italic text-danger">
                        **Scan Barcode Item**
                    </span><br>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modals-detail" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
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
        var table = $('#checkerTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('checkertwo.get') }}",
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
    function showError(message) {
        Swal.fire({
            title: 'Oops...!',
            text: message,
            icon: 'error',
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true
        });
    }
    let pallet_code = '';
    let id_data_pengiriman = '';
    function checkPalletReady(codesParams){
        var urlx = "{{ route('checkertwo.checkpallet', ['kode' => '__NUMBER__']) }}".replace('__NUMBER__', codesParams);

        $.ajax({
            url: urlx,
            type: 'get',
            success: function (response, textStatus, jqXHR) {
                if (jqXHR.status === 200) {
                    Swal.fire({
                        title: 'Success...!',
                        text: response.message,
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 500,
                        timerProgressBar: true
                    }).then(() => {
                        pallet_code = codesParams
                        $('#firstModal').modal('hide');
                        $('#secondModal').modal('show');
                    });
                } else {
                    showError(response.message)
                    $('#pallet').val('').focus();

                }
            },
            error: function (response) {
                showError(response.responseJSON.message)
                $('#pallet').val('').focus();

            }
        });
    }
    function clearStoreItem(){
        pallet_code = '';
        $('#item').val('').focus();

    }
    function storeItem(item){
        $.ajax({
            url: "{{ route('checkertwo.store') }}",
            type: 'POST',
            data: {
                OtherID: item,
                pallet_code: pallet_code,
                id_data_pengiriman: id_data_pengiriman,
                _token: '{{ csrf_token() }}'
            },
            success: function(response, textStatus, jqXHR) {
                if (jqXHR.status === 201) {
                    Swal.fire({
                        title: 'Success...!',
                        text: response.message,
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 1000,
                        timerProgressBar: true
                    }).then(() => {
                        clearStoreItem();
                        $('#secondModal').modal('hide');
                        $('#firstModal').modal('show');

                    });
                } else {
                    $('#item').val('').focus();
                    showError(response.message);
                }
            },
            error: function(response) {
                $('#item').val('').focus();
                showError(response.responseJSON.message);
            }
        });
    }

    $('#pallet').on('keypress', function(e) {
        if (e.which === 13) {
            e.preventDefault();
            const codePrefix = $('#pallet').val().substring(0, 2);

            if(codePrefix !== "PL") {
                showError("Barcode Invalid Please Try Again !!")
                $('#pallet').val('').focus();
                return;
            }
            checkPalletReady($('#pallet').val())
        }
    });

    $('#item').on('keypress', function(e) {
        if (e.which === 13) {
            e.preventDefault();
            const item = $('#item').val();
            storeItem(item)
        }
    });

    function addNew(id, tujuan) {
        id_data_pengiriman = id;
        $('#firstModal').modal('show');
        $('#m1').text("Pallet Scan - "+tujuan);
        $('#m2').text("Form Input Pallet Same Type - "+tujuan);
        $('#m3').text("Form Input Costum Pallet - "+tujuan);
    }
    let itemcustom = [];
    $('#item2').on('keypress', function(e) {
        if (e.which === 13) {
            e.preventDefault();
            if (itemcustom.some(item => item.id === $('#item2').val().trim())) {
                showError('The item code has been scanned previously')
                $('#item2').val('').focus();
                return;
            }
            $('#type2').val($('#item2').val());
            $('#qty2').focus();
            $('#item2').val('');
        }
    });

    $('#qty2').on('keypress', function(e) {
        if (e.which === 13) {
            e.preventDefault();
            addCustom($('#type2').val(),$('#qty2').val());
        }
    });

    function removeItem(id){
        $('#' + id).remove();
        itemcustom = itemcustom.filter(item => item.id !== id);

    }

    function addCustom(codeItem,qty){
        var urlitem ="{{ route('checkertwo.checkitem', ['kode' => '__NUMBER__', 'qty' => '__QTY__', 'id_data_pengiriman' => '__DATAPENGIRIMAN__']) }}"
            .replace('__NUMBER__', codeItem)
            .replace('__QTY__', qty)
            .replace('__DATAPENGIRIMAN__', id_data_pengiriman);
        $.ajax({
            url: urlitem,
            type: 'get',
            success: function (response, textStatus, jqXHR) {
                if (jqXHR.status === 200) {
                        itemcustom.push({
                            Part: response.partID,
                            id: response.OtherID,
                            qty: qty
                        });
                        $('#customTable tbody').append(
                            '<tr id="'+ response.OtherID +'">' +
                                '<td>' + codeItem + '</td>' +
                                '<td>' + qty + '</td>' +
                            `<td><a class="edit btn btn-outline-danger btn-sm" onclick="removeItem('${response.OtherID}')"><i class="fa fa-trash"></i></a></td>` +
                            '</tr>'
                        );
                    clearCustomItem()
                    $('#item2').focus();

                } else {
                    showError(response.message)
                    clearCustomItem()
                    $('#item2').focus();

                }
            },
            error: function (response) {
                showError(response.responseJSON.message)
                clearCustomItem()
                $('#item2').focus();
            }
        });

    }
    function clearCustomItem(){
        $('#item2').val('');
        $('#qty2').val('')
        $('#type2').val('')
    }
    function saveCustom(){
        var urlSaveCustom = "{{ route('checkertwo.store') }}";

        $.ajax({
            url: urlSaveCustom,
            type: 'post',
            data: {
                "inventori" : itemcustom,
                pallet_code: pallet_code,
                id_data_pengiriman: id_data_pengiriman,
                _token: '{{ csrf_token() }}',

            },
            success: function (response, textStatus, jqXHR) {
                if (jqXHR.status === 201) {
                    Swal.fire({
                        title: 'Success...!',
                        text: response.message,
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 1000,
                        timerProgressBar: true
                    }).then(() => {
                        $('#customTable tbody').html('');
                        clearCustomItem()
                        itemcustom=[];
                        $('#thirdModal').modal('hide');
                        $('#firstModal').modal('show');
                    });


                } else {
                    showError(response.message)
                    $('#item2').focus();

                }
            },
            error: function (response) {
                showError(response.responseJSON.message)
                $('#item2').focus();
            }
        });

    }

    $('#firstModal').on('shown.bs.modal', function () {
        $('#pallet').val("").focus();
    });

    $('#secondModal').on('shown.bs.modal', function () {
        $('#item').val("").focus();
        if ($.fn.dataTable.isDataTable('#kebutuhanTable')) {
            $('#kebutuhanTable').DataTable().clear().destroy();
        }
        var urlx = '{{route('checkertwo.getKebutuhan', ['id_data_pengiriman' => '__NUMBER__'])}}'.replace('__NUMBER__', id_data_pengiriman);
        var kebutuhan_table = $('#kebutuhanTable').DataTable({
            paging: false,
            searching: false,
            processing: true,
            serverSide: true,
            ajax: {
                url: urlx,
                type: 'GET'
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'type', name: 'type', orderable: false, searchable: false },
                { data: 'qty', name: 'qty', orderable: false, searchable: false }
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

    $('#thirdModal').on('shown.bs.modal', function () {
        $('#item2').val("").focus();
    });

    $('#customButton').on('click', function() {
        // Close the second modal
        $('#secondModal').modal('hide');

        // Open the third modal
        $('#thirdModal').modal('show');
    });

    $('#basicButton').on('click', function() {
        // Close the third modal
        $('#thirdModal').modal('hide');

        // Open the second modal
        $('#secondModal').modal('show');
    });

    function showDetail(id) {
        var urlx = "{{ route('checkertwo.show', ['id_data_pengiriman' => '__NUMBER__']) }}".replace('__NUMBER__', id);
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

    function confirmUpdate(itemId) {
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
                document.getElementById('update-form-item-'  + `${itemId}`).submit();
            }
        });
    }
</script>

@endsection
