@extends('layout/admin-layout')

@section('space-work')
    <h2 class="mb-4">Hallgatók</h2>

     <!-- Button trigger modal -->
     <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addStudentModal">
        Hallgató hozzáadása
    </button>
    <a href="{{route('exportStudents')}}" class="btn btn-warning">Hallgatók exportálása</a>

    <!-- table -->
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Név</th>
                <th scope="col">Email</th>
                <th scope="col">Szerkesztés</th>
                <th scope="col">Törlés</th>

            </tr>
        </thead>
        <tbody>

            @if (count($students) > 0)
                @foreach ($students as $student)
                    <tr>
                        <td>{{ $student->id }}</td>
                        <td>{{ $student->name }}</td>
                        <td>{{ $student->email }}</td>

                        <td>
                            <button class="btn btn-info editButton" data-id="{{ $student->id }}" data-name="{{$student->name}}" data-email="{{$student->email}}" data-bs-toggle="modal" data-bs-target="#editStudentModal">Szerkesztés</button>
                        </td>

                        <td>
                            <button class="btn btn-danger deleteButton" data-id="{{ $student->id }}"  data-bs-toggle="modal" data-bs-target="#deleteStudentModal">Törlés</button>
                        </td>


                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="3">Hallgatók nem található!</td>
                </tr>
            @endif

        </tbody>
    </table>

    <!-- table end -->

    <!-- Modal -->
    <div class="modal fade" id="addStudentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">

            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel"></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addStudent">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col">
                                <input type="text" class="w-100" name="name" placeholder="Írja be a hallgató nevét">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col">
                               <input type="email" class="w-100" name="email" placeholder="Írja be a hallgató email címét">
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
    <div class="modal fade" id="editStudentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">

            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Szerkesztés</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editStudent">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col">
                                <input type="hidden" name="id" id="id">
                                <input type="text" class="w-100" name="name" id="name" placeholder="Írja be a hallgató nevét">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col">
                               <input type="email" class="w-100" name="email" id="email" placeholder="Írja be a hallgató email címét">
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <span class="error" style="color:red;"></span>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bezár</button>
                        <button type="submit" class="btn btn-primary">Feltöltés</button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <!-- Edit  QnA Modal end -->

    <!-- ShowModal -->

    <!-- ShowModal end -->


    <!-- DeleteModal -->
<div class="modal fade" id="deleteStudentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">

            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Törlés</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="deleteStudent">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col">
                                <p>Biztos törölni akarja az adatot?</p>
                                <input type="hidden" name="id" id="student_id">

                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <span class="error" style="color:red;"></span>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bezár</button>
                        <button type="submit" class="btn btn-danger">Törlés</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
    <!-- DeleteModal end -->

     <!-- ImportModal -->

    <!-- ImportModal end -->

    <script>
        $(document).ready(function() {
            $("#addStudent").submit(function(e){
                e.preventDefault();

                var formData = $(this).serialize();

                $.ajax({
                    url:"{{route('addStudent')}}",
                    type:"POST",
                    data:formData,
                    success:function(data){
                        // console.log(data)
                        if(data.success == true){
                            location.reload();
                        }
                        else{
                            alert(data.msg);
                        }
                    }

                });

            });

            //Edit button
            $(".editButton").click(function(){

                $("#id").val( $(this).attr('data-id'));
                $("#name").val( $(this).attr('data-name'));
                $("#email").val( $(this).attr('data-email'));

            });

            $("#editStudent").submit(function(e){
                e.preventDefault();
                $('.updateButton').prop('disabled', true);

                var formData = $(this).serialize();

                $.ajax({
                    url:"{{route('editStudent')}}",
                    type:"POST",
                    data:formData,
                    success:function(data){
                        // console.log(data)
                        if(data.success == true){
                            location.reload();
                        }
                        else{
                            alert(data.msg);
                        }
                    }

                });

            });

            //delete button
            $(".deleteButton").click(function(){
                var id = $(this).attr('data-id');
                $("#student_id").val(id);
            });

            $("#deleteStudent").submit(function(e){
                e.preventDefault();
                var formData = $(this).serialize();

                $.ajax({
                    url:"{{route('deleteStudent')}}",
                    type:"POST",
                    data:formData,
                    success:function(data){
                        // console.log(data)
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
