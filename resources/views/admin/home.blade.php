@extends('admin.layout.admin')

@section('content')
    <div class="row">
        <div class="col-lg-12 grid-margin">
            <div class="card performance-cards">
                <div class="card-body">
                    <div class="row">
                        <div class="col d-flex flex-row justify-content-center align-items-center">
                            <div class="wrapper icon-circle bg-success">
                                <i class="icon-rocket icons"></i>
                            </div>
                            <div class="wrapper text-wrapper">
                                <p class="text-dark">8954</p>
                                <p>Lifetime total sales</p>
                            </div>
                        </div>
                        <div class="col d-flex flex-row justify-content-center align-items-center">
                            <div class="wrapper icon-circle bg-danger">
                                <i class="icon-briefcase icons"></i>
                            </div>
                            <div class="wrapper text-wrapper">
                                <p class="text-dark">7841</p>
                                <p>Income amounts</p>
                            </div>
                        </div>
                        <div class="col d-flex flex-row justify-content-center align-items-center">
                            <div class="wrapper icon-circle bg-warning">
                                <i class="icon-umbrella icons"></i>
                            </div>
                            <div class="wrapper text-wrapper">
                                <p class="text-dark">6521</p>
                                <p>Total users</p>
                            </div>
                        </div>
                        <div class="col d-flex flex-row justify-content-center align-items-center">
                            <div class="wrapper icon-circle bg-primary">
                                <i class="icon-check icons"></i>
                            </div>
                            <div class="wrapper text-wrapper">
                                <p class="text-dark">325</p>
                                <p>Total visits</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection