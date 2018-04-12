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
      .when('/clienti', {
        templateUrl: '/clienti.php',
        //controller: 'MainCtrl',
        map: 'clienti'
      })
      .when('/impianti', {
        templateUrl: '/impianti.php',
        //controller: 'MainCtrl',
        map: 'impianti'
      })
      .when('/sensori', {
        templateUrl: '/sensori.php',
        //controller: 'MainCtrl',
        map: 'sensori'
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
    var idImpianto = '';
    var rilevazioni = '';
    var rilevazioniSens = '';
    var idSens = '';
    var idAmbiente = '';
    var idCliente = '';
    var tipoSens = '';
    var unitaSens = '';
    var soglie = '';
    var homeDisplay = '';
    var soglieDisplay = '';
    return {
        getNomeImpianto: function() {
            return nomeImpianto;
        },
        setNomeImpianto: function(value) {
          //console.log(value);
          nomeImpianto = value;
        },
        getIdImpianto: function() {
            return idImpianto;
        },
        setIdImpianto: function(value) {
          //console.log(value);
          idImpianto = value;
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
        getIdAmbiente: function() {
            return idAmbiente;
        },
        setIdAmbiente: function(value) {
          //console.log(value);
          idAmbiente = value;
        },
        getIdCliente: function() {
            return idCliente;
        },
        setIdCliente: function(value) {
          //console.log(value);
          idCliente = value;
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
        },
        getSoglie: function() {
            return soglie;
        },
        setSoglie: function(value) {
          //console.log(value);
          soglie = value;
        },
        getHomeDisplay: function() {
            return homeDisplay;
        },
        setHomeDisplay: function(value) {
          //console.log(value);
          homeDisplay = value;
        },
        getSoglieDisplay: function() {
            return soglieDisplay;
        },
        setSoglieDisplay: function(value) {
          //console.log(value);
          soglieDisplay = value;
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
    sharedProperties.setHomeDisplay("none");
    sharedProperties.setSoglieDisplay("none");

    $scope.$route = $route;
    $scope.both = function() {
      return sharedProperties.getNomeImpianto();
    };
    $scope.both1 = function() {
      return sharedProperties.getSoglie();;
    };

    $scope.both2 = function() {
      return sharedProperties.getHomeDisplay();
    };

    $scope.both3 = function() {
      return sharedProperties.getSoglieDisplay();
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
      $http.post('/php/RilevazioniServices.php', {
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
    sharedProperties.setHomeDisplay("none");
    sharedProperties.setSoglieDisplay("none");
    console.log("choose");
    $scope.chooseImpianto = function(idImpianto) {
      console.log(idImpianto);
      $http.post('/php/ImpiantiServices.php', {
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
        sharedProperties.setIdImpianto(idImpianto);
        sharedProperties.setNomeImpianto(data);
        sharedProperties.setSoglie("Soglie");
        sharedProperties.setHomeDisplay("block");
        sharedProperties.setSoglieDisplay("block");
            $http.post('/php/RilevazioniServices.php', {
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

    $scope.generateGraph = function(dateFrom, dateTo) {
      console.log(dateFrom + dateTo);
      $http.post('/php/RilevazioniServices.php', {
        cod: "getRilevazioniSensDate",
        id:   $scope.idSens,
        dateFrom: dateFrom.substring(6, 10) + "-" + dateFrom.substring(3, 5) + "-" + dateFrom.substring(0, 2),
        dateTo:  dateTo.substring(6, 10) + "-" + dateTo.substring(3, 5) + "-" + dateTo.substring(0, 2)
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
    };
  })
  .controller('SoglieCtrl', function($scope, $mdDialog, $mdMedia, $http, $route, $window, $templateCache, $routeParams, sharedProperties) {
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
                        } else if (cod == "addAmbiente"){
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
            })};
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
                $scope.soglieList.valore =  angular.fromJson(soglie).valore;
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
                          } else if (cod == "addAmbiente"){
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
              })};
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
                console.log( sharedProperties.getIdSens() );
                console.log( sharedProperties.getIdAmbiente() );
                console.log( angular.fromJson(soglie).id);
                console.log (answer.tipi);
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
  .controller('TerzePartiCtrl',function($scope, $mdDialog, $mdMedia, $http, $route, $templateCache, $routeParams) {
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
                $scope.terzePartiList.email =  angular.fromJson(_terzaParte).email;
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
  .controller('ClientiCtrl',function($scope, $mdDialog, $mdMedia, $http, $route, $templateCache, $routeParams) {
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
                  $scope.clientiList.partitaIva =  angular.fromJson(_cliente).partitaIva;
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
  .controller('ImpiantiCtrl',function($scope, $mdDialog, $mdMedia, $http, $route, $templateCache, $routeParams, sharedProperties) {
            $scope.status = '  ';
            var impiantiList = this;
            impiantiList.allsQ = [];
            impiantiList.addDialog = function($event) {
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
                    $scope.select = function(cod) {
                      console.log(cod + " ");
                      var path = cod + "List.html";
                      var get = "get" + cod;
                      console.log(cod + " " + get);
                      $mdDialog.show({
                        controllerAs: 'impiantiList',
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
                          $http.post('/php/ImpiantiServices.php', {
                            cod: get
                          }, {
                            headers: {
                              'Content-Type': 'application/json'
                            }
                          }).
                          then(function onSuccess(response) {
                            //console.log(sharedProperties.getIdImpianto());
                            // Handle success
                            var data = response.data;
                            var status = response.status;
                            var statusText = response.statusText;
                            var headers = response.headers;
                            var config = response.config;
                            $scope.list_imp = data;

                            $scope.addCliente = function(id, cliente) {
                                sharedProperties.setIdCliente(id);
                                console.log(cliente);
                                $scope.parent.impiantiList.cliente = cliente;
                                $mdDialog.hide();
                            }
                      });
                    }
                  })};
                  },
                  controllerAs: 'impiantiList',
                  templateUrl: 'aggiungi_impianto.html',
                  parent: angular.element(document.body),
                  targetEvent: $event,
                  clickOutsideToClose: true,
                  locals: {
                    parent: $scope
                  },
                })
                .then(function(answer) {
                  $http.post('/impianti.php', {
                    cod: "add",
                    nome: answer.nome,
                    tipo: answer.tipo,
                    idCliente: sharedProperties.getIdCliente()
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
            impiantiList.editDialog =
              function($event, _impianto) {
                $mdDialog
                  .show({
                    controller: function($timeout, $q, $scope, $mdDialog) {
                      var clientiList = this;
                      $scope.impiantiList.id = angular.fromJson(_impianto).id;
                      $scope.impiantiList.nome = angular.fromJson(_impianto).nome;
                      $scope.impiantiList.tipo = angular.fromJson(_impianto).tipo;
                      $scope.impiantiList.idCliente = angular.fromJson(_impianto).idCliente;
                      sharedProperties.setIdCliente(angular.fromJson(_impianto).idCliente);
                      sharedProperties.setIdImpianto(angular.fromJson(_impianto).id);

                      $scope.cancel = function($event) {
                        $mdDialog.cancel();
                      };
                      $scope.finish = function($event) {
                        $mdDialog.hide();
                      };
                      $scope.answer = function(cod, answer) {
                        $cod = cod;
                        $mdDialog.hide(answer);
                      };
                      $scope.select = function(cod) {
                        console.log(cod + " ");
                        var path = cod + "List.html";
                        var get = "get" + cod;
                        console.log(cod + " " + get);
                        $mdDialog.show({
                          controllerAs: 'impiantiList',
                          clickOutsideToClose: true,
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
                            $http.post('/php/ImpiantiServices.php', {
                              cod: get
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

                              $scope.addCliente = function(id, cliente) {
                                  sharedProperties.setIdCliente(id);
                                  console.log(cliente);
                                  $scope.parent.impiantiList.cliente = cliente;
                                  $mdDialog.hide();
                              }
                        });
                      }
                    })};
                    $http.post('/php/ImpiantiServices.php', {
                        cod: "getNomeCliente",
                        id: $scope.impiantiList.idCliente
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
                          $scope.impiantiList.cliente = data;
                        }, function onError(response) {
                          // Handle error
                          var data = response.data;
                          var status = response.status;
                          var statusText = response.statusText;
                          var headers = response.headers;
                          var config = response.config;
                        });

                        $scope.add = function(cod, id) {
                          console.log(cod + " " + id);
                          var path = cod + ".html";
                          var get = "get" + cod.substring(3);
                          console.log(cod + " " + get);
                          $mdDialog.show({
                            controllerAs: 'impiantiList',
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
                              $scope.aggiungiAmbiente = function(impiantiList) {
                                console.log("AGGIUNGI");
                                console.log(impiantiList.nomeAmbiente);
                                $http.post('/php/ImpiantiServices.php', {
                                  cod: "addAmbiente",
                                  nomeAmbiente: impiantiList.nomeAmbiente,
                                  idImpianto: sharedProperties.getIdImpianto()
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
                                  $http.post('/php/ImpiantiServices.php', {
                                    cod: "getAutorizzazioni",
                                    id: sharedProperties.getIdImpianto()
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
                                    $mdDialog.hide();
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
                              $scope.installaSensore = function(impiantiList) {
                                console.log("INSTALLA");
                                console.log(impiantiList.nomeSensore);
                                console.log(impiantiList.nomeAmbiente);
                                $http.post('/php/ImpiantiServices.php', {
                                  cod: "addSensore",
                                  nome: impiantiList.nomeSensoreInstallato,
                                  idSensore: sharedProperties.getIdSens(),
                                  idAmbiente: sharedProperties.getIdAmbiente(),
                                  idImpianto: sharedProperties.getIdImpianto()
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
                                  $http.post('/php/ImpiantiServices.php', {
                                    cod: "getAutorizzazioni",
                                    id: sharedProperties.getIdImpianto()
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
                                    $mdDialog.hide();
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
                              $scope.select = function(cod) {
                                console.log(cod + " ");
                                var path = cod + "List.html";
                                var get = "get" + cod;
                                console.log(cod + " " + get);
                                $mdDialog.show({
                                  controllerAs: 'impiantiList',
                                  clickOutsideToClose: true,
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
                                    $http.post('/php/ImpiantiServices.php', {
                                      cod: get,
                                      id: sharedProperties.getIdImpianto()
                                    }, {
                                      headers: {
                                        'Content-Type': 'application/json'
                                      }
                                    })
                                    .then(function onSuccess(response) {
                                      // Handle success
                                      var data = response.data;
                                      var status = response.status;
                                      var statusText = response.statusText;
                                      var headers = response.headers;
                                      var config = response.config;
                                      console.log(data);
                                      $scope.list_imp = data;

                                      $scope.setSensore = function(id, sensore) {
                                          console.log(sensore);
                                          sharedProperties.setIdSens(id);
                                          $scope.parent.impiantiList.nomeSensore = sensore;
                                          $mdDialog.hide();
                                      };
                                      $scope.setAmbiente = function(id, ambiente) {
                                          console.log(ambiente);
                                          sharedProperties.setIdAmbiente(id);
                                          $scope.parent.impiantiList.nomeAmbiente = ambiente;
                                          $mdDialog.hide();
                                      };

                                    });
                                  }
                              })};
                              //LISTA IMPIANTI _ AMBIENTI _ SENSORI
                              $http.post('/php/ImpiantiServices.php', {
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
                                $scope.edit = function(cod, aut, id) {
                                  //ADDIMPIANTO _ AMBIENTE _ SENSORE
                                  $http.post('/php/ImpiantiServices.php', {
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
                                    $http.post('/php/ImpiantiServices.php', {
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
                          });
                        };
                        $scope.editImpianto = function(cod, id) {
                          console.log("Sadad");
                          var path = "edit" + cod + ".html";
                          var get = "get" + cod.substring(3);
                          console.log(cod + " " + get);
                                    $mdDialog.show({
                                      controllerAs: 'impiantiList',
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
                                        if (cod == "Ambiente") {
                                          $http.post('/php/ImpiantiServices.php', {
                                              cod: "getNomeAmbiente",
                                              id: sharedProperties.getIdAmbiente()
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
                                                $scope.impiantiList.nomeAmbiente = data;
                                              }, function onError(response) {
                                                // Handle error
                                                var data = response.data;
                                                var status = response.status;
                                                var statusText = response.statusText;
                                                var headers = response.headers;
                                                var config = response.config;
                                              });
                                        } else if (cod == "Sensore") {
                                          $http.post('/php/ImpiantiServices.php', {
                                              cod: "getSensoreInstallato",
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
                                                $scope.impiantiList.id = angular.fromJson(data).id;
                                                $scope.impiantiList.nomeSensoreInstallato = angular.fromJson(data).nome;
                                                $scope.impiantiList.idAmbiente = angular.fromJson(data).idAmbiente;
                                                $scope.impiantiList.idSensore = angular.fromJson(data).idSensore;
                                                $scope.impiantiList.idImpianto = angular.fromJson(data).idImpianto;
                                                sharedProperties.setIdSens(angular.fromJson(data).idSensore);
                                                sharedProperties.setIdAmbiente(angular.fromJson(data).idAmbiente);
                                                sharedProperties.setIdImpianto(angular.fromJson(data).idImpianto);

                                                $http.post('/php/ImpiantiServices.php', {
                                                    cod: "getNomeAmbiente",
                                                    id: $scope.impiantiList.idAmbiente
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
                                                      $scope.impiantiList.nomeAmbiente = data;
                                                    }, function onError(response) {
                                                      // Handle error
                                                      var data = response.data;
                                                      var status = response.status;
                                                      var statusText = response.statusText;
                                                      var headers = response.headers;
                                                      var config = response.config;
                                                    });
                                                    $http.post('/php/ImpiantiServices.php', {
                                                        cod: "getNomeSensore",
                                                        id: $scope.impiantiList.idSensore
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
                                                          $scope.impiantiList.nomeSensore = data;
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
                                        }
                                        $scope.modificaAmbiente = function(cod, impiantiList) {
                                          console.log("AGGIUNGI");
                                          console.log(impiantiList.nomeAmbiente);
                                          $http.post('/php/ImpiantiServices.php', {
                                            cod: cod + "Ambiente",
                                            id: id,
                                            nomeAmbiente: impiantiList.nomeAmbiente,
                                            idImpianto: sharedProperties.getIdImpianto()
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
                                            $http.post('/php/ImpiantiServices.php', {
                                              cod: "getAutorizzazioni",
                                              id: sharedProperties.getIdImpianto()
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
                                              $mdDialog.hide();
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
                                        $scope.modificaSensore = function(cod, impiantiList) {
                                          $http.post('/php/ImpiantiServices.php', {
                                            cod: cod + "Sensore",
                                            id: id,
                                            nome: impiantiList.nomeSensoreInstallato,
                                            idSensore: sharedProperties.getIdSens(),
                                            idAmbiente: sharedProperties.getIdAmbiente(),
                                            idImpianto: impiantiList.idImpianto,
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
                                            $http.post('/php/ImpiantiServices.php', {
                                              cod: "getAutorizzazioni",
                                              id: sharedProperties.getIdImpianto()
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
                                              $mdDialog.hide();
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
                                        $scope.select = function(cod) {
                                          console.log(cod + " ");
                                          var path = cod + "List.html";
                                          var get = "get" + cod;
                                          console.log(cod + " " + get);
                                          $mdDialog.show({
                                            controllerAs: 'impiantiList',
                                            clickOutsideToClose: true,
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
                                              $http.post('/php/ImpiantiServices.php', {
                                                cod: get,
                                                id: sharedProperties.getIdImpianto()
                                              }, {
                                                headers: {
                                                  'Content-Type': 'application/json'
                                                }
                                              })
                                              .then(function onSuccess(response) {
                                                // Handle success
                                                var data = response.data;
                                                var status = response.status;
                                                var statusText = response.statusText;
                                                var headers = response.headers;
                                                var config = response.config;
                                                console.log(data);
                                                $scope.list_imp = data;

                                                $scope.setSensore = function(id, sensore) {
                                                    console.log(sensore);
                                                    sharedProperties.setIdSens(id);
                                                    $scope.parent.impiantiList.nomeSensore = sensore;
                                                    $mdDialog.hide();
                                                };
                                                $scope.setAmbiente = function(id, ambiente) {
                                                    console.log(ambiente + id);
                                                    sharedProperties.setIdAmbiente(id);
                                                    $scope.parent.impiantiList.nomeAmbiente = ambiente;
                                                    $mdDialog.hide();
                                                };

                                              });
                                            }
                                        })};
                                        //LISTA IMPIANTI _ AMBIENTI _ SENSORI
                                        $http.post('/php/ImpiantiServices.php', {
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
                                          $scope.edit = function(cod, aut, id) {
                                            //ADDIMPIANTO _ AMBIENTE _ SENSORE
                                            $http.post('/php/ImpiantiServices.php', {
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
                                              $http.post('/php/ImpiantiServices.php', {
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
                                    });
                        };
                        $scope.edit = function(cod, aut, id) {
                          //DELETEIMPIANTO _ AMBIENTE _ SENSORE
                          $http.post('/php/ImpiantiServices.php', {
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
                            $http.post('/php/ImpiantiServices.php', {
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

                        $http.post('/php/ImpiantiServices.php', {
                          cod: "getAutorizzazioni",
                          id: angular.fromJson(_impianto).id
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
                    controllerAs: 'impiantiList',
                    preserveScope: true,
                    templateUrl: 'modifica_impianto.html',
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
                      $http.post('/impianti.php', {
                        cod: $cod,
                        id: angular.fromJson(_impianto).id,
                        nome: answer.nome,
                        tipo: answer.tipo,
                        idCliente: sharedProperties.getIdCliente(),
                      }, {
                        headers: {
                          'Content-Type': 'application/json'
                        }
                      })
                  .then(function onSuccess(response) {
                        // Handle success
                        var data = response.data;
                        var status = response.status;
                        var statusText = response.statusText;
                        var headers = response.headers;
                        var config = response.config;
                        console.log(angular.fromJson(_impianto).id);
                      //  console.log(data);
                        console.log(sharedProperties.getIdCliente());
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
  .controller('SensoriCtrl',function($scope, $mdDialog, $mdMedia, $http, $route, $templateCache, $routeParams) {
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
                      $http.post('/sensori.php', {
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
                          $http.post('/sensori.php', {
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
              });
