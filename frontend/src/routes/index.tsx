import React from 'react'
import { Router } from '@reach/router'

import { Uploader } from '../pages/uploader'
import { Success } from '../pages/success'


export const App = () => (
  <Router>
    <Uploader path='/' />
    <Success path='/success' />
  </Router>
)