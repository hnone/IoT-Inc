app.controller('ClientiCtrl', function($scope, $mdDialog, $mdMedia, $http, $route, $templateCache, $routeParams) {
  $scope.status = '  ';
  var clientiList = this;
  clientiList.allsQ = [];
  clientiList.addDialog = function($event) {
    $mdDialog
      .show({
        controller: function($timeout, $q, $scope, $mdDialog) {
          var clientiList = this;
          $scope.cancel = function($event) {
            $mdDialog.cancel();
          };
          $scope.finish = function($event) {
            $mdDialog.hide();
          };
          $scope.answer = function(answer) {
            $mdDialog.hide(answer);
          };
        },
        controllerAs: 'clientiList',
        templateUrl: 'aggiungi_cliente.html',
        parent: angular.element(document.body),
        targetEvent: $event,
        clickOutsideToClose: true,
        locals: {
          parent: $scope
        },
      })
      .then(function(answer) {
        $http.post('/clienti.php', {
          cod: "add",
          nome: answer.nome,
          cognome: answer.cognome,
          email: answer.email,
          password: answer.password,
          partitaIva: answer.partitaIva
        }, {
          headers: {
            'Content-Type': 'application/json'
          }
        }).
        then(function onSuccess(response) {
          // Handle success
          var data = response.data;
          var status = response.status;
          var statusText = response.statusText;
          var headers = response.headers;
          var config = response.config;
          console.log(data);
          var currentPageTemplate = $route.current.templateUrl;
          $templateCache.remove(currentPageTemplate);
          $route.reload();
        }, function onError(response) {
          // Handle error
          var data = response.data;
          var status = response.status;
          var statusText = response.statusText;
          var headers = response.headers;
          var config = response.config;
        });
      });
  };
  clientiList.editDialog =
    function($event, _cliente) {
      $mdDialog
        .show({
          controller: function($timeout, $q, $scope, $mdDialog) {
            var clientiList = this;
            $scope.clientiList.id = angular.fromJson(_cliente).id;
            $scope.clientiList.nome = angular.fromJson(_cliente).nome;
            $scope.clientiList.cognome = angular.fromJson(_cliente).cognome;
            $scope.clientiList.email = angular.fromJson(_cliente).email;
            $scope.clientiList.password = angular.fromJson(_cliente).password;
            $scope.clientiList.partitaIva = angular.fromJson(_cliente).partitaIva;
            $scope.cancel = function($event) {
              $mdDialog.cancel();
            };
            $scope.finish = function($event) {
              $mdDialog.hide();
            };
            $scope.answer = function(cod, answer) {
              //console.log(cod);
              $cod = cod;
              $mdDialog.hide(answer);
            };
            $http.post('/php/ClientiServices.php', {
              cod: "getAutorizzazioni",
              id: $scope.clientiList.id
            }, {
              headers: {
                'Content-Type': 'application/json'
              }
            }).
            then(function onSuccess(response) {
              // Handle success
              var data = response.data;
              var status = response.status;
              var statusText = response.statusText;
              var headers = response.headers;
              var config = response.config;
              $scope.autorizzate = data;
            }, function onError(response) {
              // Handle error
              var data = response.data;
              var status = response.status;
              var statusText = response.statusText;
              var headers = response.headers;
              var config = response.config;
            });
          },
          controllerAs: 'clientiList',
          preserveScope: true,
          templateUrl: 'modifica_cliente.html',
          autoWrap: false,
          //parent: angular.element(document.body),
          //targetEvent: $event,
          clickOutsideToClose: true,
          locals: {
            parent: $scope,
            //terzaParte: _terzaParte
          },
        })
        .then(
          function(answer) {
            console.log($cod);
            console.log(angular.fromJson(_cliente).id);
            //console.log(answer);
            $http.post('/clienti.php', {
              cod: $cod,
              id: angular.fromJson(_cliente).id,
              nome: answer.nome,
              cognome: answer.cognome,
              email: answer.email,
              password: answer.password,
              partitaIva: answer.partitaIva
            }, {
              headers: {
                'Content-Type': 'application/json'
              }
            }).
            then(function onSuccess(response) {
              // Handle success
              var data = response.data;
              var status = response.status;
              var statusText = response.statusText;
              var headers = response.headers;
              var config = response.config;
              var currentPageTemplate = $route.current.templateUrl;
              $templateCache.remove(currentPageTemplate);
              $route.reload();
            }, function onError(response) {
              // Handle error
              var data = response.data;
              var status = response.status;
              var statusText = response.statusText;
              var headers = response.headers;
              var config = response.config;
            });
          })
    };
})
