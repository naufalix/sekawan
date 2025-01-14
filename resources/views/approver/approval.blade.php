@extends('layouts.approver')

@section('content')

<div class="card mb-2">
  <!--begin::Card Body-->
  <div class="card-body fs-6 py-15 px-10 py-lg-15 px-lg-15 text-gray-700">
    <!--begin::Section-->
    <div>
      <!--begin::Heading-->
      <div class="col-12 d-flex">
        <h1 class="anchor fw-bolder mb-5" id="striped-rounded-bordered">Data persetujuan reservasi</h1>
      </div>
      <!--end::Heading-->
      <!--begin::Block-->
      <div class="my-5 table-responsive">
        <table id="myTable" class="table table-striped table-hover table-rounded border gs-7">
          <thead>
            <tr class="fw-bold fs-6 text-gray-800 border-bottom border-gray-200">
              <th class="width: 30px">No</th>
              <th style="min-width: 120px">Tujuan</th>
              <th style="min-width: 200px">Driver/Kendaraan</th>
              <th style="min-width: 200px">Tanggal</th>
              <th>Satus</th>
              <th style="min-width: 150px">Komentar</th>
              <th style="min-width: 90px">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($approvals as $a)
            @php
              $updated = date_create($a->updated_at);
              $sd = date_create($a->reservation->start_date);
              $ed = date_create($a->reservation->end_date);
            @endphp
            <tr>
              <td class="">{{$loop->iteration}}</td>
              <td style="min-width: 100px;">{{ $a->reservation->purpose }}  </td>
              <td>
                <p class="mb-0"><b>Driver : </b> {{ $a->reservation->driver->name }}</p>
                <p class="mb-0"><b>Kendaraan : </b> {{ $a->reservation->vehicle->name }}</p>  
              </td>
              <td>
                <p class="mb-0"><b>Tanggal mulai : </b> {{date_format($sd,"d/m/Y")}}</p>
                <p class="mb-0"><b>Tanggal selesai : </b> {{date_format($ed,"d/m/Y")}}</p>  
              </td>
              <td>
                <span class="badge 
                    @if($a->status == 'pending') badge-warning 
                    @elseif($a->status == 'approved') badge-success 
                    @elseif($a->status == 'rejected') badge-danger 
                    @else badge-primary 
                    @endif">
                    {{ ucfirst($a->status) }}
                </span>
              </td>
              <td>{{ $a->comment }}</td>
              <td>
                <a href="#" class="btn btn-icon btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#edit" onclick="edit({{ $a->id }})"><i class="bi bi-pencil-fill"></i></a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <!--end::Block-->
    </div>
    <!--end::Section-->
  </div>
  <!--end::Card Body-->
</div>

<div class="modal fade" tabindex="-1" id="edit">
  <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <h3 class="modal-title" id="et">Edit persetujuan</h3>
          <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
            <i class="bi bi-x-lg"></i>
          </div>
        </div>
        <form class="form" method="post" action="" enctype="multipart/form-data">
          @csrf
          <input type="hidden" id="eid" name="id">
          <div class="modal-body">
            <div class="row g-9">
              <div class="col-12">
                <div class="d-flex">
                  <p class="badge badge-primary fs-4 mx-auto">
                    Anda sebagai approver level <span id="level"></span>
                  </p>
                </div>
                <br>
                <label class="required fw-bold mb-2">Status verivikasi</label>
                <select class="form-control form-select" name="status" required>
                  <option value="pending">Pending</option>
                  <option value="approved">Approved</option>
                  <option value="rejected">Rejected</option>
                </select>
              </div>
              <div class="col-12">
                <label class="required fw-bold mb-2">Catatan</label>
                <input type="text" class="form-control" name="comment" required>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary" name="submit" value="update">Simpan</button>
          </div>
        </form>
      </div>
  </div>
</div>

<script type="text/javascript">
  function edit(id){
    $.ajax({
      url: "/api/reservation_approval/"+id,
      type: 'GET',
      dataType: 'json', // added data type
      success: function(response) {
        var mydata = response.data;
        $('#edit input[name="id"]').val(id);
        $('#edit input[name="comment"]').val(mydata.comment);
        $('#edit select[name="status"]').val(mydata.status);
        $("#level").text(mydata.approval_level);
      }
    });
  }
</script>
@endsection