@extends('layout')

@section('content')
    <div class="lecturer">
        <p>Mark</p>

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Exam Name</th>
                    <th scope="col">Marks/Q</th>
                    <th scope="col">Total Marks</th>
                    <th scope="col">Final Marks</th>
                    <th scope="col">Edit</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $x = 1;
                @endphp
                @forelse($exams as $exam)
                        <tr>
                            <td>{{ $x++ }}</td>
                            <td>{{ $exam->exam_name }}</td>
                            <td>{{ $exam->marks }}</td>
                            <td>{{ count($exam->getQnaExam) * $exam->marks }}</td>
                            <td>{{ $exam->carry_marks }}</td>
                            <td>
                                <button class="btn btn-primary editMarks" data-bs-id="{{ $exam->id }}" data-bs-marks="{{ $exam->marks }}" data-bs-carry-marks="{{ $exam->carry_marks }}" data-bs-totalq="{{ count($exam->getQnaExam) }}" data-bs-toggle="modal" data-bs-target="#editMarksModal">Edit</button>
                            </td>
                        </tr>
                @empty
                    <tr>
                        <td colspan="5">Exams not added!</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Edit Exam -->
    <div class="modal fade" id="editMarksModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fs-5" id="exampleModalLabel">Edit Mark</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editMarks">@csrf
                    <div class="modal-body">
                        <div class="row mt-2">
                            <div class="col-sm-4">
                                <label>Mark/Q</label>
                            </div>
                            <div class="col-sm-6">
                                <input type="hidden" name="exam_id" id="exam_id">
                                <input type="text" onkeypress="return event.charCode >=48 && event.charCode<=57 || event.charCode == 46" 
                                name="marks" placeholder="Ender Marks/Q" id="marks" required>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-sm-4">
                                <label>Total Marks</label>
                            </div>
                            <div class="col-sm-6">
                                <input type="text" disabled placeholder="Total Marks" id="tmarks">
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-sm-4">
                                <label>Final Mark</label>
                            </div>
                            <div class="col-sm-6">
                            <input type="text" onkeypress="return event.charCode >=48 && event.charCode<=57 || event.charCode == 46" 
                            name="carry_marks" placeholder="Ender Final Marks" id="carry_marks" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update Marks</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<script>
    $(document).ready(function(){
        var totalQna = 0;
        $('.editMarks').click(function(){
            var exam_id = $(this).attr('data-bs-id');
            var marks = $(this).attr('data-bs-marks');
            var totalq = $(this).attr('data-bs-totalq');
            var carry_marks = $(this).attr('data-bs-carry-marks');

            $('#marks').val(marks);
            $('#carry_marks').val(carry_marks);
            $('#exam_id').val(exam_id);
            $('#tmarks').val((marks*totalq).toFixed(1));

            totalQna = totalq;

        });

        $('#marks').keyup(function(){
            $('#tmarks').val( ($(this).val()*totalQna).toFixed(1) );
        });

        $('#editMarks').submit(function(event){
            event.preventDefault();
            var formData = $(this).serialize();

            $.ajax({
                url: "{{ route('updateMarks') }}",
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