@extends('layouts.dashboard')
@section('title','Invoice: INV-9770')

@section('addnew')

<div class="dropup header-drop-top">
    <button type="button" class="btn btn-white btn-sm" data-toggle="dropdown" aria-expanded="false">
        <i class="fa fa-chevron-down"></i>&nbsp; More Actions
    </button>

    <div class="dropdown-menu" role="menu">

        <a class="dropdown-item" href="http://localhost/laravel/akaunting/1/sales/invoices/166/duplicate">
            Duplicate
        </a>

        <div class="dropdown-divider"></div>

        <a class="dropdown-item" href="http://localhost/laravel/akaunting/1/sales/invoices/166/print" target="_blank">
            Print
        </a>


        <a class="dropdown-item" href="http://localhost/laravel/akaunting/1/sales/invoices/166/pdf">
            Download PDF
        </a>

        <a class="dropdown-item" href="http://localhost/laravel/akaunting/1/sales/invoices/166/cancelled">
            Cancel
        </a>

        <div class="dropdown-divider"></div>

        <a class="dropdown-item" href="http://localhost/laravel/akaunting/1/settings/invoice">
            Customize
        </a>

        <div class="dropdown-divider"></div>

        <button type="button" class="dropdown-item action-delete" title="Delete"
            @click="confirmDelete(&quot;http://localhost/laravel/akaunting/1/sales/invoices/166&quot;, &quot;Invoices&quot;, &quot;Confirm delete &lt;strong&gt;INV-9770&lt;/strong&gt; invoice?&quot;, &quot;Cancel&quot;, &quot;Delete&quot;)">Delete</button>

    </div>
</div>

<a href="http://localhost/laravel/akaunting/1/sales/invoices/create" class="btn btn-white btn-sm">
    Add New
</a>
@endsection

@section('content')

<div>

    <div class="row" style="font-size: inherit !important">
        <div class="col-md-2">
            Status
            <br>

            <strong>
                <span class="float-left">
                    <span class="badge badge-info">
                        Partial
                    </span>
                </span>
            </strong>
            <br><br>
        </div>

        <div class="col-md-6">
            Customer
            <br>

            <strong>
                <span class="float-left">
                    Pete Allen
                </span>
            </strong>
            <br><br>
        </div>

        <div class="col-md-2">
            Amount due
            <br>

            <strong>
                <span class="float-left">
                    $275.36 </span>
            </strong>
            <br><br>
        </div>

        <div class="col-md-2">
            Due on
            <br>

            <strong>
                <span class="float-left">
                    22 Apr 2023 </span>
            </strong>
            <br><br>
        </div>
    </div>



    <div class="card">
        <div class="card-body">
            <div class="timeline timeline-one-side" data-timeline-content="axis" data-timeline-axis-style="dashed">
                <div class="timeline-block">
                    <span class="timeline-step badge-primary">
                        <i class="fas fa-plus"></i>
                    </span>

                    <div class="timeline-content">
                        <h2 class="font-weight-500">
                            Create Invoice
                        </h2>

                        <small>
                            Status:
                        </small>
                        <small>
                            Created on 18 Jun 2021
                        </small>

                        <div class="mt-3">
                            <a href="http://localhost/laravel/akaunting/1/sales/invoices/166/edit"
                                class="btn btn-primary btn-sm btn-alone header-button-top">
                                Edit
                            </a>
                        </div>
                    </div>
                </div>

                <div class="timeline-block">
                    <span class="timeline-step badge-danger">
                        <i class="far fa-envelope"></i>
                    </span>

                    <div class="timeline-content">
                        <h2 class="font-weight-500">
                            Send Invoice
                        </h2>

                        <small>Status:</small>
                        <small>Sent on 28 Jun 2021</small>

                        <div class="mt-3">

                            <a href="http://localhost/laravel/akaunting/1/sales/invoices/166/email"
                                class="btn btn-danger btn-sm header-button-top">
                                Send Email
                            </a>

                            <a href="http://localhost/laravel/akaunting/1/signed/invoices/166?signature=3c192ac26b0b8f6eb5d1ed7669c0adc0756e2c576db7b7d5b014d4fd3370f488"
                                target="_blank" class="btn btn-white btn-sm header-button-top">
                                Share
                            </a>

                        </div>

                    </div>
                </div>

                <div class="timeline-block">
                    <span class="timeline-step badge-success">
                        <i class="far fa-money-bill-alt"></i>
                    </span>

                    <div class="timeline-content">
                        <h2 class="font-weight-500">
                            Get Paid
                        </h2>

                        <small>
                            Status:
                        </small>
                        <small>
                            Partially Paid
                        </small>

                        <div class="mt-3">
                            <a href="http://localhost/laravel/akaunting/1/sales/invoices/166/paid"
                                class="btn btn-white btn-sm header-button-top">
                                Mark Paid
                            </a>

                            <button @click="onPayment" id="button-payment"
                                class="btn btn-success btn-sm header-button-bottom">
                                Add Payment
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card"
        style="padding: 0; padding-left: 15px; padding-right: 15px; border-radius: 0; box-shadow: 0 4px 16px rgba(0,0,0,.2);">
        <div class="card-body">
            <div class="row">
                <div class="col-100">
                    <div class="text">
                        <h3>
                            Invoice
                        </h3>
                    </div>
                </div>
            </div>

            <div class="row border-bottom-1">
                <div class="col-58">
                    <div class="text company">
                        <img class="d-logo"
                            src="data:image/png;base64,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"
                            alt="My Company" />
                    </div>
                </div>

                <div class="col-42">
                    <div class="text company">
                        <strong>My Company</strong><br>

                        <p></p>

                        <p>
                        </p>

                        <p>
                        </p>

                        <p>my@company.com</p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-58">
                    <div class="text company">
                        <br>

                        <strong>Pete Allen</strong><br>

                        <p>18 Jacob Brook<br />
                            Whitechester<br />
                            W4 3JU</p>

                        <p>
                            Tax Number: 953253415
                        </p>

                        <p>
                            +44(0)1855 25709
                        </p>

                        <p>
                            jwilson@example.com
                        </p>
                    </div>
                </div>

                <div class="col-42">
                    <div class="text company">
                        <br>
                        <strong>
                            Invoice Number:
                        </strong>
                        <span class="float-right">INV-9770</span><br><br>


                        <strong>
                            Invoice Date:
                        </strong>
                        <span class="float-right">17 Oct 2021</span><br><br>

                        <strong>
                            Due Date:
                        </strong>
                        <span class="float-right">22 Apr 2023</span><br><br>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-100">
                    <div class="text">
                        <table class="lines">
                            <thead style="background-color:#55588b !important; -webkit-print-color-adjust: exact;">
                                <tr>
                                    <th class="item text-left text-white">Items</th>

                                    <th class="quantity text-white">Quantity</th>

                                    <th class="price text-white">Price</th>


                                    <th class="total text-white">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="item">
                                        Dolores modi.

                                        <br><small>Et dolores qui minus qui labore. Nam aliquam et sit
                                            voluptatibus vero sed. Est perspiciatis eius aut placeat aut
                                            nihil a.</small>

                                    </td>

                                    <td class="quantity">1</td>

                                    <td class="price">$387.28</td>


                                    <td class="total">$387.28</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="row mt-9 clearfix">
                <div class="col-58">
                    <div class="text company">
                        <br>
                        <strong>Notes</strong><br><br>
                        Aut.
                    </div>
                </div>

                <div class="col-42 float-right text-right">
                    <div class="text company">
                        <div class="border-top-1 py-2">
                            <strong class="float-left">Subtotal:</strong>
                            <span>$387.28</span><br>
                        </div>
                        <div class="border-top-1 py-2">
                            <strong class="float-left">Quia dolor. (17.08):</strong>
                            <span>$17.08</span><br>
                        </div>
                        <div class="border-top-1 py-2">
                            <strong class="float-left">Paid:</strong>
                            <span>- $129.00</span><br>
                        </div>
                        <div class="border-top-1 py-2">
                            <strong class="float-left">Total:</strong>
                            <span>$275.36</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>


    <div class="row">
        <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
            <div class="accordion">
                <div class="card">
                    <div class="card-header" id="accordion-histories-header" data-toggle="collapse"
                        data-target="#accordion-histories-body" aria-expanded="false"
                        aria-controls="accordion-histories-body">
                        <h4 class="mb-0">Histories</h4>
                    </div>

                    <div id="accordion-histories-body" class="collapse hide"
                        aria-labelledby="accordion-histories-header">
                        <div class="table-responsive">
                            <table class="table table-flush table-hover">
                                <thead class="thead-light">
                                    <tr class="row table-head-line">
                                        <th class="col-xs-4 col-sm-3">
                                            Date
                                        </th>
                                        <th class="col-xs-4 col-sm-3 text-left">
                                            Status
                                        </th>
                                        <th class="col-xs-4 col-sm-6 text-left long-texts">
                                            Description
                                        </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr class="row align-items-center border-top-1 tr-py">
                                        <td class="col-xs-4 col-sm-3">
                                            18 Jun 2021 </td>
                                        <td class="col-xs-4 col-sm-3 text-left">
                                            Draft
                                        </td>
                                        <td class="col-xs-4 col-sm-6 text-left long-texts">
                                            INV-9770 added!
                                        </td>
                                    </tr>
                                    <tr class="row align-items-center border-top-1 tr-py">
                                        <td class="col-xs-4 col-sm-3">
                                            18 Jun 2021 </td>
                                        <td class="col-xs-4 col-sm-3 text-left">
                                            Partial
                                        </td>
                                        <td class="col-xs-4 col-sm-6 text-left long-texts">
                                            $129.00 Payment
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
            <div class="accordion">
                <div class="card">
                    <div class="card-header" id="accordion-transactions-header" data-toggle="collapse"
                        data-target="#accordion-transactions-body" aria-expanded="false"
                        aria-controls="accordion-transactions-body">
                        <h4 class="mb-0">Transactions</h4>
                    </div>

                    <div id="accordion-transactions-body" class="collapse hide"
                        aria-labelledby="accordion-transactions-header">
                        <div class="table-responsive">
                            <table class="table table-flush table-hover">
                                <thead class="thead-light">
                                    <tr class="row table-head-line">

                                        <th class="col-xs-4 col-sm-3">
                                            Date
                                        </th>

                                        <th class="col-xs-4 col-sm-3">
                                            Amount
                                        </th>

                                        <th class="col-sm-3 d-none d-sm-block">
                                            Account
                                        </th>

                                        <th class="col-xs-4 col-sm-3">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr class="row align-items-center border-top-1 tr-py">
                                        <td class="col-xs-4 col-sm-3">
                                            22 Apr 2023 </td>

                                        <td class="col-xs-4 col-sm-3">
                                            $129.00 </td>

                                        <td class="col-sm-3 d-none d-sm-block">
                                            Cash
                                        </td>

                                        <td class="col-xs-4 col-sm-3 py-0">

                                            <button type="button" class="btn btn-danger btn-sm" title="Delete"
                                                @click="confirmDelete(&quot;http://localhost/laravel/akaunting/1/banking/transactions/52&quot;, &quot;Transactions&quot;, &quot;Confirm delete &lt;strong&gt;22 Apr 2023 - $129.00 - Cash&lt;/strong&gt; transaction?&quot;,  &quot;Cancel&quot;, &quot;Delete&quot;)">Delete</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <input id="document_id" name="document_id" type="hidden" value="166">
    <input id="invoice_id" name="invoice_id" type="hidden" value="166">


    <notifications></notifications>

    <form id="form-dynamic-component" method="POST" action="#"></form>

    <component v-bind:is="component"></component>
</div>

@endsection
