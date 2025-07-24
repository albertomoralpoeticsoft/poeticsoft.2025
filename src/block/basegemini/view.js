import React from 'react'
import { createRoot } from 'react-dom/client'
import { Provider } from 'react-redux'
import { store } from './app/store/store'

import APP from './app/app'
import './view.scss'

document.addEventListener('DOMContentLoaded', () => {

  const items = document.getElementsByClassName('wp-block-poeticsoft-basegemini')
  Array
  .from(items)
  .forEach(
    (element, index) => {

      const attributes = {}
      for (const child of element.children) {

        const key = child.className
        const value = child.textContent.trim()

        attributes[key] = value
      }

      const root = createRoot(element)

      root.render(
        <Provider store={ store }>
          <APP { ...attributes } />
        </Provider>
      )
    }
  )
})