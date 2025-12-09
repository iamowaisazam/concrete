<template>

    <v-col> 
      <v-card title="Notifications" subtitle="Change to notification settings, the user will get the update" >
        <div class="border" ></div>
          <v-container fluid>
          
              <!-- Notifications Table -->
              <v-table class="bg-surface notification-table " density="comfortable">
              <thead>
                  <tr class="bg-surface">
                  <th class="text-left text-white text-caption font-weight-bold pa-4">TYPE</th>
                  <th class="text-center text-white text-caption font-weight-bold">EMAIL</th>
                  <th class="text-center text-white text-caption font-weight-bold">BROWSER</th>
                  </tr>
              </thead>
              <tbody>
                  <tr v-for="(item, i) in notifications" :key="i" class="border-b border-grey-darken-3">
                  <td class="text-white pa-6 text-subtitle-1 font-weight-medium">
                      {{ item.type }}
                  </td>
                  <td class="text-center">
                      <v-switch
                      v-model="item.email"
                      color="primary"
                      hide-details
                      inset
                      class="d-inline-flex"
                      ></v-switch>
                      <div class="text-primary text-caption mt-1 cursor-pointer" @click="selectAllEmail">
                      Select All (Email)
                      </div>
                  </td>
                  <td class="text-center">
                      <v-switch
                      v-model="item.browser"
                      color="green-accent-2"
                      hide-details
                      inset
                      class="d-inline-flex"
                      ></v-switch>
                      <div class="text-green-accent-2 text-caption mt-1 cursor-pointer" @click="selectAllBrowser">
                      Select All (Browser)
                      </div>
                  </td>
                  </tr>
              </tbody>
              </v-table>

              <!-- Action Buttons -->
              <div class="mt-10">
              <v-btn color="primary" variant="flat" class="mx-2" >
                  Save changes
              </v-btn>
              <v-btn variant="tonal" class="mx-2 bg-background">
                  Cancel
              </v-btn>
              </div>
          </v-container>
      </v-card>
  </v-col>

    
  
</template>

<script>
export default {
  name: 'NotificationSettings',

  data() {
    return {
      notifications: [
        { type: 'Auction Activity', email: true, browser: true },
        { type: 'Vehicle Tracking', email: false, browser: true },
        { type: 'Scheduling', email: false, browser: false },
        { type: 'System', email: true, browser: false },
        { type: 'News Engagement', email: false, browser: true }
      ]
    }
  },

  methods: {
    selectAllEmail() {
      this.notifications.forEach(n => n.email = true)
    },
    selectAllBrowser() {
      this.notifications.forEach(n => n.browser = true)
    }
  }
}
</script>

<style scoped>
    .v-application {
    background: #0f0f1e !important;
    }

    .notification-table {
    /* background: #1a1a2e; */
    }

    .notification-table tbody tr:hover {
    background: rgba(138, 43, 226, 0.05) !important;
    }

    .v-table thead th {
    /* background: #1e1e2e !important; */
    }

    /* Custom cursor for "Select All" links */
    .cursor-pointer {
    cursor: pointer;
    user-select: none;
    }
</style>