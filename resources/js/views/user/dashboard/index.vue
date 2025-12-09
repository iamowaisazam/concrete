<template>

  <user-title-bar>

    <div class="d-flex flex-column flex-xs-row flex-md-row justify-space-between align-start pa-3">
      <div style="max-width: 600px;">
        <div>
          <h6 class="text-h5 font-weight-bold">Welcome back , <span class="text-primary">Mr Shan!</span> </h6>
        </div>
        <div class="pr-5 pb-5">
          <p class="mt-3 text-body-1 text-light ">
            Lorem ipsum dolor sit amet consectetur, adipisicing elit. Quisquam excepturi distinctio cum numquam minima
            porro tempore possimus a, id voluptates totam, inventore vitae unde cupiditate perspiciatis quidem dolor ab
            sequi.
          </p>
        </div>
      </div>
      <div>
        <v-card max-width="500px" class="bg-primary rounded p-6">
          <v-card-text>
            <div class="d-flex flex-sm-wrap align-center ">
              <div class="pa-3" style="max-width: 300px;">
                <h6 class="text-h6 font-weight-bold">Refer & Earn</h6>
                <p class="text-body-1 text-background font-weight-bold">Use Refer & Earn modal to encourage your exiting
                  customers refer their friends & colleague.</p>
              </div>
              <div style="max-width: 300px;" class="pa-3">
                <div class="dot-box"
                  style="width: 100px; height: 50px; background-color: rgba(0, 0, 0, 0.466); border-radius: 8px;display: flex;align-items: center;justify-content: center;margin-left: 10px; ">
                  <div class="dot" style=" width: 30px;  height: 30px; background-color: black;  border-radius: 4px;">
                  </div>
                </div>
              </div>
            </div>
          </v-card-text>
        </v-card>
      </div>
    </div>
  </user-title-bar>

  <v-container fluid class="">

    <v-row class="">
      <!-- Total Auctions -->


      <!-- Total Auctions -->
      <v-col cols="12" sm="6" md="3" class="">

        <v-card class="border-bottom w-100">
          <v-container>

            <div class="d-flex h-6 align-center  ">
              <div style="background: #0080ff38;border-radius: 22px;padding: 4px 6px;" class=" circle">
                <v-icon size="32" color="primary">mdi-circle</v-icon>
              </div>
              <span class="text-h4 px-1">{{ counter.total_Auctions }}</span>
            </div>

            <div class="pt-3 text-body-1 text-light ">Total Auctions</div>
            <div class="pt-2 d-flex">
              <div class="text-body-2 pr-2">
                <span style="color: #76778e;">Live Auctions: </span>
                <span>{{ counter.liveAuctions }}</span>
              </div>
              <div class=" text-body-2 pl-2">
                <span style="color: #76778e;">Time Auctions: </span>
                <span> {{ counter.timeAuctions }}</span>
              </div>
            </div>


          </v-container>
        </v-card>
      </v-col>
      <!-- Total Auctions -->
      <v-col cols="12" sm="6" md="3" class="">

        <v-card class="border-bottom w-100">
          <v-container>

            <div class="d-flex h-6 align-center  ">
              <div style="background: #0080ff38;border-radius: 22px;padding: 4px 6px;" class=" circle">
                <v-icon size="32" color="primary">mdi-circle</v-icon>
              </div>
              <span class="text-h4 px-1">{{ counter.inprogress_Auctions }}</span>
            </div>

            <div class="pt-3 text-body-1 text-light ">Inprogress Auctions</div>
            <div class="pt-2 d-flex">
              <div class="text-body-2 pr-2">
                <span style="color: #76778e;">Inprogress Auctions: </span>
                <span>{{ counter.inprogress_Auctions }}</span>
              </div>

            </div>


          </v-container>
        </v-card>
      </v-col>
      <!-- Total Auctions -->
      <v-col cols="12" sm="6" md="3" class="">

        <v-card class="border-bottom w-100">
          <v-container>

            <div class="d-flex h-6 align-center  ">
              <div style="background: #0080ff38;border-radius: 22px;padding: 4px 6px;" class=" circle">
                <v-icon size="32" color="primary">mdi-circle</v-icon>
              </div>
              <span class="text-h4 px-1">{{ counter.totalVehicles }}</span>
            </div>

            <div class="pt-3 text-body-1 text-light ">Total Vehicles</div>
            <div class="pt-2 d-flex">
              <div class="text-body-2 pr-2">
                <span style="color: #76778e;">Total Vehicles:</span>
                <span>{{ counter.totalVehicles }}</span>
              </div>
            </div>


          </v-container>
        </v-card>
      </v-col>

      <v-col cols="12" sm="6" md="3" class="">

        <v-card class="border-bottom w-100">
          <v-container>

            <div class="d-flex h-6 align-center  ">
              <div style="background: #0080ff38;border-radius: 22px;padding: 4px 6px;" class=" circle">
                <v-icon size="32" color="primary">mdi-circle</v-icon>
              </div>
              <span class="text-h4 px-1">{{ counter.vehicleReauctions }}</span>
            </div>

            <div class="pt-3 text-body-1 text-light ">Vehicle in reauctions</div>
            <div class="pt-2 d-flex">
              <div class="text-body-2 pr-2">
                <span style="color: #76778e;">Vehicles:</span>
                <span>{{ counter.vehicleReauctions }}</span>
              </div>

            </div>


          </v-container>
        </v-card>
      </v-col>
    </v-row>

    <v-container />



    <v-row>
      <v-col cols="12" md="6">
        <!-- Online Auction -->
        <v-card class="mb-5 border" title="Online Auction">
          <template v-slot:append>
            <div class="d-none d-sm-block">
              <v-select v-model="onlineAction.platformsId" :items="platforms" label="Select Platform" variant="outlined"
                density="compact" max-width="200px" min-width="200px" hide-details />
            </div>
          </template>

          <div class="border-b"></div>

          <v-card-text>
            <v-select v-model="onlineAction.platformsId" :items="platforms" label="Select Platform" variant="outlined"
              density="compact" hide-details class="d-block d-sm-none mb-3" />

            <v-table density="comfortable">
              <thead>
                <tr>
                  <th class="text-left">PLATFORM</th>
                  <th>Type Of Action</th>
                  <th class="text-left">TOTAL AUCTION</th>
                  <th class="text-left">REMAINING</th>
                  <th class="text-left">LOTS</th>
                </tr>
              </thead>

              <tbody>
                <tr v-if="onlineAction.isLoadingOnline">
                  <td colspan="5">
                    <v-progress-linear color="primary" indeterminate />
                  </td>
                </tr>

                <tr v-else-if="onlineAction.data.length" v-for="item in onlineAction.data"
                  :key="item.auction_platform_name">
                  <td>{{ item.auction_platform_name }}</td>
                  <td>{{ item.auction_type }}</td>
                  <td>{{ item.car_count }}</td>
                  <td>{{ item.remaining }}</td>
                  <td>{{ item.lots }}</td>
                </tr>

                <tr v-else>
                  <td colspan="5" class="text-center py-4 text-grey">No data found</td>
                </tr>
              </tbody>
            </v-table>
          </v-card-text>
        </v-card>

        <!-- Time Auction -->
        <v-card title="Time Auction">
          <template v-slot:append>
            <div class="d-none d-sm-block">
              <v-select v-model="timeAutions.platformsId" :items="platforms" label="Select Platform" variant="outlined"
                density="compact" max-width="200px" min-width="200px" hide-details />
            </div>
          </template>

          <div class="border-b"></div>

          <v-card-text>
            <v-select v-model="timeAutions.platformsId" :items="platforms" label="Select Platform" variant="outlined"
              density="compact" hide-details class="d-block d-sm-none mb-3" />

            <v-table density="comfortable">
              <thead>
                <tr>
                  <th class="text-left">PLATFORM</th>
                  <th class="text-left">TOTAL</th>
                  <th class="text-left">END TIME</th>
                </tr>
              </thead>

              <tbody>
                <tr v-if="timeAutions.isLoadingOnline">
                  <td colspan="3">
                    <v-progress-linear color="primary" indeterminate />
                  </td>
                </tr>

                <tr v-else-if="timeAutions.data.length" v-for="item in timeAutions.data"
                  :key="item.auction_platform_name">
                  <td>{{ item.auction_platform_name }}</td>
                  <td>{{ item.totalVehicles }}</td>
                  <td>{{ item.timeEnd }}</td>
                </tr>

                <tr v-else>
                  <td colspan="3" class="text-center py-4 text-grey">No data found</td>
                </tr>
              </tbody>
            </v-table>
          </v-card-text>
        </v-card>
      </v-col>

      <!-- Right Column: Vehicle Statistics -->
      <v-col cols="12" md="6">
        <v-card title="Vehicle Statistics" subtitle="Today">
          <v-card-text class="d-flex flex-column h-100 justify-space-between">
            <v-container>
              <v-row class="mt-5">
                <v-col cols="12">
                  <div class="text-h3 font-weight-bold">254</div>
                  <div class="text-body-2 text-light mb-6">Remaining</div>
                </v-col>
              </v-row>

              <v-row>
                <v-col cols="12">

                  <div v-if="vehicelState.isLoadingOnline" class="text-center py-5">
                    <v-progress-circular indeterminate color="primary" />
                  </div>

                  <div v-else>
                    <div class="d-flex align-center mb-3">
                      <div style="background:#0080ff38;border-radius:22px;padding:4px 6px;">
                        <v-icon size="32" color="primary">mdi-circle</v-icon>
                      </div>
                      <div class="pl-3 d-flex">
                        <div class="text-h5 font-weight-bold">
                          {{ vehicelState.inprogress_vehicles }}
                        </div>
                        <div class="text-h5 text-grey-lighten-1 ml-2">provisional</div>
                      </div>
                    </div>

                    <div class="d-flex align-center mb-3">
                      <div style="background:#0080ff38;border-radius:22px;padding:4px 6px;">
                        <v-icon size="32" color="primary">mdi-circle</v-icon>
                      </div>
                      <div class="pl-3 d-flex">
                        <div class="text-h5 font-weight-bold">{{ vehicelState.sold_vehicles }}</div>
                        <div class="text-h5 text-grey-lighten-1 ml-2">Sold</div>
                      </div>
                    </div>

                    <div class="d-flex align-center">
                      <div style="background:#0080ff38;border-radius:22px;padding:4px 6px;">
                        <v-icon size="32" color="primary">mdi-circle</v-icon>
                      </div>
                      <div class="pl-3 d-flex">
                        <div class="text-h5 font-weight-bold">{{ vehicelState.not_sold }}</div>
                        <div class="text-h5 text-grey-lighten-1 ml-2">Not Sold</div>
                      </div>
                    </div>
                  </div>

                </v-col>
              </v-row>
            </v-container>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>


  </v-container>

</template>

<script>
import api from '@/plugins/axios';

export default {
  name: 'AuctionDashboard',

  data() {
    return {
      onlinePlatform: null,
      timePlatform: null,
      platforms: [],


      counter: {
        total_Auctions: 1,
        liveAuctions: 2,
        timeAuctions: 3,
        inprogress_Auctions: 4,
        totalVehicles: 5,
        vehicleReauctions: 6,
        isLoadingOnline: false
      },


      onlineAction: {
        data: [],
        platformsId: null,
        isLoadingOnline: false
      },


      timeAutions: {
        data: [],
        platformsId: null,
        isLoadingOnline: false
      },


      vehicelState:
      {
        isLoadingOnline: false,
        onsale_vehicles: 2,
        provisional_vehicles: 3,
        sold_vehicles: 5,
        not_sold : 0,
      }

    }
  },
  computed: {
    
    // getCounter() {

    //   return {
    //     totalAuctions: {
    //       title: 'Total Auctions',
    //       live_auctions: '',
    //       time_auctions: '',
    //     },
    //     inprogressAuctions: {
    //       title: 'Inprogress Auctions',
    //       vehicles: '',
    //     },
    //     totalVehicles: {
    //       title: 'Total Vehicles',
    //       sold: ''
    //     },
    //     vehicleinReauctions: {
    //       title: 'Vehicle in reauctions',
    //       vehicle: '',
    //     }
    //   }
    // }

  },
  methods: {

    async getCountData() {
      this.counter.isLoadingOnline = true;
      try {

        let res = await api.get("/api/user/dashboard/counters");
        this.counter.total_Auctions = res.data.data.total_auctions;
        this.counter.inprogress_Auctions = res.data.data.vehicles_in_progress_auctions;
        this.counter.totalVehicles = res.data.data.total_vehicles;
        this.counter.vehicleReauctions = res.data.data.vehicles_in_reauction
        this.counter.isLoadingOnline = false;

      } catch (error) {
        this.counter.isLoadingOnline = false;
        console.error(error.message, "counters Api error");
      }
    },



    async getOnlineAction() {
      this.onlineAction.isLoadingOnline = true;
      try {
        let res = await api.get("/api/user/dashboard/onlineAuctions");
        this.onlineAction.data = res.data.data;
        this.onlineAction.isLoadingOnline = false;
      } catch (error) {
        console.error(error.message, "onlineAuction Api error");
        this.onlineAction.isLoadingOnline = false;
      }
    },


    async getTimeAction() {
      this.timeAutions.isLoadingOnline = true;
      try {
        let res = await api.get("/api/user/dashboard/timeAuctions");
        this.timeAutions.data = res.data.data;
        this.timeAutions.isLoadingOnline = false;
      } catch (error) {
        alert("Time Action Data not fetch", error)
        this.timeAutions.isLoadingOnline = false;
      }
    },



    async getVehicleStates() {
      this.vehicelState.isLoadingOnline = true;
      try {
        let res = await api.get("/api/user/dashboard/vehicleStates");
        this.vehicelState.inprogress_vehicles = res.data.data.inprogress_vehicles;
        this.vehicelState.sold_vehicles = res.data.data.sold_vehicles


        this.vehicelState.data = res.data.data;
        this.vehicelState.isLoadingOnline = false;
      } catch (error) {
        console.error(error.message, "vehicleStates Api error");
        this.timeAutions.isLoadingOnline = false
      }
    }
  },



  mounted() {
    this.getCountData();
    this.getOnlineAction();
    this.getVehicleStates();
  }

  
}

</script>

<style scoped>
.bg-primary-darken-1 {
  background-color: #0d1b2a;
}

.blink {
  animation: blinker 1.5s linear infinite;
}

@keyframes blinker {
  50% {
    opacity: 0.4;
  }
}

.border-x {
  border-left: 1px solid rgba(255, 255, 255, 0.12) !important;
  border-right: 1px solid rgba(255, 255, 255, 0.12) !important;
}

.border-l {
  border-left: 1px solid rgba(255, 255, 255, 0.12) !important;
}


.border-bottom {
  border-bottom: 5px solid rgb(var(--v-theme-primary)) !important;
}
</style>