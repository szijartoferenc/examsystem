<!DOCTYPE html>
<html lang="en">

<head>

    <title>{{ $data['title'] }} </title>
</head>
<body>


    <p>
        <b>Üdvözöljük {{ $data['name'] }}</b> ({{ $data['exam_name'] }}) vizsgájának felülvizsgálata sikeres volt.
        Így ellenőrizheti a pontszámait.
    </p>

    <a href="{{$data['url']}}">Eredmény megtekintéséhez kattintson a linkre!</a>
    <p>Köszönjük!</p>

</body>
</html>
