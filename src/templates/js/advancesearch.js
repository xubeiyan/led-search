var searchtype = document.getElementById('searchtype'),
	searchsubtype = document.getElementById('searchsubtype'),
	searchvalue = document.getElementById('searchvalue'),
	subtype = {
		"product_type": [{
			'index': 'LEDclip',
			'value': "LED芯片",
		},{
			'index': 'LEDdevice',
			'value': "LED器件",
		},{
			'index': 'LEDlightsource',
			'value': "LED光源",
		},{
			'index': 'LEDlamps',
			'value': "LED灯具",
		}],
		"std_type": [{
			'index': 'safestd',
			'value': "安全标准",
		},{
			'index': 'methodstd',
			'value': '方法标准',
		},{
			'index': 'productstd',
			'value': '产品规范',
		}],
		"std_level": [{
			'index': 'nationalstd',
			'value': '国家标准',
		},{
			'index': 'internationalstd',
			'value': '国际标准',
		},{
			'index': 'industrystd',
			'value': '行业标准',
		},{
			'index': 'groupstd',
			'value': '团体标准',
		}],
		"publish_year": [],
		"std_status": [{
			'index': 'published',
			'value': '已发布',
		},{
			'index': 'dis',
			'value': 'DIS',
		}],
	},
	error_info = document.getElementById('errorInfo'),
	search_result = document.getElementById('searchresult'),
	searchbutton = document.getElementById('searchbutton');
	
searchtype.addEventListener('change', function() {
	var type = searchtype.value,
		subtypeHtml = '';
	// console.log(subtype[type]);
	if (subtype[type] == undefined) {
		searchsubtype.innerHTML = subtypeHtml;
		return;
	}
	for (var item of subtype[type]) {
		subtypeHtml += '<option value="' + item.index + '">' + item.value + '</option>';
	}
	searchsubtype.innerHTML = subtypeHtml;
});

searchbutton.addEventListener('click', function () {
	error_info.innerText = '';

	var xmlRequest = new XMLHttpRequest(),
		body = {
			'request': 'advancesearch',
			'search_type': searchtype.value,
			'search_subtype': searchsubtype.value,
			'keyword': searchvalue.value,
			'page': 0,
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
			}
			
		}
	}
});

window.onload = function () {
	console.log(window.location.href);
}