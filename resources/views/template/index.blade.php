@extends('layouts.dashboard')
@section('title','Invoices')
@section('addnew')

<a href="invoices/create" class="btn btn-success btn-sm">Add New</a>

<a href="imports/index" class="btn btn-white btn-sm">Import</a>

<a href="exports/index" class="btn btn-white btn-sm">Export</a>

@endsection

@section('content')

<div>
    <div class="card">
        <div class="card-header border-bottom-0" :class="[{'bg-gradient-primary': bulk_action.show}]">
            <form method="GET" action="http://localhost/laravel/akaunting/1/sales/invoices" accept-charset="UTF-8"
                role="form" class="mb-0">
                <div class="align-items-center" v-if="!bulk_action.show">
                    <akaunting-search placeholder="Search or filter results.." search-text="Search for this text"
                        operator-is-text="is" operator-is-not-text="is not" no-data-text="No data"
                        no-matching-data-text="No matching data" value=""
                        :filters="[{&quot;key&quot;:&quot;status&quot;,&quot;value&quot;:&quot;Status&quot;,&quot;type&quot;:&quot;select&quot;,&quot;url&quot;:&quot;&quot;,&quot;values&quot;:{&quot;paid&quot;:&quot;Paid&quot;,&quot;partial&quot;:&quot;Partial&quot;,&quot;sent&quot;:&quot;Sent&quot;,&quot;viewed&quot;:&quot;Viewed&quot;,&quot;cancelled&quot;:&quot;Cancelled&quot;,&quot;draft&quot;:&quot;Draft&quot;}},{&quot;key&quot;:&quot;invoiced_at&quot;,&quot;value&quot;:&quot;Invoice Date&quot;,&quot;type&quot;:&quot;date&quot;,&quot;url&quot;:&quot;&quot;,&quot;values&quot;:[]},{&quot;key&quot;:&quot;due_at&quot;,&quot;value&quot;:&quot;Due Date&quot;,&quot;type&quot;:&quot;date&quot;,&quot;url&quot;:&quot;&quot;,&quot;values&quot;:[]},{&quot;key&quot;:&quot;currency_code&quot;,&quot;value&quot;:&quot;Currency&quot;,&quot;type&quot;:&quot;select&quot;,&quot;url&quot;:&quot;http:\/\/localhost\/laravel\/akaunting\/1\/settings\/currencies&quot;,&quot;values&quot;:[]},{&quot;key&quot;:&quot;contact_id&quot;,&quot;value&quot;:&quot;Contact&quot;,&quot;type&quot;:&quot;select&quot;,&quot;url&quot;:&quot;http:\/\/localhost\/laravel\/akaunting\/1\/sales\/customers&quot;,&quot;values&quot;:[]},{&quot;key&quot;:&quot;category_id&quot;,&quot;value&quot;:&quot;Category&quot;,&quot;type&quot;:&quot;select&quot;,&quot;url&quot;:&quot;http:\/\/localhost\/laravel\/akaunting\/1\/settings\/categories?search=type:income&quot;,&quot;values&quot;:[]}]"
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
                                invoice
                            </span>
                            <span v-else-if="bulk_action.count > 1">
                                invoices
                            </span>
                            selected
                        </span>
                    </div>

                    <div class="w-25 mr-4" v-if="bulk_action.count">
                        <div class="form-group mb-0">
                            <select class="form-control form-control-sm" v-model="bulk_action.value" @change="onChange">
                                <option value="*">Bulk Actions</option>
                                <option value="paid"
                                    data-message="`Are you sure you want to mark selected invoices as &lt;b&gt;paid&lt;/b&gt;?`"
                                    data-path="" data-type="">Mark Paid</option>
                                <option value="sent"
                                    data-message="`Are you sure you want to mark selected invoices as &lt;b&gt;sent&lt;/b&gt;?`"
                                    data-path="" data-type="">Mark Sent</option>
                                <option value="cancelled"
                                    data-message="`Are you sure you want to &lt;b&gt;cancel&lt;/b&gt; selected invoices/bills?`"
                                    data-path="" data-type="">Cancel</option>
                                <option value="delete"
                                    data-message="`Are you sure you want to &lt;b&gt;delete&lt;/b&gt; selected records?`"
                                    data-path="" data-type="">Delete</option>
                                <option value="export"
                                    data-message="`Are you sure you want to &lt;b&gt;export&lt;/b&gt; selected records?`"
                                    data-path="" data-type="download">Export</option>
                            </select>

                            <input type="hidden" name="bulk_action_path"
                                value="http://localhost/laravel/akaunting/1/common/bulk-actions/sales/invoices" />
                        </div>
                    </div>

                    <div class="mr-4" v-if="bulk_action.count">
                        <button type="button" class="btn btn-sm btn-outline-confirm"
                            :disabled="bulk_action.value == '*'" v-if="bulk_action.message.length"
                            @click="bulk_action.modal=true">
                            <span>Confirm</span>
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-confirm"
                            :disabled="bulk_action.value == '*'" v-if="!bulk_action.message.length" @click="onAction">
                            <span>Confirm</span>
                        </button>
                    </div>

                    <div class="mr-4" v-if="bulk_action.count">
                        <button type="button" class="btn btn-outline-clear btn-sm" @click="onClear">
                            <span>Clear</span>
                        </button>
                    </div>
                </div>

                <akaunting-modal :show="bulk_action.modal" :title="`Invoices`" :message="bulk_action.message"
                    @cancel="onCancel" v-if='bulk_action.message && bulk_action.modal'>
                    <template #card-footer>
                        <div class="float-right">
                            <button type="button" class="btn btn-outline-secondary" @click="onCancel">
                                <span>Cancel</span>
                            </button>

                            <button :disabled="bulk_action.loading" type="button" class="btn btn-success button-submit"
                                @click="onAction">
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

                        <th class="col-md-2 col-lg-1 col-xl-1 d-none d-md-block">

                            <a class="col-aka"
                                href="http://localhost/laravel/akaunting/1/sales/invoices?filter=active%2C+visible&sort=document_number&direction=asc"
                                rel="nofollow">Number</a>&nbsp; <i class="fas fa-sort-numeric-up"></i>
                        </th>

                        <th class="col-xs-4 col-sm-4 col-md-4 col-lg-2 col-xl-2 text-left">

                            <a
                                href="http://localhost/laravel/akaunting/1/sales/invoices?sort=contact_name&direction=asc">Customer</a>&nbsp;
                            <i class="fas fa-arrow-down sort-icon"></i>
                        </th>

                        <th class="col-xs-4 col-sm-4 col-md-3 col-lg-2 col-xl-2 text-right">

                            <a
                                href="http://localhost/laravel/akaunting/1/sales/invoices?sort=amount&direction=asc">Amount</a>&nbsp;
                            <i class="fas fa-arrow-down sort-icon"></i>
                        </th>

                        <th class="col-lg-2 col-xl-2 d-none d-lg-block text-left">

                            <a href="http://localhost/laravel/akaunting/1/sales/invoices?sort=issued_at&direction=asc">Invoice
                                Date</a>&nbsp; <i class="fas fa-arrow-down sort-icon"></i>
                        </th>

                        <th class="col-lg-2 col-xl-2 d-none d-lg-block text-left">

                            <a href="http://localhost/laravel/akaunting/1/sales/invoices?sort=due_at&direction=asc">Due
                                Date</a>&nbsp; <i class="fas fa-arrow-down sort-icon"></i>
                        </th>

                        <th class="col-lg-1 col-xl-1 d-none d-lg-block text-center">

                            <a
                                href="http://localhost/laravel/akaunting/1/sales/invoices?sort=status&direction=asc">Status</a>&nbsp;
                            <i class="fas fa-arrow-down sort-icon"></i>
                        </th>

                        <th class="col-xs-4 col-sm-2 col-md-2 col-lg-1 col-xl-1 text-center">
                            <a>Actions</a>
                        </th>
                    </tr>
                </thead>

                <tbody>

                    <tr class="row align-items-center border-top-1">
                        <td class="col-sm-2 col-md-1 col-lg-1 col-xl-1 d-none d-sm-block">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="bulk-action-160"
                                    data-bulk-action="160" :value="160" v-model="bulk_action.selected"
                                    v-on:change="onSelect">
                                <label class="custom-control-label" for="bulk-action-160"></label>
                            </div>


                        </td>

                        <td class="col-md-2 col-lg-1 col-xl-1 d-none d-md-block">

                            <a class="col-aka"
                                href="http://localhost/laravel/akaunting/1/sales/invoices/160">INV-99625</a>

                        </td>

                        <td class="col-xs-4 col-sm-4 col-md-4 col-lg-2 col-xl-2 text-left">

                            Barry Richardson

                        </td>

                        <td class="col-xs-4 col-sm-4 col-md-3 col-lg-2 col-xl-2 text-right">

                            $185.39
                        </td>

                        <td class="col-lg-2 col-xl-2 d-none d-lg-block text-left">

                            20 Jul 2021
                        </td>

                        <td class="col-lg-2 col-xl-2 d-none d-lg-block text-left">

                            21 Dec 2021
                        </td>

                        <td class="col-lg-1 col-xl-1 d-none d-lg-block text-center">

                            <span class="badge badge-pill badge-success">Paid</span>

                        </td>

                        <td class="col-xs-4 col-sm-2 col-md-2 col-lg-1 col-xl-1 text-center">
                            <div class="dropdown">
                                <a class="btn btn-neutral btn-sm text-light items-align-center py-2" href="#"
                                    role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-ellipsis-h text-muted"></i>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/sales/invoices/160">Show</a>

                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/sales/invoices/160/edit">Edit</a>

                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/sales/invoices/160/duplicate">Duplicate</a>

                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/sales/invoices/160/cancelled">Cancel</a>

                                    <button type="button" class="dropdown-item action-delete" title="Delete"
                                        @click="confirmDelete(&quot;http://localhost/laravel/akaunting/1/sales/invoices/160&quot;, &quot;Invoices&quot;, &quot;Confirm delete &lt;strong&gt;INV-99625&lt;/strong&gt; invoice?&quot;, &quot;Cancel&quot;, &quot;Delete&quot;)">Delete</button>

                                </div>
                            </div>
                        </td>
                    </tr>

                    <tr class="row align-items-center border-top-1">
                        <td class="col-sm-2 col-md-1 col-lg-1 col-xl-1 d-none d-sm-block">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="bulk-action-166"
                                    data-bulk-action="166" :value="166" v-model="bulk_action.selected"
                                    v-on:change="onSelect">
                                <label class="custom-control-label" for="bulk-action-166"></label>
                            </div>


                        </td>

                        <td class="col-md-2 col-lg-1 col-xl-1 d-none d-md-block">

                            <a class="col-aka"
                                href="http://localhost/laravel/akaunting/1/sales/invoices/166">INV-9770</a>

                        </td>

                        <td class="col-xs-4 col-sm-4 col-md-4 col-lg-2 col-xl-2 text-left">

                            Pete Allen

                        </td>

                        <td class="col-xs-4 col-sm-4 col-md-3 col-lg-2 col-xl-2 text-right">

                            $404.36
                        </td>

                        <td class="col-lg-2 col-xl-2 d-none d-lg-block text-left">

                            17 Oct 2021
                        </td>

                        <td class="col-lg-2 col-xl-2 d-none d-lg-block text-left">

                            22 Apr 2023
                        </td>

                        <td class="col-lg-1 col-xl-1 d-none d-lg-block text-center">

                            <span class="badge badge-pill badge-info">Partial</span>

                        </td>

                        <td class="col-xs-4 col-sm-2 col-md-2 col-lg-1 col-xl-1 text-center">
                            <div class="dropdown">
                                <a class="btn btn-neutral btn-sm text-light items-align-center py-2" href="#"
                                    role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-ellipsis-h text-muted"></i>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/sales/invoices/166">Show</a>

                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/sales/invoices/166/edit">Edit</a>

                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/sales/invoices/166/duplicate">Duplicate</a>

                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/sales/invoices/166/cancelled">Cancel</a>

                                    <button type="button" class="dropdown-item action-delete" title="Delete"
                                        @click="confirmDelete(&quot;http://localhost/laravel/akaunting/1/sales/invoices/166&quot;, &quot;Invoices&quot;, &quot;Confirm delete &lt;strong&gt;INV-9770&lt;/strong&gt; invoice?&quot;, &quot;Cancel&quot;, &quot;Delete&quot;)">Delete</button>

                                </div>
                            </div>
                        </td>
                    </tr>

                    <tr class="row align-items-center border-top-1">
                        <td class="col-sm-2 col-md-1 col-lg-1 col-xl-1 d-none d-sm-block">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="bulk-action-132"
                                    data-bulk-action="132" :value="132" v-model="bulk_action.selected"
                                    v-on:change="onSelect">
                                <label class="custom-control-label" for="bulk-action-132"></label>
                            </div>


                        </td>

                        <td class="col-md-2 col-lg-1 col-xl-1 d-none d-md-block">

                            <a class="col-aka"
                                href="http://localhost/laravel/akaunting/1/sales/invoices/132">INV-97411</a>

                        </td>

                        <td class="col-xs-4 col-sm-4 col-md-4 col-lg-2 col-xl-2 text-left">

                            Craig Khan

                        </td>

                        <td class="col-xs-4 col-sm-4 col-md-3 col-lg-2 col-xl-2 text-right">

                            $32.87
                        </td>

                        <td class="col-lg-2 col-xl-2 d-none d-lg-block text-left">

                            31 May 2021
                        </td>

                        <td class="col-lg-2 col-xl-2 d-none d-lg-block text-left">

                            18 Aug 2021
                        </td>

                        <td class="col-lg-1 col-xl-1 d-none d-lg-block text-center">

                            <span class="badge badge-pill badge-danger">Sent</span>

                        </td>

                        <td class="col-xs-4 col-sm-2 col-md-2 col-lg-1 col-xl-1 text-center">
                            <div class="dropdown">
                                <a class="btn btn-neutral btn-sm text-light items-align-center py-2" href="#"
                                    role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-ellipsis-h text-muted"></i>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/sales/invoices/132">Show</a>

                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/sales/invoices/132/edit">Edit</a>

                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/sales/invoices/132/duplicate">Duplicate</a>

                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/sales/invoices/132/cancelled">Cancel</a>

                                    <button type="button" class="dropdown-item action-delete" title="Delete"
                                        @click="confirmDelete(&quot;http://localhost/laravel/akaunting/1/sales/invoices/132&quot;, &quot;Invoices&quot;, &quot;Confirm delete &lt;strong&gt;INV-97411&lt;/strong&gt; invoice?&quot;, &quot;Cancel&quot;, &quot;Delete&quot;)">Delete</button>

                                </div>
                            </div>
                        </td>
                    </tr>

                    <tr class="row align-items-center border-top-1">
                        <td class="col-sm-2 col-md-1 col-lg-1 col-xl-1 d-none d-sm-block">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="bulk-action-158"
                                    data-bulk-action="158" :value="158" v-model="bulk_action.selected"
                                    v-on:change="onSelect">
                                <label class="custom-control-label" for="bulk-action-158"></label>
                            </div>


                        </td>

                        <td class="col-md-2 col-lg-1 col-xl-1 d-none d-md-block">

                            <a class="col-aka"
                                href="http://localhost/laravel/akaunting/1/sales/invoices/158">INV-96386</a>

                        </td>

                        <td class="col-xs-4 col-sm-4 col-md-4 col-lg-2 col-xl-2 text-left">

                            Dylan Walsh

                        </td>

                        <td class="col-xs-4 col-sm-4 col-md-3 col-lg-2 col-xl-2 text-right">

                            $823.15
                        </td>

                        <td class="col-lg-2 col-xl-2 d-none d-lg-block text-left">

                            16 Mar 2021
                        </td>

                        <td class="col-lg-2 col-xl-2 d-none d-lg-block text-left">

                            07 May 2022
                        </td>

                        <td class="col-lg-1 col-xl-1 d-none d-lg-block text-center">

                            <span class="badge badge-pill badge-warning">Viewed</span>

                        </td>

                        <td class="col-xs-4 col-sm-2 col-md-2 col-lg-1 col-xl-1 text-center">
                            <div class="dropdown">
                                <a class="btn btn-neutral btn-sm text-light items-align-center py-2" href="#"
                                    role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-ellipsis-h text-muted"></i>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/sales/invoices/158">Show</a>

                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/sales/invoices/158/edit">Edit</a>

                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/sales/invoices/158/duplicate">Duplicate</a>

                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/sales/invoices/158/cancelled">Cancel</a>

                                    <button type="button" class="dropdown-item action-delete" title="Delete"
                                        @click="confirmDelete(&quot;http://localhost/laravel/akaunting/1/sales/invoices/158&quot;, &quot;Invoices&quot;, &quot;Confirm delete &lt;strong&gt;INV-96386&lt;/strong&gt; invoice?&quot;, &quot;Cancel&quot;, &quot;Delete&quot;)">Delete</button>

                                </div>
                            </div>
                        </td>
                    </tr>

                    <tr class="row align-items-center border-top-1">
                        <td class="col-sm-2 col-md-1 col-lg-1 col-xl-1 d-none d-sm-block">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="bulk-action-156"
                                    data-bulk-action="156" :value="156" v-model="bulk_action.selected"
                                    v-on:change="onSelect">
                                <label class="custom-control-label" for="bulk-action-156"></label>
                            </div>


                        </td>

                        <td class="col-md-2 col-lg-1 col-xl-1 d-none d-md-block">

                            <a class="col-aka"
                                href="http://localhost/laravel/akaunting/1/sales/invoices/156">INV-94871</a>

                        </td>

                        <td class="col-xs-4 col-sm-4 col-md-4 col-lg-2 col-xl-2 text-left">

                            Hollie Miller

                        </td>

                        <td class="col-xs-4 col-sm-4 col-md-3 col-lg-2 col-xl-2 text-right">

                            $43.82
                        </td>

                        <td class="col-lg-2 col-xl-2 d-none d-lg-block text-left">

                            29 Apr 2021
                        </td>

                        <td class="col-lg-2 col-xl-2 d-none d-lg-block text-left">

                            09 Nov 2021
                        </td>

                        <td class="col-lg-1 col-xl-1 d-none d-lg-block text-center">

                            <span class="badge badge-pill badge-primary">Draft</span>

                        </td>

                        <td class="col-xs-4 col-sm-2 col-md-2 col-lg-1 col-xl-1 text-center">
                            <div class="dropdown">
                                <a class="btn btn-neutral btn-sm text-light items-align-center py-2" href="#"
                                    role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-ellipsis-h text-muted"></i>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/sales/invoices/156">Show</a>

                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/sales/invoices/156/edit">Edit</a>

                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/sales/invoices/156/duplicate">Duplicate</a>

                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/sales/invoices/156/cancelled">Cancel</a>

                                    <button type="button" class="dropdown-item action-delete" title="Delete"
                                        @click="confirmDelete(&quot;http://localhost/laravel/akaunting/1/sales/invoices/156&quot;, &quot;Invoices&quot;, &quot;Confirm delete &lt;strong&gt;INV-94871&lt;/strong&gt; invoice?&quot;, &quot;Cancel&quot;, &quot;Delete&quot;)">Delete</button>

                                </div>
                            </div>
                        </td>
                    </tr>

                    <tr class="row align-items-center border-top-1">
                        <td class="col-sm-2 col-md-1 col-lg-1 col-xl-1 d-none d-sm-block">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="bulk-action-114"
                                    data-bulk-action="114" :value="114" v-model="bulk_action.selected"
                                    v-on:change="onSelect">
                                <label class="custom-control-label" for="bulk-action-114"></label>
                            </div>


                        </td>

                        <td class="col-md-2 col-lg-1 col-xl-1 d-none d-md-block">

                            <a class="col-aka"
                                href="http://localhost/laravel/akaunting/1/sales/invoices/114">INV-93384</a>

                        </td>

                        <td class="col-xs-4 col-sm-4 col-md-4 col-lg-2 col-xl-2 text-left">

                            Jennifer Marshall

                        </td>

                        <td class="col-xs-4 col-sm-4 col-md-3 col-lg-2 col-xl-2 text-right">

                            $635.01
                        </td>

                        <td class="col-lg-2 col-xl-2 d-none d-lg-block text-left">

                            28 Dec 2021
                        </td>

                        <td class="col-lg-2 col-xl-2 d-none d-lg-block text-left">

                            11 Jul 2024
                        </td>

                        <td class="col-lg-1 col-xl-1 d-none d-lg-block text-center">

                            <span class="badge badge-pill badge-warning">Viewed</span>

                        </td>

                        <td class="col-xs-4 col-sm-2 col-md-2 col-lg-1 col-xl-1 text-center">
                            <div class="dropdown">
                                <a class="btn btn-neutral btn-sm text-light items-align-center py-2" href="#"
                                    role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-ellipsis-h text-muted"></i>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/sales/invoices/114">Show</a>

                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/sales/invoices/114/edit">Edit</a>

                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/sales/invoices/114/duplicate">Duplicate</a>

                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/sales/invoices/114/cancelled">Cancel</a>

                                    <button type="button" class="dropdown-item action-delete" title="Delete"
                                        @click="confirmDelete(&quot;http://localhost/laravel/akaunting/1/sales/invoices/114&quot;, &quot;Invoices&quot;, &quot;Confirm delete &lt;strong&gt;INV-93384&lt;/strong&gt; invoice?&quot;, &quot;Cancel&quot;, &quot;Delete&quot;)">Delete</button>

                                </div>
                            </div>
                        </td>
                    </tr>

                    <tr class="row align-items-center border-top-1">
                        <td class="col-sm-2 col-md-1 col-lg-1 col-xl-1 d-none d-sm-block">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="bulk-action-175"
                                    data-bulk-action="175" :value="175" v-model="bulk_action.selected"
                                    v-on:change="onSelect">
                                <label class="custom-control-label" for="bulk-action-175"></label>
                            </div>


                        </td>

                        <td class="col-md-2 col-lg-1 col-xl-1 d-none d-md-block">

                            <a class="col-aka"
                                href="http://localhost/laravel/akaunting/1/sales/invoices/175">INV-93142</a>

                        </td>

                        <td class="col-xs-4 col-sm-4 col-md-4 col-lg-2 col-xl-2 text-left">

                            Alan Ward

                        </td>

                        <td class="col-xs-4 col-sm-4 col-md-3 col-lg-2 col-xl-2 text-right">

                            $315.36
                        </td>

                        <td class="col-lg-2 col-xl-2 d-none d-lg-block text-left">

                            27 Nov 2021
                        </td>

                        <td class="col-lg-2 col-xl-2 d-none d-lg-block text-left">

                            19 Oct 2022
                        </td>

                        <td class="col-lg-1 col-xl-1 d-none d-lg-block text-center">

                            <span class="badge badge-pill badge-dark">Cancelled</span>

                        </td>

                        <td class="col-xs-4 col-sm-2 col-md-2 col-lg-1 col-xl-1 text-center">
                            <div class="dropdown">
                                <a class="btn btn-neutral btn-sm text-light items-align-center py-2" href="#"
                                    role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-ellipsis-h text-muted"></i>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/sales/invoices/175">Show</a>

                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/sales/invoices/175/edit">Edit</a>


                                    <button type="button" class="dropdown-item action-delete" title="Delete"
                                        @click="confirmDelete(&quot;http://localhost/laravel/akaunting/1/sales/invoices/175&quot;, &quot;Invoices&quot;, &quot;Confirm delete &lt;strong&gt;INV-93142&lt;/strong&gt; invoice?&quot;, &quot;Cancel&quot;, &quot;Delete&quot;)">Delete</button>

                                </div>
                            </div>
                        </td>
                    </tr>

                    <tr class="row align-items-center border-top-1">
                        <td class="col-sm-2 col-md-1 col-lg-1 col-xl-1 d-none d-sm-block">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="bulk-action-120"
                                    data-bulk-action="120" :value="120" v-model="bulk_action.selected"
                                    v-on:change="onSelect">
                                <label class="custom-control-label" for="bulk-action-120"></label>
                            </div>


                        </td>

                        <td class="col-md-2 col-lg-1 col-xl-1 d-none d-md-block">

                            <a class="col-aka"
                                href="http://localhost/laravel/akaunting/1/sales/invoices/120">INV-92288</a>

                        </td>

                        <td class="col-xs-4 col-sm-4 col-md-4 col-lg-2 col-xl-2 text-left">

                            Lilly Saunders

                        </td>

                        <td class="col-xs-4 col-sm-4 col-md-3 col-lg-2 col-xl-2 text-right">

                            $948.09
                        </td>

                        <td class="col-lg-2 col-xl-2 d-none d-lg-block text-left">

                            18 Apr 2021
                        </td>

                        <td class="col-lg-2 col-xl-2 d-none d-lg-block text-left">

                            25 Jul 2022
                        </td>

                        <td class="col-lg-1 col-xl-1 d-none d-lg-block text-center">

                            <span class="badge badge-pill badge-dark">Cancelled</span>

                        </td>

                        <td class="col-xs-4 col-sm-2 col-md-2 col-lg-1 col-xl-1 text-center">
                            <div class="dropdown">
                                <a class="btn btn-neutral btn-sm text-light items-align-center py-2" href="#"
                                    role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-ellipsis-h text-muted"></i>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/sales/invoices/120">Show</a>

                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/sales/invoices/120/edit">Edit</a>


                                    <button type="button" class="dropdown-item action-delete" title="Delete"
                                        @click="confirmDelete(&quot;http://localhost/laravel/akaunting/1/sales/invoices/120&quot;, &quot;Invoices&quot;, &quot;Confirm delete &lt;strong&gt;INV-92288&lt;/strong&gt; invoice?&quot;, &quot;Cancel&quot;, &quot;Delete&quot;)">Delete</button>

                                </div>
                            </div>
                        </td>
                    </tr>

                    <tr class="row align-items-center border-top-1">
                        <td class="col-sm-2 col-md-1 col-lg-1 col-xl-1 d-none d-sm-block">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="bulk-action-185"
                                    data-bulk-action="185" :value="185" v-model="bulk_action.selected"
                                    v-on:change="onSelect">
                                <label class="custom-control-label" for="bulk-action-185"></label>
                            </div>


                        </td>

                        <td class="col-md-2 col-lg-1 col-xl-1 d-none d-md-block">

                            <a class="col-aka"
                                href="http://localhost/laravel/akaunting/1/sales/invoices/185">INV-92073</a>

                        </td>

                        <td class="col-xs-4 col-sm-4 col-md-4 col-lg-2 col-xl-2 text-left">

                            Ryan Smith

                        </td>

                        <td class="col-xs-4 col-sm-4 col-md-3 col-lg-2 col-xl-2 text-right">

                            $822.72
                        </td>

                        <td class="col-lg-2 col-xl-2 d-none d-lg-block text-left">

                            09 Mar 2021
                        </td>

                        <td class="col-lg-2 col-xl-2 d-none d-lg-block text-left">

                            18 Aug 2021
                        </td>

                        <td class="col-lg-1 col-xl-1 d-none d-lg-block text-center">

                            <span class="badge badge-pill badge-danger">Sent</span>

                        </td>

                        <td class="col-xs-4 col-sm-2 col-md-2 col-lg-1 col-xl-1 text-center">
                            <div class="dropdown">
                                <a class="btn btn-neutral btn-sm text-light items-align-center py-2" href="#"
                                    role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-ellipsis-h text-muted"></i>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/sales/invoices/185">Show</a>

                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/sales/invoices/185/edit">Edit</a>

                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/sales/invoices/185/duplicate">Duplicate</a>

                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/sales/invoices/185/cancelled">Cancel</a>

                                    <button type="button" class="dropdown-item action-delete" title="Delete"
                                        @click="confirmDelete(&quot;http://localhost/laravel/akaunting/1/sales/invoices/185&quot;, &quot;Invoices&quot;, &quot;Confirm delete &lt;strong&gt;INV-92073&lt;/strong&gt; invoice?&quot;, &quot;Cancel&quot;, &quot;Delete&quot;)">Delete</button>

                                </div>
                            </div>
                        </td>
                    </tr>

                    <tr class="row align-items-center border-top-1">
                        <td class="col-sm-2 col-md-1 col-lg-1 col-xl-1 d-none d-sm-block">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="bulk-action-169"
                                    data-bulk-action="169" :value="169" v-model="bulk_action.selected"
                                    v-on:change="onSelect">
                                <label class="custom-control-label" for="bulk-action-169"></label>
                            </div>


                        </td>

                        <td class="col-md-2 col-lg-1 col-xl-1 d-none d-md-block">

                            <a class="col-aka"
                                href="http://localhost/laravel/akaunting/1/sales/invoices/169">INV-91295</a>

                        </td>

                        <td class="col-xs-4 col-sm-4 col-md-4 col-lg-2 col-xl-2 text-left">

                            Hollie Miller

                        </td>

                        <td class="col-xs-4 col-sm-4 col-md-3 col-lg-2 col-xl-2 text-right">

                            $205.03
                        </td>

                        <td class="col-lg-2 col-xl-2 d-none d-lg-block text-left">

                            14 Aug 2021
                        </td>

                        <td class="col-lg-2 col-xl-2 d-none d-lg-block text-left">

                            11 Mar 2022
                        </td>

                        <td class="col-lg-1 col-xl-1 d-none d-lg-block text-center">

                            <span class="badge badge-pill badge-success">Paid</span>

                        </td>

                        <td class="col-xs-4 col-sm-2 col-md-2 col-lg-1 col-xl-1 text-center">
                            <div class="dropdown">
                                <a class="btn btn-neutral btn-sm text-light items-align-center py-2" href="#"
                                    role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-ellipsis-h text-muted"></i>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/sales/invoices/169">Show</a>

                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/sales/invoices/169/edit">Edit</a>

                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/sales/invoices/169/duplicate">Duplicate</a>

                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/sales/invoices/169/cancelled">Cancel</a>

                                    <button type="button" class="dropdown-item action-delete" title="Delete"
                                        @click="confirmDelete(&quot;http://localhost/laravel/akaunting/1/sales/invoices/169&quot;, &quot;Invoices&quot;, &quot;Confirm delete &lt;strong&gt;INV-91295&lt;/strong&gt; invoice?&quot;, &quot;Cancel&quot;, &quot;Delete&quot;)">Delete</button>

                                </div>
                            </div>
                        </td>
                    </tr>

                    <tr class="row align-items-center border-top-1">
                        <td class="col-sm-2 col-md-1 col-lg-1 col-xl-1 d-none d-sm-block">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="bulk-action-182"
                                    data-bulk-action="182" :value="182" v-model="bulk_action.selected"
                                    v-on:change="onSelect">
                                <label class="custom-control-label" for="bulk-action-182"></label>
                            </div>


                        </td>

                        <td class="col-md-2 col-lg-1 col-xl-1 d-none d-md-block">

                            <a class="col-aka"
                                href="http://localhost/laravel/akaunting/1/sales/invoices/182">INV-90690</a>

                        </td>

                        <td class="col-xs-4 col-sm-4 col-md-4 col-lg-2 col-xl-2 text-left">

                            Alan Ward

                        </td>

                        <td class="col-xs-4 col-sm-4 col-md-3 col-lg-2 col-xl-2 text-right">

                            $605.41
                        </td>

                        <td class="col-lg-2 col-xl-2 d-none d-lg-block text-left">

                            20 Feb 2021
                        </td>

                        <td class="col-lg-2 col-xl-2 d-none d-lg-block text-left">

                            17 Sep 2022
                        </td>

                        <td class="col-lg-1 col-xl-1 d-none d-lg-block text-center">

                            <span class="badge badge-pill badge-primary">Draft</span>

                        </td>

                        <td class="col-xs-4 col-sm-2 col-md-2 col-lg-1 col-xl-1 text-center">
                            <div class="dropdown">
                                <a class="btn btn-neutral btn-sm text-light items-align-center py-2" href="#"
                                    role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-ellipsis-h text-muted"></i>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/sales/invoices/182">Show</a>

                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/sales/invoices/182/edit">Edit</a>

                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/sales/invoices/182/duplicate">Duplicate</a>

                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/sales/invoices/182/cancelled">Cancel</a>

                                    <button type="button" class="dropdown-item action-delete" title="Delete"
                                        @click="confirmDelete(&quot;http://localhost/laravel/akaunting/1/sales/invoices/182&quot;, &quot;Invoices&quot;, &quot;Confirm delete &lt;strong&gt;INV-90690&lt;/strong&gt; invoice?&quot;, &quot;Cancel&quot;, &quot;Delete&quot;)">Delete</button>

                                </div>
                            </div>
                        </td>
                    </tr>

                    <tr class="row align-items-center border-top-1">
                        <td class="col-sm-2 col-md-1 col-lg-1 col-xl-1 d-none d-sm-block">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="bulk-action-125"
                                    data-bulk-action="125" :value="125" v-model="bulk_action.selected"
                                    v-on:change="onSelect">
                                <label class="custom-control-label" for="bulk-action-125"></label>
                            </div>


                        </td>

                        <td class="col-md-2 col-lg-1 col-xl-1 d-none d-md-block">

                            <a class="col-aka"
                                href="http://localhost/laravel/akaunting/1/sales/invoices/125">INV-90285</a>

                        </td>

                        <td class="col-xs-4 col-sm-4 col-md-4 col-lg-2 col-xl-2 text-left">

                            Jasmine Mason

                        </td>

                        <td class="col-xs-4 col-sm-4 col-md-3 col-lg-2 col-xl-2 text-right">

                            $728.57
                        </td>

                        <td class="col-lg-2 col-xl-2 d-none d-lg-block text-left">

                            03 Jan 2021
                        </td>

                        <td class="col-lg-2 col-xl-2 d-none d-lg-block text-left">

                            23 Mar 2023
                        </td>

                        <td class="col-lg-1 col-xl-1 d-none d-lg-block text-center">

                            <span class="badge badge-pill badge-success">Paid</span>

                        </td>

                        <td class="col-xs-4 col-sm-2 col-md-2 col-lg-1 col-xl-1 text-center">
                            <div class="dropdown">
                                <a class="btn btn-neutral btn-sm text-light items-align-center py-2" href="#"
                                    role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-ellipsis-h text-muted"></i>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/sales/invoices/125">Show</a>

                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/sales/invoices/125/edit">Edit</a>

                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/sales/invoices/125/duplicate">Duplicate</a>

                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/sales/invoices/125/cancelled">Cancel</a>

                                    <button type="button" class="dropdown-item action-delete" title="Delete"
                                        @click="confirmDelete(&quot;http://localhost/laravel/akaunting/1/sales/invoices/125&quot;, &quot;Invoices&quot;, &quot;Confirm delete &lt;strong&gt;INV-90285&lt;/strong&gt; invoice?&quot;, &quot;Cancel&quot;, &quot;Delete&quot;)">Delete</button>

                                </div>
                            </div>
                        </td>
                    </tr>

                    <tr class="row align-items-center border-top-1">
                        <td class="col-sm-2 col-md-1 col-lg-1 col-xl-1 d-none d-sm-block">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="bulk-action-153"
                                    data-bulk-action="153" :value="153" v-model="bulk_action.selected"
                                    v-on:change="onSelect">
                                <label class="custom-control-label" for="bulk-action-153"></label>
                            </div>


                        </td>

                        <td class="col-md-2 col-lg-1 col-xl-1 d-none d-md-block">

                            <a class="col-aka"
                                href="http://localhost/laravel/akaunting/1/sales/invoices/153">INV-90107</a>

                        </td>

                        <td class="col-xs-4 col-sm-4 col-md-4 col-lg-2 col-xl-2 text-left">

                            Ryan Smith

                        </td>

                        <td class="col-xs-4 col-sm-4 col-md-3 col-lg-2 col-xl-2 text-right">

                            $63.22
                        </td>

                        <td class="col-lg-2 col-xl-2 d-none d-lg-block text-left">

                            01 Apr 2021
                        </td>

                        <td class="col-lg-2 col-xl-2 d-none d-lg-block text-left">

                            07 Oct 2022
                        </td>

                        <td class="col-lg-1 col-xl-1 d-none d-lg-block text-center">

                            <span class="badge badge-pill badge-primary">Draft</span>

                        </td>

                        <td class="col-xs-4 col-sm-2 col-md-2 col-lg-1 col-xl-1 text-center">
                            <div class="dropdown">
                                <a class="btn btn-neutral btn-sm text-light items-align-center py-2" href="#"
                                    role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-ellipsis-h text-muted"></i>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/sales/invoices/153">Show</a>

                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/sales/invoices/153/edit">Edit</a>

                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/sales/invoices/153/duplicate">Duplicate</a>

                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/sales/invoices/153/cancelled">Cancel</a>

                                    <button type="button" class="dropdown-item action-delete" title="Delete"
                                        @click="confirmDelete(&quot;http://localhost/laravel/akaunting/1/sales/invoices/153&quot;, &quot;Invoices&quot;, &quot;Confirm delete &lt;strong&gt;INV-90107&lt;/strong&gt; invoice?&quot;, &quot;Cancel&quot;, &quot;Delete&quot;)">Delete</button>

                                </div>
                            </div>
                        </td>
                    </tr>

                    <tr class="row align-items-center border-top-1">
                        <td class="col-sm-2 col-md-1 col-lg-1 col-xl-1 d-none d-sm-block">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="bulk-action-194"
                                    data-bulk-action="194" :value="194" v-model="bulk_action.selected"
                                    v-on:change="onSelect">
                                <label class="custom-control-label" for="bulk-action-194"></label>
                            </div>


                        </td>

                        <td class="col-md-2 col-lg-1 col-xl-1 d-none d-md-block">

                            <a class="col-aka"
                                href="http://localhost/laravel/akaunting/1/sales/invoices/194">INV-89864</a>

                        </td>

                        <td class="col-xs-4 col-sm-4 col-md-4 col-lg-2 col-xl-2 text-left">

                            Isaac Chapman

                        </td>

                        <td class="col-xs-4 col-sm-4 col-md-3 col-lg-2 col-xl-2 text-right">

                            $83.35
                        </td>

                        <td class="col-lg-2 col-xl-2 d-none d-lg-block text-left">

                            14 May 2021
                        </td>

                        <td class="col-lg-2 col-xl-2 d-none d-lg-block text-left">

                            08 Dec 2021
                        </td>

                        <td class="col-lg-1 col-xl-1 d-none d-lg-block text-center">

                            <span class="badge badge-pill badge-dark">Cancelled</span>

                        </td>

                        <td class="col-xs-4 col-sm-2 col-md-2 col-lg-1 col-xl-1 text-center">
                            <div class="dropdown">
                                <a class="btn btn-neutral btn-sm text-light items-align-center py-2" href="#"
                                    role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-ellipsis-h text-muted"></i>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/sales/invoices/194">Show</a>

                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/sales/invoices/194/edit">Edit</a>


                                    <button type="button" class="dropdown-item action-delete" title="Delete"
                                        @click="confirmDelete(&quot;http://localhost/laravel/akaunting/1/sales/invoices/194&quot;, &quot;Invoices&quot;, &quot;Confirm delete &lt;strong&gt;INV-89864&lt;/strong&gt; invoice?&quot;, &quot;Cancel&quot;, &quot;Delete&quot;)">Delete</button>

                                </div>
                            </div>
                        </td>
                    </tr>

                    <tr class="row align-items-center border-top-1">
                        <td class="col-sm-2 col-md-1 col-lg-1 col-xl-1 d-none d-sm-block">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="bulk-action-157"
                                    data-bulk-action="157" :value="157" v-model="bulk_action.selected"
                                    v-on:change="onSelect">
                                <label class="custom-control-label" for="bulk-action-157"></label>
                            </div>


                        </td>

                        <td class="col-md-2 col-lg-1 col-xl-1 d-none d-md-block">

                            <a class="col-aka"
                                href="http://localhost/laravel/akaunting/1/sales/invoices/157">INV-89451</a>

                        </td>

                        <td class="col-xs-4 col-sm-4 col-md-4 col-lg-2 col-xl-2 text-left">

                            Anna Bennett

                        </td>

                        <td class="col-xs-4 col-sm-4 col-md-3 col-lg-2 col-xl-2 text-right">

                            $845.39
                        </td>

                        <td class="col-lg-2 col-xl-2 d-none d-lg-block text-left">

                            24 Apr 2021
                        </td>

                        <td class="col-lg-2 col-xl-2 d-none d-lg-block text-left">

                            21 Mar 2022
                        </td>

                        <td class="col-lg-1 col-xl-1 d-none d-lg-block text-center">

                            <span class="badge badge-pill badge-warning">Viewed</span>

                        </td>

                        <td class="col-xs-4 col-sm-2 col-md-2 col-lg-1 col-xl-1 text-center">
                            <div class="dropdown">
                                <a class="btn btn-neutral btn-sm text-light items-align-center py-2" href="#"
                                    role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-ellipsis-h text-muted"></i>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/sales/invoices/157">Show</a>

                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/sales/invoices/157/edit">Edit</a>

                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/sales/invoices/157/duplicate">Duplicate</a>

                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/sales/invoices/157/cancelled">Cancel</a>

                                    <button type="button" class="dropdown-item action-delete" title="Delete"
                                        @click="confirmDelete(&quot;http://localhost/laravel/akaunting/1/sales/invoices/157&quot;, &quot;Invoices&quot;, &quot;Confirm delete &lt;strong&gt;INV-89451&lt;/strong&gt; invoice?&quot;, &quot;Cancel&quot;, &quot;Delete&quot;)">Delete</button>

                                </div>
                            </div>
                        </td>
                    </tr>

                    <tr class="row align-items-center border-top-1">
                        <td class="col-sm-2 col-md-1 col-lg-1 col-xl-1 d-none d-sm-block">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="bulk-action-126"
                                    data-bulk-action="126" :value="126" v-model="bulk_action.selected"
                                    v-on:change="onSelect">
                                <label class="custom-control-label" for="bulk-action-126"></label>
                            </div>


                        </td>

                        <td class="col-md-2 col-lg-1 col-xl-1 d-none d-md-block">

                            <a class="col-aka"
                                href="http://localhost/laravel/akaunting/1/sales/invoices/126">INV-89145</a>

                        </td>

                        <td class="col-xs-4 col-sm-4 col-md-4 col-lg-2 col-xl-2 text-left">

                            Barry Richardson

                        </td>

                        <td class="col-xs-4 col-sm-4 col-md-3 col-lg-2 col-xl-2 text-right">

                            $458.27
                        </td>

                        <td class="col-lg-2 col-xl-2 d-none d-lg-block text-left">

                            24 Feb 2021
                        </td>

                        <td class="col-lg-2 col-xl-2 d-none d-lg-block text-left">

                            29 Jul 2023
                        </td>

                        <td class="col-lg-1 col-xl-1 d-none d-lg-block text-center">

                            <span class="badge badge-pill badge-primary">Draft</span>

                        </td>

                        <td class="col-xs-4 col-sm-2 col-md-2 col-lg-1 col-xl-1 text-center">
                            <div class="dropdown">
                                <a class="btn btn-neutral btn-sm text-light items-align-center py-2" href="#"
                                    role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-ellipsis-h text-muted"></i>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/sales/invoices/126">Show</a>

                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/sales/invoices/126/edit">Edit</a>

                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/sales/invoices/126/duplicate">Duplicate</a>

                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/sales/invoices/126/cancelled">Cancel</a>

                                    <button type="button" class="dropdown-item action-delete" title="Delete"
                                        @click="confirmDelete(&quot;http://localhost/laravel/akaunting/1/sales/invoices/126&quot;, &quot;Invoices&quot;, &quot;Confirm delete &lt;strong&gt;INV-89145&lt;/strong&gt; invoice?&quot;, &quot;Cancel&quot;, &quot;Delete&quot;)">Delete</button>

                                </div>
                            </div>
                        </td>
                    </tr>

                    <tr class="row align-items-center border-top-1">
                        <td class="col-sm-2 col-md-1 col-lg-1 col-xl-1 d-none d-sm-block">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="bulk-action-111"
                                    data-bulk-action="111" :value="111" v-model="bulk_action.selected"
                                    v-on:change="onSelect">
                                <label class="custom-control-label" for="bulk-action-111"></label>
                            </div>


                        </td>

                        <td class="col-md-2 col-lg-1 col-xl-1 d-none d-md-block">

                            <a class="col-aka"
                                href="http://localhost/laravel/akaunting/1/sales/invoices/111">INV-88873</a>

                        </td>

                        <td class="col-xs-4 col-sm-4 col-md-4 col-lg-2 col-xl-2 text-left">

                            Lilly Saunders

                        </td>

                        <td class="col-xs-4 col-sm-4 col-md-3 col-lg-2 col-xl-2 text-right">

                            $256.91
                        </td>

                        <td class="col-lg-2 col-xl-2 d-none d-lg-block text-left">

                            17 Jun 2021
                        </td>

                        <td class="col-lg-2 col-xl-2 d-none d-lg-block text-left">

                            17 Jan 2024
                        </td>

                        <td class="col-lg-1 col-xl-1 d-none d-lg-block text-center">

                            <span class="badge badge-pill badge-danger">Sent</span>

                        </td>

                        <td class="col-xs-4 col-sm-2 col-md-2 col-lg-1 col-xl-1 text-center">
                            <div class="dropdown">
                                <a class="btn btn-neutral btn-sm text-light items-align-center py-2" href="#"
                                    role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-ellipsis-h text-muted"></i>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/sales/invoices/111">Show</a>

                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/sales/invoices/111/edit">Edit</a>

                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/sales/invoices/111/duplicate">Duplicate</a>

                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/sales/invoices/111/cancelled">Cancel</a>

                                    <button type="button" class="dropdown-item action-delete" title="Delete"
                                        @click="confirmDelete(&quot;http://localhost/laravel/akaunting/1/sales/invoices/111&quot;, &quot;Invoices&quot;, &quot;Confirm delete &lt;strong&gt;INV-88873&lt;/strong&gt; invoice?&quot;, &quot;Cancel&quot;, &quot;Delete&quot;)">Delete</button>

                                </div>
                            </div>
                        </td>
                    </tr>

                    <tr class="row align-items-center border-top-1">
                        <td class="col-sm-2 col-md-1 col-lg-1 col-xl-1 d-none d-sm-block">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="bulk-action-187"
                                    data-bulk-action="187" :value="187" v-model="bulk_action.selected"
                                    v-on:change="onSelect">
                                <label class="custom-control-label" for="bulk-action-187"></label>
                            </div>


                        </td>

                        <td class="col-md-2 col-lg-1 col-xl-1 d-none d-md-block">

                            <a class="col-aka"
                                href="http://localhost/laravel/akaunting/1/sales/invoices/187">INV-88727</a>

                        </td>

                        <td class="col-xs-4 col-sm-4 col-md-4 col-lg-2 col-xl-2 text-left">

                            Pete Allen

                        </td>

                        <td class="col-xs-4 col-sm-4 col-md-3 col-lg-2 col-xl-2 text-right">

                            $899.57
                        </td>

                        <td class="col-lg-2 col-xl-2 d-none d-lg-block text-left">

                            25 Feb 2021
                        </td>

                        <td class="col-lg-2 col-xl-2 d-none d-lg-block text-left">

                            28 Mar 2021
                        </td>

                        <td class="col-lg-1 col-xl-1 d-none d-lg-block text-center">

                            <span class="badge badge-pill badge-dark">Cancelled</span>

                        </td>

                        <td class="col-xs-4 col-sm-2 col-md-2 col-lg-1 col-xl-1 text-center">
                            <div class="dropdown">
                                <a class="btn btn-neutral btn-sm text-light items-align-center py-2" href="#"
                                    role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-ellipsis-h text-muted"></i>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/sales/invoices/187">Show</a>

                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/sales/invoices/187/edit">Edit</a>


                                    <button type="button" class="dropdown-item action-delete" title="Delete"
                                        @click="confirmDelete(&quot;http://localhost/laravel/akaunting/1/sales/invoices/187&quot;, &quot;Invoices&quot;, &quot;Confirm delete &lt;strong&gt;INV-88727&lt;/strong&gt; invoice?&quot;, &quot;Cancel&quot;, &quot;Delete&quot;)">Delete</button>

                                </div>
                            </div>
                        </td>
                    </tr>

                    <tr class="row align-items-center border-top-1">
                        <td class="col-sm-2 col-md-1 col-lg-1 col-xl-1 d-none d-sm-block">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="bulk-action-154"
                                    data-bulk-action="154" :value="154" v-model="bulk_action.selected"
                                    v-on:change="onSelect">
                                <label class="custom-control-label" for="bulk-action-154"></label>
                            </div>


                        </td>

                        <td class="col-md-2 col-lg-1 col-xl-1 d-none d-md-block">

                            <a class="col-aka"
                                href="http://localhost/laravel/akaunting/1/sales/invoices/154">INV-86678</a>

                        </td>

                        <td class="col-xs-4 col-sm-4 col-md-4 col-lg-2 col-xl-2 text-left">

                            Mason Mason

                        </td>

                        <td class="col-xs-4 col-sm-4 col-md-3 col-lg-2 col-xl-2 text-right">

                            $889.92
                        </td>

                        <td class="col-lg-2 col-xl-2 d-none d-lg-block text-left">

                            24 Sep 2021
                        </td>

                        <td class="col-lg-2 col-xl-2 d-none d-lg-block text-left">

                            22 Jan 2024
                        </td>

                        <td class="col-lg-1 col-xl-1 d-none d-lg-block text-center">

                            <span class="badge badge-pill badge-dark">Cancelled</span>

                        </td>

                        <td class="col-xs-4 col-sm-2 col-md-2 col-lg-1 col-xl-1 text-center">
                            <div class="dropdown">
                                <a class="btn btn-neutral btn-sm text-light items-align-center py-2" href="#"
                                    role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-ellipsis-h text-muted"></i>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/sales/invoices/154">Show</a>

                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/sales/invoices/154/edit">Edit</a>


                                    <button type="button" class="dropdown-item action-delete" title="Delete"
                                        @click="confirmDelete(&quot;http://localhost/laravel/akaunting/1/sales/invoices/154&quot;, &quot;Invoices&quot;, &quot;Confirm delete &lt;strong&gt;INV-86678&lt;/strong&gt; invoice?&quot;, &quot;Cancel&quot;, &quot;Delete&quot;)">Delete</button>

                                </div>
                            </div>
                        </td>
                    </tr>

                    <tr class="row align-items-center border-top-1">
                        <td class="col-sm-2 col-md-1 col-lg-1 col-xl-1 d-none d-sm-block">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="bulk-action-127"
                                    data-bulk-action="127" :value="127" v-model="bulk_action.selected"
                                    v-on:change="onSelect">
                                <label class="custom-control-label" for="bulk-action-127"></label>
                            </div>


                        </td>

                        <td class="col-md-2 col-lg-1 col-xl-1 d-none d-md-block">

                            <a class="col-aka"
                                href="http://localhost/laravel/akaunting/1/sales/invoices/127">INV-86675</a>

                        </td>

                        <td class="col-xs-4 col-sm-4 col-md-4 col-lg-2 col-xl-2 text-left">

                            Anna Bennett

                        </td>

                        <td class="col-xs-4 col-sm-4 col-md-3 col-lg-2 col-xl-2 text-right">

                            $95.81
                        </td>

                        <td class="col-lg-2 col-xl-2 d-none d-lg-block text-left">

                            23 May 2021
                        </td>

                        <td class="col-lg-2 col-xl-2 d-none d-lg-block text-left">

                            09 May 2023
                        </td>

                        <td class="col-lg-1 col-xl-1 d-none d-lg-block text-center">

                            <span class="badge badge-pill badge-dark">Cancelled</span>

                        </td>

                        <td class="col-xs-4 col-sm-2 col-md-2 col-lg-1 col-xl-1 text-center">
                            <div class="dropdown">
                                <a class="btn btn-neutral btn-sm text-light items-align-center py-2" href="#"
                                    role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-ellipsis-h text-muted"></i>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/sales/invoices/127">Show</a>

                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/sales/invoices/127/edit">Edit</a>


                                    <button type="button" class="dropdown-item action-delete" title="Delete"
                                        @click="confirmDelete(&quot;http://localhost/laravel/akaunting/1/sales/invoices/127&quot;, &quot;Invoices&quot;, &quot;Confirm delete &lt;strong&gt;INV-86675&lt;/strong&gt; invoice?&quot;, &quot;Cancel&quot;, &quot;Delete&quot;)">Delete</button>

                                </div>
                            </div>
                        </td>
                    </tr>

                    <tr class="row align-items-center border-top-1">
                        <td class="col-sm-2 col-md-1 col-lg-1 col-xl-1 d-none d-sm-block">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="bulk-action-195"
                                    data-bulk-action="195" :value="195" v-model="bulk_action.selected"
                                    v-on:change="onSelect">
                                <label class="custom-control-label" for="bulk-action-195"></label>
                            </div>


                        </td>

                        <td class="col-md-2 col-lg-1 col-xl-1 d-none d-md-block">

                            <a class="col-aka"
                                href="http://localhost/laravel/akaunting/1/sales/invoices/195">INV-86251</a>

                        </td>

                        <td class="col-xs-4 col-sm-4 col-md-4 col-lg-2 col-xl-2 text-left">

                            Craig Khan

                        </td>

                        <td class="col-xs-4 col-sm-4 col-md-3 col-lg-2 col-xl-2 text-right">

                            $236.20
                        </td>

                        <td class="col-lg-2 col-xl-2 d-none d-lg-block text-left">

                            15 Feb 2021
                        </td>

                        <td class="col-lg-2 col-xl-2 d-none d-lg-block text-left">

                            21 Nov 2021
                        </td>

                        <td class="col-lg-1 col-xl-1 d-none d-lg-block text-center">

                            <span class="badge badge-pill badge-info">Partial</span>

                        </td>

                        <td class="col-xs-4 col-sm-2 col-md-2 col-lg-1 col-xl-1 text-center">
                            <div class="dropdown">
                                <a class="btn btn-neutral btn-sm text-light items-align-center py-2" href="#"
                                    role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-ellipsis-h text-muted"></i>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/sales/invoices/195">Show</a>

                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/sales/invoices/195/edit">Edit</a>

                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/sales/invoices/195/duplicate">Duplicate</a>

                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/sales/invoices/195/cancelled">Cancel</a>

                                    <button type="button" class="dropdown-item action-delete" title="Delete"
                                        @click="confirmDelete(&quot;http://localhost/laravel/akaunting/1/sales/invoices/195&quot;, &quot;Invoices&quot;, &quot;Confirm delete &lt;strong&gt;INV-86251&lt;/strong&gt; invoice?&quot;, &quot;Cancel&quot;, &quot;Delete&quot;)">Delete</button>

                                </div>
                            </div>
                        </td>
                    </tr>

                    <tr class="row align-items-center border-top-1">
                        <td class="col-sm-2 col-md-1 col-lg-1 col-xl-1 d-none d-sm-block">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="bulk-action-138"
                                    data-bulk-action="138" :value="138" v-model="bulk_action.selected"
                                    v-on:change="onSelect">
                                <label class="custom-control-label" for="bulk-action-138"></label>
                            </div>


                        </td>

                        <td class="col-md-2 col-lg-1 col-xl-1 d-none d-md-block">

                            <a class="col-aka"
                                href="http://localhost/laravel/akaunting/1/sales/invoices/138">INV-85757</a>

                        </td>

                        <td class="col-xs-4 col-sm-4 col-md-4 col-lg-2 col-xl-2 text-left">

                            Barry Richardson

                        </td>

                        <td class="col-xs-4 col-sm-4 col-md-3 col-lg-2 col-xl-2 text-right">

                            $997.23
                        </td>

                        <td class="col-lg-2 col-xl-2 d-none d-lg-block text-left">

                            24 Nov 2021
                        </td>

                        <td class="col-lg-2 col-xl-2 d-none d-lg-block text-left">

                            16 Jun 2023
                        </td>

                        <td class="col-lg-1 col-xl-1 d-none d-lg-block text-center">

                            <span class="badge badge-pill badge-primary">Draft</span>

                        </td>

                        <td class="col-xs-4 col-sm-2 col-md-2 col-lg-1 col-xl-1 text-center">
                            <div class="dropdown">
                                <a class="btn btn-neutral btn-sm text-light items-align-center py-2" href="#"
                                    role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-ellipsis-h text-muted"></i>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/sales/invoices/138">Show</a>

                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/sales/invoices/138/edit">Edit</a>

                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/sales/invoices/138/duplicate">Duplicate</a>

                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/sales/invoices/138/cancelled">Cancel</a>

                                    <button type="button" class="dropdown-item action-delete" title="Delete"
                                        @click="confirmDelete(&quot;http://localhost/laravel/akaunting/1/sales/invoices/138&quot;, &quot;Invoices&quot;, &quot;Confirm delete &lt;strong&gt;INV-85757&lt;/strong&gt; invoice?&quot;, &quot;Cancel&quot;, &quot;Delete&quot;)">Delete</button>

                                </div>
                            </div>
                        </td>
                    </tr>

                    <tr class="row align-items-center border-top-1">
                        <td class="col-sm-2 col-md-1 col-lg-1 col-xl-1 d-none d-sm-block">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="bulk-action-134"
                                    data-bulk-action="134" :value="134" v-model="bulk_action.selected"
                                    v-on:change="onSelect">
                                <label class="custom-control-label" for="bulk-action-134"></label>
                            </div>


                        </td>

                        <td class="col-md-2 col-lg-1 col-xl-1 d-none d-md-block">

                            <a class="col-aka"
                                href="http://localhost/laravel/akaunting/1/sales/invoices/134">INV-85074</a>

                        </td>

                        <td class="col-xs-4 col-sm-4 col-md-4 col-lg-2 col-xl-2 text-left">

                            Lilly Saunders

                        </td>

                        <td class="col-xs-4 col-sm-4 col-md-3 col-lg-2 col-xl-2 text-right">

                            $744.18
                        </td>

                        <td class="col-lg-2 col-xl-2 d-none d-lg-block text-left">

                            06 Feb 2021
                        </td>

                        <td class="col-lg-2 col-xl-2 d-none d-lg-block text-left">

                            01 Sep 2022
                        </td>

                        <td class="col-lg-1 col-xl-1 d-none d-lg-block text-center">

                            <span class="badge badge-pill badge-primary">Draft</span>

                        </td>

                        <td class="col-xs-4 col-sm-2 col-md-2 col-lg-1 col-xl-1 text-center">
                            <div class="dropdown">
                                <a class="btn btn-neutral btn-sm text-light items-align-center py-2" href="#"
                                    role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-ellipsis-h text-muted"></i>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/sales/invoices/134">Show</a>

                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/sales/invoices/134/edit">Edit</a>

                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/sales/invoices/134/duplicate">Duplicate</a>

                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/sales/invoices/134/cancelled">Cancel</a>

                                    <button type="button" class="dropdown-item action-delete" title="Delete"
                                        @click="confirmDelete(&quot;http://localhost/laravel/akaunting/1/sales/invoices/134&quot;, &quot;Invoices&quot;, &quot;Confirm delete &lt;strong&gt;INV-85074&lt;/strong&gt; invoice?&quot;, &quot;Cancel&quot;, &quot;Delete&quot;)">Delete</button>

                                </div>
                            </div>
                        </td>
                    </tr>

                    <tr class="row align-items-center border-top-1">
                        <td class="col-sm-2 col-md-1 col-lg-1 col-xl-1 d-none d-sm-block">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="bulk-action-110"
                                    data-bulk-action="110" :value="110" v-model="bulk_action.selected"
                                    v-on:change="onSelect">
                                <label class="custom-control-label" for="bulk-action-110"></label>
                            </div>


                        </td>

                        <td class="col-md-2 col-lg-1 col-xl-1 d-none d-md-block">

                            <a class="col-aka"
                                href="http://localhost/laravel/akaunting/1/sales/invoices/110">INV-84049</a>

                        </td>

                        <td class="col-xs-4 col-sm-4 col-md-4 col-lg-2 col-xl-2 text-left">

                            Ryan Smith

                        </td>

                        <td class="col-xs-4 col-sm-4 col-md-3 col-lg-2 col-xl-2 text-right">

                            $660.61
                        </td>

                        <td class="col-lg-2 col-xl-2 d-none d-lg-block text-left">

                            19 Feb 2021
                        </td>

                        <td class="col-lg-2 col-xl-2 d-none d-lg-block text-left">

                            14 Oct 2021
                        </td>

                        <td class="col-lg-1 col-xl-1 d-none d-lg-block text-center">

                            <span class="badge badge-pill badge-info">Partial</span>

                        </td>

                        <td class="col-xs-4 col-sm-2 col-md-2 col-lg-1 col-xl-1 text-center">
                            <div class="dropdown">
                                <a class="btn btn-neutral btn-sm text-light items-align-center py-2" href="#"
                                    role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-ellipsis-h text-muted"></i>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/sales/invoices/110">Show</a>

                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/sales/invoices/110/edit">Edit</a>

                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/sales/invoices/110/duplicate">Duplicate</a>

                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/sales/invoices/110/cancelled">Cancel</a>

                                    <button type="button" class="dropdown-item action-delete" title="Delete"
                                        @click="confirmDelete(&quot;http://localhost/laravel/akaunting/1/sales/invoices/110&quot;, &quot;Invoices&quot;, &quot;Confirm delete &lt;strong&gt;INV-84049&lt;/strong&gt; invoice?&quot;, &quot;Cancel&quot;, &quot;Delete&quot;)">Delete</button>

                                </div>
                            </div>
                        </td>
                    </tr>

                    <tr class="row align-items-center border-top-1">
                        <td class="col-sm-2 col-md-1 col-lg-1 col-xl-1 d-none d-sm-block">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="bulk-action-188"
                                    data-bulk-action="188" :value="188" v-model="bulk_action.selected"
                                    v-on:change="onSelect">
                                <label class="custom-control-label" for="bulk-action-188"></label>
                            </div>


                        </td>

                        <td class="col-md-2 col-lg-1 col-xl-1 d-none d-md-block">

                            <a class="col-aka"
                                href="http://localhost/laravel/akaunting/1/sales/invoices/188">INV-82959</a>

                        </td>

                        <td class="col-xs-4 col-sm-4 col-md-4 col-lg-2 col-xl-2 text-left">

                            Pete Allen

                        </td>

                        <td class="col-xs-4 col-sm-4 col-md-3 col-lg-2 col-xl-2 text-right">

                            $682.29
                        </td>

                        <td class="col-lg-2 col-xl-2 d-none d-lg-block text-left">

                            10 Jul 2021
                        </td>

                        <td class="col-lg-2 col-xl-2 d-none d-lg-block text-left">

                            31 Jul 2022
                        </td>

                        <td class="col-lg-1 col-xl-1 d-none d-lg-block text-center">

                            <span class="badge badge-pill badge-warning">Viewed</span>

                        </td>

                        <td class="col-xs-4 col-sm-2 col-md-2 col-lg-1 col-xl-1 text-center">
                            <div class="dropdown">
                                <a class="btn btn-neutral btn-sm text-light items-align-center py-2" href="#"
                                    role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-ellipsis-h text-muted"></i>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/sales/invoices/188">Show</a>

                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/sales/invoices/188/edit">Edit</a>

                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/sales/invoices/188/duplicate">Duplicate</a>

                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item"
                                        href="http://localhost/laravel/akaunting/1/sales/invoices/188/cancelled">Cancel</a>

                                    <button type="button" class="dropdown-item action-delete" title="Delete"
                                        @click="confirmDelete(&quot;http://localhost/laravel/akaunting/1/sales/invoices/188&quot;, &quot;Invoices&quot;, &quot;Confirm delete &lt;strong&gt;INV-82959&lt;/strong&gt; invoice?&quot;, &quot;Cancel&quot;, &quot;Delete&quot;)">Delete</button>

                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="card-footer table-action">
            <div class="row">
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
                                    href="http://localhost/laravel/akaunting/1/sales/invoices?sort=document_number&amp;direction=desc&amp;page=2">2</a>
                            </li>
                            <li class="page-item"><a class="page-link"
                                    href="http://localhost/laravel/akaunting/1/sales/invoices?sort=document_number&amp;direction=desc&amp;page=3">3</a>
                            </li>
                            <li class="page-item d-none d-sm-block"><a class="page-link"
                                    href="http://localhost/laravel/akaunting/1/sales/invoices?sort=document_number&amp;direction=desc&amp;page=4">4</a>
                            </li>


                            <li class="page-item"><a class="page-link"
                                    href="http://localhost/laravel/akaunting/1/sales/invoices?sort=document_number&amp;direction=desc&amp;page=2"
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
