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
		var xmlRequest = new XMLHttpRequest();
	},
	reset = function () {
		username.value = '';
		password.value = '';
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