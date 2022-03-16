<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Relatório de núcleos</title>
        <style>
            table {font-family: arial, sans-serif;border-collapse: collapse;width: 100%;}
            td, th {border: solid #dddddd;text-align: center; padding: 10px;}
            .pmsl {float: left;}
            .header {height: 250px;padding-bottom: 10px;}
        </style>
    </head>
    <body>
        <div class="header"><img src="{{asset('img/logo_prefeitura.jpg')}}" class="pmsl"></div>
        <div class="container"><h3>Quantidade total de núcleos no relatório: {{count($nucleoslist)}}</h3></div>
        <br>
        @foreach ($nucleoslist as $nucleo)
            <div style="border-style: solid; border-color: #999999; border-width: 2px;">
                <h3 style="margin-left: 2%;">Nome: <b>{{$nucleo->nome}}</b></h3>
                <br>
                <table>
                    <tr>
                        @if($opcoes_colunas[0] == 1)<th>Cidade</th>@endif
                        @if($opcoes_colunas[1] == 1)<th>Bairro</th>@endif
                        @if($opcoes_colunas[2] == 1)<th>Rua</th>@endif
                        @if($opcoes_colunas[3] == 1)<th style="width: 90px;">Número de endereço</th>@endif
                        @if($opcoes_colunas[4] == 1)<th>CEP</th>@endif
                        @if($opcoes_colunas[5] == 1)<th>Inativo</th>@endif
                    </tr>
                    <tr>
                        @if($opcoes_colunas[0] == 1)<td>{{$nucleo->cidade}}</td>@endif
                        @if($opcoes_colunas[1] == 1)<td>{{$nucleo->bairro}}</td>@endif
                        @if($opcoes_colunas[2] == 1)<td>{{$nucleo->rua}}</td>@endif
                        @if($opcoes_colunas[3] == 1)<td>{{$nucleo->numero_endereco}}</td>@endif
                        @if($opcoes_colunas[4] == 1)<td>{{$nucleo->cep}}</td>@endif
                        @if($opcoes_colunas[5] == 1)
                            <td>@if($nucleo->inativo == 2) Não @else Sim @endif</td>
                        @endif
                    </tr>
                </table>
            </div>
            <br>
        @endforeach
    </body>
</html>