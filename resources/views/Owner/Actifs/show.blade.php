@extends('......layouts.owner')

@section('content-header')
    <div class="">
       <h3 style="font-weight: 800; margin-top: 50px; color: #FFFFFF; padding-bottom: 15px; border-bottom: solid #FFFFFF 1px;" class="page-header">GESTION DES CESSIONS D'ACTIFS</h3>
        <h5 style="font-weight: 600; margin-top: 20px; color: #FFFFFF; padding-bottom: 5px; border-bottom: solid #FFFFFF 1px;"> {{$projet->name}}</h5>
    </div>
@endsection

@section('content')
    <div style="padding-top: 30px" class="container-fluid">
                <div class="row">
                    <div class="col-md-4 col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                    <div style="height: 300px; width: 100%; background: url('{{ $projet->imageUri?asset('img/'.$projet->imageUri):asset('img/logo.png') }}'); background-size: cover ">

                                    </div>
                            <p>TYPE D'IMMOBILISATION : {{ $projet->tactif->name }}</p>
                            <p>DATE DE CREATION : <span class="value"> {{ date_format($projet->created_at,'d/m/Y') }}</span></p>
                            <p>PROMOTEUR : <span class="value">{{ $projet->owner->name }}</span></p>

                            <p>PRIX INITIAL : {{ $projet->prix }}</p>
                            <input type="hidden" id="id" value="<?= $projet->id ?>"/>
                            <p><i class="fa fa-map-marker"></i> {{ $projet->ville->name }}</p>
                            @if($projet->expert_id)
                                <p>CONSULTANT : <span class="value">{{ $projet->consultant->name }}</span></p>

                            @endif

                            @if($projet->cessions)
                                <h6>LISTE DES CANDIDATS</h6>
                                <ul class="list-group">
                                    @foreach($projet->cessions as $cession)
                                        <li class="list-group-item">
                                                <div class="card card-default cardutline direct-chat direct-chat-primary collapsed-card">
                                                              <div class="card-header">
                                                                <h3 class="card-title">{{$cession->angel->name}}</h3>

                                                                <div class="card-tools">
                                                                  <span data-toggle="tooltip" class="badge bg-primary">{{ count($cession->comments) }}</span>
                                                                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                                                                  </button>
                                                                  <button type="button" class="btn btn-tool" data-toggle="tooltip" title="Contacts"
                                                                          data-widget="chat-pane-toggle">
                                                                    <i class="fas fa-comments"></i></button>
                                                                  <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i>
                                                                  </button>
                                                                </div>
                                                              </div>
                                                              <!-- /.card-header -->
                                                              <div class="card-body">
                                                                <!-- Conversations are loaded here -->
                                                                <div class="direct-chat-messages">
                                                                  <!-- Message. Default to the left -->
                                                                  <div class="direct-chat-msg">
                                                                    <div class="direct-chat-infos clearfix">
                                                                      <span class="direct-chat-name float-left">Alexander Pierce</span>
                                                                      <span class="direct-chat-timestamp float-right">23 Jan 2:00 pm</span>
                                                                    </div>
                                                                    <div class="direct-chat-text">
                                                                      Is this template really for free? That's unbelievable!
                                                                    </div>
                                                                    <!-- /.direct-chat-text -->
                                                                  </div>
                                                                  <!-- /.direct-chat-msg -->

                                                                  <!-- Message to the right -->
                                                                  <div class="direct-chat-msg right">
                                                                    <div class="direct-chat-infos clearfix">
                                                                      <span class="direct-chat-name float-right">Sarah Bullock</span>
                                                                      <span class="direct-chat-timestamp float-left">23 Jan 2:05 pm</span>
                                                                    </div>
                                                                    <!-- /.direct-chat-infos -->

                                                                    <div class="direct-chat-text">
                                                                      You better believe it!
                                                                    </div>
                                                                    <!-- /.direct-chat-text -->
                                                                  </div>
                                                                  <!-- /.direct-chat-msg -->
                                                                </div>
                                                                <!--/.direct-chat-messages-->


                                                              </div>
                                                              <!-- /.card-body -->
                                                              <div class="card-footer">
                                                                <form action="#" class="form-send" method="post">
                                                                  <div class="input-group">
                                                                    <input data-id="{{ $cession->id }}" type="text" name="message" placeholder="Saisir un commentaire ..." class="form-control">
                                                                    <span class="input-group-append">
                                                                      <button class="btn btn-success btn-send">Envoyer</button>
                                                                    </span>
                                                                  </div>
                                                                </form>
                                                              </div>
                                                              <!-- /.card-footer-->
                                                            </div>

                                                            <script>
                                                                $('.form-send').submit(function(e){
                                                                    e.preventDefault();
                                                                    var msg = $(this).find('input').val();
                                                                    var id = $(this).find('input').data('id');
                                                                    $.ajax({
                                                                        url:'/owner/comment/save',
                                                                        type:'get',
                                                                        dataType:'json',
                                                                        data:{body:msg,cession_id:id},
                                                                        success:function()
                                                                    });
                                                                });
                                                            </script>

                                        </li>
                                    @endforeach
                                </ul>
                            @endif

                        </div>
                        </div>

                    </div>
                    <div class="col-md-8 col-sm-12">
                        <div class="card">
                            <div class="card-header">

                                    <h5>DESCRIPTION</h5>
                            </div>
                            <div class="card-body">
                                    <p>
                                        <?= $projet->description ?>
                                    </p>

                               </div>
                        </div>


                        <div class="card">
                               <div class="card-header">
                                    <h5>CARACTERISTIQUES</h5>
                               </div>
                               <div class="card-body">
                                    <p>
                                        <?= $projet->caracteristiques ?>
                                    </p>
                               </div>
                        </div>
                        @if($projet->teaser)
                            <div class="card">
                               <div class="card-header">
                                    <h5>TEASER</h5>
                               </div>
                               <div class="card-body">
                                    <p>
                                        <?= $projet->teaser ?>
                                    </p>
                               </div>
                            </div>
                        @endif
                    </div>
                        </div>
                    </div>


      <div class="modal fade modal-lg" id="EditModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                <h4 class="modal-title">{{ $projet->name }}</h4>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">x</span></button>
            </div>
            <div class="modal-body">
                 <form enctype="multipart/form-data" class="form" action="{{route('owner.update.actif')}}"  method="post">
                                    {{csrf_field()}}
                                    <input type="hidden" name="token" value="{{$projet->token}}"/>
                                    <input type="hidden" name="id" value="{{$projet->id}}"/>

                                    <fieldset>
                                        <legend>INFORMATIONS SUR L'ARTICLE</legend>
                                            <div class="row">
                                                 <div class="col-md-8">
                                                     <div class="form-group">
                                                         <label class="control-label">NOM</label>
                                                         <input id="name" name="name" maxlength="250" type="text" required="required" class="form-control" value="{{$projet->name}}">
                                                     </div>
                                                 </div>
                                                 <div class="col-md-4">
                                                     <div class="form-group">
                                                         <label for="prix" class="control-label">PRIX INITIAL</label>
                                                         <input id="prix" name="prix"  type="number"  class="form-control" value="{{$projet->prix}}">
                                                     </div>
                                                 </div>

                                                 <div class="col-md-6 col-sm-12">
                                                     <div class="form-group">
                                                         <label class="control-label">TYPE D'IMMOBILISATION</label>
                                                         <select class="form-control" name="tactif_id" id="variante_id">
                                                         <option value="{{$projet->tactif_id}}">{{$projet->tactif->name}}</option>
                                                            @foreach($tactifs as $p)
                                                               <option value='{!! $p->id !!}'>{{$p->name}}</option>
                                                            @endforeach
                                                         </select>
                                                     </div>
                                                 </div>
                                                 <div class="col-md-6">
                                                     <div class="form-group">
                                                         <label for="imageUri" class="control-label">PHOTO DE L'ARTICLE</label>
                                                         <input id="imageUri" name="imageUri" type="file"  class="form-control" placeholder="">
                                                     </div>
                                                 </div>
                                                 <div class="col-md-12 col-sm-12">
                                                     <div class="form-group">
                                                         <label for="description" class="control-label">DESCRIPTION</label>
                                                         <textarea name="description" id="description" cols="30" rows="3"><?= $projet->description ?></textarea>
                                                     </div>
                                                 </div>
                                                 <div class="col-md-12 col-sm-12">
                                                     <div class="form-group">
                                                         <label for="caracteristiques" class="control-label">CARACTERISTIQUES</label>
                                                         <textarea name="caracteristiques" id="caracteristiques" cols="30" rows="3"><?= $projet->caracteristiques ?></textarea>
                                                     </div>
                                                 </div>
                                                 <div class="col-md-6 col-sm-12">
                                                     <div class="form-group">
                                                         <label for="ville_id" class="control-label">VILLE</label>
                                                         <select class="form-control" name="ville_id" id="ville_id">
                                                         <option value="{{$projet->ville_id}}">{{$projet->ville->name}}</option>
                                                            @foreach($villes as $p)
                                                               <option value='{!! $p->id !!}'>{{$p->name}}</option>
                                                            @endforeach
                                                         </select>
                                                     </div>
                                                 </div>
                                             </div>

                                             <div class="btn-div card-footer text-center">
                                                 <button class="btn btn-success  btn-sm " type="submit"> Enregister <i class="fa fa-save"></i></button>
                                            </div>

                                     </fieldset>
                                </form>
            </div>
                </div>
            </div>
      </div>

      <script type="text/javascript" src="{{ asset('summernote/dist/summernote.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('summernote/lang/summernote-fr-FR.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('summernote/dist/summernote.css') }}"/>
    <script type="text/javascript">
        $(document).ready(function() {
          $('textarea').summernote({
            height: 200,
            tabsize: 2,
            followingToolbar: true,
            lang:'fr-FR'
          });
        });
      </script>
@endsection

@section('nav_actions')
    <a class="nav-link" data-toggle="dropdown" href="#">
             <i class="fas fa-cogs"></i>
             <span class="badge  navbar-badge"></span>
           </a>
           <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
             @if($projet->paye)
             <a href="#" data-toggle="modal" data-target="#addAngels" class="dropdown-item">
               <i class="fas fa-plus-circle mr-2"></i> Associer des investisseurs
             </a>
             @endif
             <div class="dropdown-divider"></div>
             <a href="#" data-target="#EditModal" data-toggle="modal" class="dropdown-item">
               <i class="fa fa-pencil mr-2"></i> Modifier
             </a>
             <div class="dropdown-divider"></div>
             <a href="#" class="dropdown-item">
               <i class="fas fa-envelope mr-2"></i> Contacter OBAC
             </a>


           </div>

@endsection

