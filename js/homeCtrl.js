app.controller('HomeCtrl', function($scope, $route, $location, $http, sharedProperties) {
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
      },
      function onError(response) {
        // Handle error
        var data = response.data;
        var status = response.status;
        var statusText = response.statusText;
        var headers = response.headers;
        var config = response.config;
      });
  }
})
