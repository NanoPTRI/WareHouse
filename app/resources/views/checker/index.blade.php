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
                    <div class="col mb-5">
                        @if($dataPengiriman)
                            <a href="{{route('checker.print')}}" class="btn btn-warning btn-sm mb-2" type="button" target="_blank"><i class="fa fa-save"></i> Print</a>
                        @endif
                        <div class="row">
                        @if($dataPengiriman)
                                @foreach ($dataPengiriman as $key=> $data)
                                    <div class="col-sm-6">

                                        <div class="card mb-2">
                                            <div class="card-header bg-secondary text-white">{{$data['tujuan']}}</div>
                                            <div class="card-body">
                                                <form action="{{ route('checker.finish', $data['id']) }}" method="POST" id="checker-finish-{{$data['id']}}">
                                                    @csrf
                                                    @can(\App\Rules::Checker1->value)
                                                    <button class="btn btn-outline-danger btn-sm" type="button" onclick="finish('{{$data['id']}}')"><i class="fa fa-save"></i> Simpan</button>
                                                    @endcan
                                                </form>
                                                <div class="table-responsive">
                                                    <table class="table table-bordered" id="{{$data['tujuan'].$key}}_Table" width="100%" cellspacing="0">
                                                        <thead>
                                                        <tr>
                                                            <th style="width:6%">No</th>
                                                            <th>Type</th>
                                                            <th>Qty</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody></tbody>
                                                    </table>
                                                </div>
                                            </div> <!-- /.card-body -->
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="col-12 text-center align-content-center " style="height: 70vh;">
                                    <h5>Not Record Data </h5>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script>
    @foreach ($dataPengiriman as $key=> $data)
    $(document).ready(function() {
        let {{$data['tujuan'].$key}}_table = $('#{{$data['tujuan'].$key}}_Table').DataTable({
            paging: false,
            searching: false,
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('checker.get', $data['id']) }}",
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
    @endforeach

    function finish(Id) {
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
                document.getElementById('checker-finish-'  + `${Id}`).submit();
            }
        });
    }
</script>

@endsection
