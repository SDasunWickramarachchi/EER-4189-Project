import { createApp } from 'vue';
import { api, firstErrors } from './api';

window.VueLib = { createApp };
window.api = api;
window.firstErrors = firstErrors;