/* 搜索 */
var search_button = document.getElementById('searchbutton'),
	search_type = document.getElementById('searchtype'),
	search_value = document.getElementById('searchvalue'),
	search_result = document.getElementById('searchresult'),
	makeResultTable = function (resultArray) {
		var resultHTML = '';
		for (var line of resultArray) {
			resultHTML += line['ArchId'] + ' ' + line['StdNum'] + ' ' + line['ChName'] + ' ' + line['EnName']; 
		}
		search_result.innerHTML = resultHTML;
	}

search_button.addEventListener('click', function () {
	var xmlRequest = new XMLHttpRequest(),
		body = {
			'request': 'stdsearch',
			'search_type': search_type.value,
			'keyword': search_value.value,
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
				makeResultTable(arrRes.results);
			}
			
		}
	}
});
