const validation = {
	isEmpty : function(val) {
		val = String(val).trim();
		if(val != "") return true;
		return false;
	},
	isNumber : function(val) {
		let regex = /^\d+$/;
		val = String(val).trim();
		
		if(regex.test(val))	return true;
		return false;
	},
	isCharacter: function(val) {
		let regex = /^[A-Za-z]+$/;
		val = String(val).trim();
		
		if(regex.test(val))	return true;
		return false;
	},
	/*isPhoneNumber : (val) => {
		val = String(val).trim();
		let regex = /^\+?[1-9]\d{1,14}$/;
		if(regex.test(val)) return true;
		reutrn false;
	}*/
}

let temp = {
  fun: function () {
    console.log("s");
  },
  check: function () {
    this.fun(); // `this` refers to `temp`
    console.log("check");
  }
};

temp.check();
