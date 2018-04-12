app.controller('ImpiantiCtrl', function($scope, $mdDialog, $mdMedia, $http, $route, $templateCache, $routeParams, sharedProperties) {
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
            })
          };
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
              })
            };
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
                    })
                  };
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
                    })
                  };
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
