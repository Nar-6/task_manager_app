@extends('admin/base')

@section('script')
    
@endsection

@section('title')
MyTask
@endsection

@section('nav')
<li><a class="active-link" href="{{ route('admin.profile')}}"><i class="fa-solid fa-user"></i></a></li>
@endsection

@section('content')
    <div class="home">
        <h1>PROFILE</h1>
        <div class="taches-container">
            <div class="profil-one-container">
                <div class="profil-one-photo">
                    <img src="{{ asset('image/pp.png') }}" class="shadow" alt="" height="100" width="100">
                </div>
                <div class="profil-one-nom">
                    <h1>{{Auth::user()->nom}}</h1>
                    <h3>{{Auth::user()->prenom}}</h3>
                    <h4>{{Auth::user()->role}}</h4>
                    <div class="modifier-compte btn btn-blue" type="button" data-toggle="modal" data-target="#exampleModalCenter">Modifier compte</div>
                </div>
            </div>
            <div class="taches-header"><h3>Taches Assignees</h3> </a></div>
                @foreach (Auth::user()->taches as $tache)
                <div class="tache-one">
                    <div class="left">
                        <div class="dropdown">
                            <a class="btn btn-secondary " href="#" role="button" >
                                <div class="priorite btn btn-secondary">{{ $tache->priorite }}</div>
                            </a>
                        </div>
                        <div class="statut">Statut : {{ $tache->statut }}</div>
                    </div>
                    <div class="middle">
                        <h4 class="tache-nom">{{ $tache->nom_tache }}</h4>
                        <div class="description">{{ $tache->description }}</div>
                    </div>
                    <div class="right-one">
                        @if ($tache->statut == "À faire")  
                            <a href="{{ route('taches.encours', ['num_tache'=>$tache->num_tache])}}">
                                <div class="assigne btn btn-secondary" style="width: 130px; margin-top:0px !important;">
                                    Commencer tache
                                </div>
                            </a>
                        @elseif ($tache->statut == "En cours")
                            <a href="{{ route('taches.termine', ['num_tache'=>$tache->num_tache])}}">
                                <div class="assigne btn btn-secondary" style="width: 130px; margin-top:0px !important;">
                                    Marquer terminee
                                </div>
                            </a>
                        @else
                            <div class="assigne btn btn-secondary">Completee</div>
                        @endif
                    </div>
                </div>
                @endforeach
            
        </div>
    </div>

    <div class="navigation-right">
        <form action="{{ route('user.logout')}}" method="post">
            @csrf
            @method('delete')
            <button type="submit" style="border: 0px;">
                <div class="btn btn-blue" ><i class="fa fa-sign-out" aria-hidden="true" style="color: whitesmoke"></i> Se deconnecter</div>
            </button>
        </form>
    </div>
@endsection

@section('modal')
     <!-- Modal -->
     <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">Modifier une tâche</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <form method="POST" id="updateTacheForm" action="{{route('user.update',['id'=>Auth::user()->id])}}">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="nom">Nom</label>
                        <input type="text" class="form-control" value="{{Auth::user()->nom}}" name="nom" id="nom" placeholder="Nom" required>
                        @if ($errors->has('nom'))
                            <span class="text-danger">{{ $errors->first('nom') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="prenom">Prenom</label>
                        <input type="text" class="form-control" value="{{Auth::user()->prenom}}" name="prenom" id="prenom" placeholder="Prenom" required></input>
                        @if ($errors->has('prenom'))
                            <span class="text-danger">{{ $errors->first('prenom') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" class="form-control" value="{{Auth::user()->email}}" name="email" id="email" placeholder="Email" readonly required></input>
                        @if ($errors->has('email'))
                            <span class="text-danger">{{ $errors->first('email') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" name="password" id="password" placeholder="Pour ne pas changer de mot de passe, laissez vide." ></input>
                        @if ($errors->has('password'))
                            <span class="text-danger">{{ $errors->first('password') }}</span>
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
