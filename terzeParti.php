<?php
include('php/session.php');
include('php/DAOCliente.php');
include('php/Cliente.php');
include('php/DAOTerzaParte.php');
include('php/TerzaParte.php');
include('php/DAOAutorizzazione.php');
include('php/Impianto.php');
$DAOTerzaParte = new DAOTerzaParte();
$DAOAutorizzazione = new DAOAutorizzazione();
$terzeParti = $DAOTerzaParte -> getFromIdCliente($id_cliente);
$htmlString = "";
$impiantiString = "";
foreach ($terzeParti as $i) {
  $toPass2 = htmlspecialchars(json_encode($i), ENT_QUOTES, 'UTF-8');
  $htmlString .=
  //"<tr ng-click=\"questList.editDialog(\$event,'".$i->getId()."','".$i->getNome()."','".$i->getCognome()."','".$i->getEmail()."')\">
  "<tr ng-click=\"questList.editDialog(\$event,".$toPass2.")\">
    <td class=\"mdl-data-table__cell--non-numeric\">".$i->getNome()."</td>
    <td class=\"mdl-data-table__cell--non-numeric\">".$i->getCognome()."</td>
    <td class=\"mdl-data-table__cell--non-numeric\">".$i->getEmail()."</td>
    <td class=\"mdl-data-table__cell\" style=\"text-align:  center;\">".$i->getTempo()."</td>
  </tr>";
}
if($_SERVER["REQUEST_METHOD"] == "POST") {
  $postdata = file_get_contents("php://input");
  $request = json_decode($postdata);
  if ($request->cod == "add") {
    $DAOTerzaParte -> insert(new TerzaParte($request->nome, $request->cognome, $request->email, $request->tempo, $id_cliente));
  } else if ($request->cod == "edit") {
    $DAOTerzaParte -> update($request->id, $request->nome, $request->cognome, $request->email, $request->tempo);
  } else if ($request->cod == "remove") {
    $DAOTerzaParte -> delete($request->id);
  }
}
?>
<html>
<head>
  <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/angular_material/1.1.0/angular-material.min.css">
  <script src = "app.js"></script>
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
<div ng-cloak ng-controller="DemoCtrl as questList">
<section class="section--center mdl-grid mdl-grid--no-spacing mdl-shadow--2dp">
  <div class="mdl-card mdl-cell mdl-cell--12-col">
    <div class="mdl-card__supporting-text mdl-grid mdl-grid--no-spacing">
      <h4 class="mdl-cell mdl-cell--12-col">Terze Parti</h4>
      </div>
      <table class="mdl-data-table mdl-js-data-table ">
      <thead>
        <tr>
          <th class="mdl-data-table__cell--non-numeric">Nome</th>
          <th class="mdl-data-table__cell--non-numeric">Cognome</th>
          <th class="mdl-data-table__cell--non-numeric">Email</th>
          <th class="mdl-data-table__cell" style="text-align: center;">Tempo</th>
        </tr>
      </thead>
      <tbody>
        <?php echo $htmlString ?>
      </tbody>
    </table>
    <button class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon" id="add" data-upgraded=",MaterialButton,MaterialRipple" ng-click="questList.addDialog($event)">
        <i class="material-icons">add</i>
    </button>
  </div>
  </section>
  <script type="text/ng-template" id="aggiungi_terzaParte.html">
      <md-dialog aria-label="Aggiungi Terza Parte">
    <md-toolbar>
      <div class="md-toolbar-tools">
        <h2>Aggiungi Terza Parte</h2>
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
                      <input ng-model="questList.nome"  size="25" placeholder="Mario">
                    </md-input-container>
                    <md-input-container class="md-block">
                      <label>Cognome</label>
                      <input ng-model="questList.cognome"  size="25" placeholder="Rossi">
                    </md-input-container>
                    <md-input-container class="md-block">
                      <label>Email</label>
                      <input ng-model="questList.email" size="30" placeholder="mario.rossi@email.com"></input>
                    </md-input-container>
                    <md-input-container class="md-block">
                      <label>Tempo(min.)</label>
                      <input ng-model="questList.tempo" size="10" placeholder="5"></input>
                    </md-input-container>
                  </div>
                  <div layout="row" layout-align="center center">
                  <md-button ng-click="answer(questList)" class="md-raised md-primary">Aggiungi</md-button>
                </div>
        </form>
      </div>
    </md-dialog-content>
  </md-dialog>
  </script>
  <script type="text/ng-template" id="modifica_terzaParte.html">
    <md-dialog aria-label="Modifica Terza Parte" class="myDialog">
    <md-toolbar>
      <div class="md-toolbar-tools">
        <h2>Modifica Terza Parte</h2>
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
                      <input ng-model="questList.nome"  size="20">
                    </md-input-container>
                    <md-input-container class="md-block">
                      <label>Cognome</label>
                      <input ng-model="questList.cognome"  size="25">
                    </md-input-container>
                    <md-input-container class="md-block">
                      <label>Email</label>
                      <input ng-model="questList.email" size="30">
                    </md-input-container>
                    <md-input-container class="md-block">
                      <label>Tempo(min.)</label>
                      <input ng-model="questList.tempo" size="10"></input>
                    </md-input-container>
                  </div>
                  <div layout-gt-xs="row" layout-align="center center" style="margin-bottom: 30px;">
                        <div compile="autorizzate" id="render"></div>
                  </div>
                  <div layout-gt-xs="row" layout-align="center center">
                  <md-button ng-click="answer('edit', questList)" class="md-raised md-primary">Salva</md-button>
                  <md-button ng-click="answer('remove', questList)" class="md-raised md-primary" style="background-color: rgb(199, 56, 11);">Elimina</md-button>
                </div>
        </form>
      </div>
    </md-dialog-content>
  </md-dialog>
  </script>
  <script type="text/ng-template" id="addImpiantoList.html">
    <md-dialog aria-label="Aggiungi Impianto a Terza Parte">
    <md-toolbar>
      <div class="md-toolbar-tools">
        <h2>Seleziona impianto da associare</h2>
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
  <script type="text/ng-template" id="addAmbienteList.html">
    <md-dialog aria-label="Aggiungi Ambiente a Terza Parte">
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
  <script type="text/ng-template" id="addSensoreList.html">
    <md-dialog aria-label="Aggiungi Sensore a Terza Parte">
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
<!--<div ng-controller="TerzeParti" class="md-padding" id="popupContainer">
    <div class="dialog-demo-content" layout="row" layout-wrap layout-margin layout-align="center">
        <md-button class="md-primary md-raised" ng-click="showAlert($event)"   >
          Alert Dialog
        </md-button>
        <md-button class="md-primary md-raised" ng-click="showConfirm($event)" >
          Confirm Dialog
        </md-button>
        <md-button class="md-primary md-raised" ng-click="showPrompt($event)"  >
          Prompt Dialog
        </md-button>
        <md-button class="md-primary md-raised" ng-click="showAdvanced($event)">
          Custom Dialog
        </md-button>
        <md-button class="md-primary md-raised" ng-click="showTabDialog($event)" >
          Tab Dialog
        </md-button>
        <md-button class="md-primary md-raised" ng-if="listPrerenderedButton" ng-click="showPrerenderedDialog($event)">
          Pre-Rendered Dialog
        </md-button>
      </div>
    <p class="footer">Note: The <b>Confirm</b> dialog does not use <code>$mdDialog.clickOutsideToClose(true)</code>.</p>
    <div ng-if="status" id="status">
        <b layout="row" layout-align="center center" class="md-padding">
          {{status}}
        </b>
      </div>
    <div class="dialog-demo-prerendered">
        <md-checkbox ng-model="listPrerenderedButton">Show Pre-Rendered Dialog</md-checkbox>
        <p class="md-caption">Sometimes you may not want to compile the dialogs template on each opening.</p>
        <md-checkbox ng-model="customFullscreen" aria-label="Fullscreen custom dialog">Use full screen mode for custom dialog</md-checkbox>
        <p class="md-caption">Allows the dialog to consume all available space on small devices</p>
      </div>
    <div style="visibility: hidden">
        <div class="md-dialog-container" id="myDialog">
          <md-dialog layout-padding>
            <h2>Pre-Rendered Dialog</h2>
            <p>
              This is a pre-rendered dialog, which means that <code>$mdDialog</code> doesn't compile its
              template on each opening.
              <br/><br/>
              The Dialog Element is a static element in the DOM, which is just visually hidden.<br/>
              Once the dialog opens, we just fetch the element from the DOM into our dialog and upon close
              we restore the element back into its old DOM position.
            </p>
          </md-dialog>
        </div>
      </div>
</div>-->
</body>
</html>
