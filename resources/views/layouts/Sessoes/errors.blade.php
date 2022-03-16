@if(isset($errors) && count($errors) > 0)
    @foreach($errors->all() as $error)
        <div style="margin-left: 15%; margin-top: 1%;">
            <div class="chip red lighten-2">
                {{$error}}
                <i class="close material-icons">close</i>
            </div>
        </div>
    @endforeach
@endif