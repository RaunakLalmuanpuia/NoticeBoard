import Vue from 'vue'
import './plugins/axios'
import App from './App.vue'
import router from './router'
import store from './store'
import vuetify from './plugins/vuetify';
import * as VueGoogleMaps from 'vue2-google-maps'
import axios from "./plugins/axios";
import auth from "./plugins/auth";
import VueYoutube from 'vue-youtube';
import VueBarcodeScanner from 'vue-barcode-scanner'

let options = {
  sensitivity: 300, // default is 100
  requiredAttr: true, // default is false
  controlSequenceKeys: ['NumLock', 'Clear'], // default is null
  callbackAfterTimeout: true // default is false
}

Vue.use(VueBarcodeScanner, options)

Vue.config.productionTip = false
Vue.prototype.$axios = axios;
Vue.prototype.$auth = auth;

Vue.use(VueYoutube);
Vue.use(VueGoogleMaps, {
  load: {
    key: 'AIzaSyCcmcAIt8iadV71e2Wx6Gj61JFceoSMtAI',
    libraries: 'places',
  }
});

new Vue({
  router,
  store,
  vuetify,
  VueGoogleMaps,
  render: function (h) { return h(App) }
}).$mount('#app')
