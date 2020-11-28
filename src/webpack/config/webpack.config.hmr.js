const
	webpack = require('webpack')
	, path = require('path')
	, merge = require('webpack-merge')
	, webpackBaseConfig = require('./webpack.config.base');


module.exports = (env, argv) => {

	let config = require(`./${argv.env}`);

	if (!config) {
		console.log('Missing site_ config');
		return false;
	}

	let webpackConfig = merge.smart({

		output: {
			filename: '[name]-hmr.js',
			libraryTarget: 'umd',
			library: config.js.filename.main,
			umdNamedDefine: false,
			path: path.resolve(__dirname, config.js.path.target),
			publicPath: `https://127.0.0.1:8080${config.js.path.public}`,
		},

		plugins: [
			new webpack.ProvidePlugin({
				$: "jquery",
				jQuery: "jquery",
				'window.$': 'jquery'
			}),
			new webpack.HotModuleReplacementPlugin(),
			new webpack.NamedModulesPlugin(),
		],

		devServer: {
			contentBase: config.js.path.public,
			hot: true,
			https: true,
			host: '127.0.0.1',
			headers: {
				'Access-Control-Allow-Origin': '*'
			}
		}
	}, webpackBaseConfig(config));

	return webpackConfig;
};
