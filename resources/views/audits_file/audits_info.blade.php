@extends('layouts.app')
@section('css.personalizado')<link rel="stylesheet" href="{{asset('css/table_audits.css')}}">@endsection
@section('breadcrumbs')
    <a href="{{route('home')}}" class="breadcrumb">Home</a>
    <a href="{{route('audits.index')}}" class="breadcrumb">Auditorias</a>
    <a href="{{route('audits_info', $audit->id)}}" class="breadcrumb">Informações</a>
@endsection
@section('title') Informações de auditoria @endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col s5">
                <table>
                    <tr>
                        <td><h6>User id:</h6></td>
                        <td><h6>{{$audit->user_id}}</h6></td>
                    </tr>
                    <tr>
                        <td><h6>Auditable id:</h6></td>
                        <td><h6>{{$audit->auditable_id}}</h6></td>
                    </tr>
                    <tr>
                        <td><h6></h6>User Type:</td>
                        <td><h6>{{$audit->user_type}}</h6></td>
                    </tr>
                    <tr>
                        <td><h6>Auditable Type:</h6></td>
                        <td><h6>{{$audit->auditable_type}}</h6></td>
                    </tr>
                    <tr>
                        <td><h6>Evento:</h6></td>
                        <td><h6>{{$audit->event}}</h6></td>
                    </tr>
                    <tr>
                        <td><h6>Ip address:</h6></td>
                        <td><h6>@if($audit->ip_address == '::1') Localhost @else {{$audit->ip_address}} @endif</h6></td>
                    </tr>
                </table>
            </div>
            <div class="col s7">
                <table>
                    <tr>
                        <td><h6>URL:</h6></td>
                        <td><h6>{{$audit->url}}</h6></td>
                    </tr>
                    <tr>
                        <td><h6>Tags:</h6></td>
                        <td><h6>@if($audit->tags == null) Nenhuma tag comentada @else {{$audit->tags}} @endif</h6></td>
                    </tr>
                    <tr>
                        <td><h6>Old value:</h6></td>
                        <td>
                            <h6>
                                @if($audit->old_values == '[]') 
                                    nenhum valor substituido 
                                @else
                                    {{substr($audit->old_values, 0, 40)}}
                                    {{substr($audit->old_values, 40, 53)}} 
                                @endif
                            </h6>
                        </td>
                    </tr>
                    <tr>
                        <td><h6>New value:</h6></td>
                        <td>
                            <h6>
                                @if($audit->new_values == '[]') 
                                    nenhum valor criado 
                                @else
                                    {{substr($audit->new_values, 0, 40)}}
                                    {{substr($audit->new_values, 40, 53)}} 
                                @endif
                            </h6>
                        </td>
                    </tr>
                    <tr>
                        <td><h6>User agent:</h6></td>
                        <td><h6>{{$audit->user_agent}}</h6></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@endsection