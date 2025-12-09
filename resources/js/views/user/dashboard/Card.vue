<template>
    <v-card class="mb-5 border" title="Online Auction">
        <template v-slot:append>
            <div class="d-none d-sm-block">
                <v-select v-model="onlineAction.platformsId" label="Select Platform" variant="outlined"
                    density="compact" max-width="200px" min-width="200px" hide-details />
            </div>
        </template>

        <div class="border-b"></div>

        <v-card-text>
            <v-select v-model="onlineAction.platformsId" label="Select Platform" variant="outlined" density="compact"
                hide-details class="d-block d-sm-none mb-3" />

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

</template>


<script>



export default {
    name: 'AuctionDashboard',

    data() {
        return {
            onlineAction: {
                isLoadingOnline: false,
                platformsId: null,
                data: [],
            },
        }
    },
    computed: {

    },
    mounted() {

    },
    methods: {



    },






}
</script>