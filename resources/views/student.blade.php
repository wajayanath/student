@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-9">
            <table class="table">
                <thead>
                    <tr>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Address</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="data">
                </tbody>
            </table>
        </div>
        <div class="col-md-3">
            <div class="alert alert-danger" style="display: none;">ERROR</div>
            {!! Form::open(['url' => 'student', 'method' => 'post', 'id' => 'formData']) !!}
            <div class="form-group">
                <label for="name">First Name</label>
                {!! Form::text('first_name', null, ['class' => 'form-control', 'id' => 'first_name']) !!}
            </div> 
            <div class="form-group">
                <label for="lastname">Last Name</label>
                {!! Form::text('last_name', null, ['class' => 'form-control', 'id' => 'last_name']) !!}
            </div>
            <div class="form-group">
                <label for="address">Address</label>
                {!! Form::text('stu_address', null, ['class' => 'form-control', 'id' => 'stu_address']) !!}
                {!! Form::hidden('id', null, ['disabled' => '', 'id' => 'studentID']) !!}
            </div>
            <button type="submit" class="btn btn-default" id="create">create</button>
            <button type="submit" class="btn btn-default" id="update" style="display: none;">update</button>
            {!! Form::close() !!}
        </div>
    </div>
 
</div>
@endsection

@section('script')
<script type="text/javascript">
    $(document).ready(function() {
        getAll();

        $('#create').click(function(event) {
            event.preventDefault();
            save();
        });

        $('#update').click(function(event) {
            event.preventDefault();
            id = $('#studentID').val();
            update(id);
        });

        $('#data').on('click', '.btn-danger', function() {
            id = $(this).data('id');
            destroy(id);
        });

        $('#data').on('click', '.btn-info', function() {
            id = $(this).data('id');
            edit(id);
        });

    });


    function getAll() {
        $("#data").empty();
        $.ajax({ 
            url: '{{ url('student') }}',
            type: 'GET',
        })
        .done(function(data) {
            $.each(data, function(index, val) {
                 $('#data').append('<tr>')
                 $('#data').append('<td>'+val.first_name+'</td>')
                 $('#data').append('<td>'+val.last_name+'</td>')
                 $('#data').append('<td>'+val.stu_address+'</td>')
                 $('#data').append('<td><button class="btn btn-sm btn-danger" data-id="'+val.id+'">Delete</button><button class="btn btn-sm btn-info" data-id="'+val.id+'">Edit</button></td>')
                 $('#data').append('</tr>')
            });
        })
        .fail(function () {
            console.log("error");
        })
    }

    function save() {
        formData = $('#formData').serializeArray();
        console.log(formData);
        $.ajax({
            url: '{{ url('student') }}',
            type: 'POST',
            dataType: 'JSON',
            data: formData,
        })
        .done(function() {
            document.getElementById("formData").reset();
            getAll();
        })
        .fail(function() {
            $('alert').show();
        })
    }

    function destroy(id) {
        $.ajax({
                url: '{{ url('student/delete') }}/'+id,
                type: 'DELETE',
                dataType: 'JSON',
                data: {_token: '{{ csrf_token() }}'},
            })
            .done(function() {
                getAll();
            })
            .fail(function() {
                 $('alert').show();
            }) 
    }

    function edit(id) {
        $.ajax({
            url: '{{ url('student/edit') }}/'+id,
            type: 'GET',
        })
        .done(function(data) {

            $('#first_name').val(data.first_name);
            $('#last_name').val(data.last_name);
            $('#stu_address').val(data.stu_address);
            $('#studentID').val(data.id);

            $('#create').hide();
            $('#update').show();
        })
        .fail(function() {
           $('alert').show();
        })
    }

    function update(id) {
        formData = $('#formData').serializeArray();
        console.log(formData);
        $.ajax({
            url: '{{ url('student/update') }}/'+id,
            type: 'POST',
            dataType: 'JSON',
            data: formData,
        })
        .done(function() {
            getAll();
            document.getElementById("formData").reset();
            $('#create').show();
            $('#update').hide();
        })
        .fail(function() {
            console.log("error");
        })
        .always(function() {
            console.log("complete");
        });
        
    }

</script>
@endsection