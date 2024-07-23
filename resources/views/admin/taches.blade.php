@extends('admin/base')

@section('title')
MyTask - Admin
@endsection

@section('script')
<script>
    document.addEventListener('DOMContentLoaded', (event) => {
        const taches = @json($taches);
        const users = @json($users);

        const high = [];
        const medium = [];
        const low = [];
        const toutes = [];


        taches.forEach(element => {
            let tache = {
                num_tache: element.num_tache,
                nom_tache: element.nom_tache,
                assigne_a: element.assigne_a,
                nom: '',
                description: element.description,
                statut: element.statut,
                priorite: element.priorite,
            };

            const user = users.find(u => u.email === element.assigne_a);
            tache.nom = `${user.nom} ${user.prenom}`;

            switch (element.priorite) {
                case 'High':
                    high.push(tache);
                    break;
                case 'Medium':
                    medium.push(tache);
                    break;
                case 'Low':
                    low.push(tache);
                    break;
            }
            toutes.push(tache)
        });

        function afficherTaches(toutes) {
            const container = document.querySelector('.taches-one');
            container.innerHTML = '';
            toutes.forEach(element => {
                const row = `
                    <div class="tache-one">
                        <div class="left">
                            <div class="dropdown">
                                <a class="btn btn-secondary ${element.priorite.toLowerCase()}" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                    <div class="">${element.priorite}</div>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                    <li><a class="dropdown-item" href="{{ url('/taches/high/${element.num_tache}') }}">High</a></li>
                                    <li><a class="dropdown-item" href="{{ url('/taches/medium/${element.num_tache}') }}">Medium</a></li>
                                    <li><a class="dropdown-item" href="{{ url('/taches/low/${element.num_tache}') }}">Low</a></li>
                                </ul>
                            </div>
                            <div class="statut">Statut : ${element.statut}</div>
                        </div>
                        <div class="middle">
                            <h4 class="tache-nom">${element.nom_tache}</h4>
                            <div class="description">${element.description}</div>
                        </div>
                        <div class="right">
                            <div class="photo-profil">
                                <img src="{{ asset('image/pp.png') }}" class="shadow" alt="" height="100" width="100">
                            </div>
                            <div class="assigne">${element.nom}</div>
                        </div>
                        <div class="right-ext">
                            <div class="edit-btn" data-toggle="modal" data-target="#exampleModalCenterUpdate" data-tache='${JSON.stringify(element)}'>
                                <i class="fa-solid fa-pen"></i>
                            </div>
                             <form action="{{ url('admin/taches/destroy/${element.num_tache}') }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="vilain" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette tâche ?');">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                `;
                container.innerHTML += row;
            });

             // Add event listener to edit buttons
             document.querySelectorAll('.edit-btn').forEach(button => {
                button.addEventListener('click', (event) => {
                    const tache = JSON.parse(button.getAttribute('data-tache'));
                    document.getElementById('updateTacheForm').setAttribute('action', `/admin/taches/update/${tache.num_tache}`);
                    document.getElementById('updateUser').value = tache.assigne_a;
                    document.getElementById('updateTitre').value = tache.nom_tache;
                    document.getElementById('updateDescription').value = tache.description;
                    document.querySelector(`input[name="priorite"][value="${tache.priorite}"]`).checked = true;
                });
            });
        }

        // Initial display
        afficherTaches(toutes);

        // Add event listeners to navigation items
        document.querySelectorAll('.navigation-right-2 div').forEach((navItem, index) => {
            navItem.addEventListener('click', () => {
                document.querySelectorAll('.navigation-right-2 div').forEach(li => li.classList.remove('active'));
                navItem.classList.add('active');

                switch (index) {
                    case 0:
                        afficherTaches(toutes);
                        break;
                    case 1:
                        afficherTaches(high);
                        break;
                    case 2:
                        afficherTaches(medium);
                        break;
                    case 3:
                        afficherTaches(low);
                        break;
                }
            });
        });
    });
</script>
@endsection

@section('nav')
    <li><a href="{{ route('admin.home') }}"><i class="fa-solid fa-house"></i></a></li>
    <li><a class="active-link" href="{{ route('admin.taches') }}"><i class="fa-solid fa-list-check"></i></a></li>
    <li><a href="{{ route('admin.users')}}"><i class="fa-solid fa-users-line"></i></a></li>
    <li><a href="{{ route('admin.profile')}}"><i class="fa-solid fa-user"></i></a></li>
@endsection

@section('content')
    <div class="home">
        <h1>TACHES</h1>
        <div class="taches-one">
            @if ($taches->isEmpty())
                <p style="text-align: center">Aucune tâche disponible.</p>
            @endif
        </div>
    </div>
    <div class="navigation-right-3">
        <div type="button" data-toggle="modal" data-target="#exampleModalCenter">
            Ajouter
        </div>
    </div>
    <div class="navigation-right-2">
        <div class="active">Toutes</div>
        <div>High</div>
        <div>Medium</div>
        <div>Low</div>
    </div>
@endsection


@section('modal')
    
 <!-- Modal -->
 <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Creer une tache</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form method="POST" action="{{route('taches.store')}}">
                @csrf
                <div class="form-group">
                  <label for="user">User</label>
                  @php
                      use App\Models\User;
                      $users = User::all();
                  @endphp
                  <select class="custom-select custom-select-sm" name="assigne_a" id="user" required>
                    <option selected>Assigne a</option>
                    @foreach ($users as $user)
                        <option value={{$user->email}}>{{$user->nom}} {{$user->prenom}}</option>
                    @endforeach
                  </select>
                  @if ($errors->has('user'))
                      <span class="text-danger">{{ $errors->first('user') }}</span>
                  @endif
                </div>
                <div class="form-group">
                    <label for="titre">Titre</label>
                    <input type="text" class="form-control" name="nom_tache" id="titre" placeholder="Donnez un titre" required>
                    @if ($errors->has('nom_tache'))
                        <span class="text-danger">{{ $errors->first('nom_tache') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" name="description" id="description" placeholder="Donnez une description" required></textarea>
                    @if ($errors->has('description'))
                        <span class="text-danger">{{ $errors->first('description') }}</span>
                    @endif
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="priorite" id="inlineRadio1" value="High" required>
                    <label class="form-check-label" for="inlineRadio1">High</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="priorite" id="inlineRadio2" value="Medium" required>
                    <label class="form-check-label" for="inlineRadio2">Medium</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="priorite" id="inlineRadio2" value="Low" required>
                    <label class="form-check-label" for="inlineRadio2">Low</label>
                </div>
                @if ($errors->has('priorite'))
                      <span class="text-danger">{{ $errors->first('priorite') }}</span>
                  @endif
                <small id="emailHelp" class="form-text text-muted">Choisissez la priorite.</small>
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
