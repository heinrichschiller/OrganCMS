const path = require('path');

module.exports = {
    devtool: 'source-map',
    mode: 'development',
    entry: './resources/js/index.js',
    output: {
      path: path.resolve(__dirname, 'public/assets/js'),
      filename: 'bundle.js',
    },
    module: {
      rules: [
        {
          test: /\.css$/i,
          use: ["style-loader", "css-loader"],
        },
        {
          test: /\.woff(2)?(\?v=[0-9]\.[0-9]\.[0-9])?$/,
          include: path.resolve(__dirname, './node_modules/bootstrap-icons/font/fonts'),
          use: {
            loader: 'file-loader',
            options: {
              name: '[name].[ext]',
              outputPath: 'webfonts',
              publicPath: path.resolve(__dirname, 'public/assets/js/webfonts'),
              // publicPath: '../webfonts',
            },
          }
        }
      ]
    }
};