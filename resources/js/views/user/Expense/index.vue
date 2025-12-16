<template>
  <v-row>
    <v-col cols="12">
      <v-card title="Expense" subtitle="View All Expense Details">
        <v-card-text>
   
          <div class="d-flex flex-wrap pb-3 pt-3">
            <v-select 
              label="Length" 
              v-model="filter.length" 
              :items="[10, 20, 30]"  
              width="150"
            />
            <v-text-field
              class="ml-2"
              label="Search"
              v-model="filter.search"
              width="200"
              clearable
              persistent-placeholder
            />
            <v-btn class="ml-2" color="primary" variant="flat" prepend-icon="mdi-magnify" @click="loadItems">Search</v-btn>
            <v-btn class="ml-2" color="success" variant="flat" prepend-icon="mdi-plus" :to="`/user/expense/create`">Add Expense</v-btn>
          </div>

          <v-data-table-server
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
                 <v-btn color="warning" variant="flat" :to="`/user/expense/edit/${item.id}`">
                    <v-icon>mdi-square-edit-outline</v-icon>
                </v-btn>
            <span class="px-1"> </span>
            <v-btn
                color="danger"
                variant="flat"
                @click="deleteItem(item.id)"
                >
                <v-icon>mdi-delete</v-icon> 
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
import expenseModel from "@/models/expense.model";

export default {
  data() {
    return {
      filter: { search: "", length: 10, page: 1, offset: 0 },
      items: [],
      totalItems: 0,
      last_page: 1,
      loading: false,
      headers: [
        { title: "ID", value: "id" },
        { title: "Date", value: "date" },
        { title: "Debit", value: "debit" },
        { title: "Credit", value: "credit" },
        { title: "Remarks", value: "remarks" },
        { title: "Actions", value: "actions", sortable: false },
      ],
    };
  },
  mounted() {
    this.loadItems();
  },
  methods: {
    async loadItems() {
      this.loading = true;
      try {
        const res = await expenseModel.all(this.filter);
        this.items = res.data;
        this.totalItems = res.total;
        this.last_page = res.last_page;
        this.filter.page = Number(res.page);
        this.filter.offset = res.offset;
      } catch (error) {
        this.items = [];
        this.totalItems = 0;
      } finally {
        this.loading = false;
      }
    },
    async deleteItem(id) {
        if (!confirm("Are you sure you want to delete this item?")) return;

        this.loading = true;
        try {
        const res = await expenseModel.delete(id);

        this.$alertStore.add(res.message || "Inventory deleted", "success");
        this.loadItems(); 

        } catch (error) {
        console.error(error);
        this.$alertStore.add(error.message || "Delete failed", "error");
        } finally {
        this.loading = false;
        }
    }

  },
};
</script>
