@extends('layout/layout-common')

@section('space-work')
      <div class="container">
            <div class="text-center">
                <h2>Köszönjük, hogy kitöltötte a tesztet, {{Auth::user()->name}}</h2>
                <p>Átnézzük a vizsgáját, és hamarosan email-ben értesítjük!</p>
                <a href="/dashboard" class="btn btn-info">Visszalépés</a>
            </div>
      </div>
@endsection
