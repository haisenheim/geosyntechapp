@extends('......layouts.owner')

@section('page-title')
DOSSIERS DE PROJETS EN PHASE DE DEMARRAGE
@endsection
@section('content')
    <div style="padding-top: 30px" class="container-fluid">
        <div class="card">
        <div class="card-header">

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fas fa-minus"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fas fa-times"></i></button>
          </div>
        </div>

        <div class="card-body p-0">
          <table class="table table-striped projects" id="table-projets">
              <thead>
                  <tr>
                      <th style="width: 1%">
                          #
                      </th>
                      <th style="width: 38%">
                          Projet
                      </th>
                      <th style="width: 20%">
                          Consultant
                      </th>
                      <th>
                          Progression
                      </th>

                      <th style="width: 10%">
                      </th>
                  </tr>
              </thead>
              <tbody>


                   @foreach($dossiers as $projet)
                        <tr>
                            <td>#</td>
                            <td>
                            <span class="text-bold text-lg-left">{{ $projet->name }}</span>- <small>{{ $projet->created_at?date_format($projet->created_at,'d/m/Y'):'' }}</small>  - <span class="badge badge-default"><i class="fa fa-map-marker"></i>&nbsp; {{ $projet->ville->name  }}</span> <br/>
                            <?= $projet->active?'<span class="badge badge-success">ACTIF</span>':'<span class="badge badge-danger">Bloqué</span>' ?> -
                            <?= $projet->public?'<span class="badge badge-info">PUBLIC</span>':'<span class="badge badge-warning">PRIVE</span>' ?>
                            </td>

                            <td>{{$projet->consultant?$projet->consultant->name:'-'}}</td>
                            <td class="project_progress">
                          <div class="progress progress-sm">
                              <div class="progress-bar progress-bar-striped bg-{{$projet->progresscolor}}" role="progressbar" aria-volumenow="{{$projet->progress }}" aria-volumemin="0" aria-volumemax="100" style="width: {{$projet->progress .'%'}} ">
                              </div>
                          </div>
                          <small>
                             Complet à {{$projet->progress}}%
                          </small>
                      </td>


                      <td class="project-actions text-right">
                        <ul class="list-inline">
                            <li class="list-inline-item">
                                <a class="btn btn-info btn-xs" href="/owner/projets/{{ $projet->token  }}"><i class="fas fa-eye"></i>
                                 </a>
                            </li>
                            <li class="list-inline-item">
                                <a class="btn btn-warning btn-xs" href="/owner/projet/edit/{{ $projet->token  }}"><i class="fas fa-edit"></i></a>
                            </li>
                        </ul>



                      </td>
                        </tr>
                   @endforeach
              </tbody>
          </table>
        </div>
        <!-- /.card-body -->
      </div>

        <link rel="stylesheet" href="{{asset('plugins/datatables-bs4/css/dataTables.bootstrap4.css')}}">
        <!-- jQuery -->
        <script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>




        <!-- AdminLTE for demo purposes -->
        <script src="{{asset('dist/js/demo.js')}}"></script>
        <!-- DataTables -->
        <script src="{{asset('plugins/datatables/jquery.dataTables.js')}} "></script>
        <script src="{{asset('plugins/datatables-bs4/js/dataTables.bootstrap4.js')}}"></script>

        <script>
          $(function () {

            $('#table-projets').DataTable({
              "paging": true,
              "lengthChange": false,

              "ordering": true,
              "info": true,
              "autoWidth": false
            });
          });
        </script>

     </div>

@endsection

@section('nav_actions')
<main>
    <nav class="floating-menu">
        <ul class="main-menu">
            <li>
                <a title="Nouveau Dossier" href="/owner/projets/create" class="ripple">
                    <i class="fa fa-plus-circle fa-lg"></i>
                </a>
            </li>
        </ul>
        <div class="menu-bg"></div>
    </nav>
</main>

@endsection