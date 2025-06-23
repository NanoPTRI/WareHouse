@extends('component.app')
@section('content')

    <div class="content-wrapper">
        <div class="content-header">
            <div class="container">
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
        </div>

        <div class="content">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="card mb-2">
                            <div class="card-body">
                                <form action="{{ route('transaction.store.transaction') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label for="name" class="text-capitalize">Upload Excel File*</label>
                                        <input type="file" class="form-control" style="padding:2px;" id="file" name="file" value="{{ old('file') }}" placeholder="Enter file">
                                        @error('file')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="row p-4 justify-content-end" id="save-data" style="display: none;">
                                        <div class="col-auto">
                                            <button type="submit" class="btn btn-outline-secondary btn-sm" id="saveButton">
                                                <i class="fa fa-save"></i> Save
                                            </button>
                                        </div>
                                        <div class="col-auto">
                                            <button type="button" class="btn btn-outline-warning btn-sm" onclick="clickReset()">
                                                <i class="fa fa-undo"></i> Reset
                                            </button>
                                        </div>


                                    </div>

                                </form>
                                <section class="content mt-2 ">
                                    <div id="dynamic-table-container" class="row"></div>
                                </section>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <script>

        document.getElementById('saveButton').addEventListener('click', function () {
            window.shouldClearTemp = true; // jangan hapus session
        });

        $('#file').on('change', function () {
            let formData = new FormData();
            let fileInput = this.files[0];
            formData.append('file', fileInput);
            formData.append('_token', '{{ csrf_token() }}');

            // Tampilkan SweetAlert loading spinner
            Swal.fire({
                title: 'Uploading...',
                text: 'Please wait while the file is being uploaded.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                url: '/Transaction/store',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    Swal.close(); // Tutup loading spinner

                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: 'File uploaded successfully.',
                        timer: 2000,
                        showConfirmButton: false
                    });

                    $('#file-error').text('');
                    loadTables();
                },
                error: function (xhr) {
                    Swal.close(); // Tutup loading spinner

                    let errorMessage = 'Upload failed.';
                    if (xhr.responseJSON?.errors?.file) {
                        errorMessage = xhr.responseJSON.errors.file[0];
                        $('#file-error').text(errorMessage);
                    } else {
                        $('#file-error').text(errorMessage);
                    }

                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: errorMessage
                    });
                }
            });
        });

        function formatTanggal(dateString) {
            const date = new Date(dateString);
            return new Intl.DateTimeFormat('id-ID', { day: 'numeric', month: 'long', year: 'numeric' }).format(date);
        }
        function loadTables() {
            $.ajax({
                url: '/Transaction/get-table-data', // Route kamu
                type: 'GET',
                success: function(response) {
                    // Kosongkan dulu container
                    $('#dynamic-table-container').html('');
                    $('#save-data').css('display', 'flex');
                    // Loop data dari response
                    Object.values(response).map((tableData, index) => {
                        let tableId = 'dynamic_table_' + index;

                        let tableHtml = `
                        <div class="col-md-6 mb-4">
                            <div class="card">
                                <div class="card-header text-center">${tableData.location}</div>
                                <div class="card-header text-center">${formatTanggal(tableData.date)}</div>
                                <div class="card-body">
                                    <table class="table table-bordered" id="${tableId}">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>PART ID</th>
                                                <th>PART NUMBER</th>
                                                <th>PART NAME</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            ${tableData.data.map((row, i) => `
                                                <tr>
                                                    <td>${i + 1}</td>
                                                    <td>${row.kode}</td>
                                                    <td>${row.jumlah}</td>
                                                    <td>${row.keterangan}</td>
                                                </tr>
                                            `).join('')}
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    `;
                        $('#dynamic-table-container').append(tableHtml);

                        // Aktifkan DataTables setelah append
                        setTimeout(() => {
                            $('#' + tableId).DataTable();
                        }, 100);
                    });
                }
            });
        }

        function clickReset() {
            console.log('test')
            $.ajax({
                url: '{{route('clear-temp-session')}}',
                type: 'POST',
                data:{
                    _token: '{{ csrf_token() }}',
                },
                success: function (response) {
                    if(response.status == 'cleared'){
                        $('#dynamic-table-container').html('');
                        $('#save-data').css('display', 'flex');
                        $('#file').val('');
                    }
                },
            })
        }
    </script>

    <!-- End view -->
@endsection
