import React from 'react'
import { Router } from '@reach/router'

import { Uploader } from '../pages/uploader'


export const App = () => (
  <Router>
    <Uploader path='/' />
  </Router>
)