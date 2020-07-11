import './bootstrap';
import './template';

import Vue from 'vue';
import Servers from './components/Servers';

if (document.getElementById('servers') != null) {
    new Vue({
        render: h => h(Servers),
    }).$mount(('#servers'));
}
