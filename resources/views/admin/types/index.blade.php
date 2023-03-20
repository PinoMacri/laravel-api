@extends("layouts.app")

@section("title","Types")

@section("content")
<header id="myIndex">
    <div class="container">
        <h1 data-text="Tipi" id="titolo" class="my-4">Tipi</h1>
        <div class="d-flex justify-content-between align-items-center mb-4">
          <div>
            <a class="btn btn-small btn-success" href="{{route("admin.types.create")}}">Aggiungi <i class="fa-solid fa-plus"></i></a>
          </div>
        </div>
       
        <table class="table table-dark table-striped-columns table-index">
            <thead>
                <tr>
                  <th class="my-th" scope="col">ID</th>
                  <th class="my-th" scope="col">Tipo</th>
                  <th class="my-th" scope="col">Colore</th>
                  <th class="my-th" scope="col">Azione</th>

                </tr>
              </thead>
              <tbody>
               @forelse ($types as $type)
               <tr>
                <th class="my-id" scope="row">{{$type->id}}</th>
                <td><p class="badge rounded-pill text-center" style="background-color: {{$type->color}}">{{$type->label}}</p></td>
                <td>{{ Str::limit($type->color, 10)}}</td>
    
                <td class="text-center">
                <a href="{{route("admin.types.edit", $type->id)}}" class="btn btn-small btn-warning"><i class="fa-solid fa-pen"></i></a>
                    <form class="delete-form d-inline" data-type="{{$type->label}}"  action="{{route("admin.types.destroy", $type->id)}}" method="POST">
                      @csrf
                      @method("DELETE")
                      <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i>
                      </button>
                    </form>
                </td>
               
              </tr>
               @empty
                <tr>
                    <th scope="row" colspan="5" class="text-center">Non ci sono Tipi</th>
                </tr>
               @endforelse
              </tbody>
        </table>
    </div>
    </header>
@endsection