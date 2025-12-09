<template>
    <!-- <custom-card title="Payment Methods"> -->
    <v-col cols="12" md="5">
        <v-card class="rounded-xl pa-6 d-flex flex-wrap align-center justify-space-between" color="#1e1e2e" elevation="4">
            <div class="d-flex align-center">
                <div class="mr-6">
                    <!-- Mastercard Logo Placeholder -->
                    <div class="mastercard-logo">
                        <v-avatar size="48">
                            <v-img
                                src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/2a/Mastercard-logo.svg/1280px-Mastercard-logo.svg.png"></v-img>
                        </v-avatar>
                    </div>
                </div>
                <div>
                    <div class="text-white text-h6 font-weight-medium">•••• •••• ••••</div>
                    <div class="text-grey-lighten-2 text-caption">
                        Card expires at 12/12
                    </div>
                </div>
            </div>

            <v-btn variant="text" color="red-accent-2" class="text-capitalize pl-0">
                Delete
            </v-btn>
        </v-card>
    </v-col>

    <!-- <v-container fluid class="pa-8 pa-md-12 bg-#0f0f1e">
        <v-radio-group v-model="selectedMethod" inline class="mb-8">

            <v-radio label="Credit/Debit/ATM Card" value="card" color="primary" class="text-white text-body-1" />

            <v-radio label="Paypal account" value="paypal" color="primary" class="text-white ml-8 text-body-1" />
        </v-radio-group>

        <v-row>
            <v-col cols="12" md="7">
                <v-form>
                    <v-row class="mb-4">
                        <v-col cols="12">
                            <label class="text-caption  mb-2 d-block">
                                Card Number
                            </label>
                            <v-text-field v-model="cardNumber" placeholder="1356 3215 6548 7898" variant="outlined"
                                density="comfortable" hide-details readonly bg-color="#1e1e2e" class="rounded-lg" />
                        </v-col>
                    </v-row>

                    <v-row>
                        <v-col cols="12" sm="6">
                            <label class="text-caption  mb-2 d-block">Name</label>
                            <v-text-field v-model="cardName" placeholder="John Doe" variant="outlined"
                                density="comfortable" hide-details bg-color="#1e1e2e-" class="rounded-lg" />
                        </v-col>

                        <v-col cols="6" sm="3">
                            <label class="text-caption  mb-2 d-block">Exp. Date</label>
                            <v-text-field v-model="expDate" placeholder="MM/YY" variant="outlined" density="comfortable"
                                hide-details bg-color="#1e1e2e" class="rounded-lg" />
                        </v-col>

                        <v-col cols="6" sm="3">
                            <label class="text-caption  mb-2 d-block">CVV Code</label>
                            <v-text-field v-model="cvv" placeholder="654" variant="outlined" density="comfortable"
                                hide-details type="password" bg-color="#1e1e2e" class="rounded-lg" />
                        </v-col>
                    </v-row>

                    <div class="mt-8">
                        <v-btn color="primary" class="mx-2">
                            Save Changes
                        </v-btn>
                        <v-btn variant="tonal" color="mx-2 grey-darken-1">
                            Cancel
                        </v-btn>
                    </div>
                </v-form>
            </v-col>

      
        </v-row>
    </v-container> -->
    <!-- </custom-card> -->

</template>

<script>
export default {
    name: 'PaymentMethods',

    data() {
        return {
            selectedMethod: 'card',
            cardNumber: '1356 3215 6548 7898',
            cardName: 'John Doe',
            expDate: '12/24',
            cvv: '654'
        }
    }
}
</script>

<style scoped>
.v-application {
    background: #0f0f1e !important;
}

.mastercard-logo {
    width: 60px;
    filter: brightness(0) invert(1);
    /* makes it white if needed */
}
</style>