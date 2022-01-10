@extends(backpack_view('blank'))

@section('content')
    <div class="mb-3">
        <h3>Cargar planilla de autos</h3>
    </div>

    @if (session()->has('bulkupload.success'))
        @php $response = session()->get('bulkupload.success') @endphp
        <div class="alert alert-success">
            {{ $response['carsCount'] }} cargados, de los cuales {{ $response['newCarsCount'] }} han sido agregados a la base de datos
        </div>
    @endif

    <div class="card p-3">
        <form action="{{ route('bulk-upload.upload') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="col-md-12 mb-3">
                <input type="file" name="files[]" class="form-control" multiple>
            </div>
            <div class="col-md-12">
                <button type="submit" class="btn btn-block btn-primary">CARGAR PLANILLA</button>
            </div>
        </form>
    </div>
@endsection