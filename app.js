var app = angular.module("MyApp", ["ngRoute", "ngMaterial", "ngMessages", "ngSanitize", "nvd3"]);
app
  .config(function($routeProvider, $locationProvider) {
    $locationProvider.hashPrefix('');
    $routeProvider
      /*.when('/', {
        templateUrl: '/home.php',
        controller: 'MainCtrl',
        map: 'home'
      })*/
      .when('/', {
        templateUrl: '/choose.php',
        //controller: 'ChooseCtrl',
        map: 'choose'
      })
      .when('/choose', {
        templateUrl: '/choose.php',
        //controller: 'ChooseCtrl',
        map: 'choose'
      })
      .when('/home', {
        templateUrl: '/home.php',
        //controller: 'MainCtrl',
        map: 'home'
      })
      .when('/rilevazioni', {
        templateUrl: '/rilevazioni.php',
        //controller: 'RilevazioniCtrl',
        map: 'rilevazioni'
      })
      .when('/soglie', {
        templateUrl: '/soglie.php',
        //(controller: 'DemoCtrl',
        map: 'soglie'
      })
      .when('/terzeParti', {
        templateUrl: '/terzeParti.php',
        //controller: 'DemoCtrl',
        map: 'terzeParti'
      })
  })
  .directive('compile', ['$compile', function($compile) {
    return function(scope, element, attrs) {
      scope.$watch(
        function(scope) {
          // watch the 'compile' expression for changes
          return scope.$eval(attrs.compile);
        },
        function(value) {
          // when the 'compile' expression changes
          // assign it into the current DOM
          element.html(value);

          // compile the new DOM and link it to the current
          // scope.
          // NOTE: we only compile .childNodes so that
          // we don't get into infinite loop compiling ourselves
          $compile(element.contents())(scope);
        }
      );
    };
  }])
  app.service('sharedProperties', function() {
    var nomeImpianto = '';
    var rilevazioni = '';
    var rilevazioniSens = '';
    var idSens = '';
    var tipoSens = '';
    var unitaSens = '';
    return {
        getNomeImpianto: function() {
            return nomeImpianto;
        },
        setNomeImpianto: function(value) {
          //console.log(value);
          nomeImpianto = value;
        },
        getRilevazioni: function() {
            return rilevazioni;
        },
        setRilevazioni: function(value) {
          //console.log(value);
          rilevazioni = value;
        },
        getIdSens: function() {
            return idSens;
        },
        setIdSens: function(value) {
          //console.log(value);
          idSens = value;
        },
        getTipoSens: function() {
          return tipoSens;
        },
        setTipoSens: function(value) {
          //console.log(value);
          tipoSens = value;
        },
        getUnitaSens: function() {
          return unitaSens;
        },
        setUnitaSens: function(value) {
          //console.log(value);
          unitaSens = value;
        },
        getRilevazioniSens: function() {
            return rilevazioniSens;
        },
        setRilevazioniSens: function(value) {
          //console.log(value);
          rilevazioniSens = value;
        }
    }
  })
  .run(['$location', '$rootScope', function($location, $rootScope) {
    $rootScope.$on('$locationChangeStart', function() {
      console.log('location change started', $location.url());
    })
    $rootScope.$on('$locationChangeSuccess', function() {
      console.log('location change ended', $location.url());
    })
  }])
  .controller('MainCtrl', function($scope, $route, sharedProperties) {
    $scope.$route = $route;
    $scope.both = function() {
      return sharedProperties.getNomeImpianto();
    };
  })
  .controller('HomeCtrl', function($scope, $route, $location, $http, sharedProperties) {
    $scope.both = function() {
      return sharedProperties.getRilevazioni();
    };
    $scope.listRil = sharedProperties.getRilevazioni();
    $scope.chooseSensoreInstallato = function($scope, idSensoreInstallato, tipoSens, unitaSens) {
      console.log(idSensoreInstallato);
      sharedProperties.setIdSens(idSensoreInstallato);
      sharedProperties.setTipoSens(tipoSens);
      sharedProperties.setUnitaSens(unitaSens);
      $http.post('http://79.8.96.3/php/RilevazioniServices.php', {
        cod: "setIdSensoreInstallato",
        id: idSensoreInstallato
      }, {
        headers: {
          'Content-Type': 'application/json'
        }
      }).
      then(
        function onSuccess(response) {
        //$location.path("/home");
        // Handle success
        var data = response.data;
        var status = response.status;
        var statusText = response.statusText;
        var headers = response.headers;
        var config = response.config;
        //console.log(data);
        sharedProperties.setRilevazioniSens(data);
        //console.log(data);
        $location.path("/rilevazioni");
      }, function onError(response) {
        // Handle error
        var data = response.data;
        var status = response.status;
        var statusText = response.statusText;
        var headers = response.headers;
        var config = response.config;
      });
    }
  })
  .controller('ChooseCtrl', function($scope, $route, $location, $http, sharedProperties) {
    $scope.chooseImpianto = function($scope, idImpianto) {
      console.log(idImpianto);
      $http.post('http://79.8.96.3/php/ImpiantiServices.php', {
        cod: "getNomeImpianto",
        id: idImpianto
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
        //console.log(idImpianto + " " + data);
        sharedProperties.setNomeImpianto(data);
            $http.post('http://79.8.96.3/php/RilevazioniServices.php', {
              cod: "setIdImpianto",
              id: idImpianto
            }, {
              headers: {
                'Content-Type': 'application/json'
              }
            }).
            then(
              function onSuccess(response) {
              //$location.path("/home");
              // Handle success
              var data = response.data;
              var status = response.status;
              var statusText = response.statusText;
              var headers = response.headers;
              var config = response.config;
              //console.log(data);
              sharedProperties.setRilevazioni(data);
              $location.path("/home");
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
  })
  .controller('RilevazioniCtrl', function($scope, $route, $http, $window, $timeout, sharedProperties) {
    $scope.both = function() {
      return sharedProperties.getRilevazioniSens();
    };
    $scope.listRilSens = sharedProperties.getRilevazioniSens();
    $scope.idSens = sharedProperties.getIdSens();

    $scope.$watch('fetching', function() {
      if(!$scope.fetching) {
        $timeout(function() {
          $window.dispatchEvent(new Event('resize'));
          $scope.fetching = true;
        }, 200);
      }
    });

    $http.post('http://79.8.96.3/php/RilevazioniServices.php', {
      cod: "getRilevazioniSensDate",
      id:   $scope.idSens,
      dateFrom: "2018-03-23",
      dateTo: "2018-03-24"
    }, {
      headers: {
        'Content-Type': 'application/json'
      }
    }).
    then(function onSuccess(response) {
      // Handle success
      console.log("chiamato rilevazioniSensdate");
      var data = response.data;
      var status = response.status;
      var statusText = response.statusText;
      var headers = response.headers;
      var config = response.config;
      console.log(data);
      console.log("DECODIFICO" + angular.fromJson(data).length);
      console.log(angular.fromJson(data)[0]);
      /*$scope.labels = new Array();
      $scope.data = new Array();*/

            $scope.options = {
                        chart: {
                            type: 'lineChart',
                            height: 450,
                            margin : {
                                top: 20,
                                right: 20,
                                bottom: 150,
                                left: 55
                            },
                            x: function(d){ return d.x; },
                            y: function(d){ return d.y; },
                            showLegend: false,
                            useInteractiveGuideline: false,
                            duration: 300,
                            focusEnable: false,
                            dispatch: {
                                stateChange: function(e){ console.log("stateChange"); },
                                changeState: function(e){ console.log("changeState"); },
                                tooltipShow: function(e){ console.log("tooltipShow"); },
                                tooltipHide: function(e){ console.log("tooltipHide"); }
                            },
                            xAxis: {
                                axisLabel: 'Data/Ora',
                                tickFormat: function(d) {
                                  return d3.time.format('%d/%m/%y %H:%M:%S')(new Date(d))
                                },
                                  showMaxMin: true,
                                  rotateLabels: -60
                            },
                            //Scale: d3.time.scale.utc(),
                            yAxis: {
                                axisLabel: sharedProperties.getTipoSens() + " (" + sharedProperties.getUnitaSens() + ")",
                                tickFormat: function(d){
                                    return d3.format('.02f')(d);
                                },
                                axisLabelDistance: -10
                            },
                            callback: function(chart){
                                console.log("!!! lineChart callback !!!");
                            }
                        },
                    };

        $scope.data = dataParser();

        function dataParser() {

            var cos = [];
            angular.fromJson(data).forEach(function(rilevazione) {
              //console.log(rilevazione.valore.replace('.',','));
                  //$scope.labels.push(rilevazione.data + " " + rilevazione.ora);
                  console.log(rilevazione.valore);
                  if (rilevazione.valore != null) {
                    //console.log(rilevazione.data + rilevazione.ora);
                    //console.log(new Date(rilevazione.data + "T" + rilevazione.ora).getTime());
                    console.log(new Date(rilevazione.data).getTime() + "-" + parseFloat(rilevazione.valore).toFixed(2));
                    cos.push({x: new Date(rilevazione.data).getTime(), y: parseFloat(rilevazione.valore).toFixed(2)});
                  }
              });

            //Line chart data should be sent as an array of series objects.
            return [
                {
                    values: cos,
                    key: sharedProperties.getTipoSens(),
                    color: '#364061'
                }
            ];
        };
      }, function onError(response) {
      // Handle error
      var data = response.data;
      var status = response.status;
      var statusText = response.statusText;
      var headers = response.headers;
      var config = response.config;
    });
  })
  .controller('DemoCtrl',
    function($scope, $mdDialog, $mdMedia, $http, $route, $templateCache, $routeParams) {
      $scope.status = '  ';
      var questList = this;
      questList.allsQ = [];
      questList.addDialog = function($event) {
        $mdDialog
          .show({
            controller: function($timeout, $q, $scope, $mdDialog) {
              var questList = this;
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
            controllerAs: 'questList',
            templateUrl: 'aggiungi_terzaParte.html',
            parent: angular.element(document.body),
            targetEvent: $event,
            clickOutsideToClose: true,
            locals: {
              parent: $scope
            },
          })
          .then(function(answer) {
            $http.post('http://79.8.96.3/terzeParti.php', {
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
      questList.editDialog =
        function($event, _terzaParte) {
          $mdDialog
            .show({
              controller: function($timeout, $q, $scope, $mdDialog) {
                var questList = this;
                //$scope.questList.id = _id;
                //console.log(_terzaParte);
                $scope.questList.id = angular.fromJson(_terzaParte).id;
                $scope.questList.nome = angular.fromJson(_terzaParte).nome;
                $scope.questList.cognome = angular.fromJson(_terzaParte).cognome;
                $scope.questList.email =  angular.fromJson(_terzaParte).email;
                $scope.questList.tempo = angular.fromJson(_terzaParte).tempo;
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
                    controllerAs: 'questList',
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
                      $http.post('http://79.8.96.3/php/ClientiServices.php', {
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
                          $http.post('http://79.8.96.3/php/AutorizzazioniServices.php', {
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
                            $http.post('http://79.8.96.3/php/AutorizzazioniServices.php', {
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
                  $http.post('http://79.8.96.3/php/AutorizzazioniServices.php', {
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
                    $http.post('http://79.8.96.3/php/AutorizzazioniServices.php', {
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
                $http.post('http://79.8.96.3/php/AutorizzazioniServices.php', {
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
              controllerAs: 'questList',
              preserveScope: true,
              templateUrl: 'modifica_terzaParte.html',
              autoWrap: false,
              //parent: angular.element(document.body),
              //targetEvent: $event,
              clickOutsideToClose: true,
              locals: {
                parent: $scope,
                terzaParte: _terzaParte
              },
            })
            .then(
              function(answer) {
                console.log($cod);
                //console.log(answer);
                $http.post('http://79.8.96.3/terzeParti.php', {
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
    });
