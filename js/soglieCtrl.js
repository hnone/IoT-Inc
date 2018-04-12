app.controller('SoglieCtrl', function($scope, $mdDialog, $mdMedia, $http, $route, $window, $templateCache, $routeParams, sharedProperties) {
  console.log("SOGLIECTRL_PARTITO");
  var soglieList = this;
  soglieList.allsQ = [];
  $http.post('/php/SoglieServices.php', {
    cod: "getSoglie",
    id: sharedProperties.getIdImpianto()
  }, {
    headers: {
      'Content-Type': 'application/json'
    }
  }).
  then(function onSuccess(response) {
    console.log(sharedProperties.getIdImpianto());
    // Handle success
    var data = response.data;
    var status = response.status;
    var statusText = response.statusText;
    var headers = response.headers;
    var config = response.config;
    //console.log(data);
    soglieList.list_soglie = data;
  });
  soglieList.addDialog = function($event, typeName) {
    $mdDialog
      .show({
        controller: function($timeout, $q, $scope, $mdDialog) {
          var soglieList = this;

          $scope.cancel = function($event) {
            $mdDialog.cancel();
          };
          $scope.finish = function($event) {
            $mdDialog.hide();
          };
          $scope.answer = function(answer) {
            $mdDialog.hide(answer);
          };

          $scope.select = function(cod) {
            console.log(cod + " ");
            var path = cod + "List.html";
            var get = "get" + cod;
            console.log(cod + " " + get);
            $mdDialog.show({
              controllerAs: 'soglieList',
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
              controller: function($mdDialog, $scope, parent) {
                $scope.parent = parent;
                $scope.cancel = function($event) {
                  $mdDialog.cancel();
                };
                $scope.finish = function($event) {
                  $mdDialog.hide();
                };
                //LISTA AMBIENTI _ SENSORI
                $http.post('/php/SoglieServices.php', {
                  cod: get,
                  id: sharedProperties.getIdImpianto()
                }, {
                  headers: {
                    'Content-Type': 'application/json'
                  }
                }).
                then(function onSuccess(response) {
                  console.log(sharedProperties.getIdImpianto());
                  // Handle success
                  var data = response.data;
                  var status = response.status;
                  var statusText = response.statusText;
                  var headers = response.headers;
                  var config = response.config;
                  $scope.list_imp = data;

                  $scope.addSoglia = function(cod, id, nome) {
                    if (cod == "addSensore") {
                      sharedProperties.setIdSens(id);
                      console.log(nome);
                      $scope.parent.soglieList.sensore = nome;
                      $mdDialog.hide();
                    } else if (cod == "addAmbiente") {
                      sharedProperties.setIdAmbiente(id);
                      console.log(nome);
                      $scope.parent.soglieList.ambiente = nome;
                      $http.post('/php/SoglieServices.php', {
                        cod: "getNomeTipologie",
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
                        //console.log(data);
                        $scope.parent.soglieList.tipologie = data;
                        $scope.parent.soglieList.tipi = $scope.parent.soglieList.tipologie[0];
                      }, function onError(response) {
                        // Handle error
                        var data = response.data;
                        var status = response.status;
                        var statusText = response.statusText;
                        var headers = response.headers;
                        var config = response.config;
                      });
                      $mdDialog.hide();
                    }
                  }
                });
              }
            })
          };
        },
        controllerAs: 'soglieList',
        templateUrl: typeName + '.html',
        parent: angular.element(document.body),
        targetEvent: $event,
        clickOutsideToClose: true,
        locals: {
          parent: $scope
        },
      })
      .then(function(answer) {
        console.log("PREMUTO_AGGIUNGI");
        console.log(answer);
        console.log(typeName);
        $http.post('/soglie.php', {
          cod: "addSoglia" + typeName.substring(15),
          nome: answer.nome,
          maggMin: answer.maggMin,
          valore: answer.valore,
          idSensore: sharedProperties.getIdSens(),
          idAmbiente: sharedProperties.getIdAmbiente(),
          tipo: answer.tipi
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
  soglieList.editDialog =
    function($event, typeName, soglie) {
      $mdDialog
        .show({
          controller: function($timeout, $q, $scope, $mdDialog, parent) {
            var soglieList = this;
            //$scope.terzePartiList.id = _id;
            console.log(soglie);
            console.log(typeName);
            $scope.soglieList.id = angular.fromJson(soglie).id;
            $scope.soglieList.nome = angular.fromJson(soglie).nome;
            $scope.soglieList.maggMin = angular.fromJson(soglie).maggMin;
            $scope.soglieList.valore = angular.fromJson(soglie).valore;
            if (angular.fromJson(soglie).idSensore != null) {
              $scope.soglieList.idSensAmb = angular.fromJson(soglie).idSensore;
              sharedProperties.setIdSens(angular.fromJson(soglie).idSensore);
            } else {
              $scope.soglieList.idSensAmb = angular.fromJson(soglie).idAmbiente;
              sharedProperties.setIdAmbiente(angular.fromJson(soglie).idAmbiente);
            }
            if (typeName == "modifica_sogliaAmbiente") {
              $http.post('/php/SoglieServices.php', {
                cod: "getNomeTipologie",
                id: $scope.soglieList.idSensAmb
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
                //console.log(data);
                $scope.soglieList.tipologie = data;
                $scope.soglieList.tipi = $scope.soglieList.tipologie[$scope.soglieList.tipologie.indexOf(angular.fromJson(soglie).tipo)];
              }, function onError(response) {
                // Handle error
                var data = response.data;
                var status = response.status;
                var statusText = response.statusText;
                var headers = response.headers;
                var config = response.config;
              });
            }
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
            $scope.select = function(cod) {
              console.log(cod + " ");
              var path = cod + "List.html";
              var get = "get" + cod;
              console.log(cod + " " + get);
              $mdDialog.show({
                controllerAs: 'soglieList',
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
                controller: function($mdDialog, $scope, parent) {
                  $scope.parent = parent;
                  $scope.cancel = function($event) {
                    $mdDialog.cancel();
                  };
                  $scope.finish = function($event) {
                    $mdDialog.hide();
                  };
                  //LISTA AMBIENTI _ SENSORI
                  $http.post('/php/SoglieServices.php', {
                    cod: get,
                    id: sharedProperties.getIdImpianto()
                  }, {
                    headers: {
                      'Content-Type': 'application/json'
                    }
                  }).
                  then(function onSuccess(response) {
                    console.log(sharedProperties.getIdImpianto());
                    // Handle success
                    var data = response.data;
                    var status = response.status;
                    var statusText = response.statusText;
                    var headers = response.headers;
                    var config = response.config;
                    $scope.list_imp = data;

                    $scope.addSoglia = function(cod, id, nome) {
                      if (cod == "addSensore") {
                        sharedProperties.setIdSens(id);
                        console.log(nome);
                        $scope.parent.soglieList.sensore = nome;
                        $mdDialog.hide();
                      } else if (cod == "addAmbiente") {
                        sharedProperties.setIdAmbiente(id);
                        console.log(nome);
                        $scope.parent.soglieList.ambiente = nome;
                        $http.post('/php/SoglieServices.php', {
                          cod: "getNomeTipologie",
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
                          //console.log(data);
                          $scope.parent.soglieList.tipologie = data;
                          $scope.parent.soglieList.tipi = $scope.parent.soglieList.tipologie[0];
                        }, function onError(response) {
                          // Handle error
                          var data = response.data;
                          var status = response.status;
                          var statusText = response.statusText;
                          var headers = response.headers;
                          var config = response.config;
                        });
                        $mdDialog.hide();
                      }
                    }
                  });
                }
              })
            };
            $http.post('/php/SoglieServices.php', {
              cod: "getNome" + typeName.substring(15),
              id: $scope.soglieList.idSensAmb
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
              //console.log(data);
              $scope.soglieList.sensore = data;
              $scope.soglieList.ambiente = data;
            }, function onError(response) {
              // Handle error
              var data = response.data;
              var status = response.status;
              var statusText = response.statusText;
              var headers = response.headers;
              var config = response.config;
            });

          },
          controllerAs: 'soglieList',
          preserveScope: true,
          templateUrl: typeName + '.html',
          autoWrap: false,
          //parent: angular.element(document.body),
          //targetEvent: $event,
          clickOutsideToClose: true,
          locals: {
            parent: $scope,
          },
        })
        .then(
          function(answer) {
            console.log($cod);
            //console.log(answer);
            console.log(answer);
            console.log(sharedProperties.getIdSens());
            console.log(sharedProperties.getIdAmbiente());
            console.log(angular.fromJson(soglie).id);
            console.log(answer.tipi);
            $http.post('/soglie.php', {
              cod: $cod + "Soglia" + typeName.substring(15),
              id: angular.fromJson(soglie).id,
              nome: answer.nome,
              maggMin: answer.maggMin,
              valore: answer.valore,
              idSensore: sharedProperties.getIdSens(),
              idAmbiente: sharedProperties.getIdAmbiente(),
              tipo: answer.tipi
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
              //console.log(data);
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
