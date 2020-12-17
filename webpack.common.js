const path = require('path');
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const CopyWebpackPlugin = require('copy-webpack-plugin');
const imageminMozjpeg = require('imagemin-mozjpeg');
const ImageminPlugin = require('imagemin-webpack-plugin').default;
const MediaQueryPlugin = require('media-query-plugin');
const env = process.env.NODE_ENV;

module.exports = {
  entry: {
    main: './assets/js/app.js',
    admin: './assets/js/admin.js',
    ie: './assets/js/ie.js',
  },
  output: {
    filename: 'js/[name].js',
    path: path.resolve(__dirname, './public/wp-content/themes/boilerplate_theme/assets') // remplacer "boilerplate_theme" par le thème actuel
  },
  module: {
    rules: [
      {
        test: /\.js$/,
        exclude: path.resolve(__dirname, "node_modules"),
        use: {
          loader: "babel-loader",
          options: {
            presets: ['@babel/preset-env']
          }
        }
      },
      {
        test: /\.(sa|sc|c)ss$/,
        exclude: /node_modules/,
        use: [  
            MiniCssExtractPlugin.loader,
          {
              loader: 'css-loader',
              options: { 
                sourceMap: true,
                url:false
              }
          },
          "postcss-loader",          
          {
              loader: 'sass-loader',
              options: { sourceMap: true }
          }]
      },
      {
        test: /\.(ttf|eot|woff|woff2)$/,
        use: {
          loader: "file-loader",
          options: {
            name: "fonts/[name].[ext]",
          },
        },
      },
    ]
  },

  plugins: [
  
    new CopyWebpackPlugin([
      {
        from: './assets/img/dist',
        to: path.resolve(__dirname, './public/wp-content/themes/boilerplate_theme/assets/img') // remplacer "boilerplate_theme" par le thème actuel
      },
      {
        from: './assets/fonts',
        to: path.resolve(__dirname, './public/wp-content/themes/boilerplate_theme/assets/fonts') // remplacer "boilerplate_theme" par le thème actuel
      }
    ]),  
    new ImageminPlugin({
      pngquant: ({quality: '80-90'}),
      plugins: [imageminMozjpeg({quality: 80})],
      svgo: {
        plugins:[{cleanupIDs:false}]
      }
    }),
    new MiniCssExtractPlugin({
      filename: 'css/[name].css',
      allChunks: true,
    }),
  ],
};