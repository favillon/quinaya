<?php

use App\Models\Quote;
use Illuminate\Http\Request;
use App\Models\LogUserPreference;
use Illuminate\Support\Facades\Route;
use Symfony\Component\Console\Input\Input;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/**
 * TODO: Adicionar autenticacion para el api
 */
/**
 * Consulta para traer log de los wallpapers
 *  TODO :Pasar a controlador de api
 */
Route::get('getUser/{name?}', function ($name=null) {    
    $logs = LogUserPreference::
    join('users', 'users.id', '=', 'log_user_preferences.user_id')->
    select(
        'log_user_preferences.id as identificador', 'users.name as codigoUsuario',
        'log_user_preferences.wallpaper as imagen', 'log_user_preferences.phone as celular',
        'log_user_preferences.created_at as creado', 'log_user_preferences.updated_at as actualizado',
    );
    if ($name != null ) {
        $logs = $logs->where('users.name', $name);
    }
    $logs = $logs->orderby('log_user_preferences.id', 'desc')->paginate(10);
    return response()->json($logs, 200);
});

/**
 * Log de la citas
 * TODO: pasar a controlador de api
 */
Route::get('quotes', function () {
    $citas = Quote::
    select('description as cita', 'date_view as fecha', 'num_view as vistas')->
    orderby('id', 'desc')->paginate(10);
    return response()->json($citas, 200);
});