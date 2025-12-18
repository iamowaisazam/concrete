<template>
  <v-row>
    <v-col cols="12">
      <v-card :title="model?.title+ ' - Product '" subtitle="View All Details">
        <v-card-text>
   
          <div class="d-flex flex-wrap pb-3 pt-3">
            <v-select 
              label="Length"
              max-width="100px" 
              v-model="filter.length" 
              :items="[10, 20, 30]"  
              width="150"
            />
            <v-text-field
              class="ml-2"
              label="Search"
              max-width="200px"
              v-model="filter.search"
              width="200"
              clearable
              persistent-placeholder
            />
            <v-btn class="ml-2" color="primary" variant="flat" prepend-icon="mdi-magnify" @click="loadItems"></v-btn>
     
          </div>

          <v-data-table-server class="border striped-table"
            :headers="headers"
            :items="items"
            :items-length="totalItems"
            :loading="loading"
            item-value="id"
            @update:options="loadItems"
          >
            <template #item.image="{ item }">
              <v-img :src="item.image" width="60" height="50" contain></v-img>
            </template>

            <template #item.actions="{ item }">
                 <!-- <v-btn color="success" variant="plain"  :to="`/user/inventory/edit/${item.id}`">
                    <v-icon>mdi-eye</v-icon>
                </v-btn> -->
            </template>
            <template v-slot:bottom>

        
              <div class="border-t border-b py-3 d-flex justify-center">
                <div style="width: 200px;" class="text-end font-weight-bold" >Current Stock :</div>
                <div style="width: 100px;" class="px-3"  >{{ stock }}</div>
              </div>
              
              <custom-pagination
                :loading="loading"
                v-model:page="filter.page"
                :lastPage="last_page"
                @page-changed="loadItems"
              />
            </template>

          </v-data-table-server>
        </v-card-text>
      </v-card>
    </v-col>
  </v-row>
</template>

<script>
import reportModel from "@/models/report.model";
import customerLedger from "@/models/report.model";

export default {
  data() {
    return {
      model:{},
      filter: {
        search: "",
        length: 10,
        page: 1,
        offset: 0,
      },

      items: [],

      totalItems: 0,
      last_page: 1,
      loading: false,
      stock:0,

      headers: [
        { title: "ID", value: "id", sortable: false },
        { title: "Date", value: "date" },
        { title: "Description", value: "remarks" },
        { title: "Stock In", value: "stock_in" },
        { title: "Stock Out", value: "stock_out" },
        { title: "Stock", value: "balance" },
        // { title: "Actions", value: "actions", sortable: false },
      ],
    };
  },

  mounted() {
    this.loadItems();
  },

  methods: {
    async loadItems(options = {}) {
      this.loading = true;

      try {
        // ✅ datatable options sync
        if (options.page) this.filter.page = options.page;
        if (options.itemsPerPage) this.filter.length = options.itemsPerPage;

        // 👇 single customer ledger (id from route)
        const id = this.$route.params.id;

        const res = await reportModel.inventoryDetail(id, this.filter);

        this.items = res.data ?? [];
        this.totalItems = res.total ?? 0;
        this.last_page = res.last_page ?? 1;
        this.filter.page = Number(res.page ?? 1);
        this.filter.offset = res.offset ?? 0;
        this.model = res.prodcut;
        this.stock = res.balance;

      } catch (error) {
        console.error(error);
        this.items = [];
        this.totalItems = 0;
      } finally {
        this.loading = false;
      }
    },
  },
};
</script>

