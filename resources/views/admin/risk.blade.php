@extends('layouts.dashboard')

@section('content')

<div class="card mb-2">
  <!--begin::Card Body-->
  <div class="card-body fs-6 py-15 px-10 py-lg-15 px-lg-15 text-gray-700">
    <!--begin::Section-->
    <div>
      <!--begin::Heading-->
      <div class="col-12 d-flex">
        <h1 class="anchor fw-bolder mb-5" id="striped-rounded-bordered">Laporan anda</h1>
        <button class="ms-auto btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambah">Tambah</button>
      </div>
      <!--end::Heading-->
      <!--begin::Block-->
      <div class="my-5 table-responsive">
        <table id="myTable" class="table table-striped table-hover table-rounded border gs-7">
          <thead>
            <tr class="fw-bold fs-6 text-gray-800 border-bottom border-gray-200">
              <th>No.</th>
              <th style="min-width: 150px">Detail lokasi</th>
              <th style="min-width: 150px">Kota/Kabupaten</th>
              <th style="min-width: 150px">Luas area banjir</th>
              <th style="min-width: 120px">Koordinat</th>
              <th style="min-width: 150px">Tanggal</th>
              <th style="min-width: 90px">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($risks as $r)
            @php
              $date = date_create($r->date);
            @endphp
            <tr>
              <td>{{$loop->iteration}}</td>
              <td>{{ $r->title }}</td>
              <td>
                <span class="badge badge-success">{{ $r->city->name }}</span>
              </td>
              <td>{{ $r->area }}m²</td>
              <td>
                <span class="badge badge-primary">{{ substr($r->latitude,0,6) }}</span>
                <span class="badge badge-primary">{{ substr($r->longitude,0,6) }}</span>
              </td>
              <td>{{date_format($date,"d/m/Y")}}</td>
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
        <h3 class="modal-title">Buat laporan daerah rawan banjir</h3>
        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
          <i class="bi bi-x-lg"></i>
        </div>
      </div>

      <form class="form" method="post" action="" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
          <div class="row g-9">
            <div class="col-12 col-md-8">
              <label class="required fw-bold mb-2">Detail lokasi</label>
              <input type="text" class="form-control" name="title" required>
            </div>
            <div class="col-12 col-md-4">
              <label class="required fw-bold mb-2">Kota/kabupaten</label>
              <select class="form-select" name="cars" id="city_id" required>
                @foreach ($cities as $c)
                  <option value="{{ $c->id }}">{{ str_replace(['KABUPATEN ', 'KOTA '], '', $c->name) }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-12 col-md-6">
              <label class="required fw-bold mb-2">Deskripsi</label>
              <textarea class="form-control" name="description" rows="8" required></textarea>
            </div>
            <div class="col-12 col-md-6">
              <label class="required fw-bold mb-2">Pilih lokasi banjir</label>
              <div id="map" style="height: 200px"></div>
              <input type="hidden" name="latitude" required>
              <input type="hidden" name="longitude" required>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-success" name="submit" value="store">Submit</button>
        </div>
      </form>  
      
    </div>
  </div>
</div>

<div class="modal fade" tabindex="-1" id="edit">
  <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h3 class="modal-title" id="et">Edit Kota</h3>
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
                <label class="required fw-bold mb-2">Detail lokasi</label>
                <input type="text" class="form-control" name="title" required>
              </div>
              <div class="col-12 col-md-6">
                <label class="required fw-bold mb-2">Deskripsi</label>
                <textarea class="form-control" name="description" rows="8" required></textarea>
              </div>
              <div class="col-12 col-md-6">
                <label class="required fw-bold mb-2">Pilih lokasi banjir</label>
                <div id="map2" style="height: 200px"></div>
                <input type="hidden" name="latitude" required>
                <input type="hidden" name="longitude" required>
              </div>
              <div class="col-12 col-md-6">
                <label class="fw-bold mb-2">Upload foto</label>
                <input type="file" class="form-control" name="image">
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
          <h3 class="modal-title">Hapus Laporan</h3>
          <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
            <i class="bi bi-x-lg"></i>
          </div>
        </div>
        <form class="form" method="post" action="">
          @csrf
          <div class="modal-body text-center">
            <input type="hidden" class="d-none" id="hi" name="id">
            <p class="fw-bold mb-2 fs-3">"<span id="hd"></span>"</p>
            <p class="mb-2 fs-4">Apakah anda yakin ingin menghapus laporan ini?</p>
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
        <div class="modal-body d-flex">
          <img class="mx-auto" id="img-view" src="" style="height:100%">
        </div>
      </div>
  </div>
</div>

<script type="text/javascript">
  function foto(image){
    $("#img-view").attr("src","/assets/img/city/"+image);
  }

  function edit(id){
    $.ajax({
      url: "/api/flood/"+id,
      type: 'GET',
      dataType: 'json', // added data type
      success: function(response) {
        var mydata = response.data;
        $('#edit input[name="id"]').val(id);
        $('#edit input[name="title"]').val(mydata.title);
        $('#edit textarea[name="description"]').val(mydata.description);
        $('#edit input[name="latitude"]').val(mydata.latitude);
        $('#edit input[name="longitude"]').val(mydata.longitude);
        $('#edit select[name="cause_id"]').val(mydata.cause_id);
        $("#et").text("Edit "+mydata.title);
        L.marker([mydata.latitude, mydata.longitude]).addTo(map2).bindPopup(`Latitude: ${lat}<br>Longitude: ${lng}`).openPopup();
      }
    });
  }
  function hapus(id){
    $.ajax({
      url: "/api/flood/"+id,
      type: 'GET',
      dataType: 'json', // added data type
      success: function(response) {
        //alert(JSON.stringify(mydata));
        var mydata = response.data;
        $("#hi").val(id);
        $("#hd").text(mydata.title);
      }
    });
  }
</script>
@endsection

@section('script')
<script>
  var map = L.map('map', {
    center: [-7.68, 111.87],
    zoom: 10
  });

  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
  }).addTo(map);

  // Variable to store the current marker
  let currentMarker = null;

  // Add click event listener
  map.on('click', (event) => {
    const { lat, lng } = event.latlng;
    $('#tambah input[name="latitude"]').val(lat);
    $('#tambah input[name="longitude"]').val(lng);

    // Remove the previous marker if it exists
    if (currentMarker) {
      map.removeLayer(currentMarker);
    }

    // Add a new marker at the clicked location
    currentMarker = L.marker([lat, lng]).addTo(map).bindPopup(`Latitude: ${lat}<br>Longitude: ${lng}`).openPopup();
  });

  ///
  var map2 = L.map('map2', {
    center: [-7, 110],
    zoom: 12
  });
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
  }).addTo(map2);
  let currentMarker2 = null;
  map2.on('click', (event) => {
    const { lat, lng } = event.latlng;
    $('#edit input[name="latitude"]').val(lat);
    $('#edit input[name="longitude"]').val(lng);
    if (currentMarker2) {
      map2.removeLayer(currentMarker2);
    }
    currentMarker2 = L.marker([lat, lng]).addTo(map2).bindPopup(`Latitude: ${lat}<br>Longitude: ${lng}`).openPopup();
  });
  


</script>
@endsection