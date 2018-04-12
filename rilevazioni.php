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
<style>
.chart {
  width: initial !important;
  padding: 10;
}

.dtp>.dtp-content>.dtp-date-view>header.dtp-header,
	table.dtp-picker-days tr>td>a.selected{
		background-color: #364061;
	}
	.dtp div.dtp-date, .dtp div.dtp-time{
		background-color: #495370;
	}
	.svg-clock [fill='#8BC34A'] {
		fill: #495370;
	}
	.hour-hand, .minute-hand{ stroke: #364061; }
	.div.dtp-actual-year, .p10>a{ color: #fff; }
	.btn{
		padding: 10px 20px;
		text-transform: uppercase;
		background-color: #495370;
		margin-left: 10px;
		box-shadow: 0;
		border: 0;
		color: #fff;
		cursor: pointer;
  		&:hover, &:focus{
  			background-color: #495370;
  		}
  		&.dtp-btn-cancel{
  			background-color: #495370;
  		}
    }
    .dtp .p10>a {
    color: #495370;
    }
    .dtp table.dtp-picker-days tr>td>a.selected {
    background: #495370;
	}
  .dtp div.dtp-actual-year {
    color: #fff;
  }
  .datePicker {
    /*width:50%;*/
    font-size: 16px;
    width: 92px;
  }

  .material-icons {
    color: #fff !important;
  }
  
  #myCol {
    display: inline-flex;
        font-size: 18px;
        line-height: 32px;
        vertical-align: middle;
-webkit-box-align: center;
-moz-box-align: center;
-ms-flex-align: center;
-webkit-align-items: center;
align-items: center;
-webkit-box-pack: center;
-moz-box-pack: center;
-ms-flex-pack: center;
-webkit-justify-content: center;
justify-content: center;
  }
</style>
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
