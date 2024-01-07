import axios from "./axios";

/* eslint-disable */
export default {
  login(credentials) {
    return new Promise((resolve, reject) => {
      axios
        .post("/login", credentials)
        .then(res => {
          axios.defaults.headers.common["Authorization"] =
            "Bearer " + res.data.token;
          localStorage.thenzawl_golf_resort_token = res.data.token;
          localStorage.thenzawl_golf_resort_user_name = res.data.user.name;
          localStorage.thenzawl_golf_resort_user_role = res.data.user.role;
          resolve(res.data.user);
        })
        .catch(err => {
          reject(err);
        });
    });
  },

  getUser() {
    let user = {
      user_name: localStorage.thenzawl_golf_resort_user_name,
      user_role: localStorage.thenzawl_golf_resort_user_role
    };
    return user;
  },

  logout() {
    return new Promise((resolve, reject) => {
      if (
        delete localStorage.thenzawl_golf_resort_user &&
        delete localStorage.thenzawl_golf_resort_token
      ) {
        if (localStorage.thenzawl_golf_resort_settings) {
          delete localStorage.thenzawl_golf_resort_settings;
        }
        if (localStorage.thenzawl_golf_resort_sessionId) {
          delete localStorage.thenzawl_golf_resort_sessionId;
        }
        resolve(true);
      } else {
        reject();
      }
    });
  },

  loggedIn() {
    return !!localStorage.thenzawl_golf_resort_token;
  },

  onChange() { },

  activate(token) {
    return axios.post("auth/activate", { token });
  },

  resetPassword(email) {
    return axios.post("auth/reset-password", { email });
  },

  updatePassword(data) {
    return axios.post("auth/update-password-with-token", data);
  },

  parseJsonOrString(string) {
    try {
      return JSON.parse(string);
    } catch (e) {
      return string;
    }
  }
};