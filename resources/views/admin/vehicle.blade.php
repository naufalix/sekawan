@extends('layouts.admin')

@section('content')

<div class="card mb-2">
  <!--begin::Card Body-->
  <div class="card-body fs-6 py-15 px-10 py-lg-15 px-lg-15 text-gray-700">
    <!--begin::Section-->
    <div>
      <!--begin::Heading-->
      <div class="col-12 d-flex">
        <h1 class="me-auto anchor fw-bolder mb-5" id="striped-rounded-bordered">Data kendaraan</h1>
        <button class="btn btn-success me-3" onClick="dataexport('excel')" style="zoom:75%; height: fit-content">Export</button>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambah" style="zoom:75%; height: fit-content">Tambah</button>
      </div>
      <!--end::Heading-->
      <!--begin::Block-->
      <div class="my-5 table-responsive">
        <table id="myTable" class="table table-striped table-hover table-rounded border gs-7">
          <thead>
            <tr class="fw-bold fs-6 text-gray-800 border-bottom border-gray-200">
              <th class="d-none">Sort</th>
              <th>Nama</th>
              <th style="min-width: 120px">Plat nomor</th>
              <th style="min-width: 120px">Jenis angkutan</th>
              <th style="min-width: 120px">Kepemilikan</th>
              <th style="min-width: 120px">Servis terakhir</th>
              <th style="min-width: 150px">Servis selanjutnya</th>
              <th style="min-width: 90px">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($vehicles as $v)
            @php
              $last_service = date_create($v->last_service);
              $next_service = date_create($v->next_service);
            @endphp
            <tr>
              <td class="d-none">{{$loop->iteration}}</td>
              <td style="min-width: 320px;">
                <div class="symbol symbol-30px me-5" data-bs-toggle="modal" data-bs-target="#foto" onclick="foto('{{ $v->image }}')">
                  <img src="/assets/img/vehicle/{{ $v->image }}" class="h-30 align-self-center of-cover rounded-0" alt="">
                </div>
                {{ $v->name }}  
              </td>
              <td>
                <span class="badge badge-primary">{{ $v->license_plate }}</span>
              </td>
              <td>
                <span class="badge badge-primary">{{ $v->type == 'people' ? 'Orang' : 'Barang' }}</span>
              </td>
              <td>{{ $v->is_owned ? 'Milik perusahaan' : 'Sewa' }}</td>
              <td>{{date_format($last_service,"d F Y")}}</td>
              <td>{{date_format($next_service,"d F Y")}}</td>
              <td>
                <a href="#" class="btn btn-icon btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#edit" onclick="edit({{ $v->id }})"><i class="bi bi-pencil-fill"></i></a>
                <a href="#" class="btn btn-icon btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#hapus" onclick="hapus({{ $v->id }})"><i class="fa fa-times"></i></a>
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
        <h3 class="modal-title">Tambah kendaraan</h3>
        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
          <i class="bi bi-x-lg"></i>
        </div>
      </div>

      <form class="form" method="post" action="" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
          <div class="row g-9">
            <div class="col-12 col-md-8">
              <label class="required fw-bold mb-2">Nama kendaraan</label>
              <input type="text" class="form-control" name="name" required>
            </div>
            <div class="col-12 col-md-4">
              <label class="required fw-bold mb-2">Tipe kendaraan</label>
              <select class="form-control" name="type" required>
                <option value="" disabled selected>- Pilih tipe -</option>
                <option value="people">Angkutan orang</option>
                <option value="goods">Angkutan barang</option>
              </select>
            </div>
            <div class="col-12 col-md-3">
              <label class="required fw-bold mb-2">Plat nomor</label>
              <input type="text" class="form-control" name="license_plate" required>
            </div>
            <div class="col-12 col-md-4">
              <label class="required fw-bold mb-2">Kepemilikan</label>
              <select class="form-control" name="is_owned" required>
                <option value="" disabled selected>- Pilih kepemilikan -</option>
                <option value="1">Milik perusahaan</option>
                <option value="0">Sewa</option>
              </select>
            </div>
            <div class="col-12 col-md-5">
              <label class="required fw-bold mb-2">Upload foto kendaraan</label>
              <input type="file" class="form-control" name="image" required>
            </div>
            <div class="col-12 col-md-4">
              <label class="required fw-bold mb-2">Konsumsi BBM (kilometer/liter)</label>
              <input type="number" class="form-control" name="fuel_consumption" required>
            </div>
            <div class="col-12 col-md-4">
              <label class="required fw-bold mb-2">Servis terakhir</label>
              <input type="date" class="form-control" name="last_service" required>
            </div>
            <div class="col-12 col-md-4">
              <label class="required fw-bold mb-2">Servis berikutnya</label>
              <input type="date" class="form-control" name="next_service" required>
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
          <h3 class="modal-title" id="et">Edit kendaraan</h3>
          <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
            <i class="bi bi-x-lg"></i>
          </div>
        </div>
        <form class="form" method="post" action="" enctype="multipart/form-data">
          @csrf
          <input type="hidden" id="eid" name="id">
          <div class="modal-body">
            <div class="row g-9">
              <div class="col-12 col-md-8">
                <label class="required fw-bold mb-2">Nama kendaraan</label>
                <input type="text" class="form-control" name="name" required>
              </div>
              <div class="col-12 col-md-4">
                <label class="required fw-bold mb-2">Tipe kendaraan</label>
                <select class="form-control" name="type" required>
                  <option value="" disabled selected>- Pilih tipe -</option>
                  <option value="people">Angkutan orang</option>
                  <option value="goods">Angkutan barang</option>
                </select>
              </div>
              <div class="col-12 col-md-3">
                <label class="required fw-bold mb-2">Plat nomor</label>
                <input type="text" class="form-control" name="license_plate" required>
              </div>
              <div class="col-12 col-md-4">
                <label class="required fw-bold mb-2">Kepemilikan</label>
                <select class="form-control" name="is_owned" required>
                  <option value="" disabled selected>- Pilih kepemilikan -</option>
                  <option value="1">Milik perusahaan</option>
                  <option value="0">Sewa</option>
                </select>
              </div>
              <div class="col-12 col-md-5">
                <label class="fw-bold mb-2">Upload foto kendaraan</label>
                <input type="file" class="form-control" name="image">
              </div>
              <div class="col-12 col-md-4">
                <label class="required fw-bold mb-2">Konsumsi BBM (kilometer/liter)</label>
                <input type="number" class="form-control" name="fuel_consumption" required>
              </div>
              <div class="col-12 col-md-4">
                <label class="required fw-bold mb-2">Servis terakhir</label>
                <input type="date" class="form-control" name="last_service" required>
              </div>
              <div class="col-12 col-md-4">
                <label class="required fw-bold mb-2">Servis berikutnya</label>
                <input type="date" class="form-control" name="next_service" required>
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
          <h3 class="modal-title">Hapus kendaraan</h3>
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

<div class="modal fade" tabindex="-1" id="foto">
  <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <h3 class="modal-title" id="ft">View image</h3>
          <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
            <i class="bi bi-x-lg"></i>
          </div>
        </div>
        <div class="modal-body">
          <img id="img-view" src="" style="width:100%">
        </div>
      </div>
  </div>
</div>

<script type="text/javascript">
  function foto(image){
    $("#img-view").attr("src","/assets/img/vehicle/"+image);
  }
  function edit(id){
    $.ajax({
      url: "/api/vehicle/"+id,
      type: 'GET',
      dataType: 'json', // added data type
      success: function(response) {
        var mydata = response.data;
        $('#edit input[name="id"]').val(id);
        $('#edit input[name="name"]').val(mydata.name);
        $('#edit select[name="type"]').val(mydata.type);
        $('#edit input[name="license_plate"]').val(mydata.license_plate);
        $('#edit select[name="is_owned"]').val(mydata.is_owned);
        $('#edit input[name="fuel_consumption"]').val(mydata.fuel_consumption);
        $('#edit input[name="last_service"]').val(mydata.last_service);
        $('#edit input[name="next_service"]').val(mydata.next_service);
        $("#et").text("Edit "+mydata.name);
      }
    });
  }
  function hapus(id){
    $.ajax({
      url: "/api/vehicle/"+id,
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