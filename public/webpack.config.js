var webpack = require("webpack");
var path = require("path");

module.exports = {
  entry: {
    home: "./js/index.js",
    my: "./js/my.js",
    search: "./js/search.js",
    user: "./js/user.js",
    view: "./js/view-question.js",
    write: "./js/write-question.js",
    login: "./js/login.js",
    signup: "./js/signup.js"
  },

  output: {
    path: __dirname + "/dist/js/",
    filename: "[name].js"
  },

  module: {
    loaders: [
      {
        test: /\.js$/,
        loader: "babel-loader",
        exclude: /node_modules/,
        query: {
          cacheDirectory: true,
          presets: ["env"]
        }
      }
    ]
  },

  // plugins: [
  //   new webpack.optimize.UglifyJsPlugin({
  //     compress: {
  //       warnings: false
  //     }
  //   })
  // ],

  resolve: {
    modules: ["node_modules"],
    alias: {
      handlebars: "handlebars/dist/handlebars.min",
    }
  }
};

