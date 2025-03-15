<div class="app-content-top-area">
          <!--begin::Container-->
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-6"><h1>{{ $breadcrumb->title }}</h1></div>
              <div class="col-md-6 align-content-center">
                <ol class="breadcrumb float-md-end">
                    @foreach ($breadcrumb->list as $key => $value)
                        @if ($key == count($breadcrumb->list) - 1)
                            <li class="breadcrumb-item">{{ $value }}</li>
                            @else
                            <li class="breadcrumb-item fw-semibold"> {{ $value }}</li>
                        @endif
                    @endforeach
                </ol>
              </div>
            </div>
          </div>
          <!--end::Container-->
        </div>