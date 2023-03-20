@extends("layouts.app")

@section("title","Projects")

@section("content")
@if(session("delete"))
<div class="alert alert-danger alert-dismissible text-center">
  <div class="d-flex justify-content-center">
    <p class="my-alert d-inline m-0">{{session("delete")}}</p>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
</div>
@endif

@if(session()->has('msg'))
    <div class="alert alert-{{ session('type') }} alert-dismissible text-center">
        <div class="d-flex justify-content-center">
            {{ session('msg') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
@endif

@if(session('message'))
    <div class="alert alert-{{ session('type') }} alert-dismissible text-center">
        <div class="d-flex justify-content-center">
            {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
@endif

@if (session()->has('success'))
    <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif





@foreach ($projects as $project)
<div class="alert text-center alert-success alert-dismissible fade show" role="alert" style="display:none;" id="create-success-alert">
  <p>Il Progetto {{$project->title}} è stato creato con sucesso!</p>
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endforeach

<header id="myIndex">
<div class="container">
    <h1 data-text="Progetti" id="titolo" class="my-4">Progetti</h1>
    <div class="d-flex justify-content-between align-items-center mb-4">
      <div>
        <a class="btn btn-small btn-success" href="{{route("admin.projects.create")}}">Aggiungi <i class="fa-solid fa-plus"></i></a>
        <a class="btn btn-small btn-danger"  href="{{route("admin.projects.trash.index")}}">Cestino <i class="fas fa-trash"></i></a>
      </div>
      <div class="d-flex">
       
        <form action="{{route("admin.projects.index")}}" method="GET" class="mb-0 d-flex align-items-center my-filtered">
          <div class="dropdown">
            <button id="technology-dropdown-btn" class="btn btn-secondary dropdown-toggle me-3" type="button" id="technology-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Seleziona le Tecnologie
            </button>            
            <div class="dropdown-menu" aria-labelledby="technology-dropdown">
              @foreach ($technologies as $technology)
                <div class="form-check dropdown-item text-center">
                  <input class="form-check-input tech ms-2" type="checkbox" name="technologies[]" value="{{ $technology->id }}" id="technology-{{$loop->iteration}}"  {{ in_array($technology->id, $selected_technologies) ? 'checked' : '' }}>
                  <label class="form-check-label dropdown-link"  for="technology-{{$loop->iteration}}">
                    {{ $technology->label }}
                  </label>
                </div>
              @endforeach
            </div>
          </div>
          
          
          


        <select class="form-select me-3" name="type_filter" id="type_filter">
          <option value="">Tutti i Tipi</option>
          @foreach($types as $type)
          <option @if ($type_filter==$type->id) selected @endif value="{{$type->id}}">{{$type->label}}</option>
          @endforeach
        </select>

        <select name="status_filter" class="form-select me-3">
          <option value="">Tutti i Stati</option>
          <option @if($status_filter=="pubblicati") selected @endif value="published">Pubblicati</option>
          <option @if($status_filter=="bozze") selected @endif value="bozze">Bozze</option>
        </select>

          <input type="text" placeholder="Nome Progetto" name="search" value="{{old("search",$search)}}">


        <button type="submit" class="btn btn-primary ms-3">Filtra</button>
        </form>
        
      </div>
    </div>
   
    <table class="table table-dark table-striped-columns table-index">
        <thead>
            <tr>
              <th class="my-th" scope="col">ID</th>
              <th class="my-th" scope="col">Titolo</th>
              <th class="my-th" scope="col">Tipo</th>
              <th class="my-th" scope="col">Tecnologie</th>
              <th class="my-th" scope="col">Descrizione</th>
              <th class="my-th" scope="col">GIT Hub</th>
              <th class="my-th" scope="col">Stato</th>
              <th class="my-th" scope="col">Azione</th>
            </tr>
          </thead>
          <tbody>
           @forelse ($projects as $project)
           <tr>
            <th class="my-id" scope="row">{{$project->id}}</th>
            <td id="titolos">{{ Str::limit($project->title, 20)}}</td>
            <td><p class="badge rounded-pill text-center" style="background-color: {{$project->type?->color}}">{{$project->type?->label}}</p></td>
            <td id="tecnologie">
              @forelse($project->technologies as $technology)
              <span class="badge rounded-pill text-dark" style="background-color: {{$technology->color}}">{{$technology->label}}</span>
              @empty
                -
              @endforelse
            </td>
            <td>{{ Str::limit($project->description, 10)}}</td>
            <td>{{ Str::limit($project->github, 10)}}</td>
            <td>
              <form action="{{route("admin.projects.toggle", $project->id)}}" method="POST" class="mb-0">
              @method("PATCH")
              @csrf
              <button type="submit" class="btn btn-outline">
                <i class="fas fa-toggle-{{$project->is_published ? "on" : "off"}}  {{$project->is_published ? "text-success" : "text-danger"}}"></i>
              </button>
              </form>
            </td>

            <td class="text-center">
                <a href="{{route("admin.projects.show", $project->id)}}" class="btn btn-small btn-primary"><i class="fa-solid fa-eye"></i></a>
                <a href="{{route("admin.projects.edit", $project->id)}}" class="btn btn-small btn-warning"><i class="fa-solid fa-pen"></i></a>
                <form class="delete-form d-inline" data-project="{{$project->title}}"  action="{{route("admin.projects.destroy", $project->id)}}" method="POST">
                  @csrf
                  @method("DELETE")
                  <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i>
                  </button>
                </form>
            </td>
           
          </tr>
           @empty
            <tr>
                <th scope="row" colspan="8" class="text-center">Non ci sono Progetti</th>
            </tr>
           @endforelse
          </tbody>
    </table>
   <div>
     {{$projects->links()}}
   </div>
</div>
</header>
@endsection

@section("scripts")
<script>
 
</script>



  