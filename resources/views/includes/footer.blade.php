     <footer class="main-footer">
        <strong>Copyright &copy; <?= date('Y') ?> <a href="#">OBAC ALERT</a>.</strong> <small>Tous droits reserés</small>
        <script src="{{asset('dist/js/adminlte.js')}}"></script>
      </footer>

<?php use Illuminate\Support\Facades\Auth; ?>

<div class="modal fade" id="obac-contact-form" tabindex="-1" role="dialog" aria-labelledby="addModalLabel">
    <div class="modal-dialog modal-xl" role="document">
    	<div class="modal-content">
    		<div class="modal-header bg-success">
    			<h5 style="text-transform: uppercase; background-color: transparent" class="modal-title" id="myModalLabel"><span>CONTACTER OBAC</span></h5>
    			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
    		</div>
    		<div class="modal-body">
    		    <form method="post" action="/contact-obac">
    		    <div class="card">
    		        <div class="card-body">
    		             @csrf
                         <div class="row">

                             <div class="col-md-12">
                                 <div class="form-group">

                                     <input required="required" type="text" name="objet" class="form-control" placeholder="Objet"/>
                                 </div>
                             </div>
                             <div class="col-md-12">
                                 <div class="form-group">

                                     <textarea required="required" name="message" id="" cols="30" rows="4" class="form-control" placeholder="Votre message ..."></textarea>
                                 </div>
                             </div>

                         </div>
    		        </div>
    		        <div class="card-footer">
    		           <button class="btn btn-warning btn-block btn-sm"><i class="fa fa-envelope"></i> ENVOYER</button>
    		        </div>
    		    </div>
    		    </form>
    		</div>
    	</div>
    </div>
</div>

<div class="modal fade" id="user-profil-form" tabindex="-1" role="dialog" aria-labelledby="addModalLabel">
    <div class="modal-dialog modal-xl" role="document">
    	<div class="modal-content">
    		<div class="modal-header bg-info">
    			<h5 style="text-transform: uppercase; background-color: transparent" class="modal-title" id="myModalLabel"><span>VOTRE PROFIL UTLISATEUR</span></h5>
    			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
    		</div>
    		<div class="modal-body">
    		    <form method="post" action="/profil">
    		    <div class="card">
    		        <div class="card-body">
    		             @csrf
                         <div class="row">

                             <div class="col-md-12">
                                 <div class="form-group">
                                        <label for="last-name">VOTRE NOM</label>
                                     <input required="required" type="text" name="objet" class="form-control" placeholder="<?= Auth::user()->last_name ?>"/>
                                 </div>
                             </div>
                             <div class="col-md-12">
                                 <div class="form-group">

                                     <textarea required="required" name="message" id="" cols="30" rows="4" class="form-control" placeholder="Votre message ..."></textarea>
                                 </div>
                             </div>

                         </div>
    		        </div>
    		        <div class="card-footer">
    		           <button class="btn btn-warning btn-block btn-sm"><i class="fa fa-envelope"></i> ENVOYER</button>
    		        </div>
    		    </div>
    		    </form>
    		</div>
    	</div>
    </div>
</div>

<script>
    $('.nav-contact-obac-link').click(function(e) {
        e.preventDefault();
        $('#obac-contact-form').show();
    })

    $('.nav-profil-link').click(function(e) {
        e.preventDefault();
        $('#user-form').show();
    })
</script>