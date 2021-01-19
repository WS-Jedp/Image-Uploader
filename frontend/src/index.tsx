import React from 'react'
import ReactDOM from 'react-dom'

import './assets/styles/main.css'

import { Provider } from './context/index'

import { App } from './routes'

ReactDOM.render(<Provider>
    <App />
  </Provider>, window.document.getElementById('main'))
