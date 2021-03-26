<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserPreference;
use App\Models\LogUserPreference;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $urlImages    = $this->getUrlSlider();
        $quote        = $this->getKanye();
        $arrayCompact = ['quote', 'urlImages'];
        
        if (Auth::check()) {
            $quoteLogin = $this->getKanye();
            $arrayCompact[] = 'quoteLogin';
            $logWallpapers = $this->getLogWallpapers();
            $arrayCompact[] = 'logWallpapers';
        }
        return view('home', compact($arrayCompact));
    }

    /**
     * Obtienes los quotes para visualizacion por vue o por php
     */
    function getKanye()
    {
        $quote = new QuotesController();
        return $quote->generator();
    }
    /**
     * obtiene el array de las imagenes aleatorias
     */
    function getUrlSlider()
    {
        $images = new ImagenController();
        return $images->createUrlImagen();
    }
    /**
     * Obtiene el log de  los cambio de pantalla del usuario
     */
    function getLogWallpapers()
    {
        return LogUserPreference::all();
    }

    /**
     * Metodo para guardar preferencias 
     * TODO:: cambiar a un controlador para usuarios
     */
    public function savePreferences(Request $request)
    {
        $user = Auth::user();
        $preference = UserPreference::where('user_id', $user->id)->first();
        $stringImagen = $request->input('image') . '.png';
        if ($preference == null) {
            $quote = UserPreference::create([
                'user_id'   => $user->id,
                'wallpaper' => $stringImagen,
                'phone'     => $request->input('phone'),
            ]);
            
        } else { 
            $preference->wallpaper = $stringImagen;
            $preference->phone     = $request->input('phone');
            $preference->save();
        }
        
        LogUserPreference::create([
            'user_id'   => $user->id,
            'wallpaper' => $stringImagen,
            'phone'     => $request->input('phone'),
        ]);

        $request->session()->flash('preference-status', 'Preferencia actualizada');
        return redirect()->route('home');    
    }
}
