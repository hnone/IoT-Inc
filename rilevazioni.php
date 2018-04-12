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

  window.onload = function () {
    angular.element(document.getElementById('RilevazioniCtrlID')).scope().generateGraph($('#date-start').bootstrapMaterialDatePicker().val(), $('#date-end').bootstrapMaterialDatePicker().val());
  }

  $('#date-end').bootstrapMaterialDatePicker({ weekStart : 0, format : 'DD/MM/YYYY', currentDate: new Date(), time: false, cancelText : 'CANCELLA'})
    .on('change', function(e, date) {
      console.log("DATE_START: " +  $('#date-start').bootstrapMaterialDatePicker().val());
      console.log("DATE_END: " + $('#date-end').bootstrapMaterialDatePicker().val());
      angular.element(document.getElementById('RilevazioniCtrlID')).scope().generateGraph($('#date-start').bootstrapMaterialDatePicker().val(), $('#date-end').bootstrapMaterialDatePicker().val());
    });
  $('#date-start').bootstrapMaterialDatePicker({ weekStart : 0, format : 'DD/MM/YYYY', currentDate: new Date(), time: false, cancelText : 'CANCELLA'})
    .on('change', function(e, date) {
      console.log("DATE_START: " +  $('#date-start').bootstrapMaterialDatePicker().val());
      console.log("DATE_END: " + $('#date-end').bootstrapMaterialDatePicker().val());
      angular.element(document.getElementById('RilevazioniCtrlID')).scope().generateGraph($('#date-start').bootstrapMaterialDatePicker().val(), $('#date-end').bootstrapMaterialDatePicker().val());
      $('#date-end').bootstrapMaterialDatePicker('setMinDate', date);
    });
</script>
<link rel="stylesheet" href="css/rilevazioni.css">
<div ng-cloak ng-controller="RilevazioniCtrl" id="RilevazioniCtrlID">

      <div compile="listRilSens" style="width: 100%;"></div>
      <section class="section--center mdl-grid mdl-grid--no-spacing mdl-shadow--2dp">
        <div class="mdl-card mdl-cell mdl-cell--12-col">
          <div class="mdl-card__supporting-text mdl-grid mdl-grid--no-spacing">
            <h4 class="mdl-cell mdl-cell--3-col">Grafico</h4>
            <div class="mdl-cell mdl-cell--9-col" id="myCol">
              <div>Dal:</div>
              <input type="text" id="date-start" placeholder="gg/mm/aa" class="datePicker">
              <div style="padding-left: 10px;">Al:</div>
              <input type="text" id="date-end" placeholder="gg/mm/aa" class="datePicker">
            </div>
          </div>
          <nvd3 options="options" data="data" class="chart"></nvd3>

        </div>
      </section>
</div>
