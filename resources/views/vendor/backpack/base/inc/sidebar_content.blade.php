<!-- This file is used to store sidebar items, starting with Backpack\Base 0.9.0 -->
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('state') }}'><i class='nav-icon la la-question'></i> States</a></li>
<li class='nav-item'><a class='nav-link' href='{{ route('bulk-upload.index') }}'><i class='nav-icon la la-upload'></i> Cargar Excel</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('model') }}'><i class='nav-icon la la-question'></i> Models</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('car') }}'><i class='nav-icon la la-question'></i> Cars</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('brand') }}'><i class='nav-icon la la-question'></i> Brands</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('city') }}'><i class='nav-icon la la-question'></i> Cities</a></li>