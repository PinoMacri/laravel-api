@extends ("layouts.app")

@section("title", $project->title)

@section ("content")
@if (session("success"))
    <div class="alert alert-warning alert-dismissible text-center">
        <div class="d-flex justify-content-center">
            {{ session("success") }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
@endif

<header>
    <div class="container">
        <div class="my-show">
         <div>
            <div class="my-img-show float-start me-4">
                <img class="img-fluid" src="{{asset("storage/" . $project->image)}}" alt="" >
            </div>
         <h1 class="my-5 text-white">
            {{$project->title}}
        </h1>
        <p class="text-white">
            {{$project->description}}
        </p>
    </div>

        </div>
        <div class="d-flex justify-content-end">
            <a href="{{$project->github}}" class="btn btn-success" target="_blank">Link Progetto a GitHub</a>
        </div>
        
         <div class="text-white">
            <strong>Stato:</strong> {{$project->is_published ? "Pubblicato" : "Bozza"}}
            <br>
         <a href="{{route("admin.projects.index")}}" class="mt-3 btn btn-primary">Ritorna ai Progetti</a>

        </div>

       
    </div>
    
</header>

@endsection