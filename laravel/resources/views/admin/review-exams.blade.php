@extends('layout/admin-layout')

@section('space-work')
    <h2 class="mb-4">Hallgatói vizsgák</h2>

   <!-- table -->
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Név</th>
                <th scope="col">Vizsga</th>
                <th scope="col">Státusz</th>
                <th scope="col">Esemény</th>
            </tr>
        </thead>
        <tbody>

                @if (count($attempts)> 0)
                    @php $x = 1;   @endphp
                    @foreach ($attempts as $attempt)

                        <tr>
                            <td>{{ $x++ }}</td>
                            <td>{{ $attempt->user->name }}</td>
                            <td>{{ $attempt->exam->exam_name }}</td>
                            <td>
                                @if ($attempt->status == 0)
                                    <span style="color:red">Folyamatban</span>
                                @else
                                    <span style="color:green">Elfogadva</span>
                                @endif
                            </td>
                            <td>
                                @if ($attempt->status == 0)
                                    <a href="" class="reviewExam" data-id="{{$attempt->id}}" data-bs-toggle="modal" data-bs-target="#reviewExamModal">Felülvizsgálat</a>
                                @else
                                    Befejezve
                                @endif
                            </td>
                        </tr>

                    @endforeach

                @else
                    <tr>
                        <td>A tanulók nem próbálnak vizsgát tenni!</td>
                    </tr>
                @endif
        </tbody>
    </table>


  <!-- Modal -->
  <div class="modal fade" id="reviewExamModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Vizsga felülvizsgálat</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="reviewForm">
            @csrf
            <input type="hidden" name="attempt_id" id="attempt_id">
            <div class="modal-body review-exam">
              A betöltés folyamatban...
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bezár</button>
              <button type="submit" class="btn btn-primary approved-btn">Elfogadva</button>
            </div>
        </form>
      </div>
    </div>
  </div>
  <!--end Modal -->

  <script type="text/javascript">
    $(document).ready(function(){

        $('.reviewExam').click(function(){

            var id = $(this).attr('data-id');
            $('#attempt_id').val(id);

            $.ajax({
                url:"{{route('reviewQnA')}}",
                type:"GET",
                data:{attempt_id: id},
                success:function(data){

                    var html = '';

                    if (data.success == true) {

                        var data = data.data;
                        if(data.length > 0){

                            for (let i = 0; i < data.length; i++) {

                                let isCorrect = '<span style="color:red;" class="fa fa-close"></span>';

                                if(data[i]['answers']['is_correct'] == 1) {
                                    isCorrect = '<span style="color:green;" class="fa fa-check"></span>';
                                }

                                let answer = data[i]['answers']['answer'];

                                html += `
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <h6>Kérdés(`+(i+1)+`). `+data[i]['question']['question']+`</h6>
                                                <p>Válasz:-`+answer+` `+isCorrect+`</p>
                                            </div>
                                        </div>
                                `;

                            }

                        }
                        else{
                            html += `<h6>A hallgató nem tesz fel kérdéseket!</h6>
                                    <p>Ha elfogadja a hallgató vizsgája sikertelen</p>`;
                        }

                    }
                    else{
                        html += `<p>Szerverprobléma található</p>`;
                    }

                    $('.review-exam').html(html);
                }
            });

        });

        //Vizsga elfogadása
        $('#reviewForm').submit(function(event){
            event.preventDefault();

            $('.approved-btn').html('Kérem várjon <i class="fa fa-spinner"></i>');

            var formData = $(this).serialize();

            $.ajax({
                url:"{{ route('approvedQnA') }}",
                type:"POST",
                data:formData,
                success:function(data){
                    // console.log(data);
                    if(data.success == true) {
                        location.reload();

                    }
                    else{
                        alert(data.msg);

                    }

                }

            });

        });

    });
  </script>

@endsection
