const path = require('path')

const MiniCssExtractPlugin = require('mini-css-extract-plugin')

const pluginname = 'poeticsoft-2025'
const destdir = path.join(__dirname, pluginname)
const themeplublic = '/wp-content/plugin/' + pluginname

module.exports = env => {  
                                                    
  const input = Object.keys(env)[2] || ''

  const params = input.split('-')
  const type = params[0] || 'block' // block 
  const name = params[1] || 'base' // base | etc.
  const mode = params[2] || 'dev' // dev | prod

  const paths = {
    output: destdir  + '/' + type + '/' + name,
    public: themeplublic,
    cssfilename: '[name].css'
  }
  let entry = {}
  let externals = {}  

  const wpexternals = {
    '@wordpress/element': 'wp.element',
    '@wordpress/i18n': 'wp.i18n',
    '@wordpress/blocks': 'wp.blocks'
  }

  switch (type) {

    case 'block':
      
      paths.output = destdir  + '/' + type + '/' + name + '/build'

      entry = {
        editor: './src/' + type + '/' + name + '/editor.js',
        view: './src/' + type + '/' + name + '/view.js'
      }

      externals = wpexternals

      break;
  }

  const config = {
    context: __dirname,
    stats: 'minimal',
    watch: true,
    name: 'minimal',
    entry: entry,
    output: {
      path: paths.output,
      publicPath: paths.public,
      filename: '[name].js'
    },
    mode: mode == 'prod' ? 'production' : 'development',
    devtool: mode == 'prod' ? false : 'source-map',
    module: {
      rules: [
        {
          test: /\.jsx?$/,
          exclude: /node_modules/,
          use: [          
            { 
              loader: 'babel-loader',
              options: {
                presets: [
                  '@babel/preset-env',
                  '@babel/preset-react'
                ]
              }
            }
          ]
        },
        {
          test: /\.s[ac]ss$/i,
          exclude: /node_modules/,
          use: [
            { 
              loader: MiniCssExtractPlugin.loader
            },
            {
              loader: 'css-loader'
            },
            {
              loader: 'sass-loader'
            }
          ]
        },
        {
          test: /\.css$/,
          include: /node_modules/,
          use: [
            { 
              loader: MiniCssExtractPlugin.loader
            },
            'style-loader',
            'css-loader'
          ]
        },
        // Assets
        {
          test: /\.(jpg|jpeg|png|gif|svg|woff|ttf|eot|mp3|woff|woff2|webm|mp4)$/,
          type: 'asset/resource',
          generator: {
            emit: false,
            filename: content => { 

              return content.filename.replace(pluginname, '')
            }
          }
        }
      ]
    },
    plugins: [
      new MiniCssExtractPlugin({
        filename: paths.cssfilename
      })
    ],
    resolve: {
      extensions: ['.js'],
      alias: {
        assets: path.resolve(destdir + '/assets'),       
        blocks: path.join(__dirname, pluginname, 'block'),       
        styles: path.join(__dirname, 'src', 'styles')
      }
    }
  }

  return config
}