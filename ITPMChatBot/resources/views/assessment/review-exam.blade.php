@extends('layout')

@section('content')
    <div class="lecturer">
        <p>Student Exam</p>

        <table class="table">
            <thead>
                <th>#</th>
                <th>Name</th>
                <th>Exam</th>
                <th>Status</th>
                <th>Review</th>
            </thead>
            <tbody>
                @php
                    $x = 1;
                @endphp
                @forelse($attempts as $attempt)
                    <tr>
                        <td>{{ $x++ }}</td>
                        <td>{{ $attempt->user->name }}</td>
                        <td>{{ $attempt->exam->exam_name }}</td>
                        <td>
                            @if($attempt->status == 0)
                                <span style="color:DodgerBlue">Pending</span>
                            @else
                                <span style="color:MediumSeaGreen">Approved</span>
                            @endif
                        </td>
                        <td>
                            @if($attempt->status == 0)
                                <a href="#" class="reviewExam" data-bs-id="{{ $attempt->id }}" data-bs-toggle="modal" data-bs-target="#reviewExamModal">Review & Approved</a>
                            @else
                                Completed
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">Student not Attempt Exams!</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- reviewExam -->
    <div class="modal fade" id="reviewExamModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fs-5" id="exampleModalLabel">Review Exam</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="reviewForm">@csrf
                    <input type="hidden" name="attempt_id" id="attempt_id">
                    <div class="modal-body review-exam">
                        Loading...
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary approved">Approved</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function(){
            $('.reviewExam').click(function(){
                var id = $(this).attr('data-bs-id');
                $('#attempt_id').val(id);

                $.ajax({
                    url: "{{ route('reviewQna') }}",
                    type: "GET",
                    data: {attempt_id: id},
                    success: function(data){
                        console.log(id);
                        var html = '';
                        console.log(data);
                        if(data.success == true){
                            var data = data.data;
                            if(data.length > 0){
                                for(let i = 0; i < data.length; i++){
                                    let isCorrect = '<span style="color:red;" class="bx bx-x"></span>'
                                    if(data[i]['answers']['is_correct'] == 1){
                                        isCorrect = '<span style="color:green;" class="bx bx-check"></span>'
                                    }
                                    let answer = data[i]['answers']['answer'];

                                    html += `
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <h6>Q(`+(i+1)+`). `+data[i]['question']['question']+`</h6>
                                            <p>Ans: `+answer+` `+isCorrect+` </p>
                                        </div>
                                    </div>
                                    `;
                                }
                            } else {
                            html += `
                            <h6>Student not attempt any Questions!</h6>
                            <p>If you Approve this Exam Student will Fail!</p>`;
                        }
                    } else {
                        html += `
                        <p>Having some server issue!
                        `;
                    }
                    $('.review-exam').html(html);
                }
            });
        });

        //approved exam
        $('#reviewForm').submit(function(event){
            event.preventDefault();
            $('.approved-btn').html('Please wait <i class="bx bx-spinner bx-spin"></i>');

            var formData = $(this).serialize();

            $.ajax({
                url: "{{ route('approvedExam') }}",
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
    });
</script>

@endsection