<!DOCTYPE html>
<html lang="en">

<head>
    <title>

        {{ $data['title'] }}

    </title>

</head>

<table>
        <tr>
            <th>Név</th>
            <th>{{ $data['name'] }} </th>
        </tr>
        <tr>
            <th>Email</th>
            <th>{{ $data['email'] }} </th>
        </tr>

    </table>

    <p><b>Megjegyzés:</b>Használhatja a régi jelszavát</p>
    <a href="{{ $data['url'] }}">A bejelentkezéshez kattintson a linkre!</a>
    <p>Köszönjük!</p>


</body>
</html>
