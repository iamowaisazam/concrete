<template>
  <v-row>
    <v-col cols="12">
      <v-card title="Sale Invoice" subtitle="View All Sale Invoice Details">
        <v-card class="mb-4" outlined>
          <v-card-text>

            <v-row dense>

              <!-- Search -->
              <v-col cols="12" md="4">
                <v-text-field
                  v-model="filter.search"
                  label="Search"
                  prepend-inner-icon="mdi-magnify"
                  clearable
                  density="compact"
                />
              </v-col>

              <!-- Date -->
              <v-col cols="12" md="4">
                <v-text-field
                  v-model="filter.date"
                  label="Date"
                  type="date"
                  density="compact"
                />
              </v-col>

              <!-- Due Date -->
              <v-col cols="12" md="4">
                <v-text-field
                  v-model="filter.due_date"
                  label="Due Date"
                  type="date"
                  density="compact"
                />
              </v-col>

              <!-- Paid Status -->
              <v-col cols="12" md="4">
                <v-select
                  v-model="filter.is_paid"
                  label="Paid Status"
                  :items="[
                    { title: 'All', value: '' },
                    { title: 'Paid', value: 1 },
                    { title: 'Unpaid', value: 0 }
                  ]"
                  density="compact"
                />
              </v-col>

              <!-- Min Total -->
              <v-col cols="12" md="4">
                <v-text-field
                  v-model="filter.total_min"
                  label="Min Total"
                  type="number"
                  density="compact"
                />
              </v-col>

              <!-- Max Total -->
              <v-col cols="12" md="4">
                <v-text-field
                  v-model="filter.total_max"
                  label="Max Total"
                  type="number"
                  density="compact"
                />
              </v-col>

              <!-- Buttons -->
              <v-col cols="12" class="text-center mt-3">
                <v-btn
                  color="primary"
                  prepend-icon="mdi-filter"
                  class="mr-2"
                  @click="loadItems"
                >
                  Search
                </v-btn>

                <v-btn
                  color="grey"
                  variant="outlined"
                  prepend-icon="mdi-refresh"
                  @click="resetFilter"
                >
                  Reset
                </v-btn>
              </v-col>

            </v-row>

          </v-card-text>
        </v-card>
        <v-card-text>
          <v-data-table-server class="border striped-table"
            :headers="headers"
            :items="items"
            :items-length="totalItems"
            :loading="loading"
            item-value="id"
            @update:options="loadItems"
          >
            <template #item.actions="{ item }">
                 <v-btn color="warning" variant="flat" :to="`/user/saleInvoice/edit/${item.id}`">
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
import saleInvoiceModel from "@/models/saleInvoice.model";

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
        { 
          title: "Date", 
          value: "date",
          format: (value) => value ? value.split(' ')[0] : ''
        },
        { 
          title: "Due Date", 
          value: "due_date",
          format: (value) => value ? value.split(' ')[0] : ''
        },
        { title: "Ref", value: "ref" },
        { title: "Remarks", value: "remarks" },
        { title: "paid", value: "is_paid" },
        { title: "Total", value: "total" },
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
        const res = await saleInvoiceModel.all(this.filter);
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
        const res = await saleInvoiceModel.delete(id);

        this.$alertStore.add(res.message || "Sale Invoice deleted", "success");
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
