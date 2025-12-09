import { createPinia } from 'pinia'
import { useAlertStore } from './alertStore';
import { useThemeStore } from './themeStore';
import { toRaw } from 'vue';

const pinia = createPinia()

pinia.use(({ store }) => {
  store.$subscribe((mutation, state) => {

    console.log(`[STORE CHANGE] ${store.$id}`)
    // console.log('Mutation:', mutation)
    console.log('New State:',toRaw(state))

  })
})


export function registerStores(app) {
  app.config.globalProperties.$alertStore = useAlertStore();
  app.config.globalProperties.$themeStore = useThemeStore();
}

export default pinia