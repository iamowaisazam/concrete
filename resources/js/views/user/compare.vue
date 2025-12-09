<template>
    <main>
        <user-title-bar title="Find the Best Auction Deal"
            subtitle="Review and compare live auctions side by side to find the smartest deal.">
            <v-btn append-icon="mdi-arrow-down" color="transparent" id="filterToggle" variant="flat"
                class="d-flex align-center cursor-pointer border-0 text-capitalize font-weight-light"
                @click="toggleFilters">
                <span class="mr-2">Filters</span>

            </v-btn>
            <!-- Filter Section -->
            <div class="flex justify-start align-start" v-show="showFilters">
                <v-container fluid class="pa-6 bg-background rounded border border-[#44485e] w-[90%] mt-2"
                    style="margin-left: -1px">
                    <v-row dense>
                        <!-- Make -->
                        <v-col cols="12" sm="6" md="3">
                            <v-select color="primary" density="compact" label="Make" />
                        </v-col>

                        <!-- Model -->
                        <v-col cols="12" sm="6" md="3">
                            <v-select color="primary" density="compact" label="Model" />
                        </v-col>

                        <!-- Variant -->
                        <v-col cols="12" sm="6" md="3">
                            <v-select color="primary" density="compact" label="Variant" />
                        </v-col>

                        <!-- Year -->
                        <v-col cols="12" sm="6" md="3">
                            <v-select color="primary" density="compact" label="Year" />
                        </v-col>

                        <!-- Transmission -->
                        <v-col cols="12" sm="6" md="3">
                            <v-select color="primary" density="compact" label="Transmission" />
                        </v-col>

                        <!-- Fuel -->
                        <v-col cols="12" sm="6" md="3">
                            <v-select color="primary" density="compact" label="Fuel" />
                        </v-col>

                        <!-- Grade -->
                        <v-col cols="12" sm="6" md="3">
                            <v-select color="primary" density="compact" label="Grade" />
                        </v-col>

                        <!-- Mileage -->
                        <v-col cols="12" sm="6" md="3">
                            <v-select color="primary" density="compact" label="Mileage" />
                        </v-col>

                        <!-- Auction House -->
                        <v-col cols="12" sm="6" md="3">
                            <v-select density="compact" color="primary" label="Auction House" />
                        </v-col>

                        <!-- Search Button -->
                        <v-col cols="12" sm="6" md="3" class="d-flex align-center mb-6">
                            <v-btn prepend-icon="mdi-magnify" variant="flat" color="primary" @click="toggleSearch">
                                Search
                            </v-btn>
                        </v-col>
                    </v-row>
                </v-container>
            </div>
        </user-title-bar>

        <div v-show="showSearch" class="pa-5 ps-2 ps-sm-6 mr-auto ml-auto" style="max-width: 1500px;">
     
        </div>
    </main>
</template>

<script>


export default {
    props: {},
    components: {
       
    },

    name: "FilterToggle",
    data() {
        return {
            headers: Array.from({ length: 8 }, (_, i) => ({
                title: `Vehicle ${i + 1}`,
                key: `vehicle_${i}`,
            })),
            items: [
                { field: "Auction House" },
                { field: "Auction Date" },
                { field: "Lot Number" },
                { field: "Sale Status" },
                { field: "Final Price" },
                { field: "Make" },
                { field: "Model" },
                { field: "Variant" },
            ],
            loading: false,




            showFilters: true,
            showSearch: false,
        };

    },
    methods: {
        randomData() {
            const data = ["BMW", "Audi", "Sold", "Not Sold", "£4500"];
            return data[Math.floor(Math.random() * data.length)];
        },
        getScrollEl() {
            // find the real Vuetify scrollable wrapper
            const wrapper = this.$refs.scrollContainer?.querySelector('.v-table__wrapper');
            return wrapper || this.$refs.scrollContainer;
        },
        scrollBy(px) {
            const el = this.getScrollEl();
            if (!el) return console.warn('scroll container not found');
            el.scrollBy({ left: px, behavior: 'smooth' });
        },
        scrollLeft() {
            this.scrollBy(-100);
        },
        scrollRight() {
            this.scrollBy(100);
        },




        toggleFilters() {
            this.showFilters = !this.showFilters;
        },
        toggleSearch() {
            this.showSearch = !this.showSearch;
        },
    },
};
</script>

