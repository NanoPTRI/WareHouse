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
                        <li class="breadcrumb-item"><a href="{{ route('admin.pallet.index') }}">Back</a></li>
                        <li class="breadcrumb-item active">{{ $title }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-header bg-secondary">
                <h3 class="card-title">{{ $title }}</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>

            <div class="card-body">
                <div class="container mt-0">
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <div class="card-body">
                                <form method="POST" action="{{ route('admin.pallet.update',$id) }}" autocomplete="off">
                                    @csrf
                                    @method('patch')

                                    <div class="form-group">
                                        <label for="name" class="text-capitalize">Name Visitor Card*</label>
                                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name',$data->name) }}" placeholder="Enter Name">
                                        @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="row mt-4 justify-content-end">
                                        <div class="col-auto">
                                            <button type="submit" class="btn btn-outline-secondary btn-sm">
                                                <i class="fa fa-save"></i> Save
                                            </button>
                                        </div>
                                        <div class="col-auto">
                                            <button type="reset" class="btn btn-outline-warning btn-sm">
                                                <i class="fa fa-undo"></i> Reset
                                            </button>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


