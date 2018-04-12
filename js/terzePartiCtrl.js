app.controller('TerzePartiCtrl', function($scope, $mdDialog, $mdMedia, $http, $route, $templateCache, $routeParams) {
  $scope.status = '  ';
  var terzePartiList = this;
  terzePartiList.allsQ = [];
  terzePartiList.addDialog = function($event) {
    $mdDialog
      .show({
        controller: function($timeout, $q, $scope, $mdDialog) {
          var terzePartiList = this;
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
        controllerAs: 'terzePartiList',
        templateUrl: 'aggiungi_terzaParte.html',
        parent: angular.element(document.body),
        targetEvent: $event,
        clickOutsideToClose: true,
        locals: {
          parent: $scope
        },
      })
      .then(function(answer) {
        $http.post('/terzeParti.php', {
          cod: "add",
          nome: answer.nome,
          cognome: answer.cognome,
          email: answer.email,
          tempo: answer.tempo
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
      });
  };
  terzePartiList.editDialog =
    function($event, _terzaParte) {
      $mdDialog
        .show({
          controller: function($timeout, $q, $scope, $mdDialog) {
            var terzePartiList = this;
            //$scope.terzePartiList.id = _id;
            //console.log(_terzaParte);
            $scope.terzePartiList.id = angular.fromJson(_terzaParte).id;
            $scope.terzePartiList.nome = angular.fromJson(_terzaParte).nome;
            $scope.terzePartiList.cognome = angular.fromJson(_terzaParte).cognome;
            $scope.terzePartiList.email = angular.fromJson(_terzaParte).email;
            $scope.terzePartiList.tempo = angular.fromJson(_terzaParte).tempo;
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

            $scope.addAut = function(cod, id) {
              console.log(cod + " " + id);
              var path = cod + "List.html";
              var get = "get" + cod.substring(3);
              console.log(cod + " " + get);
              $mdDialog.show({
                controllerAs: 'terzePartiList',
                clickOutsideToClose: true,
                //scope: $scope,
                preserveScope: true,
                closeByDocument: false,
                autoWrap: true,
                locals: {
                  parent: $scope
                },
                multiple: true,
                templateUrl: path,
                controller: function($mdDialog, $scope, $mdDialog, parent) {
                  $scope.parent = parent;
                  $scope.cancel = function($event) {
                    $mdDialog.cancel();
                  };
                  $scope.finish = function($event) {
                    $mdDialog.hide();
                  };
                  //LISTA IMPIANTI _ AMBIENTI _ SENSORI
                  $http.post('/php/TerzePartiServices.php', {
                    cod: get,
                    id: id
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
                    $scope.list_imp = data;
                    $scope.editAut = function(cod, aut, id) {
                      //ADDIMPIANTO _ AMBIENTE _ SENSORE
                      $http.post('/php/AutorizzazioniServices.php', {
                        cod: cod,
                        aut: aut,
                        id: id
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
                        $mdDialog.hide();
                        //AGGIORNA LA TABELLA
                        $http.post('/php/AutorizzazioniServices.php', {
                          cod: "getAutorizzazioni",
                          id: id
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
                          parent.autorizzate = data;
                        }, function onError(response) {
                          // Handle error
                          var data = response.data;
                          var status = response.status;
                          var statusText = response.statusText;
                          var headers = response.headers;
                          var config = response.config;
                        });
                      }, function onError(response) {
                        // Handle error
                        var data = response.data;
                        var status = response.status;
                        var statusText = response.statusText;
                        var headers = response.headers;
                        var config = response.config;
                      });
                    };
                  }, function onError(response) {
                    // Handle error
                    var data = response.data;
                    var status = response.status;
                    var statusText = response.statusText;
                    var headers = response.headers;
                    var config = response.config;
                  });
                }
                //template: '<md-dialog class="confirm"><md-conent><md-button ng-click="dialogCtrl.click()">I am in a 2nd dialog!</md-button></md-conent></md-dialog>'
              });
              //newCompModal.show($event);
            };
            $scope.editAut = function(cod, aut, id) {
              //DELETEIMPIANTO _ AMBIENTE _ SENSORE
              $http.post('/php/AutorizzazioniServices.php', {
                cod: cod,
                aut: aut,
                id: id
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
                //$scope.autorizzate = data;
                //AGGIORNA LA TABELLA
                $http.post('/php/AutorizzazioniServices.php', {
                  cod: "getAutorizzazioni",
                  id: id
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
              }, function onError(response) {
                // Handle error
                var data = response.data;
                var status = response.status;
                var statusText = response.statusText;
                var headers = response.headers;
                var config = response.config;
              });
            };

            //console.log('>>>>>>> '+  $scope.nome + " " + $scope.cognome + " " +   $scope.email);
            $http.post('/php/AutorizzazioniServices.php', {
              cod: "getAutorizzazioni",
              id: angular.fromJson(_terzaParte).id
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
          controllerAs: 'terzePartiList',
          preserveScope: true,
          templateUrl: 'modifica_terzaParte.html',
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
            //console.log(answer);
            $http.post('/terzeParti.php', {
              cod: $cod,
              id: angular.fromJson(_terzaParte).id,
              nome: answer.nome,
              cognome: answer.cognome,
              email: answer.email,
              tempo: answer.tempo
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
