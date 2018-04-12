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
      var data = response.data;
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
          var data = response.data;
          sharedProperties.setRilevazioni(data);
          $location.path("/home");
        });
    });
  }
});
