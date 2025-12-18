<template>
  <v-row>
    <v-col cols="12">
      <v-card title="Inventory" subtitle="View All Inventory Details">
        <v-card-text>
   
          <div class="d-flex flex-wrap pb-3 pt-3">
            <v-select 
              label="Length" 
              v-model="filter.length" 
              :items="[10, 20, 30]"  
              max-width="100px"
            />
            <v-text-field
              class="ml-2"
              label="Search"
              v-model="filter.search"
              max-width="200"
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
            <template #item.unit="{ item }">
              {{ item?.unit?.title }}
            </template>
            <template #item.category="{ item }">
              {{ item?.category?.title }}
            </template> 
            <template #item.actions="{ item }">
                 <v-btn color="success" variant="plain" :to="`/user/reports/inventory/${item.id}`">
                    <v-icon>mdi-eye</v-icon>
                </v-btn>
            </template>
            <template v-slot:bottom>
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
import report from "@/models/report.model";

export default {
  data() {
    return {
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

      headers: [
        { title: "ID", value: "id", sortable: false },
        { title: "Title", value: "title", sortable: false },
        { title: "Sku", value: "sku" },
        { title: "unit", value: "unit" },
        { title: "category", value: "category" },
        { title: "Stock", value: "balance" },
        {title: "Actions", value: "actions", sortable: false },
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


        const res = await report.inventory(this.filter);

        this.items = res.data ?? [];
        this.totalItems = res.total ?? 0;
        this.last_page = res.last_page ?? 1;
        this.filter.page = Number(res.page ?? 1);
        this.filter.offset = res.offset ?? 0;

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

