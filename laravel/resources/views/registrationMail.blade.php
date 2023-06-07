<!DOCTYPE html>
<html lang="en">

<head>

    <title>{{ $data['title'] }} </title>
</head>
<body>

    <table>
        <tr>
            <th>Név</th>
            <th>{{ $data['name'] }} </th>
        </tr>
        <tr>
            <th>Email</th>
            <th>{{ $data['email'] }} </th>
        </tr>
        <tr>
            <th>Jelszó</th>
            <th>{{ $data['password'] }}    </th>
        </tr>
    </table>

    <a href="{{ $data['url'] }}">A bejelentkezéshez kattintson a linkre!</a>
    <p>Köszönjük!</p>

</body>
</html>
