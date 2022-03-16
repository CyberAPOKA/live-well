@extends('layouts.app')
@section('breadcrumbs')
    <a href="{{route('home')}}" class="breadcrumb">Home</a>
@endsection
@section('title') Página principal @endsection
@section('content')
    <div class='container'>
        <div class='card-panel'>
            <div class='row'>
                <a href="{{route('professor.index')}}">
                    <div class="col s12 m6 l4">
                        <div class="card hoverable red darken-4" style="border-radius: 25px;">
                            <div class="card-content black-text center-align">
                                <i class='large material-icons'>local_library</i>
                            </div>
                            <div class="card-action white-text" style="border-radius: 25px;">
                                <span class='card-title'>Professores</span>
                            </div>
                        </div>
                    </div>
                </a>
                <a href="{{route('pessoas.index')}}">
                    <div class="col s12 m6 l4">
                        <div class="card hoverable green darken-4" style="border-radius: 25px;">
                            <div class="card-content black-text center-align">
                                <i class='large material-icons'>people</i>
                            </div>
                            <div class="card-action white-text" style="border-radius: 25px;">
                                <span class='card-title'>Pessoas</span>
                            </div>
                        </div>
                    </div>
                </a>
                <a href="{{route('anamneses.index')}}">
                    <div class="col s12 m6 l4">
                        <div class="card hoverable blue darken-4" style="border-radius: 25px;">
                            <div class="card-content black-text center-align">
                                <i class='large material-icons'>add_box</i>
                            </div>
                            <div class="card-action white-text" style="border-radius: 25px;">
                                <span class='card-title'>Anamneses</span>
                            </div>
                        </div>
                    </div>
                </a>
                <a href="{{route('doencas.index')}}">
                    <div class="col s12 m6 l4">
                        <div class="card hoverable yellow darken-3" style="border-radius: 25px;">
                            <div class="card-content black-text center-align">
                                <i class='large material-icons'>warning</i>
                            </div>
                            <div class="card-action white-text" style="border-radius: 25px;">
                                <span class='card-title'>Doenças</span>
                            </div>
                        </div>
                    </div>
                </a>
                <a href="{{route('turmas.index')}}">
                    <div class="col s12 m6 l4">
                        <div class="card hoverable pink darken-1" style="border-radius: 25px;">
                            <div class="card-content black-text center-align">
                                <i class='large material-icons'>art_track</i>
                            </div>
                            <div class="card-action white-text" style="border-radius: 25px;">
                                <span class='card-title'>Turmas</span>
                            </div>
                        </div>
                    </div>
                </a>
                <a href="{{route('nucleos.index')}}">
                    <div class="col s12 m6 l4">
                        <div class="card hoverable grey darken-2" style="border-radius: 25px;">
                            <div class="card-content black-text center-align">
                                <i class='large material-icons'>filter_tilt_shift</i>
                            </div>
                            <div class="card-action white-text" style="border-radius: 25px;">
                                <span class='card-title'>Núcleos</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
@endsection
