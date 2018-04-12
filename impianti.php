<html>
<head>
  <link rel="stylesheet" href="css/page.css">
</head>
<body>
<div ng-cloak ng-controller="ImpiantiCtrl as impiantiList">
<section class="section--center mdl-grid mdl-grid--no-spacing mdl-shadow--2dp">
  <div class="mdl-card mdl-cell mdl-cell--12-col">
    <div class="mdl-card__supporting-text mdl-grid mdl-grid--no-spacing">
      <h4 class="mdl-cell mdl-cell--12-col">Impianti</h4>
      </div>
      <table class="mdl-data-table mdl-js-data-table ">
      <thead>
        <tr>
          <th class="mdl-data-table__cell--non-numeric">Nome</th>
          <th class="mdl-data-table__cell--non-numeric">Tipo</th>
          <th class="mdl-data-table__cell--non-numeric">Cliente</th>
        </tr>
      </thead>
      <tbody>

      </tbody>
    </table>
    <button class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon" id="add" data-upgraded=",MaterialButton,MaterialRipple" ng-click="impiantiList.addDialog($event)">
        <i class="material-icons">add</i>
    </button>
  </div>
  </section>
  <script type="text/ng-template" id="aggiungi_impianto.html">
      <md-dialog aria-label="Aggiungi Impianto">
    <md-toolbar>
      <div class="md-toolbar-tools">
        <h2>Aggiungi Impianto</h2>
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
                      <input ng-model="impiantiList.nome"  size="25" placeholder="Impianto1">
                    </md-input-container>
                    <md-input-container class="md-block">
                      <label>Tipo</label>
                      <input ng-model="impiantiList.tipo"  size="20" placeholder="Tipo1">
                    </md-input-container>
                    <md-input-container class="md-block">
                      <label>Cliente</label>
                      <input ng-model="impiantiList.cliente" size="25" placeholder="Cliente1" ng-focus="select('Cliente')"></input>
                    </md-input-container>
                  </div>
                  <div layout="row" layout-align="center center">
                  <md-button ng-click="answer(impiantiList)" class="md-raised md-primary">Aggiungi</md-button>
                </div>
        </form>
      </div>
    </md-dialog-content>
  </md-dialog>
  </script>
  <script type="text/ng-template" id="modifica_impianto.html">
    <md-dialog aria-label="Modifica Impianto" class="myDialog">
    <md-toolbar>
      <div class="md-toolbar-tools">
        <h2>Modifica Impianto</h2>
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
                      <input ng-model="impiantiList.nome"  size="25">
                    </md-input-container>
                    <md-input-container class="md-block">
                      <label>Tipo</label>
                      <input ng-model="impiantiList.tipo"  size="20">
                    </md-input-container>
                    <md-input-container class="md-block">
                      <label>Cliente</label>
                      <input ng-model="impiantiList.cliente" size="25" ng-focus="select('Cliente')"></input>
                    </md-input-container>
                  </div>
                  <div layout-gt-xs="row" layout-align="center center" style="margin-bottom: 30px;">
                        <div compile="autorizzate" id="render"></div>
                  </div>
                  <div layout-gt-xs="row" layout-align="center center">
                  <md-button ng-click="answer('edit', impiantiList)" class="md-raised md-primary">Salva</md-button>
                  <md-button ng-click="answer('remove', impiantiList)" class="md-raised md-primary" style="background-color: rgb(199, 56, 11);">Elimina</md-button>
                </div>
        </form>
      </div>
    </md-dialog-content>
  </md-dialog>
  </script>

  <script type="text/ng-template" id="ClienteList.html">
      <md-dialog aria-label="Seleziona Cliente">
      <md-toolbar>
        <div class="md-toolbar-tools">
          <h2>Seleziona cliente da associare</h2>
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
  <script type="text/ng-template" id="addAmbiente.html">
    <md-dialog aria-label="Aggiungi Ambiente">
    <md-toolbar>
      <div class="md-toolbar-tools">
        <h2>Aggiungi ambiente</h2>
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
                      <input ng-model="impiantiList.nomeAmbiente"  size="25">
                    </md-input-container>
                  </div>
                  <div layout-gt-xs="row" layout-align="center center">
                  <md-button ng-click="aggiungiAmbiente(impiantiList)" class="md-raised md-primary">Aggiungi</md-button>
                  </div>
                </div>
        </form>
      </div>
    </md-dialog-content>
  </md-dialog>
  </script>
  <script type="text/ng-template" id="addSensore.html">
    <md-dialog aria-label="Installa Sensore">
    <md-toolbar>
      <div class="md-toolbar-tools">
        <h2>Installa sensore</h2>
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
                      <input ng-model="impiantiList.nomeSensoreInstallato"  size="25" placeholder="Sensore1">
                    </md-input-container>
                    <md-input-container class="md-block">
                      <label>Sensore</label>
                      <input ng-model="impiantiList.nomeSensore"  size="30" placeholder="SAMSUNG MOD1 TEMPERATURA" ng-focus="select('Sensore')">
                    </md-input-container>
                    <md-input-container class="md-block">
                      <label>Ambiente</label>
                      <input ng-model="impiantiList.nomeAmbiente" size="25" placeholder="Altoforno" ng-focus="select('Ambiente')"></input>
                    </md-input-container>
                  </div>
                  <div layout="row" layout-align="center center">
                  <md-button ng-click="installaSensore(impiantiList)" class="md-raised md-primary">Installa</md-button>
                </div>
        </form>
      </div>
    </md-dialog-content>
  </md-dialog>
  </script>
  <script type="text/ng-template" id="editAmbiente.html">
    <md-dialog aria-label="Modifica Ambiente">
    <md-toolbar>
      <div class="md-toolbar-tools">
        <h2>Modifica ambiente</h2>
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
                      <input ng-model="impiantiList.nomeAmbiente" size="25">
                    </md-input-container>
                  </div>
                  <div layout-gt-xs="row" layout-align="center center">
                    <md-button ng-click="modificaAmbiente('edit', impiantiList)" class="md-raised md-primary">Salva</md-button>
                    <md-button ng-click="modificaAmbiente('delete', impiantiList)" class="md-raised md-primary" style="background-color: rgb(199, 56, 11);">Elimina</md-button>
                </div>
        </form>
      </div>
    </md-dialog-content>
  </md-dialog>
  </script>
  <script type="text/ng-template" id="editSensore.html">
    <md-dialog aria-label="Modifica Sensore">
    <md-toolbar>
      <div class="md-toolbar-tools">
        <h2>Modifica Sensore Installato</h2>
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
                      <input ng-model="impiantiList.nomeSensoreInstallato"  size="25">
                    </md-input-container>
                    <md-input-container class="md-block">
                      <label>Sensore</label>
                      <input ng-model="impiantiList.nomeSensore"  size="30" ng-focus="select('Sensore')">
                    </md-input-container>
                    <md-input-container class="md-block">
                      <label>Ambiente</label>
                      <input ng-model="impiantiList.nomeAmbiente" size="25" ng-focus="select('Ambiente')"></input>
                    </md-input-container>
                  </div>
                  <div layout="row" layout-align="center center">
                    <md-button ng-click="modificaSensore('edit', impiantiList)" class="md-raised md-primary">Salva</md-button>
                    <md-button ng-click="modificaSensore('delete', impiantiList)" class="md-raised md-primary" style="background-color: rgb(199, 56, 11);">Elimina</md-button>
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
    <md-dialog aria-label="Seleziona Sensore">
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
