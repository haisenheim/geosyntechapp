@extends('......layouts.angel')


<?php
use \Illuminate\Support\Facades\Auth;

    $projet = $investissement->dossier;
?>

@section('content-header')
 <h3 style="font-weight: 800; margin-top: 50px; color: #FFFFFF; padding-bottom: 15px; border-bottom: solid #FFFFFF 1px;" class="page-header">{{$projet->name}}</h3>
@endsection
@section('page-title')
{{$projet->name}}
@endsection

@section('content')
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.css') }}">
    <div style="padding-top: 30px; padding-bottom: 80px;" class="container-fluid">
                <div class="row">
                    <div id="side1" class="col-md-4 col-sm-12" style="">
                       @include('includes.Sidebars.dossier_angel')
                    </div>
                    <div style="" id="side2" class="col-md-8 col-sm-12">
                         @include('includes.Show.diagnostic1')
                    </div>
                </div>
                <div style="margin-top: 30px" class="">
                   @if($projet->etape>=2)
                      @include('includes.Show.diagnostic2')
                   @endif


                    @if($projet->etape>=3)
                       @include('includes.Show.diagnostic3')
                    @endif
                    @if($projet->etape>=4)
                         @include('includes.Show.plan_financier')
                    @endif
                  </div>

              </div>

         @if($projet->modepaiement_id>0)
          <input type="hidden" id="tokpay" value="<?= $projet->token ?>"/>
         @endif


    <!-- Edition de la synthese du diagnostic interne  -->
    @include('includes.Show.synthese1')
    <!-- Edition de la synthese du diagnostic externe-->
    @include('includes.Show.synthese2')
        <!-- Edition de la synthese du diagnostic Strategique -->
    @include('includes.Show.synthese3')
        <!-- Edition du teaser-->
        @include('includes.Show.teaser')

        @if($projet->modele)
        @include('includes.Show.business_model')
        @endif

    <div class="card card-success collapsed-card">
        <div class="card-header">
            <h5 class="card-title">Rapports mensuels de gestion</h5>
              <div class="card-tools">
                  <button title="dérouler" data-toggle="tooltip" type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="maximize" data-toggle="tooltip" title="Agrandir"><i class="fas fa-expand"></i>
                  </button>
              </div>
        </div>
        <div class="card-body">
            @if($investissement->report)
                @include('includes.Show.report')
            @else
                <div class="alert alert-danger">
                  <h5><i class="icon fas fa-ban"></i> Alert!</h5>
                    <p>VOUS N'ETES PAS AUTORISE A ACCEDER A CES INFORMATIONS. VEUILLEZ CONTACTER LE CABINET OBAC.</p>
                </div>
            @endif

         </div>
    </div>
    <div  class="modal fade" id="JustificatifModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header bg-info">
                <h4  class="modal-title text-center">CHARGEMENT Du JUSTIFICATIF DE VOTRE PAIEMENT</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div style="padding: 20px 20px 40px 20px; font-family: 'Gill Sans MT', Calibri, sans-serif" class="modal-body">
                 <form id="letter" enctype="multipart/form-data" class="form" action="/angel/investissement/doc/" method="post">
                    {{csrf_field()}}
                    <input type="hidden" name="token" value="{{ $investissement->token }}"/>
                    <input type="file" name="justificatifUri" id="justificatifUri" class="form-control"/>

                    <button id="btn-save3" type="submit" class="btn btn-info btn-block"> ENREGISTRER </button>
                </form>
              </div>

            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
    </div>

        @if($investissement->lettre)
       <div  class="modal fade" id="DocModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header bg-danger">
                <h4  class="modal-title text-center">CHARGEMENT DE VOTRE {{ $investissement->lettre->forme_id==1?'CONTRAT D\'ASSOCIES':$investissement->lettre->forme_id==2?'CONTRAT DE PRET':'CONTRAT D\'ENGAGEMENT' }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div style="padding: 20px 20px 40px 20px; font-family: 'Gill Sans MT', Calibri, sans-serif" class="modal-body">
                 <form id="letter" enctype="multipart/form-data" class="form" action="/angel/investissement/doc/" method="post">
                    {{csrf_field()}}
                    <input type="hidden" name="token" value="{{ $investissement->token }}"/>
                    <input type="file" name="docUri" id="docUri" class="form-control"/>

                    <button id="btn-save2" type="submit" class="btn btn-danger btn-block"> ENREGISTRER </button>
                </form>
              </div>

            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
    </div>
        @endif
      @include('includes.Edit.lettre_intention')

 <style>

    div.note-editor.note-frame{
          padding: 0;
      }
    .note-frame .btn-default {
          color: #222;
          background-color: #FFF;
          border-color: none;
      }

      label{
      color: #000000;
      margin-top: 10px;
      }

   .modal .card-title{
        color: #000000;
        font-weight: bold;
   }

   .modal label{
        font-size: x-small;
        line-height: 0.5;
   }
   .card.maximized-card {

      overflow-y: scroll;
   }

    #concurrents table th{
       max-width:50%;
    }

</style>

<script type="text/javascript" src="{{ asset('js/tinymce/jquery.tinymce.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/tinymce/tinymce.min.js') }}"></script>
 <script type="text/javascript" src="{{ asset('js/api.js') }}"></script>

<script>
    $(document).ready(function(){

         var h1 = $('#side1 .card').height();
         $('#side2 .card').height(h1).css({'overflow-y':'scroll'});

         $('#btn-print').click(function(e){
             e.preventDefault();
             var link='/print/projet/'+$('#tokpay').val();

             window.location.replace(link);
         });
        getPlan($('#plan_id').val());


        $.ajax({
            url: "/owner/dossier/getchoices",
            type:'Get',
            dataType:'json',
            data:{id:$('#tokpay').val()},
            success:function(data){
                if(data!=null){
                    $.ajax({
                        url:orm+'carto',
                        type:'Post',
                        dataType:'json',
                        data:{choix:data},
                        success:function(rep){
                            var html = '';
                            //console.log(Object.entries(rep));
                            var risks=Object.entries(rep);
                            for(var i=0; i<risks.length;i++){

                                var rs= parseInt(risks[i][1].length) + 1;
                                var tr= '<tr><th style="align-content: center; margin-top: auto" align="center" rowspan='+ rs  +'>'+ risks[i][0] +'</th></tr>';
                                html=html+tr;
                                for(var k=0; k<risks[i][1].length; k++){
                                    $value = risks[i][1][k];
                                    $cb= parseInt($value.question.produits_risque.frequence) * parseInt($value.question.produits_risque.gravite);
                                    $cn=parseInt($value.question.produits_risque.frequence) * parseInt($value.question.produits_risque.gravite) * parseFloat($value.taux);

                                    if(parseFloat($cb) >= 13){
                                        $clrb='red';
                                    }else{
                                        if( parseFloat($cb) >=4 && parseFloat($cb) <= 12){
                                            $clrb='yellow';
                                        }else{
                                            $clrb = '#0ac60a';
                                        }
                                    }

                                    if( parseFloat($cn) >= 13){
                                        $clr='red';
                                    }else{
                                        if( parseFloat($cn) >=4 &&  parseFloat($cn) <= 12){
                                            $clr='yellow';
                                        }else{
                                            $clr = '#0ac60a';
                                        }
                                    }

                                    var trr = '<tr>'+
                                        '<td>'+ $value.question.produits_risque.name +'</td>'+
                                        '<td>'+$value.question.produits_risque.causes +'</td>'+
                                        '<td>'+ $value.question.produits_risque.consequences +'</td>'+
                                        '<td>'+ $value.question.produits_risque.frequence +'</td>'+
                                        '<td>'+ $value.question.produits_risque.gravite+'</td>'+
                                        '<td style="background-color:'+ $clrb +'; font-weight: 900; text-align: right">'+ $cb  +'</td>'+
                                        '<td style="background-color:'+ $clr +'">'+ $cn +'</td>'+
                                    '</tr>';

                                    html=html+trr;

                                    //console.log(risks[i][1][k]);
                                }
                               // console.log(risks[i][1]);
                            }

                            $('#risques-tab').find('tbody').html(html);
                        },
                        Error:function(){
                            $('#risks-loader').hide();
                        }
                    });
                }

            }
        })


      tinymce.init({
        selector:'textarea'
      })
    });

    function getPlan(id){

             $.ajax({
               url:orm+'get-plan',
               type:'Get',
               dataType:'json',
               data:{id:id},
                   success:function(data){
                       //console.log(data);
                       if(data!=null){
                            $.ajax({
                              url:orm+'get-plan',
                              type:'Get',
                              dataType:'json',
                              data:{id:id},
                            success:function(){
                            }
                            });
                       }
                       var html = '';
                       var pls = data.plignes;
                       for(var i = 0; i<data.plignes.length; i++){

                            var tr ='<tr data-id="'+ pls[i].id +'"><td style="width: 13%">'+ pls[i].produits_risque.risque.name +'</td><td style="width: 20%">'+ pls[i].produits_risque.produit.name +'</td><td style="width: 20%">'+ pls[i].produits_risque.name +'</td><td contenteditable="true" style="width: 37%">'+ pls[i].amelioration +'</td></tr>';
                            html = html + tr;
                       }
                       $('#example').find('tbody').html(html);
                   },
               Error:function(){

               }
             });
        }
</script>

@endsection








