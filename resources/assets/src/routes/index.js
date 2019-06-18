import CardForm from '../components/CardForm.vue';
import List from '../components/List.vue';
import TransferForm from '../components/TransferForm.vue';

let routes = [
    {path: '/', component: List},
    {path: '/card', component: CardForm},
    {path: '/transfer', component: TransferForm},
];

export default routes;