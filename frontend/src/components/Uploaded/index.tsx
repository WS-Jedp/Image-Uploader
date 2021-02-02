import React, {useEffect, useState} from 'react'
import '../../assets/styles/uploaded.css'

import { Clipboard } from '../Clipboard'

import ExampleImage from '../../assets/images/drop_image.png'

export const Uploaded = ({url}:{url:string}) => {

  return (
    <article className="uploaded">
      <h2 className="uploaded__title">Uploaded Succesfully!</h2>
      <img className="uploaded__image" src={url} />
      <Clipboard link={url} />
    </article>
  )
}