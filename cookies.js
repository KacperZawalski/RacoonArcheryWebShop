var MyCookies = { 
	create : function(name, value, ttl, dom) { 
		if(ttl) { 
			var expire = new Date(); 
			expire.setTime(expire.getTime() + ttl); 
			var expires = "; expires="+expire.toGMTString(); 
		} 
		else 
			expires = ""; 
		if(dom!=undefined && dom!=""){
			document.cookie = name + "="+ value + expires + "; domain="+dom+"; path=/";
		}
		else
			document.cookie = name + "=" + value + expires + "; path=/"; 
		}, 
	read : function(name) { 
		cont = document.cookie.split('; '); 
		var pair = null; 
		for(i=0; i<cont.length; i++) { 
			pair = cont[i].split('='); 
			if(pair[0] == name) { 
				return pair[1]; 
			} 
		} 
		return false; 
	}, 
	erase : function(name) { 
		this.create(name, "", -1); 
	}
};
