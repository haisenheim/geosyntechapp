
@extends('......layouts.national')

@section('content-header')
    <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">CONSULTANTS</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/national/dashboard">ACCUEIL</a></li>

              <li class="breadcrumb-item active">Consultants</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
@endsection

@section('content')

    <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">BASE DE DONNEES NATIONALE DE CONSULTANTS</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="example1" class="table table-bordered table-hover table-condensed">
                    <thead>
                     <tr>
                            <th>NOM</th>
                            <th>PRENOM</th>
                            <th>ADRESSE</th>
                            <th>TELEPHONE</th>
                            <th>EMAIL</th>
                            <th>TYPE DE COMPTE</th>
                            <th></th>
                     </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <?php
                                 $rang= 'junior';
                                if($user->senior){
                                    $rang= 'senior';
                                }
                                if($user->confirmed){
                                    $rang= 'confirmé';
                                }
                            ?>
                            <tr>
                                <td>{!! $user->last_name !!} </td>
                                <td>{!! $user->first_name !!} </td>
                                <td>{!! $user->address !!} </td>
                                <td>{!! $user->phone !!} </td>
                                <td>{!! $user->email !!} </td>
                                <td> {{ $rang }}</td>
                                <td>
                                    <ul class="list-inline">
                                        <li title="Toutes les dettes" class="list-inline-item"><a class="btn btn-danger btn-xs" href="/national/consultant/creances/{{ $user->token }}"><i class="fa fa-coins"></i></a></li>
                                        <li title="Toutes les factures payées" class="list-inline-item"><a class="btn btn-warning btn-xs" href="/national/consultant/payees/{{ $user->token }}"><i class="fa fa-search"></i></a></li>

                                    </ul>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                      <th>NOM</th>
                      <th>PRENOM</th>
                      <th>ADRESSE</th>
                      <th>TELEPHONE</th>
                      <th>EMAIL</th>
                      <th>TYPE DE COMPTE</th>
                      <th></th>
                    </tr>
                    </tfoot>
                  </table>
                </div>
                <!-- /.card-body -->
              </div>

            </div>

            <!-- /.col -->
          </div>




<style>
    .table th,
    .table td {
      padding: 0.35rem;
      vertical-align: top;
      border-top: 1px solid #dee2e6;
    }
  </style>

  <link rel="stylesheet" href="{{asset('plugins/datatables-bs4/css/dataTables.bootstrap4.css')}}">

<!-- DataTables -->
<script src="{{asset('plugins/datatables/jquery.dataTables.js')}} "></script>
<script src="{{asset('plugins/datatables-bs4/js/dataTables.bootstrap4.js')}}"></script>

<script>
  $(function () {
    $("#example1").DataTable();

  });
</script>


@endsection