import React from 'react'
import { Link } from '@reach/router'
import { RouteComponentProps } from '@reach/router'

import { Uploaded } from '../../components/Uploaded'
import { Layout } from '../../layout'

export const Success = (props:RouteComponentProps) => {

  return (
    <Layout>
      <Uploaded />
      <div className="success__links">
        <Link to="/">go Back?</Link>
        <Link to="/galley">See all Images</Link>
      </div>
    </Layout>
  )
} 