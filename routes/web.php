<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Models\User;
use App\Models\Post;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [UserController::class, 'index']);
Route::post('users', [UserController::class, 'store'])->name('users.store');
Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy');


Route::get('count-users', function () {
    $users = User::get();
    
    foreach($users as $user){
        echo "
        $user->id 
        <strong>{$user->name}</strong>
        {$user->posts->count()} posts
        <br>";
    }
});

Route::get('collection', function () {
    $users = User::get();
    
    /* Consultando datos con colecciones */
    // dd($users);  ---> Los trae todos
    // dd($users->contains(5));  ---> Trae los primeros 5
    // dd($users->except([1,2,3]));  ---> Mostrara todos menos el id 1,2,3
    // dd($users->only(4));  ---> Mostrara solo el que contenga ID 4
    // dd($users->find(4));  ---> Mostrara solo el que contenga ID 4
     dd($users->load('posts')); // ---> Mostrara los usuarios que tengan relacion con post
});

Route::get('serialization', function () {
    $users = User::get();
    
    /* Presentando los datos en forma de array 
        dd($users->toArray());
        $user = $users->find(1);
        dd($user);
    */
    

    /* Presentando los datos en forma de Json  */

        $user = $users->find(1);
        dd($user->toJson());
});

Route::get('posts', function () {
    $posts = Post::get();

    foreach($posts as $post){
        echo "
        $post->id 
        <strong>{$post->user->name}</strong>
        $post->title 
        <br>";
    }
});