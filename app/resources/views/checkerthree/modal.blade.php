@if($data)
    <style>
        input:disabled {
            background-color: transparent !important;
            color: #FFFFFF; /* Sesuaikan agar teks tetap terbaca */
            border: none; /* Tambahkan jika perlu outline */
        }

    </style>
    @php
        $hasNullChecker2 = collect($data)->contains(fn($d) => $d->checker2 === null);
    @endphp
    <div class="row">
        <div class="col-md-6 mb-4">
            @if ($hasNullChecker2)
                <div class="form-group">
                    <label for="item">QR-Code Pallet*</label>
                    <input type="text" class="form-control" name="code" id="codes" placeholder="SCAN QR-CODE ITEM">
                    @error('item') <div class="text-danger">{{ $message }}</div> @enderror
                </div>
            @else
                <form method="POST" action="{{route('checkerthree.store')}}" autocomplete="off">
                    @csrf
                    <div class="form-group">
                        <label for="item">Click Save For Finishing Checker 3*</label>
                        <input type="hidden" value="{{$id}}" name="id" >
                    </div>
                    <button type="button" class="btn btn-outline-warning text-warning hover-text-white" data-dismiss="modal">
                        Close
                    </button>
                    <button type="submit" class="btn btn-danger">Save</button>
                </form>
            @endif
        </div>
        <div class="col-md-6">
            <div class="table-responsive" style="max-height: 50vh; overflow-y: auto;">
                <table class="table table-bordered" id="paketTables" >
                    <thead>
                    <tr>
                        <th style="width:6%">No</th>
                        <th>Part Name</th>
                        <th>ID Other</th>
                        <th>Qty</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $key => $dat)
                        @if ($dat->inventori)
                        <tr class="{{ $dat->checker2 === null ? 'bg-red' : 'bg-green' }}">
                                <td>{{ $dat->tempPallet->palletCode->name }}</td>
                                <td>{{ $dat->inventori->PartName }}</td>
                                <td>{{ $dat->inventori->OtherID }}</td>
                                <td> {{ (int) $dat->inventori->QtySalesPerPack }}
                                <td>
                                    <a href="#"
                                       id="edit-linksingle{{ $dat->tempPallet->palletCode->name . $key }}"
                                       onclick="inputqty('single{{ $dat->tempPallet->palletCode->name . $key }}')"
                                       class="edit btn btn-warning btn-sm">
                                        <i class="fa fa-edit"></i>
                                    </a>

                                    <a
                                        href="#"
                                        onclick="updateQtySingle('{{ $dat->id }}','single{{ $dat->tempPallet->palletCode->name . $key }}')"
                                        id="submit-btnsingle{{ $dat->tempPallet->palletCode->name . $key }}"
                                        class="btn btn-light btn-sm editable"
                                        hidden>
                                        <i class="fa fa-trash"></i>
                                    </a>

                                </td>
                        </tr>
                        @elseif($dat->palletCustom && $dat->palletCustom->isNotEmpty())
                            @foreach($dat->palletCustom as $i => $d)
                                <tr class="{{ $dat->checker2 === null ? 'bg-red' : 'bg-green' }}">
                                    @if($i == 0)
                                        <td>{{ $dat->tempPallet->palletCode->name }}</td>
                                    @else
                                        <td></td>
                                    @endif

                                    <td>{{ $d->inventori->PartName }}</td>
                                    <td>{{ $d->inventori->OtherID }}</td>
                                        <td>
                                            <input
                                                id="custom{{ $dat->tempPallet->palletCode->name . $i }}"
                                                value="{{ $d->qty }}"
                                                class="form-control editable"
                                                disabled
                                            />
                                        </td>
                                        <td>
                                                <a href="#"
                                                   id="edit-linkcustom{{ $dat->tempPallet->palletCode->name . $i }}"
                                                   onclick="inputqty('custom{{ $dat->tempPallet->palletCode->name . $i }}')"
                                                   class="edit btn btn-warning btn-sm">
                                                    <i class="fa fa-edit"></i>
                                                </a>

                                            <a
                                                href="#"
                                                onclick="updateQtyCustom('{{ $d->id }}','custom{{ $dat->tempPallet->palletCode->name . $i }}')"
                                                id="submit-btncustom{{ $dat->tempPallet->palletCode->name . $i }}"
                                                class="btn btn-light btn-sm editable"
                                                hidden>
                                                <i class="fa fa-save"></i>
                                            </a>

                                        </td>
                                </tr>
                            @endforeach
                        @else
                            <td colspan="3">Tidak ada data inventori</td>
                        @endif
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@else
    <h1>Error Call Divison IT </h1>
@endif
<script>
    function inputqty(id) {
        const active = $('a.editable:not(:hidden)').not(`#${id}`);
        if (active.length > 0) {
            alert("Selesaikan input yang sedang aktif terlebih dahulu.");
            return;
        }

        // Aktifkan input
        $(`#${id}`).prop('disabled', false).focus();
        // Sembunyikan tombol edit dan tampilkan tombol submit untuk baris terkait
        $(`#edit-link${id}`).hide();
        $(`#submit-btn${id}`).removeAttr('hidden');
    }
    function updateQtyCustom(item,inputId) {
        let urlx = "{{ route('checkerthree.update.qtycustom', ['id' => '__NUMBER__']) }}".replace('__NUMBER__', item);
        const qty = $(`#${inputId}`).val();

        $.ajax({
            url: urlx,
            type: 'PATCH',
            data: {
                qty: qty,
                _token: '{{ csrf_token() }}'
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
                        modal(@json($id));
                    });
                } else {
                    showError(response.message);
                }
            },
            error: function(response) {
                showError(response.responseJSON.message);
            }
        });
    }
    function updateQtySingle(item,inputId) {
        let urlx = "{{ route('checkerthree.update.qtysingle', ['id' => '__NUMBER__']) }}".replace('__NUMBER__', item);
        const qty = $(`#${inputId}`).val();

        $.ajax({
            url: urlx,
            type: 'PATCH',
            data: {
                qty: qty,
                _token: '{{ csrf_token() }}'
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
                        modal(@json($id));
                    });
                } else {
                    showError(response.message);
                }
            },
            error: function(response) {
                showError(response.responseJSON.message);
            }
        });
    }

    $(document).ready(function() {

        function processScannedCode(codesParams) {
            if (codesParams === "") {
                showError('Please enter a valid item code')
                $('#codes').val("").focus();
                return;
            }
            const codebar = codesParams.substring(0, 2);

            if (codebar === 'PL') {
                var urlx = "{{ route('checkerthree.update', ['kode' => '__NUMBER__']) }}".replace('__NUMBER__', codesParams);
                $.ajax({
                    url: urlx,
                    type: 'PATCH',
                    data: {
                        _token: '{{ csrf_token() }}'
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
                                modal(@json($id));
                            });

                        } else {
                            $('#codes').val("")
                            showError(response.message)
                        }
                    },
                    error: function (response) {
                        $('#codes').val("")
                        showError(response.responseJSON.message)

                    }
                });
            } else {
                $('#codes').val("")
                showError('Please Scan Valid Card')
            }
        }

        $('#codes').on('keypress', function(e) {
            if (e.which === 13) {
                let codesParams = $(this).val();
                processScannedCode(codesParams);
            }
        });

    })
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
</script>
