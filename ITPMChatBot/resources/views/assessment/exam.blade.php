@extends('layout')

@section('content') 
    <div class="lecturer">
        <p>Quiz Exam</p>

        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addExamModal">
            Add Exam
        </button>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Exam Name</th>
                    <th scope="col">Category</th>
                    <th scope="col">Time</th>
                    <th scope="col">Start Time</th>
                    <th scope="col">End Time</th>
                    <th scope="col">Attempt</th>
                    <th scope="col">Add Questions</th>
                    <th scope="col">Show Questions</th>
                    <th scope="col">Copy Link</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $count = 1;
                @endphp
                @forelse($exams as $exam)
                    <tr>
                        <td style="display:none;">{{ $exam->id }}</td>
                        <td>{{ $count++ }}</td>
                        <td>{{ $exam->exam_name }}</td>
                        <td>{{ $exam->subjects[0]['subject'] }}</td>
                        <td>{{ $exam->time }} Hrs</td>
                        <td>{{ $exam->start_time }}</td>
                        <td>{{ $exam->end_time }}</td>
                        <td>{{ $exam->attempt }} Time</td>
                        <td>
                            <a herf="#" class="addExamQuestion" data-id="{{ $exam->id }}" data-bs-toggle="modal" data-bs-target="#addExamQnaModal">Add Questions</a>
                        </td>
                        <td>
                            <a herf="#" class="seeExamQuestion" data-id="{{ $exam->id }}" data-bs-toggle="modal" data-bs-target="#seeExamQnaModal">Show Questions</a>
                        </td>
                        <td>{{ $exam->enterance_id }} <a href="#" data-code="{{ $exam->enterance_id }}" class="copy"><i class="bx bx-copy"></i></a></td>
                        <td>
                            <button class="btn btn-info editButton" data-id="{{ $exam->id }}" data-bs-toggle="modal" data-bs-target="#editExamModal" style="margin-right: .25rem;">Edit</button>
                            <button class="btn btn-danger deleteButton" data-id="{{ $exam->id }}" data-bs-toggle="modal" data-bs-target="#deleteExamModal" style="margin-left: .25rem;">Delete</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="11">Exams not Found!</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Create Exam -->
    <div class="modal fade" id="addExamModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fs-5" id="exampleModalLabel">Add Exam</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addExam">@csrf
                    <div class="modal-body">
                        <input type="text" name="exam_name" placeholder="Enter Exam Name" class="w-100" required>
                        <br><br>
                        <select name="subject_id" required class="w-100">
                            <option value="">Select Category</option>
                            @forelse($subjects as $subject)
                            <option value="{{ $subject->id }}">{{ $subject->subject }}</option>
                            @empty
                            @endforelse
                        </select>
                        <br><br>
                        <input type="datetime-local" id="StartTime" name="StartTime" class="w-100" min="<?=date('Y-m-d\Th:i')?>" required>
                        <input type="hidden" id="EndTime" name="EndTime" class="w-100" required>
                        <br><br>
                        <input type="number" id="hours" class="time-input" min="0" max="23" placeholder=" HH" required>
                        :
                        <input type="number" id="minutes" class="time-input" min="0" max="59" placeholder=" MM" required>
                        <input type="hidden" id="atime" name="atime" class="w-100" required> 
                        <input type="hidden" id="time" name="time" class="w-100" required>  
                        <br><br>
                        <input type="number" min="1" name="attempt" placeholder="Enter Exam Attempt Time" class="w-100" required>      
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Exam</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Exam -->
    <div class="modal fade" id="editExamModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fs-5" id="exampleModalLabel">Edit Exam</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editExam">@csrf
                    <div class="modal-body">
                        <input type="hidden" name="exam_id" id="exam_id">
                        <input type="text" name="exam_name" id="exam_name" placeholder="Enter Exam Name" class="w-100" required>
                        <br><br>
                        <select name="subject_id" id="subject_id" required class="w-100">
                            <option value="">Select Category</option>
                            @forelse($subjects as $subject)
                            <option value="{{ $subject->id }}">{{ $subject->subject }}</option>
                            @empty
                            @endforelse
                        </select>
                        <br><br>
                        <input type="datetime-local" id="editStartTime" name="editStartTime" class="w-100" min="<?=date('Y-m-d\TH:i')?>" required>
                        <input type="hidden" id="EndTime" name="EndTime" class="w-100" required>
                        <br><br>
                        <input type="number" id="editHours" name="editHours" class="time-input" min="0" max="23" placeholder=" HH" required>
                        :
                        <input type="number" id="editMinutes" name="editMinutes" class="time-input" min="0" max="59" placeholder=" MM" required>
                        <input type="hidden" id="editTime" name="editTime" class="w-100" required>
                        <input type="hidden" id="editaTime" name="editaTime" class="w-100" required> 
                        <br><br>
                        <input type="number" min="1" id="attempt" name="attempt" placeholder="Enter Exam Attempt Time" class="w-100" required>     
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Exam -->
    <div class="modal fade" id="deleteExamModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fs-5" id="exampleModalLabel">Delete Exam</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="deleteExam">@csrf
                    <div class="modal-body">
                        <input type="hidden" name="exam_id" id="deleteExamId">
                        <p>Are you Sure you want to delete the Exam?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Add Q&A Exam -->
    <div class="modal fade" id="addExamQnaModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fs-5" id="exampleModalLabel">Add Q&A</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addExamQna">@csrf
                    <div class="modal-body addExamQna">
                        <input type="hidden" name="exam_id" id="addExamId">
                        <input type="search" name="search" id="search" onkeyup="searchTable()" class="w-100" placeholder="Search here">
                        <br><br>
                        <table class="table" id="questionsTable">
                            <thead>
                                <th>Select</th>
                                <th>Question</th>
                            </thead>
                            <tbody class="addExamQnaBody">
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Q&A</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Show Q&A Exam -->
    <div class="modal fade" id="seeExamQnaModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fs-5" id="exampleModalLabel">Questions</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body seeExamQna">
                    <table class="table">
                        <thead>
                            <th>S.No</th>
                            <th>Question</th>
                        </thead>
                        <tbody class="seeQuestionsTable">
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function(){
            // Update time input based on hours and minutes
            function updateTimeInput() {
                var hours = $("#hours").val();
                var minutes = $("#minutes").val();

                // Ensure that hours and minutes are two digits each
                hours = hours.padStart(2, "0");
                minutes = minutes.padStart(2, "0");

                // Extract hours and minutes from the input fields
                var ahours = parseInt($("#hours").val());
                var aminutes = parseInt($("#minutes").val());

                // Calculate the total time in minutes
                var totalTime = ((ahours * 60) + aminutes);
                $("#atime").val(totalTime);

                // Update the time input value
                $("#time").val(hours + ":" + minutes);
            }

            // Listen for changes in the hours and minutes inputs
            $("#hours, #minutes").on("input", updateTimeInput);

            $('#addExamModal').on('click', function(){
                updateTimeInput();
            });

            // Update time input based on hours and minutes
            function updateEditTimeInput() {
                var editHours = $("#editHours").val();
                var editMinutes = $("#editMinutes").val();

                // Ensure that hours and minutes are two digits each
                editHours = editHours.padStart(2, "0");
                editMinutes = editMinutes.padStart(2, "0");

                // Extract hours and minutes from the input fields
                var editaHours = parseInt($("#editHours").val());
                var editaMinutes = parseInt($("#editMinutes").val());

                // Calculate the total time in minutes
                var editTotalTime = ((editaHours * 60) + editaMinutes);
                $("#editaTime").val(editTotalTime);

                // Update the time input value
                $("#editTime").val(editHours + ":" + editMinutes);
            }

            // Listen for changes in the hours and minutes inputs
            $("#editHours, #editMinutes").on("input", updateEditTimeInput);

            //add Exam
            $("#addExam").submit(function(e){
                e.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                    url: "{{ route('addExam') }}",
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

            //get Exam Detail
            $(".editButton").click(function(){
                var id = $(this).attr('data-id');
                $("#exam_id").val(id);

                var url = '{{ route("getExamDetail","id") }}';
                url = url.replace('id',id);

                $.ajax({
                    url: url,
                    type: "GET",
                    success:function(data){
                        if(data.success == true){
                            var exam = data.data;
                            $("#exam_name").val(exam[0].exam_name);
                            $("#subject_id").val(exam[0].subject_id);
                            // Split the time value and set hours and minutes
                            var timeComponents = exam[0].time.split(":");
                            $("#editStartTime").val(exam[0].start_time);
                            $("#editEndTime").val(exam[0].start_time);
                            $("#editHours").val(timeComponents[0]);
                            $("#editMinutes").val(timeComponents[1]);
                            $("#editTime").val(exam[0].time);
                            $("#attempt").val(exam[0].attempt);

                            var editHours = $("#editHours").val();
                            var editMinutes = $("#editMinutes").val();

                            // Ensure that hours and minutes are two digits each
                            editHours = editHours.padStart(2, "0");
                            editMinutes = editMinutes.padStart(2, "0");

                            // Extract hours and minutes from the input fields
                            var editaHours = parseInt($("#editHours").val());
                            var editaMinutes = parseInt($("#editMinutes").val());

                            // Calculate the total time in minutes
                            var editTotalTime = ((editaHours * 60) + editaMinutes);
                            $("#editaTime").val(editTotalTime);

                            // Update the time input value
                            $("#editTime").val(editHours + ":" + editMinutes);

                        } else {
                            alert(data.msg);
                        }
                    }
                });
            });

            //edit Exam
            $("#editExam").submit(function(e){
                e.preventDefault();
                var formData = $(this).serialize();

                $.ajax({
                    url: "{{ route('editExam') }}",
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

            //delete Exam
            $(".deleteButton").click(function(){
                var id = $(this).attr('data-id');
                $("#deleteExamId").val(id);
            });

            $("#deleteExam").submit(function(e){
                e.preventDefault();
          
                var formData = $(this).serialize();

                $.ajax({
                    url: "{{ route('deleteExam') }}",
                    type: "POST",
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

            //add questions
            $('.addExamQuestion').click(function(){
                var id = $(this).attr('data-id');
                $('#addExamId').val(id);

                $.ajax({
                    url: "{{ route('getQuestions') }}",
                    type: "GET",
                    data: {exam_id:id},
                    success:function(data){
                        if(data.success == true){
                            var questions = data.data;
                            var html = '';
                            if(questions.length > 0){
                                for(let i=0; i < questions.length; i++){
                                    html +=`                 
                                    <tr>
                                        <td><input type="checkbox" value="`+questions[i]['id']+`" name="questions_ids[]"></input></td>
                                        <td>`+questions[i]['questions']+`</td>
                                    </tr>
                                    `;
                                }
                            } else {
                                html +=`
                                <tr>
                                    <td colspan="2">Questions not Available</td>
                                </tr>
                                `;
                            }
                            $('.addExamQnaBody').html(html);
                        } else {
                            alert(data.msg);
                        }
                    }
                });
            });

            $("#addExamQna").submit(function(e){
                e.preventDefault();
          
                var formData = $(this).serialize();

                $.ajax({
                    url: "{{ route('addQuestions') }}",
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

            //see questions
            $('.seeExamQuestion').click(function(){
                var id = $(this).attr('data-id');

                $.ajax({
                    url: "{{ route('getExamQuestions') }}",
                    type: "GET",
                    data: {exam_id:id},
                    success: function(data){
                        //console.log(data);
                        var html = '';
                        var questions = data.data;
                        if(questions.length > 0){
                    
                            for(let i = 0; i < questions.length; i++){
                                html +=`
                                <tr>
                                    <td>`+(i+1)+`</td>
                                    <td>`+questions[i]['question'][0]['question']+`</td>
                                    <td>
                                        <button class="btn btn-danger deleteExamQuestion" data-id="`+questions[i]['id']+`">Delete</button>
                                    </td>
                                </tr>
                                `;
                            }
                        } else {
                            html +=`
                            <tr>
                                <td colspan="1">Questions not available</td>
                            </tr>
                            `;
                        }
                        $('.seeQuestionsTable').html(html);
                    }
                });
            });

            //delete question
            $(document).on('click','.deleteExamQuestion',function(){
                var id = $(this).attr('data-id');
                var obj = $(this);
                $.ajax({
                    url: "{{ route('deleteExamQuestions') }}",
                    type: "GET",
                    data: {id:id},
                    success: function(data){
                        if(data.success == true){
                            obj.parent().parent().remove();
                        } else {
                            alert(data.msg);
                        }
                    }
                });
            });

            $('.copy').click(function(){
                $(this).parent().prepend('<span class="copied_text">Copied</span>');

                var code = $(this).attr('data-code');
                var url = "{{URL::to('/')}}/exam/"+code;

                var $temp = $("<input>");
                $("body").append($temp);
                $temp.val(url).select();
                document.execCommand("copy");
                $temp.remove();

                setTimeout(() => {
                    $('.copied_text').remove();
                }, 1000);
            });
        });

        function searchTable(){
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById('search');
            filter = input.value.toUpperCase();
            table = document.getElementById('questionsTable');
            tr = table.getElementsByTagName("tr");
            for(i = 0; i < tr.length; i++){
                td = tr[i].getElementsByTagName("td")[1];
                if(td){
                    txtValue = td.textContent || td.innerText;
                    if(txtValue.toUpperCase().indexOf(filter) > -1){
                        tr[i].style.display = "";
                    } else {
                    tr[i].style.display = "none";
                    }
                }
            }
        }
    </script>
@endsection