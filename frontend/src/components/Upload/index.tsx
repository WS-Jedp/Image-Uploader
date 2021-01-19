import React, {useState, useCallback, useRef, useContext} from 'react'
import { useNavigate } from '@reach/router'
import { useDropzone } from 'react-dropzone'

import { Context } from '../../context'

import DropImage from '../../assets/images/drop_image.png'
import '../../assets/styles/upload.css'

export const Upload = ({setLoading}:{setLoading: Function}) => {

  const { setLastImage } = useContext(Context)
  const navigate = useNavigate()

  const formRef = useRef<HTMLFormElement | null>(null)
  const onDrop = useCallback(async acceptedFiles => {
    setLoading(true);
    const formdata = new FormData()
    formdata.append('image', acceptedFiles[0], acceptedFiles[0].name)

    const data = await fetch('http://localhost:3000/image/create', {
      method: 'POST',
      body: formdata,
    })

    const resp = await data.json()
    
    if(resp.status === 401 || !resp) {
      setLoading(false)
      console.error(resp)
    } else if(resp.status === 201) {
      setLoading(false)
      setLastImage(resp.data.id)
      navigate('/success')
    }

  }, [])

  const { isDragActive, getInputProps, getRootProps } = useDropzone({onDrop})


  return (
    <article className="upload">
      <h2 className="upload__title">
        Upload Your Image
      </h2>
      <span className="upload__span">File should be Jpeg,Png...</span>
      <form ref={formRef} method="post" className="upload__form">
          <div {...getRootProps()} className="upload__input">
            <input name="image" id="image" {...getInputProps()} />
            <img className="upload__image" src={DropImage} />
            <span className="upload__span">
              {
                isDragActive ? ('Put the file here') : 'Drag and drop your image here.'
              }
            </span>
          </div>

          <span className="upload__span">or</span>

          <div className="upload__select" {...getRootProps()}>
            <input type="file" id="image" name="image" {...getInputProps()} />
            Choose File
          </div>
      </form>
    </article>
  )
}