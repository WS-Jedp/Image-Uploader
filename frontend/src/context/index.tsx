import React, { createContext, useState } from 'react'

export const Context = createContext({})

export const Provider:React.FC = ({ children }) => {

  const [lastImage, setLastImage] = useState<string | null>(null)

  const state = {
    lastImage,
    setLastImage
  }

  return (
    <Context.Provider value={state}>
      {
        children
      }
    </Context.Provider>
  )
}