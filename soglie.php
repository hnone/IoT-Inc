<?php
include('php/session.php');
include('php/DAOSogliaSensore.php');
include('php/SogliaSensore.php');
include('php/DAOSogliaAmbiente.php');
include('php/SogliaAmbiente.php');

$DAOSogliaSensore = new DAOSogliaSensore();
$DAOSogliaAmbiente = new DAOSogliaAmbiente();

if($_SERVER["REQUEST_METHOD"] == "POST") {
  $postdata = file_get_contents("php://input");
  $request = json_decode($postdata);
  if ($request->cod == "addSogliaSensore") {
    if($request->maggMin == "maggiore") {
      $DAOSogliaSensore -> insert(new SogliaSensore($request->nome, $request->valore, null, $request->idSensore));
    } else {
      $DAOSogliaSensore -> insert(new SogliaSensore($request->nome, null, $request->valore, $request->idSensore));
    }
  } else if ($request->cod == "addSogliaAmbiente") {
    if($request->maggMin == "maggiore") {
      $DAOSogliaAmbiente -> insert(new SogliaAmbiente($request->nome, $request->valore, null, $request->tipo, $request->idAmbiente));
    } else {
      $DAOSogliaAmbiente -> insert(new SogliaAmbiente($request->nome, null, $request->valore, $request->tipo, $request->idAmbiente));
    }
  } else if ($request->cod == "editSogliaSensore") {
    if($request->maggMin == "maggiore") {
      $toUpdate = new SogliaSensore($request->nome, $request->valore, null, $request->idSensore);
    } else {
      $toUpdate = new SogliaSensore($request->nome, null, $request->valore, $request->idSensore);
    }
    $toUpdate -> setId($request->id);
    $DAOSogliaSensore -> update($toUpdate);
  } else if ($request->cod == "editSogliaAmbiente") {
    if($request->maggMin == "maggiore") {
      $toUpdate = new SogliaAmbiente($request->nome, $request->valore, null, $request->tipo, $request->idAmbiente);
    } else {
      $toUpdate = new SogliaAmbiente($request->nome, null, $request->valore, $request->tipo, $request->idAmbiente);
    }
    $toUpdate -> setId($request->id);
    $DAOSogliaAmbiente -> update($toUpdate);
  } else if ($request->cod == "removeSogliaSensore") {
    $DAOSogliaSensore -> delete($request->id);
  } else if ($request->cod == "removeSogliaAmbiente") {
    $DAOSogliaAmbiente -> delete($request->id);
  }
}
?>
<html>
<head>
  <script>
  if (window.performance) {
    console.info("window.performance work's fine on this browser");
  }
    if (performance.navigation.type == 1) {
      console.info( "This page is reloaded" );
      window.location.href = "/dashboard.php";
    } else {
      console.info( "This page is not reloaded");
    }
  </script>
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

  md-select {
    width: min-content;
  }


</style>
</head>
<body>
<div ng-cloak ng-controller="SoglieCtrl as soglieList">
  <div compile="soglieList.list_soglie" style="width: 100%;"></div>
  <script type="text/ng-template" id="aggiungi_sogliaSensore.html">
      <md-dialog aria-label="Aggiungi Soglia Sensore">
    <md-toolbar>
      <div class="md-toolbar-tools">
        <h2>Aggiungi Soglia Sensore</h2>
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
                      <label>Nome</label>
                      <input ng-model="soglieList.nome"  size="25" placeholder="Soglia1">
                    </md-input-container>
                    <md-input-container>
                     <label>Magg/Min</label>
                     <md-select ng-model="soglieList.maggMin">
                      <md-option ng-selected="true" value="maggiore">></md-option>
                      <md-option value="minore"><</md-option>
                    </md-select>
                   </md-input-container>
                    <md-input-container class="md-block">
                      <label>Valore</label>
                      <input ng-model="soglieList.valore"  size="25" placeholder=">30">
                    </md-input-container>
                    <md-input-container class="md-block">
                      <label>Sensore</label>
                      <input ng-model="soglieList.sensore" size="30" placeholder="Sensore1" ng-focus="select('Sensore')"></input>
                    </md-input-container>
                  </div>
                  <div layout="row" layout-align="center center">
                  <md-button ng-click="answer(soglieList)" class="md-raised md-primary">Aggiungi</md-button>
                </div>
        </form>
      </div>
    </md-dialog-content>
  </md-dialog>
  </script>
  <script type="text/ng-template" id="aggiungi_sogliaAmbiente.html">
      <md-dialog aria-label="Aggiungi Soglia Ambiente">
    <md-toolbar>
      <div class="md-toolbar-tools">
        <h2>Aggiungi Soglia Ambiente</h2>
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
                      <label>Nome</label>
                      <input ng-model="soglieList.nome"  size="25" placeholder="Soglia1">
                    </md-input-container>
                    <md-input-container>
                     <label>Magg/Min</label>
                     <md-select ng-model="soglieList.maggMin">
                      <md-option ng-selected="true" value="maggiore">></md-option>
                      <md-option value="minore"><</md-option>
                    </md-select>
                   </md-input-container>
                    <md-input-container class="md-block">
                      <label>Valore</label>
                      <input ng-model="soglieList.valore"  size="25" placeholder=">30">
                    </md-input-container>
                    <md-input-container class="md-block">
                      <label>Ambiente</label>
                      <input ng-model="soglieList.ambiente" size="30" placeholder="Ambiente1" ng-focus="select('Ambiente')"></input>
                    </md-input-container>
                    <md-input-container>
                     <label>Tipo</label>
                     <md-select ng-model="soglieList.tipi">
                       <md-option ng-repeat="tipo in soglieList.tipologie" value="{{tipo}}">{{tipo}}</md-option>
                    </md-select>
                   </md-input-container>
                  </div>
                  <div layout="row" layout-align="center center">
                  <md-button ng-click="answer(soglieList)" class="md-raised md-primary">Aggiungi</md-button>
                </div>
        </form>
      </div>
    </md-dialog-content>
  </md-dialog>
  </script>
  <script type="text/ng-template" id="modifica_sogliaSensore.html">
    <md-dialog aria-label="Modifica Soglia Sensore" class="myDialog">
    <md-toolbar>
      <div class="md-toolbar-tools">
        <h2>Modifica Soglia Sensore</h2>
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
                      <label>Nome</label>
                      <input ng-model="soglieList.nome"  size="20">
                    </md-input-container>
                    <md-input-container>
                     <label>Magg/Min</label>
                     <md-select ng-model="soglieList.maggMin">
                      <md-option value="maggiore">></md-option>
                      <md-option value="minore"><</md-option>
                    </md-select>
                   </md-input-container>
                    <md-input-container class="md-block">
                      <label>Valore</label>
                      <input ng-model="soglieList.valore"  size="25">
                    </md-input-container>
                    <md-input-container class="md-block">
                      <label>Sensore</label>
                      <input ng-model="soglieList.sensore" size="30" ng-focus="select('Sensore')"></input>
                    </md-input-container>
                  </div>
                  <div layout-gt-xs="row" layout-align="center center">
                  <md-button ng-click="answer('edit', soglieList)" class="md-raised md-primary">Salva</md-button>
                  <md-button ng-click="answer('remove', soglieList)" class="md-raised md-primary" style="background-color: rgb(199, 56, 11);">Elimina</md-button>
                </div>
        </form>
      </div>
    </md-dialog-content>
  </md-dialog>
  </script>
  <script type="text/ng-template" id="modifica_sogliaAmbiente.html">
    <md-dialog aria-label="Modifica Soglia Ambiente" class="myDialog">
    <md-toolbar>
      <div class="md-toolbar-tools">
        <h2>Modifica Soglia Ambiente</h2>
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
                      <label>Nome</label>
                      <input ng-model="soglieList.nome"  size="20">
                    </md-input-container>
                    <md-input-container>
                     <label>Magg/Min</label>
                     <md-select ng-model="soglieList.maggMin">
                      <md-option value="maggiore">></md-option>
                      <md-option value="minore"><</md-option>
                    </md-select>
                   </md-input-container>
                    <md-input-container class="md-block">
                      <label>Valore</label>
                      <input ng-model="soglieList.valore"  size="25">
                    </md-input-container>
                    <md-input-container class="md-block">
                      <label>Ambiente</label>
                      <input ng-model="soglieList.ambiente" size="30" ng-focus="select('Ambiente')"></input>
                    </md-input-container>
                    <md-input-container>
                     <label>Tipo</label>
                     <md-select ng-model="soglieList.tipi">
                       <md-option ng-repeat="tipo in soglieList.tipologie" value="{{tipo}}">{{tipo}}</md-option>
                    </md-select>
                   </md-input-container>
                  </div>
                  <div layout-gt-xs="row" layout-align="center center">
                  <md-button ng-click="answer('edit', soglieList)" class="md-raised md-primary">Salva</md-button>
                  <md-button ng-click="answer('remove', soglieList)" class="md-raised md-primary" style="background-color: rgb(199, 56, 11);">Elimina</md-button>
                </div>
        </form>
      </div>
    </md-dialog-content>
  </md-dialog>
  </script>

<script type="text/ng-template" id="AmbienteList.html">
    <md-dialog aria-label="Seleziona Ambiente">
    <md-toolbar>
      <div class="md-toolbar-tools">
        <h2>Seleziona ambiente da associare</h2>
        <span flex></span>
        <md-button class="md-icon-button" ng-click="cancel($event)">
          <i class="material-icons">close</i>
        </md-button>
      </div>
    </md-toolbar>
    <md-dialog-content>
      <div class="md-dialog-content" id="listDialog">
        <form role="form">
                <div layout-gt-xs="row">
                    <div compile="list_imp" class="fullList"></div>
                </div>
        </form>
      </div>
    </md-dialog-content>
  </md-dialog>
</script>
  <script type="text/ng-template" id="SensoreList.html">
    <md-dialog aria-label="Seleziona sensore">
    <md-toolbar>
      <div class="md-toolbar-tools">
        <h2>Seleziona sensore da associare</h2>
        <span flex></span>
        <md-button class="md-icon-button" ng-click="cancel($event)">
          <i class="material-icons">close</i>
        </md-button>
      </div>
    </md-toolbar>
    <md-dialog-content>
      <div class="md-dialog-content" id="listDialog">
        <form role="form">
                <div layout-gt-xs="row">
                    <div compile="list_imp" class="fullList"></div>
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
