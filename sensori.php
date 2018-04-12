<?php
include('php/session.php');
include('php/DAOSensore.php');
include('php/Sensore.php');
$DAOSensore = new DAOSensore();
$sensori = $DAOSensore -> getAll();
$htmlString = "";
foreach ($sensori as $i) {
  $toPass2 = htmlspecialchars(json_encode($i), ENT_QUOTES, 'UTF-8');
    $htmlString .=
    "<tr ng-click=\"sensoriList.editDialog(\$event,".$toPass2.")\">
      <td class=\"mdl-data-table__cell--non-numeric\">".$i->getMarca()."</td>
      <td class=\"mdl-data-table__cell--non-numeric\">".$i->getModello()."</td>
      <td class=\"mdl-data-table__cell--non-numeric\">".$i->getTipo()."</td>
      <td class=\"mdl-data-table__cell--non-numeric\">".$i->getUnitaMisura()."</td>
    </tr>";
}
if($_SERVER["REQUEST_METHOD"] == "POST") {
  $postdata = file_get_contents("php://input");
  $request = json_decode($postdata);
  if ($request->cod == "add") {
    $DAOSensore-> insert(new Sensore($request->marca, $request->modello, $request->tipo, $request->unitaMisura));
  } else if ($request->cod == "edit") {
    $toUpdate = new Sensore($request->marca, $request->modello, $request->tipo, $request->unitaMisura);
    $toUpdate -> setId($request->id);
    $DAOSensore -> update($toUpdate);
  } else if ($request->cod == "remove") {
    $DAOSensore -> delete($request->id);
  }
}
?>
<html>
<head>
  <style>
  #add {
    position: absolute;
    z-index: 99;
    top: 6px;
    right: 8px;
    height: 40px;
    width: 40px;
  }
  md-dialog {
    overflow: visible !important;
  }
  md-toolbar:not(.md-menu-toolbar) {
    background-color: #354061 !important;
  }
  md-input-container {
    margin-bottom: 0px !important;
  }
  .mdl-data-table td {
    padding: 12px 12px !important
  }
  #delete {
    margin-top: -2px;
}
#render {
  width: 100%;
  display: inherit;
}
.mdl-demo .mdl-card {
  min-height: 50px !important;
  margin: 0 auto;
  width: 100%;
}

#render .mdl-card.mdl-cell {
    padding: 2px;
}

.fullList {
  width: 100%;
}

#listDialog {
  padding: 0 !important;
}

  @media (max-width: 690px) {
      #render {
        display: inline-table;
      }
      .mdl-demo .mdl-card {
    margin-bottom: 10px;
    }
  }


</style>
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
