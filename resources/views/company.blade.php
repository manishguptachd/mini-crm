@extends('layouts.app')

@section('content')
<style>
    .bt-pd {
        padding-bottom: 4px;
    }
</style>
<div class="container">
    <?php
        // echo "<pre>";
        // print_r($company_list);
    ?>
    <div class="row justify-content-center">
        <div class="col-12">

            <p>Companies</p>

            <!-- Button trigger modal -->
            <button type="button" data-toggle="modal" data-target="#exampleModalCenter" class="btn btn-success mb-3">Create new company</button>

            <div class="card">
                <div class="card-header">
                    Companies list
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Website</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @isset($company_list)
                                @foreach ($company_list as $company)
                                    <tr id="link{{$company['id']}}">
                                        <td>{{ $company['name'] }}</td>
                                        <td>{{ $company['email'] }}</td>
                                        <td>{{ $company['website'] }}</td>
                                        <td>
                                            <button class="btn btn-outline-secondary btn-sm edit-company" data-toggle="modal" data-target="#editData" value="{{$company['id']}}">Edit</button>
                                            <br>
                                            <button class="btn btn-danger btn-sm delete-link" value="{{$company['id']}}">Delete</button>
                                        </td>
                                    </tr>
                                @endforeach
                            @endisset

                           
                        </tbody>
                    </table>
                    {{-- Pagination --}}
                    <div class="d-flex justify-content-center">
                        {!! $company_list->links() !!}
                    </div>
                    
                </div>
            </div>
            
        </div>
        

        <!-- Create Modal -->
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

                    <form id="create_company">
                    {!! csrf_field() !!}
                        <div class="form-group">
                            <label for="cName">Name</label>
                            <input type="text" name="name" class="form-control" id="cName" placeholder="Enter name">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Email address</label>
                            <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                        </div>
                        <div class="form-group">
                            <div class="custom-file">
                                <input type="file" name="file" class="custom-file-input" id="file-upload" accept="image/x-png,image/gif,image/jpeg">
                                <label class="custom-file-label" for="customFile">Choose file</label>
                                <label id="file-name"></label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="cWebsite">Website</label>
                            <input type="text" name="website" class="form-control" id="cWebsite" placeholder="Website">
                        </div>
                        <button type="button" id="submit_company" data-dismiss="modal" class="btn btn-primary">Submit</button>
                    </form>                    
                </div>
            </div>
        </div>
        </div>

        <!-- Edit Modal -->
        <div class="modal fade" id="editData" tabindex="-1" role="dialog" aria-labelledby="editDataTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editDataLongTitle">Edit Company</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <form id="edit_company_form">
                        {!! csrf_field() !!}
                            <input type="hidden" id="comapny_id" value="">
                            <div class="form-group">
                                <label for="cName">Name</label>
                                <input type="text" name="name" class="form-control" id="cName1" placeholder="Enter name">
                                
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Email address</label>
                                <input type="email" name="email" class="form-control" id="cEmail1" aria-describedby="emailHelp" 
                                placeholder="Enter email">
                                <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                            </div>
                            <div class="form-group">
                                <label for="cWebsite">Website</label>
                                <input type="text" name="website" class="form-control" id="cWebsite1" placeholder="Website">
                                
                            </div>
                            <button type="button" id="edit_company" data-dismiss="modal" class="btn btn-primary">Submit</button>
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

        $("#file-upload").change(function(){
            $("#file-name").text(this.files[0].name);
        });

        $("#submit_company").on('click', function(e) {
            e.preventDefault();
            var form = $('#create_company')[0];
            var formData = new FormData(form);
            $.ajax({
                type: "POST",
                enctype: 'multipart/form-data',
                url: "{{ url('create-company') }}",
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

        $('.delete-link').click(function () {
            var link_id = $(this).val();
            console.log(link_id);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "DELETE",
                url: 'company-delete/' + link_id,
                success: function (data) {
                    $("#link" + link_id).remove();
                    alert(data.msg);
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
        });

        $('.edit-company').click(function () {
            var edit_id = $(this).val();
            console.log(edit_id);
            $.ajax({
                type: "GET",
                url: 'company-edit/' + edit_id,
                success: function (data) {
                    console.log(data.data);
                    if(data.success == true)
                    {
                        $('#cName1').val(data.data.name);
                        $('#cEmail1').val(data.data.email);
                        $('#cWebsite1').val(data.data.website);
                        $('#comapny_id').val(edit_id);
                    }
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
        });

        $("#edit_company").on('click', function(e) {
            e.preventDefault();
            var form = $('#edit_company_form')[0];
            var formData = new FormData(form);
            let company_id = $('#comapny_id').val();
            $.ajax({
                type: "POST",
                enctype: 'multipart/form-data',
                url: 'company-update/' + company_id,
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

        var _URL = window.URL || window.webkitURL;
        $("#file-upload").change(function (e) {
            var file, img;
            if ((file = this.files[0])) {
                img = new Image();
                var objectUrl = _URL.createObjectURL(file);
                img.onload = function () {
                    var height = this.height;
                    var width = this.width;
                    if (height > 100 || width > 100) {
                        // alert("Height and Width must not exceed 100px.");
                        $('#file-upload').val("");
                        $("#file-name").text("Height and Width must not exceed 100px.");
                        return false;
                    }
                    // alert("Uploaded image has valid Height and Width.");
                    return false;
                    // _URL.revokeObjectURL(objectUrl);
                };
                img.src = objectUrl;
            }
        });
    } );
</script>
@endsection
