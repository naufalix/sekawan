@extends('layouts.dashboard')

@section('content')

<div class="card mb-2">
  <!--begin::Card Body-->
  <div class="card-body fs-6 py-15 px-10 py-lg-15 px-lg-15 text-gray-700">
    <!--begin::Section-->
    <div>
      <!--begin::Heading-->
      <div class="col-12 d-flex">
        <h1 class="anchor fw-bolder mb-5" id="striped-rounded-bordered">Data laporan banjir</h1>
      </div>
      <!--end::Heading-->
      <!--begin::Block-->
      <div class="my-5 table-responsive">
        <table id="myTable" class="table table-striped table-hover table-rounded border gs-7">
          <thead>
            <tr class="fw-bold fs-6 text-gray-800 border-bottom border-gray-200">
              <th>No.</th>
              <th style="min-width: 150px">Detail lokasi</th>
              <th style="min-width: 300px">Deskripsi</th>
              <th style="min-width: 120px">Penyebab banjir</th>
              <th style="min-width: 120px">Nama Pelapor</th>
              <th style="min-width: 100px">Tanggal banjir</th>
              <th style="min-width: 90px">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($floods as $f)
            @php
              $fdate = date_create($f->flood_date);
            @endphp
            <tr>
              <td>{{$loop->iteration}}</td>
              <td>{{ $f->title }}</td>
              <td>{{ strlen($f->description) > 100 ? substr($f->description, 0, 100) . '...' : $f->description }}</td>
              <td>
                <span class="badge" style="background-color: {{ $f->cause->color }}">{{ $f->cause->name }}</span>
              </td>
              <td>{{ $f->user->name }}</td>
              <td>{{date_format($fdate,"d/m/Y H:i")}}</td>
              <td>
                <a href="/laporan/{{ $f->id }}" class="badge badge-primary" target="_blank">Lihat detail</a>
                <a href="#" class="badge badge-primary" data-bs-toggle="modal" data-bs-target="#tambah" onclick="tambah({{ $f->id }})">Tindak lanjut</a>
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

<div class="card mb-2">
  <!--begin::Card Body-->
  <div class="card-body fs-6 py-15 px-10 py-lg-15 px-lg-15 text-gray-700">
    <!--begin::Section-->
    <div>
      <!--begin::Heading-->
      <div class="col-12 d-flex">
        <h1 class="anchor fw-bolder mb-5" id="striped-rounded-bordered">Tindak lanjut laporan</h1>
        <button class="ms-auto btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambah">Tambah</button>
      </div>
      <!--end::Heading-->
      <!--begin::Block-->
      <div class="my-5 table-responsive">
        <table id="myTable" class="table table-striped table-hover table-rounded border gs-7">
          <thead>
            <tr class="fw-bold fs-6 text-gray-800 border-bottom border-gray-200">
              <th class="">No</th>
              <th style="min-width: 120px">Nama</th>
              <th style="min-width: 120px">Deskripsi</th>
              <th style="min-width: 120px">Jenis</th>
              <th style="min-width: 120px">Poin</th>
              <th style="min-width: 120px">Tanggal</th>
              <th style="min-width: 90px">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($followups as $fo)
            @php
              $created = date_create($fo->created_at);
            @endphp
            <tr>
              <td class="">{{$loop->iteration}}</td>
              <td style="min-width: 320px;">{{ $fo->name }}</td>
              <td>{{ strlen($fo->description) > 100 ? substr($fo->description, 0, 100) . '...' : $fo->description }}</td>
              <td style="min-width: 320px;">{{ $fo->type }}</td>
              <td>
                <span class="badge badge-success">+{{$fo->point}}</span>
              </td>
              <td>{{date_format($created,"d/m/Y H:i")}}</td>
              <td>
                <a href="#" class="btn btn-icon btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#edit" onclick="edit({{ $fo->id }})"><i class="bi bi-pencil-fill"></i></a>
                <a href="#" class="btn btn-icon btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#hapus" onclick="hapus({{ $fo->id }})"><i class="fa fa-times"></i></a>
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
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title">Tindak lanjut anda</h3>
        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
          <i class="bi bi-x-lg"></i>
        </div>
      </div>

      <form class="form" method="post" action="" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="flood_id">
        <div class="modal-body">
          <div class="row g-9">
            <div class="col-12">
              <label class="required fw-bold mb-2">Nama</label>
              <input type="text" class="form-control" name="name" required>
            </div>
            <div class="col-12">
              <label class="required fw-bold mb-2">Anda sebagai</label>
              <input type="text" class="form-control" name="type" required placeholder="Individu/Komunitas/Pemerintah">
            </div>
            <div class="col-12">
              <label class="required fw-bold mb-2">Deskripsi</label>
              <textarea class="form-control" rows="3" name="description" required placeholder="SUdah ditindak 100%"></textarea>
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
  <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <h3 class="modal-title" id="et">Edit postingan</h3>
          <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
            <i class="bi bi-x-lg"></i>
          </div>
        </div>
        <form class="form" method="post" action="" enctype="multipart/form-data">
          @csrf
          <input type="hidden" name="id">
          <div class="modal-body">
            <div class="row g-9">
              <div class="col-12">
                <label class="required fw-bold mb-2">Nama</label>
                <input type="text" class="form-control" name="name" required>
              </div>
              <div class="col-12">
                <label class="required fw-bold mb-2">Anda sebagai</label>
                <input type="text" class="form-control" name="type" required placeholder="Individu/Komunitas/Pemerintah">
              </div>
              <div class="col-12">
                <label class="required fw-bold mb-2">Deskripsi</label>
                <textarea class="form-control" rows="3" name="description" required placeholder="SUdah ditindak 100%"></textarea>
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
          <h3 class="modal-title">Hapus tindak lanjut</h3>
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

  function tambah(id){
    $('#tambah input[name="flood_id"]').val(id);
  }
  function edit(id){
    $.ajax({
      url: "/api/follow-up/"+id,
      type: 'GET',
      dataType: 'json', // added data type
      success: function(response) {
        var mydata = response.data;
        $('#edit input[name="id"]').val(id);
        $('#edit input[name="name"]').val(mydata.name);
        $('#edit input[name="type"]').val(mydata.type);
        $('#edit textarea[name="description"]').val(mydata.description);
        $("#et").text("Edit "+mydata.name);
      }
    });
  }
  function hapus(id){
    $.ajax({
      url: "/api/follow-up/"+id,
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