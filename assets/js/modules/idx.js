export default (function() {
	function getIdx ($el, $all) {
		return Array.prototype.indexOf.call($all, $el)
	}
	
	return getIdx
})()