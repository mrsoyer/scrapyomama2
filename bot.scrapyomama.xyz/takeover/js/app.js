function reportIncident() {
  var incidentNr = $('input[name=incident]:checked').val();
  var incidentText = $("#incident-report-content").val();
  $.post("/incidents/report", { in:incidentNr, content:incidentText }, function(response) {
    $("#incident-report").modal("hide");
  });
}