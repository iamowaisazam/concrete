<template>
    <v-container max-width="1300px" fluid>
        <v-row>
            <v-col cols="12">
                <div class="d-flex flex-wrap">
                    <div class="px-2 py-2">
                        <v-btn to="/user/settings/profile" class="text-capitalize"
                            :class="{ 'bg-primary': this.$route.params.id == 'profile' } " variant="flat"
                            prepend-icon="mdi-eye" >Account</v-btn>
                    </div>
                    <div class="px-2 py-2">
                        <v-btn to="/user/settings/security" class="text-capitalize" variant="flat"
                        :class="{ 'bg-primary': this.$route.params.id == 'security' }"
                            prepend-icon="mdi-lock">Security</v-btn>
                    </div>
                    <div class="px-2 py-2">
                        <v-btn to="/user/settings/billing" class="text-capitalize" variant="flat" 
                        :class="{ 'bg-primary': this.$route.params.id == 'billing' }"
                        prepend-icon="mdi-card-text">Billing
                            & Plans</v-btn>
                    </div>
                    <!-- <div class="px-2 py-2">
                        <v-btn to="/user/settings/notification" class="text-capitalize" variant="flat"
                        :class="{ 'bg-primary': this.$route.params.id == 'notification' }"
                            prepend-icon="mdi-bell">Notifications</v-btn>
                    </div> -->
                </div>
            </v-col>
        </v-row>
    </v-container>

    <v-container max-width="1300px" fluid>
        <v-row>
             <component :is="currentComponent" />
        </v-row>
    </v-container>
</template>

<script>

import profile from "./profile.vue";
import security from "./security.vue";
import billing from "./billing.vue";
import notification from "./notification.vue";


export default {
    components: {
        profile,
        security,
        billing,
        notification
    },
    data() {
        return {
            activeTab: this.$route.params.id,
        };
    },
    watch: {
        '$route.params.id'(newVal) {
            this.activeTab = newVal;
        }
    },
    computed: {
        currentComponent() {
            switch (this.activeTab) {
                case "profile":
                    return profile
                case "security":
                    return security
                case "billing":
                    return billing;
                case "notification":
                    return notification
                default:
                    return profile
            }
        },
    },
};
</script>
