'use strict';

const path  = require('path');

module.exports = {
    module: {
        loaders: [
            {
                test: /\.jsx$/,
                include: path.join(__dirname, 'resources/assets'),
                exclude: /node_modules/,
                loader: 'babel'
            }
        ]
    },
};
