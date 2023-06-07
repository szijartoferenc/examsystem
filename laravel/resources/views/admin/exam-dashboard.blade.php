@extends('layout/admin-layout')

@section('space-work')

    <h2 class="mb-4">Vizsgák</h2>

    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addExamModal">
        Vizsga hozzáadása
    </button>

    <!-- table -->
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Vizsga</th>
                <th scope="col">Tantárgy</th>
                <th scope="col">Dátum</th>
                <th scope="col">Idő</th>
                <th scope="col">Kísérletek</th>
                <th scope="col">Kérdések hozzáadása</th>
                <th scope="col">Kérdések megtekintése</th>
                <th scope="col">Szerkesztés</th>
                <th scope="col">Törlés</th>
            </tr>
        </thead>
        <tbody>

            @if (count($exams) > 0)
                @foreach ($exams as $exam)
                    <tr>
                        <td>{{ $exam->id }}</td>
                        <td>{{ $exam->exam_name }}</td>
                        <td>{{ $exam->subjects[0]['subject'] }}</td>
                        <td>{{ $exam->date }}</td>
                        <td>{{ $exam->time }} óra</td>
                        <td>{{ $exam->attempt }}</td>
                        <td>
                            <a href="#" class="addQuestion" data-id="{{ $exam->id }}" data-bs-toggle="modal" data-bs-target="#addQnAModal">Kérdések hozzáadása</a>
                        </td>
                        <td>
                            <a href="#" class="showQuestions" data-id="{{ $exam->id }}" data-bs-toggle="modal" data-bs-target="#showQnAModal">Kérdések megtekintése</a>
                        </td>
                        <td>
                            <button class="btn btn-info editButton" data-id="{{ $exam->id }}" data-bs-toggle="modal" data-bs-target="#editExamModal">Szerkesztés</button>
                        </td>
                        <td>
                            <button class="btn btn-danger deleteButton" data-id="{{ $exam->id }}" data-bs-toggle="modal" data-bs-target="#deleteExamModal">Törlés</button>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="5">Vizsga nem található!</td>
                </tr>
            @endif

        </tbody>
    </table>
    <!-- table end -->

    <!-- Modal -->
    <div class="modal fade" id="addExamModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="addExam">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Vizsga</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="text" name="exam_name" placeholder="Írja be a vizsga nevét" class="w-100" required>
                        <br><br>
                        <select name="subject_id" required class="w-100">
                            <option value="">Tantárgy kiválasztása</option>
                            @if (count($subjects) > 0)
                                @foreach ($subjects as $subject)
                                    <option value="{{ $subject->id }}">{{ $subject->subject }}</option>
                                @endforeach
                            @endif
                        </select>
                        <br><br>
                        <input type="date" name="date" class="w-100" required min="@php echo('Y-m-d'); @endphp">
                        <br><br>
                        <input type="time" name="time" class="w-100" required>
                        <br><br>
                        <input type="number" min="1" name="attempt"
                            placeholder="Állítsa be az próbálkozások számát!" class="w-100" required>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bezár</button>
                        <button type="submit" class="btn btn-primary">Hozzáadás</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- Modal end -->

    <!-- EditModal -->
    <div class="modal fade" id="editExamModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">

            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Vizsga szerkesztése</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editExam">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="exam_id" id="exam_id">
                        <input type="text" name="exam_name" id="exam_name" placeholder="Írja be a vizsga nevét"
                            class="w-100" required>
                        <br><br>
                        <select name="subject_id" id="subject_id" required class="w-100">
                            <option value="">Tantárgy kiválasztása</option>
                            @if (count($subjects) > 0)
                                @foreach ($subjects as $subject)
                                    <option value="{{ $subject->id }}">{{ $subject->subject }}</option>
                                @endforeach
                            @endif
                        </select>
                        <br><br>
                        <input type="date" name="date" id="date" class="w-100" required
                            min="@php echo('Y-m-d'); @endphp">
                        <br><br>
                        <input type="time" name="time" id="time" class="w-100" required>
                        <input type="number" min="1" name="attempt" id="attempt"
                            placeholder="Állítsa be az próbálkozások számát!" class="w-100" required>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bezár</button>
                        <button type="submit" class="btn btn-primary">Feltöltés</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
    <!-- EditModal end -->

    <!-- DeleteModal -->
    <div class="modal fade" id="deleteExamModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">

            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Vizsga törlése</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="deleteExam">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="exam_id" id="deleteExamId">
                        <p>Biztos törli a vizsga adatokat?</p>

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

    <!-- Add Answer Modal -->
    <div class="modal fade" id="addQnAModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">

            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">K&V hozzáadás</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addQnA">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="exam_id" id="addExamId">
                        <input type="search" name="search" id="search" onkeyup="searchTable()" class="w-100" placeholder="keresés itt">
                        <br><br>
                        <table class="table" id="questionsTable">
                            <thead>
                                <th>Kiválasztás</th>
                                <th>Kérdések</th>
                            </thead>
                            <tbody class="addBody">

                            </tbody>

                        </table>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bezár</button>
                        <button type="submit" class="btn btn-primary">Hozzáadás K&V</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
    <!-- Modal end -->

     <!-- Show Answer Modal -->
     <div class="modal fade" id="showQnAModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">

            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">K&V megtekintése</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                    <div class="modal-body">
                        <input type="hidden" name="exam_id" id="addExamId">
                        <!-- <input type="search" name="search" id="search" onkeyup="searchTable()" class="w-100" placeholder="keresés itt"> -->
                        <br><br>
                        <table class="table">
                            <thead>
                                <th>Sorszám</th>
                                <th>Kérdések</th>
                                <th>Esemény</th>
                            </thead>
                            <tbody class="showQuestionTable">

                            </tbody>

                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bezár</button>
                        <!-- <button type="submit" class="btn btn-primary">Hozzáadás K&V</button> -->
                    </div>

            </div>

        </div>
    </div>
    <!-- Modal end -->


    <script>
        $(document).ready(function() {
            //addExam
            $("#addExam").submit(function(e) {
                e.preventDefault();

                var formData = $(this).serialize();

                $.ajax({
                    url: "{{ route('addExam') }}",
                    type: "POST",
                    data: formData,
                    success: function(data) {
                        if (data.success == true) {
                            location.reload();
                        } else {
                            alert(data.msg);
                        }
                    }
                });

            });

            //edit exam
            $(".editButton").click(function() {
                var id = $(this).attr('data-id');
                $("#exam_id").val(id);

                var url = '{{ route('getExamDetail', 'id') }}';
                url = url.replace('id', id);

                $.ajax({

                    url: url,
                    type: "GET",
                    success: function(data) {
                        if (data.success == true) {
                            var exam = data.data;
                            $("#exam_name").val(exam[0].exam_name);
                            $("#subject_id").val(exam[0].subject_id);
                            $("#date").val(exam[0].date);
                            $("#time").val(exam[0].time);
                            $("#attempt").val(exam[0].attempt);

                        } else {
                            alert(data.msg);
                        }
                    }

                });

            });

            $("#editExam").submit(function(e) {
                e.preventDefault();

                var formData = $(this).serialize();

                $.ajax({
                    url: "{{ route('updateExam') }}",
                    type: "POST",
                    data: formData,
                    success: function(data) {
                        if (data.success == true) {
                            location.reload();
                        } else {
                            alert(data.msg);
                        }
                    }
                });

            });

            //DeleteExam
            $(".deleteButton").click(function() {
                var id = $(this).attr('data-id');

                $("#deleteExamId").val(id);
            });

            $("#deleteExam").submit(function(e) {
                e.preventDefault();

                var formData = $(this).serialize();

                $.ajax({
                    url: "{{ route('deleteExam') }}",
                    type: "POST",
                    data: formData,
                    success: function(data) {
                        if (data.success == true) {
                            location.reload();
                        } else {
                            alert(data.msg);
                        }
                    }
                });



            });

            //add Question part
            $('.addQuestion').click(function(){

                var id = $(this).attr('data-id');
                $("#addExamId").val(id);

                $.ajax({
                    url: "{{ route('getQuestions') }}",
                    type: "GET",
                    data: {exam_id: id},
                    success: function(data) {
                        if (data.success == true) {
                            // console.log(data);
                            var questions = data.data;
                            var html = '';
                            if (questions.length > 0) {
                                for (let i=0;i<questions.length;i++){
                                    html += `
                                         <tr>
                                            <td><input type="checkbox" value="`+questions[i]['id']+`" name="questions_ids[]"</td>
                                            <td>`+questions[i]['questions']+`</td>
                                         </tr>`;
                                }
                            }
                            else{
                                html +=`
                                    <tr>
                                    <td colspan="2">A kérdések nem elérhetőek!</td>
                                    </tr>`;
                            }

                            $('.addBody').html(html);
                        }
                        else{

                            alert(data.msg);
                        }
                    }
                });

            });

            //Update Examquestions

            $("#addQnA").submit(function(e) {
                e.preventDefault();

                var formData = $(this).serialize();

                $.ajax({
                    url: "{{ route('addQuestions') }}",
                    type: "POST",
                    data: formData,
                    success: function(data) {
                        if (data.success == true) {
                            location.reload();
                        } else {
                            alert(data.msg);
                        }
                    }
                });

            });

            //show Questions
            $('.showQuestions').click(function(){
                var id = $(this).attr('data-id');

                $.ajax({
                    url: "{{ route('getExamQuestions') }}",
                    type: "GET",
                    data: {exam_id:id},
                    success: function(data) {

                        var html = '';
                        var questions = data.data;

                            if (questions.length > 0) {
                                for (let i=0; i<questions.length; i++){
                                    html += `
                                         <tr>
                                            <td>`+(i+1)+`</td>
                                            <td>`+questions[i]['question'][0]['question']+`</td>
                                            <td>
                                                  <button class="btn btn-danger deleteQuestion" data-id="`+questions[i]['id']+`">Törlés</button>
                                            </td>
                                         </tr>
                                    `;
                                }
                            }
                            else{
                                html +=`
                                    <tr>
                                    <td colspan="2">A kérdések nem elérhetőek!</td>
                                    </tr>`;
                            }

                            $('.showQuestionTable').html(html);



                    }

                });

            });

            //
            //delete Question
            $(document).on('click', '.deleteQuestion', function(){

                var id = $(this).attr('data-id');
                var obj = $(this);

                $.ajax({
                    url: "{{ route('deleteExamQuestions') }}",
                    type: "GET",
                    data: {id:id},
                    success: function(data){
                        if (data.success == true) {
                            obj.parent().parent().remove();

                        }
                        else{
                            alert(data.msg);
                        }

                    }

                });
            });



        });
    </script>

    <script>
        function searchTable()
        {

            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById('search');
            filter = input.value.toUpperCase();
            table = document.getElementById('questionsTable');
            tr = table.getElementsByTagName("tr");
            for (let i=0; i<tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[1];
                if(td){

                   txtValue = td.textContent || td.innerText;
                   if(txtValue.toUpperCase().indexOf(filter)> -1){
                        tr[i].style.display = "";
                    }
                    else{
                        tr[i].style.display = "none";
                    }

                }

            }


        }
    </script>

@endsection
