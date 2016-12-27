import hoverintent from 'hoverintent'
import _ from 'lodash'

// ---------------------------------------------

module.exports = {
	bind: function($links) {
		if (_.isEmpty($links))
			return

		if (window.innerWidth > 770) {
			for (let i = 0; i < $links.length; i++) {
				hoverintent($links[i], function() {
					this.classList.add('over')
				}, function() {
					this.classList.remove('over')
				}).options({
					timeout: 200,
					interval: 50
				})
			}
		}

		else {
			for (let i = 0; i < $links.length; i++) {
				$links[i].addEventListener('click', function(e) {
					e.preventDefault()
					this.parentNode.classList.toggle('over')
				})
			}
		}
	},

	destroy: function($links) {
		for (let i = 0; i < $links.length; i++)
			hoverintent.remove($links[i])
	}
}