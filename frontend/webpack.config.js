const path = require('path')
const HtmlWebpackPlugin = require('html-webpack-plugin')
const TsConfigPathsWebapckPlugin = require('tsconfig-paths-webpack-plugin')

module.exports = {
  mode: 'development',
  entry: './src/index.tsx',
  output: {
    path: path.resolve(__dirname, 'dist'),
    filename: 'app.bundle.js'
  },
  devServer: {
    publicPath: '/',
    historyApiFallback: true,
    port: 8000,
    open: true
  },
  resolve: {
    plugins: [
      new TsConfigPathsWebapckPlugin(),
    ],
    extensions: ['.tsx', '.ts', '.js']
  },
  module: {
    rules: [
      {
        test: /\.(tsx|ts)/,
        exclude: /node_modules/,
        use: {
          loader: 'babel-loader'
        }
      },
      {
        test: /\.(css)/,
        exclude: /node_modules/,
        use: [
          {
            loader: 'style-loader',
          },
          'css-loader'
        ]
      }
    ]
  },
  plugins: [
    new HtmlWebpackPlugin({
      inject: true,
      template: './public/index.html',
      filename: 'index.html'
    })
  ]
}
