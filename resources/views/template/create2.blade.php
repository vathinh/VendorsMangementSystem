@extends('layouts.dashboard')
@section('title','New Item')

@section('content')
<div id="app">

    <div class="card">
        <form method="POST" action="http://localhost/laravel/akaunting/1/common/items" accept-charset="UTF-8" id="item"
            @submit.prevent="onSubmit" @keydown="form.errors.clear($event.target.name)" role="form"
            class="form-loading-button" novalidate enctype="multipart/form-data"><input name="_token" type="hidden"
                value="T5V96my2LUOFPpcalfRCz8ESFGwAYc65XhdMTF5O">

            <div class="card-body">
                <div class="row">
                    <div class="form-group col-md-6 required"
                        :class="[{'has-error': form.errors.get(&quot;name&quot;) }]">
                        <label for="name" class="form-control-label">Name</label>

                        <div class="input-group input-group-merge ">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-tag"></i>
                                </span>
                            </div>
                            <input class="form-control" data-name="name" placeholder="Enter Name" v-model="form.name"
                                required="required" name="name" type="text" id="name">
                        </div>

                        <div class="invalid-feedback d-block" v-if="form.errors.has(&quot;name&quot;)"
                            v-html="form.errors.get(&quot;name&quot;)">
                        </div>
                    </div>



                    <akaunting-select class="col-md-6 el-select-tags-pl-38"
                        :form-classes="[{'has-error': form.errors.get('tax_ids') }]" icon="percentage" title="Tax"
                        placeholder="- Select Tax -" name="tax_ids"
                        :options="{&quot;1&quot;:&quot;Distinctio. (18.32%)&quot;,&quot;10&quot;:&quot;Est corporis. (10.95)&quot;,&quot;7&quot;:&quot;Est fugiat sit. (19%)&quot;,&quot;6&quot;:&quot;Ex voluptas. (15.04%)&quot;,&quot;4&quot;:&quot;Quas quia aut. (11.71)&quot;,&quot;8&quot;:&quot;Quia dolor. (17.08)&quot;,&quot;2&quot;:&quot;Rerum debitis. (15.55)&quot;,&quot;5&quot;:&quot;Sunt sed. (13.21)&quot;,&quot;3&quot;:&quot;Ut voluptates. (12.52%)&quot;,&quot;9&quot;:&quot;Vitae natus. (13.6%)&quot;}"
                        :multiple="true"
                        :add-new="{&quot;status&quot;:true,&quot;text&quot;:&quot;Add New&quot;,&quot;path&quot;:&quot;http:\/\/localhost\/laravel\/akaunting\/1\/modals\/taxes\/create&quot;,&quot;type&quot;:&quot;modal&quot;,&quot;field&quot;:{&quot;key&quot;:&quot;id&quot;,&quot;value&quot;:&quot;title&quot;},&quot;new_text&quot;:&quot;New&quot;,&quot;buttons&quot;:{&quot;cancel&quot;:{&quot;text&quot;:&quot;Cancel&quot;,&quot;class&quot;:&quot;btn-outline-secondary&quot;},&quot;confirm&quot;:{&quot;text&quot;:&quot;Save&quot;,&quot;class&quot;:&quot;btn-success&quot;}}}"
                        @interface="form.errors.clear('tax_ids'); form.tax_ids = $event"
                        :form-error="form.errors.get('tax_ids')" no-data-text="No data"
                        no-matching-data-text="No matching data"></akaunting-select>



                    <div class="form-group col-md-12"
                        :class="[{'has-error': form.errors.get(&quot;description&quot;) }]">
                        <label for="description" class="form-control-label">Description</label>

                        <textarea class="form-control" data-name="description" placeholder="Enter Description"
                            v-model="form.description" rows="3" name="description" cols="50"
                            id="description"></textarea>

                        <div class="invalid-feedback d-block" v-if="form.errors.has(&quot;description&quot;)"
                            v-html="form.errors.get(&quot;description&quot;)">
                        </div>
                    </div>



                    <div class="form-group col-md-6 required"
                        :class="[{'has-error': form.errors.get(&quot;sale_price&quot;) }]">
                        <label for="sale_price" class="form-control-label">Sale Price</label>

                        <div class="input-group input-group-merge ">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-money-bill-wave"></i>
                                </span>
                            </div>
                            <input class="form-control" data-name="sale_price" placeholder="Enter Sale Price"
                                v-model="form.sale_price" required="required" name="sale_price" type="text"
                                id="sale_price">
                        </div>

                        <div class="invalid-feedback d-block" v-if="form.errors.has(&quot;sale_price&quot;)"
                            v-html="form.errors.get(&quot;sale_price&quot;)">
                        </div>
                    </div>



                    <div class="form-group col-md-6 required"
                        :class="[{'has-error': form.errors.get(&quot;purchase_price&quot;) }]">
                        <label for="purchase_price" class="form-control-label">Purchase Price</label>

                        <div class="input-group input-group-merge ">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-money-bill-wave-alt"></i>
                                </span>
                            </div>
                            <input class="form-control" data-name="purchase_price" placeholder="Enter Purchase Price"
                                v-model="form.purchase_price" required="required" name="purchase_price" type="text"
                                id="purchase_price">
                        </div>

                        <div class="invalid-feedback d-block" v-if="form.errors.has(&quot;purchase_price&quot;)"
                            v-html="form.errors.get(&quot;purchase_price&quot;)">
                        </div>
                    </div>



                    <akaunting-select-remote class="col-md-6" id="form-select-category_id"
                        :form-classes="[{'has-error': form.errors.get('category_id') }]" icon="folder" title="Category"
                        placeholder="- Select Category -" name="category_id"
                        :options="{&quot;40&quot;:&quot;Animi.&quot;,&quot;38&quot;:&quot;Aut quo sit.&quot;,&quot;80&quot;:&quot;Blanditiis.&quot;,&quot;41&quot;:&quot;Consectetur.&quot;,&quot;101&quot;:&quot;Dicta.&quot;,&quot;66&quot;:&quot;Dolorum labore.&quot;,&quot;11&quot;:&quot;Est rem ut.&quot;,&quot;5&quot;:&quot;General&quot;,&quot;54&quot;:&quot;Molestiae.&quot;,&quot;52&quot;:&quot;Temporibus.&quot;}"
                        :add-new="{&quot;status&quot;:true,&quot;text&quot;:&quot;Add New&quot;,&quot;path&quot;:&quot;http:\/\/localhost\/laravel\/akaunting\/1\/modals\/categories\/create?type=item&quot;,&quot;type&quot;:&quot;modal&quot;,&quot;field&quot;:{&quot;key&quot;:&quot;id&quot;,&quot;value&quot;:&quot;name&quot;},&quot;new_text&quot;:&quot;New&quot;,&quot;buttons&quot;:{&quot;cancel&quot;:{&quot;text&quot;:&quot;Cancel&quot;,&quot;class&quot;:&quot;btn-outline-secondary&quot;},&quot;confirm&quot;:{&quot;text&quot;:&quot;Save&quot;,&quot;class&quot;:&quot;btn-success&quot;}}}"
                        @interface="form.category_id = $event; form.errors.clear('category_id');"
                        :form-error="form.errors.get('category_id')"
                        remote-action="http://localhost/laravel/akaunting/1/settings/categories?search=type:item"
                        loading-text="Loading..." no-data-text="No data" no-matching-data-text="No matching data">
                    </akaunting-select-remote>



                    <div class="form-group col-md-6" :class="[{'has-error': errors.picture}]">
                        <label for="picture" class="form-control-label">Picture</label>

                        <div class="input-group input-group-merge">
                            <akaunting-dropzone-file-upload text-drop-file="Drop files here to upload"
                                text-choose-file="Choose File" class="form-file" v-model="form.picture">
                            </akaunting-dropzone-file-upload>
                        </div>

                        <div class="invalid-feedback d-block" v-if="form.errors.has(&quot;picture&quot;)"
                            v-html="form.errors.get(&quot;picture&quot;)">
                        </div>
                    </div>



                    <div class="form-group col-md-6" :class="[{'has-error': form.errors.get(&quot;enabled&quot;) }]">
                        <label for="enabled" class="form-control-label">Enabled</label>

                        <div class="tab-pane tab-example-result fade show active" role="tabpanel"
                            aria-labelledby="-component-tab">
                            <div class="btn-group btn-group-toggle radio-yes-no" data-toggle="buttons">
                                <label class="btn btn-success" @click="form.enabled=1"
                                    v-bind:class="{ active: form.enabled == 1 }">
                                    Yes
                                    <input type="radio" name="enabled" id="enabled-1" v-model="form.enabled">
                                </label>

                                <label class="btn btn-danger" @click="form.enabled=0"
                                    v-bind:class="{ active: form.enabled == 0 }">
                                    No
                                    <input type="radio" name="enabled" id="enabled-0" v-model="form.enabled">
                                </label>
                            </div>

                            <input type="hidden" name="enabled" value="1" />
                        </div>

                        <div class="invalid-feedback d-block" v-if="form.errors.has(&quot;enabled&quot;)"
                            v-html="form.errors.get(&quot;enabled&quot;)">
                        </div>
                    </div>


                </div>
            </div>

            <div class="card-footer">
                <div class="row save-buttons">
                    <div class="col-md-12">
                        <a href="http://localhost/laravel/akaunting/1/common/items"
                            class="btn btn-outline-secondary">Cancel</a>

                        <button :disabled="form.loading" type="submit" class="btn btn-icon btn-success"><span
                                v-if="form.loading" class="btn-inner--icon"><i class="aka-loader"></i></span> <span
                                :class="[{'ml-0': form.loading}]" class="btn-inner--text">Save</span></button>
                    </div>


                </div>
            </div>
        </form>
    </div>


    <notifications></notifications>

    <form id="form-dynamic-component" method="POST" action="#"></form>

    <component v-bind:is="component"></component>
</div>

<script src="{{ asset('js/common/items.js?v=2.1.16') }}"></script>


@endsection
