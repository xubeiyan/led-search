var nickname = document.getElementById('nickname'),
	oldpass = document.getElementById('oldpass'),
	newpass = document.getElementById('newpass'),
	confirm = document.getElementById('confirm'),
	errorInfo = document.getElementById('errorInfo'),
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
	}