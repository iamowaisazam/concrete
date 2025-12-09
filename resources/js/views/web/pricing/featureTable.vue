<template>
    <v-container fluid class="pa-0 bg-surface" >



        <!-- Desktop Table -->
        <v-container class="py-8" max-width="1500px">
            <div class="text-start py-4 ">
                <h2 class="text-h5 font-weight-bold ">
                    Compare features and model access across all plans
                </h2>
            </div>
            <v-table class="border-thin">
                <thead>
                    <tr class="text-white ">
                        <th class="text-left text-subtitle-1 font-weight-bold pa-4 bg-surface"></th>
                        <th v-for="plan in plans" :key="plan.name" class="text-start pa-4 bg-surface">
                            <div class="d-flex  align-center bg-surface">
                                <v-icon small class="">{{ plan.icon }}</v-icon>
                                <span class="font-weight-medium">{{ plan.name }}</span>
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody class="text-white">
                    <template v-for="(group, groupName) in features" :key="groupName">
                        <!-- Group Header -->
                        <tr v-if="groupName !== 'General'">
                            <td colspan="6" class="text-subtitle-1 font-weight-bold pa-4">
                                {{ groupName }}
                            </td>
                        </tr>

                        <!-- Features Rows -->
                        <tr v-for="(feature, featureName) in group" :key="featureName">
                            <td class="pa-4 font-weight-medium">{{ featureName }}</td>
                            <td v-for="(value, planIndex) in feature" :key="planIndex" class="text-start pa-4">
                                <template v-if="typeof value === 'boolean'">
                                    <v-icon v-if="value" color="primary" class=" border-thin">mdi-check-circle</v-icon>
                                    <v-icon v-else>mdi-close-circle</v-icon>
                                </template>
                                <template v-else-if="typeof value === 'string' && value.includes('images')">
                                    <span class="text-caption">{{ value }}</span>
                                </template>
                                <template v-else>
                                    <span class="text-caption">{{ value }}</span>
                                </template>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </v-table>
        </v-container>
    </v-container>
</template>

<script setup>
const plans = [
    { name: 'Free', icon: 'mdi-help-circle-outline', mostPopular: false },
    { name: 'Entry', icon: 'mdi-lightbulb-outline', mostPopular: false },
    { name: 'Core', icon: 'mdi-fire', mostPopular: false },
    { name: 'Plus', icon: 'mdi-flash', mostPopular: true },
    { name: 'Ultra', icon: 'mdi-rocket-launch', mostPopular: false }
]

const features = {
    General: {
        'Dashboard & Insights': [true, true, true, true, true],
        'Auction Overview': ['40 /day', '3,000 /month', '15,000 /month', '35,000 /month', '100,000 /month'],
        'Interest Based': [1, 2, 4, 8, 10],
        'Watched List': ['30 days', 'Unlimited', 'Unlimited', 'Unlimited', 'Unlimited'],
        'Alerted List': [false, true, true, true, true],
        'Vehicle Sales Overview': [false, true, true, true, true]
    },
    'Interest Based': {
        'Save Custom Search (Interest)': ['40 images', '3,000 images', '15,000 images', '35,000 images', '100,000 images'],
        'Discover Matching Auctions': ['8 images', '600 images', '3,000 images', '7,000 images', '20,000 images'],
        'Past Auction Records': ['1 image', '120 images', '600 images', '1,400 images', '4,000 images'],
        '3-Month Price Trend Graph': [false, '100 images', '500 images', '1,166 images', '3,333 images'],
        'Real-Time Vehicle Valuation': [false, '6.6 images', '333 images', '777 images', '2,222 images'],
        'Best Auction Match Finder': [false, '6.6 images', '333 images', '777 images', '2,222 images']
    },
    'Auction Data': {
        'Auction Market Snapshot': ['40 images', '3,000 images', '15,000 images', '35,000 images', '100,000 images'],
        'Live Online Auctions': ['8 images', '600 images', '3,000 images', '7,000 images', '20,000 images'],
        'Scheduled Timed Auctions': ['1 image', '120 images', '600 images', '1,400 images', '4,000 images'],
        'Auction Vehicle Insights': [false, '100 images', '500 images', '1,166 images', '3,333 images'],
        'Auction Alerts & Notifications': [false, '6.6 images', '333 images', '777 images', '2,222 images'],
        'Live Auction Screen': [false, '6.6 images', '333 images', '777 images', '2,222 images'],
        'Auction Schedule': [false, '6.6 images', '333 images', '777 images', '2,222 images'],
        'Reaction Tracker': [false, '6.6 images', '333 images', '777 images', '2,222 images'],
        'Upcoming Auction Vehicles': [false, '6.6 images', '333 images', '777 images', '2,222 images'],
        'Historical Auction Data': [false, '6.6 images', '333 images', '777 images', '2,222 images']
    },
    'Vehicle Valuation': {
        'Instant Vehicle Valuation': ['40 images', '3,000 images', '15,000 images', '35,000 images', '100,000 images'],
        'Smart Bid Recommendation': ['8 images', '600 images', '3,000 images', '7,000 images', '20,000 images']
    },
    More: {
        'Comparison Tool': ['40 images', '3,000 images', '15,000 images', '35,000 images', '100,000 images'],
        'VIN Report Credits': ['8 images', '600 images', '3,000 images', '7,000 images', '20,000 images'],
        'Industry News & Insights': ['8 images', '600 images', '3,000 images', '7,000 images', '20,000 images'],
        'Sub-User Account Access': ['8 images', '600 images', '3,000 images', '7,000 images', '20,000 images'],
        'Light/Dark Mode': ['8 images', '600 images', '3,000 images', '7,000 images', '20,000 images'],
        'Advanced Search Filters': ['8 images', '600 images', '3,000 images', '7,000 images', '20,000 images']
    }
}
</script>

