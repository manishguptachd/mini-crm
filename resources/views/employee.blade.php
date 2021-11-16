@extends('layouts.app')

@section('content')
<style>
    .bt-pd {
        padding-bottom: 4px;
    }
</style>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">

            <p>Employees</p>

            <!-- Button trigger modal -->
            <button type="button" data-toggle="modal" data-target="#exampleModalCenter" class="btn btn-success mb-3">Create new employee</button>

            <div class="card">
                <div class="card-header">
                    Employees list
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">First name</th>
                                <th scope="col">Last name</th>
                                <th scope="col">Company</th>
                                <th scope="col">Phone</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @isset($employee_list)
                                @foreach ($employee_list as $employee)
                                    <tr id="link_{{$employee->id}}">
                                        <td>{{ $employee->first_name }}</td>
                                        <td>{{ $employee->last_name }}</td>
                                        <td>{{ $employee->companies['email'] }}</td>
                                        <td>{{ $employee->phone }}</td>
                                        <td>
                                            <button class="btn btn-outline-secondary btn-sm edit-employee" data-toggle="modal" data-target="#editData" value="{{$employee->id}}">Edit</button>
                                            <br>
                                            <button class="btn btn-danger btn-sm delete-emp" value="{{$employee->id}}">Delete</button>
                                        </td>
                                    </tr>
                                @endforeach
                            @endisset
                        </tbody>
                    </table>

                    {{-- Pagination --}}
                    <div class="d-flex justify-content-center">
                        {!! $employee_list->links() !!}
                    </div>
                </div>
            </div>
            
        </div>
        

        <!-- Create Employee Modal -->
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Create Company</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form id="create_employee">
                    {!! csrf_field() !!}
                        <div class="form-group">
                            <label for="efName">First Name</label>
                            <input type="text" name="f_name" class="form-control" id="efName" placeholder="Enter first name">
                        </div>
                        <div class="form-group">
                            <label for="elName">Last Name</label>
                            <input type="text" name="l_name" class="form-control" id="elName" placeholder="Enter last name">
                        </div>
                        <div class="form-group mt-3">
                            <label for="exampleFormControlSelect2">Company select</label>
                            <select class="form-control" id="companyEmail" name="companyEmail">
                            <option value=""> -- Select One --</option>
                                @if (count($company_email) > 0)

                                    @foreach($company_email as $cEmail)
                                        <option value="{{ $cEmail['id'] }}">{{ $cEmail['email'] }}</option>    
                                    @endForeach
                                @else
                                    No Record Found
                                @endif 

                            </select>
                        </div>
                        <div class="form-group">
                            <label for="ePhone">Phone</label>
                            <input type="text" name="phone" class="form-control" id="ePhone" placeholder="Phone">
                        </div>
                        <button type="button" id="submit_employee" data-dismiss="modal" class="btn btn-primary">Submit</button>
                    </form>                    
                </div>
            </div>
        </div>
        </div>

        <!-- Edit Employee Modal -->
        <div class="modal fade" id="editData" tabindex="-1" role="dialog" aria-labelledby="editDataTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editDataLongTitle">Edit Employee</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <form id="edit_employee_form">
                        {!! csrf_field() !!}
                            <input type="hidden" id="employee_id" value="">
                            <div class="form-group">
                                <label for="eFName">Name</label>
                                <input type="text" name="eFname" class="form-control" id="eFName" placeholder="Enter first name">
                            </div>

                            <div class="form-group">
                                <label for="eLName">Name</label>
                                <input type="text" name="eLname" class="form-control" id="eLName" placeholder="Enter last name">
                            </div>

                            <div class="form-group mt-3">
                                <label for="exampleFormControlSelect2">Company select</label>
                                <select class="form-control" id="companyEmail1" name="companyEmail1">
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="ePhone1">Phone</label>
                                <input type="text" name="phone1" class="form-control" id="ePhone1" placeholder="Phone">
                            </div>
                            <button type="button" id="edit_employee" data-dismiss="modal" class="btn btn-primary">Submit</button>
                        </form>                    
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function() {

        $("#submit_employee").on('click', function(e) {
            e.preventDefault();
            var form = $('#create_employee')[0];
            var formData = new FormData(form);
            $.ajax({
                type: "POST",
                enctype: 'multipart/form-data',
                url: "{{ url('create-employee') }}",
                data: formData,
                processData: false,
                contentType: false,
                dataType: "json",
                success: function(res) {
                    alert(res.msg);
                    window.location.reload();
                    console.log(res);
                },
                error: function(error) {
                    alert(error);
                }
            });
        });

        $('.delete-emp').click(function (e) {
            e.preventDefault();
            let link_id = $(this).val();
            console.log(link_id);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "DELETE",
                url: 'employee-delete/' + link_id,
                success: function (data) {
                    $("#link_" + link_id).remove();
                    alert(data.msg);
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
        });

        $('.edit-employee').click(function (e) {
            e.preventDefault();
            let edit_id = $(this).val();
            console.log(edit_id);
            $.ajax({
                type: "GET",
                url: 'employee-edit/' + edit_id,
                success: function (data) {
                    console.log(data.data);
                    if(data.success == true)
                    {
                        $('#eFName').val(data.data.first_name);
                        $('#eLName').val(data.data.last_name);
                        // $('#companyEmail1').val();
                        var selectOption = $('#companyEmail1');
                        console.log(data.data.companies.email);
                        selectOption.append(
                                $('<option></option>').val(data.data.companies.id).html(data.data.companies.email)
                            );
                        // $.each(data.data.companies, function (val, text) {
                        //     console.log(val);
                            
                        // });
                        $('#ePhone1').val(data.data.phone);
                        $('#employee_id').val(edit_id);
                    }
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
        });

        $("#edit_employee").on('click', function(e) {
            e.preventDefault();
            var form = $('#edit_employee_form')[0];
            var formData = new FormData(form);
            let employee_id = $('#employee_id').val();
            $.ajax({
                type: "POST",
                enctype: 'multipart/form-data',
                url: 'employee-update/' + employee_id,
                data: formData,
                processData: false,
                contentType: false,
                dataType: "json",
                success: function(res) {
                    console.log(res);
                    if(res.success == true)
                    {
                        alert(res.msg);
                        window.location.reload();
                        console.log(res);
                    }
                },
                error: function(error) {
                    alert(error);
                    console.log(error);
                }
            });
        });
    } );
</script>
@endsection
