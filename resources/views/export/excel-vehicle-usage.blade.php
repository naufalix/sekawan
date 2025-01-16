@extends('layouts.excel')

@section('content')
<div class="card mb-2">
  <!--begin::Card Body-->
  <div class="card-body fs-6 py-15 px-10 py-lg-15 px-lg-15 text-gray-700">
    <!--begin::Section-->
    <div>
      <!--begin::Heading-->
      <div class="row">
        <div class="col-12 col-md-6">
          <h1 class="anchor fw-bolder mb-5" id="striped-rounded-bordered">Export data riwayat pemakaian kendaraan</h1>
        </div>
        <div class="col-12 col-md-6 text-end">
          <button class="btn btn-dark me-3" onClick="dataexport('copy')" style="zoom:75%; height: fit-content">Copy</button>
          <button class="btn btn-primary me-3" onClick="dataexport('csv')" style="zoom:75%; height: fit-content">CSV</button>
          <button class="btn btn-danger me-3" onClick="dataexport('pdf')" style="zoom:75%; height: fit-content">PDF</button>
          <button class="btn btn-success me-3" onClick="dataexport('excel')" style="zoom:75%; height: fit-content">Export</button>
        </div>
      </div>
      <!--end::Heading-->
      <!--begin::Block-->
      <div class="my-5 table-responsive">
        <table id="myTable" class="table table-striped table-hover table-rounded border gs-7" style="border-bottom: 1px solid black !important;">
          <thead>
            <tr class="fw-bold fs-6 text-gray-800 border-bottom border-gray-200">
              <th class="width: 30px">No</th>
              <th>Reservasi</th>
              <th>Kendaraan</th>
              <th>Jarak tempuh</th>
              <th>Pemakaian BBM</th>
              <th>Waktu mulai</th>
              <th>Waktu selesai</th>
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
              <td>{{ $vu->vehicle->name }}</td>
              <td>{{ $vu->distance_covered }} km</td>
              <td>{{ $vu->fuel_used }} liter</td>
              <td>{{date_format($st,"d F Y H:i")}}</td>
              <td>{{date_format($et,"d F Y H:i")}}</p></td>
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