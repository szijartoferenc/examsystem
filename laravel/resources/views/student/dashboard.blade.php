@extends('layout/student-layout')

@section('space-work')
<h2>Vizsga</h2>

    <table class="table">

        <thead>
            <th>#</th>
            <th>Vizsga neve</th>
            <th>Tantárgy</th>
            <th>Dátum</th>
            <th>Idő</th>
            <th>Teljes próbálkozások</th>
            <th>Elérhető próbálkozások</th>
            <th>Link</th>
        </thead>
        <tbody>
            @if (count($exams)> 0)
                @php $count = 1;  @endphp
                @foreach ($exams as $exam)
                    <tr>
                        <td style="display:none;">{{ $exam->id }}</td>
                        <td>{{$count++}}</td>
                        <td>{{$exam->exam_name}}</td>
                        <td>{{$exam->subjects[0]['subjects']}}</td>
                        <td>{{$exam->date}}</td>
                        <td>{{$exam->time}}</td>
                        <td>{{$exam->attempt}}</td>
                        <td>{{$exam->attempt_counter}}</td>
                        <td><a href="#" data-code="{{$exam->enterance_id}}" class="copy"><i class="fa fa-copy"></i></a></td>
                    </tr>

                @endforeach

            @else
                <tr>
                    <td colspan="8">Vizsgák nem elérhetőek</td>
                </tr>
            @endif


        </tbody>

    </table>

    <script>
        $(document).ready(function(){

            $('.copy').click(function(){
                $(this).parent().prepend('<span class="copied_text">Copied</span>');

                var code = $(this).attr('data-code');
                var url = "{{URL::to('/')}}/exam/"+code;

                var $temp = $("<input>");
                $("body").append($temp);
                $temp.val(url).select();
                document.execCommand("copy");
                $temp.remove();

                setTimeout(() => {
                    $('.copied_text').remove();
                }, 1000);
            });
        });
    </script>

@endsection
