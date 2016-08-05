<html>
<head>
<script type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script>
function display_report()
{
	document.getElementById("report").innerHTML="<center><font><img width=\"70\" height=\"70\" src=\"../loading.gif\"></center>"
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
xmlhttp.open("GET","fetch_immunization_BCG_JSP.php?age="+age+"&gender="+gender+"&date="+date+"&vacc_code="+vacc_code+"&sequence="+sequence+"&facility="+facility,true);
xmlhttp.send();
}
$(document).ready(function () {
            $.getJSON('http://fhirtest.uhn.ca/baseDstu3/ValueSet/cvx-tz?_format=json',
                function (data) {
                    var tableData = "";
                    for (var code in data.compose.include[0].concept) {
                    		if(data.compose.include[0].concept[code].display=="BCG")
                        tableData += "<option value='" + data.compose.include[0].concept[code].code + "'>" + data.compose.include[0].concept[code].display + "</td></tr>";
                     }
                    $('#codes').html(tableData);
                });
        });
</script>
</head>
<body>
<form action="#" name="send">
<table align="center">
<center><h1>Report BCG Vaccine Count To DHIS2</h1></center>
<tr><td>Age</td><td>
<select name="age">
<?php
$options  = create_option_list("http://fhirtest.uhn.ca/baseDstu3","dhis2-bcg-age-categories-tz","dhis2-category-options");
echo implode("\n",$options);
?>
</select>
</td></tr>
<tr><td>Gender</td><td><select name="gender">
<?php
$options  = create_option_list("http://fhirtest.uhn.ca/baseDstu3","dhis2-bcg-gender-categories-tz","dhis2-category-options");
echo implode("\n",$options);
?>
</select></td></tr>
<tr><td>Start Date</td><td><input type="text" name="date" value="2016-04-1"></td></tr>
<tr><td>End Date</td><td><input type="text" name="edate" value="2016-06-30"></td></tr>
<tr><td>Facility</td><td><input type="text" name="facility" value="urn:uuid:2C63C30F-D4FB-3FA5-9BEA-6DA616DD8CBA"></td></tr>
<tr><td>Vaccine Code</td><td><select id="codes" name="codes"></select></td></tr>
<tr><td>Sequence</td><td><input type="text" name="sequence"></td></tr>
<tr><td><input type="button" onclick="display_report()" value="Send To DHIS"></td></tr>
</table>
</form>
<div id="report">

</div>


<?php
function create_option_list($server,$vs_id,$cs_id =false) {
    $codes = array();
    if ($cs_id) {
        $cs_url = $server . '/CodeSystem/' . $cs_id . '?_format=json';
        $cs_json = json_decode(file_get_contents($cs_url),true);
        $options = array();
        if (is_array($cs_json)
            && array_key_exists('concept',$cs_json)
            && is_array($cs_json['concept'])
            ) {
            foreach ($cs_json['concept'] as $concepty) {
                $code = $concept['code'];
                $display = $concept['display'];
                if (!$code || !$display) {
                    continue;
                }
                $codes[$code] = $display;
            }
        }
    }

    $vs_url = $server . '/ValueSet/' . $vs_id . '?_format=json';
    $vs_json = json_decode(file_get_contents($vs_url),true);
    $options = array();
    if (is_array($vs_json)
        && array_key_exists('compose',$vs_json)
        && is_array($vs_json['compose'])
        && array_key_exists('include',$vs_json['compose'])
        && is_array($vs_json['compose']['include'])
        ) {
        foreach ($vs_json['compose']['include'] as $include) {
            $system = $include['system'];
            foreach ($include['concept'] as $concept) {
                $code = $concept['code'];
                $display = $concept['display'];
                if (!$display) {
                    $display = $codes[$code];
                }
                if (!$code || !$display) {
                    continue;
                }
                $options[] =  "<option value='" . $code . "'>" . $display . "</option>";
            }
        }
    }
    return $options;
    

  }
?>
</body>
