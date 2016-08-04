<html>
<head>
<script type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script>
function display_report()
{
	document.getElementById("report").innerHTML="<center><font><img width=\"70\" height=\"70\" src=\"loading.gif\"></center>"
	document.send.date.value
	var age = document.send.age.value
	var date = document.send.date.value
	var gender = document.send.gender.value
	var vacc_code = document.send.codes.value
	var sequence = document.send.sequence.value
	var facility = document.send.facility.value
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("report").innerHTML=xmlhttp.responseText;    
    }
  }
xmlhttp.open("GET","fetch_immunization_JSP.php?age="+age+"&gender="+gender+"&date="+date+"&vacc_code="+vacc_code+"&sequence="+sequence+"&facility="+facility,true);
xmlhttp.send();
}
$(document).ready(function () {
            $.getJSON('http://fhirtest.uhn.ca/baseDstu3/ValueSet/cvx-tz?_format=json',
                function (data) {
                    var tableData = "<option value=''>---All---";
                    for (var code in data.compose.include[0].concept)
                        tableData += "<option value='" + data.compose.include[0].concept[code].code + "'>" + data.compose.include[0].concept[code].display + "</td></tr>";
                    $('#codes').html(tableData);
                });
        });
</script>
</head>
<body>
<form action="#" name="send">
<table align="center">
<center><h1>Immunization</h1></center>
<tr><td>Age</td><td><input type="text" name="age"></td></tr>
<tr><td>Gender</td><td><select name="gender"><option value="M">Male</option><option value="F">Female</option></select></td></tr>
<tr><td>Date</td><td><input type="text" name="date"></td></tr>
<tr><td>Facility</td><td><input type="text" name="facility"></td></tr>
<tr><td>Vaccine Code</td><td><select id="codes" name="codes"></select></td></tr>
<tr><td>Sequence</td><td><input type="text" name="sequence"></td></tr>
<tr><td><input type="button" onclick="display_report()" value="View Report"></td></tr>
</table>
</form>
<div id="report">

</div>
</body>