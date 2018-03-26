<script>
if (window.performance) {
  console.info("window.performance work's fine on this browser");
}
  if (performance.navigation.type == 1) {
    console.info( "This page is reloaded" );
    window.location.href = "/dashboard.php";
  } else {
    console.info( "This page is not reloaded");
  }
</script>

<div ng-cloak ng-controller="HomeCtrl">

      <div compile="listRil" style="width: 100%;"></div>

</div>
