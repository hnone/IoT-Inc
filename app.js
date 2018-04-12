var app = angular.module("MyApp", ["ngRoute", "ngMaterial", "ngMessages", "ngSanitize", "nvd3"]);
app
  .config(function($routeProvider, $locationProvider) {
    $locationProvider.hashPrefix('');
    $routeProvider
      .when('/', {
        templateUrl: '/choose.php',
        map: 'choose'
      })
      .when('/choose', {
        templateUrl: '/choose.php',
        map: 'choose'
      })
      .when('/home', {
        templateUrl: '/home.php',
        map: 'home'
      })
      .when('/clienti', {
        templateUrl: '/clienti.php',
        map: 'clienti'
      })
      .when('/impianti', {
        templateUrl: '/impianti.php',
        map: 'impianti'
      })
      .when('/sensori', {
        templateUrl: '/sensori.php',
        map: 'sensori'
      })
      .when('/rilevazioni', {
        templateUrl: '/rilevazioni.php',
        map: 'rilevazioni'
      })
      .when('/soglie', {
        templateUrl: '/soglie.php',
        map: 'soglie'
      })
      .when('/terzeParti', {
        templateUrl: '/terzeParti.php',
        map: 'terzeParti'
      })
  })
  .directive('compile', ['$compile', function($compile) {
    return function(scope, element, attrs) {
      scope.$watch(
        function(scope) {
          return scope.$eval(attrs.compile);
        },
        function(value) {
          element.html(value);
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
        nomeImpianto = value;
      },
      getIdImpianto: function() {
        return idImpianto;
      },
      setIdImpianto: function(value) {
        idImpianto = value;
      },
      getRilevazioni: function() {
        return rilevazioni;
      },
      setRilevazioni: function(value) {
        rilevazioni = value;
      },
      getIdSens: function() {
        return idSens;
      },
      setIdSens: function(value) {
        idSens = value;
      },
      getIdAmbiente: function() {
        return idAmbiente;
      },
      setIdAmbiente: function(value) {
        idAmbiente = value;
      },
      getIdCliente: function() {
        return idCliente;
      },
      setIdCliente: function(value) {
        idCliente = value;
      },
      getTipoSens: function() {
        return tipoSens;
      },
      setTipoSens: function(value) {
        tipoSens = value;
      },
      getUnitaSens: function() {
        return unitaSens;
      },
      setUnitaSens: function(value) {
        unitaSens = value;
      },
      getRilevazioniSens: function() {
        return rilevazioniSens;
      },
      setRilevazioniSens: function(value) {
        rilevazioniSens = value;
      },
      getSoglie: function() {
        return soglie;
      },
      setSoglie: function(value) {
        soglie = value;
      },
      getHomeDisplay: function() {
        return homeDisplay;
      },
      setHomeDisplay: function(value) {
        homeDisplay = value;
      },
      getSoglieDisplay: function() {
        return soglieDisplay;
      },
      setSoglieDisplay: function(value) {
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
