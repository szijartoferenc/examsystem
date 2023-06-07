@extends('layout/admin-layout')

@section('space-work')

    <h2 class="mb-4">Tantárgyak</h2>

    <!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSubjectModal">
    Tantárgy hozzáadása
  </button>

   <!-- table -->
    <table class="table">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Tantárgy</th>
            <th scope="col">Szerkesztés</th>
            <th scope="col">Törlés</th>
        </tr>
        </thead>
        <tbody>

            @if (count($subjects) > 0)

                @foreach ($subjects as $subject)
                    <tr>
                        <td>{{ $subject->id }}</td>
                        <td>{{ $subject->subject }}</td>
                        <td>
                            <button class="btn btn-info editButton" data-id="{{ $subject->id}}" data-subject="{{$subject->subject}}" data-bs-toggle="modal" data-bs-target="#editSubjectModal">Szerkesztés</button>
                        </td>
                        <td>
                            <button class="btn btn-danger deleteButton" data-id="{{ $subject->id}}" data-bs-toggle="modal" data-bs-target="#deleteSubjectModal">Törlés</button>
                        </td>
                    </tr>

                @endforeach

            @else
                <tr>
                    <td colspan="4">Tantrágy nem található!</td>
                </tr>
            @endif

        </tbody>
    </table>
 <!-- table end -->

  <!-- Modal -->
  <div class="modal fade" id="addSubjectModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <form id="addSubject">
          @csrf
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="exampleModalLabel">Tantárgy</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <label for="">Tantárgy</label>
                <input type="text" name="subject" placeholder="Írja be a tantárgy nevét" required>
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
  <div class="modal fade" id="editSubjectModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <form id="editSubject">
          @csrf
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="exampleModalLabel">Tantárgy szerkesztése</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <label for="">Tantárgy</label>
                <input type="text" name="subject" placeholder="Írja be a tantárgy nevét" id="edit_subject" required>
                <input type="hidden" name="id" id="edit_subject_id">
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bezár</button>
              <button type="submit" class="btn btn-primary">Feltöltés</button>
            </div>
          </div>
      </form>
    </div>
  </div>
 <!-- EditModal end -->

 <!-- DeleteModal -->
 <div class="modal fade" id="deleteSubjectModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">

          <div class="modal-content">
                <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Tantárgy törlése</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="deleteSubject">
                    @csrf
                    <div class="modal-body">
                        <p>Biztosan törli a tantárgyat?</p>
                        <input type="hidden" name="id" id="delete_subject_id">
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bezár</button>
                    <button type="submit" class="btn btn-primary">Törlés</button>
                    </div>
                    </div>
                </form>
        </div>
  </div>
 <!-- DeleteModal end -->






    <script>
       $(document).ready(function(){
        //addSubject
        $("#addSubject").submit (function(e){
                e.preventDefault();

                var formData = $(this).serialize();

                $.ajax({
                    url:"{{ route('addSubject')}}",
                    type:"POST",
                    data:formData,
                    success:function(data){
                        if(data.success == true)
                        {
                            location.reload();
                        }
                        else {
                            alert(data.msg);
                        }
                    }
                });

            });

            //edit Subject
            $(".editButton").click(function(){
                var subject_id = $(this).attr('data-id');
                var subject = $(this).attr('data-subject');
                $("#edit_subject").val(subject);
                $("#edit_subject_id").val(subject_id);
            });

                $("#editSubject").submit (function(e){
                e.preventDefault();

                var formData = $(this).serialize();

                $.ajax({
                    url:"{{ route('editSubject')}}",
                    type:"POST",
                    data:formData,
                    success:function(data){
                        if(data.success == true)
                        {
                            location.reload();
                        }
                        else {
                            alert(data.msg);
                        }
                    }
                });

            });

            //DeleteSubject
            $(".deleteButton").click(function(){
                var subject_id = $(this).attr('data-id');

                $("#delete_subject_id").val(subject_id);
            });

            $("#deleteSubject").submit (function(e){
                e.preventDefault();

                var formData = $(this).serialize();

                $.ajax({
                    url:"{{ route('deleteSubject')}}",
                    type:"POST",
                    data:formData,
                    success:function(data){
                        if(data.success == true)
                        {
                            location.reload();
                        }
                        else {
                            alert(data.msg);
                        }
                    }
                });

        });




       });

    </script>

@endsection
