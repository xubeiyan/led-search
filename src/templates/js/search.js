/* 搜索 */
var search_button = document.getElementById('searchbutton'),
	search_type = document.getElementById('searchtype'),
	search_value = document.getElementById('searchvalue'),
	search_result = document.getElementById('searchresult'),
	error_info = document.getElementById('errorInfo'),
	currentPage = 0,
	makeResultTable = function (resultArray) {
		var resultHTML = '<table><tr class="header"><td>序号</td><td>标准编号</td><td>中文名称</td><td>英文名称</td></tr>';
		var startNum = 1;
		for (var line of resultArray) {
			resultHTML += '<tr class="focus" onclick="window.location.href=\'?view&entityid=' + 
				line['ArchId'] + '\'"><td>' + startNum + '</td><td>' + line['StdNum'] + '</td><td>' + line['ChName'] + 
				'</td><td>' + line['EnName'] + '</td></tr>'; 
			startNum += 1;
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
		search_button.click();
	},
	next = function () {
		currentPage = currentPage + 1;
		search_button.click();
	};

search_button.addEventListener('click', function () {
	if (search_value.value == '') {
		error_info.innerText = '搜索内容不能为空';
		return;
	} else {
		error_info.innerText = '';
	}
	
	var	xmlRequest = new XMLHttpRequest(),
		body = {
			'request': 'stdsearch',
			'search_type': search_type.value,
			'keyword': search_value.value,
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
				search_result.innerHTML += makePageNum(arrRes.page, nextPageActive);
			}
			
		}
	}
});
