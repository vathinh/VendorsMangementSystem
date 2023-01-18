@extends('layouts.dashboard')
@section('title','New Invoice')
@section('content')

<div id="app">

    <form method="POST" action="" id="document">

        <div class="card">
            {{-- <div class="document-loading" v-if="!page_loaded">
                    <div><i class="fas fa-spinner fa-pulse fa-7x"></i></div>
                </div> --}}

            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                        <div class="row">
                            {{-- Add Customer  --}}
                            <akaunting-contact-card placeholder="Type a Customer name" no-data-text="No data"
                                no-matching-data-text="No matching data" search-route="" create-route=""
                                :contacts="[{&quot;id&quot;:75,&quot;company_id&quot;:1,&quot;type&quot;:&quot;customer&quot;,&quot;name&quot;:&quot;Alan Ward&quot;,&quot;email&quot;:&quot;peter84@example.org&quot;,&quot;user_id&quot;:null,&quot;tax_number&quot;:&quot;952089376&quot;,&quot;phone&quot;:&quot;+44(0)0354922665&quot;,&quot;address&quot;:&quot;Studio 78u\nElizabeth Forks\nCaitlinchester\nG77 6DL&quot;,&quot;website&quot;:&quot;https:\/\/akaunting.com&quot;,&quot;currency_code&quot;:&quot;USD&quot;,&quot;enabled&quot;:true,&quot;reference&quot;:&quot;Quia.&quot;,&quot;created_by&quot;:null,&quot;created_at&quot;:&quot;2021-06-18T07:43:47.000000Z&quot;,&quot;updated_at&quot;:&quot;2021-06-18T07:43:47.000000Z&quot;,&quot;deleted_at&quot;:null}]">
                            </akaunting-contact-card>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                        <div class="row">
                            {{-- Invoice Date  --}}
                            <akaunting-date class="col-md-6 required" icon="fa fa-calendar" title="Invoice Date"
                                name="issued_at" value="2021-06-26"
                                :date-config="{wrap: true, allowInput: true, altInput: true, altFormat: 'd/m/Y', dateFormat: 'Y-m-d', }">
                            </akaunting-date>

                            {{-- Invoice Number  --}}
                            <div class="form-group col-md-6 required">
                                <label for="document_number" class="form-control-label">Invoice Number</label>
                                <div class="input-group input-group-merge ">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fa fa-file"></i>
                                        </span>
                                    </div>
                                    <input class="form-control" name="document_number" id="document_number"
                                        value="INV-00101" readonly>
                                </div>
                            </div>

                            {{-- Due Date  --}}
                            <akaunting-date class="col-md-6 required" icon="fa fa-calendar" title="Due Date"
                                name="due_at" value="2021-06-26"
                                :date-config="{wrap: true, allowInput: true, altInput: true, altFormat: 'd M Y', dateFormat: 'Y-m-d',}">
                            </akaunting-date>

                            {{-- Order Number  --}}
                            <div class="form-group col-md-6">
                                <label for="order_number" class="form-control-label">Order Number</label>
                                <div class="input-group input-group-merge ">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fa fa-shopping-cart"></i>
                                        </span>
                                    </div>
                                    <input class="form-control" placeholder="Enter Order Number" name="order_number"
                                        type="text" id="order_number">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row document-item-body">
                    <div class="col-sm-12 p-0" style="table-layout: fixed;">
                        {{-- Talbe  --}}
                        <div class="table-responsive overflow-x-scroll overflow-y-hidden">
                            <table class="table" id="items" style="table-layout: fixed">
                                <colgroup>
                                    <col class="document-item-40-px">
                                    <col class="document-item-25">
                                    <col class="document-item-30 description">
                                    <col class="document-item-10">
                                    <col class="document-item-10">
                                    <col class="document-item-20">
                                    <col class="document-item-40-px">
                                </colgroup>
                                {{-- Table Header  --}}
                                <thead class="thead-light">
                                    <tr>
                                        <th class="border-top-0 border-right-0 border-bottom-0" style="max-width: 40px">
                                            <div></div>
                                        </th>

                                        <th class="text-center border-top-0 border-right-0 border-bottom-0">
                                            Items Name
                                        </th>

                                        <th class="text-center border-top-0 border-right-0 border-bottom-0">Description
                                        </th>

                                        <th class="text-center pl-2 border-top-0 border-right-0 border-bottom-0">
                                            Quantity
                                        </th>

                                        <th class="text-right border-top-0 border-right-0 border-bottom-0 pr-1"
                                            style="padding-left: 5px;">
                                            Price
                                        </th>

                                        <th class="text-right border-top-0 border-bottom-0 item-total">
                                            Amount
                                        </th>

                                        <th class="border-top-0 border-right-0 border-bottom-0" style="max-width: 40px">
                                            <div></div>
                                        </th>
                                    </tr>
                                </thead>
                                {{-- Table Body  --}}

                                <tbody id="invoice-item-rows" class="table-padding-05">
                                    <tr v-for="(row, index) in items" :index="index">
                                        <td class="border-right-0 border-bottom-0 p-0"
                                            :class="[{'has-error': form.errors.has('items.' + index + '.name') }]"
                                            colspan="7">
                                            <table class="w-100">
                                                <colgroup>
                                                    <col class="document-item-40-px">
                                                    <col class="document-item-25">
                                                    <col class="document-item-30 description">
                                                    <col class="document-item-10">
                                                    <col class="document-item-10">
                                                    <col class="document-item-20">
                                                    <col class="document-item-40-px">
                                                </colgroup>
                                                <tbody>
                                                    <tr>
                                                        <td class="pl-3 pb-3 align-middle border-bottom-0 move"
                                                            style="max-width: 40px;" style="color: #8898aa;">
                                                            <div>
                                                                <i class="fas fa-grip-vertical"></i>
                                                            </div>
                                                        </td>

                                                        <td class="pb-3 align-middle border-bottom-0 name">
                                                            <span class="aka-text aka-text--body" tabindex="0"
                                                                v-html="row.name" v-if="row.item_id"></span>
                                                            <div v-else>
                                                                <input type="text" class="form-control"
                                                                    :name="'items.' + index + '.name'"
                                                                    autocomplete="off" required="required"
                                                                    data-item="name" v-model="row.name"
                                                                    @input="onBindingItemField(index, 'name')"
                                                                    @change="form.errors.clear('items.' + index + '.name')">

                                                                <div class="invalid-feedback d-block"
                                                                    v-if="form.errors.has('items.' + index + '.name')"
                                                                    v-html="form.errors.get('items.' + index + '.name')">
                                                                </div>
                                                            </div>
                                                        </td>

                                                        <td class="pb-3 border-bottom-0 description">
                                                            <textarea class="form-control"
                                                                placeholder="Enter item description"
                                                                style="height: 46px; overflow: hidden;"
                                                                :name="'items.' + index + '.description'"
                                                                v-model="row.description" data-item="description"
                                                                resize="none"
                                                                @input="onBindingItemField(index, 'description')"></textarea>
                                                        </td>

                                                        <td class="pb-3 pl-0 pr-2 border-bottom-0 quantity">
                                                            <div>
                                                                <input type="text" class="form-control text-center p-0"
                                                                    :name="'items.' + index + '.quantity'"
                                                                    autocomplete="off" required="required"
                                                                    data-item="quantity" v-model="row.quantity"
                                                                    @input="onCalculateTotal"
                                                                    @change="form.errors.clear('items.' + index + '.quantity')">

                                                                <div class="invalid-feedback d-block"
                                                                    v-if="form.errors.has('items.' + index + '.quantity')"
                                                                    v-html="form.errors.get('items.' + index + '.quantity')">
                                                                </div>
                                                            </div>
                                                        </td>

                                                        <td class="pb-3 pl-0 pr-0 border-bottom-0 price"
                                                            style="padding-right: 5px; padding-left: 5px;">
                                                            <div>
                                                                <akaunting-money :col="'text-right input-price p-0'"
                                                                    :form-classes="[{'has-error': form.errors.get(&#039;items.&#039; + index + &#039;.price&#039;) }]"
                                                                    :required="true"
                                                                    :error="form.errors.get(&#039;items.&#039; + index + &#039;.price&#039;)"
                                                                    name="price" title="" :group_class="''" icon=""
                                                                    :currency="{&quot;id&quot;:1,&quot;company_id&quot;:1,&quot;name&quot;:&quot;US Dollar&quot;,&quot;code&quot;:&quot;USD&quot;,&quot;rate&quot;:1,&quot;precision&quot;:2,&quot;symbol&quot;:&quot;$&quot;,&quot;symbol_first&quot;:1,&quot;decimal_mark&quot;:&quot;.&quot;,&quot;thousands_separator&quot;:&quot;,&quot;,&quot;enabled&quot;:true,&quot;created_by&quot;:null,&quot;created_at&quot;:&quot;2021-06-18T07:43:40.000000Z&quot;,&quot;updated_at&quot;:&quot;2021-06-18T07:43:40.000000Z&quot;,&quot;deleted_at&quot;:null}"
                                                                    :value="0" :dynamic-currency="currency"
                                                                    v-model="row.price"
                                                                    @change="row.price = $event; form.errors.clear(&#039;items.&#039; + index + &#039;.price&#039;); onCalculateTotal($event)"
                                                                    @interface="form.errors.clear('row.price'); row.price = $event"
                                                                    :form-error="form.errors.get(&#039;items.&#039; + index + &#039;.price&#039;)"
                                                                    :row-input="true"></akaunting-money>


                                                            </div>
                                                        </td>

                                                        <td class="text-right long-texts pb-3 border-bottom-0 total">
                                                            <div>
                                                                <akaunting-money
                                                                    :col="'text-right input-price disabled-money'"
                                                                    :form-classes="[{'has-error': form.errors.has('total') }]"
                                                                    :required="true" :disabled="true"
                                                                    :error="form.errors.get(&quot;total&quot;)"
                                                                    name="total" title="" :group_class="''" icon=""
                                                                    :currency="{&quot;id&quot;:1,&quot;company_id&quot;:1,&quot;name&quot;:&quot;US Dollar&quot;,&quot;code&quot;:&quot;USD&quot;,&quot;rate&quot;:1,&quot;precision&quot;:2,&quot;symbol&quot;:&quot;$&quot;,&quot;symbol_first&quot;:1,&quot;decimal_mark&quot;:&quot;.&quot;,&quot;thousands_separator&quot;:&quot;,&quot;,&quot;enabled&quot;:true,&quot;created_by&quot;:null,&quot;created_at&quot;:&quot;2021-06-18T07:43:40.000000Z&quot;,&quot;updated_at&quot;:&quot;2021-06-18T07:43:40.000000Z&quot;,&quot;deleted_at&quot;:null}"
                                                                    :value="0" :dynamic-currency="currency"
                                                                    v-model="row.total"
                                                                    @interface="form.errors.clear('row.total'); row.total = $event"
                                                                    :form-error="form.errors.get('total')"
                                                                    :row-input="true"></akaunting-money>


                                                            </div>
                                                        </td>

                                                        <td class="pb-3 pl-2 align-middle border-bottom-0 delete"
                                                            style="max-width: 40px;">
                                                            <div>
                                                                <button type="button" @click="onDeleteItem(index)"
                                                                    class="btn btn-link btn-delete p-0">
                                                                    <i class="far fa-trash-alt"></i>
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="border-top-0" colspan="3">
                                                        </td>
                                                        <td class="border-top-0 p-0" colspan="4">
                                                            {{-- Tax Row  --}}
                                                            <div class="line-item-area pb-3"
                                                                v-for="(row_tax, row_tax_index) in row.tax_ids"
                                                                :index="row_tax_index">
                                                                <div class="line-item-content">
                                                                    <div class="long-texts line-item-text"
                                                                        style="float: left; margin-top: 15px; margin-right:2px; position: absolute; left: -63px;">
                                                                        Taxi
                                                                    </div>

                                                                    <akaunting-select class="mb-0 select-tax"
                                                                        :form-classes="[{'has-error': form.errors.has('items.' + index + '.taxes') }]"
                                                                        :icon="''" :title="''"
                                                                        :placeholder="'- Select Tax -'"
                                                                        :name="'items.' + index + '.taxes.' + row_tax_index"
                                                                        :options="{&quot;1&quot;:&quot;Distinctio. (18.32%)&quot;,&quot;10&quot;:&quot;Est corporis. (10.95)&quot;,&quot;7&quot;:&quot;Est fugiat sit. (19%)&quot;,&quot;6&quot;:&quot;Ex voluptas. (15.04%)&quot;,&quot;4&quot;:&quot;Quas quia aut. (11.71)&quot;,&quot;8&quot;:&quot;Quia dolor. (17.08)&quot;,&quot;2&quot;:&quot;Rerum debitis. (15.55)&quot;,&quot;5&quot;:&quot;Sunt sed. (13.21)&quot;,&quot;3&quot;:&quot;Ut voluptates. (12.52%)&quot;,&quot;9&quot;:&quot;Vitae natus. (13.6%)&quot;}"
                                                                        :disabled-options="form.items[index].tax_ids"
                                                                        :value="row_tax.id"
                                                                        @interface="row_tax.id = $event"
                                                                        @change="onCalculateTotal()"
                                                                        @new="taxes.push($event)"
                                                                        :form-error="form.errors.get('items.' + index + '.taxes')"
                                                                        :no-data-text="'No data'"
                                                                        :no-matching-data-text="'No matching data'">
                                                                    </akaunting-select>
                                                                </div>

                                                                <div class="line-item-content-right">
                                                                    <div
                                                                        class="line-item-content-right-price long-texts text-right">
                                                                        <akaunting-money
                                                                            :col="'text-right input-price disabled-money'"
                                                                            :form-classes="[{'has-error': form.errors.has('tax') }]"
                                                                            :required="true" :disabled="true"
                                                                            :error="form.errors.get(&quot;tax&quot;)"
                                                                            name="tax" title="" :group_class="''"
                                                                            icon=""
                                                                            :currency="{&quot;id&quot;:1,&quot;company_id&quot;:1,&quot;name&quot;:&quot;US Dollar&quot;,&quot;code&quot;:&quot;USD&quot;,&quot;rate&quot;:1,&quot;precision&quot;:2,&quot;symbol&quot;:&quot;$&quot;,&quot;symbol_first&quot;:1,&quot;decimal_mark&quot;:&quot;.&quot;,&quot;thousands_separator&quot;:&quot;,&quot;,&quot;enabled&quot;:true,&quot;created_by&quot;:null,&quot;created_at&quot;:&quot;2021-06-18T07:43:40.000000Z&quot;,&quot;updated_at&quot;:&quot;2021-06-18T07:43:40.000000Z&quot;,&quot;deleted_at&quot;:null}"
                                                                            :value="0" :dynamic-currency="currency"
                                                                            v-model="row_tax.price"
                                                                            @interface="form.errors.clear('row_tax.price'); row_tax.price = $event"
                                                                            :form-error="form.errors.get('tax')"
                                                                            :row-input="true"></akaunting-money>


                                                                    </div>
                                                                    <div class="line-item-content-right-delete pl-2">
                                                                        <button type="button"
                                                                            @click="onDeleteTax(index, row_tax_index)"
                                                                            class="btn btn-link btn-delete p-0">
                                                                            <i class="far fa-trash-alt"></i>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div v-if="row.add_tax" class="line-item-area pb-3"
                                                                :class="{'pt-2' : row.add_discount}">
                                                                <div class="line-item-content">
                                                                    <div class="long-texts line-item-text"
                                                                        style="float: left; margin-top: 15px; margin-right:2px; position: absolute; left: -63px;">
                                                                        Tax
                                                                    </div>

                                                                    <akaunting-select class="mb-0 select-tax"
                                                                        style="margin-left: 1px; margin-right: -2px;"
                                                                        :form-classes="[{'has-error': form.errors.has('items.' + index + '.taxes') }]"
                                                                        :icon="''" :title="''"
                                                                        :placeholder="'- Select Tax -'"
                                                                        :name="'items.' + index + '.taxes.999'"
                                                                        :options="{&quot;1&quot;:&quot;Distinctio. (18.32%)&quot;,&quot;10&quot;:&quot;Est corporis. (10.95)&quot;,&quot;7&quot;:&quot;Est fugiat sit. (19%)&quot;,&quot;6&quot;:&quot;Ex voluptas. (15.04%)&quot;,&quot;4&quot;:&quot;Quas quia aut. (11.71)&quot;,&quot;8&quot;:&quot;Quia dolor. (17.08)&quot;,&quot;2&quot;:&quot;Rerum debitis. (15.55)&quot;,&quot;5&quot;:&quot;Sunt sed. (13.21)&quot;,&quot;3&quot;:&quot;Ut voluptates. (12.52%)&quot;,&quot;9&quot;:&quot;Vitae natus. (13.6%)&quot;}"
                                                                        :disabled-options="form.items[index].tax_ids"
                                                                        :value="tax_id"
                                                                        :add-new="{&quot;status&quot;:true,&quot;text&quot;:&quot;Add New&quot;,&quot;path&quot;:&quot;http:\/\/localhost\/laravel\/akaunting\/1\/modals\/taxes\/create&quot;,&quot;type&quot;:&quot;modal&quot;,&quot;field&quot;:{&quot;key&quot;:&quot;id&quot;,&quot;value&quot;:&quot;title&quot;},&quot;new_text&quot;:&quot;New&quot;,&quot;buttons&quot;:{&quot;cancel&quot;:{&quot;text&quot;:&quot;Cancel&quot;,&quot;class&quot;:&quot;btn-outline-secondary&quot;},&quot;confirm&quot;:{&quot;text&quot;:&quot;Save&quot;,&quot;class&quot;:&quot;btn-success&quot;}}}"
                                                                        @interface="tax_id = $event"
                                                                        @visible-change="onSelectedTax(index)"
                                                                        @new="taxes.push($event)"
                                                                        :form-error="form.errors.get('items.' + index + '.taxes')"
                                                                        :no-data-text="'No data'"
                                                                        :no-matching-data-text="'No matching data'">
                                                                    </akaunting-select>
                                                                </div>
                                                                <div class="line-item-content-right">
                                                                    <div
                                                                        class="line-item-content-right-price long-texts text-right">
                                                                        <div>
                                                                            <div
                                                                                class="required disabled text-right input-price disabled-money">
                                                                                <input type="tel"
                                                                                    class="v-money form-control text-right"
                                                                                    name="discount_amount"
                                                                                    disabled="disabled" value="__">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="line-item-content-right-delete pl-2">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>

                                    <tr id="addItem">
                                        <td class="text-right border-bottom-0 p-0" colspan="7">
                                            <akaunting-item-button placeholder="Type an item name"
                                                no-data-text="No data" no-matching-data-text="No matching data"
                                                type="invoice" price="sale_price" :dynamic-currency="currency"
                                                :items="[{&quot;id&quot;:56,&quot;company_id&quot;:1,&quot;name&quot;:&quot;Alias id et.&quot;,&quot;sku&quot;:null,&quot;description&quot;:&quot;Et soluta autem officia eos. Nobis et nulla ea. Suscipit aut ut atque aliquam beatae.&quot;,&quot;sale_price&quot;:14.26,&quot;purchase_price&quot;:17.05,&quot;quantity&quot;:1,&quot;category_id&quot;:40,&quot;tax_id&quot;:null,&quot;enabled&quot;:true,&quot;created_by&quot;:null,&quot;created_at&quot;:&quot;2021-06-18T07:43:48.000000Z&quot;,&quot;updated_at&quot;:&quot;2021-06-18T07:43:48.000000Z&quot;,&quot;deleted_at&quot;:null,&quot;price&quot;:14.26,&quot;item_id&quot;:56,&quot;tax_ids&quot;:[]},{&quot;id&quot;:2,&quot;company_id&quot;:1,&quot;name&quot;:&quot;Aliquam autem.&quot;,&quot;sku&quot;:null,&quot;description&quot;:&quot;Qui iusto sapiente molestias quibusdam quibusdam provident quibusdam. Eaque at sint molestias quis.&quot;,&quot;sale_price&quot;:16.91,&quot;purchase_price&quot;:16.68,&quot;quantity&quot;:1,&quot;category_id&quot;:11,&quot;tax_id&quot;:null,&quot;enabled&quot;:true,&quot;created_by&quot;:null,&quot;created_at&quot;:&quot;2021-06-18T07:43:48.000000Z&quot;,&quot;updated_at&quot;:&quot;2021-06-18T07:43:48.000000Z&quot;,&quot;deleted_at&quot;:null,&quot;price&quot;:16.91,&quot;item_id&quot;:2,&quot;tax_ids&quot;:[]},{&quot;id&quot;:43,&quot;company_id&quot;:1,&quot;name&quot;:&quot;Aliquid.&quot;,&quot;sku&quot;:null,&quot;description&quot;:&quot;Iusto qui voluptatum eos sequi consequatur minus cupiditate. Quas occaecati et est ea ipsa.&quot;,&quot;sale_price&quot;:14.07,&quot;purchase_price&quot;:15.66,&quot;quantity&quot;:1,&quot;category_id&quot;:54,&quot;tax_id&quot;:null,&quot;enabled&quot;:true,&quot;created_by&quot;:null,&quot;created_at&quot;:&quot;2021-06-18T07:43:48.000000Z&quot;,&quot;updated_at&quot;:&quot;2021-06-18T07:43:48.000000Z&quot;,&quot;deleted_at&quot;:null,&quot;price&quot;:14.07,&quot;item_id&quot;:43,&quot;tax_ids&quot;:[]},{&quot;id&quot;:76,&quot;company_id&quot;:1,&quot;name&quot;:&quot;Aliquid.&quot;,&quot;sku&quot;:null,&quot;description&quot;:&quot;Quis excepturi culpa consequuntur illo dolorem odio aspernatur. Voluptate quo nulla eius error et.&quot;,&quot;sale_price&quot;:19.12,&quot;purchase_price&quot;:10.8,&quot;quantity&quot;:1,&quot;category_id&quot;:54,&quot;tax_id&quot;:null,&quot;enabled&quot;:true,&quot;created_by&quot;:null,&quot;created_at&quot;:&quot;2021-06-18T07:43:48.000000Z&quot;,&quot;updated_at&quot;:&quot;2021-06-18T07:43:48.000000Z&quot;,&quot;deleted_at&quot;:null,&quot;price&quot;:19.12,&quot;item_id&quot;:76,&quot;tax_ids&quot;:[]},{&quot;id&quot;:31,&quot;company_id&quot;:1,&quot;name&quot;:&quot;Architecto.&quot;,&quot;sku&quot;:null,&quot;description&quot;:&quot;Repellat deleniti maiores voluptatem sapiente blanditiis. Voluptas quis adipisci harum vel.&quot;,&quot;sale_price&quot;:11.98,&quot;purchase_price&quot;:16.11,&quot;quantity&quot;:1,&quot;category_id&quot;:66,&quot;tax_id&quot;:null,&quot;enabled&quot;:true,&quot;created_by&quot;:null,&quot;created_at&quot;:&quot;2021-06-18T07:43:48.000000Z&quot;,&quot;updated_at&quot;:&quot;2021-06-18T07:43:48.000000Z&quot;,&quot;deleted_at&quot;:null,&quot;price&quot;:11.98,&quot;item_id&quot;:31,&quot;tax_ids&quot;:[]},{&quot;id&quot;:41,&quot;company_id&quot;:1,&quot;name&quot;:&quot;Architecto.&quot;,&quot;sku&quot;:null,&quot;description&quot;:&quot;Doloribus temporibus sint perferendis eos qui molestias. Est omnis optio voluptas sit officia unde.&quot;,&quot;sale_price&quot;:15.84,&quot;purchase_price&quot;:17.17,&quot;quantity&quot;:1,&quot;category_id&quot;:27,&quot;tax_id&quot;:null,&quot;enabled&quot;:true,&quot;created_by&quot;:null,&quot;created_at&quot;:&quot;2021-06-18T07:43:48.000000Z&quot;,&quot;updated_at&quot;:&quot;2021-06-18T07:43:48.000000Z&quot;,&quot;deleted_at&quot;:null,&quot;price&quot;:15.84,&quot;item_id&quot;:41,&quot;tax_ids&quot;:[]},{&quot;id&quot;:34,&quot;company_id&quot;:1,&quot;name&quot;:&quot;Aut deserunt.&quot;,&quot;sku&quot;:null,&quot;description&quot;:&quot;At odio ea voluptatem eaque. Eum voluptas sed qui et. Et ut deleniti non accusamus occaecati.&quot;,&quot;sale_price&quot;:13.29,&quot;purchase_price&quot;:14.81,&quot;quantity&quot;:1,&quot;category_id&quot;:52,&quot;tax_id&quot;:null,&quot;enabled&quot;:true,&quot;created_by&quot;:null,&quot;created_at&quot;:&quot;2021-06-18T07:43:48.000000Z&quot;,&quot;updated_at&quot;:&quot;2021-06-18T07:43:48.000000Z&quot;,&quot;deleted_at&quot;:null,&quot;price&quot;:13.29,&quot;item_id&quot;:34,&quot;tax_ids&quot;:[]},{&quot;id&quot;:70,&quot;company_id&quot;:1,&quot;name&quot;:&quot;Aut laboriosam.&quot;,&quot;sku&quot;:null,&quot;description&quot;:&quot;Quo et quia consequatur. Totam eum incidunt adipisci eum. Asperiores ex fugiat iste architecto est.&quot;,&quot;sale_price&quot;:10.08,&quot;purchase_price&quot;:17.24,&quot;quantity&quot;:1,&quot;category_id&quot;:9,&quot;tax_id&quot;:null,&quot;enabled&quot;:true,&quot;created_by&quot;:null,&quot;created_at&quot;:&quot;2021-06-18T07:43:48.000000Z&quot;,&quot;updated_at&quot;:&quot;2021-06-18T07:43:48.000000Z&quot;,&quot;deleted_at&quot;:null,&quot;price&quot;:10.08,&quot;item_id&quot;:70,&quot;tax_ids&quot;:[]},{&quot;id&quot;:28,&quot;company_id&quot;:1,&quot;name&quot;:&quot;Aut neque.&quot;,&quot;sku&quot;:null,&quot;description&quot;:&quot;Voluptas quisquam cumque tenetur alias quia. Aliquam nobis animi aut.&quot;,&quot;sale_price&quot;:11.44,&quot;purchase_price&quot;:19.17,&quot;quantity&quot;:1,&quot;category_id&quot;:49,&quot;tax_id&quot;:null,&quot;enabled&quot;:true,&quot;created_by&quot;:null,&quot;created_at&quot;:&quot;2021-06-18T07:43:48.000000Z&quot;,&quot;updated_at&quot;:&quot;2021-06-18T07:43:48.000000Z&quot;,&quot;deleted_at&quot;:null,&quot;price&quot;:11.44,&quot;item_id&quot;:28,&quot;tax_ids&quot;:[]},{&quot;id&quot;:78,&quot;company_id&quot;:1,&quot;name&quot;:&quot;Beatae tenetur.&quot;,&quot;sku&quot;:null,&quot;description&quot;:&quot;Qui ut eum quos ut quia velit assumenda. Vero perspiciatis dignissimos ea ipsum eaque molestiae.&quot;,&quot;sale_price&quot;:10.19,&quot;purchase_price&quot;:11.74,&quot;quantity&quot;:1,&quot;category_id&quot;:49,&quot;tax_id&quot;:null,&quot;enabled&quot;:true,&quot;created_by&quot;:null,&quot;created_at&quot;:&quot;2021-06-18T07:43:48.000000Z&quot;,&quot;updated_at&quot;:&quot;2021-06-18T07:43:48.000000Z&quot;,&quot;deleted_at&quot;:null,&quot;price&quot;:10.19,&quot;item_id&quot;:78,&quot;tax_ids&quot;:[]}]"
                                                @item="onSelectedItem($event)" add-item-text="Add an Item"
                                                create-new-item-text="Create Item"></akaunting-item-button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {{-- End Add Item  --}}

                <div class="row document-item-body">
                    <div class="col-sm-12 mb-4 p-0">
                        <div class="table-responsive overflow-x-scroll overflow-y-hidden">
                            <table class="table" id="totals">
                                <colgroup>
                                    <col class="document-total-50">
                                    <col class="document-total-30">
                                    <col class="document-total-25">
                                    <col class="document-total-50-px">
                                </colgroup>
                                {{-- Subtotal  --}}
                                <tbody id="invoice-total-rows" class="table-padding-05">
                                    <tr id="tr-subtotal">
                                        <td class="border-bottom-0 pb-0"></td>
                                        <td class="text-right border-right-0 border-bottom-0 align-middle pb-0 pr-0">
                                            <strong>Subtotal</strong>
                                        </td>
                                        <td class="text-right border-bottom-0 long-texts pb-0 pr-3">
                                            <div>
                                                <akaunting-money :col="'text-right disabled-money'"
                                                    :form-classes="[{'has-error': form.errors.has('sub_total') }]"
                                                    money-class="text-right disabled-money" :disabled="true"
                                                    :error="form.errors.get(&quot;sub_total&quot;)" name="sub_total"
                                                    title="" :group_class="''" icon=""
                                                    :currency="{&quot;id&quot;:1,&quot;company_id&quot;:1,&quot;name&quot;:&quot;US Dollar&quot;,&quot;code&quot;:&quot;USD&quot;,&quot;rate&quot;:1,&quot;precision&quot;:2,&quot;symbol&quot;:&quot;$&quot;,&quot;symbol_first&quot;:1,&quot;decimal_mark&quot;:&quot;.&quot;,&quot;thousands_separator&quot;:&quot;,&quot;,&quot;enabled&quot;:true,&quot;created_by&quot;:null,&quot;created_at&quot;:&quot;2021-06-18T07:43:40.000000Z&quot;,&quot;updated_at&quot;:&quot;2021-06-18T07:43:40.000000Z&quot;,&quot;deleted_at&quot;:null}"
                                                    :value="0" :dynamic-currency="currency" v-model="totals.sub"
                                                    @interface="form.errors.clear('totals.sub'); totals.sub = $event"
                                                    :form-error="form.errors.get('sub_total')" :row-input="true">
                                                </akaunting-money>
                                            </div>
                                        </td>
                                        <td class="border-bottom-0 pb-0" style="max-width: 50px"></td>
                                    </tr>

                                    {{-- Discount  --}}
                                    <tr id="tr-discount">
                                        <td class="border-top-0 pt-0 pb-0"></td>
                                        <td
                                            class="text-right border-top-0 border-right-0 border-bottom-0 align-middle pt-0 pb-0 pr-0">
                                            <el-popover popper-class="p-0 h-0" placement="bottom" width="300"
                                                v-model="discount">
                                                <div class="card d-none" :class="[{'show' : discount}]">
                                                    <div class="discount card-body">
                                                        <div class="row align-items-center">
                                                            <div class="col-sm-6">
                                                                <div class="input-group input-group-merge">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text"
                                                                            id="input-discount">
                                                                            <i class="fa fa-percent"></i>
                                                                        </span>
                                                                    </div>
                                                                    <input id="pre-discount" class="form-control"
                                                                        v-model="form.discount" name="pre_discount"
                                                                        type="number">
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="discount-description">
                                                                    <strong>of subtotal</strong>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="discount card-footer">
                                                        <div class="row float-right">
                                                            <div class="col-xs-12 col-sm-12">
                                                                <a href="javascript:void(0)" @click="discount = false"
                                                                    class="btn btn-outline-secondary"
                                                                    @click="closePayment">
                                                                    Cancel
                                                                </a>
                                                                <button type="button" id="save-discount"
                                                                    @click="onAddTotalDiscount"
                                                                    class="btn btn-success">Save</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <el-link class="cursor-pointer text-info" slot="reference"
                                                    type="primary" v-if="!totals.discount_text">Add Discount</el-link>
                                                <el-link slot="reference" type="primary" v-if="totals.discount_text"
                                                    v-html="totals.discount_text"></el-link>
                                            </el-popover>
                                        </td>
                                        <td class="text-right border-top-0  border-bottom-0 pt-0 pb-0 pr-3">
                                            <div>
                                                <akaunting-money :col="'text-right disabled-money'"
                                                    :form-classes="[{'has-error': form.errors.has('discount_total') }]"
                                                    money-class="text-right disabled-money" :disabled="true"
                                                    :error="form.errors.get(&quot;discount_total&quot;)"
                                                    name="discount_total" title="" :group_class="''" icon=""
                                                    :currency="{&quot;id&quot;:1,&quot;company_id&quot;:1,&quot;name&quot;:&quot;US Dollar&quot;,&quot;code&quot;:&quot;USD&quot;,&quot;rate&quot;:1,&quot;precision&quot;:2,&quot;symbol&quot;:&quot;$&quot;,&quot;symbol_first&quot;:1,&quot;decimal_mark&quot;:&quot;.&quot;,&quot;thousands_separator&quot;:&quot;,&quot;,&quot;enabled&quot;:true,&quot;created_by&quot;:null,&quot;created_at&quot;:&quot;2021-06-18T07:43:40.000000Z&quot;,&quot;updated_at&quot;:&quot;2021-06-18T07:43:40.000000Z&quot;,&quot;deleted_at&quot;:null}"
                                                    :value="0" :dynamic-currency="currency" v-model="totals.discount"
                                                    @interface="form.errors.clear('totals.discount'); totals.discount = $event"
                                                    :form-error="form.errors.get('discount_total')" :row-input="true">
                                                </akaunting-money>


                                            </div>
                                            <input id="discount" class="form-control text-right" v-model="form.discount"
                                                name="discount" type="hidden">
                                        </td>
                                        <td class="border-top-0 pt-0 pb-0" style="max-width: 50px"></td>
                                    </tr>

                                    {{-- Total  --}}
                                    <tr id="tr-total">
                                        <td class="border-top-0 pt-0 pb-0"></td>
                                        <td class="text-right border-top-0 border-right-0 align-middle pt-0 pb-0 pr-0">
                                            <strong class="document-total-span">Total</strong>
                                            <akaunting-select class="document-total-currency required"
                                                :form-classes="[{'has-error': form.errors.has('currency_code') }]"
                                                icon="exchange-alt" title="" placeholder="- Select  -"
                                                name="currency_code"
                                                :options="{&quot;USD&quot;:&quot;US Dollar&quot;,&quot;EUR&quot;:&quot;Euro&quot;,&quot;GBP&quot;:&quot;British Pound&quot;,&quot;TRY&quot;:&quot;Turkish Lira&quot;}"
                                                value="USD" :model="form.currency_code"
                                                @interface="form.errors.clear('currency_code'); form.currency_code = $event;"
                                                @change="onChangeCurrency($event)"
                                                :form-error="form.errors.get('currency_code')" no-data-text="No data"
                                                no-matching-data-text="No matching data"></akaunting-select>


                                            <input id="currency_rate" class="form-control" required="required"
                                                name="currency_rate" type="hidden" value="1">
                                        </td>
                                        <td class="text-right border-top-0 long-texts pt-0 pb-0 pr-3">
                                            <div>
                                                <akaunting-money :col="'text-right disabled-money'"
                                                    :form-classes="[{'has-error': form.errors.has('grand_total') }]"
                                                    money-class="text-right disabled-money" :disabled="true"
                                                    :error="form.errors.get(&quot;grand_total&quot;)" name="grand_total"
                                                    title="" :group_class="''" icon=""
                                                    :currency="{&quot;id&quot;:1,&quot;company_id&quot;:1,&quot;name&quot;:&quot;US Dollar&quot;,&quot;code&quot;:&quot;USD&quot;,&quot;rate&quot;:1,&quot;precision&quot;:2,&quot;symbol&quot;:&quot;$&quot;,&quot;symbol_first&quot;:1,&quot;decimal_mark&quot;:&quot;.&quot;,&quot;thousands_separator&quot;:&quot;,&quot;,&quot;enabled&quot;:true,&quot;created_by&quot;:null,&quot;created_at&quot;:&quot;2021-06-18T07:43:40.000000Z&quot;,&quot;updated_at&quot;:&quot;2021-06-18T07:43:40.000000Z&quot;,&quot;deleted_at&quot;:null}"
                                                    :value="0" :dynamic-currency="currency" v-model="totals.total"
                                                    @interface="form.errors.clear('totals.total'); totals.total = $event"
                                                    :form-error="form.errors.get('grand_total')" :row-input="true">
                                                </akaunting-money>


                                            </div>
                                        </td>
                                        <td class="border-top-0 pt-0 pb-0" style="max-width: 50px"></td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {{-- Description  --}}

                <div class="row embed-card-body-footer">
                    <div class="form-group col-md-12 embed-acoordion-textarea">
                        <label for="notes" class="form-control-label">Description</label>

                        <textarea class="form-control embed-card-body-footer-textarea" data-name="notes"
                            placeholder="Enter Notes" v-model="form.notes" rows="3" name="notes" cols="50"
                            id="notes"></textarea>

                        <div class="invalid-feedback d-block" v-if="form.errors.has(&quot;notes&quot;)"
                            v-html="form.errors.get(&quot;notes&quot;)">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Save/Cancel  --}}
        <div class="card">
            <div class="card-footer">
                <div class="row save-buttons">
                    <div class="col-md-12">
                        <a href="http://localhost/laravel/akaunting/1/sales/invoices"
                            class="btn btn-outline-secondary">Cancel</a>

                        <button :disabled="form.loading" type="submit" class="btn btn-icon btn-success"><span
                                v-if="form.loading" class="btn-inner--icon"><i class="aka-loader"></i></span> <span
                                :class="[{'ml-0': form.loading}]" class="btn-inner--text">Save</span></button>
                    </div>


                </div>
            </div>
        </div>

        <input id="type" v-model="form.type" name="type" type="hidden" value="invoice">
        <input id="status" v-model="form.status" name="status" type="hidden" value="draft">
        <input id="amount" v-model="form.amount" name="amount" type="hidden" value="0">
    </form>


    <notifications></notifications>

    <form id="form-dynamic-component" method="POST" action="#"></form>

    <component v-bind:is="component"></component>
</div>

@section('script')

<script src="{{ asset('js/common/documents.js?v=2.1.16') }}"></script>

<script type="text/javascript">
    var document_items = false;
    var document_default_currency = 'USD';
    var document_currencies = [{
        "name": "British Pound"
        , "code": "GBP"
        , "rate": 1.6
        , "precision": 2
        , "symbol": "\u00a3"
        , "symbol_first": 1
        , "decimal_mark": "."
        , "thousands_separator": ","
        , "enabled": true
        , "created_by": null
    }, {
        "name": "Euro"
        , "code": "EUR"
        , "rate": 1.25
        , "precision": 2
        , "symbol": "\u20ac"
        , "symbol_first": 1
        , "decimal_mark": ","
        , "thousands_separator": "."
        , "enabled": true
        , "created_by": null
    }, {
        "name": "Turkish Lira"
        , "code": "TRY"
        , "rate": 0.8
        , "precision": 2
        , "symbol": "\u20ba"
        , "symbol_first": 1
        , "decimal_mark": ","
        , "thousands_separator": "."
        , "enabled": true
        , "created_by": null
    }, {
        "name": "US Dollar"
        , "code": "USD"
        , "rate": 1
        , "precision": 2
        , "symbol": "$"
        , "symbol_first": 1
        , "decimal_mark": "."
        , "thousands_separator": ","
        , "enabled": true
        , "created_by": null
    }];
    var document_taxes = [{
        "id": 1
        , "name": "Distinctio."
        , "rate": 18.32
        , "type": "compound"
        , "enabled": true
        , "created_by": null
        , "title": "Distinctio. (18.32%)"
    }, {
        "id": 10
        , "name": "Est corporis."
        , "rate": 10.95
        , "type": "fixed"
        , "enabled": true
        , "created_by": null
        , "title": "Est corporis. (10.95)"
    }, {
        "id": 7
        , "name": "Est fugiat sit."
        , "rate": 19
        , "type": "compound"
        , "enabled": true
        , "created_by": null
        , "title": "Est fugiat sit. (19%)"
    }, {
        "id": 6
        , "name": "Ex voluptas."
        , "rate": 15.04
        , "type": "inclusive"
        , "enabled": true
        , "created_by": null
        , "title": "Ex voluptas. (15.04%)"
    }, {
        "id": 4
        , "name": "Quas quia aut."
        , "rate": 11.71
        , "type": "fixed"
        , "enabled": true
        , "created_by": null
        , "title": "Quas quia aut. (11.71)"
    }, {
        "id": 8
        , "name": "Quia dolor."
        , "rate": 17.08
        , "type": "fixed"
        , "enabled": true
        , "created_by": null
        , "title": "Quia dolor. (17.08)"
    }, {
        "id": 2
        , "name": "Rerum debitis."
        , "rate": 15.55
        , "type": "fixed"
        , "enabled": true
        , "created_by": null
        , "title": "Rerum debitis. (15.55)"
    }, {
        "id": 5
        , "name": "Sunt sed."
        , "rate": 13.21
        , "type": "fixed"
        , "enabled": true
        , "created_by": null
        , "title": "Sunt sed. (13.21)"
    }, {
        "id": 3
        , "name": "Ut voluptates."
        , "rate": 12.52
        , "type": "withholding"
        , "enabled": true
        , "created_by": null
        , "title": "Ut voluptates. (12.52%)"
    }, {
        "id": 9
        , "name": "Vitae natus."
        , "rate": 13.6
        , "type": "inclusive"
        , "enabled": true
        , "created_by": null
        , "title": "Vitae natus. (13.6%)"
    }];

</script>
@endsection


@endsection
