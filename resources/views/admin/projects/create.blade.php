@extends("layouts.app")

@section("title","Crea Progetto")

@section("content")
<main id="myCreate">
  
  <div class="container">
    

    <div class="container my-5">
     <form class="row g-3" action="{{route("admin.projects.store")}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="d-flex justify-content-end">
          <a href="{{route("admin.projects.index")}}" class="btn btn-primary">Ritorna ai Progetti</a>
        </div>
    
        <!-- Titolo -->
        <div class="d-flex">
        <div class="col-md-6 me-3 pb-4">
            <label for="title" class="form-label text-white">Titolo</label>
            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $project->title) }}">
          @if($errors->has("title"))
          <ul class="alert list-unstyled alert-danger m-0  d-flex flex-column justify-content-center">
          @foreach ($errors->get('title') as $error)
              <li class="m-0">{{ $error }}</li>
          @endforeach
          </ul>
          @endif
          </div>
          <!-- Tipo -->
          <div>
          <label for="type_id" class="form-label text-white">Tipi</label>
          <select class="form-select" name="type_id" id="type_id">
          <option value="">Nessun Tipo</option>
          @foreach($types as $type)
          <option value="{{$type->id}}"@if($project->type_id == $type->id) selected @endif>{{$type->label}}</option>
          @endforeach  
          </select> 
          @if($errors->has("type_id"))
          <ul class="alert list-unstyled alert-danger m-0  d-flex flex-column justify-content-center">
            @foreach ($errors->get('type_id') as $error)
                <li class="m-0">{{ $error }}</li>
            @endforeach
            </ul>
            @endif
          </div>        
        </div>
          <!-- GIT Hub -->
          <div class="col-md-6 pb-4">
            <label for="github" class="form-label text-white">Link GIT-Hub</label>
            <input type="text" class="form-control  @error('github') is-invalid @enderror" id="github" name="github"  value="{{ old('github', $project->github) }}">
            @if($errors->has("github"))
          <ul class="alert list-unstyled alert-danger ps-2 d-flex flex-column justify-content-center">
          @foreach ($errors->get('github') as $error)
              <li class="m-0">{{ $error }}</li>
          @endforeach
          </ul>
          @endif
          </div>
          <!-- Descrizione -->
          <div class="col-12 pb-4">
            <label for="description" class="form-label text-white">Descrizione</label>
            <textarea class="form-control @error('description')is-invalid @enderror" name="description" id="description" cols="173" rows="3"> {{old('description', $project->description)}}</textarea>
            @if($errors->has("description"))
            <ul class="alert list-unstyled alert-danger ps-2 d-flex flex-column justify-content-center">
              @foreach ($errors->get('description') as $error)
                  <li class="m-0">{{ $error }}</li>
              @endforeach
              </ul>
              @endif
          </div>
          <!-- Immagine -->
          <div class="col-md-12 mb-4 mt-3">
              <div class="d-flex justify-content-between align-items-center pb-4">
                <div>
              <label for="image" class="form-label text-white">Immagine</label>
                  <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" >
                </div>
                  @if($errors->has("image"))
                <ul class="alert list-unstyled alert-danger ps-2 d-flex flex-column justify-content-center">
                  @foreach ($errors->get('image') as $error)
                      <li class="m-0">{{ $error }}</li>
                  @endforeach
                  </ul>
                  @endif
                  <div class="col-md-1">
                    <img class="img-edit" id="img-preview"
                    src="{{$project->image?asset("storage/" . $project->image) : "https://marcolanci.it/utils/placeholder.jpg"}}" alt="">
                  </div>
                </div>
              
              <!-- Tecnologie -->
                <div>
                  <h4 class="text-white mb-3">Tecnologie</h4>
                  @foreach ($technologies as $technology)
                  <div class="form-check form-check-inline text-white">
                    <input class="form-check-input" type="checkbox" id="technology-{{$loop->iteration}}" value="{{$technology->id}}" name="technologies[]"
                    @if (in_array($technology->id, old("technologies", $project_technologies ?? []))) checked @endif>
                    <label class="form-check-label" for="technology-{{$loop->iteration}}">{{$technology->label}}</label>
                  </div>
                  @endforeach
                  @error("technologies")
                  <small class="text-danger">{{$message}}</small>
                  @enderror
                
              </div>
            
              
          </div>
          <!-- Bottone -->
          <div class="col-12 d-flex justify-content-between">
            <button type="submit" class="btn btn-success">Crea</button>
          </div>
      </form> 
              
    </div>
</main>
@endsection

@section("scripts")
<script>
  const placeholder="https://marcolanci.it/utils/placeholder.jpg";
  const imageInput=document.getElementById("image");
  const imagePreview=document.getElementById("img-preview");
  imageInput.addEventListener("change", ()=>{
    if(imageInput.files && imageInput.files[0]){
      const reader=new FileReader();
      reader.readAsDataURL(imageInput.files[0]);
      reader.onload=e=>{
        imagePreview.src=e.target.result;
      }
    } else {
      imagePreview.src=placeholder;
    }
  })
</script>
@endsection