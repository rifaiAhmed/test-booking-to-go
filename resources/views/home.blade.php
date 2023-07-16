@extends('templates/main')
<meta name="csrf-token" content="{{ csrf_token() }}"/>
{{-- modal add --}}

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Form Add Customer</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label for="name" class="form-label">*Your Name</label>
          <input type="text" class="form-control" id="name" required>
        </div>
        <div class="mb-3">
          <label class="required">Date Of Birth</label>
          <input type="date" id="dob" class="form-control mt-2">
        </div>
        <div class="mb-3">
          <label for="phone" class="form-label">*Phone Number</label>
          <input type="number" class="form-control" id="phone" required>
        </div>
        <div class="mb-3">
          <label for="email" class="form-label">*Email address</label>
          <input type="email" class="form-control" id="email" aria-describedby="emailHelp" required>
        </div>
        <div>
          <label for="nationality" class="form-label">*Nationality</label>
          <select class="form-select" id="nationality" aria-label="Default select example">
            <option selected>Open this select your nationality</option>
            @foreach ($data['nationals'] as $val)
              <option value="{{ $val['nationality_id'] }}">{{ $val['nationality_name'] }} || {{ $val['nationality_code'] }}</option>
            @endforeach
          </select>
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

{{-- emd modal add --}}

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
<h1 class="text-center mt-4">List Data</h1>
<div class="row mt-4">
    <span onclick="addData()" style="cursor: pointer;"><i class="fas fa-sharp fa-solid fa-plus" style="color: #356fd4;"></i>
        Add Data</span>
    <div class="col-12">
        <table class="table">
            <thead>
              <tr>
                <th scope="col" class="text-center">#</th>
                <th scope="col" class="text-center">Nama</th>
                <th scope="col" class="text-center">Kewarganegaraan</th>
                <th scope="col" class="text-center">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php $i = 1; ?>
              @foreach ($data['custs'] as $val)
                <tr>
                  <th scope="row" class="text-center">{{ $i }}</th>
                  <td class="text-center">{{ $val->cst_name }}</td>
                  <td class="text-center">{{ $val->nationality_name }}</td>
                  <td class="text-center">
                    <a href="{{ url('/detail') }}/{{ $val->cst_id }}">
                      <span class="badge bg-success">Views</span>
                    </a>
                    <span style="cursor: pointer;"  onclick="deleteCust({{ $val->cst_id }})" class="badge bg-danger">Delete</span>
                  </td>
                  <?php $i++; ?>
                </tr>
              @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
@section('jquery')
<script>
    function addData() {
      $('#exampleModal').modal('show');
    }

    function insertData() {
      var name = $('#name').val();
      var phone = $('#phone').val();
      var email = $('#email').val();
      var dob = $('#dob').val();
      var nationality = $('#nationality').val();
      if (name == "" || phone == "" || email == "" || nationality == "") {
        Swal.fire(
          'Error?',
          'Please Fiil The form _-',
          'error'
        )
      } else {
        var str = "Name : "+name+"\n"+"Date Of Birth : "+dob+"\n"+"Phone : "+phone+"\n"+"Email : "+email+"\n"+"Nationality : "+nationality+"\n";
        var payload = {
                'name' : name,
                'phone' : phone,
                'email' : email,
                'nationality' : nationality,
                'dob' : dob,
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
                      url: "{{url('insert-cust')}}",
                      type: 'POST',
                      data: payload,
                      headers: {
                          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                      },
                      success: function (response) {
                          // success handling
                          var inputSelectors = 'input[type="text"], input[type="email"], input[type="number"], textarea';
                          var status = response['status'];
                          if (status == "insert") {
                              timeout_modal();
                              Swal.fire(
                                  'Saved!',
                                  'Your data has been saved.',
                                  'success'
                              );
                              $(inputSelectors).val("");
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

    function deleteCust(id)
    {
      Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: "{{url('delete-cust')}}/"+id,
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
</script>
@endsection