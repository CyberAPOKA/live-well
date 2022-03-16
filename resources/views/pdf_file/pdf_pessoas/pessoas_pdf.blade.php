<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Relatório de pessoas</title>
        <style>
            table {font-family: arial, sans-serif;border-collapse: collapse;width: 100%;}
            td, th {border: solid #dddddd;text-align: center; padding: 10px;}
            .pmsl {float: left;}
            .header {height: 250px;padding-bottom: 10px;}
        </style>
    </head>
    <body>
        <div class="header"><img src="{{asset('img/logo_prefeitura.jpg')}}" class="pmsl"></div>
        <div class="container"><h3>Quantidade total de pessoas no relatório: {{count($pessoaslist)}}</h3></div>
        <br>
        @foreach ($pessoaslist as $pessoa)
            <div>
                <h3 style="margin-left: 2%;">Nome: <b>{{$pessoa->nome}}</b></h3>
                <table>
                    <tr>
                        @if($opcoes_colunas[0] == 1)<th style="width: 100px;">Endereço</th>@endif
                        @if($opcoes_colunas[1] == 1)<th style="width: 100px;">Telefone</th>@endif
                        @if($opcoes_colunas[2] == 1)<th style="width: 100px;">Data de nascimento</th>@endif
                        @if($opcoes_colunas[3] == 1)<th style="width: 70px;">RG</th>@endif
                        @if($opcoes_colunas[4] == 1)<th style="width: 5px;">Usuário falecido?</th>@endif
                    </tr>
                    <tr>
                        @if($opcoes_colunas[0] == 1)
                            @if(isset($pessoa->bairro))
                                <td>{{$pessoa->bairro}}<br>{{$pessoa->rua}}<br>{{$pessoa->numero_endereco}}</td>
                            @else
                                <td>Não informado</td>
                            @endif
                        @endif
                        @if($opcoes_colunas[1] == 1)
                            @if(isset($pessoa->telefone))
                                <td>{{$pessoa->telefone}}</td>
                            @else
                                <td>Não informado</td>
                            @endif
                        @endif
                        @if($opcoes_colunas[2] == 1)
                            @if(isset($pessoa->nascimento))
                                @php 
                                    $dia_hora = explode(' ', $pessoa->nascimento);
                                    $dia = explode('-',$dia_hora[0]);
                                @endphp
                                <td>{{$dia[1].'/'.$dia[1].'/'.$dia[0]}}</td>
                            @else
                                <td>Não informado</td>
                            @endif
                        @endif
                        @if($opcoes_colunas[3] == 1)
                            @if(isset($pessoa->rg))
                                <td>{{$pessoa->rg}}</td>
                            @else
                                <td>Não informado</td>
                            @endif
                        @endif
                        @if($opcoes_colunas[4] == 1)
                            <td>@if($pessoa->morte == null) Não @else Sim @endif</td>
                        @endif
                    </tr>
                </table>
            </div>
            <br>
        @endforeach
    </body>
</html>