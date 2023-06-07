@extends('layout/student-layout')

@section('space-work')

    <h2>Eredmények</h2>
    <table class="table">

        <thead>
            <tr>
                <th>#</th>
                <th>Vizsga</th>
                <th>Eredmények</th>
                <th>Állapot</th>
            </tr>
        </thead>
        <tbody>
            @if (count($attempts) > 0)
                @php $x = 1; @endphp
                @foreach ($attempts as $attempt)
                    <tr>
                        <td>{{ $x++ }}</td>
                        <td>{{ $attempt->exam->exam_name }}</td>
                        <td>
                            @if ($attempt->status == 0)
                                Nincs értékelve
                            @else

                                @if ($attempt->marks >= $attempt->exam->passing_marks)
                                    <span style="color:green">Sikeres</span>
                                @else
                                    <span style="color:red">Sikertelen</span>
                                @endif

                            @endif
                        </td>
                        <td>
                            @if ($attempt->status == 0)
                                <span style="color:red">Függőben</span>
                            @else
                                <a href="#" data-id="{{ $attempt->id }}" class="reviewExam" data-bs-toggle="modal" data-bs-target="#reviewQnAModal">K&V áttekintés</a>
                            @endif
                        </td>

                    </tr>

                @endforeach

            @else
                <td colspan="4">Nem kísérel meg semmilyen vizsgát</td>
            @endif
        </tbody>

    </table>

     <!-- Modal -->
  <div class="modal fade" id="reviewQnAModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
            <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Vizsga áttekintés</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body review-qna">
              A betöltés folyamatban...
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bezár</button>
          </div>
       </div>
    </div>
  </div>
  <!--end Modal -->

  <!-- explain Modal -->
  <div class="modal fade" id="explainationModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
            <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Magyarázat</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
             <p id="explaination"></p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bezár</button>
          </div>
       </div>
    </div>
  </div>
  <!--end Modal -->

  <script>
        $(document).ready(function(){

            $('.reviewExam').click(function(){

                var id = $(this).attr('data-id');

                $.ajax({
                    url:"{{ route('resultStudentQnA') }}",
                    type:"GET",
                    data:{ attempt_id:id },
                    success:function(data){

                        console.log(data);
                        var html = '';

                        if (data.success == true) {
                            console.log(data);
                            var data = data.data;
                            if(data.length > 0){

                                for(let i = 0; i < data.length; i++){

                                    let is_correct = '<span style="color:red;" class="fa fa-close"></span>';

                                    if(data[i]['answers']['is_correct'] == 1) {
                                       is_correct = '<span style="color:green;" class="fa fa-check"></span>';
                                    }


                                    let answer = data[i]['answers']['answer'];

                                    html += `
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <h6>Kérdés(`+(i+1)+`). `+data[i]['question']['question']+`</h6>
                                                    <p>Válasz:-`+answer+` `+is_correct+`</p>`;

                                    if (data[i]['question']['explaination'] != null) {
                                        html += `<p><a href="#" data-explaination="`+data[i]['question']['explaination']+`" class="explaination"  data-bs-toggle="modal" data-bs-target="#explainationModal">Magyarázat</a></p>`;
                                    }

                                    html += `
                                            </div>
                                        </div>


                                    `;


                                }
                            }
                            else{
                                html += `<h6>Nincs folyamatban lévő kérdés!</h6>`
                            }



                        }
                        else{
                            html += `<p>valami probléma van a szerver oldalon</p>`
                        }

                        $('.review-qna').html(html);

                    }

                });

            });

            $(document).on('click','.explaination', function(){
                var explaination = $(this).attr('data-explaination');
                $('#explaination').text(explaination);
            });

        });
  </script>

@endsection
