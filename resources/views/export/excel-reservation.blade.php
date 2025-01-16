@extends('layouts.excel')

@section('content')
<div class="card mb-2">
  <!--begin::Card Body-->
  <div class="card-body fs-6 py-15 px-10 py-lg-15 px-lg-15 text-gray-700">
    <!--begin::Section-->
    <div>
      <!--begin::Heading-->
      <div class="col-12 d-flex">
        <h1 class="me-auto anchor fw-bolder mb-5" id="striped-rounded-bordered">Export data reservasi kendaraan</h1>
        <button class="btn btn-primary me-3" onClick="dataexport('csv')" style="zoom:75%; height: fit-content">CSV</button>
        <button class="btn btn-danger me-3" onClick="dataexport('pdf')" style="zoom:75%; height: fit-content">PDF</button>
        <button class="btn btn-success me-3" onClick="dataexport('excel')" style="zoom:75%; height: fit-content">Export</button>
      </div>
      <!--end::Heading-->
      <!--begin::Block-->
      <div class="my-5 table-responsive">
        <table id="myTable" class="table table-striped table-hover table-rounded border gs-7" style="border-bottom: 1px solid black !important;">
          <thead>
            <tr class="fw-bold fs-6 text-gray-800 border-bottom border-gray-200">
              <th class="width: 30px">No</th>
              <th>Keperluan reservasi</th>
              <th>Driver</th>
              <th>Kendaraan</th>
              <th>Tanggal mulai</th>
              <th>Tanggal selesai</th>
              <th>Status</th>
              <th>Approver 1</th>
              <th>Approver 2</th>
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
              <td>{{ $r->driver->name }}</td>
              <td>{{ $r->vehicle->name }}</td>
              <td>{{date_format($sd,"d/m/Y")}}</td>
              <td>{{date_format($ed,"d/m/Y")}}</td>
              <td>{{ ucfirst($r->status) }}</td>
              <td>
                {{$approval1->approver->name}} ({{$approval1->status}})
              </td>
              <td>
                {{$approval2->approver->name}} ({{$approval2->status}})
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
@endsection