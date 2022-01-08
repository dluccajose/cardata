@extends(backpack_view('blank'))

@section('content')
    <div class="mb-3">
        <h3>Cargar planilla de autos</h3>
    </div>

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