<template>
  <v-row>
    <v-col cols="12">
      <v-card title="Customer 1 Ledger" subtitle="View All Account Details">
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
            <v-btn class="ml-2" color="primary" variant="flat" prepend-icon="mdi-magnify" @click="loadItems">Search</v-btn>
     
          </div>

          <v-data-table-server class="border"
            fixed-header
            striped="even"
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
                 <v-btn color="primary" variant="flat" :to="`/user/inventory/edit/${item.id}`">
                    <v-icon>mdi-eye</v-icon>
                </v-btn>
            </template>
            <template v-slot:bottom>

              <div class="border-t pt-4 d-flex justify-end">
                <div style="width: 100px;" class="text-end font-weight-bold" >Balance :</div>
                <div style="width: 100px;" class="px-3"  >0.00</div>
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


export default {
  data() {
    return {
      filter: { search: "", length: 10, page: 1, offset: 0 },
      items: [
              {
                id: 1,
                date: "2025-09-12",
                description: "Opening balance",
                debit: 0,
                credit: 5000,
                actions: true
              },
          {
            id: 2,
            date: "2025-09-13",
            description: "Car Rent",
            debit: 3000,
            credit: 0,
            actions: true
          },
          {
            id: 3,
            date: "2025-09-14",
            description: "Sale invoice #INV-001",
            debit: 0,
            credit: 12000,
            actions: true
          },
          {
            id: 4,
            date: "2025-09-15",
            description: "Advance Payment",
            debit: 1800,
            credit: 0,
            actions: true
          },
        
      ],
      totalItems: 0,
      last_page: 1,
      loading: false,
      headers: [
        { title: "ID", value: "id",sortable: false },
        { title: "Date", value: "date" },
        { title: "Description", value: "description" },
        { title: "Debit", value: "debit" },
        { title: "Credit", value: "credit" },
        { title: "Actions", value: "actions", sortable: false },
      ],
    };
  },
  mounted() {
    this.loadItems();
  },
  methods: {
    async loadItems() {
 
    },


  },
};
</script>
