import React, { useContext, useEffect, useState } from 'react'
import { Link } from '@reach/router'
import { RouteComponentProps } from '@reach/router'

import { Uploaded } from '../../components/Uploaded'
import { Loading } from '../../components/Loading'
import { Layout } from '../../layout'

import { Context } from '../../context'

export const Success = (props:RouteComponentProps) => {

  const { lastImage } = useContext(Context)
  const [url, setUrl] = useState<string>('')

  useEffect(() => {
    const getImage = async () => {
      const data = await fetch(`http://localhost:3000/api/find/${lastImage}`)
      const resp = await data.json()
      console.log(resp)
      setUrl(resp.data.url)
    }
    getImage()
  }, [])

  return (
    <Layout>
     {
       url.length > 0 ? <Uploaded url={url} /> : <Loading />
     }
      <div className="success__links">
        <Link to="/">go Back?</Link>
        <Link to="/galley">See all Images</Link>
      </div>
    </Layout>
  )
} 