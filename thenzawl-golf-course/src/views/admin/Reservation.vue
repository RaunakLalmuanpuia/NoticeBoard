<template>
  <v-container fluid ml-6 mt-6>
    <v-overlay :value="show">
      <v-progress-circular indeterminate size="64"></v-progress-circular>
    </v-overlay>
    <v-container mt-6>
      <v-card>
				<v-card-title>Make Reservation</v-card-title>
				<v-card-text>
					<v-form ref="form" v-model="valid">
						<v-row>
							<v-col>
								<v-label>
								No. of Huts Required
								</v-label>
                <v-text-field
                  solo
									:rules="[(v) => !!v || 'Please mention number of rooms required']"
									type="number"
                  class="my-input"
									min="1"
									v-model="noOfHutsRequired"
                ></v-text-field>
							</v-col>
							<v-col>
								<v-label>
								Check In
								</v-label>
                <v-text-field
                  solo
									:rules="[(v) => !!v || 'Please mention check in date']"
									type="date"
                  class="my-input"
                  label="Check In Date"
									v-model="checkIn"
                ></v-text-field>
							</v-col>
							<v-col>
								<v-label>
								Check Out
								</v-label>
                <v-text-field
                  solo
									:rules="[(v) => !!v || 'Please mention check out date']"
									type="date"
                  class="my-input"
                  label="Check Out Date"
									v-model="checkOut"
                  :min="checkIn"
                  :disabled="checkIn.length == 0"
                ></v-text-field>
							</v-col>
							<v-col>
								<v-label>
								Expected Arrival
								</v-label>
                <v-dialog
        ref="dialog"
        v-model="timePicker"
        :return-value.sync="expectedArrival"
        persistent
        width="290px"
      >
        <template v-slot:activator="{ on, attrs }">
          <v-text-field
          solo
          class="my-input"
          :rules="[(v) => !!v || 'Please select arrival time']"
            v-model="expectedArrival"
            label="Pick arrival time"
            append-icon="mdi-clock-time-four-outline"
            readonly
            v-bind="attrs"
            v-on="on"
          ></v-text-field>
        </template>
        <v-time-picker
          v-if="timePicker"
          v-model="expectedArrival"
          full-width
          format="ampm"
        >
          <v-spacer></v-spacer>
          <v-btn
            text
            color="primary"
            @click="timePicker = false"
          >
            Cancel
          </v-btn>
          <v-btn
            text
            color="primary"
            @click="$refs.dialog.save(expectedArrival)"
          >
            OK
          </v-btn>
        </v-time-picker>
      </v-dialog>
							</v-col>
						</v-row>
					</v-form>
					<p class="text-right">
        <v-btn
					@click="validate()"
          elevation="0"
          rounded
          color="#04d39b"
          class="text-white"
          >Make Reservation</v-btn
        >
      </p>
				</v-card-text>
			</v-card>
		</v-container>
		<v-container mt-6>
			<v-card>
				<v-card-title>Reservations</v-card-title>
				<v-card-text>
					<v-data-table
						:headers="headers"
						:items="orders"
						:items-per-page="5"
						class="elevation-1 text-center"
					>
					<template v-slot:[`item.ordered_item`]="{ item }">
						<ul style="list-style-type: none">
							<li v-for="(order, index) in item.ordered_item" :key="index">
								{{ order.item.name_of_item }} / {{ order.quantity }}
							</li>
						</ul>
					</template>
					<template v-slot:[`item.period`]="{ item }">
						<p v-if="item.ordered_item.length > 0">
							{{ item.ordered_item[0].date_from }}
							{{
								item.ordered_item[0].date_to != null
									? "to " + item.ordered_item[0].date_to
									: item.ordered_item[0].date_to
							}}
						</p>
					</template>
					<template v-slot:[`item.expected_arrival`]="{ item }">
						<div v-if="item.ordered_item.length != 0">
							<div v-if="item.ordered_item[0].expected_arrival != null">
								{{ (item.ordered_item[0].expected_arrival + ":00") | formatTime }}
							</div>
						</div>
					</template>
					<template v-slot:[`item.created_at`]="{ item }">
						{{ item.created_at | formatDate }}
					</template>
          <template v-slot:[`item.actions`]="{ item }">
            <v-icon small @click="deleteItem(item.order_id)"> mdi-delete </v-icon>
          </template>
					</v-data-table>
				</v-card-text>
			</v-card>
		</v-container>
    <!-- delete -->
    <v-dialog v-model="deleteDialog" max-width="290">
      <v-card>
        <v-card-title class="text-h5">
          Are you sure you want to delete this reservation?
        </v-card-title>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="green darken-1" text @click="deleteDialog = false">
            No
          </v-btn>
          <v-btn color="green darken-1" text @click="confirmDelete">
            Yes
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
	</v-container>
</template>
<script>
import moment from "moment";
export default {
	data(){
		return {
			valid: false,
			show: false,
			expectedArrival: null,
			timePicker: false,
      deleteDialog: false,
			noOfHutsRequired: 1,
      deleteId: null,
			checkIn: '',
			checkOut: '',
			headers: [
        { text: "Ticket No.", value: "order_id", sortable: false, align: 'center' },
        { text: "Order Date", value: "created_at", sortable: false, align: 'center' },
        { text: "Items / Qnty.", value: "ordered_item", sortable: false, align: 'center' },
        { text: "Period", value: "period", sortable: false, align: 'center' },
        { text: "Booking Status", value: "status", sortable: false, align: 'center' },
        { text: "Expected Arrival", value: "expected_arrival", align: 'center' },
        { text: "Actions", value: 'actions'},
      ],
      orders: [],
		}
	},
	mounted(){
		this.getReservations();
	},
	filters: {
    formatDate: function (string) {
      return moment(String(string)).format("DD/MM/YYYY");
    },
		formatTime: function (string) {
      return moment(String("2022/1/1 " + string)).format("hh:mm a");
    },
  },
	methods: {
		validate() {
      this.$refs.form.validate();
      if (this.$refs.form.validate() == true) {
        this.makeReservation();
      }
    },
		makeReservation(){
			let self = this;
			self.show = true;
			self.$axios.post('make-reservation', {
				noOfHuts: this.noOfHutsRequired,
				checkIn: this.checkIn,
				checkOut: this.checkOut,
				expectedArrival: this.expectedArrival,
			})
			.then((res) => {
				self.$emit("show-snackbar", {
					message: res.data.success,
					color: "success",
				});
				self.$refs.form.reset();
				self.noOfHutsRequired = 1;
        self.getReservations();
			})
			.catch((err) => {
				self.show = false;
				self.$emit("show-snackbar", {
					message: 'Oops! Something Went Wrong',
					color: "red",
				});
          throw err;
			});
		},
		getReservations(){
			let self = this;
			self.show = true;
			self.$axios.get('get-reservations')
			.then((res) => {
				self.orders = res.data.orders;
				self.show = false;
			})
			.catch((err) => {
				self.show = false;
				self.$emit("show-snackbar", {
					message: 'Oops! Something Went Wrong',
					color: "red",
				});
				throw err;
			});
		},
    deleteItem(id){
      this.deleteDialog = true;
      this.deleteId = id;
    },
    confirmDelete(){
      let self = this;
      self.deleteDialog = false;
      self.show = true;
      self.$axios.post('delete-reservation',{id: self.deleteId})
      .then((res) => {
        self.getReservations();
        self.show = false;
        self.$emit("show-snackbar", {
					message: res.data.success,
					color: "success",
				});
      })
      .catch((err) => {
        self.$emit("show-snackbar", {
					message: "Oops! Something Went Wrong",
					color: "red",
				});
        throw err;
      })
    }
	}
}
</script>
<style>
.text-white {
  color: white !important;
  text-transform: capitalize;
}
.custom-padding {
  margin-top: -45px;
}
</style>
