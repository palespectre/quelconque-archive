const path = require('path');
const merge = require('webpack-merge');
const common = require('./webpack.common.js');
const WriteFilePlugin = require('write-file-webpack-plugin');

module.exports = merge(common, {
  mode: 'development',
  devtool: 'source-map',
  plugins: [
  	new WriteFilePlugin(),
  ],
});