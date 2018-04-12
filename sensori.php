<html>
<head>
  <link rel="stylesheet" href="css/page.css">
</head>
<body>
<div ng-cloak ng-controller="SensoriCtrl as sensoriList">
<section class="section--center mdl-grid mdl-grid--no-spacing mdl-shadow--2dp">
  <div class="mdl-card mdl-cell mdl-cell--12-col">
    <div class="mdl-card__supporting-text mdl-grid mdl-grid--no-spacing">
      <h4 class="mdl-cell mdl-cell--12-col">Sensori</h4>
      </div>
      <table class="mdl-data-table mdl-js-data-table ">
      <thead>
        <tr>
          <th class="mdl-data-table__cell--non-numeric">Marca</th>
          <th class="mdl-data-table__cell--non-numeric">Modello</th>
          <th class="mdl-data-table__cell--non-numeric">Tipo</th>
          <th class="mdl-data-table__cell--non-numeric">Unità di misura</th>
        </tr>
      </thead>
      <tbody>
        <?php echo $htmlString ?>
      </tbody>
    </table>
    <button class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon" id="add" data-upgraded=",MaterialButton,MaterialRipple" ng-click="sensoriList.addDialog($event)">
        <i class="material-icons">add</i>
    </button>
  </div>
  </section>
  <script type="text/ng-template" id="aggiungi_sensore.html">
      <md-dialog aria-label="Aggiungi Sensore">
    <md-toolbar>
      <div class="md-toolbar-tools">
        <h2>Aggiungi Sensore</h2>
        <span flex></span>
        <md-button class="md-icon-button" ng-click="cancel($event)">
          <i class="material-icons">close</i>
        </md-button>
      </div>
    </md-toolbar>
    <md-dialog-content>
      <div class="md-dialog-content">
        <form role="form">
                  <div layout-gt-xs="row">
                    <md-input-container class="md-block">
                      <label>Marca</label>
                      <input ng-model="sensoriList.marca"  size="25" placeholder="Samsung">
                    </md-input-container>
                    <md-input-container class="md-block">
                      <label>Modello</label>
                      <input ng-model="sensoriList.modello"  size="25" placeholder="MOD_1">
                    </md-input-container>
                    <md-input-container class="md-block">
                      <label>Tipo</label>
                      <input ng-model="sensoriList.tipo" size="25" placeholder="Temperatura"></input>
                    </md-input-container>
                    <md-input-container class="md-block">
                      <label>Unità di Misura</label>
                      <input ng-model="sensoriList.unitaMisura" size="15" placeholder="°C"></input>
                    </md-input-container>
                  </div>
                  <div layout="row" layout-align="center center">
                  <md-button ng-click="answer(sensoriList)" class="md-raised md-primary">Aggiungi</md-button>
                </div>
        </form>
      </div>
    </md-dialog-content>
  </md-dialog>
  </script>
  <script type="text/ng-template" id="modifica_sensore.html">
    <md-dialog aria-label="Modifica Sensore" class="myDialog">
    <md-toolbar>
      <div class="md-toolbar-tools">
        <h2>Modifica Sensore</h2>
        <span flex></span>
        <md-button class="md-icon-button" ng-click="cancel($event)">
          <i class="material-icons">close</i>
        </md-button>
      </div>
    </md-toolbar>
    <md-dialog-content>
      <div class="md-dialog-content">
        <form role="form">
                  <div layout-gt-xs="row">
                    <md-input-container class="md-block">
                      <label>Marca</label>
                      <input ng-model="sensoriList.marca"  size="25">
                    </md-input-container>
                    <md-input-container class="md-block">
                      <label>Modello</label>
                      <input ng-model="sensoriList.modello"  size="25">
                    </md-input-container>
                    <md-input-container class="md-block">
                      <label>Tipo</label>
                      <input ng-model="sensoriList.tipo" size="25"></input>
                    </md-input-container>
                    <md-input-container class="md-block">
                      <label>Unità di Misura</label>
                      <input ng-model="sensoriList.unitaMisura" size="15"></input>
                    </md-input-container>
                  </div>
                  <div layout-gt-xs="row" layout-align="center center">
                  <md-button ng-click="answer('edit', sensoriList)" class="md-raised md-primary">Salva</md-button>
                  <md-button ng-click="answer('remove', sensoriList)" class="md-raised md-primary" style="background-color: rgb(199, 56, 11);">Elimina</md-button>
                </div>
        </form>
      </div>
    </md-dialog-content>
  </md-dialog>
  </script>
<section>
</section>
</div>
</body>
</html>
