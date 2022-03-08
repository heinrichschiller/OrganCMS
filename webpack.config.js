const path = require('path');

module.exports = {
    mode: 'development',
    entry: './resources/js/index.js',
    output: {
        path: path.resolve(__dirname, 'public/assets/js'),
        filename: 'bundle.js',
    }
};