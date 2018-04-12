app.controller('RilevazioniCtrl', function($scope, $route, $http, $window, $timeout, sharedProperties) {
  $scope.both = function() {
    return sharedProperties.getRilevazioniSens();
  };
  $scope.listRilSens = sharedProperties.getRilevazioniSens();
  $scope.idSens = sharedProperties.getIdSens();

  $scope.$watch('fetching', function() {
    if (!$scope.fetching) {
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
      id: $scope.idSens,
      dateFrom: dateFrom.substring(6, 10) + "-" + dateFrom.substring(3, 5) + "-" + dateFrom.substring(0, 2),
      dateTo: dateTo.substring(6, 10) + "-" + dateTo.substring(3, 5) + "-" + dateTo.substring(0, 2)
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
          margin: {
            top: 20,
            right: 20,
            bottom: 150,
            left: 55
          },
          x: function(d) {
            return d.x;
          },
          y: function(d) {
            return d.y;
          },
          showLegend: false,
          useInteractiveGuideline: false,
          duration: 300,
          focusEnable: false,
          dispatch: {
            stateChange: function(e) {
              console.log("stateChange");
            },
            changeState: function(e) {
              console.log("changeState");
            },
            tooltipShow: function(e) {
              console.log("tooltipShow");
            },
            tooltipHide: function(e) {
              console.log("tooltipHide");
            }
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
            tickFormat: function(d) {
              return d3.format('.02f')(d);
            },
            axisLabelDistance: -10
          },
          callback: function(chart) {
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
            cos.push({
              x: new Date(rilevazione.data).getTime(),
              y: parseFloat(rilevazione.valore).toFixed(2)
            });
          }
        });

        //Line chart data should be sent as an array of series objects.
        return [{
          values: cos,
          key: sharedProperties.getTipoSens(),
          color: '#364061'
        }];
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
