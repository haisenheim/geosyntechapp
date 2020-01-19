<style>
    .pull-right{
        float: right;
        margin-right: 10px;
    }
</style>
<div style="margin-top: 15px" class="card">
    <div class="card-header bg-info">
        <h3 class="card-title">{{ $formation->name  }}</h3>
    </div>
    <div class="card-body">
        <div style="width: 100%; height: 220px">
            <img src="{{ $formation->imageUri?asset('img/'.$formation->imageUri):'img/logo-obac.png' }}" style="height: 100%; width: 100%" alt=""/>
        </div>
        <div class="divider"></div>

        <ul>
            <li>MODULES : <span class="text-info text-bold">{{ $formation->modules->count() }}</span></li>
            <li>PRIX EN LIGNE: <span class="text-info text-bold">{{ number_format($formation->prix_ligne,0,',','.') }}</span></li>
            <li>PRIX EN PRESENTIEL: <span class="text-info text-bold">{{ number_format($formation->prix_presentiel,0,',','.') }}</span></li>
        </ul>
        <div class="divider"></div>
        <fieldset>
            <legend>Description</legend>
                <div style="max-height: 200px; overflow-y: scroll">
                    <p><?= $formation->description ?></p>
                </div>
        </fieldset>
        <fieldset>
            <legend>AUTEUR</legend>
            <ul>
                <li><b> {{ $formation->contributeur->name }} </b></li>
                <li>{{ $formation->contributeur->address }}</li>
                <li><i class="fa fa-mobile"></i> {{ $formation->contributeur->phone }}</li>
                <li><i class="fa fa-envelope"></i> {{ $formation->contributeur->email }}</li>

            </ul>
        </fieldset>
    </div>

</div>