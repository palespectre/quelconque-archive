const path = require('path');

module.exports = {
  plugins: {
    'postcss-import': {},
    'postcss-preset-env': {
       	autoprefixer: { grid: true }
    },
    'cssnano': {},    
	'postcss-critical-css': {
		outputPath: path.resolve(__dirname, './public/wp-content/themes/boilerplate_theme/assets/css'),
	},
    'postcss-extract-media-query':{
	    output: {
	        path: path.resolve(__dirname, './public/wp-content/themes/boilerplate_theme/assets/css'), // remplacer "boilerplate_theme" par le thème actuel
	        name: '[query].css'
	    },	    
	    queries: {
	        'only screen and (min-width:36em)': 'large-mobile',
	        'only screen and (min-width:48em)': 'tablet',
	        'only screen and (min-width:64em)': 'desktop',
	        'only screen and (min-width:80em)': 'large-desktop',
	    }
	},
  },
};