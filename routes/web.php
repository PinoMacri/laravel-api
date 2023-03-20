<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Guest\HomeController as GuestHomeController;
use App\Http\Controllers\Admin\HomeController as AdminHomeController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\TechnologyController;
use App\Http\Controllers\Admin\TypeController;

Route::get('/', [GuestHomeController::class, "index"])->name("guest.home");

Route::middleware(["auth", "verified"])->name("admin.")->prefix("admin")->group(function(){
    Route::patch("/projects/{project}/restore", [ProjectController::class,"restore"])->name("projects.trash.restore");
    Route::get("/projects/trash", [ProjectController::class, "trash"])->name("projects.trash.index");
    Route::get("/", [AdminHomeController::class,"index"])->name("home");
    Route::delete("/projects/{project}/drop",[ProjectController::class,"drop"])->name("projects.trash.drop");
    Route::delete("/projects/drop", [ProjectController::class, "dropAll"])->name("projects.trash.dropAll");

    Route::get("/projects", [ProjectController::class,"index"])->name("projects.index");
    Route::get("/projects/create", [ProjectController::class,"create"])->name("projects.create");
    Route::post("/projects", [ProjectController::class,"store"])->name("projects.store");
    Route::get("/projects/{project}", [ProjectController::class,"show"])->name("projects.show");
    Route::get("/projects{project}/edit", [ProjectController::class,"edit"])->name("projects.edit");
    Route::put("/projects/{project}", [ProjectController::class,"update"])->name("projects.update");
    Route::delete("/projects/{project}", [ProjectController::class,"destroy"])->name("projects.destroy");
    Route::patch("/projects/{project}/toggle", [ProjectController::class, "togglePubblication"])->name("projects.toggle");
   
    Route::get("/types", [TypeController::class,"index"])->name("types.index");
    Route::get("/types/create", [TypeController::class,"create"])->name("types.create");
    Route::post("/types", [TypeController::class,"store"])->name("types.store");
    Route::get("/types{type}/edit", [TypeController::class,"edit"])->name("types.edit");
    Route::put("/types/{type}", [TypeController::class,"update"])->name("types.update");
    Route::delete("/types/{type}", [TypeController::class,"destroy"])->name("types.destroy");

    Route::get("/technologies", [TechnologyController::class,"index"])->name("technologies.index");
    Route::get("/technologies/create", [TechnologyController::class,"create"])->name("technologies.create");
    Route::post("/technologies", [TechnologyController::class,"store"])->name("technologies.store");
    Route::get("/technologies{technology}/edit", [TechnologyController::class,"edit"])->name("technologies.edit");
    Route::put("/technologies/{technology}", [TechnologyController::class,"update"])->name("technologies.update");
    Route::delete("/technologies/{technology}", [TechnologyController::class,"destroy"])->name("technologies.destroy");

});

Route::middleware('auth')->name("profile.")->prefix("/profile")->group(function () {
    Route::get('/', [ProfileController::class, 'edit'])->name('edit');
    Route::patch('/', [ProfileController::class, 'update'])->name('update');
    Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
});

require __DIR__.'/auth.php';
Route::resource('admin/technologies', App\Http\Controllers\Admin\TechnologyController::class, ['as' => 'admin']);