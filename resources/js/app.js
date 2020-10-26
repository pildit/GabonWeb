require('./bootstrap');

import Vue from 'vue';
import Base from './components/Base';
import User from './components/User/User';

Vue.config.devtools = true;

let Gabon = window.Gabon || {}

Gabon.Base = Base;
Gabon.User = User;

window.Gabon = Gabon;
