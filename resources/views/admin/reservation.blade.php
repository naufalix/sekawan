@extends('layouts.admin')

@section('content')

<div class="card mb-2">
  <!--begin::Card Body-->
  <div class="card-body fs-6 py-15 px-10 py-lg-15 px-lg-15 text-gray-700">
    <!--begin::Section-->
    <div>
      <!--begin::Heading-->
      <div class="col-12 d-flex">
        <h1 class="anchor fw-bolder mb-5" id="striped-rounded-bordered">Data reservasi kendaraan</h1>
        <button class="ms-auto btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambah">Tambah</button>
      </div>
      <!--end::Heading-->
      <!--begin::Block-->
      <div class="my-5 table-responsive">
        <table id="myTable" class="table table-striped table-hover table-rounded border gs-7">
          <thead>
            <tr class="fw-bold fs-6 text-gray-800 border-bottom border-gray-200">
              <th class="width: 30px">No</th>
              <th>Keperluan reservasi</th>
              <th style="min-width: 120px">Kendaraan/Driver</th>
              <th style="min-width: 150px">Tanggal</th>
              <th style="min-width: 120px">Status</th>
              <th style="min-width: 120px">Approver 1</th>
              <th style="min-width: 120px">Approver 2</th>
              <th style="min-width: 90px">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($reservations as $r)
            @php
              $updated = date_create($r->updated_at);
            @endphp
            <tr>
              <td class="">{{$loop->iteration}}</td>
              <td>{{ $r->purpose }}  </td>
              <td>{{ $r->vehicle->name }}</td>
              <td>
                <span class="badge badge-primary">{{ $r->license_number }}</span>
              </td>
              <td>
                <span class="badge badge-success">{{ $r->phone }}</span>
              </td>
              <td>{{date_format($updated,"d F Y")}}</td>
              <td>
                <a href="#" class="btn btn-icon btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#edit" onclick="edit({{ $r->id }})"><i class="bi bi-pencil-fill"></i></a>
                <a href="#" class="btn btn-icon btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#hapus" onclick="hapus({{ $r->id }})"><i class="fa fa-times"></i></a>
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

<div class="modal fade" tabindex="-1" id="tambah">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title">Tambah reservasi</h3>
        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
          <i class="bi bi-x-lg"></i>
        </div>
      </div>

      <form class="form" method="post" action="" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
          <div class="row g-9">
            <div class="col-12 col-md-6">
              <label class="required fw-bold mb-2">Keperluan reservasi</label>
              <input type="text" class="form-control" name="purpose" required>
            </div>
            <div class="col-12 col-md-6">
              <label class="required fw-bold mb-2">Nomor telepon</label>
              <input type="text" class="form-control" name="phone" required>
            </div>
            <div class="col-12 col-md-6">
              <label class="required fw-bold mb-2">Kantor cabang</label>
              <select class="form-control" name="office_id" required>
                <option value="" disabled selected>- Pilih tipe -</option>
                {{-- @foreach ($offices as $o)
                  <option value="{{$o->id}}">{{$o->name}}</option>
                @endforeach --}}
              </select>
            </div>
            <div class="col-12 col-md-6">
              <label class="required fw-bold mb-2">Nomor SIM</label>
              <input type="text" class="form-control" name="license_number" required>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary" name="submit" value="store">Submit</button>
        </div>
      </form>  
      
    </div>
  </div>
</div>

<div class="modal fade" tabindex="-1" id="edit">
  <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h3 class="modal-title" id="et">Edit driver</h3>
          <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
            <i class="bi bi-x-lg"></i>
          </div>
        </div>
        <form class="form" method="post" action="" enctype="multipart/form-data">
          @csrf
          <input type="hidden" id="eid" name="id">
          <div class="modal-body">
            <div class="row g-9">
              <div class="col-12 col-md-6">
                <label class="required fw-bold mb-2">Nama driver</label>
                <input type="text" class="form-control" name="name" required>
              </div>
              <div class="col-12 col-md-6">
                <label class="required fw-bold mb-2">Nommor telepon</label>
                <input type="text" class="form-control" name="phone" required>
              </div>
              <div class="col-12 col-md-6">
                <label class="required fw-bold mb-2">Kantor cabang</label>
                <select class="form-control" name="office_id" required>
                  <option value="" disabled selected>- Pilih tipe -</option>
                  {{-- @foreach ($offices as $o)
                    <option value="{{$o->id}}">{{$o->name}}</option>
                  @endforeach --}}
                </select>
              </div>
              <div class="col-12 col-md-6">
                <label class="required fw-bold mb-2">Nomor SIM</label>
                <input type="text" class="form-control" name="license_number" required>
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

<div class="modal fade" tabindex="-1" id="hapus">
  <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h3 class="modal-title">Hapus driver</h3>
          <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
            <i class="bi bi-x-lg"></i>
          </div>
        </div>
        <form class="form" method="post" action="">
          @csrf
          <div class="modal-body text-center">
            <input type="hidden" class="d-none" id="hi" name="id">
            <p class="fw-bold mb-2 fs-4" id="hd">Apakah anda yakin ingin menghapus artikel ini?</p>
          </div>
          <div class="modal-footer">
            <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-danger" name="submit" value="destroy">Hapus</button>
          </div>
        </form>
      </div>
  </div>
</div>


<script type="text/javascript">
  function edit(id){
    $.ajax({
      url: "/api/driver/"+id,
      type: 'GET',
      dataType: 'json', // added data type
      success: function(response) {
        var mydata = response.data;
        $('#edit input[name="id"]').val(id);
        $('#edit input[name="name"]').val(mydata.name);
        $('#edit input[name="phone"]').val(mydata.phone);
        $('#edit select[name="office_id"]').val(mydata.office_id);
        $('#edit input[name="license_number"]').val(mydata.license_number);
        $("#et").text("Edit "+mydata.name);
      }
    });
  }
  function hapus(id){
    $.ajax({
      url: "/api/driver/"+id,
      type: 'GET',
      dataType: 'json', // added data type
      success: function(response) {
        //alert(JSON.stringify(mydata));
        var mydata = response.data;
        $("#hi").val(id);
        $("#hd").text("Apakah anda yakin ingin menghapus "+mydata.name+"?");
      }
    });
  }
</script>
@endsection