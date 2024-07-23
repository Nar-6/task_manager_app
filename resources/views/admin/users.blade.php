@extends('admin/base')

@section('title')
MyTask - Admin
@endsection

@section('script')

@endsection

@section('nav')
    <li><a href="{{ route('admin.home') }}"><i class="fa-solid fa-house"></i></a></li>
    <li><a href="{{ route('admin.taches') }}"><i class="fa-solid fa-list-check"></i></a></li>
    <li><a class="active-link" href="{{ route('admin.users')}}"><i class="fa-solid fa-users-line"></i></a></li>
    <li><a href="{{ route('admin.profile')}}"><i class="fa-solid fa-user"></i></a></li>
@endsection

@section('content')
    <div class="home">
        <h1>UTILISATEURS</h1>
        <div class="users-one">
            @forelse ($users as $user)
                <div class="user-one">
                    <div class="user-one-profile">
                        <div class="photo-profil">
                            <img src="{{ asset('image/pp.png') }}" class="shadow" alt="" height="100" width="100">
                        </div>
                        <div class="assigne">{{$user->nom}} {{$user->prenom}}</div>
                        <div class="assigne">{{$user->role}}</div>
                        @if ($user->role == "Utilisateur")
                        <a style="width:fit-content; margin-left:auto; margin-right:auto;" href="{{ route('promouvoir', ['id'=> $user->id])}}">
                            <button type="submit" class="vilain" style="margin-top:10px; width:fit-content; margin-left:auto; margin-right:auto;" onclick="return confirm('Êtes-vous sûr de vouloir promouvoir cet utilisateur ?');">
                                <div class="btn btn-blue">Promouvoir</div>
                            </button>
                        </a>
                        @endif
                    </div>
                    <div class="user-one-taches">
                        @forelse ($user->taches as $tache)
                            <div class="tache-ligne">
                                <div class="titre">{{$tache->nom_tache}}</div>
                                <div class="priorite">{{$tache->priorite}}</div>
                                <div class="statut">{{$tache->statut}}</div>
                            </div>
                            @if ($tache != $user->taches->last())
                                <div class="trait"></div>
                            @endif
                        @empty
                            <div class="pas-de-tache" >Aucune tache assignee</div>
                        @endforelse
                    </div>
                </div>
            @empty
                <p style="text-align: center">Aucun utilisateur.</p>
            @endforelse
        </div>
    </div>
    <div class="navigation-right-3">
        <div type="button" data-toggle="modal" data-target="#exampleModalCenterCreer">
            Creer
        </div>
    </div>
@endsection


@section('modal')
    
 <!-- Modal -->
 <div class="modal fade" id="exampleModalCenterCreer" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Creer un utilisateur</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form method="POST" action="{{route('users.store')}}">
                @csrf
                <div class="form-group">
                  <label for="role">Role</label>
                  @php
                      use App\Models\User;
                      $users = User::all();
                  @endphp
                  <select class="custom-select custom-select-sm" name="role" id="role" required>
                    <option selected>Choisissez un role</option>
                    <option value="Admin">Admin</option>
                    <option value="Utilisateur">Utilisateur</option>
                  </select>
                  @if ($errors->has('role'))
                      <span class="text-danger">{{ $errors->first('role') }}</span>
                  @endif
                </div>
                <div class="form-group">
                    <label for="nom">Titre</label>
                    <input type="text" class="form-control" name="nom" id="nom" placeholder="Ecrivez son nom" required>
                    @if ($errors->has('nom'))
                        <span class="text-danger">{{ $errors->first('nom') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="prenom">Prenom</label>
                    <input type="text" class="form-control" name="prenom" id="prenom" placeholder="Donnez son prenom" required></input>
                    @if ($errors->has('prenom'))
                        <span class="text-danger">{{ $errors->first('prenom') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" name="email" id="email" placeholder="Donnez son email" required></input>
                    @if ($errors->has('email'))
                        <span class="text-danger">{{ $errors->first('email') }}</span>
                    @endif
                </div>
                
                <br>
                <button type="submit" class="btn-blue " style="border: 0px !important;">Creer</button>
            </form>
        </div>
        {{-- <div class="modal-footer">
          {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> 
          +

          <button type="button" class="btn btn-primary">Commencer</button>
        </div> --}}
      </div>
    </div>
</div>

 <!-- Modal -->
 <div class="modal fade" id="exampleModalCenterUpdate" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Modifier une tâche</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form method="POST" id="updateTacheForm" action="">
                @csrf
                @method('PUT')
                <div class="form-group">
                  <label for="updateUser">User</label>
                  <select class="custom-select custom-select-sm" name="assigne_a" id="updateUser" required>
                    <option selected>Assigné à</option>
                    @foreach ($users as $user)
                        <option value={{$user->email}}>{{$user->nom}} {{$user->prenom}}</option>
                    @endforeach
                  </select>
                  @if ($errors->has('assigne_a'))
                      <span class="text-danger">{{ $errors->first('assigne_a') }}</span>
                  @endif
                </div>
                <div class="form-group">
                    <label for="updateTitre">Titre</label>
                    <input type="text" class="form-control" name="nom_tache" id="updateTitre" placeholder="Donnez un titre" required>
                    @if ($errors->has('nom_tache'))
                        <span class="text-danger">{{ $errors->first('nom_tache') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="updateDescription">Description</label>
                    <textarea class="form-control" name="description" id="updateDescription" placeholder="Donnez une description" required></textarea>
                    @if ($errors->has('description'))
                        <span class="text-danger">{{ $errors->first('description') }}</span>
                    @endif
                </div>
               
                <br>
                <button type="submit" class="btn-blue" style="border: 0px !important;">Modifier</button>
            </form>
        </div>
      </div>
    </div>
</div>
@endsection
