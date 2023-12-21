@extends('layout')

@section('content')
    <div class="student">
        <p>Results</p>

        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Exam</th>
                    <th>Exam Mark</th>
                    <th>Carry Mark</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $x = 1;
                @endphp
                @forelse($attempts as $attempt)
                    <tr>
                        <td>{{ $x++ }}</td>
                        <td>{{ $attempt->exam->exam_name }}</td>
                        <td>
                            @if($attempt->status == 0)
                                <span>Not Declared</span>
                            @else
                                <span>{{ $attempt->tmarks }} / {{ ($attempt->exam->marks * count($attempt->exam->getQnaExam)) }}</span>
                            @endif
                        </td>
                        <td>
                            @if($attempt->status == 0)
                                <span>Not Declared</span>
                            @else
                                <span>{{ ($attempt->tmarks / $attempt->exam->marks) * ($attempt->exam->carry_marks / count($attempt->exam->getQnaExam)) }} / {{ ($attempt->exam->carry_marks) }} %</span>
                            @endif
                        </td>
                        <td>
                            @if($attempt->status == 0)
                                <span style="color:DodgerBlue;">Pending</span>
                            @else
                                <a href="#" data-id="{{ $attempt->id }}" class="reviewResult" data-bs-toggle="modal" data-bs-target="#reviewResultModal">Review </a>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">You not attempted any Exam!</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- reviewExam -->
    <div class="modal fade" id="reviewResultModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fs-5" id="exampleModalLabel">Review Exam</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="resultForm">@csrf
                    <input type="hidden" name="attempt_id" id="attempt_id">
                    <div class="modal-body review-result">
                        Loading...
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function(){
            $('.reviewResult').click(function(){
                var id = $(this).attr('data-id');
                $.ajax({
                    url: "{{ route('reviewResult') }}",
                    type: "GET",
                    data: { attempt_id:id },
                    success: function(data){
                        var html = '';
                        if(data.success == true){
                            var data = data.data;
                            if(data.length > 0){
                                for(let i = 0; i < data.length; i++){
                                    let isCorrect = '<span style="color:red;" class="bx bx-x"></span>'
                                    if(data[i]['answers']['is_correct'] == 1){
                                        isCorrect = '<span style="color:green;" class="bx bx-check"></span>'
                                    }
                                    let answer = data[i]['answers']['answer'];

                                    html += `<div class="row">
                                                <div class="col-sm-12">
                                                    <h6>Q(`+(i+1)+`). `+data[i]['question']['question']+`</h6>
                                                    <p>Ans: `+answer+` `+isCorrect+` </p>
                                                </div>
                                            </div>
                                            `;
                                }
                            } else {
                                html += `<h6>You didn't attempt any Questions!</h6>`
                            }
                        } else {
                            html += `<p>Having some issue on server side.</p>`;
                        }
                        $('.review-result').html(html);
                    }
                });
            });
        });
    </script>
@endsection