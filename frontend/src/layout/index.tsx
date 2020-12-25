import React from 'react'
import '../assets/styles/layout.css'

export const Layout:React.FC = ({children}) => (
  <section className="layout">
    {
      children
    }
  </section>
)