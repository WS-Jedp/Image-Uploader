import React from 'react'
import '../../assets/styles/modal_error.css'



type ErrorContainerProps = {
  children?: React.ReactNode;
  title?: string;
  message?: string | Boolean;
  code?: Number;
  closeError: Function;
}

export const ErrorContainer = ({ title, message, closeError }:ErrorContainerProps) => {

  return (
    <div className="error-modal">
      <div className="error-modal-title">
        <h3>
          {
            title
          }
        </h3>
        <span className="close-error" onClick={() => closeError()}>
          X
        </span>
      </div>
      <p>
        {
          message
        }
      </p>

    </div>
  )

}