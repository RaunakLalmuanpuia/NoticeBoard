import axios from "axios";
var bookings = {
  getBookings() {
    return 'test';
  },
  save(id, status) {
    axios
      .post("/update-booking/" + id, {
        status: status,
      })
      .then(function (res) {
        return res.data.success;
      })
      .catch(function (err) {
        throw err;
      });
  },
}

export default bookings;