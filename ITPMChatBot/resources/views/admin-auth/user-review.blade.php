@extends('layout')

@section('content')
    <div class="admin">
        <p>User List</p>

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">User Name</th>
                    <th scope="col">User Email</th>
                    <th scope="col">User Type</th>
                    <th scope="col">User Password</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        @if( $user->user_type == 'admin')
                        <td>Admin</td>
                        @elseif( $user->user_type == 'lecturer')
                        <td>Lecturer</td>
                        @else
                        <td>Student</td> 
                        @endif
                        <td>{{ $user->password }}</td>
                        <td>
                            <button class="btn btn-info editButton" data-id="{{ $user->id }}" data-bs-toggle="modal" data-bs-target="#editReviewUserModal" style="margin-right: .25rem;">Edit</button>
                            <button class="btn btn-danger deleteButton" data-id="{{ $user->id }}" data-bs-toggle="modal" data-bs-target="#deleteReviewUserModal" style="margin-left: .25rem;">Delete</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">User not found!</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Edit User -->
    <div class="modal fade" id="editReviewUserModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fs-5" id="exampleModalLabel">Edit User</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editReviewUser">@csrf
                    <div class="modal-body editReviewUserM">
                        <input type="hidden" name="user_id" id="user_id">
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

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
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
    <div class="modal fade" id="deleteReviewUserModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fs-5" id="exampleModalLabel">Delete Exam</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="deleteReviewUser">@csrf
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
            //get User Detail
            $(".editButton").click(function () {
                var id = $(this).attr('data-id');
                $("#user_id").val(id);
                var url = '{{ route("reviewUserGet", ["id" => ":id"]) }}';
                url = url.replace(':id', id);
                $.ajax({
                    url: url,
                    type: "GET",
                    success: function (data) {
                        if (data.success == true) {
                            var user = data.data;
                            $("#name").val(user[0].name);
                            $("#email").val(user[0].email);
                            $("#user_type").val(user[0].user_type);
                            $("#password").val('');
                        } else {
                            alert(data.msg);
                        }
                    }
                });
            });

            //edit User
            $("#editReviewUser").submit(function(e){
                e.preventDefault();
                var formData = $(this).serialize();

                $.ajax({
                    url: "{{ route('reviewUserEdit') }}",
                    type: "POST",
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success:function(data){
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

            $("#deleteReviewUser").submit(function(e){
                e.preventDefault();
                var formData = $(this).serialize();

                $.ajax({
                    url: "{{ route('reviewUserDelete') }}",
                    type: "POST",
                    data: formData,
                    success: function(data){
                        if(data.success == true) {
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
