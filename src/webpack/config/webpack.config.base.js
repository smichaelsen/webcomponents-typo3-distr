const path = require('path');

module.exports = (config) => ({
	mode        : process.env.WEBPACK_ENV ? process.env.WEBPACK_ENV : 'development',
	entry       : [`${path.resolve(__dirname, config.js.path.source)}/${config.js.filename.main}.js`],
	// disable chunk splitting. Include it, if we need other JS stuff
	// optimization: {
	// 	splitChunks: {
	// 		cacheGroups: {
	// 			commons: {
	// 				test  : /[\\/]node_modules[\\/]/,
	// 				name  : config.js.filename.commonVendor,
	// 				chunks: 'all'
	// 			}
	// 		}
	// 	}
	// },
	module: {
		rules: [
			{
				test   : /\.js$/,
				exclude: /(node_modules)/,
				use    : {
					loader : 'babel-loader',
					options: {
						presets: ['@babel/preset-env'],
						plugins: ['@babel/plugin-transform-runtime']
					}
				}
			},
			{
				test: /\.css$/,
				use : [
					'css-loader'
				]
			},
			{
				test: /\.scss$/,
				use : [
					'css-loader',
					'sass-loader'
				]
			},
			{
				test: /\.(png|jpg|gif)$/,
				use : [
					{
						loader : 'file-loader',
						options: {
							emitFile: false
						}
					}
				]
			}
		]
	},
	resolve: {
		symlinks: true,
		alias   : {
			'@babel': path.resolve(__dirname, './../node_modules/@babel')
		}
	}
});
