import Forum from './components/Forum.vue';
import Login from './components/Login.vue';
import Logout from './components/Logout.vue';
import Signup from './components/signup.vue';
import SingleForum from './components/SingleForum.vue';
import AskQuestion from './components/AskQuestion.vue';
import EditForum from './components/EditForum.vue';
import Category from './components/Category.vue';

export const routes = [
    { path: '/', component: Forum },
    { path: '/login', component: Login },
    { path: '/signup', component: Signup },
    { path: '/logout', component: Logout },
    { path: '/forum/:slug', component: SingleForum, name: 'forum' },
    { path: '/ask', component: AskQuestion },
    { path: '/forum/:slug/edit', component: EditForum, name: 'forumedit' },
    { path: '/category', component: Category },
  ]