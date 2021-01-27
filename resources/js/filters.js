import Vue from 'vue'

Vue.filter('textShort',function(text, length, suffix){
	if(text.length > length){
		return text.substring(0, length)+suffix;
	}else{
		return text.substring(0, length);
	}
	
})