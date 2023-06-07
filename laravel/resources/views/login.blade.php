
@extends('layout/layout-common')

@section('space-work')

    <h1>Bejelentkezés</h1>

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <p style="color:red;">{{ $error }}</p>
        @endforeach

    @endif

    @if (Session::has('error'))
            <p style="color: red;">{{ Session::get('error')}}</p>
    @endif


    <form action="{{ route('userLogin')}}" method="POST">
        @csrf

        <input type="email" name="email" placeholder="Írja be az email címét">
        <br><br>
        <input type="password" name="password" placeholder="Írja be a jelszót">
        <br><br>
        <input type="submit" value="Bejelentkezés">

    </form>

    <a href="/forget-password">Elfelejtett jelszó</a>

@endsection
