<template>
    <div class="div">
        <div class="content-header">
            <h1>
                {{ trans(`products.${pageTitle}`) }}
            </h1>
            <el-breadcrumb separator="/">
                <el-breadcrumb-item>
                    <a href="/backend"><i class="fa fa-dashboard"></i> {{ trans('core.breadcrumb.home') }}</a>
                </el-breadcrumb-item>
                <el-breadcrumb-item :to="{name: 'admin.product.products.index'}">{{ trans('products.list resource') }}
                </el-breadcrumb-item>
                <el-breadcrumb-item :to="{name: 'admin.product.products.create'}">{{ trans(`products.${pageTitle}`) }}
                </el-breadcrumb-item>
            </el-breadcrumb>
        </div>

        <el-form ref="form" :model="product" label-width="120px" label-position="top"
                 v-loading.body="loading"
                 @keydown="form.errors.clear($event.target.name);">
            <div class="row">
                <div class="col-sm-9">
                    <!-- Image Gallery -->
                    <div class="box box-primary">
                        <div class="box-body">
                            <el-form-item :label="trans('products.type')"
                                          :class="{'el-form-item is-error': form.errors.has('type') }">
                                <el-select v-model="product.type" filterable>
                                    <el-option v-for="type in types" :key="type"
                                               :label="trans('products.types.'+type)" :value="type"></el-option>
                                </el-select>
                                <div class="el-form-item__error" v-if="form.errors.has('type')"
                                     v-text="form.errors.first('type')">
                                </div>
                            </el-form-item>

                            <el-form-item :label="trans('products.category')"
                                          :class="{'el-form-item is-error': form.errors.has('type') }">
                                <el-select v-model="product.category_id" filterable>
                                    <el-option v-for="(category, key) in categories" :key="key"
                                               :label="category.name" :value="category.id"></el-option>
                                </el-select>
                                <div class="el-form-item__error" v-if="form.errors.has('type')"
                                     v-text="form.errors.first('type')">
                                </div>
                            </el-form-item>

                            <el-form-item>
                                <single-media :label="trans('products.image')"
                                              zone="image"
                                              @singleFileSelected="selectSingleFile($event, 'product')"
                                              entity="Modules\Product\Entities\Product"
                                              :entity-id="$route.params.productId">
                                </single-media>
                            </el-form-item>

                            <el-form-item :label="trans('products.regular_price')"
                                          :class="{'el-form-item is-error': form.errors.has('regular_price') }">
                                <currency-input v-model="product.regular_price" :prefix="trans('products.currency.prefix')" :suffix="trans('products.currency.suffix')"></currency-input>
                                <div class="el-form-item__error" v-if="form.errors.has('regular_price')"
                                     v-text="form.errors.first('regular_price')"></div>
                            </el-form-item>

                            <el-form-item :label="trans('products.sale_price')"
                                          :class="{'el-form-item is-error': form.errors.has('sale_price') }">
                                <currency-input v-model="product.sale_price" :prefix="trans('products.currency.prefix')" :suffix="trans('products.currency.suffix')"></currency-input>
                                <div class="el-form-item__error" v-if="form.errors.has('sale_price')"
                                     v-text="form.errors.first('sale_price')"></div>
                            </el-form-item>
                        </div>
                    </div>

                    <div class="box box-primary">
                        <div class="box-body">
                            <el-tabs v-model="activeTab">
                                <el-tab-pane :label="localeArray.name" v-for="(localeArray, locale) in locales"
                                             :key="localeArray.name" :name="locale">

                                    <span slot="label" :class="{'error' : form.errors.has(locale)}">{{ localeArray.native }}</span>

                                    <el-form-item :label="trans('products.name')"
                                                  :class="{'el-form-item is-error': form.errors.has(locale + '.name') }">
                                        <el-input v-model="product[locale].name"></el-input>
                                        <div class="el-form-item__error" v-if="form.errors.has(locale + '.name')"
                                             v-text="form.errors.first(locale + '.name')"></div>
                                    </el-form-item>

                                    <el-form-item :label="trans('products.description')"
                                                  :class="{'el-form-item is-error': form.errors.has(locale + '.description') }">
                                        <component :is="getCurrentEditor()" v-model="product[locale].description" :value="product[locale].description">
                                        </component>
                                        <div class="el-form-item__error" v-if="form.errors.has(locale + '.description')"
                                             v-text="form.errors.first(locale + '.description')">
                                        </div>
                                    </el-form-item>

                                </el-tab-pane>
                            </el-tabs>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">

                    <div class="box box-primary">
                        <div class="box-body">
                            <el-form-item :label="trans('products.sku')"
                                          :class="{'el-form-item is-error': form.errors.has('sku') }">
                                <el-input v-model="product.sku">
                                    <!-- <el-button slot="prepend" @click="generateSKU($event, locale)">{{ trans('products.button.generate') }}</el-button> -->
                                </el-input>
                                <div class="el-form-item__error" v-if="form.errors.has('sku')"
                                     v-text="form.errors.first('sku')"></div>
                            </el-form-item>

                            <tags-input :label="trans('products.tags')" namespace="asgardcms/product" v-model="tags" :current-tags="tags"></tags-input>

                            <el-form-item :label="trans('products.status')"
                                          :class="{'el-form-item is-error': form.errors.has('status') }">
                                <el-select v-model="product.status" filterable>
                                    <el-option v-for="(status, key) in statuses" :key="status"
                                               :label="trans('products.statuses.'+status)" :value="key"></el-option>
                                </el-select>
                                <div class="el-form-item__error" v-if="form.errors.has('status')"
                                     v-text="form.errors.first('status')"></div>
                            </el-form-item>

                            <el-form-item>
                                <el-button type="primary" @click="onSubmit()" :loading="loading">
                                    {{ trans('core.save') }}
                                </el-button>
                                <el-button @click="onCancel()">
                                    {{ trans('core.button.cancel') }}
                                </el-button>
                            </el-form-item>
                        </div>
                    </div>

                    <!-- Stock Management -->
                    <div class="box box-primary">
                        <div class="box-body">
                            <el-form-item :label="trans('products.use_stock')"
                                          :class="{'el-form-item is-error': form.errors.has('use_stock') }">
                                <el-checkbox v-model="product.use_stock">{{ trans('products.use_stock') }}</el-checkbox>
                                <div class="el-form-item__error" v-if="form.errors.has('use_stock')"
                                     v-text="form.errors.first('use_stock')"></div>
                            </el-form-item>
                            <el-form-item :label="trans('products.stock_qty')">
                                <el-input-number v-model="product.stock_qty" :min="0" :disabled="!product.use_stock"></el-input-number>
                            </el-form-item>
                        </div>
                    </div>

                </div>
            </div>
        </el-form>
        <button v-shortkey="['b']" @shortkey="pushRoute({name: 'admin.product.products.index'})" v-show="false"></button>
    </div>
</template>

<script>
    import axios from 'axios';
    import Form from 'form-backend-validation';
    import Slugify from '../../../../Core/Assets/js/mixins/Slugify';
    import ShortcutHelper from '../../../../Core/Assets/js/mixins/ShortcutHelper';
    import ActiveEditor from '../../../../Core/Assets/js/mixins/ActiveEditor';
    import SingleFileSelector from '../../../../Media/Assets/js/mixins/SingleFileSelector';

    export default {
        mixins: [Slugify, ShortcutHelper, ActiveEditor, SingleFileSelector],
        props: {
            locales: { default: null },
            pageTitle: { default: null, String },
        },
        data() {
            return {
                product: _(this.locales)
                    .keys()
                    .map(locale => [locale, {
                        type: '',
                        name: '',
                        sku: '',
                        description: '',
                        regular_price: 0,
                        sale_price: 0,
                        use_stock: '',
                        stock_qty: '',
                        use_tax: '',
                        use_review: '',
                    }])
                    .fromPairs()
                    .merge({
                        type: 'basic',
                        status: 'active',
                        medias_single: []
                    })
                    .value(),
                types: {
                    basic: 'basic',
                    //bundle: 'bundle',
                    //digital: 'digital',
                    ordermade: 'ordermade',
                },
                statuses: {
                    active: 'active',
                    hide: 'hide',
                    inactive: 'inactive',
                },
                categories: [],
                form: new Form(),
                loading: false,
                tags: {},
                activeTab: window.AsgardCMS.currentLocale || 'en',
            };
        },
        methods: {
            onSubmit() {
                console.log(this.product);
                this.form = new Form(_.merge(this.product, { tags: this.tags }));
                this.loading = true;

                this.form.post(this.getRoute())
                    .then((response) => {
                        this.loading = false;
                        this.$message({
                            type: 'success',
                            message: response.message,
                        });
                        this.$router.push({ name: 'admin.product.products.index' });
                    })
                    .catch((error) => {
                        console.log(error);
                        this.loading = false;
                        this.$notify.error({
                            title: 'Error',
                            message: 'There are some errors in the form.',
                        });
                    });
            },
            onCancel() {
                this.$router.push({ name: 'admin.product.products.index' });
            },
            generateSKU(event, locale) {
                this.product.sku = '';
            },
            fetchProduct() {
                this.loading = true;
                axios.post(route('api.product.products.find', { product: this.$route.params.productId }))
                    .then((response) => {
                        this.loading = false;
                        this.product = response.data.data;
                        this.tags = response.data.data.tags;
                        //$('.publicUrl').attr('href', this.product.urls.public_url).show();
                    });
            },
            fetchCategories() {
                axios.get(route('api.product.category.index'))
                    .then((response) => {
                        this.categories = response.data.data;
                    });
            },
            getRoute() {
                if (this.$route.params.productId !== undefined) {
                    return route('api.product.products.update', { product: this.$route.params.productId });
                }
                return route('api.product.products.store');
            },
        },
        mounted() {
            this.fetchCategories();
            if (this.$route.params.productId !== undefined) {
                this.fetchProduct();
            }
        },
        destroyed() {
            //$('.publicUrl').hide();
        },
    };
</script>
