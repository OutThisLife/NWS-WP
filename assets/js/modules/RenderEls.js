import React from 'react'
import { render } from 'react-dom'
import _ from 'lodash'

module.exports = function(toRender, elements) {
	for (var i = 0; i < elements.length; i++)
		render(toRender, elements[i])
}