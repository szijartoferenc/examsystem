
@extends('layout/layout-common')

@section('space-work')

    <h1>Jelszó csere</h1>

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <p style="color:red;">{{ $error }}</p>
        @endforeach

    @endif

    @if (Session::has('error'))
            <p style="color: red;">{{ Session::get('error')}}</p>
    @endif

    @if (Session::has('success'))
            <p style="color: green;">{{ Session::get('success')}}</p>
    @endif


    <form action="{{ route('resetPassword')}}" method="POST">
        @csrf
        <input type="hidden" name="id" value="{{ $user[0]['id']}}">
        <input type="password" name="password" placeholder="Írja be a jelszót">
        <br><br>
        <input type="password" name="password_confirmation" placeholder="Írja be a jelszót mégegyszer">
        <br><br>
        <input type="submit" value="Jelszócsere">

    </form>

    <a href="/">Bejelentkezés</a>

@endsection
