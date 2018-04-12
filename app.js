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
  .service('sharedProperties', function() {
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
  });
