@extends('templates/main')
<meta name="csrf-token" content="{{ csrf_token() }}"/>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Form Add Family</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="name" class="form-label">*Name</label>
            <input type="text" class="form-control" id="name" required>
          </div>
          <div class="mb-3">
            <label for="relation" class="form-label">*Relation</label>
            <input type="text" class="form-control" id="relation" required>
          </div>
          <div class="mb-3">
            <label class="required">Date Of Birth</label>
            <input type="date" id="dob" class="form-control mt-2">
          </div>
        </div>
        <div class="text-center">
          <div class="form-text fst-italic">We'll never share your data with anyone else.</div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" onclick="insertData()" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
</div>

{{-- loading --}}
<div class="modal fade" id="modal-loading" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Please wait...</h4>
            </div>
            <div class="modal-body">
                <div class="d-flex justify-content-center">
                    <div class="spinner-border" role="status">
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>

@section('container')
<h1 class="text-center mt-4">Detail Data</h1>
<div class="row mt-4">
    <div class="col-3"></div>
    <div class="col-6">
        <div class="mb-3" hidden>
            <label for="cst_id" class="form-label">Name</label>
            <input type="text" class="form-control" id="cst_id" readonly value="{{ $data['customer']['cst_id'] }}">
        </div>
        <div class="mb-3">
            <label for="name_cst" class="form-label">Name</label>
            <input type="text" class="form-control" id="name_cst" readonly value="{{ $data['customer']['cst_name'] }}">
        </div>
        <div class="mb-3">
            <label class="required">Date Of Birth</label>
            <input type="date" id="dob_cst" class="form-control mt-2" value="{{ $data['customer']['cst_dob'] }}" readonly>
        </div>
        <div class="mb-3">
            <label for="nationality_cst" class="form-label">Nationality</label>
            <input type="text" class="form-control" id="nationality_cst" readonly value="{{ $data['customer']['nationality_name'] }}">
        </div>
    </div>
    <div class="col-3"></div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex bd-highlight">
                    <div class="p-2 w-100 bd-highlight">Familys</div>
                    <div class="p-2 flex-shrink-0 bd-highlight" style="cursor: pointer;" onclick="addData()"><i class="fas fa-sharp fa-solid fa-plus" style="color: #356fd4;"></i>
                        Add Data</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-1"></div>
    <div class="col-10">
        @foreach ($data['familys'] as $val)
        <div class="row">
            <div class="col-sm-5">
                <div class="mb-3">
                    <label for="name{{ $val->fi_id }}" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name{{ $val->fi_id }}" required value="{{ $val->fi_name }}">
                </div>
            </div>
            <div class="col-sm-5">
                <div class="mb-3">
                    <label class="required">Date Of Birth</label>
                    <input type="date" id="dob" class="form-control mt-2" value="{{ $val->fi_dob }}">
                </div>
            </div>
            <div class="col-sm-2 d-flex align-items-center">
                <button type="button" class="btn btn-danger mt-3" onclick="deleteFam({{ $val->fi_id }})">Delete</button>
            </div>
        </div>
        @endforeach
    </div>
    <div class="col-1"></div>
</div>
@endsection

@section('jquery')
<script>
    function deleteFam(id) {
        var com = '#name'+id
        var name = $(com).val();

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to delete "+name,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                      url: "{{url('delete')}}/"+id,
                      type: 'GET',
                      headers: {
                          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                      },
                      success: function (response) {
                          // success handling
                          var status = response['status'];
                          if (status == "insert") {
                              Swal.fire(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                                );
                              setTimeout(function() {
                                  location.reload();
                              }, 1000);
                          } else {
                              Swal.fire({
                                  icon: 'error',
                                  title: 'Oops...',
                                  text: 'Failed to delete!'
                              })
                          }
                      },
                      error: function (xhr) {
                          // error handling
                      }
                });
            }
        })
    }

    function addData() {
      $('#exampleModal').modal('show');
    }

    function insertData()
    {
        var cst_id = $('#cst_id').val();
        var name = $('#name').val();
        var dob = $('#dob').val();
        var relation = $('#relation').val();

        if (name == "" || dob == "" || cst_id == "") {
            Swal.fire(
            'Error?',
            'Please Fiil The form _-',
            'error'
            );
        } else {
            var str = "Name : "+name+"\n"+"Relation : "+relation+"\n"+"Date Of Birth : "+dob;

            var payload = {
                'cst_id' : cst_id,
                'name' : name,
                'dob' : dob,
                'relation' : relation,
            };

            Swal.fire({
              title: 'Are you sure?',
              text: "This data want to insert to database!",
              html: '<pre>' + str + '</pre>',
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes, save it!'
              }).then((result) => {
                if (result.isConfirmed) {
                    $('#exampleModal').modal('hide');
                    $('#modal-loading').modal('show');
                    $.ajax({
                        url: "{{url('insert-fam')}}",
                        type: 'POST',
                        data: payload,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (response) {
                            // success handling
                            var status = response['status'];
                            if (status == "insert") {
                                timeout_modal();
                                Swal.fire(
                                    'Saved!',
                                    'Your data has been saved.',
                                    'success'
                                );

                                setTimeout(function() {
                                    location.reload();
                                }, 1000);
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Failed to insert!'
                                })
                            }
                        },
                        error: function (xhr) {
                            // error handling
                        }
                    });
                }
            })
        }
    }

    function timeout_modal() {
        setTimeout(function () {
            $('#modal-loading').modal('hide');
        }, 1000);
    }
</script>
@endsection