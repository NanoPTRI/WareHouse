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
                        <li class="breadcrumb-item"><a href="{{ route('admin.user.index') }}">Back</a></li>
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
                                <form method="POST" action="{{ route('admin.user.update',$id) }}" autocomplete="off">
                                    @csrf
                                    @method('patch')
                                    <div class="form-group">
                                        <label for="name" class="text-capitalize">Username*</label>
                                        <input type="text" class="form-control" id="username" name="username" value="{{ old('username',$data->username) }}" placeholder="Enter Name">
                                        @error('username')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="password" class="text-capitalize">Password*</label>
                                        <input type="text" class="form-control" id="password" name="password" value="{{ old('password') }}" placeholder="Enter Password">
                                        @error('password')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="role" class="text-capitalize">Role*</label>
                                        <select class="form-control" id="role" name="role">
                                            <option value="" disabled selected>-- Pilih Role --</option>
                                            @foreach(\App\Rules::cases() as $enum)
                                                <option value="{{ $enum->value }}" {{ old('role',$data->role) == $enum->value ? 'selected' : '' }}>
                                                    {{ $enum->label() }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('role')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="role" class="text-capitalize">Employe*</label>
                                        <select class="form-control" id="id_employe" name="id_employe">
                                            <option value="" disabled selected>-- Pilih Role --</option>
                                            @foreach($employes as $employe)
                                                <option value="{{ $employe->UserID }}" {{ old('id_employe',$data->id_employe) == $employe->UserID ? 'selected' : '' }}>
                                                    {{ $employe->UserName }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('id_employe')
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


