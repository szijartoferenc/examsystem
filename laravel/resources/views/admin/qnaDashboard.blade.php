@extends('layout/admin-layout')

@section('space-work')
    <h2 class="mb-4">Kérdések&Válaszok</h2>

    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addQnAModal">
        K&V hozzáadása
    </button>
    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#importQnAModal">
        K&V importálása
    </button>

    <!-- table -->
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Kérdések</th>
                <th scope="col">Válaszok</th>
                <th scope="col">Szerkesztés</th>
                <th scope="col">Törlés</th>
            </tr>
        </thead>
        <tbody>

            @if (count($questions) > 0)
                @foreach ($questions as $question)
                    <tr>
                        <td>{{ $question->id }}</td>
                        <td>{{ $question->question }}</td>

                        <td>
                            <a href="#" class="ansButton" data-id="{{ $question->id }}" data-bs-toggle="modal" data-bs-target="#showAnsModal">Válaszok</a>
                        </td>

                        <td>
                            <button class="btn btn-info editButton" data-id="{{ $question->id }}" data-bs-toggle="modal" data-bs-target="#editQnAModal">Szerkesztés</button>
                        </td>

                        <td>
                            <button class="btn btn-danger deleteButton" data-id="{{ $question->id }}" data-bs-toggle="modal" data-bs-target="#deleteQnAModal">Törlés</button>
                        </td>


                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="3">Kérdések és válaszok nem található!</td>
                </tr>
            @endif

        </tbody>
    </table>

    <!-- table end -->

    <!-- Modal -->
    <div class="modal fade" id="addQnAModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">

            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">K&V</h1>
                    <button id="addAnswer" class="ml-5 btn btn-success">Válasz hozzáadás</button>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addQnA">
                    @csrf
                    <div class="modal-body addModalAnswers">
                        <div class="row">
                            <div class="col">
                                <input type="text" class="w-100" name="question" placeholder="Írja be a kérdést">
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col">
                               <textarea name="explaination" class="w-100" placeholder="Írja be a magyarázatot (optionális)"></textarea>
                            </div>
                        </div>


                    </div>
                    <div class="modal-footer">
                        <span class="error" style="color:red;"></span>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bezár</button>
                        <button type="submit" class="btn btn-primary">Hozzáadás</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
    <!-- Modal end -->

    <!-- Edit QnA Modal -->
    <div class="modal fade" id="editQnAModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">

            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">K&V feltöltés</h1>
                    <button id="addEditAnswer" class="ml-5 btn btn-success">Válasz hozzáadás</button>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editQnA">
                    @csrf
                    <div class="modal-body editModalAnswers">
                        <div class="row">
                            <div class="col">
                                <textarea name="explaination" id="explaination" class="w-100" placeholder="Írja be a magyarázatot (optionális)"></textarea>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <input type="hidden" name="question_id" id="question_id">
                                <input type="text" class="w-100" name="question" id="question" placeholder="Írja be a kérdést">
                            </div>
                        </div>


                    </div>
                    <div class="modal-footer">
                        <span class="editError" style="color:red;"></span>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bezár</button>
                        <button type="submit" class="btn btn-primary">Feltöltés</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
    <!-- Edit  QnA Modal end -->

    <!-- ShowModal -->
    <div class="modal fade" id="showAnsModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">

            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Válaszok mutatása</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <table class="table">
                        <thead>
                            <th>#</th>
                            <th>Válasz</th>
                            <th>Megoldás</th>
                        </thead>
                        <tbody class="showAnswers">


                        </tbody>

                    </table>


                </div>
                <div class="modal-footer">
                    <span class="error" style="color:red;"></span>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bezár</button>

                </div>

            </div>

        </div>
    </div>
    <!-- ShowModal end -->


    <!-- DeleteModal -->
    <div class="modal fade" id="deleteQnAModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">

              <div class="modal-content">
                <div class="modal-header">
                  <h1 class="modal-title fs-5" id="exampleModalLabel">K&V törlése</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="deleteQnA">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="id" id="delete_qna_id">
                        <p>Biztos törli a K&V adatokat?</p>

                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bezár</button>
                    <button type="submit" class="btn btn-danger">Törlés</button>
                    </div>
                </form>
              </div>

        </div>
      </div>
    <!-- DeleteModal end -->

     <!-- ImportModal -->
     <div class="modal fade" id="importQnAModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">

              <div class="modal-content">
                <div class="modal-header">
                  <h1 class="modal-title fs-5" id="exampleModalLabel">K&V importálása</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="importQnA" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <input type="file" name="file" id="fileupload" required accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet ,application/vnd.ms.excel">
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bezár</button>
                    <button type="submit" class="btn btn-danger">Importálás</button>
                    </div>
                </form>
              </div>

        </div>
      </div>
    <!-- ImportModal end -->

    <script>
        $(document).ready(function() {

            //form submittion
            $("#addQnA").submit(function(e) {
                e.preventDefault();

                if ($(".answers").length < 2) {
                    $(".error").text("Adjon hozzá minimum 2 választ!")
                    setTimeout(function() {
                        $(".error").text("");
                    }, 2000);

                } else {

                    var checkIsCorrect = false;

                    for (let i = 0; i < $(".is_correct").length; i++) {
                        if ($(".is_correct:eq(" +i+ ")").prop('checked') == true) {
                            checkIsCorrect = true;
                            $(".is_correct:eq(" +i+ ")").val($(".is_correct:eq(" +i+ ")").next().find(
                                'input').val());

                        }


                    }

                    if (checkIsCorrect) {

                        var formData = $(this).serialize();

                        $.ajax({
                            url: "{{ route('addQnA') }}",
                            type: "POST",
                            data: formData,
                            success: function(data) {
                                // console.log(data);
                                if (data.success == true) {
                                    location.reload();
                                } else {
                                    alert(data.msg);
                                }
                            }
                        });


                    }
                    else {
                        $(".error").text("Kérem válassza ki a helyes választ!")
                        setTimeout(function() {
                            $(".error").text("");
                        }, 2000);

                    }
                }

            });
            //addAnswers

            $("#addAnswer").click(function() {

                if ($(".answers").length >= 12) {
                    $(".error").text("Hozzáadhat maximum 12 választ!")
                    setTimeout(function() {
                        $(".error").text("");
                    }, 2000);

                } else {
                    var html = `
                            <div class="row mt-2 answers">
                                    <input type="radio" name="is_correct" class="is_correct">
                                    <div class="col">
                                        <input type="text" class="w-100" name="answers[]" placeholder="Írja be a választ" required>
                                    </div>
                                    <button class="btn btn-danger removeButton">Eltávolítás</button>
                            </div>
                         `;

                    $(".addModalAnswers").append(html);

                }

            });
            //delete answers
            $(document).on("click", ".removeButton", function() {
                $(this).parent().remove();

            });

            //show answers
            $(".ansButton").click(function() {

                var questions = @json($questions);
                var qid = $(this).attr('data-id');
                var html = '';

                for (let i = 0; i < questions.length; i++) {

                    if (questions[i]['id'] == qid) {

                        var answersLength = questions[i]['answers'].length;
                        for (let j = 0; j < answersLength; j++) {
                            let is_correct = 'No';
                            if (questions[i]['answers'][j]['is_correct'] == 1) {
                                is_correct = 'Yes';

                            }


                            html += `
                                <tr>
                                    <td>` + (j + 1) + `</td>
                                    <td>` + questions[i]['answers'][j]['answer'] + `</td>
                                    <td>` + is_correct + `</td>
                                </tr>

                           `;

                        }
                        break;

                    }

                }

                $('.showAnswers').html(html);

            });

            //Edit QnA

            $("#addEditAnswer").click(function() {

                if ($(".editAnswers").length >= 12) {
                    $(".editError").text("Hozzáadhat maximum 12 választ!")
                    setTimeout(function() {
                        $(".editError").text("");
                    }, 2000);

                }
                else {
                    var html = `
                            <div class="row mt-2 editAnswers">
                                    <input type="radio" name="is_correct" class="edit_is_correct">
                                    <div class="col">
                                        <input type="text" class="w-100" name="new_answers[]" placeholder="Írja be a választ" required>
                                    </div>
                                    <button class="btn btn-danger removeButton">Eltávolítás</button>
                            </div>
                        `;

                        $(".editModalAnswers").append(html);

                }

            });

            $(".editButton").click(function(){

                var qid = $(this).attr('data-id');

                $.ajax({
                    url:"{{ route('getQnADetails')}}",
                    type:"GET",
                    data:{qid:qid},
                    success:function(data){
                            console.log(data);

                        var qna = data.data[0];
                        $("#question_id").val(qna['id']);
                        $("#question").val(qna['question']);
                        $("#explaination").val(qna['explaination']);
                        $(".editAnswers").remove();

                        var html = '';

                        for (let i= 0; i< qna['answers'].length; i++) {

                            var checked = '';
                            if (qna['answers'][i]['is_correct'] == 1) {
                                checked = 'checked';

                            }

                            html += `
                                <div class="row mt-2 editAnswers">
                                        <input type="radio" name="is_correct" class="edit_is_correct" `+checked+`>
                                        <div class="col">
                                            <input type="text" class="w-100" name="answers[`+qna['answers'][i]['id']+`]"
                                            placeholder="Írja be a választ" value="`+qna['answers'][i]['answer']+`" required>
                                        </div>
                                        <button class="btn btn-danger removeButton removeAnswer" data-id="`+qna['answers'][i]['id']+`">Eltávolítás</button>
                                </div>

                            `;
                        }
                        $(".editModalAnswers").append(html);

                    }
                });
            });

             //update QnA submittion
             $("#editQnA").submit(function(e) {
                e.preventDefault();

                if ($(".editAnswers").length < 2) {
                    $(".editError").text("Adjon hozzá minimum 2 választ!")
                    setTimeout(function() {
                        $(".editError").text("");
                    }, 2000);

                }
                else {

                    var checkIsCorrect = false;

                    for (let i = 0; i < $(".edit_is_correct").length; i++) {
                        if ($(".edit_is_correct:eq(" +i+ ")").prop('checked') == true)
                        {
                            checkIsCorrect = true;
                            $(".edit_is_correct:eq("+i+")").val($(".edit_is_correct:eq("+i+")").next().find('input').val() );

                        }


                    }

                    if (checkIsCorrect) {
                            //

                            var formData = $(this).serialize();

                            $.ajax({
                            url:"{{route('updateQnA')}}",
                            type:"POST",
                            data:formData,
                            success:function(data){
                                // console.log(data);
                                if (data.success == true) {
                                    location.reload();
                                }
                                else{
                                    alert(data.msg);
                                }
                            }

                        });

                    }
                    else {
                        $(".editError").text("Kérem válassza ki a helyes választ!")
                        setTimeout(function() {
                            $(".editError").text("");
                        }, 2000);

                    }
                }

            });

            //remove Answer
            $(document).on('click','.removeAnswer', function(){

                var ansId = $(this).attr('data-id');

                $.ajax({
                    url:"{{route('deleteAns')}}",
                    type:"GET",
                    data:{ id:ansId},
                    success:function(data){
                        if (data.success == true) {
                            console.log(data.msg)
                        }
                        else{
                            alert(data.msg);
                        }
                    }

                });
            });

            //delete QnA
            $('.deleteButton').click(function(){
                var id = $(this).attr('data-id');
                $('#delete_qna_id').val(id);

            });

            $('#deleteQnA').submit(function(e){
                e.preventDefault();

                var formData = $(this).serialize();

                $.ajax({
                    url:"{{route('deleteQnA')}}",
                    type:"POST",
                    data:formData,
                    success:function(data){
                        if(data.success == true){
                            location.reload();
                        }
                        else{
                            alert(data.msg);
                        }
                    }


                });


            });

            //import QnA
            $('#importQnA').submit(function(e){
                e.preventDefault();

                let formData = new FormData();

                formData.append("file", fileupload.files[0]);

                $.ajaxSetup({
                    headers:{
                        "X-CSRF-TOKEN":"{{ csrf_token() }}"
                    }
                });

                $.ajax({
                    url:"{{route('importQnA')}}",
                    type:"POST",
                    data:formData,
                    processData:false,
                    contentType:false,
                    success:function(data){
                        // console.log(data);
                        if(data.success == true){

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
