@extends('component.app')

@section('content')
    <style>
        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            background-color: rgba(0, 0, 0, 0.5); /* Tambahkan background agar lebih terlihat */
            border-radius: 100%; /* Untuk tampilan ikon yang lebih rapi */

        }

        .carousel-control-prev,
        .carousel-control-next {
            border: none; /* Menghapus border */
            background: none; /* Menghapus background jika ada */
        }
        .card {
            height: 90%;
        }
        .custom-width {
            width: 100%;
            max-width: 250px;
        }
        @media (max-width: 576px) {
            .custom-width {
                width: 100%;
                max-width: 576px;
            }
        }
    </style>
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0"> <small>{{$title}}</small></h1>
                    </div>

                </div>
            </div>
        </div>

        <div class="content">
            <div class="row justify-content-center  col-12">
                <!-- Card 1 -->
                <div class="col-md-6 col-lg-5 mb-5 ">
                    <div class="row justify-content-center">
                        @canany([\App\Rules::AdminSales->value,\App\Rules::Administrator->value])
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title mb-4 text-bold text-secondary" style="width:100%;"><i class="fa fa-qrcode" aria-hidden="true"></i> Upload Data Planning</h5>
                                    <a href="{{ route('transaction.index') }}" type="button" class="btn btn-outline-primary custom-width">
                                        Upload Data Planning  <i class="fa fa-qrcode" aria-hidden="true"></i>
                                    </a>
                                </div>

                            </div>
                        </div>
                        @endcanany
                          @canany([\App\Rules::AdminWarehouse->value,\App\Rules::Administrator->value])

                            <div class="col-sm-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title mb-4 text-bold text-secondary" style="width:100%;"><i class="fa fa-qrcode" aria-hidden="true"></i> Data Planning</h5>
                                    <a href="{{ route('transaction.view') }}" type="button" class="btn btn-outline-primary custom-width">
                                        Data Planning  <i class="fa fa-qrcode" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                            @endcanany
                            @canany([\App\Rules::Checker1->value,\App\Rules::Administrator->value])

                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title mb-4 text-bold text-secondary" style="width:100%;"><i class="fa fa-qrcode" aria-hidden="true"></i> Checker 1</h5>
                                    <a href="{{ route('checker.index') }}" type="button" class="btn btn-outline-primary custom-width" >
                                        Checker 1 <i class="fa fa-qrcode" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                            @endcanany
                            @canany([\App\Rules::Checker2->value,\App\Rules::Administrator->value])

                            <div class="col-sm-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title mb-4 text-bold text-secondary" style="width:100%;"><i class="fa fa-qrcode" aria-hidden="true"></i> Checker 2</h5>
                                    <a href="{{ route('checkertwo.index') }}" type="button" class="btn btn-outline-primary custom-width" >
                                        Checker 2 <i class="fa fa-qrcode" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                            @endcanany
                            @canany([\App\Rules::Checker3->value,\App\Rules::Administrator->value])

                            <div class="col-sm-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title mb-4 text-bold text-secondary" style="width:100%;"><i class="fa fa-qrcode" aria-hidden="true"></i> Checker 3</h5>
                                    <a href="{{ route('checkerthree.index') }}" type="button" class="btn btn-outline-primary custom-width" >
                                        Checker 3 <i class="fa fa-qrcode" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                            @endcanany
                    </div>
                </div>
            </div>

            <!-- Carousel Section -->
            <div class="content d-flex justify-content-center col-12">
                <div class="card text-white  col-5">
                    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                        </ol>
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="{{ asset('assets/backend/dist/img/tools.png') }}" class="d-block w-100" alt="...">
                            </div>
                            <div class="carousel-item">
                                <img src="{{ asset('assets/backend/dist/img/window.png') }}" class="d-block w-100" alt="...">
                            </div>
                            <div class="carousel-item">
                                <img src="{{ asset('assets/backend/dist/img/enc.png') }}" class="d-block w-100" alt="...">
                            </div>
                        </div>
                        <button class="carousel-control-prev" data-target="#carouselExampleIndicators" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-target="#carouselExampleIndicators" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
