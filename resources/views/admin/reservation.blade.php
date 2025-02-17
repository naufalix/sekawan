@extends('layouts.admin')

@section('content')
<div class="card mb-2">
  <!--begin::Card Body-->
  <div class="card-body fs-6 py-15 px-10 py-lg-15 px-lg-15 text-gray-700">
    <!--begin::Section-->
    <div>
      <!--begin::Heading-->
      <div class="col-12 d-flex">
        <h1 class="me-auto anchor fw-bolder mb-5" id="striped-rounded-bordered">Data reservasi kendaraan</h1>
        <a class="btn btn-primary btn-sekawan me-3" href="/admin/excel/reservation" target="_blank" style="zoom:75%; height: fit-content">
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
              <th style="min-width: 200px">Keperluan reservasi</th>
              <th style="min-width: 200px">Driver/Kendaraan</th>
              <th style="min-width: 200px">Tanggal</th>
              <th style="min-width: 100px">Status</th>
              <th style="min-width: 200px">Approver</th>
              <th style="min-width: 90px">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($reservations as $r)
            @php
              $sd = date_create($r->start_date);
              $ed = date_create($r->end_date);
              $approval1 = $r->reservation_approval->where('approval_level',1)->first();
              $approval2 = $r->reservation_approval->where('approval_level',2)->first();
            @endphp
            <tr>
              <td class="">{{$loop->iteration}}</td>
              <td>{{ $r->purpose }}  </td>
              <td>
                <p class="mb-0"><b>Driver : </b> {{ $r->driver->name }}</p>
                <p class="mb-0"><b>Kendaraan : </b> {{ $r->vehicle->name }}</p>  
              </td>
              <td>
                <p class="mb-0"><b>Tanggal mulai : </b> {{date_format($sd,"d/m/Y")}}</p>
                <p class="mb-0"><b>Tanggal selesai : </b> {{date_format($ed,"d/m/Y")}}</p>  
              </td>
              <td>
                <span class="badge 
                    @if($r->status == 'pending') badge-warning 
                    @elseif($r->status == 'approved') badge-success 
                    @elseif($r->status == 'rejected') badge-danger 
                    @else badge-primary 
                    @endif">
                    {{ ucfirst($r->status) }}
                </span>
              </td>
              <td>
                @if ($approval1)
                  <p class=""><b>{{$approval1->approver->name}} : </b> 
                    <span class="badge @if($approval1->status == 'pending') badge-warning 
                      @elseif($approval1->status == 'approved') badge-success 
                      @elseif($approval1->status == 'rejected') badge-danger 
                      @else badge-primary 
                      @endif">{{ucfirst($approval1->status)}}</span>
                  </p>
                @endif
                @if ($approval2)
                  <p class="mb-0"><b>{{$approval2->approver->name}} : </b> 
                    <span class="badge @if($approval2->status == 'pending') badge-warning 
                      @elseif($approval2->status == 'approved') badge-success 
                      @elseif($approval2->status == 'rejected') badge-danger 
                      @else badge-primary 
                      @endif">{{ucfirst($approval2->status)}}</span>
                  </p>
                @endif
              </td>
              <td>
                @if ($approval1->status!='approved'&&$approval2->status!='approved')
                <a href="#" class="btn btn-icon btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#hapus" onclick="hapus({{ $r->id }})"><i class="fa fa-times"></i></a>
                @endif
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
            <div class="col-12">
              <label class="required fw-bold mb-2">Keperluan reservasi</label>
              <input type="text" class="form-control" name="purpose" required>
            </div>
            <div class="col-12 col-md-6">
              <label class="required fw-bold mb-2">Driver</label>
              <select class="form-control" name="driver_id" required>
                <option value="" disabled selected>- Pilih driver -</option>
                @foreach ($drivers as $d)
                  <option value="{{$d->id}}">{{$d->name}}</option>
                @endforeach
              </select>
            </div>
            <div class="col-12 col-md-6">
              <label class="required fw-bold mb-2">Kendaraan</label>
              <select class="form-control" name="vehicle_id" required>
                <option value="" disabled selected>- Pilih kendaraan -</option>
                @foreach ($vehicles as $v)
                  <option value="{{$v->id}}">{{$v->name}}</option>
                @endforeach
              </select>
            </div>
            <div class="col-12 col-md-6">
              <label class="required fw-bold mb-2">Tanggal mulai</label>
              <input type="date" class="form-control" name="start_date" required>
            </div>
            <div class="col-12 col-md-6">
              <label class="required fw-bold mb-2">Tanggal selesai</label>
              <input type="date" class="form-control" name="end_date" required>
            </div>
            <div class="col-12 col-md-6">
              <label class="required fw-bold mb-2">Approver level 1</label>
              <select class="form-control" name="approver_1" required>
                <option value="" disabled selected>- Pilih approver 1 -</option>
                @foreach ($approvers as $a)
                  <option value="{{$a->id}}">{{$a->name}}</option>
                @endforeach
              </select>
            </div>
            <div class="col-12 col-md-6">
              <label class="required fw-bold mb-2">Approver level 2</label>
              <select class="form-control" name="approver_2" required>
                <option value="" disabled selected>- Pilih approver 2 -</option>
                @foreach ($approvers as $a)
                  <option value="{{$a->id}}">{{$a->name}}</option>
                @endforeach
              </select>
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
          <h3 class="modal-title" id="et">Edit reservasi</h3>
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
                <label class="required fw-bold mb-2">Keperluan reservasi</label>
                <input type="text" class="form-control" name="purpose" required>
              </div>
              <div class="col-12 col-md-6">
                <label class="required fw-bold mb-2">Driver</label>
                <select class="form-control" name="driver_id" required>
                  <option value="" disabled selected>- Pilih driver -</option>
                  @foreach ($drivers as $d)
                    <option value="{{$d->id}}">{{$d->name}}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-12 col-md-6">
                <label class="required fw-bold mb-2">Kendaraan</label>
                <select class="form-control" name="vehicle_id" required>
                  <option value="" disabled selected>- Pilih kendaraan -</option>
                  @foreach ($vehicles as $v)
                    <option value="{{$v->id}}">{{$v->name}}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-12 col-md-6">
                <label class="required fw-bold mb-2">Tanggal mulai</label>
                <input type="date" class="form-control" name="start_date" required>
              </div>
              <div class="col-12 col-md-6">
                <label class="required fw-bold mb-2">Tanggal selesai</label>
                <input type="date" class="form-control" name="end_date" required>
              </div>
              <div class="col-12 col-md-6">
                <label class="required fw-bold mb-2">Approver level 1</label>
                <select class="form-control" name="approver_1" required>
                  <option value="" disabled selected>- Pilih approver 1 -</option>
                  @foreach ($approvers as $a)
                    <option value="{{$a->id}}">{{$a->name}}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-12 col-md-6">
                <label class="required fw-bold mb-2">Approver level 2</label>
                <select class="form-control" name="approver_2" required>
                  <option value="" disabled selected>- Pilih approver 2 -</option>
                  @foreach ($approvers as $a)
                    <option value="{{$a->id}}">{{$a->name}}</option>
                  @endforeach
                </select>
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
          <h3 class="modal-title">Hapus reservasi</h3>
          <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
            <i class="bi bi-x-lg"></i>
          </div>
        </div>
        <form class="form" method="post" action="">
          @csrf
          <div class="modal-body text-center">
            <input type="hidden" class="d-none" id="hi" name="id">
            <p class="fw-bold mb-2 fs-4" id="hd">Apakah anda yakin ingin menghapus reservasi ini?</p>
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
  function hapus(id){
    $.ajax({
      url: "/api/reservation/"+id,
      type: 'GET',
      dataType: 'json', // added data type
      success: function(response) {
        //alert(JSON.stringify(mydata));
        var mydata = response.data;
        $("#hi").val(id);
        $("#hd").text("Apakah anda yakin ingin menghapus "+mydata.purpose+"?");
      }
    });
  }
</script>
@endsection