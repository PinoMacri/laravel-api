@extends("layouts.app")

@section("type","Modifica la Tecnologia")

@section("content")
<main id="my-create-types">
    <div class="container">
        <form class="row g-3" action="{{route("admin.technologies.update", $technology->id)}}" method="POST" enctype="multipart/form-data">
        @csrf
    @method("PUT")

       <!-- Tipo -->
       <div>
        <div class="col-md-6">
            <label for="label" class="form-label">Tecnologia</label>
            <input type="text" class="form-control @error('type') is-invalid @enderror" id="label" name="label" value="{{ old('label', $technology->label) }}">
          @if($errors->has("technology"))
          <ul class="alert list-unstyled alert-danger m-0  d-flex flex-column justify-content-center">
          @foreach ($errors->get('technology') as $error)
              <li class="m-0">{{ $error }}</li>
          @endforeach
          </ul>
          @endif
          </div>
    <!-- Color -->
    <div class="mt-3 mb-3">
        <label for="color" class="d-block">Colore</label>
        <input type="color" id="color" name="color" value="{{ old('color', $technology->color) }}">
    </div>
  <div class="d-flex justify-content-between" >
    <button class="btn btn-warning">Modifica</button>
        <a href="{{route("admin.technologies.index")}}" class="btn btn-primary">Ritorna alle Technologies</a>
  </div>
    </form> 


    </div>
</main>

@endsection