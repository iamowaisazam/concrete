<template>
    <v-container fluid class="fill-height">
        <v-row align="center" justify="center">
            <v-col cols="12" sm="10" md="8" lg="6" xl="5">
                <v-card elevation="0" class="text-center pa-8" color="transparent">
                    <!-- Animated 404 SVG -->
                    <div class="mb-8">
                        <svg width="300" height="200" viewBox="0 0 300 200" xmlns="http://www.w3.org/2000/svg"
                            class="mx-auto">
                            <!-- Background circles for effect -->
                            <circle cx="60" cy="100" r="40" fill="#E3F2FD" opacity="0.5">
                                <animate attributeName="r" values="40;45;40" dur="2s" repeatCount="indefinite" />
                            </circle>
                            <circle cx="240" cy="100" r="40" fill="#E3F2FD" opacity="0.5">
                                <animate attributeName="r" values="40;45;40" dur="2s" repeatCount="indefinite"
                                    begin="1s" />
                            </circle>

                            <!-- 4 -->
                            <path d="M 40 60 L 40 100 L 70 100 M 70 50 L 70 120" stroke="#1976D2" stroke-width="12"
                                fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <animate attributeName="stroke-dasharray" values="0,200;200,0" dur="1.5s"
                                    fill="freeze" />
                            </path>

                            <!-- 0 (center) -->
                            <ellipse cx="150" cy="100" rx="35" ry="50" fill="none" stroke="#1976D2" stroke-width="12">
                                <animate attributeName="opacity" values="0;1" dur="0.5s" begin="0.5s" fill="freeze" />
                            </ellipse>

                            <!-- Eye wink effect -->
                            <circle cx="140" cy="90" r="4" fill="#1976D2">
                                <animate attributeName="opacity" values="1;0;1" dur="3s" repeatCount="indefinite"
                                    begin="2s" />
                            </circle>
                            <circle cx="160" cy="90" r="4" fill="#1976D2" />

                            <!-- Smile -->
                            <path d="M 135 110 Q 150 120 165 110" stroke="#1976D2" stroke-width="3" fill="none"
                                stroke-linecap="round">
                                <animate attributeName="opacity" values="0;1" dur="0.5s" begin="1s" fill="freeze" />
                            </path>

                            <!-- 4 (right) -->
                            <path d="M 220 60 L 220 100 L 250 100 M 250 50 L 250 120" stroke="#1976D2" stroke-width="12"
                                fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <animate attributeName="stroke-dasharray" values="0,200;200,0" dur="1.5s"
                                    fill="freeze" />
                            </path>
                        </svg>
                    </div>

                    <!-- Title -->
                    <v-card-title class="text-h3 font-weight-bold justify-center mb-4 text-primary">
                        Oops! Page Not Found
                    </v-card-title>

                    <!-- Subtitle -->
                    <v-card-text class="text-primary-lighten-1">
                        <p class="text-h6 text-medium-emphasis mb-2">
                            The page you're looking for seems to have wandered off.
                        </p>
                        <p class="text-body-1 text-medium-emphasis">
                            Don't worry, even the best explorers lose their way sometimes!
                        </p>
                    </v-card-text>

                    <!-- Action Buttons -->
                    <v-card-actions class="justify-center mt-6">
                        <v-btn color="primary" size="large" prepend-icon="mdi-undo-variant" variant="elevated" to="/"
                            class="px-8">
                            Go Back
                        </v-btn>
                    </v-card-actions>

                    <!-- Additional Help -->
                    <v-card-text class="mt-8">
                        <v-divider class="mb-6"></v-divider>
                        <p class="text-body-2 text-medium-emphasis mb-4">
                            Need help? Try these:
                        </p>
                        <v-row dense justify="center">
                            <v-col cols="auto">
                                <v-btn variant="text" size="small" prepend-icon="mdi-arrow-left" to="/">
                                    Go Back
                                </v-btn>
                            </v-col>
                            <v-col cols="auto">
                                <v-btn variant="text" size="small" prepend-icon="mdi-refresh" @click="refresh">
                                    Refresh
                                </v-btn>
                            </v-col>
                            <v-col cols="auto">
                                <v-btn variant="text" size="small" prepend-icon="mdi-help-circle" @click="getHelp">
                                    Contact Support
                                </v-btn>
                            </v-col>
                        </v-row>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script setup>
const refresh = () => {
    console.log('Refreshing page...');
    window.location.reload();
};

const getHelp = () => {
    console.log('Opening support...');
    alert('Support contact feature would open here!');
};
</script>

<style scoped>
.fill-height {
    min-height: 100vh;
    background: linear-gradient(135deg, #E3F2FD 0%, #BBDEFB 100%);
}

.v-card {
    transition: all 0.3s ease;
}

.v-btn {
    transition: transform 0.2s ease;
}

.v-btn:hover {
    transform: translateY(-2px);
}

svg {
    max-width: 100%;
    height: auto;
}
</style>