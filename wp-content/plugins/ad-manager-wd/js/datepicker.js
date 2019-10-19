(function ($) {


  var dateFromGlobal, dateToGlobal;
  dateFromGlobal = $("#wd_ads_stats_from").val(),
    dateToGlobal = $("#wd_ads_stats_to").val();
  if (typeof dateFromGlobal != 'undefined') {

    $("#wd_ads_stats_from, #wd_ads_stats_to").datetimepicker({
      timepicker: false,
      format: 'Y-m-d',
      scrollInput: false,
      closeOnDateSelect: true
    });
    if (dateFromGlobal) {
      $("#wd_ads_stats_from").attr('value', dateFromGlobal.split(' ')[0]);

    }
    if (dateToGlobal) {
      $("#wd_ads_stats_to").attr('value', dateToGlobal.split(' ')[0]);
    }

  }

  var dateFromSchedule, dateToSchedule;
  dateFromSchedule = $("#wd_ads_schedules_from").val(),
    dateToSchedule = $("#wd_ads_schedules_to").val();
  if (typeof dateFromSchedule != 'undefined') {


    $("#wd_ads_schedules_from, #wd_ads_schedules_to").datetimepicker({
      timepicker: true,
      format: 'Y-m-d H:i',
      scrollInput: false,
      closeOnDateSelect: false
    });
    if (dateFromGlobal) {
      $("#wd_ads_schedules_from").attr('value', dateFromSchedule.split(' ')[0]);

    }
    if (dateToGlobal) {
      $("#wd_ads_schedules_to").attr('value', dateToSchedule.split(' ')[0]);

    }
  }


}(jQuery));