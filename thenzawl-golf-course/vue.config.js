module.exports = {
  chainWebpack: config => {
    config
      .plugin('html')
      .tap(args => {
        args[0].title = "Thenzawl Golf Resort";
        return args;
      })
  },
  transpileDependencies: [
    'vuetify'
  ],
  devServer: {
    proxy: "http://localhost:8000"
  },
  productionSourceMap: false,
  configureWebpack: {
    devtool: false
  },

  // output built static files to Laravel's public dir.
  // note the "build" script in package.json needs to be modified as well.
  outputDir: process.env.NODE_ENV === 'production' ? "../public/assets" : 'dist',
  publicPath: process.env.NODE_ENV === 'production' ? '/assets' : '/',
  indexPath: process.env.NODE_ENV === 'production' ? '../../resources/views/welcome.blade.php' : 'index.html'
}
