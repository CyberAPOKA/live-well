<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Relatório de turmas</title>
        <style>
            table {font-family: arial, sans-serif; border-collapse: collapse; width: 100%;}
            td, th {border: solid #dddddd; text-align: center; padding: 10px;}
            .pmsl {float: left;}
            .header {height: 250px;padding-bottom: 10px;}
        </style>
    </head>
    <body>
        <div class="header"><img src="{{asset('img/logo_prefeitura.jpg')}}" class="pmsl"></div>
        <div class="container"><h3>Quantidade total de turmas no relatório: {{count($turmaslist)}}</h3></div>
        <br>
        @foreach ($turmaslist as $turma)
            <div style="border-style: solid; border-color: #999999; border-width: 2px;">
                <h3 style="margin-left: 2%;">Nome: <b>{{$turma->nome}}</b></h3>
                <br>
                <table>
                    <tr>
                        @if($opcoes_colunas[0] == 1)<th>Limite</th>@endif
                        @if($opcoes_colunas[1] == 1)<th>Quantida atual</th>@endif
                        @if($opcoes_colunas[2] == 1)
                            <th style="width: 110px;">Horario inicial</th>
                            <th style="width: 110px;">Horario final</th>
                        @endif
                        @if($opcoes_colunas[3] == 1)<th>Datas semanais</th>@endif
                        @if($opcoes_colunas[4] == 1)<th>Inativo</th>@endif
                    </tr>
                    <tr>
                        @if($opcoes_colunas[0] == 1)<td>{{$turma->limite}}</td>@endif
                        @if($opcoes_colunas[1] == 1)<td>{{$turma->quant_atual}}</td>@endif
                        @if($opcoes_colunas[2] == 1)
                            <td>{{$turma->horario_inicial}}</td>
                            <td>{{$turma->horario_final}}</td>
                        @endif
                        @if(isset($turma->data_semanal))
                            @if($opcoes_colunas[3] == 1)
                                @php 
                                    $datas = explode(',', $turma->data_semanal);
                                @endphp
                                <td>
                                    @foreach ($datas as $data)
                                        {{$data}}<br>
                                    @endforeach
                                </td>
                            @endif
                        @else
                            <td>Não possui</td>
                        @endif
                        @if($opcoes_colunas[4] == 1)
                            <td>@if($turma->inativo == 2) Não @else Sim @endif</td>
                        @endif
                    </tr>
                </table>
            </div>
            <br>
        @endforeach
    </body>
</html>