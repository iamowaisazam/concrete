<template>
    <!-- <user-title-bar title="Watched & Alerted" subtitle="Track recently watched and alerted vehicles — stay ahead of every auction opportunity">
        <div class="d-flex align-center ga-3"></div>
    </user-title-bar> -->

        <v-row>
            <v-col cols="12">
                <v-row class="mt-3">
                    <v-col cols="12" class="">
                        
                        <v-card title="Accounts" subtitle="View All Accounts Details" class="">
                            <v-card-text>
                                <div class="pb-3 pt-3 d-flex flex-wrap ">
                                    <div class="py-2">
                                        <v-select 
                                            label="Length" 
                                            v-model="filter.length" 
                                            :items="[10, 20, 30]"
                                            @update:model-value="handleInput"  
                                            class=""
                                            width="150"
                                             />
                                    </div>
                                    <div class="pl-2 py-2">
                                        <v-text-field label="Search" 
                                            v-model="filter.search"
                                            @update:model-value="handleInput"
                                            width="200"
                                            persistent-placeholder
                                            clearable />
                                    </div>

                                    <div class="pl-2 py-2">
                                        <v-btn color="primary" variant="flat" prepend-icon="mdi-magnify"
                                            @click="handleInput" />
                                    </div>
                                    <div class="pl-2 py-2">
                                        <v-btn class="text-center" color="success" variant="flat"
                                            prepend-icon="mdi-plus" to="/user/account/create" />
                                    </div>
                                </div>

                                <v-data-table-server class="border" :headers="headers" :items="items"
                                    :items-length="totalItems" :loading="loading" item-value="id"
                                    @update:options="loadItems">

                                    <template #item.view="{ item }">
                                        <v-btn color="warning" variant="flat" :to="`/user/account/edit/${item.id}`">
                                            <v-icon>mdi-square-edit-outline</v-icon>
                                        </v-btn>
                                        <span class="px-1"> </span>
                                        <v-btn color="danger" variant="flat">
                                            <v-icon>mdi-delete</v-icon>
                                        </v-btn>
                                    </template>

                                    <template #item.autoboli="{ item }">
                                        -
                                    </template>

                                    <template v-slot:bottom>
                                        <div class="py-2">
                                            <custom-pagination :loading="loading" v-model:page="filter.page"
                                                :lastPage="last_page" @page-changed="loadItems" />
                                        </div>
                                    </template>
                                </v-data-table-server>

                            </v-card-text>
                        </v-card>
                    </v-col>
                </v-row>
            </v-col>
        </v-row>
 
</template>

<script>

import UserModel from "@/models/user.model";



// console.log(accounts);

export default {
    components: {

    },
    data() {
        return {
            createModel: false,
            filter: {
                search: '',
                length: 10,
                page: 1,
                offset: 0,
            },
            last_page: 1,
            items: [],
            totalItems: 0,
            loading: false,
            headers: [
                { title: "ID", value: "id" },
                { title: "Account", value: "firstName" },
                { title: "Phone", value: "phone" },
                { title: "Email", value: "personalEmail" },
                { title: "City", value: "townCity" },
                { title: "Address", value: "companyAddress1" },
                { title: "Action", key: 'view', sortable: false },
            ],
        };
    },
    computed: {
       
    },
    mounted() {

        this.loadItems();
    },
    methods: {
        handleInput(value, field = null) {

            switch (field) {
                case 'search':
                    this.filter.search = value;
                    break;
                default:
                    break;
            }

            this.loadItems();
        },
        async loadItems() {

            this.loading = true;
            try {

                const res = await UserModel.getAccounts(this.filter);
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
