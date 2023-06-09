<?php

namespace App\Http\Controllers\Admin;

use App\Models\Project;
use App\Models\Type;
use App\Models\Technology;
use App\Models\Userform;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserPubblicationMail;
use App\Mail\UserNotifyProjectMail;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;


class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $status_filter = $request->query("status_filter");
        $type_filter = $request->query("type_filter");
        $selected_technologies = $request->input('technologies', []);
        $query = Project::orderBy("updated_at", "DESC");
        $search=$request->query("search");

        if ($status_filter) {
            $value = $status_filter === "published";
            $query->where("is_published", $value);
        }
        
        if ($type_filter) {
            $query->where("type_id", $type_filter);
        }
        
        if (count($selected_technologies)) {
            $query->whereHas('technologies', function ($q) use ($selected_technologies) {
                $q->whereIn('technologies.id', $selected_technologies);
            }, '=', count($selected_technologies));
        }
        
        
        
        

        if($search){
            $query->where("title","LIKE","%$search%");
        }
        
        $projects = $query->paginate(15);
        $types = Type::all();
        $technologies = Technology::all();
        
        return view("admin.projects.index", compact("projects", "types", "technologies", "status_filter", "type_filter", "search", 'selected_technologies'));
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $project=new Project();
        $types=Type::all();
        $technologies=Technology::all();
        return view("admin.projects.create", compact("project","types","technologies"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
        "title"=>"required|string|unique:projects|min:5|max:50",
        "description"=>"required|string",
        "image"=>"image|nullable|mimes:jpeg,jpg,png",
        "github"=>"required|url|max:100",
        "type_id"=>"exists:types,id",
        "technologies"=>"nullable|exists:technologies,id"
        ], [
            "title.required" => "ERROR - il titolo è obbligatorio",
            "title.unique" => "ERROR - il titolo $request->title è gia presente",
            "title.min" => "ERROR - la lunghezza del titolo deve essere almeno di 5 caratteri",
            "title.max" => "ERROR - la lunghezza del titolo non deve superare i 50 caratteri",
            "description.required" => "ERROR - la descrizione è obbligatoria",
            "image.image" => "ERROR - sono accettati solo formati di tipo jpeg, jpg, png",
            "github.required" => "ERROR - il link al progetto è obbligatorio",
            "github.url"=> "ERROR - devi inserire un URL",
            "github.max"=> "ERROR - la lunghezza del titolo non deve superare i 100 caratteri, controlla che sia un link github",
            "type_id"=>"ERROR - tipo non valido"   ,
            "technologies"=>"ERROR - le tecnologie selezionate non sono valide" 
        ]);
        $data = $request->all();
        $project=new Project();
        if(Arr::exists($data,"image")){
            $img_url=Storage::put("projects",$data["image"]);
            $data["image"] =$img_url;
        };
        $project->fill($data);
        $project->is_published=Arr::exists($data,"is_published");
        $project->save();
        if (Arr::exists($data,"technologies")) $project->technologies()->attach($data["technologies"]);
        session()->flash('success', 'Creazione avvenuta con successo!');
        return redirect()->route('admin.projects.index')->with('success', 'Il progetto è stato creato con successo.');


    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        return view("admin.projects.show", compact("project"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        $types=Type::all();
        $technologies=Technology::all();
        $project_technologies = $project->technologies->pluck("id")->toArray();
        return view ("admin.projects.edit", compact("project","types", "technologies", "project_technologies"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        $data = $request->all();
        $request->validate([
            "title"=>["required","string", "min:5", "max:50", Rule::unique("projects")->ignore($project->id)],
            "description"=>"required|string",
            "image"=>"image|nullable|mimes:jpeg,jpg,png",
            "github"=>"required|url|max:100",
            "type_id"=>"exists:types,id",
            "technologies"=>"nullable|exists:technologies,id"
            ], [
                "title.required" => "ERROR - il titolo è obbligatorio",
                "title.min" => "ERROR - la lunghezza del titolo deve essere almeno di 5 caratteri",
                "title.max" => "ERROR - la lunghezza del titolo non deve superare i 50 caratteri",
                "description.required" => "ERROR - la descrizione è obbligatoria",
                "image.image" => "ERROR - sono accettati solo formati di tipo jpeg, jpg, png",
                "github.required" => "ERROR - il link al progetto è obbligatorio",
                "github.url"=> "ERROR - devi inserire un URL",
                "github.max"=> "ERROR - la lunghezza del titolo non deve superare i 100 caratteri, controlla che sia un link github",
                "type_id"=>"ERROR - tipo non valido",
                "technologies"=>"ERROR - le tecnologie selezionate non sono valide"
            ]);
            if(Arr::exists($data,"image")){
                if($project->image)Storage::delete($project->image);
                $img_url=Storage::put("projects",$data["image"]);
                $data["image"] =$img_url;
            };
            $data["is_published"]=Arr::exists($data,"is_published");
        $project->update($data);
        if (Arr::exists($data,"technologies")) $project->technologies()->sync($data["technologies"]);
        else if (count($project->technologies)) $project->technologies()->detach();
        $project->save();
        return to_route("admin.projects.show", $project->id)->with("success", "Modifica avvenuta con successo.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        if ($project->image) {
            Storage::delete($project->image);
        }
        
        // Imposta la colonna deleted_at nella tabella ponte project_technology per i record correlati
        $project->technologies()->updateExistingPivot($project->technologies->pluck('id'), ['deleted_at' => now()]);
        
        $project->delete();
        return redirect()->route("admin.projects.index")->with("delete", "Il Progetto $project->title è stato eliminato");
    }
    

    public function togglePubblication(Project $project){
        $project->is_published=!$project->is_published;
        $action=$project->is_published ? "Pubblicato" : "Messo in Bozza";
        $project->save();
        $users = Userform::where('newsletter', true)->get();
        foreach ($users as $user) {
            if ($project->is_published) {
                $email = new UserNotifyProjectMail;
                Mail::to($user->email)->send($email); 
            }
       
    } 
    return to_route("admin.projects.index")->with("type","success")->with("msg","Il Progetto è stato $action con successo");
}

    public function trash(){
        $projects=Project::onlyTrashed()->get();
        return view("admin.projects.trash.index", compact("projects"));
    }
    

    public function restore(int $id){
        $project = Project::onlyTrashed()->findOrFail($id);
        $project->restore();
        return to_route("admin.projects.index")->with("message","Il Progetto $project->title è stato ripristinato")->with("type", "success");
    }

    public function drop(int $id){
        $project = Project::onlyTrashed()->findOrFail($id);
        $project->forceDelete();
        return to_route("admin.projects.trash.index")->with("recupero","Il Progetto $project->title è stato eliminato definitivamente")->with("type","danger");
    }

    public function dropAll(){
        Project::onlyTrashed()->forceDelete();
       
        return to_route("admin.projects.trash.index")
            ->with("segnalazione","Sono stati eliminati definitivamente tutti i Progetti")
            ->with("type","danger");
           
    }
    

    
}