<template>
    <v-app class="bg-primary">
        <div
            class="position-absolute bottom-0 left-0 right-0 h-50 bg-primary"
            style="z-index: 0; clip-path: polygon(0 29%, 100% 0, 100% 100%, 0% 100%);"
        ></div>

        <v-main class="h-screen d-flex align-center justify-center" style="z-index: 10;">
            <v-container fluid class="d-flex justify-center align-center">
                <v-row justify="center">
                    <v-col cols="12" sm="8" md="6" lg="4">
                        <v-card elevation="10" rounded="lg" class="py-6 px-4">
                            <v-card-title class="text-center text-h5 font-weight-medium">
                                Forgot Password
                            </v-card-title>

                            <v-card-subtitle class="text-center mb-4">
                                Enter your email to receive a password reset link
                            </v-card-subtitle>

                            <v-card-text>
                                <v-text-field
                                    v-model="form.email"
                                    type="email"
                                    label="Email Address"
                                    prepend-inner-icon="mdi-email-outline"
                                    variant="outlined"
                                    density="comfortable"
                                    color="primary"
                                    :error="!!errors.email"
                                    :error-messages="errors.email"
                                />
                            </v-card-text>

                            <v-card-actions>
                                <v-btn
                                    color="primary"
                                    block
                                    size="large"
                                    :loading="loading"
                                    @click="sendResetLink"
                                >
                                    Send Reset Link
                                </v-btn>
                            </v-card-actions>

                            <v-divider class="my-4" />

                            <div class="text-center">
                                <v-btn
                                    variant="text"
                                    color="primary"
                                    @click="$router.push('/login')"
                                >
                                    Back to Login
                                </v-btn>
                            </div>
                        </v-card>
                    </v-col>
                </v-row>
            </v-container>
        </v-main>
    </v-app>
</template>

<script>
import { useAlertStore } from "@stores/alertStore";
import axios from "axios";

export default {
    name: "ForgotPassword",
    data() {
        return {
            alertStore: useAlertStore(),
            loading: false,
            errors: {},
            form: {
                email: "",
            },
        };
    },

};
</script>

<style scoped>
</style>
