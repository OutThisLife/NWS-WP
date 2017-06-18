module.exports = function(obj, src, callback) {
	if (!window[obj]) {
		let s = document.createElement('script')
		s.src = src
		s.async = true

		s.onreadystatechange = s.onload = callback
		document.querySelector('head').appendChild(s)
	}

	else callback()
}