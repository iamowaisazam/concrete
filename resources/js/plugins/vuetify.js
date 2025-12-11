// plugins/vuetify.js
import { createVuetify } from "vuetify";
import * as components from "vuetify/components";
import * as directives from "vuetify/directives";

// Icon sets
import { aliases, mdi } from 'vuetify/iconsets/mdi';
import { fa } from 'vuetify/iconsets/fa';
import { md } from 'vuetify/iconsets/md';

// Styles
import "vuetify/styles";
import '@fontsource/inter';
import '@mdi/font/css/materialdesignicons.css';
import '@fortawesome/fontawesome-free/css/all.css';
import 'material-design-icons-iconfont/dist/material-design-icons.css';


const vuetify = createVuetify({
    components,
    directives,
    defaults: {
        global: {
            style: {
                fontFamily: 'Inter, sans-serif',
            },
        },
        VBtn: {
            ripple: false,
            style: {
                '--v-btn-overlay-opacity': 0
            },
            class: 'no-overlay text-capitalize font-weight-medium',
        },
        VCard: {
            rounded: 0,
            elevation: 0,
            variant: "flat",
            class:"pa-2"
        },
        VCardTitle: {
         class: "text-h6 font-weight-medium"   
        },
        VTextField: {
            color:'primary',
            baseColor:'inputColor',
            variant: 'outlined',
            density: 'compact',
            hideDetails: 'auto',
            class: 'force-38px',
            height: 38,
        },
        VSelect: {
            color:'primary',
            baseColor:'inputColor',
            variant: 'outlined',
            density: 'compact',
        }
    },
    theme: {
        defaultTheme: "adminLight",
        themes: {
            adminLight: {
                dark: false,
                colors: {
                    primary: "#0080ff",
                    'primary-lighten-1': '#8579F2',

                    background: "#EBEFF3",
                    'on-background': '#212529',
                    
   
                    surface: "#FFFFFF",
                    'on-surface':'#0f1c2b',

                    'surface-variant-1': "#e9eff6",
                    
                    nav:"#0f1c2b",

                    inputColor:"#36383aff",
               
                   
                
                    border: "#B1BFCD",
                    danger: "#b91c1c",
                    success: "#4CAF50",
                    warning: "#FB8C00",
                    error: "#FF5252",
                    info: "#2196F3",
                    shadow: "#E1EBEE",
                   
                },
                variables:{
                    'border-color': '#e0e0e0',
                    // 'border-opacity': 1,
                    'border-opacity': 0.38,
                    'input-color': '#e71b1bff' // Text color inside inputs
                }


            },
        },
    },
    icons: {
        defaultSet: 'mdi', // default icon set
        aliases,
        sets: { mdi, fa, md, },
    },
});




export default vuetify;
