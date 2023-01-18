@extends('layouts.dashboard')
@section('addnew')

<a href="http://localhost/laravel/akaunting/1/common/items/create" class="btn btn-success btn-sm">Add New</a>
<a href="http://localhost/laravel/akaunting/1/common/import/common/items" class="btn btn-white btn-sm">Import</a>
<a href="http://localhost/laravel/akaunting/1/common/items/export?sort=name&amp;direction=asc"
    class="btn btn-white btn-sm">Export</a>

<a href="http://localhost/laravel/akaunting/1/apps/inventory?utm_source=Suggestion&amp;utm_medium=App&amp;utm_campaign=Inventory"
    class="btn btn-white btn-sm" target="_self">
    Inventory
</a>

@endsection

@section('content')
<div>

    <div class="card">
        <div class="card-header border-bottom-0" :class="[{'bg-gradient-primary': bulk_action.show}]">
            <form method="GET" action="http://localhost/laravel/akaunting/1/common/items" accept-charset="UTF-8"
                role="form" class="mb-0">
                <div class="align-items-center" v-if="!bulk_action.show">
                    <akaunting-search placeholder="Search or filter results.." search-text="Search for this text"
                        operator-is-text="is" operator-is-not-text="is not" no-data-text="No data"
                        no-matching-data-text="No matching data" value=""
                        :filters="[{&quot;key&quot;:&quot;enabled&quot;,&quot;value&quot;:&quot;Enabled&quot;,&quot;type&quot;:&quot;boolean&quot;,&quot;url&quot;:&quot;&quot;,&quot;values&quot;:[{&quot;key&quot;:0,&quot;value&quot;:&quot;No&quot;},{&quot;key&quot;:1,&quot;value&quot;:&quot;Yes&quot;}]},{&quot;key&quot;:&quot;category_id&quot;,&quot;value&quot;:&quot;Category&quot;,&quot;type&quot;:&quot;select&quot;,&quot;url&quot;:&quot;http:\/\/localhost\/laravel\/akaunting\/1\/settings\/categories?search=type:item&quot;,&quot;values&quot;:[]}]"
                        :date-config="{
    allowInput: true,
    altInput: true,
    altFormat: 'd M Y',
    dateFormat: 'd M Y',
                }"></akaunting-search>
                </div>

                <div class="align-items-center d-none mt-2" v-if="bulk_action.show"
                    :class="[{'show': bulk_action.show}]">
                    <div class="mr-6">
                        <span class="text-white d-none d-sm-block">
                            <b v-text="bulk_action.count"></b>
                            <span v-if="bulk_action.count === 1">
                                item
                            </span>
                            <span v-else-if="bulk_action.count > 1">
                                items
                            </span>
                            selected
                        </span>
                    </div>

                    <div class="w-25 mr-4" v-if="bulk_action.count">
                        <div class="form-group mb-0">
                            <select class="form-control form-control-sm" v-model="bulk_action.value"
                                @change="onChange">
                                <option value="*">Bulk Actions</option>
                                <option value="enable"
                                    data-message="`Are you sure you want to &lt;b&gt;enable&lt;/b&gt; selected records?`"
                                    data-path="http://localhost/laravel/akaunting/1/common/bulk-actions/common/items"
                                    data-type="*">Enable</option>
                                <option value="disable"
                                    data-message="`Are you sure you want to &lt;b&gt;disable&lt;/b&gt; selected records?`"
                                    data-path="http://localhost/laravel/akaunting/1/common/bulk-actions/common/items"
                                    data-type="*">Disable</option>
                                <option value="delete"
                                    data-message="`Are you sure you want to &lt;b&gt;delete&lt;/b&gt; selected records?`"
                                    data-path="" data-type="">Delete</option>
                                <option value="export"
                                    data-message="`Are you sure you want to &lt;b&gt;export&lt;/b&gt; selected records?`"
                                    data-path="" data-type="download">Export</option>
                            </select>

                            <input type="hidden" name="bulk_action_path"
                                value="http://localhost/laravel/akaunting/1/common/bulk-actions/common/items" />
                        </div>
                    </div>

                    <div class="mr-4" v-if="bulk_action.count">
                        <button type="button" class="btn btn-sm btn-outline-confirm"
                            :disabled="bulk_action.value == '*'" v-if="bulk_action.message.length"
                            @click="bulk_action.modal=true">
                            <span>Confirm</span>
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-confirm"
                            :disabled="bulk_action.value == '*'" v-if="!bulk_action.message.length"
                            @click="onAction">
                            <span>Confirm</span>
                        </button>
                    </div>

                    <div class="mr-4" v-if="bulk_action.count">
                        <button type="button" class="btn btn-outline-clear btn-sm" @click="onClear">
                            <span>Clear</span>
                        </button>
                    </div>
                </div>

                <akaunting-modal :show="bulk_action.modal" :title="`Items`" :message="bulk_action.message"
                    @cancel="onCancel" v-if='bulk_action.message && bulk_action.modal'>
                    <template #card-footer>
                        <div class="float-right">
                            <button type="button" class="btn btn-outline-secondary" @click="onCancel">
                                <span>Cancel</span>
                            </button>

                            <button :disabled="bulk_action.loading" type="button"
                                class="btn btn-success button-submit" @click="onAction">
                                <div class="aka-loader d-none"></div>
                                <span>Confirm</span>
                            </button>
                        </div>
                    </template>
                </akaunting-modal>


            </form>
        </div>

        <div class="table-responsive">
            <table class="table table-flush table-hover">
                <thead class="thead-light">
                    <tr class="row table-head-line">
                        <th class="col-sm-2 col-md-1 col-lg-1 col-xl-1 d-none d-sm-block">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" id="table-check-all" type="checkbox"
                                    v-model="bulk_action.select_all" @click="onSelectAll">
                                <label class="custom-control-label" for="table-check-all"></label>
                            </div>

                        </th>
                        <th class="col-xs-4 col-sm-4 col-md-4 col-lg-3 col-xl-3"><a class="col-aka"
                                href="http://localhost/laravel/akaunting/1/common/items?filter=active%2C+visible&sort=name&direction=desc"
                                rel="nofollow">Name</a>&nbsp; <i class="fas fa-sort-alpha-down"></i>
                        </th>
                        <th class="col-lg-1 col-xl-2 d-none d-lg-block"><a
                                href="http://localhost/laravel/akaunting/1/common/items?sort=category&direction=asc">Category</a>&nbsp;
                            <i class="fas fa-arrow-down sort-icon"></i></th>
                        <th class="col-md-3 col-lg-3 col-xl-2 text-right d-none d-md-block"><a
                                href="http://localhost/laravel/akaunting/1/common/items?sort=sale_price&direction=asc">Sale
                                Price</a>&nbsp; <i class="fas fa-arrow-down sort-icon"></i></th>
                        <th class="col-lg-2 col-xl-2 text-right d-none d-lg-block"><a
                                href="http://localhost/laravel/akaunting/1/common/items?sort=purchase_price&direction=asc">Purchase
                                Price</a>&nbsp; <i class="fas fa-arrow-down sort-icon"></i></th>
                        <th class="col-xs-4 col-sm-3 col-md-2 col-lg-1 col-xl-1 text-center"><a
                                href="http://localhost/laravel/akaunting/1/common/items?sort=enabled&direction=asc">Enabled</a>&nbsp;
                            <i class="fas fa-arrow-down sort-icon"></i></th>
                        <th class="col-xs-4 col-sm-3 col-md-2 col-lg-1 col-xl-1 text-center">
                            <a>Actions</a></th>
                    </tr>
                </thead>

                <tbody>
                    <tr class="row align-items-center border-top-1">
                        <td class="col-sm-2 col-md-1 col-lg-1 col-xl-1 d-none d-sm-block">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="bulk-action-56"
                                    data-bulk-action="56" :value="56" v-model="bulk_action.selected"
                                    v-on:change="onSelect">
                                <label class="custom-control-label" for="bulk-action-56"></label>
                            </div>


                        </td>
                        <td class="col-xs-4 col-sm-4 col-md-4 col-lg-3 col-xl-3 py-2">
                            <img src="http://localhost/laravel/akaunting/public/img/akaunting-logo-green.svg"
                                class="avatar image-style p-1 mr-3 item-img hidden-md col-aka" alt="Alias id et.">
                            <a href="http://localhost/laravel/akaunting/1/common/items/56/edit">Alias id
                                et.</a>
                        </td>
                        <td class="col-lg-1 col-xl-2 d-none d-lg-block long-texts">
                            Animi.
                        </td>
                        <td class="col-md-3 col-lg-3 col-xl-2 text-right d-none d-md-block">
                            $14.26
                        </td>
                        <td class="col-lg-2 col-xl-2 text-right d-none d-lg-block">
                            $17.05
                        </td>
                        <td class="col-xs-4 col-sm-3 col-md-2 col-lg-1 col-xl-1 text-center">
                            <label class="custom-toggle d-inline-block">
                                <input type="checkbox" name="status[56]"
                                    @input="bulk_action.path='1/common/items'; onStatus(56, $event)" checked>

                                <span class="custom-toggle-slider rounded-circle status-green" data-label-off="No"
                                    data-label-on="Yes">
                                </span>
                            </label>


                        </td>
                        <td class="col-xs-4 col-sm-3 col-md-2 col-lg-1 col-xl-1 text-center">
                            <div class="dropdown">
                                <a class="btn btn-neutral btn-sm text-light items-align-center p-2" href="#"
                                    role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-ellipsis-h text-muted"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/common/items/56/edit">Edit</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/common/items/56/duplicate">Duplicate</a>
                                    <div class="dropdown-divider"></div>
                                    <button type="button" class="dropdown-item action-delete" title="Delete"
                                        @click="confirmDelete(&quot;http://localhost/laravel/akaunting/1/common/items/56&quot;, &quot;Items&quot;, &quot;Confirm delete &lt;strong&gt;Alias id et.&lt;/strong&gt; item?&quot;, &quot;Cancel&quot;, &quot;Delete&quot;)">Delete</button>

                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr class="row align-items-center border-top-1">
                        <td class="col-sm-2 col-md-1 col-lg-1 col-xl-1 d-none d-sm-block">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="bulk-action-49"
                                    data-bulk-action="49" :value="49" v-model="bulk_action.selected"
                                    v-on:change="onSelect">
                                <label class="custom-control-label" for="bulk-action-49"></label>
                            </div>


                        </td>
                        <td class="col-xs-4 col-sm-4 col-md-4 col-lg-3 col-xl-3 py-2">
                            <img src="http://localhost/laravel/akaunting/public/img/akaunting-logo-green.svg"
                                class="avatar image-style p-1 mr-3 item-img hidden-md col-aka" alt="Alias nihil.">
                            <a href="http://localhost/laravel/akaunting/1/common/items/49/edit">Alias
                                nihil.</a>
                        </td>
                        <td class="col-lg-1 col-xl-2 d-none d-lg-block long-texts">
                            Est rem ut.
                        </td>
                        <td class="col-md-3 col-lg-3 col-xl-2 text-right d-none d-md-block">
                            $14.19
                        </td>
                        <td class="col-lg-2 col-xl-2 text-right d-none d-lg-block">
                            $18.99
                        </td>
                        <td class="col-xs-4 col-sm-3 col-md-2 col-lg-1 col-xl-1 text-center">
                            <label class="custom-toggle d-inline-block">
                                <input type="checkbox" name="status[49]"
                                    @input="bulk_action.path='1/common/items'; onStatus(49, $event)">

                                <span class="custom-toggle-slider rounded-circle status-green" data-label-off="No"
                                    data-label-on="Yes">
                                </span>
                            </label>


                        </td>
                        <td class="col-xs-4 col-sm-3 col-md-2 col-lg-1 col-xl-1 text-center">
                            <div class="dropdown">
                                <a class="btn btn-neutral btn-sm text-light items-align-center p-2" href="#"
                                    role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-ellipsis-h text-muted"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/common/items/49/edit">Edit</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/common/items/49/duplicate">Duplicate</a>
                                    <div class="dropdown-divider"></div>
                                    <button type="button" class="dropdown-item action-delete" title="Delete"
                                        @click="confirmDelete(&quot;http://localhost/laravel/akaunting/1/common/items/49&quot;, &quot;Items&quot;, &quot;Confirm delete &lt;strong&gt;Alias nihil.&lt;/strong&gt; item?&quot;, &quot;Cancel&quot;, &quot;Delete&quot;)">Delete</button>

                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr class="row align-items-center border-top-1">
                        <td class="col-sm-2 col-md-1 col-lg-1 col-xl-1 d-none d-sm-block">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="bulk-action-2"
                                    data-bulk-action="2" :value="2" v-model="bulk_action.selected"
                                    v-on:change="onSelect">
                                <label class="custom-control-label" for="bulk-action-2"></label>
                            </div>


                        </td>
                        <td class="col-xs-4 col-sm-4 col-md-4 col-lg-3 col-xl-3 py-2">
                            <img src="http://localhost/laravel/akaunting/public/img/akaunting-logo-green.svg"
                                class="avatar image-style p-1 mr-3 item-img hidden-md col-aka" alt="Aliquam autem.">
                            <a href="http://localhost/laravel/akaunting/1/common/items/2/edit">Aliquam
                                autem.</a>
                        </td>
                        <td class="col-lg-1 col-xl-2 d-none d-lg-block long-texts">
                            Est rem ut.
                        </td>
                        <td class="col-md-3 col-lg-3 col-xl-2 text-right d-none d-md-block">
                            $16.91
                        </td>
                        <td class="col-lg-2 col-xl-2 text-right d-none d-lg-block">
                            $16.68
                        </td>
                        <td class="col-xs-4 col-sm-3 col-md-2 col-lg-1 col-xl-1 text-center">
                            <label class="custom-toggle d-inline-block">
                                <input type="checkbox" name="status[2]"
                                    @input="bulk_action.path='1/common/items'; onStatus(2, $event)" checked>

                                <span class="custom-toggle-slider rounded-circle status-green" data-label-off="No"
                                    data-label-on="Yes">
                                </span>
                            </label>


                        </td>
                        <td class="col-xs-4 col-sm-3 col-md-2 col-lg-1 col-xl-1 text-center">
                            <div class="dropdown">
                                <a class="btn btn-neutral btn-sm text-light items-align-center p-2" href="#"
                                    role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-ellipsis-h text-muted"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/common/items/2/edit">Edit</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/common/items/2/duplicate">Duplicate</a>
                                    <div class="dropdown-divider"></div>
                                    <button type="button" class="dropdown-item action-delete" title="Delete"
                                        @click="confirmDelete(&quot;http://localhost/laravel/akaunting/1/common/items/2&quot;, &quot;Items&quot;, &quot;Confirm delete &lt;strong&gt;Aliquam autem.&lt;/strong&gt; item?&quot;, &quot;Cancel&quot;, &quot;Delete&quot;)">Delete</button>

                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr class="row align-items-center border-top-1">
                        <td class="col-sm-2 col-md-1 col-lg-1 col-xl-1 d-none d-sm-block">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="bulk-action-43"
                                    data-bulk-action="43" :value="43" v-model="bulk_action.selected"
                                    v-on:change="onSelect">
                                <label class="custom-control-label" for="bulk-action-43"></label>
                            </div>


                        </td>
                        <td class="col-xs-4 col-sm-4 col-md-4 col-lg-3 col-xl-3 py-2">
                            <img src="http://localhost/laravel/akaunting/public/img/akaunting-logo-green.svg"
                                class="avatar image-style p-1 mr-3 item-img hidden-md col-aka" alt="Aliquid.">
                            <a href="http://localhost/laravel/akaunting/1/common/items/43/edit">Aliquid.</a>
                        </td>
                        <td class="col-lg-1 col-xl-2 d-none d-lg-block long-texts">
                            Molestiae.
                        </td>
                        <td class="col-md-3 col-lg-3 col-xl-2 text-right d-none d-md-block">
                            $14.07
                        </td>
                        <td class="col-lg-2 col-xl-2 text-right d-none d-lg-block">
                            $15.66
                        </td>
                        <td class="col-xs-4 col-sm-3 col-md-2 col-lg-1 col-xl-1 text-center">
                            <label class="custom-toggle d-inline-block">
                                <input type="checkbox" name="status[43]"
                                    @input="bulk_action.path='1/common/items'; onStatus(43, $event)" checked>

                                <span class="custom-toggle-slider rounded-circle status-green" data-label-off="No"
                                    data-label-on="Yes">
                                </span>
                            </label>


                        </td>
                        <td class="col-xs-4 col-sm-3 col-md-2 col-lg-1 col-xl-1 text-center">
                            <div class="dropdown">
                                <a class="btn btn-neutral btn-sm text-light items-align-center p-2" href="#"
                                    role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-ellipsis-h text-muted"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/common/items/43/edit">Edit</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/common/items/43/duplicate">Duplicate</a>
                                    <div class="dropdown-divider"></div>
                                    <button type="button" class="dropdown-item action-delete" title="Delete"
                                        @click="confirmDelete(&quot;http://localhost/laravel/akaunting/1/common/items/43&quot;, &quot;Items&quot;, &quot;Confirm delete &lt;strong&gt;Aliquid.&lt;/strong&gt; item?&quot;, &quot;Cancel&quot;, &quot;Delete&quot;)">Delete</button>

                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr class="row align-items-center border-top-1">
                        <td class="col-sm-2 col-md-1 col-lg-1 col-xl-1 d-none d-sm-block">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="bulk-action-76"
                                    data-bulk-action="76" :value="76" v-model="bulk_action.selected"
                                    v-on:change="onSelect">
                                <label class="custom-control-label" for="bulk-action-76"></label>
                            </div>


                        </td>
                        <td class="col-xs-4 col-sm-4 col-md-4 col-lg-3 col-xl-3 py-2">
                            <img src="http://localhost/laravel/akaunting/public/img/akaunting-logo-green.svg"
                                class="avatar image-style p-1 mr-3 item-img hidden-md col-aka" alt="Aliquid.">
                            <a href="http://localhost/laravel/akaunting/1/common/items/76/edit">Aliquid.</a>
                        </td>
                        <td class="col-lg-1 col-xl-2 d-none d-lg-block long-texts">
                            Molestiae.
                        </td>
                        <td class="col-md-3 col-lg-3 col-xl-2 text-right d-none d-md-block">
                            $19.12
                        </td>
                        <td class="col-lg-2 col-xl-2 text-right d-none d-lg-block">
                            $10.80
                        </td>
                        <td class="col-xs-4 col-sm-3 col-md-2 col-lg-1 col-xl-1 text-center">
                            <label class="custom-toggle d-inline-block">
                                <input type="checkbox" name="status[76]"
                                    @input="bulk_action.path='1/common/items'; onStatus(76, $event)" checked>

                                <span class="custom-toggle-slider rounded-circle status-green" data-label-off="No"
                                    data-label-on="Yes">
                                </span>
                            </label>


                        </td>
                        <td class="col-xs-4 col-sm-3 col-md-2 col-lg-1 col-xl-1 text-center">
                            <div class="dropdown">
                                <a class="btn btn-neutral btn-sm text-light items-align-center p-2" href="#"
                                    role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-ellipsis-h text-muted"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/common/items/76/edit">Edit</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/common/items/76/duplicate">Duplicate</a>
                                    <div class="dropdown-divider"></div>
                                    <button type="button" class="dropdown-item action-delete" title="Delete"
                                        @click="confirmDelete(&quot;http://localhost/laravel/akaunting/1/common/items/76&quot;, &quot;Items&quot;, &quot;Confirm delete &lt;strong&gt;Aliquid.&lt;/strong&gt; item?&quot;, &quot;Cancel&quot;, &quot;Delete&quot;)">Delete</button>

                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr class="row align-items-center border-top-1">
                        <td class="col-sm-2 col-md-1 col-lg-1 col-xl-1 d-none d-sm-block">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="bulk-action-99"
                                    data-bulk-action="99" :value="99" v-model="bulk_action.selected"
                                    v-on:change="onSelect">
                                <label class="custom-control-label" for="bulk-action-99"></label>
                            </div>


                        </td>
                        <td class="col-xs-4 col-sm-4 col-md-4 col-lg-3 col-xl-3 py-2">
                            <img src="http://localhost/laravel/akaunting/public/img/akaunting-logo-green.svg"
                                class="avatar image-style p-1 mr-3 item-img hidden-md col-aka" alt="Aliquid.">
                            <a href="http://localhost/laravel/akaunting/1/common/items/99/edit">Aliquid.</a>
                        </td>
                        <td class="col-lg-1 col-xl-2 d-none d-lg-block long-texts">
                            Dolorum labore.
                        </td>
                        <td class="col-md-3 col-lg-3 col-xl-2 text-right d-none d-md-block">
                            $14.54
                        </td>
                        <td class="col-lg-2 col-xl-2 text-right d-none d-lg-block">
                            $14.32
                        </td>
                        <td class="col-xs-4 col-sm-3 col-md-2 col-lg-1 col-xl-1 text-center">
                            <label class="custom-toggle d-inline-block">
                                <input type="checkbox" name="status[99]"
                                    @input="bulk_action.path='1/common/items'; onStatus(99, $event)">

                                <span class="custom-toggle-slider rounded-circle status-green" data-label-off="No"
                                    data-label-on="Yes">
                                </span>
                            </label>


                        </td>
                        <td class="col-xs-4 col-sm-3 col-md-2 col-lg-1 col-xl-1 text-center">
                            <div class="dropdown">
                                <a class="btn btn-neutral btn-sm text-light items-align-center p-2" href="#"
                                    role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-ellipsis-h text-muted"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/common/items/99/edit">Edit</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/common/items/99/duplicate">Duplicate</a>
                                    <div class="dropdown-divider"></div>
                                    <button type="button" class="dropdown-item action-delete" title="Delete"
                                        @click="confirmDelete(&quot;http://localhost/laravel/akaunting/1/common/items/99&quot;, &quot;Items&quot;, &quot;Confirm delete &lt;strong&gt;Aliquid.&lt;/strong&gt; item?&quot;, &quot;Cancel&quot;, &quot;Delete&quot;)">Delete</button>

                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr class="row align-items-center border-top-1">
                        <td class="col-sm-2 col-md-1 col-lg-1 col-xl-1 d-none d-sm-block">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="bulk-action-31"
                                    data-bulk-action="31" :value="31" v-model="bulk_action.selected"
                                    v-on:change="onSelect">
                                <label class="custom-control-label" for="bulk-action-31"></label>
                            </div>


                        </td>
                        <td class="col-xs-4 col-sm-4 col-md-4 col-lg-3 col-xl-3 py-2">
                            <img src="http://localhost/laravel/akaunting/public/img/akaunting-logo-green.svg"
                                class="avatar image-style p-1 mr-3 item-img hidden-md col-aka" alt="Architecto.">
                            <a href="http://localhost/laravel/akaunting/1/common/items/31/edit">Architecto.</a>
                        </td>
                        <td class="col-lg-1 col-xl-2 d-none d-lg-block long-texts">
                            Dolorum labore.
                        </td>
                        <td class="col-md-3 col-lg-3 col-xl-2 text-right d-none d-md-block">
                            $11.98
                        </td>
                        <td class="col-lg-2 col-xl-2 text-right d-none d-lg-block">
                            $16.11
                        </td>
                        <td class="col-xs-4 col-sm-3 col-md-2 col-lg-1 col-xl-1 text-center">
                            <label class="custom-toggle d-inline-block">
                                <input type="checkbox" name="status[31]"
                                    @input="bulk_action.path='1/common/items'; onStatus(31, $event)" checked>

                                <span class="custom-toggle-slider rounded-circle status-green" data-label-off="No"
                                    data-label-on="Yes">
                                </span>
                            </label>


                        </td>
                        <td class="col-xs-4 col-sm-3 col-md-2 col-lg-1 col-xl-1 text-center">
                            <div class="dropdown">
                                <a class="btn btn-neutral btn-sm text-light items-align-center p-2" href="#"
                                    role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-ellipsis-h text-muted"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/common/items/31/edit">Edit</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/common/items/31/duplicate">Duplicate</a>
                                    <div class="dropdown-divider"></div>
                                    <button type="button" class="dropdown-item action-delete" title="Delete"
                                        @click="confirmDelete(&quot;http://localhost/laravel/akaunting/1/common/items/31&quot;, &quot;Items&quot;, &quot;Confirm delete &lt;strong&gt;Architecto.&lt;/strong&gt; item?&quot;, &quot;Cancel&quot;, &quot;Delete&quot;)">Delete</button>

                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr class="row align-items-center border-top-1">
                        <td class="col-sm-2 col-md-1 col-lg-1 col-xl-1 d-none d-sm-block">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="bulk-action-41"
                                    data-bulk-action="41" :value="41" v-model="bulk_action.selected"
                                    v-on:change="onSelect">
                                <label class="custom-control-label" for="bulk-action-41"></label>
                            </div>


                        </td>
                        <td class="col-xs-4 col-sm-4 col-md-4 col-lg-3 col-xl-3 py-2">
                            <img src="http://localhost/laravel/akaunting/public/img/akaunting-logo-green.svg"
                                class="avatar image-style p-1 mr-3 item-img hidden-md col-aka" alt="Architecto.">
                            <a href="http://localhost/laravel/akaunting/1/common/items/41/edit">Architecto.</a>
                        </td>
                        <td class="col-lg-1 col-xl-2 d-none d-lg-block long-texts">
                            Quia id.
                        </td>
                        <td class="col-md-3 col-lg-3 col-xl-2 text-right d-none d-md-block">
                            $15.84
                        </td>
                        <td class="col-lg-2 col-xl-2 text-right d-none d-lg-block">
                            $17.17
                        </td>
                        <td class="col-xs-4 col-sm-3 col-md-2 col-lg-1 col-xl-1 text-center">
                            <label class="custom-toggle d-inline-block">
                                <input type="checkbox" name="status[41]"
                                    @input="bulk_action.path='1/common/items'; onStatus(41, $event)" checked>

                                <span class="custom-toggle-slider rounded-circle status-green" data-label-off="No"
                                    data-label-on="Yes">
                                </span>
                            </label>


                        </td>
                        <td class="col-xs-4 col-sm-3 col-md-2 col-lg-1 col-xl-1 text-center">
                            <div class="dropdown">
                                <a class="btn btn-neutral btn-sm text-light items-align-center p-2" href="#"
                                    role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-ellipsis-h text-muted"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/common/items/41/edit">Edit</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/common/items/41/duplicate">Duplicate</a>
                                    <div class="dropdown-divider"></div>
                                    <button type="button" class="dropdown-item action-delete" title="Delete"
                                        @click="confirmDelete(&quot;http://localhost/laravel/akaunting/1/common/items/41&quot;, &quot;Items&quot;, &quot;Confirm delete &lt;strong&gt;Architecto.&lt;/strong&gt; item?&quot;, &quot;Cancel&quot;, &quot;Delete&quot;)">Delete</button>

                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr class="row align-items-center border-top-1">
                        <td class="col-sm-2 col-md-1 col-lg-1 col-xl-1 d-none d-sm-block">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="bulk-action-23"
                                    data-bulk-action="23" :value="23" v-model="bulk_action.selected"
                                    v-on:change="onSelect">
                                <label class="custom-control-label" for="bulk-action-23"></label>
                            </div>


                        </td>
                        <td class="col-xs-4 col-sm-4 col-md-4 col-lg-3 col-xl-3 py-2">
                            <img src="http://localhost/laravel/akaunting/public/img/akaunting-logo-green.svg"
                                class="avatar image-style p-1 mr-3 item-img hidden-md col-aka" alt="Assumenda.">
                            <a href="http://localhost/laravel/akaunting/1/common/items/23/edit">Assumenda.</a>
                        </td>
                        <td class="col-lg-1 col-xl-2 d-none d-lg-block long-texts">
                            General
                        </td>
                        <td class="col-md-3 col-lg-3 col-xl-2 text-right d-none d-md-block">
                            $14.30
                        </td>
                        <td class="col-lg-2 col-xl-2 text-right d-none d-lg-block">
                            $16.87
                        </td>
                        <td class="col-xs-4 col-sm-3 col-md-2 col-lg-1 col-xl-1 text-center">
                            <label class="custom-toggle d-inline-block">
                                <input type="checkbox" name="status[23]"
                                    @input="bulk_action.path='1/common/items'; onStatus(23, $event)">

                                <span class="custom-toggle-slider rounded-circle status-green" data-label-off="No"
                                    data-label-on="Yes">
                                </span>
                            </label>


                        </td>
                        <td class="col-xs-4 col-sm-3 col-md-2 col-lg-1 col-xl-1 text-center">
                            <div class="dropdown">
                                <a class="btn btn-neutral btn-sm text-light items-align-center p-2" href="#"
                                    role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-ellipsis-h text-muted"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/common/items/23/edit">Edit</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/common/items/23/duplicate">Duplicate</a>
                                    <div class="dropdown-divider"></div>
                                    <button type="button" class="dropdown-item action-delete" title="Delete"
                                        @click="confirmDelete(&quot;http://localhost/laravel/akaunting/1/common/items/23&quot;, &quot;Items&quot;, &quot;Confirm delete &lt;strong&gt;Assumenda.&lt;/strong&gt; item?&quot;, &quot;Cancel&quot;, &quot;Delete&quot;)">Delete</button>

                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr class="row align-items-center border-top-1">
                        <td class="col-sm-2 col-md-1 col-lg-1 col-xl-1 d-none d-sm-block">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="bulk-action-15"
                                    data-bulk-action="15" :value="15" v-model="bulk_action.selected"
                                    v-on:change="onSelect">
                                <label class="custom-control-label" for="bulk-action-15"></label>
                            </div>


                        </td>
                        <td class="col-xs-4 col-sm-4 col-md-4 col-lg-3 col-xl-3 py-2">
                            <img src="http://localhost/laravel/akaunting/public/img/akaunting-logo-green.svg"
                                class="avatar image-style p-1 mr-3 item-img hidden-md col-aka" alt="Aut deleniti.">
                            <a href="http://localhost/laravel/akaunting/1/common/items/15/edit">Aut
                                deleniti.</a>
                        </td>
                        <td class="col-lg-1 col-xl-2 d-none d-lg-block long-texts">
                            Quos nihil.
                        </td>
                        <td class="col-md-3 col-lg-3 col-xl-2 text-right d-none d-md-block">
                            $19.07
                        </td>
                        <td class="col-lg-2 col-xl-2 text-right d-none d-lg-block">
                            $15.44
                        </td>
                        <td class="col-xs-4 col-sm-3 col-md-2 col-lg-1 col-xl-1 text-center">
                            <label class="custom-toggle d-inline-block">
                                <input type="checkbox" name="status[15]"
                                    @input="bulk_action.path='1/common/items'; onStatus(15, $event)">

                                <span class="custom-toggle-slider rounded-circle status-green" data-label-off="No"
                                    data-label-on="Yes">
                                </span>
                            </label>


                        </td>
                        <td class="col-xs-4 col-sm-3 col-md-2 col-lg-1 col-xl-1 text-center">
                            <div class="dropdown">
                                <a class="btn btn-neutral btn-sm text-light items-align-center p-2" href="#"
                                    role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-ellipsis-h text-muted"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/common/items/15/edit">Edit</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/common/items/15/duplicate">Duplicate</a>
                                    <div class="dropdown-divider"></div>
                                    <button type="button" class="dropdown-item action-delete" title="Delete"
                                        @click="confirmDelete(&quot;http://localhost/laravel/akaunting/1/common/items/15&quot;, &quot;Items&quot;, &quot;Confirm delete &lt;strong&gt;Aut deleniti.&lt;/strong&gt; item?&quot;, &quot;Cancel&quot;, &quot;Delete&quot;)">Delete</button>

                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr class="row align-items-center border-top-1">
                        <td class="col-sm-2 col-md-1 col-lg-1 col-xl-1 d-none d-sm-block">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="bulk-action-34"
                                    data-bulk-action="34" :value="34" v-model="bulk_action.selected"
                                    v-on:change="onSelect">
                                <label class="custom-control-label" for="bulk-action-34"></label>
                            </div>


                        </td>
                        <td class="col-xs-4 col-sm-4 col-md-4 col-lg-3 col-xl-3 py-2">
                            <img src="http://localhost/laravel/akaunting/public/img/akaunting-logo-green.svg"
                                class="avatar image-style p-1 mr-3 item-img hidden-md col-aka" alt="Aut deserunt.">
                            <a href="http://localhost/laravel/akaunting/1/common/items/34/edit">Aut
                                deserunt.</a>
                        </td>
                        <td class="col-lg-1 col-xl-2 d-none d-lg-block long-texts">
                            Temporibus.
                        </td>
                        <td class="col-md-3 col-lg-3 col-xl-2 text-right d-none d-md-block">
                            $13.29
                        </td>
                        <td class="col-lg-2 col-xl-2 text-right d-none d-lg-block">
                            $14.81
                        </td>
                        <td class="col-xs-4 col-sm-3 col-md-2 col-lg-1 col-xl-1 text-center">
                            <label class="custom-toggle d-inline-block">
                                <input type="checkbox" name="status[34]"
                                    @input="bulk_action.path='1/common/items'; onStatus(34, $event)" checked>

                                <span class="custom-toggle-slider rounded-circle status-green" data-label-off="No"
                                    data-label-on="Yes">
                                </span>
                            </label>


                        </td>
                        <td class="col-xs-4 col-sm-3 col-md-2 col-lg-1 col-xl-1 text-center">
                            <div class="dropdown">
                                <a class="btn btn-neutral btn-sm text-light items-align-center p-2" href="#"
                                    role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-ellipsis-h text-muted"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/common/items/34/edit">Edit</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/common/items/34/duplicate">Duplicate</a>
                                    <div class="dropdown-divider"></div>
                                    <button type="button" class="dropdown-item action-delete" title="Delete"
                                        @click="confirmDelete(&quot;http://localhost/laravel/akaunting/1/common/items/34&quot;, &quot;Items&quot;, &quot;Confirm delete &lt;strong&gt;Aut deserunt.&lt;/strong&gt; item?&quot;, &quot;Cancel&quot;, &quot;Delete&quot;)">Delete</button>

                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr class="row align-items-center border-top-1">
                        <td class="col-sm-2 col-md-1 col-lg-1 col-xl-1 d-none d-sm-block">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="bulk-action-70"
                                    data-bulk-action="70" :value="70" v-model="bulk_action.selected"
                                    v-on:change="onSelect">
                                <label class="custom-control-label" for="bulk-action-70"></label>
                            </div>


                        </td>
                        <td class="col-xs-4 col-sm-4 col-md-4 col-lg-3 col-xl-3 py-2">
                            <img src="http://localhost/laravel/akaunting/public/img/akaunting-logo-green.svg"
                                class="avatar image-style p-1 mr-3 item-img hidden-md col-aka"
                                alt="Aut laboriosam.">
                            <a href="http://localhost/laravel/akaunting/1/common/items/70/edit">Aut
                                laboriosam.</a>
                        </td>
                        <td class="col-lg-1 col-xl-2 d-none d-lg-block long-texts">
                            Atque.
                        </td>
                        <td class="col-md-3 col-lg-3 col-xl-2 text-right d-none d-md-block">
                            $10.08
                        </td>
                        <td class="col-lg-2 col-xl-2 text-right d-none d-lg-block">
                            $17.24
                        </td>
                        <td class="col-xs-4 col-sm-3 col-md-2 col-lg-1 col-xl-1 text-center">
                            <label class="custom-toggle d-inline-block">
                                <input type="checkbox" name="status[70]"
                                    @input="bulk_action.path='1/common/items'; onStatus(70, $event)" checked>

                                <span class="custom-toggle-slider rounded-circle status-green" data-label-off="No"
                                    data-label-on="Yes">
                                </span>
                            </label>


                        </td>
                        <td class="col-xs-4 col-sm-3 col-md-2 col-lg-1 col-xl-1 text-center">
                            <div class="dropdown">
                                <a class="btn btn-neutral btn-sm text-light items-align-center p-2" href="#"
                                    role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-ellipsis-h text-muted"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/common/items/70/edit">Edit</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/common/items/70/duplicate">Duplicate</a>
                                    <div class="dropdown-divider"></div>
                                    <button type="button" class="dropdown-item action-delete" title="Delete"
                                        @click="confirmDelete(&quot;http://localhost/laravel/akaunting/1/common/items/70&quot;, &quot;Items&quot;, &quot;Confirm delete &lt;strong&gt;Aut laboriosam.&lt;/strong&gt; item?&quot;, &quot;Cancel&quot;, &quot;Delete&quot;)">Delete</button>

                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr class="row align-items-center border-top-1">
                        <td class="col-sm-2 col-md-1 col-lg-1 col-xl-1 d-none d-sm-block">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="bulk-action-28"
                                    data-bulk-action="28" :value="28" v-model="bulk_action.selected"
                                    v-on:change="onSelect">
                                <label class="custom-control-label" for="bulk-action-28"></label>
                            </div>


                        </td>
                        <td class="col-xs-4 col-sm-4 col-md-4 col-lg-3 col-xl-3 py-2">
                            <img src="http://localhost/laravel/akaunting/public/img/akaunting-logo-green.svg"
                                class="avatar image-style p-1 mr-3 item-img hidden-md col-aka" alt="Aut neque.">
                            <a href="http://localhost/laravel/akaunting/1/common/items/28/edit">Aut
                                neque.</a>
                        </td>
                        <td class="col-lg-1 col-xl-2 d-none d-lg-block long-texts">
                            Eum quidem.
                        </td>
                        <td class="col-md-3 col-lg-3 col-xl-2 text-right d-none d-md-block">
                            $11.44
                        </td>
                        <td class="col-lg-2 col-xl-2 text-right d-none d-lg-block">
                            $19.17
                        </td>
                        <td class="col-xs-4 col-sm-3 col-md-2 col-lg-1 col-xl-1 text-center">
                            <label class="custom-toggle d-inline-block">
                                <input type="checkbox" name="status[28]"
                                    @input="bulk_action.path='1/common/items'; onStatus(28, $event)" checked>

                                <span class="custom-toggle-slider rounded-circle status-green" data-label-off="No"
                                    data-label-on="Yes">
                                </span>
                            </label>


                        </td>
                        <td class="col-xs-4 col-sm-3 col-md-2 col-lg-1 col-xl-1 text-center">
                            <div class="dropdown">
                                <a class="btn btn-neutral btn-sm text-light items-align-center p-2" href="#"
                                    role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-ellipsis-h text-muted"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/common/items/28/edit">Edit</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/common/items/28/duplicate">Duplicate</a>
                                    <div class="dropdown-divider"></div>
                                    <button type="button" class="dropdown-item action-delete" title="Delete"
                                        @click="confirmDelete(&quot;http://localhost/laravel/akaunting/1/common/items/28&quot;, &quot;Items&quot;, &quot;Confirm delete &lt;strong&gt;Aut neque.&lt;/strong&gt; item?&quot;, &quot;Cancel&quot;, &quot;Delete&quot;)">Delete</button>

                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr class="row align-items-center border-top-1">
                        <td class="col-sm-2 col-md-1 col-lg-1 col-xl-1 d-none d-sm-block">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="bulk-action-68"
                                    data-bulk-action="68" :value="68" v-model="bulk_action.selected"
                                    v-on:change="onSelect">
                                <label class="custom-control-label" for="bulk-action-68"></label>
                            </div>


                        </td>
                        <td class="col-xs-4 col-sm-4 col-md-4 col-lg-3 col-xl-3 py-2">
                            <img src="http://localhost/laravel/akaunting/public/img/akaunting-logo-green.svg"
                                class="avatar image-style p-1 mr-3 item-img hidden-md col-aka" alt="Aut velit.">
                            <a href="http://localhost/laravel/akaunting/1/common/items/68/edit">Aut
                                velit.</a>
                        </td>
                        <td class="col-lg-1 col-xl-2 d-none d-lg-block long-texts">
                            Iure aut illum.
                        </td>
                        <td class="col-md-3 col-lg-3 col-xl-2 text-right d-none d-md-block">
                            $16.00
                        </td>
                        <td class="col-lg-2 col-xl-2 text-right d-none d-lg-block">
                            $13.93
                        </td>
                        <td class="col-xs-4 col-sm-3 col-md-2 col-lg-1 col-xl-1 text-center">
                            <label class="custom-toggle d-inline-block">
                                <input type="checkbox" name="status[68]"
                                    @input="bulk_action.path='1/common/items'; onStatus(68, $event)">

                                <span class="custom-toggle-slider rounded-circle status-green" data-label-off="No"
                                    data-label-on="Yes">
                                </span>
                            </label>


                        </td>
                        <td class="col-xs-4 col-sm-3 col-md-2 col-lg-1 col-xl-1 text-center">
                            <div class="dropdown">
                                <a class="btn btn-neutral btn-sm text-light items-align-center p-2" href="#"
                                    role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-ellipsis-h text-muted"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/common/items/68/edit">Edit</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/common/items/68/duplicate">Duplicate</a>
                                    <div class="dropdown-divider"></div>
                                    <button type="button" class="dropdown-item action-delete" title="Delete"
                                        @click="confirmDelete(&quot;http://localhost/laravel/akaunting/1/common/items/68&quot;, &quot;Items&quot;, &quot;Confirm delete &lt;strong&gt;Aut velit.&lt;/strong&gt; item?&quot;, &quot;Cancel&quot;, &quot;Delete&quot;)">Delete</button>

                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr class="row align-items-center border-top-1">
                        <td class="col-sm-2 col-md-1 col-lg-1 col-xl-1 d-none d-sm-block">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="bulk-action-53"
                                    data-bulk-action="53" :value="53" v-model="bulk_action.selected"
                                    v-on:change="onSelect">
                                <label class="custom-control-label" for="bulk-action-53"></label>
                            </div>


                        </td>
                        <td class="col-xs-4 col-sm-4 col-md-4 col-lg-3 col-xl-3 py-2">
                            <img src="http://localhost/laravel/akaunting/public/img/akaunting-logo-green.svg"
                                class="avatar image-style p-1 mr-3 item-img hidden-md col-aka"
                                alt="Autem non nemo.">
                            <a href="http://localhost/laravel/akaunting/1/common/items/53/edit">Autem
                                non nemo.</a>
                        </td>
                        <td class="col-lg-1 col-xl-2 d-none d-lg-block long-texts">
                            Animi.
                        </td>
                        <td class="col-md-3 col-lg-3 col-xl-2 text-right d-none d-md-block">
                            $18.88
                        </td>
                        <td class="col-lg-2 col-xl-2 text-right d-none d-lg-block">
                            $12.20
                        </td>
                        <td class="col-xs-4 col-sm-3 col-md-2 col-lg-1 col-xl-1 text-center">
                            <label class="custom-toggle d-inline-block">
                                <input type="checkbox" name="status[53]"
                                    @input="bulk_action.path='1/common/items'; onStatus(53, $event)">

                                <span class="custom-toggle-slider rounded-circle status-green" data-label-off="No"
                                    data-label-on="Yes">
                                </span>
                            </label>


                        </td>
                        <td class="col-xs-4 col-sm-3 col-md-2 col-lg-1 col-xl-1 text-center">
                            <div class="dropdown">
                                <a class="btn btn-neutral btn-sm text-light items-align-center p-2" href="#"
                                    role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-ellipsis-h text-muted"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/common/items/53/edit">Edit</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/common/items/53/duplicate">Duplicate</a>
                                    <div class="dropdown-divider"></div>
                                    <button type="button" class="dropdown-item action-delete" title="Delete"
                                        @click="confirmDelete(&quot;http://localhost/laravel/akaunting/1/common/items/53&quot;, &quot;Items&quot;, &quot;Confirm delete &lt;strong&gt;Autem non nemo.&lt;/strong&gt; item?&quot;, &quot;Cancel&quot;, &quot;Delete&quot;)">Delete</button>

                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr class="row align-items-center border-top-1">
                        <td class="col-sm-2 col-md-1 col-lg-1 col-xl-1 d-none d-sm-block">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="bulk-action-65"
                                    data-bulk-action="65" :value="65" v-model="bulk_action.selected"
                                    v-on:change="onSelect">
                                <label class="custom-control-label" for="bulk-action-65"></label>
                            </div>


                        </td>
                        <td class="col-xs-4 col-sm-4 col-md-4 col-lg-3 col-xl-3 py-2">
                            <img src="http://localhost/laravel/akaunting/public/img/akaunting-logo-green.svg"
                                class="avatar image-style p-1 mr-3 item-img hidden-md col-aka" alt="Autem officia.">
                            <a href="http://localhost/laravel/akaunting/1/common/items/65/edit">Autem
                                officia.</a>
                        </td>
                        <td class="col-lg-1 col-xl-2 d-none d-lg-block long-texts">
                            Dicta.
                        </td>
                        <td class="col-md-3 col-lg-3 col-xl-2 text-right d-none d-md-block">
                            $13.63
                        </td>
                        <td class="col-lg-2 col-xl-2 text-right d-none d-lg-block">
                            $15.40
                        </td>
                        <td class="col-xs-4 col-sm-3 col-md-2 col-lg-1 col-xl-1 text-center">
                            <label class="custom-toggle d-inline-block">
                                <input type="checkbox" name="status[65]"
                                    @input="bulk_action.path='1/common/items'; onStatus(65, $event)">

                                <span class="custom-toggle-slider rounded-circle status-green" data-label-off="No"
                                    data-label-on="Yes">
                                </span>
                            </label>


                        </td>
                        <td class="col-xs-4 col-sm-3 col-md-2 col-lg-1 col-xl-1 text-center">
                            <div class="dropdown">
                                <a class="btn btn-neutral btn-sm text-light items-align-center p-2" href="#"
                                    role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-ellipsis-h text-muted"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/common/items/65/edit">Edit</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/common/items/65/duplicate">Duplicate</a>
                                    <div class="dropdown-divider"></div>
                                    <button type="button" class="dropdown-item action-delete" title="Delete"
                                        @click="confirmDelete(&quot;http://localhost/laravel/akaunting/1/common/items/65&quot;, &quot;Items&quot;, &quot;Confirm delete &lt;strong&gt;Autem officia.&lt;/strong&gt; item?&quot;, &quot;Cancel&quot;, &quot;Delete&quot;)">Delete</button>

                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr class="row align-items-center border-top-1">
                        <td class="col-sm-2 col-md-1 col-lg-1 col-xl-1 d-none d-sm-block">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="bulk-action-78"
                                    data-bulk-action="78" :value="78" v-model="bulk_action.selected"
                                    v-on:change="onSelect">
                                <label class="custom-control-label" for="bulk-action-78"></label>
                            </div>


                        </td>
                        <td class="col-xs-4 col-sm-4 col-md-4 col-lg-3 col-xl-3 py-2">
                            <img src="http://localhost/laravel/akaunting/public/img/akaunting-logo-green.svg"
                                class="avatar image-style p-1 mr-3 item-img hidden-md col-aka"
                                alt="Beatae tenetur.">
                            <a href="http://localhost/laravel/akaunting/1/common/items/78/edit">Beatae
                                tenetur.</a>
                        </td>
                        <td class="col-lg-1 col-xl-2 d-none d-lg-block long-texts">
                            Eum quidem.
                        </td>
                        <td class="col-md-3 col-lg-3 col-xl-2 text-right d-none d-md-block">
                            $10.19
                        </td>
                        <td class="col-lg-2 col-xl-2 text-right d-none d-lg-block">
                            $11.74
                        </td>
                        <td class="col-xs-4 col-sm-3 col-md-2 col-lg-1 col-xl-1 text-center">
                            <label class="custom-toggle d-inline-block">
                                <input type="checkbox" name="status[78]"
                                    @input="bulk_action.path='1/common/items'; onStatus(78, $event)" checked>

                                <span class="custom-toggle-slider rounded-circle status-green" data-label-off="No"
                                    data-label-on="Yes">
                                </span>
                            </label>


                        </td>
                        <td class="col-xs-4 col-sm-3 col-md-2 col-lg-1 col-xl-1 text-center">
                            <div class="dropdown">
                                <a class="btn btn-neutral btn-sm text-light items-align-center p-2" href="#"
                                    role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-ellipsis-h text-muted"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/common/items/78/edit">Edit</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/common/items/78/duplicate">Duplicate</a>
                                    <div class="dropdown-divider"></div>
                                    <button type="button" class="dropdown-item action-delete" title="Delete"
                                        @click="confirmDelete(&quot;http://localhost/laravel/akaunting/1/common/items/78&quot;, &quot;Items&quot;, &quot;Confirm delete &lt;strong&gt;Beatae tenetur.&lt;/strong&gt; item?&quot;, &quot;Cancel&quot;, &quot;Delete&quot;)">Delete</button>

                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr class="row align-items-center border-top-1">
                        <td class="col-sm-2 col-md-1 col-lg-1 col-xl-1 d-none d-sm-block">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="bulk-action-59"
                                    data-bulk-action="59" :value="59" v-model="bulk_action.selected"
                                    v-on:change="onSelect">
                                <label class="custom-control-label" for="bulk-action-59"></label>
                            </div>


                        </td>
                        <td class="col-xs-4 col-sm-4 col-md-4 col-lg-3 col-xl-3 py-2">
                            <img src="http://localhost/laravel/akaunting/public/img/akaunting-logo-green.svg"
                                class="avatar image-style p-1 mr-3 item-img hidden-md col-aka"
                                alt="Blanditiis qui.">
                            <a href="http://localhost/laravel/akaunting/1/common/items/59/edit">Blanditiis
                                qui.</a>
                        </td>
                        <td class="col-lg-1 col-xl-2 d-none d-lg-block long-texts">
                            Molestiae.
                        </td>
                        <td class="col-md-3 col-lg-3 col-xl-2 text-right d-none d-md-block">
                            $18.40
                        </td>
                        <td class="col-lg-2 col-xl-2 text-right d-none d-lg-block">
                            $10.88
                        </td>
                        <td class="col-xs-4 col-sm-3 col-md-2 col-lg-1 col-xl-1 text-center">
                            <label class="custom-toggle d-inline-block">
                                <input type="checkbox" name="status[59]"
                                    @input="bulk_action.path='1/common/items'; onStatus(59, $event)" checked>

                                <span class="custom-toggle-slider rounded-circle status-green" data-label-off="No"
                                    data-label-on="Yes">
                                </span>
                            </label>


                        </td>
                        <td class="col-xs-4 col-sm-3 col-md-2 col-lg-1 col-xl-1 text-center">
                            <div class="dropdown">
                                <a class="btn btn-neutral btn-sm text-light items-align-center p-2" href="#"
                                    role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-ellipsis-h text-muted"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/common/items/59/edit">Edit</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/common/items/59/duplicate">Duplicate</a>
                                    <div class="dropdown-divider"></div>
                                    <button type="button" class="dropdown-item action-delete" title="Delete"
                                        @click="confirmDelete(&quot;http://localhost/laravel/akaunting/1/common/items/59&quot;, &quot;Items&quot;, &quot;Confirm delete &lt;strong&gt;Blanditiis qui.&lt;/strong&gt; item?&quot;, &quot;Cancel&quot;, &quot;Delete&quot;)">Delete</button>

                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr class="row align-items-center border-top-1">
                        <td class="col-sm-2 col-md-1 col-lg-1 col-xl-1 d-none d-sm-block">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="bulk-action-11"
                                    data-bulk-action="11" :value="11" v-model="bulk_action.selected"
                                    v-on:change="onSelect">
                                <label class="custom-control-label" for="bulk-action-11"></label>
                            </div>


                        </td>
                        <td class="col-xs-4 col-sm-4 col-md-4 col-lg-3 col-xl-3 py-2">
                            <img src="http://localhost/laravel/akaunting/public/img/akaunting-logo-green.svg"
                                class="avatar image-style p-1 mr-3 item-img hidden-md col-aka" alt="Culpa nihil.">
                            <a href="http://localhost/laravel/akaunting/1/common/items/11/edit">Culpa
                                nihil.</a>
                        </td>
                        <td class="col-lg-1 col-xl-2 d-none d-lg-block long-texts">
                            Consectetur.
                        </td>
                        <td class="col-md-3 col-lg-3 col-xl-2 text-right d-none d-md-block">
                            $15.85
                        </td>
                        <td class="col-lg-2 col-xl-2 text-right d-none d-lg-block">
                            $11.80
                        </td>
                        <td class="col-xs-4 col-sm-3 col-md-2 col-lg-1 col-xl-1 text-center">
                            <label class="custom-toggle d-inline-block">
                                <input type="checkbox" name="status[11]"
                                    @input="bulk_action.path='1/common/items'; onStatus(11, $event)">

                                <span class="custom-toggle-slider rounded-circle status-green" data-label-off="No"
                                    data-label-on="Yes">
                                </span>
                            </label>


                        </td>
                        <td class="col-xs-4 col-sm-3 col-md-2 col-lg-1 col-xl-1 text-center">
                            <div class="dropdown">
                                <a class="btn btn-neutral btn-sm text-light items-align-center p-2" href="#"
                                    role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-ellipsis-h text-muted"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/common/items/11/edit">Edit</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/common/items/11/duplicate">Duplicate</a>
                                    <div class="dropdown-divider"></div>
                                    <button type="button" class="dropdown-item action-delete" title="Delete"
                                        @click="confirmDelete(&quot;http://localhost/laravel/akaunting/1/common/items/11&quot;, &quot;Items&quot;, &quot;Confirm delete &lt;strong&gt;Culpa nihil.&lt;/strong&gt; item?&quot;, &quot;Cancel&quot;, &quot;Delete&quot;)">Delete</button>

                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr class="row align-items-center border-top-1">
                        <td class="col-sm-2 col-md-1 col-lg-1 col-xl-1 d-none d-sm-block">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="bulk-action-52"
                                    data-bulk-action="52" :value="52" v-model="bulk_action.selected"
                                    v-on:change="onSelect">
                                <label class="custom-control-label" for="bulk-action-52"></label>
                            </div>


                        </td>
                        <td class="col-xs-4 col-sm-4 col-md-4 col-lg-3 col-xl-3 py-2">
                            <img src="http://localhost/laravel/akaunting/public/img/akaunting-logo-green.svg"
                                class="avatar image-style p-1 mr-3 item-img hidden-md col-aka" alt="Debitis iste.">
                            <a href="http://localhost/laravel/akaunting/1/common/items/52/edit">Debitis
                                iste.</a>
                        </td>
                        <td class="col-lg-1 col-xl-2 d-none d-lg-block long-texts">
                            Animi.
                        </td>
                        <td class="col-md-3 col-lg-3 col-xl-2 text-right d-none d-md-block">
                            $17.15
                        </td>
                        <td class="col-lg-2 col-xl-2 text-right d-none d-lg-block">
                            $12.04
                        </td>
                        <td class="col-xs-4 col-sm-3 col-md-2 col-lg-1 col-xl-1 text-center">
                            <label class="custom-toggle d-inline-block">
                                <input type="checkbox" name="status[52]"
                                    @input="bulk_action.path='1/common/items'; onStatus(52, $event)" checked>

                                <span class="custom-toggle-slider rounded-circle status-green" data-label-off="No"
                                    data-label-on="Yes">
                                </span>
                            </label>


                        </td>
                        <td class="col-xs-4 col-sm-3 col-md-2 col-lg-1 col-xl-1 text-center">
                            <div class="dropdown">
                                <a class="btn btn-neutral btn-sm text-light items-align-center p-2" href="#"
                                    role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-ellipsis-h text-muted"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/common/items/52/edit">Edit</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/common/items/52/duplicate">Duplicate</a>
                                    <div class="dropdown-divider"></div>
                                    <button type="button" class="dropdown-item action-delete" title="Delete"
                                        @click="confirmDelete(&quot;http://localhost/laravel/akaunting/1/common/items/52&quot;, &quot;Items&quot;, &quot;Confirm delete &lt;strong&gt;Debitis iste.&lt;/strong&gt; item?&quot;, &quot;Cancel&quot;, &quot;Delete&quot;)">Delete</button>

                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr class="row align-items-center border-top-1">
                        <td class="col-sm-2 col-md-1 col-lg-1 col-xl-1 d-none d-sm-block">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="bulk-action-16"
                                    data-bulk-action="16" :value="16" v-model="bulk_action.selected"
                                    v-on:change="onSelect">
                                <label class="custom-control-label" for="bulk-action-16"></label>
                            </div>


                        </td>
                        <td class="col-xs-4 col-sm-4 col-md-4 col-lg-3 col-xl-3 py-2">
                            <img src="http://localhost/laravel/akaunting/public/img/akaunting-logo-green.svg"
                                class="avatar image-style p-1 mr-3 item-img hidden-md col-aka" alt="Dignissimos a.">
                            <a href="http://localhost/laravel/akaunting/1/common/items/16/edit">Dignissimos
                                a.</a>
                        </td>
                        <td class="col-lg-1 col-xl-2 d-none d-lg-block long-texts">
                            Iure aut illum.
                        </td>
                        <td class="col-md-3 col-lg-3 col-xl-2 text-right d-none d-md-block">
                            $12.08
                        </td>
                        <td class="col-lg-2 col-xl-2 text-right d-none d-lg-block">
                            $13.32
                        </td>
                        <td class="col-xs-4 col-sm-3 col-md-2 col-lg-1 col-xl-1 text-center">
                            <label class="custom-toggle d-inline-block">
                                <input type="checkbox" name="status[16]"
                                    @input="bulk_action.path='1/common/items'; onStatus(16, $event)">

                                <span class="custom-toggle-slider rounded-circle status-green" data-label-off="No"
                                    data-label-on="Yes">
                                </span>
                            </label>


                        </td>
                        <td class="col-xs-4 col-sm-3 col-md-2 col-lg-1 col-xl-1 text-center">
                            <div class="dropdown">
                                <a class="btn btn-neutral btn-sm text-light items-align-center p-2" href="#"
                                    role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-ellipsis-h text-muted"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/common/items/16/edit">Edit</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/common/items/16/duplicate">Duplicate</a>
                                    <div class="dropdown-divider"></div>
                                    <button type="button" class="dropdown-item action-delete" title="Delete"
                                        @click="confirmDelete(&quot;http://localhost/laravel/akaunting/1/common/items/16&quot;, &quot;Items&quot;, &quot;Confirm delete &lt;strong&gt;Dignissimos a.&lt;/strong&gt; item?&quot;, &quot;Cancel&quot;, &quot;Delete&quot;)">Delete</button>

                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr class="row align-items-center border-top-1">
                        <td class="col-sm-2 col-md-1 col-lg-1 col-xl-1 d-none d-sm-block">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="bulk-action-42"
                                    data-bulk-action="42" :value="42" v-model="bulk_action.selected"
                                    v-on:change="onSelect">
                                <label class="custom-control-label" for="bulk-action-42"></label>
                            </div>


                        </td>
                        <td class="col-xs-4 col-sm-4 col-md-4 col-lg-3 col-xl-3 py-2">
                            <img src="http://localhost/laravel/akaunting/public/img/akaunting-logo-green.svg"
                                class="avatar image-style p-1 mr-3 item-img hidden-md col-aka" alt="Dolore aut.">
                            <a href="http://localhost/laravel/akaunting/1/common/items/42/edit">Dolore
                                aut.</a>
                        </td>
                        <td class="col-lg-1 col-xl-2 d-none d-lg-block long-texts">
                            Quia id.
                        </td>
                        <td class="col-md-3 col-lg-3 col-xl-2 text-right d-none d-md-block">
                            $19.74
                        </td>
                        <td class="col-lg-2 col-xl-2 text-right d-none d-lg-block">
                            $15.36
                        </td>
                        <td class="col-xs-4 col-sm-3 col-md-2 col-lg-1 col-xl-1 text-center">
                            <label class="custom-toggle d-inline-block">
                                <input type="checkbox" name="status[42]"
                                    @input="bulk_action.path='1/common/items'; onStatus(42, $event)">

                                <span class="custom-toggle-slider rounded-circle status-green" data-label-off="No"
                                    data-label-on="Yes">
                                </span>
                            </label>


                        </td>
                        <td class="col-xs-4 col-sm-3 col-md-2 col-lg-1 col-xl-1 text-center">
                            <div class="dropdown">
                                <a class="btn btn-neutral btn-sm text-light items-align-center p-2" href="#"
                                    role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-ellipsis-h text-muted"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/common/items/42/edit">Edit</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/common/items/42/duplicate">Duplicate</a>
                                    <div class="dropdown-divider"></div>
                                    <button type="button" class="dropdown-item action-delete" title="Delete"
                                        @click="confirmDelete(&quot;http://localhost/laravel/akaunting/1/common/items/42&quot;, &quot;Items&quot;, &quot;Confirm delete &lt;strong&gt;Dolore aut.&lt;/strong&gt; item?&quot;, &quot;Cancel&quot;, &quot;Delete&quot;)">Delete</button>

                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr class="row align-items-center border-top-1">
                        <td class="col-sm-2 col-md-1 col-lg-1 col-xl-1 d-none d-sm-block">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="bulk-action-79"
                                    data-bulk-action="79" :value="79" v-model="bulk_action.selected"
                                    v-on:change="onSelect">
                                <label class="custom-control-label" for="bulk-action-79"></label>
                            </div>


                        </td>
                        <td class="col-xs-4 col-sm-4 col-md-4 col-lg-3 col-xl-3 py-2">
                            <img src="http://localhost/laravel/akaunting/public/img/akaunting-logo-green.svg"
                                class="avatar image-style p-1 mr-3 item-img hidden-md col-aka"
                                alt="Dolore dolorem.">
                            <a href="http://localhost/laravel/akaunting/1/common/items/79/edit">Dolore
                                dolorem.</a>
                        </td>
                        <td class="col-lg-1 col-xl-2 d-none d-lg-block long-texts">
                            Blanditiis.
                        </td>
                        <td class="col-md-3 col-lg-3 col-xl-2 text-right d-none d-md-block">
                            $17.23
                        </td>
                        <td class="col-lg-2 col-xl-2 text-right d-none d-lg-block">
                            $12.79
                        </td>
                        <td class="col-xs-4 col-sm-3 col-md-2 col-lg-1 col-xl-1 text-center">
                            <label class="custom-toggle d-inline-block">
                                <input type="checkbox" name="status[79]"
                                    @input="bulk_action.path='1/common/items'; onStatus(79, $event)" checked>

                                <span class="custom-toggle-slider rounded-circle status-green" data-label-off="No"
                                    data-label-on="Yes">
                                </span>
                            </label>


                        </td>
                        <td class="col-xs-4 col-sm-3 col-md-2 col-lg-1 col-xl-1 text-center">
                            <div class="dropdown">
                                <a class="btn btn-neutral btn-sm text-light items-align-center p-2" href="#"
                                    role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-ellipsis-h text-muted"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/common/items/79/edit">Edit</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/common/items/79/duplicate">Duplicate</a>
                                    <div class="dropdown-divider"></div>
                                    <button type="button" class="dropdown-item action-delete" title="Delete"
                                        @click="confirmDelete(&quot;http://localhost/laravel/akaunting/1/common/items/79&quot;, &quot;Items&quot;, &quot;Confirm delete &lt;strong&gt;Dolore dolorem.&lt;/strong&gt; item?&quot;, &quot;Cancel&quot;, &quot;Delete&quot;)">Delete</button>

                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr class="row align-items-center border-top-1">
                        <td class="col-sm-2 col-md-1 col-lg-1 col-xl-1 d-none d-sm-block">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="bulk-action-97"
                                    data-bulk-action="97" :value="97" v-model="bulk_action.selected"
                                    v-on:change="onSelect">
                                <label class="custom-control-label" for="bulk-action-97"></label>
                            </div>


                        </td>
                        <td class="col-xs-4 col-sm-4 col-md-4 col-lg-3 col-xl-3 py-2">
                            <img src="http://localhost/laravel/akaunting/public/img/akaunting-logo-green.svg"
                                class="avatar image-style p-1 mr-3 item-img hidden-md col-aka" alt="Dolore fuga.">
                            <a href="http://localhost/laravel/akaunting/1/common/items/97/edit">Dolore
                                fuga.</a>
                        </td>
                        <td class="col-lg-1 col-xl-2 d-none d-lg-block long-texts">
                            Temporibus.
                        </td>
                        <td class="col-md-3 col-lg-3 col-xl-2 text-right d-none d-md-block">
                            $12.26
                        </td>
                        <td class="col-lg-2 col-xl-2 text-right d-none d-lg-block">
                            $16.92
                        </td>
                        <td class="col-xs-4 col-sm-3 col-md-2 col-lg-1 col-xl-1 text-center">
                            <label class="custom-toggle d-inline-block">
                                <input type="checkbox" name="status[97]"
                                    @input="bulk_action.path='1/common/items'; onStatus(97, $event)">

                                <span class="custom-toggle-slider rounded-circle status-green" data-label-off="No"
                                    data-label-on="Yes">
                                </span>
                            </label>


                        </td>
                        <td class="col-xs-4 col-sm-3 col-md-2 col-lg-1 col-xl-1 text-center">
                            <div class="dropdown">
                                <a class="btn btn-neutral btn-sm text-light items-align-center p-2" href="#"
                                    role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-ellipsis-h text-muted"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/common/items/97/edit">Edit</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/common/items/97/duplicate">Duplicate</a>
                                    <div class="dropdown-divider"></div>
                                    <button type="button" class="dropdown-item action-delete" title="Delete"
                                        @click="confirmDelete(&quot;http://localhost/laravel/akaunting/1/common/items/97&quot;, &quot;Items&quot;, &quot;Confirm delete &lt;strong&gt;Dolore fuga.&lt;/strong&gt; item?&quot;, &quot;Cancel&quot;, &quot;Delete&quot;)">Delete</button>

                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr class="row align-items-center border-top-1">
                        <td class="col-sm-2 col-md-1 col-lg-1 col-xl-1 d-none d-sm-block">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="bulk-action-61"
                                    data-bulk-action="61" :value="61" v-model="bulk_action.selected"
                                    v-on:change="onSelect">
                                <label class="custom-control-label" for="bulk-action-61"></label>
                            </div>


                        </td>
                        <td class="col-xs-4 col-sm-4 col-md-4 col-lg-3 col-xl-3 py-2">
                            <img src="http://localhost/laravel/akaunting/public/img/akaunting-logo-green.svg"
                                class="avatar image-style p-1 mr-3 item-img hidden-md col-aka" alt="Dolorem odit.">
                            <a href="http://localhost/laravel/akaunting/1/common/items/61/edit">Dolorem
                                odit.</a>
                        </td>
                        <td class="col-lg-1 col-xl-2 d-none d-lg-block long-texts">
                            Est rem ut.
                        </td>
                        <td class="col-md-3 col-lg-3 col-xl-2 text-right d-none d-md-block">
                            $12.77
                        </td>
                        <td class="col-lg-2 col-xl-2 text-right d-none d-lg-block">
                            $17.65
                        </td>
                        <td class="col-xs-4 col-sm-3 col-md-2 col-lg-1 col-xl-1 text-center">
                            <label class="custom-toggle d-inline-block">
                                <input type="checkbox" name="status[61]"
                                    @input="bulk_action.path='1/common/items'; onStatus(61, $event)">

                                <span class="custom-toggle-slider rounded-circle status-green" data-label-off="No"
                                    data-label-on="Yes">
                                </span>
                            </label>


                        </td>
                        <td class="col-xs-4 col-sm-3 col-md-2 col-lg-1 col-xl-1 text-center">
                            <div class="dropdown">
                                <a class="btn btn-neutral btn-sm text-light items-align-center p-2" href="#"
                                    role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-ellipsis-h text-muted"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/common/items/61/edit">Edit</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/common/items/61/duplicate">Duplicate</a>
                                    <div class="dropdown-divider"></div>
                                    <button type="button" class="dropdown-item action-delete" title="Delete"
                                        @click="confirmDelete(&quot;http://localhost/laravel/akaunting/1/common/items/61&quot;, &quot;Items&quot;, &quot;Confirm delete &lt;strong&gt;Dolorem odit.&lt;/strong&gt; item?&quot;, &quot;Cancel&quot;, &quot;Delete&quot;)">Delete</button>

                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="card-footer table-action">
            <div class="row align-items-center">
                <div class="col-xs-12 col-sm-5 d-flex align-items-center">
                    <select class="form-control form-control-sm d-inline-block w-auto d-none d-md-block"
                        @change="onChangePaginationLimit($event)" name="limit">
                        <option value="10">10</option>
                        <option value="25" selected="selected">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                    <span class="table-text d-none d-lg-block ml-2">
                        per page.
                        1-25 of 100 records.
                    </span>
                </div>

                <div class="col-xs-12 col-sm-7 pagination-xs">
                    <nav class="float-right">
                        <ul class="pagination mb-0">

                            <li class="page-item disabled"><span class="page-link">«</span></li>

                            <li class="page-item active"><span class="page-link">1</span></li>
                            <li class="page-item"><a class="page-link"
                                    href="http://localhost/laravel/akaunting/1/common/items?sort=name&amp;direction=asc&amp;page=2">2</a>
                            </li>
                            <li class="page-item"><a class="page-link"
                                    href="http://localhost/laravel/akaunting/1/common/items?sort=name&amp;direction=asc&amp;page=3">3</a>
                            </li>
                            <li class="page-item d-none d-sm-block"><a class="page-link"
                                    href="http://localhost/laravel/akaunting/1/common/items?sort=name&amp;direction=asc&amp;page=4">4</a>
                            </li>


                            <li class="page-item"><a class="page-link"
                                    href="http://localhost/laravel/akaunting/1/common/items?sort=name&amp;direction=asc&amp;page=2"
                                    rel="next">»</a></li>
                        </ul>

                    </nav>
                </div>
            </div>
        </div>
    </div>


    <notifications></notifications>

    <form id="form-dynamic-component" method="POST" action="#"></form>

    <component v-bind:is="component"></component>
</div>

@endsection





