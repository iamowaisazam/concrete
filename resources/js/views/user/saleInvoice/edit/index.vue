<template>
  <v-container>

    <v-card :loading="loading" :disabled="loading"
      title="Edit Sale Invoice"
      subtitle="Update Sale Invoice"
    >
      <v-card-text>
        <v-row class="pt-3">

          <v-col cols="12" sm="4">
            <v-text-field v-model="form.ref" label="Reference" />
          </v-col>

          <v-col cols="12" sm="4">
            <v-text-field v-model="form.date" type="date" label="Date" />
          </v-col>

          <v-col cols="12" sm="4">
            <v-text-field v-model="form.due_date" type="date" label="Due Date" />
          </v-col>

          <v-col cols="12" sm="4">
            <v-text-field v-model="form.remarks" label="Remarks" />
          </v-col>

          <v-col cols="12" sm="4">
            <v-select
              v-model="form.status"
              :items="statusItems"
              item-title="label"
              item-value="value"
              label="Status"
            />
          </v-col>
               <v-col cols="3" sm="4">
                <v-select v-model="form.is_paid" :items="[
                  { text: 'Yes', value: 1 },
                  { text: 'No', value: 0 }
                ]" item-title="text" item-value="value"  label="Paid status" clearable persistent-placeholder=""/>
              </v-col>

          <v-col cols="12" sm="4">
            <UserDropdown v-model="form.user_id" label="User" />
          </v-col>

        </v-row>
      </v-card-text>
    </v-card>

    <!-- ITEMS -->
    <v-card class="mt-3" title="Item List">
      <v-card-text>
        <InvoiceItemsSection
          :items="form.items"
          :user-id="form.user_id"
          @add="addItem"
          @remove="removeItem"
        />
      </v-card-text>
    </v-card>

    <!-- TOTAL -->
    <v-card class="mt-3" title="Invoice Total">
      <v-card-text>
        <v-row>
          <v-col cols="3">
            <v-text-field label="Subtotal" :model-value="subtotal" disabled />
          </v-col>

          <v-col cols="3">
            <v-text-field label="Discount %" v-model="form.discount" />
          </v-col>

          <v-col cols="3">
            <v-text-field label="Tax %" v-model="form.tax" />
          </v-col>

          <v-col cols="3">
            <v-text-field label="Grand Total" :model-value="grandTotal" disabled />
          </v-col>
        </v-row>
      </v-card-text>
    </v-card>

    <div class="mt-4 text-center">
      <v-btn color="primary" @click="updateInvoice">
        Update Invoice
      </v-btn>
    </div>

  </v-container>
</template>



<script>
import InvoiceItemsSection from "./InvoiceItemsSection.vue"
import saleInvoiceModel from "@/models/saleInvoice.model"
import UserDropdown from "@/components/UserDropdown.vue"

export default {
  components: { InvoiceItemsSection, UserDropdown },

  data() {
    return {
      loading: false,
      invoiceId: this.$route.params.id,

      form: {
        date: "",
        due_date: "",
        ref: "",
        remarks: "",
        status: 1,
        discount: 0,
        tax: 0,
        user_id: null,
        items: []
      },

      statusItems: [
        { label: "Active", value: 1 },
        { label: "Deactive", value: 0 },
      ],
    }
  },

  mounted() {
    this.loadInvoice()
  },

  methods: {
    addItem() {
      this.form.items.push({
        delivery_note: null,
        delivery_note_id: null,
        discount: 0,
        tax: 0,
      })
    },

    removeItem(i) {
      this.form.items.splice(i, 1)
    },

    async loadInvoice() {
      this.loading = true
      try {
        const res = await saleInvoiceModel.find(this.invoiceId)
        const inv = res.data

        this.form = {
        date: inv.date?.substring(0, 10),
        due_date: inv.due_date?.substring(0, 10),
        ref: inv.ref,
        is_paid: Number(inv.is_paid),
        remarks: inv.remarks,
        status: Number(inv.status),
        discount: Number(inv.discount),
        tax: Number(inv.tax),
        user_id: inv.user_id,

        items: inv.items.map(it => ({
          delivery_note: {
            id: it.delivery_note_id,
            title: `DN-${it.delivery_note_id}`,
            total: Number(it.total || 0)
          },
          delivery_note_id: it.delivery_note_id,
          discount: Number(it.discount || 0),
          tax: Number(it.tax || 0),
        }))
      }

      } finally {
        this.loading = false
      }
    },

    async updateInvoice() {
      this.loading = true
      try {
        const fd = new FormData()
        fd.append("_method", "PUT")

        Object.entries(this.form).forEach(([k, v]) => {
          if (k !== "items") fd.append(k, v ?? "")
        })

        this.form.items.forEach((item, i) => {
          if (!item.delivery_note_id) return
          fd.append(`items[${i}][delivery_note_id]`, item.delivery_note_id)
          fd.append(`items[${i}][discount]`, item.discount ?? 0)
          fd.append(`items[${i}][tax]`, item.tax ?? 0)
        })

        await saleInvoiceModel.update(this.invoiceId, fd)
        this.$alertStore.add("Invoice updated successfully", "success")
        this.$router.push("/user/saleInvoice")

      } catch (e) {
        this.$alertStore.add("Update failed", "error")
      } finally {
        this.loading = false
      }
    }
  },

  computed: {
    subtotal() {
      return this.form.items.reduce((s, i) => {
        const t = Number(i.delivery_note?.total || 0)
        return s + (t - i.discount + i.tax)
      }, 0).toFixed(2)
    },

    grandTotal() {
      const disc = (this.subtotal * this.form.discount) / 100
      const tax = ((this.subtotal - disc) * this.form.tax) / 100
      return (this.subtotal - disc + tax).toFixed(2)
    }
  }
}
</script>


<style>
.section {
  margin-bottom: 28px;
}

.section-title {
  font-size: 16px;
  font-weight: 600;
}
</style>
