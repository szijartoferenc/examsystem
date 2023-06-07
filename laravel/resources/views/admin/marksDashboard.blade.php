@extends('layout/admin-layout')

@section('space-work')
    <h2 class="mb-4">Pontszámok</h2>

     <!-- Button trigger modal -->


    <!-- table -->
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Vizsga neve</th>
                <th scope="col">Pontszám/Kérdés</th>
                <th scope="col">Összes pontszám</th>
                <th scope="col">Sikeres vizsgapont</th>
                <th scope="col">Szerkesztés</th>

            </tr>
        </thead>
        <tbody>

            @if (count($exams) > 0)
            @php $x = 1; @endphp
                @foreach ($exams as $exam)
                    <tr>
                        <td>{{ $x++ }}</td>
                        <td>{{ $exam->exam_name }}</td>
                        <td>{{ $exam->marks }}</td>
                        <td>{{ count($exam->getQnAExam) * $exam->marks }}</td>
                        <td>{{$exam->passing_marks}}</td>
                        <td>
                            <button class="btn btn-primary editMarks" data-id="{{ $exam->id }}" data-passing-marks="{{ $exam->passing_marks }}" data-marks="{{ $exam->marks }}" data-totalq="{{ count($exam->getQnAExam) }}" data-bs-toggle="modal" data-bs-target="#editMarksModal">Szerkesztés</button>
                        </td>
                    </tr>

                @endforeach
            @else
                <tr>
                    <td colspan="5">Vizsga nincs hozzáadva</td>
                </tr>
            @endif
        </tbody>
    </table>

    <!-- Modal -->
    <div class="modal fade" id="editMarksModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="editMarks">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Vizsga</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mt-2">
                            <div class="col-sm-4">
                                <label>Pontszám/kérdés</label>
                            </div>
                            <div class="col-sm-4">
                                <input type="hidden" name="exam_id" id="exam_id">
                                <input type="text"
                                    onkeypress="return event.charCode >=48 && event.charCode<=57 || event.charCode == 46"
                                name="marks" placeholder="Írja be a pontszámot" id="marks" required>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-sm-4">
                                <label>Összes pontszám</label>
                            </div>
                            <div class="col-sm-6">
                                <input type="text" disabled placeholder="Összes pontszám" id="tmarks">
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-sm-4">
                                <label>Sikeres vizsga pontszám</label>
                            </div>
                            <div class="col-sm-6">
                                <input type="text"
                                onkeypress="return event.charCode >=48 && event.charCode<=57 || event.charCode == 46"
                                name="passing_marks" placeholder="Írja be a minimum pontszámot" id="passing_marks" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bezár</button>
                        <button type="submit" class="btn btn-primary">Pontszám feltöltése</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- Modal end -->

    <script>
        $(document).ready(function(){
            var totalQnA = 0;
            $('.editMarks').click(function(){

                var exam_id = $(this).attr('data-id');
                var marks = $(this).attr('data-marks');
                var totalq = $(this).attr('data-totalq');

                $('#marks').val(marks);
                $('#exam_id').val(exam_id);
                $('#tmarks').val((marks*totalq).toFixed(1));

                totalQnA = totalq;

                $('#passing_marks').val($(this).attr('data-passing-marks'))
            });

            $('#marks').keyup(function(){

                $('#tmarks').val( ($(this).val()*totalQnA).toFixed(1));
            });

            $('#passing_marks').keyup(function(){

                $('.pass-error').remove();
                var tmarks = $('#tmarks').val();
                var pmarks = $(this).val();

                if (parseFloat(pmarks) >= parseFloat(tmarks)) {

                    $(this).parent().append('<p style="color:red;" class="pass-error">A pontszám több, mint a teljes pontszám</p>');
                    setTimeout(() => {
                        $('.pass-error').remove();
                    }, 2000);
                }

            });

            $('#editMarks').submit(function(event){
                event.preventDefault();

                $('.pass-error').remove();
                var tmarks = $('#tmarks').val();
                var pmarks = $('passing_marks').val();

                if (parseFloat(pmarks) >= parseFloat(tmarks)) {

                    $('#passing_marks').parent().append('<p style="color:red;" class="pass-error">A pontszám több, mint a teljes pontszám</p>');
                    setTimeout(() => {
                        $('.pass-error').remove();
                    }, 2000);

                    return false;
                }

                var formData = $(this).serialize();

                $.ajax({
                    url:"{{route('updateMarks')}}",
                    type:"POST",
                    data:formData,
                    success:function(data){
                        if (data.success == true) {
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
