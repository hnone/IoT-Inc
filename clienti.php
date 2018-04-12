<<html>
<head>
  <link rel="stylesheet" href="css/clienti.css">
</head>

<body>
  <div ng-cloak ng-controller="ClientiCtrl as clientiList">
    <section class="section--center mdl-grid mdl-grid--no-spacing mdl-shadow--2dp">
      <div class="mdl-card mdl-cell mdl-cell--12-col">
        <div class="mdl-card__supporting-text mdl-grid mdl-grid--no-spacing">
          <h4 class="mdl-cell mdl-cell--12-col">Clienti</h4>
        </div>
        <table class="mdl-data-table mdl-js-data-table ">
          <thead>
            <tr>
              <th class="mdl-data-table__cell--non-numeric">Nome</th>
              <th class="mdl-data-table__cell--non-numeric">Cognome</th>
              <th class="mdl-data-table__cell--non-numeric">Email</th>
              <th class="mdl-data-table__cell--non-numeric">P.Iva</th>
            </tr>
          </thead>
          <tbody>
            <div compile="clientiList"></div>
          </tbody>
        </table>
        <button class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon" id="add" data-upgraded=",MaterialButton,MaterialRipple" ng-click="clientiList.addDialog($event)">
        <i class="material-icons">add</i>
    </button>
      </div>
    </section>
    <script type="text/ng-template" id="aggiungi_cliente.html">
      <md-dialog aria-label="Aggiungi Cliente">
        <md-toolbar>
          <div class="md-toolbar-tools">
            <h2>Aggiungi Cliente</h2>
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
                  <input ng-model="clientiList.nome" size="25" placeholder="Mario">
                </md-input-container>
                <md-input-container class="md-block">
                  <label>Cognome</label>
                  <input ng-model="clientiList.cognome" size="25" placeholder="Rossi">
                </md-input-container>
                <md-input-container class="md-block">
                  <label>Email</label>
                  <input type="email" ng-model="clientiList.email" size="30" placeholder="mario.rossi@email.com"></input>
                </md-input-container>
                <md-input-container class="md-block">
                  <label>Password</label>
                  <input type="password" ng-model="clientiList.password" size="15"></input>
                </md-input-container>
                <md-input-container class="md-block">
                  <label>P.Iva</label>
                  <input ng-model="clientiList.partitaIva" size="15" placeholder="1234567890"></input>
                </md-input-container>
              </div>
              <div layout="row" layout-align="center center">
                <md-button ng-click="answer(clientiList)" class="md-raised md-primary">Aggiungi</md-button>
              </div>
            </form>
          </div>
        </md-dialog-content>
      </md-dialog>
    </script>
    <script type="text/ng-template" id="modifica_cliente.html">
      <md-dialog aria-label="Modifica Cliente" class="myDialog">
        <md-toolbar>
          <div class="md-toolbar-tools">
            <h2>Modifica Cliente</h2>
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
                  <input ng-model="clientiList.nome" size="20">
                </md-input-container>
                <md-input-container class="md-block">
                  <label>Cognome</label>
                  <input ng-model="clientiList.cognome" size="25">
                </md-input-container>
                <md-input-container class="md-block">
                  <label>Email</label>
                  <input type="email" ng-model="clientiList.email" size="30">
                </md-input-container>
                <md-input-container class="md-block">
                  <label>Password</label>
                  <input type="password" ng-model="clientiList.password" size="10" placeholder=""></input>
                </md-input-container>
                <md-input-container class="md-block">
                  <label>P.Iva</label>
                  <input ng-model="clientiList.partitaIva" size="10" placeholder="1234567890"></input>
                </md-input-container>
              </div>
              <div layout-gt-xs="row" layout-align="center center" style="margin-bottom: 30px;">
                <div compile="autorizzate" id="render"></div>
              </div>
              <div layout-gt-xs="row" layout-align="center center">
                <md-button ng-click="answer('edit', clientiList)" class="md-raised md-primary">Salva</md-button>
                <md-button ng-click="answer('remove', clientiList)" class="md-raised md-primary" style="background-color: rgb(199, 56, 11);">Elimina</md-button>
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
