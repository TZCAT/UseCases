//Gives display names to dhis category option combos 
/**
 * Takes a json generated from a dhis fetch request of /dhis/api/categoryOptionCombos.json?fields=id|rename(code),name|rename(display),categoryOptions&paging=false
 * and adds the names of the category options to the category option combos
 * 
 * 
 * 
 * */
 
 
function addDisplayNamesToCategoryCombos(json){
	var newCategoryOptionCombos = [];
	for(categoryOptionComboIndex in json.categoryOptionCombos){
		var display = "";
		//loop through category options to get the names
		for(categoryOptionIndex in json.categoryOptionCombos[categoryOptionComboIndex].categoryOptions){ 
			var name = json.categoryOptionCombos[categoryOptionComboIndex].categoryOptions[categoryOptionIndex].name;
			if(categoryOptionIndex > 0){
				json.categoryOptionCombos[categoryOptionComboIndex].display += "," ;
			}
			json.categoryOptionCombos[categoryOptionComboIndex].display += name ;
		}
		delete json.categoryOptionCombos[categoryOptionComboIndex].categoryOptions;
	}
	return JSON.stringify(json);
}
