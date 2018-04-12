app.controller('ChooseCtrl', function($scope, $route, $location, $http, sharedProperties) {
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
        },
        function onError(response) {
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
