<template>
    <div class="d-flex justify-center pt-2 align-center flex-wrap">

        <v-btn
            icon
            
          
            :disabled="page === 1 || loading"
            @click="changePage(1)"
            >
           <v-icon>mdi-page-first</v-icon>
        </v-btn>
        <!-- Previous Button -->
        <v-btn
            icon
            :disabled="page === 1 || loading"
            @click="changePage(page - 1)"
        >
            <v-icon>mdi-chevron-left</v-icon>
        </v-btn>

        <v-btn icon
            v-for="(n,i) in displayedPages"
                :key="n"
                :disabled="loading"
                :color="n === page ? 'primary' : ''"
                @click="changePage(n)"
                >
            {{ n }}
        </v-btn>

        <v-btn
            icon
            :disabled="page === lastPage || loading"
            @click="changePage(page + 1)"
        >
            <v-icon>mdi-chevron-right</v-icon>
        </v-btn>

          <!-- Last Button -->
        <v-btn
        icon
        :disabled="page === lastPage || loading"
        @click="changePage(lastPage)"
        >
        <v-icon>mdi-page-last</v-icon>
        </v-btn>

    </div>
</template>

<script>

export default {
    props: {
        page: {
          default: 1, 
        },
        lastPage: {
          default: 0, 
        },
        loading: {
          default: false, 
        },
    },
    data() {
        return {
            
        }
    },
    computed: {
         displayedPages() {

            // Show up to 5 pages starting from current page
            const pages = []
            const max = 10
            let start = Math.max(this.page - 2, 1)
            let end = Math.min(start + max - 1, this.lastPage)

            // adjust start if end is at last page
            start = Math.max(end - max + 1, 1)

            for (let i = start; i <= end; i++) {
                pages.push(i)
            }

            return pages;

        }
    },
    methods: {
        changePage(i) {
            this.$emit('update:page', i)
            this.$emit('page-changed', i)
        }
    }
};

</script>

<style>

</style>