import Home from './Page/home'
import CategoryList from './Page/categoryList'
import BlogDetail from './Page/blogDetail'
import BlogList from './Page/blogList'
export const routes = [
    { path: '/', component: Home },
    { path: '/kategori/:slug', component: CategoryList },
    { path: '/yazi/:slug', component: BlogDetail },
    { path: '/tum-yazilar', component: BlogList },
];
