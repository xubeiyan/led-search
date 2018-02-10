/* 登录页面 */
var username = document.getElementById('username'),
	password = document.getElementById('password'),
	errInfo = document.getElementById('errorInfo'),
	submit = function () {
		var retMsg = validate();
		if (retMsg == 'username empty') {
			return;
		}
		
		if (retMsg == 'password empty') {
			return;
		}
		var xmlRequest = new XMLHttpRequest(),
			body = {
				'request': 'login',
				'username': username.value,
				'password': password.value,
			};
		xmlRequest.open('POST', '.');
		xmlRequest.setRequestHeader("Content-Type", "application/json");
		xmlRequest.send(JSON.stringify(body));
		
		xmlRequest.onreadystatechange = function () {
			if (xmlRequest.readyState == 4 && xmlRequest.status == 200) {
				var arrRes = JSON.parse(xmlRequest.response);
				if (arrRes.err_type) {
					errInfo.innerText = arrRes.err_msg;
					return;
				}
				
				if (arrRes.type == 'login_success') {
					window.location.href = '.';
				}
			}
		}
	},
	reset = function () {
		username.value = '';
		password.value = '';
		errInfo.innerText = '';
	},
	validate = function () {
		if (username.value == '') {
			errInfo.innerText = '用户名不能为空';
			return 'username empty';
		}
		
		if (password.value == '') {
			errInfo.innerText = '密码不能为空';
			return 'password empty';
		}
	}
	
password.addEventListener('keypress', function(e) {
	if (e.code == 'Enter') {
		submit();		
	}
})