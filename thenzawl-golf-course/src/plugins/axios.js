import axios from "axios";
import decode from "jwt-decode";

const instance = axios.create({
  headers: { "X-Requested-With": "XMLHttpRequest" },
  baseURL: "http://localhost:8000/api/",
  // baseURL: "https://thenzawlgolfresort.com/api/"
});

instance.interceptors.request.use(
  config => {
    let originalRequest = config;
    if (
      typeof localStorage.thenzawl_golf_resort_token === "undefined" ||
      localStorage.thenzawl_golf_resort_token === "undefined"
    ) {
      return config;
    }

    let token = decode(localStorage.thenzawl_golf_resort_token);
    if (token.exp <= new Date().getTime() / 1000) {
      return axios
        .post(
          "/oauth/token/refresh",
          { token: localStorage.thenzawl_golf_resort_token },
          {
            headers: {
              Authorization: "Bearer " + localStorage.thenzawl_golf_resort_token
            }
          }
        )
        .then(res => {
          originalRequest.headers.Authorization = "Bearer " + res.data.token;
          localStorage.thenzawl_golf_resort_token = res.data.token;
          return Promise.resolve(originalRequest);
        });
    }
    config.headers.Authorization =
      "Bearer " + localStorage.thenzawl_golf_resort_token;
    // let user = JSON.parse(localStorage.thenzawl_golf_resort_user)
    return config;
  },
  err => {
    return Promise.reject(err);
  }
);

export default instance;
