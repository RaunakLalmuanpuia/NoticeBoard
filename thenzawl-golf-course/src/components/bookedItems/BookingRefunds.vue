<template>
    <v-card flat>
        <v-card-title>
            <v-row>
                <v-col md="2">
                    <v-select label="Search By" v-model="options.searchBy" item-text="label" item-value="value"
                        :items="searchTypes"></v-select>
                </v-col>
                <v-col md="4">
                    <v-label> </v-label>
                    <v-select v-if="options.searchBy == 'item'" :items="bookingItems" item-value="id"
                        item-text="name_of_item" v-model="search">
                    </v-select>
                    <div v-else-if="options.searchBy == 'period'">
                        <v-row>
                            <v-col md="6">
                                <v-text-field label="From" v-model="from" type="date"></v-text-field>
                            </v-col>
                            <v-col md="6">
                                <v-text-field label="To" v-model="to" type="date"></v-text-field>
                            </v-col>
                        </v-row>
                    </div>
                    <v-text-field v-else-if="options.searchBy != 'created_at'" v-model="search" label="Search"
                        single-line hide-details></v-text-field>
                    <v-text-field label="Date" v-else v-model="search" type="date"></v-text-field>
                </v-col>
                <v-col style="margin-top: 1rem">
                    <v-btn outlined elevation="0" color="blue" icon
                        @click="getRefunds()"><v-icon>mdi-magnify</v-icon></v-btn>
                </v-col>
            </v-row>
        </v-card-title>
        <v-data-table :headers="headers" :items="refunds" :options.sync="options"
            :server-items-length="options.totalBooked" :loading="loading" class="elevation-1" :page="options.page"
            :itemsPerPage="options.itemsPerPage">
            <template v-slot:[`item.order_id`]="{ item }">
                <router-link :to="'/admin/booked/' + item.order_id + '/track'">
                    {{ item.order_id }}
                </router-link>
            </template>
            <template v-slot:[`item.ordered_item`]="{ item }">
                <ul style="list-style-type: none">
                    <li v-for="(order, index) in item.ordered_item" :key="index">
                        {{ order.item.name_of_item }} / {{ order.quantity }}
                    </li>
                </ul>
            </template>
            <template v-slot:[`item.amount`]="{ item }">
                <p v-if="item.order != null">
                    {{ item.order.amount }}
                </p>
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
            <template v-slot:[`item.created_at`]="{ item }">
                {{ item.created_at | formatDate }}
            </template>
            <template v-slot:[`item.expected_arrival`]="{ item }">
                <div v-if="item.ordered_item.length != 0">
                    <div v-if="item.ordered_item[0].expected_arrival != null">
                        {{ (item.ordered_item[0].expected_arrival + ":00") | formatTime }}
                    </div>
                </div>
            </template>
            <template v-slot:[`item.no_of_pax`]="{ item }">
                <div v-if="item.ordered_item.length != 0">
                    <div v-if="item.ordered_item[0].no_of_adult != null">
                        {{ item.ordered_item[0].no_of_children }} Children <br />
                        {{ item.ordered_item[0].no_of_adult }} Adult(s)
                    </div>
                </div>
            </template>
            <template v-slot:[`item.actions`]="{ item }">
                <v-icon small class="mr-2" @click="editItem(item)"> mdi-pencil </v-icon>
            </template>
        </v-data-table>
        <v-dialog v-model="dialog" width="500">
            <v-form ref="form">
                <v-card>
                    <v-card-title class="text-h5 grey lighten-2"> Update </v-card-title>

                    <v-card-text>
                        <v-select class="mt-2" :items="items" label="Update Status" outlined
                            v-model="selectedStatus"></v-select>
                    </v-card-text>

                    <v-divider></v-divider>

                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="primary" @click="save()" text> Save </v-btn>
                    </v-card-actions>
                </v-card>
            </v-form>
        </v-dialog>
    </v-card>
</template>

<script>
import moment from "moment";

export default {
    data() {
        return {
            search: "",
            from: "",
            to: "",
            loading: false,
            options: {
                searchBy: "name",
                search: "",
                page: 0,
                itemsPerPage: 5,
                totalBooked: 0,
            },
            searchTypes: [
                {
                    value: "name",
                    label: "Name",
                },
                {
                    value: "created_at",
                    label: "Date",
                },
                {
                    value: "contact",
                    label: "Phone No",
                },
                {
                    value: "email",
                    label: "Email",
                },
                {
                    value: "item",
                    label: "Item",
                },
                {
                    value: "period",
                    label: "Period",
                },
            ],
            headers: [
                { text: "Ticket No.", value: "order_id", sortable: false },
                { text: "Tracking ID", value: "order.tracking_id", sortable: false },
                { text: "Order Date", value: "created_at", sortable: false },
                { text: "Name", value: "name", sortable: false },
                { text: "Contact", value: "contact", sortable: false },
                { text: "Email", value: "email", sortable: false },
                { text: "Items / Qnty.", value: "ordered_item", sortable: false },
                { text: "Amount", value: "amount", sortable: false },
                { text: "Period", value: "period", sortable: false },
                { text: "Payment Status", value: "payment_status", sortable: false },
                { text: "Booking Status", value: "status", sortable: false },
                { text: "Expected Arrival", value: "expected_arrival" },
                { text: "No. Of Pax", value: "no_of_pax" },
                { text: "Actions", value: "actions", align: "center", sortable: false },
            ],
            refunds: [],

            selectedStatus: "",
            selectedId: "",
            items: ["Not Visited", "Visited", "Checked Out", "Cancelled", "Refunded"],
            dialog: false,
            bookingItems: [],
        };
    },
    filters: {
        formatDate: function (string) {
            return moment(String(string)).format("DD/MM/YYYY");
        },
    },
    watch: {
        options: {
            handler() {
                this.getRefunds();
                this.getItems();
            },
            deep: true,
        },
    },
    methods: {
        getItems() {
            let self = this;
            self.$axios.get("/get-all-items")
                .then(function (res) {
                    self.bookingItems = res.data;
                });
        },
        getRefunds() {
            let self = this;
            if (self.options.itemsPerPage == -1) {
                self.options.itemsPerPage = self.options.totalBooked;
            }
            self.loading = true;
            if (self.options.searchBy == "period") {
                self.$axios
                    .get(
                        "/refunds?page=" +
                        self.options.page +
                        "&&paginate=" +
                        self.options.itemsPerPage +
                        "&&from=" +
                        self.from +
                        "&&to=" +
                        self.to +
                        "&&searchBy=" +
                        self.options.searchBy
                    )
                    .then(function (res) {
                        self.refunds = res.data.refunds.data;
                        self.options.totalBooked = res.data.refunds.total;
                        self.options.page = res.data.refunds.current_page;
                        self.loading = false;
                    });
            } else {
                self.$axios
                    .get(
                        "/refunds?page=" +
                        self.options.page +
                        "&&paginate=" +
                        self.options.itemsPerPage +
                        "&&search=" +
                        self.search +
                        "&&searchBy=" +
                        self.options.searchBy
                    )
                    .then(function (res) {
                        self.refunds = res.data.refunds.data;
                        self.options.totalBooked = res.data.refunds.total;
                        self.options.page = res.data.refunds.current_page;
                        self.loading = false;
                    });
            }
        },
        editItem(item) {
            this.selectedId = item.id;
            this.selectedStatus = item.status;
            this.dialog = true;
        },
        close() {
            this.dialog = false;
            this.$nextTick(() => {
                this.editedItem = Object.assign({}, this.defaultItem);
                this.editedIndex = -1;
            });
        },
        save() {
            let self = this;
            self.close();
            self.$axios
                .post("/update-booking/" + self.selectedId, {
                    status: self.selectedStatus,
                })
                .then(function (res) {
                    self.$emit("show-snackbar", {
                        message: res.data.success,
                        color: "green",
                    });
                })
                .then(function () {
                    self.getRefunds();
                })
                .catch(function (err) {
                    self.$emit("show-snackbar", {
                        message: "Oops! Something Went Wrong",
                        color: "red",
                    });
                    throw err;
                });
        },
    },
};
</script>
