@extends('......layouts.consultant')

@section('content-header')
 <h3 style="font-weight: 800; margin-top: 50px; color: #FFFFFF; padding-bottom: 15px; border-bottom: solid #FFFFFF 1px;" class="page-header">{{$projet->name}}</h3>
@endsection


@section('content')
    <div style="padding-top: 30px; padding-bottom: 80px;" class="container-fluid">
                <div class="row">
                    <div id="side1" class="col-md-4 col-sm-12">
                        <div class="card">
                            <div class="card-body">

                            <a data-toggle="modal" data-target="#uploadImgModal" href="" title="modifier l'image"><i class="fa fa-pencil"></i>
                            <div style="height: 300px; width: 100%; background: url('{{ $projet->imageUri?asset('img/'.$projet->imageUri):asset('img/logo.png') }}'); background-size: cover ">

                            </div>
                            </a>
                            <p>CODE : {{ $projet->code }}</p>
                            <p>DATE DE CREATION : <span class="value"> {{ date_format($projet->created_at,'d/m/Y') }}</span></p>
                            <p>PROMOTEUR : <span class="value">{{ $projet->owner->name }}</span></p>
                            <p>AUTEUR : {{ $projet->auteur->name }}</p>
                            <p class="text-danger" style="font-weight: 700" > {{ $projet->capital?'DOSSIER D\'AUGMENTATION DE CAPITAL':'' }}</p>

                            @if($projet->etape>=4)
                                <ul class="list-group">
                                    <li class="list-group-item">MONTANT DES INVESTISSEMENT : <span class="value"><?= $projet->montant_investissement ?></span></li>
                                    <li class="list-group-item">BESOIN EN FONDS DE ROULEMENT : <span class="value"><?= $projet->bfr ?></span></li>
                                    <li style="font-weight: bold;" class="list-group-item">COUT GLOBAL DU PROJET : <span class="value"><?= $projet->montant_investissement + $projet->bfr ?></span></li>
                                </ul>

                                <fieldset>
                                    <legend>MOYENS DE FINANCEMENT</legend>
                                    <ul class="list-group">
                                        @if($projet->moyens)
                                            @foreach($projet->financements as $moyen)

                                                <li class="list-group-item"><?= $moyen->moyen? $moyen->moyen->name:'-' ?> : <span class="value"><?= $moyen->montant ?></span></li>
                                            @endforeach
                                        @endif
                                    </ul>
                                </fieldset>
                                
                            @endif
                            <input type="hidden" id="id" value="<?= $projet->id ?>"/>
                            <p><i class="fa fa-map-marker"></i> {{ $projet->ville->name }}</p>
                            @if($projet->expert_id)
                                <p>CONSULTANT : <span class="value">{{ $projet->consultant->name }}</span></p>
                             @else
                                <form class="form-inline"  action="/admin/dossier/expert">
                                {{csrf_field()}}
                                <input type="hidden" name="id" value="{{ $projet->id }}"/>
                                    <div class="form-group">
                                        <select class="form-text" name="expert_id" id="id">
                                            @foreach($experts as $expert)
                                                <option value="{{ $expert->id }}">{{ $expert->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-danger"><i class="fa fa-link"></i> LIER</button>
                                    </div>
                                </form>
                            @endif


                            <button data-toggle="modal" data-target="#synDiagIntModal" class="btn btn-default btn-xs"><i class="fa fa-pencil"></i>SYNTHESE DU DIAGNOSTIC INTERNE</button>


                            @if($projet->etape>=2)
                                <button style="margin-top: 7px" data-toggle="modal" data-target="#synDiagExtModal" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i>SYNTHESE DU DIAGNOSTIC EXTERNE</button>
                            @endif

                            @if($projet->etape>=3)
                                <button style="margin-top: 7px" data-toggle="modal" data-target="#synDiagStratModal" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i>SYNTHESE DU DIAGNOSTIC STRATEGIQUE</button>
                            @endif

                             @if($projet->etape>=4)
                                <button style="margin-top: 7px" data-toggle="modal" data-target="#teaserModal" class="btn btn-success btn-xs"><i class="fa fa-pencil"></i> EDITER LE TEASER</button>
                            @endif


                            @if($projet->modepaiement_id>0)
                                <h6 class="page-header" style="background-color: inherit">MODALITE DE PAIEMENT</h6>
                                <ul class="list-group">
                                    <li class="list-group-item"><span style="font-weight: 700">{{ $projet->modepaiement->name }}</span></li>
                                    <li class="list-group-item" >PRIX HT : <span style="font-weight: 700">{{ $projet->modepaiement->prix }}</span></li>
                                    <li class="list-group-item">PRIX TTC : <span style="font-weight: 700">{{ $projet->modepaiement->prixttc }}</span></li>
                                </ul>
                            @else
                                <div>
                                    <h6 class="page-header" style="background-color: inherit">MODALITE DE PAIEMENT</h6>

                                    <ul class="list-group">
                                        <li class="list-group-item"><span id="mode_name" style="font-weight: 700"></span></li>
                                        <li class="list-group-item" >PRIX HT : <span id="mode_prix" style="font-weight: 700"></span></li>
                                        <li class="list-group-item">PRIX TTC : <span id="mode_prixttc" style="font-weight: 700"></span></li>
                                        <li class="list-group-item">
                                        <p id="mode_description"></p>
                                        </li>
                                    </ul>
                                    <hr/>
                                    <form action="/consultant/dossier/add-mode" method="get" class="form-inline">
                                        <input type="hidden" id="projet_token" value="<?= $projet->token ?>" name="projet_token"/>
                                        <select style="background-color: #FFFFFF" class="form-control" name="mode_id" id="mode_id">
                                            <option value="0">Choix d'une offre de service</option>
                                            @foreach($modes as $mode)
                                                <option value="{{ $mode->id }}">{{ $mode->name }}</option>
                                            @endforeach
                                        </select>
                                        <button class="btn btn-xs btn-danger" type="submit"><i class="fa fa-check"></i> ENREGISTRER</button>

                                    </form>
                                </div>
                            @endif

                        </div>
                        </div>


                    </div>
                    <div style="overflow-y: scroll;" id="side2" class="col-md-8 col-sm-12">
                        <div class="card">
                            <div class="card-body">
                               <fieldset>
                                    <legend>DIAGNOSTIC INTERNE</legend>
                                    <ul class="nav nav-tabs pull-right" style="margin: 2px 10px 20px 0" id="objTabs" role="tablist">
                                         <li role="presentation" class="active">
                                             <a href="#etats" role="tab" id="tab1" data-toggle="tab" aria-controls="n1" aria-expanded="false"><span class=""></span> ETATS FINANCIERS </a>
                                         </li>

                                         <li role="presentation" class="">
                                             <a href="#risques" role="tab" id="tab2" data-toggle="tab" aria-controls="n2" aria-expanded="false"><span class=""></span> CARTOGRAPHIE DES RISQUES </a>
                                         </li>
                                     </ul>

                                     <div class="tab-content" id="myTabContent">
                                        <div class="tab-pane fade active in" role="tabpanel" id="etats" aria-labelledby="tab1">
                                             <div>


                                                     <div>
                                                        <h4 class="page-header">SANTE FINANCIERE</h4>
                                                        <table class="table table-condensed table-hover">
                                                            <thead>
                                                            <tr>
                                                                <th></th>
                                                                <th><?= isset($projet->bilans[0])?$projet->bilans[0]->annee:'' ?></th>
                                                                <th><?= isset($projet->bilans[1])?$projet->bilans[0]->annee:'' ?></th>
                                                                <th>TAUX DE VARIATION</th>
                                                                <th><?= isset($projet->bilans[2])?$projet->bilans[0]->annee:'' ?></th>
                                                                <th>TAUX DE VARIATION</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <tr>
                                                                <td>RESSOURCES DURABLES</td>
                                                                <td><?= isset($projet->bilans[0])?$projet->bilans[0]->ress_durable:'' ?></td>
                                                                <td><?= isset($projet->bilans[1])?$projet->bilans[0]->ress_durable:'' ?></td>
                                                                <td></td>
                                                                <td><?= isset($projet->bilans[2])?$projet->bilans[0]->ress_durable:'' ?></td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <td>ACTIFS IMMOBILISES</td>
                                                                <td><?= isset($projet->bilans[0])?$projet->bilans[0]->actifs_immo:'' ?></td>
                                                                <td><?= isset($projet->bilans[1])?$projet->bilans[0]->actifs_immo:'' ?></td>
                                                                <td></td>
                                                                <td><?= isset($projet->bilans[2])?$projet->bilans[0]->actifs_immo:'' ?></td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <td>FONDS DE ROULEMENT NET GLOBAL</td>
                                                                <th><?= $projet->frng_0 ?></th>
                                                                <th><?= $projet->frng_0 ?></th>
                                                                <th></th>
                                                                <th><?= $projet->frng_0 ?></th>
                                                                <th></th>
                                                            </tr>
                                                            <tr>
                                                                <td>CREANCES</td>
                                                                <td><?= isset($projet->bilans[0])?$projet->bilans[0]->creances:'' ?></td>
                                                                <td><?= isset($projet->bilans[1])?$projet->bilans[0]->creances:'' ?></td>
                                                                <td></td>
                                                                <td><?= isset($projet->bilans[2])?$projet->bilans[0]->creances:'' ?></td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <td>STOCKS</td>
                                                                <td><?= isset($projet->bilans[0])?$projet->bilans[0]->stocks:'' ?></td>
                                                                <td><?= isset($projet->bilans[1])?$projet->bilans[0]->stocks:'' ?></td>
                                                                <td></td>
                                                                <td><?= isset($projet->bilans[2])?$projet->bilans[0]->stocks:'' ?></td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <td>DETTES</td>
                                                                <td><?= isset($projet->bilans[0])?$projet->bilans[0]->dettes:'' ?></td>
                                                                <td><?= isset($projet->bilans[1])?$projet->bilans[0]->dettes:'' ?></td>
                                                                <td></td>
                                                                <td><?= isset($projet->bilans[2])?$projet->bilans[0]->dettes:'' ?></td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <td>BESOIN EN FONDS DE ROULEMENT</td>
                                                                <th><?= isset($projet->bilans[0])?$projet->bilans[0]->bfr:'' ?></th>
                                                                <th><?= isset($projet->bilans[1])?$projet->bilans[0]->bfr:'' ?></th>
                                                                <th><?= $projet->tvbfr_0 ?></th>
                                                                <th><?= isset($projet->bilans[2])?$projet->bilans[0]->bfr:'' ?></th>
                                                                <th><?= $projet->tvbfr_1 ?></th>
                                                            </tr>
                                                            <tr>
                                                                <td>TRESORERIE NETTE</td>
                                                                <th><?= $projet->tsrn_0 ?></th>
                                                                <th><?= $projet->tsrn_1 ?></th>
                                                                <th><?= $projet->tvtsr_0 ?></th>
                                                                <th><?= $projet->tsrn_2 ?></th>
                                                                <th><?= $projet->tvtsr_1 ?></th>
                                                            </tr>
                                                            </tbody>
                                                        </table>


                                                        <h5>PERFORMANCE FINANCIERE</h5>
                                                        <table class="table table-bordered table-condensed">
                                                            <thead>
                                                            <tr>
                                                                <th></th>
                                                                <th><?= isset($projet->resultats[0])?$projet->resultats[0]->annee:'' ?></th>
                                                                <th><?= isset($projet->resultats[1])?$projet->resultats[1]->annee:'' ?></th>
                                                                <th>TAUX DE VARIATION</th>
                                                                <th><?= isset($projet->resultats[2])?$projet->resultats[2]->annee:'' ?></th>
                                                                <th>TAUX DE VARIATION</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <tr>
                                                                <td>CHIFFRE D'AFFAIRE</td>

                                                                <td><?= isset($projet->resultats[0])?$projet->resultats[0]->ca:'' ?></td>
                                                                <td><?= isset($projet->resultats[1])?$projet->resultats[1]->ca:'' ?></td>
                                                                <td><?= $projet->tvca_0 ?></td>
                                                                <td><?= isset($projet->resultats[2])?$projet->resultats[2]->ca:'' ?></td>
                                                                <td><?= $projet->tvca_0 ?></td>

                                                            </tr>
                                                            <tr>
                                                                <td>CHARGES VARIABLES</td>

                                                                <td><?= isset($projet->resultats[0])?$projet->resultats[0]->cv:'' ?></td>
                                                                <td><?= isset($projet->resultats[1])?$projet->resultats[1]->cv:'' ?></td>
                                                                <td></td>
                                                                <td><?= isset($projet->resultats[2])?$projet->resultats[2]->cv:'' ?></td>
                                                                <td></td>

                                                            </tr>
                                                            <tr>
                                                                <th>MARGE BRUTE</th>
                                                                <th><?= $projet->mb_0 ?></th>
                                                                <th><?= $projet->mb_1 ?></th>
                                                                <th><?= $projet->tvmb_0 ?></th>
                                                                <th><?= $projet->mb_2 ?></th>
                                                                <th><?= $projet->tvmb_1 ?></th>

                                                            </tr>
                                                            <tr>
                                                                <td>CHARGES FIXES</td>

                                                                <td><?= isset($projet->resultats[0])?$projet->resultats[0]->cf:'' ?></td>
                                                                <td><?= isset($projet->resultats[1])?$projet->resultats[1]->cf:'' ?></td>
                                                                <td></td>
                                                                <td><?= isset($projet->resultats[2])?$projet->resultats[2]->cf:'' ?></td>
                                                                <td></td>

                                                            </tr>
                                                            <tr>
                                                                <th>VALEUR AJOUTEE</th>

                                                                <td><?= $projet->va_0 ?></td>
                                                                <td><?= $projet->va_1 ?></td>
                                                                <th><?= $projet->tvva_0 ?></th>
                                                                <td><?= $projet->va_2 ?></td>
                                                                <th><?= $projet->tvva_1 ?></th>

                                                            </tr>
                                                            <tr>
                                                                <td>SALAIRES</td>

                                                                <td><?= isset($projet->resultats[0])?$projet->resultats[0]->salaires:'' ?></td>
                                                                <td><?= isset($projet->resultats[1])?$projet->resultats[1]->salaires:'' ?></td>
                                                                <td></td>
                                                                <td><?= isset($projet->resultats[2])?$projet->resultats[2]->salaires:'' ?></td>
                                                                <td></td>

                                                            </tr>
                                                            <tr>
                                                                <th>EXCEDENT BRUT D'EXPLOITATION</th>

                                                                <td><?= $projet->ebe_0 ?></td>
                                                                <td><?= $projet->ebe_1 ?></td>
                                                                <th><?= $projet->tvebe_0 ?></th>
                                                                <td><?= $projet->ebe_2 ?></td>
                                                                <th><?= $projet->tvebe_1 ?></th>

                                                            </tr>
                                                            <tr>
                                                                <td>DOTATIONS AUX AMORTISSEMENTS ET AUX PROVISIONS</td>
                                                                <td><?= isset($projet->resultats[0])?$projet->resultats[0]->dap:'' ?></td>
                                                                <td><?= isset($projet->resultats[1])?$projet->resultats[1]->dap:'' ?></td>
                                                                <td></td>
                                                                <td><?= isset($projet->resultats[2])?$projet->resultats[2]->dap:'' ?></td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <th>RESULTAT D'EXPLOITATION</th>

                                                                <th><?= $projet->re_0 ?></th>
                                                                <th><?= $projet->re_1 ?></th>
                                                                <th><?= $projet->tvre_0 ?></th>
                                                                <th><?= $projet->re_2 ?></th>
                                                                <th><?= $projet->tvre_1 ?></th>
                                                            </tr>
                                                            <tr>
                                                                <td>PRODUITS FINANCIERS</td>

                                                                <td><?= isset($projet->resultats[0])?$projet->resultats[0]->pf:'' ?></td>
                                                                <td><?= isset($projet->resultats[1])?$projet->resultats[1]->pf:'' ?></td>
                                                                <td></td>
                                                                <td><?= isset($projet->resultats[2])?$projet->resultats[2]->pf:'' ?></td>
                                                                <td></td>

                                                            </tr>
                                                            <tr>
                                                                <td>CHARGES FINANCIERES</td>

                                                                <td><?= isset($projet->resultats[0])?$projet->resultats[0]->cfi:'' ?></td>
                                                                <td><?= isset($projet->resultats[1])?$projet->resultats[1]->cfi:'' ?></td>
                                                                <td></td>
                                                                <td><?= isset($projet->resultats[2])?$projet->resultats[2]->cfi:'' ?></td>
                                                                <td></td>

                                                            </tr>
                                                            <tr>
                                                                <th>RESULTAT FINANCIER</th>

                                                                <th><?= $projet->rf_0 ?></th>
                                                                <th><?= $projet->rf_1 ?></th>
                                                                <th><?= $projet->tvrf_0 ?></th>
                                                                <th><?= $projet->rf_2 ?></th>
                                                                <th><?= $projet->tvrf_1 ?></th>

                                                            </tr>
                                                            <tr>
                                                                <td>PRODUIT EXCEPTIONNEL</td>

                                                                <td><?= isset($projet->resultats[0])?$projet->resultats[0]->pe:'' ?></td>
                                                                <td><?= isset($projet->resultats[1])?$projet->resultats[1]->pe:'' ?></td>
                                                                <td></td>
                                                                <td><?= isset($projet->resultats[2])?$projet->resultats[2]->pe:'' ?></td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <td>CHARGES EXCEPTIONNELLES</td>

                                                                <td><?= isset($projet->resultats[0])?$projet->resultats[0]->ce:'' ?></td>
                                                                <td><?= isset($projet->resultats[1])?$projet->resultats[1]->ce:'' ?></td>
                                                                <td></td>
                                                                <td><?= isset($projet->resultats[2])?$projet->resultats[2]->ce:'' ?></td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <th>RESULTAT EXCEPTIONNEL</th>

                                                                <th><?= $projet->rex_0 ?></th>
                                                                <th><?= $projet->rex_1 ?></th>
                                                                <th><?= $projet->tvrex_0 ?></th>
                                                                <th><?= $projet->rex_2 ?></th>
                                                                <th><?= $projet->tvrex_1 ?></th>

                                                            </tr>
                                                            <tr>
                                                                <th>RESULTAT COURANT AVANT IMPOT</th>

                                                                <th><?= $projet->rcai_0 ?></th>
                                                                <th><?= $projet->rcai_1 ?></th>
                                                                <th><?= $projet->tvrcai_0 ?></th>
                                                                <th><?= $projet->rcai_2 ?></th>
                                                                <th><?= $projet->rcai_1 ?></th>

                                                            </tr>
                                                            <tr>
                                                                <td>IMPOTS</td>

                                                                <td><?= isset($projet->resultats[0])?$projet->resultats[0]->impots:'' ?></td>
                                                                <td><?= isset($projet->resultats[1])?$projet->resultats[1]->impots:'' ?></td>
                                                                <td></td>
                                                                <td><?= isset($projet->resultats[2])?$projet->resultats[2]->impots:'' ?></td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <th>RESULTAT NET</th>

                                                                <th><?= $projet->rn_0 ?></th>
                                                                <th><?= $projet->rn_1 ?></th>
                                                                <th><?= $projet->tvrn_0 ?></th>
                                                                <th><?= $projet->rn_2 ?></th>
                                                                <th><?= $projet->tvrn_1 ?></th>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                     </div>

                                             </div>

                                        </div>

                                        <div class="tab-pane fade" role="tabpanel" id="risques" aria-labelledby="">
                                             <table id="risques-tab" class="table table-condensed table-hover table-bordered">
                                                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>Defaillances possibles</th>
                                                    <th>Causes</th>
                                                    <th>Consequences</th>
                                                    <th>Frequence</th>
                                                    <th>Gravite</th>
                                                    <th>Criticite brut</th>

                                                    <th>Criticite nette</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                                </table>
                                            <div style="width: 20%; margin:10px auto">
                                                <span id="risks-loader"  class="dashboard-spinner spinner-success spinner-xl "></span>
                                            </div>
                                        </div>
                                     </div>
                               </fieldset>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <div class="widget">
                            <div class="widget-content">
                     @if($projet->etape>=2)

                               <fieldset>
                                   <legend>DIAGNOSTIC EXTERNE</legend>
                                   <ul class="nav nav-tabs pull-right" style="margin: 2px 10px 20px 0" id="objTabs" role="tablist">
                                         <li role="presentation" class="active">
                                             <a href="#segments" role="tab" id="tab1" data-toggle="tab" aria-controls="n1" aria-expanded="false"><span class=""></span> ANALYSE DE LA DEMANDE </a>
                                         </li>

                                         <li role="presentation" class="">
                                             <a href="#concurrents" role="tab" id="tab2" data-toggle="tab" aria-controls="n2" aria-expanded="false"><span class=""></span> ANALYSE DE L'OFFRE </a>
                                         </li>

                                         <li role="presentation" class="">
                                             <a href="#environnement" role="tab" id="tab3" data-toggle="tab" aria-controls="n2" aria-expanded="false"><span class=""></span> ANALYSE DE L'ENVIRONNMENT </a>
                                         </li>


                                    </ul>

                                    <div class="tab-content" id="myTabContent">
                                        <div class="tab-pane fade active in" role="tabpanel" id="segments" aria-labelledby="tab1">
                                             <div>
                                                     <div>


                                                            <?php if($projet->segments): ?>

                                                            <table class="table table-bordered">

                                                                <tbody>
                                                                <?php $i=0; $quoi=""; $qui=""; $ou=""; $comment=""; $combien=""; $quand="";
                                                                $ca=""; $cv=""; $cf=""; $mb=""; $va=""; $salaires=""; $ebe=""; $pourquoi=""; $con ="";
                                                                foreach($projet->segments as $segment): ?>
                                                                    <?php
                                                                    $con = $con."<th>SEGMENT ". ++$i ."</th>";
                                                                    $quoi=$quoi."<td>".$segment->quoi."</td>";
                                                                    $qui=$qui."<td>".$segment->name."</td>";
                                                                    $quand=$quand."<td>".$segment->quand."</td>";
                                                                    $combien=$combien."<td>".$segment->combien."</td>";
                                                                    $ou=$ou."<td>".$segment->ou."</td>";
                                                                    $comment=$comment."<td>".$segment->comment."</td>";
                                                                    $pourquoi=$pourquoi."<td>".$segment->pourquoi."</td>";

                                                                    ?>
                                                                <?php endforeach; ?>
                                                                <tr><th></th><?= $con ?></tr>
                                                                <tr> <th>QUI</th> <?= $qui ?> </tr>
                                                                <tr><th>QUOI</th> <?= $quoi ?> </tr>
                                                                <tr> <th>OU</th> <?= $ou ?> </tr>
                                                                <tr> <th>QUAND</th> <?= $quand ?> </tr>
                                                                <tr> <th>COMBIEN</th> <?= $combien ?> </tr>
                                                                <tr> <th>POURQUOI</th> <?= $pourquoi ?> </tr>

                                                                </tbody>
                                                            </table>
                                                        <?php endif; ?>


                                                     </div>

                                             </div>

                                        </div>

                                        <div class="tab-pane fade" role="tabpanel" id="concurrents" aria-labelledby="">
                                        <?php if($projet->concurrents): ?>
                                            <table class="table table-bordered">

                                            <tbody>
                                            <?php $i=0; $quoi=""; $qui=""; $ou=""; $comment=""; $combien=""; $quand="";
                                            $ca=""; $cv=""; $cf=""; $mb=""; $va=""; $salaires=""; $ebe=""; $pourquoi=""; $con ="";
                                            foreach($projet->concurrents as $segment): ?>
                                                <?php
                                                $con = $con."<th>CONCURRENT ". ++$i ."</th>";
                                                $quoi=$quoi."<td>".$segment->quoi."</td>";
                                                $qui=$qui."<td>".$segment->name."</td>";
                                                $quand=$quand."<td>".$segment->quand."</td>";
                                                $combien=$combien."<td>".$segment->combien."</td>";
                                                $ou=$ou."<td>".$segment->ou."</td>";
                                                $comment=$comment."<td>".$segment->comment."</td>";
                                                $pourquoi=$pourquoi."<td>".$segment->pourquoi."</td>";
                                                $ca=$ca."<td>".$segment->ca."</td>";
                                                $cv=$cv."<td>".$segment->cv."</td>";
                                                $cf=$cf."<td>".$segment->cf."</td>";
                                                $salaires=$salaires."<td>".$segment->salaires."</td>";
                                                $va=$va."<td>".$segment->va."</td>";
                                                $mb=$mb."<td>".$segment->marge_brute."</td>";
                                                $ebe=$ebe."<td>".$segment->ebe."</td>";
                                                ?>
                                            <?php endforeach; ?>
                                            <tr><th></th><?= $con ?></tr>
                                            <tr> <th>QUI</th> <?= $qui ?> </tr>
                                           <tr><th>QUOI</th> <?= $quoi ?> </tr>
                                           <tr> <th>OU</th> <?= $ou ?> </tr>
                                           <tr> <th>QUAND</th> <?= $quand ?> </tr>
                                           <tr> <th>COMBIEN</th> <?= $combien ?> </tr>
                                           <tr> <th>POURQUOI</th> <?= $pourquoi ?> </tr>
                                           <tr> <th>CA</th> <?= $ca ?> </tr>
                                           <tr> <th>Charges variables</th> <?= $cv ?> </tr>
                                           <tr> <th>Marge brute</th> <?= $mb ?> </tr>
                                           <tr> <th>Charges fixes</th> <?= $cf ?> </tr>
                                          <tr>  <th>Valeur ajoutee</th> <?= $va ?> </tr>
                                           <tr> <th>Salaires</th> <?= $salaires ?> </tr>
                                           <tr> <th>EBE</th> <?= $ebe ?> </tr>
                                            </tbody>
                                        </table>
                                        <?php endif; ?>

                                        </div>

                                        <div class="tab-pane fade" role="tabpanel" id="environnement" aria-labelledby="">
                                              <?php if($projet->environnement): ?>
                                                    <table class="table table-bordered table-condensed">
                                                        <thead>
                                                        <tr >
                                                            <th style="width: 25%"></th>
                                                            <th>OPPORTUNUITES</th>
                                                            <th>MENACES</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <tr id="ps">
                                                            <th style="width: 25%" >POLITIQUE SECTORIELLE</th>
                                                            <td ><?= $projet->environnement->pol_secto_op ?></td>
                                                            <td ><?= $projet->environnement->pol_secto_men ?></td>
                                                        </tr>
                                                        <tr id="cmep">
                                                            <th style="width: 25%">CADRE MACRO ECONOMIQUE DU PROJET</th>
                                                            <td ><?= $projet->environnement->cadre_macroeco_op ?></td>
                                                            <td ><?= $projet->environnement->cadre_macroeco_men ?></td>
                                                        </tr>
                                                        <tr id="asc">
                                                            <th style="width: 25%">ASPECTS SOCIO-CULTURELS</th>
                                                            <td ><?= $projet->environnement->asp_sociocult_op ?></td>
                                                            <td ><?= $projet->environnement->asp_sociocult_men ?></td>
                                                        </tr>
                                                        <tr id="et">
                                                            <th style="width: 25%">ENVIRONNEMENT TECHNOLOGIQUES</th>
                                                            <td ><?= $projet->environnement->env_tech_op ?></td>
                                                            <td ><?= $projet->environnement->env_tech_men ?></td>
                                                        </tr>
                                                        <tr id="iep">
                                                            <th style="width: 25%">IMPACT ENVIRONNEMENTAL DU PROJET</th>
                                                            <td ><?= $projet->environnement->impact_env_op ?></td>
                                                            <td ><?= $projet->environnement->impact_env_men ?></td>
                                                        </tr>
                                                        <tr id="crp">
                                                            <th style="width: 25%">CADRE REGLEMENTAIRE DU PROJET</th>
                                                            <td ><?= $projet->environnement->cadre_regl_op ?></td>
                                                            <td ><?= $projet->environnement->cadre_regl_men ?></td>
                                                        </tr>
                                                        <tr id="pnf">
                                                            <th style="width: 25%">POUVOIR DE NEGOCIATION DES FOURNISSEURS</th>
                                                            <td ><?= $projet->environnement->pouv_nego_frn_op ?></td>
                                                            <td ><?= $projet->environnement->pouv_nego_frn_men ?></td>
                                                        </tr>
                                                        <tr id="pnc">
                                                            <th style="width: 25%">POUVOIR DE NEGOCIATION DES CLIENTS</th>
                                                            <td ><?= $projet->environnement->pouv_nego_cli_op ?></td>
                                                            <td ><?= $projet->environnement->pouv_nego_cli_men ?></td>
                                                        </tr>
                                                        <tr id="pps">
                                                            <th style="width: 25%">PERFORMANCES  DES PRODUITS DE SUBSTITUTION </th>
                                                            <td ><?= $projet->environnement->perf_prdt_subst_op ?></td>
                                                            <td ><?= $projet->environnement->perf_prdt_subst_men ?></td>
                                                        </tr>
                                                        <tr id="ic">
                                                            <th style="width: 25%">INTENSITE CONCURRENTIELLE</th>
                                                            <td ><?= $projet->environnement->intensite_concu_op ?></td>
                                                            <td ><?= $projet->environnement->intensite_concu_men ?></td>
                                                        </tr>

                                                        </tbody>
                                                    </table>
                                              <?php endif; ?>
                                        </div>

                                     </div>
                               </fieldset>
                     @endif

                        </div>
                    </div>
                 </div>

                    @if($projet->etape>=3)
                     <div class="col-md-12 col-sm-12">
                           <div class="widget">
                            <div class="widget-content">
                                   <fieldset>
                                      <legend>DIAGNOSTIC STRATEGIQUE</legend>
                                       <ul class="nav nav-tabs pull-right" style="margin: 2px 10px 20px 0" id="objTabs" role="tablist">
                                            <li role="presentation" class="active">
                                                <a href="#swot" role="tab" id="tab1" data-toggle="tab" aria-controls="n1" aria-expanded="false"><span class=""></span> SWOT </a>
                                            </li>

                                            <li role="presentation" class="">
                                                <a href="#objectifs" role="tab" id="tab2" data-toggle="tab" aria-controls="n2" aria-expanded="false"><span class=""></span> OBJECTIFS </a>
                                            </li>

                                            <li role="presentation" class="">
                                                <a href="#organisation" role="tab" id="tab3" data-toggle="tab" aria-controls="n2" aria-expanded="false"><span class=""></span> ORGANISATION DU TRAVAIL </a>
                                            </li>

                                            <li role="presentation" class="">
                                                 <a href="#actions" role="tab" id="tab4" data-toggle="tab" aria-controls="n2" aria-expanded="false"><span class=""></span> ACTIONS DE MAITRISE </a>
                                            </li>

                                            <li role="presentation" class="">
                                                <a href="#etapes" role="tab" id="tab5" data-toggle="tab" aria-controls="n2" aria-expanded="false"><span class=""></span> PLAN D'ACTION STRATEGIQUE </a>
                                            </li>

                                            <li role="presentation" class="">
                                                <a href="#faisabilite" role="tab" id="tab6" data-toggle="tab" aria-controls="n2" aria-expanded="false"><span class=""></span> ETUDE DE FAISABILITE</a>
                                            </li>
                                       </ul>

                                       <div class="tab-content" id="myTabContent">
                                         <div class="tab-pane fade active in" role="tabpanel" id="swot" aria-labelledby="tab1">
                                              <div>

                                                <div class="row">
                                                    <div class="col-md-6 col-sm-12">
                                                        <fieldset>
                                                            <legend>SYNTHESE DES OPPORTUNITES</legend>
                                                            <?= $projet->swot->synt_op ?>
                                                        </fieldset>
                                                    </div>
                                                    <div class="col-md-6 col-sm-12">
                                                        <fieldset>
                                                            <legend>SYNTHESE DES MENACES</legend>
                                                                <?= $projet->swot->synt_men ?>
                                                        </fieldset>
                                                    </div>
                                                    <div class="col-md-6 col-sm-12">
                                                        <fieldset>
                                                            <legend>SYNTHESE DES FORCES</legend>
                                                            <?= $projet->swot->synt_forces ?>
                                                        </fieldset>
                                                    </div>
                                                    <div class="col-md-6 col-sm-12">
                                                        <fieldset>
                                                            <legend>SYNTHESE DES FAIBLESSES</legend>
                                                                <?= $projet->swot->synt_faiblesses ?>
                                                        </fieldset>
                                                    </div>
                                                </div>

                                              </div>

                                         </div>

                                         <div class="tab-pane fade" role="tabpanel" id="objectifs" aria-labelledby="">
                                            <p></p>
                                            <br/>
                                            <hr/>
                                            <div class="row">
                                                <div class="col-md-4 col-sm-12">
                                                    <div class="well">
                                                        <fieldset>
                                                            <legend>OBJECTIFS A COURT TERME</legend>
                                                            <p><?= $projet->objectifs_courts ?></p>
                                                        </fieldset>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-sm-12">
                                                    <div class="well">
                                                        <fieldset>
                                                            <legend>OBJECTIFS A MOYEN TERME</legend>
                                                            <p><?= $projet->objectifs_moyens ?></p>
                                                        </fieldset>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-sm-12">
                                                    <div class="well">
                                                        <fieldset>
                                                            <legend>OBJECTIFS A LONG TERME</legend>
                                                            <p><?= $projet->objectifs_longs ?></p>
                                                        </fieldset>
                                                    </div>
                                                </div>
                                            </div>

                                         </div>

                                         <div class="tab-pane fade" role="tabpanel" id="organisation" aria-labelledby="">
                                            <p></p>

                                            <h6 class="page-header">ORGANISATION DU TRAVAIL</h6>
                                            <table class="table table-bordered table-hover table-condensed">
                                                <thead>
                                                    <tr>
                                                        <th>NOM</th>
                                                        <th>FONCTION</th>
                                                        <th>RESPONSABILITES</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($projet->ressources as $ressource)
                                                        <tr>
                                                            <td><?= $ressource->name ?></td>
                                                            <td><?= $ressource->fonction ?></td>
                                                            <td><?= $ressource->responsabilite ?></td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                         </div>

                                         <div class="tab-pane fade" role="tabpanel" id="actions" aria-labelledby="">
                                            <input type="hidden" id="plan_id" value="<?= $projet->plan_id ?>"/>
                                            <table class="table table-bordered table-condensed table-hover" id="example">
                                                <thead>
                                                <tr>
                                                    <th>TYPE DE RISQUE</th>
                                                    <th>PRODUIT</th>
                                                    <th>DEFAILLANCE</th>
                                                    <th>ACTION</th>
                                                </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                            </table>
                                         </div>

                                         <div class="tab-pane fade" role="tabpanel" id="etapes" aria-labelledby="">
                                            <table class="table table-bordered table-hover table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>ETAPE</th>
                                                        <th>ACTION STRATEGIQUE</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($projet->etapes as $etape)
                                                        <tr>
                                                            <td>{{ $etape->name }}</td>
                                                            <td>{{ $etape->action }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                         </div>

                                         <div class="tab-pane fade" role="tabpanel" id="faisabilite" aria-labelledby="">
                                            <br/>
                                            <br/>
                                            <div class="well">
                                                <p><?= $projet->etude_faisabilite ?></p>
                                            </div>

                                         </div>


                                      </div>
                                   </fieldset>
                            </div>
                        </div>
                    </div>
                    @endif
                  </div>
              </div>

    <script type="text/javascript" src="{{ asset('js/api.js') }}"></script>

    <script>
        $(document).ready(function(){
            $('#side2').height($('#side1').height());
            getPlan($('#plan_id').val());

            $.ajax({
                url: "/consultant/dossier/getchoices",
                type:'Get',
                dataType:'json',
                data:{id:$('#id').val()},
                success:function(data){
                    if(data!=null){
                        $.ajax({
                            url:orm+'carto',
                            type:'Post',
                            dataType:'json',
                            data:{choix:data},
                            success:function(rep){
                                $('#risks-loader').hide();

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

    <!-- Edition de la synthese du diagnostic interne -->
    <div class="modal fade" id="synDiagIntModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel">
    	<form method="post" action="/consultant/dossier/synthese1">
    		<input type="hidden" id="" name="projet_token" value="<?= $projet->token ?>" />
    		{{csrf_field()}}
    		<div class="modal-dialog modal-lg" role="document">
    			<div class="modal-content">
    				<div class="modal-header">
    					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    					<h5 style="text-transform: uppercase; background-color: transparent" class="modal-title" id="myModalLabel"><span> SYNTHESE DU DIAGNOSTIC INTERNE</span></h5>
    				</div>
    				<div class="modal-body">
    					<div class="form-group">
    						<textarea class="form-control"  name="synthese1" id="synthese1" cols="30" rows="10" placeholder="Saisir le synthese ici...">{{ $projet->synthese_diagnostic_interne }}</textarea>
    					</div>
    				</div>
    				<div class="modal-footer">
    					<button type="submit" class="btn btn-danger"><i class="fa fa-save"></i> ENREGISTRER</button>
    				</div>

    			</div>
    		</div>
    	</form>


    	<script type="text/javascript" src="{{ asset('summernote/dist/summernote.min.js') }}"></script>
            <script type="text/javascript" src="{{ asset('summernote/lang/summernote-fr-FR.js') }}"></script>
            <link rel="stylesheet" href="{{ asset('summernote/dist/summernote.css') }}"/>

            <script type="text/javascript">
                $(document).ready(function() {
                  $('#synthes').summernote({
                    height: 300,
                    tabsize: 2,
                    followingToolbar: true,
                    lang:'fr-FR'
                  });
                });
              </script>


    </div>


    <!-- Edition de la synthese du diagnostic externe-->
        <div class="modal fade" id="synDiagExtModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel">
        	<form method="post" action="/consultant/dossier/synthese2">
        		<input type="hidden" id="" name="projet_token" value="<?= $projet->token ?>" />
        		{{csrf_field()}}
        		<div class="modal-dialog modal-lg" role="document">
        			<div class="modal-content">
        				<div class="modal-header">
        					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        					<h5 style="text-transform: uppercase; background-color: transparent" class="modal-title" id="myModalLabel"><span> SYNTHESE DU DIAGNOSTIC EXTERNE</span></h5>
        				</div>
        				<div class="modal-body">
        					<div class="form-group">
        						<textarea class="form-control"  name="synthese2" id="synthese2" cols="30" rows="10" placeholder="Saisir le synthese ici...">{{ $projet->synthese_diagnostic_externe }}</textarea>
        					</div>
        				</div>
        				<div class="modal-footer">
        					<button type="submit" class="btn btn-danger"><i class="fa fa-save"></i> ENREGISTRER</button>
        				</div>

        			</div>
        		</div>
        	</form>




                <script type="text/javascript">
                    $(document).ready(function() {
                      $('#synthese2').summernote({
                        height: 300,
                        tabsize: 2,
                        followingToolbar: true,
                        lang:'fr-FR'
                      });
                    });
                  </script>


        </div>

        <!-- Edition de la synthese du diagnostic Strategique -->
        <div class="modal fade" id="synDiagStratModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel">
        	<form method="post" action="/consultant/dossier/synthese3">
        		<input type="hidden" id="" name="projet_token" value="<?= $projet->token ?>" />
        		{{csrf_field()}}
        		<div class="modal-dialog modal-lg" role="document">
        			<div class="modal-content">
        				<div class="modal-header">
        					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        					<h5 style="text-transform: uppercase; background-color: transparent" class="modal-title" id="myModalLabel"><span> SYNTHESE DU DIAGNOSTIC STRATEGIQUE</span></h5>
        				</div>
        				<div class="modal-body">
        					<div class="form-group">
        						<textarea class="form-control"  name="synthese3" id="synthese3" cols="30" rows="10" placeholder="Saisir le synthese ici...">{{ $projet->synthese_diagnostic_strategique }}</textarea>
        					</div>
        				</div>
        				<div class="modal-footer">
        					<button type="submit" class="btn btn-danger"><i class="fa fa-save"></i> ENREGISTRER</button>
        				</div>

        			</div>
        		</div>
        	</form>

                <script type="text/javascript">
                    $(document).ready(function() {
                      $('#synthese3').summernote({
                        height: 300,
                        tabsize: 2,
                        followingToolbar: true,
                        lang:'fr-FR'
                      });
                    });
                  </script>


        </div>




        <!-- Edition du teaser-->
        <div class="modal fade" id="teaserModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel">
        	<form method="post" action="/consultant/dossier/teaser">
        		<input type="hidden" id="" name="projet_token" value="<?= $projet->token ?>" />
        		{{csrf_field()}}
        		<div class="modal-dialog modal-lg" role="document">
        			<div class="modal-content">
        				<div class="modal-header">
        					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        					<h5 style="text-transform: uppercase; background-color: transparent" class="modal-title" id="myModalLabel"><span> ELABORATION DU TEASER</span></h5>
        				</div>
        				<div class="modal-body">
        					 <div class="row">

                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label for="contexte">CONTEXTE</label>
                                        <textarea name="contexte" rows="3" id="contexte"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label for="problematique">PROBLEMATIQUE</label>
                                        <input name="problematique" type="text" class="form-control" id="problematique"/>
                                    </div>

                                </div>
                                <div class="col-md-12 col-sm-12">
                                <div class="form-group">
                                     <label for="marche">MARCHE</label>
                                    <input name="marche" type="text" class="form-control" id="marche"/>
                                </div>

                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label for="strategie">STRATEGIE</label>
                                        <input name="strategie" type="text" class="form-control" id="strategie"/>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label for="chiffres">CHIFFRES CLES</label>
                                        <input name="chiffres" type="text" class="form-control" id="chiffres" placeholder="Saisir ici quelques chiffres clefs" />
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label for="">FOCUS SUR LES REALISATIONS DE L'ENTREPRISE</label>
                                        <textarea name="focus_realisations" class="form-control telt" id="focus_realisations" placeholder=""></textarea>
                                    </div>
                                </div>
                            </div>
        				</div>
        				<div class="modal-footer">
        					<button type="submit" class="btn btn-danger"><i class="fa fa-save"></i> ENREGISTRER</button>
        				</div>

        			</div>
        		</div>
        	</form>

                <script type="text/javascript">
                    $(document).ready(function() {
                      $('textarea').summernote({
                        height: 300,
                        tabsize: 2,
                        followingToolbar: true,
                        lang:'fr-FR'
                      });

                    });


                  </script>


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

@endsection

@section('action')
@if($projet->etape==1)
    @if($projet->validated_step==1)
        <a class="btn btn-xs btn-success" href="/consultant/dossier/create-diag-externe/{{$projet->token}}"><i class="fa fa-pencil"></i> Editer le diagnostic externe</a>
    @endif
@endif

@if($projet->etape==2)
    @if($projet->validated_step==2)
        <a class="btn btn-xs btn-success" href="/consultant/dossier/create-diag-strategique/{{$projet->token}}"><i class="fa fa-pencil"></i> Editer le diagnostic strategique</a>
    @endif
@endif



@if($projet->etape==3)
    @if($projet->validated_step==3)
        <a class="btn btn-xs btn-success" href="/consultant/dossier/create-plan-financier/{{$projet->token}}"><i class="fa fa-pencil"></i> Elaborer le plan financier</a>
    @endif
@endif


@endsection