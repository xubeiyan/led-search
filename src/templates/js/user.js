var nickname = document.getElementById('nickname'),
	email = document.getElementById('email'),
	oldpass = document.getElementById('oldpass'),
	newpass = document.getElementById('newpass'),
	confirm = document.getElementById('confirm'),
	errorInfo = document.getElementById('errorInfo'),
	successInfo = document.getElementById('successInfo'),
	submit = function () {
		if (oldpass.value == '') {
			errorInfo.innerText = '必须填写旧密码';
			return;
		}
		
		if (newpass.value == '') {
			errorInfo.innerText = '新密码不能为空';
			return;
		}
		
		if (newpass.value != confirm.value) {
			errorInfo.innerText = '两次密码不一致';
			return;
		}
		
		var xmlRequest = new XMLHttpRequest(),
			body = {
				'request': 'updateUserInfo',
				'nickname': nickname.value,
				'oldpass': oldpass.value,
				'newpass': newpass.value,
				'email': email.value,
			};
		xmlRequest.open('POST', '.');
		xmlRequest.setRequestHeader("Content-Type", "application/json");
		xmlRequest.send(JSON.stringify(body));
		
		xmlRequest.onreadystatechange = function () {
			if (xmlRequest.readyState == 4 && xmlRequest.status == 200) {
				var arrRes = JSON.parse(xmlRequest.response);
				if (arrRes.err_type) {
					errorInfo.innerText = arrRes.err_msg;
					successInfo.innerText = '';
					return;
				}
				
				if (arrRes.type == 'update_success') {
					errorInfo.innerText = '';
					successInfo.innerText = arrRes.msg;
				}
			}
		}
	}