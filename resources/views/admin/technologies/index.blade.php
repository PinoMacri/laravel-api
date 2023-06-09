@extends("layouts.app")

@section("title","Technologies")

@section("content")
<header id="myIndex">
    <div class="container">
        <h1 data-text="Tecnologie" id="titolo" class="my-4">Tecnologie</h1>
        <div class="d-flex justify-content-between align-items-center mb-4">
          <div>
            <a class="btn btn-small btn-success" href="{{route("admin.technologies.create")}}">Aggiungi <i class="fa-solid fa-plus"></i></a>
          </div>
        </div>
       
        <table class="table table-dark table-striped-columns table-index">
            <thead>
                <tr>
                  <th class="my-th" scope="col">ID</th>
                  <th class="my-th" scope="col">Tecnologia</th>
                  <th class="my-th" scope="col">Colore</th>
                  <th class="my-th" scope="col">Azione</th>

                </tr>
              </thead>
              <tbody>
               @forelse ($technologies as $technology)
               <tr>
                <th class="my-id" scope="row">{{$technology->id}}</th>
                <td><p class="badge rounded-pill text-dark text-center" style="background-color: {{$technology->color}}">{{$technology->label}}</p></td>
                <td>{{ Str::limit($technology->color, 10)}}</td>
    
                <td class="text-center">
                <a href="{{route("admin.technologies.edit", $technology->id)}}" class="btn btn-small btn-warning"><i class="fa-solid fa-pen"></i></a>
                    <form class="delete-form d-inline" data-technology="{{$technology->label}}"  action="{{route("admin.technologies.destroy", $technology->id)}}" method="POST">
                      @csrf
                      @method("DELETE")
                      <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i>
                      </button>
                    </form>
                </td>
               
              </tr>
               @empty
                <tr>
                    <th scope="row" colspan="5" class="text-center">Non ci sono Tecnologie</th>
                </tr>
               @endforelse
              </tbody>
        </table>
    </div>
    </header>
@endsection