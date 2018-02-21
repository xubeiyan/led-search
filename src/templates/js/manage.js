var submit = document.getElementById('submit'),
	info = document.getElementById('info')
	managepost = [],
	selectchange = function (id, value) {
		for (var item of managepost) {
			if (item.id == id) {
				item.value = value;
				return;
			}
		}
		managepost.push({id: id, value: value});
	},
	topage = function(page) {
		window.location.href = "?manage&page=" + page;
	}
	

submit.addEventListener('click', function () {
	info.innerHTML = '';
	if (managepost.length == 0) {
		info.innerHTML = '未作任何修改';
		return;
	}
	var xmlRequest = new XMLHttpRequest(),
		body = {
			'request': 'updateUserTable',
			'update': managepost,
		};
		xmlRequest.open('POST', '.');
		xmlRequest.setRequestHeader("Content-Type", "application/json");
		xmlRequest.send(JSON.stringify(body));
		
	xmlRequest.onreadystatechange = function () {
		if (xmlRequest.readyState == 4 && xmlRequest.status == 200) {
			var res = JSON.parse(xmlRequest.response);
			info.innerHTML = res.msg;
		}
	}
});

