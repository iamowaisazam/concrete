<template>
    <v-menu class="menuLabel" location="bottom" transition="fade-transition">
        <template #activator="{ props }">
            <v-btn icon size="small" v-bind="props" class="notificationBtn">
                <v-icon icon="mdi-bell-outline"></v-icon>
            </v-btn>
        </template>

        <v-list elevation="0" class="rounded-lg border z-3 animate-fade-in w-[352px]" @click.stop>
            <v-list-item>
                <v-list-item-title class="d-flex justify-space-between align-center ps-4 p-3 w-100">
                    <div class="text-h6">Notifications</div>
                    <div class="d-flex align-center ga-2">
                        <div class="bg-primary rounded-sm text-sm-caption font-weight-light ps-2 pe-2 text-lowercase">
                            8 new
                        </div>
                        <span class="material-symbols-outlined text-h6">
                            drafts
                        </span>
                    </div>
                </v-list-item-title>
            </v-list-item>
            <v-divider></v-divider>
            <v-list>
                <v-list-item v-for="(note, i) in notifications" :key="i" link class="transition-all duration-200">
                    <v-list-item-title>
                        <div class="d-flex align-start cursor-pointer overflow">
                            <div class="d-flex align-center justify-center pt-2 ps-2">
                                <div class="icon-notify-container  rounded-circle d-flex align-center justify-center">
                                    <v-icon icon="mdi-bell-ring" color="primary" size="small"></v-icon>
                                </div>
                            </div>

                            <div class="pt-2 ps-4 w-75">
                                <div class="text-caption">
                                    {{ note.title }}
                                </div>
                                <div class="text-caption">
                                    {{ note.description }}
                                </div>
                                <p class="mt-2 text-caption text-[#76778e]">
                                    {{ note.time }}
                                </p>
                            </div>
                            <div>
                                <div class="blue-dot bg-primary rounded-circle mt-5"></div>
                            </div>
                        </div>
                    </v-list-item-title>
                </v-list-item>
            </v-list>

            <v-divider></v-divider>

            <v-list-item>
                <v-list-item-title>
                    <div class="d-flex justify-center align-center p-2 ps-3 mt-2">
                        <button class="notificationbtn bg-primary pt-2 pb-2 ps-2 border-0 rounded">
                            View All Notifications
                        </button>
                    </div>
                </v-list-item-title>
            </v-list-item>
        </v-list>
    </v-menu>
</template>

<script>

export default {
    name: "NotificationMenu",
    data() {
        return {
            notifications: [
                {
                    title: "New Message",
                    description: "You have received a new message.",
                    time: "2m ago",
                },
                {
                    title: "Server Alert",
                    description: "Server CPU usage is high.",
                    time: "10m ago",
                },
                {
                    title: "Payment Received",
                    description: "Payment of $100 has been completed.",
                    time: "1h ago",
                },
            ],
        };
    },
};
</script>

<style scoped>
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.icon-notify-container {
    height: 40px;
    width: 40px;
}

.blue-dot {
    height: 8px;
    width: 8px;
}

.notificationbtn {
    width: 90%;
}

</style>
