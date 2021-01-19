import React from 'react'
import '../../assets/styles/loading.css'

export const Loading:React.FC = () => {

  return (
    <div className="loading__component">
      <h4 className="loading__title">
        Loading...
      </h4>
      <div className="loading">
        <div className="loading__bar"></div>
      </div>
    </div>
  )
}