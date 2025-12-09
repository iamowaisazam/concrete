<template>
    <v-col cols="12">
        <v-row class="mt-3">
            <v-col cols="12">
                <div class="d-flex justify-md-space-between flex-wrap ">
                    <div class="d-flex flex-wrap">
                        <div class="px-2">
                            <v-select label="Length" v-model="filter.length" :items="[10, 20, 30]"
                                @update:model-value="handleInput" variant="outlined" color="primary" width="120"
                                density="compact" />
                        </div>
                        <div class="px-2">
                            <YearDropdown label="All Years" :model-value="filter.year"
                                @update:model-value="handleInput($event, 'year')" item-title="label" item-value="id"
                                variant="outlined" color="primary" width="150" density="compact" clearable />
                        </div>
                    </div>
                    <div class="d-flex flex-wrap">

                        <div class="px-2">
                            <v-text-field prepend-inner-icon="mdi-magnify" label="Reg No" v-model="filter.reg_search"
                                @update:model-value="handleInput" variant="outlined" color="primary" width="200"
                                density="compact" clearable />
                        </div>

                        <div class="px-2">
                            <MakeDropdown width="200" label="Select Make" variant="outlined" color="primary"
                                density="compact" :model-value="filter.make"
                                @update:modelValue="handleInput($event, 'make')" clearable />
                        </div>

                        <div class="px-2">

                            <ModelDropdown width="200" label="Select Model" variant="outlined" color="primary"
                                :make="filter.make" :model-value="filter.model"
                                @update:modelValue="handleInput($event, 'model')" clearable density="compact" />

                        </div>

                    </div>
                </div>
            </v-col>

            <v-col cols="12" class="">
                <div class="  border ">
                    <v-data-table-server class="" :headers="headers" :items="items" :items-length=" totalItems"
                        :loading="loading" item-value="id" @update:options="loadItems">

                        <template #item.view="{ item }">
                            <v-btn :to="'/user/vehicle-detail/' + item.id"> <v-icon>mdi-eye</v-icon></v-btn>
                        </template>

                        <template #item.autoboli="{ item }">
                            -
                        </template>

                        <template v-slot:bottom>
                            <div class="py-2">
                                <custom-pagination :loading="loading" v-model:page="filter.page" :lastPage="last_page"
                                    @page-changed="loadItems" />
                            </div>
                        </template>
                    </v-data-table-server>
                </div>
            </v-col>
        </v-row>


    </v-col>


</template>

<script>

import MakeDropdown from "@/components/MakeDropdown.vue";
import ModelDropdown from "@/components/ModelDropdown.vue";
import YearDropdown from "@/components/YearDropdown.vue";
import UserModel from "@/models/user.model";

export default {
    name: "Watchlist",
    components: {
        MakeDropdown,
        ModelDropdown,
        YearDropdown
    },
    data() {
        return {
            filter: {
                make: null,
                model: null,
                reg_search: '',
                year: null,
                length: 10,
                page: 1,
                offset: 0,
            },
            last_page: 1,
            items: [],
            totalItems: 0,
            loading: false,
            headers: [
                { title: "", key: 'view', sortable: false },
                { title: "VEHICLE", value: "vehicle" },
                { title: "REG", value: "reg" },
                { title: "CLEAN", value: "cap_clean" },
                { title: "AVERAGE", value: "cap_average" },
                { title: "BELOW", value: "cap_below" },
                { title: "AUTOTRADER", value: "autotrader_retail_value" },
                { title: "AUCTION", value: "platform_title" },
                { title: "LAST BID", value: "last_bid" },
                { title: "AUTOBOLI", key: "autoboli", sortable: false },
            ],
        }
    },
    mounted() {

        this.loadItems();
    },
    methods: {
        handleInput(value, field = null) {

            switch (field) {
                case 'make':
                    this.filter.make = value;
                    break;
                case 'model':
                    this.filter.model = value;
                    break;
                case 'year':
                    this.filter.year = value;
                    break;
                default:
                    break;
            }

            this.loadItems();
        },
        async loadItems() {

            this.loading = true;
            try {

                const res = await UserModel.getWatchList(this.filter);
                // console.log(res);
                

                this.items = res.data || [];
                this.totalItems = res.recordsTotal;
                this.filter.offset = res.offset;
                this.filter.page = res.page;
                this.last_page = res.last_page;

            } catch (error) {
                console.error("Error fetching userWatchList:", error);
                this.totalItems = 0;
                this.items = [];
            } finally {
                this.loading = false;
            }

        },

    },
};
</script>

<style></style>
