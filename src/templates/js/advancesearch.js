var searchtype = document.getElementById('searchtype'),
	searchsubtype = document.getElementById('searchsubtype'),
	subtype = {
		"product_type": ["LED芯片","LED器件", "LED光源", "LED灯具"],
		"std_type": ["安全标准"],
	}
	
searchtype.addEventListener('change', function() {
	var type = searchtype.value;
	// console.log(subtype[type]);
	if (subtype[type] == undefined) {
		console.log('!');
		return;
	}
	//searchsubtype.innerHTML = subtype
})