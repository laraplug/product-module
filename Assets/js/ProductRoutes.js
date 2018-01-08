import ProductTable from './components/ProductTable.vue';
import ProductForm from './components/ProductForm.vue';

const locales = window.AsgardCMS.locales;

export default [
    {
        path: '/product/products',
        name: 'admin.product.products.index',
        component: ProductTable,
    },
    {
        path: '/product/products/create',
        name: 'admin.product.products.create',
        component: ProductForm,
        props: {
            locales,
            pageTitle: 'create resource',
        },
    },
    {
        path: '/product/products/:productId/edit',
        name: 'admin.product.products.edit',
        component: ProductForm,
        props: {
            locales,
            pageTitle: 'edit resource',
        },
    },
];
