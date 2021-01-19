import React, { useRef, useState } from 'react'
import '../../assets/styles/clipboard.css'

export const Clipboard = (props:{link:string}) => {

  const { link } = props;

  const linkTextarea = useRef<HTMLTextAreaElement | null>(null);
  const [copied, setCopy] = useState<Boolean>(false)

  const copyIntoClipboard = (ev:React.MouseEvent) => {
    ev.preventDefault()
    linkTextarea.current?.select()
    window.document.execCommand('copy')
  }

  return (
    <div className="clipboard">
      <textarea ref={linkTextarea} value={link} style={{opacity: 0, position: 'absolute'}} onCopy={() => setCopy(true)} />
      <span>
        {
          link
        }
      </span>
      <button className="clipboard__button" onClick={copyIntoClipboard}>
        Copy Link
      </button>
    </div>
  )
}