const path = require("path");
const outputDir = path.resolve(__dirname, "js/dist");

module.exports = {
	mode: "development", 
	entry: path.resolve(__dirname, "js/index.js"), 
	devtool: "inline-source-map", 
	output: {
		path: outputDir, 
		filename: "bundle.js"
	},
	devtool: 'source-map', 
	module: {
		rules: [
			{
				test: /\.(js|jsx)$/,
				exclude: /node_modules/,
				loader: 'babel-loader', 
				options: {
					babelrc: true
				}			
			},
			{
				test: /\.(js|jsx)$/,
				use: ["source-map-loader"],
				enforce: "pre"
			}
		]
	}
}