<meta charset="utf-8">
  <link rel="preload" as="image" href="{{$meta['image']}}" test="microsite-preload">
  <meta charset="utf-8">
  <title>{{$meta["title"]}}</title>
  <meta name="description" content="{{$meta['description']}}" />
  <meta name="keywords" content="{{$meta['keywords']}}" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta property="og:locale" content="en_US" />
  <meta property="og:type" content="{{$meta['type']}}" />
  <meta property="og:title" content="{{$meta['title']}}" />
  <meta property="og:url" content="{{$meta['url'] ?? Request::url()}}" />
  <meta property="og:site_name" content="{{$meta['site_name']}}" />
  <meta property="og:image" content="{{$meta['image']}}" />
  <meta name="twitter:card" content="summary_large_image" />
  <meta name="twitter:title" content="{{$meta['title']}}" />
  <meta name="twitter:description" content="{{$meta['description']}}" />
  <meta name="twitter:image" content="{{$meta['image']}}" />
  <link rel="canonical" href="{{$meta['url'] ?? Request::url()}}" />

  <!-- Favicons -->
  <link href="/assets/img/favicon.png" rel="icon">
  <link href="/assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link rel="stylesheet" href="/assets/vendor/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="/assets/vendor/bootstrap-icons/bootstrap-icons.css">
  <link rel="stylesheet" href="/assets/vendor/aos/aos.css">
  <link rel="stylesheet" href="/assets/vendor/glightbox/css/glightbox.min.css">
  <link rel="stylesheet" href="/assets/vendor/leaflet/leaflet.css" />
  <link rel="stylesheet" href="/assets/vendor/swiper/swiper-bundle.min.css">
  <link rel="stylesheet" href="/assets/plugins/custom/datatables.net-bs4/dataTables.bootstrap4.css">

  <!-- jQuery -->
  <script src="/assets/js/jquery.min.js"></script>
  <script src="/assets/js/jquery.easing.js"></script>

  <!-- Main CSS File -->
  <link rel="stylesheet" href="/assets/css/main.css">

  <style>
    #header .container-fluid{
      max-height: 32px;
    }
    #navmenu a{
      font-size: 14px;
    }
    .btn{
      font-size: 14px;
      font-weight: 400;
      letter-spacing: 1px;
      display: inline-block;
      border-radius: 50px;
      transition: 0.5s;
      padding: 10px 20px;
    }

    /* Testimonial */
    #testimonial img{
      aspect-ratio: 1/1;
      object-fit: cover;
    }
    #testimonial .btn-floating{
      width: 32px;
      height: 32px;
      z-index: 2;
    }
    #testimonial .testimonial-prev{
      margin-right: -8px;
    }
    #testimonial .testimonial-next{
      margin-left: -8px;
    }
    /* #testimonial #review .modal-content{
      border-radius: 10px;
    }
    #testimonial #review .modal-body{
      padding: 40px;
    } */
    #testimonial #review .btn-close{
      position: absolute;
      right: 0;
      z-index: 2;
      font-size: 12px;
    }
    #testimonial #review h5{
      font-size: 22px;
    }
    #testimonial #review p, #testimonial #review label{
      font-size: 14px;
    }
  </style>