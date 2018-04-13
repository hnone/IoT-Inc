app.controller('SensoriCtrl', function($scope, $mdDialog, $mdMedia, $http, $route, $templateCache, $routeParams) {
  $scope.status = '  ';
  var sensoriList = this;
  sensoriList.allsQ = [];
  sensoriList.addDialog = function($event) {
    $mdDialog
      .show({
        controller: function($timeout, $q, $scope, $mdDialog) {
          var sensoriList = this;
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
        controllerAs: 'sensoriList',
        templateUrl: 'aggiungi_sensore.html',
        parent: angular.element(document.body),
        targetEvent: $event,
        clickOutsideToClose: true,
        locals: {
          parent: $scope
        },
      })
      .then(function(answer) {
        $http.post('../php/Servizi/ServizioSensore.php', {
          cod: "add",
          marca: answer.marca,
          modello: answer.modello,
          tipo: answer.tipo,
          unitaMisura: answer.unitaMisura
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
  sensoriList.editDialog =
    function($event, _sensore) {
      $mdDialog
        .show({
          controller: function($timeout, $q, $scope, $mdDialog) {
            var clientiList = this;
            $scope.sensoriList.id = angular.fromJson(_sensore).id;
            $scope.sensoriList.marca = angular.fromJson(_sensore).marca;
            $scope.sensoriList.modello = angular.fromJson(_sensore).modello;
            $scope.sensoriList.tipo = angular.fromJson(_sensore).tipo;
            $scope.sensoriList.unitaMisura = angular.fromJson(_sensore).unitaMisura;
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
          },
          controllerAs: 'sensoriList',
          preserveScope: true,
          templateUrl: 'modifica_sensore.html',
          autoWrap: false,
          clickOutsideToClose: true,
          locals: {
            parent: $scope,
          },
        })
        .then(
          function(answer) {
            console.log($cod);
            console.log(angular.fromJson(_sensore).id);
            //console.log(answer);
            $http.post('../php/Servizi/ServizioSensore.php', {
              cod: $cod,
              id: angular.fromJson(_sensore).id,
              marca: answer.marca,
              modello: answer.modello,
              tipo: answer.tipo,
              unitaMisura: answer.unitaMisura
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
