import React, { createContext, useState } from 'react'

type State = {
  lastImage?: string | null;
  setLastImage: Function; 
}

export const Context = createContext<State>({lastImage: null, setLastImage: () => {}})

export const Provider:React.FC = ({ children }) => {

  const [lastImage, setLastImage] = useState<string | null>(null)

  const state:State = {
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