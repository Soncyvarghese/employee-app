@extends('layouts.master')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="alert alert-success" style="display:none">
</div>
<h4>Employee List</h4>
<a class="btn btn-info" href="javascript:void(0)" id="createEmployee"> Add Employee</a>
<div class="container col-sm-10">
    <table class="table table-bordered data-table hover">
        <thead>
            <tr>
                <th>Emp.Id</th>
                <th>Username</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Gender</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
<div class="modal fade" id="ajaxModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading" style="margin:auto;"></h4>
            </div>
            <div class="modal-body">
                <form id="postForm" name="postForm" class="form-horizontal">
                    <div class="alert alert-danger print-error-msg" style="display:none">
                        <ul></ul>
                    </div>
                    <input type="hidden" name="id" id="id">
                    <div class="form-group">
                        <div class="col-sm-12">
                            <label style="float:left;">Username</label>
                            <input type="text" class="form-control" id="name" name="name"  value="" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <label style="float:left;">Email</label>
                            <input type="text" class="form-control" id="email" name="email"  value="" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <label style="float:left;">Phone</label>
                            <input type="text" class="form-control" id="phone" name="phone"  value="" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <label style="float:left;">Gender</label>
                            <select  class="form-control" id="gender" name="gender"  required>
                                <option value="">Please Select</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                    <div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary" id="savedata" value="create" style="float:right;">Save
                        </button>
                    </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
  $(function () {
    $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
    });
    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('list') }}",
        columns: [
            {data: 'id', name: 'id'},
            {data: 'name', name: 'name'},
            {data: 'email', name: 'email'},
            {data: 'phone', name: 'phone'},
            {data: 'gender', name: 'gender'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ],
        columnDefs: [ {
            'targets': [3,4],
            'orderable': false,
        }]
    });

    $('#createEmployee').click(function () {
        $('#savedata').val("create-employee");
        $('#id').val('');
        $('#postForm').trigger("reset");
        $('#modelHeading').html("Add Employee");
        $('#ajaxModel').modal('show');
    });
    
    $('#savedata').click(function (e) {
        e.preventDefault();
        $.ajax({
          data: $('#postForm').serialize(),
          url: "createEmployee",
          type: "POST",
          dataType: 'json',
          success: function (data) {
            if(data.success){
                $('#ajaxModel').modal('hide');
                table.draw();
                $(".alert-success").css('display','block');
                $(".alert-success").html(data.success);
            }else{
                printErrorMsg(data.errors);
            }
            setTimeout(() => {
                $(".alert-success").css('display','none');
            }, 2000);
         },
      });
    });

    $('body').on('click', '.editEmployee', function () {
      var id = $(this).data('id');
      $.get("editEmployee" +'/' + id, function (data) {
          $('#modelHeading').html("Edit Employee");
          $('#savedata').val("edit-employee");
          $('#ajaxModel').modal('show');
          $(".print-error-msg").find("ul").html('');
          $(".print-error-msg").css('display','none');
          $('#id').val(data.id);
          $('#name').val(data.name);
          $('#email').val(data.email);
          $('#phone').val(data.phone);
          $('#gender').val(data.gender);
      })
   });

    $('body').on('click', '.deleteEmployee', function () {
     
     var id = $(this).data("id");
     confirm("Are You sure want to delete this entry!");
     $.ajax({
         type: "GET",
         url:"deleteEmployee/" + id,
         success: function (data) {
             table.draw();
             $(".alert-success").css('display','block');
             $(".alert-success").html(data.success);
         },
         error: function (data) {
             console.log('Error:', data);
         }
     });
     setTimeout(() => {
                $(".alert-success").css('display','none');
            }, 2000);
    });
  });
  function printErrorMsg (msg) {
    $(".print-error-msg").find("ul").html('');
    $(".print-error-msg").css('display','block');
    $.each( msg, function( key, value ) {
        $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
    });
    setTimeout(() => {
            $(".print-error-msg").css('display','none');
        }, 2000);
    }
</script>
@endsection
