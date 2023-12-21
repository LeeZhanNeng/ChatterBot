@extends('layout')

@section('content')
    <div class="admin">
        <p>User Register</p>

        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
            Add User
        </button>

        <table class="table">
            <thead>
                <tr>
                    <th scope="col" width="25%">User Name</th>
                    <th scope="col" width="45%">User Email</th>
                    <th scope="col" width="15%">User Type</th>
                    <th scope="col" width="15%">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($userEmailRegisters as $user)
                    <tr>
                        <td>{{ $user->user_name }}</td>
                        <td>{{ $user->user_email }}</td>
                    @if($user->user_type == 'admin')
                        <td>Admin</td>
                    @elseif($user->user_type == 'lecturer')
                        <td>Lecturer</td> 
                    @else
                        <td>Student</td> 
                    @endif
                        <td>
                            <button class="btn btn-info editButton" data-id="{{ $user->id }}" data-bs-toggle="modal" data-bs-target="#editUserModal" style="margin-right: .25rem;">Edit</button>
                            <button class="btn btn-danger deleteButton" data-id="{{ $user->id }}" data-bs-toggle="modal" data-bs-target="#deleteUserModal" style="margin-left: .25rem;">Delete</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">User not found!</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Create UserEmail -->
    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fs-5" id="exampleModalLabel">Add User</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addUser">@csrf
                    <div class="modal-body addUserA">
                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" placeholder="Enter Name" required autocomplete="name" autofocus>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Enter Email" required autocomplete="email">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="user_type" class="col-md-4 col-form-label text-md-end">{{ __('User Type') }}</label>
                            <select name="user_type" id="user_type" required class="w-25" style="margin-left: .75rem; margin-right: .75rem;">
                                <option value="student">Student</option>
                                <option value="lecturer">Lecturer</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit User -->
    <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fs-5" id="exampleModalLabel">Edit User</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editUser"> @csrf
                    <div class="modal-body editUserM">
                        <input type="hidden" name="user_id" id="user_id">
                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>
                            <div class="col-md-6">
                                <input id="editName" type="text" class="form-control @error('name') is-invalid @enderror" name="editName" value="{{ old('name') }}" placeholder="Enter Name" required autocomplete="name" autofocus>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>
                            <div class="col-md-6">
                                <input id="editEmail" type="email" class="form-control @error('email') is-invalid @enderror" name="editEmail" value="{{ old('email') }}" placeholder="Enter Email" required autocomplete="email">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="edit_user_type" class="col-md-4 col-form-label text-md-end">{{ __('User Type') }}</label>
                            <select name="edit_user_type" id="edit_user_type" required class="w-25" style="margin-left: .75rem; margin-right: .75rem;">
                                <option value="student">Student</option>
                                <option value="lecturer">Lecturer</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Delete User -->
    <div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fs-5" id="exampleModalLabel">Delete Exam</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form id="deleteUser">@csrf
                    <div class="modal-body">
                        <input type="hidden" name="user_id" id="deleteUserId">
                        <p>Are you Sure you want to delete the User?</p>
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
            //add User
            $("#addUser").submit(function(e){
                e.preventDefault();
          
                var formData = $(this).serialize();

                $.ajax({
                    url: "{{ route('adminRegister') }}",
                    type: "POST",
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data){
                        console.log(data);
                        if(data.success == true){
                            location.reload();
                        } else {
                            alert(data.msg);
                        }
                    }
                });
            });

            //get User Detail
            $(".editButton").click(function () {
                var id = $(this).attr('data-id');
                $("#user_id").val(id);
                var url = '{{ route("getUserDetail", ["id" => ":id"]) }}';
                url = url.replace(':id', id);
                $.ajax({
                    url: url,
                    type: "GET",
                    success: function (data) {
                        if (data.success == true) {
                            var user = data.data;
                            $("#editName").val(user[0].user_name);
                            $("#editEmail").val(user[0].user_email);
                            $("#edit_user_type").val(user[0].user_type);
                        } else {
                            alert(data.msg);
                        }
                    }
                });
            });

            //edit User
            $("#editUser").submit(function(e){
                e.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                    url: "{{ route('editAdminRegister') }}",
                    type: "POST",
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data){
                        if(data.success == true){
                            location.reload();
                        } else {
                            alert(data.msg);
                        }
                    }
                });
            });

            //delete User
            $(".deleteButton").click(function(){
                var id = $(this).attr('data-id');
                $("#deleteUserId").val(id);
            });

            $("#deleteUser").submit(function(e){
                e.preventDefault();
          
                var formData = $(this).serialize();

                $.ajax({
                    url: "{{ route('deleteUser') }}",
                    type: "POST",
                    data: formData,
                    success: function(data){
                        if(data.success == true){
                            location.reload();
                        }else{
                            alert(data.msg);
                        }
                    }
                });
            });
        });
    </script>

@endsection
