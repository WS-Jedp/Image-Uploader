import React from 'react'
import ReactDOM from 'react-dom'

import '../../assets/styles/modal_error.css'

export const ErrorModal:React.FC = ({ children }) => {


  return ReactDOM.createPortal(<div className="modal">
    {
      children
    }
  </div>, window.document.getElementById('error-modal'))

}