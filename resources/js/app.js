import { createApp } from "vue";
import App from "./app.vue";


//Plugins
import vuetify from '@/plugins/vuetify'
import router from "./routes";
import pinia,{registerStores} from "./stores";
import registerTags from "./tags";
import "./style.css";




const render = createApp(App);
render.use(pinia);
render.use(router);
render.use(vuetify); 

registerTags(render)
registerStores(render)




render.mount("#userApp");



