<h3 id="profile" class="title text-center">Il mio Profilo</h3>
<div class="table-responsive">
    <table class="table table-striped summary">
        <tbody>
            <tr>
                <td class="text-right"><b>Nome</b></td>
                <td>{{$user->name}}</td>
            </tr>
            <tr>
                <td class="text-right"><b>E-mail</b></td>
                <td>{{$user->email}}</td>
            </tr>
            <tr>
                <td class="text-right"><b>Tipo di profilo</b></td>
                <td><i>{{$user->role}}</i></td>
            </tr>
            <tr>
                <td class="text-right"><b>Data di iscrizione</b></td>
                <td>{{$date}}</td>
            </tr>
            <tr>
                <td id="reset-psw" class="text-right"><b>Reimposta password</b></td>
                @php
                    $path = Auth::user()->is_admin() ? 'admin' : 'backend';
                @endphp
                <td><a class="btn btn-primary btn-sm" href="{{url($path.'/change-my-pswd')}}">Cambia</a></td>
            </tr>
        </tbody>
    </table>
</div>