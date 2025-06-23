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
                                <form action="{{ route('transaction.update', $transaction->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PATCH')
                                    <div class="form-group col-md-6 p-0">
                                        <label for="tanggal_pengiriman">Tgl Pengiriman</label>
                                        <input type="date" class="form-control"
                                            name="tanggal_pengiriman" id="tanggal_pengiriman"
                                            value="{{ old('tanggal_pengiriman', $transaction->tanggal_pengiriman) }}"
                                            placeholder="{{ now()->format('Y-m-d') }}" disabled>
                                        @error('tanggal_pengiriman')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="tujuan" class="text-capitalize">Tujuan</label>
                                        <input type="text" class="form-control" id="tujuan" name="tujuan" value="{{ old('tujuan', $transaction->tujuan) }}" disabled>
                                        @error('tujuan')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="expedisi" class="text-capitalize">Ekspedisi</label>
                                        <input type="text" class="form-control" id="expedisi" name="expedisi" value="{{ old('expedisi', $transaction->expedisi) }}">
                                        @error('expedisi')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="supir" class="text-capitalize">supir</label>
                                        <input type="text" class="form-control" id="supir" name="supir" value="{{ old('supir', $transaction->supir) }}">
                                        @error('supir')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="no_mobil" class="text-capitalize">No Mobil</label>
                                        <input type="text" class="form-control" id="no_mobil" name="no_mobil" value="{{ old('no_mobil', $transaction->no_mobil) }}">
                                        @error('no_mobil')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="no_loading" class="text-capitalize">No Loading</label>
                                        <input type="text" class="form-control" id="no_loading" name="no_loading" value="{{ old('no_loading', $transaction->no_loading) }}">
                                        @error('no_loading')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="no_cont" class="text-capitalize">No Cont</label>
                                        <input type="text" class="form-control" id="no_cont" name="no_cont" value="{{ old('no_cont', $transaction->no_cont) }}">
                                        @error('no_cont')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6 p-0">
                                        <label for="mulai">Mulai</label>
                                        <input type="time" class="form-control"
                                            name="mulai" id="mulai"
                                            value="{{ old('sampai', $transaction->mulai) }}">
                                        @error('mulai')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6 p-0">
                                        <label for="sampai">Sampai</label>
                                        <input type="time" class="form-control"
                                            name="sampai" id="sampai"
                                            value="{{ old('sampai', $transaction->sampai) }}">
                                        @error('sampai')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <button type="submit" class="btn btn-outline-primary btn-sm">
                                        <i class="fa fa-save"></i> Update
                                    </button>
                                    <button type="reset" class="btn btn-outline-warning btn-sm">
                                        <i class="fa fa-undo"></i> Reset
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
