@extends('layouts.admin')
@section('content')
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    Projet PFE
                </div>

                <div class="card-body">
                    @if(session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    Nom :    <br>
                    Prenom :     <br>
                    Filiere :   
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                Gestion réservation des salles
                </div>

                <div class="card-body">
                <div class="row mb-3">
                    
                <div class="col-xl-3 col-sm-6 py-2"> <a href="{{ route('admin.users.index') }}">
                    <div class="card bg-success text-white h-100">
                        <div class="card-body bg-success">
                            <div class="rotate">
                                <i class="fa fa-users fa-4x"></i>
                            </div>
                            <h6 class="text-uppercase">Utilisateurs / Demandeurs</h6>
                            <h1 class="display-4">{{ $userCount }}</h1>
                        </div>
                    </div></a>
                </div>
                <div class="col-xl-3 col-sm-6 py-2"> <a href="{{ route('admin.rooms.index') }}">
                    <div class="card text-white bg-danger h-100">
                        <div class="card-body bg-danger">
                            <div class="rotate">
                                <i class="fa fa-list fa-4x"></i>
                            </div>
                            <h6 class="text-uppercase">Salles</h6>
                            <h1 class="display-4">{{ $roomCount }}</h1>
                        </div>
                    </div></a>
                </div>
                <div class="col-xl-3 col-sm-6 py-2"> <a href="{{ route('admin.events.index') }}">
                    <div class="card text-white bg-info h-100">
                        <div class="card-body bg-info">
                            <div class="rotate">
                                <i class="fa fa-calendar fa-4x"></i>
                            </div>
                            <h6 class="text-uppercase">Réunions </h6>
                            <h1 class="display-4">{{ $eventCount }}</h1>
                        </div>
                    </div></a>
                </div>
                <div class="col-xl-3 col-sm-6 py-2"> <a href="{{ route('admin.events.index') }}">
                    <div class="card text-white bg-warning h-100">
                        <div class="card-body">
                            <div class="rotate">
                                <i class="fa fa-calendar fa-4x"></i>
                            </div>
                            <h6 class="text-uppercase">Réunion à venir</h6>
                            <h1 class="display-4">{{ $incomingEventsCount }}</h1>
                        </div>
                    </div> </a>
                </div>
            </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
@parent

@endsection