module.exports = {
  devServer: {
    proxy: "http://test:85/"
  },
  // assets
  publicPath: process.env.NODE_ENV === 'production' ? '../vue-source/athenaeum/dist/' : '/',
  // index
  indexPath: process.env.NODE_ENV === 'production' ? '../../../../views/site/index.php' : 'index.html',
  transpileDependencies: [
    "vuetify"
  ]
};
