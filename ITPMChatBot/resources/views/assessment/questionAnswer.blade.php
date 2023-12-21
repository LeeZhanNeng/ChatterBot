@extends('layout')

@section('content')
    <div class="lecturer">
        <p>Q&A</p>

        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addQnaModal" style="margin-right: .5rem;">
            Add Q&A
        </button>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#importQnaModal" style="margin-left: .5rem;">
            Import Q&A
        </button>

        <table class="table">
            <thead>
                <th>#</th>
                <th>Question</th>
                <th>Answers</th>
                <th>Image</th>
                <th>Actions</th>
            </thead>
            <tbody>
                @php
                    $x = 1;
                @endphp
                @forelse($questions as $question)
                    <tr>
                        <td>{{ $x++ }}</td>
                        <td>{{ $question->question }}</td>
                        <td>
                            <a href="#" class="ansButton" data-id="{{ $question->id }}" data-bs-toggle="modal" data-bs-target="#showAnsModal">Check Answers</a>
                        </td>
                        <td>
                            @if($question->image != 'empty.jpg')
                            <img src="{{ asset ('images/') }}/{{ $question->image }}" class="img-fluid" alt="" style="width: 70px;" data-toggle="modal" data-target="#imageModal">
                            @else
                            <img src="#" class="img-fluid" alt="" style="width: 70px;" data-toggle="modal" data-target="#imageModal">
                            @endif
                        </td>
                        <td>
                            <button class="btn btn-info editQnaButton" data-id="{{ $question->id }}" data-bs-toggle="modal" data-bs-target="#editQnaModal" style="margin-right: .25rem;">Edit</button>
                            <button class="btn btn-danger deleteQnaButton" data-id="{{ $question->id }}" data-bs-toggle="modal" data-bs-target="#deleteQnaModal" style="margin-left: .25rem;">Delete</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">Questions & Answers not Found!</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Create Q&A -->
    <div class="modal fade" id="addQnaModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fs-5" id="exampleModalLabel">Add Q&A</h5>
                    <button id="addAnswer" class="ml-5 btn btn-info">Add Answer</button>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    </button>
                </div>
                <form id="addQna">@csrf
                    <div class="modal-body addAnswers">
                        <div class="row">
                            <div class="col">
                                Question: <input type="text" class="w-100" name="question" placeholder="Enter Question">
                                Image: <input type="file" name="image" class="form-control"/>
                                <br>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <span class="error" style="color:red;"></span>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Q&A</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Show Answer -->
    <div class="modal fade" id="showAnsModal" tabindex="-1"  aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fs-5" id="exampleModalLabel">Show Answers</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body showAns">
                    <table class="table">
                        <thead>
                            <th>#</th>
                            <th>Answer</th>
                            <th>Is Correct</th>
                        </thead>
                        <tbody class="showAnswers"></tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <span class="error" style="color:red;"></span>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Q&A -->
    <div class="modal fade" id="editQnaModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fs-5" id="exampleModalLabel"> Update Q&A</h5>
                    <button id="addEditAnswer" class="ml-5 btn btn-info">Add Answer</button>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    </button>
                </div>
                <form id="editQna">@csrf
                    <div class="modal-body editModelAnswers">
                        <div class="row">
                            <div class="col">
                                <input type="hidden" name="question_id" id="question_id">
                                Question: <input type="text" class="w-100" name="question" id="question" placeholder="Enter Question">
                                Image: <input type="file" name="image" class="form-control"/>
                                <br>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <span class="error" style="color:red;"></span>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Q&A -->
    <div class="modal fade" id="deleteQnaModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fs-5" id="exampleModalLabel">Delete EQ&A</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="deleteQna">@csrf
                    <div class="modal-body deleteModalQna">
                        <input type="hidden" name="id" id="deleteQnaId">
                        <p>Are you Sure you want to delete the Q&A?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Import Q&A -->
    <div class="modal fade" id="importQnaModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fs-5" id="exampleModalLabel">Import Q&A</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="importQna" enctype="multipart/form-data">@csrf
                    <div class="modal-body uploadModalQna">
                        <input type="file" name="file" id="fileupload" required accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms.excel">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-info">Import Q&A</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Image -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <img class="img-fluid" id="modalImgSrc" src="#" alt="">
            </div>
        </div>
    </div>

    <script>
        $("#check").click(function(){
            console.log($(".is_correct").length);
            for(let i = 0; i < $(".is_correct").length; i++ ){
                if($(".is_correct:eq("+i+")").prop('checked') == true ){
                    checkIsCorrect = true;
                    $(".is_correct:eq("+i+")").val( $(".is_correct:eq("+i+")").next().find('input').val());
                }
            }
        });

        $(document).ready(function(){
            //form submittion
            $("#addQna").submit(function(e){
                e.preventDefault();

                if($(".answers").length < 2 ){
                    $(".error").text("Please add minumum two answer")
                    setTimeout(function(){
                        $(".error").text("");
                    },2000);
                } else {
                    var checkIsCorrect = false;
                    for(let i = 0; i < $(".is_correct").length; i++ ){
                        console.log(i);
                        if($(".is_correct:eq("+i+")").prop('checked') == true ){
                            checkIsCorrect = true;
                            $(".is_correct:eq("+i+")").val( $(".is_correct:eq("+i+")").next().find('input').val() );
                        }
                    }
                    if(checkIsCorrect){

                        var formData = $(this).serialize();
                        var myFormData = new FormData(this);

                        myFormData.append('image', $('#editQnaModal input[name="image"]')[0].files[0]);

                        $.ajax({
                            url: "{{ route('addQna') }}",
                            type: "POST",
                            data: myFormData,
                            contentType: false,
                            processData: false,
                            success:function(data){
                                console.log(data);
                                if(data.success == true){
                                    location.reload();
                                } else {
                                    alert(data.msg);
                                }
                            }
                        });
                    } else {
                        $(".error").text("Please select anyone correct answer.")
                        setTimeout(function(){
                            $(".error").text("");
                        },2000);
                    }
                }
            });

            //add Answer
            $("#addAnswer").click(function(){
                if($(".answers").length >= 6 ){
                    $(".error").text("You can add Maximum 6 Answer.")
                    setTimeout(function(){
                        $(".error").text("");
                    },2000);
                } else {
                    var html = `
                    <div class="row answers">
                        <div class="col" style="display: flex; align-items: center; margin-top: .5rem;">
                            <input type="radio" name="is_correct" class="is_correct"></input>
                            <div style="padding-left: .5rem; width: 75%;"> 
                                <input type="text" class="w-100" name="answers[]" placeholder="Enter Answer"></input>
                            </div>
                            <div style="padding-left: 1rem;">
                                <button class="btn btn-danger removeButton">Remove</button>
                            </div>
                            <br>
                        </div>
                    </div>
                    `;

                    $(".modal-body.addAnswers").append(html);
                }
            });

            $(document).on("click",".removeButton",function(){
                $(this).parent().parent().parent().remove();
            });

            //show answers
            $(".ansButton").click(function(){
                var questions = @json($questions);
                var qid = $(this).attr('data-id');
                var html = '';

                for(let i=0; i < questions.length; i++){
                    if(questions[i]['id'] == qid){
                        var answersLength = questions[i]['answers'].length;
                        for(let j=0; j < answersLength; j++){
                            let is_correct = 'No';
                            if(questions[i]['answers'][j]['is_correct'] == 1){
                                is_correct = 'Yes';
                            }
                            html += `
                            <tr>
                                <td>`+(j+1)+`</td>
                                <td>`+questions[i]['answers'][j]['answer']+`</td>
                            <td>`+is_correct+`</td>
                            </tr>
                            `;
                        }
                        break;
                    }
                }
                $('.showAnswers').html(html);
            });

            //edit Answer
            $("#addEditAnswer").click(function(){
                if($(".editAnswers").length >= 6 ){
                    $(".editError").text("You can add Maximum 6 Answer.")
                    setTimeout(function(){
                        $(".editError").text("");
                    },2000);
                } else {
                    var html = `
                    <div class="row editAnswers">
                        <div class="col" style="display: flex; align-items: center; margin-top: .5rem;">
                            <input type="radio" name="is_correct" class="edit_is_correct">
                            <div style="padding-left: .5rem; width: 75%;"> 
                                <input type="text" class="w-100" name="new_answers[]" placeholder="Enter Answer" required>
                            </div>
                        <div style="padding-left: 1rem;">
                            <button class="btn btn-danger removeButton">Remove</button>
                        </div>
                        <br>
                    </div>
                </div>
                `;

                $(".modal-body.editModelAnswers").append(html);
                }
            });

            $(".editQnaButton").click(function(){
                var qid = $(this).attr('data-id');

                $.ajax({
                    url: "{{ route('getQnaDetails') }}",
                    type: "GET",
                    data: {qid:qid},
                    success: function(data){
                        console.log(data);

                        var qna = data.data[0];
                        $("#question_id").val(qna['id']);
                        $("#question").val(qna['question']);
                        $("#image").val(qna['image']);
                        $(".editAnswers").remove();

                        var html = '';

                        for(let i = 0; i < qna['answers'].length; i++){
                            var checked = '';
                            if(qna['answers'][i]['is_correct'] == 1){
                                checked = 'checked';
                            }
                            html += `
                            <div class="row editAnswers">
                                <div class="col" style="display: flex; align-items: center; margin-top: .5rem;">
                                    <input type="radio" name="is_correct" class="edit_is_correct" `+checked+`>
                                    <div style="padding-left: .5rem; width: 75%;"> 
                                        <input type="text" class="w-100" name="answers[`+qna['answers'][i]['id']+`]" 
                                        placeholder="Enter Answer" value="`+qna['answers'][i]['answer']+`" required>
                                    </div>
                                    <div style="padding-left: 1rem;">
                                        <button class="btn btn-danger removeButton removeAnswer" data-id="`+qna['answers'][i]['id']+`">Remove</button>
                                    </div>
                                    <br>
                                </div>
                            </div>
                            `;
                        }
                        $(".modal-body.editModelAnswers").append(html);
                    }
                });
            });

            //form submittion
            $("#editQna").submit(function(e){
                e.preventDefault();
                if($(".editAnswers").length < 2 ){
                    $(".editError").text("Please add minumum two answer")
                    setTimeout(function(){
                        $(".editError").text("");
                    },2000);
                } else {
                    var checkIsCorrect = false;

                    for(let i = 0; i < $(".edit_is_correct").length; i++ ){
                        if($(".edit_is_correct:eq("+i+")").prop('checked') == true ){
                        checkIsCorrect = true;
                            $(".edit_is_correct:eq("+i+")").val( $(".edit_is_correct:eq("+i+")").next().find('input').val() );
                        }
                    }
                    if(checkIsCorrect){
                        var myFormData = new FormData(this);
                        myFormData.append('image', $('#editQnaModal input[name="image"]')[0].files[0]);

                        $.ajax({
                            url: "{{ route('updateQna') }}",
                            type: "POST",
                            data: myFormData,
                            contentType: false,
                            processData: false,
                            success: function(data){
                                console.log(data);
                                if(data.success == true){
                                    location.reload();
                                } else {
                                    alert(data.msg);
                                }
                            }
                        });
                    } else {
                        $(".editError").text("Please select anyone correct answer.")
                        setTimeout(function(){
                            $(".editError").text("");
                        },2000);
                    }
                }
            });

            //remove Answers
            $(document).on('click','.removeAnswer',function(){
                var ansId = $(this).attr('data-id');

                $.ajax({
                    url: "{{ route('deleteAns') }}",
                    type: "GET",
                    data: { id:ansId },
                    success: function(data){
                        if(data.success == true){
                        console.log(data.msg);
                        } else {
                            alert(data.msg);
                        }
                    }
                });
            });

            //delete Q&A
            $('.deleteQnaButton').click(function(){
                var id = $(this).attr('data-id');
                $('#deleteQnaId').val(id);
            });

            $('#deleteQna').submit(function(e){
                e.preventDefault();
                var formData = $(this).serialize();

                $.ajax({
                    url: "{{ route('deleteQna') }}",
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
            })

            //import Q&A
            $('#importQna').submit(function(e){
                e.preventDefault();
                let formData = new FormData();
                formData.append("file",fileupload.files[0]);

                $.ajaxSetup({
                    headers:{
                        "X-CSRF-TOKEN":"{{ csrf_token() }}"
                    }
                });

                $.ajax({
                    url: "{{ route('importQna') }}",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(data){
                        if(data.success == true){
                            location.reload();
                        } else {
                            alert(data.msg);
                        }
                    }
                });
            });        
            
            //imageModal
            $('img[data-toggle="modal"]').on('click', function () {
                var imageUrl = $(this).attr('src');

                $('#modalImgSrc').attr('src', imageUrl);
            });
        });
    </script>


@endsection