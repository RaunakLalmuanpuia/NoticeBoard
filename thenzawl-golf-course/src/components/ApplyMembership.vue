<template v-slot:extension>
    <div>
        <v-tabs v-model="tabs">
            <v-tab>Corporate Membership</v-tab>
            <v-tab>Individual Membership</v-tab>
        </v-tabs>
    <v-tabs-items v-model="tabs">
        <v-tab-item>
            <v-card>
                <v-card-text>Hello</v-card-text>
            </v-card>
        </v-tab-item>
    </v-tabs-items>
    </div>
</template>

<script>
    export default {
        name: "ApplyMembership"
    }
</script>

<style scoped>

</style>
