<!DOCTYPE html>
<html>
  <head>
      <link rel="icon" type="img/ico" href="/images/icons/mychildday.ico">
      <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700" rel="stylesheet">
      <meta charset="utf-8">

      <meta name="viewport" content="width=device-width, initial-scale=1">

      <link rel="stylesheet" type="text/css" href="/css/reset.css">

      <link rel="stylesheet" type="text/css" href="/css/style_index.css">
      <link rel="stylesheet" type="text/css" href="/css/style_faq.css">
      <link rel="stylesheet" type="text/css" href="/css/style_terms.css">
      <link rel="stylesheet" type="text/css" href="/css/style_popup.css">

      <script src="/js/offpage.js" charset="utf-8"></script>


      <title>@yield('title')</title>
  </head>
  <body>

    <a href="{{ url('/logout') }}"
                                                onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                                                Logout
                                            </a>

                                            <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                                {{ csrf_field() }}
                                            </form>
    <!-- HEADER -->
    @include('layouts.components.headers.loggedParent')
    <!-- REG/OLG -->

    <!-- CONTENT -->
    @yield('content')
    <!-- FOOTER -->


    @include('layouts.components.footers.loggedParent')

  </body>
  </html>
