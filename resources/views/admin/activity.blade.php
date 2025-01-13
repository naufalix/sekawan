@extends('layouts.dashboard')

@section('content')

<div class="card mb-2">
  <!--begin::Card Body-->
  <div class="card-body fs-6 py-15 px-10 py-lg-15 px-lg-15 text-gray-700">
    <!--begin::Section-->
    <div>
      <!--begin::Heading-->
      <div class="col-12 d-flex">
        <h1 class="anchor fw-bolder mb-5" id="striped-rounded-bordered">Kegiatan anda</h1>
        <button class="ms-auto btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambah">Tambah</button>
      </div>
      <!--end::Heading-->
      <!--begin::Block-->
      <div class="my-5 table-responsive">
        <table id="myTable" class="table table-striped table-hover table-rounded border gs-7">
          <thead>
            <tr class="fw-bold fs-6 text-gray-800 border-bottom border-gray-200">
              <th style="width: 30px">No.</th>
              <th style="min-width: 100px">Nama kegiatan</th>
              <th style="min-width: 100px">Penyelenggara</th>
              <th style="min-width: 100px">Lokasi</th>
              <th style="width: 120px">Tanggal mulai</th>
              <th style="width: 120px">Tanggal selesai</th>
              <th style="width: 100px">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($activities as $a)
            @php
              $sd = date_create($a->start_date);
              $ed = date_create($a->end_date);
            @endphp
            <tr>
              <td>{{$loop->iteration}}</td>
              <td>
                <div class="symbol symbol-30px me-5" data-bs-toggle="modal" data-bs-target="#foto" onclick="foto('{{ $a->image }}')">
                  <img src="/assets/img/activity/{{ $a->image }}" class="h-30 align-self-center of-cover rounded-0" alt="">
                </div>
                {{ $a->name }}  
              </td>
              <td>
                <b class="text-primary fs-3">{{ $a->organizer }} </b><br>
                <b>Penanggungjawab : </b>{{ $a->pic_name }} <br>
                <b>No telepon : </b>{{ $a->phone }}
              </td>
              <td><span class="badge badge-primary">{{ $a->location }}</span></td>
              <td>{{date_format($sd,"d/m/Y H:i")}}</td>
              <td>{{date_format($ed,"d/m/Y H:i")}}</td>
              <td>
                <a href="#" class="btn btn-icon btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#edit" onclick="edit({{ $a->id }})"><i class="bi bi-pencil-fill"></i></a>
                <a href="#" class="btn btn-icon btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#hapus" onclick="hapus({{ $a->id }})"><i class="fa fa-times"></i></a>
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
        <h3 class="modal-title">Tambah kegiatan</h3>
        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
          <i class="bi bi-x-lg"></i>
        </div>
      </div>

      <form class="form" method="post" action="" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
          <div class="row g-9">
            <div class="col-12 col-md-7">
              <label class="required fw-bold mb-2">Nama kegiatan</label>
              <input type="text" class="form-control" name="name" required>
            </div>
            <div class="col-12 col-md-5">
              <label class="required fw-bold mb-2">Lokasi kegiatan</label>
              <input type="text" class="form-control" name="location" required>
            </div>

            <div class="col-12">
              <label class="required fw-bold mb-2">Deskripsi kegiatan</label>
              <textarea class="form-control" rows="3" name="description" required></textarea>
            </div>

            <div class="col-12 col-md-4">
              <label class="required fw-bold mb-2">Tanggal mulai</label>
              <input type="datetime-local" class="form-control" name="start_date" required>
            </div>
            <div class="col-12 col-md-4">
              <label class="required fw-bold mb-2">Tanggal selesai</label>
              <input type="datetime-local" class="form-control" name="end_date" required>
            </div>
            <div class="col-12 col-md-4">
              <label class="required fw-bold mb-2">Upload foto</label>
              <input type="file" class="form-control" name="image" required>
            </div>

            <div class="col-12 col-md-4">
              <label class="required fw-bold mb-2">Penyelenggara</label>
              <input type="text" class="form-control" name="organizer" required>
            </div>
            <div class="col-12 col-md-4">
              <label class="required fw-bold mb-2">Penanggungjawab</label>
              <input type="text" class="form-control" name="pic_name" required>
            </div>
            <div class="col-12 col-md-4">
              <label class="required fw-bold mb-2">No telepon</label>
              <input type="text" class="form-control" name="phone" required>
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
          <h3 class="modal-title" id="et">Edit Agenda Budaya</h3>
          <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
            <i class="bi bi-x-lg"></i>
          </div>
        </div>
        <form class="form" method="post" action="" enctype="multipart/form-data">
          @csrf
          <input type="hidden" id="eid" name="id">
          <div class="modal-body">
            <div class="row g-9">
              <div class="col-12 col-md-7">
                <label class="required fw-bold mb-2">Nama kegiatan</label>
                <input type="text" class="form-control" name="name" required>
              </div>
              <div class="col-12 col-md-5">
                <label class="required fw-bold mb-2">Lokasi kegiatan</label>
                <input type="text" class="form-control" name="location" required>
              </div>
  
              <div class="col-12">
                <label class="required fw-bold mb-2">Deskripsi kegiatan</label>
                <textarea class="form-control" rows="3" name="description" required></textarea>
              </div>
  
              <div class="col-12 col-md-4">
                <label class="required fw-bold mb-2">Tanggal mulai</label>
                <input type="datetime-local" class="form-control" name="start_date" required>
              </div>
              <div class="col-12 col-md-4">
                <label class="required fw-bold mb-2">Tanggal selesai</label>
                <input type="datetime-local" class="form-control" name="end_date" required>
              </div>
              <div class="col-12 col-md-4">
                <label class="fw-bold mb-2">Upload foto</label>
                <input type="file" class="form-control" name="image">
              </div>
  
              <div class="col-12 col-md-4">
                <label class="required fw-bold mb-2">Penyelenggara</label>
                <input type="text" class="form-control" name="organizer" required>
              </div>
              <div class="col-12 col-md-4">
                <label class="required fw-bold mb-2">Penanggungjawab</label>
                <input type="text" class="form-control" name="pic_name" required>
              </div>
              <div class="col-12 col-md-4">
                <label class="required fw-bold mb-2">No telepon</label>
                <input type="text" class="form-control" name="phone" required>
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
          <h3 class="modal-title">Hapus kegiatan</h3>
          <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
            <i class="bi bi-x-lg"></i>
          </div>
        </div>
        <form class="form" method="post" action="">
          @csrf
          <div class="modal-body text-center">
            <input type="hidden" class="d-none" id="hi" name="id">
            <p class="fw-bold mb-2 fs-3">"<span id="hd"></span>"</p>
            <p class="mb-2 fs-4">Apakah anda yakin ingin menghapus kegiatan ini?</p>
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
    $("#img-view").attr("src","/assets/img/activity/"+image);
  }
  function edit(id){
    $.ajax({
      url: "/api/activity/"+id,
      type: 'GET',
      dataType: 'json', // added data type
      success: function(response) {
        var mydata = response.data;

        //     $table->string('pic_name');
        //     $table->string('phone');
        $('#edit input[name="id"]').val(id);
        $('#edit input[name="name"]').val(mydata.name);
        $('#edit input[name="organizer"]').val(mydata.organizer);
        $('#edit input[name="location"]').val(mydata.location);
        $('#edit textarea[name="description"]').val(mydata.description);
        $('#edit input[name="start_date"]').val(mydata.start_date);
        $('#edit input[name="end_date"]').val(mydata.end_date);
        $('#edit input[name="pic_name"]').val(mydata.pic_name);
        $('#edit input[name="phone"]').val(mydata.phone);
        $("#et").text("Edit "+mydata.title);
      }
    });
  }
  function hapus(id){
    $.ajax({
      url: "/api/activity/"+id,
      type: 'GET',
      dataType: 'json', // added data type
      success: function(response) {
        //alert(JSON.stringify(mydata));
        var mydata = response.data;
        $("#hi").val(id);
        $("#hd").text(mydata.name);
      }
    });
  }
</script>
@endsection