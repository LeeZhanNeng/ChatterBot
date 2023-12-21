@extends('layout')

@section('content') 
    <div class="lecturer">
    <p>Category</p>

        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSubjectModal">
            Add Category
        </button>

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Category</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $x = 1;
                @endphp
                @forelse($subjects as $subject)
                    <tr>
                        <td>{{ $x++ }}</td>
                        <td>{{ $subject->subject }}</td>
                        <td>
                            <button class="btn btn-info editButton"  data-id="{{ $subject->id }}" data-subject="{{ $subject->subject }}" data-bs-toggle="modal" data-bs-target="#editSubjectModal" style="margin-right: .25rem;">Edit</button>
                            <button class="btn btn-danger deleteButton"  data-id="{{ $subject->id }}" data-bs-toggle="modal" data-bs-target="#deleteSubjectModal" style="margin-left: .25rem;">Delete</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3">Category Not Found!</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Create Subject -->
    <div class="modal fade" id="addSubjectModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fs-5" id="exampleModalLabel">Add Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addSubject">@csrf
                    <div class="modal-body subject">
                        <label>Category</label>
                        <input type="text" name="subject" placeholder="Enter Subject Name" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Subject -->
    <div class="modal fade" id="editSubjectModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fs-5" id="exampleModalLabel">Edit Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editSubject">@csrf
                    <div class="modal-body subject">
                        <label>Category</label>
                        <input type="text" name="subject" placeholder="Enter Subject Name" id="edit_subject" required>
                        <input type="hidden" name="id" id="editSubjectId">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Subject -->
    <div class="modal fade" id="deleteSubjectModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fs-5" id="exampleModalLabel">Delete Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="deleteSubject">@csrf
                    <div class="modal-body subject">
                        <p>Are you Sure you want to delete the Category?</p>
                        <input type="hidden" name="id" id="deleteSubjectId">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function(){
            //add Subject
            $("#addSubject").submit(function(e){
                e.preventDefault();
                var formData = $(this).serialize();

                $.ajax({
                    url: "{{ route('addSubject') }}",
                    type: "POST",
                    data: formData,
                    success: function(data){
                        if(data.success == true){
                            location.reload();
                        } else {
                            alert(data.msg);
                        }
                    }
                });
            });

            //edit Subject
            $(".editButton").click(function(){
                var subject_id = $(this).attr('data-id');
                var subject = $(this).attr('data-subject');
                $("#editSubject").val(subject);
                $("#editSubjectId").val(subject_id);
            });

            $("#editSubject").submit(function(e){
                e.preventDefault();
                var formData = $(this).serialize();

                $.ajax({
                    url: "{{ route('editSubject') }}",
                    type: "POST",
                    data: formData,
                    success: function(data){
                        if(data.success == true){
                            location.reload();
                        } else {
                            alert(data.msg);
                        }
                    }
                });
            });

            //delete Subject
            $(".deleteButton").click(function(){
                var subject_id = $(this).attr('data-id');
                $('#deleteSubjectId').val(subject_id);
            });

            $("#deleteSubject").submit(function(e){
                e.preventDefault();
                var formData = $(this).serialize();

                $.ajax({
                    url:"{{ route('deleteSubject') }}",
                    type:"POST",
                    data:formData,
                    success:function(data){
                        if(data.success == true){
                            location.reload();
                        } else {
                            alert(data.msg);
                        }
                    }
                });
            });
        });
    </script>

@endsection