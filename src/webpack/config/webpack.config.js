const
	webpack = require('webpack'),
	webpackBaseConfig = require('./webpack.config.base'),
	path = require('path'),
	fs = require('fs'),
	merge = require('webpack-merge'),
	EventHooksPlugin = require('event-hooks-webpack-plugin'),
	CompressionPlugin = require('compression-webpack-plugin');

module.exports = (env, argv) => {

	const config = require(`./${argv.env}`);

	if (!config) {
		console.log('Missing site_ config');
		return false;
	}

	const webpackConfig = merge.smart({

		output: {
			filename      : '[name].[contenthash].js',
			libraryTarget : 'umd',
			library       : config.js.filename.main,
			umdNamedDefine: false,
			path          : path.resolve(__dirname, config.js.path.target),
			publicPath    : config.js.path.public
		},

		plugins: [

			new EventHooksPlugin({

				beforeRun: () => {

					// make sure JS public directory exists and is clean
					const jsPath = path.resolve(__dirname, config.js.path.target);
					if (!fs.existsSync(jsPath)) {
						fs.mkdirSync(jsPath);
					}

					fs.readdirSync(jsPath, { withFileTypes: true }).forEach((file) => {

						// only remove file
						// skip directories
						if (file.isFile()) {
							fs.unlinkSync(path.resolve(__dirname, `${config.js.path.target}/${file.name}`), (err) => {
								if (err) {
									throw err;
								}
							});
						}
					});
				},

				done: () => {

					// Remove hash from 'main' and 'common-vendor' JS file names
					// hash handling for both files is done by Typo3
					const files = fs.readdirSync(path.resolve(__dirname, config.js.path.target));
					files.filter((file) => {
						return file.match(new RegExp(`(${config.js.filename.main}|${config.js.filename.commonVendor}).(.?([^".]*)).(js)`, 'g'));
					}).forEach((file) => {
						const name = file.split('.')[0];
						const fileType = file.match(/(\.js|\.js\.br|\.js\.gz)$/g)[0];
						fs.rename(path.resolve(__dirname, `${config.js.path.target}/${file}`), path.resolve(__dirname, `${config.js.path.target}/${name}${fileType}`), (err) => {
							if (err) {
								throw err;
							}
							console.log(`renamed ${name}${fileType} complete`);
						});
					});
				}
			})
		]
	}, webpackBaseConfig(config));


	if (argv.mode === 'production') {
		// generate static gzip and brotli version
		webpackConfig.plugins.push(
			new CompressionPlugin({
				filename : '[path][base].gz',
				algorithm: 'gzip',
				test     : /\.js$|\.css$/,
				minRatio : 0.7
			}),
			new CompressionPlugin({
				filename : '[path][base].br',
				algorithm: 'brotliCompress',
				test     : /\.js$|\.css$/,
				minRatio : 0.7
			})
		);
	}

	return webpackConfig;
};
