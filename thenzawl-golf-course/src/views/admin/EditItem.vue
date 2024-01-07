<template>
    <v-container fluid ml-4 mt-6 pr-10>
        <v-overlay :value="show">
            <v-progress-circular indeterminate size="64"></v-progress-circular>
        </v-overlay>
        <v-container mt-6>
            <v-card style="padding: 18px">
                <v-card-title>Edit Item</v-card-title>
                <v-card-text>
                    <v-form ref="form" v-model="valid">
                        <v-row>
                            <v-col md="6">
                                <br />
                                <h3>Basic Information</h3>
                                <br />
                                <v-label>Name of Item</v-label>
                                <v-text-field required :rules="[(v) => !!v || 'Item Name is required']" solo
                                    class="my-input" label="Enter name" v-model="itemData.name"></v-text-field>

                                <v-label>Picture</v-label>
                                <v-file-input solo label="Click to select picture" class="my-input"
                                    append-icon="mdi-camera" prepend-icon="" v-model="itemData.picture"
                                    accept="image/*"></v-file-input>

                                <v-row>
                                    <v-col md="8">
                                        <v-label>Rate</v-label>
                                        <div v-for="(rate, i) in rates" :key="i">
                                            <v-text-field required :rules="[(v) => !!v || 'Rate is required']"
                                                v-model="rate.rate" solo type="number" label="Enter number"
                                                class="my-input"></v-text-field>
                                        </div>
                                    </v-col>
                                    <v-col md="4">
                                        <v-label><br /></v-label>
                                        <div v-for="(rate, i) in rates" :key="i">
                                            <v-select v-model="rate.type" :items="items" solo
                                                class="my-input"></v-select>
                                        </div>
                                    </v-col>
                                </v-row>
                                <p class="text-right custom-padding">
                                    <v-btn style="
                      text-decoration: underline;
                      text-transform: capitalize;
                    " color="#04d39b" link text @click="addRates">Add more rate +</v-btn>
                                </p>
                            </v-col>
                            <v-col md="6">
                                <v-alert style="padding: 13px" color="#f7ffdb">
                                    <v-icon color="#04d39b">mdi-information-outline</v-icon>
                                    Discount and instructions
                                </v-alert>
                                <v-label>Instruction / Remark</v-label>
                                <v-textarea required :rules="[(v) => !!v || 'This field is required']"
                                    v-model="itemData.instruction" label="Remark" solo class="my-input"></v-textarea>
                                <v-row>
                                    <v-col>
                                        <p></p>
                                        <v-radio-group v-model="type" row>
                                            <v-radio label="General" value="general"></v-radio>
                                            <v-radio label="Display on Booking" value="display"></v-radio>
                                            <v-radio label="Add On" value="addon"></v-radio>
                                        </v-radio-group>
                                    </v-col>
                                </v-row>
                            </v-col>
                        </v-row>
                    </v-form>
                </v-card-text>
            </v-card>
            <br />
            <p class="text-right">
                <v-btn @click="validate()" elevation="0" rounded color="#04d39b" class="text-white">Update Item</v-btn>
            </p>
        </v-container>
    </v-container>
</template>

<script>
export default {
    props: ["id"],
    data() {
        return {
            type: "general",
            show: false,
            valid: true,
            items: ["Amount", "Hours", "Person", "Day"],
            itemData: {
                name: "",
                picture: null,
                instruction: "",
            },
            rates: [],
        };
    },
    mounted() {
        this.getSingleItem();
    },
    methods: {
        getSingleItem() {
            let self = this;
            self.$axios
                .get("item/" + self.id)
                .then(function (res) {
                    self.itemData.name = res.data.item.name_of_item;
                    for (let i = 0; i < res.data.item.rate.length; i++) {
                        self.rates.push({
                            id: res.data.item.rate[i].id,
                            rate: res.data.item.rate[i].rate,
                            type: res.data.item.rate[i].type,
                        });
                    }
                    self.type = res.data.item.type;
                    self.itemData.instruction = res.data.item.remark;
                })
                .catch(function (err) {
                    throw err;
                });
        },
        addRates() {
            this.rates.push({
                id: 0,
                rate: "",
                type: "Amount",
            });
        },
        validate() {
            this.$refs.form.validate();
            if (this.$refs.form.validate() == true) {
                this.addItem();
            }
        },
        addItem() {
            this.show = true;
            let formData = new FormData();
            formData.append("type", this.type);
            formData.append("name", this.itemData.name);
            formData.append("picture", this.itemData.picture);
            formData.append("instruction", this.itemData.instruction);
            this.rates.forEach((item) => {
                formData.append("rates[]", JSON.stringify(item));
            });
            this.$axios
                .post("update-item/" + this.id, formData, {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                })
                .then((res) => {
                    this.show = false;
                    this.$router.push("/admin/list-item");
                    (this.rates = [
                        {
                            rate: "",
                            type: "Amount",
                        },
                    ]),
                        (this.discounts = [
                            {
                                name: "",
                                percent: "",
                            },
                        ]),
                        this.$emit("show-snackbar", {
                            message: res.data.success,
                            color: "success",
                        });
                })
                .catch((err) => {
                    this.show = false;
                    this.$emit("show-snackbar", {
                        message: "Oops! Something Went Wrong",
                        color: "red",
                    });
                    throw err;
                });
        },
    },
};
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
