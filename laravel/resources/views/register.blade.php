
@extends('layout/layout-common')

@section('space-work')

    <h1>Regisztráció</h1>

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <p style="color:red;">{{ $error }}</p>
        @endforeach

    @endif


    <form action="{{ route('studentRegister')}}" method="POST">
        @csrf

        <input type="text" name="name" placeholder="Írja be a nevét">
        <br><br>
        <input type="email" name="email" placeholder="Írja be az email címét">
        <br><br>
        <input type="password" name="password" placeholder="Írja be a jelszót">
        <br><br>
        <input type="password" name="password_confirmation" placeholder="Írja be a jelszót mégegyszer">
        <br><br>
        <input type="submit" value="Regisztráció">

    </form>

    @if (Session::has('success'))
            <p style="color: green;">{{ Session::get('success')}}</p>
    @endif

@endsection
