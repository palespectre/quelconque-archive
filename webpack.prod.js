const merge = require('webpack-merge');
const common = require('./webpack.common.js');
const TerserPlugin = require('terser-webpack-plugin');
const OptimizeCssAssetsPlugin = require('optimize-css-assets-webpack-plugin');

module.exports = merge(common, {
  mode: 'production',  
  optimization: {
    minimizer: [
      new TerserPlugin({
          cache: true,
          parallel: true,
          terserOptions: {
            output: {
              comments: false,
            },
        },
      }),
      
      new OptimizeCssAssetsPlugin({
          cssProcessor: require('clean-css'),
          cssProcessorOptions: {
            level:2,
            rebase:false
          },
      })
      
    ],
  },
});