<template>
  <v-row>
    <v-col cols="12">
      <v-card title="Sale Order" subtitle="View All Sale Order Details">
        <v-card class="mb-4" outlined>
          <v-card-text>

            <v-row dense>
              <v-col cols="12" md="4">
                <v-text-field
                  v-model="filter.search"
                  label="Search"
                  prepend-inner-icon="mdi-magnify"
                  clearable
                  density="compact"
                  persistent-placeholder=""
                />
              </v-col>
              <v-col cols="12" md="4">
                <v-text-field
                  v-model="filter.date"
                  label="Date"
                  type="date"
                  density="compact"
                />
              </v-col>
              <v-col cols="3" sm="4">
              <UserDropdown
                    v-model="filter.user_id"
                    label="Users"
                    clearable persistent-placeholder=""
                />
            </v-col>
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
                class="ml-2" 
                color="success" 
                variant="flat" 
                prepend-icon="mdi-plus" 
                :to="`/user/saleorder/create`"></v-btn>
           
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
                 <v-btn color="warning" variant="flat" :to="`/user/saleorder/edit/${item.id}`">
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
            <template #item.user="{item}">
                <span class="font-weight-medium">
                  {{ item.user?.firstName || '-' }}
                  {{ item.user?.surname || '' }}
                </span>
            </template>

              <template #item.status="{ item }">
                <v-chip
                  :color="item.status == 1 ? 'green' : 'red'"
                  dark
                  small
                >
                  {{ item.status == 1 ? 'Active' : 'Deactive' }}
                </v-chip>
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
import generaApi from "@/models/general.model"
import UserDropdown from "@/components/UserDropdown.vue"
export default {
  components: {
    UserDropdown
  },
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
        { title: "Ref", value: "ref" },
        { title: "Remarks", value: "remarks" },
        { title: "Status", value: "status" },
        { title: "User", value: "user" },
        // { title: "Subtotal", value: "subtotal" },
        // { title: "Discount", value: "discount" },
        // { title: "Tax", value: "tax" },
        { title: "Total", value: "total" },
        { title: "Actions", value: "actions", sortable: false },
      ],
      url :"/api/saleOrder/"
    };
  },
  mounted() {
    this.loadItems();
  },
  methods: {
   
    async loadItems() {
      this.loading = true;
      try {
        const res = await generaApi.get(this.url,this.filter);
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
        const deleteurl = this.url+id
        const res = await generaApi.delete(deleteurl);

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
