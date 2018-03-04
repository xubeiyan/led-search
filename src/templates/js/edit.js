var entityid = document.getElementById('entityid'),
	stdnum = document.getElementById('stdnum'),
	stdlevel = document.getElementById('stdlevel'),
	category = document.getElementById('category'),
	chname = document.getElementById('chname'),
	enname = document.getElementById('enname'),
	releasedate = document.getElementById('releasedate'),
	impelementdate = document.getElementById('impelementdate'),
	stdstatus = document.getElementById('stdstatus'),
	alterstandard = document.getElementById('alterstandard'),
	adoptno = document.getElementById('adoptno'),
	adoptname = document.getElementById('adoptname'),
	adoptlev = document.getElementById('adoptlev'),
	adopttype = document.getElementById('adopttype'),
	ics = document.getElementById('ics'),
	ccs = document.getElementById('ccs'),
	standardtype = document.getElementById('standardtype'),
	producttype = document.getElementById('producttype'),
	departcharge = document.getElementById('departcharge'),
	departresponse = document.getElementById('departresponse'),
	announcenum = document.getElementById('announcenum'),
	ctnlink = document.getElementById('ctnlink'),
	abstractText = document.getElementById('abstract'),
	submitbutton = document.getElementById('submit');

submitbutton.addEventListener('click', function () {
	var xmlRequest = new XMLHttpRequest(),
		body = {
			'request': 'edit',
			'entityid': entityid.innerText,
			'stdnum': stdnum.value,
			'category': category.value,
			'chname': chname.value,
			'enname': enname.value,
			'releasedate': releasedate.value,
			'impelementdate': impelementdate.value,
			'stdstatus': stdstatus.value,
			'alterstandard': alterstandard.value,
			'adoptno': adoptno.value,
			'adoptname': adoptname.value,
			'adoptlev': adoptlev.value,
			'adopttype': adopttype.value,
			'ics': ics.value,
			'ccs': ccs.value,
			'standardtype': standardtype.value,
			'producttype': producttype.value,
			'departcharge': departcharge.value,
			'departresponse': departresponse.value,
			'announcenum': announcenum.value,
			'ctnlink': ctnlink.value,
			'abstractText': abstractText.value,
		};
		
	xmlRequest.open('POST', '.');
	xmlRequest.setRequestHeader("Content-Type", "application/json");
	xmlRequest.send(JSON.stringify(body));
	
	xmlRequest.onreadystatechange = function () {
		if (xmlRequest.readyState == 4 && xmlRequest.status == 200) {
			var arrRes = JSON.parse(xmlRequest.response);
			if (arrRes.type == 'update_success') {
				window.location.href="?view&entityid=" + entityid.innerText;
			}
		}
	}
});