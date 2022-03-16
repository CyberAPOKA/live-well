@if(Session::get('quant'))
    <div class="center-align quantmens">
        <div class="chip light-blue accent-2 lighten-2">
            {{Session::get('quant')}}
            <i class="close material-icons">close</i>
        </div>
    </div>
    {{Session::forget('quant')}}
@endif