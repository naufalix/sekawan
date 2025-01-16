@extends('layouts.admin')

@section('content')

<div class="card mb-2">
  <!--begin::Card Body-->
  <div class="card-body fs-6 py-15 px-10 py-lg-15 px-lg-15 text-gray-700">
    <!--begin::Section-->
    <div>
      <!--begin::Heading-->
      <div class="col-12 d-flex">
        <h1 class="me-auto anchor fw-bolder mb-5" id="striped-rounded-bordered">Data riwayat pemakaian</h1>
        <a class="btn btn-primary btn-sekawan me-3" href="/admin/excel/vehicle_usage" target="_blank" style="zoom:75%; height: fit-content">
          <i class="mdi mdi-download fs-2"></i>Export
        </a>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambah" style="zoom:75%; height: fit-content">Tambah</button>
      </div>
      <!--end::Heading-->
      <!--begin::Block-->
      <div class="my-5 table-responsive">
        <table id="myTable" class="table table-striped table-hover table-rounded border gs-7">
          <thead>
            <tr class="fw-bold fs-6 text-gray-800 border-bottom border-gray-200">
              <th class="width: 30px">No</th>
              <th>Reservasi</th>
              <th style="min-width: 180px">Kendaraan</th>
              <th style="min-width: 150px">Jarak & Pemakaian BBM</th>
              <th style="min-width: 220px">Waktu pemakaian</th>
              <th style="min-width: 90px">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($vehicle_usages as $vu)
            @php
              $st = date_create($vu->start_time);
              $et = date_create($vu->end_time);
            @endphp
            <tr>
              <td class="">{{$loop->iteration}}</td>
              <td>{{ $vu->reservation->purpose }}  </td>
              <td>{{ $vu->vehicle->name }}  </td>
              <td>
                <span class="badge badge-primary">{{ $vu->distance_covered }} km</span>
                <span class="badge badge-primary">{{ $vu->fuel_used }} liter</span>
              </td>
              <td>
                <p class="mb-0"><b>Mulai : </b> {{date_format($st,"d F Y H:i")}}</p>
                <p class="mb-0"><b>Selesai : </b> {{date_format($et,"d F Y H:i")}}</p>  
              </td>
              <td>
                <a href="#" class="btn btn-icon btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#edit" onclick="edit({{ $vu->id }})"><i class="bi bi-pencil-fill"></i></a>
                <a href="#" class="btn btn-icon btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#hapus" onclick="hapus({{ $vu->id }})"><i class="fa fa-times"></i></a>
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
        <h3 class="modal-title">Tambah riwayat</h3>
        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
          <i class="bi bi-x-lg"></i>
        </div>
      </div>

      <form class="form" method="post" action="" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
          <div class="row g-9">
            <div class="col-12">
              <label class="required fw-bold mb-2">Pilih reservasi</label>
              <select class="form-control form-select" name="reservation_id" required>
                <option value="" disabled selected>- Pilih tipe -</option>
                @foreach ($reservations as $r)
                  <option value="{{$r->id}}">{{$r->purpose}}</option>
                @endforeach
              </select>
            </div>
            <div class="col-12 col-md-6">
              <label class="required fw-bold mb-2">Jarak tempuh (km)</label>
              <input type="number" step="0.1" class="form-control" name="distance_covered" required>
            </div>
            <div class="col-12 col-md-6">
              <label class="required fw-bold mb-2">Pemakaian BBM (liter)</label>
              <input type="number" step="0.1" class="form-control" name="fuel_used" required>
            </div>
            <div class="col-12 col-md-6">
              <label class="required fw-bold mb-2">Waktu mulai pemakaian</label>
              <input type="datetime-local" class="form-control" name="start_time" required>
            </div>
            <div class="col-12 col-md-6">
              <label class="required fw-bold mb-2">Waktu selesai pemakaian</label>
              <input type="datetime-local" class="form-control" name="end_time" required>
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
          <h3 class="modal-title" id="et">Edit riwayat pemakaian kendaraan</h3>
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
                <label class="required fw-bold mb-2">Pilih reservasi</label>
                <select class="form-control form-select" name="reservation_id" required>
                  <option value="" disabled selected>- Pilih tipe -</option>
                  @foreach ($reservations as $r)
                    <option value="{{$r->id}}">{{$r->purpose}}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-12 col-md-6">
                <label class="required fw-bold mb-2">Jarak tempuh (km)</label>
                <input type="number" step="0.1" class="form-control" name="distance_covered" required>
              </div>
              <div class="col-12 col-md-6">
                <label class="required fw-bold mb-2">Pemakaian BBM (liter)</label>
                <input type="number" step="0.1" class="form-control" name="fuel_used" required>
              </div>
              <div class="col-12 col-md-6">
                <label class="required fw-bold mb-2">Waktu mulai pemakaian</label>
                <input type="datetime-local" class="form-control" name="start_time" required>
              </div>
              <div class="col-12 col-md-6">
                <label class="required fw-bold mb-2">Waktu selesai pemakaian</label>
                <input type="datetime-local" class="form-control" name="end_time" required>
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
          <h3 class="modal-title">Hapus riwayat pemakaian kendaraan</h3>
          <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
            <i class="bi bi-x-lg"></i>
          </div>
        </div>
        <form class="form" method="post" action="">
          @csrf
          <div class="modal-body text-center">
            <input type="hidden" class="d-none" id="hi" name="id">
            <p class="fw-bold mb-2 fs-4" id="hd">Apakah anda yakin ingin menghapus data ini?</p>
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
      url: "/api/vehicle_usage/"+id,
      type: 'GET',
      dataType: 'json', // added data type
      success: function(response) {
        var mydata = response.data;
        $('#edit input[name="id"]').val(id);
        $('#edit select[name="reservation_id"]').val(mydata.reservation_id);
        $('#edit input[name="distance_covered"]').val(mydata.distance_covered);
        $('#edit input[name="fuel_used"]').val(mydata.fuel_used);
        $('#edit input[name="start_time"]').val(mydata.start_time);
        $('#edit input[name="end_time"]').val(mydata.end_time);
        // $("#et").text("Edit "+mydata.name);
      }
    });
  }
  function hapus(id){
    $.ajax({
      url: "/api/vehicle_usage/"+id,
      type: 'GET',
      dataType: 'json', // added data type
      success: function(response) {
        //alert(JSON.stringify(mydata));
        var mydata = response.data;
        $("#hi").val(id);
        // $("#hd").text("Apakah anda yakin ingin menghapus "+mydata.name+"?");
      }
    });
  }
</script>
@endsection