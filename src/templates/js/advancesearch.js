var searchtype = document.getElementById('type'),
	searchsubtype = document.getElementById('subtype'),
	searchcountrytype = document.getElementById('countrytype'),
	searchvalue = document.getElementById('searchvalue'),
	searchtypetext = ['uncertain', 'general','material','candd','light','other'],
	searchcountrytypetext = ['uncertain', 'na', 'in'],
	type = {
		'general': [{index: 'uncertain', text: '未指定'}],
		'material': [
			{index: 'uncertain', text: '未指定'},
			{index: 'standard', text: '材料通用标准'}, 
			{index: 'substrate', text: '衬底材料'},
			{index: 'light_m', text: '发光材料'},
		],
		'candd': [
			{index: 'uncertain', text: '未指定'},
			{index: 'wafer', text: '外延片'},
			{index: 'chip', text: '芯片'},
			{index: 'device', text: '器件'},
		],
		'light': [
			{index: 'uncertain', text: '未指定'},
			{index: 'led_module', text: 'LED模块'},
			{index: 'led_light_source', text: 'LED光源'},
			{index: 'lamp_annex', text: '灯用附件'},
			{index: 'lamp_holder_and_socket', text: '灯头灯座'},
			{index: 'lamps', text: '灯具'},
			{index: 'light_system', text: '照明系统'},
		],
		'other': [{index: 'uncertain', text: '未指定'}],
	},
	currentPage = 0,
	error_info = document.getElementById('errorInfo'),
	search_result = document.getElementById('searchresult'),
	searchbutton = document.getElementById('searchbutton'),
	makeResultTable = function (resultArray) {
		var resultHTML = '<table><tr class="header"><td>序号</td><td>标准编号</td><td>中文名称</td><td>英文名称</td></tr>';
		for (var line of resultArray) {
			resultHTML += '<tr class="focus" onclick="window.location.href=\'?view&entityid=' + line['ArchId'] + '\'"><td>' + line['ArchId'] + '</td><td>' + line['StdNum'] + '</td><td>' + line['ChName'] + 
				'</td><td>' + line['EnName'] + '</td></tr>'; 
		}
		resultHTML += '</table>';
		return resultHTML;
	},
	makePageNum = function (num, nextPageActive) {
		if (nextPageActive) {
			var disable = 'disabled';
		} else {
			var disable = '';
		}
		
		var returnHTML = '<div class="pagenum"><button onclick="prev()">上一页</button><span>' + (currentPage + 1) + '</span>' +
		'<button onclick="next()" ' + disable + '>下一页</button></div>';
		return returnHTML;
	},
	prev = function () {
		currentPage = currentPage == 0 ? 0 : currentPage - 1;
		searchbutton.click();
	},
	next = function () {
		currentPage = currentPage + 1;
		searchbutton.click();
	};
	
searchtype.addEventListener('change', function() {
	var typeValue = searchtype.value,
		subtypeHtml = '';
	// console.log(typeValue);
	if (type[typeValue] == undefined) {
		searchsubtype.innerHTML = subtypeHtml;
		return;
	}
	for (var item of type[typeValue]) {
		console.log(item);
		subtypeHtml += '<option value="' + item.index + '">' + item.text + '</option>';
	}
	searchsubtype.innerHTML = subtypeHtml;
});

searchbutton.addEventListener('click', function () {
	error_info.innerText = '';
	var searchTypeText = 'uncertain';
	if (searchtype.value != 'uncertain') {
		searchTypeText = searchtype.value;
		if (searchsubtype.value != 'uncertain') {
			searchTypeText = searchsubtype.value;
		}
	}

	var xmlRequest = new XMLHttpRequest(),
		body = {
			'request': 'advancesearch',
			'searchtype': searchTypeText,
			'country': searchcountrytype.value,
			'keyword': searchvalue.value,
			'page': currentPage,
		};
		
	xmlRequest.open('POST', '.');
	xmlRequest.setRequestHeader("Content-Type", "application/json");
	xmlRequest.send(JSON.stringify(body));
		
	xmlRequest.onreadystatechange = function () {
		if (xmlRequest.readyState == 4 && xmlRequest.status == 200) {
			var arrRes = JSON.parse(xmlRequest.response);
			if (arrRes.found_result == 0) {
				search_result.innerText = '什么都没找到';
			} else {
				search_result.innerHTML = makeResultTable(arrRes.results);
				var nextPageActive = arrRes.perPage > arrRes.found_result ? 'false' : 'true';
				search_result.innerHTML += makePageNum(currentPage, nextPageActive);
			}
			
		}
	}
});

window.onload = function () {
	// console.log(window.location.search);
	var params = window.location.search.split('&'),
		advancesearch, searchTypeText = '', autosearch = false;
	for (var param of params) {
		if (param.split('=')[0] == 'advancesearch') {
			advancesearch = 'advancesearch';
		} else if (param.split('=')[0] == 'type') {
			searchTypeText = param.split('=')[1];
		} else if (param.split('=')[0] == 'autosearch') {
			autosearch = true;
		}
	}
	if (searchTypeText == '') {
		return;
	}
	
	var country_type = searchTypeText.split(',')[0] == undefined ? -1 : searchTypeText.split(',')[0],
		search_type = searchTypeText.split(',')[1] == undefined ? -1 : searchTypeText.split(',')[1],
		search_subtype = searchTypeText.split(',')[2] == undefined ? -1 : searchTypeText.split(',')[2];
		
	// console.log(parseInt(search_type) + 1);
	// searchtype.value = type[search_type + 1]
	countrytype.value = searchcountrytypetext[parseInt(country_type) + 1];
	searchtype.value = searchtypetext[parseInt(search_type) + 1];
	// console.log(searchtype.value);
	var search_subtype_value = parseInt(search_subtype) + 1;
	// console.log(type[searchtype.value]);
	if (search_subtype == -1) {
		searchsubtype.innerHTML = '<option value="uncertain">未指定</option>';		
	} else {
		searchsubtype.innerHTML = '<option value="' + type[searchtype.value][search_subtype_value].index + '">' 
			+ type[searchtype.value][search_subtype_value].text + '</option>';		
	}
	
	if (autosearch) {
		searchbutton.click();
	}
}