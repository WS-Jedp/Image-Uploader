import React, { useState } from 'react'
import { RouteComponentProps } from '@reach/router'

import { Layout } from '../../layout'
import { Upload } from '../../components/Upload'

import { Loading } from '../../components/Loading'

export const Uploader = (props:RouteComponentProps) => {


  return (
    <Layout>
      <Upload />
    </Layout>
  )
}
