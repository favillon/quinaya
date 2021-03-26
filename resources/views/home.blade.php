@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row justify-content-center">
        <div class="col-12">
            <div>
                <slide :data="slide" :speed="5000" />
            </div>

            <br />
            <hr />
            <br />

            <div class="card-deck">
                @auth
                    <div class="card">
                        <div class="card-header">
                            <header>
                                <h4>{{ __('Para los de las casa') }}</h4>
                            </header>
                        </div>

                        <div class="card-body">
                            <span id="message-guest">
                                <i>{{ $quoteLogin }}</i>
                            </span> 
                        </div>
                    </div>
                @endauth
                <div class="card">
                    <div class="card-header">
                        @guest {{ __('Kanye Rest') }} @endguest
                        @auth <h2 class="animated fadeIn">{{ __('Para los amigos') }}</h2> @endauth
                    </div>
                    <div class="card-body">
                            <span id="message-guest">
                                <i v-if="messageGuest ==''">{{ $quote }}</i>
                                <i v-else>@{{ messageGuest }}</i>
                            </span>
                            <br /> 
                            <span>
                                <button v-on:click="searchKanye()" class="btn btn-success">Otra, otra, otra!</button>
                            </span>
                    </div>
                </div>
            </div>

            <br />
            @auth
                @if ($alertFm = Session::get('preference-status'))
                    <div class="alert alert-success alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ $alertFm }}</strong>
                    </div>
                @endif
                <div class="card">
                    <div class="card-header">
                        <h3>{{ __('Preferencias') }}</h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('user.preferences') }}">
                            @csrf
                            <div class="form-group">
                                <label for="image">Imagen</label>
                                <select class="form-control" id="image" name="image" required>
                                    <option value=""></option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>                                
                            </div>
                            <div class="form-group">
                                <label for="phone">Celular</label>
                                <input type="tel" class="form-control" id="phone"  name="phone" 
                                    maxlength="10" pattern="[3]{1}[0-2]{2}[0-9]{7}" required
                                    placeholder="(3001234567 - 3011234567 - 3101234567 - 3201234567)"
                                >
                                <small id="phone" class="form-text text-muted">
                                    Formato 3(0-2)(0-2) 1234567 : 321 3654895
                                </small>
                            </div>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </form>
                    </div>
                </div>
                <br />
                <div class="card">
                    <div class="card-header">
                        <h3>{{ __('Log') }}</h3>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nombre Usuario</th>
                                    <th scope="col">Imagen</th>
                                    <th scope="col">Telefono</th>
                                    <th scope="col">Creacion</th>
                                    <th scope="col">Actualizacion</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($logWallpapers as $logWallpaper)
                                    <tr>
                                        <th scope="row">{{$logWallpaper->id}}</th>
                                        <td>{{$logWallpaper->user->name}}</td>
                                        <td>{{$logWallpaper->wallpaper}}</td>
                                        <td>{{$logWallpaper->phone}}</td>
                                        <td>{{$logWallpaper->created_at}}</td>
                                        <td>{{$logWallpaper->updated_at}}</td>
                                    </tr>
                                @empty
                                   <tr>
                                        <td></td>
                                   </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            @endauth 
        </div>
    </div>
</div>
@endsection
