@php
use App\Models\User;

@endphp
@extends('admin/base')

@section('title')
MyTask - Admin
@endsection
@section('nav')
<li><a class="active-link" href="{{ route('admin.home')}}"><i class="fa-solid fa-house"></i></a></li>
<li><a href="{{ route('admin.taches')}}"><i class="fa-solid fa-list-check"></i></a></li>
<li><a href="{{ route('admin.users')}}"><i class="fa-solid fa-users-line"></i></a></li>
<li><a href="{{ route('admin.profile')}}"><i class="fa-solid fa-user"></i></a></li>
@endsection
@section('content')
    <div class="home">
        <h1>HOME</h1>
        <div class="taches-container">
            <div class="taches-header"><h3>Quelques Taches</h3> <a href="{{route('admin.taches')}}">voir plus -></a></div>
            <div class="taches shadow">
                @forelse ($taches as $tache)
                    <div class="tache">
                        <h4 class="tache-nom">{{$tache->nom_tache}}</h4>
                        <div class="tache-header">
                            <div class="priorite"><div class={{$tache->priorite}}>{{$tache->priorite}}</div></div>
                            <div class="statut">
                                @if ($tache->statut == "Terminé")
                                    <i class="fa-solid fa-circle-check"></i>
                                @elseif ($tache->statut == "En cours")
                                    <i class="fa-solid fa-spinner"></i>
                                @elseif ($tache->statut == "À faire")
                                    <i class="fa-solid fa-hourglass-start"></i>
                                @endif
                            </div>
                        </div>
                        <div class="description">{{$tache->description}}</div>
                        @php
                            $user = User::where('email', $tache->assigne_a)->first();
                        @endphp
                        <div class="assigne">{{$user->nom}} {{$user->prenom}}</div>
                    </div>
                @empty
                <p style="text-align: center">Aucune tâche disponible.</p>
                @endforelse
            </div>
        </div>
        <div class="users-container">
            <div class="taches-header"><h3>Quelques Utilisateurs</h3> <a href="{{route('admin.users')}}">voir plus -></a></div>
            <div class="users">
                @forelse ($users as $user)
                    <div class="user">
                        <div class="photo-profil">
                            <img src="{{asset('image/pp.png')}}" class="shadow" alt="" height="200" width="200" >
                        </div>
                        <div class="assigne">{{$user->nom}} {{$user->prenom}}</div>
                    </div>
                @empty
                    <p style="text-align: center">Aucun utilisateur.</p>
                @endforelse
            </div>
        </div>
    </div>

    <div class="navigation-right">
        <div class="photo-profil">
            <img src="{{asset('image/pp.png')}}" class="shadow" alt="" height="150" width="150" >
        </div>
        <div class="assigne">{{Auth::user()->nom}} {{Auth::user()->prenom}}</div>
    </div>
@endsection


