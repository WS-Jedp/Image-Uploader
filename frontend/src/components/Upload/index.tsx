import React, {useState, useCallback, useRef} from 'react'
import { useDropzone } from 'react-dropzone'

import DropImage from '../../assets/images/drop_image.png'
import '../../assets/styles/upload.css'

export const Upload = ({setLoading}:{setLoading: Function}) => {

  const formRef = useRef<HTMLFormElement | null>(null)
  const onDrop = useCallback(async acceptedFiles => {
    setLoading(true);
    const formData = new FormData()
    formData.append('image', acceptedFiles[0], acceptedFiles[0].name)
    const data = await fetch('http://localhost:3000/image/create', {
      method: 'POST',
      headers: new Headers({
        'Access-Control-Allow-Origin': 'http://localhost:8000',
        'Content-Type': 'multipart/form-data; boundary=<calculated when request is sent></calculated>'
      }),
      mode: 'no-cors',
      body: formData
    })
    const resp = await data.json()
    console.log(resp)
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