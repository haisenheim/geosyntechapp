@extends('......layouts.owner')

@section('page-title')
{{ $projet->debiteur }} - {{ number_format($projet->montant,0,',','.')  }} <sup>{{ $projet->devise->abb }}</sup>
@endsection

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <form enctype="multipart/form-data" class="form" action="'owner/creances/update/{{ $projet }}" method="post">
                    {{csrf_field()}}

                    <fieldset>
                        <legend>INFORMATIONS SUR LA CREANCE</legend>
                            <div class="row">
                                 <div class="col-md-12">
                                     <div class="form-group">
                                         <label class="control-label">NOM DU DEBITEUR</label>
                                         <input id="name" name="debiteur" maxlength="250" type="text" required="required" class="form-control" value="{{ $projet->debiteur }}" placeholder="">
                                     </div>
                                 </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                     <div class="form-group">
                                         <label for="prix" class="control-label">MONTANT</label>
                                         <input id="prix" name="montant"  type="number"  class="form-control" placeholder="" value="{{ $projet->montant }}">
                                     </div>
                                 </div>
                                 <div class="col-md-4">
                                     <div class="form-group">
                                         <label for="prix" class="control-label">PRIX DE LA CESSION</label>
                                         <input id="prix" name="prix_cession"  type="number"  class="form-control" placeholder="" value="{{ $projet->prix_cession }}">
                                     </div>
                                 </div>
                                 <div class="col-md-4">
                                     <div class="form-group">
                                         <label for="prix" class="control-label">DATE DE PAIEMENT</label>
                                         <input id="prix" name="dt_paiement"  type="date"  class="form-control" placeholder="" value="{{$projet->dt_paiement}}"
                                     </div>
                                 </div>

                             </div>
                             <div class="row">
                                 <div class="col-md-12 col-sm-12">
                                     <div class="form-group">
                                         <label for="description" class="control-label">DESCRIPTION</label>
                                         <textarea name="description" id="description" cols="30" rows="3">{{$projet->description}}</textarea>
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

    <style>



        div.note-editor.note-frame{
            padding: 0;
        }
      .note-frame .btn-default {
            color: #222;
            background-color: #FFF;
            border-color: none;
        }
    </style>
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