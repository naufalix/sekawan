<!DOCTYPE html>
<html lang="en">
  <head>
    @include('partials.admin-head')
    <style>
      body{font-family: 'Arial'}
      td, th {border: 1px solid black !important; padding: 8px !important}
      th {font-weight: 600 !important; text-align: center !important}
    </style>
  </head>

  <body class="bg-white">
    @yield('content')
    @include('partials.admin-script')
  </body>\
</html>