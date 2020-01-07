@extends('......layouts.contributeur')
@section('content')


    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4 col-sm-12">
                 @include('includes.Show.module_left_side')
            </div>
            <div class="col-md-8 col-sm-12">
                 @include('includes.Show.module_right_side')
            </div>
        </div>
    </div>

    <div class="modal" id="coursAdd">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header bg-info">
              <h4 class="modal-title">NOUVELLE QUESTION</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">
              <form>
              {{csrf_field()}}
              <input type="hidden" name="token" id="token" value="{{ $module->token }}"/>

                <!-- /.card-body -->
                <div class="card-body">
                     <div class="form-group">
                          <label for="name">INTITULE</label>
                          <input type="text" name="name" id="name" class="form-control">
                     </div>

                     <div class="divider"></div>
                     <h5>LES CHOIX</h5>
                     <div class="row">
                            <div class="col-md-8 col-sm-12">
                                <div class="form-group">
                                    <label for="choice">INTITULE</label>
                                    <input type="text" id="choice" class="form-control"/>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-12">
                                <div class="form-group">
                                    <label for="chk">JUSTE ?</label>
                                    <input type="checkbox" id="chk" class="form-control"/>
                                </div>
                            </div>
                            <div class="col-md-1 col-sm-12">
                                <button id="btn-add" class="btn btn-outline-info btn-block btn-xs"><i class="fa fa-plus-circle"></i></button>
                            </div>
                     </div>

                     <div class="divider"></div>
                     <table id="tab-choices" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>CHOIX</th>
                                <th>JUSTE ?</th>
                            </tr>

                        </thead>
                        <tbody></tbody>
                     </table>


                </div>

                <div class="card-footer">
                  <button id="btn-save"><i class="fa fa-w fa-save"></i> ENREGISTRER</button>
                </div>
              </form>
            </div>

          </div>
          <!-- /.modal-content -->
        </div>
                  <!-- /.modal-dialog -->

    </div>

     <script type="text/javascript" src="{{ asset('js/loadingOverlay.js') }}"></script>

    <link rel="stylesheet" href="{{ asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">
            <!-- SweetAlert2 -->
    <script type="text/javascript" src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
            <!-- Toastr -->
    <script type="text/javascript" src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>

    <script>
        $('#btn-add').click(function(e){
            e.preventDefault();
            var choice= $('#choice').val();
            $('#choice').val('');
            var juste = $('#chk').is(':checked')?1:0;
            //$('#chk').val('');
            var tr = '<tr data-choice="'+ choice+'" data-juste='+ juste +'><td>'+ choice+'</td> <td>'+ juste?"oui":"non" +'</td><td><span class="remove btn btn-xs btn-danger"><i class="fa fa-trash"></i></span></td></tr>';
            $('#tab-choices').find('tbody').append(tr);
        });

        $('.remove').click(function(e){
            e.preventDefault();
            $(this).parent().parent().remove();
        });

        $('#btn-save').click(function(e){
            e.preventDefault();
            const Toast = Swal.mixin({
                              toast: true,
                              position: 'top-end',
                              showConfirmButton: false,
                              timer: 5000
                            });
            var spinHandle_firstProcess = loadingOverlay.activate();

            var data = [];
            $('#tab-choices').find('tbody').find('tr').each(function(e){
                var elt = {};
                elt.name = $(this).data('choice');
                elt.ok = $(this).data('juste');
                data.push(elt);
            });

            $.ajax({
                url:'/contributeur/test/add-question',
                type:'Post',
                dataType:'json',
                data:{donnees:data, name:$('#name').val(), token:$('#token').val()},
                beforeSend:function(xhr){
                    xhr.setRequestHeader('X-CSRF-Token',$('input[name="_token"]').val());

                },
                success: function(data){

                  loadingOverlay.cancel(spinHandle_firstProcess);

                   Toast.fire({
                     type: 'success',
                     title: 'La question a été ajoutée avec succès!!!'
                   });

                   setTimeout(function() {
                     window.location.reload();
                   },2000);
                },

                Error:function(){
                    loadingOverlay.cancel(spinHandle_firstProcess);
                    Toast.fire({
                               type: 'error',
                               title: 'Une erreur est survenue lors de l\'enregistrement de la question. Verifiez que toutes les informations sont saisies correctement !!!'
                             });


                }

            });
        });
    </script>

@endsection