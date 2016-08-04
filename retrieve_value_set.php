<?php 


function create_option_list($server,$vs_id,$cs_id =false) {
    $codes = array();
    if ($cs_id) {
        $cs_url = $server . '/CodeSystem/' . $cs_id . '?_format=json';
        $cs_json = json_decode(file_get_contents($cs_url),true);
        $options = array();
        if (is_array($cs_json)
            && array_key_exists('compose',$cs_json)
            && is_array($cs_json['compose'])
            && array_key_exists('include',$cs_json['compose'])
            && is_array($cs_json['compose']['include'])
            ) {
            foreach ($cs_json['compose']['include'] as $include) {
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



$options  = create_option_list("http://fhirtest.uhn.ca/baseDstu3","dhis2-bcg-gender-categories-tz","dhis2-category-options");
echo "Options:\n\t" . implode("\n\t",$options) . "\n";


